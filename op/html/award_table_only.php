<?php 
$title = "Atlantian Awards by Precedence";
include("header.php");
$pagewidth = "80%";
if (isset($printable) && $printable == 1)
{
   $pagewidth = 650;
}
?>
<p class="title2" align="center">Atlantian Awards by Precedence</p>
<?php include("award_table.php");?>
<?php include("footer.php");?>



