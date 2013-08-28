<?php 
include_once('db/host_defines.php');
require_once('admin/session.php');

$title = "Search";
include("header.php");

$link = db_connect();

// Pick Lists
// Awards
$award_pl_query = "SELECT award.award_id, award.award_name, award.branch_id, branch.branch " .
                  "FROM $DBNAME_OP.precedence JOIN $DBNAME_OP.award ON precedence.type_id = award.type_id " .
                  "LEFT OUTER JOIN $DBNAME_BRANCH.branch ON award.branch_id = branch.branch_id " .
                  "WHERE precedence.precedence >= $DUCAL " .
                  "ORDER BY award.award_name";

/* Performing SQL query */
$award_pl_result = mysql_query($award_pl_query) 
   or die("Award List Query failed : " . mysql_error());

// Home Branchs
$group_pl_query = "SELECT branch.branch_id, branch.branch, branch.incipient, branch_type.branch_type " .
                  "FROM $DBNAME_BRANCH.branch JOIN $DBNAME_BRANCH.branch_type ON branch.branch_type_id = branch_type.branch_type_id " .
                  "ORDER BY branch.branch";

/* Performing SQL query */
$group_pl_result = mysql_query($group_pl_query) 
   or die("Group List Query failed : " . mysql_error());

$SUBMIT_SEARCH = "Search $KINGDOM_ADJ OP";

$list_type = "A";
$award_type = "A";
$dir = "ASC";
$dir_param = "&amp;dir=D";
$dir_title = "Ascending";
$order_by = "atlantian.sca_name $dir";
$order_display = "Recipients are listed in alphabetical order by SCA Name.";

// Data submitted
if (isset($_POST['submit']) && $_POST['submit'] == $SUBMIT_SEARCH)
{
   $form_award_id = "";
   if (isset($_POST['form_award_id']))
   {
      $form_award_id = clean($_POST['form_award_id']);
   }
   $form_branch_id = "";
   if (isset($_POST['form_branch_id']))
   {
      $form_branch_id = clean($_POST['form_branch_id']);
   }
   $form_date_start = clean($_POST['form_date_start']);
   $form_date_end = clean($_POST['form_date_end']);
   $form_sca_name = clean($_POST['form_sca_name']);
   $form_event_name = clean($_POST['form_event_name']);

   $errmsg = "";

   if ($form_sca_name == '' && $form_branch_id == '' && $form_date_start == '' && $form_date_end == '' && $form_award_id == '' && $form_event_name == '')
   {
      $errmsg = "Please enter at least one search parameter.<br/>";
   }

   // Valid dates
   if (($form_date_start != '') && (strtotime($form_date_start) === FALSE))
   {
      $errmsg .= "Please enter a valid date for the Start Date.<br/>";
   }
   if (($form_date_end != '') && (strtotime($form_date_end) === FALSE))
   {
      $errmsg .= "Please enter a valid date for the End Date.<br/>";
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
      if ($list_type == "A")
      {
         $order_by = "atlantian.sca_name $dir";
         if ($dir == "DESC")
         {
            $order_display = "Recipients are listed in reverse alphabetical order by SCA Name.";
         }
         else
         {
            $order_display = "Recipients are listed in alphabetical order by SCA Name.";
         }
      }
      else if ($list_type == "O")
      {
         $order_by = "atlantian_award.award_date $dir, atlantian_award.sequence $dir, atlantian.sca_name $dir";
         if ($dir == "DESC")
         {
            $order_display = "Recipients are listed in reverse of the order bestowed.";
         }
         else
         {
            $order_display = "Recipients are listed in the order bestowed.";
         }
      }
   }

   if (isset($_POST['award_type']))
   {
      $award_type = clean($_POST['award_type']);
   }

   if (strlen($errmsg) == 0)
   {
      $query = "SELECT atlantian.atlantian_id, atlantian.sca_name, atlantian.alternate_names, atlantian.first_name, atlantian.last_name, atlantian.gender, atlantian.deceased, atlantian.deceased_date, " . 
         "award.award_id, award.award_name, award.award_name_male, award.award_name_female, award.type_id, award.award_group_id AS ag_id, award.branch_id, branch.branch, " .
         "atlantian_award.award_date, atlantian_award.sequence, atlantian_award.retired_date, atlantian_award.gender AS award_gender, atlantian_award.premier, atlantian_award.private, atlantian_award.branch_id as award_group_id, award_group.branch as award_group_name, " .
         "event.event_id, event.event_name, event_loc.branch AS event_location " .
         "FROM $DBNAME_AUTH.atlantian JOIN $DBNAME_OP.atlantian_award ON atlantian.atlantian_id = atlantian_award.atlantian_id " .
         "JOIN $DBNAME_OP.award ON atlantian_award.award_id = award.award_id " .
         "JOIN $DBNAME_OP.precedence ON award.type_id = precedence.type_id " .
         "LEFT OUTER JOIN $DBNAME_BRANCH.branch ON award.branch_id = branch.branch_id " .
         "LEFT OUTER JOIN $DBNAME_BRANCH.branch award_group ON atlantian_award.branch_id = award_group.branch_id " .
         "LEFT OUTER JOIN $DBNAME_OP.court_report ON atlantian_award.court_report_id = court_report.court_report_id " .
         "LEFT OUTER JOIN $DBNAME_OP.event ON court_report.event_id = event.event_id " .
         "LEFT OUTER JOIN $DBNAME_BRANCH.branch event_loc ON event.branch_id = event_loc.branch_id ";

         $wc = "WHERE ";
         if ($form_sca_name != '')
         {
            $wc .= "(atlantian.sca_name LIKE '%" . mysql_real_escape_string($form_sca_name) . "%' OR atlantian.alternate_names LIKE '%" . mysql_real_escape_string($form_sca_name) . "%')";
         }
         if ($form_branch_id != '')
         {
            if (strlen($wc) > strlen("WHERE "))
            {
               $wc .= " AND ";
            }
            $wc .= "(atlantian.branch_id = " . value_or_null($form_branch_id) . ")";
         }
         if ($form_award_id != '')
         {
            if (strlen($wc) > strlen("WHERE "))
            {
               $wc .= " AND ";
            }
            $wc .= "award.award_id IN (" . $form_award_id . ")";
         }
         else if ($award_type == "K" || $award_type == "B")
         {
            if (strlen($wc) > strlen("WHERE "))
            {
               $wc .= " AND ";
            }
            if ($award_type == "B")
            {
               $wc .= "precedence.precedence > $UNDER_OP_LEVEL";
            }
            else // if ($award_type == "K")
            {
               $wc .= "precedence.precedence <= $UNDER_OP_LEVEL";
            }
         }
         // Only one date - exact
         if (($form_date_start != '' && $form_date_end == ''))
         {
            if (strlen($wc) > strlen("WHERE "))
            {
               $wc .= " AND ";
            }
            $wc .= "atlantian_award.award_date = " . value_or_null(format_mysql_date($form_date_start));
         }
         if (($form_date_start == '' && $form_date_end != ''))
         {
            if (strlen($wc) > strlen("WHERE "))
            {
               $wc .= " AND ";
            }
            $wc .= "atlantian_award.award_date = " . value_or_null(format_mysql_date($form_date_end));
         }
         if (($form_date_start != '' && $form_date_end != ''))
         {
            if (strlen($wc) > strlen("WHERE "))
            {
               $wc .= " AND ";
            }
            $wc .= "(atlantian_award.award_date >= " . value_or_null(format_mysql_date($form_date_start)) . " AND atlantian_award.award_date <= " . value_or_null(format_mysql_date($form_date_end)) . ")";
         }
         if ($form_event_name != '')
         {
            if (strlen($wc) > strlen("WHERE "))
            {
               $wc .= " AND ";
            }
            $wc .= "(event.event_name LIKE '%" . mysql_real_escape_string($form_event_name) . "%')";
         }

      $query .= $wc . " ORDER BY " . $order_by;
      /* Performing SQL query */
      $result = mysql_query($query) 
         or die("Search Query failed : " . mysql_error());
   }
}
?>
<p class="title2" align="center">Search the Order of Precedence</p>
<?php
if (isset($errmsg) && strlen($errmsg) > 0)
{
   echo '<p align="center" style="color:red;font-weight:bold">' . $errmsg . '</p>';
}
?>
<form action="search.php" method="post">
<table align="center" border="1" cellpadding="5" cellspacing="0" summary="Search Criteria selection">
   <tr>
      <th colspan="2" class="title">Search Criteria</th>
   </tr>
   <tr>
      <th class="titleright"><label for="form_sca_name">SCA Name</label></th>
      <td class="data"><input type="text" name="form_sca_name" id="form_sca_name" size="50"<?php if (isset($form_sca_name) && $form_sca_name != '') { echo " value=\"$form_sca_name\"";} ?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_branch_id">Home Branch</label></th>
      <td class="data">
      <select name="form_branch_id" id="form_branch_id">
         <option></option>
         <?php
            while ($group_data = mysql_fetch_array($group_pl_result, MYSQL_BOTH))
            {
               $branch_id = $group_data['branch_id'];
               $branch = clean($group_data['branch']);
               $group_display = $branch . ", ";
               $incipient = clean($group_data['incipient']);
               $branch_type = clean($group_data['branch_type']);
               if ($incipient == 1)
               {
                  $group_display .= "Incipient ";
               }
               $group_display .= $branch_type;
               $kingdom = get_kingdom($branch_id);
               if ($kingdom != $branch)
               {
                  $group_display .= " (" . $kingdom . ")";
               }
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
      <th class="titleright"><label for="form_date_start"><label for="form_date_end">Award Dates</label></label></th>
      <td class="data">
      <span style="font-weight:bold"><label for="form_date_start">Start</label></span> <input type="text" name="form_date_start" id="form_date_start" size="15"<?php if (isset($form_date_start) && $form_date_start != '') { echo " value=\"$form_date_start\"";} ?>/>
      &nbsp;&nbsp;
      <span style="font-weight:bold"><label for="form_date_end">End</label></span> <input type="text" name="form_date_end" id="form_date_end" size="15"<?php if (isset($form_date_end) && $form_date_end != '') { echo " value=\"$form_date_end\"";} ?>/>
      </td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_award_id">Award</label></th>
      <td class="data">
      <select name="form_award_id" id="form_award_id">
         <option></option>
         <?php
            while ($award_data = mysql_fetch_array($award_pl_result, MYSQL_BOTH))
            {
               $award_display = clean($award_data['award_name']);
               $branch_id = $award_data['branch_id'];
               $branch = clean($award_data['branch']);
               if ($branch != '')
               {
                  $group_display = ' (' . $award_data['branch'] . ')';
                  $kingdom = get_kingdom($branch_id);
                  if ($kingdom != $branch)
                  {
                     $group_display = ' (' . $kingdom . ')' . $group_display;
                  }
                  $award_display .= $group_display;
               }
               echo '<option id="' . $award_data['award_id'] . '" value="' . $award_data['award_id'] . '"';
               if (isset($form_award_id) && $form_award_id == $award_data['award_id'])
               {
                  echo ' selected';
               }
               echo '>' . $award_display . '</option>';
            }
         ?>
      </select>
      </td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_event_name">Event Name</label></th>
      <td class="data"><input type="text" name="form_event_name" id="form_event_name" size="50"<?php if (isset($form_event_name) && $form_event_name != '') { echo " value=\"$form_event_name\"";} ?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="list_type">Sort By</label></th>
      <td class="data">
      <input type="radio" name="list_type" id="list_type" value="A"<?php if (isset($list_type) && $list_type == "A") { echo ' checked="checked"';} ?>/><span style="font-weight:bold">SCA Name</span>
      &nbsp;&nbsp;
      <input type="radio" name="list_type" id="list_type" value="O"<?php if (isset($list_type) && $list_type == "O") { echo ' checked="checked"';} ?>/><span style="font-weight:bold">Award Date</span>
      &nbsp;&nbsp;
      <input type="checkbox" name="dir" id="dir" value="DESC"<?php if (isset($dir) && $dir == "DESC") { echo ' checked="checked"';} ?>/><span style="font-weight:bold"><label for="dir">Reverse Order</label></span>
      </td>
   </tr>
   <tr>
      <th class="titleright"><label for="award_type">View</label></th>
      <td class="data">
      <input type="checkbox" name="printable" id="printable" value="1"<?php if (isset($printable) && $printable == 1) { echo ' checked="checked"';} ?>/><span style="font-weight:bold"><label for="printable">Printer-Friendly</label></span>
      &nbsp;&nbsp;
      <input type="radio" name="award_type" id="award_type" value="A"<?php if (isset($award_type) && $award_type == "A") { echo ' checked="checked"';} ?>/><span style="font-weight:bold">All Awards</span>
      &nbsp;&nbsp;
      <input type="radio" name="award_type" id="award_type" value="K"<?php if (isset($award_type) && $award_type == "K") { echo ' checked="checked"';} ?>/><span style="font-weight:bold">Kingdom Awards</span>
      &nbsp;&nbsp;
      <input type="radio" name="award_type" id="award_type" value="B"<?php if (isset($award_type) && $award_type == "B") { echo ' checked="checked"';} ?>/><span style="font-weight:bold">Baronial Awards</span>
      </td>
   </tr>
   <tr>
      <th colspan="2" class="title"><input type="submit" name="submit" value="<?php echo $SUBMIT_SEARCH; ?>"/></th>
   </tr>
</table>
</form>
<p align="center">
<img src="<?php echo $IMAGES_DIR; ?>op-divider.gif" width="648" height="41" border="0" alt="OP Line"/>
</p>
<?php 
if (isset($result) && mysql_num_rows($result) > 0)
{
   echo '<p align="center">' . $order_display . '</p>';
?>
<?php 
   if ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) || (isset($_SESSION[$BACKLOG_ADMIN]) && $_SESSION[$BACKLOG_ADMIN]))
   {
?>
<p align="center">
<img src="<?php echo $IMAGES_DIR; ?>private.gif" width="15" height="15" alt="Marked Private" border="0"/> Lock icon indicates record is marked private.
</p>
<?php 
   }
?>
<table align="center" cellpadding="5" cellspacing="0" border="1" summary="Table listing search results">
   <tr>
      <th class="title" nowrap="nowrap">
      SCA Name<?php if ($list_type == "A") { echo "&nbsp;<img src=\"" . $IMAGES_DIR . strtolower($dir) . ".gif\" align=\"middle\" border=\"0\" alt=\"" . $dir_title . "\"/>"; } ?>
      </th>
      <th class="title">Award</th>
      <th class="title">
      Award Date<?php if ($list_type == "O") { echo "&nbsp;<img src=\"" . $IMAGES_DIR . strtolower($dir) . ".gif\" align=\"middle\" border=\"0\" alt=\"" . $dir_title . "\"/>"; } ?>
      </th>
<?php 
   if ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) || (isset($_SESSION[$BACKLOG_ADMIN]) && $_SESSION[$BACKLOG_ADMIN]))
   {
?>
      <th class="title">Sequence</th>
<?php 
   }
?>
      <th class="title">Event</th>
   </tr>
<?php 
      while ($data = mysql_fetch_array($result, MYSQL_BOTH))
      {
         $atlantian_id = $data['atlantian_id'];
         $sca_name = clean($data['sca_name']);
         $alternate_names = clean($data['alternate_names']);
         $deceased = $data['deceased'];

         $name_display = "<a href=\"op_ind.php?atlantian_id=$atlantian_id\" class=\"td\">$sca_name</a>";
         if ($deceased == 1)
         {
            $name_display .= " - DECEASED";
         }
         if ($alternate_names != "")
         {
            $name_display .= " <i>[AKA " . $alternate_names . "]</i>";
         }

         $gender = $data['gender'];

         $award_id = $data['award_id'];
         $award_group_id = $data['ag_id'];
         $type_id = $data['type_id'];
         $award_name = clean($data['award_name']);
         $award_name_display = $award_name;
         // Use gender-specific names for applicable awards
         $award_name_gender = "";
         if (is_award_gender_specific($award_id, $award_group_id, $type_id))
         {
            if ($type_id = $RETIRED_BARONAGE || $type_id = $CURRENT_BARONAGE)
            {
               $award_gender = clean($data['award_gender']);
               if ($award_gender == $FEMALE)
               {
                  $award_name_gender = clean($data['award_name_female']);
               }
               else if ($award_gender == $MALE)
               {
                  $award_name_gender = clean($data['award_name_male']);
               }
            }
            // If we didn't pull gender for territorial baronage, try it on Atlantian's gender
            if ($award_name_gender == "")
            {
               if ($gender == $FEMALE)
               {
                  $award_name_gender = clean($data['award_name_female']);
               }
               else if ($gender == $MALE)
               {
                  $award_name_gender = clean($data['award_name_male']);
               }
            }
            if ($award_name_gender != "")
            {
               $award_name_display = $award_name_gender;
            }
         }
         else
         {
            $award_name_gender = clean($data['award_name_male']);
         }
         if ($award_name_gender != "")
         {
            $award_name_display = $award_name_gender;
         }

         $branch = clean($data['branch']);
         $branch_id = $data['branch_id'];
         $award_branch = clean($data['award_group_name']);
         $award_branch_id = $data['award_group_id'];
         $group_display = "";
         if ($branch_id != "" && $branch_id > 0)
         {
            $kingdom = get_kingdom($branch_id);
            if ($kingdom == $branch)
            {
               $branch = "";
            }
            else
            {
               $group_display .= " (" . $branch . ")";
            }
         }
         else if ($award_branch != "" && $award_branch_id > 0)
         {
            $kingdom = get_kingdom($award_branch_id);
            if ($kingdom == $award_branch)
            {
               $award_branch = "";
            }
            else
            {
               $group_display .= " (" . $award_branch . ")";
            }
         }
         else
         {
            $kingdom = "<i>Unknown</i>";
         }
         $group_display = " (" . $kingdom . ")" . $group_display;

         if (is_award_linkable($award_id, $award_group_id, $type_id, $kingdom))
         {
            if ($award_group_id > 0)
            {
               $award_name_display = "<a href=\"" . $HOME_DIR . "op_award.php?award_group_id=" . $award_group_id . "\" class=\"td\">" . $award_name_display . "</a>";
            }
            else
            {
               $award_name_display = "<a href=\"" . $HOME_DIR . "op_award.php?award_id=" . $award_id . "\" class=\"td\">" . $award_name_display . "</a>";
            }
         }

         $award_name_display .= " " . $group_display;

         $premier = $data['premier'];
         if ($premier == 1)
         {
            if ($award_id == $LANDED_BARONAGE_ID || $award_id == $RETIRED_BARONAGE_ID)
            {
               $award_name_display = "Founding " . $award_name_display;
            }
            else
            {
               $award_name_display .= " - Premier";
            }
         }

         $retired_date = $data['retired_date'];
         if (trim($retired_date) != "")
         {
            if ($award_id == $ST_AIDAN)
            {
               $award_name_display .= " - EMERITUS ";
            }
            else
            {
               $award_name_display .= " - RETIRED ";
            }
            $award_name_display .= format_short_date($retired_date);
         }

         $award_date = $data['award_date'];
         if (trim($award_date) != "")
         {
            $award_date = format_short_date($award_date);
         }
         else
         {
            $award_date = "<i>Unknown</i>";
         }
         $sequence = $data['sequence'];

         $event_id = $data['event_id'];
         $event_name = clean($data['event_name']);
         $event_loc = clean($data['event_location']);
         $event_name_display = $event_name;
         if ($event_name_display != "")
         {
            $event_name_display = "<a href=\"op_event.php?event_id=$event_id\" class=\"td\">$event_name_display</a>";
         }
         if ($event_loc != "")
         {
            $event_name_display .= " (" . $event_loc . ")";
         }

         $private = $data['private'];
         if ($private == 0 || ($private == 1 && ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) || (isset($_SESSION[$BACKLOG_ADMIN]) && $_SESSION[$BACKLOG_ADMIN]))))
         {
            $private_display = "";
            if ($private == 1)
            {
               $private_display = "<img src=\"" . $IMAGES_DIR . "private.gif\" width=\"15\" height=\"15\" alt=\"Marked Private\" border=\"0\"/> ";
            }
?>
   <tr>
      <td class="data"><?php echo $private_display . $name_display; ?></td>
      <td class="data"><?php echo $award_name_display; ?></td>
      <td class="data" nowrap="nowrap"><?php echo $award_date; ?></td>
<?php 
if ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) || (isset($_SESSION[$BACKLOG_ADMIN]) && $_SESSION[$BACKLOG_ADMIN]))
{
?>
      <td class="dataright"><?php echo $sequence; ?></td>
<?php 
}
?>
      <td class="data"><?php echo $event_name_display; ?></td>
   </tr>
<?php 
         }
      }
?>
</table>
<p align="center"><?php echo mysql_num_rows($result); ?> records matched your search criteria.</p>
<?php 
   /* Free resultset */
   mysql_free_result($result);
}
// Nothing matched search criteria
else if (isset($errmsg) && $errmsg == '' && isset($result) && mysql_num_rows($result) == 0)
{
?>
<p align="center">No records matched your search criteria.</p>
<?php 
}
/* Free resultset */
mysql_free_result($award_pl_result);

/* Closing connection */
db_disconnect($link);

include("footer.php");
?>



