<?php
include_once("db.php");

$form_court_report_id = 0;
if (isset($_POST['form_court_report_id']))
{
   $form_court_report_id = clean($_POST['form_court_report_id']);
}
else if (isset($_GET['court_report_id']))
{
   $form_court_report_id = clean($_GET['court_report_id']);
}

$mode = $MODE_EDIT;
if (isset($_POST['mode']))
{
   $mode = clean($_POST['mode']);
}
else if (isset($_GET['mode']))
{
   $mode = clean($_GET['mode']);
}

if (isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN])
{

   if ($mode == $MODE_EDIT && $form_court_report_id == 0)
   {
      $no_edit_selection = true;
   }

   $SUBMIT_ADD = "Add Selected Awards to Court Report";

   // Data submitted
   if (isset($_POST['submit']))
   {
      if ($_POST['submit'] == $SUBMIT_ADD)
      {
         $form_court_report_id = clean($_POST['form_court_report_id']);
         $form_event_id = clean($_POST['form_event_id']);
         $form_atlantian_award_id = null;

         $valid = true;
         $errmsg = '';
         // Validate data
         if (!isset($_POST['form_atlantian_award_id']))
         {
            $valid = false;
            $errmsg = "Please select at least one award to add.<br/>";
         }
         else
         {
            $form_atlantian_award_id = create_in_clause_from_array($_POST['form_atlantian_award_id']);
         }

         // Update database if valid
         if ($valid)
         {
            $link = db_admin_connect();
            // Update
            $sql_stmt = "UPDATE atlantian_award SET " .
               "event_id = " . value_or_null($form_event_id) .
               ", court_report_id = " . value_or_null($form_court_report_id) .
               " WHERE atlantian_award_id IN ($form_atlantian_award_id)";

            $sql_result = mysql_query($sql_stmt)
               or die("Error updating Atlantian Award data: " . mysql_error());

            // Redirect to edit page
            redirect("court_report.php?court_report_id=$form_court_report_id&mode=$MODE_EDIT");
         }
      } // Submit Save
   } // Submit
   // Read Existing  - if this isn't a submit, or it is a failed submit
   if ($form_court_report_id > 0 && (!(isset($_POST['submit'])) || (isset($_POST['submit']) && !$valid)))
   {
      $link = db_connect();

      $query = "SELECT court_report.*, event.event_name, branch, monarchs_display, principality_display, baronage_display " .
               "FROM court_report JOIN event ON court_report.event_id = event.event_id LEFT OUTER JOIN branch ON event.branch_id = branch.branch_id " .
               "LEFT OUTER JOIN reign ON court_report.reign_id = reign.reign_id " .
               "LEFT OUTER JOIN principality ON court_report.principality_id = principality.principality_id " .
               "LEFT OUTER JOIN baronage ON court_report.baronage_id = baronage.baronage_id " .
               "WHERE court_report_id = " . value_or_null($form_court_report_id);
      $result = mysql_query($query);
      $data = mysql_fetch_array($result, MYSQL_BOTH);

      $form_court_report_id = clean($data['court_report_id']);
      $form_event_id = clean($data['event_id']);
      $form_event_name = clean($data['event_name']);
      $form_branch = clean($data['branch']);
      $form_court_type = clean($data['court_type']);
      $form_court_date = clean($data['court_date']);
      $form_court_time = clean($data['court_time']);
      $form_reign = clean($data['monarchs_display']);
      $form_principality = clean($data['principality_display']);
      $form_baronage = clean($data['baronage_display']);
      $display = "";
      if ($form_court_type == $COURT_TYPE_ROYAL)
      {
         if ($form_reign != null)
         {
            $display = $form_reign;
         }
         else
         {
            $display = $form_principality;
         }
      }
      else
      {
         $display = $form_baronage;
      }

      mysql_free_result($result);

      db_disconnect($link);
   }

$link = db_connect();

$title = "Add Existing Awards to Court Report";
include("header.php");
?>
<p align="center" class="title2"><?php echo $title; ?></p>
<p align="center" class="title2">Court Report Information</p>
<?php 
   if (isset($valid) && !$valid && isset($errmsg) && $errmsg != '')
   {
?>
<p align="center" class="title3" style="color:red">Please correct the following errors:<br/><br/><?php echo $errmsg; ?></p>
<?php 
   }
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<?php 
   if (isset($form_event_id) && $form_event_id > 0)
   {
?>
   <input type="hidden" name="form_event_id" id="form_event_id" value="<?php echo $form_event_id; ?>"/>
<?php 
   }
   if (isset($form_court_report_id) && $form_court_report_id > 0)
   {
?>
   <input type="hidden" name="form_court_report_id" id="form_court_report_id" value="<?php echo $form_court_report_id; ?>"/>
<?php 
   }
?>
<table align="center" cellpadding="5" cellspacing="0" border="1">
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Event Name</td>
      <td class="data"><?php echo $form_event_name; ?></td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Host Group</td>
      <td class="data"><?php echo $form_branch; ?></td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Court Date/Time</td>
      <td class="data"><?php echo $form_court_date . " - " . translate_court_time($form_court_time); ?></td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Court Type</td>
      <td class="data"><?php echo translate_court_type($form_court_type); ?></td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Presiding Nobility</td>
      <td class="data"><?php echo $display; ?></td>
   </tr>
</table>
<?php
   $award_query = "SELECT atlantian_award.*, atlantian.sca_name, award.award_name, branch.branch, rg.branch AS rg " .
                  "FROM atlantian_award JOIN award ON atlantian_award.award_id = award.award_id JOIN atlantian ON atlantian.atlantian_id = atlantian_award.atlantian_id " .
                  "LEFT OUTER JOIN branch ON atlantian_award.branch_id = branch.branch_id " .
                  "LEFT OUTER JOIN branch rg ON award.branch_id = rg.branch_id " .
                  "WHERE award_date = " . date_value_or_null($form_court_date) . " AND court_report_id IS NULL ORDER BY sequence, sca_name";
   /* Performing SQL query */
   $award_result = mysql_query($award_query) 
      or die("Award Query failed : " . mysql_error());
   if (mysql_num_rows($award_result) > 0)
   {
?>
<p align="center" class="title2">Possible Awards</p>
<table align="center" cellpadding="5" cellspacing="0" border="1" summary="">
   <tr>
      <th class="title" bgcolor="#FFFFCC">Select</td>
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
?>
   <tr>
      <td>
      <input type="checkbox" name="form_atlantian_award_id[]" id="form_atlantian_award_id" value="<?php echo $atlantian_award_id; ?>"/>
      </td>
      <td class="data"><?php echo $sca_name; ?></td>
      <td class="data"><?php echo $award_name . $rg_display; ?></td>
      <td class="data"><?php echo $sequence; ?></td>
   </tr>
<?php
      } // More records
?>
</table>
<p class="datacenter">
<input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_ADD; ?>"/>
</p>
<?php
   } // Any records
?>
</form>

      <form action="court_report.php" method="post">
         <input type="hidden" name="form_court_report_id" id="form_court_report_id" value="<?php echo $form_court_report_id; ?>"/>
         <input type="hidden" name="mode" id="mode" value="<?php echo $MODE_EDIT; ?>"/>
         <input type="submit" value="Return to Court Report"/>
      </form>

<?php
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