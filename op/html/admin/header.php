<?php 
include_once("db.php");
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
   <meta http-equiv="Description" content="Atlantian Order of Precedence - Atlantian Awards" />
   <meta http-equiv="Keywords" content="SCA, Atlantia, OP, Heraldry, Order of Precedence" />
   <meta http-equiv="Copyright" content="Kingdom of Atlantia/SCA, Inc. 2005" />
   <title><?php echo $KINGDOM_ADJ; ?> Order of Precedence Administration - <?php echo $title; ?></title>
   <link rel="stylesheet" type="text/css" href="<?php echo $HOME_DIR; ?>op.css" />
	<link rel="shortcut icon" href="<?php echo $HOME_DIR; ?>favicon.ico">
</head>

<body background="<?php echo $IMAGES_DIR; ?>background.jpg">
<a name="opmenu"></a>
<table border="0" width="100%" cellspacing="0" cellpadding="0" summary="Table used for formatting">
   <tr valign="top">
<?php
if (!$printable)
{
?>
      <td width="15%" valign="top" nowrap="nowrap">
      <table border="0" width="100%" summary="table used for formatting">
         <tr><td align="center"><a href="<?php echo $HOME_DIR; ?>index.php"><img src="<?php echo $IMAGES_DIR; ?>eastern.gif" alt="<?php echo $KINGDOM_ADJ; ?> Order of Precedence" border="0"/></a></td></tr>
         <tr>
            <td nowrap="nowrap">
      <p class="t_menu"><a href="#skip_navigation"><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="1" height="1" alt="W3C Compliant Skip Navigation Link" border="0"/></a></p>
<?php 
      if (isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) 
      {
?>
      <p class="t_menu_header"><?php echo $KINGDOM_RES; ?>s</p>
      <p class="t_menu">
      <a class="menu" href="<?php echo $HOME_DIR; ?>admin/edit_ind.php?mode=<?php echo $MODE_ADD; ?>">Add Person</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <a class="menu" href="<?php echo $HOME_DIR; ?>admin/select_ind.php?type=<?php echo $TYPE_ATLANTIAN; ?>">Edit Person</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <br/>
      <a class="menu" href="<?php echo $HOME_DIR; ?>admin/select_ind.php?type=<?php echo $TYPE_AWARD; ?>&amp;mode=<?php echo $MODE_ADD; ?>">Add Award</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <a class="menu" href="<?php echo $HOME_DIR; ?>admin/select_ind.php?type=<?php echo $TYPE_AWARD; ?>&amp;mode=<?php echo $MODE_EDIT; ?>">Edit Award</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <br/>
      <a class="menu" href="<?php echo $HOME_DIR; ?>admin/coronation.php?mode=<?php echo $MODE_ADD; ?>">Coronation</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <br/>
      <a class="menu" href="<?php echo $HOME_DIR; ?>admin/reign.php?mode=<?php echo $MODE_EDIT; ?>">Monarchs</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <a class="menu" href="<?php echo $HOME_DIR; ?>admin/principality.php?mode=<?php echo $MODE_EDIT; ?>">Principality</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <a class="menu" href="<?php echo $HOME_DIR; ?>admin/baronage.php?mode=<?php echo $MODE_EDIT; ?>">Baronage</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <!--
      <a class="menu" href="<?php echo $HOME_DIR; ?>admin/investiture.php?mode=<?php echo $MODE_EDIT; ?>"></a>Investiture<img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      -->
      <br/>
      <a class="menu" href="<?php echo $HOME_DIR; ?>search.php">Search</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      </p>
<?php
      }
      if ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) || (isset($_SESSION[$BACKLOG_ADMIN]) && $_SESSION[$BACKLOG_ADMIN])) 
      {
?>
      <p class="t_menu_header">Events</p>
      <p class="t_menu">
      <a class="menu" href="<?php echo $HOME_DIR; ?>admin/eventop.php">OP Events</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
<?php
      }
      if (isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) 
      {
?>
      <br/>
      <a class="menu" href="<?php echo $HOME_DIR; ?>admin/event.php?mode=<?php echo $MODE_ADD; ?>">Add OP Event</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <a class="menu" href="<?php echo $HOME_DIR; ?>admin/select_event.php?type=<?php echo $TYPE_EVENT; ?>">Edit OP Event</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
<?php
      }
      if ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) || (isset($_SESSION[$BACKLOG_ADMIN]) && $_SESSION[$BACKLOG_ADMIN])) 
      {
?>
      </p>
<?php
      }
      if (isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) 
      {
?>
      <p class="t_menu_header">Awards</p>
      <p class="t_menu">
      <a class="menu" href="<?php echo $HOME_DIR; ?>admin/award.php?mode=<?php echo $MODE_ADD; ?>">Add Award</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <a class="menu" href="<?php echo $HOME_DIR; ?>admin/award.php?mode=<?php echo $MODE_EDIT; ?>">Edit Award</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <br/>
      <a class="menu" href="<?php echo $HOME_DIR; ?>admin/branch.php?mode=<?php echo $MODE_ADD; ?>">Add Branch</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <a class="menu" href="<?php echo $HOME_DIR; ?>admin/branch.php">Edit Branch</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      </p>
      <p class="t_menu_header">Other</p>
      <p class="t_menu">
      <a class="menu" href="<?php echo $HOME_DIR; ?>admin/missing.php">Missing</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <a class="menu" href="<?php echo $HOME_DIR; ?>admin/private.php">Private</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <a class="menu" href="<?php echo $HOME_DIR; ?>admin/unknown.php">Unknowns</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <a class="menu" href="<?php echo $HOME_DIR; ?>admin/deceased.php">Deceased</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <a class="menu" href="<?php echo $HOME_DIR; ?>admin/kingdom.php">By Kingdom</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <a class="menu" href="<?php echo $HOME_DIR; ?>admin/overdue.php">Overdue</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      </p>
<?php
      }
      if ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) || (isset($_SESSION[$BACKLOG_ADMIN]) && $_SESSION[$BACKLOG_ADMIN])) 
      {
?>
      <p class="t_menu_header">Backlog</p>
      <p class="t_menu">
      <a class="menu" href="<?php echo $HOME_DIR; ?>admin/select_ind.php?type=<?php echo $TYPE_BACKLOG; ?>&amp;mode=<?php echo $MODE_EDIT; ?>">Search By Name</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <a class="menu" href="<?php echo $HOME_DIR; ?>admin/search_award.php">Search By Award</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <a class="menu" href="<?php echo $HOME_DIR; ?>admin/search_scribe.php">Search Scribes</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
<?php
      }
?>
      <p class="t_menu_header">Administration</p>
      <p class="t_menu">
<?php 
      if (isset($_SESSION['s_username']))
      {
?>
      <a class="menu" href="<?php echo $HOME_DIR; ?>admin/password.php">Change Password</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <a class="menu" href="<?php echo $HOME_DIR; ?>admin/logout.php">Logout</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
<?php
      }
      else
      {
?>
      <a class="menu" href="<?php echo $HOME_DIR; ?>admin/index.php">Login</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
<?php
      }
?>
      </p>
      <p class="t_menu_header">Links</p>
      <p class="t_menu">
      <a class="menu" href="<?php echo $HOME_DIR; ?>"><?php echo $KINGDOM_ADJ; ?> OP</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <br/>
      <a class="menu" href="http://www.eastkingdom.org/heraldry/"><?php echo $KINGDOM_ADJ; ?> College of Heralds</a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <br/>
      <a class="menu" href="http://eastkingdom.org/">Kingdom of <?php echo $KINGDOM_NAME; ?></a><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
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
      <img src="<?php echo $IMAGES_DIR; ?>op-title.gif" alt="<?php echo $KINGDOM_ADJ; ?> Order of Precedence" border="0"/>
      <br/>
      <img src="<?php echo $IMAGES_DIR; ?>op-divider.gif" width="648" height="41" border="0" alt="OP Line"/>
      <br/>
      <a name="skip_navigation" tabindex="1"></a>
