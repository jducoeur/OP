<?php
include_once("defines.php");
include_once("validation_format.php");

/**
 * Connect to DB as read-only user
 */
function db_connect()
{
   global $DBHOST, $DBNAME_UNIVERSITY, $DBUSER, $DBPASS;

   /* Connecting, selecting database */
   $link = mysql_connect($DBHOST, $DBUSER, $DBPASS)
      or die("Could not connect: " . mysql_error());
   mysql_select_db($DBNAME_UNIVERSITY) 
      or die("Could not select database.");
   return $link;
}

/**
 * Connect as admin user
 */
function db_admin_connect()
{
   global $DBHOST, $DBNAME_UNIVERSITY, $DBUSER_ADMIN, $DBPASS_ADMIN;

   /* Connecting, selecting database */
   $link = mysql_connect($DBHOST, $DBUSER_ADMIN, $DBPASS_ADMIN)
      or die("Could not connect: " . mysql_error());
   mysql_select_db($DBNAME_UNIVERSITY) 
      or die("Could not select database.");
   return $link;
}

/**
 * Disconnect from the database
 */
function db_disconnect($link)
{
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

function get_webminister_display($db_link)
{
   $retval = 'Web Minister (webminister AT atlantia.sca.org)';
   return $retval;
}

/**
 * Get the preferred SCA name (from Unified)
 * @param atlantian_id The Atlantian ID of the individual
 * @param sca_name The official SCA Name of the individual
 * @return String the preferred SCA name
 */
function get_preferred_sca_name($atlantian_id, $sca_name)
{
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
 * Function: display_officer
 */
function display_officer($officer_title)
{
   $link = db_connect();
   global $DBNAME_REGNUM;

   $query = "SELECT * FROM $DBNAME_REGNUM.goofs WHERE title = " . quote_smart($officer_title);
   $result = mysql_query($query) or die("Failed");
   $data = mysql_fetch_array($result, MYSQL_ASSOC);

   $title = stripslashes($data['title']);

   if (isset($data['term_end_date']))
   {
      $term_end_date = stripslashes($data['term_end_date']);
      $title .= " (" . date("m/y", strtotime($term_end_date)) . ")";
   }
   #display information
   echo '<b>'. $title .'</b><br/>';
   echo display_person($data);

   mysql_free_result($result);
   db_disconnect($link);
   return;
}

/**
 * Function: display_chancellor
 */
function display_chancellor()
{
   global $CHANCELLOR;
   display_officer($CHANCELLOR);
}

/**
 * Function: display_registrar
 */
function display_registrar()
{
   global $REGISTRAR;
   display_officer($REGISTRAR);
}

/**
 * Function: display_registrar
 */
function display_registrar_maddr()
{
   $link = db_connect();
   global $DBNAME_REGNUM, $REGISTRAR;

   $query = "SELECT * FROM $DBNAME_REGNUM.goofs WHERE title = " . quote_smart($REGISTRAR);
   $result = mysql_query($query) or die("Failed");
   $data = mysql_fetch_array($result, MYSQL_ASSOC);

   echo display_address($data);

   mysql_free_result($result);
   db_disconnect($link);
   return;
}

/**
 * Function: display_person
 */
function display_person($data)
{
   $honorific = stripslashes($data['honorific']);
   $sname = stripslashes($data['sname']);
   $mname = stripslashes($data['mname']);
   $addr = stripslashes($data['addr']);
   $city = stripslashes($data['city']);
   $state = stripslashes($data['state']);
   $zip = $data['zip'];
   $phone = $data['phone'];
   $nlt = $data['nlt'];
   $email = stripslashes($data['email']);
   $website = stripslashes($data['website']);
   $mpriv = $data['mpriv'];
   $apriv = $data['apriv'];
   $ppriv = $data['ppriv'];
   $epriv = $data['epriv'];
   $term_end_date = '';

   $disp_name = '';
   #Handle Null Values in Names
   if ($sname != '')
   {
      $disp_name = $sname;
      if ($honorific != '')
      {
         $disp_name = "$honorific $sname";
      }
   }
   if (($mpriv == 0) && ($mname != ''))
   {
      $disp_name .= " ($mname)";
   }
   if ($disp_name != '')
   {
      $disp_name .= "<br />";
   }

   $disp_addr = '';
   if ($apriv != 1)
   {
      $disp_addr = $addr .', '. $city .', '. $state .' '. $zip .'<br />';
   }

   $disp_phone = '';
   if ($ppriv != 1)
   {
      if ($nlt != '')
      {
         $disp_phone = 'Phone:  '. $phone .' ('. $nlt .')<br />';
      }
      else
      {
         $disp_phone = 'Phone:  '.$phone .'<br />';
      }
   }

   $disp_email = '';
   if ($epriv != 1)
   {
      $disp_email = priv_email($email);
   }

   $disp_web = '';
   if ($website != '')
   {
      $disp_web = "Web Site: " . display_url($website) . "<br />";
   }

   echo $disp_name . $disp_addr . $disp_phone . $disp_email . $disp_web;
   return;
}

/**
 * Function: display_address
 */
function display_address($data)
{
   $mname = stripslashes($data['mname']);
   $addr = stripslashes($data['addr']);
   $city = stripslashes($data['city']);
   $state = stripslashes($data['state']);
   $zip = $data['zip'];
   $mpriv = $data['mpriv'];
   $apriv = $data['apriv'];

   $disp_name = '';
   if (($mpriv == 0) && ($mname != ''))
   {
      $disp_name .= "$mname";
   }
   if ($disp_name != '')
   {
      $disp_name .= "<br />";
   }

   $disp_addr = '';
   if ($apriv != 1)
   {
      $disp_addr = $addr .'<br />'. $city .', '. $state .' '. $zip;
   }

   echo $disp_name . $disp_addr;
   return;
}

/**
 * Function: display_email
 */
function display_email($email)
{
   $edata = explode("@",$email);
   $user = $edata[0];
   $domain = $edata[1];

   $disp_email = '<a href="functions/mailto.php?u='.$user .'&amp;d='. $domain .'" target="redir">'. $user .' AT '. $domain .'</a>';
   return($disp_email);
}

/**
 * Function: priv_email
 */
function priv_email($email)
{
   $disp_email = 'Email:  ' . display_email($email) . '<br/>';
   return($disp_email);
}

/**
 * Function: display_url
 */
function display_url($url)
{
   $disp_url = '<a href="' . $url . '">'. $url .'</a>';
   return($disp_url);
}

/**
 * Determine the title of a given person on the given date
 * NOTE: YOU MUST BE CONNECTED TO THE DB ALREADY TO RUN THIS FUNCTION
 * @param atlantian_id The ID of the Atlantian
 * @param checkdate The date for which the title should be retrieved
 * @return String The title of the Pontoon on the given date
 */
function get_title($atlantian_id, $checkdate)
{
   global $MALE, $FEMALE, $RETIRED_BARONAGE_ID, $LANDED_BARONAGE_ID, $FOUNDING_BARON, $FOUNDING_BARONESS, $LORD, $LADY, $ORDER_MERIT_P, $ORDER_HIGH_MERIT, $ORDER_HIGH_MERIT_P, $ATLANTIA_NAME, $GOA_DATE, $COURT_BARONAGE_AOA, $COURT_BARONAGE_GOA, $GOA;

   $title = NULL;
   /* Performing SQL query */
   $titlequery = 
      "SELECT atlantian.gender, title.title_male, title.title_female, award.award_id, award.type_id, atlantian_award.branch_id, atlantian_award.award_date, atlantian_award.sequence, atlantian_award.premier, precedence.precedence ".
      "FROM $DBNAME_AUTH.atlantian JOIN $DBNAME_OP.atlantian_award ON atlantian.atlantian_id = atlantian_award.atlantian_id ".
      "JOIN $DBNAME_OP.award ON atlantian_award.award_id = award.award_id ".
      "JOIN $DBNAME_OP.precedence ON award.type_id = precedence.type_id ".
      "LEFT OUTER JOIN $DBNAME_OP.title ON award.title_id = title.title_id ".
      "WHERE atlantian.atlantian_id = ". $atlantian_id . " ".
      "AND atlantian_award.award_date <= \"". $checkdate . "\" ".
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
 * Returns the name of the Kingdom where of the given group is located
 * YOU MUST ALREADY HAVE A DATABASE CONNECTION BEFORE USING THIS METHOD
 * @param branch_id The ID of the branch for which to get the kingdom name
 * @return String The name of the kingdom
 */
function get_kingdom($branch_id)
{
   global $BT_KINGDOM, $DBNAME_BRANCH;
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
   global $BT_KINGDOM, $DBNAME_BRANCH;
   $group_name = "";

   if (trim($branch_id) != "")
   {
      /* Performing SQL query */
      $query = "SELECT branch_id, branch, branch_type_id, parent_branch_id FROM $DBNAME_BRANCH.branch WHERE branch_id = ";

      $result = mysql_query($query . $branch_id) 
         or die("Branch Query failed : " . mysql_error());

      $data = mysql_fetch_array($result, MYSQL_BOTH);
      $branch_type_id = trim($data['branch_type_id']);
      $branch_id = trim($data['parent_branch_id']);
      $group_name = clean($data['branch']);
   }

   return $group_name;
}

/**
 * Returns the university ID of the next session after the given one
 * YOU MUST ALREADY HAVE A DATABASE CONNECTION BEFORE USING THIS METHOD
 * @param university_id The ID of the session at which the degree was earned
 * @return number The university_id of the awarding university
 */
function get_next_university($university_id)
{
   global $DBNAME_UNIVERSITY;
   $next_u_id = 0;

   if ($university_id != "")
   {
      /* Performing SQL query */
      $query = "SELECT university_id FROM $DBNAME_UNIVERSITY.university WHERE is_university = 1 AND university_date = " .
               "(SELECT MIN(university_date) FROM $DBNAME_UNIVERSITY.university WHERE is_university = 1 AND university_date > " .
               "(SELECT university_date FROM $DBNAME_UNIVERSITY.university WHERE university_id = " . $university_id . "))";
      $result = mysql_query($query) 
         or die("Next University Query failed: " . mysql_error());
      $num_recs = mysql_num_rows($result);
      if ($num_recs > 0)
      {
         $data = mysql_fetch_array($result, MYSQL_BOTH);
         $next_u_id = clean($data['university_id']);
      }
   }

   return $next_u_id;
}
?>
