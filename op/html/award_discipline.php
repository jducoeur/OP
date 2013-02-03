<?php 
$title = "Awards by Discipline";
include("header.php");
$pagewidth = "80%";
if (isset($printable) && $printable == 1)
{
   $pagewidth = 650;
}
?>
<p class="title2" align="center">Atlantian Awards by Discipline</p>
<p align="center">
<a href="awards.php">Atlantian Award Descriptions</a> | <a href="award_table_only.php">Atlantian Awards by Precedence</a> | <a href="award_discipline.php">Atlantian Awards by Discipline</a>
</p>
<?php include("award_by_discpline.php");?>
<?php include("footer.php");?>



