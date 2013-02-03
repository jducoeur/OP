<?php
include_once("../db/db.php");
include_once("db.php");
$title = "Find Username";
include("../header.php");
?>
<h2 style="text-align:center">Find Username</h2>
<?php
echo $AEL_BLURB;

$errmsg = "";
$submit = NULL;
$SUBMIT_FIND = "Find Username";

$form_email = "";
if (isset($_REQUEST['email']))
{
   $form_email = clean($_REQUEST['email']);
}

if (isset($_POST['submit']) && $_POST['submit'])
{
   $submit = clean($_POST['submit']);
   $form_email = clean($_POST['email']);

   $link = db_admin_connect();

   ##Check for Valid Email
   $query = "SELECT user_id, atlantian_id, username, email " .
            "FROM $DBNAME_AUTH.user_auth " .
            "WHERE UPPER(email) = " . quote_smart(strtoupper($form_email));
   $result = mysql_query($query);
   $num = mysql_num_rows($result);

   if ($num == 0)
   {
      $errmsg .= "Email address $form_email is not associated with any accounts.<br/>";
   }
   else if ($num > 1)
   {
      $errmsg .= "More than one account is currently associated with $form_email.<br/>";
   }
   else
   {
      $data = mysql_fetch_array($result);
      $username = clean($data['username']);
   }

   mysql_free_result($result);
   db_disconnect($link);
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
      <th class="titleright"><label for="email">Email Address:</label></th>
      <td class="data"><input type="text" name="email" id="email" size="50" maxlength="100"<?php if (isset($form_email) && $form_email != '') { echo " value=\"$form_email\"";} ?>/></td>
   </tr>
   <tr>
      <td colspan="2" class="datacenter"><input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_FIND; ?>"/></td>
   </tr>
</table>
</form>
<?php
}
// One result
else
{
   ##Begin mail
   ##Define Recipiant
   $recip = $form_email;

   ##Build Body
   $body = "University of Atlantia\n";
   $body .= "Find Username\n";
   $body .= "\n";
   $body .= "Username:  $username\n";

   ##Build subject
   $subject = "University of Atlantia Administration -- Find Username";

   ##Build Headers
   $headers ="From:  webminister@atlantia.sca.org\n";
   $headers .="X-Sender:  <seahorse.atlantia.sca.org>\n";
   $headers .="X-Mailer:  PHP";

   ##Send mail
   mail($recip, $subject, $body, $headers);

   ##Notfiy User;
   echo "<p style=\"text-align:center\">Your username has been sent to the email address specified.</p>";
}
?>
<br/>
<p style="text-align:center"><a href="index.php">Return to Login</a></p>
<?php
include("../footer.php");
?>