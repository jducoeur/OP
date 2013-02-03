<?php
include_once("../db/validation_format.php");

$university_id = "";
if (isset($_REQUEST['university_id']))
{
   $university_id = clean($_REQUEST['university_id']);
}

$title = "Instructor Rosters";
$printable = 1;
include("../header.php");

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

$query = "SELECT university.* FROM $DBNAME_UNIVERSITY.university " .
         "WHERE is_university = 1 AND publish_date IS NOT NULL AND publish_date <= CURRENT_DATE AND university_id = $university_id";
$result = mysql_query($query)
   or die("University Query failed : " . mysql_error());
$data = mysql_fetch_array($result, MYSQL_BOTH);

$university_code = clean($data['university_code']);
$university_number = substr($university_code, 2);
$university_date = clean($data['university_date']);

// Retrieve university session courses
$class_query = "SELECT course.*, room.* FROM $DBNAME_UNIVERSITY.course " .
               "LEFT OUTER JOIN $DBNAME_UNIVERSITY.room ON course.room_id = room.room_id " .
               "WHERE course.university_id = $university_id " .
               "AND course.course_status_id = $STATUS_APPROVED " .
               "ORDER BY start_time, end_time, course_number";
$class_result = mysql_query($class_query)
   or die("Class Query failed : " . mysql_error());
$num_classes = mysql_num_rows($class_result);

if ($num_classes > 0)
{
   while ($class_data = mysql_fetch_array($class_result, MYSQL_BOTH)) 
   {
      $course_id = clean($class_data['course_id']);
      $course_number = clean($class_data['course_number']);
      $title = clean($class_data['title']);
      $room = clean($class_data['room']);
      $cost = clean($class_data['cost']);
      $cost_display = "None";
      if ($cost != "" && $cost != NULL)
      {
         $cost_display = "$" . $cost;
      }
      $capacity = clean($class_data['capacity']);
      if ($capacity == "" || $capacity == NULL)
      {
         $capacity = "&infin;";
      }
      $title = clean($class_data['title']);
      $requirements = clean($class_data['requirements']);
      $start_time = clean($class_data['start_time']);
      $end_time = clean($class_data['end_time']);
      $time_display = "";
      if ($start_time != "" && $end_time != "")
      {
         $time_display .= format_time($start_time) . " - " . format_time($end_time);
      }

      $student_query = "SELECT registration.registration_id FROM $DBNAME_UNIVERSITY.registration " .
         "WHERE registration.course_id = $course_id AND registration.participant_type_id = $TYPE_STUDENT";
      $student_result = mysql_query($student_query)
         or die("Student Query failed : " . mysql_error());
      $attendance = mysql_num_rows($student_result);
      mysql_free_result($student_result);
?>
<p style="font-size:12pt;text-align:center">University of Atlantia Instructor's Roster<br>for<br>
<b style="font-size:16pt;"><?php echo htmlentities($university_code) . " - " . htmlentities($title) . " - " . htmlentities($course_number); ?></b>
</p>
		    <table style="border-top: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0);" width="100%">
			    <tbody>
             <tr>
				    <th style="font-size:12pt;text-align:left">Room #</td>
				    <th style="font-size:12pt;text-align:left">Start Time</td>
				    <th style="font-size:12pt;text-align:center">Pre-Registered</td>
				    <th style="font-size:12pt;text-align:center">Capacity</td>
				    <th style="font-size:12pt;text-align:left" width="40%">Equipment</td>
				    <th style="font-size:12pt;text-align:">Cost</td>
			    </tr>
			    <tr>
				    <td style="font-size:12pt;text-align:left"><?php echo $room; ?></td>
				    <td style="font-size:12pt;text-align:left"><?php echo format_time($start_time); ?></td>
				    <td style="font-size:12pt;text-align:center"><?php echo $attendance; ?></td>
				    <td style="font-size:12pt;text-align:center"><?php echo $capacity; ?></td>
				    <td style="font-size:12pt;text-align:left"><?php echo $requirements; ?></td>
				    <td style="font-size:12pt;text-align:left"><?php echo $cost_display; ?></td>
			    </tr>
		       </tbody>
          </table>
		    <p style="font-size:12pt;">
		    Instructors: These students have registered for your class. Please take 
		    attendance by placing a check in the Attendance column. Students must 
		    be present for 75% of the class to receive credit. If any students come late 
		    or leave early so that they do not meet this requirement, please note this 
		    on the roster sheet. Please add any additional students to the bottom of the 
		    sheet and return it to the Registration Table after your class.
          <br/><br/>
          If there is a couse materials fee, it is the instructor's responsibility to collect 
		    the fee from students.</p>
		    <p style="font-size:16pt;font-style:italic;text-align:center">
          <span style="font-weight:bold">Please Print Legibly - No Calligraphy</span>
          <br/><br/>
		    Give Complete Legal and SCA Names
          </p>

<table style="border-top: 1px solid rgb(0, 0, 0);page-break-after:always;" width="100%">
   <tr>
      <th style="font-size:12pt;text-align:left">Participant</th>
      <th style="font-size:12pt;text-align:left">SCA Name</th>
      <th style="font-size:12pt;text-align:left">S/I</th>
      <th style="font-size:12pt;text-align:left">Attendance</th>
   </tr>
<?php

      $participant_query = 
         "SELECT participant.participant_id, participant.sca_name, participant_type.participant_type, atlantian.first_name, atlantian.last_name " .
         "FROM $DBNAME_UNIVERSITY.registration " .
         "JOIN $DBNAME_UNIVERSITY.participant ON registration.participant_id = participant.participant_id " .
         "JOIN $DBNAME_UNIVERSITY.participant_type ON registration.participant_type_id = participant_type.participant_type_id " .
         "JOIN $DBNAME_AUTH.atlantian ON participant.atlantian_id = atlantian.atlantian_id " .
         "WHERE registration.course_id = $course_id " .
         "UNION " .
         "SELECT participant.participant_id, participant.sca_name, participant_type.participant_type, user_auth.first_name, user_auth.last_name " .
         "FROM $DBNAME_UNIVERSITY.registration " .
         "JOIN $DBNAME_UNIVERSITY.participant ON registration.participant_id = participant.participant_id " .
         "JOIN $DBNAME_UNIVERSITY.participant_type ON registration.participant_type_id = participant_type.participant_type_id " .
         "JOIN $DBNAME_AUTH.user_auth ON participant.user_id = user_auth.user_id " .
         "WHERE registration.course_id = $course_id " .
         "AND participant.atlantian_id IS NULL " .
         "ORDER BY participant_type, last_name, first_name, sca_name";
      $participant_result = mysql_query($participant_query)
         or die("Participant Query failed : " . mysql_error());
      $num_participant = mysql_num_rows($participant_result);
      $participant_display = "";
      if ($num_participant > 0)
      {
         $j = 0;
         while ($participant_data = mysql_fetch_array($participant_result, MYSQL_BOTH))
         {
            $participant_type = htmlentities(clean($participant_data['participant_type']));
            $first_name = clean($participant_data['first_name']);
            $last_name = clean($participant_data['last_name']);
            $legal_name = htmlentities($last_name . ", " . $first_name);
            $sca_name = htmlentities(clean($participant_data['sca_name']));

            $bgcolor = (($j%2 == 0)? "#DDDDDD": "#EEEEEE");
?>
   <tr>
      <td style="font-size:12pt;background-color:<?php echo $bgcolor; ?>"><?php echo $legal_name; ?></td>
      <td style="font-size:12pt;background-color:<?php echo $bgcolor; ?>"><?php echo $sca_name; ?></td>
      <td style="font-size:12pt;background-color:<?php echo $bgcolor; ?>"><?php echo $participant_type; ?></td>
      <td style="font-size:12pt;background-color:<?php echo $bgcolor; ?>">&nbsp;</td>
   </tr>
<?php
            $j++;
         }
      }
?>
</table>
<?php
      mysql_free_result($participant_result);
   }
}
mysql_free_result($class_result);
mysql_free_result($result);
db_disconnect($link);

include("../footer.php");
?>