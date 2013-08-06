<?php 
include_once("db.php");
include("header.php");
if (isset($_POST['submit']))
{
   $form_email = strip_tags(trim($_POST['email']));
   $form_username = strip_tags(trim($_POST['username']));
   $errmsg = "";
   if ($form_email == NULL || $form_email == '' || $form_username == NULL || $form_username == '')
   {
      $errmsg .= "You must specify both a username and an email address.\n";
   }

   if ($errmsg == "")
   {
      $link = db_admin_connect();
      $query = "SELECT user_id, username, email " .
               "FROM $DBNAME_AUTH.user_auth " .
               "WHERE UPPER(email) = " . quote_smart(strtoupper($form_email)) . ' ' .
               "AND UPPER(username) = " . quote_smart(strtoupper($form_username));
      $result = mysql_query($query);
      $num = mysql_num_rows($result);

      ##Check for Valid Username/Email
      if (!$num)
      {
         echo "<p>Username $form_username and email address $form_email not found in database.<br/>";
         echo "Contact the " . get_webminister_display($link) . ".</p>";
         include ('footer.php');
         exit;
      }

      ##Store e-mail address
      $row = mysql_fetch_array($result);
      $email = stripslashes($row["email"]);

      ##Generate New Password  
      $passwd = generate_password($form_username);

      ##Insert password into databasae
      $update = "UPDATE $DBNAME_AUTH.user_auth " .
                "SET pass_word = password(" . quote_smart($passwd) . ") " .
                "WHERE UPPER(username) = ". quote_smart(strtoupper($form_username)) . " " .
                "AND UPPER(email) = " . quote_smart(strtoupper($email));
      $uresult = mysql_query($update);
      $unum = mysql_affected_rows();

      if (!$unum)
      {
         echo "<p><b>ERROR:</b>  Password not updated. <br/>";
         echo "Please inform the " . get_webminister_display($link) . " of this error </p>";
         include ('footer.php');
         exit;
      }

      ##Begin mail
      ##Define Recipiant

      $recip = $email;

      ##Build Body
      $body .= "Atlantian Order of Precedence\n";
      $body .= "Website Administration\n";
      $body .= "Password Reset\n";
      $body .= "\n";
      $body .= "Username:  $username\n";
      $body .= "Password:  $passwd\n";

      ##Build subject
      $subject = "Atlantian Order of Precedence Administration -- Password Reset";

      ##Build Headers
      $headers .="From:  no-replies-please@atlantia.sca.org\n";
      $headers .="X-Sender:  <seahorse.atlantia.sca.org>\n";
      $headers .="X-Mailer:  PHP";

      ##Send mail
      mail($recip, $subject, $body, $headers);

      ##Notfiy User;

      echo "<p>Your new password has been sent to the email address specified.</p>";
   }
}
if ((isset($errmsg) && $errmsg != "") || !isset($_POST['submit']))
{
##Provide form
?>
<p class="title2">Password Recovery</p>
<?php 
      if (isset($errmsg) && $errmsg != "")
      {
?>
<p align="center" class="title3" style="color:red">Please correct the following errors:<br/><br/><?php echo $errmsg; ?></p>
<?php 
      }
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table border="1" cellpadding="5" cellspacing="0" summary="Password recovery form">
   <tr>
      <th class="titleright"><label for="username">Username:</label></th>
      <td class="data"><input type="text" name="username" id="username" size="50" maxlength="50"/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="email">Email Address:</label></th>
      <td class="data"><input type="text" name="email" id="email" size="50" maxlength="100"/></td>
   </tr>
   <tr>
      <td colspan="2" class="title"><input type="submit" name="submit" id="submit" value="Reset and Email Password"/></td>
   </tr>
</table>
<?php
}
?>
</form>
<br/>
<p><a href="index.php">Return to Login</a></p>
<?php
include("footer.php");
?>
  
  


