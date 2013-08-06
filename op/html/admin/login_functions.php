<?php
require_once('db.php'); 
/** 
 * Authenticate user
 */
function user_auth($adminuser, $paswd)
{
   global $DBNAME_AUTH, $DBNAME_ORDER;
   global $LOCKOUT, $OP_ADMIN, $BACKLOG_ADMIN, $AWARD_ADMIN, $SPIKE_ADMIN, $UNIVERSITY_ADMIN;
   global $SENESCHAL_ADMIN, $EXCHEQUER_ADMIN, $HERALD_ADMIN, $MARSHAL_ADMIN, $MOL_ADMIN;
   global $MOAS_ADMIN, $CHRONICLER_ADMIN, $CHIRURGEON_ADMIN, $WEBMINISTER_ADMIN, $CHATELAINE_ADMIN;

   $retval = false;
   /* Connecting, selecting database */
   $link = db_admin_connect();

   $auth_query = 
      "SELECT user_auth.* " .
      "FROM $DBNAME_AUTH.user_auth " .
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

      $login_update = "UPDATE $DBNAME_AUTH.user_auth SET last_log = " . value_or_null(gmdate("Y-m-d")) . ", client_ip = " . value_or_null($_SERVER['REMOTE_ADDR']) . " WHERE user_id = " . value_or_null($register['user_id']);
      $login_result = mysql_query($login_update) 
         or die ("Error 2 (user_auth).  Please forward this error to the " . get_webminister_display($link) . ".  " . mysql_error());

      $retval = true;
   }

   /* Free resultset */
   mysql_free_result($auth_result);

   /* Closing connection */
   db_disconnect($link);

   return $retval;
}
