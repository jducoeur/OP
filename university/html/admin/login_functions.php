<?
include_once('../db/db.php');
include_once('db.php');
include_once('admin.php');
/** 
 * Authenticates user to database
 */
function user_auth($adminuser, $paswd)
{
   global $DBNAME_AUTH, $DBNAME_ORDER;
   global $LOCKOUT, $OP_ADMIN, $BACKLOG_ADMIN, $AWARD_ADMIN, $SPIKE_ADMIN, $UNIVERSITY_ADMIN;
   global $SENESCHAL_ADMIN, $EXCHEQUER_ADMIN, $HERALD_ADMIN, $MARSHAL_ADMIN, $MOL_ADMIN;
   global $MOAS_ADMIN, $CHRONICLER_ADMIN, $CHIRURGEON_ADMIN, $WEBMINISTER_ADMIN, $CHATELAINE_ADMIN;
   global $CHIVALRY_ADMIN, $LAUREL_ADMIN, $PELICAN_ADMIN, $ROSE_ADMIN;
   global $WHITESCARF_ADMIN, $PEARL_ADMIN, $DOLPHIN_ADMIN, $KRAKEN_ADMIN, $SEASTAG_ADMIN, $YEWBOW_ADMIN;

   $retval = false;
   /* Connecting, selecting database */
   $link = db_admin_connect();

   $auth_query = 
      "SELECT user_auth.*, chivalry.chivalry_id, laurel.laurel_id, pelican.pelican_id, rose.rose_id, " .
             "whitescarf.whitescarf_id, pearl.pearl_id, dolphin.dolphin_id, " .
             "kraken.kraken_id, seastag.seastag_id, yewbow.yewbow_id " .
      "FROM $DBNAME_AUTH.user_auth " .
      "LEFT JOIN $DBNAME_ORDER.chivalry ON user_auth.atlantian_id = chivalry.atlantian_id " .
      "LEFT JOIN $DBNAME_ORDER.laurel ON user_auth.atlantian_id = laurel.atlantian_id " .
      "LEFT JOIN $DBNAME_ORDER.pelican ON user_auth.atlantian_id = pelican.atlantian_id " .
      "LEFT JOIN $DBNAME_ORDER.rose ON user_auth.atlantian_id = rose.atlantian_id " .
      "LEFT JOIN $DBNAME_ORDER.whitescarf ON user_auth.atlantian_id = whitescarf.atlantian_id " .
      "LEFT JOIN $DBNAME_ORDER.pearl ON user_auth.atlantian_id = pearl.atlantian_id " .
      "LEFT JOIN $DBNAME_ORDER.dolphin ON user_auth.atlantian_id = dolphin.atlantian_id " .
      "LEFT JOIN $DBNAME_ORDER.kraken ON user_auth.atlantian_id = kraken.atlantian_id " .
      "LEFT JOIN $DBNAME_ORDER.seastag ON user_auth.atlantian_id = seastag.atlantian_id " .
      "LEFT JOIN $DBNAME_ORDER.yewbow ON user_auth.atlantian_id = yewbow.atlantian_id " .
      "WHERE UPPER(user_auth.username) = " . quote_smart(strtoupper($adminuser)) . " " .
      "AND user_auth.pass_word = password(" . quote_smart($paswd) .")";
   if ($LOCKOUT == 1)
   {
      $auth_query .= " AND user_auth.$WEBMINISTER_ADMIN = 1";
   }

   $auth_result = mysql_query($auth_query) 
      or die ("Error 1 (user_auth).  Please forward this error to the " . get_webminister_display($link) . ".  " . mysql_error());
   $auth_count = mysql_num_rows($auth_result);

   if ($auth_count > 0)
   {
      $register = mysql_fetch_array($auth_result, MYSQL_BOTH);

      // Set Session Variables
      $_SESSION['s_atlantian_id'] = $register['atlantian_id'];
      $_SESSION['s_user_id'] = $register['user_id'];
      $_SESSION['s_username'] = $adminuser;
      $_SESSION['s_sca_name'] = stripslashes($register['sca_name']);
      $_SESSION['s_email'] = stripslashes($register['email']);

      //-------------
      // Order Member
      //-------------
      // Patent Orders
      if ($register['chivalry'] == 1 && $register['chivalry_id'] > 0)
      {
         $_SESSION['s_chivalry_id'] = $register['chivalry_id'];
      }
      if ($register['laurel'] == 1 && $register['laurel_id'] > 0)
      {
         $_SESSION['s_laurel_id'] = $register['laurel_id'];
      }
      if ($register['pelican'] == 1 && $register['pelican_id'] > 0)
      {
         $_SESSION['s_pelican_id'] = $register['pelican_id'];
      }
      if ($register['rose'] == 1 && $register['rose_id'] > 0)
      {
         $_SESSION['s_rose_id'] = $register['rose_id'];
      }
      // Grant Orders
      if ($register['kraken'] == 1 && $register['kraken_id'] > 0)
      {
         $_SESSION['s_kraken_id'] = $register['kraken_id'];
      }
      if ($register['pearl'] == 1 && $register['pearl_id'] > 0)
      {
         $_SESSION['s_pearl_id'] = $register['pearl_id'];
      }
      if ($register['dolphin'] == 1 && $register['dolphin_id'] > 0)
      {
         $_SESSION['s_dolphin_id'] = $register['dolphin_id'];
      }
      if ($register['whitescarf'] == 1 && $register['whitescarf_id'] > 0)
      {
         $_SESSION['s_whitescarf_id'] = $register['whitescarf_id'];
      }
      if ($register['yewbow'] == 1 && $register['yewbow_id'] > 0)
      {
         $_SESSION['s_yewbow_id'] = $register['yewbow_id'];
      }
      if ($register['seastag'] == 1 && $register['seastag_id'] > 0)
      {
         $_SESSION['s_seastag_id'] = $register['seastag_id'];
      }

      //----------------------
      // Administrative Access
      //----------------------
      // Order Principals
      // Patent Orders
      if ($register[$CHIVALRY_ADMIN] != '' && $register[$CHIVALRY_ADMIN] > 0)
      {
         $_SESSION[$CHIVALRY_ADMIN] = true;
      }
      if ($register[$LAUREL_ADMIN] != '' && $register[$LAUREL_ADMIN] > 0)
      {
         $_SESSION[$LAUREL_ADMIN] = true;
      }
      if ($register[$PELICAN_ADMIN] != '' && $register[$PELICAN_ADMIN] > 0)
      {
         $_SESSION[$PELICAN_ADMIN] = true;
      }
      if ($register[$ROSE_ADMIN] != '' && $register[$ROSE_ADMIN] > 0)
      {
         $_SESSION[$ROSE_ADMIN] = true;
      }
      // Grant Orders
      if ($register[$WHITESCARF_ADMIN] != '' && $register[$WHITESCARF_ADMIN] > 0)
      {
         $_SESSION[$WHITESCARF_ADMIN] = true;
      }
      if ($register[$PEARL_ADMIN] != '' && $register[$PEARL_ADMIN] > 0)
      {
         $_SESSION[$PEARL_ADMIN] = true;
      }
      if ($register[$DOLPHIN_ADMIN] != '' && $register[$DOLPHIN_ADMIN] > 0)
      {
         $_SESSION[$DOLPHIN_ADMIN] = true;
      }
      if ($register[$KRAKEN_ADMIN] != '' && $register[$KRAKEN_ADMIN] > 0)
      {
         $_SESSION[$KRAKEN_ADMIN] = true;
      }
      if ($register[$SEASTAG_ADMIN] != '' && $register[$SEASTAG_ADMIN] > 0)
      {
         $_SESSION[$SEASTAG_ADMIN] = true;
      }
      if ($register[$YEWBOW_ADMIN] != '' && $register[$YEWBOW_ADMIN] > 0)
      {
         $_SESSION[$YEWBOW_ADMIN] = true;
      }
      // GOofS
      if ($register[$SENESCHAL_ADMIN] != '' && $register[$SENESCHAL_ADMIN] > 0)
      {
         $_SESSION[$SENESCHAL_ADMIN] = true;
      }
      if ($register[$EXCHEQUER_ADMIN] != '' && $register[$EXCHEQUER_ADMIN] > 0)
      {
         $_SESSION[$EXCHEQUER_ADMIN] = true;
      }
      if ($register[$HERALD_ADMIN] != '' && $register[$HERALD_ADMIN] > 0)
      {
         $_SESSION[$HERALD_ADMIN] = true;
      }
      if ($register[$MARSHAL_ADMIN] != '' && $register[$MARSHAL_ADMIN] > 0)
      {
         $_SESSION[$MARSHAL_ADMIN] = true;
      }
      if ($register[$MOL_ADMIN] != '' && $register[$MOL_ADMIN] > 0)
      {
         $_SESSION[$MOL_ADMIN] = true;
      }
      if ($register[$MOAS_ADMIN] != '' && $register[$MOAS_ADMIN] > 0)
      {
         $_SESSION[$MOAS_ADMIN] = true;
      }
      if ($register[$CHRONICLER_ADMIN] != '' && $register[$CHRONICLER_ADMIN] > 0)
      {
         $_SESSION[$CHRONICLER_ADMIN] = true;
      }
      if ($register[$CHIRURGEON_ADMIN] != '' && $register[$CHIRURGEON_ADMIN] > 0)
      {
         $_SESSION[$CHIRURGEON_ADMIN] = true;
      }
      if ($register[$WEBMINISTER_ADMIN] != '' && $register[$WEBMINISTER_ADMIN] > 0)
      {
         $_SESSION[$WEBMINISTER_ADMIN] = true;
      }
      if ($register[$CHATELAINE_ADMIN] != '' && $register[$CHATELAINE_ADMIN] > 0)
      {
         $_SESSION[$CHATELAINE_ADMIN] = true;
      }
      // Other apps
      if ($register[$OP_ADMIN] != '' && $register[$OP_ADMIN] > 0)
      {
         $_SESSION[$OP_ADMIN] = true;
      }
      if ($register[$BACKLOG_ADMIN] != '' && $register[$BACKLOG_ADMIN] > 0)
      {
         $_SESSION[$BACKLOG_ADMIN] = true;
      }
      if ($register[$AWARD_ADMIN] != '' && $register[$AWARD_ADMIN] > 0)
      {
         $_SESSION[$AWARD_ADMIN] = true;
      }
      if ($register[$SPIKE_ADMIN] != '' && $register[$SPIKE_ADMIN] > 0)
      {
         $_SESSION[$SPIKE_ADMIN] = true;
      }
      if ($register[$UNIVERSITY_ADMIN] != '' && $register[$UNIVERSITY_ADMIN] > 0)
      {
         $_SESSION[$UNIVERSITY_ADMIN] = true;
      }

      $login_update = "UPDATE $DBNAME_AUTH.user_auth SET last_log = " . value_or_null(date("Y-m-d")) . ", client_ip = " . value_or_null($_SERVER['REMOTE_ADDR']) . " WHERE user_id = " . value_or_null($register['user_id']);
      $login_result = mysql_query($login_update) 
         or die ("Error 2 (user_auth).  Please forward this error to the " . get_webminister_display($link) . ".  " . mysql_error());

      $retval = true;
   }

   /* Free resultset */
   mysql_free_result($auth_result);

   /* Closing connection */
   mysql_close($link);

   //DEBUG: dump_session();
   return $retval;
}
