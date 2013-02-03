<?php 
include_once("db/host_defines.php");
include_once("admin/session.php");

$event_id = 0;
if (isset($_GET['event_id']))
{
   $event_id = $_GET['event_id'];
}
$title = "Awards by Event";
include("header.php");

$link = db_connect();

// Get information on the selected event
$query = "SELECT e.event_name, e.start_date, e.end_date, r.branch, r.incipient, g.branch_type " .
         "FROM $DBNAME_OP.event e JOIN $DBNAME_BRANCH.branch r ON e.branch_id = r.branch_id " .
         "JOIN $DBNAME_BRANCH.branch_type g ON r.branch_type_id = g.branch_type_id " .
         "WHERE e.event_id = $event_id";

/* Performing SQL query */
$result = mysql_query($query) 
   or die("Event Query failed : " . mysql_error());

$data = mysql_fetch_array($result, MYSQL_BOTH);
$event_name = clean($data['event_name']);
$start_date = $data['start_date'];
$end_date = $data['end_date'];
$host_group = clean($data['branch']);
$incipient = $data['incipient'];
$branch_type = clean($data['branch_type']);

$host_display = $branch_type . " of " . $host_group;
if ($incipient == 1)
{
   $host_group = "Incipient " . $host_group;
}

// Award list query
$award_query =
   "SELECT atlantian.atlantian_id, atlantian.sca_name, atlantian.gender, atlantian.first_name, atlantian.last_name, " .
   "award.award_name, award.award_name_male, award.award_name_female, award.award_id, award.award_group_id, award.type_id, " .
   "branch.branch, branch.branch_id, atlantian_award.award_date, atlantian_award.sequence, atlantian_award.private, atlantian_award.gender AS award_gender, " .
   "court_report.reign_id, court_report.principality_id, court_report.baronage_id, " .
   "reign.monarchs_display, principality.principality_display, baronage.baronage_display, baronage.branch_id as barony_id " .
   "FROM $DBNAME_AUTH.atlantian JOIN $DBNAME_OP.atlantian_award ON atlantian.atlantian_id = atlantian_award.atlantian_id " .
   "JOIN $DBNAME_OP.award ON atlantian_award.award_id = award.award_id " .
   "JOIN $DBNAME_BRANCH.branch ON award.branch_id = branch.branch_id " .
   "JOIN $DBNAME_OP.event ON atlantian_award.event_id = event.event_id " .
   "LEFT OUTER JOIN $DBNAME_OP.court_report ON atlantian_award.court_report_id = court_report.court_report_id " .
   "LEFT OUTER JOIN $DBNAME_OP.reign ON court_report.reign_id = reign.reign_id " .
   "LEFT OUTER JOIN $DBNAME_OP.principality ON court_report.principality_id = principality.principality_id " .
   "LEFT OUTER JOIN $DBNAME_OP.baronage ON court_report.baronage_id = baronage.baronage_id " .
   "WHERE event.event_id = " . value_or_null($event_id) . " " .
   "UNION ALL " .
   "SELECT atlantian.atlantian_id, atlantian.sca_name, atlantian.gender, atlantian.first_name, atlantian.last_name, " .
   "award.award_name, award.award_name_male, award.award_name_female, award.award_id, award.award_group_id, award.type_id, " .
   "branch.branch, branch.branch_id, atlantian_award.award_date, atlantian_award.sequence, atlantian_award.private, atlantian_award.gender AS award_gender, " .
   "court_report.reign_id, court_report.principality_id, court_report.baronage_id, " .
   "reign.monarchs_display, principality.principality_display, baronage.baronage_display, baronage.branch_id as barony_id " .
   "FROM $DBNAME_AUTH.atlantian JOIN $DBNAME_OP.atlantian_award ON atlantian.atlantian_id = atlantian_award.atlantian_id " .
   "JOIN $DBNAME_OP.award ON atlantian_award.award_id = award.award_id " .
   "JOIN $DBNAME_BRANCH.branch ON atlantian_award.branch_id = branch.branch_id " .
   "JOIN $DBNAME_OP.event ON atlantian_award.event_id = event.event_id " .
   "LEFT OUTER JOIN $DBNAME_OP.court_report ON atlantian_award.court_report_id = court_report.court_report_id " .
   "LEFT OUTER JOIN $DBNAME_OP.reign ON court_report.reign_id = reign.reign_id " .
   "LEFT OUTER JOIN $DBNAME_OP.principality ON court_report.principality_id = principality.principality_id " .
   "LEFT OUTER JOIN $DBNAME_OP.baronage ON court_report.baronage_id = baronage.baronage_id " .
   "WHERE event.event_id = " . value_or_null($event_id) . " " .
   "ORDER BY award_date, sequence, sca_name";

/* Performing SQL query */
$award_result = mysql_query($award_query) 
   or die("Award Query failed : " . mysql_error());

$num_award_results = mysql_num_rows($award_result);
?>
<p class="title2" align="center">Awards by Event<br/><br/><?php echo $event_name; ?><br/><?php echo $host_display; ?><br/><?php echo format_sca_date($start_date) . " - " . format_sca_date($end_date); ?></p>
<p align="center">
<img src="images/atlantia.gif" width="97" height="118" alt="Arms of Atlantia" border="0"/>
<br/><br/>
Awards bestowed during this event in the order bestowed.
<br/><br/>
<?php 
if ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) || (isset($_SESSION[$BACKLOG_ADMIN]) && $_SESSION[$BACKLOG_ADMIN]))
{
?>
<img src="<?php echo $IMAGES_DIR; ?>private.gif" width="15" height="15" alt="Marked Private" border="0"/> Lock icon indicates record is marked private.
<br/>
<form action="admin/event.php" method="post">
   <input type="hidden" name="form_event_id" value="<?php echo $event_id; ?>" />
   <input type="hidden" name="mode" value="<?php echo $MODE_EDIT; ?>" />
   <input type="submit" value="Edit Event" />
</form>
<br/>
<br/><br/>
<?php 
}
?>
<img src="<?php echo $IMAGES_DIR; ?>op-divider.gif" width="648" height="41" border="0" alt="OP Line"/>
</p>
<table align="center" cellpadding="5" cellspacing="0" border="1" summary="Table listing the awards given this reign">
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
      <th class="title">Date</th>
      <th class="title">Bestowed By</th>
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
$i = 1;
$num_cols = 5;
if ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) || (isset($_SESSION[$BACKLOG_ADMIN]) && $_SESSION[$BACKLOG_ADMIN]))
{
   $num_cols = 7;
}
while ($award_data = mysql_fetch_array($award_result, MYSQL_BOTH))
{
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

   $branch = clean($award_data['branch']);
   $branch_id = $award_data['branch_id'];
   $kingdom = "";
   if ($branch_id != "" && $branch_id > 0)
   {
      $kingdom = get_kingdom($branch_id);
      if ($kingdom == $branch)
      {
         $branch = "&nbsp;";
      }
   }
   else
   {
      $kingdom = "<i>Unknown</i>";
   }

   $award_name_display .= " (" . $kingdom . ")";
   if ($branch != "&nbsp;")
   {
      $award_name_display .= " (" . $branch . ")";
   }

   $award_date = $award_data['award_date'];
   $sequence = $award_data['sequence'];
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
      <td class="dataright"><?php echo $i++; ?></td>
      <td class="data"><?php echo $private_display . $name_display; ?></td>
<?php 
      if ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) || (isset($_SESSION[$BACKLOG_ADMIN]) && $_SESSION[$BACKLOG_ADMIN]))
      {
?>
      <td class="data"><?php echo $first_name . " " . $last_name . " ($gender)"; ?></td>
<?php 
      }

      $bestowers_display = "&nbsp;";
      if ($award_data['reign_id'] != "")
      {
         $bestowers_display = "<a href=\"" . $HOME_DIR . "awards_by_reign.php?reign_id=" . $award_data['reign_id'] . "\" class=\"td\">" . clean($award_data['monarchs_display']) . "</a>";
      }
      else if ($award_data['baronage_id'] != "")
      {
         $bestowers_display = "<a href=\"" . $HOME_DIR . "awards_by_baronage.php?baronage_id=" . $award_data['baronage_id'] . "&amp;barony_id=" . $award_data['barony_id'] . "\" class=\"td\">" . clean($award_data['baronage_display']) . "</a>";
      }
      else if ($award_data['principality_id'] != "")
      {
         $bestowers_display = "<a href=\"" . $HOME_DIR . "awards_by_principality.php?principality_id=" . $award_data['principality_id'] . "\" class=\"td\">" . clean($award_data['principality_display']) . "</a>";
      }
      else if ($kingdom != "Atlantia")
      {
         $bestowers_display = "BNA*";
      }
?>
      <td class="data"><?php echo $award_name_display; ?></td>
      <td class="datacenter" nowrap="nowrap"><?php echo format_short_date($award_date); ?></td>
      <td class="data"><?php echo $bestowers_display; ?></td>
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
}
?>
</table>
<p align="center">There <?php if ($num_award_results == 1) { echo "is 1 award"; } else { echo "are $num_award_results awards"; } ?>.</p>
<p align="center"><span class="blurb">* BNA = Bestowed By Not Atlantian - Only when awards are bestowed by Atlantian royalty is that information tracked in the Atlantian OP.</span></p>
<?php 
/* Free resultset */
mysql_free_result($result);

/* Closing connection */
db_disconnect($link);

include("footer.php");
?>



