<?php 
include("header.php");
$pagewidth = "80%";
if (isset($printable) && $printable == 1)
{
   $pagewidth = 650;
}
?>
<p class="title2" align="center">Welcome to the Atlantian Order of Precedence!</p>
<p align="center">
The Atlantian Order of Precedence includes all the accolades bestowed upon the populace of Atlantia that have been reported to the Clerk of Precedence.
<br/><br/>
Please send all <b>Royal</b> <a href="court_reports.php">court reports</a> to <b>royalcourtreport AT atlantia.sca.org</b>: This alias emails the Clerk of Precedence, the Triton Principal Herald, 
the Clerk Signet, the Backlog Deputy and the presiding Crowns.
<br/><br/>
Please send all <b>Baronial</b> <a href="court_reports.php">court reports</a> to <b>courtreport AT atlantia.sca.org</b>: This alias emails the Clerk of Precedence, the Triton Principal Herald, 
the Clerk Signet and the Backlog Deputy.  Baronial court reports should also be reported to the presiding coronets and the baronial herald (if not the one conducting court).
<br/><br/>
For updates and corrections, please use the <a href="corrections.php">Corrections form</a>. 
</p>
<!-- Begin blurb -->
<p align="center">
Lady Glynis Gwynedd<br/>
Clerk of Precedence<br/>
op AT atlantia.sca.org
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



