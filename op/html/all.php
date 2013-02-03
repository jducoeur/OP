<?php 
$printable = 1;
$pagewidth = 650;
$datewidth = 50;

$title = "Award Listing - All";
include("header.php");

$link = db_connect();

$recipient_query = "SELECT atlantian_id, sca_name, alternate_names, name_reg_date, blazon, device_reg_date, gender, deceased, revoked, revoked_date " .
                   "FROM $DBNAME_AUTH.atlantian " .
                   "WHERE atlantian_id IN (SELECT DISTINCT atlantian_id FROM $DBNAME_OP.atlantian_award) " .
                   "ORDER BY sca_name";
?>
<p class="title2" align="center">Alphabetical Award Listing - All</p>
<?php 
/* Performing SQL query */
$recipient_result = mysql_query($recipient_query) 
   or die("Recipient Query failed : " . mysql_error());
$num_recipient_result = mysql_num_rows($recipient_result);

if ($num_recipient_result > 0)
{
?>
<table style="table-layout:fixed" border="1" align="center" cellpadding="1" cellspacing="0" summary="Table listing names and devices of award recipients">
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
         $name_reg_date = ' <span style="font-weight:normal">(' . format_short_month_date($name_reg_date) . ')</span>';
      }
      $device_reg_date = $recipient_data['device_reg_date'];
      if (trim($device_reg_date) != "")
      {
         $device_reg_date = ' (' . format_short_month_date($device_reg_date) . ')';
      }
      $preferred_sca_name = get_preferred_sca_name($atlantian_id, $sca_name);

      $link = db_connect();
?>
   <tr>
      <th width="<?php echo $pagewidth; ?>" class="ptitleleft"><?php echo $sca_name . $preferred_sca_name . $name_reg_date . " ($gender) " . $deceased_display . $revoked_display . $alternate_names_display; ?></th>
   </tr>
   <tr>
      <td width="<?php echo $pagewidth; ?>" class="pdata"><?php echo $blazon . $device_reg_date; ?></td>
   </tr>
   <tr>
      <td width="<?php echo $pagewidth; ?>" class="pdatacenter">
      <table style="table-layout:fixed" border="0" align="center" width="100%" cellpadding="1" cellspacing="0" summary="Table listing awards in order of precedence">
<?php
      /* Performing SQL query */
      $award_query = "SELECT award.award_id, award.award_name, award.award_name_male, award.award_name_female, award.type_id, award.award_group_id, " .
                     "atlantian_award.award_date, atlantian_award.sequence, atlantian_award.premier, atlantian_award.retired_date, atlantian_award.resigned_date, atlantian_award.revoked_date, atlantian_award.comments, " .
                     "null AS branch_id, null AS branch, precedence.precedence " .
                     "FROM $DBNAME_OP.award, $DBNAME_OP.atlantian_award, $DBNAME_OP.precedence " .
                     "WHERE award.award_id = atlantian_award.award_id " .
                     "AND award.type_id = precedence.type_id " .
                     "AND atlantian_award.branch_id IS NULL " .
                     "AND award.branch_id IS NULL " .
                     "AND atlantian_award.atlantian_id = $atlantian_id " .
                     "UNION ALL " .
                     "SELECT award.award_id, award.award_name, award.award_name_male, award.award_name_female, award.type_id, award.award_group_id, " .
                     "atlantian_award.award_date, atlantian_award.sequence, atlantian_award.premier, atlantian_award.retired_date, atlantian_award.resigned_date, atlantian_award.revoked_date, atlantian_award.comments, " .
                     "branch.branch_id, branch.branch, precedence.precedence " .
                     "FROM $DBNAME_OP.award, $DBNAME_OP.atlantian_award, $DBNAME_BRANCH.branch, $DBNAME_OP.precedence " .
                     "WHERE award.award_id = atlantian_award.award_id " .
                     "AND award.type_id = precedence.type_id " .
                     "AND atlantian_award.branch_id = branch.branch_id " .
                     "AND award.branch_id IS NULL " .
                     "AND atlantian_award.atlantian_id = $atlantian_id " .
                     "UNION ALL " .
                     "SELECT award.award_id, award.award_name, award.award_name_male, award.award_name_female, award.type_id, award.award_group_id, " .
                     "atlantian_award.award_date, atlantian_award.sequence, atlantian_award.premier, atlantian_award.retired_date, atlantian_award.resigned_date, atlantian_award.revoked_date, atlantian_award.comments, " .
                     "branch.branch_id, branch.branch, precedence.precedence " .
                     "FROM $DBNAME_OP.award, $DBNAME_OP.atlantian_award, $DBNAME_BRANCH.branch, $DBNAME_OP.precedence " .
                     "WHERE award.award_id = atlantian_award.award_id " .
                     "AND award.type_id = precedence.type_id " .
                     "AND award.branch_id = branch.branch_id " .
                     "AND atlantian_award.branch_id IS NULL " .
                     "AND atlantian_award.atlantian_id = $atlantian_id " .
                     //"ORDER BY award_date, sequence ";
                     "ORDER BY precedence, award_date, sequence ";

      $award_result = mysql_query($award_query) 
         or die("Award Query failed : " . mysql_error());

      while ($award_data = mysql_fetch_array($award_result, MYSQL_BOTH))
      {
         $award_id = $award_data['award_id'];
         $award_group_id = $award_data['award_group_id'];
         $award_name = clean($award_data['award_name']);
         $award_name_display = $award_name;
         /*
         if ($gender == $FEMALE)
         {
            $award_name_gender = clean($award_data['award_name_female']);
         }
         else
         {
            $award_name_gender = clean($award_data['award_name_male']);
         }
         $award_name_display = $award_name_gender;
         if ($award_name_gender == "")
         {
            $award_name_display = $award_name;
         }
         */

         $branch = clean($award_data['branch']);
         $branch_id = $award_data['branch_id'];
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
         $rg_display = " ($kingdom)";
         if ($branch != "")
         {
            $rg_display .= " ($branch)";
         }
/*
         $type_id = $award_data['type_id'];
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
*/
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
?>
         <tr>
            <td class="pdataright" width="<?php echo $datewidth; ?>"><?php echo $award_date; ?></td>
            <td class="pdata" width="<?php echo ($pagewidth - $datewidth); ?>"><?php echo $award_name_display . $rg_display; ?></td>
         </tr>
<?php
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
<p align="center" style="font-size:8px">There <?php if ($num_recipient_result == 1) { echo "is 1 award recipient"; } else { echo "are $num_recipient_result award recipients"; } ?>.</p>
<?php 
}
// No awardees
else
{
?>
<p align="center" style="font-size:8px">There are no award recipients.</p>
<?php 
}

/* Free resultset */
mysql_free_result($recipient_result);

/* Closing connection */
db_disconnect($link);

include("footer.php");
?>



