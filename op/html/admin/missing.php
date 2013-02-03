<?php 
include_once("db.php");

// Only allow authorized users
if (isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN])
{
$SUBMIT_SEARCH = "Search Atlantian Awards not in Court Report";

$submit = "";
if (isset($_POST['submit']))
{
   $submit = $_POST['submit'];
}

$link = db_connect();

if ($submit == $SUBMIT_SEARCH)
{
   $form_start_date = "";
   if (isset($_POST['form_start_date']))
   {
      $form_start_date = clean($_POST['form_start_date']);
   }

   $form_end_date = "";
   if (isset($_POST['form_end_date']))
   {
      $form_end_date = clean($_POST['form_end_date']);
   }

   $award_type = "A";
   if (isset($_POST['award_type']))
   {
      $award_type = clean($_POST['award_type']);
   }

   $errmsg = "";
   if ($form_start_date == "" && $form_end_date == "")
   {
      $errmsg = "Please select a date range on which to search.<br/>";
   }
   $wc = "";
   if ($form_start_date != "")
   {
      if (validate_date($form_start_date))
      {
         $wc .= " AND award_date >= " . value_or_null(format_mysql_date($form_start_date));
      }
   }
   if ($form_end_date != "")
   {
      if (validate_date($form_end_date))
      {
         $wc .= " AND award_date < " . value_or_null(format_mysql_date($form_end_date));
      }
   }
   if ($award_type == "K" || $award_type == "B")
   {
      if ($award_type == "B")
      {
         $wc .= " AND award.type_id > $UNDER_OP_LEVEL";
      }
      else // if ($award_type == "K")
      {
         $wc .= " AND award.type_id <= $UNDER_OP_LEVEL";
      }
   }

   if (strlen($errmsg) == 0)
   {
      $query = "SELECT atlantian_award_id, sca_name, award_name, branch.branch, rg.branch AS gname, award_date, sequence " .
               "FROM $DBNAME_OP.atlantian_award JOIN $DBNAME_AUTH.atlantian ON atlantian_award.atlantian_id = atlantian.atlantian_id " .
               "JOIN $DBNAME_OP.award ON atlantian_award.award_id = award.award_id JOIN precedence ON award.type_id = precedence.type_id " .
               "LEFT OUTER JOIN $DBNAME_BRANCH.branch ON atlantian_award.branch_id = branch.branch_id " .
               "LEFT OUTER JOIN $DBNAME_BRANCH.branch rg ON award.branch_id = rg.branch_id " .
               "WHERE court_report_id IS NULL " .
               "AND (((branch.branch_id = 8 OR rg.branch_id = 8) AND precedence.precedence <= 20 AND precedence.precedence NOT IN (10, 1, 2, 3, 4)) " .
               "OR (precedence.precedence IN (10,21) AND award.branch_id IN (SELECT branch_id FROM $DBNAME_BRANCH.branch WHERE parent_branch_id = 8 AND branch_type_id = 3))) " .
               $wc .
               " ORDER BY award_date, sequence";

      /* Performing SQL query */
      $result = mysql_query($query) 
         or die("Search Query failed : " . mysql_error());
   }
}

$title = "Search Atlantian Awards not in Court Report";
include("header.php");
?>
<p class="title2" align="center">Search Atlantian Awards not in Court Report</p>
<?php
if (isset($errmsg) && strlen($errmsg) > 0)
{
   echo '<p align="center" style="color:red;font-weight:bold">' . $errmsg . '</p>';
}
?>
<form action="missing.php" method="post">
<table align="center" border="1" cellpadding="5" cellspacing="0" summary="Search Criteria selection">
   <tr>
      <th colspan="4" class="title">Search Criteria</th>
   </tr>
   <tr>
      <th class="titleright">Start Date</th>
      <td class="data">
      <input name="form_start_date" id="form_start_date" size="10"<?php if (isset($form_start_date)) { echo ' value="' . $form_start_date . '"';} ?> />
      </td>
      <th class="titleright">End Date</th>
      <td class="data">
      <input name="form_end_date" id="form_end_date" size="10"<?php if (isset($form_end_date)) { echo ' value="' . $form_end_date . '"';} ?> />
      </td>
   </tr>
   <tr>
      <th class="titleright">View</th>
      <td class="data" colspan="3">
      <input type="checkbox" name="printable" id="printable" value="1"<?php if (isset($printable) && $printable == 1) { echo ' checked="checked"';} ?>/><span style="font-weight:bold"><label for="printable">Printer-Friendly</label></span>
      &nbsp;&nbsp;
      <input type="radio" name="award_type" id="award_type" value="A"<?php if (isset($award_type) && $award_type == "A") { echo ' checked="checked"';} ?>/><span style="font-weight:bold">All Awards</span>
      &nbsp;&nbsp;
      <input type="radio" name="award_type" id="award_type" value="K"<?php if (isset($award_type) && $award_type == "K") { echo ' checked="checked"';} ?>/><span style="font-weight:bold">Kingdom Awards</span>
      &nbsp;&nbsp;
      <input type="radio" name="award_type" id="award_type" value="B"<?php if (isset($award_type) && $award_type == "B") { echo ' checked="checked"';} ?>/><span style="font-weight:bold">Baronial Awards</span>
      </td>
   </tr>
   <tr>
      <th colspan="4" class="title"><input type="submit" name="submit" value="<?php echo $SUBMIT_SEARCH; ?>"/></th>
   </tr>
</table>
</form>
<?php 
if (isset($result) && mysql_num_rows($result) > 0)
{
?>
<p align="center">
<img src="<?php echo $IMAGES_DIR; ?>op-divider.gif" width="648" height="41" border="0" alt="OP Line"/>
</p>
<?php 
   if (isset($errmsg2) && strlen($errmsg2) > 0)
   {
      echo '<p align="center" style="color:red;font-weight:bold">' . $errmsg2 . '</p>';
   }
?>
<table align="center" cellpadding="5" cellspacing="0" border="1" summary="Table listing search results">
   <tr>
      <th class="title" nowrap="nowrap">SCA Name</th>
      <th class="title">Award Name</th>
      <th class="title">Group</th>
      <th class="title">Award Date</th>
      <th class="title">Sequence</th>
   </tr>
<?php 
      while ($data = mysql_fetch_array($result, MYSQL_BOTH))
      {
         $sca_name = $data['sca_name'];
         $award_name = $data['award_name'];
         $branch = $data['branch'];
         $rg = $data['gname'];
         $award_date = $data['award_date'];
         $sequence = $data['sequence'];
         $group_display = $branch;
         if ($group_display == "")
         {
            $group_display = $rg;
         }
?>
   <tr>
      <td class="data"><?php echo $sca_name; ?></td>
      <td class="data" nowrap="nowrap"><?php echo $award_name; ?></td>
      <td class="data"><?php echo $group_display; ?></td>
      <td class="data"><?php echo $award_date; ?></td>
      <td class="data"><?php echo $sequence; ?></td>
   </tr>
<?php 
      }
?>
</table>
<p align="center"><?php echo mysql_num_rows($result); ?> records matched your search criteria.</p>
<?php 
   /* Free resultset */
   mysql_free_result($result);
}
// Nothing matched search criteria
else if (isset($errmsg) && $errmsg == '' && isset($result) && mysql_num_rows($result) == 0)
{
?>
<p align="center">
<img src="<?php echo $IMAGES_DIR; ?>op-divider.gif" width="648" height="41" border="0" alt="OP Line"/>
</p>
<p align="center">No records matched your search criteria.</p>
<?php 
}
/* Closing connection */
db_disconnect($link);
}
// Not allowed to access page
else
{
include("header.php");
?>
<p class="title2">Search Atlantian Awards not in Court Report</p>
<p>You are not authorized to access this page.</p>
<?php
}
include("footer.php");
?>



