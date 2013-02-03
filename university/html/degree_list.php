<?php
include_once("db/defines.php");
include_once("db/validation_format.php");

$type = "";
if (isset($_REQUEST['type']))
{
   $type = clean($_REQUEST['type']);
}

if ($type != $TYPE_BACHELOR && $type != $TYPE_FELLOW && $type != $TYPE_MASTER && $type != $TYPE_DOCTOR)
{
   $type = $TYPE_BACHELOR;
}

$type_description = "Bachelors of SCA Studies";
$university_field = "b_university_id";
switch ($type)
{
   case $TYPE_FELLOW:
      $type_description = "Fellows of the University of Atlantia";
      $university_field = "f_university_id";
      break;
   case $TYPE_MASTER:
      $type_description = "Masters of SCA Studies";
      $university_field = "m_university_id";
      break;
   case $TYPE_DOCTOR:
      $type_description = "Honorary Doctors of the University of Atlantia";
      $university_field = "d_university_id";
      break;
}

$title = $type_description;
include("header.php");
?>
<table border="0" cellpadding="0" width="100%">
   <tr>
      <td class="leftnav">
      <?php include("degree_menu.php"); ?>
      </td>
      <td valign="top">
      <br/>
<h2 style="text-align:center"><?php echo $type_description; ?></h2>
<?php
/* Connecting, selecting database */
$link = db_connect();

$query = "SELECT university.university_code, participant.sca_name " .
         "FROM $DBNAME_UNIVERSITY.participant JOIN $DBNAME_UNIVERSITY.university ON participant.$university_field = university.university_id " .
         "WHERE participant.$university_field IS NOT NULL ORDER BY university.university_date, participant.sca_name";
$result = mysql_query($query)
   or die("Degree Recipient Query failed : " . $query . "<br/>" . mysql_error());
$num_recipients = mysql_num_rows($result);
?>
<table align="center" cellpadding="2" cellspacing="0">
   <tr>
      <td>
      <table align="center" cellpadding="2" cellspacing="0">
<?php
$i = 0;
while ($data = mysql_fetch_array($result, MYSQL_BOTH))
{
   $university_code = clean($data['university_code']);
   $sca_name = clean($data['sca_name']);
?>
         <tr>
            <td><?php echo $sca_name; ?></td>
            <td><?php echo $university_code; ?></td>
         </tr>
<?php
   $i++;
}
?>
      </table>
      </td>
   </tr>
</table>
<p style="text-align:center">There are <?php echo $num_recipients; ?> recipients.</p>
      </td>
   </tr>
</table>
<?php
mysql_free_result($result);
db_disconnect($link);
include("footer.php");
?>