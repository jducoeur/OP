<?php 
include_once("db.php");
include("header.php");

// Only allow authorized users
if (isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN])
{
$link = db_connect();

$query = "SELECT DISTINCT herald, event_name, court_date, DATE_ADD(end_date, INTERVAL 14 DAY) AS due_date, received_date " .
         "FROM $DBNAME_OP.court_report JOIN $DBNAME_OP.event ON court_report.event_id = event.event_id " .
         "WHERE (received_date IS NULL AND CURDATE() > DATE_ADD(end_date, INTERVAL 14 DAY)) " .
         "OR (received_date > DATE_ADD(end_date, INTERVAL 14 DAY)) " .
         "ORDER BY herald, court_date";

/* Performing SQL query */
$result = mysql_query($query) 
   or die("Overdue Court Report Query failed : " . mysql_error());

?>
<p class="title2" align="center">Overdue Court Reports</p>
<table align="center" cellpadding="5" cellspacing="0" border="1" summary="Table listing search results">
   <tr>
      <th class="title">Herald</th>
      <th class="title">Event</th>
      <th class="title">Court Date</th>
      <th class="title">Due Date</th>
      <th class="title">Received Date</th>
   </tr>
<?php 
      while ($data = mysql_fetch_array($result, MYSQL_BOTH))
      {
         $herald = $data['herald'];
         $event_name = $data['event_name'];
         $court_date = $data['court_date'];
         $due_date = $data['due_date'];
         $received_date = $data['received_date'];
?>
   <tr>
      <td class="data"><?php echo $herald; ?></td>
      <td class="data"><?php echo $event_name; ?></td>
      <td class="data"><?php echo $court_date; ?></td>
      <td class="data"><?php echo $due_date; ?></td>
      <td class="data"><?php echo $received_date; ?></td>
   </tr>
<?php 
      }
?>
</table>
<p align="center"><?php echo mysql_num_rows($result); ?> records matched your search criteria.</p>
<?php 
   /* Free resultset */
   mysql_free_result($result);

   /* Closing connection */
   db_disconnect($link);
}
// Not allowed to access page
else
{
?>
<p class="title2">Display Overdue Court Reports</p>
<p>You are not authorized to access this page.</p>
<?php
}
include("footer.php");
?>



