<?php
include_once("db.php");

$form_eastern_id = 0;
if (isset($_POST['form_eastern_id']))
{
   $form_eastern_id = clean($_POST['form_eastern_id']);
}
else if (isset($_GET['eastern_id']))
{
   $form_eastern_id = clean($_GET['eastern_id']);
}

$mode = $MODE_EDIT;
if (isset($_REQUEST['mode']))
{
   $mode = clean($_REQUEST['mode']);
}

if (isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN])
{

   if ($mode == $MODE_EDIT && $form_eastern_id == 0)
   {
      $no_edit_selection = true;
   }

   $SUBMIT_SAVE = "Save Easterner";
   $SUBMIT_DELETE = "Delete Easterner";
   $SUBMIT_MERGE = "Merge Easterner";

   // Data submitted
   if (isset($_POST['submit']))
   {
      if ($_POST['submit'] == $SUBMIT_DELETE)
      {
         if ($mode == $MODE_EDIT && $form_eastern_id > 0)
         {
            $count = 0;
            // Check for child OP records: eastern_award
            $link = db_admin_connect();

            $check_query = "SELECT eastern_id FROM $DBNAME_OP.eastern_award WHERE eastern_id = $form_eastern_id";
            $check_result = mysql_query($check_query)
               or die("Error checking OP for Eastern: " . mysql_error());
            $count += mysql_num_rows($check_result);

            // Check for child order records: orders, users
            $check_query = "SELECT eastern_id FROM $DBNAME_AUTH.user_auth WHERE eastern_id = $form_eastern_id";
            $check_result = mysql_query($check_query)
               or die("Error checking Unified for Eastern: " . mysql_error());
            $count += mysql_num_rows($check_result);

            // Only delete if the checks passed
            if ($count == 0)
            {
               // Delete Eastern
               $delete = "DELETE FROM $DBNAME_AUTH.eastern WHERE eastern_id = $form_eastern_id";
               $del_result = mysql_query($delete)
                  or die("Error deleting Easterner: " . mysql_error());

               // Redirect to edit page
               redirect("deleted.php?type_id=$DEL_TYPE_ATLANTIAN");
            }
            // Error - need to delete child records first
            else
            {
               $valid = false;
               if ($count == 1)
               {
                  $errmsg = "There is a child record";
               }
               else
               {
                  $errmsg = "There are $count child records";
               }
               $errmsg .= " for Easterner ID $form_eastern_id; this Easterner may not be deleted until all child records are deleted.";
            }
            // Close DBs
            db_disconnect($link);
         }
      } // End Submit Delete
      if ($_POST['submit'] == $SUBMIT_SAVE)
      {
         $form_first_name = clean($_POST['form_first_name']);
         $form_middle_name = clean($_POST['form_middle_name']);
         $form_last_name = clean($_POST['form_last_name']);
         $form_email = clean($_POST['form_email']);

         $form_gender = $UNKNOWN;
         if (isset($_POST['form_gender']))
         {
            $form_gender = clean($_POST['form_gender']);
         }

         $form_inactive = 0;
         if (isset($_POST['form_inactive']))
         {
            $form_inactive = clean($_POST['form_inactive']);
         }

         $form_deceased = 0;
         if (isset($_POST['form_deceased']))
         {
            $form_deceased = clean($_POST['form_deceased']);
            if ($form_deceased == 1)
            {
               $form_inactive = 1;
            }
         }
         $form_deceased_date = clean($_POST['form_deceased_date']);

         $form_revoked = 0;
         if (isset($_POST['form_revoked']))
         {
            $form_revoked = clean($_POST['form_revoked']);
         }
         $form_revoked_date = clean($_POST['form_revoked_date']);

         $form_sca_name = clean($_POST['form_sca_name']);
         $form_preferred_sca_name = clean($_POST['form_preferred_sca_name']);
         $form_branch_id = clean($_POST['form_branch_id']);
         $form_blazon = clean($_POST['form_blazon']);
         $form_name_reg_date = clean($_POST['form_name_reg_date']);
         $form_device_reg_date = clean($_POST['form_device_reg_date']);
         $form_alternate_names = clean($_POST['form_alternate_names']);

         $form_device_file_name = clean($_POST['form_device_file_name']);
         $form_device_file_credit = clean($_POST['form_device_file_credit']);
         $form_op_notes = clean($_POST['form_op_notes']);

         $valid = true;
         $errmsg = '';
         // Validate data
         if ($form_sca_name == '')
         {
            $valid = false;
            $errmsg .= "Please enter an SCA name.<br/>";
         }
         if ($form_deceased_date != '')
         {
            if (strtotime($form_deceased_date) === FALSE)
            {
               $valid = false;
               $errmsg .= "Please enter a valid date for the Deceased Date.<br/>";
            }
            else
            {
               $form_deceased_date = format_mysql_date($form_deceased_date);
               $form_deceased = 1;
            }
         }
         if ($form_revoked_date != '')
         {
            if (strtotime($form_revoked_date) === FALSE)
            {
               $valid = false;
               $errmsg .= "Please enter a valid date for the Revoked Date.<br/>";
            }
            else
            {
               $form_revoked_date = format_mysql_date($form_revoked_date);
               $form_revoked = 1;
            }
         }
         if ($form_email != '' && !validate_email($form_email))
         {
            $valid = false;
            $errmsg .= "Please enter an email address with one @ and no spaces.<br/>";
         }
         if ($form_name_reg_date != '')
         {
            if (strtotime($form_name_reg_date) === FALSE)
            {
               $valid = false;
               $errmsg .= "Please enter a valid date for the Name Registration Date.<br/>";
            }
            else
            {
               $form_name_reg_date = format_mysql_date($form_name_reg_date);
            }
         }
         if ($form_device_reg_date != '')
         {
            if (strtotime($form_device_reg_date) === FALSE)
            {
               $valid = false;
               $errmsg .= "Please enter a valid date for the Device Registration Date.<br/>";
            }
            else
            {
               $form_device_reg_date = format_mysql_date($form_device_reg_date);
            }
         }

         // Update database if valid
         if ($valid)
         {
            $link = db_admin_connect();
            // Update
            if ($form_eastern_id > 0)
            {
               // Get previous SCA Name
               $name_query = "SELECT sca_name, preferred_sca_name FROM $DBNAME_AUTH.eastern WHERE eastern_id = " . value_or_null($form_eastern_id);

               $name_result = mysql_query($name_query)
                  or die("Error retrieving Easterner SCA Name: " . mysql_error());

               $name_data = mysql_fetch_array($name_result, MYSQL_BOTH);

               $prev_name = $name_data['sca_name'];
               $prev_pref_name = $name_data['preferred_sca_name'];

               // If the current SCA name does not match the previous SCA name, and the previous SCA and preferred names matched
               if ($prev_name != $form_sca_name && $prev_name == $prev_pref_name)
               {
                  // Update the preferred name to continue to match the SCA name
                  $form_preferred_sca_name = $form_sca_name;
               }

               $sql_stmt = "UPDATE $DBNAME_AUTH.eastern SET " .
                  "first_name = " . value_or_null($form_first_name) .
                  ", middle_name = " . value_or_null($form_middle_name) .
                  ", last_name = " . value_or_null($form_last_name) .
                  ", email = " . value_or_null($form_email) .
                  ", gender = " . value_or_null($form_gender) .
                  ", deceased = " . value_or_zero($form_deceased) .
                  ", deceased_date = " . value_or_null($form_deceased_date) .
                  ", inactive = " . value_or_zero($form_inactive) .
                  ", revoked = " . value_or_zero($form_revoked) .
                  ", revoked_date = " . value_or_null($form_revoked_date) .
                  ", sca_name = " . value_or_null($form_sca_name) .
                  ", preferred_sca_name = " . value_or_null($form_preferred_sca_name) .
                  ", branch_id = " . value_or_null($form_branch_id) .
                  ", blazon = " . value_or_null($form_blazon) .
                  ", name_reg_date = " . value_or_null($form_name_reg_date) .
                  ", device_reg_date = " . value_or_null($form_device_reg_date) .
                  ", alternate_names = " . value_or_null($form_alternate_names) .
                  ", last_updated = " . value_or_null(date("Y-m-d")) .
                  ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) .
                  ", device_file_name = " . value_or_null($form_device_file_name) .
                  ", device_file_credit = " . value_or_null($form_device_file_credit) .
                  ", op_notes = " . value_or_null($form_op_notes) .
                  " WHERE eastern_id = " . value_or_null($form_eastern_id);

               $sql_result = mysql_query($sql_stmt)
                  or die("Error updating Easterner data: " . mysql_error());
            }
            // Insert
            else
            {
               // If the preferred SCA name is blank, make it match the SCA name
               if ($form_preferred_sca_name == "")
               {
                  $form_preferred_sca_name = $form_sca_name;
               }

               $sql_stmt = "INSERT INTO $DBNAME_AUTH.eastern (first_name, middle_name, last_name, email, gender, deceased, deceased_date, inactive, revoked, revoked_date, " .
                  "sca_name, preferred_sca_name, branch_id, blazon, name_reg_date, device_reg_date, alternate_names, last_updated, last_updated_by, device_file_name, device_file_credit, op_notes " .
                  ") VALUES (" .
                  value_or_null($form_first_name) . ", " .
                  value_or_null($form_middle_name) . ", " .
                  value_or_null($form_last_name) . ", " .
                  value_or_null($form_email) . ", " .
                  value_or_null($form_gender) . ", " .
                  value_or_zero($form_deceased) . ", " .
                  value_or_null($form_deceased_date) . ", " .
                  value_or_zero($form_inactive) . ", " .
                  value_or_zero($form_revoked) . ", " .
                  value_or_null($form_revoked_date) . ", " .
                  value_or_null($form_sca_name) . ", " .
                  value_or_null($form_preferred_sca_name) . ", " .
                  value_or_null($form_branch_id) . ", " .
                  value_or_null($form_blazon) . ", " .
                  value_or_null($form_name_reg_date) . ", " .
                  value_or_null($form_device_reg_date) . ", " .
                  value_or_null($form_alternate_names) . ", " .
                  value_or_null(date("Y-m-d")) . ", " .
                  value_or_null($_SESSION['s_user_id']) . ", " .
                  value_or_null($form_device_file_name) . ", " .
                  value_or_null($form_device_file_credit) . ", " .
                  value_or_null($form_op_notes) .
                  ")";

               $sql_result = mysql_query($sql_stmt)
                  or die("Error inserting Easterner data: " . mysql_error());
               $form_eastern_id = mysql_insert_id();
            }

            db_disconnect($link);

            // Redirect to edit page
            redirect("eastern.php?eastern_id=$form_eastern_id&mode=$MODE_EDIT");
         }
      } // Submit Save
   } // Submit
   // Read Existing Easterner - if this isn't a submit, or it is a failed submit delete
   if ($form_eastern_id > 0 && (!(isset($_POST['submit'])) || (isset($_POST['submit']) && $_POST['submit'] == $SUBMIT_DELETE)))
   {
      $link = db_connect();
      $query = "SELECT * FROM $DBNAME_AUTH.eastern WHERE eastern_id = " . value_or_null($form_eastern_id);
      $result = mysql_query($query);
      $data = mysql_fetch_array($result, MYSQL_BOTH);

      $form_first_name = clean($data['first_name']);
      $form_middle_name = clean($data['middle_name']);
      $form_last_name = clean($data['last_name']);
      $form_email = clean($data['email']);

      $form_gender = clean($data['gender']);
      $form_deceased = clean($data['deceased']);
      $form_deceased_date = clean($data['deceased_date']);
      $form_inactive = clean($data['inactive']);
      $form_revoked = clean($data['revoked']);
      $form_revoked_date = clean($data['revoked_date']);
      $form_sca_name = clean($data['sca_name']);
      $form_preferred_sca_name = clean($data['preferred_sca_name']);
      $form_name_reg_date = clean($data['name_reg_date']);
      $form_alternate_names = clean($data['alternate_names']);
      $form_blazon = clean($data['blazon']);
      $form_device_reg_date = clean($data['device_reg_date']);
      $form_device_file_name = clean($data['device_file_name']);
      $form_device_file_credit = clean($data['device_file_credit']);
      $form_op_notes = clean($data['op_notes']);
      $form_branch_id = clean($data['branch_id']);

      mysql_free_result($result);

      db_disconnect($link);
   }

// Get pick lists
$branch_data_array = get_branch_pick_list();

$title = ucfirst($mode) . " Easterner";
include("header.php");
?>
<p align="center" class="title2"><?php echo ucfirst($mode); ?> Easterner</p>
<p align="center" class="title2">Easterner Information</p>
<?php 
   if (isset($no_edit_selection) && $no_edit_selection)
   {
?>
<p align="center" class="title3" style="color:red">No Easterner was selected for Edit.  Please use a navigation link to the left.</p>
<?php 
   }
   else
   {
?>
<?php 
      if (isset($valid) && !$valid && isset($errmsg) && $errmsg != '')
      {
?>
<p align="center" class="title3" style="color:red">Please correct the following errors:<br/><br/><?php echo $errmsg; ?></p>
<?php 
      }
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>"/>
<?php 
      if (isset($form_eastern_id) && $form_eastern_id > 0)
      {
?>
   <input type="hidden" name="form_eastern_id" id="form_eastern_id" value="<?php echo $form_eastern_id; ?>"/>
<?php 
      }
?>
<table align="center" cellpadding="5" cellspacing="0" border="1">
   <tr>
      <th class="title" colspan="4" bgcolor="#FFFF99">Contact Information</th>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Name</td>
      <td class="data" colspan="3">
      <b>First</b> <input type="text" name="form_first_name" id="form_first_name" size="20" maxlength="50"<?php if (isset($form_first_name) && $form_first_name != '') { echo " value=\"$form_first_name\"";} ?>/>
      <b>Middle</b> <input type="text" name="form_middle_name" id="form_middle_name" size="30" maxlength="50"<?php if (isset($form_middle_name) && $form_middle_name != '') { echo " value=\"$form_middle_name\"";} ?>/>
      <b>Last</b> <input type="text" name="form_last_name" id="form_last_name" size="30" maxlength="50"<?php if (isset($form_last_name) && $form_last_name != '') { echo " value=\"$form_last_name\"";} ?>/>
      </td>
   </tr>
   <tr>
      <th class="titleright" bgcolor="#FFFFCC"><label for="form_gender">Gender</label></th>
      <td class="data"><input name="form_gender" id="form_genderM" type="radio" value="<?php echo $MALE; ?>"<?php if (isset($form_gender) && $form_gender == $MALE) { echo ' CHECKED'; }?>/>Male 
      &nbsp;&nbsp;<input name="form_gender" id="form_genderF" type="radio" value="<?php echo $FEMALE; ?>"<?php if (isset($form_gender) && $form_gender == $FEMALE) { echo ' CHECKED'; }?>/>Female
      &nbsp;&nbsp;<input name="form_gender" id="form_genderU" type="radio" value="<?php echo $UNKNOWN; ?>"<?php if (isset($form_gender) && $form_gender == $UNKNOWN) { echo ' CHECKED'; }?>/>Unknown
      &nbsp;&nbsp;<input name="form_gender" id="form_genderN" type="radio" value="<?php echo $NONE; ?>"<?php if (isset($form_gender) && $form_gender == $NONE) { echo ' CHECKED'; }?>/>None
      </td>
      <th class="titleright" bgcolor="#FFFFCC"><label for="form_deceased">Deceased</label></th>
      <td class="data">
      <input type="checkbox" name="form_deceased" id="form_deceased" value="1"<?php if (isset($form_deceased) && $form_deceased == 1) { echo ' CHECKED'; }?> />
      &nbsp;
      <b>Date</b> <input type="text" name="form_deceased_date" id="form_deceased_date" size="11" maxlength="10"<?php if (isset($form_deceased_date) && $form_deceased_date != '') { echo " value=\"$form_deceased_date\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Email</td>
      <td class="data" colspan="3"><input type="text" name="form_email" id="form_email" size="50" maxlength="100"<?php if (isset($form_email) && $form_email != '') { echo " value=\"$form_email\"";} ?>></td>
   </tr>
   <tr>
      <th class="title" colspan="4" bgcolor="#FFFF99">SCA Information</th>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">SCA Name</td>
      <td class="data"><input type="text" name="form_sca_name" id="form_sca_name" size="50" maxlength="255"<?php if (isset($form_sca_name) && $form_sca_name != '') { echo " value=\"$form_sca_name\"";} ?>/></td>
      <td class="titleright" bgcolor="#FFFFCC">Branch</td>
      <td class="data">
      <select name="form_branch_id" id="form_branch_id">
         <option></option>
         <?php
            for ($i = 0; $i < count($branch_data_array); $i++)
            {
               echo '<option value="' . $branch_data_array[$i]['branch_id'] . '"';
               if (isset($form_branch_id) && $form_branch_id == $branch_data_array[$i]['branch_id'])
               {
                  echo ' selected';
               }
               echo '>' . $branch_data_array[$i]['branch_name'] . '</option>';
            }
         ?>
      </select>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Date Name Registered</td>
      <td class="data"><input type="text" name="form_name_reg_date" id="form_name_reg_date" size="15" maxlength="10"<?php if (isset($form_name_reg_date) && $form_name_reg_date != '') { echo " value=\"$form_name_reg_date\"";} ?>/></td>
      <td class="titleright" bgcolor="#FFFFCC">Date Device Registered</td>
      <td class="data"><input type="text" name="form_device_reg_date" id="form_device_reg_date" size="15" maxlength="10"<?php if (isset($form_device_reg_date) && $form_device_reg_date != '') { echo " value=\"$form_device_reg_date\"";} ?>/></td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Blazon</td>
      <td class="data" colspan="3"><input type="text" name="form_blazon" id="form_blazon" size="100" maxlength="65535"<?php if (isset($form_blazon) && $form_blazon != '') { echo " value=\"$form_blazon\"";} ?>/></td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Preferred SCA Name</td>
      <td class="data" colspan="3"><input type="text" name="form_preferred_sca_name" id="form_preferred_sca_name" size="50" maxlength="255"<?php if (isset($form_preferred_sca_name) && $form_preferred_sca_name != '') { echo " value=\"$form_preferred_sca_name\"";} ?>/></td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Alternate Names</td>
      <td class="data" colspan="3"><input type="text" name="form_alternate_names" id="form_alternate_names" size="100" maxlength="255"<?php if (isset($form_alternate_names) && $form_alternate_names != '') { echo " value=\"$form_alternate_names\"";} ?>/></td>
   </tr>
      <th class="titleright" bgcolor="#FFFFCC"><label for="form_inactive">Inactive</label></th>
      <td class="data">
      <input type="checkbox" name="form_inactive" id="form_inactive" value="1"<?php if (isset($form_inactive) && $form_inactive == 1) { echo ' CHECKED'; }?>/>
      </td>
      <th class="titleright" bgcolor="#FFFFCC"><label for="form_revoked">Revoked and Denied</label></th>
      <td class="data">
      <input type="checkbox" name="form_revoked" id="form_revoked" value="1"<?php if (isset($form_revoked) && $form_revoked == 1) { echo ' CHECKED'; }?>/>
      &nbsp;
      <b>Date</b> <input type="text" name="form_revoked_date" id="form_revoked_date" size="11" maxlength="10"<?php if (isset($form_revoked_date) && $form_revoked_date != '') { echo " value=\"$form_revoked_date\"";} ?>/>
      </td>
   <tr>
      <th class="title" colspan="4" bgcolor="#FFFF99">System Information</th>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Device File Name</td>
      <td class="data" colspan="3"><input type="text" name="form_device_file_name" id="form_device_file_name" size="100" maxlength="255"<?php if (isset($form_device_file_name) && $form_device_file_name != '') { echo " value=\"$form_device_file_name\"";} ?>/></td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Device File Credit</td>
      <td class="data" colspan="3"><input type="text" name="form_device_file_credit" id="form_device_file_credit" size="100" maxlength="255"<?php if (isset($form_device_file_credit) && $form_device_file_credit != '') { echo " value=\"$form_device_file_credit\"";} ?>/></td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Notes</td>
      <td class="data" colspan="3"><input type="text" name="form_op_notes" id="form_op_notes" size="100" maxlength="65535"<?php if (isset($form_op_notes) && $form_op_notes != '') { echo " value=\"$form_op_notes\"";} ?>/></td>
   </tr>
</table>
<p class="datacenter">
<input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_SAVE; ?>"/>
<?php if ($mode == $MODE_EDIT) {?>
&nbsp;&nbsp;&nbsp;<input name="submit" id="submit" type="submit" value="<?php echo $SUBMIT_DELETE; ?>"/>
<?php } ?>
</p>
</form>
<?php
      if ($mode == $MODE_EDIT)
      {
?>
<table border="0" align="center" cellpadding="5" summary="">
   <tr>
      <td>
      <form action="eastern_award.php" method="post">
         <input type="hidden" name="form_eastern_id" id="form_eastern_id" value="<?php echo $form_eastern_id; ?>"/>
         <input type="hidden" name="mode" id="mode" value="<?php echo $MODE_ADD; ?>"/>
         <input type="submit" value="Add Award for <?php echo $form_sca_name; ?>"/>
      </form>
      </td>
      <td>
      <form action="select_eastern.php" method="post">
         <input type="hidden" name="first_eastern_id" id="first_eastern_id" value="<?php echo $form_eastern_id; ?>"/>
         <input type="hidden" name="mode" id="mode" value="<?php echo $MODE_EDIT; ?>"/>
         <input type="hidden" name="type" id="type" value="<?php echo $TYPE_MERGE; ?>"/>
         <input type="submit" value="<?php echo $SUBMIT_MERGE; ?>"/>
      </form>
      </td>
   </tr>
   <tr><td colspan="2" align="center"><a href="../op_ind.php?eastern_id=<?php echo $form_eastern_id; ?>">View Individual Page</a></td></tr>
</table>
<?php
         $link = db_connect();
         $award_query = "SELECT eastern_award.*, award.award_name, branch.branch, rg.branch AS rg, " .
                        "event.event_name, reign.monarchs_display, principality.principality_display, baronage.baronage_display, " .
                        "event_loc.branch as event_location, event.event_id " .
                        "FROM $DBNAME_OP.eastern_award JOIN award ON eastern_award.award_id = award.award_id " .
                        "JOIN $DBNAME_OP.precedence ON award.type_id = precedence.type_id " .
                        "LEFT OUTER JOIN $DBNAME_BRANCH.branch ON eastern_award.branch_id = branch.branch_id " .
                        "LEFT OUTER JOIN $DBNAME_BRANCH.branch rg ON award.branch_id = rg.branch_id " .
                        "LEFT OUTER JOIN $DBNAME_OP.court_report ON eastern_award.court_report_id = court_report.court_report_id " .
                        "LEFT OUTER JOIN $DBNAME_OP.event ON eastern_award.event_id = event.event_id " .
                        "LEFT OUTER JOIN $DBNAME_BRANCH.branch event_loc ON event.branch_id = event_loc.branch_id " .
                        "LEFT OUTER JOIN $DBNAME_OP.reign ON court_report.reign_id = reign.reign_id " .
                        "LEFT OUTER JOIN $DBNAME_OP.principality ON court_report.principality_id = principality.principality_id " .
                        "LEFT OUTER JOIN $DBNAME_OP.baronage ON court_report.baronage_id = baronage.baronage_id " .
                        "WHERE eastern_id = $form_eastern_id ORDER BY precedence, award_date, sequence";
         /* Performing SQL query */
         $award_result = mysql_query($award_query) 
            or die("Award Query failed : " . mysql_error());
         $num_awards = mysql_num_rows($award_result);
         if ($num_awards > 0)
         {
?>
<p align="center" class="title2">Awards</p>
<p class="datacenter">
Click the Edit button to edit an award.<br/>
<img src="<?php echo $IMAGES_DIR; ?>private.gif" width="15" height="15" alt="Marked Private" border="0"/> Lock icon indicates record is marked private.
</p>
<table align="center" cellpadding="5" cellspacing="0" border="1" summary="">
   <tr>
      <th class="title" bgcolor="#FFFFCC">Edit</td>
      <th class="title" bgcolor="#FFFFCC">Award Name</td>
      <th class="title" bgcolor="#FFFFCC">Award Date</td>
      <th class="title" bgcolor="#FFFFCC">Event</td>
      <th class="title" bgcolor="#FFFFCC">Bestowed By</td>
      <th class="title" bgcolor="#FFFFCC">Sequence</td>
   </tr>
<?php
            while ($award_data = mysql_fetch_array($award_result, MYSQL_BOTH))
            {
               $eastern_award_id = $award_data['eastern_award_id'];
               $eastern_id = $award_data['eastern_id'];
               $award_id = $award_data['award_id'];
               $award_name = clean($award_data['award_name']);
               $branch = clean($award_data['branch']);
               $rg = clean($award_data['rg']);
               $rg_display = $branch;
               if ($rg_display == null || $rg_display == '')
               {
                  $rg_display = $rg;
               }
               if ($rg_display != null && $rg_display != '')
               {
                  $rg_display = " (" . $rg_display . ")";
               }
               $award_date = $award_data['award_date'];
               if ($award_date == "" || $award_date == "0000-00-00")
               {
                  $award_date = "<i>Unknown</i>";
               }
               else
               {
                  $award_date = format_short_date($award_date);
               }
               $event_id = $award_data['event_id'];
               $event_name = clean($award_data['event_name']);
               $event_loc = clean($award_data['event_location']);
               $event_name_display = $event_name;
               if ($event_name_display != "")
               {
                  $event_name_display = "<a href=\"event.php?mode=edit&event_id=$event_id\" class=\"td\">$event_name_display</a>";
               }
               if ($event_loc != "")
               {
                  $event_name_display .= " (" . $event_loc . ")";
               }
               $bestow_display = "";
               $monarchs_display = clean($award_data['monarchs_display']);
               $principality_display = clean($award_data['principality_display']);
               $baronage_display = clean($award_data['baronage_display']);
               if ($monarchs_display != "")
               {
                  $bestow_display = $monarchs_display;
               }
               else if ($baronage_display != "")
               {
                  $bestow_display = $baronage_display;
               }
               else if ($principality_display != "")
               {
                  $bestow_display = $principality_display;
               }
               $sequence = $award_data['sequence'];
               $private = $award_data['private'];
               $private_display = "";
               if ($private == 1)
               {
                  $private_display = "<img src=\"" . $IMAGES_DIR . "private.gif\" width=\"15\" height=\"15\" alt=\"Marked Private\" border=\"0\"/> ";
               }

               $form_event_id = clean($award_data['event_id']);
               $form_court_report_id = clean($award_data['court_report_id']);
?>
   <tr>
      <td>
      <form action="eastern_award.php" method="post">
         <input type="hidden" name="form_eastern_id" id="form_eastern_id" value="<?php echo $eastern_id; ?>"/>
         <input type="hidden" name="form_award_id" id="form_award_id" value="<?php echo $award_id; ?>"/>
         <input type="hidden" name="form_eastern_award_id" id="form_eastern_award_id" value="<?php echo $eastern_award_id; ?>"/>
         <input type="hidden" name="form_event_id" id="form_event_id" value="<?php echo $form_event_id; ?>"/>
         <input type="hidden" name="form_court_report_id" id="form_court_report_id" value="<?php echo $form_court_report_id; ?>"/>
         <input type="hidden" name="mode" id="mode" value="<?php echo $MODE_EDIT; ?>"/>
         <input type="submit" value="Edit"/>
      </form>
      </td>
      <td class="data"><?php echo $award_name . $rg_display; ?></td>
      <td class="datacenter"><?php echo $award_date; ?></td>
      <td class="data"><?php echo $event_name_display; ?></td>
      <td class="data"><?php echo $bestow_display; ?></td>
      <td class="data"><?php echo $sequence; ?></td>
   </tr>
<?php
            }
?>
</table>
<p align="center"><?php echo $num_awards; ?> award<?php if ($num_awards > 1) { echo "s"; } ?> given.</p>
<?php
            db_disconnect($link);
         }
      }
   } // End Add or Edit Selection
}
// Not authorized
else
{
include("header.php");
?>
<p align="center" class="title2">Edit Easterner</p>
<p align="center" class="title2">You are not authorized to access this page.</p>
<?php
}
include("footer.php");
?>
