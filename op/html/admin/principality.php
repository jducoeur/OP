<?php 
include_once("db.php");

// Only web admins allowed
if ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]))
{
$SUBMIT_SAVE = "Save Changes";
$SUBMIT_PRINCE = "Select Prince";
$SUBMIT_PRINCESS = "Select Princess";
$SUBMIT_CPRINCE = "Remove Prince";
$SUBMIT_CPRINCESS = "Remove Princess";

$SUBMIT_DELETE = "Delete Selected Principality";

$mode = $MODE_EDIT;
if (isset($_POST['mode']))
{
   $mode = clean($_POST['mode']);
}
else if (isset($_GET['mode']))
{
   $mode = clean($_GET['mode']);
}

$form_principality_id = 0;
if (isset($_REQUEST['form_principality_id']))
{
   $form_principality_id = clean($_REQUEST['form_principality_id']);
}

$form_prince_id = 0;
if (isset($_REQUEST['form_prince_id']))
{
   $form_prince_id = clean($_REQUEST['form_prince_id']);
}

$form_princess_id = 0;
if (isset($_REQUEST['form_princess_id']))
{
   $form_princess_id = clean($_REQUEST['form_princess_id']);
}

$valid = true;
$errmsg = '';
$display_message = '';
if (isset($_POST['submit']) && ($_POST['submit'] == $SUBMIT_SAVE || $_POST['submit'] == $SUBMIT_PRINCE || $_POST['submit'] == $SUBMIT_PRINCESS || $_POST['submit'] == $SUBMIT_CPRINCE || $_POST['submit'] == $SUBMIT_CPRINCESS))
{
   $form_prince_id = NULL;
   if (isset($_POST['form_prince_id']) && $_POST['submit'] != $SUBMIT_CPRINCE)
   {
      $form_prince_id = clean($_POST['form_prince_id']);
   }
   $form_princess_id = NULL;
   if (isset($_POST['form_princess_id']) && $_POST['submit'] != $SUBMIT_CPRINCESS)
   {
      $form_princess_id = clean($_POST['form_princess_id']);
   }
   $form_principality_display = NULL;
   if (isset($_POST['form_principality_display']))
   {
      $form_principality_display = clean($_POST['form_principality_display']);
   }
   $form_principality_start_date = NULL;
   if (isset($_POST['form_principality_start_date']))
   {
      $form_principality_start_date = clean($_POST['form_principality_start_date']);
   }
   $form_principality_end_date = NULL;
   if (isset($_POST['form_principality_end_date']))
   {
      $form_principality_end_date = clean($_POST['form_principality_end_date']);
   }
   $form_event_id = NULL;
   if (isset($_POST['form_event_id']))
   {
      $form_event_id = clean($_POST['form_event_id']);
   }
   $form_principality_start_sequence = 0;
   if (isset($_POST['form_principality_start_sequence']))
   {
      $form_principality_start_sequence = clean($_POST['form_principality_start_sequence']);
   }

   // Validate data
   if ($form_principality_display == '')
   {
      $valid = false;
      $errmsg .= "Please enter a Display Name.<br/>";
   }
   if ($form_principality_start_date != '')
   {
      if (strtotime($form_principality_start_date) === FALSE)
      {
         $valid = false;
         $errmsg .= "Please enter a valid date for the Investiture Date.<br/>";
      }
      else
      {
         $form_principality_start_date = format_mysql_date($form_principality_start_date);
      }
   }
   if ($form_principality_end_date != '')
   {
      if (strtotime($form_principality_end_date) === FALSE)
      {
         $valid = false;
         $errmsg .= "Please enter a valid date for the Devestiture Date.<br/>";
      }
      else
      {
         $form_principality_end_date = format_mysql_date($form_principality_end_date);
      }
   }
   if (!validate_zero_plus_number($form_principality_start_sequence))
   {
      $valid = false;
      $errmsg .= "Please enter a Sequence value that is a whole number greater than or equal to zero.<br/>";
   }

   if ($valid)
   {
      $link = db_admin_connect();

      // Update Principality
      if ($mode == $MODE_EDIT)
      {
         $update = 
            "UPDATE $DBNAME_OP.principality " . 
            "SET prince_id = " . value_or_null($form_prince_id) . 
            ", princess_id = " . value_or_null($form_princess_id) .
            ", principality_display = " . value_or_null($form_principality_display) . 
            ", principality_start_date = " . value_or_null($form_principality_start_date) . 
            ", principality_end_date = " . value_or_null($form_principality_end_date) . 
            ", principality_start_sequence = " . value_or_zero($form_principality_start_sequence) . 
            ", event_id = " . value_or_null($form_event_id) . 
            ", last_updated = " . value_or_null(date("Y-m-d")) .
            ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) .
            " WHERE principality_id = ". value_or_null($form_principality_id);

         $uresult = mysql_query($update)
            or die("Error updating Principality: " . mysql_error());
      }
      // Insert Principality
      else
      {
         $insert = 
            "INSERT INTO $DBNAME_OP.principality (prince_id, princess_id, principality_display, principality_start_date, principality_end_date, principality_start_sequence, event_id, last_updated, last_updated_by) VALUES (" . 
            value_or_null($form_prince_id) . ", " .
            value_or_null($form_princess_id) . ", " .
            value_or_null($form_principality_display) . ", " .
            value_or_null($form_principality_start_date) . ", " .
            value_or_null($form_principality_end_date) . ", " .
            value_or_null($form_principality_start_sequence) . ", " .
            value_or_null($form_event_id) . ", " .
            value_or_null(date("Y-m-d")) . ", " .
            value_or_null($_SESSION['s_user_id']) . ")";

         $iresult = mysql_query($insert)
            or die("Error inserting Principality: " . mysql_error());
         $form_principality_id = mysql_insert_id();
      }
      /* Closing connection */
      db_disconnect($link);

      // Select Prince or Princess
      if ($_POST['submit'] == $SUBMIT_PRINCE || $_POST['submit'] == $SUBMIT_PRINCESS)
      {
         $url = "select_principality.php?principality_id=$form_principality_id&gender=";
         $gender = $FEMALE;
         if ($_POST['submit'] == $SUBMIT_PRINCE)
         {
            $gender = $MALE;
         }
         redirect($url . $gender);
      }
      $display_message = '<p align="center">Principality successfully updated.  <a href="principality.php">View the Principality</a>.</p>';
   } // valid
}

include("header.php");
echo $display_message;

// We haven't submitted save yet - display Principality list or edit form
if (!(isset($_POST['submit'])) || (isset($_POST['submit']) && 
   (($_POST['submit'] == $SUBMIT_SAVE || $_POST['submit'] == $SUBMIT_PRINCE || $_POST['submit'] == $SUBMIT_PRINCESS) && !$valid) || 
   ($_POST['submit'] == $SUBMIT_DELETE)))
{
   // Do delete
   if (isset($_POST['submit']) && $_POST['submit'] == $SUBMIT_DELETE)
   {
      $del_principality_id = '';
      for ($i = 1; $i < $_POST['del_principality_max']; $i++)
      {
         if (isset($_POST['del_principality_id' . $i]))
         {
            if ($del_principality_id != '')
            {
               $del_principality_id .= ',';
            }
            $del_principality_id .= $_POST['del_principality_id' . $i];
         }
      }

      if ($del_principality_id != '')
      {
         $link = db_admin_connect();

         $delete = "DELETE FROM $DBNAME_OP.principality WHERE principality_id IN ($del_principality_id)";

         $dresult = mysql_query($delete)
            or die("Error deleteing Principality: " . mysql_error());

         /* Closing connection */
         db_disconnect($link);
      }
      else
      {
         $delerrmsg = "Please select at least one Principality to delete.";
         $display_message = '<p align="center" class="title3" style="color:red">' . $delerrmsg . '</p>';
         echo $display_message;
      }
   }

   // Dislay edit list
   if ($mode == $MODE_EDIT && (!isset($form_principality_id) || $form_principality_id == 0))
   {
      $link = db_connect();
      $query = "SELECT principality.*, b1.sca_name AS prince, b2.sca_name AS princess " . 
               "FROM $DBNAME_OP.principality " . 
               "LEFT OUTER JOIN $DBNAME_AUTH.atlantian b1 ON principality.prince_id = b1.atlantian_id " .
               "LEFT OUTER JOIN $DBNAME_AUTH.atlantian b2 ON principality.princess_id = b2.atlantian_id " .
               "ORDER BY principality_start_date";
      $result = mysql_query($query);

?>
<p align="center">
To edit an existing Principality: Click on the Principality link.<br/>
To delete an existing Principality: Check the box in front of the Principality and click the <?php echo $SUBMIT_DELETE; ?> button.<br/>
To add a new Principality: Visit the <a href="<?php echo $_SERVER['PHP_SELF'] . "?mode=" . $MODE_ADD; ?>">Add Principality page</a>.<br/>
</p>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table align="center" border="1" cellpadding="5" cellspacing="0" summary="Principality Update Form">
   <tr>
      <th class="title"><label for="del_principality_id">Select</label></th>
      <th class="title">Investiture Date</th>
      <th class="title">Principality</th>
   </tr>
<?php 
      $i = 1;
      while ($data = mysql_fetch_array($result, MYSQL_BOTH))
      {
         $principality_id = $data['principality_id'];
         $principality_display = stripslashes(trim($data['principality_display']));
         $principality_start_date = $data['principality_start_date'];
         if ($principality_start_date != null)
         {
            $principality_start_date = format_short_date($principality_start_date);
         }
?>
   <tr>
      <td class="title"><input type="checkbox" name="del_principality_id<?php echo $i; ?>" id="del_principality_id<?php echo $i++; ?>" value="<?php echo $principality_id; ?>"/></td>
      <td class="dataright"><?php echo $principality_start_date; ?></td>
      <td class="data">
      <a href="<?php echo $_SERVER['PHP_SELF'] . "?form_principality_id=" . $principality_id; ?>"><?php echo $principality_display; ?></a>
      </td>
   </tr>
<?php 
      }
?>
   <input type="hidden" name="del_principality_max" id="del_principality_max" value="<?php echo $i; ?>"/>
   <tr>
      <td class="title" colspan="3"><input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_DELETE; ?>"/></td>
   </tr>
</table>
</form>
<?php 
      /* Free resultset */
      mysql_free_result($result);

      /* Closing connection */
      db_disconnect($link);
   }
   // Display form
   else
   {
      // Get data for edit
      if ($mode == $MODE_EDIT && $valid)
      {
         $link = db_connect();

         // Get Prince information, if already selected
         $form_prince = null;
         if ($form_prince_id > 0)
         {
            $query = "SELECT sca_name FROM $DBNAME_AUTH.atlantian WHERE atlantian_id = $form_prince_id";
            $result = mysql_query($query);
            $data = mysql_fetch_array($result, MYSQL_BOTH);
            $form_prince = stripslashes(trim($data['sca_name']));
            mysql_free_result($result);
         }
         // Get Princess information, if already selected
         $form_princess = null;
         if ($form_princess_id > 0)
         {
            $query = "SELECT sca_name FROM $DBNAME_AUTH.atlantian WHERE atlantian_id = $form_princess_id";
            $result = mysql_query($query);
            $data = mysql_fetch_array($result, MYSQL_BOTH);
            $form_princess = stripslashes(trim($data['sca_name']));
            mysql_free_result($result);
         }

         $query = "SELECT principality.*, b1.sca_name AS prince, b2.sca_name AS princess " .
            "FROM $DBNAME_OP.principality LEFT OUTER JOIN $DBNAME_AUTH.atlantian b1 ON principality.prince_id = b1.atlantian_id " . 
            "LEFT OUTER JOIN $DBNAME_AUTH.atlantian b2 ON principality.princess_id = b2.atlantian_id " .
            "WHERE principality_id = " . $form_principality_id;
         $result = mysql_query($query);

         $data = mysql_fetch_array($result, MYSQL_BOTH);
         $form_principality_id = $data['principality_id'];
         $form_principality_display = stripslashes(trim($data['principality_display']));
         $form_principality_start_date = $data['principality_start_date'];
         $form_principality_end_date = $data['principality_end_date'];
         $form_principality_start_sequence = $data['principality_start_sequence'];
         $form_event_id = $data['event_id'];
         if ($form_prince_id == 0)
         {
            $form_prince_id = $data['prince_id'];
            $form_prince = stripslashes(trim($data['prince']));
         }
         if ($form_princess_id == 0)
         {
            $form_princess_id = $data['princess_id'];
            $form_princess = stripslashes(trim($data['princess']));
         }

         /* Free resultset */
         mysql_free_result($result);

         /* Closing connection */
         db_disconnect($link);
      }
      if (!$valid)
      {
?>
<p align="center" class="title3" style="color:red">Please correct the following errors:<br/><br/><?php echo $errmsg; ?></p>
<?php 
      }
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>"/>
<p class="title2"><?php echo ucfirst($mode); ?> Principality</p>
<table border="1" cellpadding="5" cellspacing="0" summary="Principality Form">
<?php 
      if (isset($form_principality_id) && $form_principality_id > 0)
      {
?>
   <input type="hidden" name="form_principality_id" id="form_principality_id" value="<?php echo $form_principality_id; ?>"/>
<?php 
      }
      if (isset($form_prince_id) && $form_prince_id > 0)
      {
?>
   <input type="hidden" name="form_prince_id" id="form_prince_id" value="<?php echo $form_prince_id; ?>"/>
<?php 
      }
      if (isset($form_princess_id) && $form_princess_id > 0)
      {
?>
   <input type="hidden" name="form_princess_id" id="form_princess_id" value="<?php echo $form_princess_id; ?>"/>
<?php 
      }
?>
   <tr>
      <th class="titleright">Principality ID:</th>
      <td class="data"><?php if (isset($form_principality_id) && trim($form_principality_id) != '' && $form_principality_id > 0) { echo $form_principality_id; } ?></td>
   </tr>
   <tr>
      <th class="titleright">Prince:</th>
      <td class="data"><input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_PRINCE; ?>"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if (isset($form_prince) && trim($form_prince) != '') { echo $form_prince . "&nbsp;&nbsp;&nbsp;<input type=\"submit\" name=\"submit\" id=\"submit\" value=\"$SUBMIT_CPRINCE\"/>"; } ?></td>
   </tr>
   <tr>
      <th class="titleright">Princess:</th>
      <td class="data"><input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_PRINCESS; ?>"/>&nbsp;&nbsp;&nbsp;<?php if (isset($form_princess) && trim($form_princess) != '') { echo $form_princess . "&nbsp;&nbsp;&nbsp;<input type=\"submit\" name=\"submit\" id=\"submit\" value=\"$SUBMIT_CPRINCESS\"/>"; } ?></td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_principality_display">Display Name:</label></th>
      <td class="data"><input type="text" name="form_principality_display" id="form_principality_display" size="50" maxlength="255"<?php if (isset($form_principality_display) && trim($form_principality_display) != '') { echo " value=\"" . $form_principality_display . "\""; } ?>/></td>
   </tr>
   <tr>
      <td class="titleright"><label for="form_principality_start_date">Invesiture Date:</label></td>
      <td class="data"><input type="text" name="form_principality_start_date" id="form_principality_start_date" size="10" maxlength="10"<?php if (isset($form_principality_start_date) && trim($form_principality_start_date) != '') { echo " value=\"" . $form_principality_start_date . "\""; } ?>/></td>
   </tr>
   <tr>
      <td class="titleright"><label for="form_principality_start_sequence">Investiture Sequence:</label></td>
      <td class="data"><input type="text" name="form_principality_start_sequence" id="form_principality_start_sequence" size="10" maxlength="10"<?php if (isset($form_principality_start_sequence) && trim($form_principality_start_sequence) != '') { echo " value=\"" . $form_principality_start_sequence . "\""; } ?>/></td>
   </tr>
   <tr>
      <td class="titleright"><label for="form_principality_end_date">Devesiture Date:</label></td>
      <td class="data"><input type="text" name="form_principality_end_date" id="form_principality_end_date" size="10" maxlength="10"<?php if (isset($form_principality_end_date) && trim($form_principality_end_date) != '') { echo " value=\"" . $form_principality_end_date . "\""; } ?>/></td>
   </tr>
   <tr>
      <td colspan="2" class="title"><input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_SAVE; ?>"/></td>
   </tr>
</table>
<?php
   }
}
?>
</form>
<?php
}
// Not authorized
else
{
?>
<p align="center" class="title2">Principality</p>
<p align="center">You are not authorized to access this page.</p>
<?php
}
include("footer.php");
?>
