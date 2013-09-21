<?php
$title = "Group Order of Precedence";
include('db/db.php');
include('header.php');

include("disabled.php");

$group_id = 29; // Ponte Alto

if (isset($_GET['group_id']))
{
   $group_id = $_GET['group_id'];
}

/* Connecting, selecting database */
$link = db_connect();

/* Performing SQL query */
$max_query = 
      "SELECT MAX(atlantian_id) FROM $DBNAME_AUTH.atlantian";

$max_result = mysql_query($max_query) 
   or die("Max query failed : " . mysql_error());

$max = mysql_fetch_array($max_result, MYSQL_BOTH);
$num_atlantians = $max[0];

/* Performing SQL query */
$group_query = "SELECT branch.branch, branch_type.branch_type, branch.incipient " .
               "FROM $DBNAME_BRANCH.branch, $DBNAME_BRANCH.branch_type " .
               "WHERE branch.branch_type_id = branch_type.branch_type_id " .
               "AND branch.branch_id = $group_id";

$group_result = mysql_query($group_query) 
   or die("Group query failed : " . mysql_error());

$group_data = mysql_fetch_array($group_result, MYSQL_BOTH);
$branch_name = clean($group_data['branch_type']) . ' of ' . clean($group_data['branch']);
if ($group_data['incipient'] == 1)
{
   $branch_name = "Incipient $branch_name";
}

// No Atlantians printed yet
$printedArray = array_fill(1, $num_atlantians, 0);

/* Performing SQL query */
$query = 
      "SELECT atlantian.atlantian_id, atlantian.sca_name, atlantian.alternate_names, atlantian.gender, atlantian.deceased, atlantian.deceased_date, atlantian.name_reg_date, atlantian.blazon, atlantian.device_reg_date, " .
      "award.award_name, award.type_id, atlantian_award.award_date, atlantian_award.sequence, precedence.display_name, precedence.precedence, branch.date_founded " .
      "FROM $DBNAME_AUTH.atlantian INNER JOIN $DBNAME_OP.atlantian_award ON atlantian.atlantian_id = atlantian_award.atlantian_id " .
      "INNER JOIN $DBNAME_OP.award ON atlantian_award.award_id = award.award_id " .
      "INNER JOIN $DBNAME_OP.precedence ON award.type_id = precedence.type_id " .
      "INNER JOIN $DBNAME_BRANCH.branch ON award.branch_id = branch.branch_id " .
      "WHERE atlantian_award.resigned_date IS NULL ".
      "AND atlantian_award.revoked_date IS NULL ".
      "AND (atlantian.branch_id IN (SELECT branch_id FROM $DBNAME_BRANCH.branch WHERE branch_id = " . $group_id . " OR parent_branch_id = " . $group_id . ") " .
      "OR award.type_id IN (". $MONARCH . ", " . $HEIR . ")) " .
      "UNION " .
      "SELECT atlantian.atlantian_id, atlantian.sca_name, atlantian.alternate_names, atlantian.gender, atlantian.deceased, atlantian.deceased_date, atlantian.name_reg_date, atlantian.blazon, atlantian.device_reg_date, " .
      "award.award_name, award.type_id, atlantian_award.award_date, atlantian_award.sequence, precedence.display_name, precedence.precedence, branch.date_founded " .
      "FROM $DBNAME_AUTH.atlantian INNER JOIN $DBNAME_OP.atlantian_award ON atlantian.atlantian_id = atlantian_award.atlantian_id " .
      "INNER JOIN $DBNAME_OP.award ON atlantian_award.award_id = award.award_id " .
      "INNER JOIN $DBNAME_OP.precedence ON award.type_id = precedence.type_id " .
      "INNER JOIN $DBNAME_BRANCH.branch ON atlantian_award.branch_id = branch.branch_id ".
      "WHERE atlantian_award.resigned_date IS NULL ".
      "AND atlantian_award.revoked_date IS NULL ".
      "AND (atlantian.branch_id IN (SELECT branch_id FROM $DBNAME_BRANCH.branch WHERE branch_id = " . $group_id . " OR parent_branch_id = " . $group_id . ") " .
      "OR award.type_id IN (". $MONARCH . ", " . $HEIR . ")) " .
      "UNION " .
      "SELECT atlantian.atlantian_id, atlantian.sca_name, atlantian.alternate_names, atlantian.gender, atlantian.deceased, atlantian.deceased_date, atlantian.name_reg_date, atlantian.blazon, atlantian.device_reg_date, " .
      "award.award_name, award.type_id, atlantian_award.award_date, atlantian_award.sequence, precedence.display_name, precedence.precedence, " . date("Y-m-d") . " as date_founded " .
      "FROM $DBNAME_AUTH.atlantian INNER JOIN $DBNAME_OP.atlantian_award ON atlantian.atlantian_id = atlantian_award.atlantian_id " .
      "INNER JOIN $DBNAME_OP.award ON atlantian_award.award_id = award.award_id " .
      "INNER JOIN $DBNAME_OP.precedence ON award.type_id = precedence.type_id " .
      "WHERE atlantian_award.resigned_date IS NULL ".
      "AND atlantian_award.revoked_date IS NULL ".
      "AND award.branch_id IS NULL ".
      "AND atlantian_award.branch_id IS NULL ".
      "AND (atlantian.branch_id IN (SELECT branch_id FROM $DBNAME_BRANCH.branch WHERE branch_id = " . $group_id . " OR parent_branch_id = " . $group_id . ") " .
      "OR award.type_id IN (". $MONARCH . ", " . $HEIR . ")) " .
      "ORDER BY precedence, award_date, date_founded, sequence, sca_name";

/*$query = 
      "SELECT atlantian.atlantian_id, atlantian.sca_name, atlantian.alternate_names, atlantian.gender, atlantian.deceased, atlantian.deceased_date, atlantian.name_reg_date, atlantian.blazon, atlantian.device_reg_date, " .
      "award.award_name, award.type_id, atlantian_award.award_date, atlantian_award.sequence, precedence.display_name, precedence.precedence ".
      "FROM atlantian, award, atlantian_award, precedence ".
      "WHERE award.award_id = atlantian_award.award_id ".
      "AND atlantian.atlantian_id = atlantian_award.atlantian_id ".
      "AND award.type_id = precedence.type_id ".
      "AND atlantian_award.resigned_date IS NULL ".
      "AND atlantian_award.revoked_date IS NULL ".
      "AND (atlantian.branch_id IN (SELECT branch_id from branch WHERE branch_id = " . $group_id . " OR parent_branch_id = " . $group_id . ") " .
      "OR award.type_id IN (". $MONARCH . ", " . $HEIR . ")) " .
      "ORDER BY precedence, award_date, sequence, sca_name";
*/
//      "AND (atlantian.branch_id = " . $group_id . " " .
/* When InnoDB is implemented on the server, and this will work fast
      "AND precedence.precedence = (SELECT MIN(precedence) ".
      "   FROM precedence p, award a ".
      "   WHERE p.type_id = a.type_id ".
      "   AND a.award_id IN (SELECT award_id ".
      "      FROM atlantian_award ".
      "      WHERE atlantian_id = atlantian.atlantian_id)) ".
      "AND atlantian_award.award_date = (SELECT MIN(award_date) ".
      "   FROM atlantian_award pa, award award2 ".
      "   WHERE pa.award_id = award2.award_id ".
      "   AND award2.type_id = award.type_id ".
      "   AND pa.atlantian_id = atlantian.atlantian_id) ".
      "AND atlantian_award.sequence = (SELECT MIN(sequence) ".
      "   FROM atlantian_award pa2, award award3 ".
      "   WHERE pa2.award_id = award3.award_id ".
      "   AND award3.type_id = award.type_id ".
      "   AND pa2.atlantian_id = atlantian.atlantian_id) ".
*/

$result = mysql_query($query) 
   or die("Query failed : " . mysql_error());

$ind_data = NULL;
$type_id_level = -1;
$display_name = NULL;

/* Printing results in HTML */
?>
<p align="center" class="title2">Order of Precedence of the <?php echo $branch_name; ?></p>
<table border="1" align="center" cellpadding="5" cellspacing="0" summary="Order of Precedence for the <?php echo $branch_name; ?>">
<?php
$num_op_people = 0;
$rank = 0;
$prev_precedence = 0;
$prev_date = 0;
$prev_seq = 0;
$prev_date_founded = 0;
while ($data = mysql_fetch_array($result, MYSQL_BOTH)) 
{
   $type_id = $data['type_id'];
   $precedence = $data['precedence'];
   $a_date = $data['award_date'];
   $sequence = $data['sequence'];
   $date_founded = $data['date_founded'];
   // Changed levels - but skip PoA
   if ($type_id_level != $type_id && $type_id != $POA_LEVEL)
   {
      $display_name = clean($data['display_name']);
      $type_id_level = $type_id;
      if ($precedence == $UNDER_OP_LEVEL)
      {
         // kingdom awards - start new table
?>
</table>
<br/><br/>
<p align="center" class="title2">Kingdom and Baronial Awards</p>
<table border="1" align="center" cellpadding="5" cellspacing="0" summary="Holders of only non-precedence awards of the Kindgom of Atlantia">
<?php
      }
?>      
   <tr>
      <th colspan="4" scope="rowgroup" class="title"><?php echo $display_name; ?></th>
   </tr>
   <tr>
      <th scope="col" class="title">Rank</th>
      <th scope="col" class="title">Individual</th>
      <th scope="col" class="title">Award Date</th>
      <th scope="col" class="title">Awards</th>
   </tr>
<?php   
   }
   $atlantian_id = $data[0];
   // Only print those Atlantians we haven't printed yet
   if ($printedArray[$atlantian_id] == 0)
   {
      $num_op_people++;
      $sca_name = clean($data['sca_name']);
      $alternate_names = clean($data['alternate_names']);
      $name_reg_date = "&nbsp;";
      if (clean($data['name_reg_date']) != '')
      {
         $name_reg_date = clean($data['name_reg_date']);
         $name_reg_date = '(' . date('n/Y', strtotime($name_reg_date)) . ')';
      }
      $blazon = "&nbsp;";
      if ($data['blazon'] != NULL)
      {
         $blazon = clean($data['blazon']);
      }
      $device_reg_date = "&nbsp;";
      if (trim($data['device_reg_date']) != '')
      {
         $device_reg_date = clean($data['device_reg_date']);
         $device_reg_date = '(' . date('n/Y', strtotime($device_reg_date)) . ')';
      }
      $gender = $data['gender'];
      $deceased = $data['deceased'];
      $deceased_date = $data['deceased_date'];
      $deceased_display = "";
      if ($deceased == 1)
      {
         $deceased_display = " - DECEASED";
         if ($deceased_date != '')
         {
            $deceased_display .= ' (' . date('n/d/Y', strtotime($deceased_date)) . ')';
         }
      }
      $name_display = "<a href=\"op_ind.php?atlantian_id=$atlantian_id\" class=\"td\">$sca_name</a>";
      if ($name_reg_date != '')
      {
         $name_display .= " $name_reg_date";
      }
      if ($deceased_display != '')
      {
         $name_display .= " $deceased_display";
      }
      if ($alternate_names != '')
      {
         $name_display .= "<br/>[AKA $alternate_names]";
      }
      if ($blazon != '')
      {
         $name_display .= "<br/>$blazon $device_reg_date";
      }

   /* Performing SQL query */
   $ind_query = 
      "(SELECT atlantian.sca_name, award.award_id, award.award_name, award.award_name_male, award.award_name_female, award.type_id, award.award_group_id, " .
      "atlantian_award.award_date, atlantian_award.sequence, atlantian_award.premier, branch.branch, branch.branch_id, precedence.precedence ".
      "FROM $DBNAME_AUTH.atlantian, $DBNAME_OP.award, $DBNAME_OP.atlantian_award, $DBNAME_BRANCH.branch, $DBNAME_OP.precedence ".
      "WHERE award.award_id = atlantian_award.award_id ".
      "AND atlantian.atlantian_id = atlantian_award.atlantian_id ".
      "AND award.type_id = precedence.type_id ".
      "AND award.branch_id = branch.branch_id ".
      "AND atlantian_award.resigned_date IS NULL ".
      "AND atlantian_award.revoked_date IS NULL ".
      "AND atlantian_award.atlantian_id = ". $atlantian_id . " ".
      "AND (atlantian.branch_id IN (SELECT branch_id FROM $DBNAME_BRANCH.branch WHERE branch_id = " . $group_id . " OR parent_branch_id = " . $group_id . ") " .
      "OR award.type_id IN (". $MONARCH . ", " . $HEIR . "))) " .
      "UNION ALL ".
      "(SELECT atlantian.sca_name, award.award_id, award.award_name, award.award_name_male, award.award_name_female, award.type_id, award.award_group_id, " .
      "atlantian_award.award_date, atlantian_award.sequence, atlantian_award.premier, branch.branch, branch.branch_id, precedence.precedence ".
      "FROM $DBNAME_AUTH.atlantian, $DBNAME_OP.award, $DBNAME_OP.atlantian_award, $DBNAME_BRANCH.branch, $DBNAME_OP.precedence ".
      "WHERE award.award_id = atlantian_award.award_id ".
      "AND atlantian.atlantian_id = atlantian_award.atlantian_id ".
      "AND award.type_id = precedence.type_id ".
      "AND atlantian_award.branch_id = branch.branch_id ".
      "AND atlantian_award.resigned_date IS NULL ".
      "AND atlantian_award.revoked_date IS NULL ".
      "AND atlantian_award.atlantian_id = ". $atlantian_id . " ".
      "AND (atlantian.branch_id IN (SELECT branch_id FROM $DBNAME_BRANCH.branch WHERE branch_id = " . $group_id . " OR parent_branch_id = " . $group_id . ") " .
      "OR award.type_id IN (". $MONARCH . ", " . $HEIR . "))) " .
      "UNION ALL ".
      "(SELECT atlantian.sca_name, award.award_id, award.award_name, award.award_name_male, award.award_name_female, award.type_id, award.award_group_id, " .
      "atlantian_award.award_date, atlantian_award.sequence, atlantian_award.premier, null AS branch, null AS branch_id, precedence.precedence ".
      "FROM $DBNAME_AUTH.atlantian, $DBNAME_OP.award, $DBNAME_OP.atlantian_award, $DBNAME_OP.precedence ".
      "WHERE award.award_id = atlantian_award.award_id ".
      "AND atlantian.atlantian_id = atlantian_award.atlantian_id ".
      "AND award.type_id = precedence.type_id ".
      "AND atlantian_award.branch_id IS NULL ".
      "AND award.branch_id IS NULL ".
      "AND atlantian_award.resigned_date IS NULL ".
      "AND atlantian_award.revoked_date IS NULL ".
      "AND atlantian_award.atlantian_id = ". $atlantian_id . " ".
      "AND (atlantian.branch_id IN (SELECT branch_id FROM $DBNAME_BRANCH.branch WHERE branch_id = " . $group_id . " OR parent_branch_id = " . $group_id . ") " .
      "OR award.type_id IN (". $MONARCH . ", " . $HEIR . "))) " .
      "ORDER BY precedence, award_date, sequence, sca_name";

      $ind_result = mysql_query($ind_query) 
         or die("Individual query failed : " . mysql_error());
      $num_awards = mysql_num_rows($ind_result);

      if (!($prev_precedence == $precedence && $prev_date == $a_date && $prev_seq == $sequence && $prev_date_founded == $date_founded))
      {
         $rank++;
      }
      $prev_precedence = $precedence;
      $prev_date = $a_date;
      $prev_seq = $sequence;
      $prev_date_founded = $date_founded;
?>
      <tr>
         <td valign="top" class="dataright" rowspan="<?php echo $num_awards; ?>"><?php echo $rank; ?></td>
         <td valign="top" class="data" rowspan="<?php echo $num_awards; ?>"><?php echo $name_display; ?></td>
<?php
      $award_index = 0;
      while ($ind_data = mysql_fetch_array($ind_result, MYSQL_BOTH))
      {
         $award_id = $ind_data['award_id'];
         $award_group_id = $ind_data['award_group_id'];
         $award_name = clean($ind_data['award_name']);
         if ($gender == $FEMALE)
         {
            $award_name_gender = clean($ind_data['award_name_female']);
         }
         else
         {
            $award_name_gender = clean($ind_data['award_name_male']);
         }
         $award_name_display = $award_name_gender;
         if ($award_name_gender == "")
         {
            $award_name_display = $award_name;
         }

         $branch = clean($ind_data['branch']);
         $branch_id = $ind_data['branch_id'];
         if ($branch_id != "" && $branch_id > 0)
         {
            $kingdom = clean(get_kingdom($branch_id));
            if ($kingdom == $branch)
            {
               $branch = "";
            }
         }
         else
         {
            $kingdom = "<i>Unknown</i>";
         }
         $kingdom_display = "";
         if ($kingdom != "")
         {
            $kingdom_display = " ($kingdom)";
         }
         if ($branch != "")
         {
            $kingdom_display .= " ($branch)";
         }

         $type_id = $ind_data['type_id'];
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

         $premier = $ind_data['premier'];
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

         $award_date = $ind_data['award_date'];
         if (trim($award_date) != "")
         {
            $award_date = format_short_date($award_date) . " ";
         }
         else
         {
            $award_date = "<i>Unknown</i> ";
         }
         $display_string = $award_name_display . $kingdom_display;
?>
         <td valign="top" class="dataright"><?php echo $award_date; ?></td>
         <td valign="top" class="data" nowrap="nowrap"><?php echo $display_string; ?></td>
<?php
         if ($award_index < ($num_awards - 1))
         {
?>
      </tr>
      <tr>
<?php
         }
         $award_index++;
      }
      /* Free individual resultset */
      mysql_free_result($ind_result);

      // Mark this Pontoon as printed
      $printedArray[$atlantian_id] = 1;
?>
      </tr>
<?php
   } // printed Atlantian
}

/* Free resultset */
mysql_free_result($result);

/* Closing connection */
db_disconnect($link);

?>
</table>
<?php 
if (isset($num_op_people) && $num_op_people > 0)
{
?>
<p align="center">There are <?php echo $num_op_people; ?> people listed in the OP for the <?php echo $branch_name; ?>.</p>
<?php 
}
include('footer.php'); 
?>
