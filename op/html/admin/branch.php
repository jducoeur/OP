<?php 
include_once("db.php");
include("header.php");

// Only web admins allowed
if ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]))
{
$SUBMIT_SAVE = "Save Changes";

$SUBMIT_DELETE = "Delete Selected Branchs";

$mode = $MODE_EDIT;
if (isset($_REQUEST['mode']))
{
   $mode = clean($_REQUEST['mode']);
}

$form_branch_id = 0;
if (isset($_REQUEST['form_branch_id']))
{
   $form_branch_id = clean($_REQUEST['form_branch_id']);
}

$valid = true;
$errmsg = '';
if (isset($_POST['submit']) && $_POST['submit'] == $SUBMIT_SAVE)
{
   $form_branch = NULL;
   if (isset($_POST['form_branch']))
   {
      $form_branch = clean($_POST['form_branch']);
   }
   $form_branch_type_id = NULL;
   if (isset($_POST['form_branch_type_id']))
   {
      $form_branch_type_id = clean($_POST['form_branch_type_id']);
   }
   $form_incipient = 0;
   if (isset($_POST['form_incipient']))
   {
      $form_incipient = clean($_POST['form_incipient']);
   }
   $form_parent_branch_id = NULL;
   if (isset($_POST['form_parent_branch_id']))
   {
      $form_parent_branch_id = clean($_POST['form_parent_branch_id']);
   }
   $form_date_founded = NULL;
   if (isset($_POST['form_date_founded']))
   {
      $form_date_founded = clean($_POST['form_date_founded']);
   }
   $form_ceremonial_date_founded = NULL;
   if (isset($_POST['form_ceremonial_date_founded']))
   {
      $form_ceremonial_date_founded = clean($_POST['form_ceremonial_date_founded']);
   }
   $form_date_dissolved = NULL;
   if (isset($_POST['form_date_dissolved']))
   {
      $form_date_dissolved = clean($_POST['form_date_dissolved']);
   }
   $form_website = NULL;
   if (isset($_POST['form_website']))
   {
      $form_website = clean($_POST['form_website']);
   }
   $form_display_order = NULL;
   if (isset($_POST['form_display_order']))
   {
      $form_display_order = clean($_POST['form_display_order']);
   }
   $form_inactive = 0;
   if (isset($_POST['form_inactive']))
   {
      $form_inactive = clean($_POST['form_inactive']);
   }
   $form_is_atlantian = 0;
   if (isset($_POST['form_is_atlantian']))
   {
      $form_is_atlantian = clean($_POST['form_is_atlantian']);
   }
   $form_blazon = NULL;
   if (isset($_POST['form_blazon']))
   {
      $form_blazon = clean($_POST['form_blazon']);
   }
   $form_name_reg_date = NULL;
   if (isset($_POST['form_name_reg_date']))
   {
      $form_name_reg_date = clean($_POST['form_name_reg_date']);
   }
   $form_device_reg_date = NULL;
   if (isset($_POST['form_device_reg_date']))
   {
      $form_device_reg_date = clean($_POST['form_device_reg_date']);
   }
   $form_device_file_name = NULL;
   if (isset($_POST['form_device_file_name']))
   {
      $form_device_file_name = clean($_POST['form_device_file_name']);
   }
   $form_device_file_credit = NULL;
   if (isset($_POST['form_device_file_credit']))
   {
      $form_device_file_credit = clean($_POST['form_device_file_credit']);
   }
   $form_notes = NULL;
   if (isset($_POST['form_notes']))
   {
      $form_notes = clean($_POST['form_notes']);
   }

   // Validate data
   if ($form_branch == '')
   {
      $valid = false;
      $errmsg .= "Please enter a Branch Name.<br/>";
   }
   if ($form_date_founded != '')
   {
      if (strtotime($form_date_founded) === FALSE)
      {
         $valid = false;
         $errmsg .= "Please enter a valid date for the Date Founded.<br/>";
      }
      else
      {
         $form_date_founded = format_mysql_date($form_date_founded);
      }
   }
   if ($form_ceremonial_date_founded != '')
   {
      // Branch types that have investitures or coronations
      if ($form_branch_type_id == $BT_KINGDOM || $form_branch_type_id == $BT_PRINCIPALITY || $form_branch_type_id == $BT_BARONY)
      {
         if (strtotime($form_ceremonial_date_founded) === FALSE)
         {
            $valid = false;
            $errmsg .= "Please enter a valid date for the Investiture/Coronation Date.<br/>";
         }
         else
         {
            $form_ceremonial_date_founded = format_mysql_date($form_ceremonial_date_founded);
         }
      }
      else
      {
         $valid = false;
         $errmsg .= "Please do not enter a date for the Investiture/Coronation Date if the branch is not a Kingdom, Principality, or Barony.<br/>";
      }
   }
   // Require parent branch for child branch types
   if ($form_branch_type_id != $BT_KINGDOM)
   {
      if ($form_parent_branch_id == '')
      {
         $valid = false;
         $errmsg .= "Please select a Parent Branch.<br/>";
      }
   }
   if (!validate_positive_integer($form_display_order))
   {
      $valid = false;
      $errmsg .= "Please enter Display Order value that is a whole number greater than zero.<br/>";
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

   if ($valid)
   {
      $link = db_admin_connect();

      // Update Branch
      if ($mode == $MODE_EDIT)
      {
         $update = 
            "UPDATE $DBNAME_BRANCH.branch " . 
            "SET branch = " . value_or_null($form_branch) . 
            ", branch_type_id = " . value_or_null($form_branch_type_id) . 
            ", parent_branch_id = " . value_or_null($form_parent_branch_id) . 
            ", incipient = " . value_or_null($form_incipient) . 
            ", is_atlantian = " . value_or_null($form_is_atlantian) . 
            ", website = " . value_or_null($form_website) . 
            ", display_order = " . value_or_null($form_display_order) .
            ", date_founded = " . value_or_null($form_date_founded) . 
            ", ceremonial_date_founded = " . value_or_null($form_ceremonial_date_founded) . 
            ", date_dissolved = " . value_or_null($form_date_dissolved) . 
            ", inactive = " . value_or_zero($form_inactive) .
            ", blazon = " . value_or_null($form_blazon) .
            ", name_reg_date = " . value_or_null($form_name_reg_date) .
            ", device_reg_date = " . value_or_null($form_device_reg_date) .
            ", device_file_name = " . value_or_null($form_device_file_name) .
            ", device_file_credit = " . value_or_null($form_device_file_credit) .
            ", notes = " . value_or_null($form_notes) .
            ", last_updated = " . value_or_null(date("Y-m-d")) .
            ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) .
            " WHERE branch_id = ". value_or_null($form_branch_id);

         $uresult = mysql_query($update)
            or die("Error updating Branch: " . mysql_error());
      }
      // Insert Branch
      else
      {
         $insert = 
            "INSERT INTO $DBNAME_BRANCH.branch (branch, branch_type_id, parent_branch_id, incipient, website, display_order, " .
            "date_founded, ceremonial_date_founded, date_dissolved, inactive, is_atlantian, blazon, name_reg_date, device_reg_date, " .
            "device_file_name, device_file_credit, notes, last_updated, last_updated_by) VALUES (" . 
            value_or_null($form_branch) . ", " .
            value_or_null($form_branch_type_id) . ", " .
            value_or_null($form_parent_branch_id) . ", " .
            value_or_null($form_incipient) . ", " .
            value_or_null($form_website) . ", " .
            value_or_null($form_display_order) . ", " .
            value_or_null($form_date_founded) . ", " .
            value_or_null($form_ceremonial_date_founded) . ", " .
            value_or_null($form_date_dissolved) . ", " .
            value_or_zero($form_inactive) . ", " .
            value_or_zero($form_is_atlantian) . ", " .
            value_or_null($form_blazon) . ", " .
            value_or_null($form_name_reg_date) . ", " .
            value_or_null($form_device_reg_date) . ", " .
            value_or_null($form_device_file_name) . ", " .
            value_or_null($form_device_file_credit) . ", " .
            value_or_null($form_notes) . ", " .
            value_or_null(date("Y-m-d")) . ", " .
            value_or_null($_SESSION['s_user_id']) . ")";

         $iresult = mysql_query($insert)
            or die("Error inserting Branch: " . mysql_error());
      }
      /* Closing connection */
      db_disconnect($link);
?>
<p align="center">Branch successfully updated.  <a href="branch.php">View the Branch</a>.</p>
<?php 
   } // valid
}
// We haven't submitted save yet - display Branch list or edit form
if (!(isset($_POST['submit'])) || (isset($_POST['submit']) && 
   ($_POST['submit'] == $SUBMIT_SAVE && !$valid) || 
   ($_POST['submit'] == $SUBMIT_DELETE)))
{
   // Do delete
   if (isset($_POST['submit']) && $_POST['submit'] == $SUBMIT_DELETE)
   {
      $del_branch_id = '';
      for ($i = 1; $i < $_POST['del_branch_max']; $i++)
      {
         if (isset($_POST['del_branch_id' . $i]))
         {
            if ($del_branch_id != '')
            {
               $del_branch_id .= ',';
            }
            $del_branch_id .= $_POST['del_branch_id' . $i];
         }
      }

      if ($del_branch_id != '')
      {
         $link = db_admin_connect();

         $delete = "DELETE FROM $DBNAME_BRANCH.branch WHERE branch_id IN ($del_branch_id)";

         $dresult = mysql_query($delete)
            or die("Error deleteing Branchs: " . mysql_error());

         /* Closing connection */
         db_disconnect($link);
      }
      else
      {
         $delerrmsg = "Please select at least one Branch to delete.";
?>
<p align="center" class="title3" style="color:red"><?php echo $delerrmsg; ?></p>
<?php 
      }
   }

   // Dislay edit list
   if ($mode == $MODE_EDIT && (!isset($form_branch_id) || $form_branch_id == 0))
   {
?>
<p align="center">
To edit an existing Branch: Click on the Branch link.<br/>
To delete an existing Branch: Check the box in front of the Branch and click the <?php echo $SUBMIT_DELETE; ?> button.<br/>
To add a new Branch: Visit the <a href="<?php echo $_SERVER['PHP_SELF'] . "?mode=" . $MODE_ADD; ?>">Add Branch page</a>.<br/>
</p>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table align="center" border="1" cellpadding="5" cellspacing="0" summary="Branch Update Form">
   <tr>
      <th class="title"><label for="del_branch_id">Select</label></th>
      <th class="title">Display Order</th>
      <th class="title">Branch</th>
   </tr>
<?php 
      $link = db_connect();
      $query = "SELECT branch_id, branch, branch_type, incipient, display_order " . 
         "FROM $DBNAME_BRANCH.branch, $DBNAME_BRANCH.branch_type " . 
         "WHERE branch.branch_type_id = branch_type.branch_type_id " .
         "ORDER BY display_order";
      $result = mysql_query($query);

      $i = 1;
      while ($data = mysql_fetch_array($result, MYSQL_BOTH))
      {
         $branch_id = $data['branch_id'];
         $branch = stripslashes(trim($data['branch']));
         $kingdom = get_kingdom($branch_id);
         $branch_type = stripslashes(trim($data['branch_type']));
         $incipient = '';
         if ($data['incipient'] == 1)
         {
            $incipient = "Incipient ";
         }
         $branch_display = "$branch ($incipient$branch_type)";
         if ($kingdom != $branch)
         {
            $branch_display .= ", $kingdom";
         }
         $display_order = $data['display_order'];
?>
   <tr>
      <td class="title"><input type="checkbox" name="del_branch_id<?php echo $i; ?>" id="del_branch_id<?php echo $i++; ?>" value="<?php echo $branch_id; ?>"/></td>
      <td class="dataright"><?php echo $display_order; ?></td>
      <td class="data">
      <a href="<?php echo $_SERVER['PHP_SELF'] . "?form_branch_id=" . $branch_id; ?>"><?php echo $branch_display; ?></a>
      </td>
   </tr>
<?php 
      }
?>
   <input type="hidden" name="del_branch_max" id="del_branch_max" value="<?php echo $i; ?>"/>
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

      // Get Branch Type List
      $branch_type_query = "SELECT branch_type, branch_type_id FROM $DBNAME_BRANCH.branch_type ORDER BY branch_type_id";
      $branch_type_result = mysql_query($branch_type_query)
         or die("Error reading Branch Type list: " . mysql_error());
      $branch_type_data_array = array();
      $i = 0;
      while ($branch_type_data = mysql_fetch_array($branch_type_result, MYSQL_BOTH))
      {
         $branch_type_data_array[$i]['branch_type_id'] = $branch_type_data['branch_type_id'];
         $branch_type_data_array[$i++]['branch_type'] = $branch_type_data['branch_type'];
      }
      mysql_free_result($branch_type_result);

      // Get Branch List
      $parent_branch_query = "SELECT branch, branch_id, branch_type, incipient " .
         "FROM $DBNAME_BRANCH.branch JOIN $DBNAME_BRANCH.branch_type ON branch.branch_type_id = branch_type.branch_type_id " .
         "WHERE branch.branch_type_id IN (" . $BT_KINGDOM . ", " . $BT_PRINCIPALITY . ", " . $BT_BARONY . ") " .
         "ORDER BY branch";
      $parent_branch_result = mysql_query($parent_branch_query)
         or die("Error reading Parent Branch list: " . mysql_error());
      $parent_branch_data_array = array();
      $i = 0;
      while ($parent_branch_data = mysql_fetch_array($parent_branch_result, MYSQL_BOTH))
      {
         $p_branch_id = $parent_branch_data['branch_id'];
         $p_branch = stripslashes(trim($parent_branch_data['branch']));
         $p_kingdom = get_kingdom($p_branch_id);
         $p_branch_type = stripslashes(trim($parent_branch_data['branch_type']));
         $p_incipient = '';
         if ($parent_branch_data['incipient'] == 1)
         {
            $p_incipient = "Incipient ";
         }
         $p_branch_display = "$p_branch ($p_incipient$p_branch_type)";
         if ($p_kingdom != $p_branch)
         {
            $p_branch_display .= ", $p_kingdom";
         }
         $parent_branch_data_array[$i]['branch_id'] = $p_branch_id;
         $parent_branch_data_array[$i++]['branch'] = $p_branch_display;
      }
      mysql_free_result($parent_branch_result);

      db_disconnect($link);

      // Get data for edit
      if ($mode == $MODE_EDIT && $valid)
      {
         $link = db_connect();
         $query = "SELECT * FROM $DBNAME_BRANCH.branch WHERE branch_id = " . $form_branch_id;
         $result = mysql_query($query);

         $data = mysql_fetch_array($result, MYSQL_BOTH);
         $form_branch_id = clean($data['branch_id']);
         $form_branch = clean($data['branch']);
         $form_branch_type_id = clean($data['branch_type_id']);
         $form_parent_branch_id = clean($data['parent_branch_id']);
         $form_incipient = clean($data['incipient']);
         $form_website = clean($data['website']);
         $form_display_order = clean($data['display_order']);
         $form_date_founded = clean($data['date_founded']);
         $form_ceremonial_date_founded = clean($data['ceremonial_date_founded']);
         $form_date_dissolved = clean($data['date_dissolved']);
         $form_inactive = clean($data['inactive']);
         $form_is_atlantian = clean($data['is_atlantian']);
         $form_name_reg_date = clean($data['name_reg_date']);
         $form_blazon = clean($data['blazon']);
         $form_device_reg_date = clean($data['device_reg_date']);
         $form_device_file_name = clean($data['device_file_name']);
         $form_device_file_credit = clean($data['device_file_credit']);
         $form_notes = clean($data['notes']);

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
<p class="title2"><?php echo ucfirst($mode); ?> Branch</p>
<table border="1" cellpadding="5" cellspacing="0" summary="Branch Form">
<?php 
      if (isset($form_branch_id) && $form_branch_id > 0)
      {
?>
   <input type="hidden" name="form_branch_id" id="form_branch_id" value="<?php echo $form_branch_id; ?>"/>
<?php 
      }
?>
   <tr>
      <th class="titleright">Branch ID:</th>
      <td class="data"><?php if (isset($form_branch_id) && trim($form_branch_id) != '' && $form_branch_id > 0) { echo $form_branch_id; } ?></td>
      <td class="titleright">Incipient</td>
      <td class="data"><input type="checkbox" name="form_incipient" id="form_incipient" value="1"<?php if (isset($form_incipient) && $form_incipient == 1) { echo ' CHECKED'; }?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_branch">Branch Name:</label></th>
      <td class="data"><input type="text" name="form_branch" id="form_branch" size="30" maxlength="255"<?php if (isset($form_branch) && trim($form_branch) != '') { echo " value=\"" . $form_branch . "\""; } ?>/></td>
      <td class="titleright"><label for="form_branch_type_id">Branch Type:</label></td>
      <td class="data">
      <select name="form_branch_type_id" id="form_branch_type_id">
         <?php
            for ($i = 0; $i < count($branch_type_data_array); $i++)
            {
               echo '<option value="' . $branch_type_data_array[$i]['branch_type_id'] . '"';
               if (isset($form_branch_type_id) && $form_branch_type_id == $branch_type_data_array[$i]['branch_type_id'])
               {
                  echo ' selected';
               }
               echo '>' . $branch_type_data_array[$i]['branch_type'] . '</option>';
            }
         ?>
      </select>
      </td>
   </tr>
   <tr>
      <td class="titleright"><label for="form_parent_branch_id">Parent Branch:</label></td>
      <td class="data">
      <select name="form_parent_branch_id" id="form_parent_branch_id">
         <option></option>
         <?php
            for ($i = 0; $i < count($parent_branch_data_array); $i++)
            {
               echo '<option value="' . $parent_branch_data_array[$i]['branch_id'] . '"';
               if (isset($form_parent_branch_id) && $form_parent_branch_id == $parent_branch_data_array[$i]['branch_id'])
               {
                  echo ' selected';
               }
               echo '>' . $parent_branch_data_array[$i]['branch'] . '</option>';
            }
         ?>
      </select>
      </td>
      <th class="titleright" bgcolor="#FFFFCC"><label for="form_is_atlantian">Atlantian?</label></th>
      <td class="data">
      <input type="checkbox" name="form_is_atlantian" id="form_is_atlantian" value="1"<?php if (isset($form_is_atlantian) && $form_is_atlantian == 1) { echo ' CHECKED'; }?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC"><label for="form_date_founded">Date Founded</label></td>
      <td class="data"><input type="text" name="form_date_founded" id="form_date_founded" size="15" maxlength="10"<?php if (isset($form_date_founded) && $form_date_founded != '') { echo " value=\"$form_date_founded\"";} ?>/></td>
      <td class="titleright"><label for="form_ceremonial_date_founded">Investiture/Coronation Date:</label></td>
      <td class="data"><input type="text" name="form_ceremonial_date_founded" id="form_ceremonial_date_founded" size="10" maxlength="10"<?php if (isset($form_ceremonial_date_founded) && trim($form_ceremonial_date_founded) != '') { echo " value=\"" . $form_ceremonial_date_founded . "\""; } ?>/></td>
   </tr>
   <tr>
      <th class="titleright" bgcolor="#FFFFCC"><label for="form_inactive">Inactive</label></th>
      <td class="data">
      <input type="checkbox" name="form_inactive" id="form_inactive" value="1"<?php if (isset($form_inactive) && $form_inactive == 1) { echo ' CHECKED'; }?>/>
      </td>
      <td class="titleright" bgcolor="#FFFFCC"><label for="form_date_dissolved">Date Dissolved</label></td>
      <td class="data"><input type="text" name="form_date_dissolved" id="form_date_dissolved" size="15" maxlength="10"<?php if (isset($form_date_dissolved) && $form_date_dissolved != '') { echo " value=\"$form_date_dissolved\"";} ?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_website">Branch Web Site:</label></th>
      <td class="data"><input type="text" name="form_website" id="form_website" size="50" maxlength="255"<?php if (isset($form_website) && trim($form_website) != '') { echo " value=\"" . $form_website . "\""; } ?>/></td>
      <td class="titleright"><label for="form_display_order">Display Order:</label></td>
      <td class="data"><input type="text" name="form_display_order" id="form_display_order" size="10" maxlength="10"<?php if (isset($form_display_order) && trim($form_display_order) != '') { echo " value=\"" . $form_display_order . "\""; } ?>/></td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC"><label for="form_name_reg_date">Date Name Registered</label></td>
      <td class="data"><input type="text" name="form_name_reg_date" id="form_name_reg_date" size="15" maxlength="10"<?php if (isset($form_name_reg_date) && $form_name_reg_date != '') { echo " value=\"$form_name_reg_date\"";} ?>/></td>
      <td class="titleright" bgcolor="#FFFFCC"><label for="form_device_reg_date">Date Device Registered</label></td>
      <td class="data"><input type="text" name="form_device_reg_date" id="form_device_reg_date" size="15" maxlength="10"<?php if (isset($form_device_reg_date) && $form_device_reg_date != '') { echo " value=\"$form_device_reg_date\"";} ?>/></td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC"><label for="form_blazon">Blazon</label></td>
      <td class="data" colspan="3"><input type="text" name="form_blazon" id="form_blazon" size="100" maxlength="65535"<?php if (isset($form_blazon) && $form_blazon != '') { echo " value=\"$form_blazon\"";} ?>/></td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC"><label for="form_device_file_name">Device File Name</label></td>
      <td class="data" colspan="3"><input type="text" name="form_device_file_name" id="form_device_file_name" size="100" maxlength="255"<?php if (isset($form_device_file_name) && $form_device_file_name != '') { echo " value=\"$form_device_file_name\"";} ?>/></td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC"><label for="form_device_file_credit">Device File Credit</label></td>
      <td class="data" colspan="3"><input type="text" name="form_device_file_credit" id="form_device_file_credit" size="100" maxlength="255"<?php if (isset($form_device_file_credit) && $form_device_file_credit != '') { echo " value=\"$form_device_file_credit\"";} ?>/></td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC"><label for="form_notes">Notes</label></td>
      <td class="data" colspan="3"><input type="text" name="form_notes" id="form_notes" size="100" maxlength="65535"<?php if (isset($form_notes) && $form_notes != '') { echo " value=\"$form_notes\"";} ?>/></td>
   </tr>
   <tr>
      <td colspan="4" class="title"><input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_SAVE; ?>"/></td>
   </tr>
</table>
<p class="blurb1">Device images for branches are stored in <?php echo $BRANCH_IMAGE_DIR; ?>.</p>
<?php
      if (isset($form_device_file_name) && $form_device_file_name != '')
      {
?>
<p><img src="<?php echo $BRANCH_IMAGE_DIR . $form_device_file_name; ?>" height="200" border="0" alt="Device Image for <?php echo $form_branch; ?>" /></p>
<?php
      }
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
<p align="center" class="title2">Branch</p>
<p align="center">You are not authorized to access this page.</p>
<?php
}
include("footer.php");
?>
