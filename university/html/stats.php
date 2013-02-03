<?php
$title = "Degrees";
include("header.php");
?>
<h2 style="text-align:center">University of Atlantia Sessions</h2>

<table width="100%" border="0" cellpadding="5" cellspacing="0" align="left">
   <tr> 
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Session</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Location</th>
      <th style="text-align:center;color:white;background-color:<?php echo $accent_color; ?>">Date</th>
      <th style="text-align:center;color:white;background-color:<?php echo $accent_color; ?>">Students</th>
      <th style="text-align:center;color:white;background-color:<?php echo $accent_color; ?>">Teachers</th>
      <th style="text-align:center;color:white;background-color:<?php echo $accent_color; ?>">Total Attendance</th>
      <th style="text-align:center;color:white;background-color:<?php echo $accent_color; ?>">First Time Attendees</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">AS</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">CM</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">H</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">HS</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">MA</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">MD</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">NC</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">R</th>
      <!--<th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">T</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Q</th>-->
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">HE</th>
      <th style="text-align:left;color:white;background-color:<?php echo $accent_color; ?>">Total</th>
   </tr>
<?php
/* Connecting, selecting database */
$link = db_connect();

$query = "SELECT university.*, branch.branch FROM $DBNAME_UNIVERSITY.university JOIN $DBNAME_BRANCH.branch ON university.branch_id = branch.branch_id " .
         "WHERE is_university = 1 AND publish_date IS NOT NULL AND publish_date <= CURRENT_DATE " .
         "ORDER BY university_date DESC";
$result = mysql_query($query)
   or die("University Query failed : " . mysql_error());

$j = 1;
while ($data = mysql_fetch_array($result, MYSQL_BOTH))
{
   $university_id = clean($data['university_id']);
   $university_code = clean($data['university_code']);
   $university_number = substr($university_code, 2);
   $branch_name = clean($data['branch']);
   $university_date = clean($data['university_date']);
   $total_students = clean($data['total_students']);
   $total_teachers = clean($data['total_teachers']);
   $total_attendees = clean($data['total_attendees']);
   $total_newcomers = clean($data['total_newcomers']);
   $total_classes = clean($data['total_classes']);

   $course_category_query = "SELECT university_statistics.*, course_category.* FROM $DBNAME_UNIVERSITY.university_statistics " .
      "JOIN $DBNAME_UNIVERSITY.course_category ON university_statistics.course_category_id = course_category.course_category_id " .
      "WHERE university_id = $university_id ORDER BY university_statistics.course_category_id";
   $course_category_result = mysql_query($course_category_query)
      or die("Course Category Query failed : " . mysql_error());

   $total_as = "-";
   $total_cm = "-";
   $total_h = "-";
   $total_he = "-";
   $total_hs = "-";
   $total_ma = "-";
   $total_md = "-";
   $total_t = "-";
   $total_q = "-";
   $total_r = "-";
   $total_nc = "-";
   while ($course_category_data = mysql_fetch_array($course_category_result, MYSQL_BOTH))
   {
      $course_category_code = clean($course_category_data['course_category_code']);
      $total_category_classes = clean($course_category_data['total_classes']);
      switch ($course_category_code)
      {
         case $CATEGORY_AS:
            $total_as = $total_category_classes;
            break;
         case $CATEGORY_CM:
            $total_cm = $total_category_classes;
            break;
         case $CATEGORY_H:
            $total_h = $total_category_classes;
            break;
         case $CATEGORY_HE:
            $total_he = $total_category_classes;
            break;
         case $CATEGORY_HS:
            $total_hs = $total_category_classes;
            break;
         case $CATEGORY_MA:
            $total_ma = $total_category_classes;
            break;
         case $CATEGORY_MD:
            $total_md = $total_category_classes;
            break;
         case $CATEGORY_T:
            $total_t = $total_category_classes;
            break;
         case $CATEGORY_Q:
            $total_q = $total_category_classes;
            break;
         case $CATEGORY_R:
            $total_r = $total_category_classes;
            break;
         case $CATEGORY_NC:
            $total_nc = $total_category_classes;
            break;
      }
   }

   $bgcolor = (($j%2 == 0)? "#DDDDDD": "#EEEEEE");
?>
   <tr>
      <td bgcolor="<?php echo $bgcolor; ?>" align="center"><?php echo $university_number; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>"><?php echo $branch_name; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>" align="center"><?php echo format_short_month_date($university_date); ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>" align="center"><?php echo $total_students; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>" align="center"><?php echo $total_teachers; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>" align="center"><?php echo $total_attendees; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>" align="center"><?php echo $total_newcomers; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>" align="center"><?php echo $total_as; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>" align="center"><?php echo $total_cm; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>" align="center"><?php echo $total_h; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>" align="center"><?php echo $total_hs; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>" align="center"><?php echo $total_ma; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>" align="center"><?php echo $total_md; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>" align="center"><?php echo $total_nc; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>" align="center"><?php echo $total_r; ?></td>
      <!--<td bgcolor="<?php echo $bgcolor; ?>" align="center"><?php echo $total_t; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>" align="center"><?php echo $total_q; ?></td>-->
      <td bgcolor="<?php echo $bgcolor; ?>" align="center"><?php echo $total_he; ?></td>
      <td bgcolor="<?php echo $bgcolor; ?>" align="center"><?php echo $total_classes; ?></td>
   </tr>
<?php
   mysql_free_result($course_category_result);
   $j++;
}
mysql_free_result($result);
?>
</table>

<br/><hr/><br/>

<table cellpadding="5" cellspacing="5" align="center">
	<tr>
		<th colspan="8">Course Abbreviations</th>
	</tr>
	<tr>
		<th style="text-align:left">AS</th> <td align="left">Arts &amp; Sciences</td> <th style="text-align:left">CM</th> <td align="left">Current Middle Ages</td>
		<th style="text-align:left">H</th> <td align="left">Humanities</td> <th style="text-align:left">HE</th> <td align="left">Heraldry </td>
	</tr>
	<tr>
		<th style="text-align:left">HS</th> <td align="left">History</td> <th style="text-align:left">MA</th> <td align="left">Martial Arts</td>
		<th style="text-align:left">MD</th> <td align="left">Music &amp; Dance</td> <th style="text-align:left">NC</th> <td>No Credit</td>
	</tr>
	<tr>
		<th style="text-align:left">R</th> <td align="left">Required</td> <th style="text-align:left">&nbsp;</th> <td align="left">&nbsp;</td>
		<th style="text-align:left">&nbsp;</th> <td align="left">&nbsp;</td> <th style="text-align:left">&nbsp;</th> <td align="left">&nbsp;</td>
	</tr>
<!--	<tr>
		<th style="text-align:left">Q</th> <td align="left">Quadrivium</td> <th style="text-align:left">R</th> <td align="left">Required</td>
		<th style="text-align:left">T</th> <td align="left">Trivium</td> <th style="text-align:left">&nbsp;</th> <td align="left">&nbsp;</td>
	</tr>-->
</table>

<br/><hr/><br/>
<table width="95%" border="0" cellpadding="5">
   <tr> 
      <th style="text-align:left">Instructors who have taught the most classes at the University of Atlantia:</th>
      <th style="text-align:left">Students who have taken the most classes at the University of Atlantia:</th>
   </tr>
   <tr> 
      <td align="left" valign="top">
<?php
$max_query = "SELECT DISTINCT total_university_classes_taught as class_cnt " .
         "FROM $DBNAME_UNIVERSITY.participant " .
         "ORDER BY 1 DESC LIMIT 10";
$max_result = mysql_query($max_query)
   or die("Max instructor classes Query failed : " . mysql_error());
$max_data_array = array();
$i = 0;
while ($max_data = mysql_fetch_array($max_result, MYSQL_BOTH))
{
   $max_data_array[$i++] = clean($max_data['class_cnt']);
}
$max_in_clause = create_in_clause_from_array($max_data_array);

$query = "SELECT participant.total_university_classes_taught as class_cnt, participant.sca_name " .
         "FROM $DBNAME_UNIVERSITY.participant " .
         "WHERE participant.total_university_classes_taught IN ($max_in_clause) " .
         "ORDER BY 1 DESC, 2";
$result = mysql_query($query)
   or die("Instructor Query failed : " . mysql_error());

while ($data = mysql_fetch_array($result, MYSQL_BOTH))
{
   $sca_name = clean($data['sca_name']);
   $total_classes = clean($data['class_cnt']);
   echo "$sca_name: $total_classes Classes<br/>";
}
mysql_free_result($result);
mysql_free_result($max_result);
?>
      </td>
      <td align="left" valign="top">
<?php 
$max_query = "SELECT DISTINCT total_university_classes_taken as class_cnt " .
         "FROM $DBNAME_UNIVERSITY.participant " .
         "ORDER BY 1 DESC LIMIT 10";
$max_result = mysql_query($max_query)
   or die("Max student classes Query failed : " . mysql_error());
$max_data_array = array();
$i = 0;
while ($max_data = mysql_fetch_array($max_result, MYSQL_BOTH))
{
   $max_data_array[$i++] = clean($max_data['class_cnt']);
}
$max_in_clause = create_in_clause_from_array($max_data_array);

$query = "SELECT participant.total_university_classes_taken as class_cnt, participant.sca_name " .
         "FROM $DBNAME_UNIVERSITY.participant " .
         "WHERE participant.total_university_classes_taken IN ($max_in_clause) " .
         "ORDER BY 1 DESC, 2";
$result = mysql_query($query)
   or die("Student Query failed : " . mysql_error());

while ($data = mysql_fetch_array($result, MYSQL_BOTH))
{
   $sca_name = clean($data['sca_name']);
   $total_classes = clean($data['class_cnt']);
   echo "$sca_name: $total_classes Classes<br/>";
}
mysql_free_result($result);
mysql_free_result($max_result);
?>
      </td>
   </tr>
</table>
<?php 
db_disconnect($link);
include("footer.php"); 
?>