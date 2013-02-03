<?php 
include_once("db.php");
include("header.php");

// Only allow authorized users
if (isset($_SESSION[$BACKLOG_ADMIN]) && $_SESSION[$BACKLOG_ADMIN])
{
   $SUBMIT_SAVE = "Save Backlog Data";

   $submit = "";
   if (isset($_POST['submit']))
   {
      $submit = clean($_POST['submit']);
   }
   $errmsg = "";

   // Selected someone?
   $form_event_id = 0;
   if (isset($_GET['event_id']))
   {
      $form_event_id = clean($_GET['event_id']);
   }
   else if (isset($_POST['event_id']))
   {
      $form_event_id = clean($_POST['event_id']);
   }
   else if (isset($_POST['form_event_id']))
   {
      $form_event_id = clean($_POST['form_event_id']);
   }

   $link = db_admin_connect();

   // Save
   if ($submit == $SUBMIT_SAVE)
   {
      $form_num_recs = clean($_POST['form_num_recs']);
      if ($form_num_recs > 0)
      {
         for ($i = 1; $i <= $form_num_recs; $i++)
         {
            $form_atlantian_award_id[$i] = "";
            if (isset($_POST['form' . $i . '_atlantian_award_id']))
            {
               $form_atlantian_award_id[$i] = clean($_POST['form' . $i . '_atlantian_award_id']);
            }
            $form_scroll_status_id[$i] = "";
            if (isset($_POST['form' . $i . '_scroll_status_id']))
            {
               $form_scroll_status_id[$i] = clean($_POST['form' . $i . '_scroll_status_id']);
            }
            $form_scroll_assignees[$i] = "";
            if (isset($_POST['form' . $i . '_scroll_assignees']))
            {
               $form_scroll_assignees[$i] = clean($_POST['form' . $i . '_scroll_assignees']);
            }
            $form_scroll_assigned_date[$i] = "";
            if (isset($_POST['form' . $i . '_scroll_assigned_date']))
            {
               $form_scroll_assigned_date[$i] = clean($_POST['form' . $i . '_scroll_assigned_date']);
            }
            $form_scroll_notes[$i] = "";
            if (isset($_POST['form' . $i . '_scroll_notes']))
            {
               $form_scroll_notes[$i] = clean($_POST['form' . $i . '_scroll_notes']);
            }
            // Validation
            if ($form_scroll_assigned_date[$i] != '') 
            {
               if (strtotime($form_scroll_assigned_date[$i]) === FALSE)
               {
                  $errmsg .= "Please enter a valid date for the Scroll Assigned Date for award line $i.<br/>";
               }
               else
               {
                  $form_scroll_assigned_date[$i] = format_mysql_date($form_scroll_assigned_date[$i]);
               }
            }
            // Update
            if ($form_atlantian_award_id > 0 && $errmsg == "")
            {
               $update_query = 'UPDATE atlantian_award SET ' .
                               'last_updated = ' . value_or_null(date("Y-m-d")) .
                               ', last_updated_by = ' . value_or_null($_SESSION['s_user_id']) .
                               ', scroll_status_id = ' . value_or_null($form_scroll_status_id[$i]) .
                               ', scroll_assignees = ' . value_or_null($form_scroll_assignees[$i]) .
                               ', scroll_assigned_date = ' . value_or_null($form_scroll_assigned_date[$i]) .
                               ', scroll_notes = ' . value_or_null($form_scroll_notes[$i]) .
                               ' WHERE atlantian_award_id = ' . value_or_null($form_atlantian_award_id[$i]);

               $update_result = mysql_query($update_query) 
                  or die("UPDATE failed : " . mysql_error());
            }
         }
      }
   }

$query = "SELECT event_name, start_date, end_date FROM event WHERE event_id = " . value_or_null($form_event_id);

/* Performing SQL query */
$result = mysql_query($query) 
   or die("Backlog Event Query failed : " . mysql_error());

$data = mysql_fetch_array($result, MYSQL_BOTH);
$event_name = $data['event_name'];
$start_date = $data['start_date'];
$end_date = $data['end_date'];

$date_display = "";
if ($start_date != "")
{
   $date_display = format_short_date($start_date); 
}
if ($end_date != "")
{
   if ($start_date != $end_date) 
   {
      $date_display .= ' - ' . format_short_date($end_date); 
   }
}

/* Free resultset */
mysql_free_result($result);

$query = "SELECT atlantian.sca_name, award.award_name, atlantian_award.award_date, atlantian_award.atlantian_award_id, " .
         "rg1.branch AS rg1_group, rg1.branch_id AS rg1_id, rg1.branch_type_id AS rg1_type, " .
         "rg2.branch AS rg2_group, rg2.branch_id AS rg2_id, rg2.branch_type_id AS rg2_type, " .
         "atlantian_award.scroll_status_id, atlantian_award.scroll_assignees, atlantian_award.scroll_assigned_date, " .
         "atlantian_award.scroll_notes, scroll_status.scroll_status, scroll_status.scroll_status_code " .
         "FROM atlantian_award JOIN award ON award.award_id = atlantian_award.award_id " .
         "JOIN precedence ON award.type_id = precedence.type_id " .
         "JOIN atlantian ON atlantian.atlantian_id = atlantian_award.atlantian_id " .
         "LEFT OUTER JOIN branch rg1 ON rg1.branch_id = atlantian_award.branch_id " .
         "LEFT OUTER JOIN branch rg2 ON rg2.branch_id = award.branch_id " .
         "LEFT OUTER JOIN scroll_status ON scroll_status.scroll_status_id = atlantian_award.scroll_status_id " .
         "WHERE atlantian_award.event_id = " . $form_event_id . " " .
         "AND precedence.precedence <= $UNDER_OP_LEVEL " .
         "ORDER BY atlantian_award.award_date, atlantian_award.sequence, atlantian_award.atlantian_award_id ";

/* Performing SQL query */
$result = mysql_query($query) 
   or die("Backlog Award Query failed : " . mysql_error());

$display_form = (isset($submit) && $submit == $SUBMIT_SAVE && isset($errmsg) && strlen($errmsg) > 0) || (!isset($submit) && !isset($errmsg)) || 
                (isset($submit) && $submit == "" && isset($errmsg) && strlen($errmsg) == 0);
?>
<p class="title2" align="center">Backlog</p>
<p align="center">Awards given at <b><?php echo $event_name; ?></b> <?php echo $date_display; ?></p>
<?php
// ONLY DISPLAY IF THERE ARE RECORDS
if (mysql_num_rows($result) > 0)
{
if (isset($errmsg) && strlen($errmsg) > 0)
{
   echo '<p align="center" style="color:red;font-weight:bold">' . $errmsg . '</p>';
}
if ($display_form)
{
?>
<form action="backlog_court.php" method="post">
<input type="hidden" name="form_event_id" id="form_event_id" value="<?php echo $form_event_id; ?>" />
<?php
}
?>
<table align="center" cellpadding="5" cellspacing="0" border="1" summary="Table listing search results">
   <tr>
      <th class="title">#</th>
      <th class="title">SCA Name</th>
      <th class="title">Award Name</th>
      <th class="title">Award Date</th>
      <th class="title">Scroll Status</th>
      <th class="title">Scribe(s)</th>
      <th class="title">Scroll Assigned Date</th>
      <th class="title">Scroll Notes</th>
   </tr>
<?php 
      $i = 1;
      while ($data = mysql_fetch_array($result, MYSQL_BOTH))
      {
         $sca_name = $data['sca_name'];
         $award_name = $data['award_name'];
         $rg1_group = $data['rg1_group'];
         $rg1_id = $data['rg1_id'];
         $rg1_type = $data['rg1_type'];
         $rg2_group = $data['rg2_group'];
         $rg2_id = $data['rg2_id'];
         $rg2_type = $data['rg2_type'];

         $award_display = $award_name;
         if ($rg1_type != "")
         {
            $award_display .= " ($rg1_group)";
            if ($rg1_type != $BT_KINGDOM)
            {
               $award_display .= " (" . get_kingdom($rg1_id) . ")";
            }
         }
         else if ($rg2_type != "")
         {
            $award_display .= " ($rg2_group)";
            if ($rg2_type != $BT_KINGDOM)
            {
               $award_display .= " (" . get_kingdom($rg2_id) . ")";
            }
         }

         $award_date = $data['award_date'];
         $scroll_status_id = $data['scroll_status_id'];
         $scroll_status = $data['scroll_status'];
         $scroll_assignees = clean($data['scroll_assignees']);
         $scroll_assigned_date = $data['scroll_assigned_date'];
         $scroll_notes = clean($data['scroll_notes']);
         $atlantian_award_id = $data['atlantian_award_id'];

         if ($display_form)
         {
            if ($errmsg != "")
            {
               if (isset(${'form' . $i . '_scroll_status_id'}))
               {
                  $scroll_status_id = ${'form' . $i . '_scroll_status_id'};
               }
               if (isset(${'form' . $i . '_scroll_assignees'}))
               {
                  $scroll_assignees = ${'form' . $i . '_scroll_assignees'};
               }
               if (isset(${'form' . $i . '_scroll_assigned_date'}))
               {
                  $scroll_assigned_date = ${'form' . $i . '_scroll_assigned_date'};
               }
               if (isset(${'form' . $i . '_scroll_notes'}))
               {
                  $scroll_notes = ${'form' . $i . '_scroll_notes'};
               }
            }
?>
   <input type="hidden" name="form<?php echo $i; ?>_atlantian_award_id" id="form<?php echo $i; ?>_atlantian_award_id" value="<?php echo $atlantian_award_id; ?>" />
<?php
         }
?>
   <tr>
      <td class="data"><?php echo $i; ?></td>
      <td class="data"><?php echo $sca_name; ?></td>
      <td class="data"><?php echo $award_display; ?></td>
      <td class="data"><?php echo $award_date; ?></td>
<?php
         if ($display_form)
         {
?>
      <td class="data">
      <select name="form<?php echo $i; ?>_scroll_status_id" id="form<?php echo $i; ?>_scroll_status_id">
         <option value="">Unknown</option>
      <?php 
         $pl_query = "SELECT scroll_status_id, scroll_status, scroll_status_code " .
                     "FROM scroll_status " .
                     "ORDER BY scroll_status_id";

         $pl_result = mysql_query($pl_query)
            or die("Pick List Query failed: " . mysql_error());

         while ($pl_data = mysql_fetch_array($pl_result, MYSQL_BOTH))
         {
            $pl_display = $pl_data['scroll_status'] . " (" . $pl_data['scroll_status_code'] . ")";
            echo '<option value="' . $pl_data['scroll_status_id'] . '"'; 
            if (isset($scroll_status_id) && ($scroll_status_id == $pl_data['scroll_status_id']))
            {
               echo ' selected="selected"';
            }
            echo '>' . $pl_display . '</option>';
         }

         /* Free resultset */
         mysql_free_result($pl_result);
      ?>
      </select>
      </td>
      <td class="data"><input name="form<?php echo $i; ?>_scroll_assignees" id="form<?php echo $i; ?>_scroll_assignees" type="text" size="30"<?php if (isset($scroll_assignees)) { echo ' value="' . $scroll_assignees . '"'; }?>/></td>
      <td class="data"><input name="form<?php echo $i; ?>_scroll_assigned_date" id="form<?php echo $i; ?>_scroll_assigned_date" type="text" size="10"<?php if (isset($scroll_assigned_date)) { echo ' value="' . $scroll_assigned_date . '"'; }?>/></td>
      <td class="data"><input name="form<?php echo $i; ?>_scroll_notes" id="form<?php echo $i; ?>_scroll_notes" type="text" size="30"<?php if (isset($scroll_notes)) { echo ' value="' . $scroll_notes . '"'; }?>/></td>
<?php
         }
         else
         {
?>
      <td class="data"><?php echo $scroll_status; ?></td>
      <td class="data"><?php echo $scroll_assignees; ?></td>
      <td class="data"><?php echo $scroll_assigned_date; ?></td>
      <td class="data"><?php echo $scroll_notes; ?></td>
<?php 
         }
?>
   </tr>
<?php 
         $i++;
      }
      $num_recs = mysql_num_rows($result);

      if ($display_form)
      {
?>
   <tr>
      <td class="title" colspan="8"><input name="submit" id="submit" type="submit" value="<?php echo $SUBMIT_SAVE; ?>"/>&nbsp;&nbsp;&nbsp;<input type="reset" value="Reset Form"/></td>
   </tr>
<?php
      }
?>
</table>
<?php
      if ($display_form)
      {
?>
<input type="hidden" name="form_num_recs" id="form_num_recs" value="<?php echo $num_recs; ?>" />
</form>
<?php
      }
?>
<p align="center"><?php echo $num_recs; ?> records matched your search criteria.</p>
<?php 
   /* Free resultset */
   mysql_free_result($result);

   /* Closing connection */
   db_disconnect($link);
} // end records
else
{
?>
<p align="center">No records matched your search criteria.</p>
<?php 
} // end no records
}
// Not allowed to access page
else
{
?>
<p class="title2">Backlog</p>
<p>You are not authorized to access this page.</p>
<?php
}
include("footer.php");
?>



