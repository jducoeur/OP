<?php
$title = "Chancellor";
include("header.php");
?>
<h2 style="text-align:center">University Chancellor</h2><br/>
<p style="text-align:center"><?php echo display_chancellor(); ?></p><br/>
<p style="text-align:center"><?php echo display_registrar(); ?></p><br/>
<p style="text-align:center"><a href="chancellors.php">Previous Chancellors of the University</a></p>
<?php include("footer.php");?>