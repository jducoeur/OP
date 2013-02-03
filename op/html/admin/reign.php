<? 
include_once("db.php");

// Only web admins allowed
if ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]))
{
$SUBMIT_SAVE = "Save Changes";
$SUBMIT_KING = "Select King";
$SUBMIT_QUEEN = "Select Queen";
$SUBMIT_CKING = "Remove King";
$SUBMIT_CQUEEN = "Remove Queen";

$SUBMIT_DELETE = "Delete Selected Monarchs";

$mode = $MODE_EDIT;
if (isset($_POST['mode']))
{
   $mode = clean($_POST['mode']);
}
else if (isset($_GET['mode']))
{
   $mode = clean($_GET['mode']);
}

$form_reign_id = 0;
if (isset($_REQUEST['form_reign_id']))
{
   $form_reign_id = clean($_REQUEST['form_reign_id']);
}

$form_king_id = 0;
if (isset($_REQUEST['form_king_id']))
{
   $form_king_id = clean($_REQUEST['form_king_id']);
}

$form_queen_id = 0;
if (isset($_REQUEST['form_queen_id']))
{
   $form_queen_id = clean($_REQUEST['form_queen_id']);
}

$valid = true;
$errmsg = '';
$display_message = '';
if (isset($_POST['submit']) && ($_POST['submit'] == $SUBMIT_SAVE || $_POST['submit'] == $SUBMIT_KING || $_POST['submit'] == $SUBMIT_QUEEN || $_POST['submit'] == $SUBMIT_CKING || $_POST['submit'] == $SUBMIT_CQUEEN))
{
   $form_king_id = NULL;
   if (isset($_POST['form_king_id']) && $_POST['submit'] != $SUBMIT_CKING)
   {
      $form_king_id = clean($_POST['form_king_id']);
   }
   $form_queen_id = NULL;
   if (isset($_POST['form_queen_id']) && $_POST['submit'] != $SUBMIT_CQUEEN)
   {
      $form_queen_id = clean($_POST['form_queen_id']);
   }
   $form_monarchs_display = NULL;
   if (isset($_POST['form_monarchs_display']))
   {
      $form_monarchs_display = clean($_POST['form_monarchs_display']);
   }
   $form_reign_start_date = NULL;
   if (isset($_POST['form_reign_start_date']))
   {
      $form_reign_start_date = clean($_POST['form_reign_start_date']);
   }
   $form_reign_end_date = NULL;
   if (isset($_POST['form_reign_end_date']))
   {
      $form_reign_end_date = clean($_POST['form_reign_end_date']);
   }
   $form_event_id = NULL;
   if (isset($_POST['form_event_id']))
   {
      $form_event_id = clean($_POST['form_event_id']);
   }
   $form_reign_start_sequence = 0;
   if (isset($_POST['form_reign_start_sequence']))
   {
      $form_reign_start_sequence = clean($_POST['form_reign_start_sequence']);
   }

   // Validate data
   if ($form_monarchs_display == '')
   {
      $valid = false;
      $errmsg .= "Please enter a Display Name.<br/>";
   }
   if ($form_reign_start_date != '')
   {
      if (strtotime($form_reign_start_date) === FALSE)
      {
         $valid = false;
         $errmsg .= "Please enter a valid date for the Investiture Date.<br/>";
      }
      else
      {
         $form_reign_start_date = format_mysql_date($form_reign_start_date);
      }
   }
   if ($form_reign_end_date != '')
   {
      if (strtotime($form_reign_end_date) === FALSE)
      {
         $valid = false;
         $errmsg .= "Please enter a valid date for the Devestiture Date.<br/>";
      }
      else
      {
         $form_reign_end_date = format_mysql_date($form_reign_end_date);
      }
   }
   if (!validate_zero_plus_number($form_reign_start_sequence))
   {
      $valid = false;
      $errmsg .= "Please enter a Sequence value that is a whole number greater than or equal to zero.<br/>";
   }

   if ($valid)
   {
      $link = db_admin_connect();

      // Update Monarchs
      if ($mode == $MODE_EDIT)
      {
         $update = 
            "UPDATE $DBNAME_OP.reign " . 
            "SET king_id = " . value_or_null($form_king_id) . 
            ", queen_id = " . value_or_null($form_queen_id) .
            ", monarchs_display = " . value_or_null($form_monarchs_display) . 
            ", reign_start_date = " . value_or_null($form_reign_start_date) . 
            ", reign_end_date = " . value_or_null($form_reign_end_date) . 
            ", reign_start_sequence = " . value_or_zero($form_reign_start_sequence) . 
            ", event_id = " . value_or_null($form_event_id) . 
            ", last_updated = " . value_or_null(date("Y-m-d")) .
            ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) .
            " WHERE reign_id = ". value_or_null($form_reign_id);

         $uresult = mysql_query($update)
            or die("Error updating Monarchs: " . mysql_error());
      }
      // Insert Monarchs
      else
      {
         $insert = 
            "INSERT INTO $DBNAME_OP.reign (king_id, queen_id, monarchs_display, reign_start_date, reign_end_date, reign_start_sequence, event_id, last_updated, last_updated_by) VALUES (" . 
            value_or_null($form_king_id) . ", " .
            value_or_null($form_queen_id) . ", " .
            value_or_null($form_monarchs_display) . ", " .
            value_or_null($form_reign_start_date) . ", " .
            value_or_null($form_reign_end_date) . ", " .
            value_or_null($form_reign_start_sequence) . ", " .
            value_or_null($form_event_id) . ", " .
            value_or_null(date("Y-m-d")) . ", " .
            value_or_null($_SESSION['s_user_id']) . ")";

         $iresult = mysql_query($insert)
            or die("Error inserting Monarchs: " . mysql_error());
         $form_reign_id = mysql_insert_id();
      }
      /* Closing connection */
      db_disconnect($link);

      // Select King or Queen
      if ($_POST['submit'] == $SUBMIT_KING || $_POST['submit'] == $SUBMIT_QUEEN)
      {
         $url = "select_reign.php?reign_id=$form_reign_id&gender=";
         $gender = $FEMALE;
         if ($_POST['submit'] == $SUBMIT_KING)
         {
            $gender = $MALE;
         }
         redirect($url . $gender);
      }
      $display_message = '<p align="center">Monarchs successfully updated.  <a href="reign.php">View the Monarchs</a>.</p>';
   } // valid
}

include("header.php");
echo $display_message;

// We haven't submitted save yet - display Monarchs list or edit form
if (!(isset($_POST['submit'])) || (isset($_POST['submit']) && 
   (($_POST['submit'] == $SUBMIT_SAVE || $_POST['submit'] == $SUBMIT_KING || $_POST['submit'] == $SUBMIT_QUEEN) && !$valid) || 
   ($_POST['submit'] == $SUBMIT_DELETE)))
{
   // Do delete
   if (isset($_POST['submit']) && $_POST['submit'] == $SUBMIT_DELETE)
   {
      $del_reign_id = '';
      for ($i = 1; $i < $_POST['del_reign_max']; $i++)
      {
         if (isset($_POST['del_reign_id' . $i]))
         {
            if ($del_reign_id != '')
            {
               $del_reign_id .= ',';
            }
            $del_reign_id .= $_POST['del_reign_id' . $i];
         }
      }

      if ($del_reign_id != '')
      {
         $link = db_admin_connect();

         $delete = "DELETE FROM $DBNAME_OP.reign WHERE reign_id IN ($del_reign_id)";

         $dresult = mysql_query($delete)
            or die("Error deleteing Monarchs: " . mysql_error());

         /* Closing connection */
         db_disconnect($link);
      }
      else
      {
         $delerrmsg = "Please select at least one Monarchs to delete.";
         $display_message = '<p align="center" class="title3" style="color:red">' . $delerrmsg . '</p>';
         echo $display_message;
      }
   }

   // Dislay edit list
   if ($mode == $MODE_EDIT && (!isset($form_reign_id) || $form_reign_id == 0))
   {
      $link = db_connect();
      $query = "SELECT reign.*, b1.sca_name AS king, b2.sca_name AS queen " . 
               "FROM $DBNAME_OP.reign " . 
               "LEFT OUTER JOIN $DBNAME_AUTH.atlantian b1 ON reign.king_id = b1.atlantian_id " .
               "LEFT OUTER JOIN $DBNAME_AUTH.atlantian b2 ON reign.queen_id = b2.atlantian_id " .
               "ORDER BY reign_start_date";
      $result = mysql_query($query);

?>
<p align="center">
To edit an existing Monarchs: Click on the Monarchs link.<br/>
To delete an existing Monarchs: Check the box in front of the Monarchs and click the <?php echo $SUBMIT_DELETE; ?> button.<br/>
To add a new Monarchs: Visit the <a href="<?php echo $_SERVER['PHP_SELF'] . "?mode=" . $MODE_ADD; ?>">Add Monarchs page</a>.<br/>
</p>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table align="center" border="1" cellpadding="5" cellspacing="0" summary="Monarchs Update Form">
   <tr>
      <th class="title"><label for="del_reign_id">Select</label></th>
      <th class="title">Investiture Date</th>
      <th class="title">Monarchs</th>
   </tr>
<?php 
      $i = 1;
      while ($data = mysql_fetch_array($result, MYSQL_BOTH))
      {
         $reign_id = $data['reign_id'];
         $monarchs_display = stripslashes(trim($data['monarchs_display']));
         $reign_start_date = $data['reign_start_date'];
         if ($reign_start_date != null)
         {
            $reign_start_date = format_short_date($reign_start_date);
         }
?>
   <tr>
      <td class="title"><input type="checkbox" name="del_reign_id<?php echo $i; ?>" id="del_reign_id<?php echo $i++; ?>" value="<?php echo $reign_id; ?>"/></td>
      <td class="dataright"><?php echo $reign_start_date; ?></td>
      <td class="data">
      <a href="<?php echo $_SERVER['PHP_SELF'] . "?form_reign_id=" . $reign_id; ?>"><?php echo $monarchs_display; ?></a>
      </td>
   </tr>
<?php 
      }
?>
   <input type="hidden" name="del_reign_max" id="del_reign_max" value="<?php echo $i; ?>"/>
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

         // Get King information, if already selected
         $form_king = null;
         if ($form_king_id > 0)
         {
            $query = "SELECT sca_name FROM $DBNAME_AUTH.atlantian WHERE atlantian_id = $form_king_id";
            $result = mysql_query($query);
            $data = mysql_fetch_array($result, MYSQL_BOTH);
            $form_king = stripslashes(trim($data['sca_name']));
            mysql_free_result($result);
         }
         // Get Queen information, if already selected
         $form_queen = null;
         if ($form_queen_id > 0)
         {
            $query = "SELECT sca_name FROM $DBNAME_AUTH.atlantian WHERE atlantian_id = $form_queen_id";
            $result = mysql_query($query);
            $data = mysql_fetch_array($result, MYSQL_BOTH);
            $form_queen = stripslashes(trim($data['sca_name']));
            mysql_free_result($result);
         }

         $query = "SELECT reign.*, b1.sca_name AS king, b2.sca_name AS queen " .
            "FROM $DBNAME_OP.reign LEFT OUTER JOIN $DBNAME_AUTH.atlantian b1 ON reign.king_id = b1.atlantian_id " . 
            "LEFT OUTER JOIN $DBNAME_AUTH.atlantian b2 ON reign.queen_id = b2.atlantian_id " .
            "WHERE reign_id = " . $form_reign_id;
         $result = mysql_query($query);

         $data = mysql_fetch_array($result, MYSQL_BOTH);
         $form_reign_id = $data['reign_id'];
         $form_monarchs_display = stripslashes(trim($data['monarchs_display']));
         $form_reign_start_date = $data['reign_start_date'];
         $form_reign_end_date = $data['reign_end_date'];
         $form_reign_start_sequence = $data['reign_start_sequence'];
         $form_event_id = $data['event_id'];
         if ($form_king_id == 0)
         {
            $form_king_id = $data['king_id'];
            $form_king = stripslashes(trim($data['king']));
         }
         if ($form_queen_id == 0)
         {
            $form_queen_id = $data['queen_id'];
            $form_queen = stripslashes(trim($data['queen']));
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
<p class="title2"><?php echo ucfirst($mode); ?> Monarchs</p>
<table border="1" cellpadding="5" cellspacing="0" summary="Monarchs Form">
<?php 
      if (isset($form_reign_id) && $form_reign_id > 0)
      {
?>
   <input type="hidden" name="form_reign_id" id="form_reign_id" value="<?php echo $form_reign_id; ?>"/>
<?php 
      }
      if (isset($form_king_id) && $form_king_id > 0)
      {
?>
   <input type="hidden" name="form_king_id" id="form_king_id" value="<?php echo $form_king_id; ?>"/>
<?php 
      }
      if (isset($form_queen_id) && $form_queen_id > 0)
      {
?>
   <input type="hidden" name="form_queen_id" id="form_queen_id" value="<?php echo $form_queen_id; ?>"/>
<?php 
      }
?>
   <tr>
      <th class="titleright">Monarchs ID:</th>
      <td class="data"><?php if (isset($form_reign_id) && trim($form_reign_id) != '' && $form_reign_id > 0) { echo $form_reign_id; } ?></td>
   </tr>
   <tr>
      <th class="titleright">King:</th>
      <td class="data"><input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_KING; ?>"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if (isset($form_king) && trim($form_king) != '') { echo $form_king . "&nbsp;&nbsp;&nbsp;<input type=\"submit\" name=\"submit\" id=\"submit\" value=\"$SUBMIT_CKING\"/>"; } ?></td>
   </tr>
   <tr>
      <th class="titleright">Queen:</th>
      <td class="data"><input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_QUEEN; ?>"/>&nbsp;&nbsp;&nbsp;<?php if (isset($form_queen) && trim($form_queen) != '') { echo $form_queen . "&nbsp;&nbsp;&nbsp;<input type=\"submit\" name=\"submit\" id=\"submit\" value=\"$SUBMIT_CQUEEN\"/>"; } ?></td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_monarchs_display">Display Name:</label></th>
      <td class="data"><input type="text" name="form_monarchs_display" id="form_monarchs_display" size="50" maxlength="255"<?php if (isset($form_monarchs_display) && trim($form_monarchs_display) != '') { echo " value=\"" . $form_monarchs_display . "\""; } ?>/></td>
   </tr>
   <tr>
      <td class="titleright"><label for="form_reign_start_date">Coronation Date:</label></td>
      <td class="data"><input type="text" name="form_reign_start_date" id="form_reign_start_date" size="10" maxlength="10"<?php if (isset($form_reign_start_date) && trim($form_reign_start_date) != '') { echo " value=\"" . $form_reign_start_date . "\""; } ?>/></td>
   </tr>
   <tr>
      <td class="titleright"><label for="form_reign_start_sequence">Coronation Sequence:</label></td>
      <td class="data"><input type="text" name="form_reign_start_sequence" id="form_reign_start_sequence" size="10" maxlength="10"<?php if (isset($form_reign_start_sequence) && trim($form_reign_start_sequence) != '') { echo " value=\"" . $form_reign_start_sequence . "\""; } ?>/></td>
   </tr>
   <tr>
      <td class="titleright"><label for="form_reign_end_date">De-Coronation Date:</label></td>
      <td class="data"><input type="text" name="form_reign_end_date" id="form_reign_end_date" size="10" maxlength="10"<?php if (isset($form_reign_end_date) && trim($form_reign_end_date) != '') { echo " value=\"" . $form_reign_end_date . "\""; } ?>/></td>
   </tr>
   <tr>
      <td colspan="2" class="title"><input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_SAVE; ?>"/></td>
   </tr>
</table>
<?
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
<p align="center" class="title2">Monarchs</p>
<p align="center">You are not authorized to access this page.</p>
<?php
}
include("footer.php");
?>
