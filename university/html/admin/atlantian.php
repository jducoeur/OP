<?php
include_once("db.php");
include_once("../db/db.php");
include_once("../db/session.php");

$form_atlantian_id = 0;
if (isset($_POST['form_atlantian_id']))
{
   $form_atlantian_id = $_POST['form_atlantian_id'];
}
if (isset($_GET['atlantian_id']))
{
   $form_atlantian_id = $_GET['atlantian_id'];
}

if (isset($_SESSION['s_atlantian_id']) && $_SESSION['s_atlantian_id'] > 0)
{
   $form_atlantian_id = $_SESSION['s_atlantian_id'];
}

$mode = $MODE_EDIT;
if (isset($_REQUEST['mode']))
{
   $mode = $_REQUEST['mode'];
}

// No atlantian_id set
if ($form_atlantian_id == 0)
{
   // Administrator may select someone
   if (isset($_SESSION[$UNIVERSITY_ADMIN]) && $_SESSION[$UNIVERSITY_ADMIN] == 1)
   {
      redirect("select_participant.php");
   }
   // Other users may edit their account profile
   else if (isset($_SESSION['s_user_id']) && $_SESSION['s_user_id'] > 0)
   {
      redirect("profile.php");
   }
}
include("../header.php");
?>
<p align="center" class="title2"><?php echo ucfirst($mode); ?> Atlantian</p>
<?php
if ((isset($_SESSION[$UNIVERSITY_ADMIN]) && $_SESSION[$UNIVERSITY_ADMIN] == 1) || 
    (isset($_SESSION['s_atlantian_id']) && $_SESSION['s_atlantian_id'] > 0))
{
   $SUBMIT_SAVE = "Save Atlantian Information";

   // Data submitted
   if (isset($_POST['submit']) && $_POST['submit'] == $SUBMIT_SAVE)
   {
      $form_first_name = clean($_POST['form_first_name']);
      $form_middle_name = clean($_POST['form_middle_name']);
      $form_last_name = clean($_POST['form_last_name']);
      $form_publish_name = 0;
      if (isset($_POST['form_publish_name']))
      {
         $form_publish_name = $_POST['form_publish_name'];
      }
      $form_publish_address = 0;
      if (isset($_POST['form_publish_address']))
      {
         $form_publish_address = $_POST['form_publish_address'];
      }
      $form_publish_email = 0;
      if (isset($_POST['form_publish_email']))
      {
         $form_publish_email = $_POST['form_publish_email'];
      }
      $form_publish_alternate_email = 0;
      if (isset($_POST['form_publish_alternate_email']))
      {
         $form_publish_alternate_email = $_POST['form_publish_alternate_email'];
      }
      $form_publish_phone_home = 0;
      if (isset($_POST['form_publish_phone_home']))
      {
         $form_publish_phone_home = $_POST['form_publish_phone_home'];
      }
      $form_publish_phone_work = 0;
      if (isset($_POST['form_publish_phone_work']))
      {
         $form_publish_phone_work = $_POST['form_publish_phone_work'];
      }
      $form_publish_phone_mobile = 0;
      if (isset($_POST['form_publish_phone_mobile']))
      {
         $form_publish_phone_mobile = $_POST['form_publish_phone_mobile'];
      }
      $form_address1 = clean($_POST['form_address1']);
      $form_address2 = clean($_POST['form_address2']);
      $form_city = clean($_POST['form_city']);
      $form_state = clean($_POST['form_state']);
      $form_zip = clean($_POST['form_zip']);
      $form_country = clean($_POST['form_country']);
      $form_email = clean($_POST['form_email']);
      $form_alternate_email = clean($_POST['form_alternate_email']);
      $form_phone_home = clean($_POST['form_phone_home']);
      if ($form_phone_home != '')
      {
         $form_phone_home = format_phone($form_phone_home);
      }
      $form_phone_work = clean($_POST['form_phone_work']);
      if ($form_phone_work != '')
      {
         $form_phone_work = format_phone($form_phone_work);
      }
      $form_phone_mobile = clean($_POST['form_phone_mobile']);
      if ($form_phone_mobile != '')
      {
         $form_phone_mobile = format_phone($form_phone_mobile);
      }
      $form_call_times = clean($_POST['form_call_times']);

      $form_sca_name = clean($_POST['form_sca_name']);
      $form_name_reg_date = NULL;
      if (isset($_POST['form_name_reg_date']))
      {
         $form_name_reg_date = clean($_POST['form_name_reg_date']);
      }
      $form_branch_id = clean($_POST['form_branch_id']);
      $form_branch = "";
      if ($form_branch_id > 0)
      {
         $form_branch = clean($_POST['form_branch' . $form_branch_id]);
      }
      $form_website = clean($_POST['form_website']);

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
      if ($form_alternate_email != '' && !validate_email($form_alternate_email))
      {
         $valid = false;
         $errmsg .= "Please enter an alternate email address with one @ and no spaces.<br/>";
      }
      if (isset($_SESSION['s_atlantian_id']) && $_SESSION['s_atlantian_id'] == $form_atlantian_id && $form_email == '')
      {
         $valid = false;
         $errmsg .= "You must enter an email address to maintain your account.<br/>";
      }

      // Update database if valid
      if ($valid)
      {
         $link = db_admin_connect();
         // Update
         if ($form_atlantian_id > 0)
         {
            // Keep preferred and SCA names matching if the SCA name is not registered
            $wc_sca_name = "";
            if ($form_name_reg_date == NULL)
            {
               $wc_sca_name = ", sca_name = " . value_or_null($form_sca_name);
            }
            $sql_stmt = "UPDATE $DBNAME_AUTH.atlantian SET " .
               "first_name = " . value_or_null($form_first_name) .
               ", middle_name = " . value_or_null($form_middle_name) .
               ", last_name = " . value_or_null($form_last_name) .
               ", publish_name = " . value_or_null($form_publish_name) .
               ", address1 = " . value_or_null($form_address1) .
               ", address2 = " . value_or_null($form_address2) .
               ", city = " . value_or_null($form_city) .
               ", state = " . value_or_null($form_state) .
               ", zip = " . value_or_null($form_zip) .
               ", country = " . value_or_null($form_country) .
               ", publish_address = " . value_or_null($form_publish_address) .
               ", email = " . value_or_null($form_email) .
               ", publish_email = " . value_or_null($form_publish_email) .
               ", alternate_email = " . value_or_null($form_alternate_email) .
               ", publish_alternate_email = " . value_or_null($form_publish_alternate_email) .
               ", phone_home = " . value_or_null($form_phone_home) .
               ", publish_phone_home = " . value_or_null($form_publish_phone_home) .
               ", phone_work = " . value_or_null($form_phone_work) .
               ", publish_phone_work = " . value_or_null($form_publish_phone_work) .
               ", phone_mobile = " . value_or_null($form_phone_mobile) .
               ", publish_phone_mobile = " . value_or_null($form_publish_phone_mobile) .
               ", call_times = " . value_or_null($form_call_times) .
               ", preferred_sca_name = " . value_or_null($form_sca_name) .
               $wc_sca_name .
               ", branch_id = " . value_or_null($form_branch_id) .
               ", website = " . value_or_null($form_website) .
               ", last_updated = " . value_or_null(date("Y-m-d")) .
               ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) .
               " WHERE atlantian_id = " . value_or_null($form_atlantian_id);
           $sql_result = mysql_query($sql_stmt)
               or die("Error updating Atlantian data: " . mysql_error());

            // Update sca_name and email in user table
            $user_query = "UPDATE $DBNAME_AUTH.user_auth SET " .
                          "email = " . value_or_null($form_email) . 
                          ", first_name = " . value_or_null($form_first_name) .
                          ", last_name = " . value_or_null($form_last_name) .
                          ", sca_name = " . value_or_null($form_sca_name) . 
                          ", last_updated = " . value_or_null(date("Y-m-d")) . 
                          ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) .
                          " WHERE atlantian_id = " . value_or_null($form_atlantian_id);
            $user_result = mysql_query($user_query)
               or die("Error updating User data: " . mysql_error());

            // Update sca_name in participant table
            $user_query = "UPDATE $DBNAME_UNIVERSITY.participant SET " .
                          "sca_name = " . value_or_null($form_sca_name) . 
                          ", last_updated = " . value_or_null(date("Y-m-d")) . 
                          ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) .
                          " WHERE atlantian_id = " . value_or_null($form_atlantian_id);
            $user_result = mysql_query($user_query)
               or die("Error updating User data: " . mysql_error());

            $update_msg = "Atlantian successfully updated.";
         }

         db_disconnect($link);
      }
   }
   // Read Existing Atlantian
   else if ($form_atlantian_id > 0)
   {
      $link = db_connect();
      $query = "SELECT atlantian.*, branch.branch FROM $DBNAME_AUTH.atlantian LEFT OUTER JOIN $DBNAME_BRANCH.branch ON atlantian.branch_id = branch.branch_id WHERE atlantian_id = " . $form_atlantian_id;
      $result = mysql_query($query);
      $data = mysql_fetch_array($result, MYSQL_BOTH);

      $form_first_name = clean($data['first_name']);
      $form_middle_name = clean($data['middle_name']);
      $form_last_name = clean($data['last_name']);
      $form_publish_name = $data['publish_name'];
      $form_address1 = clean($data['address1']);
      $form_address2 = clean($data['address2']);
      $form_city = clean($data['city']);
      $form_state = clean($data['state']);
      $form_zip = clean($data['zip']);
      $form_country = clean($data['country']);
      $form_publish_address = $data['publish_address'];
      $form_email = clean($data['email']);
      $form_publish_email = $data['publish_email'];
      $form_alternate_email = clean($data['alternate_email']);
      $form_publish_alternate_email = $data['publish_alternate_email'];
      $form_phone_home = clean($data['phone_home']);
      $form_publish_phone_home = $data['publish_phone_home'];
      $form_phone_work = clean($data['phone_work']);
      $form_publish_phone_work = $data['publish_phone_work'];
      $form_phone_mobile = clean($data['phone_mobile']);
      $form_publish_phone_mobile = $data['publish_phone_mobile'];
      $form_call_times = clean($data['call_times']);

      $form_sca_name = clean($data['preferred_sca_name']);
      $form_name_reg_date = clean($data['name_reg_date']);
      $form_branch_id = clean($data['branch_id']);
      $form_branch = clean($data['branch']);
      $form_website = clean($data['website']);

      mysql_free_result($result);

      db_disconnect($link);
   }

   // Get pick lists
   $branch_data_array = get_branch_pick_list();
?>
<p align="center" class="title2">
Atlantian Information
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
<p align="center">
<b>Privacy Information:</b>
By default, your personal information (name, address, email addresses, phone numbers) is kept private.  <br/>
By checking any <i>Publish</i> checkbox for a field, you indicate your agreement to display your information for that field 
on Kingdom of Atlantia websites.
</p>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>"/>
<?php 
   if (isset($form_atlantian_id) && $form_atlantian_id > 0)
   {
?>
   <input type="hidden" name="form_atlantian_id" id="form_atlantian_id" value="<?php echo $form_atlantian_id; ?>"/>
<?php 
   }
   if (isset($form_name_reg_date) && $form_name_reg_date > 0)
   {
?>
   <input type="hidden" name="form_name_reg_date" id="form_name_reg_date" value="<?php echo $form_name_reg_date; ?>"/>
<?php 
   }
?>
<table align="center" cellpadding="5" cellspacing="1" border="1">
   <tr>
      <th class="title" colspan="4" bgcolor="<?php echo $TITLE_BG_COLOR; ?>">Contact Information</th>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_first_name"><label for="form_middle_name"><label for="form_last_name">Name</label></label></label><br/><i><label for="form_publish_name">Publish</label></i><input type="checkbox" name="form_publish_name" id="form_publish_name" value="1"<?php if (isset($form_publish_name)) { if ($form_publish_name == 1) { echo ' CHECKED'; } }?>/></td>
      <td class="data" colspan="3">
      <span class="titleleft"><label for="form_first_name">First</label></span> <input type="text" name="form_first_name" id="form_first_name" size="20" maxlength="50"<?php if (isset($form_first_name) && $form_first_name != '') { echo " value=\"$form_first_name\"";} ?>/>
      <span class="titleleft"><label for="form_middle_name">Middle</label></span> <input type="text" name="form_middle_name" id="form_middle_name" size="20" maxlength="50"<?php if (isset($form_middle_name) && $form_middle_name != '') { echo " value=\"$form_middle_name\"";} ?>/>
      <span class="titleleft"><label for="form_last_name">Last</label></span> <input type="text" name="form_last_name" id="form_last_name" size="30" maxlength="50"<?php if (isset($form_last_name) && $form_last_name != '') { echo " value=\"$form_last_name\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_address1"><label for="form_address2">Address</label></label><br/><i><label for="form_publish_address">Publish</label></i><input type="checkbox" name="form_publish_address" id="form_publish_address" value="1"<?php if (isset($form_publish_address)) { if ($form_publish_address == 1) { echo ' CHECKED'; } }?>/></td>
      <td class="data" colspan="3">
      <input type="text" name="form_address1" id="form_address1" size="50" maxlength="100"<?php if (isset($form_address1) && $form_address1 != '') { echo " value=\"$form_address1\"";} ?>/><br/>
      <input type="text" name="form_address2" id="form_address2" size="50" maxlength="100"<?php if (isset($form_address2) && $form_address2 != '') { echo " value=\"$form_address2\"";} ?>/><br/>
      <span class="titleleft"><label for="form_city">City</label></span> <input type="text" name="form_city" id="form_city" size="30" maxlength="50"<?php if (isset($form_city) && $form_city != '') { echo " value=\"$form_city\"";} ?>/>
      <span class="titleleft"><label for="form_state">State</label></span> <input type="text" name="form_state" id="form_state" size="5" maxlength="2"<?php if (isset($form_state) && $form_state != '') { echo " value=\"$form_state\"";} ?>/>
      <span class="titleleft"><label for="form_zip">Zip</label></span> <input type="text" name="form_zip" id="form_zip" size="15" maxlength="10"<?php if (isset($form_zip) && $form_zip != '') { echo " value=\"$form_zip\"";} ?>/>
      <span class="titleleft"><label for="form_country">Country</label></span> <input type="text" name="form_country" id="form_country" size="30" maxlength="50"<?php if (isset($form_country) && $form_country != '') { echo " value=\"$form_country\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_email">Email</label><br/><i><label for="form_publish_email">Publish</label></i><input type="checkbox" name="form_publish_email" id="form_publish_email" value="1"<?php if (isset($form_publish_email)) { if ($form_publish_email == 1) { echo ' CHECKED'; } }?>/></td>
      <td class="data"><input type="text" name="form_email" id="form_email" size="50" maxlength="100"<?php if (isset($form_email) && $form_email != '') { echo " value=\"$form_email\"";} ?>></td>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_alternate_email">Alternate Email</label><br/><i><label for="form_alternate_email">Publish</label></i><input type="checkbox" name="form_publish_alternate_email" id="form_publish_alternate_email" value="1"<?php if (isset($form_publish_alternate_email)) { if ($form_publish_alternate_email == 1) { echo ' CHECKED'; } }?>/></td>
      <td class="data"><input type="text" name="form_alternate_email" id="form_alternate_email" size="50" maxlength="100"<?php if (isset($form_alternate_email) && $form_alternate_email != '') { echo " value=\"$form_alternate_email\"";} ?>></td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_phone_home">Home Phone</label><br/><i><label for="form_publish_phone_home">Publish</label></i><input type="checkbox" name="form_publish_phone_home" id="form_publish_phone_home" value="1"<?php if (isset($form_publish_phone_home)) { if ($form_publish_phone_home == 1) { echo ' CHECKED'; } }?>/></td>
      <td class="data"><input type="text" name="form_phone_home" id="form_phone_home" size="15" maxlength="20"<?php if (isset($form_phone_home) && $form_phone_home != '') { echo " value=\"$form_phone_home\"";} ?>></td>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_call_times">Call Times</label></td>
      <td class="data"><input type="text" name="form_call_times" id="form_call_times" size="15" maxlength="20"<?php if (isset($form_call_times) && $form_call_times != '') { echo " value=\"$form_call_times\"";} ?>></td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_phone_mobile">Mobile Phone</label><br/><i><label for="form_publish_phone_mobile">Publish</label></i><input type="checkbox" name="form_publish_phone_mobile" id="form_publish_phone_mobile" value="1"<?php if (isset($form_publish_phone_mobile)) { if ($form_publish_phone_mobile == 1) { echo ' CHECKED'; } }?>/></td>
      <td class="data"><input type="text" name="form_phone_mobile" id="form_phone_mobile" size="15" maxlength="20"<?php if (isset($form_phone_mobile) && $form_phone_mobile != '') { echo " value=\"$form_phone_mobile\"";} ?>></td>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_phone_work">Work Phone</label><br/><i><label for="form_publish_phone_work">Publish</label></i><input type="checkbox" name="form_publish_phone_work" id="form_publish_phone_work" value="1"<?php if (isset($form_publish_phone_work)) { if ($form_publish_phone_work == 1) { echo ' CHECKED'; } }?>/></td>
      <td class="data"><input type="text" name="form_phone_work" id="form_phone_work" size="15" maxlength="20"<?php if (isset($form_phone_work) && $form_phone_work != '') { echo " value=\"$form_phone_work\"";} ?>></td>
   </tr>
   <tr>
      <th class="title" colspan="4" bgcolor="<?php echo $TITLE_BG_COLOR; ?>">SCA Information</th>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_sca_name">SCA Name</label></td>
      <td class="data"><input type="text" name="form_sca_name" id="form_sca_name" size="50" maxlength="255"<?php if (isset($form_sca_name) && $form_sca_name != '') { echo " value=\"$form_sca_name\"";} ?>/></td>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_branch_id">Home Branch</label></td>
      <td class="data">
      <select name="form_branch_id" id="form_branch_id">
         <option></option>
<?php
   for ($i = 0; $i < count($branch_data_array); $i++)
   {
      echo '<option id="' . $branch_data_array[$i]['branch'] . '" value="' . $branch_data_array[$i]['branch_id'] . '"';
      if (isset($form_branch_id) && $form_branch_id == $branch_data_array[$i]['branch_id'])
      {
         echo ' selected';
      }
      echo '>' . $branch_data_array[$i]['branch_name'] . '</option>';
   }
?>
      </select>
<?php
   for ($i = 0; $i < count($branch_data_array); $i++)
   {
?>
      <input type="hidden" name="form_branch<?php echo $branch_data_array[$i]['branch_id']; ?>" id="branch<?php echo $branch_data_array[$i]['branch_id']; ?>" value="<?php echo $branch_data_array[$i]['branch']; ?>" />
<?php
   }
?>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_website">Website</label></td>
      <td class="data" colspan="3"><input type="text" name="form_website" id="form_website" size="100" maxlength="255"<?php if (isset($form_website) && $form_website != '') { echo " value=\"$form_website\"";} ?>/></td>
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