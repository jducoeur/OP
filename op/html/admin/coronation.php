<?php
include_once('header.php');
// Only allow authorized users
if (isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN])
{
   $SUBMIT_CROWN = "Crown Heirs";
   $submit = "";
   if (isset($_POST['submit']))
   {
      $submit = clean($_POST['submit']);
   }

   if ($submit == $SUBMIT_CROWN)
   {
      $MONARCH_AWARD_ID_IN_CLAUSE = '1, 2';
      $HEIR_AWARD_ID_IN_CLAUSE = '3, 4';
      $DUCAL_AWARD_ID_IN_CLAUSE = '9';
      $COUNTY_AWARD_ID_IN_CLAUSE = '10';

      $monarch_ids = "";
      $monarch_id_array = array();
      $heir_ids = "";
      $heir_id_array = array();
      $monarchs_display = "";
      $coronation_date = "";
      $dsequence = 0;
      $sequence = 0;
      if (isset($_POST['monarch_id']))
      {
         $monarch_ids = clean($_POST['monarch_id']);
         $monarch_id_array = explode(',', $_POST['monarch_id']);
      }
      if (isset($_POST['heir_id']))
      {
         $heir_ids = clean($_POST['heir_id']);
         $heir_id_array = explode(',', $_POST['heir_id']);
      }
      if (isset($_POST['monarchs_display']))
      {
         $monarchs_display = clean($_POST['monarchs_display']);
      }
      if (isset($_POST['coronation_date']))
      {
         $coronation_date = clean($_POST['coronation_date']);
      }
      if (isset($_POST['dsequence']))
      {
         $dsequence = clean($_POST['dsequence']);
      }
      if (isset($_POST['sequence']))
      {
         $sequence = clean($_POST['sequence']);
      }

      // Validation
      $errmsg = "";
      if ($monarchs_display == "")
      {
         $errmsg .= "Please enter a display name for the new Monarchs' reign.<br/>";
      }
      // Validate date
      if ($coronation_date == '' || strtotime($coronation_date) === FALSE)
      {
         $errmsg .= "Please enter a valid date for the Coronation Date.<br/>";
      }
      else
      {
         $coronation_date = format_mysql_date($coronation_date);
      }
      // Validate sequence numbers
      if (($sequence != '') && (!validate_zero_plus_integer($sequence)))
      {
         $errmsg .= "Please enter a valid number for the Coronation Sequence.<br/>";
      }
      // Validate sequence numbers
      if (($dsequence != '') && (!validate_zero_plus_integer($dsequence)))
      {
         $errmsg .= "Please enter a valid number for the De-Coronation Sequence.<br/>";
      }

      if ($errmsg == "")
      {
         /* Connecting, selecting database */
         $link = db_admin_connect();

         $sovereign_id = "";
         $consort_id = "";
         // Loop through the Monarchs
         for ($i = 0; $i < count($monarch_id_array); $i++)
         {
            // Check for existing Royal Peer Status
            // Get gender
            $gender_query = "SELECT atlantian.atlantian_id, atlantian.gender, atlantian_award.award_id " .
               "FROM $DBNAME_AUTH.atlantian, $DBNAME_OP.atlantian_award " .
               "WHERE atlantian.atlantian_id = atlantian_award.atlantian_id " .
               "AND atlantian_award.award_id IN (" . $MONARCH_AWARD_ID_IN_CLAUSE . ") " .
               "AND atlantian.atlantian_id = " . $monarch_id_array[$i];

            $gender_result = mysql_query($gender_query) 
               or die("Gender query failed : " . mysql_error());
            $gender_data = mysql_fetch_array($gender_result, MYSQL_BOTH);

            if ($gender_data['award_id'] == $KING)
            {
               $sovereign_id = $monarch_id_array[$i];
            }
            else
            {
               $consort_id = $monarch_id_array[$i];
            }

            // Get highest rank under Monarchs
            $royal_query = 
               "SELECT atlantian.atlantian_id, award.award_name, award.type_id, atlantian_award.award_date, atlantian_award.sequence, precedence.precedence ".
               "FROM $DBNAME_AUTH.atlantian, $DBNAME_OP.atlantian_award, $DBNAME_OP.award, $DBNAME_OP.precedence ".
               "WHERE award.award_id = atlantian_award.award_id ".
               "AND atlantian.atlantian_id = atlantian_award.atlantian_id ".
               "AND award.type_id = precedence.type_id ".
               "AND atlantian.atlantian_id = ". $monarch_id_array[$i] . " ".
               "AND award.award_id NOT IN (" . $MONARCH_AWARD_ID_IN_CLAUSE . ") " .
               "ORDER BY precedence, award_date, sequence";

            $royal_result = mysql_query($royal_query) 
               or die("Royal query failed : " . mysql_error());

            // Only get highest record
            $royal_data = mysql_fetch_array($royal_result, MYSQL_BOTH);

            if ($royal_data['type_id'] == $DUCAL)
            {
               // Nothing special
            }
            else if ($royal_data['type_id'] == $COUNTY)
            {
               // Add Duke/Duchess "award"
               $ducal_insert = "INSERT INTO $DBNAME_OP.atlantian_award (atlantian_id, award_date, sequence, last_updated, last_updated_by, branch_id, award_id) " .
                  "VALUES (" . $monarch_id_array[$i] . ", " . 
                  value_or_null($coronation_date) . ", " .
                  value_or_zero($dsequence) . ", " .
                  value_or_null(date("Y-m-d")) . ", " .
                  value_or_null($_SESSION["s_user_id"]) . ", " .
                  $ATLANTIA . ", " .
                  $DUKE . ")";

               $ducal_result = mysql_query($ducal_insert) 
                  or die("Ducal INSERT failed : " . mysql_error());
            }
            else // Not a Royal Peer yet
            {
               // Add Count/Countess "award"
               $county_insert = "INSERT INTO $DBNAME_OP.atlantian_award (atlantian_id, award_date, sequence, last_updated, last_updated_by, branch_id, award_id) " .
                  "VALUES (" . $monarch_id_array[$i] . ", " . 
                  value_or_null($coronation_date) . ", " .
                  value_or_zero($dsequence) . ", " .
                  value_or_null(date("Y-m-d")) . ", " .
                  value_or_null($_SESSION["s_user_id"]) . ", " .
                  $ATLANTIA . ", ";

               if ($gender_data['award_id'] == $KING)
               {
                  $county_insert .= $COUNT;
               }
               else
               {
                  $rose_insert = $county_insert . $ROSE . ')';
                  $county_insert .= $COUNTESS;
               }
               $county_insert .= ')';
               $county_result = mysql_query($county_insert) 
                  or die("County insert failed : " . mysql_error());
               // Add Order of the Rose "award" if this is the Consort
               if (isset($rose_insert))
               {
                  $rose_result = mysql_query($rose_insert) 
                     or die("Rose insert failed : " . mysql_error());
               }
               // Don't Already have a PoA or better?
               if ($royal_data['type_id'] != $VISCOUNTY && $royal_data['type_id'] != $BESTOWED_PEER && $royal_data['type_id'] != $POA_LEVEL)
               {
                  // Add PoA
                  $poa_insert = "INSERT INTO $DBNAME_OP.atlantian_award (atlantian_id, award_date, sequence, last_updated, last_updated_by, branch_id, award_id) " .
                     "VALUES (" . $monarch_id_array[$i] . ", " . 
                     value_or_null($coronation_date) . ", " .
                     value_or_zero($dsequence) . ", " .
                     value_or_null(date("Y-m-d")) . ", " .
                     value_or_null($_SESSION["s_user_id"]) . ", " .
                     $ATLANTIA . ", " .
                     $POA . ")";
                  $poa_result = mysql_query($poa_insert) 
                     or die("PoA insert failed : " . mysql_error());
               }
            }
            // Remove King/Queen "award"
            $delete_query = "DELETE FROM $DBNAME_OP.atlantian_award WHERE atlantian_id = " . value_or_null($monarch_id_array[$i]) . " AND award_id IN (" . $MONARCH_AWARD_ID_IN_CLAUSE . ")";
            $delete_result = mysql_query($delete_query) 
               or die("DELETE failed : " . mysql_error());
         }
         // Update reign end date
         $reign_query = "UPDATE $DBNAME_OP.reign SET reign_end_date = " . value_or_null($coronation_date) . 
            ", last_updated = " . value_or_null(date("Y-m-d")) .
            ", last_updated_by = " . value_or_null($_SESSION["s_user_id"]) .
            " WHERE king_id = " . value_or_null($sovereign_id) .
            " AND queen_id = " . value_or_null($consort_id) . 
            " AND reign_end_date IS NULL";
         $reign_result = mysql_query($reign_query) 
            or die("Reign UPDATE failed : " . mysql_error());

         // HEIRS
         $sovereign_id = "";
         $consort_id = "";
         // Loop through the Heirs
         for ($i = 0; $i < count($heir_id_array); $i++)
         {
            // Get Prince/Princess "award" record
            $heir_check_query = "SELECT atlantian_award.atlantian_award_id, atlantian.gender, atlantian_award.award_id " . 
               "FROM $DBNAME_OP.atlantian_award, $DBNAME_AUTH.atlantian " .
               "WHERE atlantian.atlantian_id = atlantian_award.atlantian_id " .
               " AND atlantian.atlantian_id = " . value_or_null($heir_id_array[$i]) . 
               " AND atlantian_award.award_id IN (" . $HEIR_AWARD_ID_IN_CLAUSE . ")";
            $heir_check_result = mysql_query($heir_check_query) 
               or die("Heir check failed : " . mysql_error());

            $heir_data = mysql_fetch_array($heir_check_result, MYSQL_BOTH);

            // Update Prince/Princess "award" to King/Queen "award" and new award date of the Coronation date
            $update_heir_query = "UPDATE $DBNAME_OP.atlantian_award SET event_id = NULL, court_report_id = NULL" .
               ", award_date = " . value_or_null($coronation_date) . 
               ", sequence = " . value_or_zero($sequence) . 
               ", last_updated = " . value_or_null(date("Y-m-d")) .
               ", last_updated_by = " . value_or_null($_SESSION["s_user_id"]) .
               ", award_id = ";
            if ($heir_data['award_id'] == $PRINCE)
            {
               $update_heir_query .= $KING;
               $sovereign_id = $heir_id_array[$i];
            }
            else
            {
               $update_heir_query .= $QUEEN;
               $consort_id = $heir_id_array[$i];
            }
            $update_heir_query .= " WHERE atlantian_award_id = " . $heir_data["atlantian_award_id"];
            $update_heir_result = mysql_query($update_heir_query) 
               or die("Heir UPDATE failed : " . mysql_error());
         }
         // Insert Reign
         $reign_query = "INSERT INTO $DBNAME_OP.reign (king_id, queen_id, reign_start_date, reign_start_sequence, last_updated, last_updated_by, monarchs_display) VALUES (" . 
            value_or_null($sovereign_id) . ", " .
            value_or_null($consort_id) . ", " .
            value_or_null($coronation_date) . ", " .
            value_or_zero($sequence) . ", " .
            value_or_null(date("Y-m-d")) . ", " .
            value_or_null($_SESSION["s_user_id"]) . ", " .
            value_or_null($monarchs_display) . ")";
         $reign_result = mysql_query($reign_query) 
            or die("Reign INSERT failed : " . mysql_error());

         $idquery = 
            "SELECT atlantian.sca_name, award.award_name, atlantian_award.award_date, atlantian_award.sequence, " .
            "k1.branch, k2.branch AS branch2 " .
            "FROM $DBNAME_AUTH.atlantian JOIN $DBNAME_OP.atlantian_award ON atlantian.atlantian_id = atlantian_award.atlantian_id ".
            "JOIN $DBNAME_OP.award ON atlantian_award.award_id = award.award_id " .
            "LEFT OUTER JOIN $DBNAME_BRANCH.branch k1 ON award.branch_id = k1.branch_id " .
            "LEFT OUTER JOIN $DBNAME_BRANCH.branch k2 ON atlantian_award.branch_id = k2.branch_id ".
            "WHERE atlantian_award.award_date = ". value_or_null($coronation_date) .
            " AND award.type_id <= " . $POA_LEVEL .
            " AND atlantian.atlantian_id IN (" . $monarch_ids . "," . $heir_ids .")" .
            " ORDER BY sca_name, sequence";

         $idresult = mysql_query($idquery) 
            or die("ID Query failed : " . mysql_error());

      /* Printing results in HTML */
?>
<p class="title2">Coronation</p>
<table border="0" cellpadding="5" cellspacing="5" summary="Table used for layout and formatting">
<?php
         while ($iddata = mysql_fetch_array($idresult, MYSQL_BOTH))
         {
            $award_name = trim($iddata['award_name']);
            $scaname = trim($iddata['sca_name']);
            $award_date = $iddata['award_date'];
            $sequence = $iddata['sequence'];
            $kingdom = trim($iddata['branch']);
            if ($kingdom == '')
            {
               $kingdom = trim($iddata['branch2']);
            }
?>
   <tr>
      <td>
<table border="1" width="100%" cellpadding="5" cellspacing="0" summary="Award Data">
   <tr>
      <th class="titleright" valign="top">Person:</th>
      <td class="data"><?php echo $scaname; ?></td>
   </tr>
   <tr>
      <th class="titleright" valign="top">Award Name:</th>
      <td class="data"><?php echo $award_name; ?></td>
   </tr>
   <tr>
      <th class="titleright" valign="top">Branch:</th>
      <td class="data"><?php if ($kingdom != '') { echo $kingdom; } else { echo 'Not Applicable'; } ?></td>
   </tr>
   <tr>
      <th class="titleright" valign="top">Award Date:</th>
      <td class="data"><?php echo $award_date; ?></td>
   </tr>
   <tr>
      <th class="titleright" valign="top">Sequence:</th>
      <td class="data"><?php echo $sequence; ?></td>
   </tr>
</table>
      </td>
   </tr>
<?php
         }
?>
</table>
<?php
      } // Valid
   } // End submit 

   // First page
   if ($submit != $SUBMIT_CROWN || $errmsg != "")
   {
      /* Connecting, selecting database */
      $link = db_connect();

      /* Performing SQL query */
      $monarch_query = 
         "SELECT atlantian.atlantian_id, atlantian.sca_name, atlantian.gender, atlantian_award.award_id ".
         "FROM $DBNAME_AUTH.atlantian, $DBNAME_OP.atlantian_award, $DBNAME_OP.award ".
         "WHERE atlantian.atlantian_id = atlantian_award.atlantian_id " .
         "AND atlantian_award.award_id = award.award_id " .
         "AND award.type_id = ". $MONARCH .
         " ORDER BY atlantian_award.award_id";

      $monarch_result = mysql_query($monarch_query) 
         or die("Monarch Query failed : " . mysql_error());

      $heir_query = 
         "SELECT atlantian.atlantian_id, atlantian.sca_name, atlantian.gender, atlantian_award.award_id ".
         "FROM $DBNAME_AUTH.atlantian, $DBNAME_OP.atlantian_award, $DBNAME_OP.award ".
         "WHERE atlantian.atlantian_id = atlantian_award.atlantian_id " .
         "AND atlantian_award.award_id = award.award_id " .
         "AND award.type_id = ". $HEIR .
         " ORDER BY atlantian_award.award_id";

      $heir_result = mysql_query($heir_query) 
         or die("Heir Query failed : " . mysql_error());

      /* Printing results in HTML */
?>
<p class="title2">Coronation</p>
<?php 
      if (isset($errmsg) && $errmsg != '')
      {
?>
<p align="center" class="title3" style="color:red">Please correct the following errors:<br/><br/><?php echo $errmsg; ?></p>
<?php 
      }
?>
<form action="coronation.php" method="post">
<table border="1" cellpadding="5" cellspacing="0" summary="List of Monarchs">
   <tr>
      <th class="title">Monarchs</th>
   </tr>
   <tr>
      <td class="datacenter">
<?php
      $monarch_list = '';
      $monarch_display = "";
      while ($monarch_data = mysql_fetch_array($monarch_result, MYSQL_BOTH))
      {
         $atlantian_id = $monarch_data['atlantian_id'];
         $sca_name = $monarch_data['sca_name'];
         $gender = $monarch_data['gender'];
         if ($monarch_display != "")
         {
            $monarch_display .= "<br/>";
            $monarch_list .= ',';
         }
         $monarch_list .= $atlantian_id;
         $monarch_display .= $sca_name;
?>
   <input type="hidden" name="monarch_id" id="monarch_id" value="<?php echo $monarch_list; ?>"/>
<?php
      }
      echo $monarch_display;
?>
      </td>
   </tr>
</table>
<br/><br/>
<?php
      if (mysql_num_rows($heir_result) > 0)
      {
?>
<table border="1" cellpadding="5" cellspacing="0" summary="List of Heirs">
   <tr>
      <th class="title" colspan="2">Heirs</th>
   </tr>
   <tr>
      <td class="datacenter" colspan="2">
<?php
         $heir_list = '';
         $heir_display = "";
         while ($heir_data = mysql_fetch_array($heir_result, MYSQL_BOTH))
         {
            $atlantian_id = $heir_data['atlantian_id'];
            $sca_name = $heir_data['sca_name'];
            $gender = $heir_data['gender'];
            if ($heir_display != "")
            {
               $heir_display .= '<br/>';
               $heir_list .= ',';
            }
            $heir_list .= $atlantian_id;
            $heir_display .= $sca_name;
         }
         echo $heir_display;
?>
      <input type="hidden" name="heir_id" id="heir_id" value="<?php echo $heir_list; ?>"/>
      </td>
   </tr>
   <tr>
      <td class="data">
      <label for="monarchs_display"><b>Display Name:</b><br/><i>(i.e. Joe I and Jane II)</i></label>
      </td>
      <td class="data">
      <input type="text" name="monarchs_display" id="monarchs_display" size="40" maxlength="50"<?php if (isset($monarchs_display)) { echo ' value="' . $monarchs_display . '"'; }?>/>
      </td>
   </tr>
   <tr>
      <td class="data">
      <label for="coronation_date"><b>Coronation Date:</b></label>
      </td>
      <td class="data">
      <input type="text" name="coronation_date" id="coronation_date" size="12" maxlength="10"<?php if (isset($coronation_date)) { echo ' value="' . $coronation_date . '"'; }?>/>
      </td>
   </tr>
   <tr>
      <td class="data">
      <label for="sequence"><b>Coronation Sequence:</b></label>
      </td>
      <td class="data">
      <input type="text" name="sequence" id="sequence" size="5" maxlength="5"<?php if (isset($sequence)) { echo ' value="' . $sequence . '"'; }?>/> 
      </td>
   </tr>
   <tr>
      <td class="data">
      <label for="dsequence"><b>De-Coronation Sequence:</b></label>
      </td>
      <td class="data">
      <input type="text" name="dsequence" id="dsequence" size="5" maxlength="5"<?php if (isset($dsequence)) { echo ' value="' . $dsequence . '"'; }?>/> 
      </td>
   </tr>
   <tr>
      <td class="title" colspan="2"><input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_CROWN; ?>"/></td>
   </tr>
</table>
</form>
<br/>
<p>
<b>Coronation Sequence:</b> Court sequence of Coronation - awards entered after this date and sequence number will be considered part of the new reign
<br/><br/>
<b>De-Coronation Sequence:</b> Court sequence of County/Rose/Duchy/PoA
</p>
<?php
      }
      else
      {
?>
<p>There are no listed Heirs.<br/>Please use the <a href="select_ind.php?type=<?php echo $TYPE_AWARD; ?>&mode=<?php echo $MODE_ADD; ?>">Add Award</a> link to add the Prince and Princess.</p>
<?php
      }
   }
}
else
{
?>
<p class="title2">Coronation</p>
<p>You are not authorized to access this page.</p>
<?php
}
?>
<?php include('footer.php'); ?>
