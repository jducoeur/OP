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
   $form_atlantian_id = 0;
   if (isset($_REQUEST['atlantian_id']))
   {
      $form_atlantian_id = clean($_REQUEST['atlantian_id']);
   }
   else if (isset($_POST['form_atlantian_id']))
   {
      $form_atlantian_id = clean($_POST['form_atlantian_id']);
   }

   // Get pick lists
   $branch_data_array = get_branch_pick_list();

   $link = db_admin_connect();

   // Save
   if ($submit == $SUBMIT_SAVE)
   {
      // Update Atlantian data
      $form_branch_id = "";
      $form_branch = "";
      $form_inactive = 0;
      $form_deceased = 0;
      $form_decease_date = "";

      if (isset($_POST['form_branch_id']))
      {
         $form_branch_id = clean($_POST['form_branch_id']);
      }
      if (isset($_POST['form_inactive']))
      {
         $form_inactive = clean($_POST['form_inactive']);
      }
      if (isset($_POST['form_deceased']))
      {
         $form_deceased = clean($_POST['form_deceased']);
         // If they are deceased, they are also inactive
         if ($form_deceased == 1)
         {
            $form_inactive = 1;
         }
      }
      if (isset($_POST['form_deceased_date']))
      {
         $form_deceased_date = clean($_POST['form_deceased_date']);
      }
      // Validation
      if ($form_deceased_date != '') 
      {
         if (strtotime($form_deceased_date) === FALSE)
         {
            $errmsg .= "Please enter a valid date for the Deceased Date.<br/>";
         }
         else
         {
            $form_deceased_date = format_mysql_date($form_deceased_date);
         }
      }
      // Update
      if ($form_atlantian_id > 0 && $errmsg == "")
      {
         $update_query = "UPDATE $DBNAME_AUTH.atlantian SET " .
                         "last_updated = " . value_or_null(date("Y-m-d")) .
                         ", last_updated_by = " . value_or_null($_SESSION["s_user_id"]) .
                         ", branch_id = " . value_or_null($form_branch_id) .
                         ", inactive = " . value_or_zero($form_inactive) .
                         ", deceased = " . value_or_zero($form_deceased) .
                         ", deceased_date = " . value_or_null($form_deceased_date) .
                         " WHERE atlantian_id = " . value_or_null($form_atlantian_id);

         $update_result = mysql_query($update_query) 
            or die("UPDATE Atlantian failed : " . mysql_error());
      }

      // Scroll data
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
               $update_query = "UPDATE $DBNAME_OP.atlantian_award SET " .
                               "last_updated = " . value_or_null(date("Y-m-d")) .
                               ", last_updated_by = " . value_or_null($_SESSION["s_user_id"]) .
                               ", scroll_status_id = " . value_or_null($form_scroll_status_id[$i]) .
                               ", scroll_assignees = " . value_or_null($form_scroll_assignees[$i]) .
                               ", scroll_assigned_date = " . value_or_null($form_scroll_assigned_date[$i]) .
                               ", scroll_notes = " . value_or_null($form_scroll_notes[$i]) .
                               " WHERE atlantian_award_id = " . value_or_null($form_atlantian_award_id[$i]);

               $update_result = mysql_query($update_query) 
                  or die("UPDATE Award $i failed : " . mysql_error());
            }
         }
      }
   }

$query = "SELECT sca_name, atlantian.inactive, deceased, deceased_date, atlantian.branch_id, branch " .
         "FROM $DBNAME_AUTH.atlantian LEFT OUTER JOIN $DBNAME_BRANCH.branch ON atlantian.branch_id = branch.branch_id " .
         "WHERE atlantian_id = " . $form_atlantian_id;

/* Performing SQL query */
$result = mysql_query($query) 
   or die("Backlog Name Query failed : " . mysql_error());

$data = mysql_fetch_array($result, MYSQL_BOTH);
$sca_name = $data['sca_name'];
$form_inactive = $data['inactive'];
$form_deceased = $data['deceased'];
$form_deceased_date = $data['deceased_date'];
$form_branch_id = $data['branch_id'];
$form_branch = $data['branch'];

/* Free resultset */
mysql_free_result($result);

// Award query
$query = "SELECT award.award_name, atlantian_award.award_date, atlantian_award.atlantian_award_id, " .
         "b1.branch AS b1_branch, b1.branch_id AS b1_id, b1.branch_type_id AS b1_type, " .
         "b2.branch AS b2_branch, b2.branch_id AS b2_id, b2.branch_type_id AS b2_type, " .
         "atlantian_award.scroll_status_id, atlantian_award.scroll_assignees, atlantian_award.scroll_assigned_date, " .
         "atlantian_award.scroll_notes, scroll_status.scroll_status, scroll_status.scroll_status_code " .
         "FROM $DBNAME_OP.atlantian_award JOIN $DBNAME_OP.award ON award.award_id = atlantian_award.award_id " .
         "JOIN $DBNAME_OP.precedence ON award.type_id = precedence.type_id " .
         "LEFT OUTER JOIN $DBNAME_BRANCH.branch b1 ON b1.branch_id = atlantian_award.branch_id " .
         "LEFT OUTER JOIN $DBNAME_BRANCH.branch b2 ON b2.branch_id = award.branch_id " .
         "LEFT OUTER JOIN $DBNAME_OP.scroll_status ON scroll_status.scroll_status_id = atlantian_award.scroll_status_id " .
         "WHERE atlantian_award.atlantian_id = " . $form_atlantian_id . " " .
         "AND precedence.precedence <= $UNDER_OP_LEVEL " .
         "ORDER BY atlantian_award.award_date, atlantian_award.sequence, atlantian_award.atlantian_award_id ";

/* Performing SQL query */
$result = mysql_query($query) 
   or die("Backlog Award Query failed : " . mysql_error());

$display_form = (isset($submit) && $submit == $SUBMIT_SAVE && isset($errmsg) && strlen($errmsg) > 0) || (!isset($submit) && !isset($errmsg)) || 
                (isset($submit) && $submit == "" && isset($errmsg) && strlen($errmsg) == 0);
?>
<p class="title2" align="center">Backlog</p>
<p align="center"><b><?php echo $sca_name; ?></b></p>
<?php
if (isset($errmsg) && strlen($errmsg) > 0)
{
   echo '<p align="center" style="color:red;font-weight:bold">' . $errmsg . '</p>';
}
if ($display_form)
{
?>
<form action="backlog_award.php" method="post">
<input type="hidden" name="form_atlantian_id" id="form_atlantian_id" value="<?php echo $form_atlantian_id; ?>" />
<?php
}
?>
<table align="center" cellpadding="5" cellspacing="0" border="1" summary="Table listing search results">
   <tr>
      <th class="titleright"><label for="form_branch_id">Home Branch</label></th>
      <td class="data" colspan="3">
<?php 
      if ($display_form)
      {
?>
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
<?php
      }
      else
      {
         echo $form_branch;
      }
?>
      </td>
   <tr>
   </tr>
      <th class="titleright"><label for="form_inactive">Inactive</label></th>
      <td class="data">
<?php 
      if ($display_form)
      {
?>
      <input type="checkbox" name="form_inactive" id="form_inactive" value="1"<?php if (isset($form_inactive) && $form_inactive == 1) { echo ' CHECKED'; }?>>
<?php
      }
      else
      {
         if ($form_inactive == 1)
         {
            echo "Yes";
         }
         else
         {
            echo "No";
         }
      }
?>
      </td>
      <th class="titleright"><label for="form_deceased">Deceased</label></th>
      <td class="data">
<?php 
      if ($display_form)
      {
?>
      <input type="checkbox" name="form_deceased" id="form_deceased" value="1"<?php if (isset($form_deceased) && $form_deceased == 1) { echo ' CHECKED'; }?>>
      &nbsp;
      <b>Date</b> <input type="text" name="form_deceased_date" id="form_deceased_date" size="11" maxlength="10"<?php if (isset($form_deceased_date) && $form_deceased_date != '') { echo " value=\"$form_deceased_date\"";} ?>/>
<?php
      }
      else
      {
         if ($form_deceased == 1)
         {
            echo "Yes";
            if ($form_deceased_date != "")
            {
               echo "&nbsp;      <b>Date</b> " . format_short_date($form_deceased_date);
            }
         }
         else
         {
            echo "No";
         }
      }
?>
      </td>
   </tr>
</table>
<br/>
<p align="center">Awards for <b><?php echo $sca_name; ?></b></p>
<table align="center" cellpadding="5" cellspacing="0" border="1" summary="Table listing search results">
   <tr>
      <th class="title">#</th>
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
         $award_name = $data['award_name'];
         $b1_branch = $data['b1_branch'];
         $b1_id = $data['b1_id'];
         $b1_type = $data['b1_type'];
         $b2_branch = $data['b2_branch'];
         $b2_id = $data['b2_id'];
         $b2_type = $data['b2_type'];

         $award_display = $award_name;
         if ($b1_type != "")
         {
            $award_display .= " ($b1_branch)";
            if ($b1_type != $BT_KINGDOM)
            {
               $award_display .= " (" . get_kingdom($b1_id) . ")";
            }
         }
         else if ($b2_type != "")
         {
            $award_display .= " ($b2_branch)";
            if ($b2_type != $BT_KINGDOM)
            {
               $award_display .= " (" . get_kingdom($b2_id) . ")";
            }
         }

         $award_date = $data['award_date'];
         $scroll_status_id = $data['scroll_status_id'];
         $scroll_status = $data['scroll_status'];
         $scroll_assignees = clean($data['scroll_assignees']);
         $scroll_assigned_date = $data['scroll_assigned_date'];
         $scroll_notes = $data['scroll_notes'];
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
                     "FROM $DBNAME_OP.scroll_status " .
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
      <td class="title" colspan="7"><input name="submit" id="submit" type="submit" value="<?php echo $SUBMIT_SAVE; ?>"/>&nbsp;&nbsp;&nbsp;<input type="reset" value="Reset Form"/></td>
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



