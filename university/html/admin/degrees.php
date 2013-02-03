<?php
include("../db/db.php");
include("db.php");
include("../header.php");
?>
<h2 style="text-align:center">Degrees Earned</h2>
<?php
// Only appropriate admins allowed
if (isset($_SESSION[$UNIVERSITY_ADMIN]) && $_SESSION[$UNIVERSITY_ADMIN] == 1)
{
   $link = db_connect();

   $degree_array = array (
      0 => array (
         "field" => "b",
         "name" => "Bachelors"
         ), 
      1 => array (
         "field" => "f",
         "name" => "Fellowship"
         ), 
      2 => array (
         "field" => "m",
         "name" => "Masters"
         )
      );

   for ($i = 0; $i < count($degree_array); $i++)
   {
      $query = "SELECT participant.participant_id, participant.sca_name, university.university_code, " .
               "participant." . $degree_array[$i]['field'] . "_university_id, participant." . $degree_array[$i]['field'] . "_degree_status_id " .
               "FROM $DBNAME_UNIVERSITY.participant JOIN $DBNAME_UNIVERSITY.university ON participant." . $degree_array[$i]['field'] . "_university_id = university.university_id " .
               "WHERE participant." . $degree_array[$i]['field'] . "_degree_status_id = $STATUS_EARNED " .
               "ORDER BY participant.sca_name";
      $result = mysql_query($query);
?>
<table align="center" border="1" cellpadding="5" cellspacing="0" summary="Degrees Earned">
   <caption class="title"><?php echo $degree_array[$i]['name']; ?></caption>
   <tr>
      <th style="color:<?php echo $accent_color; ?>">Participant</th>
      <th style="color:<?php echo $accent_color; ?>">Session</th>
   </tr>
<?php
      while ($data = mysql_fetch_array($result, MYSQL_BOTH))
      {
         $participant_id = clean($data['participant_id']);
         $sca_name = clean($data['sca_name']);
         $university_code = clean($data['university_code']);
?>
   <tr>
      <td class="data">
      <a style="font-weight:normal" href="<?php echo "participant.php?mode=edit&amp;participant_id=" . $participant_id; ?>"><?php echo htmlentities($sca_name); ?></a>
      </td>
      <td class="data" nowrap><?php echo htmlentities($university_code); ?></td>
   </tr>
<?php 
      }
?>
</table>
<br/>
<?php 
      /* Free resultset */
      mysql_free_result($result);
   }

   /* Closing connection */
   db_disconnect($link);
}
// Not authorized
else
{
?>
<p align="center" class="title2">You are not authorized to access this page.</p>
<?php
}
include("../footer.php");
?>
