<?php 
include_once("db.php");
include("header.php");

// Only allow authorized users
if (isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN])
{
$link = db_connect();

$query = "SELECT sca_name, first_name, last_name, deceased_date " .
         "FROM $DBNAME_AUTH.atlantian " .
         "WHERE deceased = 1 " .
         "ORDER BY sca_name";

/* Performing SQL query */
$result = mysql_query($query) 
   or die("Deceased Query failed : " . mysql_error());

?>
<p class="title2" align="center">Deceased</p>
<table align="center" cellpadding="5" cellspacing="0" border="1" summary="Table listing search results">
   <tr>
      <th class="title" nowrap="nowrap">SCA Name</th>
      <th class="title">Real Name</th>
      <th class="title">Deceased Date</th>
   </tr>
<?php 
      while ($data = mysql_fetch_array($result, MYSQL_BOTH))
      {
         $sca_name = $data['sca_name'];
         $first_name = $data['first_name'];
         $last_name = $data['last_name'];
         $deceased_date = $data['deceased_date'];

?>
   <tr>
      <td class="data"><?php echo $sca_name; ?></td>
      <td class="data" nowrap="nowrap"><?php echo $first_name . " " . $last_name; ?></td>
      <td class="data"><?php echo $deceased_date; ?></td>
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
<p class="title2">Display Deceased</p>
<p>You are not authorized to access this page.</p>
<?php
}
include("footer.php");
?>



