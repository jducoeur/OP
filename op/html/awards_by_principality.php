<?php 
include_once("db/host_defines.php");
include_once("admin/session.php");

$principality_id = 0;
if (isset($_GET['principality_id']))
{
   $principality_id = $_GET['principality_id'];
}
$title = "Awards by Principality";
include("header.php");

$link = db_connect();

$principality_query = "SELECT principality_id, principality_end_date FROM $DBNAME_OP.principality WHERE principality_start_date IN (SELECT MAX(principality_start_date) FROM $DBNAME_OP.principality)";
/* Performing SQL query */
$principality_result = mysql_query($principality_query) 
   or die("Principality ID Query failed : " . mysql_error());
$principality_data = mysql_fetch_array($principality_result, MYSQL_BOTH);
$max_principality_id = $principality_data['principality_id'];
$max_principality_date = $principality_data['principality_end_date'];

// Get current principality if no principality or invalid principality specified
if ($principality_id == 0 || $principality_id > $max_principality_id)
{
   $principality_id = $max_principality_id;
}

// Get information on the selected principality
$query = "SELECT prince.sca_name AS prince, princess.sca_name AS princess, principality.prince_id, principality.princess_id, principality.principality_display, " .
         "principality.principality_start_date, principality.principality_start_sequence " .
         "FROM $DBNAME_AUTH.atlantian prince, $DBNAME_AUTH.atlantian princess, $DBNAME_OP.principality " .
         "WHERE prince.atlantian_id = principality.prince_id " .
         "AND princess.atlantian_id = principality.princess_id " .
         "AND principality.principality_id = $principality_id";

/* Performing SQL query */
$result = mysql_query($query) 
   or die("Principality Query failed : " . mysql_error());

$data = mysql_fetch_array($result, MYSQL_BOTH);
$prince = $data['prince'];
$princess = $data['princess'];
$prince_id = $data['prince_id'];
$princess_id = $data['princess_id'];
$investiture_date = $data['principality_start_date'];
$start_sequence = $data['principality_start_sequence'];
$principality_display = $data['principality_display'];

// Get end of principality information from the next principality
$next_query = "SELECT principality_id, principality_start_date, principality_start_sequence " .
              "FROM $DBNAME_OP.principality " .
              "WHERE principality_start_date > " . value_or_null(format_mysql_date($investiture_date)) . " " .
              "ORDER BY principality_start_date";

/* Performing SQL query */
$next_result = mysql_query($next_query) 
   or die("Next Principality Query failed : " . mysql_error());
$num_post_principalities = mysql_num_rows($next_result);
// First record contains next principality
if ($num_post_principalities > 0)
{
   $next_data = mysql_fetch_array($next_result, MYSQL_BOTH);
   $next_principality_id = $next_data['principality_id'];
   $next_investiture_date = $next_data['principality_start_date'];
   $next_start_sequence = $next_data['principality_start_sequence'];
}
// This is the last principality - use dummy values
else
{
   $next_principality_id = 0;
   $next_investiture_date = $max_principality_date;
   $next_start_sequence = 100;
}

$principality_start_date_clause = 
   "AND (atlantian_award.award_date > " . value_or_null(format_mysql_date($investiture_date)) . " OR (atlantian_award.award_date = " . value_or_null(format_mysql_date($investiture_date)) . " AND atlantian_award.sequence > $start_sequence)) ";
$principality_end_date_clause = 
   "AND (atlantian_award.award_date < " . value_or_null(format_mysql_date($next_investiture_date)) . " OR (atlantian_award.award_date = " . value_or_null(format_mysql_date($next_investiture_date)) . " AND atlantian_award.sequence < $next_start_sequence)) ";
if ($start_sequence == 0)
{
   $principality_start_date_clause = "AND (atlantian_award.award_date >= " . value_or_null(format_mysql_date($investiture_date)) . ") ";
}
if ($next_principality_id > 0 && $next_start_sequence == 0)
{
   $principality_end_date_clause = "AND (atlantian_award.award_date <= " . value_or_null(format_mysql_date($next_investiture_date)) . ") ";
}
// Award list query
$award_query =
   "SELECT atlantian.atlantian_id, atlantian.sca_name, atlantian.gender, atlantian.first_name, atlantian.last_name, " .
   "award.award_name, award.award_name_male, award.award_name_female, award.award_id, award.award_group_id, award.type_id, " .
   "branch.branch, atlantian_award.award_date, atlantian_award.sequence, atlantian_award.private, atlantian_award.gender AS award_gender, " .
   "event.event_id, event.event_name, event_loc.branch as location, court_report.reign_id, court_report.principality_id " .
   "FROM $DBNAME_AUTH.atlantian JOIN $DBNAME_OP.atlantian_award ON atlantian.atlantian_id = atlantian_award.atlantian_id " .
   "JOIN $DBNAME_OP.award ON atlantian_award.award_id = award.award_id " .
   "JOIN $DBNAME_BRANCH.branch ON award.branch_id = branch.branch_id " .
   "LEFT OUTER JOIN $DBNAME_OP.event ON atlantian_award.event_id = event.event_id " .
   "LEFT OUTER JOIN $DBNAME_BRANCH.branch event_loc ON event.branch_id = event_loc.branch_id " .
   "LEFT OUTER JOIN $DBNAME_OP.court_report ON atlantian_award.court_report_id = court_report.court_report_id " .
   "WHERE award.type_id IN (SELECT type_id FROM $DBNAME_OP.precedence WHERE precedence NOT IN ($BARONIAL_AWARD_P)) " . 
   $principality_start_date_clause . $principality_end_date_clause .
   "AND branch.is_atlantian = 1 " .
   "UNION ALL " .
   "SELECT atlantian.atlantian_id, atlantian.sca_name, atlantian.gender, atlantian.first_name, atlantian.last_name, " .
   "award.award_name, award.award_name_male, award.award_name_female, award.award_id, award.award_group_id, award.type_id, " .
   "branch.branch, atlantian_award.award_date, atlantian_award.sequence, atlantian_award.private, atlantian_award.gender AS award_gender, " .
   "event.event_id, event.event_name, event_loc.branch as location, court_report.reign_id, court_report.principality_id " .
   "FROM $DBNAME_AUTH.atlantian JOIN $DBNAME_OP.atlantian_award ON atlantian.atlantian_id = atlantian_award.atlantian_id " .
   "JOIN $DBNAME_OP.award ON atlantian_award.award_id = award.award_id " .
   "JOIN $DBNAME_BRANCH.branch ON atlantian_award.branch_id = branch.branch_id " .
   "LEFT OUTER JOIN $DBNAME_OP.event ON atlantian_award.event_id = event.event_id " .
   "LEFT OUTER JOIN $DBNAME_BRANCH.branch event_loc ON event.branch_id = event_loc.branch_id " .
   "LEFT OUTER JOIN $DBNAME_OP.court_report ON atlantian_award.court_report_id = court_report.court_report_id " .
   "WHERE award.type_id IN (SELECT type_id FROM $DBNAME_OP.precedence WHERE precedence NOT IN ($BARONIAL_AWARD_P)) " .
   $principality_start_date_clause . $principality_end_date_clause .
   "AND branch.is_atlantian = 1 " .
   "ORDER BY award_date, event_id, sequence, sca_name";

/* Performing SQL query */
$award_result = mysql_query($award_query) 
   or die("Award Query failed : " . mysql_error());
?>
<p class="title2" align="center">Awards by Principality<br/><br/><?php echo $principality_display; ?><br/><?php echo format_sca_date($investiture_date) . " - " . format_sca_date($next_investiture_date); ?></p>
<p align="center">
<img src="images/atlantia.gif" width="97" height="118" alt="Arms of Atlantia" border="0"/>
<br/><br/>
<?php
if (!$printable)
{
   if ($principality_id > 1)
   {
      $prev_principality_id = $principality_id - 1;
?>
<a href="awards_by_principality.php?principality_id=<?php echo $prev_principality_id; ?>">&lt;&lt; Previous Coronets</a>
<?php 
   }
   if ($principality_id > 1 && ($next_principality_id > 0 || $principality_id == $max_principality_id))
   {
?>
&nbsp;&nbsp;&nbsp;
<?php 
   }
   if ($next_principality_id > 0)
   {
?>
<a href="awards_by_principality.php?principality_id=<?php echo $next_principality_id; ?>">Next Coronets &gt;&gt;</a>
<?php 
   }
   if ($principality_id == $max_principality_id)
   {
?>
<a href="awards_by_reign.php?reign_id=1">Next Reign &gt;&gt;</a>
<?php 
   }
?>
<br/><br/>
<?php 
}
?>
Awards bestowed during this principality in the order bestowed, grouped by event.
<br/><br/>
<?php 
if ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) || (isset($_SESSION[$BACKLOG_ADMIN]) && $_SESSION[$BACKLOG_ADMIN]))
{
?>
<img src="<?php echo $IMAGES_DIR; ?>private.gif" width="15" height="15" alt="Marked Private" border="0"/> Lock icon indicates record is marked private.
<br/><br/>
<?php 
}
?>
<img src="<?php echo $IMAGES_DIR; ?>op-divider.gif" width="648" height="41" border="0" alt="OP Line"/>
</p>
<table align="center" cellpadding="5" cellspacing="0" border="1" summary="Table listing the awards given during principality reign">
<?php 
      $i = 1;
      $prev_event_id = 0;
      $first_time = 1;
      $num_cols = 5;
      if ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) || (isset($_SESSION[$BACKLOG_ADMIN]) && $_SESSION[$BACKLOG_ADMIN]))
      {
         $num_cols = 7;
      }
      while ($award_data = mysql_fetch_array($award_result, MYSQL_BOTH))
      {
         $event_id = $award_data['event_id'];
         if ((($event_id == null || $event_id == '') && $first_time == 1) || 
             (($event_id != null && $event_id != '' && $event_id > 0) && $event_id != $prev_event_id))
         {
            if ($event_id != null && $event_id != '' && $event_id > 0)
            {
               $event_name = clean($award_data['event_name']);
               $event_display = "<a href=\"" . $HOME_DIR . "op_event.php?event_id=" . $award_data['event_id'] . "\" class=\"th\">" . $event_name . "</a>";
               $event_loc = clean($award_data['location']);
               $prev_event_id = $event_id;
               $first_time = 1; // Print name headers again after this event is done
?>
   <tr>
      <th class="title" colspan="<?php echo $num_cols; ?>"><?php echo $event_display . " (" . $event_loc . ")"; ?></th>
   </tr>
<?php 
            }
            else
            {
               $first_time = 0;
            }
?>
   <tr>
      <th class="title">#</th>
      <th class="title" nowrap="nowrap">Recipient</th>
<?php 
            if ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) || (isset($_SESSION[$BACKLOG_ADMIN]) && $_SESSION[$BACKLOG_ADMIN]))
            {
?>
      <th class="title" nowrap="nowrap">Real Name</th>
<?php 
            }
?>
      <th class="title">Award</th>
      <th class="title">Group</th>
      <th class="title">Date</th>
<?php 
            if ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) || (isset($_SESSION[$BACKLOG_ADMIN]) && $_SESSION[$BACKLOG_ADMIN]))
            {
?>
      <th class="title">Sequence</th>
<?php 
            }
?>
   </tr>
<?php
         }
         $sca_name = clean($award_data['sca_name']);
         $name_display = $sca_name;
         if (!$printable)
         {
            $atlantian_id = clean($award_data['atlantian_id']);
            $name_display = "<a href=\"op_ind.php?atlantian_id=$atlantian_id\" class=\"td\">$sca_name</a>";
         }
         $gender = $award_data['gender'];
         $first_name = clean($award_data['first_name']);
         $last_name = clean($award_data['last_name']);
         $award_name = clean($award_data['award_name']);
         $award_name_display = $award_name;
         $award_id = clean($award_data['award_id']);
         $award_group_id = clean($award_data['award_group_id']);
         $type_id = clean($award_data['type_id']);
         // Use gender-specific names for applicable awards
         $award_name_gender = "";
         if (is_award_gender_specific($award_id, $award_group_id, $type_id))
         {
            if ($type_id = $RETIRED_BARONAGE || $type_id = $CURRENT_BARONAGE)
            {
               $award_gender = clean($award_data['award_gender']);
               if ($award_gender == $FEMALE)
               {
                  $award_name_gender = clean($award_data['award_name_female']);
               }
               else if ($award_gender == $MALE)
               {
                  $award_name_gender = clean($award_data['award_name_male']);
               }
            }
            // If we didn't pull gender for territorial baronage, try it on Atlantian's gender
            if ($award_name_gender == "")
            {
               if ($gender == $FEMALE)
               {
                  $award_name_gender = clean($award_data['award_name_female']);
               }
               else if ($gender == $MALE)
               {
                  $award_name_gender = clean($award_data['award_name_male']);
               }
            }
            if ($award_name_gender != "")
            {
               $award_name_display = $award_name_gender;
            }
         }
         else
         {
            $award_name_gender = clean($award_data['award_name_male']);
         }
         if ($award_name_gender != "")
         {
            $award_name_display = $award_name_gender;
         }
         if (!$printable)
         {
            if (is_award_linkable($award_id, $award_group_id, $type_id, $ATLANTIA_NAME))
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
         }
         // Display group for territorial head of subgroup (Barony or Principality)
         $branch = clean($award_data['branch']);
         if ($type_id == $LANDED_BARONAGE || $type_id == $RETIRED_BARONAGE || $type_id == $VISCOUNTY)
         {
            $award_name_display .= " ($branch)";
         }
         $award_date = $award_data['award_date'];
         $sequence = $award_data['sequence'];
         $award_principality_id = $award_data['principality_id'];
         $award_reign_id = $award_data['reign_id'];
         // Only display awards that are definitely not from another reign
         if (!(($award_reign_id != "" || ($award_principality_id != "" && $award_principality_id != $principality_id)) && ($award_date == $investiture_date || $award_date == $next_investiture_date)))
         {
            $data_prepend = "";
            if ($award_date == $investiture_date && $start_sequence == 0 && $award_principality_id == "")
            {
               $data_prepend = "* ";
            }
            if ($award_date == $next_investiture_date && ($next_start_sequence == 0 || $principality_id == $max_principality_id) && $award_principality_id == "")
            {
               $data_prepend = "+ ";
            }

            $private = $award_data['private'];
            if ($private == 0 || ($private == 1 && ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) || (isset($_SESSION[$BACKLOG_ADMIN]) && $_SESSION[$BACKLOG_ADMIN]))))
            {
               $private_display = "";
               if ($private == 1)
               {
                  $private_display = "<img src=\"" . $IMAGES_DIR . "private.gif\" width=\"15\" height=\"15\" alt=\"Marked Private\" border=\"0\"/> ";
               }
?>
   <tr>
      <td class="dataright"><?php echo $data_prepend . $i++; ?></td>
      <td class="data"><?php echo $private_display . $name_display; ?></td>
<?php 
               if ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) || (isset($_SESSION[$BACKLOG_ADMIN]) && $_SESSION[$BACKLOG_ADMIN]))
               {
?>
      <td class="data"><?php echo $first_name . " " . $last_name . " ($gender)"; ?></td>
<?php 
               }
?>
      <td class="data"><?php echo $award_name_display; ?></td>
      <td class="data"><?php echo $branch; ?></td>
      <td class="datacenter" nowrap="nowrap"><?php echo format_short_date($award_date); ?></td>
<?php 
               if ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) || (isset($_SESSION[$BACKLOG_ADMIN]) && $_SESSION[$BACKLOG_ADMIN]))
               {
?>
      <td class="dataright"><?php echo $sequence; ?></td>
<?php 
               }
?>
   </tr>
<?php 
            }
         } // Award is or may be from this reign
      }
?>
</table>
<p align="center">* Items on Investiture date may be from previous principality<br/>+ Items on <?php if ($principality_id == $max_principality_id) { ?>Coronation date may be from next reign<?php } else { ?>Investiture date may be from next principality<?php } ?></p>
<?php 
/* Free resultset */
mysql_free_result($result);

/* Closing connection */
db_disconnect($link);

include("footer.php");
?>



