<?php 
include_once("db/db.php");
$accent_color = "#006633";
if (!isset($title))
{
   $title = "Home";
}
if (!isset($printable))
{
   $printable = 0;
   if (isset($_GET['printable']))
   {
      $printable = $_GET['printable'];
   }
   else if (isset($_POST['printable']))
   {
      $printable = $_POST['printable'];
   }
}
echo '<?xml version="1.0" encoding="iso-8859-1"?>';
?>
<!DOCTYPE html 
     PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
   <meta http-equiv="Description" content="Eastern Order of Precedence - Eastern Awards" />
   <meta http-equiv="Keywords" content="SCA, East, OP, Heraldry, Order of Precedence" />
   <meta http-equiv="Copyright" content="Kingdom of East/SCA, Inc. 2005" />
   <title><?php echo $KINGDOM_ADJ; ?> Order of Precedence - <?php echo $title; ?></title>
   <link rel="stylesheet" type="text/css" href="<?php echo $HOME_DIR; ?>op.css" />
  <link rel="shortcut icon" href="<?php echo $HOME_DIR; ?>favicon.ico" />
</head>

<body background="<?php echo $IMAGES_DIR; ?>background.jpg">
<a name="opmenu"></a>
<table border="0" width="100%" cellspacing="0" cellpadding="0" summary="Table used for formatting">
   <tr valign="top">
<?php
if (!$printable)
{
?>
      <td width="5%" valign="top" nowrap="nowrap">
      <table border="0" width="100%" summary="table used for formatting">
         <tr><td align="center"><a href="<?php echo $HOME_DIR; ?>index.php"><img src="<?php echo $IMAGES_DIR; ?>eastern.gif" alt="Order of Precedence, Kingdom of East" border="0"/></a></td></tr>
         <tr>
            <td nowrap="nowrap">
      <p class="t_menu"><a href="#skip_navigation"><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="1" height="1" alt="W3C Compliant Skip Navigation Link" border="0"/></a></p>
      <p class="t_menu_header">Award Listings</p>
      <p class="t_menu">
      <a class="menu" href="<?php echo $HOME_DIR; ?>awards.php"><?php echo $KINGDOM_ADJ; ?> Awards</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <br/>
      <a class="menu" href="<?php echo $HOME_DIR; ?>principality.php">Principalities of the <?php echo $KINGDOM_NAME; ?></a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <br/>
      <a class="menu" href="<?php echo $HOME_DIR; ?>monarchs.php"><?php echo $KINGDOM_ADJ; ?> Monarchs</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <br/>
      <a class="menu" href="<?php echo $HOME_DIR; ?>baronies.php"><?php echo $KINGDOM_ADJ; ?> Baronies</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <br/>
      <a class="menu" href="<?php echo $HOME_DIR; ?>atlantian_op.php"><?php echo $KINGDOM_ADJ; ?> OP</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <br/>
      <a class="menu" href="<?php echo $HOME_DIR; ?>roa.php">Roll of Arms</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <br/>
      <a class="menu" href="<?php echo $HOME_DIR; ?>search.php">Search</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <br/>
      <a class="menu" href="<?php echo $HOME_DIR; ?>corrections.php">Corrections</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <br/>
      <b style="color:<?php echo $accent_color; ?>">Alphabetical by SCA Name</b><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;
         <a class="submenu" href="<?php echo $HOME_DIR; ?>op_name.php?letter=A">A</a>&nbsp;&nbsp;&nbsp;<img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/>
         <a class="submenu" href="<?php echo $HOME_DIR; ?>op_name.php?letter=�">�</a>&nbsp;&nbsp;<img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/>
         <a class="submenu" href="<?php echo $HOME_DIR; ?>op_name.php?letter=B">B</a>&nbsp;&nbsp;&nbsp;<img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/>
         <a class="submenu" href="<?php echo $HOME_DIR; ?>op_name.php?letter=C">C</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/>
         <br/>
         &nbsp;&nbsp;&nbsp;
         <a class="submenu" href="<?php echo $HOME_DIR; ?>op_name.php?letter=D">D</a>&nbsp;&nbsp;&nbsp;<img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/>
         <a class="submenu" href="<?php echo $HOME_DIR; ?>op_name.php?letter=E">E</a>&nbsp;&nbsp;&nbsp;<img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/>
         <a class="submenu" href="<?php echo $HOME_DIR; ?>op_name.php?letter=F">F</a>&nbsp;&nbsp;&nbsp;<img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/>
         <a class="submenu" href="<?php echo $HOME_DIR; ?>op_name.php?letter=G">G</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/>
         <br/>
         &nbsp;&nbsp;&nbsp;
         <a class="submenu" href="<?php echo $HOME_DIR; ?>op_name.php?letter=H">H</a>&nbsp;&nbsp;&nbsp;<img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/>
         <a class="submenu" href="<?php echo $HOME_DIR; ?>op_name.php?letter=I">I</a>&nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/>
         <a class="submenu" href="<?php echo $HOME_DIR; ?>op_name.php?letter=J">J</a>&nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/>
         <a class="submenu" href="<?php echo $HOME_DIR; ?>op_name.php?letter=K">K</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/>
         <br/>
         &nbsp;&nbsp;&nbsp;
         <a class="submenu" href="<?php echo $HOME_DIR; ?>op_name.php?letter=L">L</a>&nbsp;&nbsp;&nbsp;<img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/>
         <a class="submenu" href="<?php echo $HOME_DIR; ?>op_name.php?letter=M">M</a>&nbsp;&nbsp;&nbsp;<img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/>
         <a class="submenu" href="<?php echo $HOME_DIR; ?>op_name.php?letter=N">N</a>&nbsp;&nbsp;&nbsp;<img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/>
         <a class="submenu" href="<?php echo $HOME_DIR; ?>op_name.php?letter=O">O</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/>
         <br/>
         &nbsp;&nbsp;&nbsp;
         <a class="submenu" href="<?php echo $HOME_DIR; ?>op_name.php?letter=�">�</a>&nbsp;&nbsp;&nbsp;<img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/>
         <a class="submenu" href="<?php echo $HOME_DIR; ?>op_name.php?letter=P">P</a>&nbsp;&nbsp;&nbsp;<img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/>
         <a class="submenu" href="<?php echo $HOME_DIR; ?>op_name.php?letter=Q">Q</a>&nbsp;&nbsp;&nbsp;<img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/>
         <a class="submenu" href="<?php echo $HOME_DIR; ?>op_name.php?letter=R">R</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/>
         <br/>
         &nbsp;&nbsp;&nbsp;
         <a class="submenu" href="<?php echo $HOME_DIR; ?>op_name.php?letter=S">S</a>&nbsp;&nbsp;&nbsp;<img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/>
         <a class="submenu" href="<?php echo $HOME_DIR; ?>op_name.php?letter=T">T</a>&nbsp;&nbsp;&nbsp;<img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/>
         <a class="submenu" href="<?php echo $HOME_DIR; ?>op_name.php?letter=U">U</a>&nbsp;&nbsp;&nbsp;<img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/>
         <a class="submenu" href="<?php echo $HOME_DIR; ?>op_name.php?letter=V">V</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/>
         <br/>
         &nbsp;&nbsp;&nbsp;
         <a class="submenu" href="<?php echo $HOME_DIR; ?>op_name.php?letter=W">W</a>&nbsp;&nbsp;<img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/>
         <a class="submenu" href="<?php echo $HOME_DIR; ?>op_name.php?letter=X">X</a>&nbsp;&nbsp;&nbsp;<img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/>
         <a class="submenu" href="<?php echo $HOME_DIR; ?>op_name.php?letter=Y">Y</a>&nbsp;&nbsp;&nbsp;<img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/>
         <a class="submenu" href="<?php echo $HOME_DIR; ?>op_name.php?letter=Z">Z</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/>
         <br/>
         <br/>
         &nbsp;&nbsp;&nbsp;
         <a class="submenu" href="<?php echo $HOME_DIR; ?>all.php">ALL (printable, large)</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/>
         <br/>
      <br/>
      <b style="color:<?php echo $accent_color; ?>">Award by Date</b><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;<b style="color:<?php echo $accent_color; ?>">Royal Peers</b><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="submenu" href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $DUCAL_ID; ?>">Duke/Duchess</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="submenu" href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $COUNTY_ID; ?>">Count/Countess</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="submenu" href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $VISCOUNTY_ID; ?>">Vicount/Vicountess</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;<b style="color:<?php echo $accent_color; ?>">Bestowed Peers</b><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="submenu" href="<?php echo $HOME_DIR; ?>op_award.php?award_group_id=<?php echo $CHIVALRY_GROUP; ?>">Chivalry</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="submenu" href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $LAUREL; ?>">Laurel</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="submenu" href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $PELICAN; ?>">Pelican</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="submenu" href="<?php echo $HOME_DIR; ?>op_award.php?award_group_id=<?php echo $ROSE_GROUP; ?>">Rose</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         <!--
         &nbsp;&nbsp;&nbsp;<b style="color:<?php echo $accent_color; ?>">Patents of Arms</b><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="submenu" href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $POA; ?>">Patent of Arms</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         -->
         &nbsp;&nbsp;&nbsp;<b style="color:<?php echo $accent_color; ?>">Landed Baronage</b><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="submenu" href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $LANDED_BARONAGE_ID; ?>">Territorial Baronage</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="submenu" href="<?php echo $HOME_DIR; ?>op_award.php?award_group_id=<?php echo $RETIRED_BARONAGE_GROUP; ?>">Retired Baronage</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;<b style="color:<?php echo $accent_color; ?>">Orders of High Merit</b><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="submenu" href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $CRESCENT_ID; ?>">Silver Crescent</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="submenu" href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $OTC; ?>">Tyger's Combattant</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="submenu" href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $MAUNCHE_ID; ?>">Maunche</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="submenu" href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $SAGITARIUS; ?>">Sagitarius</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="submenu" href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $OGR; ?>">OGR</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;<b style="color:<?php echo $accent_color; ?>">Grants of Arms</b><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="submenu" href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $GOA; ?>">Grant of Arms</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;<b style="color:<?php echo $accent_color; ?>">Court Baronage</b><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="submenu" href="<?php echo $HOME_DIR; ?>op_award.php?award_group_id=<?php echo $COURT_BARONAGE_GROUP; ?>">Court Baronage</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;<b style="color:<?php echo $accent_color; ?>">Awards of Arms</b><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="submenu" href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $AOA; ?>">Award of Arms</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;<b style="color:<?php echo $accent_color; ?>">Society Awards</b><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="submenu" href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $SUPPORTERS_ID; ?>">Supporters</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="submenu" href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $AUG; ?>">Augmentaion of Arms</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;<b style="color:<?php echo $accent_color; ?>">Kingdom Orders</b><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="submenu" href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $QOC; ?>">Queen's Order of Courtesy</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="submenu" href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $TYGER_CUB; ?>">Tyger's Cub</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="submenu" href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $SILVER_RAPIER; ?>">Silver Rapier</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;<b style="color:<?php echo $accent_color; ?>">Kingdom Awards</b><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="submenu" href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $BURDENED_TYGER; ?>">Burdened Tyger</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="submenu" href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $GAWAIN; ?>">Gawain</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="submenu" href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $ARTEMIS; ?>">Artemis</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="submenu" href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $TROUBADOUR; ?>">Troubadour</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="submenu" href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $TERPSICHORE; ?>">Terpsichore</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="submenu" href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $KOE; ?>">KOE</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="submenu" href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $TYGER_OF_EAST; ?>">Tyger of the East</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
        &nbsp;&nbsp;&nbsp;<b style="color:<?php echo $accent_color; ?>">Kingdom Honors</b><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
        &nbsp;&nbsp;&nbsp;<b style="color:<?php echo $accent_color; ?>">Closed Orders</b><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
           </p>
      <p class="t_menu_header">Links</p>
      <p class="t_menu">
      <a class="menu" href="http://herald.east.sca.org/">Eastern College of Heralds</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <br/>
      <a class="menu" href="http://east.sca.org/">Kingdom of East</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <br/>
      <a class="menu" href="http://award.east.sca.org/">Award Recommendations</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      </p>
      <br/>
            </td>
         </tr>
         <tr><td>&nbsp;</td></tr>
      </table>
      </td>
    
      <td bgcolor="<?php echo $accent_color;?>"><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="1" height="0" alt="W3C Compliant Link Spacer" border="0"/></td>
      <td>&nbsp;</td>
<?php
} // Printable
?>
      <td align="center" valign="top">
      <img src="<?php echo $IMAGES_DIR; ?>op-title.gif" alt="Eastern Order of Precedence" border="0"/>
      <br/>
      <img src="<?php echo $IMAGES_DIR; ?>op-divider.gif" width="648" height="41" border="0" alt="OP Line"/>
      <br/>
      <a name="skip_navigation" tabindex="1"></a>
