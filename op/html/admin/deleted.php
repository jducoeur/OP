<?php
include_once("db.php");
include_once("header.php");

$type_id = $DEL_TYPE_ATLANTIAN;
if (isset($_REQUEST['type_id']))
{
   $type_id = $_REQUEST['type_id'];
}
?>
<p align="center" class="title2">Delete <?php echo $DELTYPE[$type_id]; ?></p>
<?php
if (isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN])
{
?>
<p align="center" class="title2"><?php echo $DELTYPE[$type_id]; ?> successfully deleted.</p>
<?php
}
// Not authorized
else
{
?>
<p align="center" class="title2">You are not authorized to access this page.</p>
<?php
}
include("footer.php");
?>

