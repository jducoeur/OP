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
   $query = "SELECT user_auth.user_id, participant.participant_id, user_auth.username, user_auth.last_log, user_auth.first_name, user_auth.last_name, user_auth.sca_name, user_auth.email " .
            "FROM $DBNAME_AUTH.user_auth LEFT OUTER JOIN $DBNAME_UNIVERSITY.participant ON user_auth.user_id = participant.user_id " .
            "WHERE user_auth.atlantian_id IS NULL " .
            "AND user_auth.university_admin = 0 AND user_auth.youth_admin = 0 " .
            "AND user_auth.op_admin = 0 AND user_auth.backlog_admin = 0 " .
            "AND user_auth.award_admin = 0 AND user_auth.spike_admin = 0 " .
            "AND user_auth.seneschal_admin = 0 AND user_auth.exchequer_admin = 0 " .
            "AND user_auth.herald_admin = 0 AND user_auth.moas_admin = 0 " .
            "AND user_auth.marshal_admin = 0 AND user_auth.mol_admin = 0 " .
            "AND user_auth.chronicler_admin = 0 AND user_auth.webminister_admin = 0 " .
            "AND user_auth.chirurgeon_admin = 0 AND user_auth.chatelaine_admin = 0 " .
            "AND user_auth.laurel_admin = 0 AND user_auth.pelican_admin = 0 " .
            "AND user_auth.chivalry_admin = 0 AND user_auth.rose_admin = 0 " .
            "AND user_auth.pearl_admin = 0 AND user_auth.dolphin_admin = 0 " .
            "AND user_auth.yewbow_admin = 0 AND user_auth.kraken_admin = 0 " .
            "AND user_auth.seastag_admin = 0 AND user_auth.whitescarf_admin = 0 " .
            "ORDER BY sca_name";
   $result = mysql_query($query)
      or die("User Account Query failed : " . $query. "<br/>" . mysql_error());
   $num_accounts = mysql_num_rows($result);

   if ($num_accounts > 0)
   {
?>
<table align="center" border="1" cellpadding="5" cellspacing="1" summary="Pending Account Requests">
   <tr>
      <th class="title" bgcolor="<?php echo $TITLE_BG_COLOR; ?>">User ID</th>
      <th class="title" bgcolor="<?php echo $TITLE_BG_COLOR; ?>">Participant ID</th>
      <th class="title" bgcolor="<?php echo $TITLE_BG_COLOR; ?>">Username</th>
      <th class="title" bgcolor="<?php echo $TITLE_BG_COLOR; ?>">Last Login</th>
      <th class="title" bgcolor="<?php echo $TITLE_BG_COLOR; ?>">Legal Name</th>
      <th class="title" bgcolor="<?php echo $TITLE_BG_COLOR; ?>">SCA Name</th>
      <th class="title" bgcolor="<?php echo $TITLE_BG_COLOR; ?>">Email</th>
   </tr>
<?php 
      while ($data = mysql_fetch_array($result, MYSQL_BOTH))
      {
         $form_user_id = clean($data['user_id']);
         $participant_id = clean($data['participant_id']);
         $username = clean($data['username']);
         $last_log = clean($data['last_log']);
         $first_name = clean($data['first_name']);
         $last_name = clean($data['last_name']);
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

         $account_link_pre = "";
         $account_link_post = "";
         if (isset($_SESSION[$WEBMINISTER_ADMIN]) && $_SESSION[$WEBMINISTER_ADMIN] == 1)
         {
            $account_link_pre = "<a href=\"select_atlantian.php?user_id=$form_user_id\">";
            $account_link_post = "</a>";
         }
?>
   <tr>
      <td class="titleleft" bgcolor="white"><?php echo value_or_nbsp($form_user_id); ?></td>
      <td class="data" bgcolor="white"><?php echo value_or_nbsp($participant_id); ?></td>
      <td class="data" bgcolor="white"><?php echo $account_link_pre . value_or_nbsp($username) . $account_link_post; ?></td>
      <td class="data" bgcolor="white" nowrap><?php echo value_or_nbsp($active_display); ?></td>
      <td class="data" bgcolor="white"><?php echo value_or_nbsp($first_name . " " . $last_name); ?></td>
      <td class="data" bgcolor="white"><?php echo value_or_nbsp($sca_name); ?></td>
      <td class="data" bgcolor="white"><?php echo value_or_nbsp($email); ?></td>
   </tr>
<?php 
      }
?>
</table>
<p align="center">There are <?php echo $num_accounts ?> unlinked accounts.</p>
<?php 
   }
   else
   {
?>
<p align="center">There are no unlinked accounts.</p>
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
