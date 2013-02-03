<?php 
include_once("db.php");

// Only allow authorized users
if ((isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN]) || (isset($_SESSION[$BACKLOG_ADMIN]) || $_SESSION[$BACKLOG_ADMIN]))
{
$SUBMIT_SEARCH = "Search Scribes";

$submit = "";
if (isset($_POST['submit']))
{
   $submit = $_POST['submit'];
}

$link = db_connect();

if ($submit == $SUBMIT_SEARCH)
{
   $form_scribe = "";
   if (isset($_POST['form_scribe']))
   {
      $form_scribe = clean($_POST['form_scribe']);
   }
   $form_notes = "";
   if (isset($_POST['form_notes']))
   {
      $form_notes = clean($_POST['form_notes']);
   }

   $errmsg = "";

   if ($form_scribe == '' && $form_notes == '')
   {
      $errmsg = "Please enter an SCA name or notes text on which to search.<br/>";
   }

   if (strlen($errmsg) == 0)
   {
      if (!headers_sent($filename, $linenum)) 
      {
         redirect("backlog_scribes.php?scribe=$form_scribe&notes=$form_notes");
      }
      // Debugging
      else 
      {
         echo "Headers already sent in $filename on line $linenum<br/>" .
              "Cannot redirect; click on the link below:<br/><br/>";
         echo '<a href="backlog_scribes.php?scribe=' . $form_scribe . '">Continue</a>';
         echo "<br/><br/>";
         echo var_dump(headers_list());
         exit;
      }

   }
}

$title = "Search Scribes";
include("header.php");
?>
<p class="title2" align="center">Search Scribes</p>
<?php
if (isset($errmsg) && strlen($errmsg) > 0)
{
   echo '<p align="center" style="color:red;font-weight:bold">' . $errmsg . '</p>';
}
?>
<form action="search_scribe.php" method="post">
<table align="center" border="1" cellpadding="5" cellspacing="0" summary="Search Criteria selection">
   <tr>
      <th colspan="2" class="title">Search Criteria</th>
   </tr>
   <tr>
      <th class="titleright">SCA Name</th>
      <td class="data"><input type="text" name="form_scribe" id="form_scribe" size="50"<?php if (isset($form_scribe) && $form_scribe != '') { echo " value=\"$form_scribe\"";} ?>/></td>
   </tr>
   <tr>
      <th class="titleright">Notes</th>
      <td class="data"><input type="text" name="form_notes" id="form_notes" size="50"<?php if (isset($form_notes) && $form_notes != '') { echo " value=\"$form_notes\"";} ?>/></td>
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
<p class="title2">Search Scribes</p>
<p>You are not authorized to access this page.</p>
<?php
}
include("footer.php");
?>



