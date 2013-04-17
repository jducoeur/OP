<?php
include_once('db/host_defines.php');
require_once('admin/session.php');

$title = "Individual Atlantian Award Information";
include('db/db.php');
include('header.php');

if (isset($_GET['atlantian_id']))
{
$atlantian_id = $_GET['atlantian_id'];

$list_type = "O";
$dir = "ASC";
$dir_param = "&amp;dir=D";
$dir_title = "Ascending";
$order_by = "award_date $dir, sequence $dir";
$order_display = "Awards are listed in the order bestowed.";
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
      $order_by = "award_name $dir";
      if ($dir == "DESC")
      {
         $order_display = "Awards are listed in reverse alphabetical order by Award Name.";
      }
      else
      {
         $order_display = "Awards are listed in alphabetical order by Award Name.";
      }
   }
   else if ($list_type == "O")
   {
      $order_by = "award_date $dir, sequence $dir";
      if ($dir == "DESC")
      {
         $order_display = "Awards are listed in reverse of the order bestowed.";
      }
      else
      {
         $order_display = "Awards are listed in the order bestowed.";
      }
   }
   else if ($list_type == "G")
   {
      $order_by = "branch $dir";
      if ($dir == "DESC")
      {
         $order_display = "Awards are listed in reverse alphabetical order by award location.";
      }
      else
      {
         $order_display = "Awards are listed in alphabetical order by award location.";
      }
   }
   else if ($list_type == "P")
   {
      $order_by = "precedence $dir, award_date $dir, date_founded $dir, sequence $dir";
      if ($dir == "DESC")
      {
         $order_display = "Awards are listed in reverse order of precedence.";
      }
      else
      {
         $order_display = "Awards are listed in order of precedence.";
      }
   }
}

/* Connecting, selecting database */
$link = db_connect();

/* Performing SQL query */
$query = 
      "SELECT atlantian.atlantian_id, atlantian.sca_name, atlantian.alternate_names, atlantian.name_reg_date, atlantian.blazon, atlantian.device_reg_date, atlantian.device_file_name, atlantian.device_file_credit, atlantian.gender, " .
      "atlantian.deceased, atlantian.deceased_date, atlantian.revoked, atlantian.revoked_date, atlantian.branch_id, branch.branch ".
      "FROM $DBNAME_AUTH.atlantian LEFT OUTER JOIN $DBNAME_BRANCH.branch ON atlantian.branch_id = branch.branch_id ".
      "WHERE atlantian_id = ". $atlantian_id;

$result = mysql_query($query) 
   or die("Individual Query failed : " . mysql_error());

/* Printing results in HTML */
while ($data = mysql_fetch_array($result, MYSQL_BOTH)) 
{
   $atlantian_id = $data['atlantian_id'];
   $sca_name = clean($data['sca_name']);
   $alternate_names = clean($data['alternate_names']);
   $name_reg_date = clean($data['name_reg_date']);
   $blazon = clean($data['blazon']);
   $device_reg_date = clean($data['device_reg_date']);
   $device_file_name = clean($data['device_file_name']);
   $device_file_credit = clean($data['device_file_credit']);
   $gender = clean($data['gender']);
   $title = get_current_title($atlantian_id);
   $deceased = clean($data['deceased']);
   $deceased_date = clean($data['deceased_date']);
   $deceased_display = "";
   if ($deceased == 1)
   {
      $deceased_display = " - DECEASED";
      if ($deceased_date != "")
      {
         $deceased_display .= " " . format_short_date($deceased_date);
      }
   }
   $revoked = clean($data['revoked']);
   $revoked_date = clean($data['revoked_date']);
   $revoked_display = "";
   if ($revoked == 1)
   {
      $revoked_display = "<br><br>REVOKED AND DENIED";
      if ($revoked_date != "")
      {
         $revoked_display .= " " . format_short_date($revoked_date);
      }
      $revoked_display .= "<br/>SCA Membership has been revoked.";
   }
   $local_group = clean($data['branch']);
   $local_group_id = $data['branch_id'];
   if ($local_group_id != "" && $local_group_id > 0)
   {
      $kingdom = get_kingdom($local_group_id);
      if ($kingdom != $local_group)
      {
         $local_group .= ", $kingdom";
      }
   }

   $preferred_sca_name = get_preferred_sca_name($atlantian_id, $sca_name);
   $link = db_connect();
?>
<p class="title2" align="center">Individual Atlantian Award Information</p>
<p class="title3" align="center">
<?php echo $title . ' ' . $sca_name . $preferred_sca_name . $deceased_display . $revoked_display; ?>
<br/><br/>
<?php 
   if (trim($alternate_names) != "")
   {
?>
<?php echo "<i>AKA " . $alternate_names . "</i>"; ?>
<br/><br/>
<?php 
   }
   if (trim($local_group) != "")
   {
?>
<?php echo $local_group; ?>
<br/><br/>
<?php 
   }
   if (trim($device_file_name) != "")
   {
?>
<img src="<?php echo $DEVICE_IMAGE_DIR . $device_file_name; ?>" border="0" alt="<?php echo "Device of $sca_name"; ?>"/>
<br/><br/>
<?php
   }
   if ($blazon != NULL)
   {
      echo $blazon . "<br/><br/>";
   }
   if ($name_reg_date != NULL)
   {
      $name_reg_date = format_full_month_date($name_reg_date);
?>
         <i>Name registered with the College of Arms in <?php echo $name_reg_date; ?>.</i>
<br/><br/>
<?php
   }
   if ($device_reg_date != NULL)
   {
      $device_reg_date = format_full_month_date($device_reg_date);
?>
         <i>Device registered with the College of Arms in <?php echo $device_reg_date; ?>.</i>
<br/><br/>
<?php
   }
?>
<img src="<?php echo $IMAGES_DIR; ?>op-divider.gif" width="648" height="41" border="0" alt="OP Line"/>
<?php echo "<br/><br/>" . $order_display; ?>
</p>
<?php 
if ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) || (isset($_SESSION[$BACKLOG_ADMIN]) && $_SESSION[$BACKLOG_ADMIN]))
{
?>
<p align="center">
<img src="<?php echo $IMAGES_DIR; ?>private.gif" width="15" height="15" alt="Marked Private" border="0"/> Lock icon indicates record is marked private.
<br/>
<form action="admin/atlantian.php" method="post">
   <input type="hidden" name="form_atlantian_id" value="<?php echo $atlantian_id; ?>" />
   <input type="hidden" name="mode" value="<?php echo $MODE_EDIT; ?>" />
   <input type="submit" value="Edit Atlantian" />
</form>
<br/>
</p>
<?php 
}
?>
<?php
   /* Performing SQL query */
   $ind_query = 
      "(SELECT DISTINCT award.award_id, award.award_name, award.award_name_male, award.award_name_female, award.type_id, award.award_group_id, " .
      "atlantian_award.award_date, atlantian_award.sequence, atlantian_award.premier, atlantian_award.retired_date, atlantian_award.resigned_date, atlantian_award.revoked_date, atlantian_award.comments, atlantian_award.private, atlantian_award.gender, " .
      "branch.branch, branch.branch_id, precedence.precedence, branch.date_founded, " .
      "court_report.event_id, court_report.reign_id, court_report.principality_id, court_report.baronage_id, baronage.branch_id as barony_id, " .
      "event.event_name, event_loc.branch as event_location, reign.monarchs_display, principality.principality_display, baronage.baronage_display " .
      "FROM $DBNAME_OP.atlantian_award JOIN $DBNAME_OP.award ON atlantian_award.award_id = award.award_id " .
      "JOIN $DBNAME_OP.precedence ON award.type_id = precedence.type_id " .
	  /* This is the key line in the duplications problem, once I simplify things a little. The key is that
	   * the data shouldn't be too aggressive about setting atlantian_award.branch_id: */
      "JOIN $DBNAME_BRANCH.branch ON (award.branch_id = branch.branch_id OR atlantian_award.branch_id = branch.branch_id) " .
      "LEFT OUTER JOIN $DBNAME_OP.court_report ON atlantian_award.court_report_id = court_report.court_report_id " .
      "LEFT OUTER JOIN $DBNAME_OP.event ON court_report.event_id = event.event_id " .
      "LEFT OUTER JOIN $DBNAME_BRANCH.branch event_loc ON event.branch_id = event_loc.branch_id " .
      "LEFT OUTER JOIN $DBNAME_OP.reign ON court_report.reign_id = reign.reign_id " .
      "LEFT OUTER JOIN $DBNAME_OP.principality ON court_report.principality_id = principality.principality_id " .
      "LEFT OUTER JOIN $DBNAME_OP.baronage ON court_report.baronage_id = baronage.baronage_id " .
      "WHERE atlantian_award.atlantian_id = ". $atlantian_id . ") ".
      "UNION DISTINCT ".
      "(SELECT DISTINCT award.award_id, award.award_name, award.award_name_male, award.award_name_female, award.type_id, award.award_group_id, " .
      "atlantian_award.award_date, atlantian_award.sequence, atlantian_award.premier, atlantian_award.retired_date, atlantian_award.resigned_date, atlantian_award.revoked_date, atlantian_award.comments, atlantian_award.private, atlantian_award.gender, " .
      "null AS branch, null AS branch_id, precedence.precedence, " . date("Y-m-d") . " as date_founded, " .
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
      "AND atlantian_award.atlantian_id = " . $atlantian_id . ") ";
   $ind_query .= "ORDER BY " . $order_by;

   $ind_result = mysql_query($ind_query) 
      or die("Individual award query failed : " . mysql_error());

   $num_ind_results = mysql_num_rows($ind_result);
   if ($num_ind_results > 0)
   {
?>
<table align="center" border="1" cellpadding="5" cellspacing="0" summary="Award information for <?php echo $title . ' ' . $sca_name; ?>">
   <tr>
      <th scope="col" class="title" nowrap="nowrap"><a class="th" href="op_ind.php?atlantian_id=<?php echo $atlantian_id; ?>&amp;list_type=O<?php if ($list_type == "O") { echo $dir_param; } ?>" title="Sort by award date">Award Date</a><?php if ($list_type == "O") { echo "&nbsp;<img src=\"" . $IMAGES_DIR . strtolower($dir) . ".gif\" align=\"middle\" border=\"0\" alt=\"" . $dir_title . "\"/>"; } ?></th>
      <!--<th scope="col" class="title" nowrap="nowrap">Kingdom</th>
      <th scope="col" class="title" nowrap="nowrap"><a class="th" href="op_ind.php?atlantian_id=<?php echo $atlantian_id; ?>&amp;list_type=G<?php if ($list_type == "G") { echo $dir_param; } ?>" title="Sort by group name">Group</a><?php if ($list_type == "G") { echo "&nbsp;<img src=\"" . $IMAGES_DIR . strtolower($dir) . ".gif\" align=\"middle\" border=\"0\" alt=\"" . $dir_title . "\"/>"; } ?></th>
      --><th scope="col" class="title" nowrap="nowrap">
      <table border="0" width="100%" cellpadding="5" cellspacing="0" summary="layout">
         <tr>
            <td align="center" width="80%" nowrap="nowrap"><a class="th" href="op_ind.php?atlantian_id=<?php echo $atlantian_id; ?>&amp;list_type=A<?php if ($list_type == "A") { echo $dir_param; } ?>" title="Sort by award name">Award Name</a><?php if ($list_type == "A") { echo "&nbsp;<img src=\"" . $IMAGES_DIR . strtolower($dir) . ".gif\" align=\"middle\" border=\"0\" alt=\"" . $dir_title . "\"/>"; } ?></td>
            <td align="right" width="20%" nowrap="nowrap"><a class="th" href="op_ind.php?atlantian_id=<?php echo $atlantian_id; ?>&amp;list_type=P<?php if ($list_type == "P") { echo $dir_param; } ?>" title="Sort by precedence"><img src="images/herald.gif" height="15" width="15" alt="Heraldic Badge for Precedence sort" border="0" /></a><?php if ($list_type == "P") { echo "&nbsp;<img src=\"" . $IMAGES_DIR . strtolower($dir) . ".gif\" align=\"middle\" border=\"0\" alt=\"" . $dir_title . "\"/>"; } ?></td>
         </tr>
      </table>
      </th>
      <th scope="col" class="title" nowrap="nowrap">Event</th>
      <th scope="col" class="title" nowrap="nowrap">Bestowed By</th>
   </tr>
<?php
      while ($ind_data = mysql_fetch_array($ind_result, MYSQL_BOTH)) 
      {
         $award_id = $ind_data['award_id'];
         $award_group_id = $ind_data['award_group_id'];
         $award_name = clean($ind_data['award_name']);
         $award_name_display = $award_name;
         $type_id = $ind_data['type_id'];
         // Use gender-specific names for applicable awards
         $award_name_gender = "";
         if (is_award_gender_specific($award_id, $award_group_id, $type_id))
         {
            if ($type_id = $RETIRED_BARONAGE || $type_id = $CURRENT_BARONAGE)
            {
               $award_gender = clean($ind_data['gender']);
               if ($award_gender == $FEMALE)
               {
                  $award_name_gender = clean($ind_data['award_name_female']);
               }
               else if ($award_gender == $MALE)
               {
                  $award_name_gender = clean($ind_data['award_name_male']);
               }
            }
            // If we didn't pull gender for territorial baronage, try it on Atlantian's gender
            if ($award_name_gender == "")
            {
               if ($gender == $FEMALE)
               {
                  $award_name_gender = clean($ind_data['award_name_female']);
               }
               else if ($gender == $MALE)
               {
                  $award_name_gender = clean($ind_data['award_name_male']);
               }
            }
            if ($award_name_gender != "")
            {
               $award_name_display = $award_name_gender;
            }
         }
         else
         {
            $award_name_gender = clean($ind_data['award_name_male']);
         }
         if ($award_name_gender != "")
         {
            $award_name_display = $award_name_gender;
         }

         $branch = clean($ind_data['branch']);
         $branch_id = $ind_data['branch_id'];
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
         if ($branch != "&nbsp;")
         {
            $award_name_display .= " (" . $branch . ")";
         }

         $premier = $ind_data['premier'];
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

         $retired_date = $ind_data['retired_date'];
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

         $resigned_date = $ind_data['resigned_date'];
         if (trim($resigned_date) != "")
         {
            $award_name_display .= " - RESIGNED " . format_short_date($resigned_date);
         }

         $revoked_date = $ind_data['revoked_date'];
         if (trim($revoked_date) != "")
         {
            $award_name_display .= " - REVOKED " . format_short_date($revoked_date);
         }

         $comments = clean($ind_data['comments']);
         if ($comments != "")
         {
            $award_name_display .= " ($comments)";
         }

         $award_date = $ind_data['award_date'];
         if (trim($award_date) != "")
         {
            $award_date = format_short_date($award_date);
         }
         else
         {
            $award_date = "<i>Unknown</i>";
         }

         $event_display = clean($ind_data['event_name']);
         if ($event_display != "")
         {
            $event_display = "<a href=\"" . $HOME_DIR . "op_event.php?event_id=" . $ind_data['event_id'] . "\" class=\"td\">" . $event_display . "</a>";
            $event_loc = clean($ind_data['event_location']);
            if ($event_loc != "")
            {
               $event_display .= " (" . $event_loc . ")";
            }
         }
         else if ($kingdom != $KINGDOM_NAME)
         {
            $event_display = "ENA*";
         }
         else
         {
            $event_display = "&nbsp;";
         }

         $bestowers_display = "&nbsp;";
         if ($ind_data['reign_id'] != "")
         {
            $bestowers_display = "<a href=\"" . $HOME_DIR . "awards_by_reign.php?reign_id=" . $ind_data['reign_id'] . "\" class=\"td\">" . clean($ind_data['monarchs_display']) . "</a>";
         }
         else if ($ind_data['baronage_id'] != "")
         {
            $bestowers_display = "<a href=\"" . $HOME_DIR . "awards_by_baronage.php?baronage_id=" . $ind_data['baronage_id'] . "&amp;barony_id=" . $ind_data['barony_id'] . "\" class=\"td\">" . clean($ind_data['baronage_display']) . "</a>";
         }
         else if ($ind_data['principality_id'] != "")
         {
            $bestowers_display = "<a href=\"" . $HOME_DIR . "awards_by_principality.php?principality_id=" . $ind_data['principality_id'] . "\" class=\"td\">" . clean($ind_data['principality_display']) . "</a>";
         }
         else if ($event_display == "ENA*" || $kingdom != "Atlantia")
         {
            $bestowers_display = "BNA*";
         }

         $private = $ind_data['private'];
         if ($private == 0 || ($private == 1 && ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) || (isset($_SESSION[$BACKLOG_ADMIN]) && $_SESSION[$BACKLOG_ADMIN]))))
         {
            $private_display = "";
            if ($private == 1)
            {
               $private_display = "<img src=\"" . $IMAGES_DIR . "private.gif\" width=\"15\" height=\"15\" alt=\"Marked Private\" border=\"0\"/> ";
            }
?>
      <tr>
         <td class="dataright" nowrap="nowrap"><?php echo $private_display . $award_date; ?></td>
         <!--<td class="data" nowrap="nowrap"><?php echo $kingdom; ?></td>
         <td class="data"><?php echo $branch; ?></td>-->
         <td class="data"><?php echo $award_name_display; ?></td>
         <td class="data"><?php echo $event_display; ?></td>
         <td class="data" nowrap="nowrap"><?php echo $bestowers_display; ?></td>
      </tr>
<?php
         }
      }
?>
</table>
<p align="center">There <?php if ($num_ind_results == 1) { echo "is 1 award"; } else { echo "are $num_ind_results awards"; } ?>.</p>
<p align="center"><span class="blurb">* ENA = Event Not Atlantian - Only events where Atlantian royalty bestowed awards are tracked in the Atlantian OP.<br/>
* BNA = Bestowed By Not Atlantian - Only when awards are bestowed by Atlantian royalty is that information tracked in the Atlantian OP.</span></p>
<?php 
   }
   else
   {
?>
<p align="center">There are no awards to display.</p>
<?php 
   }
   /* Free individual resultset */
   mysql_free_result($ind_result);
}
if (trim($device_file_name) != "")
{
?>
<p align="center" class="blurb1">
<?php 
   if (trim($device_file_credit) != "")
   {
?>
   Device image courtesy of <?php echo $device_file_credit; ?>.<br/><br/>
<?php 
   }
?>
Device images are the property of their creators and are used here with permission.  
For information on using device images from this website, please contact the 
Clerk of Precedence (<a href="<?php echo $HOME_DIR; ?>functions/mailto.php?u=op&amp;d=atlantia.sca.org" target="redir">op AT atlantia.sca.org</a>), 
who will assist you in contacting the original creator of the piece. Please respect the legal rights of our contributors.
</p>
<?php 
}
/* Free resultset */
mysql_free_result($result);

/* Closing connection */
db_disconnect($link);
} // atlantian_id set
include('footer.php'); 
?>
