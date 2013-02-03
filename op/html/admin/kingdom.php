<?php 
include_once("db.php");

// Only allow authorized users
if (isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN])
{
$SUBMIT_SEARCH = "Search Kingdom";

$submit = "";
if (isset($_POST['submit']))
{
   $submit = $_POST['submit'];
}

$link = db_connect();

if ($submit == $SUBMIT_SEARCH)
{
   $form_branch_id = 0;
   if (isset($_POST['form_branch_id']))
   {
      $form_branch_id = clean($_POST['form_branch_id']);
   }

   $errmsg = "";

   if ($form_branch_id == 0)
   {
      $errmsg = "Please select a Kingdom on which to search.<br/>";
   }

   if (strlen($errmsg) == 0)
   {
      $query = "SELECT atlantian.sca_name, award.award_name, branch.branch, atlantian_award.award_date " .
               "FROM $DBNAME_AUTH.atlantian JOIN $DBNAME_OP.atlantian_award ON atlantian.atlantian_id = atlantian_award.atlantian_id " .
               "JOIN $DBNAME_OP.award ON award.award_id = atlantian_award.award_id " .
               "JOIN $DBNAME_BRANCH.branch ON branch.branch_id = atlantian_award.branch_id " .
               "WHERE atlantian_award.branch_id = " . $form_branch_id;
               " ORDER BY award.award_id, atlantian_award.award_date";

      /* Performing SQL query */
      $result = mysql_query($query) 
         or die("Search Query failed : " . mysql_error());
   }
}

$title = "Search Kingdom";
include("header.php");
?>
<p class="title2" align="center">Search Kingdom</p>
<?php
if (isset($errmsg) && strlen($errmsg) > 0)
{
   echo '<p align="center" style="color:red;font-weight:bold">' . $errmsg . '</p>';
}
?>
<form action="kingdom.php" method="post">
<table align="center" border="1" cellpadding="5" cellspacing="0" summary="Search Criteria selection">
   <tr>
      <th colspan="2" class="title">Search Criteria</th>
   </tr>
   <tr>
      <th class="titleright">Kingdom</th>
      <td class="data">
      <select name="form_branch_id" id="form_branch_id">
      <?php 
            
         $pl_query = "SELECT branch_id, branch " .
                     "FROM $DBNAME_BRANCH.branch " .
                     "WHERE branch.branch_type_id = $BT_KINGDOM " .
                     "ORDER BY branch.branch";

         $pl_result = mysql_query($pl_query)
            or die("Pick List Query failed: " . mysql_error());

         while ($pl_data = mysql_fetch_array($pl_result, MYSQL_BOTH))
         {
            $branch_display = $pl_data['branch'];
            echo '<option value="' . $pl_data['branch_id'] . '"'; 
            if (isset($form_branch_id) && ($form_branch_id == $pl_data['branch_id']))
            {
               echo ' selected="selected"';
            }
            echo '>' . $branch_display . '</option>';
         }

         /* Free resultset */
         mysql_free_result($pl_result);
      ?>
      </select>
      </td>
   </tr>
   <tr>
      <th class="titleright">View</th>
      <td class="data">
      <input type="checkbox" name="printable" id="printable" value="1"<?php if (isset($printable) && $printable == 1) { echo ' checked="checked"';} ?>/><span style="font-weight:bold"><label for="printable">Printer-Friendly</label></span>
      </td>
   </tr>
   <tr>
      <th colspan="2" class="title"><input type="submit" name="submit" value="<?php echo $SUBMIT_SEARCH; ?>"/></th>
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
      <th class="title">Kingdom</th>
      <th class="title">Award Date</th>
   </tr>
<?php 
      while ($data = mysql_fetch_array($result, MYSQL_BOTH))
      {
         $sca_name = $data['sca_name'];
         $award_name = $data['award_name'];
         $branch = $data['branch'];
         $award_date = $data['award_date'];

?>
   <tr>
      <td class="data"><?php echo $sca_name; ?></td>
      <td class="data" nowrap="nowrap"><?php echo $award_name; ?></td>
      <td class="data"><?php echo $branch; ?></td>
      <td class="data"><?php echo $award_date; ?></td>
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
<p class="title2">Search Kingdom</p>
<p>You are not authorized to access this page.</p>
<?php
}
include("footer.php");
?>



