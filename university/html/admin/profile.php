<?php
include_once("db.php");
include_once("../db/db.php");
include_once("../db/session.php");

$form_user_id = 0;
if (isset($_POST['form_user_id']))
{
   $form_user_id = $_POST['form_user_id'];
}
if (isset($_GET['user_id']))
{
   $form_user_id = $_GET['user_id'];
}

if (isset($_SESSION['s_user_id']) && $_SESSION['s_user_id'] > 0)
{
   $form_user_id = $_SESSION['s_user_id'];
}

$mode = $MODE_EDIT;
if (isset($_REQUEST['mode']))
{
   $mode = $_REQUEST['mode'];
}

// No user_id set
if ($form_user_id == 0)
{
   // Administrator may select someone
   if (isset($_SESSION[$UNIVERSITY_ADMIN]) && $_SESSION[$UNIVERSITY_ADMIN] == 1)
   {
      redirect("select_participant.php");
   }
}
include("../header.php");
?>
<p align="center" class="title2"><?php echo ucfirst($mode); ?> Profile</p>
<?php
if ((isset($_SESSION[$UNIVERSITY_ADMIN]) && $_SESSION[$UNIVERSITY_ADMIN] == 1) || 
    (isset($_SESSION['s_user_id']) && $_SESSION['s_user_id'] > 0))
{
   $SUBMIT_SAVE = "Save Profile Information";

   // Data submitted
   if (isset($_POST['submit']) && $_POST['submit'] == $SUBMIT_SAVE)
   {
      $form_first_name = clean($_POST['form_first_name']);
      $form_last_name = clean($_POST['form_last_name']);
      $form_email = clean($_POST['form_email']);
      $form_sca_name = clean($_POST['form_sca_name']);

      $valid = true;
      $errmsg = '';
      // Validate data
      if (($form_first_name == '' || $form_last_name == '') && $form_sca_name == '')
      {
         $valid = false;
         $errmsg .= "Please enter either a first and last name or an SCA name.<br/>";
      }
      if ($form_email != '' && !validate_email($form_email))
      {
         $valid = false;
         $errmsg .= "Please enter an email address with one @ and no spaces.<br/>";
      }
      if (isset($_SESSION['s_user_id']) && $_SESSION['s_user_id'] == $form_user_id && $form_email == '')
      {
         $valid = false;
         $errmsg .= "You must enter an email address to maintain your account.<br/>";
      }

      // Update database if valid
      if ($valid)
      {
         $link = db_admin_connect();
         // Update
         if ($form_user_id > 0)
         {
            $sql_stmt = "UPDATE $DBNAME_AUTH.user_auth SET " .
               "first_name = " . value_or_null($form_first_name) .
               ", last_name = " . value_or_null($form_last_name) .
               ", email = " . value_or_null($form_email) .
               ", sca_name = " . value_or_null($form_sca_name) .
               ", last_updated = " . value_or_null(date("Y-m-d")) .
               ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) .
               " WHERE user_id = " . value_or_null($form_user_id);
           $sql_result = mysql_query($sql_stmt)
               or die("Error updating User data: " . mysql_error());

            // Update sca_name in participant table
            $user_query = "UPDATE $DBNAME_UNIVERSITY.participant SET " .
                          "sca_name = " . value_or_null($form_sca_name) . 
                          ", last_updated = " . value_or_null(date("Y-m-d")) . 
                          ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) .
                          " WHERE user_id = " . value_or_null($form_user_id);
            $user_result = mysql_query($user_query)
               or die("Error updating Participant data: " . mysql_error());

            $update_msg = "Profile successfully updated.";
         }

         db_disconnect($link);
      }
   }
   // Read Existing User
   else if ($form_user_id > 0)
   {
      $link = db_connect();
      $query = "SELECT user_auth.* FROM $DBNAME_AUTH.user_auth WHERE user_id = " . $form_user_id;
      $result = mysql_query($query);
      $data = mysql_fetch_array($result, MYSQL_BOTH);

      $form_first_name = clean($data['first_name']);
      $form_last_name = clean($data['last_name']);
      $form_email = clean($data['email']);
      $form_sca_name = clean($data['sca_name']);

      mysql_free_result($result);

      db_disconnect($link);
   }
?>
<p align="center" class="title2">
Profile Information
</p>
<?php 
   if (isset($valid) && !$valid && isset($errmsg) && $errmsg != '')
   {
?>
<p align="center" class="title3" style="color:red">Please correct the following errors:<br/><br/><?php echo $errmsg; ?></p>
<?php 
   }
   if (isset($update_msg) && $update_msg != "")
   {
?>
<p align="center" class="title3"><?php echo $update_msg; ?></p>
<?php 
   }
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>"/>
<?php 
   if (isset($form_user_id) && $form_user_id > 0)
   {
?>
   <input type="hidden" name="form_user_id" id="form_user_id" value="<?php echo $form_user_id; ?>"/>
<?php 
   }
?>
<table align="center" cellpadding="5" cellspacing="1" border="1">
   <tr>
      <th class="title" colspan="2" bgcolor="<?php echo $TITLE_BG_COLOR; ?>">Contact Information</th>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_first_name"><label for="form_middle_name"><label for="form_last_name">Name</label></label></label></td>
      <td class="data">
      <span class="titleleft"><label for="form_first_name">First</label></span> <input type="text" name="form_first_name" id="form_first_name" size="20" maxlength="50"<?php if (isset($form_first_name) && $form_first_name != '') { echo " value=\"$form_first_name\"";} ?>/>
      <span class="titleleft"><label for="form_last_name">Last</label></span> <input type="text" name="form_last_name" id="form_last_name" size="30" maxlength="50"<?php if (isset($form_last_name) && $form_last_name != '') { echo " value=\"$form_last_name\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_email">Email</label></td>
      <td class="data"><input type="text" name="form_email" id="form_email" size="50" maxlength="100"<?php if (isset($form_email) && $form_email != '') { echo " value=\"$form_email\"";} ?>></td>
   </tr>
   <tr>
      <th class="title" colspan="2" bgcolor="<?php echo $TITLE_BG_COLOR; ?>">SCA Information</th>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_sca_name">SCA Name</label></td>
      <td class="data"><input type="text" name="form_sca_name" id="form_sca_name" size="50" maxlength="255"<?php if (isset($form_sca_name) && $form_sca_name != '') { echo " value=\"$form_sca_name\"";} ?>/></td>
   </tr>
</table>
<p class="title">
<input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_SAVE; ?>"/>
</p>
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