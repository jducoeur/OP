<?php 
include_once("db.php");
include("header.php");

// Only allow authorized users
if (isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN])
{
$link = db_connect();

$query = "SELECT atlantian.sca_name, award.award_name, atlantian_award.award_date " .
         "FROM $DBNAME_AUTH.atlantian JOIN $DBNAME_OP.atlantian_award ON atlantian.atlantian_id = atlantian_award.atlantian_id " .
         "JOIN $DBNAME_OP.award ON award.award_id = atlantian_award.award_id " .
         "WHERE award.select_branch = 1 " .
         "AND atlantian_award.branch_id IS NULL " .
         "ORDER BY award.award_id, atlantian_award.award_date";

/* Performing SQL query */
$result = mysql_query($query) 
   or die("Unknown Kingdom Query failed : " . mysql_error());

?>
<p class="title2" align="center">Unknown Kingdoms</p>
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

?>
   <tr>
      <td class="data"><?php echo $sca_name; ?></td>
      <td class="data" nowrap="nowrap"><?php echo $award_name; ?></td>
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

$query = "SELECT atlantian.sca_name, award.award_name, award.award_id, 'N/A' as branch, 0 as branch_id " .
         "FROM $DBNAME_AUTH.atlantian JOIN $DBNAME_OP.atlantian_award ON atlantian.atlantian_id = atlantian_award.atlantian_id " .
         "JOIN $DBNAME_OP.award ON award.award_id = atlantian_award.award_id " .
         "WHERE atlantian_award.award_date IS NULL " .
         "AND award.branch_id IS NULL " .
         "AND atlantian_award.branch_id IS NULL " .
         "UNION " .
         "SELECT atlantian.sca_name, award.award_name, award.award_id, branch.branch, branch.branch_id " .
         "FROM $DBNAME_AUTH.atlantian JOIN $DBNAME_OP.atlantian_award ON atlantian.atlantian_id = atlantian_award.atlantian_id " .
         "JOIN $DBNAME_OP.award ON award.award_id = atlantian_award.award_id " .
         "JOIN $DBNAME_BRANCH.branch ON branch.branch_id = award.branch_id " .
         "WHERE atlantian_award.award_date IS NULL " .
         "UNION " .
         "SELECT atlantian.sca_name, award.award_name, award.award_id, branch.branch, branch.branch_id " .
         "FROM $DBNAME_AUTH.atlantian JOIN $DBNAME_OP.atlantian_award ON atlantian.atlantian_id = atlantian_award.atlantian_id " .
         "JOIN $DBNAME_OP.award ON award.award_id = atlantian_award.award_id " .
         "JOIN $DBNAME_BRANCH.branch ON branch.branch_id = atlantian_award.branch_id " .
         "WHERE atlantian_award.award_date IS NULL " .
         "ORDER BY award_id, sca_name";

/* Performing SQL query */
$result = mysql_query($query) 
   or die("Unknown Date Query failed : " . mysql_error());
?>
<p class="title2" align="center">Unknown Dates</p>
<table align="center" cellpadding="5" cellspacing="0" border="1" summary="Table listing search results">
   <tr>
      <th class="title" nowrap="nowrap">SCA Name</th>
      <th class="title">Award Name</th>
      <th class="title">Branch</th>
   </tr>
<?php 
      while ($data = mysql_fetch_array($result, MYSQL_BOTH))
      {
         $sca_name = $data['sca_name'];
         $award_name = $data['award_name'];
         $branch = $data['branch'];
         $branch_id = $data['branch_id'];
         $kingdom = "";
         if ($branch_id > 0)
         {
            $kingdom = get_kingdom($branch_id);
         }
         if ($kingdom != "" && $kingdom != $branch)
         {
            $branch .= ", " . $kingdom;
         }
?>
   <tr>
      <td class="data"><?php echo $sca_name; ?></td>
      <td class="data" nowrap="nowrap"><?php echo $award_name; ?></td>
      <td class="data"><?php echo $branch; ?></td>
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
<p class="title2">Display Unknowns</p>
<p>You are not authorized to access this page.</p>
<?php
}
include("footer.php");
?>



