<?php
include_once("db.php");
include_once("../db/db.php");
include_once("../db/session.php");

$form_participant_id = 0;
if (isset($_REQUEST['form_participant_id']))
{
   $form_participant_id = $_REQUEST['form_participant_id'];
}
if (isset($_REQUEST['participant_id']))
{
   $form_participant_id = $_REQUEST['participant_id'];
}

$form_atlantian_id = 0;
if (isset($_REQUEST['form_atlantian_id']))
{
   $form_atlantian_id = $_REQUEST['form_atlantian_id'];
}
if (isset($_REQUEST['atlantian_id']))
{
   $form_atlantian_id = $_REQUEST['atlantian_id'];
}

$form_user_id = 0;
if (isset($_REQUEST['form_user_id']))
{
   $form_user_id = $_REQUEST['form_user_id'];
}
if (isset($_REQUEST['user_id']))
{
   $form_user_id = $_REQUEST['user_id'];
}

$mode = $MODE_ADD;
if (isset($_REQUEST['mode']))
{
   $mode = $_REQUEST['mode'];
}

include("../header.php");
?>
<p align="center" class="title2"><?php echo ucfirst($mode); ?> Participant</p>
<?php
if (isset($_SESSION[$UNIVERSITY_ADMIN]) && $_SESSION[$UNIVERSITY_ADMIN] == 1)
{
   $SUBMIT_SAVE = "Save Participant Information";
   $SUBMIT_MERGE = "Merge Participant";
   $SUBMIT_DELETE_REGISTRATION = "Delete Registrations";

   // Data submitted
   // Delete Registrations
   if (isset($_POST['submit']) && $_POST['submit'] == $SUBMIT_DELETE_REGISTRATION)
   {
      $del_registration_id = '';
      for ($i = 1; $i < $_POST['del_registration_max']; $i++)
      {
         if (isset($_POST['del_registration_id' . $i]))
         {
            if ($del_registration_id != '')
            {
               $del_registration_id .= ',';
            }
            $del_registration_id .= $_POST['del_registration_id' . $i];
         }
      }

      if ($del_registration_id != '')
      {
         $link = db_admin_connect();

         $delete = "DELETE FROM $DBNAME_UNIVERSITY.registration WHERE registration_id IN ($del_registration_id)";

         $dresult = mysql_query($delete)
            or die("Error deleting Registrations: " . $delete . "<br/>" . mysql_error());

         /* Closing connection */
         db_disconnect($link);
?>
<p align="center">Registrations successfully deleted.</p>
<?php 
      }
      else
      {
         $delerrmsg = "Please select at least one Registration to delete.";
?>
<p align="center" class="title3" style="color:red"><?php echo $delerrmsg; ?></p>
<?php 
      }
   }

   if (isset($_POST['submit']) && $_POST['submit'] == $SUBMIT_SAVE)
   {
      $form_first_name = NULL;
      if (isset($_POST['form_first_name']))
      {
         $form_first_name = clean($_POST['form_first_name']);
      }
      $form_middle_name = NULL;
      if (isset($_POST['form_middle_name']))
      {
         $form_middle_name = clean($_POST['form_middle_name']);
      }
      $form_last_name = NULL;
      if (isset($_POST['form_last_name']))
      {
         $form_last_name = clean($_POST['form_last_name']);
      }
      $form_email = NULL;
      if (isset($_POST['form_email']))
      {
         $form_email = clean($_POST['form_email']);
      }
      $form_sca_name = NULL;
      if (isset($_POST['form_sca_name']))
      {
         $form_sca_name = clean($_POST['form_sca_name']);
      }
      $form_name_reg_date = NULL;
      if (isset($_POST['form_name_reg_date']))
      {
         $form_name_reg_date = clean($_POST['form_name_reg_date']);
      }
      $form_branch_id = NULL;
      if (isset($_POST['form_branch_id']))
      {
         $form_branch_id = clean($_POST['form_branch_id']);
      }
      $form_branch = NULL;
      if (isset($_POST['form_branch']))
      {
         $form_branch = clean($_POST['form_branch']);
      }

      $form_b_old_university_id = NULL;
      if (isset($_POST['form_b_old_university_id']))
      {
         $form_b_old_university_id = clean($_POST['form_b_old_university_id']);
      }
      $form_b_old_degree_status_id = NULL;
      if (isset($_POST['form_b_old_degree_status_id']))
      {
         $form_b_old_degree_status_id = clean($_POST['form_b_old_degree_status_id']);
      }
      $form_b_university_id = NULL;
      if (isset($_POST['form_b_university_id']))
      {
         $form_b_university_id = clean($_POST['form_b_university_id']);
      }
      $form_b_degree_status_id = NULL;
      if (isset($_POST['form_b_degree_status_id']))
      {
         $form_b_degree_status_id = clean($_POST['form_b_degree_status_id']);
      }
      $form_f_university_id = NULL;
      if (isset($_POST['form_f_university_id']))
      {
         $form_f_university_id = clean($_POST['form_f_university_id']);
      }
      $form_f_degree_status_id = NULL;
      if (isset($_POST['form_f_degree_status_id']))
      {
         $form_f_degree_status_id = clean($_POST['form_f_degree_status_id']);
      }
      $form_m_university_id = NULL;
      if (isset($_POST['form_m_university_id']))
      {
         $form_m_university_id = clean($_POST['form_m_university_id']);
      }
      $form_m_degree_status_id = NULL;
      if (isset($_POST['form_m_degree_status_id']))
      {
         $form_m_degree_status_id = clean($_POST['form_m_degree_status_id']);
      }
      $form_d_university_id = NULL;
      if (isset($_POST['form_d_university_id']))
      {
         $form_d_university_id = clean($_POST['form_d_university_id']);
      }
      $form_d_degree_status_id = NULL;
      if (isset($_POST['form_d_degree_status_id']))
      {
         $form_d_degree_status_id = clean($_POST['form_d_degree_status_id']);
      }

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

      // Update database if valid
      if ($valid)
      {
         $link = db_admin_connect();
         $update_msg = "";

         // Update
         if ($form_user_id > 0 && $mode == $MODE_EDIT)
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
               or die("Error updating User data: " . $sql_stmt . "<br/>" . mysql_error());
            $update_msg .= "User successfully updated.";
         }

         // Update
         if ($form_atlantian_id > 0 && $mode == $MODE_EDIT)
         {
            // Keep preferred and SCA names matching if the SCA name is not registered
            $wc_sca_name = "";
            if ($form_name_reg_date == NULL)
            {
               $wc_sca_name = ", sca_name = " . value_or_null($form_sca_name);
            }
            $sql_stmt = "UPDATE $DBNAME_AUTH.atlantian SET " .
               "first_name = " . value_or_null($form_first_name) .
               ", last_name = " . value_or_null($form_last_name) .
               ", email = " . value_or_null($form_email) .
               ", preferred_sca_name = " . value_or_null($form_sca_name) .
               $wc_sca_name .
               ", branch_id = " . value_or_null($form_branch_id) .
               ", last_updated = " . value_or_null(date("Y-m-d")) .
               ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) .
               " WHERE atlantian_id = " . value_or_null($form_atlantian_id);
            $sql_result = mysql_query($sql_stmt)
               or die("Error updating Atlantian data: " . $sql_stmt . "<br/>" . mysql_error());
            $update_msg .= "Atlantian successfully updated.";
         }
         // Insert
         else if ($form_participant_id == 0 && $mode == $MODE_ADD)
         {
            $sql_stmt = "INSERT INTO $DBNAME_AUTH.atlantian (first_name, middle_name, last_name, email, sca_name, preferred_sca_name, branch_id, date_created, last_updated, last_updated_by) VALUES (" .
               value_or_null($form_first_name) . ", " . 
               value_or_null($form_middle_name) . ", " . 
               value_or_null($form_last_name) . ", " . 
               value_or_null($form_email) . ", " . 
               value_or_null($form_sca_name) . ", " . 
               value_or_null($form_sca_name) . ", " . 
               value_or_null($form_branch_id) . ", " . 
               value_or_null(date("Y-m-d")) . ", " . 
               value_or_null(date("Y-m-d")) . ", " . 
               value_or_null($_SESSION['s_user_id']) . ")";
            $sql_result = mysql_query($sql_stmt)
               or die("Error inserting Atlantian data: " . $sql_stmt . "<br/>" . mysql_error());
            $form_atlantian_id = mysql_insert_id();
            $update_msg .= "Atlantian successfully inserted.";
         }

         // Update
         if ($form_participant_id > 0 && $mode == $MODE_EDIT)
         {
            // Update sca_name in participant table
            $sql_stmt = "UPDATE $DBNAME_UNIVERSITY.participant SET " .
                          "sca_name = " . value_or_null($form_sca_name) . 
                          ", b_old_university_id = " . value_or_null($form_b_old_university_id) . 
                          ", b_old_degree_status_id = " . value_or_null($form_b_old_degree_status_id) . 
                          ", b_university_id = " . value_or_null($form_b_university_id) . 
                          ", b_degree_status_id = " . value_or_null($form_b_degree_status_id) . 
                          ", f_university_id = " . value_or_null($form_f_university_id) . 
                          ", f_degree_status_id = " . value_or_null($form_f_degree_status_id) . 
                          ", m_university_id = " . value_or_null($form_m_university_id) . 
                          ", m_degree_status_id = " . value_or_null($form_m_degree_status_id) . 
                          ", d_university_id = " . value_or_null($form_d_university_id) . 
                          ", d_degree_status_id = " . value_or_null($form_d_degree_status_id) . 
                          ", last_updated = " . value_or_null(date("Y-m-d")) . 
                          ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) .
                          " WHERE participant_id = " . value_or_null($form_participant_id);
            $sql_result = mysql_query($sql_stmt)
               or die("Error updating Participant data: " . $sql_stmt . "<br/>" . mysql_error());
            $update_msg .= "<br/>Participant successfully updated.";
         }
         // Insert
         else if ($form_participant_id == 0 && $mode == $MODE_ADD)
         {
            $sql_stmt = "INSERT INTO $DBNAME_UNIVERSITY.participant (atlantian_id, sca_name, b_old_university_id, b_old_degree_status_id, " .
                        "b_university_id, b_degree_status_id, f_university_id, f_degree_status_id, m_university_id, m_degree_status_id, " .
                        "d_university_id, d_degree_status_id, date_created, last_updated, last_updated_by) VALUES (" .
                        value_or_null($form_atlantian_id) . ", " .
                        value_or_null($form_sca_name) . ", " .
                        value_or_null($form_b_old_university_id) . ", " .
                        value_or_null($form_b_old_degree_status_id) . ", " .
                        value_or_null($form_b_university_id) . ", " .
                        value_or_null($form_b_degree_status_id) . ", " .
                        value_or_null($form_f_university_id) . ", " .
                        value_or_null($form_f_degree_status_id) . ", " .
                        value_or_null($form_m_university_id) . ", " .
                        value_or_null($form_m_degree_status_id) . ", " .
                        value_or_null($form_d_university_id) . ", " .
                        value_or_null($form_d_degree_status_id) . ", " .
                        value_or_null(date("Y-m-d")) . ", " . 
                        value_or_null(date("Y-m-d")) . ", " . 
                        value_or_null($_SESSION['s_user_id']) . ")";
            $sql_result = mysql_query($sql_stmt)
               or die("Error inserting Participant data: " . $sql_stmt . "<br/>" . mysql_error());
            $form_atlantian_id = mysql_insert_id();
            $update_msg .= "Participant successfully inserted.";
         }

         db_disconnect($link);
      }
   }
   // Read Existing Participant
   if ($form_participant_id > 0)
   {
      $link = db_connect();
      $query = "SELECT participant.*, atlantian.first_name, atlantian.middle_name, atlantian.last_name, atlantian.email, atlantian.preferred_sca_name, atlantian.name_reg_date, atlantian.branch_id, branch.branch, " .
               "user_auth.first_name as fname, user_auth.last_name as lname, user_auth.email as uemail " .
               "FROM $DBNAME_UNIVERSITY.participant LEFT OUTER JOIN $DBNAME_AUTH.atlantian ON participant.atlantian_id = atlantian.atlantian_id " .
               "LEFT OUTER JOIN $DBNAME_BRANCH.branch ON atlantian.branch_id = branch.branch_id " .
               "LEFT OUTER JOIN $DBNAME_AUTH.user_auth ON participant.user_id = user_auth.user_id " .
               "WHERE participant_id = " . $form_participant_id;
      $result = mysql_query($query)
         or die("Error selecting Participant data: " . $query . "<br/>" . mysql_error());
      $data = mysql_fetch_array($result, MYSQL_BOTH);

      $form_atlantian_id = clean($data['atlantian_id']);
      $form_user_id = clean($data['user_id']);
      $form_sca_name = clean($data['sca_name']);
      if ($form_atlantian_id != "")
      {
         $form_first_name = clean($data['first_name']);
         $form_last_name = clean($data['last_name']);
         $form_email = clean($data['email']);
         $form_branch_id = clean($data['branch_id']);
         $form_branch = clean($data['branch']);
         $form_name_reg_date = clean($data['name_reg_date']);
         $form_preferred_sca_name = clean($data['preferred_sca_name']);
      }
      else if ($form_user_id != "")
      {
         $form_first_name = clean($data['fname']);
         $form_last_name = clean($data['lname']);
         $form_email = clean($data['uemail']);
      }

      $form_b_old_university_id = clean($data['b_old_university_id']);
      $form_b_old_degree_status_id = clean($data['b_old_degree_status_id']);
      $form_b_university_id = clean($data['b_university_id']);
      $form_b_degree_status_id = clean($data['b_degree_status_id']);
      $form_f_university_id = clean($data['f_university_id']);
      $form_f_degree_status_id = clean($data['f_degree_status_id']);
      $form_m_university_id = clean($data['m_university_id']);
      $form_m_degree_status_id = clean($data['m_degree_status_id']);
      $form_d_university_id = clean($data['d_university_id']);
      $form_d_degree_status_id = clean($data['d_degree_status_id']);

      mysql_free_result($result);

      db_disconnect($link);
   }

   // Get pick lists
   $branch_data_array = get_branch_pick_list();
   $university_data_array = get_university_pick_list();
   $degree_status_data_array = get_degree_status_pick_list();
?>
<p align="center" class="title2">
Participant Information
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
   if (isset($form_participant_id) && $form_participant_id > 0)
   {
?>
   <input type="hidden" name="form_participant_id" id="form_participant_id" value="<?php echo $form_participant_id; ?>"/>
<?php 
   }
   if (isset($form_atlantian_id) && $form_atlantian_id > 0)
   {
?>
   <input type="hidden" name="form_atlantian_id" id="form_atlantian_id" value="<?php echo $form_atlantian_id; ?>"/>
<?php 
   }
   if (isset($form_user_id) && $form_user_id > 0)
   {
?>
   <input type="hidden" name="form_user_id" id="form_user_id" value="<?php echo $form_user_id; ?>"/>
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
      <th class="title" colspan="3" bgcolor="<?php echo $TITLE_BG_COLOR; ?>">Contact Information</th>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_first_name"><label for="form_middle_name"><label for="form_last_name">Name</label></label></label></td>
      <td class="data" colspan="2">
      <span class="titleleft"><label for="form_first_name">First</label></span> <input type="text" name="form_first_name" id="form_first_name" size="20" maxlength="50"<?php if (isset($form_first_name) && $form_first_name != '') { echo " value=\"$form_first_name\"";} ?>/>
      <span class="titleleft"><label for="form_last_name">Last</label></span> <input type="text" name="form_last_name" id="form_last_name" size="30" maxlength="50"<?php if (isset($form_last_name) && $form_last_name != '') { echo " value=\"$form_last_name\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_email">Email</label></td>
      <td class="data" colspan="2"><input type="text" name="form_email" id="form_email" size="50" maxlength="100"<?php if (isset($form_email) && $form_email != '') { echo " value=\"$form_email\"";} ?>></td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_sca_name">SCA Name</label></td>
      <td class="data" colspan="2"><input type="text" name="form_sca_name" id="form_sca_name" size="50" maxlength="255"<?php if (isset($form_sca_name) && $form_sca_name != '') { echo " value=\"$form_sca_name\"";} ?>/></td>
   </tr>
<?php
   if ($mode == $MODE_EDIT && $form_atlantian_id != "" && $form_atlantian_id != 0)
   {
?>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_branch_id">Home Branch</label></td>
      <td class="data" colspan="2">
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
<?php
   }
?>
   <tr>
      <th class="title" colspan="3" bgcolor="<?php echo $TITLE_BG_COLOR; ?>">Degree Information</th>
   </tr>
   <tr>
      <th class="title" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Degree</th>
      <th class="title" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_b_old_university_id"><label for="form_b_university_id"><label for="form_f_university_id"><label for="form_m_university_id"><label for="form_d_university_id">University Session</label></label></label></label></label></th>
      <th class="title" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_b_old_degree_status_id"><label for="form_b_degree_status_id"><label for="form_f_degree_status_id"><label for="form_m_degree_status_id"><label for="form_d_degree_status_id">Degree Status</label></label></label></label></label></th>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Old Bachelors</td>
      <td class="datacenter">
      <select name="form_b_old_university_id" id="form_b_old_university_id">
         <option></option>
<?php
         for ($i = 0; $i < count($university_data_array); $i++)
         {
            echo '<option id="' . $university_data_array[$i]['university_code'] . '" value="' . $university_data_array[$i]['university_id'] . '"';
            if (isset($form_b_old_university_id) && $form_b_old_university_id == $university_data_array[$i]['university_id'])
            {
               echo ' selected';
            }
            echo '>' . $university_data_array[$i]['university_code'] . '</option>';
         }
?>
      </select>
      </td>
      <td class="datacenter">
      <select name="form_b_old_degree_status_id" id="form_b_old_degree_status_id">
         <option></option>
<?php
         for ($i = 0; $i < count($degree_status_data_array); $i++)
         {
            echo '<option id="' . $degree_status_data_array[$i]['degree_status'] . '" value="' . $degree_status_data_array[$i]['degree_status_id'] . '"';
            if (isset($form_b_old_degree_status_id) && $form_b_old_degree_status_id == $degree_status_data_array[$i]['degree_status_id'])
            {
               echo ' selected';
            }
            echo '>' . $degree_status_data_array[$i]['degree_status'] . '</option>';
         }
?>
      </select>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Bachelors</td>
      <td class="datacenter">
      <select name="form_b_university_id" id="form_b_university_id">
         <option></option>
<?php
         for ($i = 0; $i < count($university_data_array); $i++)
         {
            echo '<option id="' . $university_data_array[$i]['university_code'] . '" value="' . $university_data_array[$i]['university_id'] . '"';
            if (isset($form_b_university_id) && $form_b_university_id == $university_data_array[$i]['university_id'])
            {
               echo ' selected';
            }
            echo '>' . $university_data_array[$i]['university_code'] . '</option>';
         }
?>
      </select>
      </td>
      <td class="datacenter">
      <select name="form_b_degree_status_id" id="form_b_degree_status_id">
         <option></option>
<?php
         for ($i = 0; $i < count($degree_status_data_array); $i++)
         {
            echo '<option id="' . $degree_status_data_array[$i]['degree_status'] . '" value="' . $degree_status_data_array[$i]['degree_status_id'] . '"';
            if (isset($form_b_degree_status_id) && $form_b_degree_status_id == $degree_status_data_array[$i]['degree_status_id'])
            {
               echo ' selected';
            }
            echo '>' . $degree_status_data_array[$i]['degree_status'] . '</option>';
         }
?>
      </select>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Fellowship</td>
      <td class="datacenter">
      <select name="form_f_university_id" id="form_f_university_id">
         <option></option>
<?php
         for ($i = 0; $i < count($university_data_array); $i++)
         {
            echo '<option id="' . $university_data_array[$i]['university_code'] . '" value="' . $university_data_array[$i]['university_id'] . '"';
            if (isset($form_f_university_id) && $form_f_university_id == $university_data_array[$i]['university_id'])
            {
               echo ' selected';
            }
            echo '>' . $university_data_array[$i]['university_code'] . '</option>';
         }
?>
      </select>
      </td>
      <td class="datacenter">
      <select name="form_f_degree_status_id" id="form_f_degree_status_id">
         <option></option>
<?php
         for ($i = 0; $i < count($degree_status_data_array); $i++)
         {
            echo '<option id="' . $degree_status_data_array[$i]['degree_status'] . '" value="' . $degree_status_data_array[$i]['degree_status_id'] . '"';
            if (isset($form_f_degree_status_id) && $form_f_degree_status_id == $degree_status_data_array[$i]['degree_status_id'])
            {
               echo ' selected';
            }
            echo '>' . $degree_status_data_array[$i]['degree_status'] . '</option>';
         }
?>
      </select>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Masters</td>
      <td class="datacenter">
      <select name="form_m_university_id" id="form_m_university_id">
         <option></option>
<?php
         for ($i = 0; $i < count($university_data_array); $i++)
         {
            echo '<option id="' . $university_data_array[$i]['university_code'] . '" value="' . $university_data_array[$i]['university_id'] . '"';
            if (isset($form_m_university_id) && $form_m_university_id == $university_data_array[$i]['university_id'])
            {
               echo ' selected';
            }
            echo '>' . $university_data_array[$i]['university_code'] . '</option>';
         }
?>
      </select>
      </td>
      <td class="datacenter">
      <select name="form_m_degree_status_id" id="form_m_degree_status_id">
         <option></option>
<?php
         for ($i = 0; $i < count($degree_status_data_array); $i++)
         {
            echo '<option id="' . $degree_status_data_array[$i]['degree_status'] . '" value="' . $degree_status_data_array[$i]['degree_status_id'] . '"';
            if (isset($form_m_degree_status_id) && $form_m_degree_status_id == $degree_status_data_array[$i]['degree_status_id'])
            {
               echo ' selected';
            }
            echo '>' . $degree_status_data_array[$i]['degree_status'] . '</option>';
         }
?>
      </select>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Doctorate</td>
      <td class="datacenter">
      <select name="form_d_university_id" id="form_d_university_id">
         <option></option>
<?php
         for ($i = 0; $i < count($university_data_array); $i++)
         {
            echo '<option id="' . $university_data_array[$i]['university_code'] . '" value="' . $university_data_array[$i]['university_id'] . '"';
            if (isset($form_d_university_id) && $form_d_university_id == $university_data_array[$i]['university_id'])
            {
               echo ' selected';
            }
            echo '>' . $university_data_array[$i]['university_code'] . '</option>';
         }
?>
      </select>
      </td>
      <td class="datacenter">
      <select name="form_d_degree_status_id" id="form_d_degree_status_id">
         <option></option>
<?php
         for ($i = 0; $i < count($degree_status_data_array); $i++)
         {
            echo '<option id="' . $degree_status_data_array[$i]['degree_status'] . '" value="' . $degree_status_data_array[$i]['degree_status_id'] . '"';
            if (isset($form_d_degree_status_id) && $form_d_degree_status_id == $degree_status_data_array[$i]['degree_status_id'])
            {
               echo ' selected';
            }
            echo '>' . $degree_status_data_array[$i]['degree_status'] . '</option>';
         }
?>
      </select>
      </td>
   </tr>
</table>
<p class="title">
<input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_SAVE; ?>"/>
</p>
</form>
<form action="select_participant.php" method="post">
<p class="title">
<input type="hidden" name="first_participant_id" id="first_participant_id" value="<?php echo $form_participant_id; ?>"/>
<input type="hidden" name="mode" id="mode" value="<?php echo $MODE_EDIT; ?>"/>
<input type="hidden" name="type" id="type" value="<?php echo $ST_MERGE; ?>"/>
<input type="submit" id="submit" value="<?php echo $SUBMIT_MERGE; ?>"/>
</p>
</form>
<?php
   if ($form_participant_id != NULL && $form_participant_id != "" && $form_participant_id != 0)
   {
      //---------------------
      // PREREG
      //---------------------
      // Get current university session
      $query = "SELECT university.university_id, university.university_code, university.university_date, university.publish_date, university.closed_date FROM $DBNAME_UNIVERSITY.university " .
               "WHERE is_university = 1 AND university_date = (SELECT MAX(university_date) FROM $DBNAME_UNIVERSITY.university WHERE is_university = 1 AND publish_date IS NOT NULL AND publish_date <= CURRENT_DATE)";
      $result = mysql_query($query)
         or die("Current University Query failed : " . $query. "<br/>" . mysql_error());
      $data = mysql_fetch_array($result, MYSQL_BOTH);

      $university_id = clean($data['university_id']);
      $university_code = clean($data['university_code']);
      $university_date = clean($data['university_date']);
      $date_display = format_full_date($university_date);
      $publish_date = clean($data['publish_date']);
      $closed_date = clean($data['closed_date']);

      mysql_free_result($result);

      // Retrieve classes
      $query = "SELECT registration.*, participant_type.participant_type, course.course_number, course.title, course.credits, course.course_status_id " .
               "FROM $DBNAME_UNIVERSITY.registration JOIN $DBNAME_UNIVERSITY.course ON registration.course_id = course.course_id " .
               "JOIN $DBNAME_UNIVERSITY.participant_type ON registration.participant_type_id = participant_type.participant_type_id " .
               "WHERE registration.participant_id = $form_participant_id " .
               "AND registration.registration_status_id = $STATUS_REGISTERED " .
               "AND course.university_id = $university_id " .
               "ORDER BY course.course_number";
      $result = mysql_query($query)
         or die("Class Query failed : " . mysql_error());
      $num_classes = mysql_num_rows($result);

      if ($num_classes > 0)
      {
?>
<br/>
<h2 style="text-align:center">Pre-Registrations</h2>
   <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<?php 
         if (isset($form_participant_id) && $form_participant_id > 0)
         {
?>
   <input type="hidden" name="participant_id" id="participant_id" value="<?php echo $form_participant_id; ?>"/>
<?php 
         }
?>
<table cellpadding="5" cellspacing="0" align="center">
   <tr><th colspan="6" style="text-align:center;color:<?php echo $accent_color; ?>;background-color:white"><?php echo "$university_code - $date_display"; ?></th></tr>
   <tr>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Action</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">#</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Title</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Instructor(s)</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Credits</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Attendance</th>
   </tr>
<?php
         $j = 1;
         $prev_university_id = 0;
         $total_credits = 0;
         while ($data = mysql_fetch_array($result, MYSQL_BOTH))
         {
            $registration_id = clean($data['registration_id']);
            $course_id = clean($data['course_id']);
            $course_number = clean($data['course_number']);
            $title = clean($data['title']);
            $credits = clean($data['credits']);
            $total_credits += $credits;
            $participant_type = clean($data['participant_type']);
            $course_status_id = clean($data['course_status_id']);

            $instructor_query = "SELECT participant.participant_id, participant.sca_name FROM $DBNAME_UNIVERSITY.registration " .
               "JOIN $DBNAME_UNIVERSITY.participant ON registration.participant_id = participant.participant_id " .
               "WHERE registration.course_id = $course_id AND registration.participant_type_id = $TYPE_INSTRUCTOR";
            $instructor_result = mysql_query($instructor_query)
               or die("Instructor Query failed : " . mysql_error());
            $num_instructors = mysql_num_rows($instructor_result);
            $instructor_display = "";
            if ($num_instructors > 0)
            {
               $i = 0;
               while ($instructor_data = mysql_fetch_array($instructor_result, MYSQL_BOTH))
               {
                  $instructor = clean($instructor_data['sca_name']);
                  if ($instructor == "")
                  {
                     $instructor = "(No SCA name)";
                  }
                  if ($i > 0)
                  {
                     $instructor_display .= "<br/>";
                  }
                  $instructor_display .= htmlentities($instructor);
                  $i++;
               }
            }

            $bgcolor = (($j%2 == 0)? "#DDDDDD": "#EEEEEE");
            if ($course_status_id == $STATUS_CANCELED)
            {
               $bgcolor = "#ff9999";
            }
            else if ($course_status_id == $STATUS_PENDING)
            {
               $bgcolor = "#ffff99";
            }
?>
   <tr>
      <td bgcolor="<?php echo $bgcolor; ?>"><input type="checkbox" name="del_registration_id<?php echo $j; ?>" id="del_registration_id<?php echo $j; ?>" value="<?php echo $registration_id; ?>"/></td>
      <td bgcolor="<?php echo $bgcolor; ?>"><?php echo $course_number; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>"><a href="registration.php?mode=<?php echo $MODE_EDIT; ?>&amp;registration_id=<?php echo $registration_id; ?>"><?php echo $title; ?></a></td>
      <td bgcolor="<?php echo $bgcolor; ?>"><?php echo $instructor_display; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>"><?php echo $credits; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>"><?php echo $participant_type; ?></td>
   </tr>
<?php
           $j++;
         }
?>
   <input type="hidden" name="del_registration_max" id="del_registration_max" value="<?php echo $j; ?>"/>
   <tr>
      <td class="datacenter" colspan="6">
      <input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_DELETE_REGISTRATION; ?>"/>
      </td>
   </tr>
</table>
</form>
<p class="datacenter"><span style="color:<?php echo $accent_color; ?>;font-weight:bold">Total:</span> <?php echo $num_classes; ?> class<?php if ($num_classes != 1) { echo "es"; } ?>, <?php echo $total_credits; ?> credit<?php if ($total_credits != 1) { echo "s"; } ?></p>
<?php
         mysql_free_result($result);
      } // prereg classes

      //---------------------
      // TRANSCRIPT
      //---------------------
      // Retrieve classes
      $query = "SELECT registration.*, participant_type.participant_type, course.course_number, course.title, course.credits, university.university_id, university.university_code, university.university_date " .
               "FROM $DBNAME_UNIVERSITY.registration JOIN $DBNAME_UNIVERSITY.course ON registration.course_id = course.course_id " .
               "JOIN $DBNAME_UNIVERSITY.university ON course.university_id = university.university_id " .
                "JOIN $DBNAME_UNIVERSITY.participant_type ON registration.participant_type_id = participant_type.participant_type_id " .
               "WHERE registration.participant_id = $form_participant_id " .
               "AND registration.registration_status_id = $STATUS_ATTENDED " .
               "ORDER BY university.university_date, course.course_number";
      $result = mysql_query($query)
         or die("Class Query failed : " . mysql_error());
      $num_classes = mysql_num_rows($result);
?>
<br/>
<h2 style="text-align:center">Classes</h2>
<table cellpadding="5" cellspacing="0" align="center">
<?php
      $j = 1;
      $prev_university_id = 0;
      $total_credits = 0;
      while ($data = mysql_fetch_array($result, MYSQL_BOTH))
      {
         $registration_id = clean($data['registration_id']);
         $university_id = clean($data['university_id']);
         $university_code = clean($data['university_code']);
         $university_date = clean($data['university_date']);
         $date_display = format_full_date($university_date);

         $course_id = clean($data['course_id']);
         $course_number = clean($data['course_number']);
         $title = clean($data['title']);
         $credits = clean($data['credits']);
         $total_credits += $credits;
         $participant_type = clean($data['participant_type']);

         $instructor_query = "SELECT participant.participant_id, participant.sca_name FROM $DBNAME_UNIVERSITY.registration " .
            "JOIN $DBNAME_UNIVERSITY.participant ON registration.participant_id = participant.participant_id " .
            "WHERE registration.course_id = $course_id AND registration.participant_type_id = $TYPE_INSTRUCTOR";
         $instructor_result = mysql_query($instructor_query)
            or die("Instructor Query failed : " . mysql_error());
         $num_instructors = mysql_num_rows($instructor_result);
         $instructor_display = "";
         if ($num_instructors > 0)
         {
            $i = 0;
            while ($instructor_data = mysql_fetch_array($instructor_result, MYSQL_BOTH))
            {
               $instructor = clean($instructor_data['sca_name']);
               if ($instructor == "")
               {
                  $instructor = "(No SCA name)";
               }
               if ($i > 0)
               {
                  $instructor_display .= "<br/>";
               }
               $instructor_display .= htmlentities($instructor);
               $i++;
            }
         }

         $bgcolor = (($j%2 == 0)? "#DDDDDD": "#EEEEEE");

         if ($prev_university_id != $university_id)
         {
?>
   <tr><th colspan="5" style="text-align:center;color:<?php echo $accent_color; ?>;background-color:white"><?php echo "$university_code - $date_display"; ?></th></tr>
   <tr>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">#</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Title</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Instructor(s)</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Credits</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Attendance</th>
   </tr>
<?php
            $prev_university_id = $university_id;
         }
?>
   <tr>
      <td bgcolor="<?php echo $bgcolor; ?>"><?php echo $course_number; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>"><a href="registration.php?mode=<?php echo $MODE_EDIT; ?>&amp;registration_id=<?php echo $registration_id; ?>"><?php echo $title; ?></a></td>
      <td bgcolor="<?php echo $bgcolor; ?>"><?php echo $instructor_display; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>"><?php echo $credits; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>"><?php echo $participant_type; ?></td>
   </tr>
<?php
         $j++;
      }
?>
</table>
<p class="datacenter"><span style="color:<?php echo $accent_color; ?>;font-weight:bold">Total:</span> <?php echo $num_classes; ?> class<?php if ($num_classes != 1) { echo "es"; } ?>, <?php echo $total_credits; ?> credit<?php if ($total_credits != 1) { echo "s"; } ?></p>
<?php
      mysql_free_result($result);
   }
   else
   {
?>
<p class="datacenter">No classes found.</p>
<?php
   }
}
// Not authorized
else
{
?>
<p class="datacenter">You are not authorized to access this page.</p>
<?php
}
include("../footer.php");
?>