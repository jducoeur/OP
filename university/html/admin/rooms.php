<?php
include_once("../db/validation_format.php");

$university_id = "";
if (isset($_REQUEST['university_id']))
{
   $university_id = clean($_REQUEST['university_id']);
}

$title = "By Room";
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

$university_display = "University Session #$university_number: Room ";

// Retrieve university session courses
$class_query = "SELECT course.*, room.room FROM $DBNAME_UNIVERSITY.course " .
               "JOIN $DBNAME_UNIVERSITY.room ON course.room_id = room.room_id " .
               "WHERE course.university_id = $university_id " .
               "AND course.course_status_id = $STATUS_APPROVED " .
               "ORDER BY room, start_time, end_time, course_number";
$class_result = mysql_query($class_query)
   or die("Class Query failed : " . mysql_error());
$num_classes = mysql_num_rows($class_result);

if ($num_classes > 0)
{
   $j = 1;
   $prev_room = "";
   while ($class_data = mysql_fetch_array($class_result, MYSQL_BOTH)) 
   {
      $course_id = clean($class_data['course_id']);
      $course_number = clean($class_data['course_number']);
      $title = clean($class_data['title']);
      $room = clean($class_data['room']);
      $start_time = clean($class_data['start_time']);
      $end_time = clean($class_data['end_time']);

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
            if ($i > 0)
            {
               $instructor_display .= "<br/>";
            }
            $instructor_display .= htmlentities(clean($instructor_data['sca_name']));
            $i++;
         }
      }

      $bgcolor = (($j%2 == 0)? "#DDDDDD": "#EEEEEE");

      if ($prev_room != $room)
      {
         if ($prev_room != "")
         {
?>
   </table>
   <p style="page-break-after:always;">&nbsp;</p>
<?php
         }
?>
<p style="font-size:14pt;font-weight:bold;"><?php echo $university_display . $room; ?></p>
<table style="border-top: 1px solid rgb(0, 0, 0);" width="100%" cellpadding="2" cellspacing="0">
   <tr>
      <th style="font-size:12pt;vertical-align:top;text-align:left;">Start Time</th>
      <th style="font-size:12pt;vertical-align:top;text-align:left;">End Time</th>
      <th style="font-size:12pt;vertical-align:top;text-align:left;">Course Number</th>
      <th style="font-size:12pt;vertical-align:top;text-align:left;">Course Title</th>
      <th style="font-size:12pt;vertical-align:top;text-align:left;">Instructor(s)</th>
   </tr>
<?php
         $prev_room = $room;
      }
?>
   <tr>
      <td style="font-size:12pt;vertical-align:top;background-color:<?php echo $bgcolor; ?>;text-align:center;white-space:nowrap;"><?php echo format_time($start_time); ?></td>
      <td style="font-size:12pt;vertical-align:top;background-color:<?php echo $bgcolor; ?>;text-align:center;white-space:nowrap;"><?php echo format_time($end_time); ?></td>
      <td style="font-size:12pt;vertical-align:top;background-color:<?php echo $bgcolor; ?>;text-align:center;white-space:nowrap;"><?php echo $course_number; ?></td>
      <td style="font-size:12pt;vertical-align:top;background-color:<?php echo $bgcolor; ?>;text-align:left;"><?php echo htmlentities($title); ?></td>
      <td style="font-size:12pt;vertical-align:top;background-color:<?php echo $bgcolor; ?>;text-align:left;"><?php echo $instructor_display; ?></td>
   </tr>
<?php
      $j++;
      mysql_free_result($instructor_result);
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