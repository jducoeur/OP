<?php
$title = "Chancellor";
include("header.php");
?>
<h2 style="text-align:center">Chancellors of the University</h2>
<?php
/* Connecting, selecting database */
$link = db_connect();

// Retrieve Chancellors
$query = "SELECT participant.sca_name, university_start.university_code as start_code, university_end.university_code as end_code " .
         "FROM $DBNAME_UNIVERSITY.participant JOIN $DBNAME_UNIVERSITY.chancellor ON participant.participant_id = chancellor.participant_id " .
         "JOIN $DBNAME_UNIVERSITY.university university_start ON chancellor.start_university_id = university_start.university_id " .
         "LEFT OUTER JOIN $DBNAME_UNIVERSITY.university university_end ON chancellor.end_university_id = university_end.university_id " .
         "ORDER BY university_start.university_date";
$result = mysql_query($query) 
   or die("Query failed : " . mysql_error());
$num_chancellors = mysql_num_rows($result);

if ($num_chancellors > 0)
{
?>
<table align="center" cellpadding="5" cellspacing="0">
<?php
   while ($data = mysql_fetch_array($result, MYSQL_BOTH)) 
   {
      $scode = $data['start_code'];
      $ecode = $data['end_code'];
      $sname = htmlentities($data['sca_name']);
?>
   <tr>
<?php
      echo "<th style=\"text-align:left\">Sessions $scode - $ecode</th>";
      echo "<td>$sname</td>";
?>
   </tr>
<?php
   }
?>
</table>
<?php
}
mysql_free_result($result);
db_disconnect($link);
?>
<p style="text-align:center"><a href="chancellor.php">Current Chancellor of the University</a></p>
<?php include("footer.php");?>