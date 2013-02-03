<?php
include_once("../db/db.php");
include_once("db.php");
$title = "Password Reset";
include("../header.php");
?>
<h2 style="text-align:center">Password Reset</h2>
<?php 
echo $AEL_BLURB;

$errmsg = "";
$submit = NULL;
$SUBMIT_RESET = "Reset and Email Password";

if (isset($_POST['submit']) && $_POST['submit'])
{
   $submit = clean($_POST['submit']);
   $form_email = clean($_POST['email']);
   $form_username = clean($_POST['username']);

   $link = db_admin_connect();

   // Check for Valid Username/Email
   $query = "SELECT user_id, atlantian_id, username, email " .
            "FROM $DBNAME_AUTH.user_auth " .
            "WHERE UPPER(email) = " . quote_smart(strtoupper($form_email)) .
            " AND UPPER(username) = " . quote_smart(strtoupper($form_username));
   $result = mysql_query($query)
      or die("Error checking for username/email: " . $query . "<br/>" . mysql_error());
   $num = mysql_num_rows($result);

   if ($num == 0)
   {
      $errmsg .= "There is no account with username $form_username and email address $form_email.<br/>";
   }
   else
   {
      ##Generate New Password  
      $passwd = generate_password($form_username);

      ##Insert password into databasae
      $update = "UPDATE $DBNAME_AUTH.user_auth " .
                "SET pass_word = password(" . quote_smart($passwd) . ") " .
                "WHERE UPPER(username) = ". quote_smart(strtoupper($form_username)) . " " .
                "AND UPPER(email) = " . quote_smart(strtoupper($form_email));
      $uresult = mysql_query($update)
         or die("Error resetting password for username/email: " . $update . "<br/>" . mysql_error());
      $unum = mysql_affected_rows();

      if ($num == 0)
      {
         $errmsg .= "<b>ERROR:</b>  Password not updated.<br/>";
      }

      if ($errmsg == "")
      {
         ##Begin mail
         ##Define Recipiant
         $recip = $form_email;

         ##Build Body
         $body = "University of Atlantia\n";
         $body .= "Password Reset\n";
         $body .= "\n";
         $body .= "Username:  $form_username\n";
         $body .= "Password:  $passwd\n";

         ##Build subject
         $subject = "University of Atlantia Administration -- Password Reset";

         ##Build Headers
         $headers = "From:  webminister@atlantia.sca.org\n";
         $headers .= "X-Sender:  <seahorse.atlantia.sca.org>\n";
         $headers .= "X-Mailer:  PHP";

         ##Send mail
         mail($recip, $subject, $body, $headers);

         ##Notfiy User;
         echo "<p style=\"text-align:center\">Your new password has been sent to the email address specified.</p>";
         //echo "DEBUG: update [$update]<br/>";
      }
   }
}
##Provide form
if ($submit == NULL || ($submit != NULL && $errmsg != ""))
{
   if ($errmsg != "")
   {
      echo "<p style=\"color:red;text-align:center\">" . $errmsg;
      echo "Contact the " . get_webminister_display($link) . ".</p>";
   }
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table border="0" align="center" summary="Password recovery form">
   <tr>
      <th class="titleright"><label for="username">Username:</label></th>
      <td class="data"><input type="text" name="username" id="username" size="50" maxlength="50"/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="email">Email Address:</label></th>
      <td class="data"><input type="text" name="email" id="email" size="50" maxlength="100"/></td>
   </tr>
   <tr>
      <td colspan="2" class="datacenter"><input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_RESET; ?>"/></td>
   </tr>
</table>
</form>
<?php
}
?>
<br/>
<p style="text-align:center"><a href="index.php">Return to Login</a></p>
<?php
include("../footer.php");
?>