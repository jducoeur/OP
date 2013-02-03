<?php
include_once("../db/validation_format.php");

$university_id = "";
if (isset($_REQUEST['university_id']))
{
   $university_id = clean($_REQUEST['university_id']);
}

$title = "Student Schedules";
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

// Retrieve university session participants
$participant_query = 
   "SELECT participant.participant_id, participant.sca_name, atlantian.first_name, atlantian.last_name " .
   "FROM $DBNAME_UNIVERSITY.participant " .
   "JOIN $DBNAME_UNIVERSITY.registration ON participant.participant_id = registration.participant_id " .
   "JOIN $DBNAME_UNIVERSITY.course ON registration.course_id = course.course_id " .
   "JOIN $DBNAME_AUTH.atlantian ON participant.atlantian_id = atlantian.atlantian_id " .
   "WHERE course.university_id = $university_id " .
   "UNION " .
   "SELECT participant.participant_id, participant.sca_name, user_auth.first_name, user_auth.last_name " .
   "FROM $DBNAME_UNIVERSITY.participant " .
   "JOIN $DBNAME_UNIVERSITY.registration ON participant.participant_id = registration.participant_id " .
   "JOIN $DBNAME_UNIVERSITY.course ON registration.course_id = course.course_id " .
   "JOIN $DBNAME_AUTH.user_auth ON participant.user_id = user_auth.user_id " .
   "WHERE course.university_id = $university_id " .
   "AND participant.atlantian_id IS NULL " .
   "ORDER BY last_name, first_name, sca_name";
$participant_result = mysql_query($participant_query)
   or die("Participant Query failed : " . mysql_error());
$num_participants = mysql_num_rows($participant_result);

if ($num_participants > 0)
{
   while ($participant_data = mysql_fetch_array($participant_result, MYSQL_BOTH)) 
   {
      $participant_id = clean($participant_data['participant_id']);
      $first_name = clean($participant_data['first_name']);
      $last_name = clean($participant_data['last_name']);
      $legal_name = $first_name . " " . $last_name;
      if ($legal_name == " ")
      {
         $legal_name == "(Unknown)";
      }
      $sca_name = clean($participant_data['sca_name']);
?>
<p style="font-size:12pt;text-align:center">
<b style="font-size:16pt;">University of Atlantia <?php echo $university_code; ?>: Class Schedule</b><br/>for<br/>
<b style="font-size:14pt;"><?php echo htmlentities($legal_name); ?></b><br/><br/>
known in the SCA as<br/><br/>
<b style="font-size:14pt;"><?php echo htmlentities($sca_name); ?></b>
</p>
<p style="font-size:12pt;text-align:center">
Thank you for pre-registering for classes.  You have avoided waiting in a long line by doing so.<br/><br/>
You do not need to check in at the Registration desk unless you want to make a change to your schedule.
</p>

<table style="border-top: 1px solid rgb(0, 0, 0);" width="100%" cellpadding="5" cellspacing="0">
   <tr>
      <th style="font-size:12pt;text-align:left;white-space:nowrap">Room #</td>
      <th style="font-size:12pt;text-align:left;white-space:nowrap">Start</td>
      <th style="font-size:12pt;text-align:left;white-space:nowrap">End</td>
      <th style="font-size:12pt;text-align:left">Title</td>
      <th style="font-size:12pt;text-align:left;white-space:nowrap">Status</td>
      <th style="font-size:12pt;text-align:left;white-space:nowrap">S/I</td>
      <th style="font-size:12pt;text-align:left;white-space:nowrap">Fees</td>
   </tr>
<?php
      $class_query = "SELECT course.*, room.room, participant_type.participant_type_id, participant_type.participant_type, registration_status.registration_status " .
               "FROM $DBNAME_UNIVERSITY.course " .
               "JOIN $DBNAME_UNIVERSITY.registration ON course.course_id = registration.course_id " .
               "JOIN $DBNAME_UNIVERSITY.participant_type ON registration.participant_type_id = participant_type.participant_type_id " .
               "JOIN $DBNAME_UNIVERSITY.registration_status ON registration.registration_status_id = registration_status.registration_status_id " .
               "LEFT OUTER JOIN $DBNAME_UNIVERSITY.room ON course.room_id = room.room_id " .
               "WHERE registration.participant_id = $participant_id " .
               "AND course.university_id = $university_id " .
               "AND course.course_status_id IN ($STATUS_APPROVED, $STATUS_CANCELED) " .
               "ORDER BY course_status_id, start_time, end_time, course_number";
      $class_result = mysql_query($class_query)
         or die("Class Query failed : " . mysql_error());
      $num_classes = mysql_num_rows($class_result);

      $total_cost = 0;
      $total_classes = 0;
      if ($num_classes > 0)
      {
         $j = 0;
         while ($class_data = mysql_fetch_array($class_result, MYSQL_BOTH))
         {
            $course_id = clean($class_data['course_id']);
            $course_number = clean($class_data['course_number']);
            $title = clean($class_data['title']);
            $room = clean($class_data['room']);
            $participant_type_id = clean($class_data['participant_type_id']);
            $participant_type = htmlentities(clean($class_data['participant_type']));
            $course_status_id = clean($class_data['course_status_id']);
            $cost = clean($class_data['cost']);
            $cost_display = "None";
            if ($cost != "" && $cost != NULL)
            {
               if ($participant_type_id == $TYPE_STUDENT && $course_status_id == $STATUS_APPROVED)
               {
                  $cost_display = format_money($cost);
                  $total_cost += $cost;
               }
            }
            $title = clean($class_data['title']);
            $start_time = clean($class_data['start_time']);
            $end_time = clean($class_data['end_time']);
            $registration_status = htmlentities(clean($class_data['registration_status']));
            if ($course_status_id == $STATUS_CANCELED)
            {
               $registration_status = "Canceled";
            }
            else
            {
               $total_classes++;
            }

            $bgcolor = (($j%2 == 0)? "#DDDDDD": "#EEEEEE");
?>
   <tr>
      <td style="font-size:12pt;text-align:left;vertical-align:top;white-space:nowrap"><?php echo $room; ?></td>
      <td style="font-size:12pt;text-align:left;vertical-align:top;white-space:nowrap"><?php echo format_time($start_time); ?></td>
      <td style="font-size:12pt;text-align:left;vertical-align:top;white-space:nowrap"><?php echo format_time($end_time); ?></td>
      <td style="font-size:12pt;text-align:left;vertical-align:top;"><?php echo $title; ?></td>
      <td style="font-size:12pt;text-align:left;vertical-align:top;white-space:nowrap"><?php echo $registration_status; ?></td>
      <td style="font-size:12pt;text-align:left;vertical-align:top;white-space:nowrap"><?php echo $participant_type; ?></td>
      <td style="font-size:12pt;text-align:left;vertical-align:top;white-space:nowrap"><?php echo $cost_display; ?></td>
   </tr>
<?php
            $j++;
         }
      }
?>
</table>
<p style="font-size:12pt;text-align:center;">You are registered for <?php echo $total_classes; ?> class<?php if ($total_classes != 1) { echo "es"; } ?>.</p>
<p style="font-size:12pt;text-align:center;page-break-after:always;">
<?php
      if ($total_cost == 0)
      {
         echo "There are no fees for your currently registered classes.";
      }
      else
      {
         echo "Your class fees total " . format_money($total_cost) . " for your currently registered classes.";
      }
?>
</p>
<?php
      mysql_free_result($class_result);
   }
}
mysql_free_result($participant_result);
mysql_free_result($result);
db_disconnect($link);

include("../footer.php");
?>