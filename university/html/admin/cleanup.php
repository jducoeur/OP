<?php
include("../db/db.php");
include("db.php");
include("../header.php");
?>
<h2 style="text-align:center">Delete Student Pre-Registrations</h2>
<?php
// Only appropriate admins allowed
if (isset($_SESSION[$UNIVERSITY_ADMIN]) && $_SESSION[$UNIVERSITY_ADMIN] == 1)
{
   $SUBMIT_DELETE = "Delete Student Pre-Registrations";

   $valid = true;
   $errmsg = '';
   if (isset($_POST['submit']) && $_POST['submit'] == $SUBMIT_DELETE)
   {
      $form_university_id = NULL;
      if (isset($_POST['form_university_id']))
      {
         $form_university_id = clean($_POST['form_university_id']);
      }

      // Validate data
      if ($form_university_id == NULL || $form_university_id == '')
      {
         $valid = false;
         $errmsg .= "Please select a university session.<br/>";
      }

      if ($valid)
      {
         $link = db_admin_connect();

         // Delete all registrations of type Pre-Registered where university session is form_university_id
         $delete = "DELETE FROM $DBNAME_UNIVERSITY.registration " .
                   "WHERE registration_status_id = $STATUS_REGISTERED " .
                   "AND participant_type_id = $TYPE_STUDENT " .
                   "AND course_id IN (SELECT course_id FROM $DBNAME_UNIVERSITY.course WHERE university_id = $form_university_id)" ;
         $delete_result = mysql_query($delete)
            or die("Delete Pre-Registered Students failed : " . mysql_error());
         $num_recs = mysql_affected_rows($link);

         /* Closing connection */
         mysql_close($link);
?>
<p align="center"><?php echo $num_recs; ?> pre-registration(s) deleted.</p>
<?php 
      } // valid
   }
   // We haven't submitted yet - display form
   if (!(isset($_POST['submit'])) || (isset($_POST['submit']) && ($_POST['submit'] == $SUBMIT_DELETE && !$valid)))
   {
      $link = db_connect();

      // Retrieve university sessions
      $query = "SELECT university.university_id, university.university_code FROM $DBNAME_UNIVERSITY.university " .
               "ORDER BY university_code DESC";
      $result = mysql_query($query)
         or die("University Query failed : " . mysql_error());
      $num_universities = mysql_num_rows($result);

      if ($num_universities > 0)
      {
         $i = 0;
         while ($data = mysql_fetch_array($result, MYSQL_BOTH)) 
         {
            $university_id = clean($data['university_id']);
            $university_code = clean($data['university_code']);
            $university_array[$i]['university_id'] = $university_id;
            $university_array[$i++]['university_code'] = $university_code;
         }
      }

      // Display validation errors, if any
      if (isset($valid) && !$valid && isset($errmsg) && $errmsg != '')
      {
?>
<p align="center" class="title3" style="color:red">Please correct the following errors:<br/><br/><?php echo $errmsg; ?></p>
<?php 
      }
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table border="1" align="center" cellpadding="5" cellspacing="0" summary="Email Form">
   <tr>
      <th class="titleright"><label for="form_university_id">University:</label></th>
      <td class="data">
      <select name="form_university_id" id="form_university_id">
         <option id=""></option>
<?php
      for ($i = 0; $i < count($university_array); $i++)
      {
         echo '<option id="' . $university_array[$i]['university_code'] . '" value="' . $university_array[$i]['university_id'] . '"';
         if (isset($form_university_id) && $form_university_id == $university_array[$i]['university_id'])
         {
            echo ' selected';
         }
         echo '>' . $university_array[$i]['university_code'] . '</option>' . "\n";
      }
?>
      </select>
      </td>
   </tr>
   <tr>
      <td colspan="2" class="datacenter"><input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_DELETE; ?>"/></td>
   </tr>
</table>
</form>
<?php
      /* Closing connection */
      mysql_close($link);
   }
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
