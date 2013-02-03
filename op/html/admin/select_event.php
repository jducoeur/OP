<?php 
include_once("db.php");

// Only allow authorized users
if (isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN])
{
$SUBMIT_SEARCH = "Search Events";
$SUBMIT_SELECT = "Select Event";

$list_type = "N";
$dir = "ASC";
$dir_param = "&amp;dir=D";
$dir_title = "Ascending";
$order_by = "event.event_name $dir";
$order_display = "Events are listed in alphabetical order by Event Name.";

$submit = "";
if (isset($_POST['submit']))
{
   $submit = $_POST['submit'];
}

$type = 0;
if (isset($_REQUEST['type']))
{
   $type = $_REQUEST['type'];
}

$mode = $MODE_ADD;
if (isset($_REQUEST['mode']))
{
   $mode = $_REQUEST['mode'];
}
if ($type == $TYPE_EVENT)
{
   $mode = $MODE_EDIT;
}

$link = db_connect();

// Pick Lists
// Groups
$group_pl_query = "SELECT branch_id, branch, parent_branch_id, incipient, branch.branch_type_id, branch_type " .
                  "FROM $DBNAME_BRANCH.branch, $DBNAME_BRANCH.branch_type " .
                  "WHERE branch.branch_type_id = branch_type.branch_type_id " .
                  "AND (branch_id = $ATLANTIA OR parent_branch_id = $ATLANTIA " .
                  "OR parent_branch_id IN (SELECT branch_id FROM $DBNAME_BRANCH.branch WHERE parent_branch_id = $ATLANTIA))" .
                  "ORDER BY branch";

/* Performing SQL query */
$group_pl_result = mysql_query($group_pl_query) 
   or die("Branch List Query failed : " . mysql_error());

// Data submitted
if ($submit == $SUBMIT_SELECT)
{
   if (isset($_POST['form_event_id']))
   {
      $form_event_id = clean($_POST['form_event_id']);
      if (!headers_sent($filename, $linenum)) 
      {
         if ($type == $TYPE_EVENT)
         {
            redirect("event.php?mode=$MODE_EDIT&event_id=$form_event_id");
         }
         else if ($type == $TYPE_COURT)
         {
            redirect("court_report.php?mode=$mode&event_id=$form_event_id");
         }
      }
      // Debugging
      else 
      {
         echo "Headers already sent in $filename on line $linenum<br/>" .
              "Cannot redirect; click on the link below:<br/><br/>";
         if ($type == $TYPE_EVENT)
         {
            echo '<a href="event.php?mode=' . $MODE_EDIT . '&event_id=' . $form_event_id . '">Continue</a>';
         }
         else if ($type == $TYPE_COURT)
         {
            echo '<a href="court_report.php?mode=' . $mode . '&event_id=' . $form_event_id . '">Continue</a>';
         }
         echo "<br/><br/>";
         echo var_dump(headers_list());
         exit;
      }
   }
   else
   {
      $errmsg2 = "Please select an Event to edit.";
      // Rerun the search
      $submit = $SUBMIT_SEARCH;
   }
}

$link = db_connect();

if ($submit == $SUBMIT_SEARCH)
{
   $form_event_name = "";
   if (isset($_POST['form_event_name']))
   {
      $form_event_name = clean($_POST['form_event_name']);
   }
   $form_branch_id = "";
   if (isset($_POST['form_branch_id']))
   {
      $form_branch_id = clean($_POST['form_branch_id']);
   }
   $form_start_date = "";
   if (isset($_POST['form_start_date']))
   {
      $form_start_date = clean($_POST['form_start_date']);
   }
   $form_end_date = "";
   if (isset($_POST['form_end_date']))
   {
      $form_end_date = clean($_POST['form_end_date']);
   }

   if (isset($_POST['list_type']))
   {
      $dir_title = "";
      if (isset($_POST['dir']))
      {
         if (clean($_POST['dir'] == "DESC"))
         {
            $dir = "DESC";
            $dir_param = "&amp;dir=A";
            $dir_title = "Descending";
         }
      }
      $list_type = clean($_POST['list_type']);
      if ($list_type == "N")
      {
         $order_by = "event.event_name $dir";
         if ($dir == "DESC")
         {
            $order_display = "Events are listed in reverse alphabetical order by Event Name.";
         }
         else
         {
            $order_display = "Events are listed in alphabetical order by Event Name.";
         }
      }
      else if ($list_type == "D")
      {
         $order_by = "event.start_date $dir, event.event_name";
         if ($dir == "DESC")
         {
            $order_display = "Events are listed in reverse of the order held.";
         }
         else
         {
            $order_display = "Events are listed in the order held.";
         }
      }
   }

   $errmsg = "";

   if ($form_event_name == '' && $form_branch_id == '' && $form_start_date == '' && $form_end_date == '')
   {
      $errmsg = "Please enter part of an Event Name, Start Date or End Date, or select a Host Group on which to search.<br/>";
   }

   // Valid dates
   if (($form_start_date != '') && (strtotime($form_start_date) === FALSE))
   {
      $errmsg .= "Please enter a valid date for the Start Date.<br/>";
   }
   if (($form_end_date != '') && (strtotime($form_end_date) === FALSE))
   {
      $errmsg .= "Please enter a valid date for the End Date.<br/>";
   }

   if (strlen($errmsg) == 0)
   {
      $query = "SELECT event_id, event_name, branch, start_date, end_date FROM $DBNAME_OP.event, $DBNAME_BRANCH.branch WHERE event.branch_id = branch.branch_id AND ";
      $wc = "";
      if ($form_event_name != "")
      {
         $wc .= "event.event_name LIKE '%" . mysql_real_escape_string($form_event_name) . "%' ";
      }
      if ($form_branch_id != "")
      {
         if (strlen($wc) > 0)
         {
            $wc .= " AND ";
         }
         $wc .= "event.branch_id = " . $form_branch_id;
      }
      // Only one date - exact
      if (($form_start_date != '' && $form_end_date == ''))
      {
         if (strlen($wc) > 0)
         {
            $wc .= " AND ";
         }
         $wc .= "event.start_date = " . value_or_null(format_mysql_date($form_start_date));
      }
      if (($form_start_date == '' && $form_end_date != ''))
      {
         if (strlen($wc) > 0)
         {
            $wc .= " AND ";
         }
         $wc .= "event.end_date = " . value_or_null(format_mysql_date($form_end_date));
      }
      if (($form_start_date != '' && $form_end_date != ''))
      {
         if (strlen($wc) > 0)
         {
            $wc .= " AND ";
         }
         $wc .= "(event.end_date >= " . value_or_null(format_mysql_date($form_start_date)) . " AND event.start_date <= " . value_or_null(format_mysql_date($form_end_date)) . ")";
      }
      $query .= $wc . " ORDER BY " . $order_by;

      /* Performing SQL query */
      $result = mysql_query($query) 
         or die("Search Query failed : " . mysql_error());
   }
}

$title = "Select Event - " . ucfirst($mode);
if ($type == $TYPE_EVENT)
{
   $title .= " Event";
}
else if ($type == $TYPE_COURT)
{
   $title .= " Event";
}
include("header.php");
?>
<p class="title2" align="center">Search for Events</p>
<?php
if (isset($errmsg) && strlen($errmsg) > 0)
{
   echo '<p align="center" style="color:red;font-weight:bold">' . $errmsg . '</p>';
}
?>
<form action="select_event.php" method="post">
<input type="hidden" name="type" id="type"<?php if (isset($type) && $type != 0) { echo " value=\"$type\"";} ?>/>
<input type="hidden" name="mode" id="mode"<?php if (isset($mode)) { echo " value=\"$mode\"";} ?>/>
<table align="center" border="1" cellpadding="5" cellspacing="0" summary="Search Criteria selection">
   <tr>
      <th colspan="2" class="title">Search Criteria</th>
   </tr>
   <tr>
      <th class="titleright">Event Name</th>
      <td class="data"><input type="text" name="form_event_name" id="form_event_name" size="50"<?php if (isset($form_event_name) && $form_event_name != '') { echo " value=\"$form_event_name\"";} ?>/></td>
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
               $group_display = clean($group_data['branch']) . ", ";
               if ($group_data['incipient'] == 1)
               {
                  $group_display .= 'Incipient ';
               }
               $group_display .= clean($group_data['branch_type']);
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
      <th class="titleright">Event Dates</th>
      <td class="data">
      <b>Between</b> <input type="text" name="form_start_date" id="form_start_date" size="10"<?php if (isset($form_start_date) && $form_start_date != '') { echo " value=\"$form_start_date\"";} ?>/>
      <b>and</b> <input type="text" name="form_end_date" id="form_end_date" size="10"<?php if (isset($form_end_date) && $form_end_date != '') { echo " value=\"$form_end_date\"";} ?>/>
      </td>
   </tr>
   <tr>
      <th class="titleright">Sort By</th>
      <td class="data">
      <input type="radio" name="list_type" id="list_type" value="N"<?php if (isset($list_type) && $list_type == "N") { echo ' checked="checked"';} ?>/><span style="font-weight:bold">Event Name</span>
      &nbsp;&nbsp;
      <input type="radio" name="list_type" id="list_type" value="D"<?php if (isset($list_type) && $list_type == "D") { echo ' checked="checked"';} ?>/><span style="font-weight:bold">Start Date</span>
      &nbsp;&nbsp;
      <input type="checkbox" name="dir" id="dir" value="DESC"<?php if (isset($dir) && $dir == "DESC") { echo ' checked="checked"';} ?>/><span style="font-weight:bold">Reverse Order</span>
      </td>
   </tr>
   <tr>
      <th colspan="2" class="title"><input type="submit" name="submit" value="<?php echo $SUBMIT_SEARCH; ?>"/></th>
   </tr>
</table>
</form>
<?php 
if (isset($result) && mysql_num_rows($result) > 0)
{
?>
<p align="center">
<img src="<?php echo $IMAGES_DIR; ?>op-divider.gif" width="648" height="41" border="0" alt="OP Line"/>
</p>
<?php 
   if (isset($errmsg2) && strlen($errmsg2) > 0)
   {
      echo '<p align="center" style="color:red;font-weight:bold">' . $errmsg2 . '</p>';
   }
?>
<form action="select_event.php" method="post">
<input type="hidden" name="form_event_name" id="form_event_name"<?php if (isset($form_event_name) && $form_event_name != '') { echo " value=\"$form_event_name\"";} ?>/>
<input type="hidden" name="form_start_date" id="form_start_date"<?php if (isset($form_start_date) && $form_start_date != '') { echo " value=\"$form_start_date\"";} ?>/>
<input type="hidden" name="form_end_date" id="form_end_date"<?php if (isset($form_end_date) && $form_end_date != '') { echo " value=\"$form_end_date\"";} ?>/>
<input type="hidden" name="list_type" id="list_type"<?php if (isset($list_type) && $list_type != '') { echo " value=\"$list_type\"";} ?>/>
<input type="hidden" name="dir" id="dir"<?php if (isset($dir) && $dir != '') { echo " value=\"$dir\"";} ?>/>
<input type="hidden" name="type" id="type"<?php if (isset($type) && $type != 0) { echo " value=\"$type\"";} ?>/>
<input type="hidden" name="mode" id="mode"<?php if (isset($mode)) { echo " value=\"$mode\"";} ?>/>
<table align="center" cellpadding="5" cellspacing="0" border="1" summary="Table listing search results">
   <tr>
      <th class="title" nowrap="nowrap">Select</th>
      <th class="title" nowrap="nowrap">Event Name</th>
      <th class="title">Host Branch</th>
      <th class="title">Start Date</th>
      <th class="title">End Date</th>
   </tr>
<?php 
      while ($data = mysql_fetch_array($result, MYSQL_BOTH))
      {
         $event_id = $data['event_id'];
         $event_name = clean($data['event_name']);
         $branch = clean($data['branch']);
         $start_date = $data['start_date'];
         $end_date = $data['end_date'];

?>
   <tr>
      <td class="title"><input type="radio" name="form_event_id" id="form_event_id" value="<?php echo $event_id; ?>"/></td>
      <td class="data"><?php echo $event_name; ?></td>
      <td class="data" nowrap="nowrap"><?php echo $branch; ?></td>
      <td class="data"><?php echo format_short_date($start_date); ?></td>
      <td class="data"><?php echo format_short_date($end_date); ?></td>
   </tr>
<?php 
      }
?>
   <tr>
      <th class="title" colspan="5"><input type="submit" name="submit" value="<?php echo $SUBMIT_SELECT; ?>"/></th>
   </tr>
</table>
</form>
<p align="center"><?php echo mysql_num_rows($result); ?> records matched your search criteria.</p>
<?php 
   /* Free resultset */
   mysql_free_result($result);
}
// Nothing matched search criteria
else if (isset($errmsg) && $errmsg == '' && isset($result) && mysql_num_rows($result) == 0)
{
?>
<p align="center">
<img src="<?php echo $IMAGES_DIR; ?>op-divider.gif" width="648" height="41" border="0" alt="OP Line"/>
</p>
<p align="center">No records matched your search criteria.</p>
<?php 
}
/* Closing connection */
db_disconnect($link);
}
// Not allowed to access page
else
{
include("header.php");
?>
<p class="title2">Select Event</p>
<p>You are not authorized to access this page.</p>
<?php
}
include("footer.php");
?>



