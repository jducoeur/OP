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
<h2 style="text-align:center"><?php echo ucfirst($mode); ?> Doctorate</h2>
<?php
// Only appropriate admins allowed
if (isset($_SESSION[$UNIVERSITY_ADMIN]) && $_SESSION[$UNIVERSITY_ADMIN] == 1)
{
   $SUBMIT_SAVE = "Save Changes";
   $SUBMIT_DELETE = "Delete Selected Doctorates";

   $form_participant_id = 0;
   if (isset($_REQUEST['form_participant_id']))
   {
      $form_participant_id = clean($_REQUEST['form_participant_id']);
   }

   $valid = true;
   $errmsg = '';
   if (isset($_POST['submit']) && $_POST['submit'] == $SUBMIT_SAVE)
   {
      $form_d_university_id = NULL;
      if (isset($_POST['form_d_university_id']))
      {
         $form_d_university_id = clean($_POST['form_d_university_id']);
      }
      $form_d_degree_status_id = NULL;
      if (isset($_POST['form_d_degree_status_id']))
      {
         $form_d_degree_status_id = clean($_POST['form_d_degree_status_id']);
      }
      $form_sca_name = NULL;
      if (isset($_POST['form_sca_name']))
      {
         $form_sca_name = clean($_POST['form_sca_name']);
      }

      // Validate data
      if ($form_d_university_id == NULL || $form_d_university_id == '')
      {
         $valid = false;
         $errmsg .= "Please select the university session at which the Doctorate was given.<br/>";
      }
      // Not required, but if they fill it in, check it
      if ($form_d_degree_status_id == NULL)
      {
         $form_d_degree_status_id = $STATUS_EARNED;
      }

      if ($valid)
      {
         $link = db_admin_connect();

         // Update Doctorate
         $update = 
            "UPDATE $DBNAME_UNIVERSITY.participant " .
            "SET d_university_id = " . value_or_null($form_d_university_id) . 
            ", d_degree_status_id = " . value_or_null($form_d_degree_status_id) . 
            ", last_updated = " . value_or_null(date("Y-m-d")) .
            ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) .
            " WHERE participant_id = " . $form_participant_id;

         $uresult = mysql_query($update)
            or die("Error updating Participant with Doctorate: " . mysql_error());

         /* Closing connection */
         db_disconnect($link);
?>
<p align="center">Doctorate successfully updated.<br/><a href="<?php echo $_SERVER['PHP_SELF']; ?>">Return to the Doctorate list</a>.</p>
<?php 
      } // valid
   }
   // We haven't submitted save yet - display Doctorate list or edit form
   if (!(isset($_POST['submit'])) || (isset($_POST['submit']) && 
      ($_POST['submit'] == $SUBMIT_SAVE && !$valid) || 
      ($_POST['submit'] == $SUBMIT_DELETE)))
   {
      // Do delete
      if (isset($_POST['submit']) && $_POST['submit'] == $SUBMIT_DELETE)
      {
         $del_participant_id = '';
         for ($i = 1; $i < $_POST['del_participant_max']; $i++)
         {
            if (isset($_POST['del_participant_id' . $i]))
            {
               if ($del_participant_id != '')
               {
                  $del_participant_id .= ',';
               }
               $del_participant_id .= $_POST['del_participant_id' . $i];
            }
         }

         if ($del_participant_id != '')
         {
            $link = db_admin_connect();

            $delete = "UPDATE $DBNAME_UNIVERSITY.participant SET d_university_id = NULL, d_degree_status_id = NULL WHERE participant_id IN ($del_participant_id)";

            $dresult = mysql_query($delete)
               or die("Error deleteing Doctorate: " . mysql_error());

            /* Closing connection */
            db_disconnect($link);
         }
         else
         {
            $delerrmsg = "Please select at least one Doctorate to delete.";
?>
<p align="center" class="title3" style="color:red"><?php echo $delerrmsg; ?></p>
<?php 
         }
      }

      // Dislay edit list
      if ($mode == $MODE_EDIT && (!isset($form_participant_id) || $form_participant_id == 0))
      {
?>
<p align="center">
To edit an existing Doctorate: Click on the Participant link.<br/>
To delete an existing Doctorate: Check the box in front of the Doctorate and click the <?php echo $SUBMIT_DELETE; ?> button.<br/>
To add a new Doctorate: Visit the <a href="select_participant.php?type=<?php echo $ST_DOCTORATE; ?>">Add Doctorate page</a>.<br/>
</p>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table align="center" border="1" cellpadding="5" cellspacing="0" summary="Doctorate Update Form">
   <tr>
      <th style="color:<?php echo $accent_color; ?>">Delete</th>
      <th style="color:<?php echo $accent_color; ?>">Participant</th>
      <th style="color:<?php echo $accent_color; ?>">Doctorate Session</th>
      <th style="color:<?php echo $accent_color; ?>">Doctorate Degree Status</th>
   </tr>
<?php
         $link = db_connect();
         $query = "SELECT participant.participant_id, participant.d_university_id, participant.d_degree_status_id, university.university_code, degree_status.degree_status, participant.sca_name " .
                  "FROM $DBNAME_UNIVERSITY.participant JOIN $DBNAME_UNIVERSITY.university ON participant.d_university_id = university.university_id " .
                  "LEFT OUTER JOIN $DBNAME_UNIVERSITY.degree_status ON participant.d_degree_status_id = degree_status.degree_status_id " .
                  "ORDER BY university.university_date";
         $result = mysql_query($query);

         $i = 1;
         while ($data = mysql_fetch_array($result, MYSQL_BOTH))
         {
            $participant_id = clean($data['participant_id']);
            $d_university_id = clean($data['d_university_id']);
            $d_degree_status_id = clean($data['d_degree_status_id']);
            $university_code = clean($data['university_code']);
            $degree_status = clean($data['degree_status']);
            $sca_name = clean($data['sca_name']);
?>
   <tr>
      <td class="data" nowrap>
      <label for="del_participant_id<?php echo $i; ?>">Delete</label> <input type="checkbox" name="del_participant_id<?php echo $i; ?>" id="del_participant_id<?php echo $i++; ?>" value="<?php echo $participant_id; ?>"/>
      </td>
      <td class="data">
      <a style="font-weight:normal" href="<?php echo $_SERVER['PHP_SELF'] . "?form_participant_id=" . $participant_id; ?>"><?php echo htmlentities($sca_name); ?></a>
      </td>
      <td class="data" nowrap>
      <?php echo htmlentities($university_code); ?>
      </td>
      <td class="data" nowrap>
      <?php echo htmlentities($degree_status); ?>
      </td>
   </tr>
<?php 
         }
?>
   <input type="hidden" name="del_participant_max" id="del_participant_max" value="<?php echo $i; ?>"/>
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
         if (($mode == $MODE_EDIT || $form_participant_id != 0) && $valid)
         {
            $link = db_connect();
            $query = "SELECT participant.participant_id, participant.d_university_id, participant.d_degree_status_id, participant.sca_name " .
                     "FROM $DBNAME_UNIVERSITY.participant WHERE participant_id = " . $form_participant_id;
            $result = mysql_query($query);

            $data = mysql_fetch_array($result, MYSQL_BOTH);
            $form_participant_id = $data['participant_id'];
            $form_d_university_id = clean($data['d_university_id']);
            $form_sca_name = clean($data['sca_name']);
            $form_d_degree_status_id = $data['d_degree_status_id'];

            /* Free resultset */
            mysql_free_result($result);

            /* Closing connection */
            db_disconnect($link);
         }
         if (!$valid)
         {
?>
<p align="center" class="title3" style="color:red"><?php echo $errmsg; ?></p>
<?php 
         }
         // Get pick lists
         $university_data_array = get_university_pick_list();
         $degree_status_data_array = get_degree_status_pick_list();
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>"/>
<table border="1" align="center" cellpadding="5" cellspacing="0" summary="Doctorate Form">
<?php 
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
      <th class="titleright">Participant ID:</th>
      <td class="data"><?php if (isset($form_participant_id) && trim($form_participant_id) != '' && $form_participant_id > 0) { echo $form_participant_id; } ?></td>
   </tr>
   <tr>
      <th class="titleright">SCA Name:</th>
      <td class="data"><?php if (isset($form_sca_name)) { echo htmlentities($form_sca_name); } ?></td>
   </tr>
   <tr>
      <td class="titleright"><label for="form_d_university_id">University Session</label></td>
      <td class="data">
      <select name="form_d_university_id" id="form_d_university_id">
         <option></option>
<?php
         for ($i = 0; $i < count($university_data_array); $i++)
         {
            echo '<option id="' . $university_data_array[$i]['university_code'] . '" value="' . $university_data_array[$i]['university_id'] . '"';
            if (isset($form_d_university_id) && $form_d_university_id == $university_data_array[$i]['university_id'])
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
      <td class="titleright"><label for="form_d_degree_status_id">Degree Status</label></td>
      <td class="data">
      <select name="form_d_degree_status_id" id="form_d_degree_status_id">
         <option></option>
<?php
         for ($i = 0; $i < count($degree_status_data_array); $i++)
         {
            echo '<option id="' . $degree_status_data_array[$i]['degree_status'] . '" value="' . $degree_status_data_array[$i]['degree_status_id'] . '"';
            if (isset($form_d_degree_status_id) && $form_d_degree_status_id == $degree_status_data_array[$i]['degree_status_id'])
            {
               echo ' selected';
            }
            echo '>' . $degree_status_data_array[$i]['degree_status'] . '</option>';
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
