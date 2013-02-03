<?php
$title = "My Classes";
include("../header.php");
?>
<h2 style="text-align:center">University Registrations</h2>
<?php
// Verify user is authorized
if (isset($_SESSION['s_username'])) 
{
   /* Connecting, selecting database */
   $link = db_connect();

   // Get current university session
   $query = "SELECT university.university_id, university.university_code, university.university_date, university.publish_date, university.closed_date FROM $DBNAME_UNIVERSITY.university " .
            "WHERE is_university = 1 AND university_date = (SELECT MAX(university_date) FROM $DBNAME_UNIVERSITY.university WHERE publish_date IS NOT NULL AND publish_date <= CURRENT_DATE)";
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

   // Disconnect
   db_disconnect($link);

   // Preregistration is open
   $today = date("Y-m-d");
   if ($today >= $publish_date && $today <= $closed_date)
   {
?>
<p style="text-align:center">To register for classes, browse the <a href="<?php echo $HOME_DIR; ?>catalog.php">Catalog</a>, select the desired class, then click the Register button.</p>
<?php
      $SUBMIT_UNREGISTER = "Remove";

      $submit = NULL;
      if (isset($_POST['submit']))
      {
         $submit = clean($_POST['submit']);
      }
      // Non-admin user logged in
      if (isset($_SESSION['s_username']) && (!isset($_SESSION[$UNIVERSITY_ADMIN]) || (isset($_SESSION[$UNIVERSITY_ADMIN]) && $_SESSION[$UNIVERSITY_ADMIN] != 1)))
      {
         // User is unregistering from class
         if ($submit == $SUBMIT_UNREGISTER)
         {
            /* Connecting, selecting database */
            $link = db_admin_connect();

            $registration_id = NULL;
            if (isset($_POST['registration_id']))
            {
               $registration_id = clean($_POST['registration_id']);
               $delete = "DELETE FROM $DBNAME_UNIVERSITY.registration WHERE registration_id = $registration_id";
               $dresult = mysql_query($delete)
                  or die("Delete Registration failed : " . $delete. "<br/>" . mysql_error());
            }
            // Disconnect
            db_disconnect($link);
         }
      }

      /* Connecting, selecting database */
      $link = db_connect();

      // Get user information
      $id_value = NULL;
      $field = "atlantian_id";
      if (isset($_SESSION['s_atlantian_id']))
      {
         $id_value = $_SESSION['s_atlantian_id'];
      }
      else if (isset($_SESSION['s_user_id']))
      {
         $id_value = $_SESSION['s_user_id'];
         $field = "user_id";
      }
      if ($id_value != NULL)
      {
         // Retrieve classes
         $query = "SELECT registration.*, participant_type.participant_type, course.course_number, course.title, course.credits, course.start_time, course.course_status_id " .
                  "FROM $DBNAME_UNIVERSITY.registration JOIN $DBNAME_UNIVERSITY.course ON registration.course_id = course.course_id " .
                  "JOIN $DBNAME_UNIVERSITY.participant_type ON registration.participant_type_id = participant_type.participant_type_id " .
                  "JOIN $DBNAME_UNIVERSITY.participant ON registration.participant_id = participant.participant_id " .
                  "WHERE participant.$field = $id_value " .
                  "AND registration.registration_status_id = $STATUS_REGISTERED " .
                  "AND course.course_status_id IN ($STATUS_APPROVED, $STATUS_CANCELED) " .
                  "AND course.university_id = $university_id " .
                  "ORDER BY course.course_status_id, course.start_time";
         $result = mysql_query($query)
            or die("Class Query failed : " . $query. "<br/>" . mysql_error());
         $num_classes = mysql_num_rows($result);

         if ($num_classes > 0)
         {
?>
<h3 style="text-align:center">My Registrations</h3>
<table cellpadding="5" cellspacing="0" align="center">
   <tr><th colspan="5" style="text-align:center;color:<?php echo $accent_color; ?>;background-color:white"><?php echo "$university_code - $date_display"; ?></th></tr>
   <tr>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Registration</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">#</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Title</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Instructor(s)</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Credits</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Attendance</th>
   </tr>
<?php
            $j = 1;
            $total_credits = 0;
            $total_classes = 0;
            $prev_course_status_id = $STATUS_APPROVED;
            while ($data = mysql_fetch_array($result, MYSQL_BOTH))
            {
               $registration_id = clean($data['registration_id']);
               $course_id = clean($data['course_id']);
               $course_status_id = clean($data['course_status_id']);
               $course_number = clean($data['course_number']);
               $title = clean($data['title']);
               $credits = clean($data['credits']);
               if ($course_status_id == $STATUS_APPROVED)
               {
                  $total_credits += $credits;
                  $total_classes++;
               }
               $participant_type_id = clean($data['participant_type_id']);
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

               // Switching from approved to canceled classes - display new header
               if ($prev_course_status_id != $course_status_id)
               {
?>
   <tr><th colspan="5" style="text-align:center;color:<?php echo $accent_color; ?>;background-color:white">Canceled Classes</th></tr>
   <tr>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Registration</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">#</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Title</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Instructor(s)</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Credits</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Attendance</th>
   </tr>
<?php
               }
?>
   <tr>
      <td bgcolor="<?php echo $bgcolor; ?>">
<?php
               if ($participant_type_id == $TYPE_STUDENT)
               {
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="datacenter">
   <input type="hidden" name="registration_id" value="<?php echo $registration_id; ?>"/>
   <input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_UNREGISTER; ?>">
</form>
<?php
               }
               else
               {
                  echo "&nbsp;";
               }
?>
      </td>
      <td bgcolor="<?php echo $bgcolor; ?>"><?php echo $course_number; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>"><?php echo $title; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>"><?php echo $instructor_display; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>"><?php echo $credits; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>"><?php echo $participant_type; ?></td>
   </tr>
<?php
               $j++;
            }
?>
</table>
<p class="datacenter">Total: <?php echo $total_classes; ?> class<?php if ($total_classes != 1) { echo "es"; } ?>, <?php echo $total_credits; ?> credit<?php if ($total_credits != 1) { echo "s"; } ?></p>
<?php
            mysql_free_result($result);
         }
         else
         {
?>
<p class="datacenter">No classes found.</p>
<?php
         } // No classes
      } // Participant found
      // Disconnect Database
      db_disconnect($link);
   } // Preregistration open
   else
   {
?>
<p class="datacenter">There are no University sessions currently open for preregistration.</p>
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