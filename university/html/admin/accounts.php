<? 
include("../db/db.php");
include("db.php");

$title = "User Accounts";
include("../header.php");
?>
<h2 style="text-align:center">User Accounts</h2>
<?php 
// Only admins allowed
if (isset($_SESSION[$UNIVERSITY_ADMIN]) && $_SESSION[$UNIVERSITY_ADMIN] == 1)
{
   $link = db_connect();
   $query = "SELECT user_auth.user_id, user_auth.atlantian_id, user_auth.username, user_auth.last_log, participant.sca_name, user_auth.email " .
            "FROM $DBNAME_AUTH.user_auth, $DBNAME_UNIVERSITY.participant " .
            "WHERE user_auth.user_id = participant.user_id OR user_auth.atlantian_id = participant.atlantian_id ORDER BY sca_name";
   $result = mysql_query($query)
      or die("User Account Query failed : " . $query. "<br/>" . mysql_error());
   $num_accounts = mysql_num_rows($result);

   if ($num_accounts > 0)
   {
?>
<table align="center" border="1" cellpadding="5" cellspacing="1" summary="Pending Account Requests">
   <tr>
      <th class="title" bgcolor="<?php echo $TITLE_BG_COLOR; ?>">User ID</th>
      <th class="title" bgcolor="<?php echo $TITLE_BG_COLOR; ?>">Atlantian ID</th>
      <th class="title" bgcolor="<?php echo $TITLE_BG_COLOR; ?>">Username</th>
      <th class="title" bgcolor="<?php echo $TITLE_BG_COLOR; ?>">Last Login</th>
      <th class="title" bgcolor="<?php echo $TITLE_BG_COLOR; ?>">SCA Name</th>
      <th class="title" bgcolor="<?php echo $TITLE_BG_COLOR; ?>">Email</th>
   </tr>
<?php 
      while ($data = mysql_fetch_array($result, MYSQL_BOTH))
      {
         $form_user_id = clean($data['user_id']);
         $atlantian_id = clean($data['atlantian_id']);
         $username = clean($data['username']);
         $last_log = clean($data['last_log']);
         $sca_name = clean($data['sca_name']);
         $email = clean($data['email']);

         $active_display = "";
         if ($last_log != "")
         {
            $log_date = format_mysql_date($last_log);
            if (is_active($last_log))
            {
               $active_display = "<span style=\"color:green\">" . $log_date . "</span>";
            }
            else
            {
               $active_display = "<span style=\"color:red\">" . $log_date . "</span>";
            }
         }
?>
   <tr>
      <td class="titleleft" bgcolor="white"><?php echo value_or_nbsp($form_user_id); ?></td>
      <td class="data" bgcolor="white"><?php echo value_or_nbsp($atlantian_id); ?></td>
      <td class="data" bgcolor="white"><?php echo value_or_nbsp($username); ?></td>
      <td class="data" bgcolor="white" nowrap><?php echo value_or_nbsp($active_display); ?></td>
      <td class="data" bgcolor="white"><?php echo value_or_nbsp($sca_name); ?></td>
      <td class="data" bgcolor="white"><?php echo value_or_nbsp($email); ?></td>
   </tr>
<?php 
      }
?>
</table>
<p align="center">There are <?php echo $num_accounts ?> accounts.</p>
<?php 
   }
   else
   {
?>
<p align="center">There are no active accounts.</p>
<?php
   }
   /* Free resultset */
   mysql_free_result($result);

   /* Closing connection */
   mysql_close($link);
}
// Not authorized
else
{
?>
<p align="center" class="title2">You are not authorized to access this page.</p>
<?php
}
include("../footer.php");
?>
