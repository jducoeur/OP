<?php 
include_once('db/host_defines.php');
require_once('admin/session.php');

if (isset($_GET['ids']))
{
  $ids = explode(',',$_GET['ids']);
  // Validate $ids -- they should all be numeric.
  foreach ($ids as $anid) {
    if (!is_numeric($anid)) {
	  die ("IDs for op_march must be numbers; " . $anid . " is not allowed.");
	}
  }
  $where = "atlantian.atlantian_id IN (" . implode(',', $ids) . ") ";
  $title = "Order of March for selected individuals";
}
else
{
  $letter = "A";
  if (isset($_GET['letter']))
  {
     $letter = $_GET['letter'];
  }
  // TODO: this should be using quote_begins_like(), but we can't include that this high up
  $where = "sca_name LIKE '$letter%'";
  $title = "Order of March for letter $letter";
}

// Default sort -- this display is always sorted by precedence
$list_type = "P";
$order_by = "precedence, award_date, sequence";
$order_display = "Awards are listed in order of precedence.";

include("header.php");

$link = db_connect();

// The Caitlin Number is a mechanism for ranking that Mistress Caitlin Davies popularized: you combine the
// precedence and date of a given award to produce a number. Your rank is your lowest Caitlin Number.
$recipient_query = "SELECT atlantian_id, sca_name, MIN(caitlin_number) as rank, alternate_names, name_reg_date, blazon, device_reg_date, gender, deceased, revoked, revoked_date, device_file_name " .
                   "  FROM (SELECT DISTINCT atlantian.atlantian_id, sca_name, ((precedence.precedence * 1000000) + TO_DAYS(atlantian_award.award_date)) AS caitlin_number, alternate_names, name_reg_date, blazon, device_reg_date, atlantian.gender, deceased, revoked, atlantian.revoked_date, device_file_name " .
                   "    FROM $DBNAME_AUTH.atlantian " .
				   "    JOIN atlantian_award ON atlantian.atlantian_id = atlantian_award.atlantian_id " .
				   "    JOIN award ON award.award_id = atlantian_award.award_id ".
                   "    JOIN precedence ON precedence.type_id = award.type_id ".
                   "    WHERE ($where) " .
				   "  ) AS caitlin_table " .
				   "WHERE caitlin_number IS NOT NULL " .
                   "GROUP BY atlantian_id ".
                   "ORDER BY rank ";
?>
<p class="title2" align="center"><?php echo $title; ?></p>
<p align="center">
Each award listing displays the following information, if available:<br/>
SCA Name and date registered<br/>
Alternate names<br/>
Blazon and date registered<br/>
Awards received (including date, award, event, and awarding royalty)<br/>
<br/>
<?php echo $order_display; ?>
<br/><br/>
<img src="<?php echo $IMAGES_DIR; ?>dev_icon.gif" height="15" width="15" alt="Device icon" /> This icon indicates the recipient has a device image.<br/>
<br/>
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
$recipient_result = mysql_query($recipient_query) 
   or die("Recipient Query failed : " . mysql_error());
$num_recipient_result = mysql_num_rows($recipient_result);

if ($num_recipient_result > 0)
{
?>
<table border="1" align="center" cellpadding="3" cellspacing="0" summary="Table listing names and devices of award recipients">
<?php 
   while ($recipient_data = mysql_fetch_array($recipient_result, MYSQL_BOTH))
   {
      $atlantian_id = $recipient_data['atlantian_id'];
      $sca_name = clean($recipient_data['sca_name']);
      $alternate_names = clean($recipient_data['alternate_names']);
      $alternate_names_display = "";
      if (trim($alternate_names) != "")
      {
         $alternate_names_display = "<br/><span style=\"font-weight:normal\">AKA " . $alternate_names . "</span>";
      }
      $gender = $recipient_data['gender'];
      $deceased = $recipient_data['deceased'];
      $deceased_display = "";
      if ($deceased == 1)
      {
         $deceased_display = " - DECEASED";
      }
      $revoked = $recipient_data['revoked'];
      $revoked_display = "";
      if ($revoked == 1)
      {
         $revoked_display = " - REVOKED AND DENIED ";
         $revoked_date = $recipient_data['revoked_date'];
         if (trim($revoked_date) != "")
         {
            $revoked_display .= format_short_date($revoked_date);
         }
      }
      $blazon = clean($recipient_data['blazon']);
      if (trim($blazon) != "")
      {
         $blazon = '<span style="font-weight:bold">' . $blazon . '</span>';
      }
      else
      {
         $blazon = "<i>No known blazon</i>";
      }
      $name_reg_date = $recipient_data['name_reg_date'];
      if (trim($name_reg_date) != "")
      {
         $name_reg_date = ' <span style="font-weight:normal">(' . format_full_month_date($name_reg_date) . ')</span>';
      }
      $device_reg_date = $recipient_data['device_reg_date'];
      if (trim($device_reg_date) != "")
      {
         $device_reg_date = ' (' . format_full_month_date($device_reg_date) . ')';
      }
      $preferred_sca_name = ""; //get_preferred_sca_name($atlantian_id, $sca_name);

      $has_dev = "";
      $device_file_name = clean($recipient_data['device_file_name']);
      if (strlen(trim($device_file_name)) > 0)
      {
         $has_dev = '<img src="' . $IMAGES_DIR . 'dev_icon.gif" height="15" width="15" alt="Recipient has device image" /> &nbsp;';
      }
      $link = db_connect();
?>
   <tr>
      <th class="titleleft"><?php echo "<a href=\"op_ind.php?atlantian_id=$atlantian_id\" class=\"th\">$sca_name</a>". $preferred_sca_name . $name_reg_date . $deceased_display . $revoked_display . $alternate_names_display; ?></th>
   </tr>
   <tr>
      <td class="data"><?php echo $has_dev . $blazon . $device_reg_date;  ?></td>
   </tr>
   <tr>
      <td class="data" width="100%">
      <table border="0" width="100%" cellpadding="3" cellspacing="0" summary="Table listing awards in order of precedence">
<?php
      /* Performing SQL query */
      $award_query = 
      "(SELECT award.award_id, award.award_name, award.award_name_male, award.award_name_female, award.type_id, award.award_group_id, " .
      "atlantian_award.award_date, atlantian_award.sequence, atlantian_award.premier, atlantian_award.retired_date, atlantian_award.resigned_date, atlantian_award.revoked_date, atlantian_award.gender, atlantian_award.comments, atlantian_award.private, " .
      "branch.branch, branch.branch_id, precedence.precedence, " .
      "court_report.event_id, court_report.reign_id, court_report.principality_id, court_report.baronage_id, baronage.branch_id as barony_id, " .
      "event.event_name, event_loc.branch as event_location, reign.monarchs_display, principality.principality_display, baronage.baronage_display " .
      "FROM $DBNAME_OP.atlantian_award JOIN $DBNAME_OP.award ON atlantian_award.award_id = award.award_id " .
      "JOIN $DBNAME_OP.precedence ON award.type_id = precedence.type_id " .
      "JOIN $DBNAME_BRANCH.branch ON award.branch_id = branch.branch_id " .
      "LEFT OUTER JOIN $DBNAME_OP.court_report ON atlantian_award.court_report_id = court_report.court_report_id " .
      "LEFT OUTER JOIN $DBNAME_OP.event ON court_report.event_id = event.event_id " .
      "LEFT OUTER JOIN $DBNAME_BRANCH.branch event_loc ON event.branch_id = event_loc.branch_id " .
      "LEFT OUTER JOIN $DBNAME_OP.reign ON court_report.reign_id = reign.reign_id " .
      "LEFT OUTER JOIN $DBNAME_OP.principality ON court_report.principality_id = principality.principality_id " .
      "LEFT OUTER JOIN $DBNAME_OP.baronage ON court_report.baronage_id = baronage.baronage_id " .
      "WHERE atlantian_award.atlantian_id = ". $atlantian_id . ") ".
      "UNION ALL ".
      "(SELECT award.award_id, award.award_name, award.award_name_male, award.award_name_female, award.type_id, award.award_group_id, " .
      "atlantian_award.award_date, atlantian_award.sequence, atlantian_award.premier, atlantian_award.retired_date, atlantian_award.resigned_date, atlantian_award.revoked_date, atlantian_award.gender, atlantian_award.comments, atlantian_award.private, " .
      "branch.branch, branch.branch_id, precedence.precedence, " .
      "court_report.event_id, court_report.reign_id, court_report.principality_id, court_report.baronage_id, baronage.branch_id as barony_id, " .
      "event.event_name, event_loc.branch as event_location, reign.monarchs_display, principality.principality_display, baronage.baronage_display " .
      "FROM $DBNAME_OP.atlantian_award JOIN $DBNAME_OP.award ON atlantian_award.award_id = award.award_id " .
      "JOIN $DBNAME_OP.precedence ON award.type_id = precedence.type_id " .
      "JOIN $DBNAME_BRANCH.branch ON atlantian_award.branch_id = branch.branch_id " .
      "LEFT OUTER JOIN $DBNAME_OP.court_report ON atlantian_award.court_report_id = court_report.court_report_id " .
      "LEFT OUTER JOIN $DBNAME_OP.event ON court_report.event_id = event.event_id " .
      "LEFT OUTER JOIN $DBNAME_BRANCH.branch event_loc ON event.branch_id = event_loc.branch_id " .
      "LEFT OUTER JOIN $DBNAME_OP.reign ON court_report.reign_id = reign.reign_id " .
      "LEFT OUTER JOIN $DBNAME_OP.principality ON court_report.principality_id = principality.principality_id " .
      "LEFT OUTER JOIN $DBNAME_OP.baronage ON court_report.baronage_id = baronage.baronage_id " .
      "WHERE atlantian_award.atlantian_id = ". $atlantian_id . ") ".
      "UNION ALL ".
      "(SELECT award.award_id, award.award_name, award.award_name_male, award.award_name_female, award.type_id, award.award_group_id, " .
      "atlantian_award.award_date, atlantian_award.sequence, atlantian_award.premier, atlantian_award.retired_date, atlantian_award.resigned_date, atlantian_award.revoked_date, atlantian_award.gender, atlantian_award.comments, atlantian_award.private, " .
      "null AS branch, null AS branch_id, precedence.precedence, " .
      "court_report.event_id, court_report.reign_id, court_report.principality_id, court_report.baronage_id, baronage.branch_id as barony_id, " .
      "event.event_name, event_loc.branch as event_location, reign.monarchs_display, principality.principality_display, baronage.baronage_display " .
      "FROM $DBNAME_OP.atlantian_award JOIN $DBNAME_OP.award ON atlantian_award.award_id = award.award_id " .
      "JOIN $DBNAME_OP.precedence ON award.type_id = precedence.type_id " .
      "LEFT OUTER JOIN $DBNAME_OP.court_report ON atlantian_award.court_report_id = court_report.court_report_id " .
      "LEFT OUTER JOIN $DBNAME_OP.event ON court_report.event_id = event.event_id " .
      "LEFT OUTER JOIN $DBNAME_BRANCH.branch event_loc ON event.branch_id = event_loc.branch_id " .
      "LEFT OUTER JOIN $DBNAME_OP.reign ON court_report.reign_id = reign.reign_id " .
      "LEFT OUTER JOIN $DBNAME_OP.principality ON court_report.principality_id = principality.principality_id " .
      "LEFT OUTER JOIN $DBNAME_OP.baronage ON court_report.baronage_id = baronage.baronage_id " .
      "WHERE atlantian_award.branch_id IS NULL " .
      "AND award.branch_id IS NULL " .
      "AND atlantian_award.atlantian_id = " . $atlantian_id . ") ".
      "ORDER BY " . $order_by;

      $award_result = mysql_query($award_query) 
         or die("Award Query failed : " . mysql_error());

      while ($award_data = mysql_fetch_array($award_result, MYSQL_BOTH))
      {
         $award_id = $award_data['award_id'];
         $award_group_id = $award_data['award_group_id'];
         $award_name = clean($award_data['award_name']);
         $award_name_display = $award_name;
         $type_id = $award_data['type_id'];
         // Use gender-specific names for applicable awards
         $award_name_gender = "";
         if (is_award_gender_specific($award_id, $award_group_id, $type_id))
         {
            if ($type_id = $RETIRED_BARONAGE || $type_id = $CURRENT_BARONAGE)
            {
               $award_gender = clean($award_data['gender']);
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

         $branch = clean($award_data['branch']);
         $branch_id = $award_data['branch_id'];
         $kingdom = "";
         if ($branch_id != "" && $branch_id > 0)
         {
            $kingdom = get_kingdom($branch_id);
            if ($kingdom == $branch)
            {
               $branch = "";
            }
         }
         else
         {
            $kingdom = "<i>Unknown</i>";
         }

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
         $award_name_display .= " (" . $kingdom . ")";
         if ($branch != "")
         {
            $award_name_display .= " (" . $branch . ")";
         }

         $premier = $award_data['premier'];
         if ($premier == 1)
         {
            if ($award_id == $LANDED_BARONAGE_ID || $award_id == $RETIRED_BARONAGE_ID)
            {
               $award_name_display = "Founding " . $award_name_display;
            }
            else
            {
               $award_name_display .= " - <b>Premier</b>";
            }
         }

         $retired_date = $award_data['retired_date'];
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

         $resigned_date = $award_data['resigned_date'];
         if (trim($resigned_date) != "")
         {
            $award_name_display .= " - RESIGNED " . format_short_date($resigned_date);
         }

         $revoked_date = $award_data['revoked_date'];
         if (trim($revoked_date) != "")
         {
            $award_name_display .= " - REVOKED " . format_short_date($revoked_date);
         }

         $comments = clean($award_data['comments']);
         if ($comments != "")
         {
            $award_name_display .= " ($comments)";
         }

         $award_date = $award_data['award_date'];
         if (trim($award_date) != "")
         {
            $award_date = format_short_date($award_date);
         }
         else
         {
            $award_date = "<i>Unknown</i>";
         }

         $event_display = clean($award_data['event_name']);
         if ($event_display != "")
         {
            $event_display = "<a href=\"" . $HOME_DIR . "op_event.php?event_id=" . $award_data['event_id'] . "\" class=\"td\">" . $event_display . "</a>";
            $event_loc = clean($award_data['event_location']);
            if ($event_loc != "")
            {
               $event_display .= " (" . $event_loc . ")";
            }
         }
         else if ($kingdom != "Atlantia")
         {
            $event_display = "ENA*";
         }
         else
         {
            $event_display = "&nbsp;";
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
         else if ($event_display == "ENA*" || $kingdom != "Atlantia")
         {
            $bestowers_display = "BNA*";
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
            <td class="dataright" width="10%" nowrap="nowrap"><?php echo $private_display . $award_date; ?></td>
            <td class="data" width="35%"><?php echo $award_name_display; ?></td>
            <td class="data" width="40%"><?php echo $event_display; ?></td>
            <td class="data" width="15%" nowrap="nowrap"><?php echo $bestowers_display; ?></td>
         </tr>
<?php
         }
      }
?>
      </table>
      </td>
   </tr>
<?php 
      /* Free resultset */
      mysql_free_result($award_result);
   }
?>
</table>
<p align="center">There <?php if ($num_recipient_result == 1) { echo "is 1 award recipient"; } else { echo "are $num_recipient_result award recipients"; } ?>.</p>
<p align="center"><span class="blurb">* ENA = Event Not Atlantian - Only events where Atlantian royalty bestowed awards are tracked in the Atlantian OP.<br/>
* BNA = Bestowed By Not Atlantian - Only when awards are bestowed by Atlantian royalty is that information tracked in the Atlantian OP.</span></p>
<?php 
}
// No awardees
else
{
?>
<p align="center">There are no award recipients.</p>
<?php 
}

/* Free resultset */
mysql_free_result($recipient_result);

/* Closing connection */
db_disconnect($link);

include("footer.php");
?>



