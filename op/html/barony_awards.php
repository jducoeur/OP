<?php 
include_once("db/db.php");

$barony_id = 0;
if (isset($_GET['barony_id']))
{
   $barony_id = clean($_GET['barony_id']);
}
else if (isset($_POST['barony_id']))
{
   $barony_id = clean($_GET['barony_id']);
}

if ($barony_id > 0)
{
   $link = db_connect();

   $query = "SELECT branch.branch_id, branch.branch, branch.ceremonial_date_founded, branch.device_file_name, branch.website " .
            "FROM $DBNAME_BRANCH.branch " .
            "WHERE branch.branch_id = " . $barony_id;

   /* Performing SQL query */
   $result = mysql_query($query) 
      or die("Barony Query failed : " . mysql_error());

   $data = mysql_fetch_array($result, MYSQL_BOTH);
   $barony_id = clean($data['branch_id']);
   $barony = clean($data['branch']);
   $device_file_name = clean($data['device_file_name']);
   $investiture_date = clean($data['ceremonial_date_founded']);
   $website = clean($data['website']);

   $title = "Atlantian Barony - " . $barony;
   include_once("header.php");
?>
<p class="title2" align="center"><?php echo $title; ?></p>
<p align="center">
<?php 
   if (trim($device_file_name) != "") 
   {
?>
      <img src="<?php echo $BRANCH_IMAGE_DIR . $device_file_name; ?>" width="150" height="200" border="0" alt="Arms of <?php echo $barony; ?>"/>
<?php 
   }
?>
<br/><br/>
First Investiture: <?php echo format_sca_date($investiture_date); ?>
<br/><br/>
<?php 
   if (trim($website) != "") 
   {
?>
      Website: <a href="<?php echo $website; ?>"><?php echo $website; ?></a>
      <br/><br/>
<?php 
   }
?>
<img src="<?php echo $IMAGES_DIR; ?>op-divider.gif" width="648" height="41" border="0" alt="OP Line"/>
</p>
<p class="title3">
The Barons and Baronesses of <?php echo $barony; ?>
</p>
<?php 
   $bb_query = "SELECT b.baronage_id, b.baronage_start_date, b.baronage_end_date, baron_id, baroness_id, a.sca_name AS baron_name, a2.sca_name AS baroness_name, baronage_display " .
               "FROM $DBNAME_OP.baronage b LEFT OUTER JOIN $DBNAME_AUTH.atlantian a ON b.baron_id = a.atlantian_id " .
               "LEFT OUTER JOIN $DBNAME_AUTH.atlantian a2 ON b.baroness_id = a2.atlantian_id " .
               "WHERE b.branch_id = " . $barony_id . " " .
               "ORDER BY b.baronage_start_date";

   /* Performing SQL query */
   $bb_result = mysql_query($bb_query) 
      or die("New Barony Query failed : " . mysql_error());

?>
<br/>
<table align="center" cellpadding="5" cellspacing="0" border="1" summary="Table listing the Barons and Baronesses of <?php echo $barony; ?> in order of investiture">
   <tr>
      <!--<th class="title">#</th>-->
      <th class="title" nowrap="nowrap">Investiture Date</th>
      <th class="title" nowrap="nowrap">Devestiture Date</th>
      <th class="title">Baron</th>
      <th class="title">Baroness</th>
      <th class="title">Term</th>
   </tr>
<?php 
   $i = 0;
   $prev_date = "EMPTY";
   $barray = array();
   while ($bb_data = mysql_fetch_array($bb_result, MYSQL_BOTH))
   {
      $bb_date = clean($bb_data['baronage_start_date']);
      $bb_end_date = clean($bb_data['baronage_end_date']);
      $bb_date_display = "<i>Unknown</i>";
      if ($bb_date != "")
      {
         $bb_date_display = format_sca_date($bb_date);
      }
      $bb_end_date_display = "<i>Unknown</i>";
      if ($bb_end_date != "")
      {
         $bb_end_date_display = format_sca_date($bb_end_date);
      }
      $bb_baronage_id = clean($bb_data['baronage_id']);
      $bb_baron_id = clean($bb_data['baron_id']);
      $bb_baroness_id = clean($bb_data['baroness_id']);
      $bb_baron_name = clean($bb_data['baron_name']);
      $bb_baroness_name = clean($bb_data['baroness_name']);
      $bb_display = clean($bb_data['baronage_display']);
      $bb_display = "<a href=\"awards_by_baronage.php?baronage_id=" . $bb_baronage_id . "&barony_id=" . $barony_id . "\" class=\"td\">" . $bb_display . "</a>";
?>
   <tr>
      <!--<td class="dataright"><?php echo $i; ?></td>-->
      <td class="data" nowrap="nowrap"><?php echo $bb_date_display; ?></td>
      <td class="data" nowrap="nowrap"><?php echo $bb_end_date_display; ?></td>
      <td class="data"><?php if ($bb_baron_name != "" && $bb_baron_id > 0) { echo "<a href=\"op_ind.php?atlantian_id=" . $bb_baron_id . "\" class=\"td\">" . $bb_baron_name . "</a>"; } else { echo "&nbsp;"; } ?></td>
      <td class="data"><?php if ($bb_baroness_name != "" && $bb_baroness_id > 0) { echo "<a href=\"op_ind.php?atlantian_id=" . $bb_baroness_id . "\" class=\"td\">" . $bb_baroness_name . "</a>"; } else { echo "&nbsp;"; } ?></td>
      <td class="data"><?php echo $bb_display; ?></td>
   </tr>
<?php 
   }
?>
</table>
<br/><br/>
<p>A <a href="group_op.php?group_id=<?php echo $barony_id; ?>">Baronial Order of Precedence</a> containing all known members of the Barony</p>
<?php 
   /* Free resultset */
   mysql_free_result($bb_result);

   /* Baronial awards */
   $award_query = "SELECT award_id, award_name, collective_name, award_blurb, award_file_name, website FROM $DBNAME_OP.award WHERE branch_id = $barony_id AND closed = 0";

   /* Performing SQL query */
   $award_result = mysql_query($award_query) 
      or die("Award Query failed : " . mysql_error());
   $num_awards = mysql_num_rows($award_result);
   if ($num_awards > 0)
   {
?>
<br/>
<p class="title3">
The Awards of <?php echo $barony; ?>
</p>
<table align="center" cellpadding="5" cellspacing="0" border="1" summary="Table listing the awards of <?php echo $barony; ?>">
   <tr>
      <th class="title" nowrap="nowrap">Award Name</th>
      <th class="title" nowrap="nowrap">Award Badge</th>
      <th class="title" nowrap="nowrap">Award Description</th>
   </tr>
<?php 
      while ($award_data = mysql_fetch_array($award_result, MYSQL_BOTH))
      {
         $award_id = clean($award_data['award_id']);
         $award_name = clean($award_data['award_name']);
         $award_name_display = $award_name;
         $collective_name = clean($award_data['collective_name']);
         if ($collective_name != "")
         {
            $award_name_display = $collective_name;
         }
         $award_blurb = clean($award_data['award_blurb']);
         $website = clean($award_data['website']);
         $award_file_display = "&nbsp;";
         $award_file_name = clean($award_data['award_file_name']);
         if ($award_file_name != "")
         {
            $award_file_display = '<img src="' . $AWARD_IMAGE_DIR . $award_file_name . '" width="40" height="40" border="0" alt="Badge of ' . $award_name . '" />';
         }
?>
   <tr>
      <td class="data" nowrap="nowrap"><?php echo '<a href="op_award.php?award_id=' . $award_id . '" class="td">' . $award_name_display . '</a>'; ?></td>
      <td class="datacenter"><?php echo $award_file_display; ?></td>
      <td class="data"><?php echo $award_blurb; ?></td>
   </tr>
<?php 
      }
?>
</table>
<?php 
   } // $num_awards > 0
   /* Free resultset */
   mysql_free_result($award_result);

   /* Baronial awards */
   $award_query = "SELECT award_id, award_name, collective_name, award_blurb, award_file_name, website FROM $DBNAME_OP.award WHERE branch_id = $barony_id AND closed = 1";

   /* Performing SQL query */
   $award_result = mysql_query($award_query) 
      or die("Closed Award Query failed : " . mysql_error());
   $num_awards = mysql_num_rows($award_result);
   if ($num_awards > 0)
   {
?>
<br/>
<p class="title3">
The Former Awards of <?php echo $barony; ?>
</p>
<p align="center">
These closed awards and orders are no longer bestowed.
</p>
<table align="center" cellpadding="5" cellspacing="0" border="1" summary="Table listing the awards of <?php echo $barony; ?>">
   <tr>
      <th class="title" nowrap="nowrap">Award Name</th>
      <th class="title" nowrap="nowrap">Award Badge</th>
      <th class="title" nowrap="nowrap">Award Description</th>
   </tr>
<?php 
      while ($award_data = mysql_fetch_array($award_result, MYSQL_BOTH))
      {
         $award_id = clean($award_data['award_id']);
         $award_name = clean($award_data['award_name']);
         $award_name_display = $award_name;
         $collective_name = clean($award_data['collective_name']);
         if ($collective_name != "")
         {
            $award_name_display = $collective_name;
         }
         $award_blurb = clean($award_data['award_blurb']);
         $website = clean($award_data['website']);
         $award_file_display = "&nbsp;";
         $award_file_name = clean($award_data['award_file_name']);
         if ($award_file_name != "")
         {
            $award_file_display = '<img src="' . $AWARD_IMAGE_DIR . $award_file_name . '" width="40" height="40" border="0" alt="Badge of ' . $award_name . '" />';
         }
?>
   <tr>
      <td class="data" nowrap="nowrap"><?php echo '<a href="op_award.php?award_id=' . $award_id . '" class="td">' . $award_name_display . '</a> - CLOSED'; ?></td>
      <td class="datacenter"><?php echo $award_file_display; ?></td>
      <td class="data"><?php echo $award_blurb; ?></td>
   </tr>
<?php 
      }
?>
</table>
<?php 
   } // $num_awards > 0
   /* Free resultset */
   mysql_free_result($award_result);

   /* Closing connection */
   db_disconnect($link);
?>
<p align="center" class="blurb1">
<br/>
Images of Baronial arms courtesy of Corun MacAnndra, Eldred AElfwald, and Darri Kveldulfsson <br/>
(from the Atlantian Scribal web site <a href="http://scribe.atlantia.sca.org/arms_images.php">http://scribe.atlantia.sca.org/arms_images.php</a>).
</p>
<?php 
}
else
{
include_once("header.php");
?>
<p align="center">
No Barony was selected for display.
</p>
<?php 
}
include("footer.php");
?>



