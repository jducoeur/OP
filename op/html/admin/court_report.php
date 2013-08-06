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

$form_court_report_id = 0;
if (isset($_POST['form_court_report_id']))
{
   $form_court_report_id = clean($_POST['form_court_report_id']);
}
else if (isset($_GET['court_report_id']))
{
   $form_court_report_id = clean($_GET['court_report_id']);
}

$form_event_name = "";
if (isset($_POST['form_event_name']))
{
   $form_event_name = clean($_POST['form_event_name']);
}
else if (isset($_GET['event_name']))
{
   $form_event_name = clean($_GET['event_name']);
}

$form_branch_id = "";
if (isset($_POST['form_branch_id']))
{
   $form_branch_id = clean($_POST['form_branch_id']);
}
else if (isset($_GET['branch_id']))
{
   $form_branch_id = clean($_GET['branch_id']);
}

$form_start_date = "";
if (isset($_POST['form_start_date']))
{
   $form_start_date = clean($_POST['form_start_date']);
}
else if (isset($_GET['start_date']))
{
   $form_start_date = clean($_GET['start_date']);
}

$form_end_date = "";
if (isset($_POST['form_end_date']))
{
   $form_end_date = clean($_POST['form_end_date']);
}
else if (isset($_GET['end_date']))
{
   $form_end_date = clean($_GET['end_date']);
}

$mode = $MODE_EDIT;
if (isset($_REQUEST['mode']))
{
   $mode = clean($_REQUEST['mode']);
}

if (isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN])
{
   if ($mode == $MODE_EDIT && $form_court_report_id == 0)
   {
      $no_edit_selection = true;
   }

   $SUBMIT_SAVE = "Save Court Report";
   $SUBMIT_DELETE = "Delete Court Report";
   $SUBMIT_REMOVE = "Remove"; // Remove Award from Court Report

   // Data submitted
   if (isset($_POST['submit']))
   {
      if ($_POST['submit'] == $SUBMIT_DELETE)
      {
         if ($mode == $MODE_EDIT && $form_court_report_id > 0)
         {
            $count = 0;
            $link = db_admin_connect();

            // Check for child OP records: atlantian_award
            $check_query = "SELECT court_report_id FROM $DBNAME_OP.atlantian_award WHERE court_report_id = " . value_or_null($form_court_report_id);
            $check_result = mysql_query($check_query, $link)
               or die("Error checking OP for Court Report (atlantian_award): " . mysql_error());
            $count += mysql_num_rows($check_result);

            // Only delete if the checks passed
            if ($count == 0)
            {
               // Delete from op
               $delete = "DELETE FROM $DBNAME_OP.court_report WHERE court_report_id = " . value_or_null($form_court_report_id);
               $del_result = mysql_query($delete, $link)
                  or die("Error deleting Court Report from OP: " . mysql_error());

               // Redirect to edit page
               redirect("deleted.php?type_id=$DEL_TYPE_CR");
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
               $errmsg .= " for Court Report ID $form_court_report_id; this Court Report may not be deleted until all child records are deleted.";
            }
            // Close DBs
            db_disconnect($link);
         }
      } // End Submit Delete
      if ($_POST['submit'] == $SUBMIT_REMOVE)
      {
         // Connect to DB
         $link = db_admin_connect();
         // Update
         $form_atlantian_award_id = clean($_POST['form_atlantian_award_id']);
         $update = "UPDATE $DBNAME_OP.atlantian_award SET court_report_id = NULL, event_id = NULL WHERE atlantian_award_id = " . value_or_null($form_atlantian_award_id);
         $upd_result = mysql_query($update, $link)
            or die("Error removing Award from Court Report: " . mysql_error());
         // Close DB
         db_disconnect($link);
      }
      if ($_POST['submit'] == $SUBMIT_SAVE)
      {
         $form_kingdom_id = clean($_POST['form_kingdom_id']);
         $form_reign_id = clean($_POST['form_reign_id']);
         $form_principality_id = clean($_POST['form_principality_id']);
         $form_baronage_id = clean($_POST['form_baronage_id']);
         $form_court_type = clean($_POST['form_court_type']);
         $form_court_date = clean($_POST['form_court_date']);
         $form_court_time = clean($_POST['form_court_time']);
         $form_received_date = clean($_POST['form_received_date']);
         $form_entered_date = clean($_POST['form_entered_date']);
         $form_herald = clean($_POST['form_herald']);
         $form_notes = clean($_POST['form_notes']);

         $valid = true;
         $errmsg = '';
         // Validate data
         if ($form_court_type == '')
         {
            $valid = false;
            $errmsg .= "Please select a Court Type.<br/>";
         }
         if ($form_court_type == $COURT_TYPE_ROYAL)
         {
            if ($form_reign_id > 0 && $form_principality_id > 0)
            {
               $valid = false;
               $errmsg .= "Please select either Monarchs or Territorial Prince/Princess, not both.<br/>";
            }
            if ($form_baronage_id > 0)
            {
               $valid = false;
               $errmsg .= "Please select either Monarchs or Territorial Prince/Princess for a Royal Court Type, not Baronage.<br/>";
            }
         }
         if ($form_court_type == $COURT_TYPE_BARONIAL)
         {
            if ($form_reign_id > 0 || $form_principality_id > 0)
            {
               $valid = false;
               $errmsg .= "Please select Baronage for a Baronial Court Type, not Monarchs or Territorial Prince/Princess.<br/>";
            }
         }
         if (($form_reign_id > 0 || $form_principality_id > 0 || $form_baronage_id > 0) && ($form_kingdom_id != $ATLANTIA && $form_kingdom_id != ""))
         {
            $valid = false;
            $errmsg .= "Please select Kingdom Atlantia when selecting Atlantian Monarchs, Territorial Prince/Princess, or Baronage.<br/>";
         }
         if ($form_court_date != '')
         {
            if (strtotime($form_court_date) === FALSE)
            {
               $valid = false;
               $errmsg .= "Please enter a valid date for the Court Date.<br/>";
            }
            else
            {
               $form_court_date = format_mysql_date($form_court_date);
            }
         }
         else
         {
            $valid = false;
            $errmsg .= "Please enter the Court Date.<br/>";
         }
         if ($form_court_time == '')
         {
            $valid = false;
            $errmsg .= "Please select a Court Time.<br/>";
         }
         if ($form_received_date != '')
         {
            if (strtotime($form_received_date) === FALSE)
            {
               $valid = false;
               $errmsg .= "Please enter a valid date for the Received Date.<br/>";
            }
            else
            {
               $form_received_date = format_mysql_date($form_received_date);
            }
         }
         if ($form_entered_date != '')
         {
            if (strtotime($form_entered_date) === FALSE)
            {
               $valid = false;
               $errmsg .= "Please enter a valid date for the Entered Date.<br/>";
            }
            else
            {
               $form_entered_date = format_mysql_date($form_entered_date);
            }
         }

         // Update database if valid
         if ($valid)
         {
            $link = db_admin_connect();
            // Update
            if ($form_court_report_id > 0)
            {
               $sql_stmt = "UPDATE $DBNAME_OP.court_report SET " .
                  "court_type = " . value_or_null($form_court_type) .
                  ", court_time = " . value_or_null($form_court_time) .
                  ", event_id = " . value_or_null($form_event_id) .
                  ", kingdom_id = " . value_or_null($form_kingdom_id) .
                  ", reign_id = " . value_or_null($form_reign_id) .
                  ", principality_id = " . value_or_null($form_principality_id) .
                  ", baronage_id = " . value_or_null($form_baronage_id) .
                  ", court_date = " . value_or_null($form_court_date) .
                  ", received_date = " . value_or_null($form_received_date) .
                  ", entered_date = " . value_or_null($form_entered_date) .
                  ", herald = " . value_or_null($form_herald) .
                  ", notes = " . value_or_null($form_notes) .
                  ", last_updated = " . value_or_null(date("Y-m-d")) .
                  ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) .
                  " WHERE court_report_id = " . value_or_null($form_court_report_id);

               $sql_result = mysql_query($sql_stmt)
                  or die("Error updating Court Report data: " . mysql_error());
            }
            // Insert
            else
            {
               $sql_stmt = "INSERT INTO $DBNAME_OP.court_report (court_type, court_time, event_id, kingdom_id, reign_id, principality_id, baronage_id, court_date, received_date, entered_date, herald, notes, last_updated, last_updated_by " .
                  ") VALUES (" .
                  value_or_null($form_court_type) . ", " .
                  value_or_null($form_court_time) . ", " .
                  value_or_null($form_event_id) . ", " .
                  value_or_null($form_kingdom_id) . ", " .
                  value_or_null($form_reign_id) . ", " .
                  value_or_null($form_principality_id) . ", " .
                  value_or_null($form_baronage_id) . ", " .
                  value_or_null($form_court_date) . ", " .
                  value_or_null($form_received_date) . ", " .
                  value_or_null($form_entered_date) . ", " .
                  value_or_null($form_herald) . ", " .
                  value_or_null($form_notes) . ", " .
                  value_or_null(date("Y-m-d")) . ", " .
                  value_or_null($_SESSION['s_user_id']) . 
                  ")";

               $sql_result = mysql_query($sql_stmt)
                  or die("Error inserting Court Report data: " . mysql_error());
               $form_court_report_id = mysql_insert_id();
            }
            // Redirect to edit page
            redirect("court_report.php?court_report_id=$form_court_report_id&mode=$MODE_EDIT");
         }
      } // Submit Save
   } // Submit
   // Read Existing Court Report - if this isn't a submit, or it is a failed submit delete
   if ($form_court_report_id > 0 && (!(isset($_POST['submit'])) || (isset($_POST['submit']) && ($_POST['submit'] == $SUBMIT_DELETE || $_POST['submit'] == $SUBMIT_REMOVE))))
   {
      $link = db_connect();

      $query = "SELECT court_report.*, event.event_name, event.start_date, event.end_date, event.branch_id FROM $DBNAME_OP.court_report JOIN $DBNAME_OP.event ON court_report.event_id = event.event_id WHERE court_report_id = " . value_or_null($form_court_report_id);
      $result = mysql_query($query);
      $data = mysql_fetch_array($result, MYSQL_BOTH);

      $form_event_id = clean($data['event_id']);
      $form_event_name = clean($data['event_name']);
      $form_start_date = clean($data['start_date']);
      $form_end_date = clean($data['end_date']);
      $form_branch_id = clean($data['branch_id']);

      $form_court_report_id = clean($data['court_report_id']);
      $form_kingdom_id = clean($data['kingdom_id']);
      $form_reign_id = clean($data['reign_id']);
      $form_principality_id = clean($data['principality_id']);
      $form_baronage_id = clean($data['baronage_id']);
      $form_court_type = clean($data['court_type']);
      $form_court_date = clean($data['court_date']);
      $form_court_time = clean($data['court_time']);
      $form_received_date = clean($data['received_date']);
      $form_entered_date = clean($data['entered_date']);
      $form_herald = clean($data['herald']);
      $form_notes = clean($data['notes']);

      mysql_free_result($result);

      db_disconnect($link);
   }

$link = db_connect();

// Get Event data
if ($mode == $MODE_ADD && $form_event_id > 0)
{
   $query = "SELECT event.event_name, event.start_date, event.end_date, event.branch_id, DATE_ADD(event.start_date, INTERVAL 1 DAY) AS next_date FROM $DBNAME_OP.event WHERE event_id = " . value_or_null($form_event_id);
   $result = mysql_query($query);
   $data = mysql_fetch_array($result, MYSQL_BOTH);

   $form_event_name = clean($data['event_name']);
   $form_start_date = clean($data['start_date']);
   $form_end_date = clean($data['end_date']);
   $form_branch_id = clean($data['branch_id']);
   $form_next_date = clean($data['next_date']);

   if (!isset($form_court_date) || $form_court_date == "")
   {
      $form_court_date = $form_start_date;
      if ($form_start_date != $form_end_date)
      {
         $form_court_date = $form_next_date;
      }
   }

   mysql_free_result($result);
}

// Pick Lists
// Kingdoms
$kingdom_pl_query = "SELECT branch_id, branch " .
                    "FROM $DBNAME_BRANCH.kingdom " .
                    "WHERE branch_id <> $ATLANTIA " .
                    "ORDER BY branch";

/* Performing SQL query */
$kingdom_pl_result = mysql_query($kingdom_pl_query) 
   or die("Kingdom List Query failed : " . mysql_error());

// Reigns
$reign_pl_query = "SELECT reign_id, monarchs_display, reign_start_date, reign_end_date " .
                  "FROM $DBNAME_OP.reign " .
                  "WHERE ((reign_start_date <= " . value_or_null($form_start_date) . " AND (reign_end_date >= " . value_or_null($form_end_date) . " OR reign_end_date IS NULL)) " .
                  "OR (reign_start_date >= " . value_or_null($form_start_date) . " AND reign_start_date <= " . value_or_null($form_end_date) . ") " .
                  "OR (reign_end_date >= " . value_or_null($form_start_date) . " AND reign_end_date <= " . value_or_null($form_end_date) . ")) " .
                  "ORDER BY reign_start_date DESC";

/* Performing SQL query */
$reign_pl_result = mysql_query($reign_pl_query) 
   or die("Reign List Query failed : " . mysql_error());

// Principality Reigns
$principality_pl_query = "SELECT principality_id, principality_display, principality_start_date, principality_end_date " .
                         "FROM $DBNAME_OP.principality " .
                         "WHERE ((principality_start_date <= " . value_or_null($form_start_date) . " AND (principality_end_date >= " . value_or_null($form_end_date) . " OR principality_end_date IS NULL)) " .
                         "OR (principality_start_date >= " . value_or_null($form_start_date) . " AND principality_start_date <= " . value_or_null($form_end_date) . ") " .
                         "OR (principality_end_date >= " . value_or_null($form_start_date) . " AND principality_end_date <= " . value_or_null($form_end_date) . ")) " .
                         "ORDER BY principality_start_date DESC";

/* Performing SQL query */
$principality_pl_result = mysql_query($principality_pl_query) 
   or die("Principality List Query failed : " . mysql_error());

$b_wc = "";
/*
if ($form_branch_id > 0)
{
   $barony_id = get_barony_id($form_branch_id);
   if ($barony_id > 0)
   {
      $b_wc = "AND baronage.branch_id = $barony_id ";
   }
}*/
// Baronage Reigns
$baronage_pl_query = "SELECT baronage_id, baronage_display, baronage_start_date, baronage_end_date, branch " .
                     "FROM $DBNAME_OP.baronage JOIN $DBNAME_BRANCH.branch ON baronage.branch_id = branch.branch_id " .
                     "WHERE ((baronage_start_date <= " . value_or_null($form_start_date) . " AND (baronage_end_date >= " . value_or_null($form_end_date) . " OR baronage_end_date IS NULL)) " .
                     "OR (baronage_start_date >= " . value_or_null($form_start_date) . " AND baronage_start_date <= " . value_or_null($form_end_date) . ") " .
                     "OR (baronage_end_date >= " . value_or_null($form_start_date) . " AND baronage_end_date <= " . value_or_null($form_end_date) . ")) " . $b_wc .
                     "ORDER BY baronage.branch_id, baronage_start_date DESC";

/* Performing SQL query */
$baronage_pl_result = mysql_query($baronage_pl_query) 
   or die("Baronage List Query failed : " . mysql_error());

$title = ucfirst($mode) . " Court Report";
include("header.php");
?>
<p align="center" class="title2"><?php echo ucfirst($mode); ?> Court Report</p>
<p align="center" class="title2">Court Report Information</p>
<?php 
   if (isset($no_edit_selection) && $no_edit_selection)
   {
?>
<p align="center" class="title3" style="color:red">No Court Report was selected for Edit.  Please use a navigation link to the left.</p>
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
      if (isset($form_court_report_id) && $form_court_report_id > 0)
      {
?>
   <input type="hidden" name="form_court_report_id" id="form_court_report_id" value="<?php echo $form_court_report_id; ?>"/>
<?php 
      }
      if (isset($form_event_id) && $form_event_id > 0)
      {
?>
   <input type="hidden" name="form_event_id" id="form_event_id" value="<?php echo $form_event_id; ?>"/>
<?php 
      }
      if (isset($form_event_name) && $form_event_name != "")
      {
?>
   <input type="hidden" name="form_event_name" id="form_event_name" value="<?php echo $form_event_name; ?>"/>
<?php 
      }
      if (isset($form_start_date) && $form_start_date != "")
      {
?>
   <input type="hidden" name="form_start_date" id="form_start_date" value="<?php echo $form_start_date; ?>"/>
<?php 
      }
      if (isset($form_end_date) && $form_end_date != "")
      {
?>
   <input type="hidden" name="form_end_date" id="form_end_date" value="<?php echo $form_end_date; ?>"/>
<?php 
      }
      if (isset($form_branch_id) && $form_branch_id != "")
      {
?>
   <input type="hidden" name="form_branch_id" id="form_branch_id" value="<?php echo $form_branch_id; ?>"/>
<?php 
      }
?>
<table align="center" cellpadding="5" cellspacing="0" border="1">
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Event</td>
      <td class="data">
      <?php if (isset($form_event_name) && $form_event_name != '') { echo $form_event_name;} ?>
      <?php if (isset($form_start_date) && $form_start_date != '') { echo format_short_date($form_start_date);} ?>
      <?php if (isset($form_end_date) && $form_end_date != '' && $form_end_date != $form_start_date) { echo " - " . format_short_date($form_end_date);} ?>
      <?php if (isset($form_event_name) && $form_event_name != '') { echo " (" . get_branch_name($form_branch_id) . ")";} ?>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Court Date</td>
      <td class="data"><input type="text" name="form_court_date" id="form_court_date" size="15" maxlength="10"<?php if (isset($form_court_date) && $form_court_date != '') { echo " value=\"$form_court_date\""; } ?>/></td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Court Time</td>
      <td class="data">
      <select name="form_court_time" id="form_court_time">
         <option></option>
         <?php generate_court_time_pl($form_court_time); ?>
      </select>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Court Type</td>
      <td class="data">
      <select name="form_court_type" id="form_court_type">
         <option></option>
         <?php generate_court_type_pl($form_court_type); ?>
      </select>
      </td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_kingdom_id">Kingdom</label>:</th>
      <td class="data">
      <select name="form_kingdom_id" id="form_kingdom_id">
         <option value="">Unknown</option>
         <option value="<?php echo $ATLANTIA; ?>"<?php if (isset($form_kingdom_id) && ($form_kingdom_id == $ATLANTIA)) { echo ' selected="selected"'; } ?>><?php echo $ATLANTIA_NAME; ?></option>
      <?php 
         while ($pl_data = mysql_fetch_array($kingdom_pl_result, MYSQL_BOTH))
         {
            $kingdom_display = $pl_data['branch'];
            echo '<option value="' . $pl_data['branch_id'] . '"'; 
            if (isset($form_kingdom_id) && ($form_kingdom_id == $pl_data['branch_id']))
            {
               echo ' selected="selected"';
            }
            echo '>' . $kingdom_display . '</option>';
         }

         /* Free resultset */
         mysql_free_result($kingdom_pl_result);
      ?>
      </select>
      </td>
   </tr>
   <tr>
      <th class="titleright">Presiding Monarchs</th>
      <td class="data">
      <select name="form_reign_id" id="form_reign_id">
         <option></option>
         <?php
            while ($reign_data = mysql_fetch_array($reign_pl_result, MYSQL_BOTH))
            {
               $reign_id = $reign_data['reign_id'];
               $reign_display = $reign_data['monarchs_display'];
               if ($reign_data['reign_start_date'] != '')
               {
                  $reign_display .= " (" . format_short_date($reign_data['reign_start_date']);
                  if ($reign_data['reign_end_date'] != '')
                  {
                     $reign_display .=  " - " . format_short_date($reign_data['reign_end_date']);
                  }
                  else
                  {
                     $reign_display .=  " - present";
                  }
                  $reign_display .= ")";
               }
               echo '<option id="' . $reign_id . '" value="' . $reign_id . '"';
               if (isset($form_reign_id) && $form_reign_id == $reign_id)
               {
                  echo ' selected';
               }
               echo '>' . $reign_display . '</option>';
            }
         ?>
      </select>
      </td>
   </tr>
   <tr>
      <th class="titleright">Presiding Territorial Prince/Princess</th>
      <td class="data">
      <select name="form_principality_id" id="form_principality_id">
         <option></option>
         <?php
            while ($principality_data = mysql_fetch_array($principality_pl_result, MYSQL_BOTH))
            {
               $principality_id = $principality_data['principality_id'];
               $principality_display = $principality_data['principality_display'];
               if ($principality_data['principality_start_date'] != '')
               {
                  $principality_display .= " (" . format_short_date($principality_data['principality_start_date']);
                  if ($principality_data['principality_end_date'] != '')
                  {
                     $principality_display .=  " - " . format_short_date($principality_data['principality_end_date']);
                  }
                  else
                  {
                     $principality_display .=  " - present";
                  }
                  $principality_display .= ")";
               }
               echo '<option id="' . $principality_id . '" value="' . $principality_id . '"';
               if (isset($form_principality_id) && $form_principality_id == $principality_id)
               {
                  echo ' selected';
               }
               echo '>' . $principality_display . '</option>';
            }
         ?>
      </select>
      </td>
   </tr>
   <tr>
      <th class="titleright">Presiding Baronage</th>
      <td class="data">
      <select name="form_baronage_id" id="form_baronage_id">
         <option></option>
         <?php
            while ($baronage_data = mysql_fetch_array($baronage_pl_result, MYSQL_BOTH))
            {
               $baronage_id = $baronage_data['baronage_id'];
               $baronage_display = $baronage_data['branch'] . " - " . $baronage_data['baronage_display'];
               if ($baronage_data['baronage_start_date'] != '')
               {
                  $baronage_display .= " (" . format_short_date($baronage_data['baronage_start_date']);
                  if ($baronage_data['baronage_end_date'] != '')
                  {
                     $baronage_display .=  " - " . format_short_date($baronage_data['baronage_end_date']);
                  }
                  else
                  {
                     $baronage_display .=  " - present";
                  }
                  $baronage_display .= ")";
               }
               echo '<option id="' . $baronage_id . '" value="' . $baronage_id . '"';
               if (isset($form_baronage_id) && $form_baronage_id == $baronage_id)
               {
                  echo ' selected';
               }
               echo '>' . $baronage_display . '</option>';
            }
         ?>
      </select>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Herald</td>
      <td class="data"><input type="text" name="form_herald" id="form_herald" size="50" maxlength="255"<?php if (isset($form_herald) && $form_herald != '') { echo " value=\"$form_herald\"";} ?>/></td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Received Date</td>
      <td class="data"><input type="text" name="form_received_date" id="form_received_date" size="15" maxlength="10"<?php if (isset($form_received_date) && $form_received_date != '') { echo " value=\"$form_received_date\"";} ?>/></td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Entered Date</td>
      <td class="data"><input type="text" name="form_entered_date" id="form_entered_date" size="15" maxlength="10"<?php if (isset($form_entered_date) && $form_entered_date != '') { echo " value=\"$form_entered_date\"";} ?>/></td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Notes</td>
      <td class="data"><input type="text" name="form_notes" id="form_notes" size="50" maxlength="65535"<?php if (isset($form_notes) && $form_notes != '') { echo " value=\"$form_notes\"";} ?>/></td>
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
      <form action="event.php" method="post">
         <input type="hidden" name="form_event_id" id="form_event_id" value="<?php echo $form_event_id; ?>"/>
         <input type="hidden" name="mode" id="mode" value="<?php echo $MODE_EDIT; ?>"/>
         <input type="submit" value="Edit Event <?php echo $form_event_name; ?>"/>
      </form>
      </td>
   </tr>
</table>
<table border="0" align="center" cellpadding="5" summary="">
   <tr>
      <td>
      <form action="select_ind.php" method="post">
         <input type="hidden" name="form_court_report_id" id="form_court_report_id" value="<?php echo $form_court_report_id; ?>"/>
         <input type="hidden" name="form_event_id" id="form_event_id" value="<?php echo $form_event_id; ?>"/>
         <input type="hidden" name="type" id="type" value="<?php echo $TYPE_AWARD; ?>"/>
         <input type="hidden" name="mode" id="mode" value="<?php echo $MODE_ADD; ?>"/>
         <input type="submit" value="Add New Award to this Court Report"/>
      </form>
      </td>
      <td>
      <form action="cr_awards.php" method="post">
         <input type="hidden" name="form_court_report_id" id="form_court_report_id" value="<?php echo $form_court_report_id; ?>"/>
         <input type="submit" value="Add Existing Awards to this Court Report"/>
      </form>
      </td>
   </tr>
</table>
<?php
         $award_query = "SELECT atlantian_award.*, atlantian.sca_name, award.award_name, branch.branch, rg.branch AS rg " .
                        "FROM $DBNAME_OP.atlantian_award JOIN $DBNAME_OP.award ON atlantian_award.award_id = award.award_id " .
                        "JOIN $DBNAME_AUTH.atlantian ON atlantian.atlantian_id = atlantian_award.atlantian_id " .
                        "LEFT OUTER JOIN $DBNAME_BRANCH.branch ON atlantian_award.branch_id = branch.branch_id " .
                        "LEFT OUTER JOIN $DBNAME_BRANCH.branch rg ON award.branch_id = rg.branch_id " .
                        "WHERE court_report_id = $form_court_report_id ORDER BY sequence, sca_name";
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
Click the Remove button to remove an award from this court report (this does not delete the award from the OP).<br/>
<img src="<?php echo $IMAGES_DIR; ?>private.gif" width="15" height="15" alt="Marked Private" border="0"/> Lock icon indicates record is marked private.
</p>
<table align="center" cellpadding="5" cellspacing="0" border="1" summary="">
   <tr>
      <th class="title" bgcolor="#FFFFCC">Remove</td>
      <th class="title" bgcolor="#FFFFCC">Edit</td>
      <th class="title" bgcolor="#FFFFCC">SCA Name</td>
      <th class="title" bgcolor="#FFFFCC">Award Name</td>
      <th class="title" bgcolor="#FFFFCC">Sequence</td>
   </tr>
<?php
            while ($award_data = mysql_fetch_array($award_result, MYSQL_BOTH))
            {
               $atlantian_award_id = $award_data['atlantian_award_id'];
               $atlantian_id = $award_data['atlantian_id'];
               $award_id = $award_data['award_id'];
               $sca_name = clean($award_data['sca_name']);
               $award_name = clean($award_data['award_name']);
               $sequence = $award_data['sequence'];
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
               $private = $award_data['private'];
               $private_display = "";
               if ($private == 1)
               {
                  $private_display = "<img src=\"" . $IMAGES_DIR . "private.gif\" width=\"15\" height=\"15\" alt=\"Marked Private\" border=\"0\"/> ";
               }
?>
   <tr>
      <td>
      <form action="court_report.php" method="post">
         <input type="hidden" name="form_atlantian_award_id" id="form_atlantian_award_id" value="<?php echo $atlantian_award_id; ?>"/>
         <input type="hidden" name="form_event_id" id="form_event_id" value="<?php echo $form_event_id; ?>"/>
         <input type="hidden" name="form_court_report_id" id="form_court_report_id" value="<?php echo $form_court_report_id; ?>"/>
         <input type="hidden" name="mode" id="mode" value="<?php echo $MODE_EDIT; ?>"/>
         <input type="submit"  name="submit" id="submit"value="<?php echo $SUBMIT_REMOVE; ?>"/>
      </form>
      </td>
      <td>
      <form action="edit_ind_award.php" method="post">
         <input type="hidden" name="form_atlantian_id" id="form_atlantian_id" value="<?php echo $atlantian_id; ?>"/>
         <input type="hidden" name="form_award_id" id="form_award_id" value="<?php echo $award_id; ?>"/>
         <input type="hidden" name="form_atlantian_award_id" id="form_atlantian_award_id" value="<?php echo $atlantian_award_id; ?>"/>
         <input type="hidden" name="form_event_id" id="form_event_id" value="<?php echo $form_event_id; ?>"/>
         <input type="hidden" name="form_court_report_id" id="form_court_report_id" value="<?php echo $form_court_report_id; ?>"/>
         <input type="hidden" name="mode" id="mode" value="<?php echo $MODE_EDIT; ?>"/>
         <input type="submit" value="Edit"/>
      </form>
      </td>
      <td class="data"><?php echo $private_display . $sca_name; ?></td>
      <td class="data"><?php echo $award_name . $rg_display; ?></td>
      <td class="data"><?php echo $sequence; ?></td>
   </tr>
<?php
            }
?>
</table>
<p align="center"><?php echo $num_awards; ?> awards given.</p>
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
<p align="center" class="title2">Edit Court Report</p>
<p align="center" class="title2">You are not authorized to access this page.</p>
<?php
}
include("footer.php");
?>