<?php 
include_once("db/db.php");

$link = db_connect();

// Entered Court Reports
$query = "SELECT event_name, court_type, court_date, court_time, branch.branch, k.branch AS kingdom, baronage_id, entered_date " .
         "FROM $DBNAME_OP.court_report JOIN $DBNAME_OP.event ON court_report.event_id = event.event_id " .
         "LEFT OUTER JOIN $DBNAME_BRANCH.branch ON event.branch_id = branch.branch_id " .
         "LEFT OUTER JOIN $DBNAME_BRANCH.branch k ON court_report.kingdom_id = k.branch_id " .
         "WHERE entered_date > DATE_SUB(CURDATE(), INTERVAL 1 MONTH) " .
         "ORDER BY entered_date";

/* Performing SQL query */
$result = mysql_query($query) 
   or die("Entered Reports Query failed : " . mysql_error());

if (mysql_num_rows($result) > 0)
{
?>
<table border="1" cellpadding="5" cellspacing="0" summary="Lists court reports recently received and entered into the Order of Precedence">
   <caption class="title2">Recently Entered Court Reports</caption>
   <tr>
      <th class="title">Event</th>
      <th class="title">Host Group</th>
      <th class="title">Court Date</th>
      <th class="title">Court Type</th>
      <th class="title">Court Time</th>
      <th class="title">Date Entered</th>
   </tr>
<?php
   while ($data = mysql_fetch_array($result, MYSQL_BOTH))
   {
      $event_name = clean($data['event_name']);
      $branch = clean($data['branch']);
      $kingdom = clean($data['kingdom']);
      $court_date = clean($data['court_date']);
      $court_type = clean($data['court_type']);
      $court_time = clean($data['court_time']);
      $baronage_id = clean($data['baronage_id']);
      $entered_date = clean($data['entered_date']);

      $court_type_display = translate_court_type($court_type);
      if ($court_type == $COURT_TYPE_BARONIAL && $baronage_id != "")
      {
         $court_type_display .= " - " . clean(get_barony_name_from_baronage_id($baronage_id));
      }
      if ($court_type == $COURT_TYPE_ROYAL && $kingdom != "")
      {
         $court_type_display .= " - " . $kingdom;
      }
?>
   <tr>
      <td class="data"><?php echo $event_name; ?></td>
      <td class="data"><?php echo $branch; ?></td>
      <td class="datacenter"><?php echo format_short_date($court_date); ?></td>
      <td class="datacenter"><?php echo $court_type_display; ?></td>
      <td class="datacenter"><?php echo translate_court_time($court_time); ?></td>
      <td class="datacenter"><?php echo format_short_date($entered_date); ?></td>
   </tr>
<?php
   }
?>
</table>
<br/>
<?php
} // Entered Court Reports

// Received Court Reports
$query = "SELECT event_name, court_type, court_date, court_time, branch.branch, k.branch AS kingdom, baronage_id, herald, received_date " .
         "FROM $DBNAME_OP.court_report JOIN $DBNAME_OP.event ON court_report.event_id = event.event_id " .
         "LEFT OUTER JOIN $DBNAME_BRANCH.branch ON event.branch_id = branch.branch_id " .
         "LEFT OUTER JOIN $DBNAME_BRANCH.branch k ON court_report.kingdom_id = k.branch_id " .
         "WHERE received_date IS NOT NULL " .
         "AND entered_date IS NULL " .
         "ORDER BY court_date, court_type DESC, court_time";

/* Performing SQL query */
$result = mysql_query($query) 
   or die("Received Reports Query failed : " . mysql_error());

if (mysql_num_rows($result) > 0)
{
?>
<table border="1" cellpadding="5" cellspacing="0" summary="Lists information about expected court reports">
   <caption class="title2">Received Court Reports</caption>
   <tr>
      <th class="title">Event</th>
      <th class="title">Host Group</th>
      <th class="title">Court Date</th>
      <th class="title">Court Type</th>
      <th class="title">Court Time</th>
      <th class="title">Herald</th>
      <th class="title">Date Received</th>
   </tr>
<?php
   while ($data = mysql_fetch_array($result, MYSQL_BOTH))
   {
      $event_name = clean($data['event_name']);
      $branch = clean($data['branch']);
      $kingdom = clean($data['kingdom']);
      $court_date = clean($data['court_date']);
      $court_type = clean($data['court_type']);
      $court_time = clean($data['court_time']);
      $baronage_id = clean($data['baronage_id']);
      $court_type_display = translate_court_type($court_type);
      if ($court_type == $COURT_TYPE_BARONIAL && $baronage_id != "")
      {
         $court_type_display .= " - " . get_barony_name_from_baronage_id($baronage_id);
      }
      if ($court_type == $COURT_TYPE_ROYAL && $kingdom != "")
      {
         $court_type_display .= " - " . $kingdom;
      }
      $herald = clean($data['herald']);
      if ($herald == "")
      {
         $herald = "&nbsp;";
      }
      $received_date = clean($data['received_date']);
?>
   <tr>
      <td class="data"><?php echo $event_name; ?></td>
      <td class="data"><?php echo $branch; ?></td>
      <td class="datacenter"><?php echo format_short_date($court_date); ?></td>
      <td class="datacenter"><?php echo $court_type_display; ?></td>
      <td class="datacenter"><?php echo translate_court_time($court_time); ?></td>
      <td class="data"><?php echo $herald; ?></td>
      <td class="datacenter"><?php echo format_short_date($received_date); ?></td>
   </tr>
<?php 
   }
?>
</table>
<br/>
<?php
} // Received

// Expected Court Reports
$query = "SELECT event_name, court_type, court_date, court_time, branch.branch, k.branch AS kingdom, baronage_id, herald, DATE_ADD(end_date, INTERVAL 14 DAY) AS due_date, CURDATE() AS today " .
         "FROM $DBNAME_OP.court_report JOIN $DBNAME_OP.event ON court_report.event_id = event.event_id " .
         "LEFT OUTER JOIN $DBNAME_BRANCH.branch ON event.branch_id = branch.branch_id " .
         "LEFT OUTER JOIN $DBNAME_BRANCH.branch k ON court_report.kingdom_id = k.branch_id " .
         "WHERE received_date IS NULL " .
         "ORDER BY court_date, court_type DESC, court_time";

/* Performing SQL query */
$result = mysql_query($query) 
   or die("Expected Reports Query failed : " . mysql_error());

if (mysql_num_rows($result) > 0)
{
?>
<table border="1" cellpadding="5" cellspacing="0" summary="Lists information about expected court reports">
   <caption class="title2">Expected Court Reports</caption>
   <tr>
      <th class="title">Event</th>
      <th class="title">Host Group</th>
      <th class="title">Court Date</th>
      <th class="title">Court Type</th>
      <th class="title">Court Time</th>
      <th class="title">Herald</th>
      <th class="title">Due Date</th>
   </tr>
<?php
   while ($data = mysql_fetch_array($result, MYSQL_BOTH))
   {
      $event_name = clean($data['event_name']);
      $branch = clean($data['branch']);
      $kingdom = clean($data['kingdom']);
      $court_date = clean($data['court_date']);
      $court_type = clean($data['court_type']);
      $court_time = clean($data['court_time']);
      $baronage_id = clean($data['baronage_id']);
      $court_type_display = translate_court_type($court_type);
      if ($court_type == $COURT_TYPE_BARONIAL && $baronage_id != "")
      {
         $court_type_display .= " - " . get_barony_name_from_baronage_id($baronage_id);
      }
      if ($court_type == $COURT_TYPE_ROYAL && $kingdom != "")
      {
         $court_type_display .= " - " . $kingdom;
      }
      $herald = clean($data['herald']);
      if ($herald == "")
      {
         $herald = "&nbsp;";
      }
      $due_date = clean($data['due_date']);
      $today = clean($data['today']);
      $style = "";
      if (strtotime($today) > strtotime($due_date))
      {
         $style = " style=\"color:red\"";
      }
?>
   <tr>
      <td class="data"><?php echo $event_name; ?></td>
      <td class="data"><?php echo $branch; ?></td>
      <td class="datacenter"><?php echo format_short_date($court_date); ?></td>
      <td class="datacenter"><?php echo $court_type_display; ?></td>
      <td class="datacenter"><?php echo translate_court_time($court_time); ?></td>
      <td class="data"><?php echo $herald; ?></td>
      <td class="datacenter"><b<?php echo $style; ?>><?php echo format_short_date($due_date); ?></b></td>
   </tr>
<?php 
   }
?>
</table>
<br/>
<?php
} // Expected

/* Free resultset */
mysql_free_result($result);

/* Closing connection */
db_disconnect($link);
?>
