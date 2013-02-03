<? 
include("../db/db.php");
include("db.php");
include("../header.php");

// Verify user is authorized
if (isset($_SESSION['s_username'])) 
{
   $errmsg = "";
   if (isset($_POST['submit']))
   {
      $form_atlantian_id = 0;
      if (isset($_POST['form_atlantian_id']))
      {
         $form_atlantian_id = $_POST['form_atlantian_id'];
      }
      $form_user_id = 0;
      if (isset($_POST['form_user_id']))
      {
         $form_user_id = $_POST['form_user_id'];
      }
      $form_pass_word = NULL;
      if (isset($_POST['form_pass_word']))
      {
         $form_pass_word = $_POST['form_pass_word'];
      }
      $form_confirm_pass_word = NULL;
      if (isset($_POST['form_confirm_pass_word']))
      {
         $form_confirm_pass_word = $_POST['form_confirm_pass_word'];
      }
      $form_username = NULL;
      if (isset($_POST['form_username']))
      {
         $form_username = $_POST['form_username'];
      }

      // Validation
      if ($form_pass_word == "")
      {
         $errmsg .= "Please enter a new password.<br/>";
      }
      else if (strlen($form_pass_word) < 8)
      {
         $errmsg .= "Please enter a new password of at least 8 characters.<br/>";
      }
      if ($form_confirm_pass_word == "")
      {
         $errmsg .= "Please confirm your new password.<br/>";
      }
      if ($form_pass_word != $form_confirm_pass_word)
      {
         $errmsg .= "The New Password and Confirm New Password fields must match.  Please retype your new password identically in both fields.<br/>";
      }

      $link = db_admin_connect();
      $query = "SELECT user_id, atlantian_id, username, sca_name, email FROM $DBNAME_AUTH.user_auth WHERE username = ". value_or_null($form_username);
      $result = mysql_query($query)
         or die ("Unable to validate username: " . mysql_error());
      $num = mysql_num_rows($result);

      ##Check for Valid Username
      if (!$num)
      {
         $errmsg .= "Username $form_username is not a valid user account.<br/>";
      }

      // No errors found
      if ($errmsg == "")
      {
         $data = mysql_fetch_array($result, MYSQL_BOTH);
         $form_email = $data['email'];

         ##Insert password into database
         $update = "UPDATE $DBNAME_AUTH.user_auth SET pass_word = password(" . quote_smart($form_pass_word) . ") WHERE username = ". value_or_null($form_username);
         $uresult = mysql_query($update)
            or die ("Unable to update password: " . mysql_error());

         ##Begin mail
         ##Define Recipiant

         if ($form_email != '')
         {
            $recip = $form_email;

            ##Build Body
            $body = "University of Atlantia Administration\n";
            $body .= "Website Administration\n";
            $body .= "Password Change\n";
            $body .= "\n";
            $body .= "Username:  $form_username\n";
            $body .= "Password:  $form_pass_word\n";

            ##Build subject
            $subject = "University of Atlantia Administration -- Password Change";

            ##Build Headers
            $headers ="From:  webminister@atlantia.sca.org\n";
            $headers .="X-Sender:  <seahorse.atlantia.sca.org>\n";
            $headers .="X-Mailer:  PHP";

            ##Send mail
            mail($recip, $subject, $body, $headers);
         }
         ##Notfiy User;

         echo "<p style=\"text-align:center\">Your password has been changed.</p>";

         /* Free resultset */
         mysql_free_result($result);
      }
      /* Closing connection */
      mysql_close($link);
   }
   if ((!isset($_POST['submit'])) || (isset($_POST['submit']) && $errmsg != ""))
   {
      ##Provide form
?>
<p align="center" class="title2">Change Password</p>
<?php 
      if (isset($errmsg) && $errmsg != "")
      {
?>
<p align="center" class="title3" style="color:red">Please correct the following errors:<br/><br/><?php echo $errmsg; ?></p>
<?php 
      }
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" name="form_user_id" id="form_user_id" value="<?php echo $_SESSION['s_user_id']?>"/>
<input type="hidden" name="form_atlantian_id" id="form_atlantian_id" value="<?php echo $_SESSION['s_atlantian_id']?>"/>
<input type="hidden" name="form_username" id="form_username" value="<?php echo $_SESSION['s_username']?>"/>
<table border="0" align="center" summary="Change Password Form">
   <tr>
      <th class="titleright">User:</th>
      <td class="data"><?php echo $_SESSION['s_username']?></td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_pass_word">New Password:</label></th>
      <td class="data"><input type="password" name="form_pass_word" id="form_pass_word" size="20" maxlength="16"/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_confirm_pass_word">Confirm New Password:</label></th>
      <td class="data"><input type="password" name="form_confirm_pass_word" id="form_confirm_pass_word" size="20" maxlength="16"/></td>
   </tr>
   <tr>
      <td colspan="2" class="datacenter"><input type="submit" name="submit" id="submit" value="Change and Email Password"/></td>
   </tr>
</table>
</form>
<?php
   }
}
// Not authorized
else
{
include("../header.php");
?>
<p align="center" class="title2">Change Password</p>
<p align="center" class="title2">You are not authorized to access this page.</p>
<?php
}
include("../footer.php");
?>