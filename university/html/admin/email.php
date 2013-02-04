<?php
include("../db/db.php");
include("db.php");
include("../header.php");
?>
<h2 style="text-align:center">Email Participants</h2>
<?php
// Only appropriate admins allowed
if (isset($_SESSION[$UNIVERSITY_ADMIN]) && $_SESSION[$UNIVERSITY_ADMIN] == 1)
{
   $SUBMIT_SEND = "Send Email";

   $valid = true;
   $errmsg = '';
   if (isset($_POST['submit']) && $_POST['submit'] == $SUBMIT_SEND)
   {
      $form_course_id = NULL;
      if (isset($_POST['form_course_id']))
      {
         $form_course_id = clean($_POST['form_course_id']);
      }
      $form_message = NULL;
      if (isset($_POST['form_message']))
      {
         $form_message = clean($_POST['form_message']);
      }
      $form_subject = NULL;
      if (isset($_POST['form_subject']))
      {
         $form_subject = clean($_POST['form_subject']);
      }

      // Validate data
      if ($form_subject == NULL || $form_subject == '')
      {
         $valid = false;
         $errmsg .= "Please enter a subject.<br/>";
      }
      if ($form_message == NULL || $form_message == '')
      {
         $valid = false;
         $errmsg .= "Please enter a message.<br/>";
      }

      if ($valid)
      {
         $link = db_connect();

         ##Define Recipiant
         $recip = "";

         // If no course is selected, get the current university, and get email addresses of university participants
         if ($form_course_id == NULL)
         {
            $query = "SELECT university.university_id FROM $DBNAME_UNIVERSITY.university " .
                     "WHERE is_university = 1 AND university_date = (SELECT MAX(university_date) FROM $DBNAME_UNIVERSITY.university WHERE is_university = 1 AND publish_date IS NOT NULL AND publish_date <= CURRENT_DATE)";
            $result = mysql_query($query)
               or die("Current University Query failed : " . mysql_error());
            $data = mysql_fetch_array($result, MYSQL_BOTH);

            $university_id = clean($data['university_id']);

            $query = "SELECT DISTINCT email FROM $DBNAME_AUTH.user_auth " .
                     "WHERE user_id IN (SELECT user_id FROM $DBNAME_UNIVERSITY.participant " .
                     "JOIN $DBNAME_UNIVERSITY.registration ON participant.participant_id = registration.participant_id " .
                     "JOIN $DBNAME_UNIVERSITY.course ON registration.course_id = course.course_id " .
                     "WHERE course.university_id = $university_id) " .
                     "OR atlantian_id IN (SELECT atlantian_id FROM $DBNAME_UNIVERSITY.participant " .
                     "JOIN $DBNAME_UNIVERSITY.registration ON participant.participant_id = registration.participant_id " .
                     "JOIN $DBNAME_UNIVERSITY.course ON registration.course_id = course.course_id " .
                     "WHERE course.university_id = $university_id)";
            $result = mysql_query($query)
               or die("University Emails Query failed : " . mysql_error());
            while ($data = mysql_fetch_array($result, MYSQL_BOTH))
            {
               if ($recip != "")
               {
                  $recip .= ", ";
               }
               $recip .= clean($data['email']);
            }
         }
         // If course is selected, get email addresses of course participants
         else
         {
            $query = "SELECT DISTINCT email FROM $DBNAME_AUTH.user_auth " .
                     "WHERE user_id IN (SELECT user_id FROM $DBNAME_UNIVERSITY.participant " .
                     "JOIN $DBNAME_UNIVERSITY.registration ON participant.participant_id = registration.participant_id " .
                     "WHERE registration.course_id = $form_course_id) " .
                     "OR atlantian_id IN (SELECT atlantian_id FROM $DBNAME_UNIVERSITY.participant " .
                     "JOIN $DBNAME_UNIVERSITY.registration ON participant.participant_id = registration.participant_id " .
                     "WHERE registration.course_id = $form_course_id)";
            $result = mysql_query($query)
               or die("Course Emails Query failed : " . mysql_error());
            while ($data = mysql_fetch_array($result, MYSQL_BOTH))
            {
               if ($recip != "")
               {
                  $recip .= ", ";
               }
               $recip .= clean($data['email']);
            }
         }

         /* Closing connection */
         mysql_close($link);

         ##Begin mail

         ##Build Body
         $body = $form_message;

         ##Build subject
         $subject = "University of Atlantia - " . $form_subject;

         ##Build Headers
         $headers = "From:  university@atlantia.sca.org\n";
         $headers .= "X-Sender:  <seahorse.atlantia.sca.org>\n";
         $headers .= "X-Mailer:  PHP";

         ##Send mail
         mail($recip, $subject, $body, $headers);
         //echo "DEBUG: body [$body]<br/>";
?>
<p align="center">Email message sent to the following participants:</p>
<p align="center"><?php echo $recip; ?></p>
<?php 
      } // valid
   }
   // We haven't submitted send yet - display form
   if (!(isset($_POST['submit'])) || (isset($_POST['submit']) && ($_POST['submit'] == $SUBMIT_SEND && !$valid)))
   {
      $link = db_connect();

      $query = "SELECT university.university_id, university.university_code FROM $DBNAME_UNIVERSITY.university " .
                     "WHERE is_university = 1 AND university_date = (SELECT MAX(university_date) FROM $DBNAME_UNIVERSITY.university WHERE is_university = 1 AND publish_date IS NOT NULL AND publish_date <= CURRENT_DATE)";
      $result = mysql_query($query)
         or die("Current University Query failed : " . mysql_error());
      $data = mysql_fetch_array($result, MYSQL_BOTH);

      $university_id = clean($data['university_id']);
      $university_code = clean($data['university_code']);

      // Retrieve university session courses
      $class_query = "SELECT course_id, course_number, title FROM $DBNAME_UNIVERSITY.course " .
                     "WHERE university_id = $university_id " .
                     "ORDER BY course_number";
      $class_result = mysql_query($class_query)
         or die("Class Query failed : " . mysql_error());
      $num_classes = mysql_num_rows($class_result);

      if ($num_classes > 0)
      {
         $i = 0;
         while ($class_data = mysql_fetch_array($class_result, MYSQL_BOTH)) 
         {
            $course_id = clean($class_data['course_id']);
            $course_number = clean($class_data['course_number']);
            $title = clean($class_data['title']);
            $course_array[$i]['course_id'] = $course_id;
            $course_array[$i++]['course'] = $course_number . " - " . $title;
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
      <th class="titleright">University:</th>
      <td class="data"><?php echo $university_code; ?></td>
   </tr>
   <tr>
      <td class="titleright"><label for="form_course_id">Course:</label></td>
      <td class="data">
      <select name="form_course_id" id="form_course_id">
         <option id=""></option>
<?php
      for ($i = 0; $i < count($course_array); $i++)
      {
         echo '<option id="' . $course_array[$i]['course'] . '" value="' . $course_array[$i]['course_id'] . '"';
         if (isset($form_course_id) && $form_course_id == $course_array[$i]['course_id'])
         {
            echo ' selected';
         }
         echo '>' . $course_array[$i]['course'] . '</option>' . "\n";
      }
?>
      </select>
      </td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_subject">Subject:</label></th>
      <td class="data"><input type="text" name="form_subject" id="form_subject" size="50"<?php if (isset($form_subject) && trim($form_subject) != '') { echo " value=\"" . $form_subject . "\""; } ?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_message">Message:</label></th>
      <td class="data"><textarea name="form_message" id="form_message" cols="60" rows="5"><?php if (isset($form_message) && trim($form_message) != '') { echo $form_message; } ?></textarea></td>
   </tr>
   <tr>
      <td colspan="2" class="datacenter"><input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_SEND; ?>"/></td>
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
