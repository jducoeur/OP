<?php 
include_once("db.php");
include("header.php");

// Only allow authorized users
if (isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN])
{
$link = db_connect();

$query = "SELECT atlantian.sca_name, award.award_name, atlantian_award.award_date, atlantian_award.atlantian_award_id, atlantian.atlantian_id " .
         "FROM $DBNAME_AUTH.atlantian JOIN $DBNAME_OP.atlantian_award ON atlantian.atlantian_id = atlantian_award.atlantian_id " .
         "JOIN $DBNAME_OP.award ON award.award_id = atlantian_award.award_id " .
         "WHERE private = 1 " .
         "ORDER BY atlantian_award.award_date, atlantian_award.sequence ";

/* Performing SQL query */
$result = mysql_query($query) 
   or die("Marked Private Query failed : " . mysql_error());

?>
<p class="title2" align="center">Awards Marked Private</p>
<table align="center" cellpadding="5" cellspacing="0" border="1" summary="Table listing search results">
   <tr>
      <th class="title" nowrap="nowrap">SCA Name</th>
      <th class="title">Award Name</th>
      <th class="title">Award Date</th>
   </tr>
<?php 
      while ($data = mysql_fetch_array($result, MYSQL_BOTH))
      {
         $sca_name = $data['sca_name'];
         $award_name = $data['award_name'];
         $award_date = $data['award_date'];
         $atlantian_id = $data['atlantian_id'];
         $atlantian_award_id = $data['atlantian_award_id'];
?>
   <tr>
      <td class="data"><?php echo $sca_name; ?></td>
      <td class="data" nowrap="nowrap"><?php echo "<a href=\"atlantian_award.php?mode=edit&atlantian_id=$atlantian_id&atlantian_award_id=$atlantian_award_id\">$award_name</a>"; ?></td>
      <td class="data"><?php echo $award_date; ?></td>
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
<p class="title2">Display Private</p>
<p>You are not authorized to access this page.</p>
<?php
}
include("footer.php");
?>



