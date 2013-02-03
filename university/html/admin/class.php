<?php
include_once("../db/validation_format.php");
include_once("db.php");

$title = "Course Detail";
include("../header.php");

$course_id = "";
if (isset($_REQUEST['course_id']))
{
   $course_id = clean($_REQUEST['course_id']);
}

$university_id = "";
if (isset($_REQUEST['university_id']))
{
   $university_id = clean($_REQUEST['university_id']);
}

$mode = $MODE_EDIT;
if (isset($_REQUEST['mode']))
{
   $mode = clean($_REQUEST['mode']);
}

?>
<h2 style="text-align:center"><?php echo ucfirst($mode); ?> Class</h2>
<?php
// Only appropriate admins allowed
if (isset($_SESSION[$UNIVERSITY_ADMIN]) && $_SESSION[$UNIVERSITY_ADMIN] == 1)
{
   $SUBMIT_SAVE = "Save Class";
   $SUBMIT_DELETE = "Delete Class";
   $SUBMIT_DELETE_REGISTRATION = "Delete Registrations";
   $SUBMIT_MARK_ATTENDED = "Mark Attended";

   $valid = true;
   $errmsg = '';
   // Delete Class
   if (isset($_POST['submit']) && $_POST['submit'] == $SUBMIT_DELETE)
   {
      if ($course_id > 0)
      {
         $link = db_admin_connect();

         // Delete Class
         $delete = "DELETE FROM $DBNAME_UNIVERSITY.course WHERE course_id = ". $course_id;
         $dresult = mysql_query($delete)
            or die("Error deleting Class: " . $delete . "<br/>" . mysql_error());

         db_disconnect($link);
?>
<p align="center">Class successfully deleted.<br/><a href="catalog.php?university_id=<?php echo $university_id; ?>">Return to the Class list</a>.</p>
<?php 
      }
   }

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
<p align="center">Registrations successfully deleted.<br/><a href="class.php?university_id=<?php echo $university_id; ?>&amp;course_id=<?php echo $course_id; ?>">Return to the Class</a>.</p>
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

   // Mark Registrations Attended
   if (isset($_POST['submit']) && $_POST['submit'] == $SUBMIT_MARK_ATTENDED)
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

         $mark = "UPDATE $DBNAME_UNIVERSITY.registration SET registration_status_id = $STATUS_ATTENDED WHERE registration_id IN ($del_registration_id)";

         $mresult = mysql_query($mark)
            or die("Error marking Registrations as attended: " . $mark . "<br/>" . mysql_error());

         /* Closing connection */
         db_disconnect($link);
?>
<p align="center">Registrations successfully marked as attended.<br/><a href="class.php?university_id=<?php echo $university_id; ?>&amp;course_id=<?php echo $course_id; ?>">Return to the Class</a>.</p>
<?php 
      }
      else
      {
         $delerrmsg = "Please select at least one Registration to mark as attended.";
?>
<p align="center" class="title3" style="color:red"><?php echo $delerrmsg; ?></p>
<?php 
      }
   }

   // Save Class
   if (isset($_POST['submit']) && $_POST['submit'] == $SUBMIT_SAVE)
   {
      $course_title = NULL;
      if (isset($_POST['course_title']))
      {
         $course_title = clean($_POST['course_title']);
      }
      $description = NULL;
      if (isset($_POST['description']))
      {
         $description = clean($_POST['description']);
      }
      $course_number = NULL;
      if (isset($_POST['course_number']))
      {
         $course_number = clean($_POST['course_number']);
      }
      $course_code = NULL;
      if (isset($_POST['course_code']))
      {
         $course_code = clean($_POST['course_code']);
      }
      $start_time = NULL;
      if (isset($_POST['start_time']))
      {
         $start_time = clean($_POST['start_time']);
      }
      $end_time = NULL;
      if (isset($_POST['end_time']))
      {
         $end_time = clean($_POST['end_time']);
      }
      $hours = NULL;
      if (isset($_POST['hours']))
      {
         $hours = clean($_POST['hours']);
      }
      $credits = NULL;
      if (isset($_POST['credits']))
      {
         $credits = clean($_POST['credits']);
      }
      $capacity = NULL;
      if (isset($_POST['capacity']))
      {
         $capacity = clean($_POST['capacity']);
      }
      $cost = NULL;
      if (isset($_POST['cost']))
      {
         $cost = clean($_POST['cost']);
      }
      $requirements = NULL;
      if (isset($_POST['requirements']))
      {
         $requirements = clean($_POST['requirements']);
      }
      $changes = NULL;
      if (isset($_POST['changes']))
      {
         $changes = clean($_POST['changes']);
      }
      $comments = NULL;
      if (isset($_POST['comments']))
      {
         $comments = clean($_POST['comments']);
      }
      $room_id = NULL;
      if (isset($_POST['room_id']))
      {
         $room_id = clean($_POST['room_id']);
      }
      $course_category_id = NULL;
      if (isset($_POST['course_category_id']))
      {
         $course_category_id = clean($_POST['course_category_id']);
      }
      $course_track_id = NULL;
      if (isset($_POST['course_track_id']))
      {
         $course_track_id = clean($_POST['course_track_id']);
      }
      $course_status_id = NULL;
      if (isset($_POST['course_status_id']))
      {
         $course_status_id = clean($_POST['course_status_id']);
      }

      // Validate data
      if ($course_title == NULL || $course_title == '')
      {
         $valid = false;
         $errmsg .= "Please enter the Course Title.<br/>";
      }
      if ($hours == NULL || $hours == '')
      {
         $valid = false;
         $errmsg .= "Please enter the Class Length.<br/>";
      }
      else if (!validate_positive_integer($hours))
      {
         $valid = false;
         $errmsg .= "Please enter a number of hours for the Class Length.<br/>";
      }
      if ($credits == NULL || $credits == '')
      {
         $valid = false;
         $errmsg .= "Please enter the Class Credits.<br/>";
      }
      else if (!validate_zero_plus_integer($credits))
      {
         $valid = false;
         $errmsg .= "Please enter a number for the Class Credits.<br/>";
      }
      if ($course_status_id == NULL || $course_status_id == '')
      {
         $valid = false;
         $errmsg .= "Please select a Course Status.<br/>";
      }
      // Check capacity if it is filled in
      if ($capacity != NULL && $capacity != '')
      {
         if (!validate_positive_integer($capacity))
         {
            $valid = false;
            $errmsg .= "Please enter a number for the Maximum Capacity.  Leave the field blank for no limit.<br/>";
         }
      }
      // Check cost if it is filled in
      if ($cost != NULL && $cost != '')
      {
         if (!validate_positive_number($cost))
         {
            $valid = false;
            $errmsg .= "Please enter a number for the Fee.  Leave the field blank for no fee.<br/>";
         }
      }

      if ($valid)
      {
         $link = db_admin_connect();

         // Update University
         if ($mode == $MODE_EDIT)
         {
            $update = 
               "UPDATE $DBNAME_UNIVERSITY.course " .
               "SET title = " . value_or_null($course_title) . 
               ", description = " . value_or_null($description) . 
               ", course_number = " . value_or_null($course_number) . 
               ", course_code = " . value_or_null($course_code) . 
               ", start_time = " . value_or_null($start_time) . 
               ", end_time = " . value_or_null($end_time) . 
               ", hours = " . value_or_null($hours) . 
               ", credits = " . value_or_null($credits) . 
               ", capacity = " . value_or_null($capacity) . 
               ", cost = " . value_or_null($cost) . 
               ", requirements = " . value_or_null($requirements) . 
               ", changes = " . value_or_null($changes) . 
               ", comments = " . value_or_null($comments) . 
               ", room_id = " . value_or_null($room_id) . 
               ", course_category_id = " . value_or_null($course_category_id) . 
               ", course_track_id = " . value_or_null($course_track_id) . 
               ", course_status_id = " . value_or_null($course_status_id) . 
               ", last_updated = " . value_or_null(date("Y-m-d")) .
               ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) .
               " WHERE course_id = ". $course_id;

            $uresult = mysql_query($update)
               or die("Error updating Class: " . $update . "<br/>" . mysql_error());
         }
         // Insert University
         else
         {
            $insert = 
               "INSERT INTO $DBNAME_UNIVERSITY.course (university_id, title, description, course_number, course_code, start_time, end_time, hours, credits, capacity, cost, requirements, changes, comments, room_id, course_category_id, course_track_id, course_status_id, date_created, last_updated, last_updated_by) VALUES (" . 
               value_or_null($university_id) . ", " . 
               value_or_null($course_title) . ", " . 
               value_or_null($description) . ", " . 
               value_or_null($course_number) . ", " . 
               value_or_null($course_code) . ", " . 
               value_or_null($start_time) . ", " . 
               value_or_null($end_time) . ", " . 
               value_or_null($hours) . ", " . 
               value_or_null($credits) . ", " . 
               value_or_null($capacity) . ", " . 
               value_or_null($cost) . ", " . 
               value_or_null($requirements) . ", " . 
               value_or_null($changes) . ", " . 
               value_or_null($comments) . ", " . 
               value_or_null($room_id) . ", " . 
               value_or_null($course_category_id) . ", " . 
               value_or_null($course_track_id) . ", " . 
               value_or_null($course_status_id) . ", " . 
               value_or_null(date("Y-m-d")) . ", " . 
               value_or_null(date("Y-m-d")) . ", " . 
               value_or_null($_SESSION['s_user_id']) . ")";

            $iresult = mysql_query($insert)
               or die("Error inserting Class: " . $insert . "<br/>" . mysql_error());
         }
         /* Closing connection */
         db_disconnect($link);
?>
<p align="center">Class successfully updated.<br/><a href="catalog.php?university_id=<?php echo $university_id; ?>">Return to the Class list</a>.</p>
<?php 
      } // valid
   }
   // We haven't submitted save yet - display edit form
   if (!(isset($_POST['submit'])) || (isset($_POST['submit']) && ($_POST['submit'] == $SUBMIT_SAVE && !$valid)))
   {
      $link = db_connect();

      if ($university_id != "")
      {
         $query = "SELECT university_code, university_date, publish_date FROM $DBNAME_UNIVERSITY.university WHERE university_id = $university_id";
         $result = mysql_query($query)
            or die("University Query failed : " . $query. "<br/>" . mysql_error());

         $data = mysql_fetch_array($result, MYSQL_BOTH);
         $university_code = clean($data['university_code']);
         $university_number = substr($university_code, 2);
         $university_date = clean($data['university_date']);
         $publish_date = clean($data['publish_date']);

         mysql_free_result($result);
      }

      if ($mode == $MODE_EDIT && $valid)
      {
         $query = "SELECT course.*, university.university_code, university.university_date, university.publish_date " .
                  "FROM $DBNAME_UNIVERSITY.course JOIN $DBNAME_UNIVERSITY.university ON course.university_id = university.university_id " .
                  "WHERE course.course_id = $course_id";
         $result = mysql_query($query)
            or die("Course Query failed : " . $query. "<br/>" . mysql_error());
         $data = mysql_fetch_array($result, MYSQL_BOTH);

         $university_id = clean($data['university_id']);
         $university_code = clean($data['university_code']);
         $university_number = substr($university_code, 2);
         $university_date = clean($data['university_date']);
         $publish_date = clean($data['publish_date']);
         $course_number = clean($data['course_number']);
         $course_title = clean($data['title']);
         $course_code = clean($data['course_code']);
         $description = clean($data['description']);
         $course_category_id = clean($data['course_category_id']);
         $course_status_id = clean($data['course_status_id']);
         $course_track_id = clean($data['course_track_id']);
         $credits = clean($data['credits']);
         $hours = clean($data['hours']);
         $start_time = clean($data['start_time']);
         $end_time = clean($data['end_time']);
         $room_id = clean($data['room_id']);
         $cost = clean($data['cost']);
         $capacity = clean($data['capacity']);
         $requirements = clean($data['requirements']);
         $changes = clean($data['changes']);
         $comments = clean($data['comments']);

         /* Free resultset */
         mysql_free_result($result);
      }
      /* Closing connection */
      db_disconnect($link);

      if (!$valid)
      {
?>
<p align="center" class="title3" style="color:red"><?php echo $errmsg; ?></p>
<?php 
      }

      // Get pick lists
      $course_category_data_array = get_course_category_pick_list();
      $course_status_data_array = get_course_status_pick_list();
      $course_track_data_array = get_course_track_pick_list($university_id);
      $room_data_array = get_room_pick_list($university_id);

      // Add people to the top
      $num_instructors = 0;
      $num_students = 0;

      /* Connecting, selecting database */
      $link = db_connect();

      if ($course_id != NULL)
      {
         $instructor_query = "SELECT registration.registration_id, registration_status.registration_status, participant.participant_id, participant.sca_name FROM $DBNAME_UNIVERSITY.registration " .
            "JOIN $DBNAME_UNIVERSITY.participant ON registration.participant_id = participant.participant_id " .
            "JOIN $DBNAME_UNIVERSITY.registration_status ON registration.registration_status_id = registration_status.registration_status_id " .
            "WHERE registration.course_id = $course_id AND registration.participant_type_id = $TYPE_INSTRUCTOR ORDER BY participant.sca_name";
         $instructor_result = mysql_query($instructor_query)
            or die("Instructor Query failed : " . $instructor_query. "<br/>" . mysql_error());
         $num_instructors = mysql_num_rows($instructor_result);

         $student_query = "SELECT registration.registration_id, registration_status.registration_status, participant.participant_id, participant.sca_name FROM $DBNAME_UNIVERSITY.registration " .
            "JOIN $DBNAME_UNIVERSITY.participant ON registration.participant_id = participant.participant_id " .
            "JOIN $DBNAME_UNIVERSITY.registration_status ON registration.registration_status_id = registration_status.registration_status_id " .
            "WHERE registration.course_id = $course_id AND registration.participant_type_id = $TYPE_STUDENT ORDER BY registration.registration_status_id, participant.sca_name";
         $student_result = mysql_query($student_query)
            or die("Student Query failed : " . $student_query. "<br/>" . mysql_error());
         $num_students = mysql_num_rows($student_result);
      }

      if ($course_id != NULL)
      {
?>
   <h3 style="text-align:center">Instructor<?php if ($num_instructors != 1) { echo "s"; } ?></h3>
   <p style="text-align:center"><a href="select_participant.php?type=<?php echo $ST_INSTRUCTOR; ?>&amp;course_id=<?php echo $course_id; ?>">Add Instructor</a></p>
   <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<?php 
         if (isset($university_id) && $university_id > 0)
         {
?>
   <input type="hidden" name="university_id" id="university_id" value="<?php echo $university_id; ?>"/>
<?php 
         }
         if (isset($course_id) && $course_id > 0)
         {
?>
   <input type="hidden" name="course_id" id="course_id" value="<?php echo $course_id; ?>"/>
<?php 
         }
?>
   <table border="1" align="center" cellpadding="5" cellspacing="0">
      <tr>
         <th class="title">Action</th>
         <th class="title">Participant</th>
         <th class="title">Registration Status</th>
      </tr>
<?php
         if ($num_instructors > 0)
         {
            $i = 1;
            while ($instructor_data = mysql_fetch_array($instructor_result, MYSQL_BOTH))
            {
               $registration_id = clean($instructor_data['registration_id']);
               $registration_status = clean($instructor_data['registration_status']);
               $participant_id = clean($instructor_data['participant_id']);
               $sca_name = clean($instructor_data['sca_name']);
               if ($sca_name == "")
               {
                  $sca_name = "(No SCA name)";
               }
?>
      <tr>
         <td class="data"><input type="checkbox" name="del_registration_id<?php echo $i; ?>" id="del_registration_id<?php echo $i++; ?>" value="<?php echo $registration_id; ?>"/></td>
         <td class="data"><a href="registration.php?mode=<?php echo $MODE_EDIT; ?>&amp;registration_id=<?php echo $registration_id; ?>"><?php echo htmlentities($sca_name); ?></a></td>
         <td class="data"><?php echo htmlentities($registration_status); ?></td>
      </tr>
               
<?php
            }
?>
      <input type="hidden" name="del_registration_max" id="del_registration_max" value="<?php echo $i; ?>"/>
      <tr>
         <td class="datacenter" colspan="4">
         <input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_DELETE_REGISTRATION; ?>"/>
         &nbsp;&nbsp;&nbsp;
         <input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_MARK_ATTENDED; ?>"/>
         </td>
      </tr>
<?php
         }
         else
         {
?>
      <tr><td colspan="3" class="datacenter">None</td></tr>
<?php
         }
?>
   </table>
   </form>
   <h3 style="text-align:center">Student<?php if ($num_students != 1) { echo "s"; } ?></h3>
   <p style="text-align:center"><a href="select_participant.php?type=<?php echo $ST_STUDENT; ?>&amp;course_id=<?php echo $course_id; ?>">Add Student</a></p>
   <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<?php 
         if (isset($university_id) && $university_id > 0)
         {
?>
   <input type="hidden" name="university_id" id="university_id" value="<?php echo $university_id; ?>"/>
<?php 
         }
         if (isset($course_id) && $course_id > 0)
         {
?>
   <input type="hidden" name="course_id" id="course_id" value="<?php echo $course_id; ?>"/>
<?php 
         }
?>
   <table border="1" align="center" cellpadding="5" cellspacing="0">
      <tr>
         <th class="title">Action</th>
         <th class="title">Participant</th>
         <th class="title">Registration Status</th>
      </tr>
<?php
         if ($num_students > 0)
         {
            $i = 1;
            while ($student_data = mysql_fetch_array($student_result, MYSQL_BOTH))
            {
               $registration_id = clean($student_data['registration_id']);
               $registration_status = clean($student_data['registration_status']);
               $participant_id = clean($student_data['participant_id']);
               $sca_name = clean($student_data['sca_name']);
               if ($sca_name == "")
               {
                  $sca_name = "(No SCA name)";
               }
?>
      <tr>
         <td class="data"><input type="checkbox" name="del_registration_id<?php echo $i; ?>" id="del_registration_id<?php echo $i++; ?>" value="<?php echo $registration_id; ?>"/></td>
         <td class="data"><a href="registration.php?mode=<?php echo $MODE_EDIT; ?>&amp;registration_id=<?php echo $registration_id; ?>"><?php echo htmlentities($sca_name); ?></a></td>
         <td class="data"><?php echo htmlentities($registration_status); ?></td>
      </tr>
               
<?php
            }
?>
      <input type="hidden" name="del_registration_max" id="del_registration_max" value="<?php echo $i; ?>"/>
      <tr>
         <td class="datacenter" colspan="3">
         <input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_DELETE_REGISTRATION; ?>"/>
         &nbsp;&nbsp;&nbsp;
         <input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_MARK_ATTENDED; ?>"/>
         </td>
      </tr>
<?php
         }
         else
         {
?>
      <tr><td colspan="3" class="datacenter">None</td></tr>
<?php
         }
?>
   </table>
   </form>
   <br/>
<?php
         mysql_free_result($instructor_result);
         mysql_free_result($student_result);
         db_disconnect($link);
      }
?>
<h3 style="text-align:center">Class Information</h3>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>"/>
<table border="1" align="center" cellpadding="5" cellspacing="0" summary="Course Form">
<?php 
      if (isset($university_id) && $university_id > 0)
      {
?>
   <input type="hidden" name="university_id" id="university_id" value="<?php echo $university_id; ?>"/>
<?php 
      }
      if (isset($course_id) && $course_id > 0)
      {
?>
   <input type="hidden" name="course_id" id="course_id" value="<?php echo $course_id; ?>"/>
<?php 
      }
?>
   <tr>
      <th class="titleright">University Session:</th>
      <td class="data"><a href="catalog.php?university_id=<?php echo $university_id; ?>"><?php echo $university_code; ?></a></td>
      <th class="titleright">Course ID:</th>
      <td class="data"><?php echo $course_id; ?></td>
   </tr>
   <tr>
      <th class="titleright"><label for="course_number">Course Number:</label></th>
      <td class="data"><input type="text" name="course_number" id="course_number" size="15" maxlength="20"<?php if (isset($course_number) && trim($course_number) != '') { echo " value=\"" . $course_number . "\""; } ?>/></td>
      <th class="titleright"><label for="course_code">Course Code:</label></th>
      <td class="data"><input type="text" name="course_code" id="course_code" size="35" maxlength="30"<?php if (isset($course_code) && trim($course_code) != '') { echo " value=\"" . $course_code . "\""; } ?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="course_title">Course Title:</label></th>
      <td class="data" colspan="3"><input type="text" name="course_title" id="course_title" size="60" maxlength="100"<?php if (isset($course_title) && trim($course_title) != '') { echo " value=\"" . $course_title . "\""; } ?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="description">Description:</label></th>
      <td class="data" colspan="3"><textarea name="description" id="description" cols="55" rows="4"><?php if (isset($description) && trim($description) != '') { echo $description; } ?></textarea></td>
   </tr>
   <tr>
      <th class="titleright"><label for="start_time">Start Time:</label></th>
      <td class="data"><input type="text" name="start_time" id="start_time" size="10" maxlength="10"<?php if (isset($start_time) && trim($start_time) != '') { echo " value=\"" . $start_time . "\""; } ?>/></td>
      <th class="titleright"><label for="end_time">End Time:</label></th>
      <td class="data"><input type="text" name="end_time" id="end_time" size="10" maxlength="10"<?php if (isset($end_time) && trim($end_time) != '') { echo " value=\"" . $end_time . "\""; } ?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="hours">Class Length:</label></th>
      <td class="data"><input type="text" name="hours" id="hours" size="5" maxlength="5"<?php if (isset($hours) && trim($hours) != '') { echo " value=\"" . $hours . "\""; } ?>/> hour(s)</td>
      <th class="titleright"><label for="capacity">Maximum Capacity:</label></th>
      <td class="data"><input type="text" name="capacity" id="capacity" size="5" maxlength="5"<?php if (isset($capacity) && trim($capacity) != '') { echo " value=\"" . $capacity . "\""; } ?>/> (Leave blank for no limit)</td>
   </tr>
   <tr>
      <th class="titleright"><label for="credits">Credits:</label></th>
      <td class="data"><input type="text" name="credits" id="credits" size="5" maxlength="5"<?php if (isset($credits) && trim($credits) != '') { echo " value=\"" . $credits . "\""; } ?>/></td>
      <th class="titleright"><label for="cost">Fee:</label></th>
      <td class="data">$<input type="text" name="cost" id="cost" size="5" maxlength="5"<?php if (isset($cost) && trim($cost) != '') { echo " value=\"" . $cost . "\""; } ?>/> (Leave blank for no fee)</td>
   </tr>
   <tr>
      <td class="titleright"><label for="course_status_id">Course Status:</label></td>
      <td class="data">
      <select name="course_status_id" id="course_status_id">
<?php
      for ($i = 0; $i < count($course_status_data_array); $i++)
      {
         echo '<option id="' . $course_status_data_array[$i]['course_status'] . '" value="' . $course_status_data_array[$i]['course_status_id'] . '"';
         if (isset($course_status_id) && $course_status_id == $course_status_data_array[$i]['course_status_id'])
         {
            echo ' selected';
         }
         echo '>' . $course_status_data_array[$i]['course_status'] . '</option>';
      }
?>
      </select>
      </td>
      <td class="titleright"><label for="room_id">Room:</label></td>
      <td class="data">
      <select name="room_id" id="room_id">
         <option></option>
<?php
      for ($i = 0; $i < count($room_data_array); $i++)
      {
         echo '<option id="' . $room_data_array[$i]['room'] . '" value="' . $room_data_array[$i]['room_id'] . '"';
         if (isset($room_id) && $room_id == $room_data_array[$i]['room_id'])
         {
            echo ' selected';
         }
         echo '>' . $room_data_array[$i]['room'] . '</option>';
      }
?>
      </select>
      </td>
   </tr>
   <tr>
      <td class="titleright"><label for="course_category_id">Course Category:</label></td>
      <td class="data">
      <select name="course_category_id" id="course_category_id">
         <option></option>
<?php
      for ($i = 0; $i < count($course_category_data_array); $i++)
      {
         echo '<option id="' . $course_category_data_array[$i]['course_category'] . '" value="' . $course_category_data_array[$i]['course_category_id'] . '"';
         if (isset($course_category_id) && $course_category_id == $course_category_data_array[$i]['course_category_id'])
         {
            echo ' selected';
         }
         echo '>' . $course_category_data_array[$i]['course_category'] . '</option>';
      }
?>
      </select>
      </td>
      <td class="titleright"><label for="course_track_id">Course Track:</label></td>
      <td class="data">
      <select name="course_track_id" id="course_track_id">
         <option></option>
<?php
      for ($i = 0; $i < count($course_track_data_array); $i++)
      {
         echo '<option id="' . $course_track_data_array[$i]['course_track'] . '" value="' . $course_track_data_array[$i]['course_track_id'] . '"';
         if (isset($course_track_id) && $course_track_id == $course_track_data_array[$i]['course_track_id'])
         {
            echo ' selected';
         }
         echo '>' . $course_track_data_array[$i]['course_track'] . '</option>';
      }
?>
      </select>
      </td>
   </tr>
   <tr>
      <th class="titleright"><label for="requirements">Requirements:</label></th>
      <td class="data" colspan="3"><input type="text" name="requirements" id="requirements" size="60" maxlength="100"<?php if (isset($requirements) && trim($requirements) != '') { echo " value=\"" . $requirements . "\""; } ?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="changes">Changes:</label></th>
      <td class="data" colspan="3"><input type="text" name="changes" id="changes" size="60" maxlength="100"<?php if (isset($changes) && trim($changes) != '') { echo " value=\"" . $changes . "\""; } ?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="comments">Comments:</label></th>
      <td class="data" colspan="3"><textarea name="comments" id="comments" cols="55" rows="3"><?php if (isset($comments) && trim($comments) != '') { echo $comments; } ?></textarea></td>
   </tr>
   <tr>
      <td colspan="4" class="datacenter">
      <input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_SAVE; ?>"/>
<?php
      if ($course_id != NULL && $num_instructors == 0 && $num_students == 0)
      {
?>
      &nbsp;&nbsp;&nbsp;
      <input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_DELETE; ?>"/>
<?php
      }
?>
      </td>
   </tr>
</table>
<?php
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
