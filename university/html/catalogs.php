<?php
$title = "Previous Course Catalogs";
include("header.php");
?>
<h2 style="text-align:center">University Sessions</h2>
<?php
/* Connecting, selecting database */
$link = db_connect();

// Retrieve current university session
$query = "SELECT university.*, branch.branch FROM $DBNAME_UNIVERSITY.university LEFT OUTER JOIN $DBNAME_BRANCH.branch ON university.branch_id = branch.branch_id " .
         "WHERE publish_date IS NOT NULL AND publish_date <= CURRENT_DATE " .
         "ORDER BY university_date DESC";
$result = mysql_query($query)
   or die("University Query failed : " . mysql_error());

?>
<table cellpadding="5" cellspacing="5" align="center">
   <tr>
      <th style="text-align:left">Session</th>
      <th style="text-align:left">Date</th>
      <th style="text-align:left">Location</th>
   </tr>
<?php
while ($data = mysql_fetch_array($result, MYSQL_BOTH))
{
   $university_id = clean($data['university_id']);
   $university_code = clean($data['university_code']);
   $university_number = substr($university_code, 2);
   $university_date = clean($data['university_date']);
   $date_display = "";
   if ($university_date != "")
   {
      $date_display = format_full_date($university_date);
   }
   $branch_name = clean($data['branch']);
?>
   <tr>
      <td><a href="catalog.php?university_id=<?php echo $university_id; ?>"><?php echo $university_code; ?></a></td>
      <td><?php echo $date_display; ?></td>
      <td><?php echo $branch_name; ?></td>
   </tr>
<?php
   }
?>
</table>
<p style="text-align:center"><a href="catalog.php">Current Session Catalog</a></p>
<?php include("footer.php");?>