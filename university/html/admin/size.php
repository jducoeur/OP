<?php
include_once("../db/validation_format.php");

$university_id = "";
if (isset($_REQUEST['university_id']))
{
   $university_id = clean($_REQUEST['university_id']);
}

$title = "Classes by Period";
$printable = 1;
include("../header.php");

// Only appropriate admins allowed
if (isset($_SESSION[$UNIVERSITY_ADMIN]) && $_SESSION[$UNIVERSITY_ADMIN] == 1)
{
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

$query = "SELECT university.*, branch.*, branch_type.branch_type FROM $DBNAME_UNIVERSITY.university JOIN $DBNAME_BRANCH.branch ON university.branch_id = branch.branch_id " .
         "JOIN $DBNAME_BRANCH.branch_type ON branch.branch_type_id = branch_type.branch_type_id " .
         "WHERE is_university = 1 AND publish_date IS NOT NULL AND publish_date <= CURRENT_DATE AND university_id = $university_id";
$result = mysql_query($query)
   or die("University Query failed : " . mysql_error());
$data = mysql_fetch_array($result, MYSQL_BOTH);

$university_code = clean($data['university_code']);
$university_number = substr($university_code, 2);
$university_date = clean($data['university_date']);
$branch_name = clean($data['branch']);
$branch_type = clean($data['branch_type']);
$incipient = clean($data['incipient']);
$incpient_display = "";
if ($incipient == 1)
{
   $incpient_display = "Incipient ";
}

$university_display = "University of Atlantia #$university_number: Classes by Period - ";

// Retrieve university session courses
$class_query = "SELECT course.*, room.room, course_status.course_status FROM $DBNAME_UNIVERSITY.course " .
               "JOIN $DBNAME_UNIVERSITY.course_status ON course.course_status_id = course_status.course_status_id " .
               "LEFT OUTER JOIN $DBNAME_UNIVERSITY.room ON course.room_id = room.room_id " .
               "WHERE course.university_id = $university_id " .
               "ORDER BY start_time, end_time, course_number";
$class_result = mysql_query($class_query)
   or die("Class Query failed : " . mysql_error());
$num_classes = mysql_num_rows($class_result);

if ($num_classes > 0)
{
   $j = 1;
   $prev_start_time = "";
   while ($class_data = mysql_fetch_array($class_result, MYSQL_BOTH)) 
   {
      $course_id = clean($class_data['course_id']);
      $course_number = clean($class_data['course_number']);
      $title = clean($class_data['title']);
      $course_status_id = clean($class_data['course_status_id']);
      $course_status = clean($class_data['course_status']);
      $room = clean($class_data['room']);
      $capacity = clean($class_data['capacity']);
      $start_time = clean($class_data['start_time']);
      $end_time = clean($class_data['end_time']);

      $student_query = "SELECT registration.registration_id FROM $DBNAME_UNIVERSITY.registration " .
         "WHERE registration.course_id = $course_id AND registration.participant_type_id = $TYPE_STUDENT";
      $student_result = mysql_query($student_query)
         or die("Student Query failed: " . mysql_error());
      $num_students = mysql_num_rows($student_result);
      mysql_free_result($student_result);

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
      if ($capacity == "")
      {
         $capacity = "&infin;";
      }
      if ($attendance != $FULL_CLASS)
      {
         $attendance = "Open";
      }

      $bgcolor = (($j%2 == 0)? "#DDDDDD": "#EEEEEE");
      if ($course_status_id == $STATUS_CANCELED)
      {
         $bgcolor = "#ff9999";
         $attendance = $course_status;
      }
      else if ($course_status_id == $STATUS_PENDING)
      {
         $bgcolor = "#ffff99";
         $attendance = $course_status;
      }

      if ($prev_start_time != $start_time)
      {
         $add_style = "";
         if ($prev_start_time != "")
         {
             $add_style = "page-break-before: always;";
?>
</table>
<?php
         }
?>
<p style="font-size:14pt;font-weight:bold;<?php echo $add_style; ?>"><?php echo $university_display . format_time($start_time); ?></p>
<table style="border-top:1px solid rgb(0, 0, 0);border-left:1px solid rgb(0, 0, 0);" width="100%" align="center" cellpadding="2" cellspacing="0">
   <tr>
      <th style="font-size:12pt;border-right:0.5px solid rgb(0, 0, 0);border-bottom:0.5px solid rgb(0, 0, 0);text-align:center" width="6%">Room</th>
      <th style="font-size:12pt;border-right:0.5px solid rgb(0, 0, 0);border-bottom:0.5px solid rgb(0, 0, 0);text-align:left" width="40%">Title</th>
      <th style="font-size:12pt;border-right:0.5px solid rgb(0, 0, 0);border-bottom:0.5px solid rgb(0, 0, 0);text-align:center" width="10%">Pre-Registered</th>
      <th style="font-size:12pt;border-right:0.5px solid rgb(0, 0, 0);border-bottom:0.5px solid rgb(0, 0, 0);text-align:left" width="30%">&nbsp;</th>
      <th style="font-size:12pt;border-right:0.5px solid rgb(0, 0, 0);border-bottom:0.5px solid rgb(0, 0, 0);text-align:center" width="10%">Capacity</th>
      <th style="font-size:12pt;border-right:0.5px solid rgb(0, 0, 0);border-bottom:0.5px solid rgb(0, 0, 0);text-align:left" width="4%">Status</th>
   </tr>
<?php
         $prev_start_time = $start_time;
      }
?>
   <tr style="height:36px;">
      <td style="font-size:12pt;border-right:0.5px solid rgb(0, 0, 0);border-bottom:0.5px solid rgb(0, 0, 0);background-color:<?php echo $bgcolor; ?>;text-align:center;vertical-align:top" nowrap="nowrap"><?php echo $room; ?></td>
      <td style="font-size:12pt;border-right:0.5px solid rgb(0, 0, 0);border-bottom:0.5px solid rgb(0, 0, 0);background-color:<?php echo $bgcolor; ?>;text-align:left;vertical-align:top"><?php echo htmlentities($title); ?></td>
      <td style="font-size:12pt;border-right:0.5px solid rgb(0, 0, 0);border-bottom:0.5px solid rgb(0, 0, 0);background-color:<?php echo $bgcolor; ?>;text-align:center;vertical-align:top"><?php echo $num_students; ?></td>
      <td style="font-size:12pt;border-right:0.5px solid rgb(0, 0, 0);border-bottom:0.5px solid rgb(0, 0, 0);background-color:<?php echo $bgcolor; ?>;text-align:center;vertical-align:top">&nbsp;</td>
      <td style="font-size:12pt;border-right:0.5px solid rgb(0, 0, 0);border-bottom:0.5px solid rgb(0, 0, 0);background-color:<?php echo $bgcolor; ?>;text-align:center;vertical-align:top"><?php echo $capacity; ?></td>
      <td style="font-size:12pt;border-right:0.5px solid rgb(0, 0, 0);border-bottom:0.5px solid rgb(0, 0, 0);background-color:<?php echo $bgcolor; ?>;text-align:left;vertical-align:top"><?php echo $attendance; ?></td>
   </tr>
<?php
      $j++;
   }
?>
</table>
<?php
}
mysql_free_result($class_result);
mysql_free_result($result);
db_disconnect($link);
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