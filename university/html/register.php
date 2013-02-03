<?php
$title = "Register";
include("header.php");
?>
<h2>Option 1</h2>
<p><a href="<?php echo $ADMIN_DIR; ?>register.php">Register online!</a></p>
<h2>Option 2</h2>
<p>Email your registration to the Registrar at <a href="functions/mailto.php?u=registrar&amp;d=atlantia.sca.org" target="redir">registrar@atlantia.sca.org</a></p>
<p>Include your mundane and SCA names<br/>
Your hometown and SCA group<br/>
The complete name and time of each class for which you wish to register.</p>
<p>Note if this is your first University or if you are teaching.</p>
<h2>Option 3</h2>
<p><a href="regform.pdf" target="new">Download our registration form</a>*, fill it out and mail to:<br/><br/>
<?php echo display_registrar_maddr(); ?></p>
<p class="copyleft">* Adobe Acrobat Reader required. <a href="http://www.adobe.com/products/acrobat/readstep2.html" target="new">Get it for free.</a></p>
<?php include("footer.php"); ?>