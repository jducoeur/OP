<?php 
include_once("db/host_defines.php");
include_once("admin/session.php");

$baronage_id = 0;
if (isset($_GET['baronage_id']))
{
   $baronage_id = $_GET['baronage_id'];
}
$barony_id = 0;
if (isset($_GET['barony_id']))
{
   $barony_id = $_GET['barony_id'];
}
$title = "Awards by Baronage";
include("header.php");

include("disabled.php");

$link = db_connect();

$baronage_query = "SELECT baronage_id FROM $DBNAME_OP.baronage WHERE branch_id = $barony_id AND baronage_start_date IN (SELECT MAX(baronage_start_date) FROM $DBNAME_OP.baronage WHERE branch_id = $barony_id)";
/* Performing SQL query */
$baronage_result = mysql_query($baronage_query) 
   or die("Baronage ID Query failed : " . mysql_error());
$baronage_data = mysql_fetch_array($baronage_result, MYSQL_BOTH);
$max_baronage_id = $baronage_data['baronage_id'];

$baronage_query = "SELECT baronage_id FROM baronage WHERE baronage_id = $baronage_id AND branch_id = $barony_id";
/* Performing SQL query */
$baronage_result = mysql_query($baronage_query) 
   or die("Baronage Check Query failed : " . mysql_error());
$b_check = mysql_num_rows($baronage_result);

// Get current baronage if no baronage or invalid baronage specified
if ($baronage_id == 0 || $b_check == 0)
{
   $baronage_id = $max_baronage_id;
}

// Get information on the selected baronage
$query = "SELECT b1.sca_name AS baron, b2.sca_name AS baroness, baronage.baron_id, baronage.baroness_id, baronage.baronage_start_date, baronage.baronage_display, baronage.baronage_start_sequence, " .
         "baronage.branch_id, branch.branch " .
         "FROM $DBNAME_OP.baronage JOIN $DBNAME_BRANCH.branch ON baronage.branch_id = branch.branch_id " .
         "LEFT OUTER JOIN $DBNAME_AUTH.atlantian b1 ON baronage.baron_id = b1.atlantian_id " .
         "LEFT OUTER JOIN $DBNAME_AUTH.atlantian b2 ON baronage.baroness_id = b2.atlantian_id " .
         "WHERE baronage.baronage_id = $baronage_id";

/* Performing SQL query */
$result = mysql_query($query) 
   or die("Baronage Query failed : " . mysql_error());

$data = mysql_fetch_array($result, MYSQL_BOTH);
$baron_id = $data['baron_id'];
$baron = clean($data['baron']);
$baroness_id = $data['baroness_id'];
$baroness = clean($data['baroness']);
$investiture_date = $data['baronage_start_date'];
$start_sequence = $data['baronage_start_sequence'];
$baronage_display = clean($data['baronage_display']);
$branch_id = $data['branch_id'];
$branch = clean($data['branch']);

// Get end of baronage information from the next baronage
$next_query = "SELECT baronage_id, baronage_start_date, baronage_start_sequence " .
              "FROM $DBNAME_OP.baronage " .
              "WHERE branch_id = $barony_id AND baronage_start_date > " . value_or_null(format_mysql_date($investiture_date)) . " " .
              "ORDER BY baronage_start_date";

/* Performing SQL query */
$next_result = mysql_query($next_query) 
   or die("Next Baronage Query failed : " . mysql_error());
$num_post_baronages = mysql_num_rows($next_result);
// First record contains next baronage
if ($num_post_baronages > 0)
{
   $next_data = mysql_fetch_array($next_result, MYSQL_BOTH);
   $next_baronage_id = $next_data['baronage_id'];
   $next_investiture_date = $next_data['baronage_start_date'];
   $next_start_sequence = $next_data['baronage_start_sequence'];
}
// This is the current baronage - use dummy values
else
{
   $next_baronage_id = 0;
   $next_investiture_date = date("Y-m-d");
   $next_start_sequence = 100;
}

$baronage_start_date_clause = 
   "AND (atlantian_award.award_date > " . value_or_null(format_mysql_date($investiture_date)) . " OR (atlantian_award.award_date = " . value_or_null(format_mysql_date($investiture_date)) . " AND atlantian_award.sequence > $start_sequence)) ";
$baronage_end_date_clause = 
   "AND (atlantian_award.award_date < " . value_or_null(format_mysql_date($next_investiture_date)) . " OR (atlantian_award.award_date = " . value_or_null(format_mysql_date($next_investiture_date)) . " AND atlantian_award.sequence < $next_start_sequence)) ";
if ($start_sequence == 0)
{
   $baronage_start_date_clause = "AND (atlantian_award.award_date >= " . value_or_null(format_mysql_date($investiture_date)) . ") ";
}
if ($next_baronage_id > 0 && $next_start_sequence == 0)
{
   $baronage_end_date_clause = "AND (atlantian_award.award_date <= " . value_or_null(format_mysql_date($next_investiture_date)) . ") ";
}
// Award list query
$award_query =
   "SELECT atlantian.atlantian_id, atlantian.sca_name, atlantian.gender, atlantian.first_name, atlantian.last_name, " .
   "award.award_name, award.award_id, award.award_group_id, award.type_id, " .
   "atlantian_award.award_date, atlantian_award.sequence, atlantian_award.private, " .
   "event.event_id, event.event_name, event_loc.branch as location, court_report.baronage_id " .
   "FROM $DBNAME_AUTH.atlantian JOIN $DBNAME_OP.atlantian_award ON atlantian.atlantian_id = atlantian_award.atlantian_id " .
   "JOIN $DBNAME_OP.award ON atlantian_award.award_id = award.award_id " .
   "LEFT OUTER JOIN $DBNAME_OP.event ON atlantian_award.event_id = event.event_id " .
   "LEFT OUTER JOIN $DBNAME_BRANCH.branch event_loc ON event.branch_id = event_loc.branch_id " .
   "LEFT OUTER JOIN $DBNAME_OP.court_report ON atlantian_award.court_report_id = court_report.court_report_id " .
   "WHERE award.type_id IN (20, 21) " . 
   "AND award.branch_id = $branch_id " .
   $baronage_start_date_clause . $baronage_end_date_clause .
   "ORDER BY award_date, event_id, sequence, sca_name";

/* Performing SQL query */
$award_result = mysql_query($award_query) 
   or die("Award Query failed : " . mysql_error());
?>
<p class="title2" align="center">Awards by Baronage<br/><br/><?php echo $baronage_display; ?><br/>Barony of <?php echo $branch; ?><br/><?php echo format_sca_date($investiture_date) . " - " . format_sca_date($next_investiture_date); ?></p>
<p align="center">
<img src="images/atlantia.gif" width="97" height="118" alt="Arms of Atlantia" border="0"/>
<br/><br/>
Awards bestowed during this term in the order bestowed, grouped by event.
<br/><br/>
<?php 
if ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) || (isset($_SESSION[$BACKLOG_ADMIN]) && $_SESSION[$BACKLOG_ADMIN]))
{
?>
<img src="<?php echo $IMAGES_DIR; ?>private.gif" width="15" height="15" alt="Marked Private" border="0"/> Lock icon indicates record is marked private.
<br/><br/>
<?php 
}
?>
<img src="<?php echo $IMAGES_DIR; ?>op-divider.gif" width="648" height="41" border="0" alt="OP Line"/>
</p>
<table align="center" cellpadding="5" cellspacing="0" border="1" summary="Table listing the awards given by this baronage">
<?php 
      $i = 1;
      $prev_event_id = 0;
      $first_time = 1;
      $num_cols = 4;
      if ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) || (isset($_SESSION[$BACKLOG_ADMIN]) && $_SESSION[$BACKLOG_ADMIN]))
      {
         $num_cols = 6;
      }
      while ($award_data = mysql_fetch_array($award_result, MYSQL_BOTH))
      {
         $event_id = $award_data['event_id'];
         if ((($event_id == null || $event_id == '') && $first_time == 1) || 
             (($event_id != null && $event_id != '' && $event_id > 0) && $event_id != $prev_event_id))
         {
            if ($event_id != null && $event_id != '' && $event_id > 0)
            {
               $event_name = clean($award_data['event_name']);
               $event_display = "<a href=\"" . $HOME_DIR . "op_event.php?event_id=" . $award_data['event_id'] . "\" class=\"th\">" . $event_name . "</a>";
               $event_loc = clean($award_data['location']);
               $prev_event_id = $event_id;
               $first_time = 1; // Print name headers again after this event is done
?>
   <tr>
      <th class="title" colspan="<?php echo $num_cols; ?>"><?php echo $event_display . " (" . $event_loc . ")"; ?></th>
   </tr>
<?php 
            }
            else
            {
               $first_time = 0;
            }
?>
   <tr>
      <th class="title">#</th>
      <th class="title" nowrap="nowrap">Recipient</th>
<?php 
            if ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) || (isset($_SESSION[$BACKLOG_ADMIN]) && $_SESSION[$BACKLOG_ADMIN]))
            {
?>
      <th class="title" nowrap="nowrap">Real Name</th>
<?php 
            }
?>
      <th class="title">Award</th>
      <th class="title">Date</th>
<?php 
            if ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) || (isset($_SESSION[$BACKLOG_ADMIN]) && $_SESSION[$BACKLOG_ADMIN]))
            {
?>
      <th class="title">Sequence</th>
<?php 
            }
?>
   </tr>
<?php
         }
         $sca_name = clean($award_data['sca_name']);
         $name_display = $sca_name;
         if (!$printable)
         {
            $atlantian_id = clean($award_data['atlantian_id']);
            $name_display = "<a href=\"op_ind.php?atlantian_id=$atlantian_id\" class=\"td\">$sca_name</a>";
         }
         $gender = $award_data['gender'];
         $first_name = clean($award_data['first_name']);
         $last_name = clean($award_data['last_name']);
         $award_name = clean($award_data['award_name']);
         $award_name_display = $award_name;
         if (!$printable)
         {
            $award_id = clean($award_data['award_id']);
            $award_group_id = clean($award_data['award_group_id']);
            $type_id = clean($award_data['type_id']);
            if (is_award_linkable($award_id, $award_group_id, $type_id, $ATLANTIA_NAME))
            {
               if ($award_group_id > 0)
               {
                  $award_name_display = "<a href=\"" . $HOME_DIR . "op_award.php?award_group_id=" . $award_group_id . "\" class=\"td\">" . $award_name_display . "</a>";
               }
               else
               {
                  $award_name_display = "<a href=\"" . $HOME_DIR . "op_award.php?award_id=" . $award_id . "\" class=\"td\">" . $award_name_display . "</a>";
               }
            }
         }
         $award_date = $award_data['award_date'];
         $sequence = $award_data['sequence'];
         $award_baronage_id = $award_data['baronage_id'];
         // Only display awards that are definitely not from another term
         if (!(($award_baronage_id != "" && $award_baronage_id != $baronage_id) && ($award_date == $investiture_date || $award_date == $next_investiture_date)))
         {
            $data_prepend = "";
            if ($award_date == $investiture_date && $start_sequence == 0 && $baronage_id > 1)
            {
               $data_prepend = "* ";
            }
            if ($award_date == $next_investiture_date && $next_start_sequence == 0)
            {
               $data_prepend = "+ ";
            }

            $private = $award_data['private'];
            if ($private == 0 || ($private == 1 && ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) || (isset($_SESSION[$BACKLOG_ADMIN]) && $_SESSION[$BACKLOG_ADMIN]))))
            {
               $private_display = "";
               if ($private == 1)
               {
                  $private_display = "<img src=\"" . $IMAGES_DIR . "private.gif\" width=\"15\" height=\"15\" alt=\"Marked Private\" border=\"0\"/> ";
               }
?>
   <tr>
      <td class="dataright"><?php echo $data_prepend . $i++; ?></td>
      <td class="data"><?php echo $private_display . $name_display; ?></td>
<?php 
               if ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) || (isset($_SESSION[$BACKLOG_ADMIN]) && $_SESSION[$BACKLOG_ADMIN]))
               {
?>
      <td class="data"><?php echo $first_name . " " . $last_name . " ($gender)"; ?></td>
<?php 
               }
?>
      <td class="data"><?php echo $award_name_display; ?></td>
      <td class="datacenter" nowrap="nowrap"><?php echo format_short_date($award_date); ?></td>
<?php 
               if ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) || (isset($_SESSION[$BACKLOG_ADMIN]) && $_SESSION[$BACKLOG_ADMIN]))
               {
?>
      <td class="dataright"><?php echo $sequence; ?></td>
<?php 
               }
?>
   </tr>
<?php 
            }
         } // Award is or may be from this term
      }
?>
</table>
<p align="center">* Items on Investiture date may be from previous baronage<br/>+ Items on Investiture date may be from next baronage</p>
<?php 
/* Free resultset */
mysql_free_result($result);

/* Closing connection */
db_disconnect($link);

include("footer.php");
?>



