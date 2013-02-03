<?php
include_once('admin.php');

function get_branch_pick_list()
{
   global $DBNAME_BRANCH, $BT_KINGDOM;
   $link = db_connect();

   // Get Branch List
   $branch_query = "SELECT branch, branch_type, branch_id, incipient, branch.branch_type_id " .
      "FROM $DBNAME_BRANCH.branch, $DBNAME_BRANCH.branch_type " .
      "WHERE branch.branch_type_id = branch_type.branch_type_id " .
      "ORDER BY branch";
   $branch_result = mysql_query($branch_query)
      or die("Error reading Branch list: " . mysql_error());
   $branch_data_array = array();
   $i = 0;
   while ($branch_data = mysql_fetch_array($branch_result, MYSQL_BOTH))
   {
      $branch_data_array[$i]['branch_id'] = $branch_data['branch_id'];
      $branch_data_array[$i]['branch'] = $branch_data['branch'];
      $branch_data_array[$i]['branch_name'] = $branch_data['branch'];
      $branch_data_array[$i]['branch_name'] .= ' (';
      if ($branch_data['incipient'] == 1)
      {
         $branch_data_array[$i]['branch_name'] .= "Incipient ";
      }
      $branch_data_array[$i]['branch_name'] .= $branch_data['branch_type'] . ')';
      if ($branch_data['branch_type_id'] != $BT_KINGDOM)
      {
         $branch_data_array[$i]['branch_name'] .= ", " . get_kingdom($branch_data['branch_id'], $link);
      }
      $i++;
   }
   mysql_free_result($branch_result);

   return $branch_data_array;
}

function get_atlantian_branch_pick_list()
{
   global $DBNAME_BRANCH;
   $link = db_connect();

   // Get Branch List
   $branch_query = "SELECT branch, branch_type, branch_id, incipient, branch.branch_type_id " .
      "FROM $DBNAME_BRANCH.branch, $DBNAME_BRANCH.branch_type " .
      "WHERE branch.branch_type_id = branch_type.branch_type_id " .
      "AND branch.is_atlantian = 1 " .
      "ORDER BY branch";
   $branch_result = mysql_query($branch_query)
      or die("Error reading Branch list: " . mysql_error());
   $branch_data_array = array();
   $i = 0;
   while ($branch_data = mysql_fetch_array($branch_result, MYSQL_BOTH))
   {
      $branch_data_array[$i]['branch_id'] = $branch_data['branch_id'];
      $branch_data_array[$i]['branch'] = $branch_data['branch'];
      $branch_data_array[$i]['branch_name'] = $branch_data['branch'];
      $branch_data_array[$i]['branch_name'] .= ' (';
      if ($branch_data['incipient'] == 1)
      {
         $branch_data_array[$i]['branch_name'] .= "Incipient ";
      }
      $branch_data_array[$i]['branch_name'] .= $branch_data['branch_type'] . ')';
      $i++;
   }
   mysql_free_result($branch_result);

   return $branch_data_array;
}

function get_kingdom_pick_list()
{
   global $DBNAME_BRANCH;

   $link = db_connect();

   // Get Monarchs list
   $kingdom_query = "SELECT branch_id, branch FROM $DBNAME_BRANCH.kingdom ORDER BY branch";

   $kingdom_result = mysql_query($kingdom_query)
      or die("Error reading kingdom list: " . mysql_error());

   $kingdom_data_array = array();
   $i = 0;
   while ($kingdom_data = mysql_fetch_array($kingdom_result, MYSQL_BOTH))
   {
      $kingdom_data_array[$i]['branch_id'] = $kingdom_data['branch_id'];
      $kingdom_data_array[$i++]['branch'] = $kingdom_data['branch'];
   }

   mysql_free_result($kingdom_result);

   mysql_close($link);
   return $kingdom_data_array;
}

function get_university_pick_list()
{
   global $DBNAME_UNIVERSITY;
   $link = db_connect();

   // Get University List
   $university_query = "SELECT university_id, university_code, university_date " .
      "FROM $DBNAME_UNIVERSITY.university " .
      "WHERE is_university = 1 AND university_date <= CURRENT_DATE " .
      "ORDER BY university_date";
   $university_result = mysql_query($university_query)
      or die("Error reading University list: " . mysql_error());
   $university_data_array = array();
   $i = 0;
   while ($university_data = mysql_fetch_array($university_result, MYSQL_BOTH))
   {
      $university_data_array[$i]['university_id'] = $university_data['university_id'];
      $university_data_array[$i]['university_code'] = $university_data['university_code'];
      $i++;
   }
   mysql_free_result($university_result);

   return $university_data_array;
}

function get_degree_status_pick_list()
{
   global $DBNAME_UNIVERSITY;
   $link = db_connect();

   // Get Degree Status List
   $degree_status_query = "SELECT degree_status_id, degree_status_code, degree_status " .
      "FROM $DBNAME_UNIVERSITY.degree_status " .
      "ORDER BY degree_status_id";
   $degree_status_result = mysql_query($degree_status_query)
      or die("Error reading Degree Status list: " . mysql_error());
   $degree_status_data_array = array();
   $i = 0;
   while ($degree_status_data = mysql_fetch_array($degree_status_result, MYSQL_BOTH))
   {
      $degree_status_data_array[$i]['degree_status_id'] = $degree_status_data['degree_status_id'];
      $degree_status_data_array[$i]['degree_status_code'] = $degree_status_data['degree_status_code'];
      $degree_status_data_array[$i]['degree_status'] = $degree_status_data['degree_status'];
      $i++;
   }
   mysql_free_result($degree_status_result);

   return $degree_status_data_array;
}

function get_course_status_pick_list()
{
   global $DBNAME_UNIVERSITY;
   $link = db_connect();

   // Get Course Status List
   $course_status_query = "SELECT course_status_id, course_status " .
      "FROM $DBNAME_UNIVERSITY.course_status " .
      "ORDER BY course_status_id";
   $course_status_result = mysql_query($course_status_query)
      or die("Error reading Course Status list: " . mysql_error());
   $course_status_data_array = array();
   $i = 0;
   while ($course_status_data = mysql_fetch_array($course_status_result, MYSQL_BOTH))
   {
      $course_status_data_array[$i]['course_status_id'] = $course_status_data['course_status_id'];
      $course_status_data_array[$i]['course_status'] = $course_status_data['course_status'];
      $i++;
   }
   mysql_free_result($course_status_result);

   return $course_status_data_array;
}

function get_course_category_pick_list()
{
   global $DBNAME_UNIVERSITY;
   $link = db_connect();

   // Get Course Category List
   $course_category_query = "SELECT course_category_id, course_category " .
      "FROM $DBNAME_UNIVERSITY.course_category " .
      "ORDER BY course_category_id";
   $course_category_result = mysql_query($course_category_query)
      or die("Error reading Course Category list: " . mysql_error());
   $course_category_data_array = array();
   $i = 0;
   while ($course_category_data = mysql_fetch_array($course_category_result, MYSQL_BOTH))
   {
      $course_category_data_array[$i]['course_category_id'] = $course_category_data['course_category_id'];
      $course_category_data_array[$i]['course_category'] = $course_category_data['course_category'];
      $i++;
   }
   mysql_free_result($course_category_result);

   return $course_category_data_array;
}

function get_course_track_pick_list($university_id)
{
   global $DBNAME_UNIVERSITY;
   $link = db_connect();

   // Get Course Track List
   $course_track_query = "SELECT course_track_id, course_track " .
      "FROM $DBNAME_UNIVERSITY.course_track WHERE university_id = $university_id " .
      "ORDER BY course_track";
   $course_track_result = mysql_query($course_track_query)
      or die("Error reading Course Track list: " . mysql_error());
   $course_track_data_array = array();
   $i = 0;
   while ($course_track_data = mysql_fetch_array($course_track_result, MYSQL_BOTH))
   {
      $course_track_data_array[$i]['course_track_id'] = $course_track_data['course_track_id'];
      $course_track_data_array[$i]['course_track'] = $course_track_data['course_track'];
      $i++;
   }
   mysql_free_result($course_track_result);

   return $course_track_data_array;
}

function get_room_pick_list($university_id)
{
   global $DBNAME_UNIVERSITY;
   $link = db_connect();

   // Get Room List
   $room_query = "SELECT room_id, room " .
      "FROM $DBNAME_UNIVERSITY.room WHERE university_id = $university_id " .
      "ORDER BY room";
   $room_result = mysql_query($room_query)
      or die("Error reading Room list: " . mysql_error());
   $room_data_array = array();
   $i = 0;
   while ($room_data = mysql_fetch_array($room_result, MYSQL_BOTH))
   {
      $room_data_array[$i]['room_id'] = $room_data['room_id'];
      $room_data_array[$i]['room'] = $room_data['room'];
      $i++;
   }
   mysql_free_result($room_result);

   return $room_data_array;
}

function get_registration_status_pick_list()
{
   global $DBNAME_UNIVERSITY;
   $link = db_connect();

   // Get Registration Status List
   $registration_status_query = "SELECT registration_status_id, registration_status " .
      "FROM $DBNAME_UNIVERSITY.registration_status " .
      "ORDER BY registration_status_id";
   $registration_status_result = mysql_query($registration_status_query)
      or die("Error reading Registration Status list: " . mysql_error());
   $registration_status_data_array = array();
   $i = 0;
   while ($registration_status_data = mysql_fetch_array($registration_status_result, MYSQL_BOTH))
   {
      $registration_status_data_array[$i]['registration_status_id'] = $registration_status_data['registration_status_id'];
      $registration_status_data_array[$i]['registration_status'] = $registration_status_data['registration_status'];
      $i++;
   }
   mysql_free_result($registration_status_result);

   return $registration_status_data_array;
}

function get_participant_type_pick_list()
{
   global $DBNAME_UNIVERSITY;
   $link = db_connect();

   // Get Participant Type List
   $participant_type_query = "SELECT participant_type_id, participant_type " .
      "FROM $DBNAME_UNIVERSITY.participant_type " .
      "ORDER BY participant_type_id";
   $participant_type_result = mysql_query($participant_type_query)
      or die("Error reading Participant Type list: " . mysql_error());
   $participant_type_data_array = array();
   $i = 0;
   while ($participant_type_data = mysql_fetch_array($participant_type_result, MYSQL_BOTH))
   {
      $participant_type_data_array[$i]['participant_type_id'] = $participant_type_data['participant_type_id'];
      $participant_type_data_array[$i]['participant_type'] = $participant_type_data['participant_type'];
      $i++;
   }
   mysql_free_result($participant_type_result);

   return $participant_type_data_array;
}
?>
