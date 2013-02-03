<?php 
include_once("../db/db.php");
include_once("db.php");
require_once('../db/session.php'); 

// Only admins allowed
if (isset($_SESSION[$WEBMINISTER_ADMIN]) && $_SESSION[$WEBMINISTER_ADMIN] == 1)
{
$SUBMIT_SEARCH = "Search Atlantians";
$SUBMIT_SELECT = "Assign Atlantian to User";
$SUBMIT_DELETE = "Delete User Account";

$submit = "";
if (isset($_POST['submit']))
{
   $submit = clean($_POST['submit']);
}

$form_user_id = "";
if (isset($_GET['user_id']))
{
   $form_user_id = clean($_GET['user_id']);
}
else if (isset($_POST['form_user_id']))
{
   $form_user_id = clean($_POST['form_user_id']);
}

$link = db_admin_connect();

// Get user request data
if ($form_user_id > 0)
{
   $user_query = "SELECT atlantian_id, first_name, last_name, sca_name, username, email FROM $DBNAME_AUTH.user_auth WHERE user_id = " . $form_user_id;
   $user_result = mysql_query($user_query);
   $user_data = mysql_fetch_array($user_result, MYSQL_BOTH);
   $user_username = $user_data['username'];
   $user_first_name = $user_data['first_name'];
   $user_last_name = $user_data['last_name'];
   $user_sca_name = $user_data['sca_name'];
   $user_email = $user_data['email'];
}

// Data submitted
if ($submit == $SUBMIT_DELETE)
{
   // Avoid constraint errors
   $update = "UPDATE $DBNAME_AUTH.user_auth " . 
      "SET last_updated_by = NULL " .
      "WHERE user_id = " . value_or_null($form_user_id) .
      " AND last_updated_by = " . value_or_null($form_user_id);
   $update_result = mysql_query($update)
      or die("Unable to update user: " . $update . "<br/>" . mysql_error());

   $delete = "DELETE FROM $DBNAME_AUTH.user_auth " . 
      "WHERE user_id = " . value_or_null($form_user_id);
   $delete_result = mysql_query($delete)
      or die("Unable to delete user: " . $delete . "<br/>" . mysql_error());

   $title = "Account Registration Deleted";
   include("../header.php");
?>
<p class="title2" align="center">Account Registration Deleted</p>
<p align="center">
The user account has been deleted.
</p>
<?php
   include("../footer.php");
   exit;
}

if ($submit == $SUBMIT_SELECT)
{
   if (isset($_POST['form_atlantian_id']))
   {
      $form_atlantian_id = clean($_POST['form_atlantian_id']);

      $query = "SELECT * FROM $DBNAME_UNIVERSITY.participant " . 
         "WHERE atlantian_id = " . value_or_null($form_atlantian_id) . " " .
         "OR user_id = " . value_or_null($form_user_id) . " " .
         "ORDER BY participant_id";
      $result = mysql_query($query)
         or die("Participant Query Failed: " . $query . "<br/>" . mysql_error());
      $num_participants = mysql_num_rows($result);

      // Only one record - just update the participant record
      if ($num_participants == 1)
      {
         $data = mysql_fetch_array($result, MYSQL_BOTH);
         $participant_id = clean($data['participant_id']);

         $update = "UPDATE $DBNAME_UNIVERSITY.participant " . 
            "SET atlantian_id = " . value_or_null($form_atlantian_id) . ", " . 
            "user_id = " . value_or_null($form_user_id) . ", " .
            "last_updated = " . value_or_null(date("Y-m-d")) . ", " .
            "last_updated_by = " . value_or_null($_SESSION['s_user_id']) . " " .
            "WHERE participant_id = " . value_or_null($participant_id);
         $update_result = mysql_query($update)
            or die("Unable to assign participant: " . $update . "<br/>" . mysql_error());
      }
      // Multiple participant records need to be merged
      else if ($num_participants > 1)
      {
         // First Participant
         $data = mysql_fetch_array($result, MYSQL_BOTH);
         $participant_id = clean($data['participant_id']);
         $university_participant_id = clean($data['university_participant_id']);
         $last_university_id = clean($data['last_university_id']);
         $b_old_university_id = clean($data['b_old_university_id']);
         $b_university_id = clean($data['b_university_id']);
         $f_university_id = clean($data['f_university_id']);
         $m_university_id = clean($data['m_university_id']);
         $d_university_id = clean($data['d_university_id']);
         $keep_participant_id = $participant_id;

         // Second Participant
         $data = mysql_fetch_array($result, MYSQL_BOTH);
         $participant_id_2 = clean($data['participant_id']);
         $university_participant_id_2 = clean($data['university_participant_id']);
         $last_university_id_2 = clean($data['last_university_id']);
         $b_old_university_id_2 = clean($data['b_old_university_id']);
         $b_university_id_2 = clean($data['b_university_id']);
         $f_university_id_2 = clean($data['f_university_id']);
         $m_university_id_2 = clean($data['m_university_id']);
         $d_university_id_2 = clean($data['d_university_id']);
         $del_participant_id = $participant_id_2;

         // Determine participant record to keep
         if (($university_participant_id_2 > 0 && $university_participant_id == "") || 
             ($last_university_id_2 > 0 && $last_university_id == "") || 
             ($b_old_university_id_2 > 0 && $b_old_university_id == "") || 
             ($b_university_id_2 > 0 && $b_university_id == "") || 
             ($f_university_id_2 > 0 && $f_university_id == "") || 
             ($m_university_id_2 > 0 && $m_university_id == "") || 
             ($d_university_id_2 > 0 && $d_university_id == ""))
         {
            $keep_participant_id = $participant_id_2;
            $del_participant_id = $participant_id;
         }

         $update = "UPDATE $DBNAME_UNIVERSITY.registration " . 
            "SET participant_id = " . value_or_null($keep_participant_id) . " " . 
            "WHERE participant_id = " . value_or_null($del_participant_id);
         $update_result = mysql_query($update)
            or die("Unable to update registrations: " . $update . "<br/>" . mysql_error());

         $delete = "DELETE FROM $DBNAME_UNIVERSITY.participant WHERE participant_id = " . value_or_null($del_participant_id);
         $delete_result = mysql_query($delete)
            or die("Unable to delete duplicate participant: " . $delete . "<br/>" . mysql_error());

         $update = "UPDATE $DBNAME_UNIVERSITY.participant " . 
            "SET atlantian_id = " . value_or_null($form_atlantian_id) . ", " . 
            "user_id = " . value_or_null($form_user_id) . ", " .
            "last_updated = " . value_or_null(date("Y-m-d")) . ", " .
            "last_updated_by = " . value_or_null($_SESSION['s_user_id']) . " " .
            "WHERE participant_id = " . value_or_null($keep_participant_id);
         $update_result = mysql_query($update)
            or die("Unable to assign participant: " . $update . "<br/>" . mysql_error());

         $participant_id = $keep_participant_id;
      }
      mysql_free_result($result);

      // Fill in email, SCA and real names from user account if blank
      if (isset($user_first_name) && $user_first_name != "")
      {
         $update = "UPDATE $DBNAME_AUTH.atlantian " . 
            "SET first_name = " . value_or_null($user_first_name) . ", " . 
            "last_updated = " . value_or_null(date("Y-m-d")) . ", " .
            "last_updated_by = " . value_or_null($_SESSION['s_user_id']) . " " .
            "WHERE atlantian_id = " . value_or_null($form_atlantian_id) . " " .
            "AND first_name IS NULL";
         $update_result = mysql_query($update)
            or die("Unable to update Atlantian First Name: " . $update . "<br/>" . mysql_error());
      }
      if (isset($user_last_name) && $user_last_name != "")
      {
         $update = "UPDATE $DBNAME_AUTH.atlantian " . 
            "SET last_name = " . value_or_null($user_last_name) . ", " . 
            "last_updated = " . value_or_null(date("Y-m-d")) . ", " .
            "last_updated_by = " . value_or_null($_SESSION['s_user_id']) . " " .
            "WHERE atlantian_id = " . value_or_null($form_atlantian_id) . " " .
            "AND last_name IS NULL";
         $update_result = mysql_query($update)
            or die("Unable to update Atlantian Last Name: " . $update . "<br/>" . mysql_error());
      }
      if (isset($user_email) && $user_email != "")
      {
         $update = "UPDATE $DBNAME_AUTH.atlantian " . 
            "SET email = " . value_or_null($user_email) . ", " . 
            "last_updated = " . value_or_null(date("Y-m-d")) . ", " .
            "last_updated_by = " . value_or_null($_SESSION['s_user_id']) . " " .
            "WHERE atlantian_id = " . value_or_null($form_atlantian_id) . " " .
            "AND email IS NULL";
         $update_result = mysql_query($update)
            or die("Unable to update Atlantian Email: " . $update . "<br/>" . mysql_error());
      }
      if (isset($user_sca_name) && $user_sca_name != "")
      {
         $update = "UPDATE $DBNAME_AUTH.atlantian " . 
            "SET sca_name = " . value_or_null($user_sca_name) . ", " . 
            "last_updated = " . value_or_null(date("Y-m-d")) . ", " .
            "last_updated_by = " . value_or_null($_SESSION['s_user_id']) . " " .
            "WHERE atlantian_id = " . value_or_null($form_atlantian_id) . " " .
            "AND sca_name IS NULL";
         $update_result = mysql_query($update)
            or die("Unable to update Atlantian SCA Name: " . $update . "<br/>" . mysql_error());

         $update = "UPDATE $DBNAME_AUTH.atlantian " . 
            "SET preferred_sca_name = " . value_or_null($user_sca_name) . ", " . 
            "last_updated = " . value_or_null(date("Y-m-d")) . ", " .
            "last_updated_by = " . value_or_null($_SESSION['s_user_id']) . " " .
            "WHERE atlantian_id = " . value_or_null($form_atlantian_id) . " " .
            "AND preferred_sca_name IS NULL";
         $update_result = mysql_query($update)
            or die("Unable to update Atlantian Preferred SCA Name: " . $update . "<br/>" . mysql_error());

         $update = "UPDATE $DBNAME_UNIVERSITY.participant " . 
            "SET sca_name = " . value_or_null($user_sca_name) . ", " . 
            "last_updated = " . value_or_null(date("Y-m-d")) . ", " .
            "last_updated_by = " . value_or_null($_SESSION['s_user_id']) . " " .
            "WHERE participant_id = " . value_or_null($participant_id) . " " .
            "AND sca_name IS NULL";
         $update_result = mysql_query($update)
            or die("Unable to update participant SCA Name: " . $update . "<br/>" . mysql_error());
      }

      $update = "UPDATE $DBNAME_AUTH.user_auth " . 
         "SET atlantian_id = " . value_or_null($form_atlantian_id) . ", " . 
         "last_updated = " . value_or_null(date("Y-m-d")) . ", " .
         "last_updated_by = " . value_or_null($_SESSION['s_user_id']) . " " .
         "WHERE user_id = " . value_or_null($form_user_id);
      $update_result = mysql_query($update)
         or die("Unable to assign user: " . $update . "<br/>" . mysql_error());

      $title = "Account Registration Assigned";
      include("../header.php");
      ?>
<p class="title2" align="center">Account Registration Assigned</p>
<p align="center">
The user account has been assigned.
</p>
<table align="center" border="0" cellpadding="5" cellspacing="2" summary="User Account Info">
   <tr>
      <th class="titleright">User ID:</th>
      <td class="data"><?php echo $form_user_id; ?></td>
   </tr>
   <tr>
      <th class="titleright">Atlantian ID:</th>
      <td class="data"><?php echo $form_atlantian_id; ?></td>
   </tr>
   <tr>
      <th class="titleright">Username:</th>
      <td class="data"><?php echo $user_username; ?></td>
   </tr>
   <tr>
      <th class="titleright">First Name:</th>
      <td class="data"><?php echo $user_first_name; ?></td>
   </tr>
   <tr>
      <th class="titleright">Last Name:</th>
      <td class="data"><?php echo $user_last_name; ?></td>
   </tr>
   <tr>
      <th class="titleright">SCA Name:</th>
      <td class="data"><?php echo $user_sca_name; ?></td>
   </tr>
   <tr>
      <th class="titleright">Email:</th>
      <td class="data"><?php echo $user_email; ?></td>
   </tr>
</table>
<?php
      include("../footer.php");
      exit;
   }
   else
   {
      $errmsg2 = "Please select an Atlantian to assign to this user.";
      // Rerun the search
      $submit = $SUBMIT_SEARCH;
   }
}

if ($submit == $SUBMIT_SEARCH)
{
   $form_sca_name = "";
   if (isset($_POST['form_sca_name']))
   {
      $form_sca_name = clean($_POST['form_sca_name']);
   }
   $form_first_name = "";
   if (isset($_POST['form_first_name']))
   {
      $form_first_name = clean($_POST['form_first_name']);
   }
   $form_last_name = "";
   if (isset($_POST['form_last_name']))
   {
      $form_last_name = clean($_POST['form_last_name']);
   }

   $errmsg = "";

   if ($form_sca_name == '' && $form_first_name == '' && $form_last_name == '')
   {
      $errmsg = "Please enter part of an SCA Name, First Name or Lsat Name on which to search.<br/>";
   }

   if (strlen($errmsg) == 0)
   {
      $query = "SELECT atlantian.atlantian_id, atlantian.preferred_sca_name, atlantian.first_name, atlantian.last_name, user_auth.username " . 
         "FROM $DBNAME_AUTH.atlantian LEFT OUTER JOIN $DBNAME_AUTH.user_auth ON atlantian.atlantian_id = user_auth.atlantian_id " .
         "WHERE 1 = 1";
      if ($form_sca_name != "")
      {
         $query .= " AND (atlantian.preferred_sca_name LIKE '%" . mysql_real_escape_string($form_sca_name) . "%'";
         $query .= " OR atlantian.sca_name LIKE '%" . mysql_real_escape_string($form_sca_name) . "%'";
         $query .= " OR atlantian.alternate_names LIKE '%" . mysql_real_escape_string($form_sca_name) . "%')";
      }
      if ($form_first_name != "")
      {
         $query .= " AND (atlantian.first_name LIKE '%" . mysql_real_escape_string($form_first_name) . "%')";
      }
      if ($form_last_name != "")
      {
         $query .= " AND (atlantian.last_name LIKE '%" . mysql_real_escape_string($form_last_name) . "%'";
         $query .= " OR atlantian.middle_name LIKE '%" . mysql_real_escape_string($form_last_name) . "%')";
      }
      $query .= " ORDER BY atlantian.preferred_sca_name";

      /* Performing SQL query */
      $result = mysql_query($query) 
         or die("Search Query failed : " . mysql_error());
   }
}

$title = "Select Atlantian - Account Assignment";
include("../header.php");
?>
<p class="title2" align="center">Search for Atlantians</p>
<p align="center">
The user account needs to be associated with a specific Atlantian so the user may edit their own data.
</p>
<table align="center" border="0" cellpadding="5" cellspacing="2" summary="User Account Info">
   <tr>
      <th class="titleright">User ID:</th>
      <td class="data"><?php echo $form_user_id; ?></td>
   </tr>
   <tr>
      <th class="titleright">Username:</th>
      <td class="data"><?php echo $user_username; ?></td>
   </tr>
   <tr>
      <th class="titleright">First Name:</th>
      <td class="data"><?php echo $user_first_name; ?></td>
   </tr>
   <tr>
      <th class="titleright">Last Name:</th>
      <td class="data"><?php echo $user_last_name; ?></td>
   </tr>
   <tr>
      <th class="titleright">SCA Name:</th>
      <td class="data"><?php echo $user_sca_name; ?></td>
   </tr>
   <tr>
      <th class="titleright">Email:</th>
      <td class="data"><?php echo $user_email; ?></td>
   </tr>
</table>
<br/>
<p align="center">
If this is an invalid or duplicate user account, you may delete it.
</p>
<form action="select_atlantian.php" method="post" style="text-align:center">
<input type="hidden" name="form_user_id" id="form_user_id"<?php if (isset($form_user_id) && $form_user_id != 0) { echo " value=\"$form_user_id\"";} ?>/>
<input type="submit" name="submit" value="<?php echo $SUBMIT_DELETE; ?>"/>
</form>
<p align="center">
Use the search form below to search for the Atlantian to associate with this user request.
<br/><br/>
If the SCA Name entered by the requesting user does not produce any results when you click 
"<?php echo $SUBMIT_SEARCH; ?>", try using parts of the name.  The spelling used by the 
requestor may not match the spelling used by the Order of Precedence.
</p>
<?php
if (isset($errmsg) && strlen($errmsg) > 0)
{
   echo '<p align="center" style="color:red;font-weight:bold">' . $errmsg . '</p>';
}
?>
<form action="select_atlantian.php" method="post">
<input type="hidden" name="form_user_id" id="form_user_id"<?php if (isset($form_user_id) && $form_user_id != 0) { echo " value=\"$form_user_id\"";} ?>/>
<table align="center" border="1" cellpadding="5" cellspacing="0" summary="Search Criteria selection">
   <tr>
      <th colspan="2" class="title">Search Criteria</th>
   </tr>
   <tr>
      <th class="titleright">SCA Name</th>
      <td class="data"><input type="text" name="form_sca_name" id="form_sca_name" size="50"<?php if (isset($form_sca_name) && $form_sca_name != '') { echo " value=\"$form_sca_name\"";} else { echo " value=\"$user_sca_name\"";}?>/></td>
   </tr>
   <tr>
      <th class="titleright">Real Name</th>
      <td class="data">
      <b>First</b> <input type="text" name="form_first_name" id="form_first_name" size="25"<?php if (isset($form_first_name) && $form_first_name != '') { echo " value=\"$form_first_name\"";} else { echo " value=\"$user_first_name\"";} ?>/>
      &nbsp;&nbsp;&nbsp;
      <b>Last</b> <input type="text" name="form_last_name" id="form_last_name" size="30"<?php if (isset($form_last_name) && $form_last_name != '') { echo " value=\"$form_last_name\"";} else { echo " value=\"$user_last_name\"";} ?>/>
      </td>
   </tr>
   <tr>
      <th colspan="2" class="title"><input type="submit" name="submit" value="<?php echo $SUBMIT_SEARCH; ?>"/></th>
   </tr>
</table>
</form>
<?php 
if (isset($result) && mysql_num_rows($result) > 0)
{
?>
<hr/>
<?php 
   if (isset($errmsg2) && strlen($errmsg2) > 0)
   {
      echo '<p align="center" style="color:red;font-weight:bold">' . $errmsg2 . '</p>';
   }
?>
<form action="select_atlantian.php" method="post">
<input type="hidden" name="form_sca_name" id="form_sca_name"<?php if (isset($form_sca_name) && $form_sca_name != '') { echo " value=\"$form_sca_name\"";} ?>/>
<input type="hidden" name="form_user_id" id="form_user_id"<?php if (isset($form_user_id) && $form_user_id != 0) { echo " value=\"$form_user_id\"";} ?>/>
<table align="center" cellpadding="5" cellspacing="0" border="1" summary="Table listing search results">
   <tr>
      <th class="title" nowrap="nowrap">Select</th>
      <th class="title" nowrap="nowrap">SCA Name</th>
      <th class="title">First Name</th>
      <th class="title">Last Name</th>
   </tr>
<?php 
      while ($data = mysql_fetch_array($result, MYSQL_BOTH))
      {
         $atlantian_id = $data['atlantian_id'];
         $sca_name = $data['preferred_sca_name'];
         $first_name = $data['first_name'];
         $last_name = $data['last_name'];
         $username = $data['username'];

?>
   <tr>
      <td class="title"><?php if ($username != "") { echo $username; } else { ?><input type="radio" name="form_atlantian_id" id="form_atlantian_id" value="<?php echo $atlantian_id; ?>"/><?php } ?></td>
      <td class="data"><?php echo $sca_name; ?></td>
      <td class="data"><?php echo $first_name; ?></td>
      <td class="data"><?php echo $last_name; ?></td>
   </tr>
<?php 
      }
?>
   <tr>
      <th class="title" colspan="5"><input type="submit" name="submit" value="<?php echo $SUBMIT_SELECT; ?>"/></th>
   </tr>
</table>
</form>
<p align="center"><?php echo mysql_num_rows($result); ?> records matched your search criteria.</p>
<?php 
   /* Free resultset */
   mysql_free_result($result);
}
// Nothing matched search criteria
else if (isset($errmsg) && $errmsg == '' && isset($result) && mysql_num_rows($result) == 0)
{
?>
<hr/>
<p align="center">No records matched your search criteria.</p>
<?php 
}
/* Closing connection */
db_disconnect($link);

include("../footer.php");
}
// Not authorized
else
{
include("../header.php");
?>
<p class="title2" align="center">Account Registration Assignment</p>
<p align="center" class="title2">You are not authorized to access this page.</p>
<?php
include("../footer.php");
}
?>



