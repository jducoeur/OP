<?php 
$title = "Kings and Queens of Atlantia";
include("header.php");

$link = db_connect();

$query = "SELECT reign.reign_id, king.sca_name AS king, queen.sca_name AS queen, reign.king_id, reign.queen_id, reign.reign_start_date, reign.monarchs_display " .
         "FROM $DBNAME_AUTH.atlantian king, $DBNAME_AUTH.atlantian queen, $DBNAME_OP.reign " .
         "WHERE king.atlantian_id = reign.king_id " .
         "AND queen.atlantian_id = reign.queen_id " .
         "ORDER BY reign.reign_start_date";

/* Performing SQL query */
$result = mysql_query($query) 
   or die("Monarch Query failed : " . mysql_error());
?>
<p class="title2" align="center">The Kings and Queens of the <?php echo $KINGDOM_NAME; ?></p>
<p align="center">
<img src="images/east.gif" width="97" height="118" alt="Arms of the <?php echo $KINGDOM_NAME; ?>" border="0"/>
<br/><br/>
Herein lies the <?php echo $KINGDOM_ADJ; ?> Royal Lineage in order of reign.
<br/><br/>
<img src="<?php echo $IMAGES_DIR; ?>op-divider.gif" width="648" height="41" border="0" alt="OP Line"/>
</p>
<table align="center" cellpadding="5" cellspacing="0" border="1" summary="Table listing the Kings and Queens of the <?php echo $KINGDOM_NAME; ?> in order of reign">
   <tr>
      <th class="title">#</th>
      <th class="title" nowrap="nowrap">Coronation Date</th>
      <th class="title">King</th>
      <th class="title">Queen</th>
      <th class="title">Reign</th>
   </tr>
<?php 
      $i = 1;
      while ($data = mysql_fetch_array($result, MYSQL_BOTH))
      {
         $reign_id = $data['reign_id'];
         $king = clean($data['king']);
         $queen = clean($data['queen']);
         $king_id = $data['king_id'];
         $queen_id = $data['queen_id'];
         $coronation_date = $data['reign_start_date'];
         $monarchs_display = clean($data['monarchs_display']);
?>
   <tr>
      <td class="dataright"><?php echo $i++; ?></td>
      <td class="data" nowrap="nowrap"><?php echo format_sca_date($coronation_date); ?></td>
      <td class="data"><?php echo "<a href=\"op_ind.php?atlantian_id=$king_id\" class=\"td\">$king</a>"; ?></td>
      <td class="data"><?php echo "<a href=\"op_ind.php?atlantian_id=$queen_id\" class=\"td\">$queen</a>"; ?></td>
      <td class="data"><?php echo "<a href=\"awards_by_reign.php?reign_id=$reign_id\" class=\"td\">$monarchs_display</a>"; ?></td>
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



