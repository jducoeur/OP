<?php
include_once("../db/defines.php");
$title = "Duplicate Processing";
include("../header.php");

function min_val($val1, $val2)
{
   $retval = NULL;
   if ($val1 != NULL && $val1 != "")
   {
      if ($val2 != NULL && $val2 != "")
      {
         $retval = min($val1, $val2);
      }
      else
      {
         $retval = $val1;
      }
   }
   else if ($val2 != NULL && $val2 != "")
   {
      $retval = $val2;
   }
   return $retval;
}

function max_val($val1, $val2)
{
   $retval = NULL;
   if ($val1 != NULL && $val1 != "")
   {
      if ($val2 != NULL && $val2 != "")
      {
         $retval = max($val1, $val2);
      }
      else
      {
         $retval = $val1;
      }
   }
   else if ($val2 != NULL && $val2 != "")
   {
      $retval = $val2;
   }
   return $retval;
}

function min_val0($val1, $val2)
{
   $retval = 0;
   if ($val1 != NULL && $val1 != "")
   {
      if ($val2 != NULL && $val2 != "")
      {
         $retval = min($val1, $val2);
      }
      else
      {
         $retval = $val1;
      }
   }
   else if ($val2 != NULL && $val2 != "")
   {
      $retval = $val2;
   }
   return $retval;
}

function max_val0($val1, $val2)
{
   $retval = 0;
   if ($val1 != NULL && $val1 != "")
   {
      if ($val2 != NULL && $val2 != "")
      {
         $retval = max($val1, $val2);
      }
      else
      {
         $retval = $val1;
      }
   }
   else if ($val2 != NULL && $val2 != "")
   {
      $retval = $val2;
   }
   return $retval;
}
?>
<h2>Duplicate Processing</h2>
<?php
// Only appropriate admins allowed
if (isset($_SESSION[$UNIVERSITY_ADMIN]) && $_SESSION[$UNIVERSITY_ADMIN] == 1)
{
   /* Connecting, selecting database */
   $link = db_admin_connect();

   // Duplicate Atlantian Participants
   $query = "SELECT participant.* FROM $DBNAME_UNIVERSITY.participant " .
            "WHERE atlantian_id in (SELECT atlantian_id FROM " .
            "(SELECT atlantian_id, COUNT(atlantian_id) FROM $DBNAME_UNIVERSITY.participant GROUP BY atlantian_id HAVING COUNT(atlantian_id) > 1) AS dup) " .
            "ORDER BY atlantian_id, participant_id";
   $result = mysql_query($query)
      or die("Participant ID Query failed : " . $query . "<br/>" . mysql_error());

   while ($data = mysql_fetch_array($result, MYSQL_BOTH))
   {
      // First row
      $atlantian_id = clean($data['atlantian_id']);

      $university_participant_id = clean($data['university_participant_id']);
      $participant_id = clean($data['participant_id']);
      $last_university_id = clean($data['last_university_id']);
      $b_old_university_id = clean($data['b_old_university_id']);
      $b_old_degree_status_id = clean($data['b_old_degree_status_id']);
      $b_university_id = clean($data['b_university_id']);
      $b_degree_status_id = clean($data['b_degree_status_id']);
      $f_university_id = clean($data['f_university_id']);
      $f_degree_status_id = clean($data['f_degree_status_id']);
      $m_university_id = clean($data['m_university_id']);
      $m_degree_status_id = clean($data['m_degree_status_id']);
      $d_university_id = clean($data['d_university_id']);
      $d_degree_status_id = clean($data['d_degree_status_id']);
      $total_university_classes_taught = clean($data['total_university_classes_taught']);
      $total_university_credits_taught = clean($data['total_university_credits_taught']);
      $total_university_classes_taken = clean($data['total_university_classes_taken']);
      $total_university_credits_taken = clean($data['total_university_credits_taken']);
      $total_university_classes = clean($data['total_university_classes']);
      $total_university_credits = clean($data['total_university_credits']);
      $total_classes = clean($data['total_classes']);
      $total_credits = clean($data['total_credits']);

      // Second row
      $data2 = mysql_fetch_array($result, MYSQL_BOTH);
      $university_participant_id2 = clean($data2['university_participant_id']);
      $participant_id2 = clean($data2['participant_id']);
      $last_university_id2 = clean($data2['last_university_id']);
      $b_old_university_id2 = clean($data2['b_old_university_id']);
      $b_old_degree_status_id2 = clean($data2['b_old_degree_status_id']);
      $b_university_id2 = clean($data2['b_university_id']);
      $b_degree_status_id2 = clean($data2['b_degree_status_id']);
      $f_university_id2 = clean($data2['f_university_id']);
      $f_degree_status_id2 = clean($data2['f_degree_status_id']);
      $m_university_id2 = clean($data2['m_university_id']);
      $m_degree_status_id2 = clean($data2['m_degree_status_id']);
      $d_university_id2 = clean($data2['d_university_id']);
      $d_degree_status_id2 = clean($data2['d_degree_status_id']);
      $total_university_classes_taught2 = clean($data2['total_university_classes_taught']);
      $total_university_credits_taught2 = clean($data2['total_university_credits_taught']);
      $total_university_classes_taken2 = clean($data2['total_university_classes_taken']);
      $total_university_credits_taken2 = clean($data2['total_university_credits_taken']);
      $total_university_classes2 = clean($data2['total_university_classes']);
      $total_university_credits2 = clean($data2['total_university_credits']);
      $total_classes2 = clean($data2['total_classes']);
      $total_credits2 = clean($data2['total_credits']);

      // Determine value to keep
      $last_university_id = max_val($last_university_id, $last_university_id2);
      $b_old_university_id = min_val($b_old_university_id, $b_old_university_id2);
      $b_old_degree_status_id = max_val($b_old_degree_status_id, $b_old_degree_status_id2);
      $b_university_id = min_val($b_university_id, $b_university_id2);
      $b_degree_status_id = max_val($b_degree_status_id, $b_degree_status_id2);
      $f_university_id = min_val($f_university_id, $f_university_id2);
      $f_degree_status_id = max_val($f_degree_status_id, $f_degree_status_id2);
      $m_university_id = min_val($m_university_id, $m_university_id2);
      $m_degree_status_id = max_val($m_degree_status_id, $m_degree_status_id2);
      $d_university_id = min_val($d_university_id, $d_university_id2);
      $d_degree_status_id = max_val($d_degree_status_id, $d_degree_status_id2);
      $total_university_classes_taught = max_val0($total_university_classes_taught, $total_university_classes_taught2);
      $total_university_credits_taught = max_val0($total_university_credits_taught, $total_university_credits_taught2);
      $total_university_classes_taken = max_val0($total_university_classes_taken, $total_university_classes_taken2);
      $total_university_credits_taken = max_val0($total_university_credits_taken, $total_university_credits_taken2);
      $total_university_classes = max_val0($total_university_classes, $total_university_classes2);
      $total_university_credits = max_val0($total_university_credits, $total_university_credits2);
      $total_classes = max_val0($total_classes, $total_classes2);
      $total_credits = max_val0($total_credits, $total_credits2);

      /* Update keep participant */
      $participant_update = "UPDATE $DBNAME_UNIVERSITY.participant SET " .
                            "university_participant_id2 = " . value_or_null($university_participant_id2) . ", " .
                            "last_university_id = " . value_or_null($last_university_id) . ", " .
                            "b_old_university_id = " . value_or_null($b_old_university_id) . ", " .
                            "b_old_degree_status_id = " . value_or_null($b_old_degree_status_id) . ", " .
                            "b_university_id = " . value_or_null($b_university_id) . ", " .
                            "b_degree_status_id = " . value_or_null($b_degree_status_id) . ", " .
                            "f_university_id = " . value_or_null($f_university_id) . ", " .
                            "f_degree_status_id = " . value_or_null($f_degree_status_id) . ", " .
                            "m_university_id = " . value_or_null($m_university_id) . ", " .
                            "m_degree_status_id = " . value_or_null($m_degree_status_id) . ", " .
                            "d_university_id = " . value_or_null($d_university_id) . ", " .
                            "d_degree_status_id = " . value_or_null($d_degree_status_id) . ", " .
                            "total_university_classes_taught = " . value_or_zero($total_university_classes_taught) . ", " .
                            "total_university_classes_taken = " . value_or_zero($total_university_classes_taken) . ", " .
                            "total_university_credits_taught = " . value_or_zero($total_university_credits_taught) . ", " .
                            "total_university_credits_taken = " . value_or_zero($total_university_credits_taken) . ", " .
                            "total_university_classes = " . value_or_zero($total_university_classes) . ", " .
                            "total_university_credits = " . value_or_zero($total_university_credits) . ", " .
                            "total_credits = " . value_or_zero($total_credits) . ", " .
                            "total_classes = " . value_or_zero($total_classes) .
                            " WHERE participant_id = " . value_or_null($participant_id);
      $participant_result = mysql_query($participant_update)
         or die("Participant Update failed : " . $participant_update . "<br/>" . mysql_error());

      /* Update registrations to replace duplicate participant ID with keep ID */
      $registration_update = "UPDATE $DBNAME_UNIVERSITY.registration SET participant_id = $participant_id " .
                             "WHERE participant_id = $participant_id2";
      $registration_result = mysql_query($registration_update)
         or die("Registration Update failed : " . $registration_update . "<br/>" . mysql_error());

      /* Delete duplicate participant */
      $participant_delete = "DELETE FROM $DBNAME_UNIVERSITY.participant WHERE participant_id = $participant_id2";
      $participant_result = mysql_query($participant_delete)
         or die("Participant Delete failed : " . $participant_delete . "<br/>" . mysql_error());
   }
   mysql_free_result($result);

   // Duplicate Registrations
   $query = "SELECT registration.* FROM $DBNAME_UNIVERSITY.registration " .
            "WHERE (participant_id, course_id) in (SELECT participant_id, course_id FROM " .
            "(SELECT participant_id, course_id, COUNT(participant_id) FROM $DBNAME_UNIVERSITY.registration GROUP BY participant_id, course_id HAVING COUNT(participant_id) > 1) AS dup) " .
            "ORDER BY participant_id, course_id, registration_id";
   $result = mysql_query($query)
      or die("Registration ID Query failed : " . $query . "<br/>" . mysql_error());

   while ($data = mysql_fetch_array($result, MYSQL_BOTH))
   {
      // First row
      $participant_id = clean($data['participant_id']);
      $course_id = clean($data['course_id']);

      $old_registration_id = clean($data['old_registration_id']);
      $registration_id = clean($data['registration_id']);
      $participant_type_id = clean($data['participant_type_id']);
      $registration_status_id = clean($data['registration_status_id']);

      // Second row
      $data2 = mysql_fetch_array($result, MYSQL_BOTH);
      $old_registration_id2 = clean($data2['old_registration_id']);
      $registration_id2 = clean($data2['registration_id']);
      $participant_type_id2 = clean($data2['participant_type_id']);
      $registration_status_id2 = clean($data2['registration_status_id']);

      // Determine value to keep
      $participant_type_id = min_val($participant_type_id, $participant_type_id2);
      $registration_status_id = max_val($registration_status_id, $registration_status_id2);

      /* Update keep registration */
      $registration_update = "UPDATE $DBNAME_UNIVERSITY.registration SET " .
                            "old_registration_id2 = " . value_or_null($old_registration_id2) . ", " .
                            "participant_type_id = " . value_or_null($participant_type_id) . ", " .
                            "registration_status_id = " . value_or_null($registration_status_id) . 
                            " WHERE registration_id = " . value_or_null($registration_id);
      $registration_result = mysql_query($registration_update)
         or die("Registration Update failed : " . $registration_update . "<br/>" . mysql_error());

      /* Delete duplicate registration */
      $registration_delete = "DELETE FROM $DBNAME_UNIVERSITY.registration WHERE registration_id = $registration_id2";
      $registration_result = mysql_query($registration_delete)
         or die("Registration Delete failed : " . $registration_delete . "<br/>" . mysql_error());
   }

   db_disconnect($link);
?>
<p>Duplicates merged.</p>
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
