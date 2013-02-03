<?php
include("../db/db.php");
include("db.php");
include("../header.php");

$mode = $MODE_EDIT;
if (isset($_REQUEST['mode']))
{
   $mode = clean($_REQUEST['mode']);
}
?>
<h2 style="text-align:center"><?php echo ucfirst($mode); ?> Chancellor</h2>
<?php
// Only appropriate admins allowed
if (isset($_SESSION[$UNIVERSITY_ADMIN]) && $_SESSION[$UNIVERSITY_ADMIN] == 1)
{
   $SUBMIT_SAVE = "Save Changes";
   $SUBMIT_DELETE = "Delete Selected Chancellors";

   $form_chancellor_id = 0;
   if (isset($_REQUEST['form_chancellor_id']))
   {
      $form_chancellor_id = clean($_REQUEST['form_chancellor_id']);
   }

   $form_participant_id = 0;
   if (isset($_REQUEST['form_participant_id']))
   {
      $form_participant_id = clean($_REQUEST['form_participant_id']);
   }

   $valid = true;
   $errmsg = '';
   if (isset($_POST['submit']) && $_POST['submit'] == $SUBMIT_SAVE)
   {
      $form_start_university_id = NULL;
      if (isset($_POST['form_start_university_id']))
      {
         $form_start_university_id = clean($_POST['form_start_university_id']);
      }
      $form_end_university_id = NULL;
      if (isset($_POST['form_end_university_id']))
      {
         $form_end_university_id = clean($_POST['form_end_university_id']);
      }
      $form_sca_name = NULL;
      if (isset($_POST['form_sca_name']))
      {
         $form_sca_name = clean($_POST['form_sca_name']);
      }

      // Validate data
      if ($form_start_university_id == NULL || $form_start_university_id == '')
      {
         $valid = false;
         $errmsg .= "Please select the university session at which the Chancellor stepped up.<br/>";
      }

      if ($valid)
      {
         $link = db_admin_connect();

         // Update Chancellor
         if ($mode == $MODE_EDIT && $form_chancellor_id != 0)
         {
            $update = 
               "UPDATE $DBNAME_UNIVERSITY.chancellor " .
               "SET participant_id = " . value_or_null($form_participant_id) . 
               ", start_university_id = " . value_or_null($form_start_university_id) . 
               ", end_university_id = " . value_or_null($form_end_university_id) . 
               ", last_updated = " . value_or_null(date("Y-m-d")) .
               ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) .
               " WHERE chancellor_id = " . $form_chancellor_id;

            $uresult = mysql_query($update)
               or die("Error updating Chancellor: " . $update . "<br/>" . mysql_error());
         }
         // Insert Chancellor
         else
         {
            $insert = 
               "INSERT INTO $DBNAME_UNIVERSITY.chancellor (participant_id, start_university_id, end_university_id, date_created, last_updated, last_updated_by) VALUES (" .
               value_or_null($form_participant_id) . ", " .
               value_or_null($form_start_university_id) . ", " .
               value_or_null($form_end_university_id) . ", " .
               value_or_null(date("Y-m-d")) . ", " .
               value_or_null(date("Y-m-d")) . ", " .
               value_or_null($_SESSION['s_user_id']) . ")";

            $iresult = mysql_query($insert)
               or die("Error inserting Chancellor: " . $insert . "<br/>" . mysql_error());
         }
         /* Closing connection */
         db_disconnect($link);
?>
<p align="center">Chancellor successfully updated.<br/><a href="<?php echo $_SERVER['PHP_SELF']; ?>">Return to the Chancellor list</a>.</p>
<?php 
      } // valid
   }
   // We haven't submitted save yet - display Chancellor list or edit form
   if (!(isset($_POST['submit'])) || (isset($_POST['submit']) && 
      ($_POST['submit'] == $SUBMIT_SAVE && !$valid) || 
      ($_POST['submit'] == $SUBMIT_DELETE)))
   {
      // Do delete
      if (isset($_POST['submit']) && $_POST['submit'] == $SUBMIT_DELETE)
      {
         $del_chancellor_id = '';
         for ($i = 1; $i < $_POST['del_chancellor_max']; $i++)
         {
            if (isset($_POST['del_chancellor_id' . $i]))
            {
               if ($del_chancellor_id != '')
               {
                  $del_chancellor_id .= ',';
               }
               $del_chancellor_id .= $_POST['del_chancellor_id' . $i];
            }
         }

         if ($del_chancellor_id != '')
         {
            $link = db_admin_connect();

            $delete = "DELETE FROM $DBNAME_UNIVERSITY.chancellor WHERE chancellor_id IN ($del_chancellor_id)";

            $dresult = mysql_query($delete)
               or die("Error deleteing Chancellor: " . $delete . "<br/>" . mysql_error());

            /* Closing connection */
            db_disconnect($link);
         }
         else
         {
            $delerrmsg = "Please select at least one Chancellor to delete.";
?>
<p align="center" class="title3" style="color:red"><?php echo $delerrmsg; ?></p>
<?php 
         }
      }

      // Dislay edit list
      if ($mode == $MODE_EDIT && (!isset($form_chancellor_id) || $form_chancellor_id == 0))
      {
?>
<p align="center">
To edit an existing Chancellor: Click on the Chancellor link.<br/>
To delete an existing Chancellor: Check the box in front of the Chancellor and click the <?php echo $SUBMIT_DELETE; ?> button.<br/>
To add a new Chancellor: Visit the <a href="select_participant.php?type=<?php echo $ST_CHANCELLOR; ?>">Add Chancellor page</a>.<br/>
</p>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table align="center" border="1" cellpadding="5" cellspacing="0" summary="Chancellor Update Form">
   <tr>
      <th style="color:<?php echo $accent_color; ?>">Delete</th>
      <th style="color:<?php echo $accent_color; ?>">Chancellor</th>
      <th style="color:<?php echo $accent_color; ?>">University Session Start</th>
      <th style="color:<?php echo $accent_color; ?>">University Session End</th>
   </tr>
<?php 
         $link = db_connect();
         $query = "SELECT chancellor.chancellor_id, chancellor.participant_id, chancellor.start_university_id, chancellor.end_university_id, start.university_code as start_university_code, end.university_code as end_university_code, participant.sca_name " .
                  "FROM $DBNAME_UNIVERSITY.participant JOIN $DBNAME_UNIVERSITY.chancellor ON participant.participant_id = chancellor.participant_id " .
                  "LEFT OUTER JOIN $DBNAME_UNIVERSITY.university start ON chancellor.start_university_id = start.university_id " .
                  "LEFT OUTER JOIN $DBNAME_UNIVERSITY.university end ON chancellor.end_university_id = end.university_id " .
                  "ORDER BY start.university_date";
         $result = mysql_query($query);

         $i = 1;
         while ($data = mysql_fetch_array($result, MYSQL_BOTH))
         {
            $chancellor_id = clean($data['chancellor_id']);
            $participant_id = clean($data['participant_id']);
            $start_university_id = clean($data['start_university_id']);
            $end_university_id = clean($data['end_university_id']);
            $start_university_code = clean($data['start_university_code']);
            $end_university_code = clean($data['end_university_code']);
            $sca_name = clean($data['sca_name']);
?>
   <tr>
      <td class="data" nowrap>
      <label for="del_chancellor_id<?php echo $i; ?>">Delete</label> <input type="checkbox" name="del_chancellor_id<?php echo $i; ?>" id="del_chancellor_id<?php echo $i++; ?>" value="<?php echo $chancellor_id; ?>"/>
      </td>
      <td class="data">
      <a style="font-weight:normal" href="<?php echo $_SERVER['PHP_SELF'] . "?form_chancellor_id=" . $chancellor_id; ?>"><?php echo htmlentities($sca_name); ?></a>
      </td>
      <td class="data" nowrap>
      <?php echo htmlentities($start_university_code); ?>
      </td>
      <td class="data" nowrap>
      <?php echo htmlentities($end_university_code); ?>
      </td>
   </tr>
<?php 
         }
?>
   <input type="hidden" name="del_chancellor_max" id="del_chancellor_max" value="<?php echo $i; ?>"/>
   <tr>
      <td class="datacenter" colspan="4"><input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_DELETE; ?>"/></td>
   </tr>
</table>
</form>
<?php 
         /* Free resultset */
         mysql_free_result($result);

         /* Closing connection */
         db_disconnect($link);
      }
      // Display form
      else
      {
         $link = db_connect();
         if (($mode == $MODE_ADD || $form_participant_id != 0) && $valid)
         {
            $query = "SELECT participant.participant_id, participant.sca_name " .
                     "FROM $DBNAME_UNIVERSITY.participant " .
                     "WHERE participant_id = " . $form_participant_id;
            $result = mysql_query($query);

            $data = mysql_fetch_array($result, MYSQL_BOTH);
            $form_participant_id = $data['participant_id'];
            $form_sca_name = clean($data['sca_name']);

            /* Free resultset */
            mysql_free_result($result);
         }
         if (($mode == $MODE_EDIT || $form_chancellor_id != 0) && $valid)
         {
            $query = "SELECT chancellor.participant_id, chancellor.start_university_id, chancellor.end_university_id, participant.sca_name " .
                     "FROM $DBNAME_UNIVERSITY.chancellor JOIN $DBNAME_UNIVERSITY.participant ON chancellor.participant_id = participant.participant_id " .
                     "WHERE chancellor_id = " . $form_chancellor_id;
            $result = mysql_query($query);

            $data = mysql_fetch_array($result, MYSQL_BOTH);
            $form_participant_id = $data['participant_id'];
            $form_start_university_id = clean($data['start_university_id']);
            $form_end_university_id = $data['end_university_id'];
            $form_sca_name = clean($data['sca_name']);

            /* Free resultset */
            mysql_free_result($result);
         }
         /* Closing connection */
         db_disconnect($link);

         if (!$valid)
         {
?>
<p align="center" class="title3" style="color:red"><?php echo $errmsg; ?></p>
<?php 
         }
         // Get pick lists
         $university_data_array = get_university_pick_list();
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>"/>
<table border="1" align="center" cellpadding="5" cellspacing="0" summary="Chancellor Form">
<?php 
         if (isset($form_chancellor_id) && $form_chancellor_id > 0)
         {
?>
   <input type="hidden" name="form_chancellor_id" id="form_chancellor_id" value="<?php echo $form_chancellor_id; ?>"/>
<?php 
         }
         if (isset($form_participant_id) && $form_participant_id > 0)
         {
?>
   <input type="hidden" name="form_participant_id" id="form_participant_id" value="<?php echo $form_participant_id; ?>"/>
<?php 
         }
         if (isset($form_sca_name) && $form_sca_name != "")
         {
?>
   <input type="hidden" name="form_sca_name" id="form_sca_name" value="<?php echo $form_sca_name; ?>"/>
<?php 
         }
?>
   <tr>
      <th class="titleright">Chancellor ID:</th>
      <td class="data"><?php if (isset($form_chancellor_id) && trim($form_chancellor_id) != '' && $form_chancellor_id > 0) { echo $form_chancellor_id; } ?></td>
   </tr>
   <tr>
      <th class="titleright">Participant ID:</th>
      <td class="data"><?php if (isset($form_participant_id) && trim($form_participant_id) != '' && $form_participant_id > 0) { echo $form_participant_id; } ?></td>
   </tr>
   <tr>
      <th class="titleright">SCA Name:</th>
      <td class="data"><?php if (isset($form_sca_name)) { echo htmlentities($form_sca_name); } ?></td>
   </tr>
   <tr>
      <td class="titleright"><label for="form_start_university_id">University Session Start</label></td>
      <td class="data">
      <select name="form_start_university_id" id="form_start_university_id">
         <option></option>
<?php
         for ($i = 0; $i < count($university_data_array); $i++)
         {
            echo '<option id="' . $university_data_array[$i]['university_code'] . '" value="' . $university_data_array[$i]['university_id'] . '"';
            if (isset($form_start_university_id) && $form_start_university_id == $university_data_array[$i]['university_id'])
            {
               echo ' selected';
            }
            echo '>' . $university_data_array[$i]['university_code'] . '</option>';
         }
?>
      </select>
      </td>
   </tr>
   <tr>
      <td class="titleright"><label for="form_end_university_id">University Session End</label></td>
      <td class="data">
      <select name="form_end_university_id" id="form_end_university_id">
         <option></option>
<?php
         for ($i = 0; $i < count($university_data_array); $i++)
         {
            echo '<option id="' . $university_data_array[$i]['university_code'] . '" value="' . $university_data_array[$i]['university_id'] . '"';
            if (isset($form_end_university_id) && $form_end_university_id == $university_data_array[$i]['university_id'])
            {
               echo ' selected';
            }
            echo '>' . $university_data_array[$i]['university_code'] . '</option>';
         }
?>
      </select>
      </td>
   </tr>
   <tr>
      <td colspan="2" class="datacenter"><input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_SAVE; ?>"/></td>
   </tr>
</table>
<?
      }
   }
?>
</form>
<?php
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
