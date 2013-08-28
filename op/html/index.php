<?php 
include("header.php");
$pagewidth = "80%";
if (isset($printable) && $printable == 1)
{
   $pagewidth = 650;
}
?>
<p class="title2" align="center">Welcome to the <?php echo $KINGDOM_ADJ; ?> Order of Precedence!</p>
<p align="center">
The <?php echo $KINGDOM_ADJ; ?> Order of Precedence includes all the accolades bestowed upon the populace of <?php echo $KINGDOM_NAME; ?> that have been reported to the Clerk of Precedence.
<br/><br/>
Please send all <b>Royal</b> <a href="http://eastkingdom.org/heraldry/">court reports</a> to <b><?php echo $COURT_REP_EMAIL; ?></b>: This alias emails the Clerk of Precedence, the Principal Herald, 
the Clerk Signet, the Backlog Deputy and the presiding Crowns.
<br/><br/>
Please send all <b>Baronial</b> <a href="http://eastkingdom.org/heraldry/">court reports</a> to <b><?php echo $COURT_REP_EMAIL; ?></b>: This alias emails the Clerk of Precedence, the Principal Herald, 
the Clerk Signet and the Backlog Deputy.  Baronial court reports should also be reported to the presiding coronets and the baronial herald (if not the one conducting court).
<br/><br/>
For updates and corrections, please use the <a href="corrections.php">Corrections form</a>. 
</p>

<br/>

<!-- End blurb -->
<?php include("cr_status.php"); ?>
<p>
<img src="<?php echo $IMAGES_DIR; ?>op-divider.gif" width="648" height="41" border="0" alt="OP Line"/>
</p>
<?php include("award_history.php");?>
<?php include("award_table.php");?>
<?php include("award_closed.php");?>
<?php include("footer.php");?>



