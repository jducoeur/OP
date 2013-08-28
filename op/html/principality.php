<?php 
$title = "Territorial Princes and Princesss of Atlantia";
include("header.php");

include("disabled.php");

$link = db_connect();

$query = "SELECT principality.principality_id, prince.sca_name AS prince, princess.sca_name AS princess, principality.prince_id, principality.princess_id, principality.principality_start_date, principality.principality_display " .
         "FROM $DBNAME_AUTH.atlantian prince, $DBNAME_AUTH.atlantian princess, $DBNAME_OP.principality " .
         "WHERE prince.atlantian_id = principality.prince_id " .
         "AND princess.atlantian_id = principality.princess_id " .
         "ORDER BY principality.principality_start_date";

/* Performing SQL query */
$result = mysql_query($query) 
   or die("Monarch Query failed : " . mysql_error());
?>
<p class="title2" align="center">The Territorial Princes and Princesses of Atlantia</p>
<p align="center">
<img src="images/atlantia.gif" width="97" height="118" alt="Arms of Atlantia" border="0"/>
<br/><br/>
Herein lies the Atlantian Royal Lineage in order of reign from the time when Atlantia was a principality of the East Kingdom.
<br/><br/>
<img src="<?php echo $IMAGES_DIR; ?>op-divider.gif" width="648" height="41" border="0" alt="OP Line"/>
</p>
<table align="center" cellpadding="5" cellspacing="0" border="1" summary="Table listing the Princes and Princesses of Atlantia in order of reign">
   <tr>
      <th class="title">#</th>
      <th class="title" nowrap="nowrap">Investiture Date</th>
      <th class="title">Prince</th>
      <th class="title">Princess</th>
      <th class="title">Reign</th>
   </tr>
<?php 
      $i = 1;
      while ($data = mysql_fetch_array($result, MYSQL_BOTH))
      {
         $principality_id = $data['principality_id'];
         $prince = clean($data['prince']);
         $princess = clean($data['princess']);
         $prince_id = $data['prince_id'];
         $princess_id = $data['princess_id'];
         $investiture_date = $data['principality_start_date'];
         $principality_display = clean($data['principality_display']);
?>
   <tr>
      <td class="dataright"><?php echo $i++; ?></td>
      <td class="data" nowrap="nowrap"><?php echo format_sca_date($investiture_date); ?></td>
      <td class="data"><?php echo "<a href=\"op_ind.php?atlantian_id=$prince_id\" class=\"td\">$prince</a>"; ?></td>
      <td class="data"><?php echo "<a href=\"op_ind.php?atlantian_id=$princess_id\" class=\"td\">$princess</a>"; ?></td>
      <td class="data"><?php echo "<a href=\"awards_by_principality.php?principality_id=$principality_id\" class=\"td\">$principality_display</a>"; ?></td>
   </tr>
<?php 
      }
?>
</table>
<?php 
/* Free resultset */
mysql_free_result($result);

/* Closing connection */
db_disconnect($link);

include("footer.php");
?>



