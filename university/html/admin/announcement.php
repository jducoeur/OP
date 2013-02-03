<?php
include("../db/db.php");
include("db.php");
include("../header.php");

$mode = $MODE_EDIT;
if (isset($_REQUEST['mode']))
{
   $mode = clean($_REQUEST['mode']);
}

$form_announcement_id = 0;
if (isset($_REQUEST['form_announcement_id']))
{
   $form_announcement_id = clean($_REQUEST['form_announcement_id']);
}
?>
<h2 style="text-align:center"><?php echo ucfirst($mode); ?> Announcement</h2>
<?php
// Only appropriate admins allowed
if (isset($_SESSION[$UNIVERSITY_ADMIN]) && $_SESSION[$UNIVERSITY_ADMIN] == 1)
{
$SUBMIT_SAVE = "Save Changes";

$SUBMIT_DELETE = "Delete Selected Announcements";

$valid = true;
$errmsg = '';
if (isset($_POST['submit']) && $_POST['submit'] == $SUBMIT_SAVE)
{
   $form_announcement_date = NULL;
   if (isset($_POST['form_announcement_date']))
   {
      $form_announcement_date = clean($_POST['form_announcement_date']);
   }
   $form_announcement = NULL;
   if (isset($_POST['form_announcement']))
   {
      $form_announcement = clean($_POST['form_announcement']);
   }
   $form_expiration_date = NULL;
   if (isset($_POST['form_expiration_date']))
   {
      $form_expiration_date = clean($_POST['form_expiration_date']);
   }

   // Validate data
   if (!validate_date($form_announcement_date))
   {
      $valid = false;
      $errmsg .= "Please enter a valid date for the Announcement Date.<br/>";
   }
   else
   {
      $form_announcement_date = format_mysql_date($form_announcement_date);
   }
   if ($form_announcement == NULL || $form_announcement == '')
   {
      $valid = false;
      $errmsg .= "Please enter the Announcement.<br/>";
   }
   // Not required, but if they fill it in, check it
   if ($form_expiration_date != NULL)
   {
      if (!validate_date($form_expiration_date))
      {
         $valid = false;
         $errmsg .= "Please enter a valid date for the Expiration Date.<br/>";
      }
      else
      {
         $form_expiration_date = format_mysql_date($form_expiration_date);
      }
   }
   // Set expiration date default 30 days after announcement date
   else if ($valid)
   {
      $thirty_days_in_seconds = 30*24*60*60;
      $form_expiration_date = date("Y-m-d", strtotime($form_announcement_date) + $thirty_days_in_seconds);
   }

   if ($valid)
   {
      $link = db_admin_connect();

      // Update Announcement
      if ($mode == $MODE_EDIT)
      {
         $update = 
            "UPDATE $DBNAME_UNIVERSITY.announcement " .
            "SET announcement_date = " . value_or_null($form_announcement_date) . 
            ", announcement = " . value_or_null($form_announcement) . 
            ", expiration_date = " . value_or_null($form_expiration_date) . 
            ", last_updated = " . value_or_null(date("Y-m-d")) .
            ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) .
            " WHERE announcement_id = ". $form_announcement_id;

         $uresult = mysql_query($update)
            or die("Error updating Announcement: " . mysql_error());
      }
      // Insert Announcement
      else
      {
         $insert = 
            "INSERT INTO $DBNAME_UNIVERSITY.announcement (announcement_date, announcement, expiration_date, date_created, last_updated, last_updated_by) VALUES (" . 
            value_or_null($form_announcement_date) . ", " . 
            value_or_null($form_announcement) . ", " . 
            value_or_null($form_expiration_date) . ", " . 
            value_or_null(date("Y-m-d")) . ", " . 
            value_or_null(date("Y-m-d")) . ", " . 
            value_or_null($_SESSION['s_user_id']) . ")";

         $iresult = mysql_query($insert)
            or die("Error inserting Announcement: " . mysql_error());
      }
      /* Closing connection */
      mysql_close($link);
?>
<p align="center">Announcement successfully updated.<br/><a href="../index.php">View the Announcement</a> or <a href="<?php echo $_SERVER['PHP_SELF']; ?>">return to the Announcement list</a>.</p>
<?php 
   } // valid
}
// We haven't submitted save yet - display Announcement list or edit form
if (!(isset($_POST['submit'])) || (isset($_POST['submit']) && 
   ($_POST['submit'] == $SUBMIT_SAVE && !$valid) || 
   ($_POST['submit'] == $SUBMIT_DELETE)))
{
   // Do delete
   if (isset($_POST['submit']) && $_POST['submit'] == $SUBMIT_DELETE)
   {
      $del_announcement_id = '';
      for ($i = 1; $i < $_POST['del_announcement_max']; $i++)
      {
         if (isset($_POST['del_announcement_id' . $i]))
         {
            if ($del_announcement_id != '')
            {
               $del_announcement_id .= ',';
            }
            $del_announcement_id .= $_POST['del_announcement_id' . $i];
         }
      }

      if ($del_announcement_id != '')
      {
         $link = db_admin_connect();

         $delete = "DELETE FROM $DBNAME_UNIVERSITY.announcement WHERE announcement_id IN ($del_announcement_id)";

         $dresult = mysql_query($delete)
            or die("Error deleteing Announcement: " . mysql_error());

         /* Closing connection */
         mysql_close($link);
      }
      else
      {
         $delerrmsg = "Please select at least one Announcement to delete.";
?>
<p align="center" class="title3" style="color:red"><?php echo $delerrmsg; ?></p>
<?php 
      }
   }

   // Dislay edit list
   if ($mode == $MODE_EDIT && (!isset($form_announcement_id) || $form_announcement_id == 0))
   {
?>
<p align="center">
To edit an existing Announcement: Click on the Announcement link.<br/>
To delete an existing Announcement: Check the box in front of the Announcement and click the <?php echo $SUBMIT_DELETE; ?> button.<br/>
To add a new Announcement: Visit the <a href="<?php echo $_SERVER['PHP_SELF'] . "?mode=" . $MODE_ADD; ?>">Add Announcement page</a>.<br/>
</p>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table align="center" border="1" cellpadding="5" cellspacing="0" summary="Announcement Update Form">
   <tr>
      <th style="color:<?php echo $accent_color; ?>">Delete</th>
      <th style="color:<?php echo $accent_color; ?>">Announcement Date</th>
      <th style="color:<?php echo $accent_color; ?>">Announcement</th>
   </tr>
<?php 
      $link = db_connect();
      $query = "SELECT announcement_id, announcement_date, announcement, expiration_date FROM $DBNAME_UNIVERSITY.announcement ORDER BY announcement_date";
      $result = mysql_query($query);

      $i = 1;
      while ($data = mysql_fetch_array($result, MYSQL_BOTH))
      {
         $announcement_id = $data['announcement_id'];
         $announcement_date = clean($data['announcement_date']);
         $announcement = clean($data['announcement']);
?>
   <tr>
      <td class="data" nowrap>
      <label for="del_announcement_id<?php echo $i; ?>">Delete</label> <input type="checkbox" name="del_announcement_id<?php echo $i; ?>" id="del_announcement_id<?php echo $i++; ?>" value="<?php echo $announcement_id; ?>"/>
      </td>
      <td class="dataright" nowrap>
      <?php echo format_short_date($announcement_date); ?>
      </td>
      <td class="data">
      <a style="font-weight:normal" href="<?php echo $_SERVER['PHP_SELF'] . "?form_announcement_id=" . $announcement_id; ?>"><?php echo str_replace("\n", "<br/>", htmlentities($announcement)); ?></a>
      </td>
   </tr>
<?php 
      }
?>
   <input type="hidden" name="del_announcement_max" id="del_announcement_max" value="<?php echo $i; ?>"/>
   <tr>
      <td class="datacenter" colspan="3"><input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_DELETE; ?>"/></td>
   </tr>
</table>
</form>
<?php 
      /* Free resultset */
      mysql_free_result($result);

      /* Closing connection */
      mysql_close($link);
   }
   // Display form
   else
   {
      if ($mode == $MODE_EDIT && $valid)
      {
         $link = db_connect();
         $query = "SELECT announcement_id, announcement_date, announcement, expiration_date FROM $DBNAME_UNIVERSITY.announcement WHERE announcement_id = " . $form_announcement_id;
         $result = mysql_query($query);

         $data = mysql_fetch_array($result, MYSQL_BOTH);
         $form_announcement_id = $data['announcement_id'];
         $form_announcement_date = clean($data['announcement_date']);
         $form_announcement = clean($data['announcement']);
         $form_expiration_date = $data['expiration_date'];

         /* Free resultset */
         mysql_free_result($result);

         /* Closing connection */
         mysql_close($link);
      }
      // Set announcement date default to the current date
      else
      {
         $form_announcement_date = date('Y-m-d');
      }
      if (!$valid)
      {
?>
<p align="center" class="title3" style="color:red"><?php echo $errmsg; ?></p>
<?php 
      }
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>"/>
<table border="1" align="center" cellpadding="5" cellspacing="0" summary="Announcement Form">
<?php 
      if (isset($form_announcement_id) && $form_announcement_id > 0)
      {
?>
   <input type="hidden" name="form_announcement_id" id="form_announcement_id" value="<?php echo $form_announcement_id; ?>"/>
<?php 
      }
?>
   <tr>
      <th class="titleright">Announcement ID:</th>
      <td class="data"><?php if (isset($form_announcement_id) && trim($form_announcement_id) != '' && $form_announcement_id > 0) { echo $form_announcement_id; } ?></td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_announcement_date">Announcement Date:</label></th>
      <td class="data"><input type="text" name="form_announcement_date" id="form_announcement_date" size="12" maxlength="10"<?php if (isset($form_announcement_date) && trim($form_announcement_date) != '') { echo " value=\"" . $form_announcement_date . "\""; } ?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_announcement">Announcement:</label></th>
      <td class="data"><textarea name="form_announcement" id="form_announcement" cols="60" rows="5"><?php if (isset($form_announcement) && trim($form_announcement) != '') { echo $form_announcement; } ?></textarea></td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_expiration_date">Expiration Date:</label></th>
      <td class="data"><input type="text" name="form_expiration_date" id="form_expiration_date" size="12" maxlength="10"<?php if (isset($form_expiration_date) && trim($form_expiration_date) != '') { echo " value=\"" . $form_expiration_date . "\""; } ?>/></td>
   </tr>
   <tr>
      <td colspan="2" class="datacenter"><input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_SAVE; ?>"/></td>
   </tr>
</table>
<?
   }
}
?>
</form>
<?php
}
// Not authorized
else
{
?>
<p align="center" class="title2">You are not authorized to access this page.</p>
<?php
}
include("../footer.php");
?>
