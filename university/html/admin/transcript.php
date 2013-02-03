<?php
$title = "My Classes";
include("../header.php");
?>
<h2 style="text-align:center">University Transcript</h2>
<?php
// Verify user is authorized
if (isset($_SESSION['s_username'])) 
{
   /* Connecting, selecting database */
   $link = db_connect();

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
      // Get degree status
      $query = "SELECT participant.*, l.university_code as l_code, l.university_date as l_date, " .
               "b_old.university_code as b_old_code, b_old.university_date as b_old_date, " .
               "b.university_code as b_code, b.university_date as b_date, " .
               "f.university_code as f_code, f.university_date as f_date, " .
               "m.university_code as m_code, m.university_date as m_date, " .
               "d.university_code as d_code, b.university_date as d_date " .
               "FROM $DBNAME_UNIVERSITY.participant " .
               "LEFT OUTER JOIN $DBNAME_UNIVERSITY.university l ON participant.last_university_id = l.university_id " .
               "LEFT OUTER JOIN $DBNAME_UNIVERSITY.university b_old ON participant.b_old_university_id = b_old.university_id " .
               "LEFT OUTER JOIN $DBNAME_UNIVERSITY.university b ON participant.b_university_id = b.university_id " .
               "LEFT OUTER JOIN $DBNAME_UNIVERSITY.university f ON participant.f_university_id = f.university_id " .
               "LEFT OUTER JOIN $DBNAME_UNIVERSITY.university m ON participant.m_university_id = m.university_id " .
               "LEFT OUTER JOIN $DBNAME_UNIVERSITY.university d ON participant.d_university_id = d.university_id " .
               "WHERE participant.$field = $id_value";
      $result = mysql_query($query)
         or die("Participant Query failed: " . $query . "<br/>" . mysql_error());
      $num_participants = mysql_num_rows($result);
      if ($num_participants > 0)
      {
         $data = mysql_fetch_array($result, MYSQL_BOTH);

         $participant_id = clean($data['participant_id']);
         $l_code = clean($data['l_code']);
         $l_date = clean($data['l_date']);
         if ($l_date != "")
         {
            $l_date = format_short_date($l_date);
         }
         $b_old_code = clean($data['b_old_code']);
         $b_old_date = clean($data['b_old_date']);
         if ($b_old_date != "")
         {
            $b_old_date = format_short_date($b_old_date);
         }
         $b_code = clean($data['b_code']);
         $b_date = clean($data['b_date']);
         if ($b_date != "")
         {
            $b_date = format_short_date($b_date);
         }
         $f_code = clean($data['f_code']);
         $f_date = clean($data['f_date']);
         if ($f_date != "")
         {
            $f_date = format_short_date($f_date);
         }
         $m_code = clean($data['m_code']);
         $m_date = clean($data['m_date']);
         if ($m_date != "")
         {
            $m_date = format_short_date($m_date);
         }
         $d_code = clean($data['d_code']);
         $d_date = clean($data['d_date']);
         if ($d_date != "")
         {
            $d_date = format_short_date($d_date);
         }
         // Output 
         if ($l_code != "")
         {
?>
<p style="text-align:center"><b>Last University Session Attended:</b> <?php echo "$l_code - $l_date"; ?></p>
<?php
         }
         if ($b_old_code != "" || $b_code != "" || $f_code != "" || $m_code != "" || $d_code != "")
         {
?>
<h3 style="text-align:center">Degrees Earned</h3>
<table cellpadding="5" cellspacing="0" align="center">
<?php
            if ($b_old_code != "")
            {
?>
   <tr>
      <th>Original Bachelors Degree</th><td><?php echo "$b_old_code - $b_old_date"; ?></td>
   </tr>
<?php
            }
            if ($b_code != "")
            {
?>
   <tr>
      <th>Bachelors Degree</th><td><?php echo "$b_code - $b_date"; ?></td>
   </tr>
<?php
            }
            if ($f_code != "")
            {
?>
   <tr>
      <th>Fellowship</th><td><?php echo "$f_code - $f_date"; ?></td>
   </tr>
<?php
            }
            if ($m_code != "")
            {
?>
   <tr>
      <th>Masters Degree</th><td><?php echo "$m_code - $m_date"; ?></td>
   </tr>
<?php
            }
            if ($d_code != "")
            {
?>
   <tr>
      <th>Honorary Doctorate</th><td><?php echo "$d_code - $d_date"; ?></td>
   </tr>
<?php
            }
?>
</table>
<?php
         }
         mysql_free_result($result);

         // Retrieve classes
         $query = "SELECT registration.*, participant_type.participant_type, course.course_number, course.title, course.credits, university.university_id, university.university_code, university.university_date " .
                  "FROM $DBNAME_UNIVERSITY.registration JOIN $DBNAME_UNIVERSITY.course ON registration.course_id = course.course_id " .
                  "JOIN $DBNAME_UNIVERSITY.university ON course.university_id = university.university_id " .
                  "JOIN $DBNAME_UNIVERSITY.participant_type ON registration.participant_type_id = participant_type.participant_type_id " .
                  "WHERE registration.participant_id = $participant_id " .
                  "AND registration.registration_status_id = $STATUS_ATTENDED " .
                  "AND course.course_status_id = $STATUS_APPROVED " .
                  "ORDER BY university.university_date, course.course_number";
         $result = mysql_query($query)
            or die("Class Query failed: " . $query . "<br/>" . mysql_error());
         $num_classes = mysql_num_rows($result);
?>
<h3 style="text-align:center">My Classes</h3>
<table cellpadding="5" cellspacing="0" align="center">
<?php
         $j = 1;
         $prev_university_id = 0;
         $total_credits = 0;
         while ($data = mysql_fetch_array($result, MYSQL_BOTH))
         {
            $university_id = clean($data['university_id']);
            $university_code = clean($data['university_code']);
            $university_date = clean($data['university_date']);
            $date_display = format_full_date($university_date);

            $course_id = clean($data['course_id']);
            $course_number = clean($data['course_number']);
            $title = clean($data['title']);
            $credits = clean($data['credits']);
            $total_credits += $credits;
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

            if ($prev_university_id != $university_id)
            {
?>
   <tr><th colspan="5" style="text-align:center;color:<?php echo $accent_color; ?>;background-color:white"><?php echo "$university_code - $date_display"; ?></th></tr>
   <tr>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">#</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Title</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Instructor(s)</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Credits</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Attendance</th>
   </tr>
<?php
               $prev_university_id = $university_id;
            }
?>
   <tr>
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
<p align="center" class="title2">Total: <?php echo $num_classes; ?> class<?php if ($num_classes != 1) { echo "es"; } ?>, <?php echo $total_credits; ?> credit<?php if ($total_credits != 1) { echo "s"; } ?></p>
<?php
         mysql_free_result($result);
      }
      else
      {
         mysql_free_result($result);
?>
<p align="center" class="title2">No classes found.</p>
<?php
      }
   }
   else
   {
?>
<p align="center" class="title2">No classes found.</p>
<?php
   }
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