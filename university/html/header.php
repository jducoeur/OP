<?php 
require_once('db/session.php'); 
include_once("db/db.php");

$accent_color = "#CC0000";
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
   <meta http-equiv="Description" content="University of Atlantia" />
   <meta http-equiv="Keywords" content="SCA, Atlantia, University, Classes" />
   <meta http-equiv="Copyright" content="Kingdom of Atlantia/SCA, Inc. 2009" />
   <title>University of Atlantia - <?php echo $title; ?></title>
   <link rel="stylesheet" type="text/css" href="<?php echo $HOME_DIR; ?>university.css" />
	<link rel="shortcut icon" href="<?php echo $HOME_DIR; ?>favicon.ico" />
<script type="text/javascript" language="JavaScript">
<!--
if (document.images)
{
  image1on = new Image();
  image1on.src = "<?php echo $IMAGES_DIR; ?>catalogon.gif";

  image2on = new Image();
  image2on.src = "<?php echo $IMAGES_DIR; ?>registeron.gif";

  image3on = new Image();
  image3on.src = "<?php echo $IMAGES_DIR; ?>teachon.gif";

  image4on = new Image();
  image4on.src = "<?php echo $IMAGES_DIR; ?>contacton.gif";

  image5on = new Image();
  image5on.src = "<?php echo $IMAGES_DIR; ?>degreeson.gif";

  image6on = new Image();
  image6on.src = "<?php echo $IMAGES_DIR; ?>faqon.gif";

  image1off = new Image();
  image1off.src = "<?php echo $IMAGES_DIR; ?>catalog.gif";

  image2off = new Image();
  image2off.src = "<?php echo $IMAGES_DIR; ?>register.gif";

  image3off = new Image();
  image3off.src = "<?php echo $IMAGES_DIR; ?>teach.gif";

  image4off = new Image();
  image4off.src = "<?php echo $IMAGES_DIR; ?>contact.gif";

  image5off = new Image();
  image5off.src = "<?php echo $IMAGES_DIR; ?>degrees.gif";

  image6off = new Image();
  image6off.src = "<?php echo $IMAGES_DIR; ?>faq.gif";
}

function changeImages()
{
  if (document.images)
  {
    for (var i = 0; i < changeImages.arguments.length; i += 2)
    {
      document[changeImages.arguments[i]].src = eval(changeImages.arguments[i+1] + ".src");
    }
  }
}

// -->
</script>
</head>

<?php
$for_printing = "";
if ($printable)
{
   if (!(isset($not_indented) && $not_indented == 1))
   {
      $for_printing = " style=\"margin-left:50px\"";
   }
}

// To prevent errors on long running calculate pages
flush();
?>
<body<?php echo $for_printing; ?>>

<table class="maintable">
   <tr>
      <td>
<?php
if (!$printable)
{
?>
      <table border="0" cellpadding="0" width="100%">
         <tr>
            <td nowrap="nowrap">
            <p>
            <a href="<?php echo $HOME_DIR; ?>index.php"><img border="0" width="55" height="56" src="<?php echo $IMAGES_DIR; ?>badge.gif" align="left" alt="Badge of the University of Atlantia" />
            <img border="0" width="479" height="51" src="<?php echo $IMAGES_DIR; ?>title.gif" alt="University of Atlantia, SCA Inc." align="bottom" /></a>
            </p>
            </td>
            <td align="right">
<?php
   if (isset($_SESSION['s_username']))
   {
?>
            User: <?php echo $_SESSION['s_username']; ?><br/>
            <a href="<?php echo $ADMIN_DIR; ?>logout.php">Logout</a><br/>
            <a href="<?php echo $ADMIN_DIR; ?>index.php">Admin Home</a>
<?php
   }
   else
   {
?>
            <a href="<?php echo $ADMIN_DIR; ?>">Login</a><br/>
            <a href="<?php echo $ADMIN_DIR; ?>register.php">Register</a>
<?php
   }
?>
            </td>
         </tr>
      </table>
      <table border="0" cellpadding="0" width="100%">
         <tr>
            <td>
            <table border="0" cellpadding="0" width="100%" style="background-color:<?php echo $accent_color; ?>">
               <tr>
                  <td class="<?php if ($title == "Home") { echo "menuon"; } else { echo "menuoff"; } ?>"><a href="<?php echo $HOME_DIR; ?>index.php" class="<?php if ($title == "Home") { echo "amenuon"; } else { echo "amenuoff"; } ?>">Home</a></td>
                  <td class="<?php if ($title == "Catalog") { echo "menuon"; } else { echo "menuoff"; } ?>"><a href="<?php echo $HOME_DIR; ?>catalog.php" class="<?php if ($title == "Catalog") { echo "amenuon"; } else { echo "amenuoff"; } ?>">Catalog</a></td>
                  <td class="<?php if ($title == "Register") { echo "menuon"; } else { echo "menuoff"; } ?>"><a href="<?php echo $HOME_DIR; ?>register.php" class="<?php if ($title == "Register") { echo "amenuon"; } else { echo "amenuoff"; } ?>">Register</a></td>
                  <td class="<?php if ($title == "Teach") { echo "menuon"; } else { echo "menuoff"; } ?>"><a href="<?php echo $HOME_DIR; ?>teach.php" class="<?php if ($title == "Teach") { echo "amenuon"; } else { echo "amenuoff"; } ?>">Teach</a></td>
                  <td class="<?php if ($title == "Chancellor") { echo "menuon"; } else { echo "menuoff"; } ?>"><a href="<?php echo $HOME_DIR; ?>chancellor.php" class="<?php if ($title == "Chancellor") { echo "amenuon"; } else { echo "amenuoff"; } ?>">Chancellor</a></td>
                  <td class="<?php if ($title == "Degrees") { echo "menuon"; } else { echo "menuoff"; } ?>"><a href="<?php echo $HOME_DIR; ?>degrees.php" class="<?php if ($title == "Degrees") { echo "amenuon"; } else { echo "amenuoff"; } ?>">Degrees</a></td>
                  <td class="<?php if ($title == "FAQ") { echo "menuon"; } else { echo "menuoff"; } ?>"><a href="<?php echo $HOME_DIR; ?>faq.php" class="<?php if ($title == "FAQ") { echo "amenuon"; } else { echo "amenuoff"; } ?>">FAQ</a></td>
               </tr>
            </table>
            </td>
         </tr>
      </table>
<?php
} // Printable
?>
      <a name="skip_navigation" tabindex="1"></a>
<?php
// Display admin menu when on admin pages and logged in
if (!$printable && isset($_SESSION['s_username']) && substr($_SERVER['PHP_SELF'], 0, strlen($ADMIN_DIR)) == $ADMIN_DIR)
{
?>
<table border="0" cellpadding="0" width="100%">
   <tr>
      <td class="leftnav">
      <span style="color:white;font-weight:bold">Account</span><br/>
<?php
   // Display personal links only when an individual (not an admin) is logged in
   if (!isset($_SESSION[$UNIVERSITY_ADMIN]) || (isset($_SESSION[$UNIVERSITY_ADMIN]) && $_SESSION[$UNIVERSITY_ADMIN] != 1))
   {
?>
      &nbsp;&nbsp;&nbsp;<a style="color:white" href="<?php echo $ADMIN_DIR; ?>preregistrations.php">My Registrations</a><img src="<?php echo $HOME_DIR; ?>images/spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      &nbsp;&nbsp;&nbsp;<a style="color:white" href="<?php echo $ADMIN_DIR; ?>transcript.php">My Transcript</a><img src="<?php echo $HOME_DIR; ?>images/spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      &nbsp;&nbsp;&nbsp;<a style="color:white" href="<?php echo $ADMIN_DIR; ?>edit_ind.php">Edit Profile</a><img src="<?php echo $HOME_DIR; ?>images/spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
<?php
   }
?>
      &nbsp;&nbsp;&nbsp;<a style="color:white" href="<?php echo $ADMIN_DIR; ?>password.php">Change Password</a><img src="<?php echo $HOME_DIR; ?>images/spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      &nbsp;&nbsp;&nbsp;<a style="color:white" href="<?php echo $ADMIN_DIR; ?>logout.php">Logout</a><img src="<?php echo $HOME_DIR; ?>images/spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
<?php
   // Display admin menu when on admin pages and logged in
   if (isset($_SESSION[$UNIVERSITY_ADMIN]) && $_SESSION[$UNIVERSITY_ADMIN] == 1)
   {
?>
      <br/>
      <span style="color:white;font-weight:bold">Administration</span><br/>
      &nbsp;&nbsp;&nbsp;<a style="color:white" href="<?php echo $ADMIN_DIR; ?>announcement.php">Announcements</a><img src="<?php echo $HOME_DIR; ?>images/spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      &nbsp;&nbsp;&nbsp;<a style="color:white" href="<?php echo $ADMIN_DIR; ?>email.php">Send Email</a><img src="<?php echo $HOME_DIR; ?>images/spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      &nbsp;&nbsp;&nbsp;<a style="color:white" href="<?php echo $ADMIN_DIR; ?>university.php">University</a><img src="<?php echo $HOME_DIR; ?>images/spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      &nbsp;&nbsp;&nbsp;<a style="color:white" href="<?php echo $ADMIN_DIR; ?>participant.php?mode=<?php echo $MODE_ADD; ?>">Add Participant</a><img src="<?php echo $HOME_DIR; ?>images/spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      &nbsp;&nbsp;&nbsp;<a style="color:white" href="<?php echo $ADMIN_DIR; ?>select_participant.php?type=<?php echo $ST_PARTICIPANT; ?>">Edit Participant</a><img src="<?php echo $HOME_DIR; ?>images/spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      &nbsp;&nbsp;&nbsp;<a style="color:white" href="<?php echo $ADMIN_DIR; ?>doctorate.php">Doctorates</a><img src="<?php echo $HOME_DIR; ?>images/spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      &nbsp;&nbsp;&nbsp;<a style="color:white" href="<?php echo $ADMIN_DIR; ?>chancellor.php">Chancellors</a><img src="<?php echo $HOME_DIR; ?>images/spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      &nbsp;&nbsp;&nbsp;<a style="color:white" href="<?php echo $ADMIN_DIR; ?>cleanup.php">Remove Student Pre-Reg</a><img src="<?php echo $HOME_DIR; ?>images/spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <br/>
      <span style="color:white;font-weight:bold">Reports</span><br/>
      &nbsp;&nbsp;&nbsp;<a style="color:white" href="<?php echo $ADMIN_DIR; ?>schedule.php">Full Schedule</a><img src="<?php echo $HOME_DIR; ?>images/spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      &nbsp;&nbsp;&nbsp;<a style="color:white" href="<?php echo $ADMIN_DIR; ?>grid.php">Schedule Grid</a><img src="<?php echo $HOME_DIR; ?>images/spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      &nbsp;&nbsp;&nbsp;<a style="color:white" href="<?php echo $ADMIN_DIR; ?>teachers.php">For Teachers</a><img src="<?php echo $HOME_DIR; ?>images/spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      &nbsp;&nbsp;&nbsp;<a style="color:white" href="<?php echo $ADMIN_DIR; ?>students.php">For Students</a><img src="<?php echo $HOME_DIR; ?>images/spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      &nbsp;&nbsp;&nbsp;<a style="color:white" href="<?php echo $ADMIN_DIR; ?>rooms.php">For Rooms</a><img src="<?php echo $HOME_DIR; ?>images/spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      &nbsp;&nbsp;&nbsp;<a style="color:white" href="<?php echo $ADMIN_DIR; ?>size.php">Size Cheat Sheet</a><img src="<?php echo $HOME_DIR; ?>images/spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      &nbsp;&nbsp;&nbsp;<a style="color:white" href="<?php echo $ADMIN_DIR; ?>degrees.php">Degrees Earned</a><img src="<?php echo $HOME_DIR; ?>images/spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <br/>
      <span style="color:white;font-weight:bold">Calculate Statistics</span><br/>
      &nbsp;&nbsp;&nbsp;<a style="color:white" href="<?php echo $ADMIN_DIR; ?>calc_university_stats.php">University Stats</a><img src="<?php echo $HOME_DIR; ?>images/spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      &nbsp;&nbsp;&nbsp;<a style="color:white" href="<?php echo $ADMIN_DIR; ?>calc_people_stats.php">Participant Stats</a><img src="<?php echo $HOME_DIR; ?>images/spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      <br/>
      <span style="color:white;font-weight:bold">Users</span><br/>
      &nbsp;&nbsp;&nbsp;<a style="color:white" href="<?php echo $ADMIN_DIR; ?>accounts.php">View Accounts</a><img src="<?php echo $HOME_DIR; ?>images/spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
      &nbsp;&nbsp;&nbsp;<a style="color:white" href="<?php echo $ADMIN_DIR; ?>accounts_unlinked.php">Unlinked Accounts</a><img src="<?php echo $HOME_DIR; ?>images/spacer.gif" width="0" height="0" alt="W3C Compliant Link Spacer" border="0"/><br/>
<?php
   }
?>
      </td>
      <td class="mainpage"> 
<?php
}
?>
