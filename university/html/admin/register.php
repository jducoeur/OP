<?php 
include_once("../db/db.php");
include_once("../admin/db.php");
$title = "User Account Registration";
include("../header.php");
?>
<h2 style="text-align:center">User Account Registration</h2>
<?php echo $AEL_BLURB; ?>
<?php
if (isset($_SESSION['s_user_id']))
{
?>
<p style="text-align:center">You are already logged in.</p>
<?php
}
else
{
   $SUBMIT_REGISTER = "Register Account";

   $submit = "";
   if (isset($_POST['submit']) && $_POST['submit'])
   {
      $submit = clean($_POST['submit']);
      $form_email = clean($_POST['email']);
      $form_username = clean($_POST['username']);
      $form_first_name = clean($_POST['first_name']);
      $form_last_name = clean($_POST['last_name']);
      $form_sca_name = clean($_POST['sca_name']);
      $form_password = clean($_POST['password']);
      $form_confirm_password = clean($_POST['confirm_password']);

      // Validation
      $errmsg = "";

      if ($form_username == "")
      {
         $errmsg .= "Please enter a Requested Username.<br/>";
      }
      else if (!(strpos($form_username, " ") === false))
      {
         $errmsg .= "Your Username may not contain spaces.<br/>";
      }

      if ($form_sca_name == "" || ($form_first_name == "" && $form_last_name == ""))
      {
         $errmsg .= "Please enter your SCA Name or your legal first and last names.<br/>";
      }

      if ($form_email == "")
      {
         $errmsg .= "Please enter your Email address.<br/>";
      }
      else if (!validate_email($form_email))
      {
         $errmsg .= "Please enter a valid email address (one @, no spaces).<br/>";
      }

      if ($form_password == "")
      {
         $errmsg .= "Please enter a Password.<br/>";
      }
      else if (strlen($form_password) < 8)
      {
         $errmsg .= "Please enter a password of at least 8 characters.<br/>";
      }

      // Verify password fields match
      if ($form_password != $form_confirm_password)
      {
         $errmsg .= "The Requested Password and Confirm Password fields must match.  Please retype your requested password identically in both fields.<br/>";
      }

      // Don't bother connecting to the DB for these checks unless we're clear so far
      if ($errmsg == "")
      {
         $link = db_admin_connect();

         // Verify username is not already in use
         $query = "SELECT user_id, atlantian_id, username, email, first_name, last_name, sca_name " .
                  "FROM $DBNAME_AUTH.user_auth " .
                  "WHERE UPPER(username) = " . value_or_null(strtoupper($form_username));
         $result = mysql_query($query)
            or die("Error checking for duplicate username: " . $query . "<br/>" . mysql_error());
         $num = mysql_num_rows($result);

         if ($num > 0)
         {
            $errmsg .= "Username $form_username is already in use.  Please select a different username.<br/>";
         }

         /* Repeat emails are possible for shared accounts and folks acting as proxies.
            Except they allow people to register for multiple accounts, which SUCKS! */
         // Verify email address is not already in use
         $query = "SELECT user_id, atlantian_id, username, email, sca_name " .
                  "FROM $DBNAME_AUTH.user_auth " .
                  "WHERE UPPER(email) = " . value_or_null(strtoupper($form_email));
         $result = mysql_query($query)
            or die("Error checking for duplicate email: " . $query . "<br/>" . mysql_error());
         $num = mysql_num_rows($result);

         if ($num > 0)
         {
            $errmsg .= "Email address $form_email is already assigned to an account: <a href=\"find_user.php?email=$form_email\">Find username</a>";
         }

         // Valid request
         if ($errmsg == "")
         {
            // Register account
            $insert = "INSERT INTO $DBNAME_AUTH.user_auth (username, first_name, last_name, sca_name, email, pass_word, account_request_date, date_created) VALUES (" .
                      value_or_null($form_username) . ", " .
                      value_or_null($form_first_name) . ", " .
                      value_or_null($form_last_name) . ", " .
                      value_or_null($form_sca_name) . ", " .
                      value_or_null($form_email) . ", " .
                      "password(" . value_or_null($form_password) . "), " .
                      value_or_null(date("Y-m-d")) . ", " .
                      value_or_null(date("Y-m-d")) . ")";
            $iresult = mysql_query($insert);
               //or die("Error inserting user account: " . mysql_error());
            $inum = mysql_affected_rows();
            $user_id = mysql_insert_id();

            if ($inum != 1)
            {
               echo "<p><b>ERROR:</b>  Unable to create account. <br/>";
               echo "Please inform the Web Minister (" . get_webminister_display($link) . ") of this error </p>";
               include("../footer.php");
               exit;
            }
            else
            {
               // Begin mail
               // Define Recipiant
               $recip = $form_email;

               // Build Body
               $body = "University of Atlantia\n";
               $body .= "Atlantian Account Registration\n";
               $body .= "\n";
               $body .= "Username:  $form_username\n";
               $body .= "Legal Name:  $form_first_name $form_last_name\n";
               $body .= "SCA Name:  $form_sca_name\n";
               $body .= "Email:     $form_email\n";

               // Build subject
               $subject = "University of Atlantia -- Atlantian Account Registration";

               // Build Headers
               $headers ="From:  webminister@atlantia.sca.org\n";
               $headers .="X-Sender:  <atlantia.sca.org>\n";
               $headers .="X-Mailer:  PHP";

               // Send mail
               mail($recip, $subject, $body, $headers);

               // Notfiy User
               //echo "DEBUG: <pre>$headers<br/>$recip<br/>$subject<br/>$body</pre><br/>";
?>
<p align="center">Your account registration is complete.  An email has been sent to you with your user registration information.<br/>
Please <a href="<?php echo $ADMIN_DIR; ?>">login</a>.</p>
<?php 
            }
         }
      }
   }
   if ($submit == "" || (isset($errmsg) && $errmsg != ""))
   {
      // Provide form
      if (isset($errmsg) && $errmsg != '')
      {
?>
<p align="center" class="title3" style="color:red">Please correct the following errors:<br/><br/><?php echo $errmsg; ?></p>
<?php 
      }
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table align="center" border="0" summary="User account registration form">
   <tr>
      <th class="titleright"><label for="username">Requested Username:</label></th>
      <td class="data"><input type="text" name="username" id="username" size="30" maxlength="50"<?php if (isset($form_username) && $form_username != '') { echo " value=\"$form_username\"";} ?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="first_name">First Name:</label></th>
      <td class="data"><input type="text" name="first_name" id="first_name" size="50" maxlength="50"<?php if (isset($form_first_name) && $form_first_name != '') { echo " value=\"$form_first_name\"";} ?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="last_name">Last Name:</label></th>
      <td class="data"><input type="text" name="last_name" id="last_name" size="50" maxlength="50"<?php if (isset($form_last_name) && $form_last_name != '') { echo " value=\"$form_last_name\"";} ?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="sca_name">SCA Name:</label></th>
      <td class="data"><input type="text" name="sca_name" id="sca_name" size="50" maxlength="255"<?php if (isset($form_sca_name) && $form_sca_name != '') { echo " value=\"$form_sca_name\"";} ?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="email">Email Address:</label></th>
      <td class="data"><input type="text" name="email" id="email" size="50" maxlength="100"<?php if (isset($form_email) && $form_email != '') { echo " value=\"$form_email\"";} ?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="password">Password:</label></th>
      <td class="data"><input type="password" name="password" id="password" size="20" maxlength="50"/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="confirm_password">Confirm Password:</label></th>
      <td class="data"><input type="password" name="confirm_password" id="confirm_password" size="20" maxlength="50"/></td>
   </tr>
   <tr>
      <td colspan="2" class="title"><input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_REGISTER; ?>"/></td>
   </tr>
</table>
</form>
<?php
   }
}
include("../footer.php");
?>
