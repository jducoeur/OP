<?php 
include_once("db.php");

// Only allow authorized users
if ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) || (isset($_SESSION[$BACKLOG_ADMIN]) || $_SESSION[$BACKLOG_ADMIN]))
{
$SUBMIT_SEARCH = "Search By Award";

$submit = "";
if (isset($_POST['submit']))
{
   $submit = $_POST['submit'];
}

$link = db_connect();

if ($submit == $SUBMIT_SEARCH)
{
   $form_award_id = "";
   if (isset($_POST['form_award_id']))
   {
      $form_award_id = clean($_POST['form_award_id']);
   }

   $errmsg = "";

   if ($form_award_id == '')
   {
      $errmsg = "Please select an award on which to search.<br/>";
   }

   if (strlen($errmsg) == 0)
   {
      if (!headers_sent($filename, $linenum)) 
      {
         redirect("backlog_by_award.php?award_id=$form_award_id");
      }
      // Debugging
      else 
      {
         echo "Headers already sent in $filename on line $linenum<br/>" .
              "Cannot redirect; click on the link below:<br/><br/>";
         echo '<a href="backlog_by_award.php?award_id=' . $form_award_id . '">Continue</a>';
         echo "<br/><br/>";
         echo var_dump(headers_list());
         exit;
      }

   }
}

$title = "Search By Award";
include("header.php");

$query = "SELECT award.award_id, award.award_group_id, award.award_name " .
         "FROM $DBNAME_OP.award JOIN $DBNAME_OP.precedence ON award.type_id = precedence.type_id " .
         "WHERE precedence.precedence <= $UNDER_OP_LEVEL " .
         "AND precedence.precedence >= $DUCAL " . 
         "AND (branch_id = $ATLANTIA OR branch_id IS NULL) " .
         "AND award.closed != 1 " .
         "ORDER BY precedence.precedence ";

/* Performing SQL query */
$result = mysql_query($query) 
   or die("Backlog Award Query failed : " . mysql_error());
?>
<p class="title2" align="center"><?php echo $title; ?></p>
<?php
if (isset($errmsg) && strlen($errmsg) > 0)
{
   echo '<p align="center" style="color:red;font-weight:bold">' . $errmsg . '</p>';
}
?>
<form action="search_award.php" method="post">
<table align="center" border="1" cellpadding="5" cellspacing="0" summary="Search Criteria selection">
   <tr>
      <th colspan="2" class="title">Search Criteria</th>
   </tr>
   <tr>
      <th class="titleright">Award</th>
      <td class="data">
      <select name="form_award_id" id="form_award_id">
         <?php
            while ($award_data = mysql_fetch_array($result, MYSQL_BOTH))
            {
               echo '<option value="' . $award_data['award_id'] . '"';
               if (isset($form_award_id) && $form_award_id == $award_data['award_id'])
               {
                  echo ' selected';
               }
               echo '>' . $award_data['award_name'] . '</option>';
            }
         ?>
      </select>
      </td>
   </tr>
   <tr>
      <th colspan="2" class="title"><input type="submit" name="submit" value="<?php echo $SUBMIT_SEARCH; ?>"/></th>
   </tr>
</table>
</form>
<?php
}
// Not allowed to access page
else
{
include("header.php");
?>
<p class="title2"><?php echo $title; ?></p>
<p>You are not authorized to access this page.</p>
<?php
}
include("footer.php");
?>



