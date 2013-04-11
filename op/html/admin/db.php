<?php
include_once('../db/host_defines.php');
include_once("session.php");
include_once("../db/db.php");

function get_branch_pick_list()
{
   global $DBNAME_AUTH, $DBNAME_OP, $DBNAME_BRANCH, $DBNAME_ORDER, $DBNAME_SPIKE;
   global $BT_KINGDOM;

   $link = db_admin_connect();

   // Get Branch List
   $branch_query = "SELECT branch, branch_type, branch_id, incipient, branch.branch_type_id " .
      "FROM $DBNAME_BRANCH.branch, $DBNAME_BRANCH.branch_type " .
      "WHERE branch.branch_type_id = branch_type.branch_type_id " .
      "ORDER BY branch";
   $branch_result = mysql_query($branch_query)
      or die("Error reading Branch list: " . mysql_error());
   $branch_data_array = array();
   $i = 0;
   while ($branch_data = mysql_fetch_array($branch_result, MYSQL_BOTH))
   {
      $branch_data_array[$i]['branch_id'] = $branch_data['branch_id'];
      $branch_data_array[$i]['branch'] = $branch_data['branch'];
      $branch_data_array[$i]['branch_name'] = $branch_data['branch'];
      $branch_data_array[$i]['branch_name'] .= ' (';
      if ($branch_data['incipient'] == 1)
      {
         $branch_data_array[$i]['branch_name'] .= "Incipient ";
      }
      $branch_data_array[$i]['branch_name'] .= $branch_data['branch_type'] . ')';
      if ($branch_data['branch_type_id'] != $BT_KINGDOM)
      {
         $branch_data_array[$i]['branch_name'] .= ", " . get_kingdom($branch_data['branch_id']);
      }
      $i++;
   }
   mysql_free_result($branch_result);

   db_disconnect($link);
   return $branch_data_array;
}

function get_kingdom_pick_list()
{
   global $DBNAME_AUTH, $DBNAME_OP, $DBNAME_BRANCH, $DBNAME_ORDER, $DBNAME_SPIKE;
   global $BT_KINGDOM;

   $link = db_admin_connect();

   // Get Monarchs list
   $kingdom_query = "SELECT branch_id, branch FROM $DBNAME_BRANCH.branch WHERE branch_type_id = $BT_KINGDOM ORDER BY branch";

   $kingdom_result = mysql_query($kingdom_query)
      or die("Error reading kingdom list: " . mysql_error());

   $kingdom_data_array = array();
   $i = 0;
   while ($kingdom_data = mysql_fetch_array($kingdom_result, MYSQL_BOTH))
   {
      $kingdom_data_array[$i]['branch_id'] = $kingdom_data['branch_id'];
      $kingdom_data_array[$i++]['branch'] = $kingdom_data['branch'];
   }

   mysql_free_result($kingdom_result);

   db_disconnect($link);
   return $kingdom_data_array;
}

/**
 * Returns the branch_id of the given award_id 
 * YOU MUST ALREADY HAVE A DATABASE CONNECTION BEFORE USING THIS METHOD
 */
function get_award_group_id($award_id)
{
   global $DBNAME_AUTH, $DBNAME_OP, $DBNAME_BRANCH, $DBNAME_ORDER, $DBNAME_SPIKE;
   global $BT_KINGDOM;
   $branch_id = "";
   $query = "SELECT branch_id, branch_type_id FROM $DBNAME_BRANCH.branch WHERE branch_id IN (select branch_id FROM $DBNAME_OP.award WHERE award_id = " . value_or_null($award_id) . ")";
   $result = mysql_query($query)
      or die("Error reading award: " . mysql_error());
   $data = mysql_fetch_array($result, MYSQL_BOTH);
   $branch_id = $data['branch_id'];
   $branch_type_id = $data['branch_type_id'];
   if ($branch_type_id != $BT_KINGDOM)
   {
      $branch_id = get_kingdom_id($branch_id);
   }
   return $branch_id;
}

/**
 * Returns the name of the Kingdom where the given group is located
 * YOU MUST ALREADY HAVE A DATABASE CONNECTION BEFORE USING THIS METHOD
 * @param branch_id The ID of the branch for which to get the kingdom name
 * @return number The ID of the kingdom
 */
function get_kingdom_id($branch_id)
{
   global $DBNAME_AUTH, $DBNAME_OP, $DBNAME_BRANCH, $DBNAME_ORDER, $DBNAME_SPIKE;
   global $BT_KINGDOM;
   $kingdom_id = "";

   if (trim($branch_id) != "")
   {
      /* Performing SQL query */
      $query = "SELECT branch_id, branch, branch_type_id, parent_branch_id FROM $DBNAME_BRANCH.branch WHERE branch_id = ";

      $result = mysql_query($query . $branch_id) 
         or die("Kingdom Query failed : " . mysql_error());

      $data = mysql_fetch_array($result, MYSQL_BOTH);
      $branch_type_id = trim($data['branch_type_id']);
      $kingdom_id = $branch_id;
      $branch_id = trim($data['parent_branch_id']);
      $kingdom = trim($data['branch']);
      while ($branch_type_id != $BT_KINGDOM)
      {
         $result = mysql_query($query . $branch_id) 
            or die("Kingdom Query failed : " . mysql_error());

         $data = mysql_fetch_array($result, MYSQL_BOTH);
         $branch_type_id = trim($data['branch_type_id']);
         $kingdom_id = $branch_id;
         $branch_id = trim($data['parent_branch_id']);
         $kingdom = trim($data['branch']);
      }
   }

   return $kingdom_id;
}

/**
 * Returns the name of the Barony where the given group is located
 * YOU MUST ALREADY HAVE A DATABASE CONNECTION BEFORE USING THIS METHOD
 * @param branch_id The ID of the branch for which to get the barony ID
 * @return number The id of the Barony
 */
function get_barony_id($branch_id)
{
   global $DBNAME_AUTH, $DBNAME_OP, $DBNAME_BRANCH, $DBNAME_ORDER, $DBNAME_SPIKE;
   global $BT_BARONY;
   $barony_id = "";

   if (trim($branch_id) != "")
   {
      /* Performing SQL query */
      $query = "SELECT branch_id, branch, branch_type_id, parent_branch_id FROM $DBNAME_BRANCH.branch WHERE branch_id = ";

      $result = mysql_query($query . $branch_id) 
         or die("Barony Query failed : " . mysql_error());

      $data = mysql_fetch_array($result, MYSQL_BOTH);
      $branch_type_id = trim($data['branch_type_id']);
      $barony_id = $branch_id;
      $branch_id = trim($data['parent_branch_id']);
      $barony = trim($data['branch']);
      while ($branch_type_id != $BT_BARONY && $branch_id > 0)
      {
         $result = mysql_query($query . $branch_id) 
            or die("Barony Query failed : " . mysql_error());

         $data = mysql_fetch_array($result, MYSQL_BOTH);
         $branch_type_id = trim($data['branch_type_id']);
         $barony_id = $branch_id;
         $branch_id = trim($data['parent_branch_id']);
         $barony = trim($data['branch']);
      }
      if ($branch_type_id != $BT_BARONY)
      {
         $barony_id = "";
      }
   }

   return $barony_id;
}

/**
 * Translates a database row into a "pretty" display string for an award
 * @param row Database result row containing award data
 * @return Formatted display string for data
 */
function get_award_display_string($row, $mode)
{
   global $MODE_EDIT;
   $award_name = trim($row['award_name']);

   $branch = trim($row['branch']);
   $branch_id = trim($row['branch_id']);
   $select_branch = trim($row['select_branch']);
   $kingdom = get_kingdom($branch_id);
   $group_display = "";
   if ($kingdom != '' && $kingdom != $branch)
   {
      $group_display .= ' (' . $kingdom . ')';
   }
   if ($branch != '')
   {
      $group_display .= ' (' . $branch . ')';
   }
   if ($mode == $MODE_EDIT && $select_branch == 1 && $group_display == "")
   {
      $group_display = " (Unknown)";
   }

   if (isset($row['award_date']))
   {
      $award_date = $row['award_date'];
   }

   $display_string = $award_name . $group_display;
   if (isset($award_date))
   {
      $display_string .= ' ' . date('n/j/Y', strtotime($award_date));
   }

   return $display_string;
}

/**
 * Returns the type_id of the given award_id 
 * YOU MUST ALREADY HAVE A DATABASE CONNECTION BEFORE USING THIS METHOD
 */
function get_award_type_id($award_id)
{
   global $DBNAME_AUTH, $DBNAME_OP, $DBNAME_BRANCH, $DBNAME_ORDER, $DBNAME_SPIKE;
   $type_id = "";
   $query = "SELECT type_id FROM $DBNAME_OP.award WHERE award_id = " . value_or_null($award_id);
   $result = mysql_query($query)
      or die("Error reading award: " . mysql_error());
   $data = mysql_fetch_array($result, MYSQL_BOTH);
   $type_id = $data['type_id'];
   return $type_id;
}

function get_type_arms_by_kingdom($type_id, $kingdom_id)
{
   global $POA, $GOA, $AOA, $COUNTY, $COURT_BARONAGE_AOA, $COURT_BARONAGE_GOA, $LANDED_BARONAGE, $RETIRED_BARONAGE;
   global $WEST, $EAST, $MIDDLE, $ATENVELDT, $MERIDIES, $CAID, $ANSTEORRA, $ATLANTIA, $AN_TIR, $CALONTIR, $TRIMARIS, $EALDORMERE, $OUTLANDS, $DRACHENWALD, $ARTEMISIA, $AETHELMEARC, $LOCHAC, $NORTHSHIELD;
   $arms = "";
   // Nothing, or polled - East, Meridies, Ansteorra, Calontir, Trimaris, Drachenwald, Aethelmearc, Northshield
   if ($type_id == $COUNTY)
   {
      if ($kingdom_id == $WEST || $kingdom_id == $ATENVELDT || $kingdom_id == $CAID || $kingdom_id == $ATLANTIA || $kingdom_id == $AN_TIR || $kingdom_id == $OUTLANDS || $kingdom_id == $ARTEMISIA || $kingdom_id == $EALDORMERE || $kingdom_id == $LOCHAC)
      {
         $arms = $POA;
      }
   }
   else if ($type_id == $COURT_BARONAGE_AOA || $type_id == $COURT_BARONAGE_GOA)
   {
      $arms = $AOA; // West, East, Middle, Atenveldt, Meridies, Caid, Atlantia, Calontir, Outlands, Drachenwald, Aethelmearc, Ealdormere, Lochac
      if ($kingdom_id == $ANSTEORRA || $kingdom_id == $AN_TIR || $kingdom_id == $TRIMARIS || $kingdom_id == $ARTEMISIA || $kingdom_id == $NORTHSHIELD)
      {
         $arms = $GOA;
      }
   }
   else if ($type_id == $LANDED_BARONAGE || $type_id == $RETIRED_BARONAGE)
   {
      // Nothing - West, East, Middle, Atenveldt, Meridies, Caid, Outlands, Drachenwald, Artemisia, Ealdormere, Lochac, Northshield
      // GOAs
      if ($kingdom_id == $ATLANTIA || $kingdom_id == $CALONTIR || $kingdom_id == $TRIMARIS || $kingdom_id == $AETHELMEARC)
      {
         $arms = $GOA;
      }
      // AOAs
      if ($kingdom_id == $AN_TIR)
      {
         $arms = $AOA;
      }
   }
   return $arms;
}

function get_rose_arms_by_kingdom($kingdom_id)
{
   global $POA, $GOA, $AOA;
   global $WEST, $EAST, $MIDDLE, $ATENVELDT, $MERIDIES, $CAID, $ANSTEORRA, $ATLANTIA, $AN_TIR, $CALONTIR, $TRIMARIS, $EALDORMERE, $OUTLANDS, $DRACHENWALD, $ARTEMISIA, $AETHELMEARC, $LOCHAC, $NORTHSHIELD;
   $arms = ""; // West, East, Middle, Atenveldt, Meridies, Caid, Ansteorra, An Tir, Calontir, Outlands, Artemisia, Aethelmearc, Ealdormere, Lochac, Northshield
   if ($kingdom_id == $ATLANTIA || $kingdom_id == $TRIMARIS)
   {
      $arms = $POA;
   }
   else if ($kingdom_id == $DRACHENWALD)
   {
      $arms = $AOA;
   }
   return $arms;
}

// TODO: what is this? Is it still relevant, or can we just scrag it as we should?
function is_order_award($award_id)
{
   global $ROSE, $ROSE_AOA, $ROSE_NO_ARMS, $LAUREL, $PELICAN, $KNIGHT, $M_AT_ARMS/* , $PEARL_ID, $PEARL_AOA_ID, $DOLPHIN_ID, $DOLPHIN_AOA_ID, $YEW_BOW_ID, $KRAKEN_ID, $SEA_STAG_ID, $WHITE_SCARF_ID */;

   $retval = false;
   switch($award_id)
   {
      case $ROSE:
      case $ROSE_AOA:
      case $ROSE_NO_ARMS:
      case $LAUREL:
      case $PELICAN:
      case $KNIGHT:
      case $M_AT_ARMS:
//      case $PEARL_ID:
//      case $PEARL_AOA_ID:
//      case $DOLPHIN_ID:
//      case $DOLPHIN_AOA_ID:
//      case $YEW_BOW_ID:
//      case $KRAKEN_ID:
//      case $SEA_STAG_ID:
//      case $WHITE_SCARF_ID:
         $retval = true;
         break;
   }
   return $retval;
}

function get_order_table($award_id)
{
   global $ROSE, $ROSE_AOA, $ROSE_NO_ARMS, $LAUREL, $PELICAN, $KNIGHT, $M_AT_ARMS/* , $PEARL_ID, $PEARL_AOA_ID, $DOLPHIN_ID, $DOLPHIN_AOA_ID, $YEW_BOW_ID, $KRAKEN_ID, $SEA_STAG_ID, $WHITE_SCARF_ID */;

   $order_table = "";
   switch($award_id)
   {
      case $ROSE:
      case $ROSE_AOA:
      case $ROSE_NO_ARMS:
         $order_table = "rose";
         break;
      case $LAUREL:
         $order_table = "laurel";
         break;
      case $PELICAN:
         $order_table = "pelican";
         break;
      case $KNIGHT:
      case $M_AT_ARMS:
         $order_table = "chivalry";
         break;
/*
      case $PEARL_ID:
      case $PEARL_AOA_ID:
         $order_table = "pearl";
         break;
      case $DOLPHIN_ID:
      case $DOLPHIN_AOA_ID:
         $order_table = "dolphin";
         break;
      case $YEW_BOW_ID:
         $order_table = "yewbow";
         break;
      case $KRAKEN_ID:
         $order_table = "kraken";
         break;
      case $SEA_STAG_ID:
         $order_table = "seastag";
         break;
      case $WHITE_SCARF_ID:
         $order_table = "whitescarf";
         break;
*/
   }
   return $order_table;
}

function get_order_access_field($award_id)
{
   global $ROSE, $ROSE_AOA, $ROSE_NO_ARMS, $LAUREL, $PELICAN, $KNIGHT, $M_AT_ARMS/* , $PEARL_ID, $PEARL_AOA_ID, $DOLPHIN_ID, $DOLPHIN_AOA_ID, $YEW_BOW_ID, $KRAKEN_ID, $SEA_STAG_ID, $WHITE_SCARF_ID */;

   $order_table = "";
   switch($award_id)
   {
      case $ROSE:
      case $ROSE_AOA:
      case $ROSE_NO_ARMS:
         $order_table = "rose";
         break;
      case $LAUREL:
         $order_table = "laurel";
         break;
      case $PELICAN:
         $order_table = "pelican";
         break;
      case $KNIGHT:
      case $M_AT_ARMS:
         $order_table = "chivalry";
         break;
/*
      case $PEARL_ID:
      case $PEARL_AOA_ID:
         $order_table = "pearl";
         break;
      case $DOLPHIN_ID:
      case $DOLPHIN_AOA_ID:
         $order_table = "dolphin";
         break;
      case $YEW_BOW_ID:
         $order_table = "yewbow";
         break;
      case $KRAKEN_ID:
         $order_table = "kraken";
         break;
      case $SEA_STAG_ID:
         $order_table = "seastag";
         break;
      case $WHITE_SCARF_ID:
         $order_table = "whitescarf";
         break;
*/
   }
   return $order_table;
}

function get_order_pending_field($award_id)
{
   global $ROSE, $ROSE_AOA, $ROSE_NO_ARMS, $LAUREL, $PELICAN, $KNIGHT, $M_AT_ARMS/* , $PEARL_ID, $PEARL_AOA_ID, $DOLPHIN_ID, $DOLPHIN_AOA_ID, $YEW_BOW_ID, $KRAKEN_ID, $SEA_STAG_ID, $WHITE_SCARF_ID */;

   $order_table = "";
   switch($award_id)
   {
      case $ROSE:
      case $ROSE_AOA:
      case $ROSE_NO_ARMS:
         $order_table = "rose_pend";
         break;
      case $PELICAN:
         $order_table = "pelican_pend";
         break;
      case $LAUREL:
         $order_table = "laurel_pend";
         break;
      case $KNIGHT:
      case $M_AT_ARMS:
         $order_table = "chivalry_pend";
         break;
/*
      case $PEARL_ID:
      case $PEARL_AOA_ID:
         $order_table = "pearl_pend";
         break;
      case $DOLPHIN_ID:
      case $DOLPHIN_AOA_ID:
         $order_table = "dolphin_pend";
         break;
      case $YEW_BOW_ID:
         $order_table = "yewbow_pend";
         break;
      case $KRAKEN_ID:
         $order_table = "kraken_pend";
         break;
      case $SEA_STAG_ID:
         $order_table = "seastag_pend";
         break;
      case $WHITE_SCARF_ID:
         $order_table = "whitescarf_pend";
         break;
*/
   }
   return $order_table;
}

function generate_court_time_pl($form_court_time)
{
   global $COURT_TIME_ALL, $COURT_TIME_MORNING, $COURT_TIME_AFTERNOON, $COURT_TIME_FIELD1, $COURT_TIME_FIELD2, $COURT_TIME_FIELD3, $COURT_TIME_EVENING, $COURT_TIME_FEAST;

   $sel = "";
   if (isset($form_court_time) && $form_court_time == $COURT_TIME_ALL) { $sel = " selected=\"selected\""; } else { $sel = ""; }
   echo '         <option id="' . $COURT_TIME_ALL . '" value="' . $COURT_TIME_ALL . '"' . $sel . '>' . translate_court_time($COURT_TIME_ALL) . '</option>';
   if (isset($form_court_time) && $form_court_time == 2) { $sel = " selected=\"selected\""; } else { $sel = ""; }
   echo '         <option id="' . $COURT_TIME_MORNING . '" value="' . $COURT_TIME_MORNING . '"' . $sel . '>' . translate_court_time($COURT_TIME_MORNING) . '</option>';
   if (isset($form_court_time) && $form_court_time == 3) { $sel = " selected=\"selected\""; } else { $sel = ""; }
   echo '         <option id="' . $COURT_TIME_AFTERNOON . '" value="' . $COURT_TIME_AFTERNOON . '"' . $sel . '>' . translate_court_time($COURT_TIME_AFTERNOON) . '</option>';
   if (isset($form_court_time) && $form_court_time == 5) { $sel = " selected=\"selected\""; } else { $sel = ""; }
   echo '         <option id="' . $COURT_TIME_FIELD1 . '" value="' . $COURT_TIME_FIELD1 . '"' . $sel . '>' . translate_court_time($COURT_TIME_FIELD1) . '</option>';
   if (isset($form_court_time) && $form_court_time == 6) { $sel = " selected=\"selected\""; } else { $sel = ""; }
   echo '         <option id="' . $COURT_TIME_FIELD2 . '" value="' . $COURT_TIME_FIELD2 . '"' . $sel . '>' . translate_court_time($COURT_TIME_FIELD2) . '</option>';
   if (isset($form_court_time) && $form_court_time == 7) { $sel = " selected=\"selected\""; } else { $sel = ""; }
   echo '         <option id="' . $COURT_TIME_FIELD3 . '" value="' . $COURT_TIME_FIELD3 . '"' . $sel . '>' . translate_court_time($COURT_TIME_FIELD3) . '</option>';
   if (isset($form_court_time) && $form_court_time == 10) { $sel = " selected=\"selected\""; } else { $sel = ""; }
   echo '         <option id="' . $COURT_TIME_EVENING . '" value="' . $COURT_TIME_EVENING . '"' . $sel . '>' . translate_court_time($COURT_TIME_EVENING) . '</option>';
   if (isset($form_court_time) && $form_court_time == 11) { $sel = " selected=\"selected\""; } else { $sel = ""; }
   echo '         <option id="' . $COURT_TIME_FEAST . '" value="' . $COURT_TIME_FEAST . '"' . $sel . '>' . translate_court_time($COURT_TIME_FEAST) . '</option>';
}

function generate_court_type_pl($form_court_type)
{
   global $COURT_TYPE_ROYAL, $COURT_TYPE_BARONIAL;

   $sel = "";
   if (isset($form_court_type) && $form_court_type == $COURT_TYPE_BARONIAL) { $sel = " selected=\"selected\""; } else { $sel = ""; }
   echo '         <option id="' . $COURT_TYPE_BARONIAL . '" value="' . $COURT_TYPE_BARONIAL . '"' . $sel . '>' . translate_court_type($COURT_TYPE_BARONIAL) . '</option>';
   if (isset($form_court_type) && $form_court_type == $COURT_TYPE_ROYAL) { $sel = " selected=\"selected\""; } else { $sel = ""; }
   echo '         <option id="' . $COURT_TYPE_ROYAL . '" value="' . $COURT_TYPE_ROYAL . '"' . $sel . '>' . translate_court_type($COURT_TYPE_ROYAL) . '</option>';
}

?>
