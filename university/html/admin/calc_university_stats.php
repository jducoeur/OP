<?php
// Give the script 5 minutes to run
set_time_limit(300);
include_once("../db/defines.php");
$title = "Calculate Statistics";
include("../header.php");
?>
<h2>Calculate University Statistics</h2>
<?php
// Only appropriate admins allowed
if (isset($_SESSION[$UNIVERSITY_ADMIN]) && $_SESSION[$UNIVERSITY_ADMIN] == 1)
{
/* Connecting, selecting database */
$link = db_admin_connect();

$query = "SELECT university.university_id FROM $DBNAME_UNIVERSITY.university " .
         "WHERE is_university = 1 AND publish_date IS NOT NULL AND publish_date <= CURRENT_DATE AND university_date < CURRENT_DATE " .
         "ORDER BY university_date";
$result = mysql_query($query)
   or die("University Query failed : " . mysql_error());
$num_universities = mysql_num_rows($result);
?>
<p>There are <?php echo $num_universities; ?> university sessions to calculate.</p>
<?php
while ($data = mysql_fetch_array($result, MYSQL_BOTH))
{
   $university_id = clean($data['university_id']);

   $cnt_query = "SELECT COUNT(DISTINCT course_id) as cnt FROM $DBNAME_UNIVERSITY.course WHERE university_id = $university_id AND course_status_id = $STATUS_APPROVED";
   $cnt_result = mysql_query($cnt_query)
      or die("Total Course Count Query failed : " . mysql_error());
   $cnt_data = mysql_fetch_array($cnt_result, MYSQL_BOTH);
   $total_classes = clean($cnt_data['cnt']);
   mysql_free_result($cnt_result);

   $cnt_query = "SELECT COUNT(DISTINCT participant_id) as cnt FROM $DBNAME_UNIVERSITY.registration WHERE course_id IN (SELECT course_id FROM $DBNAME_UNIVERSITY.course WHERE university_id = $university_id AND course_status_id = $STATUS_APPROVED)";
   $cnt_result = mysql_query($cnt_query)
      or die("Total Attendee Query failed : " . mysql_error());
   $cnt_data = mysql_fetch_array($cnt_result, MYSQL_BOTH);
   $total_attendees = clean($cnt_data['cnt']);
   mysql_free_result($cnt_result);

   $cnt_query = "SELECT COUNT(DISTINCT participant_id) as cnt FROM $DBNAME_UNIVERSITY.registration WHERE participant_type_id = $TYPE_STUDENT AND course_id IN (SELECT course_id FROM $DBNAME_UNIVERSITY.course WHERE university_id = $university_id AND course_status_id = $STATUS_APPROVED)";
   $cnt_result = mysql_query($cnt_query)
      or die("Total Students Query failed : " . mysql_error());
   $cnt_data = mysql_fetch_array($cnt_result, MYSQL_BOTH);
   $total_students = clean($cnt_data['cnt']);
   mysql_free_result($cnt_result);

   $cnt_query = "SELECT COUNT(DISTINCT participant_id) as cnt FROM $DBNAME_UNIVERSITY.registration WHERE participant_type_id = $TYPE_INSTRUCTOR AND course_id IN (SELECT course_id FROM $DBNAME_UNIVERSITY.course WHERE university_id = $university_id AND course_status_id = $STATUS_APPROVED)";
   $cnt_result = mysql_query($cnt_query)
      or die("Total Teachers Query failed : " . mysql_error());
   $cnt_data = mysql_fetch_array($cnt_result, MYSQL_BOTH);
   $total_teachers = clean($cnt_data['cnt']);
   mysql_free_result($cnt_result);

   $cnt_query = "SELECT COUNT(DISTINCT participant_id) as cnt FROM $DBNAME_UNIVERSITY.registration WHERE course_id IN (SELECT course_id FROM $DBNAME_UNIVERSITY.course WHERE university_id = $university_id AND course_status_id = $STATUS_APPROVED) " .
      "AND participant_id NOT IN (SELECT DISTINCT participant_id FROM $DBNAME_UNIVERSITY.registration WHERE registration_status_id = $STATUS_ATTENDED AND course_id IN " .
      "(SELECT course_id FROM $DBNAME_UNIVERSITY.course WHERE course_status_id = $STATUS_APPROVED AND university_id != $university_id " .
      "AND university_id IN (SELECT university_id FROM $DBNAME_UNIVERSITY.university WHERE is_university = 1 AND publish_date IS NOT NULL AND publish_date <= CURRENT_DATE AND university_date < CURRENT_DATE))) ";
   $cnt_result = mysql_query($cnt_query)
      or die("Total Newcomers Query failed : " . mysql_error());
   $cnt_data = mysql_fetch_array($cnt_result, MYSQL_BOTH);
   $total_newcomers = clean($cnt_data['cnt']);
   mysql_free_result($cnt_result);

   $university_update = "UPDATE $DBNAME_UNIVERSITY.university SET total_classes = $total_classes, total_students = $total_students, total_teachers = $total_teachers, total_attendees = $total_attendees, total_newcomers = $total_newcomers WHERE university_id = $university_id";
   $university_result = mysql_query($university_update)
      or die("University Update failed : " . mysql_error());

   $stats_delete = "DELETE FROM $DBNAME_UNIVERSITY.university_statistics WHERE university_id = $university_id";
   $stats_delete_result = mysql_query($stats_delete)
      or die("Statistics Delete failed : " . mysql_error());

   $course_category_query = "SELECT * FROM $DBNAME_UNIVERSITY.course_category ORDER BY course_category_id";
   $course_category_result = mysql_query($course_category_query)
      or die("Course Category Query failed : " . mysql_error());

   while ($course_category_data = mysql_fetch_array($course_category_result, MYSQL_BOTH))
   {
      $course_category_id = clean($course_category_data['course_category_id']);
      $course_category_code = clean($course_category_data['course_category_code']);
      $cnt_query = "SELECT COUNT(*) as cnt FROM $DBNAME_UNIVERSITY.course WHERE university_id = $university_id AND course_status_id = $STATUS_APPROVED AND course_category_id = $course_category_id";
      $cnt_result = mysql_query($cnt_query)
         or die("Total $course_category_code Course Count Query failed : " . mysql_error());
      $cnt_data = mysql_fetch_array($cnt_result, MYSQL_BOTH);
      $total_cnt = clean($cnt_data['cnt']);

      $stats_insert = "INSERT INTO $DBNAME_UNIVERSITY.university_statistics (university_id, course_category_id, total_classes) VALUES ($university_id, $course_category_id, $total_cnt)";
      $stats_result = mysql_query($stats_insert)
         or die("University Statistics Insert failed : " . mysql_error());
   }
   mysql_free_result($course_category_result);
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
