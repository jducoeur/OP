<?php
$title = "OP Event Calendar";
include 'header.php';
?>
<P CLASS="title2">OP Event Calendar</P>
<?php
// Selected someone for edit?
$month = date('n');
$year = date('Y');
if (isset($_REQUEST['month']))
{
   $month = $_REQUEST['month'];
}

if (isset($_REQUEST['year']))
{
   $year = $_REQUEST['year'];
}

if ($month == 13)
{
   $month = 1;
   $year += 1;
}
if ($month == 0)
{
   $month = 12;
   $year -= 1;
}
$date_to_use = strtotime("$month/1/$year");
$month_display = date('F Y', $date_to_use);
$month_start_date = date('Y-m-01', $date_to_use);
$month_end_date = date('Y-m-t', $date_to_use);

$link = db_connect();

// Only events with royal courts are accessible by the backlog
$query = "SELECT event.event_id, event.event_name, branch.branch, event.start_date, event.end_date, count(court_report_id) AS num_courts " .
         "FROM $DBNAME_OP.event JOIN $DBNAME_BRANCH.branch ON event.branch_id = branch.branch_id " .
         "LEFT OUTER JOIN $DBNAME_OP.court_report ON event.event_id = court_report.event_id " .
         "WHERE event.start_date >= '$month_start_date' AND event.start_date <= '$month_end_date' " .
         "AND court_report.court_type = 'R' " .
         "GROUP BY event_id, event_name, branch, start_date, end_date " .
         "ORDER BY event.start_date";

if (isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN])
{
   $query = "SELECT event.event_id, event.event_name, branch.branch, event.start_date, event.end_date " .
            "FROM $DBNAME_OP.event JOIN $DBNAME_BRANCH.branch ON event.branch_id = branch.branch_id " .
            "WHERE event.start_date >= '$month_start_date' AND event.start_date <= '$month_end_date' " .
            "ORDER BY event.start_date";
}

$result = mysql_query($query)
   or die("Event query failed. " . mysql_error());
?>
<P>
<a href="eventop.php?month=<?php echo ($month-1) . '&year=' . $year; ?>">&lt;&lt; Prev</a>
&nbsp;&nbsp;&nbsp;
<a href="eventop.php?month=<?php echo ($month+1) . '&year=' . $year; ?>">Next &gt;&gt;</a>
</P>
<table border="1" cellpadding="5" cellspacing="0" SUMMARY="Kingdom of Atlantia Events for <?php echo $month_display;?>">
   <CAPTION CLASS="title3"><?php echo $month_display;?></CAPTION>
   <tr BGCOLOR="<?php echo $BG_COLOR;?>">
      <th align="left" CLASS="title">Date</th>
      <th align="left" CLASS="title">Event</th>
      <th align="left" CLASS="title">Group</th>
   </tr>
<?php
while ($data = mysql_fetch_array($result, MYSQL_BOTH))
{
   $event_id = $data['event_id'];
   $event_name = $data['event_name'];
   $group = $data['branch'];

   $event_display = '<a href="backlog_court.php?event_id=' . $event_id . '" title="Update Scroll Status">' . $event_name . '</a>';
   if (isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN])
   {
      $event_display = '<a href="event.php?event_id=' . $event_id . '" title="Edit Event">' . $event_name . '</a>';
   }

   $date_display = "&nbsp;";
   $start_date = $data['start_date'];
   if ($start_date != "")
   {
      $start_date = strtotime($start_date);
      $date_display = date('j', $start_date); 
   }
   $end_date = $data['end_date'];
   if ($end_date != "")
   {
      $end_date = strtotime($end_date);
      if ($start_date != $end_date) 
      {
         $date_display .= '-' . date('j', $end_date); 
      }
   }
   if (isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN])
   {
      $date_display = '<a href="backlog_court.php?event_id=' . $event_id . '" title="Update Scroll Status">' . $date_display . '</a>';
   }

?>
  <tr>
    <td class="dataright"><?php echo $date_display ?></td>
    <td class="data"><?php echo $event_display; ?></td>
    <td class="data"><?php echo $group; ?></td>
  </tr>
<?php
}
mysql_free_result($result);
db_disconnect($link);
?>
</table>
<?php include 'footer.php'; ?>
