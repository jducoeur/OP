<?php
include("../db/db.php");
include("db.php");
include("../header.php");

$university_id = "";
if (isset($_REQUEST['university_id']))
{
   $university_id = clean($_REQUEST['university_id']);
}

$form_course_track_id = 0;
if (isset($_REQUEST['form_course_track_id']))
{
   $form_course_track_id = clean($_REQUEST['form_course_track_id']);
}

$mode = $MODE_EDIT;
if (isset($_REQUEST['mode']))
{
   $mode = clean($_REQUEST['mode']);
}
?>
<h2 style="text-align:center"><?php echo ucfirst($mode); ?> Track</h2>
<?php
// Only appropriate admins allowed
if (isset($_SESSION[$UNIVERSITY_ADMIN]) && $_SESSION[$UNIVERSITY_ADMIN] == 1)
{
   $SUBMIT_SAVE = "Save Changes";
   $SUBMIT_DELETE = "Delete Selected Tracks";
   $SUBMIT_ROOM = "Assign Track to Room";

   $valid = true;
   $errmsg = '';
   if (isset($_POST['submit']) && $_POST['submit'] == $SUBMIT_SAVE)
   {
      $form_course_track = NULL;
      if (isset($_POST['form_course_track']))
      {
         $form_course_track = clean($_POST['form_course_track']);
      }

      // Validate data
      if ($form_course_track == NULL || $form_course_track == '')
      {
         $valid = false;
         $errmsg .= "Please enter the Track.<br/>";
      }

      if ($valid)
      {
         $link = db_admin_connect();

         // Update Track
         if ($mode == $MODE_EDIT)
         {
            $update = 
               "UPDATE $DBNAME_UNIVERSITY.course_track " .
               "SET course_track = " . value_or_null($form_course_track) . 
               ", last_updated = " . value_or_null(date("Y-m-d")) .
               ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) .
               " WHERE course_track_id = ". $form_course_track_id;

            $uresult = mysql_query($update)
               or die("Error updating Track: " . mysql_error());
         }
         // Insert Track
         else
         {
            $insert = 
               "INSERT INTO $DBNAME_UNIVERSITY.course_track (course_track, university_id, date_created, last_updated, last_updated_by) VALUES (" . 
               value_or_null($form_course_track) . ", " . 
               value_or_null($university_id) . ", " . 
               value_or_null(date("Y-m-d")) . ", " . 
               value_or_null(date("Y-m-d")) . ", " . 
               value_or_null($_SESSION['s_user_id']) . ")";

            $iresult = mysql_query($insert)
               or die("Error inserting Track: " . mysql_error());
         }
         /* Closing connection */
         db_disconnect($link);
?>
<p align="center">Track successfully updated.<br/><a href="<?php echo $_SERVER['PHP_SELF'] . "?university_id=$university_id"; ?>">Return to the Track list</a>.</p>
<?php 
      } // valid
   }
   if (isset($_POST['submit']) && $_POST['submit'] == $SUBMIT_ROOM)
   {
      $form_room_id = 0;
      if (isset($_POST['room_id']))
      {
         $form_room_id = clean($_POST['room_id']);
      }

      if ($form_course_track_id != 0 && $form_room_id != 0)
      {
         $link = db_admin_connect();

         $update = 
            "UPDATE $DBNAME_UNIVERSITY.course " .
            "SET room_id = " . value_or_null($form_room_id) . 
            ", last_updated = " . value_or_null(date("Y-m-d")) .
            ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) .
            " WHERE course_track_id = ". $form_course_track_id .
            " AND course_status_id = $STATUS_APPROVED";

         $uresult = mysql_query($update)
            or die("Error updating Room for Track: " . mysql_error());

         /* Closing connection */
         db_disconnect($link);
      }
   }
   // We haven't submitted save yet - display Track list or edit form
   if (!(isset($_POST['submit'])) || (isset($_POST['submit']) && 
      ($_POST['submit'] == $SUBMIT_SAVE && !$valid) || 
      ($_POST['submit'] == $SUBMIT_DELETE) || 
      ($_POST['submit'] == $SUBMIT_ROOM)))
   {
      // Do delete
      if (isset($_POST['submit']) && $_POST['submit'] == $SUBMIT_DELETE)
      {
         $del_course_track_id = '';
         for ($i = 1; $i < $_POST['del_course_track_max']; $i++)
         {
            if (isset($_POST['del_course_track_id' . $i]))
            {
               if ($del_course_track_id != '')
               {
                  $del_course_track_id .= ',';
               }
               $del_course_track_id .= $_POST['del_course_track_id' . $i];
            }
         }

         if ($del_course_track_id != '')
         {
            $link = db_admin_connect();

            $delete = "DELETE FROM $DBNAME_UNIVERSITY.course_track WHERE course_track_id IN ($del_course_track_id)";

            $dresult = mysql_query($delete)
               or die("Error deleteing Track: " . mysql_error());

            /* Closing connection */
            db_disconnect($link);
         }
         else
         {
            $delerrmsg = "Please select at least one Track to delete.";
?>
<p align="center" class="title3" style="color:red"><?php echo $delerrmsg; ?></p>
<?php 
         }
      }

      // Dislay edit list
      if ($mode == $MODE_EDIT && (!isset($form_course_track_id) || $form_course_track_id == 0))
      {
         $link = db_connect();

         $query = "SELECT university_code FROM $DBNAME_UNIVERSITY.university WHERE university_id = $university_id";
         $result = mysql_query($query);

         $data = mysql_fetch_array($result, MYSQL_BOTH);
         $university_code = $data['university_code'];
         mysql_free_result($result);
?>
<h3 style="text-align:center">Tracks for Session <?php echo $university_code; ?></h3>
<p align="center">
To edit an existing Track: Click on the Track link.<br/>
To delete an existing Track: Check the box in front of the Track and click the <?php echo $SUBMIT_DELETE; ?> button.<br/>
To add a new Track: Visit the <a href="<?php echo $_SERVER['PHP_SELF'] . "?mode=" . $MODE_ADD . "&amp;university_id=$university_id"; ?>">Add Track page</a>.<br/>
</p>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table align="center" border="1" cellpadding="5" cellspacing="0" summary="Track Update Form">
   <tr>
      <th style="color:<?php echo $accent_color; ?>">Delete</th>
      <th style="color:<?php echo $accent_color; ?>">Track</th>
   </tr>
<?php 
         if (isset($university_id) && $university_id > 0)
         {
?>
   <input type="hidden" name="university_id" id="university_id" value="<?php echo $university_id; ?>"/>
<?php 
         }

         $query = "SELECT course_track_id, course_track FROM $DBNAME_UNIVERSITY.course_track WHERE university_id = $university_id ORDER BY course_track";
         $result = mysql_query($query);

         $i = 1;
         while ($data = mysql_fetch_array($result, MYSQL_BOTH))
         {
            $course_track_id = $data['course_track_id'];
            $course_track = clean($data['course_track']);
?>
   <tr>
      <td class="data" nowrap>
      <label for="del_course_track_id<?php echo $i; ?>">Delete</label> <input type="checkbox" name="del_course_track_id<?php echo $i; ?>" id="del_course_track_id<?php echo $i++; ?>" value="<?php echo $course_track_id; ?>"/>
      </td>
      <td class="data">
      <a style="font-weight:normal" href="<?php echo $_SERVER['PHP_SELF'] . "?form_course_track_id=" . $course_track_id . "&amp;university_id=$university_id"; ?>"><?php echo $course_track; ?></a>
      </td>
   </tr>
<?php 
         }
?>
   <input type="hidden" name="del_course_track_max" id="del_course_track_max" value="<?php echo $i; ?>"/>
   <tr>
      <td class="datacenter" colspan="3"><input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_DELETE; ?>"/></td>
   </tr>
</table>
</form>
<?php 
         /* Free resultset */
         mysql_free_result($result);

         /* Closing connection */
         db_disconnect($link);
      }
      // Display form
      else
      {
         $link = db_connect();

         $query = "SELECT university_code FROM $DBNAME_UNIVERSITY.university WHERE university_id = $university_id";
         $result = mysql_query($query);

         $data = mysql_fetch_array($result, MYSQL_BOTH);
         $university_code = $data['university_code'];
         mysql_free_result($result);

         if ($mode == $MODE_EDIT && $valid)
         {
            $query = "SELECT course_track_id, course_track FROM $DBNAME_UNIVERSITY.course_track WHERE course_track_id = " . $form_course_track_id;
            $result = mysql_query($query);

            $data = mysql_fetch_array($result, MYSQL_BOTH);
            $form_course_track_id = $data['course_track_id'];
            $form_course_track = clean($data['course_track']);

            /* Free resultset */
            mysql_free_result($result);
         }
         /* Closing connection */
         db_disconnect($link);

         if (!$valid)
         {
?>
<p align="center" class="title3" style="color:red"><?php echo $errmsg; ?></p>
<?php
         }
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>"/>
<table border="1" align="center" cellpadding="5" cellspacing="0" summary="Track Form">
<?php 
         if (isset($form_course_track_id) && $form_course_track_id > 0)
         {
?>
   <input type="hidden" name="form_course_track_id" id="form_course_track_id" value="<?php echo $form_course_track_id; ?>"/>
<?php 
         }
?>
<?php 
         if (isset($university_id) && $university_id > 0)
         {
?>
   <input type="hidden" name="university_id" id="university_id" value="<?php echo $university_id; ?>"/>
<?php 
         }
?>
   <tr>
      <th class="titleright">University Session:</th>
      <td class="data"><?php if (isset($university_code) && trim($university_code) != '') { echo $university_code; } ?></td>
   </tr>
   <tr>
      <th class="titleright">Track ID:</th>
      <td class="data"><?php if (isset($form_course_track_id) && trim($form_course_track_id) != '' && $form_course_track_id > 0) { echo $form_course_track_id; } ?></td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_course_track">Track:</label></th>
      <td class="data"><input type="text" name="form_course_track" id="form_course_track" size="30" maxlength="50"<?php if (isset($form_course_track) && trim($form_course_track) != '') { echo " value=\"" . $form_course_track . "\""; } ?>/></td>
   </tr>
   <tr>
      <td colspan="2" class="datacenter"><input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_SAVE; ?>"/></td>
   </tr>
</table>
<?php
         if ($form_course_track_id != NULL)
         {
            $link = db_connect();

            // Retrieve university session courses
            $class_query = "SELECT course.*, room.*, course_status.course_status FROM $DBNAME_UNIVERSITY.course " .
               "JOIN $DBNAME_UNIVERSITY.course_status ON course.course_status_id = course_status.course_status_id " .
               "LEFT OUTER JOIN $DBNAME_UNIVERSITY.room ON course.room_id = room.room_id " .
               "WHERE course.course_track_id = $form_course_track_id " .
               "ORDER BY start_time, end_time, course_number";
            $class_result = mysql_query($class_query)
               or die("Class Query failed : " . mysql_error());
            $num_classes = mysql_num_rows($class_result);

            if ($num_classes > 0)
            {
?>
<h3 style="text-align:center">Track Classes</h3>
<table align="center" cellpadding="5" cellspacing="0">
   <tr>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">#</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Title</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Instructor(s)</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Room</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Fee</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Attendees</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Length</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Time</th>
   </tr>
<?php
               $j = 1;
               while ($class_data = mysql_fetch_array($class_result, MYSQL_BOTH)) 
               {
                  $course_id = clean($class_data['course_id']);
                  $course_number = clean($class_data['course_number']);
                  $course_title = clean($class_data['title']);
                  $course_status_id = clean($class_data['course_status_id']);
                  $room = clean($class_data['room']);
                  $cost = clean($class_data['cost']);
                  $cost_display = "";
                  if ($cost != "" && $cost != NULL)
                  {
                     $cost_display .= "$" . $cost;
                  }
                  $capacity = clean($class_data['capacity']);
                  if ($capacity == "" || $capacity == NULL)
                  {
                     $capacity = "&infin;";
                  }
                  $hours = clean($class_data['hours']);
                  $start_time = clean($class_data['start_time']);
                  $end_time = clean($class_data['end_time']);
                  $time_display = "";
                  if ($start_time != "" && $end_time != "")
                  {
                     $time_display .= format_time($start_time) . " - " . format_time($end_time);
                  }

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

                  $student_query = "SELECT registration.registration_id FROM $DBNAME_UNIVERSITY.registration " .
                     "WHERE registration.course_id = $course_id AND registration.participant_type_id = $TYPE_STUDENT";
                  $student_result = mysql_query($student_query)
                     or die("Student Query failed : " . mysql_error());
                  $num_students = mysql_num_rows($student_result);
                  $attendance = $num_students . "/" . $capacity;
                  $bgcolor = (($j%2 == 0)? "#DDDDDD": "#EEEEEE");
                  if ($course_status_id == $STATUS_CANCELED)
                  {
                     $bgcolor = "#ff9999";
                  }
                  if ($course_status_id == $STATUS_PENDING)
                  {
                     $bgcolor = "#ffff99";
                  }
?>
   <tr>
      <td bgcolor="<?php echo $bgcolor; ?>" style="text-align:right"><?php echo $course_number; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>"><a href="class.php?university_id=<?php echo $university_id; ?>&amp;course_id=<?php echo $course_id; ?>"><?php echo htmlentities($course_title); ?></a></td>
      <td bgcolor="<?php echo $bgcolor; ?>"><?php echo $instructor_display; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>"><?php echo $room; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>" style="text-align:right"><?php echo $cost_display; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>" style="text-align:right"><?php echo $attendance; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>" style="text-align:right"><?php echo $hours; ?> hr<?php if ($hours != 1) { echo "s"; } ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>" style="text-align:center;white-space:nowrap"><?php echo $time_display; ?></td>
   </tr>
<?php
                  $j++;
                  mysql_free_result($instructor_result);
                  mysql_free_result($student_result);
               }
?>
</table>
<?php
            }
            mysql_free_result($class_result);
            /* Closing connection */
            db_disconnect($link);
?>
<h3 style="text-align:center">Assign Track to Room</h3>
<div style="text-align:center">
      <select name="room_id" id="room_id">
         <option></option>
<?php
            $room_data_array = get_room_pick_list($university_id);
            for ($i = 0; $i < count($room_data_array); $i++)
            {
               echo '<option id="' . $room_data_array[$i]['room'] . '" value="' . $room_data_array[$i]['room_id'] . '"';
               if (isset($room_id) && $room_id == $room_data_array[$i]['room_id'])
               {
                  echo ' selected';
               }
               echo '>' . $room_data_array[$i]['room'] . '</option>';
            }
?>
      </select>
<br/>
<input style="text-align:center" type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_ROOM; ?>"/>
</div>
<?php
         }
      }
   }
?>
</form>
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
