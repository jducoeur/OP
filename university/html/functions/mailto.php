<?
// redirect-mailto.php
$mailtoURL = "mailto:" . $_GET['u'] . "@" . $_GET['d'];
header("Location: $mailtoURL"); 
?>
