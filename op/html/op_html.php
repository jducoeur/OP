#!/usr/local/bin/php
<?php
if ($_SERVER['REMOTE_ADDR'])
{
   echo '<html>' ."\n";
   echo '<head>' ."\n";
   echo '<title>Access Denied</title>' ."\n";
   echo '</head>' ."\n";
   echo '<center>Remote Access Denied</center>';
   echo '</html>';
   exit;
}

$printable = 1;
include("atlantian_op.php");
?>
