<?php
include_once("../db/validation_format.php");

$university_id = "";
if (isset($_REQUEST['university_id']))
{
   $university_id = clean($_REQUEST['university_id']);
}

$title = "Schedule Grid";
$printable = 1;
$not_indented = 1;
include("../header.php");

$font_size = 8;
?>
<h2 style="font-size:<?php echo $font_size + 4; ?>pt;color:black;text-align:center">Class Schedule</h2>
<?php
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
      mysql_free_result($result);
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

   $university_display = "University Session #$university_number";
   if ($university_date != "")
   {
      $university_display .= " - " . format_full_date($university_date);
   }
   if ($branch_name != "")
   {
      $university_display .= " - " . $incpient_display . $branch_type . " of " . $branch_name;
   }
?>
<h2 style="font-size:<?php echo $font_size + 2; ?>pt;text-align:center;color:black"><?php echo $university_display; ?></h2>
<table border="1" width="100%" cellpadding="2" cellspacing="0">
   <tr>
      <th style="font-size:<?php echo $font_size; ?>pt;vertical-align:center;text-align:center;">Time \ Room</th>
<?php
   // Retrieve university session rooms
   $room_query = "SELECT DISTINCT room.* FROM $DBNAME_UNIVERSITY.room " .
                  "JOIN $DBNAME_UNIVERSITY.course ON course.room_id = room.room_id " .
                  "WHERE room.university_id = $university_id " .
                  "AND course.course_status_id = $STATUS_APPROVED " .
                  "ORDER BY room";
   $room_result = mysql_query($room_query)
      or die("Room Query failed : " . mysql_error());
   $num_rooms = mysql_num_rows($room_result);

   if ($num_rooms > 0)
   {
      $time_array = array("10:00 AM", "11:00 AM", "1:30 PM", "2:30 PM", "3:30 PM", "4:30 PM");
      $time_rev_array = array("10:00 AM" => 0, "11:00 AM" => 1, "1:30 PM" => 2, "2:30 PM" => 3, "3:30 PM" => 4, "4:30 PM" => 5);
      $room_array = array();
      $room_rev_array = array();
      $grid_array = array();
      $cellspan_array = array();
      $i = 0;
      while ($room_data = mysql_fetch_array($room_result, MYSQL_BOTH))
      {
         $room_id = clean($room_data['room_id']);
         $room = clean($room_data['room']);
         $room_array[$i] = $room;
         $room_rev_array[$room_id] = $i++;
      }

      // Retrieve university session courses
      $class_query = "SELECT course.* FROM $DBNAME_UNIVERSITY.course " .
                     "JOIN $DBNAME_UNIVERSITY.room ON course.room_id = room.room_id " .
                     "WHERE course.course_status_id = $STATUS_APPROVED " .
                     "ORDER BY course.start_time, room.room";
      $class_result = mysql_query($class_query)
         or die("Class Query failed : " . $class_query . "<br/>" . mysql_error());
      $num_classes = mysql_num_rows($class_result);

      if ($num_classes > 0)
      {
         $room_col = 0;
         $time_row = 0;
         $prev_start_time = "";
         while ($class_data = mysql_fetch_array($class_result, MYSQL_BOTH)) 
         {
            $reset_columns = false;

            $course_id = clean($class_data['course_id']);
            $course_number = clean($class_data['course_number']);
            $title = clean($class_data['title']);
            $c_room_id = clean($class_data['room_id']);
            $start_time = clean($class_data['start_time']);
            $hours = clean($class_data['hours']);

            $time_row = $time_rev_array[format_time($start_time)];
            $room_col = $room_rev_array[$c_room_id];
            $grid_array[$time_row][$room_col] = $course_number . ": " . htmlentities($title);
            $cellspan_array[$time_row][$room_col] = $hours;
            if ($hours > 1)
            {
               for ($t = 1; $t < $hours; $t++)
               {
                  $grid_array[($time_row + $t)][$room_col] = "SKIP";
               }
            }
         }
      }
      mysql_free_result($class_result);
   }
   mysql_free_result($room_result);
   mysql_free_result($result);
   db_disconnect($link);

   // Header
   for ($i = 0; $i < count($time_array); $i++)
   {
      // Lunch/Convocation
      if ($i == 2)
      {
?>
      <th style="font-size:<?php echo $font_size; ?>pt;vertical-align:center;text-align:center;white-space:nowrap;">12:00 PM</th>
<?php
      }
?>
      <th style="font-size:<?php echo $font_size; ?>pt;vertical-align:center;text-align:center;white-space:nowrap;"><?php echo $time_array[$i]; ?></th>
<?php
   }
?>
   </tr>
<?php
   // Display grid: time x rooms
   for ($j = 0; $j < $num_rooms; $j++)
   {
?>
   <tr>
      <th style="font-size:<?php echo $font_size; ?>pt;vertical-align:center;text-align:center;white-space:nowrap;"><?php echo $room_array[$j]; ?></th>
<?php
      for ($i = 0; $i < count($time_array); $i++)
      {
         if ($j == 0 && $i == 2)
         {
?>
      <td rowspan="<?php echo $num_rooms; ?>" style="font-size:<?php echo $font_size + 2; ?>pt;vertical-align:center;text-align:center;text-direction:vertical;">L<br/>U<br/>N<br/>C<br/>H<br/><br/>/<br/><br/>C<br/>O<br/>N<br/>V<br/>O<br/>C<br/>A<br/>T<br/>I<br/>O<br/>N</td>
<?php
         }
         if (isset($grid_array[$i][$j]))
         {
            if ($grid_array[$i][$j] != "SKIP")
            {
               $cellspan = "";
               if ($cellspan_array[$i][$j] > 1)
               {
                  $cellspan = " colspan=\"" . $cellspan_array[$i][$j] . "\"";
               }
?>
      <td<?php echo $cellspan; ?> style="font-size:<?php echo $font_size; ?>pt;vertical-align:center;text-align:center;"><?php echo $grid_array[$i][$j]; ?></td>
<?php
            }
         }
         else
         {
?>
      <td style="font-size:<?php echo $font_size; ?>pt;vertical-align:center;text-align:center;">&nbsp;</td>
<?php
         }
      }
?>
   </tr>
<?php
   }
?>
</table>
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