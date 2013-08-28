<?php 
$title = "Baronies of Atlantia";
include("header.php");

include("disabled.php");

$link = db_connect();

$query = "SELECT branch_id, branch, ceremonial_date_founded, device_file_name, website " .
         "FROM $DBNAME_BRANCH.branch " .
         "WHERE branch.branch_type_id = $BT_BARONY " .
         "AND branch.parent_branch_id = $ATLANTIA " .
         "ORDER BY branch.ceremonial_date_founded";

/* Performing SQL query */
$result = mysql_query($query) 
   or die("Barony Query failed : " . mysql_error());
?>
<p class="title2" align="center">The Baronies of the <?php echo $KINGDOM_NAME; ?></p>
<p align="center">
The Baronies of the <?php echo $KINGDOM_NAME; ?>, in order of precedence
<br/><br/>
<img src="<?php echo $IMAGES_DIR; ?>op-divider.gif" width="648" height="41" border="0" alt="OP Line"/>
</p>
<table align="center" cellpadding="5" cellspacing="0" border="1" summary="Table listing the Baronies of the <?php echo $KINGDOM_NAME; ?> in order of founding (first investiture date)">
   <tr>
      <th class="title">#</th>
      <th class="title">Barony</th>
      <th class="title">Arms</th>
      <th class="title" nowrap="nowrap">First Investiture Date</th>
      <th class="title">Founding Baron</th>
      <th class="title">Founding Baroness</th>
   </tr>
<?php 
      $i = 1;
      while ($data = mysql_fetch_array($result, MYSQL_BOTH))
      {
         $barony_id = $data['branch_id'];
         $barony = clean($data['branch']);
         $device_file_name = clean($data['device_file_name']);
         $investiture_date = clean($data['ceremonial_date_founded']);
         $website = clean($data['website']);
         $baronage = get_founding_baronage($barony_id, $link);
?>
   <tr>
      <td class="dataright"><?php echo $i++; ?></td>
      <td class="data"><a href="barony_awards.php?barony_id=<?php echo $barony_id; ?>" class="td"><?php echo $barony; ?></a></td>
      <td class="datacenter">
<?php 
      if (trim($device_file_name) != "") 
      {
         $preimage = "";
         $postimage = "";
         if (trim($website) != "") 
         {
            $preimage = "<a href=\"$website\">";
            $postimage = "</a>";
         }
?>
      <?php echo $preimage; ?><img src="<?php echo $BRANCH_IMAGE_DIR . $device_file_name; ?>" width="75" height="100" border="0" alt="Arms of <?php echo $barony; ?>"/><?php echo $postimage; ?>
<?php 
      }
      else
      {
?>
         &nbsp;
<?php 
      }
?>
      </td>
      <td class="data" nowrap="nowrap"><?php echo format_sca_date($investiture_date); ?></td>
      <td class="data"><?php if ($baronage != NULL && isset($baronage['baron_id'])) { echo "<a href=\"op_ind.php?atlantian_id=" . $baronage['baron_id'] . "\" class=\"td\">" . $baronage['baron'] . "</a>"; } else { echo "&nbsp;"; } ?></td>
      <td class="data"><?php if ($baronage != NULL && isset($baronage['baroness_id'])) { echo "<a href=\"op_ind.php?atlantian_id=" . $baronage['baroness_id'] . "\" class=\"td\">" . $baronage['baroness'] . "</a>"; } else { echo "&nbsp;"; } ?></td>
   </tr>
<?php 
      }
?>
</table>
<p align="center">
Note: The Barony of Myrkewoode is not listed, but its legacy is the Kingdom around us today.
</p>
<p align="center" class="blurb1">

</p>
<?php 
/* Free resultset */
mysql_free_result($result);

/* Closing connection */
db_disconnect($link);

include("footer.php");
?>



