<?php 
include_once("db/host_defines.php");
include_once("admin/session.php");

$reign_id = 0;
if (isset($_GET['reign_id']))
{
   $reign_id = $_GET['reign_id'];
}
$title = "Awards by Reign";
include("header.php");

$mysqli = db_new_connect();

$reign_query = "SELECT reign_id FROM $DBNAME_OP.reign WHERE reign_start_date IN (SELECT MAX(reign_start_date) FROM $DBNAME_OP.reign)";
/* Performing SQL query */
// No user-specified parameters, so we can do a straight query:
$reign_result = $mysqli->query($reign_query)
  or die("Couldn't get a reign_result");
$max_reign_obj = $reign_result->fetch_object();
$max_reign_id = $max_reign_obj->reign_id;

// Get current reign if no reign or invalid reign specified
if ($reign_id == 0 || $reign_id > $max_reign_id)
{
   $reign_id = $max_reign_id;
}

// Get information on the selected reign
$query = "SELECT king.sca_name AS king, queen.sca_name AS queen, reign.king_id, reign.queen_id, reign.reign_start_date, reign.monarchs_display, reign.reign_start_sequence " .
         "FROM $DBNAME_AUTH.atlantian king, $DBNAME_AUTH.atlantian queen, $DBNAME_OP.reign " .
         "WHERE king.atlantian_id = reign.king_id " .
         "AND queen.atlantian_id = reign.queen_id " .
         "AND reign.reign_id = ?";

/* Performing SQL query */
$data = mysqli_prepared_query($mysqli, $query, "i", array($reign_id))[0]
   or die ("Reign Query failed: " . mysqli_error());

$king = $data['king'];
$queen = $data['queen'];
$king_id = $data['king_id'];
$queen_id = $data['queen_id'];
$coronation_date = $data['reign_start_date'];
$start_sequence = $data['reign_start_sequence'];
$monarchs_display = $data['monarchs_display'];

// Get end of reign information from the next reign
$next_query = "SELECT reign_id, reign_start_date, reign_start_sequence " .
              "FROM $DBNAME_OP.reign " .
              "WHERE reign_start_date > " . sql_date($mysqli, $coronation_date) . " " .
              "ORDER BY reign_start_date";

/* Performing SQL query */
$next_result = $mysqli->query($next_query)
   or die("Next Reign Query failed : " . mysqli_error());
$num_post_reigns = $next_result->num_rows;
// First record contains next reign
if ($num_post_reigns > 0)
{
   $next_data = $next_result->fetch_assoc();
   $next_reign_id = $next_data['reign_id'];
   $next_coronation_date = $next_data['reign_start_date'];
   $next_start_sequence = $next_data['reign_start_sequence'];
}
// This is the current reign - use dummy values
else
{
   $next_reign_id = 0;
   $next_coronation_date = date("Y-m-d");
   $next_start_sequence = 100;
}

$reign_start_date_clause = 
   "AND (atlantian_award.award_date > " . sql_date($mysqli, $coronation_date) . " OR (atlantian_award.award_date = " . sql_date($mysqli, $coronation_date) . " AND atlantian_award.sequence > $start_sequence)) ";
$reign_end_date_clause = 
   "AND (atlantian_award.award_date < " . sql_date($mysqli, $next_coronation_date) . " OR (atlantian_award.award_date = " . sql_date($mysqli, $next_coronation_date) . " AND atlantian_award.sequence < $next_start_sequence)) ";
if ($start_sequence == 0)
{
   $reign_start_date_clause = "AND (atlantian_award.award_date >= " . sql_date($mysqli, $coronation_date) . ") ";
}
if ($next_reign_id > 0 && $next_start_sequence == 0)
{
   $reign_end_date_clause = "AND (atlantian_award.award_date <= " . sql_date($mysqli, $next_coronation_date) . ") ";
}
// Award list query
// TODO: this query works, but is horrible. Is there a reason we are doing it by date instead
// of tracing through the court reports instead?
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
   "WHERE award.type_id IN (SELECT type_id FROM $DBNAME_OP.precedence WHERE precedence NOT IN ($PRINCIPALITY_AWARD_P, $BARONIAL_AWARD_P)) " . 
   $reign_start_date_clause . $reign_end_date_clause .
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
   "WHERE award.type_id IN (SELECT type_id FROM $DBNAME_OP.precedence WHERE precedence NOT IN ($PRINCIPALITY_AWARD_P, $BARONIAL_AWARD_P)) " .
   $reign_start_date_clause . $reign_end_date_clause .
   "ORDER BY award_date, event_id, sequence, sca_name";

/* Performing SQL query */
$award_result = $mysqli->query($award_query) 
   or die("Award Query failed : " . mysqli_error());
?>
<p class="title2" align="center">Awards by Reign<br/><br/><?php echo $monarchs_display; ?><br/><?php echo format_sca_date($coronation_date) . " - " . format_sca_date($next_coronation_date); ?></p>
<p align="center">
<img src="images/east.gif" width="97" height="118" alt="Arms of the East" border="0"/>
<br/><br/>
<?php
if (!$printable)
{
   if ($reign_id > 1)
   {
      $prev_reign_id = $reign_id - 1;
?>
<a href="awards_by_reign.php?reign_id=<?php echo $prev_reign_id; ?>">&lt;&lt; Previous Reign</a>
<?php 
   }
   if ($next_reign_id > 0)
   {
?>
&nbsp;&nbsp;&nbsp;
<a href="awards_by_reign.php?reign_id=<?php echo $next_reign_id; ?>">Next Reign &gt;&gt;</a>
<?php 
   }
?>
<br/><br/>
<?php 
}
?>
Awards bestowed during this reign in the order bestowed, grouped by event.
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
<table align="center" cellpadding="5" cellspacing="0" border="1" summary="Table listing the awards given this reign">
<?php 
      $i = 1;
      $prev_event_id = 0;
      $first_time = 1;
      $num_cols = 5;
      if ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) || (isset($_SESSION[$BACKLOG_ADMIN]) && $_SESSION[$BACKLOG_ADMIN]))
      {
         $num_cols = 7;
      }
      while ($award_data = $award_result->fetch_assoc())
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
      <th class="title">Award</th>
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
         $award_reign_id = $award_data['reign_id'];
         $award_principality_id = $award_data['principality_id'];
         // Only display awards that are definitely not from another reign
         if (!(($award_principality_id != "" || ($award_reign_id != "" && $award_reign_id != $reign_id)) && ($award_date == $coronation_date || $award_date == $next_coronation_date)))
         {
            $data_prepend = "";
            if ($award_date == $coronation_date && $start_sequence == 0 && $award_reign_id == "")
            {
               $data_prepend = "* ";
            }
            if ($award_date == $next_coronation_date && $next_start_sequence == 0 && $award_reign_id == "")
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
			     // Formerly the Real name column
               }
?>
      <td class="data"><?php echo $award_name_display; ?></td>
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
<p align="center">* Items on Coronation date may be from previous <?php if ($reign_id == 1) { ?>principality<?php } else { ?>reign<?php } ?><br/>+ Items on Coronation date may be from next reign</p>
<?php 
/* Closing connection */
$mysqli->close();

include("footer.php");
?>



