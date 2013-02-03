<?php 
include_once("db/validation_format.php");
include("header.php");

/* Connecting, selecting database */
$link = db_connect();

// Retrieve current university session if no session is specified
$query = "SELECT university.*, branch.*, branch_type.branch_type, event_main.flyer, event_main.publish " .
         "FROM $DBNAME_UNIVERSITY.university JOIN $DBNAME_BRANCH.branch ON university.branch_id = branch.branch_id " .
         "JOIN $DBNAME_BRANCH.branch_type ON branch.branch_type_id = branch_type.branch_type_id " .
         "LEFT OUTER JOIN $DBNAME_SPIKE.event_main ON university.event_id = event_main.event_id " .
         "WHERE university.is_university = 1 " .
         "AND university.university_date = (SELECT MAX(university_date) FROM $DBNAME_UNIVERSITY.university WHERE is_university = 1)";
$result = mysql_query($query)
   or die("Current University Query failed : " . mysql_error());
$data = mysql_fetch_array($result, MYSQL_BOTH);

$university_id = clean($data['university_id']);
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

$event_id = clean($data['event_id']);
$flyer = clean($data['flyer']);
$publish = clean($data['publish']);

$location_display = $incpient_display . $branch_type . " of " . $branch_name;
$date_display = format_full_date($university_date);
$university_display = "University Session #$university_number<br/>" . format_full_date($university_date) . "<br/>" . $incpient_display . $branch_type . " of " . $branch_name;

mysql_free_result($result);

// Full classes
$full_query = "SELECT course.course_number, course.title, course.capacity, COUNT(registration.registration_id) as attendees " .
         "FROM $DBNAME_UNIVERSITY.course JOIN $DBNAME_UNIVERSITY.university ON course.university_id = university.university_id " .
         "JOIN $DBNAME_UNIVERSITY.registration ON course.course_id = registration.course_id " .
         "WHERE course.university_id = $university_id " .
         "AND university.publish_date IS NOT NULL AND university.publish_date <= CURRENT_DATE " .
         "AND course.course_status_id = $STATUS_APPROVED " .
         "AND registration.participant_type_id = $TYPE_STUDENT " .
         "GROUP BY course.course_number, course.title, course.capacity " .
         "HAVING COUNT(registration.registration_id) >= course.capacity " .
         "ORDER BY course.course_number";
$full_result = mysql_query($full_query)
   or die("Full Classes Query failed : " . $full_query . "<br/>" . mysql_error());

// New classes
$new_query = "SELECT course.course_number, course.title " .
         "FROM $DBNAME_UNIVERSITY.course JOIN $DBNAME_UNIVERSITY.university ON course.university_id = university.university_id " .
         "WHERE course.university_id = $university_id " .
         "AND university.publish_date IS NOT NULL AND university.publish_date <= CURRENT_DATE " .
         "AND course.date_created > university.publish_date AND course.course_status_id = $STATUS_APPROVED " .
         "ORDER BY course.course_number";
$new_result = mysql_query($new_query)
   or die("New Classes Query failed : " . $new_query . "<br/>" . mysql_error());

// Changes
$change_query = "SELECT course.course_number, course.title, course.changes " .
         "FROM $DBNAME_UNIVERSITY.course JOIN $DBNAME_UNIVERSITY.university ON course.university_id = university.university_id " .
         "WHERE course.university_id = $university_id " .
         "AND university.publish_date IS NOT NULL AND university.publish_date <= CURRENT_DATE " .
         "AND course.course_status_id = $STATUS_APPROVED AND course.changes IS NOT NULL " .
         "ORDER BY course.course_number";
$change_result = mysql_query($change_query)
   or die("Changed Classes Query failed : " . $change_query . "<br/>" . mysql_error());

// Canceled Classes
$cancel_query = "SELECT course.course_number, course.title " .
         "FROM $DBNAME_UNIVERSITY.course JOIN $DBNAME_UNIVERSITY.university ON course.university_id = university.university_id " .
         "WHERE course.university_id = $university_id " .
         "AND university.publish_date IS NOT NULL AND university.publish_date <= CURRENT_DATE " .
         "AND course.course_status_id = $STATUS_CANCELED " .
         "ORDER BY course.course_number";
$cancel_result = mysql_query($cancel_query)
   or die("Canceled Classes Query failed : " . $cancel_query . "<br/>" . mysql_error());

?>
<table border="0" cellpadding="0" width="100%">
   <tr>
      <td class="leftnav">
      <p><span class="leftnavtitle">Next Session:</span> #<?php echo $university_number; ?><br/>
      <?php echo $location_display; ?><br/>
      <?php echo $date_display; ?></p>
      <p><span class="leftnavtitle">Full Classes:</span><br/>
<?php
while ($data = mysql_fetch_array($full_result, MYSQL_BOTH))
{
   $course_number = clean($data['course_number']);
   $course_title = clean($data['title']);
   echo "$course_number - $course_title<br/>";
}
mysql_free_result($full_result);
?>
      </p>
      <p><span class="leftnavtitle">Additions:</span><br/>
<?php
while ($data = mysql_fetch_array($new_result, MYSQL_BOTH))
{
   $course_number = clean($data['course_number']);
   $course_title = clean($data['title']);
   echo "$course_number - $course_title<br/>";
}
mysql_free_result($new_result);
?>
      </p>
      <p><span class="leftnavtitle">Changes:</span><br/>
<?php
while ($data = mysql_fetch_array($change_result, MYSQL_BOTH))
{
   $course_number = clean($data['course_number']);
   $course_title = clean($data['title']);
   $changes = clean($data['changes']);
   echo "$course_number - $course_title: <i>$changes</i><br/>";
}
mysql_free_result($change_result);
?>
      </p>
      <p><span class="leftnavtitle">Cancellations:</span><br/>
<?php
while ($data = mysql_fetch_array($cancel_result, MYSQL_BOTH))
{
   $course_number = clean($data['course_number']);
   $course_title = clean($data['title']);
   echo "$course_number - $course_title<br/>";
}
mysql_free_result($cancel_result);
?>
      </p>
<?php 
if ($event_id != "" && $publish == 1)
{
   if ($flyer == 1)
   {
      $event_url = $ACORN_URL . "event_flyer.php?event_id=" . $event_id;
   }
   else
   {
      $event_url = $ACORN_URL . "event_info.php?event_id=" . $event_id;
   }
?>
      <p><span class="leftnavtitle">Event Flyer:</span><br/>
      <a style="color:white;font-weight:normal" href="<?php echo $event_url; ?>">University #<?php echo $university_number; ?></a>
      </p>
      
<?php 
}
?>
      </td>
      <td class="mainpage"> 
      <h2>Welcome!</h2>
      <p>The University of Atlantia is dedicated to the advancement of teaching in the <a href="http://atlantia.sca.org">Kingdom of Atlantia</a>, 
      <a href="http://www.sca.org">SCA, Inc.</a></p>
      <p>There are two to three University sessions each year. If you are interested in hosting a University, please refer to our 
      <a href="host.php">bid guidelines</a>.</p>

      <h2>Announcements</h2>
<?php 
/* Performing SQL query */
$query = 
   "SELECT announcement_date, announcement FROM $DBNAME_UNIVERSITY.announcement WHERE expiration_date > CURRENT_DATE ORDER BY announcement_date";

$result = mysql_query($query) 
   or die("Query failed : " . mysql_error());

if (mysql_num_rows($result) > 0)
{
?>
<table border="0" cellpadding="5" cellspacing="0">
<?php
   while ($data = mysql_fetch_array($result, MYSQL_BOTH)) 
   {
      $announcement_date = clean($data['announcement_date']);
      $announcement = clean($data['announcement']);
?>
   <tr>
      <td class="titleleft" style="vertical-align:top"><?php echo format_short_date($announcement_date); ?></td>
      <td class="data"><?php echo str_replace("\n", "<br/>", htmlentities($announcement)); ?></td>
   </tr>
<?php
   }
?>
</table>
<?php
}
/* Free resultset */
mysql_free_result($result);
?>
      <h2>Options</h2>
      <p>
      <a href="catalog.php"><img border="0" width="256" height="36" src="images/catalog.gif" alt="Course Catalog" title="Course Catalog" name="image1" /></a><br/>
      <a href="register.php"><img border="0" width="311" height="36" src="images/register.gif" alt="Register for Classes" title="Register for Classes" name="image2" /></a><br/>
      <a href="teach.php"><img border="0" width="265" height="36" src="images/teach.gif" alt="Sign up to Teach" title="Sign up to Teach" name="image3" /></a><br/>
      <a href="chancellor.php"><img border="0" width="355" height="36" src="images/contact.gif" alt="Contact the Chancellor" title="Contact the Chancellor" name="image4" /></a><br/>
      <a href="degrees.php"><img border="0" width="319" height="36" src="images/degrees.gif" alt="Degrees and Awards" title="Degrees and Awards" name="image5" /></a><br/>
      <a href="faq.php"><img border="0" width="416" height="36" src="images/faq.gif" alt="Frequently Asked Questions" title="Frequently Asked Questions" name="image6" /></a>
      </p>
      </td>
   </tr>
</table>
<?php
db_disconnect($link);
include("footer.php");
?>