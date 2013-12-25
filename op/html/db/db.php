<?php
include_once("defines.php");
include_once("validation_format.php");

$DBNAME_OP = 'atlantia_op';
$DBNAME_AUTH = 'atlantia_auth';
$DBNAME_BRANCH = 'atlantia_branch';
$DBNAME_ORDER = 'atlantia_order';
$DBNAME_SPIKE = 'atlantia_spike';
$DBNAME_UNIVERSITY = 'atlantia_university';
$DBNAME_WARRANT = 'atlantia_warrant';
$DBNAME = $DBNAME_OP;

/* TODO: you need to copy db_conn.php.template to db_conn.php, and fill in the
 * actual connection info: */
include_once("db_conn.php");

// DEPRECATED: switch to db_new_connect:
function db_connect()
{
   global $DBHOST, $DBNAME, $DBUSER, $DBPASS;

   /* Connecting, selecting database */
   $link = mysql_connect($DBHOST, $DBUSER, $DBPASS)
      or die("Could not connect: " . mysql_error());
   mysql_select_db($DBNAME) 
      or die("Could not select database");
   //echo "DEBUG: Open OP DB (Default): $link<br/>";
   return $link;
}

function db_new_connect()
{
   global $DBHOST, $DBNAME, $DBUSER, $DBPASS;

   $mysqli = mysqli_init();
   if (!$mysqli) {
     die('mysqli_init failed');
   }

   if (!$mysqli->real_connect($DBHOST, $DBUSER, $DBPASS, $DBNAME)) {
      die('Connect Error (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
   }
   
   return $mysqli;
}

// From this page:
//   http://www.php.net/manual/en/mysqli.prepare.php
function mysqli_prepared_query($link,$sql,$typeDef = FALSE,$params = FALSE){ 
  if($stmt = mysqli_prepare($link,$sql)){ 
    if(count($params) == count($params,1)){ 
      $params = array($params); 
      $multiQuery = FALSE; 
    } else { 
      $multiQuery = TRUE; 
    }  
    
    if($typeDef){ 
      $bindParams = array();    
      $bindParamsReferences = array(); 
      $bindParams = array_pad($bindParams,(count($params,1)-count($params))/count($params),"");         
      foreach($bindParams as $key => $value){ 
        $bindParamsReferences[$key] = &$bindParams[$key];  
      } 
      array_unshift($bindParamsReferences,$typeDef); 
      $bindParamsMethod = new ReflectionMethod('mysqli_stmt', 'bind_param'); 
      $bindParamsMethod->invokeArgs($stmt,$bindParamsReferences); 
    } 
    
    $result = array(); 
    foreach($params as $queryKey => $query){ 
      foreach($bindParams as $paramKey => $value){ 
        $bindParams[$paramKey] = $query[$paramKey]; 
      } 
      $queryResult = array(); 
      if(mysqli_stmt_execute($stmt)){ 
        $resultMetaData = mysqli_stmt_result_metadata($stmt); 
        if($resultMetaData){                                                                               
          $stmtRow = array();   
          $rowReferences = array(); 
          while ($field = mysqli_fetch_field($resultMetaData)) { 
            $rowReferences[] = &$stmtRow[$field->name]; 
          }                                
          mysqli_free_result($resultMetaData); 
          $bindResultMethod = new ReflectionMethod('mysqli_stmt', 'bind_result'); 
          $bindResultMethod->invokeArgs($stmt, $rowReferences); 
          while(mysqli_stmt_fetch($stmt)){ 
            $row = array(); 
            foreach($stmtRow as $key => $value){ 
              $row[$key] = $value;           
            } 
            $queryResult[] = $row; 
          } 
          mysqli_stmt_free_result($stmt); 
        } else { 
          $queryResult[] = mysqli_stmt_affected_rows($stmt); 
        } 
      } else { 
        $queryResult[] = FALSE; 
      } 
      $result[$queryKey] = $queryResult; 
    } 
    mysqli_stmt_close($stmt);   
  } else { 
    $result = FALSE; 
  } 
  
  if($multiQuery){ 
    return $result; 
  } else { 
    return $result[0]; 
  } 
} 

function db_admin_connect()
{
   global $DBHOST, $DBNAME, $DBUSER_ADMIN, $DBUSER_PASS;

   /* Connecting, selecting database */
   $link = mysql_connect($DBHOST, $DBUSER_ADMIN, $DBUSER_PASS)
      or die("Could not connect: " . mysql_error());
   mysql_select_db($DBNAME) 
      or die("Could not select database");
   //echo "DEBUG: Open OP DB: $link<br/>";
   return $link;
}

function db_disconnect($link)
{
   //echo "DEBUG: Close DB connection: $link<br/>";
   mysql_close($link);
}

function generate_password($uname)
{
   srand((double)microtime()*1000000);
   $ran = rand(0,1000000);
   $npasswd = "$ran$uname";
   $passwd = substr(md5($npasswd),0, 16);
   return $passwd;
}

/**
 * Determine the title of a given person on the given date
 * NOTE: YOU MUST BE CONNECTED TO THE DB ALREADY TO RUN THIS FUNCTION
 * @param atlantian_id The ID of the Pontoon
 * @param checkdate The date for which the title should be retrieved
 * @return String The title of the Pontoon on the given date
 */
function get_title($atlantian_id, $checkdate)
{
   global $DBNAME_AUTH, $DBNAME_OP, $DBNAME_BRANCH, $DBNAME_ORDER;
   global $MALE, $FEMALE, $RETIRED_BARONAGE_ID, $LANDED_BARONAGE_ID, $FOUNDING_BARON, $FOUNDING_BARONESS, $LORD, $LADY, $ORDER_MERIT_P, $ORDER_HIGH_MERIT, $ORDER_HIGH_MERIT_P, $ATLANTIA_NAME, /*$GOA_DATE,*/ $COURT_BARONAGE_AOA, $COURT_BARONAGE_GOA, $GOA;

   $title = NULL;
   /* Performing SQL query */
   $titlequery = 
      "SELECT atlantian.gender, title.title_male, title.title_female, award.award_id, award.type_id, atlantian_award.branch_id, atlantian_award.award_date, atlantian_award.sequence, atlantian_award.premier, precedence.precedence ".
      "FROM $DBNAME_AUTH.atlantian JOIN $DBNAME_OP.atlantian_award ON atlantian.atlantian_id = atlantian_award.atlantian_id ".
      "JOIN $DBNAME_OP.award ON atlantian_award.award_id = award.award_id ".
      "JOIN $DBNAME_OP.precedence ON award.type_id = precedence.type_id ".
      "LEFT OUTER JOIN $DBNAME_OP.title ON award.title_id = title.title_id ".
      "WHERE atlantian.atlantian_id = ". $atlantian_id . " ".
      "AND atlantian_award.award_date <= '". $checkdate . "' ".
      "AND atlantian_award.resigned_date IS NULL ".
      "AND atlantian_award.revoked_date IS NULL ".
      "ORDER BY precedence, award_date, sequence";

   $titleresult = mysql_query($titlequery) 
      or die("Title Query failed : " . mysql_error());

   $titledata = mysql_fetch_array($titleresult, MYSQL_BOTH);

   $award_id = $titledata['award_id'];
   $premier = $titledata['premier'];
   $gender = $titledata['gender'];

   // Retired B&B is highest award
   if ($award_id == $RETIRED_BARONAGE_ID || $award_id == $LANDED_BARONAGE_ID)
   {
      // If Founding B&B, use Founding B&B title
      if ($premier == 1)
      {
         $branch_id = $titledata['branch_id'];
         if ($gender == $MALE)
         {
            $title = $FOUNDING_BARON . get_branch_name($branch_id);
         }
         else if ($gender == $FEMALE)
         {
            $title = $FOUNDING_BARONESS . get_branch_name($branch_id);
         }
      }
      // Otherwise, for non-founding retired B&Bs, move on to next highest award for a title
      else if ($award_id == $RETIRED_BARONAGE_ID && $premier == 0)
      {
         $titledata = mysql_fetch_array($titleresult, MYSQL_BOTH);
         $award_id = $titledata['award_id'];
         $premier = $titledata['premier'];
      }
   }

   // If founding B&B is not highest award, move on.
   if ($title == NULL)
   {
      if ($gender == $MALE)
      {
         $title_field = "title_male";
      }
      else if ($gender == $FEMALE)
      {
         $title_field = "title_female";
      }
      else // unknown gender - return empty string
      {
         $title = "";
         return $title;
      }
      $title = clean($titledata[$title_field]);
      $type_id = $titledata['type_id'];
      $precedence = $titledata['precedence'];
      $award_date = $titledata['award_date'];

      // If less than a Peerage, check if there is a Court Baronage after it, as that title tends to override
      if ($precedence >= $ORDER_HIGH_MERIT_P)
      {
         $titledata3 = mysql_fetch_array($titleresult, MYSQL_BOTH);
         while ($titledata3 != NULL && $titledata3['type_id'] != $COURT_BARONAGE_AOA && $titledata3['type_id'] != $COURT_BARONAGE_GOA)
         {
            $titledata3 = mysql_fetch_array($titleresult, MYSQL_BOTH);
         }
         if ($titledata3['type_id'] == $COURT_BARONAGE_AOA || $titledata3['type_id'] == $COURT_BARONAGE_GOA)
         {
            $title = clean($titledata3[$title_field]);
         }
      }
   }
   /* Free resultset */
   mysql_free_result($titleresult);

   return $title;
}

/**
 * Determine the current title of a given person
 * NOTE: YOU MUST BE CONNECTED TO THE DB ALREADY TO RUN THIS FUNCTION
 * @param atlantian_id The ID of the Atlantian
 * @return String The current title of the Atlantian
 */
function get_current_title($atlantian_id)
{
   $checkdate = date('Y-m-d');
   return get_title($atlantian_id, $checkdate);
}

/**
 * Get a list of Baronage of a given Barony
 * @param barony_id The Branch ID of the barony
 * @return Array An array of baron and baronesses keyed by investiture date.sequence
 */
function get_baronage($barony_id, $link)
{
   global $DBNAME_AUTH, $DBNAME_OP, $DBNAME_BRANCH, $DBNAME_ORDER;
   global $TERRITORIAL_BARONAGE, $MALE;

   $disconnect = false;
   if ($link == NULL)
   {
      /* Connecting, selecting database */
      $link = db_connect();
      $disconnect = true;
   }

   $baronage = array();
   /* Performing SQL query */
   $query = 
      "SELECT atlantian.atlantian_id, atlantian.sca_name, atlantian.gender, atlantian_award.award_date, atlantian_award.sequence ".
      "FROM $DBNAME_AUTH.atlantian, $DBNAME_OP.award, $DBNAME_OP.atlantian_award ".
      "WHERE award.award_id = atlantian_award.award_id ".
      "AND atlantian.atlantian_id = atlantian_award.atlantian_id ".
      "AND award.award_id IN (". $TERRITORIAL_BARONAGE . ") ".
      "AND atlantian_award.branch_id = " . $barony_id . " ".
      "ORDER BY award_date, gender DESC";

   $result = mysql_query($query) 
      or die("Baronage Query failed : " . mysql_error());

   while ($data = mysql_fetch_array($result, MYSQL_BOTH))
   {
      $award_date = $data['award_date'] . '.' . str_pad($data['sequence'], 2, '0', STR_PAD_LEFT);
      if (array_key_exists($award_date, $baronage))
      {
         if ($data['gender'] == $MALE)
         {
            $baronage[$award_date]['baron'] = $data['sca_name'];
         }
         else
         {
            $baronage[$award_date]['baroness'] = $data['sca_name'];
         }
      }
      else
      {
         $bar = array();
         if ($data['gender'] == $MALE)
         {
            $bar['baron'] = clean($data['sca_name']);
         }
         else
         {
            $bar['baroness'] = clean($data['sca_name']);
         }
         $baronage[$award_date] = $bar;
      }
   }

   /* Free resultset */
   mysql_free_result($result);

   if ($disconnect)
   {
      /* Closing connection */
      db_disconnect($link);
   }

   return $baronage;
}

/**
 * Returns investiture date.sequence (key to array returned by get_baronage function)
 * of the Baron and Baroness of the given barony on checkdate
 * @param baronage The baronage array returned by get_baronage()
 * @param checkdate The date for which the title should be retrieved (optionally appended by a period and the sequence)
 * @return Date The investiture date of the baron and baroness as of checkdate
 */
function get_baronage_by_date($baronage, $checkdate)
{
   $date_key = NULL;
   $date_array = array_keys($baronage);
   $prev_value = NULL;

   foreach ($date_array as $key => $value) 
   {
      if ($checkdate <= $value)
      {
         $date_key = $prev_value;
         break;
      }
      $prev_value = $value;
   }
   // Not in the past?  Must be the current set!
   if ($date_key === NULL)
   {
      $date_key = $prev_value;
   }
   return $date_key;
}

/**
 * Get founding Baronage of a given Barony
 * @param barony_id The Branch ID of the barony
 * @return Array An array of baron and baronesses keyed by investiture date.sequence
 */
function get_founding_baronage($barony_id, $link)
{
   global $DBNAME_AUTH, $DBNAME_OP, $DBNAME_BRANCH, $DBNAME_ORDER;
   global $TERRITORIAL_BARONAGE, $MALE;

   $disconnect = false;
   if ($link == NULL)
   {
      /* Connecting, selecting database */
      $link = db_connect();
      $disconnect = true;
   }

   $baronage = array();
   /* Performing SQL query */
   $query = 
      "SELECT baron.atlantian_id as baron_id, baron.sca_name as baron_name, baroness.atlantian_id as baroness_id, baroness.sca_name as baroness_name " .
      "FROM $DBNAME_OP.baronage LEFT OUTER JOIN $DBNAME_AUTH.atlantian baron ON baron.atlantian_id = baronage.baron_id " .
      "LEFT OUTER JOIN $DBNAME_AUTH.atlantian baroness ON baroness.atlantian_id = baronage.baroness_id " .
      "WHERE baronage.branch_id = " . $barony_id . " " .
      "AND baronage_start_date = (SELECT MIN(baronage_start_date) FROM $DBNAME_OP.baronage WHERE baronage.branch_id = " . $barony_id . ")";

   $result = mysql_query($query) 
      or die("Founding Baronage Query failed : " . mysql_error());

   while ($data = mysql_fetch_array($result, MYSQL_BOTH))
   {
      $baronage['baron'] = clean($data['baron_name']);
      $baronage['baron_id'] = $data['baron_id'];
      $baronage['baroness'] = clean($data['baroness_name']);
      $baronage['baroness_id'] = $data['baroness_id'];
   }

   /* Free resultset */
   mysql_free_result($result);

   if ($disconnect)
   {
      /* Closing connection */
      db_disconnect($link);
   }

   return $baronage;
}

/**
 * Returns the name of the Kingdom where of the given group is located
 * YOU MUST ALREADY HAVE A DATABASE CONNECTION BEFORE USING THIS METHOD
 * @param branch_id The ID of the branch for which to get the kingdom name
 * @return String The name of the kingdom
 */
function get_kingdom($branch_id)
{
   global $DBNAME_AUTH, $DBNAME_OP, $DBNAME_BRANCH, $DBNAME_ORDER;
   global $BT_KINGDOM;
   $kingdom = "";

   if (trim($branch_id) != "")
   {
      /* Performing SQL query */
      $query = "SELECT branch_id, branch, branch_type_id, parent_branch_id FROM $DBNAME_BRANCH.branch WHERE branch_id = ";

      $result = mysql_query($query . $branch_id) 
         or die("Kingdom Query failed : " . mysql_error());

      $data = mysql_fetch_array($result, MYSQL_BOTH);
      $branch_type_id = trim($data['branch_type_id']);
      $branch_id = trim($data['parent_branch_id']);
      $kingdom = clean($data['branch']);
      while ($branch_type_id != $BT_KINGDOM)
      {
         $result = mysql_query($query . $branch_id) 
            or die("Kingdom Query failed : " . mysql_error());

         $data = mysql_fetch_array($result, MYSQL_BOTH);
         $branch_type_id = trim($data['branch_type_id']);
         $branch_id = trim($data['parent_branch_id']);
         $kingdom = clean($data['branch']);
      }
   }

   return $kingdom;
}

/**
 * Returns the name of the group where of the given ID
 * YOU MUST ALREADY HAVE A DATABASE CONNECTION BEFORE USING THIS METHOD
 * @param branch_id The ID of the branch for which to get the group name
 * @return String The name of the group
 */
function get_branch_name($branch_id)
{
   global $DBNAME_AUTH, $DBNAME_OP, $DBNAME_BRANCH, $DBNAME_ORDER;
   global $BT_KINGDOM;
   $branch_name = "";

   if (trim($branch_id) != "")
   {
      /* Performing SQL query */
      $query = "SELECT branch_id, branch, branch_type_id, parent_branch_id FROM $DBNAME_BRANCH.branch WHERE branch_id = ";

      $result = mysql_query($query . $branch_id) 
         or die("Branch Query failed : " . mysql_error());

      $data = mysql_fetch_array($result, MYSQL_BOTH);
      $branch_type_id = trim($data['branch_type_id']);
      $branch_id = trim($data['parent_branch_id']);
      $branch_name = clean($data['branch']);
   }

   return $branch_name;
}

/*
   Display monarch data
   db_link - database connection, if already open
   reign_id - DB ID of monarchs
   date_flag - true if dates of reign should be displayed
*/
function display_monarchs($db_link, $reign_id, $date_flag)
{
   global $DBNAME_AUTH, $DBNAME_OP, $DBNAME_BRANCH, $DBNAME_ORDER;
   $retval = '';
   $disconnect = false;
   if ($db_link == null)
   {
      $db_link = db_connect();
      $disconnect = true;
   }
   $query = "SELECT reign_id, king_id, queen_id, k.sca_name as king, q.sca_name as queen, monachs_display, reign_start_date, reign_end_date " .
      "FROM $DBNAME_OP.reign r, $DBNAME_AUTH.atlantian k, $DBNAME_AUTH.atlantian q " .
      "WHERE r.king_id = k.atlantian_id " .
      "AND r.queen_id = q.atlantian_id " .
      "AND r.reign_id = $reign_id";

   $result = mysql_query($query) 
      or die ("Monarchs Query failed : " . mysql_error());
   $count = mysql_num_rows($result);

   if ($count > 0)
   {
      $data = mysql_fetch_array($result, MYSQL_BOTH);
      if ($date_flag)
      {
         $retval = display_monarchs_with_dates($data);
      }
      else
      {
         $retval = display_monarchs_without_dates($data);
      }
   }

   /* Free resultset */
   mysql_free_result($result);

   if ($disconnect)
   {
      /* Closing connection */
      db_disconnect($db_link);
   }

   return $retval;
}

function display_monarchs_without_dates($row)
{
   $retval = clean($row['monarchs_display']);
   return $retval;
}

function display_monarchs_with_dates($row)
{
   $retval = display_monarchs_without_dates($row) . 
      " (" . format_short_date($row['reign_start_date']) . " - ";
   if ($row['reign_end_date'] != '')
   {
      $retval .= format_short_date($row['reign_end_date']) . ")";
   }
   else
   {
      $retval .= "present)";
   }
   return $retval;
}

function get_webminister_display($db_link)
{
   $retval = 'Web Minister (webminister AT atlantia.sca.org)';
   return $retval;
}

/**
 * Determine if the award is one we display
 * @param award_id The ID of the Award
 * @param type_id The ID of the Award Precedence Type
 * @param kingdom The name of the kingdom that bestowed the award
 * @return boolean True if the award should be linked
 */
function is_award_linkable($award_id, $award_group_id, $type_id, $kingdom)
{
   $retval = false;
   global $ATLANTIA_NAME, $POA, $DUCAL, $COUNTY, $VISCOUNTY, $BESTOWED_PEER, $DUCAL_ID, $LANDED_BARONAGE, $RETIRED_BARONAGE, $COURT_BARONAGE_AOA, $AOA, $GOA, $SUPPORTERS, $AUG, $BARONIAL_AWARD;

   // If the award is an Atlantian award, it's displayable
   if ($kingdom == $ATLANTIA_NAME && $type_id >= $DUCAL)
   {
      $retval = true;
   }
   // Royal Peers displayable
   else if (($type_id == $DUCAL) || ($type_id == $COUNTY) || ($type_id == $VISCOUNTY))
   {
      $retval = true;
   }
   // Bestowed Peers displayable
   else if ($type_id == $BESTOWED_PEER)
   {
      $retval = true;
   }
   // Baronage displayable
   else if (($type_id == $LANDED_BARONAGE) || ($type_id == $RETIRED_BARONAGE) || ($type_id == $COURT_BARONAGE_AOA))
   {
      $retval = true;
   }
   // Arms are displayable
   else if (($award_id == $AOA) || ($award_id == $GOA) || ($award_id == $POA) || ($award_id == $SUPPORTERS) || ($award_id == $AUG))
   {
      $retval = true;
   }
   else if ($award_group_id > 0)
   {
      $retval = true;
   }

   return $retval;
}

/**
 * Determine if the award is gender specific
 * @param award_id The ID of the Award
 * @param award_group_id The ID of the Award Group
 * @param type_id The ID of the Award Precedence Type
 * @return boolean True if the award is gender specific
 */
function is_award_gender_specific($award_id, $award_group_id, $type_id)
{
   return true;
/* I can find no reason for this silly hardcoding, which isn't correct for the East anyway. We
   should simply use what we find in the DB to match the award.
   $retval = false;
   global $MONARCH, $HEIR, $PPRINCE, $PHEIR, $DUCAL, $COUNTY, $VISCOUNTY, $M_AT_ARMS, $LAUREL, $PELICAN, $LANDED_BARONAGE, $RETIRED_BARONAGE, $COURT_BARONAGE_AOA, $COURT_BARONAGE_GOA, $ROSE, $ROSE_AOA, $ROSE_NO_ARMS, $ROSE_GROUP;

   // Royal Peers gender-specific
   if (($type_id == $MONARCH) || ($type_id == $HEIR) || ($type_id == $PHEIR) || ($type_id == $DUCAL) || ($type_id == $COUNTY) || ($type_id == $VISCOUNTY))
   {
      $retval = true;
   }
   // Master/Mistress gender-specific
   else if ($award_id == $M_AT_ARMS || $award_id == $LAUREL || $award_id == $PELICAN)
   {
      $retval = true;
   }
   // Order of the Rose gender-specific
   else if (($award_id == $ROSE) || ($award_id == $ROSE_AOA) || ($award_id == $ROSE_NO_ARMS) || ($award_group_id == $ROSE_GROUP))
   {
      $retval = true;
   }
   // Baronage gender-specific
   else if (($type_id == $LANDED_BARONAGE) || ($type_id == $RETIRED_BARONAGE) || ($type_id == $COURT_BARONAGE_AOA) || ($type_id == $COURT_BARONAGE_GOA))
   {
      $retval = true;
   }

   return $retval;
*/
}

/**
 * Get the preferred SCA name (from Unified)
 * @param atlantian_id The Atlantian ID of the individual
 * @param sca_name The official SCA Name of the individual
 * @return String the preferred SCA name
 *
 * TODO (JustinDuC 3/5/13): I have commented out most uses of this, because they are happening inside
 *   tight loops and are simply driving the DB to its knees and causing timeouts. At *least*, this should be using the
 *   existing database connection; really, it should be incorporated into the larger queries, where
 *   it would typically take a fraction of a second.
 */
function get_preferred_sca_name($atlantian_id, $sca_name)
{
   global $DBNAME_AUTH, $DBNAME_OP, $DBNAME_BRANCH, $DBNAME_ORDER;
   /* Connecting, selecting database */
   $link = db_connect();

   $preferred_name = "";
   /* Performing SQL query */
   $query = 
      "SELECT atlantian.preferred_sca_name ".
      "FROM $DBNAME_AUTH.atlantian ".
      "WHERE atlantian.atlantian_id = " . $atlantian_id;

   $result = mysql_query($query) 
      or die("Preferred SCA Name Query failed : " . mysql_error());

   $data = mysql_fetch_array($result, MYSQL_BOTH);
   $preferred_name = clean($data['preferred_sca_name']);
   if ($preferred_name != "" && $preferred_name != $sca_name)
   {
      $preferred_name = " [" . $preferred_name . "]";
   }
   else
   {
      $preferred_name = "";
   }

   /* Free resultset */
   mysql_free_result($result);

   /* Closing connection */
   db_disconnect($link);

   return $preferred_name;
}

/**
* Quote a variable to make it safe for SQL
*/
function quote_smart($value)
{
   // Stripslashes if we need to
   if (get_magic_quotes_gpc()) 
   {
      $value = stripslashes($value);
   }

   // Quote it if it's not a number
   if (!is_numeric($value)) 
   {
      $value = "'" . mysql_real_escape_string(trim($value)) . "'";
   }

   return $value;
}

function new_quote_smart($mysqli, $value)
{
   // Stripslashes if we need to
   if (get_magic_quotes_gpc()) 
   {
      $value = stripslashes($value);
   }

   // Quote it if it's not a number
   if (!is_numeric($value)) 
   {
      $value = "'" . $mysqli->real_escape_string(trim($value)) . "'";
   }

   return $value;
}

/**
* Quote a variable to make it safe for SQL within a LIKE
*/
function quote_like($value)
{
   // Stripslashes if we need to
   if (get_magic_quotes_gpc()) 
   {
      $value = stripslashes($value);
   }

   // Quote it if it's not a number
   if (!is_numeric($value)) 
   {
      $value = "'%" . mysql_real_escape_string(trim($value)) . "%'";
   }

   return $value;
}

/**
* Quote a variable to make it safe for SQL within a LIKE
*/
function quote_begins_like($value)
{
   // Stripslashes if we need to
   if (get_magic_quotes_gpc()) 
   {
      $value = stripslashes($value);
   }

   // Quote it if it's not a number
   if (!is_numeric($value)) 
   {
      $value = "'" . mysql_real_escape_string(trim($value)) . "%'";
   }

   return $value;
}

/**
* Quote a variable to make it right for CSV load
*/
function csv_quote($value)
{
   // Stripslashes if we need to
   if (get_magic_quotes_gpc()) 
   {
      $value = stripslashes($value);
   }

   // Double quote it if it's not a number
   if (!is_numeric($value)) 
   {
      $value = "\"" . str_replace('"', '""', $value) . "\"";
   }

   return $value;
}

function format_mysql_date($date_field)
{
   return date("Y-m-d", strtotime($date_field));
}

function translate_court_time($court_time)
{
   global $COURT_TIME_ALL, $COURT_TIME_MORNING, $COURT_TIME_AFTERNOON, $COURT_TIME_FIELD1, $COURT_TIME_FIELD2, $COURT_TIME_FIELD3, $COURT_TIME_EVENING, $COURT_TIME_FEAST;

   $ct = "";
   switch ($court_time)
   {
      case $COURT_TIME_ALL:
         $ct = "All";
         break;
      case $COURT_TIME_MORNING:
         $ct = "Morning";
         break;
      case $COURT_TIME_AFTERNOON:
         $ct = "Afternoon";
         break;
      case $COURT_TIME_FIELD1:
         $ct = "Field";
         break;
      case $COURT_TIME_FIELD2:
         $ct = "Field 2";
         break;
      case $COURT_TIME_FIELD3:
         $ct = "Field 3";
         break;
      case $COURT_TIME_EVENING:
         $ct = "Evening";
         break;
      case $COURT_TIME_FEAST:
         $ct = "Feast";
         break;
   }
   return $ct;
}

function translate_court_type($court_type)
{
   global $COURT_TYPE_ROYAL, $COURT_TYPE_BARONIAL;

   $ct = "";
   switch ($court_type)
   {
      case $COURT_TYPE_BARONIAL:
         $ct = "Baronial";
         break;
      case $COURT_TYPE_ROYAL:
         $ct = "Royal";
         break;
   }
   return $ct;
}

/**
 * Returns the name of the group of the given baronage
 * YOU MUST ALREADY HAVE A DATABASE CONNECTION BEFORE USING THIS METHOD
 * @param baronage_id The ID of the baronage for which to get the group name
 * @return String The name of the group
 */
function get_barony_name_from_baronage_id($baronage_id)
{
   global $DBNAME_AUTH, $DBNAME_OP, $DBNAME_BRANCH, $DBNAME_ORDER;
   $branch_name = "";

   if (trim($baronage_id) != "")
   {
      /* Performing SQL query */
      $query = "SELECT branch FROM $DBNAME_BRANCH.branch JOIN $DBNAME_OP.baronage ON branch.branch_id = baronage.branch_id WHERE baronage_id = ";

      $result = mysql_query($query . $baronage_id) 
         or die("Branch Query failed : " . mysql_error());

      $data = mysql_fetch_array($result, MYSQL_BOTH);
      $branch_name = clean($data['branch']);
   }

   return $branch_name;
}

/**
 * Converts the array data into a comma separated list suitable for an SQL IN clause
 */
function create_in_clause_from_array($arr)
{
   $in_clause = "";
   for ($i = 0; $i < count($arr); $i++)
   {
      if (strlen($in_clause) > 0)
      {
         $in_clause .= ",";
      }
      $in_clause .= $arr[$i];
   }
   return $in_clause;
}
?>
