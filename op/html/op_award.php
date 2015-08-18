<?php 
include_once("db/host_defines.php");
include_once("admin/session.php");

include("header.php");

$award_id = 0;
$award_group_id = 0;
if (isset($_GET['award_id']))
{
   $award_id = $_GET['award_id'];
}
if (isset($_GET['award_group_id']))
{
   $award_group_id = $_GET['award_group_id'];
}

// Default to AoA
if ($award_id == 0  && $award_group_id == 0)
{
   $award_id = $AOA;
}

$list_type = "O";
$dir = "ASC";
$dir_param = "&amp;dir=D";
$dir_title = "Ascending";
$order_by = "atlantian_award.award_date $dir, atlantian_award.sequence $dir";
$order_display = "Recipients are listed in the order bestowed.";
if (isset($_GET['list_type']))
{
   $dir_title = "";
   if (isset($_GET['dir']))
   {
      if ($_GET['dir'] == "D")
      {
         $dir = "DESC";
         $dir_param = "&amp;dir=A";
         $dir_title = "Descending";
      }
   }
   $list_type = $_GET['list_type'];
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
      $order_by = "atlantian_award.award_date $dir, atlantian_award.sequence $dir";
      if ($dir == "DESC")
      {
         $order_display = "Recipients are listed in reverse of the order bestowed.";
      }
      else
      {
         $order_display = "Recipients are listed in the order bestowed.";
      }
   }
   else if ($list_type == "G")
   {
      $order_by = "branch.branch $dir";
      if ($dir == "DESC")
      {
         $order_display = "Recipients are listed in reverse alphabetical order by award location.";
      }
      else
      {
         $order_display = "Recipients are listed in alphabetical order by award location.";
      }
   }
}

$mysqli = db_new_connect();

$award_query = '';
$recipient_query = "SELECT atlantian.atlantian_id, atlantian.sca_name, branch.branch, " .
                   "atlantian_award.award_date, atlantian_award.sequence, atlantian_award.premier, atlantian_award.retired_date, " .
                   "atlantian_award.resigned_date, atlantian_award.revoked_date, atlantian_award.branch_id, atlantian_award.comments, " .
                   "atlantian_award.private, event.event_name, event_loc.branch as event_location, " .
                   "reign.monarchs_display, principality.principality_display, baronage.baronage_display,  " .
                   "court_report.event_id, court_report.reign_id, court_report.principality_id, court_report.baronage_id, baronage.branch_id as barony_id " .
                   "FROM $DBNAME_AUTH.atlantian JOIN $DBNAME_OP.atlantian_award ON atlantian.atlantian_id = atlantian_award.atlantian_id " .
                   "LEFT OUTER JOIN $DBNAME_BRANCH.branch ON atlantian_award.branch_id = branch.branch_id " .
                   "LEFT OUTER JOIN $DBNAME_OP.court_report ON atlantian_award.court_report_id = court_report.court_report_id " .
                   "LEFT OUTER JOIN $DBNAME_OP.event ON court_report.event_id = event.event_id " .
                   "LEFT OUTER JOIN $DBNAME_BRANCH.branch event_loc ON event.branch_id = event_loc.branch_id " .
                   "LEFT OUTER JOIN $DBNAME_OP.reign ON court_report.reign_id = reign.reign_id " .
                   "LEFT OUTER JOIN $DBNAME_OP.principality ON court_report.principality_id = principality.principality_id " .
                   "LEFT OUTER JOIN $DBNAME_OP.baronage ON court_report.baronage_id = baronage.baronage_id";
// Get award info
if ($award_id > 0)
{
   $award_query = "SELECT award_id, award_group_id, type_id, award_name, collective_name, award_file_name, select_branch, award_blurb, closed, website FROM $DBNAME_OP.award WHERE award_id IN (?)"; 
   $recipient_query .= " WHERE atlantian_award.award_id IN (?)"; 
   $query_params = array($award_id);
}
else if ($award_group_id > 0)
{
   $award_query = "SELECT award_id, award_group_id, type_id, award_name, collective_name, award_file_name, select_branch, award_blurb, closed, website FROM $DBNAME_OP.award WHERE award_group_id IN (?)"; 
   $award_group_query = "SELECT award_group_id, award_group_name, collective_name, award_file_name, award_file_name2, award_blurb, website FROM $DBNAME_OP.award_group WHERE award_group_id IN (?)"; 
   $recipient_query .= " WHERE atlantian_award.award_id IN (SELECT award_id FROM $DBNAME_OP.award WHERE award_group_id = ?)"; 
   $query_params = array($award_group_id);
}
$recipient_query .= " ORDER BY " . $order_by;

/* Performing SQL query */
$award_result = mysqli_prepared_query($mysqli, $award_query, "i", $query_params)
   or die("Award Query failed : " . mysqli_error());
$num_award_result = count($award_result);

if ($num_award_result > 0)
{
   $award_data = $award_result[0];
   $award_name = clean($award_data['collective_name']);
   $award_blurb = clean($award_data['award_blurb']);
   $website = clean($award_data['website']);
   $award_image = clean($award_data['award_file_name']);
   $select_branch = $award_data['select_branch'];
   $closed = $award_data['closed'];
   $title = clean($award_name);
   if ($num_award_result > 1 && $award_group_id > 0)
   {
      /* Performing SQL query */
      $award_group_result = mysqli_prepared_query($mysqli, $award_group_query, "i", $query_params)
         or die("Award Group Query failed : " . mysqli_error());
      // If we are a group, overwrite the award info with the group info
      $award_group_data = $award_group_result[0];
      $award_name = clean($award_group_data['collective_name']);
      $award_blurb = clean($award_group_data['award_blurb']);
      $award_image = clean($award_group_data['award_file_name']);
      $website = clean($award_group_data['website']);
   }
   $closed_display = "";
   if ($closed == 1)
   {
      $closed_display = "<br/>CLOSED";
   }
?>
<p class="title2" align="center"><?php echo $award_name . $closed_display; ?></p>
<p align="center">
<?php 
   if (trim($award_image) != "")
   {
?>
<img src="<?php echo $AWARD_IMAGE_DIR . $award_image; ?>" width="130" height="130" border="0" alt="Badge of the <?php echo $award_name; ?>"/>
<?php 
      if (isset($award_image2) && trim($award_image2) != "")
      {
?>
<img src="<?php echo $AWARD_IMAGE_DIR . $award_image2; ?>" width="130" height="130" border="0" alt="Badge of the <?php echo $award_name2; ?>"/>
<?php 
      }
?>
<br/><br/>
<?php 
   }
   if (trim($award_blurb) != "")
   {
      echo $award_blurb . "<br/><br/>"; 
      if (isset($award_blurb2) && trim($award_blurb2) != "")
      {
         echo $award_blurb2 . "<br/><br/>"; 
      }
   }
   if (trim($website) != "")
   {
      echo "Web Site: <a href=\"$website\">$website</a><br/><br/>"; 
   }
   echo $order_display;
?>
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
<?php 
   /* Performing SQL query */
   $recipient_result = mysqli_prepared_query($mysqli, $recipient_query, "i", $query_params)
      or die("Recipient Query failed : " . mysqli_error());
   $num_recipient_result = count($recipient_result);

   if ($num_recipient_result > 0)
   {
?>
<table align="center" cellpadding="5" cellspacing="0" border="1" summary="Table listing award recipients and dates">
   <tr>
      <th scope="col" class="title"><a class="th" href="op_award.php?<?php if ($award_group_id > 0) { ?>award_group_id=<?php echo $award_group_id; } else { ?>award_id=<?php echo $award_id; } ?>&amp;list_type=A<?php if ($list_type == "A") { echo $dir_param; } ?>">SCA Name</a><?php if ($list_type == "A") { echo "&nbsp;<img src=\"" . $IMAGES_DIR . strtolower($dir) . ".gif\" align=\"middle\" border=\"0\" alt=\"" . $dir_title . "\"/>"; } ?></th>
<?php 
      if ($select_branch == 1)
      {
         $group_title = "Kingdom";
         if ($award_id == $VISCOUNTY_ID)
         {
            $group_title = "Principality";
         }
         else if ($award_id == $LANDED_BARONAGE_ID || $award_id == $RETIRED_BARONAGE_ID || $award_group_id == $RETIRED_BARONAGE_GROUP)
         {
            $group_title = "Barony";
         }
?>
      <th scope="col" class="title"><a class="th" href="op_award.php?<?php if ($award_group_id > 0) { ?>award_group_id=<?php echo $award_group_id; } else { ?>award_id=<?php echo $award_id; } ?>&amp;list_type=G<?php if ($list_type == "G") { echo $dir_param; } ?>"><?php echo $group_title; ?></a><?php if ($list_type == "G") { echo "&nbsp;<img src=\"" . $IMAGES_DIR . strtolower($dir) . ".gif\" align=\"middle\" border=\"0\" alt=\"" . $dir_title . "\"/>"; } ?></th></th>
<?php 
      }
?>
      <th scope="col" class="title" nowrap="nowrap"><a class="th" href="op_award.php?<?php if ($award_group_id > 0) { ?>award_group_id=<?php echo $award_group_id; } else { ?>award_id=<?php echo $award_id; } ?>&amp;list_type=O<?php if ($list_type == "O") { echo $dir_param; } ?>">Award Date</a><?php if ($list_type == "O") { echo "&nbsp;<img src=\"" . $IMAGES_DIR . strtolower($dir) . ".gif\" align=\"middle\" border=\"0\" alt=\"" . $dir_title . "\"/>"; } ?></th>
      <th scope="col" class="title" nowrap="nowrap">Event</th>
      <th scope="col" class="title" nowrap="nowrap">Bestowed By</th>
<?php 
      if (false)//$award_group_id == $YEW_BOW_GROUP || $award_id == $SUPPORTERS_ID || $award_id == $AUG || $award_id == $MARINUS_STEWARDS)
      {
?>
      <th scope="col" class="title">Description</th>
<?php 
      }
?>
   </tr>
<?php 
      foreach ($recipient_result as $recipient_data)
      {
         $atlantian_id = $recipient_data['atlantian_id'];
         $sca_name = clean($recipient_data['sca_name']);
         $award_date = clean($recipient_data['award_date']);
         $premier = clean($recipient_data['premier']);
         $retired_date = clean($recipient_data['retired_date']);
         $resigned_date = clean($recipient_data['resigned_date']);
         $revoked_date = clean($recipient_data['revoked_date']);
         $comments = clean($recipient_data['comments']);
         $private = clean($recipient_data['private']);
         $kingdom_display = "";
         if ($select_branch == 1)
         {
            if (trim($recipient_data['branch']) != "")
            {
               $kingdom_display = clean($recipient_data['branch']);
            }
            else
            {
               $kingdom_display = "<i>Unknown</i>";
            }
         }

         $premier_display = "";
         if ($premier == 1)
         {
            if ($award_id == $LANDED_BARONAGE_ID || $award_id == $RETIRED_BARONAGE_ID || $award_group_id == $RETIRED_BARONAGE_GROUP)
            {
               // Get the Barony
               $premier_display = " - <b>Founding</b>";
            }
            else
            {
               $premier_display = " - <b>Premier</b>";
            }
         }

         $retired_display = "";
         if (trim($retired_date) != "")
         {
            if ($award_id == $ST_AIDAN)
            {
               $retired_display .= " - EMERITUS ";
            }
            else
            {
               $retired_display .= " - RETIRED ";
            }
            $retired_display .= format_short_date($retired_date);
         }

         $resigned_display = "";
         if (trim($resigned_date) != "")
         {
            $resigned_display .= " - RESIGNED " . format_short_date($resigned_date);
         }

         $revoked_display = "";
         if (trim($revoked_date) != "")
         {
            $revoked_display .= " - REVOKED " . format_short_date($revoked_date);
         }

         if (trim($award_date) != "")
         {
            $award_date = format_short_date($award_date);
         }
         else
         {
            $award_date = "<i>Unknown</i>";
         }

         $event_display = clean($recipient_data['event_name']);
         if ($event_display != "")
         {
            $event_display = "<a href=\"" . $HOME_DIR . "op_event.php?event_id=" . $recipient_data['event_id'] . "\" class=\"td\">" . $event_display . "</a>";
            $event_loc = clean($recipient_data['event_location']);
            if ($event_loc != "")
            {
               $event_display .= " (" . $event_loc . ")";
            }
         }
         else
         {
            $event_display = "&nbsp;";
         }

         $bestowers_display = "&nbsp;";
         if ($recipient_data['reign_id'] != "")
         {
            $bestowers_display = "<a href=\"" . $HOME_DIR . "awards_by_reign.php?reign_id=" . $recipient_data['reign_id'] . "\" class=\"td\">" . clean($recipient_data['monarchs_display']) . "</a>";
         }
         else if ($recipient_data['baronage_id'] != "")
         {
            $bestowers_display = "<a href=\"" . $HOME_DIR . "awards_by_baronage.php?baronage_id=" . $recipient_data['baronage_id'] . "&amp;barony_id=" . $recipient_data['barony_id'] . "\" class=\"td\">" . clean($recipient_data['baronage_display']) . "</a>";
         }
         else if ($recipient_data['principality_id'] != "")
         {
            $bestowers_display = "<a href=\"" . $HOME_DIR . "awards_by_principality.php?principality_id=" . $recipient_data['principality_id'] . "\" class=\"td\">" . clean($recipient_data['principality_display']) . "</a>";
         }

		 /* This preferred_sca_name() thing takes for-bloody-ever when querying a large order. And it seems very unimportant. For
		  * now, we'll neuter it. Later, reintroduce it as a single mass query instead. -- JduCoeur, 3/4/13 */
         /*$preferred_sca_name = get_preferred_sca_name($atlantian_id, $sca_name);*/
         $preferred_sca_name = "";

         if ($private == 0 || ($private == 1 && ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) || (isset($_SESSION[$BACKLOG_ADMIN]) && $_SESSION[$BACKLOG_ADMIN]))))
         {
            $private_display = "";
            if ($private == 1)
            {
               $private_display = "<img src=\"" . $IMAGES_DIR . "private.gif\" width=\"15\" height=\"15\" alt=\"Marked Private\" border=\"0\"/> ";
            }
?>
   <tr>
      <td class="data"><?php echo $private_display . "<a href=\"op_ind.php?atlantian_id=$atlantian_id\" class=\"td\">$sca_name</a>$preferred_sca_name$premier_display$retired_display$resigned_display$revoked_display"; ?></td>
<?php 
            if ($select_branch == 1)
            {
?>
      <td class="data"><?php echo $kingdom_display; ?></td>
<?php 
            }
?>
      <td class="dataright" nowrap="nowrap"><?php echo $award_date; ?></td>
      <td class="data"><?php echo $event_display; ?></td>
      <td class="data" nowrap="nowrap"><?php echo $bestowers_display; ?></td>
<?php 
            if (false)//$award_group_id == $YEW_BOW_GROUP || $award_id == $SUPPORTERS_ID || $award_id == $AUG || $award_id == $MARINUS_STEWARDS)
            {
?>
      <td class="data"><?php echo $comments; ?></td>
<?php 
            }
?>
   </tr>
<?php 
         }
      }
?>
</table>
<p align="center">There <?php if ($num_recipient_result == 1) { echo "is 1 award recipient"; } else { echo "are $num_recipient_result award recipients"; } ?>.</p>
<?php 
   }
   // No awardees
   else
   {
?>
<p align="center">There are no recipients for this award.</p>
<?php 
   }
}

/* Closing connection */
$mysqli->close();

include("footer.php");
?>



