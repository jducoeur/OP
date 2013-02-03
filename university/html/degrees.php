<?php
$title = "Degrees";
include("header.php");

/* Connecting, selecting database */
$link = db_connect();

// Retrieve most recently completed university session
$query = "SELECT university.university_code FROM $DBNAME_UNIVERSITY.university " .
         "WHERE is_university = 1 AND university_date = (SELECT MAX(university_date) FROM $DBNAME_UNIVERSITY.university WHERE is_university = 1 AND publish_date IS NOT NULL AND publish_date <= CURRENT_DATE AND university_date <= CURRENT_DATE)";
$result = mysql_query($query)
   or die("Current University Query failed : " . mysql_error());
$data = mysql_fetch_array($result, MYSQL_BOTH);

$university_code = clean($data['university_code']);
$university_number = substr($university_code, 2);

mysql_free_result($result);
db_disconnect($link);
?>
<h2 style="text-align:center">As of Session #<?php echo $university_number; ?></h2>
<p style="text-align:center">
<a href="degree_list.php?type=<?php echo $TYPE_BACHELOR; ?>">Bachelors of SCA Studies</a>
<br/>
<a href="degree_list.php?type=<?php echo $TYPE_FELLOW; ?>">Fellows of the University</a>
<br/>
<a href="degree_list.php?type=<?php echo $TYPE_MASTER; ?>">Masters of SCA Studies</a>
<br/>
<a href="degree_list.php?type=<?php echo $TYPE_DOCTOR; ?>">Honorary Doctors of the University</a>
<!--<br/>
<a href="programs.php">Students Who Have Completed The Trivium/Quadrivium</a>-->
</p>
<p style="text-align:center"><a href="faq.php#degree">Degree Requirements</a></p>
<p style="text-align:center">
<a href="unclaimed.php">Unclaimed Degrees</a>
<br/><br/>
<a href="stats.php">University Statistics</a>
</p>
<?php include("footer.php");