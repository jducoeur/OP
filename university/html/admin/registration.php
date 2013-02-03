<?php
include_once("../db/validation_format.php");
include_once("db.php");

$title = "Registration Detail";
include("../header.php");

$registration_id = "";
if (isset($_REQUEST['registration_id']))
{
   $registration_id = clean($_REQUEST['registration_id']);
}

$participant_id = "";
if (isset($_REQUEST['participant_id']))
{
   $participant_id = clean($_REQUEST['participant_id']);
}

$course_id = "";
if (isset($_REQUEST['course_id']))
{
   $course_id = clean($_REQUEST['course_id']);
}

$type = "";
if (isset($_REQUEST['type']))
{
   $type = clean($_REQUEST['type']);
}

$mode = $MODE_ADD;
if (isset($_REQUEST['mode']))
{
   $mode = clean($_REQUEST['mode']);
}

//echo "DEBUG: registration_id [$registration_id] participant_id [$participant_id] course_id [$course_id] type [$type] mode [$mode]<br/>";
?>
<h2 style="text-align:center"><?php echo ucfirst($mode); ?> Registration</h2>
<?php
// Only appropriate admins allowed
if (isset($_SESSION[$UNIVERSITY_ADMIN]) && $_SESSION[$UNIVERSITY_ADMIN] == 1)
{
   $SUBMIT_SAVE = "Save Registration";

   $valid = true;
   $errmsg = '';
   if (isset($_POST['submit']) && $_POST['submit'] == $SUBMIT_SAVE)
   {
      $participant_type_id = NULL;
      if (isset($_POST['participant_type_id']))
      {
         $participant_type_id = clean($_POST['participant_type_id']);
      }
      $registration_status_id = NULL;
      if (isset($_POST['registration_status_id']))
      {
         $registration_status_id = clean($_POST['registration_status_id']);
      }
      $university_id = NULL;
      if (isset($_POST['university_id']))
      {
         $university_id = clean($_POST['university_id']);
      }

      // Validate data
      if ($participant_id == NULL || $participant_id == '')
      {
         $valid = false;
         $errmsg .= "Please select a participant.<br/>";
      }
      if ($course_id == NULL || $course_id == '')
      {
         $valid = false;
         $errmsg .= "Please select a course.<br/>";
      }
      if ($participant_type_id == NULL || $participant_type_id == '')
      {
         $valid = false;
         $errmsg .= "Please select a participant type.<br/>";
      }
      if ($registration_status_id == NULL || $registration_status_id == '')
      {
         $valid = false;
         $errmsg .= "Please select a registration status.<br/>";
      }

      if ($valid)
      {
         $link = db_admin_connect();

         // Update Registration
         if ($mode == $MODE_EDIT)
         {
            $update = 
               "UPDATE $DBNAME_UNIVERSITY.registration " .
               "SET participant_id = " . value_or_null($participant_id) . 
               ", course_id = " . value_or_null($course_id) . 
               ", participant_type_id = " . value_or_null($participant_type_id) . 
               ", registration_status_id = " . value_or_null($registration_status_id) . 
               ", last_updated = " . value_or_null(date("Y-m-d")) .
               ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) .
               " WHERE registration_id = ". $registration_id;

            $uresult = mysql_query($update)
               or die("Error updating Registration: " . $update . "<br/>" . mysql_error());
         }
         // Insert University
         else
         {
            $insert = 
               "INSERT INTO $DBNAME_UNIVERSITY.registration (participant_id, course_id, participant_type_id, registration_status_id, date_created, last_updated, last_updated_by) VALUES (" . 
               value_or_null($participant_id) . ", " . 
               value_or_null($course_id) . ", " . 
               value_or_null($participant_type_id) . ", " . 
               value_or_null($registration_status_id) . ", " . 
               value_or_null(date("Y-m-d")) . ", " . 
               value_or_null(date("Y-m-d")) . ", " . 
               value_or_null($_SESSION['s_user_id']) . ")";

            $iresult = mysql_query($insert)
               or die("Error inserting Registration: " . $insert . "<br/>" . mysql_error());
         }
         /* Closing connection */
         db_disconnect($link);
?>
<p align="center">Registration successfully updated.<br/>
<a href="class.php?university_id=<?php echo $university_id; ?>&amp;course_id=<?php echo $course_id; ?>">Return to the Class</a>.<br/>
<a href="participant.php?participant_id=<?php echo $participant_id; ?>">Return to the Participant</a>.
</p>
<?php 
      } // valid
   }
   // We haven't submitted save yet - display edit form
   if (!(isset($_POST['submit'])) || (isset($_POST['submit']) && ($_POST['submit'] == $SUBMIT_SAVE && !$valid)))
   {
      $link = db_connect();

      if ($course_id != "")
      {
         $query = "SELECT course.course_number, course.title, university.university_id, university.university_code FROM $DBNAME_UNIVERSITY.course JOIN $DBNAME_UNIVERSITY.university ON course.university_id = university.university_id WHERE course_id = $course_id";
         $result = mysql_query($query)
            or die("Course Query failed : " . $query. "<br/>" . mysql_error());

         $data = mysql_fetch_array($result, MYSQL_BOTH);
         $university_id = clean($data['university_id']);
         $university_code = clean($data['university_code']);
         $course_number = clean($data['course_number']);
         $course_title = clean($data['title']);

         mysql_free_result($result);
      }

      if ($participant_id != "")
      {
         $query = "SELECT participant.sca_name FROM $DBNAME_UNIVERSITY.participant WHERE participant_id = $participant_id";
         $result = mysql_query($query)
            or die("Participant Query failed : " . $query. "<br/>" . mysql_error());

         $data = mysql_fetch_array($result, MYSQL_BOTH);
         $sca_name = clean($data['sca_name']);

         mysql_free_result($result);
      }

      // Set defaults based on type input
      if (isset($type) && $type != "")
      {
         if ($type == $ST_INSTRUCTOR)
         {
            $participant_type_id = $TYPE_INSTRUCTOR;
         }
         if ($type == $ST_STUDENT)
         {
            $participant_type_id = $TYPE_STUDENT;
         }
      }

      if (($mode == $MODE_EDIT || $registration_id != "") && $valid)
      {
         $query = "SELECT registration.*, participant.sca_name, course.course_number, course.title, university.university_id, university.university_code " .
                  "FROM $DBNAME_UNIVERSITY.registration JOIN $DBNAME_UNIVERSITY.participant ON registration.participant_id = participant.participant_id " .
                  "JOIN $DBNAME_UNIVERSITY.course ON registration.course_id = course.course_id " .
                  "JOIN $DBNAME_UNIVERSITY.university ON course.university_id = university.university_id " .
                  "WHERE registration.registration_id = $registration_id";
         $result = mysql_query($query)
            or die("Registration Query failed : " . $query. "<br/>" . mysql_error());
         $data = mysql_fetch_array($result, MYSQL_BOTH);

         $university_id = clean($data['university_id']);
         $university_code = clean($data['university_code']);
         $course_id = clean($data['course_id']);
         $course_number = clean($data['course_number']);
         $course_title = clean($data['title']);
         $registration_status_id = clean($data['registration_status_id']);
         $participant_id = clean($data['participant_id']);
         $participant_type_id = clean($data['participant_type_id']);
         $sca_name = clean($data['sca_name']);
         if ($sca_name == "")
         {
            $sca_name = "(No SCA name)";
         }

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

      // Get pick lists
      $participant_type_data_array = get_participant_type_pick_list();
      $registration_status_data_array = get_registration_status_pick_list();
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>"/>
<table border="1" align="center" cellpadding="5" cellspacing="0" summary="Course Form">
<?php 
      if (isset($registration_id) && $registration_id > 0)
      {
?>
   <input type="hidden" name="registration_id" id="registration_id" value="<?php echo $registration_id; ?>"/>
<?php 
      }
      if (isset($course_id) && $course_id > 0)
      {
?>
   <input type="hidden" name="course_id" id="course_id" value="<?php echo $course_id; ?>"/>
<?php 
      }
      if (isset($participant_id) && $participant_id > 0)
      {
?>
   <input type="hidden" name="participant_id" id="participant_id" value="<?php echo $participant_id; ?>"/>
<?php 
      }
      if (isset($type) && $type > 0)
      {
?>
   <input type="hidden" name="type" id="type" value="<?php echo $type; ?>"/>
<?php 
      }
      if (isset($university_id) && $university_id > 0)
      {
?>
   <input type="hidden" name="university_id" id="university_id" value="<?php echo $university_id; ?>"/>
<?php 
      }
?>
   <tr>
      <th class="titleright">University Session:</th>
      <td class="data"><a href="catalog.php?university_id=<?php echo $university_id; ?>"><?php echo $university_code; ?></a></td>
   </tr>
   <tr>
      <th class="titleright">Course:</th>
      <td class="data"><a href="class.php?course_id=<?php echo $course_id; ?>"><?php echo $course_number . " - " . $course_title; ?></a></td>
   </tr>
   <tr>
      <th class="titleright">Participant:</th>
      <td class="data"><a href="participant.php?mode=<?php echo $MODE_EDIT; ?>&amp;participant_id=<?php echo $participant_id; ?>"><?php echo $sca_name; ?></a></td>
   </tr>
   <tr>
      <td class="titleright"><label for="participant_type_id">Participant Type:</label></td>
      <td class="data">
      <select name="participant_type_id" id="participant_type_id">
<?php
      for ($i = 0; $i < count($participant_type_data_array); $i++)
      {
         echo '<option id="' . $participant_type_data_array[$i]['participant_type'] . '" value="' . $participant_type_data_array[$i]['participant_type_id'] . '"';
         if (isset($participant_type_id) && $participant_type_id == $participant_type_data_array[$i]['participant_type_id'])
         {
            echo ' selected';
         }
         echo '>' . $participant_type_data_array[$i]['participant_type'] . '</option>';
      }
?>
      </select>
      </td>
   </tr>
   <tr>
      <td class="titleright"><label for="registration_status_id">Registration Status:</label></td>
      <td class="data">
      <select name="registration_status_id" id="registration_status_id">
<?php
      for ($i = 0; $i < count($registration_status_data_array); $i++)
      {
         echo '<option id="' . $registration_status_data_array[$i]['registration_status'] . '" value="' . $registration_status_data_array[$i]['registration_status_id'] . '"';
         if (isset($registration_status_id) && $registration_status_id == $registration_status_data_array[$i]['registration_status_id'])
         {
            echo ' selected';
         }
         echo '>' . $registration_status_data_array[$i]['registration_status'] . '</option>';
      }
?>
      </select>
      </td>
   </tr>
   <tr>
      <td colspan="2" class="datacenter"><input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_SAVE; ?>"/></td>
   </tr>
</table>
<?php
   }
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
