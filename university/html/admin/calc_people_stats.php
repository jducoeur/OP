<?php
// Give the script 5 minutes to run
set_time_limit(600);
include_once("../db/defines.php");
$title = "Calculate Statistics";
include("../header.php");
?>
<h2>Calculate Participant Statistics</h2>
<?php
// Only appropriate admins allowed
if (isset($_SESSION[$UNIVERSITY_ADMIN]) && $_SESSION[$UNIVERSITY_ADMIN] == 1)
{
/* Connecting, selecting database */
$link = db_admin_connect();

$query = "SELECT participant_id, last_university_id, b_university_id, b_degree_status_id, f_university_id, f_degree_status_id, m_university_id, m_degree_status_id " .
         "FROM $DBNAME_UNIVERSITY.participant ORDER BY participant_id";
$result = mysql_query($query)
   or die("Participant ID Query failed : " . $query . "<br/>" . mysql_error());
$num_participants = mysql_num_rows($result);
?>
<p>There are <?php echo $num_participants; ?> participants to calculate.</p>
<?php
while ($data = mysql_fetch_array($result, MYSQL_BOTH))
{
   $participant_id = clean($data['participant_id']);
   $last_university_id = clean($data['last_university_id']);
   $b_university_id = clean($data['b_university_id']);
   $b_degree_status_id = clean($data['b_degree_status_id']);
   $f_university_id = clean($data['f_university_id']);
   $f_degree_status_id = clean($data['f_degree_status_id']);
   $m_university_id = clean($data['m_university_id']);
   $m_degree_status_id = clean($data['m_degree_status_id']);

    //echo "<br/>DEBUG: participant_id: $participant_id<br/>";

   // Initialize counts
   $total_university_classes_taught = 0;
   $total_university_credits_taught = 0;
   $total_universities_taught = 0;
   $total_university_classes_taken = 0;
   $total_university_credits_taken = 0;
   $total_collegium_classes_taught = 0;
   $total_collegium_credits_taught = 0;
   $total_collegium_classes_taken = 0;
   $total_collegium_credits_taken = 0;
   $total_university_classes = $total_university_classes_taught + $total_university_classes_taken;
   $total_collegium_classes = $total_collegium_classes_taught + $total_collegium_classes_taken;
   $total_classes = $total_university_classes + $total_collegium_classes;
   $total_university_credits = $total_university_credits_taught + $total_university_credits_taken;
   $total_collegium_credits = $total_collegium_credits_taught + $total_collegium_credits_taken;
   $total_credits = $total_university_credits + $total_collegium_credits;

   /* University Classes Taught */
   $cnt_query = "SELECT COUNT(registration.registration_id) as cnt, IFNULL(SUM(course.credits), 0) as credits, COUNT(DISTINCT university.university_id) as num_univ " .
                "FROM $DBNAME_UNIVERSITY.registration JOIN $DBNAME_UNIVERSITY.course ON registration.course_id = course.course_id " .
                "JOIN $DBNAME_UNIVERSITY.university ON course.university_id = university.university_id " .
                "WHERE registration.participant_id = $participant_id " .
                "AND registration.registration_status_id = $STATUS_ATTENDED AND registration.participant_type_id = $TYPE_INSTRUCTOR " .
                "AND course.course_status_id = $STATUS_APPROVED " .
                "AND university.is_university = 1 AND university.university_date < CURRENT_DATE " .
                "AND university.publish_date IS NOT NULL AND university.publish_date <= CURRENT_DATE";
   $cnt_result = mysql_query($cnt_query)
      or die("Total University Classes Taught Count Query failed : " . $cnt_query . "<br/>" . mysql_error());
   $cnt_data = mysql_fetch_array($cnt_result, MYSQL_BOTH);
   $total_university_classes_taught = clean($cnt_data['cnt']);
   $total_university_credits_taught = clean($cnt_data['credits']);
   $total_universities_taught = clean($cnt_data['num_univ']);
   mysql_free_result($cnt_result);

   /* University Classes Taken */
   $cnt_query = "SELECT COUNT(registration.registration_id) as cnt, IFNULL(SUM(course.credits), 0) as credits " .
                "FROM $DBNAME_UNIVERSITY.registration JOIN $DBNAME_UNIVERSITY.course ON registration.course_id = course.course_id " .
                "JOIN $DBNAME_UNIVERSITY.university ON course.university_id = university.university_id " .
                "WHERE registration.participant_id = $participant_id " .
                "AND registration.registration_status_id = $STATUS_ATTENDED AND registration.participant_type_id = $TYPE_STUDENT " .
                "AND course.course_status_id = $STATUS_APPROVED " .
                "AND university.is_university = 1 AND university.university_date < CURRENT_DATE " .
                "AND university.publish_date IS NOT NULL AND university.publish_date <= CURRENT_DATE";
   $cnt_result = mysql_query($cnt_query)
      or die("Total University Classes Taken Count Query failed : " . $cnt_query . "<br/>" . mysql_error());
   $cnt_data = mysql_fetch_array($cnt_result, MYSQL_BOTH);
   $total_university_classes_taken = clean($cnt_data['cnt']);
   $total_university_credits_taken = clean($cnt_data['credits']);
   mysql_free_result($cnt_result);

   /* Collegium Classes Taught */
   $cnt_query = "SELECT COUNT(registration.registration_id) as cnt, IFNULL(SUM(course.credits), 0) as credits " .
                "FROM $DBNAME_UNIVERSITY.registration JOIN $DBNAME_UNIVERSITY.course ON registration.course_id = course.course_id " .
                "JOIN $DBNAME_UNIVERSITY.university ON course.university_id = university.university_id " .
                "WHERE registration.participant_id = $participant_id " .
                "AND registration.registration_status_id = $STATUS_ATTENDED AND registration.participant_type_id = $TYPE_INSTRUCTOR " .
                "AND course.course_status_id = $STATUS_APPROVED " .
                "AND university.is_university = 0 AND university.university_date < CURRENT_DATE " .
                "AND university.publish_date IS NOT NULL AND university.publish_date <= CURRENT_DATE";
   $cnt_result = mysql_query($cnt_query)
      or die("Total Collegium Classes Taught Count Query failed : " . $cnt_query . "<br/>" . mysql_error());
   $cnt_data = mysql_fetch_array($cnt_result, MYSQL_BOTH);
   $total_collegium_classes_taught = clean($cnt_data['cnt']);
   $total_collegium_credits_taught = clean($cnt_data['credits']);
   mysql_free_result($cnt_result);

   /* Collegium Classes Taken */
   $cnt_query = "SELECT COUNT(registration.registration_id) as cnt, IFNULL(SUM(course.credits), 0) as credits " .
                "FROM $DBNAME_UNIVERSITY.registration JOIN $DBNAME_UNIVERSITY.course ON registration.course_id = course.course_id " .
                "JOIN $DBNAME_UNIVERSITY.university ON course.university_id = university.university_id " .
                "WHERE registration.participant_id = $participant_id " .
                "AND registration.registration_status_id = $STATUS_ATTENDED AND registration.participant_type_id = $TYPE_STUDENT " .
                "AND course.course_status_id = $STATUS_APPROVED " .
                "AND university.is_university = 0 AND university.university_date < CURRENT_DATE " .
                "AND university.publish_date IS NOT NULL AND university.publish_date <= CURRENT_DATE";
   $cnt_result = mysql_query($cnt_query)
      or die("Total Collegium Classes Taken Count Query failed : " . $cnt_query . "<br/>" . mysql_error());
   $cnt_data = mysql_fetch_array($cnt_result, MYSQL_BOTH);
   $total_collegium_classes_taken = clean($cnt_data['cnt']);
   $total_collegium_credits_taken = clean($cnt_data['credits']);
   mysql_free_result($cnt_result);

   $total_university_classes = $total_university_classes_taught + $total_university_classes_taken;
   $total_collegium_classes = $total_collegium_classes_taught + $total_collegium_classes_taken;
   $total_classes = $total_university_classes + $total_collegium_classes;

   $total_university_credits = $total_university_credits_taught + $total_university_credits_taken;
   $total_collegium_credits = $total_collegium_credits_taught + $total_collegium_credits_taken;
   $total_credits = $total_university_credits + $total_collegium_credits;

   /* Determine last university attended */
   $cnt_query = "SELECT IFNULL(MAX(university.university_id), 0) as university_id " .
                "FROM $DBNAME_UNIVERSITY.registration JOIN $DBNAME_UNIVERSITY.course ON registration.course_id = course.course_id " .
                "JOIN $DBNAME_UNIVERSITY.university ON course.university_id = university.university_id " .
                "WHERE registration.participant_id = $participant_id " .
                "AND registration.registration_status_id = $STATUS_ATTENDED " .
                "AND course.course_status_id = $STATUS_APPROVED " .
                "AND university.is_university = 1 AND university.university_date < CURRENT_DATE " .
                "AND university.publish_date IS NOT NULL AND university.publish_date <= CURRENT_DATE";
   $cnt_result = mysql_query($cnt_query)
      or die("Last University Attended Query failed : " . $cnt_query . "<br/>" . mysql_error());
   $cnt_data = mysql_fetch_array($cnt_result, MYSQL_BOTH);
   $new_last_university_id = clean($cnt_data['university_id']);
   mysql_free_result($cnt_result);

   $last_update_clause = "";
   if ($new_last_university_id > 0)
   {
      $last_update_clause .= ", last_university_id = $new_last_university_id";
   }

   /* Determine if degree requirements are met */
   $new_b_degree_status_id = "";
   $new_b_university_id = "";
   $new_f_degree_status_id = "";
   $new_f_university_id = "";
   $new_m_degree_status_id = "";
   $new_m_university_id = "";
   $degree_update_clause = "";

   // Bachelors degree
   $total_bachelor_credits = $total_university_credits_taken + $total_collegium_credits_taken;
   if ($total_bachelor_credits >= $BACHELOR_CREDITS && 
      (($b_university_id == "" && $b_degree_status_id == "") || ($b_university_id > 0 && $b_degree_status_id == $STATUS_EARNED)))
   {
      $new_b_degree_status_id = $STATUS_EARNED;
      $degree_update_clause .= ", b_degree_status_id = $new_b_degree_status_id";
      //echo "DEBUG: Earned new_b_degree_status_id: $new_b_degree_status_id<br/>";

      // Determine University at which degree was earned
      $cnt_query = "SELECT registration.participant_id, course.course_id, course.start_time, course.credits, university.university_id, university.university_date " .
                   "FROM $DBNAME_UNIVERSITY.registration JOIN $DBNAME_UNIVERSITY.course ON registration.course_id = course.course_id " .
                   "JOIN $DBNAME_UNIVERSITY.university ON course.university_id = university.university_id " .
                   "WHERE registration.participant_id = $participant_id " .
                   "AND registration.registration_status_id = $STATUS_ATTENDED AND registration.participant_type_id = $TYPE_STUDENT " .
                   "AND course.course_status_id = $STATUS_APPROVED " .
                   "AND university.is_university = 0 AND university.university_date < CURRENT_DATE " .
                   "AND university.publish_date IS NOT NULL AND university.publish_date <= CURRENT_DATE " .
                   "UNION " .
                   "SELECT registration.participant_id, course.course_id, course.start_time, course.credits, university.university_id, university.university_date " .
                   "FROM $DBNAME_UNIVERSITY.registration JOIN $DBNAME_UNIVERSITY.course ON registration.course_id = course.course_id " .
                   "JOIN $DBNAME_UNIVERSITY.university ON course.university_id = university.university_id " .
                   "WHERE registration.participant_id = $participant_id " .
                   "AND registration.registration_status_id = $STATUS_ATTENDED " .
                   "AND course.course_status_id = $STATUS_APPROVED " .
                   "AND university.is_university = 1 AND university.university_date < CURRENT_DATE " .
                   "AND university.publish_date IS NOT NULL AND university.publish_date <= CURRENT_DATE " .
                   "ORDER BY university_date, start_time";
      $cnt_result = mysql_query($cnt_query)
         or die("Bachelor Degree University Query failed : " . $cnt_query . "<br/>" . mysql_error());

      $credit_cnt = 0;
      $new_b_university_id = 0;
      while ($new_b_university_id == 0 && $cnt_data = mysql_fetch_array($cnt_result, MYSQL_BOTH))
      {
         $credits = clean($cnt_data['credits']);
         $credit_cnt += $credits;
         if ($credit_cnt >= $BACHELOR_CREDITS)
         {
            $new_b_university_id = clean($cnt_data['university_id']);
            //echo "DEBUG: Earned new_b_university_id: $new_b_university_id<br/>";
            $new_b_university_id = get_next_university($new_b_university_id);
            //echo "DEBUG: Awarded new_b_university_id: $new_b_university_id<br/>";
            if ($new_b_university_id > 0)
            {
               $degree_update_clause .= ", b_university_id = $new_b_university_id";
            }
         }
      }
      mysql_free_result($cnt_result);
   }

   // Fellowship
   if ($total_universities_taught >= $FELLOWSHIP_UNIVERSITIES && 
      (($f_university_id == "" && $f_degree_status_id == "") || ($f_university_id > 0 && $f_degree_status_id == $STATUS_EARNED)))
   {
      $new_f_degree_status_id = $STATUS_EARNED;
      $degree_update_clause .= ", f_degree_status_id = $new_f_degree_status_id";
      //echo "DEBUG: Earned new_f_degree_status_id: $new_f_degree_status_id<br/>";

      // Determine University at which degree was earned
      $cnt_query = "SELECT DISTINCT university.university_id, university.university_date " .
                   "FROM $DBNAME_UNIVERSITY.registration JOIN $DBNAME_UNIVERSITY.course ON registration.course_id = course.course_id " .
                   "JOIN $DBNAME_UNIVERSITY.university ON course.university_id = university.university_id " .
                   "WHERE registration.participant_id = $participant_id " .
                   "AND registration.registration_status_id = $STATUS_ATTENDED AND registration.participant_type_id = $TYPE_INSTRUCTOR " .
                   "AND course.course_status_id = $STATUS_APPROVED " .
                   "AND university.is_university = 1 AND university.university_date < CURRENT_DATE " .
                   "AND university.publish_date IS NOT NULL AND university.publish_date <= CURRENT_DATE " .
                   "ORDER BY university.university_date LIMIT $FELLOWSHIP_UNIVERSITIES";
      $cnt_result = mysql_query($cnt_query)
         or die("Fellowship University Query failed : " . $cnt_query . "<br/>" . mysql_error());
      $num_rows = mysql_num_rows($cnt_result);
      //echo "DEBUG: Earned Fellowship Universities: $num_rows<br/>";

      if ($num_rows == $FELLOWSHIP_UNIVERSITIES)
      {
         $loop_cnt = 1;
         $new_f_university_id = 0;
         while ($loop_cnt <= $FELLOWSHIP_UNIVERSITIES && $cnt_data = mysql_fetch_array($cnt_result, MYSQL_BOTH))
         {
            if ($loop_cnt == $FELLOWSHIP_UNIVERSITIES)
            {
               $new_f_university_id = clean($cnt_data['university_id']);
               //echo "DEBUG: Earned new_f_university_id: $new_f_university_id<br/>";
               $new_f_university_id = get_next_university($new_f_university_id);
               //echo "DEBUG: Awarded new_f_university_id: $new_f_university_id<br/>";
               if ($new_f_university_id > 0)
               {
                  $degree_update_clause .= ", f_university_id = $new_f_university_id";
               }
            }
            $loop_cnt++;
         }
      }
      mysql_free_result($cnt_result);
   }

   // Masters degree
   if (($b_university_id != "" || $new_b_university_id > 0) && 
       ($f_university_id != "" || $new_f_university_id > 0) && $m_degree_status_id == $STATUS_EARNED)
   {
      $new_m_degree_status_id = $STATUS_EARNED;
      $degree_update_clause .= ", m_degree_status_id = $new_m_degree_status_id";

      // Determine University at which degree was earned
      $b_univ = $b_university_id;
      if ($new_b_university_id != "" && $new_b_university_id > 0)
      {
         $b_univ = $new_b_university_id;
      }
      $f_univ = $f_university_id;
      if ($new_f_university_id != "" && $new_f_university_id > 0)
      {
         $f_univ = $new_f_university_id;
      }
      //echo "DEBUG: Awarded b_univ: $b_univ - f_univ: $f_univ<br/>";
      $new_m_university_id = max($b_univ, $f_univ);
      //echo "DEBUG: Awarded new_m_university_id: $new_m_university_id<br/>";
      $degree_update_clause .= ", m_university_id = $new_m_university_id";
   }

   /* Update participant */
   $participant_update = "UPDATE $DBNAME_UNIVERSITY.participant SET " .
                         "total_university_classes_taught = $total_university_classes_taught, " .
                         "total_university_classes_taken = $total_university_classes_taken, " .
                         "total_collegium_classes_taught = $total_collegium_classes_taught, " .
                         "total_collegium_classes_taken = $total_collegium_classes_taken, " .
                         "total_university_classes = $total_university_classes, " .
                         "total_collegium_classes = $total_collegium_classes, " .
                         "total_university_credits_taught = $total_university_credits_taught, " .
                         "total_university_credits_taken = $total_university_credits_taken, " .
                         "total_collegium_credits_taught = $total_collegium_credits_taught, " .
                         "total_collegium_credits_taken = $total_collegium_credits_taken, " .
                         "total_university_credits = $total_university_credits, " .
                         "total_collegium_credits = $total_collegium_credits, " .
                         "total_credits = $total_credits, " .
                         "total_classes = $total_classes " .
                         $last_update_clause .
                         $degree_update_clause .
                         " WHERE participant_id = $participant_id";
   $participant_result = mysql_query($participant_update)
      or die("Participant Update failed : " . $participant_update . "<br/>" . mysql_error());
}
mysql_free_result($result);
db_disconnect($link);
?>
<p>Statistics calculated.</p>
<?php
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
