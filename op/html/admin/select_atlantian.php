<?php 
include_once("db.php");

// Only allow authorized users
if ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) || (isset($_SESSION[$BACKLOG_ADMIN]) || $_SESSION[$BACKLOG_ADMIN]))
{
$SUBMIT_SEARCH = "Search Atlantians";
$SUBMIT_SELECT = "Select Atlantian";

$submit = "";
if (isset($_POST['submit']))
{
   $submit = $_POST['submit'];
}

$type = 0;
if (isset($_GET['type']))
{
   $type = $_GET['type'];
}
else if (isset($_POST['type']))
{
   $type = $_POST['type'];
}

$mode = $MODE_ADD;
if (isset($_GET['mode']))
{
   $mode = $_GET['mode'];
}
else if (isset($_POST['mode']))
{
   $mode = $_POST['mode'];
}

if ($type == $TYPE_ATLANTIAN)
{
   $mode = $MODE_EDIT;
}

// Added from court report
$form_court_report_id = 0;
if (isset($_GET['form_court_report_id']))
{
   $form_court_report_id = $_GET['form_court_report_id'];
}
else if (isset($_POST['form_court_report_id']))
{
   $form_court_report_id = $_POST['form_court_report_id'];
}

// Added from event/court report
$form_event_id = 0;
if (isset($_GET['form_event_id']))
{
   $form_event_id = $_GET['form_event_id'];
}
else if (isset($_POST['form_event_id']))
{
   $form_event_id = $_POST['form_event_id'];
}

// Added from merge Atlantian
$first_atlantian_id = 0;
if (isset($_GET['first_atlantian_id']))
{
   $first_atlantian_id = $_GET['first_atlantian_id'];
}
else if (isset($_POST['first_atlantian_id']))
{
   $first_atlantian_id = $_POST['first_atlantian_id'];
}

// Backlog Deputy can only be here for one reason
if ($_SESSION[$BACKLOG_ADMIN] && !$_SESSION[$OP_ADMIN])
{
   $type = $TYPE_BACKLOG;
   $mode = $MODE_EDIT;
}

// Data submitted
if ($submit == $SUBMIT_SELECT)
{
   if (isset($_POST['form_atlantian_id']))
   {
      $form_atlantian_id = clean($_POST['form_atlantian_id']);
      if (!headers_sent($filename, $linenum)) 
      {
         if ($type == $TYPE_ATLANTIAN)
         {
            redirect("edit_ind.php?mode=$MODE_EDIT&atlantian_id=$form_atlantian_id&form_event_id=$form_event_id&form_court_report_id=$form_court_report_id");
         }
         else if ($type == $TYPE_AWARD)
         {
            redirect("edit_ind_award.php?mode=$mode&atlantian_id=$form_atlantian_id&form_event_id=$form_event_id&form_court_report_id=$form_court_report_id");
         }
         else if ($type == $TYPE_BACKLOG)
         {
            redirect("backlog_award.php?atlantian_id=$form_atlantian_id");
         }
         else if ($type == $TYPE_MERGE)
         {
            redirect("merge_people.php?first_atlantian_id=$first_atlantian_id&second_atlantian_id=$form_atlantian_id");
         }
      }
      // Debugging
      else 
      {
         echo "Headers already sent in $filename on line $linenum<br/>" .
              "Cannot redirect; click on the link below:<br/><br/>";
         if ($type == $TYPE_ATLANTIAN)
         {
            echo '<a href="edit_ind.php?mode=' . $MODE_EDIT . '&atlantian_id=' . $form_atlantian_id . '&form_event_id=' . $form_event_id.  '&form_court_report_id=' . $form_court_report_id . '">Continue</a>';
         }
         else if ($type == $TYPE_AWARD)
         {
            echo '<a href="edit_ind_award.php?mode=' . $mode . '&atlantian_id=' . $form_atlantian_id . '&form_event_id=' . $form_event_id.  '&form_court_report_id=' . $form_court_report_id . '">Continue</a>';
         }
         else if ($type == $TYPE_BACKLOG)
         {
            echo '<a href="backlog_award.php?atlantian_id=' . $form_atlantian_id . '">Continue</a>';
         }
         else if ($type == $TYPE_MERGE)
         {
            echo '<a href="merge_people.php?first_atlantian_id=' . $first_atlantian_id . '&second_atlantian_id=' . $form_atlantian_id . '">Continue</a>';
         }
         echo "<br/><br/>";
         echo var_dump(headers_list());
         exit;
      }
   }
   else
   {
      $errmsg2 = "Please select an Atlantian to edit.";
      // Rerun the search
      $submit = $SUBMIT_SEARCH;
   }
}

$link = db_connect();

if ($submit == $SUBMIT_SEARCH)
{
   $form_sca_name = "";
   if (isset($_POST['form_sca_name']))
   {
      $form_sca_name = clean($_POST['form_sca_name']);
   }
   $form_first_name = "";
   if (isset($_POST['form_first_name']))
   {
      $form_first_name = clean($_POST['form_first_name']);
   }
   $form_last_name = "";
   if (isset($_POST['form_last_name']))
   {
      $form_last_name = clean($_POST['form_last_name']);
   }

   $errmsg = "";

   if ($form_sca_name == '' && $form_first_name == '' && $form_last_name == '')
   {
      $errmsg = "Please enter part of an SCA Name, First Name or Last Name on which to search.<br/>";
   }

   if (strlen($errmsg) == 0)
   {
      $query = "SELECT atlantian_id, sca_name, alternate_names, first_name, middle_name, last_name FROM $DBNAME_AUTH.atlantian WHERE ";
      $wc = "";
      if ($form_sca_name != "")
      {
         $wc .= "(atlantian.sca_name LIKE '%" . mysql_real_escape_string($form_sca_name) . "%' " .
                "OR atlantian.alternate_names LIKE '%" . mysql_real_escape_string($form_sca_name) . "%')";
      }
      if ($form_first_name != "")
      {
         if (strlen($wc) > 0)
         {
            $wc .= " AND ";
         }
         $wc .= "(atlantian.first_name LIKE '%" . mysql_real_escape_string($form_first_name) . "%')";
      }
      if ($form_last_name != "")
      {
         if (strlen($wc) > 0)
         {
            $wc .= " AND ";
         }
         $wc .= "(atlantian.last_name LIKE '%" . mysql_real_escape_string($form_last_name) . "%' " .
                "OR atlantian.middle_name LIKE '%" . mysql_real_escape_string($form_last_name) . "%')";
      }
      if ($type == $TYPE_MERGE)
      {
         $wc .= " AND atlantian_id != " . value_or_null($first_atlantian_id);
      }
      $query .= $wc . " ORDER BY atlantian.sca_name";

      /* Performing SQL query */
      $result = mysql_query($query) 
         or die("Search Query failed : " . mysql_error());
   }
}

$title = "Select Atlantian - " . ucfirst($mode);
if ($type == $TYPE_ATLANTIAN || $type == $TYPE_BACKLOG || $type == $TYPE_MERGE)
{
   $title .= " Atlantian";
}
else if ($type == $TYPE_AWARD)
{
   $title .= " Atlantian Award";
}
include("header.php");
?>
<p class="title2" align="center">Search for Atlantians</p>
<?php
if (isset($errmsg) && strlen($errmsg) > 0)
{
   echo '<p align="center" style="color:red;font-weight:bold">' . $errmsg . '</p>';
}
?>
<form action="select_atlantian.php" method="post">
<input type="hidden" name="form_court_report_id" id="form_court_report_id" value="<?php echo $form_court_report_id; ?>"/>
<input type="hidden" name="form_event_id" id="form_event_id" value="<?php echo $form_event_id; ?>"/>
<input type="hidden" name="first_atlantian_id" id="first_atlantian_id" value="<?php echo $first_atlantian_id; ?>"/>
<input type="hidden" name="type" id="type"<?php if (isset($type) && $type != 0) { echo " value=\"$type\"";} ?>/>
<input type="hidden" name="mode" id="mode"<?php if (isset($mode)) { echo " value=\"$mode\"";} ?>/>
<table align="center" border="1" cellpadding="5" cellspacing="0" summary="Search Criteria selection">
   <tr>
      <th colspan="2" class="title">Search Criteria</th>
   </tr>
   <tr>
      <th class="titleright">SCA Name</th>
      <td class="data"><input type="text" name="form_sca_name" id="form_sca_name" size="50"<?php if (isset($form_sca_name) && $form_sca_name != '') { echo " value=\"$form_sca_name\"";} ?>/></td>
   </tr>
   <tr>
      <th class="titleright">Real Name</th>
      <td class="data">
      <b>First</b> <input type="text" name="form_first_name" id="form_first_name" size="25"<?php if (isset($form_first_name) && $form_first_name != '') { echo " value=\"$form_first_name\"";} ?>/>
      &nbsp;&nbsp;&nbsp;
      <b>Last</b> <input type="text" name="form_last_name" id="form_last_name" size="30"<?php if (isset($form_last_name) && $form_last_name != '') { echo " value=\"$form_last_name\"";} ?>/>
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
<form action="select_atlantian.php" method="post">
<input type="hidden" name="form_sca_name" id="form_sca_name"<?php if (isset($form_sca_name) && $form_sca_name != '') { echo " value=\"$form_sca_name\"";} ?>/>
<input type="hidden" name="form_first_name" id="form_first_name"<?php if (isset($form_first_name) && $form_first_name != '') { echo " value=\"$form_first_name\"";} ?>/>
<input type="hidden" name="form_last_name" id="form_last_name"<?php if (isset($form_last_name) && $form_last_name != '') { echo " value=\"$form_last_name\"";} ?>/>
<input type="hidden" name="form_court_report_id" id="form_court_report_id" value="<?php echo $form_court_report_id; ?>"/>
<input type="hidden" name="form_event_id" id="form_event_id" value="<?php echo $form_event_id; ?>"/>
<input type="hidden" name="first_atlantian_id" id="first_atlantian_id" value="<?php echo $first_atlantian_id; ?>"/>
<input type="hidden" name="type" id="type"<?php if (isset($type) && $type != 0) { echo " value=\"$type\"";} ?>/>
<input type="hidden" name="mode" id="mode"<?php if (isset($mode)) { echo " value=\"$mode\"";} ?>/>
<table align="center" cellpadding="5" cellspacing="0" border="1" summary="Table listing search results">
   <tr>
      <th class="title" nowrap="nowrap">Select</th>
      <th class="title" nowrap="nowrap">SCA Name</th>
      <th class="title">Alternate Names</th>
      <th class="title">First Name</th>
      <th class="title">Middle Name</th>
      <th class="title">Last Name</th>
   </tr>
<?php 
      while ($data = mysql_fetch_array($result, MYSQL_BOTH))
      {
         $atlantian_id = $data['atlantian_id'];
         $sca_name = $data['sca_name'];
         $alternate_names = $data['alternate_names'];
         $first_name = $data['first_name'];
         $middle_name = $data['middle_name'];
         $last_name = $data['last_name'];
?>
   <tr>
      <td class="title"><input type="radio" name="form_atlantian_id" id="form_atlantian_id" value="<?php echo $atlantian_id; ?>"/></td>
      <td class="data"><?php echo $sca_name; ?></td>
      <td class="data" nowrap="nowrap"><?php echo $alternate_names; ?></td>
      <td class="data"><?php echo $first_name; ?></td>
      <td class="data"><?php echo $middle_name; ?></td>
      <td class="data"><?php echo $last_name; ?></td>
   </tr>
<?php 
      }
?>
   <tr>
      <th class="title" colspan="6"><input type="submit" name="submit" value="<?php echo $SUBMIT_SELECT; ?>"/></th>
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
<p class="title2">Select Atlantian</p>
<p>You are not authorized to access this page.</p>
<?php
}
include("footer.php");
?>



