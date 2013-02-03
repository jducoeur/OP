<?php
include_once("db/validation_format.php");

$university_id = "";
if (isset($_REQUEST['university_id']))
{
   $university_id = clean($_REQUEST['university_id']);
}

$title = "Catalog";
include("header.php");
?>
<h2 style="text-align:center">Course Catalog</h2>
<?php
/* Connecting, selecting database */
$link = db_connect();

// Retrieve current university session if no session is specified
if ($university_id == "")
{
   $query = "SELECT university.university_id FROM $DBNAME_UNIVERSITY.university " .
            "WHERE is_university = 1 AND university_date = (SELECT MAX(university_date) FROM $DBNAME_UNIVERSITY.university WHERE is_university = 1 AND publish_date IS NOT NULL AND publish_date <= CURRENT_DATE)";
   $result = mysql_query($query)
      or die("Current University Query failed : " . mysql_error());
   $data = mysql_fetch_array($result, MYSQL_BOTH);

   $university_id = clean($data['university_id']);
}

$query = "SELECT university.*, branch.*, branch_type.branch_type FROM $DBNAME_UNIVERSITY.university LEFT OUTER JOIN $DBNAME_BRANCH.branch ON university.branch_id = branch.branch_id " .
         "LEFT OUTER JOIN $DBNAME_BRANCH.branch_type ON branch.branch_type_id = branch_type.branch_type_id " .
         "WHERE publish_date IS NOT NULL AND publish_date <= CURRENT_DATE AND university_id = $university_id";
$result = mysql_query($query)
   or die("University Query failed : " . mysql_error());
$data = mysql_fetch_array($result, MYSQL_BOTH);

$university_code = clean($data['university_code']);
$university_number = substr($university_code, 2);
$university_date = clean($data['university_date']);
$is_university = clean($data['is_university']);
$branch_name = clean($data['branch']);
$branch_type = clean($data['branch_type']);
$incipient = clean($data['incipient']);
$incpient_display = "";
if ($incipient == 1)
{
   $incpient_display = "Incipient ";
}

$university_display = "";
if ($is_university == 1)
{
   $university_display .= "University Session #$university_number";
}
else
{
   $university_display .= "Collegium Session $university_code";
}
if ($university_date != "")
{
   $university_display .= "<br/>" . format_full_date($university_date);
}
if ($branch_name != "")
{
   $university_display .= "<br/>" . $incpient_display . $branch_type . " of " . $branch_name;
}
?>
   <h2 style="text-align:center"><?php echo $university_display; ?></h2>
<?php
// Retrieve university session courses
$class_query = "SELECT course.*, room.*, course_status.course_status FROM $DBNAME_UNIVERSITY.course " .
               "JOIN $DBNAME_UNIVERSITY.course_status ON course.course_status_id = course_status.course_status_id " .
               "LEFT OUTER JOIN $DBNAME_UNIVERSITY.room ON course.room_id = room.room_id " .
               "WHERE course.university_id = $university_id " .
               "AND course.course_status_id = $STATUS_APPROVED " .
               "ORDER BY start_time, end_time, course_number";
$class_result = mysql_query($class_query)
   or die("Class Query failed : " . mysql_error());
$num_classes = mysql_num_rows($class_result);

if ($num_classes > 0)
{
?>
<table align="center" cellpadding="5" cellspacing="0">
   <tr>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">#</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Title</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Instructor(s)</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Room</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Fee</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Attendees</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Length</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Time</th>
   </tr>
<?php
   $j = 1;
   $prev_start_time = "";
   while ($class_data = mysql_fetch_array($class_result, MYSQL_BOTH)) 
   {
      $course_id = clean($class_data['course_id']);
      $course_number = clean($class_data['course_number']);
      $title = clean($class_data['title']);
      $hours = clean($class_data['hours']);
      $room = clean($class_data['room']);
      $cost = clean($class_data['cost']);
      $cost_display = "";
      if ($cost != "" && $cost != NULL)
      {
         $cost_display .= "$" . $cost;
      }
      $capacity = clean($class_data['capacity']);
      $hours = clean($class_data['hours']);
      $start_time = clean($class_data['start_time']);
      $end_time = clean($class_data['end_time']);
      $time_display = "";
      if ($start_time != "" && $end_time != "")
      {
         $time_display .= format_time($start_time) . " - " . format_time($end_time);
      }

      $instructor_query = "SELECT participant.participant_id, participant.sca_name FROM $DBNAME_UNIVERSITY.registration " .
         "JOIN $DBNAME_UNIVERSITY.participant ON registration.participant_id = participant.participant_id " .
         "WHERE registration.course_id = $course_id AND registration.participant_type_id = $TYPE_INSTRUCTOR ORDER BY participant.sca_name";
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

      $student_query = "SELECT registration.registration_id FROM $DBNAME_UNIVERSITY.registration " .
         "WHERE registration.course_id = $course_id AND registration.participant_type_id = $TYPE_STUDENT";
      $student_result = mysql_query($student_query)
         or die("Student Query failed : " . mysql_error());
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

      $bgcolor = (($j%2 == 0)? "#DDDDDD": "#EEEEEE");

      $course_status_id = clean($class_data['course_status_id']);
      $course_status = clean($class_data['course_status']);
      if ($course_status_id == $STATUS_CANCELED)
      {
         $bgcolor = "#ff9999";
         $attendance = $course_status;
      }

      if ($prev_start_time != $start_time)
      {
         if ($prev_start_time != "")
         {
            echo "<tr><td colspan=\"8\" style=\"background-color:$accent_color;\"></td></tr>";
         }
         $prev_start_time = $start_time;
      }
?>
   <tr>
      <td bgcolor="<?php echo $bgcolor; ?>" style="text-align:right"><?php echo $course_number; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>"><a href="class.php?course_id=<?php echo $course_id; ?>"><?php echo htmlentities($title); ?></a></td>
      <td bgcolor="<?php echo $bgcolor; ?>"><?php echo $instructor_display; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>"><?php echo $room; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>" style="text-align:right"><?php echo $cost_display; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>" style="text-align:right"><?php echo $attendance; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>" style="text-align:right"><?php echo $hours; ?> hr<?php if ($hours != 1) { echo "s"; } ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>" style="text-align:center"><?php echo $time_display; ?></td>
   </tr>
<?php
      $j++;
      mysql_free_result($instructor_result);
      mysql_free_result($student_result);
   }
?>
</table>
<?php
}
mysql_free_result($class_result);
mysql_free_result($result);
db_disconnect($link);
?>
<p style="text-align:center"><a href="catalogs.php">Other Session Catalogs</a></p>
<?php include("footer.php");?>