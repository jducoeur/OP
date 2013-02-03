<? 
include_once("db.php");

// Only web admins allowed
if ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]))
{
$SUBMIT_SAVE = "Save Changes";
$SUBMIT_BARON = "Select Baron";
$SUBMIT_BARONESS = "Select Baroness";
$SUBMIT_CBARON = "Remove Baron";
$SUBMIT_CBARONESS = "Remove Baroness";

$SUBMIT_DELETE = "Delete Selected Baronage";

$mode = $MODE_EDIT;
if (isset($_REQUEST['mode']))
{
   $mode = clean($_REQUEST['mode']);
}

$form_baronage_id = 0;
if (isset($_REQUEST['form_baronage_id']))
{
   $form_baronage_id = clean($_REQUEST['form_baronage_id']);
}

$form_baron_id = 0;
if (isset($_REQUEST['form_baron_id']))
{
   $form_baron_id = clean($_REQUEST['form_baron_id']);
}

$form_baroness_id = 0;
if (isset($_REQUEST['form_baroness_id']))
{
   $form_baroness_id = clean($_REQUEST['form_baroness_id']);
}

$valid = true;
$errmsg = '';
$display_message = '';
if (isset($_POST['submit']) && ($_POST['submit'] == $SUBMIT_SAVE || $_POST['submit'] == $SUBMIT_BARON || $_POST['submit'] == $SUBMIT_BARONESS || $_POST['submit'] == $SUBMIT_CBARON || $_POST['submit'] == $SUBMIT_CBARONESS))
{
   $form_branch_id = NULL;
   if (isset($_POST['form_branch_id']))
   {
      $form_branch_id = clean($_POST['form_branch_id']);
   }
   $form_baron_id = NULL;
   if (isset($_POST['form_baron_id']) && $_POST['submit'] != $SUBMIT_CBARON)
   {
      $form_baron_id = clean($_POST['form_baron_id']);
   }
   $form_baroness_id = NULL;
   if (isset($_POST['form_baroness_id']) && $_POST['submit'] != $SUBMIT_CBARONESS)
   {
      $form_baroness_id = clean($_POST['form_baroness_id']);
   }
   $form_baronage_display = NULL;
   if (isset($_POST['form_baronage_display']))
   {
      $form_baronage_display = clean($_POST['form_baronage_display']);
   }
   $form_baronage_start_date = NULL;
   if (isset($_POST['form_baronage_start_date']))
   {
      $form_baronage_start_date = clean($_POST['form_baronage_start_date']);
   }
   $form_baronage_end_date = NULL;
   if (isset($_POST['form_baronage_end_date']))
   {
      $form_baronage_end_date = clean($_POST['form_baronage_end_date']);
   }
   $form_event_id = NULL;
   if (isset($_POST['form_event_id']))
   {
      $form_event_id = clean($_POST['form_event_id']);
   }
   $form_baronage_start_sequence = 0;
   if (isset($_POST['form_baronage_start_sequence']))
   {
      $form_baronage_start_sequence = clean($_POST['form_baronage_start_sequence']);
   }

   // Validate data
   if ($form_baronage_display == '')
   {
      $valid = false;
      $errmsg .= "Please enter a Display Name.<br/>";
   }
   if ($form_baronage_start_date != '')
   {
      if (strtotime($form_baronage_start_date) === FALSE)
      {
         $valid = false;
         $errmsg .= "Please enter a valid date for the Investiture Date.<br/>";
      }
      else
      {
         $form_baronage_start_date = format_mysql_date($form_baronage_start_date);
      }
   }
   if ($form_baronage_end_date != '')
   {
      if (strtotime($form_baronage_end_date) === FALSE)
      {
         $valid = false;
         $errmsg .= "Please enter a valid date for the Devestiture Date.<br/>";
      }
      else
      {
         $form_baronage_end_date = format_mysql_date($form_baronage_end_date);
      }
   }
   if (!validate_zero_plus_number($form_baronage_start_sequence))
   {
      $valid = false;
      $errmsg .= "Please enter a Sequence value that is a whole number greater than or equal to zero.<br/>";
   }

   if ($valid)
   {
      $link = db_admin_connect();

      // Update Baronage
      if ($mode == $MODE_EDIT)
      {
         $update = 
            "UPDATE $DBNAME_OP.baronage " . 
            "SET branch_id = " . value_or_null($form_branch_id) . 
            ", baron_id = " . value_or_null($form_baron_id) . 
            ", baroness_id = " . value_or_null($form_baroness_id) .
            ", baronage_display = " . value_or_null($form_baronage_display) . 
            ", baronage_start_date = " . value_or_null($form_baronage_start_date) . 
            ", baronage_end_date = " . value_or_null($form_baronage_end_date) . 
            ", baronage_start_sequence = " . value_or_zero($form_baronage_start_sequence) . 
            ", event_id = " . value_or_null($form_event_id) . 
            ", last_updated = " . value_or_null(date("Y-m-d")) .
            ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) .
            " WHERE baronage_id = ". value_or_null($form_baronage_id);

         $uresult = mysql_query($update)
            or die("Error updating Baronage: " . mysql_error());
      }
      // Insert Baronage
      else
      {
         $insert = 
            "INSERT INTO $DBNAME_OP.baronage (branch_id, baron_id, baroness_id, baronage_display, baronage_start_date, baronage_end_date, baronage_start_sequence, event_id, last_updated, last_updated_by) VALUES (" . 
            value_or_null($form_branch_id) . ", " .
            value_or_null($form_baron_id) . ", " .
            value_or_null($form_baroness_id) . ", " .
            value_or_null($form_baronage_display) . ", " .
            value_or_null($form_baronage_start_date) . ", " .
            value_or_null($form_baronage_end_date) . ", " .
            value_or_null($form_baronage_start_sequence) . ", " .
            value_or_null($form_event_id) . ", " .
            value_or_null(date("Y-m-d")) . ", " .
            value_or_null($_SESSION['s_user_id']) . ")";

         $iresult = mysql_query($insert)
            or die("Error inserting Baronage: " . mysql_error());
         $form_baronage_id = mysql_insert_id();
      }
      /* Closing connection */
      db_disconnect($link);

      // Select Baron or Baroness
      if ($_POST['submit'] == $SUBMIT_BARON || $_POST['submit'] == $SUBMIT_BARONESS)
      {
         $url = "select_baronage.php?baronage_id=$form_baronage_id&gender=";
         $gender = $FEMALE;
         if ($_POST['submit'] == $SUBMIT_BARON)
         {
            $gender = $MALE;
         }
         redirect($url . $gender);
      }
      $display_message = '<p align="center">Baronage successfully updated.  <a href="baronage.php">View the Baronage</a>.</p>';
   } // valid
}

include("header.php");
echo $display_message;

// We haven't submitted save yet - display Baronage list or edit form
if (!(isset($_POST['submit'])) || (isset($_POST['submit']) && 
   (($_POST['submit'] == $SUBMIT_SAVE || $_POST['submit'] == $SUBMIT_BARON || $_POST['submit'] == $SUBMIT_BARONESS) && !$valid) || 
   ($_POST['submit'] == $SUBMIT_DELETE)))
{
   // Do delete
   if (isset($_POST['submit']) && $_POST['submit'] == $SUBMIT_DELETE)
   {
      $del_baronage_id = '';
      for ($i = 1; $i < $_POST['del_baronage_max']; $i++)
      {
         if (isset($_POST['del_baronage_id' . $i]))
         {
            if ($del_baronage_id != '')
            {
               $del_baronage_id .= ',';
            }
            $del_baronage_id .= $_POST['del_baronage_id' . $i];
         }
      }

      if ($del_baronage_id != '')
      {
         $link = db_admin_connect();

         $delete = "DELETE FROM $DBNAME_OP.baronage WHERE baronage_id IN ($del_baronage_id)";

         $dresult = mysql_query($delete)
            or die("Error deleteing Baronage: " . mysql_error());

         /* Closing connection */
         db_disconnect($link);
      }
      else
      {
         $delerrmsg = "Please select at least one Baronage to delete.";
         $display_message = '<p align="center" class="title3" style="color:red">' . $delerrmsg . '</p>';
         echo $display_message;
      }
   }

   // Dislay edit list
   if ($mode == $MODE_EDIT && (!isset($form_baronage_id) || $form_baronage_id == 0))
   {
      $link = db_connect();
      $query = "SELECT baronage.*, branch, b1.sca_name AS baron, b2.sca_name AS baroness " . 
               "FROM $DBNAME_OP.baronage INNER JOIN $DBNAME_BRANCH.branch ON baronage.branch_id = branch.branch_id " . 
               "LEFT OUTER JOIN $DBNAME_AUTH.atlantian b1 ON baronage.baron_id = b1.atlantian_id " .
               "LEFT OUTER JOIN $DBNAME_AUTH.atlantian b2 ON baronage.baroness_id = b2.atlantian_id " .
               "ORDER BY branch_id, baronage_start_date";
      $result = mysql_query($query);

?>
<p align="center">
To edit an existing Baronage: Click on the Baronage link.<br/>
To delete an existing Baronage: Check the box in front of the Baronage and click the <?php echo $SUBMIT_DELETE; ?> button.<br/>
To add a new Baronage: Visit the <a href="<?php echo $_SERVER['PHP_SELF'] . "?mode=" . $MODE_ADD; ?>">Add Baronage page</a>.<br/>
</p>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table align="center" border="1" cellpadding="5" cellspacing="0" summary="Baronage Update Form">
<?php 
      $i = 1;
      $prev_branch_id = 0;
      while ($data = mysql_fetch_array($result, MYSQL_BOTH))
      {
         $branch_id = $data['branch_id'];
         if ($branch_id != $prev_branch_id)
         {
            $branch = stripslashes(trim($data['branch']));
            $prev_branch_id = $branch_id;
?>
   <tr>
      <th class="title" colspan="3"><?php echo $branch; ?></th>
   </tr>
   <tr>
      <th class="title"><label for="del_baronage_id">Select</label></th>
      <th class="title">Investiture Date</th>
      <th class="title">Baronage</th>
   </tr>
<?php 
         }
         $baronage_id = $data['baronage_id'];
         $baronage_display = stripslashes(trim($data['baronage_display']));
         $baronage_start_date = $data['baronage_start_date'];
         if ($baronage_start_date != null)
         {
            $baronage_start_date = format_short_date($baronage_start_date);
         }
?>
   <tr>
      <td class="title"><input type="checkbox" name="del_baronage_id<?php echo $i; ?>" id="del_baronage_id<?php echo $i++; ?>" value="<?php echo $baronage_id; ?>"/></td>
      <td class="dataright"><?php echo $baronage_start_date; ?></td>
      <td class="data">
      <a href="<?php echo $_SERVER['PHP_SELF'] . "?form_baronage_id=" . $baronage_id; ?>"><?php echo $baronage_display; ?></a>
      </td>
   </tr>
<?php 
      }
?>
   <input type="hidden" name="del_baronage_max" id="del_baronage_max" value="<?php echo $i; ?>"/>
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
      // Get Pick Lists
      $link = db_connect();

      // Get Barony List
      $barony_query = "SELECT branch, branch_id " .
         "FROM $DBNAME_BRANCH.branch " .
         "WHERE branch.branch_type_id IN (" . $BT_BARONY . ") " .
         "AND parent_branch_id = " . $ATLANTIA . " " .
         "ORDER BY branch";
      $barony_result = mysql_query($barony_query)
         or die("Error reading Barony list: " . mysql_error());
      $barony_data_array = array();
      $i = 0;
      while ($barony_data = mysql_fetch_array($barony_result, MYSQL_BOTH))
      {
         $barony_id = $barony_data['branch_id'];
         $barony = stripslashes(trim($barony_data['branch']));
         $barony_data_array[$i]['branch_id'] = $barony_id;
         $barony_data_array[$i++]['branch'] = $barony;
      }
      mysql_free_result($barony_result);

      db_disconnect($link);

      // Get data for edit
      if ($mode == $MODE_EDIT && $valid)
      {
         $link = db_connect();

         // Get Baron information, if already selected
         $form_baron = null;
         if ($form_baron_id > 0)
         {
            $query = "SELECT sca_name FROM $DBNAME_AUTH.atlantian WHERE atlantian_id = $form_baron_id";
            $result = mysql_query($query);
            $data = mysql_fetch_array($result, MYSQL_BOTH);
            $form_baron = stripslashes(trim($data['sca_name']));
            mysql_free_result($result);
         }
         // Get Baroness information, if already selected
         $form_baroness = null;
         if ($form_baroness_id > 0)
         {
            $query = "SELECT sca_name FROM $DBNAME_AUTH.atlantian WHERE atlantian_id = $form_baroness_id";
            $result = mysql_query($query);
            $data = mysql_fetch_array($result, MYSQL_BOTH);
            $form_baroness = stripslashes(trim($data['sca_name']));
            mysql_free_result($result);
         }

         $query = "SELECT baronage.*, b1.sca_name AS baron, b2.sca_name AS baroness " .
            "FROM $DBNAME_OP.baronage LEFT OUTER JOIN $DBNAME_AUTH.atlantian b1 ON baronage.baron_id = b1.atlantian_id " . 
            "LEFT OUTER JOIN $DBNAME_AUTH.atlantian b2 ON baronage.baroness_id = b2.atlantian_id " .
            "WHERE baronage_id = " . $form_baronage_id;
         $result = mysql_query($query);

         $data = mysql_fetch_array($result, MYSQL_BOTH);
         $form_baronage_id = $data['baronage_id'];
         $form_baronage_display = stripslashes(trim($data['baronage_display']));
         $form_baronage_start_date = $data['baronage_start_date'];
         $form_baronage_end_date = $data['baronage_end_date'];
         $form_baronage_start_sequence = $data['baronage_start_sequence'];
         $form_branch_id = $data['branch_id'];
         $form_event_id = $data['event_id'];
         if ($form_baron_id == 0)
         {
            $form_baron_id = $data['baron_id'];
            $form_baron = stripslashes(trim($data['baron']));
         }
         if ($form_baroness_id == 0)
         {
            $form_baroness_id = $data['baroness_id'];
            $form_baroness = stripslashes(trim($data['baroness']));
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
<p class="title2"><?php echo ucfirst($mode); ?> Baronage</p>
<table border="1" cellpadding="5" cellspacing="0" summary="Baronage Form">
<?php 
      if (isset($form_baronage_id) && $form_baronage_id > 0)
      {
?>
   <input type="hidden" name="form_baronage_id" id="form_baronage_id" value="<?php echo $form_baronage_id; ?>"/>
<?php 
      }
      if (isset($form_baron_id) && $form_baron_id > 0)
      {
?>
   <input type="hidden" name="form_baron_id" id="form_baron_id" value="<?php echo $form_baron_id; ?>"/>
<?php 
      }
      if (isset($form_baroness_id) && $form_baroness_id > 0)
      {
?>
   <input type="hidden" name="form_baroness_id" id="form_baroness_id" value="<?php echo $form_baroness_id; ?>"/>
<?php 
      }
?>
   <tr>
      <th class="titleright">Baronage ID:</th>
      <td class="data"><?php if (isset($form_baronage_id) && trim($form_baronage_id) != '' && $form_baronage_id > 0) { echo $form_baronage_id; } ?></td>
   </tr>
   <tr>
      <td class="titleright"><label for="form_branch_id">Barony:</label></td>
      <td class="data">
      <select name="form_branch_id" id="form_branch_id">
         <option></option>
         <?php
            for ($i = 0; $i < count($barony_data_array); $i++)
            {
               echo '<option value="' . $barony_data_array[$i]['branch_id'] . '"';
               if (isset($form_branch_id) && $form_branch_id == $barony_data_array[$i]['branch_id'])
               {
                  echo ' selected';
               }
               echo '>' . $barony_data_array[$i]['branch'] . '</option>';
            }
         ?>
      </select>
      </td>
   </tr>
   <tr>
      <th class="titleright">Baron:</th>
      <td class="data"><input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_BARON; ?>"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if (isset($form_baron) && trim($form_baron) != '') { echo $form_baron . "&nbsp;&nbsp;&nbsp;<input type=\"submit\" name=\"submit\" id=\"submit\" value=\"$SUBMIT_CBARON\"/>"; } ?></td>
   </tr>
   <tr>
      <th class="titleright">Baroness:</th>
      <td class="data"><input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_BARONESS; ?>"/>&nbsp;&nbsp;&nbsp;<?php if (isset($form_baroness) && trim($form_baroness) != '') { echo $form_baroness . "&nbsp;&nbsp;&nbsp;<input type=\"submit\" name=\"submit\" id=\"submit\" value=\"$SUBMIT_CBARONESS\"/>"; } ?></td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_baronage_display">Display Name:</label></th>
      <td class="data"><input type="text" name="form_baronage_display" id="form_baronage_display" size="50" maxlength="255"<?php if (isset($form_baronage_display) && trim($form_baronage_display) != '') { echo " value=\"" . $form_baronage_display . "\""; } ?>/></td>
   </tr>
   <tr>
      <td class="titleright"><label for="form_baronage_start_date">Invesiture Date:</label></td>
      <td class="data"><input type="text" name="form_baronage_start_date" id="form_baronage_start_date" size="10" maxlength="10"<?php if (isset($form_baronage_start_date) && trim($form_baronage_start_date) != '') { echo " value=\"" . $form_baronage_start_date . "\""; } ?>/></td>
   </tr>
   <tr>
      <td class="titleright"><label for="form_baronage_start_sequence">Investiture Sequence:</label></td>
      <td class="data"><input type="text" name="form_baronage_start_sequence" id="form_baronage_start_sequence" size="10" maxlength="10"<?php if (isset($form_baronage_start_sequence) && trim($form_baronage_start_sequence) != '') { echo " value=\"" . $form_baronage_start_sequence . "\""; } ?>/></td>
   </tr>
   <tr>
      <td class="titleright"><label for="form_baronage_end_date">Devesiture Date:</label></td>
      <td class="data"><input type="text" name="form_baronage_end_date" id="form_baronage_end_date" size="10" maxlength="10"<?php if (isset($form_baronage_end_date) && trim($form_baronage_end_date) != '') { echo " value=\"" . $form_baronage_end_date . "\""; } ?>/></td>
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
<p align="center" class="title2">Baronage</p>
<p align="center">You are not authorized to access this page.</p>
<?php
}
include("footer.php");
?>
