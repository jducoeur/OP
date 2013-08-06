<?php
require_once('../db/session.php');
require_once('login_functions.php');

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
$title = "Login";
include("../header.php");
if (isset($_SESSION['s_username']))
{
?>
<h2 style="text-align:center">Welcome to the University of Atlantia web site!</h2>
<p style="text-align:center">Use the links on the left to view or edit your data.</p>
<p style="text-align:center">To register for classes, browse the <a href="<?php echo $HOME_DIR; ?>catalog.php">Catalog</a>, select the desired class, then click the Register button.</p>
<?php
}
else
{
#Provide login form
?>
<h2 style="text-align:center">University of Atlantia - Login</h2>
<?php echo $AEL_BLURB; ?>
<?php
   if (isset($adminuser))
   {
     #Failed Login
     echo "<p style=\"color:red;font-weight:bold;text-align:center\">ERROR: Invalid username/password</p>";
   }
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table border="0" align="center" summary="Login form">
   <tr>
      <th class="titleright"><label for="adminuser">Username:</label></th>
      <td><input type="text" name="adminuser" id="adminuser" size="20" maxlength="100"<?php if (isset($adminuser)) { echo ' value="' . $adminuser . '"'; } ?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="paswd">Password:</label></th>
      <td><input type="password" name="paswd" id="paswd" size="20" maxlength="16"/></td>
   </tr>
   <tr>
      <td colspan="2" class="datacenter"><input type="submit" value="Login"/></td>
   </tr>
</table>
</form>
<p style="text-align:center">Forgotten your user name? <a href="find_user.php">Find your username.</a></p>
<p style="text-align:center">Forgotten your password? <a href="reset.php">Reset your password.</a></p>
<p style="text-align:center">Don't have an account? <a href="register.php">Register now.</a></p>
<br/>
<?php
   if (isset($LOCKOUT) && $LOCKOUT == 1)
   {
?>
<p style="text-align:center">The system is currently down for maintenance.  Please try again later.</p>
<?php
   }
}
include("../footer.php");
?>

