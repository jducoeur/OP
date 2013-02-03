<?php
include_once("db/defines.php");
include_once("db/validation_format.php");

$title = "Unclaimed Degrees";
include("header.php");
?>
<table border="0" cellpadding="0" width="100%">
   <tr>
      <td class="leftnav">
      <?php include("degree_menu.php"); ?>
      </td>
      <td valign="top">
      <br/>
<h2 style="text-align:center"><?php echo $title; ?></h2>
<p style="text-align:center">The following are degrees that are still in the possession of the Registrar. If your name is below, please come to the registration table at University after convocation to collect your degree.</p>
<?php
/* Connecting, selecting database */
$link = db_connect();

$degree_type_array[0] = $TYPE_BACHELOR;
$degree_type_array[1] = $TYPE_FELLOW;
$degree_type_array[2] = $TYPE_MASTER;
$degree_type_array[3] = $TYPE_DOCTOR;

for ($i = 0; $i < count($degree_type_array); $i++)
{
   $univ_field = strtolower($degree_type_array[$i]) . "_university_id";
   $deg_field = strtolower($degree_type_array[$i]) . "_degree_status_id";

   $type_description = "Bachelors of SCA Studies";
   switch ($degree_type_array[$i])
   {
      case $TYPE_FELLOW:
         $type_description = "Fellows of the University of Atlantia";
         break;
      case $TYPE_MASTER:
         $type_description = "Masters of SCA Studies";
         break;
      case $TYPE_DOCTOR:
         $type_description = "Honorary Doctors of the University of Atlantia";
         break;
   }

   $query = "SELECT university.university_code, participant.$deg_field, participant.sca_name " .
            "FROM $DBNAME_UNIVERSITY.participant " .
            "JOIN $DBNAME_UNIVERSITY.university ON participant.$univ_field = university.university_id " .
            "WHERE participant.$deg_field = $STATUS_PRINTED " .
            "ORDER BY university.university_date, participant.sca_name";
   $result = mysql_query($query)
      or die("Degree Claimaint Query failed : " . $query . "<br/>" . mysql_error());
   $num_recipients = mysql_num_rows($result);
?>
<h3 style="text-align:center"><?php echo $type_description; ?></h3>
<?php
   if ($num_recipients > 0)
   {
?>
<table align="center" cellpadding="2" cellspacing="0">
   <tr>
      <td>
      <table align="center" cellpadding="2" cellspacing="0">
<?php
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
      }
?>
      </table>
      </td>
   </tr>
</table>
<p style="text-align:center">There <?php if ($num_recipients != 1) { echo "are"; } else { echo "is"; } ?> <?php echo $num_recipients; ?> unclaimed degree<?php if ($num_recipients != 1) { echo "s"; } ?>.</p>
<?php
   }
   else
   {
?>
<p style="text-align:center">There are no unclaimed degrees.</p>
<?php
   }
   mysql_free_result($result);
}
?>
      </td>
   </tr>
</table>
<?php
db_disconnect($link);
include("footer.php");
?>