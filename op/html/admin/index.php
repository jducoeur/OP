<?php
include_once("db.php");
require_once("login_functions.php");

##Define variables
if (isset($_POST['adminuser']))
{
   $adminuser = $_POST['adminuser'];
}
if (isset($_POST['paswd']))
{
   $paswd = $_POST['paswd'];
}
if (isset($adminuser) && isset($paswd))
{
   #Login Attempted
   user_auth($adminuser, $paswd);
}
include_once("header.php");
if (isset($_SESSION['s_username']))
{
?>
<p class="title2">Welcome to the Order of Precedence's Website Administration section</p>
<p>
Please select a navigation link to administer website data.
</p>
<?php
}
else
{
   if (isset($adminuser))
   {
     #Failed Login
     echo '<p class="title2">Could Not Log You In</p>';
   }
   else
   {
     #New Login
     echo '<p class="title2">Please Log In</p>';
   }
#Provide login form
?>
<form action="<? echo $_SERVER['PHP_SELF']; ?>" method="post">
<table border="1" cellpadding="5" cellspacing="0" summary="Login form">
   <tr>
      <td colspan="2" class="title">OP Administration Login</td>
   </tr>
   <tr>
      <th class="titleright"><label for="adminuser">Username:</label></th>
      <td><input type="text" name="adminuser" id="adminuser" size="50" maxlength="100"<?php if (isset($adminuser)) { echo ' VALUE="' . $adminuser . '"'; } ?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="paswd">Password:</label></th>
      <td><input type="password" name="paswd" id="paswd" size="16" maxlength="16"/></td>
   </tr>
   <tr>
      <td colspan="2" class="title"><input type="submit" value="Log In"/></td>
   </tr>
</table>
</form>
<p>Forgotten your password? <a href="reset.php">Reset your password.</a></p>
<?
}
include("footer.php");
?>

