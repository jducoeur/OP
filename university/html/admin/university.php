<?php
include("../db/db.php");
include("db.php");
include("../header.php");

$mode = $MODE_EDIT;
if (isset($_REQUEST['mode']))
{
   $mode = clean($_REQUEST['mode']);
}
?>
<h2 style="text-align:center"><?php echo ucfirst($mode); ?> University</h2>
<?php
// Only appropriate admins allowed
if (isset($_SESSION[$UNIVERSITY_ADMIN]) && $_SESSION[$UNIVERSITY_ADMIN] == 1)
{
$SUBMIT_SAVE = "Save Changes";

$SUBMIT_DELETE = "Delete Selected Universities";

$form_university_id = 0;
if (isset($_REQUEST['form_university_id']))
{
   $form_university_id = clean($_REQUEST['form_university_id']);
}

$valid = true;
$errmsg = '';
if (isset($_POST['submit']) && $_POST['submit'] == $SUBMIT_SAVE)
{
   $form_university_code = NULL;
   if (isset($_POST['form_university_code']))
   {
      $form_university_code = clean($_POST['form_university_code']);
   }
   $form_university_date = NULL;
   if (isset($_POST['form_university_date']))
   {
      $form_university_date = clean($_POST['form_university_date']);
   }
   $form_publish_date = NULL;
   if (isset($_POST['form_publish_date']))
   {
      $form_publish_date = clean($_POST['form_publish_date']);
   }
   $form_closed_date = NULL;
   if (isset($_POST['form_closed_date']))
   {
      $form_closed_date = clean($_POST['form_closed_date']);
   }
   $form_track_proposal_date = NULL;
   if (isset($_POST['form_track_proposal_date']))
   {
      $form_track_proposal_date = clean($_POST['form_track_proposal_date']);
   }
   $form_individual_proposal_date = NULL;
   if (isset($_POST['form_individual_proposal_date']))
   {
      $form_individual_proposal_date = clean($_POST['form_individual_proposal_date']);
   }
   $form_is_university = NULL;
   if (isset($_POST['form_is_university']))
   {
      $form_is_university = clean($_POST['form_is_university']);
   }
   $form_event_id = NULL;
   if (isset($_POST['form_event_id']))
   {
      $form_event_id = clean($_POST['form_event_id']);
   }
   $form_branch_id = NULL;
   if (isset($_POST['form_branch_id']))
   {
      $form_branch_id = clean($_POST['form_branch_id']);
   }

   // Validate data
   if (!validate_date($form_university_date))
   {
      $valid = false;
      $errmsg .= "Please enter a valid date for the University Date.<br/>";
   }
   else
   {
      $form_university_date = format_mysql_date($form_university_date);
   }
   if ($form_university_code == NULL || $form_university_code == '')
   {
      $valid = false;
      $errmsg .= "Please enter the University Code.<br/>";
   }
   // Not required, but if they fill it in, check it
   if ($form_publish_date != NULL)
   {
      if (!validate_date($form_publish_date))
      {
         $valid = false;
         $errmsg .= "Please enter a valid date for the Publish Date.<br/>";
      }
      else
      {
         $form_publish_date = format_mysql_date($form_publish_date);
      }
   }
   // Not required, but if they fill it in, check it
   if ($form_closed_date != NULL)
   {
      if (!validate_date($form_closed_date))
      {
         $valid = false;
         $errmsg .= "Please enter a valid date for the Pre-Reg Close Date.<br/>";
      }
      else
      {
         $form_closed_date = format_mysql_date($form_closed_date);
      }
   }
   // Not required, but if they fill it in, check it
   if ($form_track_proposal_date != NULL)
   {
      if (!validate_date($form_track_proposal_date))
      {
         $valid = false;
         $errmsg .= "Please enter a valid date for the Track Proposal Due Date.<br/>";
      }
      else
      {
         $form_track_proposal_date = format_mysql_date($form_track_proposal_date);
      }
   }
   // Not required, but if they fill it in, check it
   if ($form_individual_proposal_date != NULL)
   {
      if (!validate_date($form_individual_proposal_date))
      {
         $valid = false;
         $errmsg .= "Please enter a valid date for the Individual Proposal Due Date.<br/>";
      }
      else
      {
         $form_individual_proposal_date = format_mysql_date($form_individual_proposal_date);
      }
   }

   if ($valid)
   {
      $link = db_admin_connect();

      // Update University
      if ($mode == $MODE_EDIT)
      {
         $update = 
            "UPDATE $DBNAME_UNIVERSITY.university " .
            "SET university_date = " . value_or_null($form_university_date) . 
            ", university_code = " . value_or_null($form_university_code) . 
            ", is_university = " . value_or_zero($form_is_university) . 
            ", branch_id = " . value_or_null($form_branch_id) . 
            ", publish_date = " . value_or_null($form_publish_date) . 
            ", closed_date = " . value_or_null($form_closed_date) . 
            ", track_proposal_date = " . value_or_null($form_track_proposal_date) . 
            ", individual_proposal_date = " . value_or_null($form_individual_proposal_date) . 
            ", event_id = " . value_or_null($form_event_id) . 
            ", last_updated = " . value_or_null(date("Y-m-d")) .
            ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) .
            " WHERE university_id = ". $form_university_id;

         $uresult = mysql_query($update)
            or die("Error updating University: " . $update . "<br/>" . mysql_error());
      }
      // Insert University
      else
      {
         $insert = 
            "INSERT INTO $DBNAME_UNIVERSITY.university (university_code, university_date, publish_date, closed_date, is_university, branch_id, track_proposal_date, individual_proposal_date, event_id, date_created, last_updated, last_updated_by) VALUES (" . 
            value_or_null($form_university_code) . ", " . 
            value_or_null($form_university_date) . ", " . 
            value_or_null($form_publish_date) . ", " . 
            value_or_null($form_closed_date) . ", " . 
            value_or_zero($form_is_university) . ", " . 
            value_or_null($form_branch_id) . ", " . 
            value_or_null($form_track_proposal_date) . ", " . 
            value_or_null($form_individual_proposal_date) . ", " . 
            value_or_null($form_event_id) . ", " . 
            value_or_null(date("Y-m-d")) . ", " . 
            value_or_null(date("Y-m-d")) . ", " . 
            value_or_null($_SESSION['s_user_id']) . ")";

         $iresult = mysql_query($insert)
            or die("Error inserting University: " . $insert . "<br/>" . mysql_error());
      }
      /* Closing connection */
      db_disconnect($link);
?>
<p align="center">University successfully updated.<br/><a href="<?php echo $_SERVER['PHP_SELF']; ?>">Return to the University list</a>.</p>
<?php 
   } // valid
}
// We haven't submitted save yet - display University list or edit form
if (!(isset($_POST['submit'])) || (isset($_POST['submit']) && 
   ($_POST['submit'] == $SUBMIT_SAVE && !$valid) || 
   ($_POST['submit'] == $SUBMIT_DELETE)))
{
   // Do delete
   if (isset($_POST['submit']) && $_POST['submit'] == $SUBMIT_DELETE)
   {
      $del_university_id = '';
      for ($i = 1; $i < $_POST['del_university_max']; $i++)
      {
         if (isset($_POST['del_university_id' . $i]))
         {
            if ($del_university_id != '')
            {
               $del_university_id .= ',';
            }
            $del_university_id .= $_POST['del_university_id' . $i];
         }
      }

      if ($del_university_id != '')
      {
         $link = db_admin_connect();

         $delete = "DELETE FROM $DBNAME_UNIVERSITY.university WHERE university_id IN ($del_university_id)";

         $dresult = mysql_query($delete)
            or die("Error deleting University: " . $delete . "<br/>" . mysql_error());

         /* Closing connection */
         db_disconnect($link);
      }
      else
      {
         $delerrmsg = "Please select at least one University to delete.";
?>
<p align="center" class="title3" style="color:red"><?php echo $delerrmsg; ?></p>
<?php 
      }
   }

   // Dislay edit list
   if ($mode == $MODE_EDIT && (!isset($form_university_id) || $form_university_id == 0))
   {
?>
<p align="center">
To edit an existing University: Click on the University Session link.<br/>
To edit classes, rooms or tracks for an existing University: Click on the Classes, Rooms or Tracks link.<br/>
To delete an existing University: Check the box in front of the University and click the <?php echo $SUBMIT_DELETE; ?> button.<br/>
To add a new University: Visit the <a href="<?php echo $_SERVER['PHP_SELF'] . "?mode=" . $MODE_ADD; ?>">Add University page</a>.<br/>
</p>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table align="center" border="1" cellpadding="5" cellspacing="0" summary="University Update Form">
   <tr>
      <th style="color:<?php echo $accent_color; ?>">Delete</th>
      <th style="color:<?php echo $accent_color; ?>">University Session</th>
      <th style="color:<?php echo $accent_color; ?>">University Date</th>
      <th style="color:<?php echo $accent_color; ?>">Classes</th>
      <th style="color:<?php echo $accent_color; ?>">Rooms</th>
      <th style="color:<?php echo $accent_color; ?>">Tracks</th>
   </tr>
<?php 
      $link = db_connect();
      $query = "SELECT university_id, university_date, university_code FROM $DBNAME_UNIVERSITY.university ORDER BY university_date DESC";
      $result = mysql_query($query)
         or die("Error selecting University: " . $query . "<br/>" . mysql_error());

      $i = 1;
      while ($data = mysql_fetch_array($result, MYSQL_BOTH))
      {
         $university_id = $data['university_id'];
         $university_date = clean($data['university_date']);
         $university_code = clean($data['university_code']);
?>
   <tr>
      <td class="data" nowrap>
      <label for="del_university_id<?php echo $i; ?>">Delete</label> <input type="checkbox" name="del_university_id<?php echo $i; ?>" id="del_university_id<?php echo $i++; ?>" value="<?php echo $university_id; ?>"/>
      </td>
      <td class="datacenter">
      <a style="font-weight:normal" href="<?php echo $_SERVER['PHP_SELF'] . "?form_university_id=" . $university_id; ?>"><?php echo $university_code; ?></a>
      </td>
      <td class="dataright" nowrap>
      <?php if ($university_date != "") { echo format_short_date($university_date); } else { echo "&nbsp;";}?>
      </td>
      <td class="datacenter">
      <a style="font-weight:normal" href="catalog.php?university_id=<?php echo $university_id; ?>"><?php echo $university_code; ?> Classes</a>
      </td>
      <td class="datacenter">
      <a style="font-weight:normal" href="room.php?university_id=<?php echo $university_id; ?>"><?php echo $university_code; ?> Rooms</a>
      </td>
      <td class="datacenter">
      <a style="font-weight:normal" href="track.php?university_id=<?php echo $university_id; ?>"><?php echo $university_code; ?> Tracks</a>
      </td>
   </tr>
<?php 
      }
?>
   <input type="hidden" name="del_university_max" id="del_university_max" value="<?php echo $i; ?>"/>
   <tr>
      <td class="datacenter" colspan="6"><input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_DELETE; ?>"/></td>
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
      if ($mode == $MODE_EDIT && $valid)
      {
         $link = db_connect();
         $query = "SELECT * FROM $DBNAME_UNIVERSITY.university WHERE university_id = " . $form_university_id;
         $result = mysql_query($query)
            or die("Error selecting University: " . $query . "<br/>" . mysql_error());

         $data = mysql_fetch_array($result, MYSQL_BOTH);
         $form_university_id = $data['university_id'];
         $form_university_date = clean($data['university_date']);
         $form_university_code = clean($data['university_code']);
         $form_publish_date = $data['publish_date'];
         $form_closed_date = $data['closed_date'];
         $form_track_proposal_date = $data['track_proposal_date'];
         $form_individual_proposal_date = $data['individual_proposal_date'];
         $form_is_university = $data['is_university'];
         $form_event_id = $data['event_id'];
         $form_branch_id = $data['branch_id'];

         /* Free resultset */
         mysql_free_result($result);

         /* Closing connection */
         db_disconnect($link);
      }
      if (!$valid)
      {
?>
<p align="center" class="title3" style="color:red"><?php echo $errmsg; ?></p>
<?php 
      }

      // Get pick lists
      $branch_data_array = get_atlantian_branch_pick_list();
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>"/>
<table border="1" align="center" cellpadding="5" cellspacing="0" summary="University Form">
<?php 
      if (isset($form_university_id) && $form_university_id > 0)
      {
?>
   <input type="hidden" name="form_university_id" id="form_university_id" value="<?php echo $form_university_id; ?>"/>
<?php 
      }
?>
   <tr>
      <th class="titleright">University ID:</th>
      <td class="data"><?php if (isset($form_university_id) && trim($form_university_id) != '' && $form_university_id > 0) { echo $form_university_id; } ?></td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_university_code">University Code:</label></th>
      <td class="data"><input type="text" name="form_university_code" id="form_university_code" size="12" maxlength="10"<?php if (isset($form_university_code) && trim($form_university_code) != '') { echo " value=\"" . $form_university_code . "\""; } ?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_is_university">Official University:</label></th>
      <td class="data"><input type="checkbox" name="form_is_university" id="form_is_university" size="12" maxlength="10" value="1"<?php if (isset($form_is_university) && trim($form_is_university) == 1) { echo " CHECKED"; } ?>/> (Check for official Universities, but not for collegiums)</td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_university_date">University Date:</label></th>
      <td class="data"><input type="text" name="form_university_date" id="form_university_date" size="12" maxlength="10"<?php if (isset($form_university_date) && trim($form_university_date) != '') { echo " value=\"" . $form_university_date . "\""; } ?>/></td>
   </tr>
   <tr>
      <td class="titleright"><label for="form_branch_id">Host Branch:</label></td>
      <td class="data">
      <select name="form_branch_id" id="form_branch_id">
         <option></option>
<?php
   for ($i = 0; $i < count($branch_data_array); $i++)
   {
      echo '<option id="' . $branch_data_array[$i]['branch'] . '" value="' . $branch_data_array[$i]['branch_id'] . '"';
      if (isset($form_branch_id) && $form_branch_id == $branch_data_array[$i]['branch_id'])
      {
         echo ' selected';
      }
      echo '>' . $branch_data_array[$i]['branch_name'] . '</option>';
   }
?>
      </select>
<?php
   for ($i = 0; $i < count($branch_data_array); $i++)
   {
?>
      <input type="hidden" name="form_branch<?php echo $branch_data_array[$i]['branch_id']; ?>" id="branch<?php echo $branch_data_array[$i]['branch_id']; ?>" value="<?php echo $branch_data_array[$i]['branch']; ?>" />
<?php
   }
?>
      </td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_track_proposal_date">Track Proposal Due Date:</label></th>
      <td class="data"><input type="text" name="form_track_proposal_date" id="form_track_proposal_date" size="12" maxlength="10"<?php if (isset($form_track_proposal_date) && trim($form_track_proposal_date) != '') { echo " value=\"" . $form_track_proposal_date . "\""; } ?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_individual_proposal_date">Individual Proposal Due Date:</label></th>
      <td class="data"><input type="text" name="form_individual_proposal_date" id="form_individual_proposal_date" size="12" maxlength="10"<?php if (isset($form_individual_proposal_date) && trim($form_individual_proposal_date) != '') { echo " value=\"" . $form_individual_proposal_date . "\""; } ?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_publish_date">Publish Date:</label></th>
      <td class="data"><input type="text" name="form_publish_date" id="form_publish_date" size="12" maxlength="10"<?php if (isset($form_publish_date) && trim($form_publish_date) != '') { echo " value=\"" . $form_publish_date . "\""; } ?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_closed_date">Pre-Reg Close Date:</label></th>
      <td class="data"><input type="text" name="form_closed_date" id="form_closed_date" size="12" maxlength="10"<?php if (isset($form_closed_date) && trim($form_closed_date) != '') { echo " value=\"" . $form_closed_date . "\""; } ?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_event_id">SPIKE Event ID:</label></th>
      <td class="data"><input type="text" name="form_event_id" id="form_event_id" size="12" maxlength="8"<?php if (isset($form_event_id) && trim($form_event_id) != '') { echo " value=\"" . $form_event_id . "\""; } ?>/></td>
   </tr>
   <tr>
      <td colspan="2" class="datacenter"><input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_SAVE; ?>"/></td>
   </tr>
</table>
<?php
      if ($mode == $MODE_EDIT)
      {
?>
<p style="text-align:center"><a href="catalog.php?university_id=<?php echo $form_university_id; ?>">Edit University Courses</a></p>
<?
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
<p align="center" class="title2">You are not authorized to access this page.</p>
<?php
}
include("../footer.php");
?>
