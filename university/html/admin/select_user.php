<?php 
include_once("../db/db.php");
include_once("db.php");

$SUBMIT_SEARCH = "Search Participants";
$SUBMIT_SELECT = "Assign Participant to User and Approve Access";

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
   $user_query = "SELECT atlantian_id, sca_name, username, email FROM $DBNAME_AUTH.user_auth WHERE user_id = " . $form_user_id;
   $user_result = mysql_query($user_query);
   $user_data = mysql_fetch_array($user_result, MYSQL_BOTH);
   $user_username = $user_data['username'];
   $user_sca_name = $user_data['sca_name'];
   $user_email = $user_data['email'];
}

// Data submitted
if ($submit == $SUBMIT_SELECT)
{
   if (isset($_POST['form_atlantian_id']))
   {
      $form_atlantian_id = clean($_POST['form_atlantian_id']);
      $update = "UPDATE $DBNAME_AUTH.user_auth " . 
         "SET atlantian_id = ". $form_atlantian_id . ", " . 
         $ORDER_ARRAY[$ORDER_ID]['access'] . " = 1, " . 
         $ORDER_ARRAY[$ORDER_ID]['pend'] . " = 0 " .
         "WHERE user_id = " . $form_user_id;

      $update_result = mysql_query($update)
         or die("Unable to approve user: " . mysql_error());

      // Build Body
      $body = "University of Atlantia Participant\n";
      $body .= "Website Administration\n";
      $body .= "Account Request Approved\n";
      $body .= "\n";
      $body .= "Username:  $user_username\n";
      $body .= "SCA Name:  $user_sca_name\n";
      $body .= "Email:     $user_email\n";
      $body .= "\n University of Atlantia Web Site: " . $UNIVERSITY_URL . "\n";

      // Build subject
      $subject = "University of Atlantia Participant -- Account Request Approved";

      // Build Headers
      $headers ="From:  no-replies-please@atlantia.sca.org\n";
      $headers .="X-Sender:  <seahorse.atlantia.sca.org>\n";
      $headers .="X-Mailer:  PHP";

      // Send mail
      mail($user_email, $subject, $body, $headers);

      $title = "Account Request Approved";
      include("../header.php");
      ?>
<p class="title2" align="center">Account Request Approved</p>
<p align="center">
The user account has been approved.
</p>
<table align="center" border="0" cellpadding="5" cellspacing="2" summary="User Account Info">
   <tr>
      <th class="titleright">User ID:</th>
      <td class="data"><?php echo $form_user_id; ?></td>
   </tr>
   <tr>
      <th class="titleright">Participant ID:</th>
      <td class="data"><?php echo $form_atlantian_id; ?></td>
   </tr>
   <tr>
      <th class="titleright">Username:</th>
      <td class="data"><?php echo $user_username; ?></td>
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
      $errmsg2 = "Please select a Participant to assign to this user.";
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
         "FROM $DBNAME_ORDER." . $ORDER_ARRAY[$ORDER_ID]['table'] . ", $DBNAME_AUTH.atlantian LEFT JOIN $DBNAME_AUTH.user_auth ON atlantian.atlantian_id = user_auth.atlantian_id " .
         "WHERE atlantian.atlantian_id = " . $ORDER_ARRAY[$ORDER_ID]['table'] . ".atlantian_id";
      if ($form_sca_name != "")
      {
         $query .= " AND atlantian.preferred_sca_name LIKE '%" . mysql_real_escape_string($form_sca_name) . "%'";
      }
      if ($form_first_name != "")
      {
         $query .= " AND (atlantian.first_name LIKE '%" . mysql_real_escape_string($form_first_name) . "%')";
      }
      if ($form_last_name != "")
      {
         $query .= " AND (atlantian.last_name LIKE '%" . mysql_real_escape_string($form_last_name) . "%')";
      }
      $query .= " ORDER BY atlantian.preferred_sca_name";

      /* Performing SQL query */
      $result = mysql_query($query) 
         or die("Search Query failed : " . mysql_error());
   }
}

$title = "Select Participant - Account Request";
include("../header.php");
?>
<p class="title2" align="center">Search for Participants</p>
<p align="center">
The user account needs to be associated with a specific Participant so the user may edit their own data.
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
Use the search form below to search for the Participant to associate with this user request.
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
<form action="select_ind.php" method="post">
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
      <b>First</b> <input type="text" name="form_first_name" id="form_first_name" size="25"<?php if (isset($form_first_name) && $form_first_name != '') { echo " value=\"$form_first_name\"";} ?>/>
      &nbsp;&nbsp;&nbsp;
      <b>Last</b> <input type="text" name="form_last_name" id="form_last_name" size="30"<?php if (isset($form_last_name) && $form_last_name != '') { echo " value=\"$form_last_name\"";} ?>/>
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
<p align="center">
<img src="<?php echo $HOME_DIR; ?>images/<?php echo strtolower($SHORT_ORDER); ?>-divider.gif" width="648" height="41" border="0" alt="<?php echo $SHORT_ORDER; ?> Line"/>
</p>
<p align="center">
Only known members of the Order who match your criteria are shown below.
</p>
<?php 
   if (isset($errmsg2) && strlen($errmsg2) > 0)
   {
      echo '<p align="center" style="color:red;font-weight:bold">' . $errmsg2 . '</p>';
   }
?>
<form action="select_ind.php" method="post">
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
<p align="center">
<img src="<?php echo $HOME_DIR; ?>images/<?php echo strtolower($SHORT_ORDER); ?>-divider.gif" width="648" height="41" border="0" alt="<?php echo $SHORT_ORDER; ?> Line"/>
</p>
<p align="center">No records matched your search criteria.</p>
<?php 
}
/* Closing connection */
mysql_close($link);

include("../footer.php");
?>



