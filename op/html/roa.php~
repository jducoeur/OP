<?php
include_once("db/host_defines.php");
include_once("admin/session.php");

$title = "Atlantian Roll of Arms";
include('db/db.php');
include('header.php');

$pagewidth = "";
$printstyle = "";
$parastyle = "";
$cellstyle = 5;
if (isset($printable) && $printable == 1)
{
   $pagewidth = ' width="650"';
   $printstyle = "p";
   $parastyle = ' style="font-size:8px"';
   $cellstyle = 1;
}

/* Connecting, selecting database */
$link = db_connect();

/* Performing SQL query */
$query = 
      "SELECT atlantian.atlantian_id, atlantian.sca_name, atlantian.alternate_names, atlantian.name_reg_date, atlantian.blazon, atlantian.device_reg_date, atlantian.device_file_name, atlantian.device_file_credit, atlantian.gender, " .
      "atlantian.deceased, atlantian.deceased_date, atlantian.revoked, atlantian.revoked_date, atlantian.branch_id, branch.branch ".
      "FROM $DBNAME_AUTH.atlantian LEFT OUTER JOIN $DBNAME_BRANCH.branch ON atlantian.branch_id = branch.branch_id " .
      "WHERE atlantian.device_file_name IS NOT NULL ".
      "ORDER BY sca_name";

$result = mysql_query($query) 
   or die("Query failed : " . mysql_error());
$num_roa_people = mysql_num_rows($result);

/* Printing results in HTML */
?>
<p align="center" class="title2">Atlantian Roll of Arms</p>
<p align="center">Atlantians with emblazons are listed alphabetically by SCA name</p>
<table <?php echo $pagewidth; ?> border="1" align="center" cellpadding="<?php echo $cellstyle; ?>" cellspacing="0" summary="Roll of Arms for the Kingdom of Atlantia">
   <tr>
      <th scope="col" class="<?php echo $printstyle; ?>title">Atlantian</th>
      <th scope="col" class="<?php echo $printstyle; ?>title">Emblazon</th>
   </tr>
<?php
while ($data = mysql_fetch_array($result, MYSQL_BOTH)) 
{
   $atlantian_id = $data['atlantian_id'];
   $sca_name = clean($data['sca_name']);
   $alternate_names = clean($data['alternate_names']);
   $name_reg_date = clean($data['name_reg_date']);
   $blazon = clean($data['blazon']);
   $device_reg_date = clean($data['device_reg_date']);
   $device_file_name = clean($data['device_file_name']);
   $device_file_credit = clean($data['device_file_credit']);
   $gender = clean($data['gender']);
   $title = get_current_title($atlantian_id);
   $deceased = clean($data['deceased']);
   $deceased_date = clean($data['deceased_date']);
   $deceased_display = "";
   if ($deceased == 1)
   {
      $deceased_display = " - DECEASED";
      if ($deceased_date != "")
      {
         $deceased_display .= " " . format_short_date($deceased_date);
      }
   }
   $revoked = clean($data['revoked']);
   $revoked_date = clean($data['revoked_date']);
   $revoked_display = "";
   if ($revoked == 1)
   {
      $revoked_display = "<br><br>REVOKED AND DENIED";
      if ($revoked_date != "")
      {
         $revoked_display .= " " . format_short_date($revoked_date);
      }
      $revoked_display .= "<br/>SCA Membership has been revoked.";
   }
   $local_group = clean($data['branch']);
   $local_group_id = $data['branch_id'];
   if ($local_group_id != "" && $local_group_id > 0)
   {
      $kingdom = get_kingdom($local_group_id);
      if ($kingdom != $local_group)
      {
         $local_group .= ", $kingdom";
      }
   }

   $preferred_sca_name = get_preferred_sca_name($atlantian_id, $sca_name);
   $link = db_connect();
?>
   <tr>
      <td valign="top" class="<?php echo $printstyle; ?>datacenter">
      <a style="font-weight:bold;color:#006633" href="op_ind.php?atlantian_id=<?php echo $atlantian_id; ?>"><?php echo $title . ' ' . $sca_name . $preferred_sca_name . $deceased_display . $revoked_display; ?></a>
      <br/><br/>
<?php 
   if (trim($alternate_names) != "")
   {
?>
      <i>AKA <?php echo $alternate_names; ?></i>
      <br/><br/>
<?php 
   }
   if (trim($local_group) != "")
   {
      echo $local_group;
?>
      <br/><br/>
<?php 
   }
   if ($blazon != NULL)
   {
      echo $blazon . "<br/><br/>";
   }
   if ($name_reg_date != NULL)
   {
      $name_reg_date = format_full_month_date($name_reg_date);
?>
      <i>Name registered with the College of Arms in <?php echo $name_reg_date; ?>.</i>
      <br/><br/>
<?php
   }
   if ($device_reg_date != NULL)
   {
      $device_reg_date = format_full_month_date($device_reg_date);
?>
      <i>Device registered with the College of Arms in <?php echo $device_reg_date; ?>.</i>
      <br/><br/>
<?php
   }
   if (trim($device_file_credit) != "")
   {
?>
<?php if (!isset($printable) || $printable != 1) { echo "<span class=\"blurb1\">"; } ?>
      Device image courtesy of <?php echo $device_file_credit; ?>.
<?php if (!isset($printable) || $printable != 1) { echo "</span>"; } ?>
<?php 
   }
?>
      </td>
      <td valign="top" class="<?php echo $printstyle; ?>datacenter">
<?php
   if (trim($device_file_name) != "")
   {
?>
<img src="<?php echo $DEVICE_IMAGE_DIR . $device_file_name; ?>" height="250" border="0" alt="<?php echo "Device of $sca_name"; ?>"/>
<?php
   }
?>
      </td>
   </tr>
<?php
}

/* Free resultset */
mysql_free_result($result);

/* Closing connection */
db_disconnect($link);
?>
</table>
<?php 
if (isset($num_roa_people) && $num_roa_people > 0)
{
?>
<p align="center"<?php echo $parastyle; ?>>There are <?php echo $num_roa_people; ?> people listed in Atlantia's Roll of Arms.</p>
<?php 
}
if (!isset($printable) || $printable != 1)
{
?>
<p align="center" class="blurb1">
Device images are the property of their creators and are used here with permission.  
For information on using device images from this website, please contact the 
Clerk of Precedence (<a href="<?php echo $HOME_DIR; ?>functions/mailto.php?u=op&amp;d=atlantia.sca.org" target="redir">op AT atlantia.sca.org</a>), 
who will assist you in contacting the original creator of the piece. Please respect the legal rights of our contributors.
</p>
<?php 
}
include('footer.php'); 
?>
