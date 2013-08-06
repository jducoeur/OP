<?php
include_once("db.php");

$form_event_id = 0;
if (isset($_POST['form_event_id']))
{
   $form_event_id = clean($_POST['form_event_id']);
}
else if (isset($_GET['event_id']))
{
   $form_event_id = clean($_GET['event_id']);
}

$mode = $MODE_EDIT;
if (isset($_REQUEST['mode']))
{
   $mode = clean($_REQUEST['mode']);
}

if (isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN])
{
   if ($mode == $MODE_EDIT && $form_event_id == 0)
   {
      $no_edit_selection = true;
   }

   if ($mode == $MODE_ADD)
   {
      if (isset($_POST['form_event_name']))
      {
         $form_event_name = clean($_POST['form_event_name']);
      }
      if (isset($_POST['form_branch_id']))
      {
         $form_branch_id = clean($_POST['form_branch_id']);
      }
      if (isset($_POST['form_start_date']))
      {
         $form_start_date = clean($_POST['form_start_date']);
      }
      if (isset($_POST['form_end_date']))
      {
         $form_end_date = clean($_POST['form_end_date']);
      }
   }

   $SUBMIT_SAVE = "Save Event";
   $SUBMIT_DELETE = "Delete Event";

   // Data submitted
   if (isset($_POST['submit']))
   {
      if ($_POST['submit'] == $SUBMIT_DELETE)
      {
         if ($mode == $MODE_EDIT && $form_event_id > 0)
         {
            $count = 0;
            $link = db_admin_connect();

            // Check for child OP records: atlantian_award
            $check_query = "SELECT event_id FROM $DBNAME_OP.atlantian_award WHERE event_id = $form_event_id";
            $check_result = mysql_query($check_query, $link)
               or die("Error checking OP for Event (atlantian_award): " . mysql_error());
            $count += mysql_num_rows($check_result);

            // Check for child OP records: court_report
            $check_query = "SELECT event_id FROM $DBNAME_OP.court_report WHERE event_id = $form_event_id";
            $check_result = mysql_query($check_query, $link)
               or die("Error checking OP for Event (court_report): " . mysql_error());
            $count += mysql_num_rows($check_result);

            // Check for child OP records: reign
            $check_query = "SELECT event_id FROM $DBNAME_OP.reign WHERE event_id = $form_event_id";
            $check_result = mysql_query($check_query, $link)
               or die("Error checking OP for Event (reign): " . mysql_error());
            $count += mysql_num_rows($check_result);

            // Check for child OP records: principality
            $check_query = "SELECT event_id FROM $DBNAME_OP.principality WHERE event_id = $form_event_id";
            $check_result = mysql_query($check_query, $link)
               or die("Error checking OP for Event (principality): " . mysql_error());
            $count += mysql_num_rows($check_result);

            // Only delete if the checks passed
            if ($count == 0)
            {
               // Delete from op
               $delete = "DELETE FROM $DBNAME_OP.event WHERE event_id = $form_event_id";
               $del_result = mysql_query($delete, $link)
                  or die("Error deleting Event from OP: " . mysql_error());

               // Redirect to edit page
               redirect("deleted.php?type_id=$DEL_TYPE_EVENT");
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
               $errmsg .= " for Event ID $form_event_id; this Event may not be deleted until all child records are deleted.";
            }
            // Close DBs
            db_disconnect($link);
         }
      } // End Submit Delete
      if ($_POST['submit'] == $SUBMIT_SAVE)
      {
         $form_event_name = clean($_POST['form_event_name']);
         $form_branch_id = clean($_POST['form_branch_id']);
         $form_start_date = clean($_POST['form_start_date']);
         $form_end_date = clean($_POST['form_end_date']);

         $valid = true;
         $errmsg = '';
         // Validate data
         if ($form_event_name == '')
         {
            $valid = false;
            $errmsg .= "Please enter an Event name.<br/>";
         }
         if ($form_start_date != '')
         {
            if (strtotime($form_start_date) === FALSE)
            {
               $valid = false;
               $errmsg .= "Please enter a valid date for the Start Date.<br/>";
            }
            else
            {
               $form_start_date = format_mysql_date($form_start_date);
            }
         }
         if ($form_end_date != '')
         {
            if (strtotime($form_end_date) === FALSE)
            {
               $valid = false;
               $errmsg .= "Please enter a valid date for the End Date.<br/>";
            }
            else
            {
               $form_end_date = format_mysql_date($form_end_date);
            }
         }

         // Update database if valid
         if ($valid)
         {
            $link = db_admin_connect();
            // Update
            if ($form_event_id > 0)
            {
               $sql_stmt = "UPDATE $DBNAME_OP.event SET " .
                  "event_name = " . value_or_null($form_event_name) .
                  ", branch_id = " . value_or_null($form_branch_id) .
                  ", start_date = " . value_or_null($form_start_date) .
                  ", end_date = " . value_or_null($form_end_date) .
                  ", last_updated = " . value_or_null(date("Y-m-d")) .
                  ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) .
                  " WHERE event_id = " . value_or_null($form_event_id);

               $sql_result = mysql_query($sql_stmt)
                  or die("Error updating Event data: " . mysql_error());
            }
            // Insert
            else
            {
               $sql_stmt = "INSERT INTO $DBNAME_OP.event (event_name, branch_id, start_date, end_date, last_updated, last_updated_by " .
                  ") VALUES (" .
                  value_or_null($form_event_name) . ", " .
                  value_or_null($form_branch_id) . ", " .
                  value_or_null($form_start_date) . ", " .
                  value_or_null($form_end_date) . ", " .
                  value_or_null(date("Y-m-d")) . ", " .
                  value_or_null($_SESSION['s_user_id']) . 
                  ")";

               $sql_result = mysql_query($sql_stmt)
                  or die("Error inserting Event data: " . mysql_error());
               $form_event_id = mysql_insert_id();
            }
            // Redirect to edit page
            redirect("event.php?event_id=$form_event_id&mode=$MODE_EDIT");
         }
      } // Submit Save
   } // Submit
   // Read Existing Event - if this isn't a submit, or it is a failed submit delete
   if ($form_event_id > 0 && (!(isset($_POST['submit'])) || (isset($_POST['submit']) && $_POST['submit'] == $SUBMIT_DELETE)))
   {
      $link = db_connect();
      $query = "SELECT * FROM $DBNAME_OP.event WHERE event_id = " . value_or_null($form_event_id);
      $result = mysql_query($query);
      $data = mysql_fetch_array($result, MYSQL_BOTH);

      $form_event_name = clean($data['event_name']);
      $form_start_date = clean($data['start_date']);
      $form_end_date = clean($data['end_date']);
      $form_branch_id = clean($data['branch_id']);

      mysql_free_result($result);

      db_disconnect($link);
   }

$link = db_connect();

// Pick Lists
// Groups
$group_pl_query = "SELECT branch_id, branch, parent_branch_id, incipient, branch.branch_type_id, branch_type " .
                  "FROM $DBNAME_BRANCH.branch, $DBNAME_BRANCH.branch_type " .
                  "WHERE branch.branch_type_id = branch_type.branch_type_id " .
                  "AND (branch.branch_type_id = $BT_KINGDOM OR parent_branch_id = $KINGDOM_ID " .
                  "OR parent_branch_id IN (SELECT branch_id FROM $DBNAME_BRANCH.branch WHERE parent_branch_id = $KINGDOM_ID)) " .
                  "ORDER BY branch";

/* Performing SQL query */
$group_pl_result = mysql_query($group_pl_query) 
   or die("Branch List Query failed : " . mysql_error());

$title = ucfirst($mode) . " Event";
include("header.php");
?>
<p align="center" class="title2"><?php echo ucfirst($mode); ?> Event</p>
<p align="center" class="title2">Event Information</p>
<?php 
   if (isset($no_edit_selection) && $no_edit_selection)
   {
?>
<p align="center" class="title3" style="color:red">No Event was selected for Edit.  Please use a navigation link to the left.</p>
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
      if (isset($form_event_id) && $form_event_id > 0)
      {
?>
   <input type="hidden" name="form_event_id" id="form_event_id" value="<?php echo $form_event_id; ?>"/>
<?php 
      }
?>
<table align="center" cellpadding="5" cellspacing="0" border="1">
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Event Name</td>
      <td class="data">
      <input type="text" name="form_event_name" id="form_event_name" size="50" maxlength="100"<?php if (isset($form_event_name) && $form_event_name != '') { echo " value=\"$form_event_name\"";} ?>/>
      </td>
   </tr>
   <tr>
      <th class="titleright">Host Branch</th>
      <td class="data">
      <select name="form_branch_id" id="form_branch_id">
         <option></option>
         <?php
            while ($group_data = mysql_fetch_array($group_pl_result, MYSQL_BOTH))
            {
               $branch_id = $group_data['branch_id'];
               $group_display = $group_data['branch'] . ", ";
               if ($group_data['incipient'] == 1)
               {
                  $group_display .= 'Incipient ';
               }
               $group_display .= $group_data['branch_type'];
               echo '<option id="' . $branch_id . '" value="' . $branch_id . '"';
               if (isset($form_branch_id) && $form_branch_id == $branch_id)
               {
                  echo ' selected';
               }
               echo '>' . $group_display . '</option>';
            }
         ?>
      </select>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Start Date</td>
      <td class="data"><input type="text" name="form_start_date" id="form_start_date" size="15" maxlength="10"<?php if (isset($form_start_date) && $form_start_date != '') { echo " value=\"$form_start_date\"";} ?>/></td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">End Date</td>
      <td class="data"><input type="text" name="form_end_date" id="form_end_date" size="15" maxlength="10"<?php if (isset($form_end_date) && $form_end_date != '') { echo " value=\"$form_end_date\"";} ?>/></td>
   </tr>
</table>
<p class="datacenter">
<input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_SAVE; ?>"/>&nbsp;&nbsp;&nbsp;<?php if ($mode == $MODE_EDIT) {?><input name="submit" id="submit" type="submit" value="<?php echo $SUBMIT_DELETE; ?>"/><?php } ?>
</p>
</form>
<?php
      if ($mode == $MODE_EDIT)
      {
?>
<table border="0" align="center" cellpadding="5" summary="">
   <tr>
      <td>
      <form action="court_report.php" method="post">
         <input type="hidden" name="form_event_id" id="form_event_id" value="<?php echo $form_event_id; ?>"/>
         <input type="hidden" name="mode" id="mode" value="<?php echo $MODE_ADD; ?>"/>
         <input type="submit" value="Add Court Report for <?php echo $form_event_name; ?>"/>
      </form>
      </td>
   </tr>
</table>
<?php
         $cr_query = "SELECT * FROM $DBNAME_OP.court_report WHERE event_id = $form_event_id ORDER BY court_date, court_type DESC, court_time";
         /* Performing SQL query */
         $cr_result = mysql_query($cr_query) 
            or die("Court Report Query failed : " . mysql_error());
         if (mysql_num_rows($cr_result) > 0)
         {
?>
<p align="center" class="title2">Court Reports</p>
<table align="center" cellpadding="5" cellspacing="0" border="1" summary="">
   <tr>
      <th class="title" bgcolor="#FFFFCC">Select</td>
      <th class="title" bgcolor="#FFFFCC">Court Date</td>
      <th class="title" bgcolor="#FFFFCC">Court Type</td>
      <th class="title" bgcolor="#FFFFCC">Court Time</td>
      <th class="title" bgcolor="#FFFFCC">Received Date</td>
      <th class="title" bgcolor="#FFFFCC">Entered Date</td>
   </tr>
<?php
            while ($cr_data = mysql_fetch_array($cr_result, MYSQL_BOTH))
            {
               $court_report_id = $cr_data['court_report_id'];
               $court_type = $cr_data['court_type'];
               $court_type_display = translate_court_type($court_type);
               if ($court_type == $COURT_TYPE_ROYAL)
               {
                  $reign_id = $cr_data['reign_id'];
                  if ($reign_id > 0)
                  {
                     $query2 = "SELECT monarchs_display FROM $DBNAME_OP.reign WHERE reign_id = $reign_id";
                     $query2_result = mysql_query($query2) 
                        or die("Reign Query failed : " . mysql_error());
                     if (mysql_num_rows($query2_result) > 0)
                     {
                        $query2_data = mysql_fetch_array($query2_result, MYSQL_BOTH);
                        $court_type_display .= " - " . $query2_data['monarchs_display'];
                     }
                     mysql_free_result($query2_result);
                  }
                  $principality_id = $cr_data['principality_id'];
                  if ($principality_id > 0)
                  {
                     $query2 = "SELECT principality_display FROM $DBNAME_OP.principality WHERE principality_id = $principality_id";
                     $query2_result = mysql_query($query2) 
                        or die("Principality Query failed : " . mysql_error());
                     if (mysql_num_rows($query2_result) > 0)
                     {
                        $query2_data = mysql_fetch_array($query2_result, MYSQL_BOTH);
                        $court_type_display .= " - " . $query2_data['principality_display'];
                     }
                     mysql_free_result($query2_result);
                  }
                  if (!($reign_id > 0 || $principality_id > 0))
                  {
                     $kingdom_id = $cr_data['kingdom_id'];
                     if ($kingdom_id > 0)
                     {
                        $query2 = "SELECT branch FROM $DBNAME_BRANCH.branch WHERE branch_id = $kingdom_id";
                        $query2_result = mysql_query($query2) 
                           or die("Kingdom Query failed : " . mysql_error());
                        if (mysql_num_rows($query2_result) > 0)
                        {
                           $query2_data = mysql_fetch_array($query2_result, MYSQL_BOTH);
                           $court_type_display .= " - " . $query2_data['branch'];
                        }
                        mysql_free_result($query2_result);
                     }
                  }
               }
               if ($court_type == $COURT_TYPE_BARONIAL)
               {
                  $baronage_id = $cr_data['baronage_id'];
                  if ($baronage_id > 0)
                  {
                     $query2 = "SELECT baronage_display FROM $DBNAME_OP.baronage WHERE baronage_id = $baronage_id";
                     $query2_result = mysql_query($query2) 
                        or die("Baronage Query failed : " . mysql_error());
                     if (mysql_num_rows($query2_result) > 0)
                     {
                        $query2_data = mysql_fetch_array($query2_result, MYSQL_BOTH);
                        $court_type_display .= " - " . $query2_data['baronage_display'];
                     }
                     mysql_free_result($query2_result);
                  }
               }
               $court_time = $cr_data['court_time'];
               $court_time_display = translate_court_time($court_time);
               $court_date = format_short_date($cr_data['court_date']);
               $received_date = "";
               if ($cr_data['received_date'] != "")
               {
                  $received_date = format_short_date($cr_data['received_date']);
               }
               $entered_date = "";
               if ($cr_data['entered_date'] != "")
               {
                  $entered_date = format_short_date($cr_data['entered_date']);
               }
?>
   <tr>
      <td>
      <form action="court_report.php" method="post">
         <input type="hidden" name="form_court_report_id" id="form_court_report_id" value="<?php echo $court_report_id; ?>"/>
         <input type="hidden" name="mode" id="mode" value="<?php echo $MODE_EDIT; ?>"/>
         <input type="submit" value="Edit"/>
      </form>
      </td>
      <td class="data"><?php echo $court_date; ?></td>
      <td class="data"><?php echo $court_type_display; ?></td>
      <td class="data"><?php echo $court_time_display; ?></td>
      <td class="data"><?php echo $received_date; ?></td>
      <td class="data"><?php echo $entered_date; ?></td>
   </tr>
<?php
            }
?>
</table>
<?php
         }
      }
   } // End Add or Edit Selection
db_disconnect($link);
}
// Not authorized
else
{
include("header.php");
?>
<p align="center" class="title2">Edit Event</p>
<p align="center" class="title2">You are not authorized to access this page.</p>
<?php
}
include("footer.php");
?>