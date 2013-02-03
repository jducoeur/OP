<?php
include_once('db.php');
// Only allow authorized users
if (isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN])
{
   $MODE_ADD = 'add';
   $MODE_EDIT = 'edit';

   $mode = $MODE_ADD;
   if (isset($_REQUEST['mode']))
   {
      $mode = clean($_REQUEST['mode']);
   }

   // Selected an item for edit?
   $form_award_id = 0;
   if (isset($_REQUEST['award_id']))
   {
      $form_award_id = clean($_REQUEST['award_id']);
   }
   else if (isset($_POST['form_award_id']))
   {
      $form_award_id = clean($_POST['form_award_id']);
   }

   $SUBMIT_SAVE = "Save Award";
   $SUBMIT_SELECT = "Select Award";
   $SUBMIT_DELETE = "Delete Award";

   $submit = '';
   if (isset($_POST['submit']))
   {
      $submit = $_POST['submit'];
   }

   $errmsg = "";
   // Delete award
   if ($submit == $SUBMIT_DELETE)
   {
      if ($mode == $MODE_EDIT && $form_award_id > 0)
      {
         $count = 0;
         $del_link = db_admin_connect();

         // Check for child OP records: atlantian_award
         $check_query = "SELECT award_id FROM $DBNAME_OP.atlantian_award WHERE award_id = $form_award_id";
         $check_result = mysql_query($check_query, $del_link)
            or die("Error checking OP for Award (atlantian_award): " . mysql_error());
         $count += mysql_num_rows($check_result);

         // Only delete if the checks passed
         if ($count == 0)
         {
            // Delete from op
            $delete = "DELETE FROM $DBNAME_OP.award WHERE award_id = $form_award_id";
            $del_result = mysql_query($delete, $del_link)
               or die("Error deleting Award from OP: " . mysql_error());

            // Redirect to delete page
            redirect("deleted.php?type_id=$DEL_TYPE_AWARD");
         }
         // Error - need to delete child records first
         else
         {
            $valid = false;
            if ($count == 1)
            {
               $errmsg = "There is a child record";
            }
            else
            {
               $errmsg = "There are $count child records";
            }
            $errmsg .= " for Award ID $form_award_id; this Award may not be deleted until all child records are deleted.";
            $mode = $MODE_EDIT;
         }
         // Close DBs
         db_disconnect($del_link);
      }
   } // End Submit Delete

   /* Connecting, selecting database */
   $link = db_admin_connect();

   // Save page data
   if ($submit == $SUBMIT_SAVE)
   {
      $form_award_name = clean($_POST['form_award_name']);
      $form_award_name_male = clean($_POST['form_award_name_male']);
      $form_award_name_female = clean($_POST['form_award_name_female']);
      $form_collective_name = clean($_POST['form_collective_name']);
      $form_award_blurb = clean($_POST['form_award_blurb']);
      $form_website = clean($_POST['form_website']);
      $form_award_file_name = clean($_POST['form_award_file_name']);
      $form_title_id = clean($_POST['form_title_id']);
      $form_type_id = clean($_POST['form_type_id']);
      $form_branch_id = clean($_POST['form_branch_id']);
      $form_select_branch = 0;
      if (isset($_POST['form_select_branch']))
      {
         $form_select_branch = clean($_POST['form_select_branch']);
      }
      $form_closed = 0;
      if (isset($_POST['form_closed']))
      {
         $form_closed = clean($_POST['form_closed']);
      }

      $errmsg = "";
      // Validation - if Branch ID is selected, then Select Branch must be 0
      if ($form_branch_id != '' && $form_branch_id > 0)
      {
         if ($form_select_branch != 0)
         {
            $errmsg .= "Either an Award is always from a specific Branch, or the branch is selectable, but not both.  Please either uncheck Selectable Branch or select the blank Branch.<br/>";
         }
      }

      if (strlen($errmsg) == 0)
      {
         // Update
         if ($form_award_id > 0)
         {
            $update_query = "UPDATE $DBNAME_OP.award SET " .
                            "award_name = " . value_or_null($form_award_name) . 
                            ", award_name_male = " . value_or_null($form_award_name_male) . 
                            ", award_name_female = " . value_or_null($form_award_name_female) . 
                            ", collective_name = " . value_or_null($form_collective_name) . 
                            ", award_blurb = " . value_or_null($form_award_blurb) . 
                            ", website = " . value_or_null($form_website) . 
                            ", award_file_name = " . value_or_null($form_award_file_name) . 
                            ", title_id = " . value_or_null($form_title_id) . 
                            ", branch_id = " . value_or_null($form_branch_id) . 
                            ", type_id = " . value_or_null($form_type_id) .
                            ", select_branch = " . value_or_zero($form_select_branch) .
                            ", closed = " . value_or_zero($form_closed) .
                            ", last_updated = " . value_or_null(date("Y-m-d")) .
                            ", last_updated_by = " . value_or_null($_SESSION["s_user_id"]) .
                            " WHERE award_id = " . value_or_null($form_award_id);

            $update_result = mysql_query($update_query) 
               or die("UPDATE failed : " . mysql_error());
         }
         // Insert
         else
         {
            $insert_query = "INSERT INTO $DBNAME_OP.award (award_name, award_name_male, award_name_female, collective_name, title_id, type_id, branch_id, select_branch, award_blurb, website, closed, award_file_name, last_updated, last_updated_by) " .
                            "VALUES (" .
                            value_or_null($form_award_name) . ", " .
                            value_or_null($form_award_name_male) . ", " .
                            value_or_null($form_award_name_female) . ", " .
                            value_or_null($form_collective_name) . ", " .
                            value_or_null($form_title_id) . ", " .
                            value_or_null($form_type_id) . ", " .
                            value_or_null($form_branch_id) . ", " .
                            value_or_zero($form_select_branch) . ", " .
                            value_or_null($form_award_blurb) . ", " .
                            value_or_null($form_website) . ", " .
                            value_or_zero($form_closed) . ", " .
                            value_or_null($form_award_file_name) . ", " .
                            value_or_null(date("Y-m-d")) . ", " .
                            value_or_null($_SESSION["s_user_id"]) .
                            ")";

            $insert_result = mysql_query($insert_query) 
               or die("INSERT failed : " . mysql_error());
            $form_award_id = mysql_insert_id();
         }
         $mode = $MODE_EDIT;
      } // no errors
   } // End Submit Save

   /* Performing SQL query */
   if ($mode == $MODE_EDIT && $form_award_id > 0)
   {
      $idquery = 
         "SELECT award_id, award_name, award_name_male, award_name_female, collective_name, title_id, type_id, branch_id, select_branch, award_blurb, website, closed, award_file_name ".
         "FROM $DBNAME_OP.award ".
         "WHERE award_id = ". value_or_null($form_award_id);

      $idresult = mysql_query($idquery) 
         or die("ID Query failed : " . mysql_error());

      $iddata = mysql_fetch_array($idresult, MYSQL_BOTH);

      $form_award_id = $iddata['award_id'];
      $form_award_name = trim($iddata['award_name']);
      $form_award_name_male = trim($iddata['award_name_male']);
      $form_award_name_female = trim($iddata['award_name_female']);
      $form_collective_name = trim($iddata['collective_name']);
      $form_award_blurb = trim($iddata['award_blurb']);
      $form_website = trim($iddata['website']);
      $form_award_file_name = trim($iddata['award_file_name']);
      $form_title_id = trim($iddata['title_id']);
      $form_type_id = $iddata['type_id'];
      $form_branch_id = $iddata['branch_id'];
      $form_select_branch = $iddata['select_branch'];
      $form_closed = $iddata['closed'];
   }
   /* Printing results in HTML */
include('header.php');
?>
<p class="title2"><?php echo ucfirst($mode); ?> Award</p>
<?php 
      if (isset($errmsg) && $errmsg != '')
      {
?>
<p align="center" class="title3" style="color:red">Please correct the following errors:<br/><br/><?php echo $errmsg; ?></p>
<?php 
      }
?>
<table border="1" cellpadding="5" cellspacing="0" summary="Table used for layout and formatting">
<?php 
   if ($mode == $MODE_EDIT && $form_award_id == 0)
   {
      $query = 
         "SELECT award.award_id, award.award_name, award.title_id, award.type_id, award.branch_id, ".
         "branch.branch, title.title_male, title.title_female ".
         "FROM $DBNAME_OP.award LEFT OUTER JOIN $DBNAME_BRANCH.branch ON award.branch_id = branch.branch_id ".
         "LEFT OUTER JOIN $DBNAME_OP.title ON award.title_id = title.title_id ".
         "ORDER BY award_name";

      $result = mysql_query($query) 
         or die("Query failed : " . mysql_error());

   ?>
   <form action="award.php?mode=<?php echo $MODE_EDIT; ?>" method="post">
   <tr>
      <th class="titleright"><label for="award_id">Select Award</label></th>
      <td class="data">
      <select name="award_id" id="award_id">
   <?php 
      while ($data = mysql_fetch_array($result, MYSQL_BOTH))
      {
         $branch = trim($data['branch']);
         echo '<option value="' . $data['award_id'] . '">' . $data['award_name'];
         if ($branch != '')
         {
            $kingdom = get_kingdom($data['branch_id']);
            if ($kingdom != $branch)
            {
               echo ' (' . $kingdom . ')';
            }
            echo ' (' . $branch . ')';
            echo '</option>';
         }
      }
   ?>
      </select>
      </td>
   </tr>
   <tr>
      <td class="title" colspan="2"><input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_SELECT; ?>"/></td>
   </tr>
   </form>
   <?php 
   }
   else
   {
   ?>
   <form action="award.php" method="post">
   <?php 
      if (isset($form_award_id) && $form_award_id > 0) 
      { 
   ?>
      <input name="form_award_id" id="form_award_id" type="hidden" value="<?php echo $form_award_id; ?>"/>
   <?php 
      }
   ?>
      <input name="mode" id="mode" type="hidden" value="<?php echo $mode; ?>"/>
   <tr>
      <th class="titleright"><label for="form_award_name">Award Name</label>:</th>
      <td class="data"><input name="form_award_name" id="form_award_name" type="text" size="50" maxlength="255"<?php if (isset($form_award_name)) { echo ' value="' . $form_award_name . '"'; }?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="award_name_male">Award Name Male</label>:</th>
      <td class="data"><input name="form_award_name_male" id="form_award_name_male" type="text" size="50" maxlength="255"<?php if (isset($form_award_name_male)) { echo ' value="' . $form_award_name_male . '"'; }?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="award_name_female">Award Name Female</label>:</th>
      <td class="data"><input name="form_award_name_female" id="form_award_name_female" type="text" size="50" maxlength="255"<?php if (isset($form_award_name_female)) { echo ' value="' . $form_award_name_female . '"'; }?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="collective_name">Award Name Collective</label>:</th>
      <td class="data"><input name="form_collective_name" id="form_collective_name" type="text" size="50" maxlength="255"<?php if (isset($form_collective_name)) { echo ' value="' . $form_collective_name . '"'; }?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_title_id">Awardee Title</label>:</th>
      <td class="data">
      <select name="form_title_id" id="form_title_id">
         <option></option>
   <?php 
      /* Get pick list */
      $pl_query = "SELECT title_id, title_male, title_female FROM $DBNAME_OP.title ORDER BY title_id";

      $pl_result = mysql_query($pl_query)
         or die("Pick List Query failed: " . mysql_error());

      while ($pl_data = mysql_fetch_array($pl_result, MYSQL_BOTH))
      {
         echo '<option value="' . $pl_data['title_id'] . '"'; 
         if (isset($form_title_id) && ($form_title_id == $pl_data['title_id']))
         {
            echo ' selected="selected"';
         }
         echo '>' . $pl_data['title_male'] . '/' . $pl_data['title_female'] . '</option>';
      }
      /* Free resultset */
      mysql_free_result($pl_result);
   ?>
      </select>
      </td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_type_id">Award Level/Type</label>:</th>
      <td class="data">
      <select name="form_type_id" id="form_type_id">
   <?php 
      /* Get pick list */
      $pl_query = "SELECT type_id, type FROM $DBNAME_OP.precedence ORDER BY precedence";

      $pl_result = mysql_query($pl_query)
         or die("Pick List Query failed: " . mysql_error());

      while ($pl_data = mysql_fetch_array($pl_result, MYSQL_BOTH))
      {
         echo '<option value="' . $pl_data['type_id'] . '"'; 
         if (isset($form_type_id) && ($form_type_id == $pl_data['type_id']))
         {
            echo ' selected="selected"';
         }
         echo '>' . $pl_data['type'] . '</option>';
      }
      /* Free resultset */
      mysql_free_result($pl_result);
   ?>
      </select>
      </td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_branch_id">Branch</label>:</th>
      <td class="data">
      <select name="form_branch_id" id="form_branch_id">
         <option></option>
   <?php 
      // Get pick lists
      $branch_data_array = get_branch_pick_list();
      for ($i = 0; $i < count($branch_data_array); $i++)
      {
         echo '<option value="' . $branch_data_array[$i]['branch_id'] . '"';
         if (isset($form_branch_id) && $form_branch_id == $branch_data_array[$i]['branch_id'])
         {
            echo ' selected';
         }
         echo '>' . $branch_data_array[$i]['branch_name'] . '</option>';
      }
   ?>
      </select>
      </td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_select_branch">Selectable Branch?</label>:</th>
      <td class="data"><input name="form_select_branch" id="form_select_branch" type="checkbox" value="1"<?php if (isset($form_select_branch) && $form_select_branch == 1) { echo ' checked="checked"'; }?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_closed">Closed?</label>:</th>
      <td class="data"><input name="form_closed" id="form_closed" type="checkbox" value="1"<?php if (isset($form_closed) && $form_closed == 1) { echo ' checked="checked"'; }?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="award_blurb">Award Info</label>:</th>
      <td class="data"><textarea name="form_award_blurb" id="form_award_blurb" rows="4" cols="60"><?php if (isset($form_award_blurb)) { echo $form_award_blurb; }?></textarea></td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_website">Award Web Site</label>:</th>
      <td class="data"><input name="form_website" id="form_website" type="text" size="50" maxlength="100"<?php if (isset($form_website)) { echo ' value="' . $form_website . '"'; }?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_award_file_name">Award File Name</label>:</th>
      <td class="data"><input name="form_award_file_name" id="form_award_file_name" type="text" size="50" maxlength="255"<?php if (isset($form_award_file_name)) { echo ' value="' . $form_award_file_name . '"'; }?>/></td>
   </tr>
   <tr>
      <td class="title" colspan="2"><input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_SAVE; ?>"/>&nbsp;&nbsp;&nbsp;<input type="reset" value="Reset Form"/>&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_DELETE; ?>"/></td>
   </tr>
   </form>
<?php 
   }
   if (isset($idresult))
   {
      /* Free resultset */
      mysql_free_result($idresult);
   }
?>
</table>
<?php
}
else
{
   include('header.php');
?>
   <p class="title2">Add/Edit Award</p>
   <p>You are not authorized to access this page.</p>
<?php
}
?>
<?php include('footer.php'); ?>
