<?php
include_once("db/validation_format.php");

$course_id = "";
if (isset($_REQUEST['course_id']))
{
   $course_id = clean($_REQUEST['course_id']);
}

$title = "Course Detail";
include("header.php");
?>
<h2 style="text-align:center">Course Detail</h2>
<?php
// Display error message if no course is specified
if ($course_id == "")
{
?>
<p style="text-align:center">No course was selected.  Please return to the <a href="catalog.php">Course Catalog</a> and select a course.</p>
<?php
}
else
{
   $SUBMIT_REGISTER = "Register";
   $SUBMIT_UNREGISTER = "Remove Registration";

   $submit = NULL;
   if (isset($_POST['submit']))
   {
      $submit = clean($_POST['submit']);
   }
   // Non-admin user logged in
   if (isset($_SESSION['s_username']) && (!isset($_SESSION[$UNIVERSITY_ADMIN]) || (isset($_SESSION[$UNIVERSITY_ADMIN]) && $_SESSION[$UNIVERSITY_ADMIN] != 1)))
   {
      // Registering or unregistering classes
      if ($submit != NULL)
      {
         /* Connecting, selecting database */
         $link = db_admin_connect();

         // User is registering for class
         if ($submit == $SUBMIT_REGISTER)
         {
            $participant_id = NULL;
            // Is this user already a participant?
            if (isset($_POST['participant_id']))
            {
               $participant_id = clean($_POST['participant_id']);
            }
            // If not, create new participant record
            else
            {
               $user_id = $_SESSION['s_user_id'];
               $atlantian_id = NULL;
               if (isset($_SESSION['s_atlantian_id']))
               {
                  $atlantian_id = $_SESSION['s_atlantian_id'];
               }
               $pinsert = "";
               if ($atlantian_id != NULL)
               {
                  $pinsert = "INSERT INTO $DBNAME_UNIVERSITY.participant (atlantian_id, sca_name, date_created) SELECT atlantian_id, preferred_sca_name, CURRENT_DATE FROM $DBNAME_AUTH.atlantian WHERE atlantian_id = " . $atlantian_id;
                  $presult = mysql_query($pinsert)
                     or die("Insert Participant failed : " . $pinsert. "<br/>" . mysql_error());
                  $participant_id = mysql_insert_id();
               }
               else
               {
                  $pinsert = "INSERT INTO $DBNAME_UNIVERSITY.participant (user_id, sca_name, date_created) SELECT user_id, sca_name, CURRENT_DATE FROM $DBNAME_AUTH.user_auth WHERE user_id = " . $user_id;
                  $presult = mysql_query($pinsert)
                     or die("Insert Participant failed : " . $pinsert. "<br/>" . mysql_error());
                  $participant_id = mysql_insert_id();
               }
            }
            if (isset($participant_id))
            {
               $insert = "INSERT INTO $DBNAME_UNIVERSITY.registration (participant_id, course_id, participant_type_id, registration_status_id, date_created) VALUES ($participant_id, $course_id, $TYPE_STUDENT, $STATUS_REGISTERED, CURRENT_DATE)";
               $iresult = mysql_query($insert)
                  or die("Insert Registration failed : " . $insert. "<br/>" . mysql_error());
            }
         }
         // User is unregistering from class
         else if ($submit == $SUBMIT_UNREGISTER)
         {
            $registration_id = NULL;
            if (isset($_POST['registration_id']))
            {
               $registration_id = clean($_POST['registration_id']);
               $delete = "DELETE FROM $DBNAME_UNIVERSITY.registration WHERE registration_id = $registration_id";
               $dresult = mysql_query($delete)
                  or die("Delete Registration failed : " . $delete. "<br/>" . mysql_error());
            }
         }
         // Disconnect
         db_disconnect($link);
      }
   }

   /* Connecting, selecting database */
   $link = db_connect();

   $query = "SELECT course.*, course_category.course_category, course_category.course_category_code, room.room, course_status.course_status, university.university_date, university.university_code, university.publish_date, university.closed_date " .
         "FROM $DBNAME_UNIVERSITY.course JOIN $DBNAME_UNIVERSITY.course_status ON course.course_status_id = course_status.course_status_id " .
         "JOIN $DBNAME_UNIVERSITY.university ON course.university_id = university.university_id " .
         "LEFT OUTER JOIN $DBNAME_UNIVERSITY.course_category ON course.course_category_id = course_category.course_category_id " .
         "LEFT OUTER JOIN $DBNAME_UNIVERSITY.room ON course.room_id = room.room_id " .
         "WHERE course_id = $course_id";
   $result = mysql_query($query)
      or die("Course Query failed : " . $query. "<br/>" . mysql_error());
   $data = mysql_fetch_array($result, MYSQL_BOTH);

   $university_id = clean($data['university_id']);
   $university_code = clean($data['university_code']);
   $university_number = substr($university_code, 2);
   $university_date = clean($data['university_date']);
   $publish_date = clean($data['publish_date']);
   $closed_date = clean($data['closed_date']);

   $course_number = clean($data['course_number']);
   $title = clean($data['title']);
   $description = clean($data['description']);
   $course_category = clean($data['course_category']);
   $course_category_code = clean($data['course_category_code']);
   $course_category_display = $course_category_code;
   if ($course_category != "")
   {
      $course_category_display .= ": " . $course_category;
   }
   $credits = clean($data['credits']);
   $room = clean($data['room']);
   $cost = clean($data['cost']);
   $cost_display = "";
   if ($cost != "" && $cost != NULL)
   {
      $cost_display .= "$" . $cost;
   }
   $capacity = clean($data['capacity']);
   $hours = clean($data['hours']);
   $start_time = clean($data['start_time']);
   $end_time = clean($data['end_time']);
   $time_display = "";
   if ($start_time != "" && $end_time != "")
   {
      $time_display .= format_time($start_time) . " - " . format_time($end_time);
   }
   $course_status_id = clean($data['course_status_id']);
   $course_status = clean($data['course_status']);

   $instructor_query = "SELECT participant.participant_id, participant.sca_name FROM $DBNAME_UNIVERSITY.registration " .
      "JOIN $DBNAME_UNIVERSITY.participant ON registration.participant_id = participant.participant_id " .
      "WHERE registration.course_id = $course_id AND registration.participant_type_id = $TYPE_INSTRUCTOR";
   $instructor_result = mysql_query($instructor_query)
      or die("Instructor Query failed : " . $instructor_query. "<br/>" . mysql_error());
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

   $student_query = "SELECT registration.participant_id FROM $DBNAME_UNIVERSITY.registration " .
      "WHERE registration.course_id = $course_id AND registration.participant_type_id = $TYPE_STUDENT";
   $student_result = mysql_query($student_query)
      or die("Student Query failed : " . $student_query. "<br/>" . mysql_error());
   $num_students = mysql_num_rows($student_result);
   $attendance = "";
   if ($capacity != "" && $capacity != NULL)
   {
      if ($num_students >= $capacity)
      {
         $attendance = $FULL_CLASS;
      }
   }
   if ($capacity == "" || $capacity == NULL)
   {
      $capacity = $UNLIMITED_CLASS;
   }
   if ($attendance != $FULL_CLASS)
   {
      $attendance = $num_students . "/" . $capacity;
   }

   $university_display = ""; 
   if ($university_date != "")
   {
      $university_display .= " - " . format_short_date($university_date);
   }

   if ($course_status_id == $STATUS_CANCELED)
   {
      $attendance = $course_status;
   }
?>
   <h2 style="text-align:center"><?php echo htmlentities($title); ?></h2>
   <h3 style="text-align:center">Instructor<?php if ($num_instructors != 1) { echo "s"; } ?>:<br/><?php echo $instructor_display; ?></h3>
<table align="center" border="1" cellpadding="5" cellspacing="0">
   <tr>
      <th class="titleright">University Session</th>
      <td class="data"><a href="catalog.php?university_id=<?php echo $university_id; ?>"><?php echo $university_code; ?></a><?php echo $university_display; ?></td>
      <th class="titleright">Course #</th>
      <td class="data"><?php echo $course_number; ?></td>
   </tr>
   <tr>
      <th class="titleright">Time</th>
      <td class="data"><?php echo $time_display; ?></td>
      <th class="titleright">Fee</th>
      <td class="data"><?php echo $cost_display; ?></td>
   </tr>
   <tr>
      <th class="titleright">Length</th>
      <td class="data"><?php echo $hours; ?> hr<?php if ($hours != 1) { echo "s"; } ?></td>
      <th class="titleright">Credits</th>
      <td class="data"><?php echo $credits; ?></td>
   </tr>
   <tr>
      <th class="titleright">Attendees</th>
      <td class="data"><?php echo $attendance; ?></td>
      <th class="titleright">Room</th>
      <td class="data"><?php echo $room; ?></td>
   </tr>
   <tr>
      <th class="titleright">Course Category</th>
      <td class="data" colspan="3"><?php echo htmlentities($course_category_display); ?></td>
   </tr>
</table>
<br/>
<table align="center" border="0" cellpadding="5" cellspacing="0" width="75%">
   <tr>
      <th class="title">Description</th>
   </tr>
   <tr>
      <td class="datacenter"><?php echo htmlentities($description); ?></td>
   </tr>
</table>
<?php
   mysql_free_result($instructor_result);
   mysql_free_result($student_result);
   mysql_free_result($result);

   // Non-admin user logged in
   if (isset($_SESSION['s_username']))
   {
      // Preregistration is open
      $today = date("Y-m-d");
      if ($today >= $publish_date && $course_status_id == $STATUS_APPROVED)
      {
         // Get participant data
         $wc = "WHERE participant.user_id = " . $_SESSION['s_user_id'];
         if (isset($_SESSION['s_atlantian_id']))
         {
            $wc = "WHERE participant.atlantian_id = " . $_SESSION['s_atlantian_id'];
         }
         $query = "SELECT participant.* FROM $DBNAME_UNIVERSITY.participant $wc";
         $result = mysql_query($query)
            or die("Participant Query failed : " . $query. "<br/>" . mysql_error());
         $num_participants = mysql_num_rows($result);
         if ($num_participants > 0)
         {
            $data = mysql_fetch_array($result, MYSQL_BOTH);
            $participant_id = clean($data['participant_id']);
         }
         mysql_free_result($result);

         // Get user's currently registered classes
         $wc = "AND participant.user_id = " . $_SESSION['s_user_id'];
         if (isset($_SESSION['s_atlantian_id']))
         {
            $wc = "AND participant.atlantian_id = " . $_SESSION['s_atlantian_id'];
         }
         $query = "SELECT participant.participant_id, registration.registration_id, registration.participant_type_id, course.course_id, course.course_number, course.title, course.start_time, course.end_time " .
            "FROM $DBNAME_UNIVERSITY.course JOIN $DBNAME_UNIVERSITY.registration ON course.course_id = registration.course_id " .
            "JOIN $DBNAME_UNIVERSITY.participant ON registration.participant_id = participant.participant_id " .
            "WHERE course.university_id = $university_id AND registration.registration_status_id = $STATUS_REGISTERED " .
            "AND course.course_status_id = $STATUS_APPROVED " .
            $wc;
         $result = mysql_query($query)
            or die("Registration Query failed : " . $query. "<br/>" . mysql_error());
         $num_registrations = mysql_num_rows($result);

         $is_teaching_this_class = false;
         $is_prereg_for_this_class = false;
         $is_prereg_for_other_class_at_this_time = false;
         $other_course_title = "";
         $other_course_number = "";
         $other_course_start_time = "";
         $other_course_end_time = "";

         if ($num_registrations > 0)
         {
            while ($data = mysql_fetch_array($result, MYSQL_BOTH))
            {
               $u_course_id = clean($data['course_id']);
               // Check if already pre-registered
               if ($course_id == $u_course_id)
               {
                  $is_prereg_for_this_class = true;
                  $registration_id = clean($data['registration_id']);
                  $participant_type_id = clean($data['participant_type_id']);
                  if ($participant_type_id == $TYPE_INSTRUCTOR)
                  {
                     $is_teaching_this_class = true;
                  }
               }
               // Check for conflicting class
               else
               {
                  $u_start_time = clean($data['start_time']);
                  $u_end_time = clean($data['end_time']);
                  // If starting or ending times match, we overlap at least an hour
                  // If the class starts over an hour before and ends over an hour after, it overlaps
                  if ($start_time == $u_start_time || $end_time == $u_end_time ||
                     ($u_start_time < $start_time && $u_end_time > $end_time))
                  {
                     $is_prereg_for_other_class_at_this_time = true;
                     $other_course_number = clean($data['course_number']);
                     $other_course_title = clean($data['title']);
                     $other_course_start_time = format_time($u_start_time);
                     $other_course_end_time = format_time($u_end_time);
                  }
               }
            }
         }
         mysql_free_result($result);
?>
<h2 style="text-align:center">Registration</h2>
<?php
         // User is teaching this class
         if ($is_teaching_this_class || (isset($_SESSION[$UNIVERSITY_ADMIN]) && $_SESSION[$UNIVERSITY_ADMIN] == 1))
         {
            // Display students
            $query = "SELECT participant.sca_name " .
               "FROM $DBNAME_UNIVERSITY.participant JOIN $DBNAME_UNIVERSITY.registration ON participant.participant_id = registration.participant_id " .
               "WHERE registration.course_id = $course_id AND registration.participant_type_id = $TYPE_STUDENT";
            $result = mysql_query($query)
               or die("Student Query failed : " . $query. "<br/>" . mysql_error());
            $num_students = mysql_num_rows($result);
            if ($is_teaching_this_class)
            {
?>
<p style="text-align:center">You are teaching this class.</p>
<?php
            }
            if ($num_students > 0)
            {
?>
<h3 style="text-align:center">Students</h3>
<p style="text-align:center">
<?php
               while ($data = mysql_fetch_array($result, MYSQL_BOTH))
               {
                  $sca_name = clean($data['sca_name']);
                  if ($sca_name == "")
                  {
                     $sca_name = "(No SCA Name Given)";
                  }
                  echo htmlentities($sca_name) . "<br/>";
               }
?>
</p>
<?php
            }
            mysql_free_result($result);
         }
         // Registration options are only available during the prereg window
         else if ($today <= $closed_date && (!isset($_SESSION[$UNIVERSITY_ADMIN]) || (isset($_SESSION[$UNIVERSITY_ADMIN]) && $_SESSION[$UNIVERSITY_ADMIN] != 1)))
         {
            // If user is already pre-registered for this class, user may unregister
            if ($is_prereg_for_this_class)
            {
?>
<p style="text-align:center">You are currently registered for this class.</p>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="datacenter">
   <input type="hidden" name="course_id" value="<?php echo $course_id; ?>"/>
<?php
               if (isset($registration_id))
               {
?>
   <input type="hidden" name="registration_id" value="<?php echo $registration_id; ?>"/>
<?php
               }
?>
   <input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_UNREGISTER; ?>">
</form>
<?php
            }
            // If the class is full, no registration is allowed
            else if ($attendance == $FULL_CLASS)
            {
               echo "<p style=\"text-align:center\">This class is full.</p>";
            }
            // If the user already has a class at this time, they may not register
            else if ($is_prereg_for_other_class_at_this_time)
            {
               echo "<p style=\"text-align:center\">You are currently registered for another class at this time.  To register for this class, you must first unregister from the conflicting class.</p>";
               echo "<p style=\"text-align:center\">Conflicting Class: $other_course_number - $other_course_title - $other_course_start_time - $other_course_end_time</p>";
            }
            // Otherwise, the user may preregister for the class
            else
            {
?>
<p style="text-align:center">You may register for this class.</p>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="datacenter">
   <input type="hidden" name="course_id" value="<?php echo $course_id; ?>"/>
<?php
               if (isset($participant_id))
               {
?>
   <input type="hidden" name="participant_id" value="<?php echo $participant_id; ?>"/>
<?php
               }
?>
   <input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_REGISTER; ?>">
</form>
<?php
           }
?>
<p style="text-align:center">View <a href="<?php echo $ADMIN_DIR; ?>preregistrations.php">My Registrations</a>.</p>
<?php
         }
      }
   }
   // Disconnect database
   db_disconnect($link);
}
include("footer.php");
?>