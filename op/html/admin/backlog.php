<?php 
include_once("db.php");
include("header.php");

// Only allow authorized users
if (isset($_SESSION[$BACKLOG_ADMIN]) && $_SESSION[$BACKLOG_ADMIN])
{
$link = db_connect();

$query = "SELECT atlantian.sca_name, award.award_name, atlantian_award.award_date, atlantian_award.atlantian_award_id, atlantian.atlantian_id, scroll_status.scroll_status " .
         "FROM atlantian JOIN atlantian_award ON atlantian.atlantian_id = atlantian_award.atlantian_id " .
         "JOIN award ON award.award_id = atlantian_award.award_id " .
         "JOIN scroll_status ON scroll_status.scroll_status_id = atlantian_award.scroll_status_id " .
         "ORDER BY scroll_status.scroll_status, atlantian.sca_name ";

/* Performing SQL query */
$result = mysql_query($query) 
   or die("Backlog Query failed : " . mysql_error());

?>
<p class="title2" align="center">Backlog</p>
<table align="center" cellpadding="5" cellspacing="0" border="1" summary="Table listing search results">
   <tr>
      <th class="title" nowrap="nowrap">SCA Name</th>
      <th class="title">Award Name</th>
      <th class="title">Award Date</th>
      <th class="title">Scroll Status</th>
   </tr>
<?php 
      while ($data = mysql_fetch_array($result, MYSQL_BOTH))
      {
         $sca_name = $data['sca_name'];
         $award_name = $data['award_name'];
         $award_date = $data['award_date'];
         $scroll_status = $data['scroll_status'];
         $atlantian_id = $data['atlantian_id'];
         $atlantian_award_id = $data['atlantian_award_id'];
?>
   <tr>
      <td class="data"><?php echo $sca_name; ?></td>
      <td class="data" nowrap="nowrap"><?php echo "<a href=\"atlantian_award.php?mode=edit&atlantian_id=$atlantian_id&atlantian_award_id=$atlantian_award_id\">$award_name</a>"; ?></td>
      <td class="data"><?php echo $award_date; ?></td>
      <td class="data"><?php echo $scroll_status; ?></td>
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
<p class="title2">Backlog</p>
<p>You are not authorized to access this page.</p>
<?php
}
include("footer.php");
?>



