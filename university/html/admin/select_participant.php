<?php
include_once("../db/db.php");
include_once("db.php");
require_once('../db/session.php'); 

// Only allow authorized users
if (isset($_SESSION[$UNIVERSITY_ADMIN]) && $_SESSION[$UNIVERSITY_ADMIN] == 1)
{
   $SUBMIT_SEARCH = "Search Participants";
   $SUBMIT_SELECT = "Select Participant";

   $submit = "";
   if (isset($_POST['submit']))
   {
      $submit = $_POST['submit'];
   }

   $type = 0;
   if (isset($_REQUEST['type']))
   {
      $type = $_REQUEST['type'];
   }

   $mode = $MODE_ADD;
   if (isset($_REQUEST['mode']))
   {
      $mode = $_REQUEST['mode'];
   }

   $form_combo_id = NULL;
   $form_participant_id = NULL;
   $form_user_id = NULL;
   $form_atlantian_id = NULL;
   if (isset($_REQUEST['form_combo_id']))
   {
      $form_combo_id = $_REQUEST['form_combo_id'];
      $id_array = explode("_", $form_combo_id);
      $form_participant_id = $id_array[0];
      $form_user_id = $id_array[1];
      $form_atlantian_id = $id_array[2];
   }

   // Added from merge Participant
   $first_participant_id = 0;
   if (isset($_REQUEST['first_participant_id']))
   {
      $first_participant_id = $_REQUEST['first_participant_id'];
   }

   // Added from class instructor/student
   $course_id = NULL;
   if (isset($_REQUEST['course_id']))
   {
      $course_id = $_REQUEST['course_id'];
   }

   // Data submitted
   if ($submit == $SUBMIT_SELECT)
   {
      if ($form_combo_id != NULL)
      {
         // Needs to be added as a participant first
         if ($form_participant_id == 0)
         {
            $link = db_admin_connect();

            $sca_name = "";
            if ($form_atlantian_id > 0)
            {
               $aquery = "SELECT preferred_sca_name FROM $DBNAME_AUTH.atlantian WHERE atlantian_id = $form_atlantian_id";
               $aresult = mysql_query($aquery)
                  or die("Error reading Atlantian data: " . $aquery . "<br/>" . mysql_error());
               $adata = mysql_fetch_array($aresult, MYSQL_BOTH);
               $sca_name = clean($adata['preferred_sca_name']);
               mysql_free_result($aresult);
            }
            else if ($form_atlantian_id == 0 || $form_atlantian_id == "")
            {
               $form_atlantian_id = NULL;
            }

            if ($sca_name == "" && $form_user_id > 0)
            {
               $uquery = "SELECT sca_name FROM $DBNAME_AUTH.user_auth WHERE user_id = $form_user_id";
               $uresult = mysql_query($uquery)
                  or die("Error reading User data: " . $uquery . "<br/>" . mysql_error());
               $udata = mysql_fetch_array($uresult, MYSQL_BOTH);
               $sca_name = clean($udata['sca_name']);
               mysql_free_result($uresult);
            }
            else if ($form_user_id == 0 || $form_user_id == "")
            {
               $form_user_id = NULL;
            }

            // Insert into participant
            $pquery = "INSERT INTO $DBNAME_UNIVERSITY.participant (atlantian_id, user_id, sca_name, date_created, last_updated, last_updated_by) VALUES (" .
                      value_or_null($form_atlantian_id) . ", " .
                      value_or_null($form_user_id) . ", " .
                      value_or_null($sca_name) . ", " .
                      value_or_null(date("Y-m-d")) . ", " .
                      value_or_null(date("Y-m-d")) . ", " .
                      value_or_null($_SESSION['s_user_id']) . ")";
            $presult = mysql_query($pquery)
               or die("Error inserting Participant data: " . $pquery . "<br/>" . mysql_error());
            $form_participant_id = mysql_insert_id();

            db_disconnect($link);
         }
         // Already a participant
         if (!headers_sent($filename, $linenum))
         {
            if ($type == $ST_PARTICIPANT)
            {
               redirect("participant.php?mode=$MODE_EDIT&participant_id=$form_participant_id");
            }
            else if ($type == $ST_DOCTORATE)
            {
               redirect("doctorate.php?mode=$MODE_ADD&form_participant_id=$form_participant_id");
            }
            else if ($type == $ST_CHANCELLOR)
            {
               redirect("chancellor.php?mode=$MODE_ADD&form_participant_id=$form_participant_id");
            }
            else if ($type == $ST_INSTRUCTOR || $type == $ST_STUDENT)
            {
               redirect("registration.php?course_id=$course_id&type=$type&participant_id=$form_participant_id");
            }
            else if ($type == $ST_MERGE)
            {
               redirect("participant_merge.php?first_participant_id=$first_participant_id&second_participant_id=$form_participant_id");
            }
         }
         // Debugging
         else 
         {
            include("../header.php");
?>
<h2 style="text-align:center">Select Participant</h2>
<?php 
            echo "Headers already sent in $filename on line $linenum<br/>" .
                 "Cannot redirect; click on the link below:<br/><br/>";
            if ($type == $ST_PARTICIPANT)
            {
               echo '<a href="participant.php?mode=' . $MODE_EDIT . '&amp;participant_id=' . $form_participant_id . '">Continue</a>';
            }
            else if ($type == $ST_DOCTORATE)
            {
               echo '<a href="doctorate.php?mode=' . $MODE_ADD . '&amp;form_participant_id=' . $form_participant_id . '">Continue</a>';
            }
            else if ($type == $ST_CHANCELLOR)
            {
               echo '<a href="chancellor.php?mode=' . $MODE_ADD . '&amp;form_participant_id=' . $form_participant_id . '">Continue</a>';
            }
            else if ($type == $ST_INSTRUCTOR || $type == $ST_STUDENT)
            {
               echo '<a href="class.php?type=' . $type . '&amp;participant_id=' . $form_participant_id . '">Continue</a>';
            }
            else if ($type == $ST_MERGE)
            {
               echo '<a href="participant_merge.php?first_participant_id=' . $first_participant_id . '&amp;second_participant_id=' . $form_participant_id . '">Continue</a>';
            }
            echo "<br/><br/>";
            echo var_dump(headers_list());
            exit;
         }
      }
      else
      {
         $errmsg2 = "Please select a Participant.";
         // Rerun the search
         $submit = $SUBMIT_SEARCH;
      }
   }

   $link = db_connect();

   if ($submit == $SUBMIT_SEARCH)
   {
      $form_sca_name = "";
      if (isset($_POST['form_sca_name']))
      {
         $form_sca_name = clean($_POST['form_sca_name']);
      }
      $form_first_name = "";
      if (isset($_POST['form_first_name']))
      {
         $form_first_name = clean($_POST['form_first_name']);
      }
      $form_last_name = "";
      if (isset($_POST['form_last_name']))
      {
         $form_last_name = clean($_POST['form_last_name']);
      }

      $errmsg = "";

      if ($form_sca_name == '' && $form_first_name == '' && $form_last_name == '')
      {
         $errmsg = "Please enter part of an SCA Name, First Name or Last Name on which to search.<br/>";
      }

      if (strlen($errmsg) == 0)
      {
         $query = "SELECT participant.participant_id, atlantian.atlantian_id, user_auth.user_id, atlantian.sca_name, atlantian.preferred_sca_name, atlantian.alternate_names, atlantian.first_name, atlantian.last_name " .
                  "FROM $DBNAME_AUTH.atlantian LEFT OUTER JOIN $DBNAME_UNIVERSITY.participant ON atlantian.atlantian_id = participant.atlantian_id " .
                  "LEFT OUTER JOIN $DBNAME_AUTH.user_auth ON atlantian.atlantian_id = user_auth.atlantian_id WHERE ";
         $query1 = "SELECT participant.participant_id, user_auth.atlantian_id, user_auth.user_id, user_auth.sca_name, NULL, NULL, user_auth.first_name, user_auth.last_name " .
                  "FROM $DBNAME_AUTH.user_auth LEFT OUTER JOIN $DBNAME_UNIVERSITY.participant ON user_auth.user_id = participant.user_id " .
                  "WHERE user_auth.atlantian_id IS NULL AND ";
         $wc = "";
         $wc1 = "";
         if ($form_sca_name != "")
         {
            $wc .= "(atlantian.sca_name LIKE '%" . mysql_real_escape_string($form_sca_name) . "%' " .
                   "OR atlantian.preferred_sca_name LIKE '%" . mysql_real_escape_string($form_sca_name) . "%' " .
                   "OR atlantian.alternate_names LIKE '%" . mysql_real_escape_string($form_sca_name) . "%')";
            $wc1 .= "(user_auth.sca_name LIKE '%" . mysql_real_escape_string($form_sca_name) . "%') ";
         }
         if ($form_first_name != "")
         {
            if (strlen($wc) > 0)
            {
               $wc .= " AND ";
            }
            $wc .= "(atlantian.first_name LIKE '%" . mysql_real_escape_string($form_first_name) . "%')";
            if (strlen($wc1) > 0)
            {
               $wc1 .= " AND ";
            }
            $wc1 .= "(user_auth.first_name LIKE '%" . mysql_real_escape_string($form_first_name) . "%')";
         }
         if ($form_last_name != "")
         {
            if (strlen($wc) > 0)
            {
               $wc .= " AND ";
            }
            $wc .= "(atlantian.last_name LIKE '%" . mysql_real_escape_string($form_last_name) . "%')";
            if (strlen($wc1) > 0)
            {
               $wc1 .= " AND ";
            }
            $wc1 .= "(user_auth.last_name LIKE '%" . mysql_real_escape_string($form_last_name) . "%')";
         }
         if ($type == $ST_MERGE)
         {
            $wc .= " AND participant.participant_id != " . value_or_null($first_participant_id);
            $wc1 .= " AND participant.participant_id != " . value_or_null($first_participant_id);
         }
         $query .= $wc;
         $query1 .= $wc1;
         $query .= " UNION " . $query1 . " ORDER BY sca_name";

         /* Performing SQL query */
         $result = mysql_query($query) 
            or die("Search Query failed : " . $query . "<br/>" . mysql_error());
      }
   }

   $title = "Select Participant - " . ucfirst($mode) .  " Participant";
include("../header.php");
?>
<h2 style="text-align:center">Select Participant</h2>
<p class="title2" align="center">Search for Participants</p>
<?php
   if (isset($errmsg) && strlen($errmsg) > 0)
   {
      echo '<p align="center" style="color:red;font-weight:bold">' . $errmsg . '</p>';
   }
?>
<form action="select_participant.php" method="post">
<input type="hidden" name="course_id" id="course_id" value="<?php echo $course_id; ?>"/>
<input type="hidden" name="first_participant_id" id="first_participant_id" value="<?php echo $first_participant_id; ?>"/>
<input type="hidden" name="type" id="type"<?php if (isset($type) && $type != 0) { echo " value=\"$type\"";} ?>/>
<input type="hidden" name="mode" id="mode"<?php if (isset($mode)) { echo " value=\"$mode\"";} ?>/>
<table align="center" border="1" cellpadding="5" cellspacing="0" summary="Search Criteria selection">
   <tr>
      <th colspan="2" class="title">Search Criteria</th>
   </tr>
   <tr>
      <th class="titleright">SCA Name</th>
      <td class="data"><input type="text" name="form_sca_name" id="form_sca_name" size="50"<?php if (isset($form_sca_name) && $form_sca_name != '') { echo " value=\"$form_sca_name\"";} ?>/></td>
   </tr>
   <tr>
      <th class="titleright">Real Name</th>
      <td class="data">
      <b>First</b> <input type="text" name="form_first_name" id="form_first_name" size="25"<?php if (isset($form_first_name) && $form_first_name != '') { echo " value=\"$form_first_name\"";} ?>/>
      &nbsp;&nbsp;&nbsp;
      <b>Last</b> <input type="text" name="form_last_name" id="form_last_name" size="30"<?php if (isset($form_last_name) && $form_last_name != '') { echo " value=\"$form_last_name\"";} ?>/>
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
<hr style="color:<?php echo $accent_color; ?>"/>
</p>
<?php 
      if (isset($errmsg2) && strlen($errmsg2) > 0)
      {
         echo '<p align="center" style="color:red;font-weight:bold">' . $errmsg2 . '</p>';
      }
?>
<form action="select_participant.php" method="post">
<input type="hidden" name="form_sca_name" id="form_sca_name"<?php if (isset($form_sca_name) && $form_sca_name != '') { echo " value=\"$form_sca_name\"";} ?>/>
<input type="hidden" name="form_first_name" id="form_first_name"<?php if (isset($form_first_name) && $form_first_name != '') { echo " value=\"$form_first_name\"";} ?>/>
<input type="hidden" name="form_last_name" id="form_last_name"<?php if (isset($form_last_name) && $form_last_name != '') { echo " value=\"$form_last_name\"";} ?>/>
<input type="hidden" name="course_id" id="course_id" value="<?php echo $course_id; ?>"/>
<input type="hidden" name="first_participant_id" id="first_participant_id" value="<?php echo $first_participant_id; ?>"/>
<input type="hidden" name="type" id="type"<?php if (isset($type) && $type != 0) { echo " value=\"$type\"";} ?>/>
<input type="hidden" name="mode" id="mode"<?php if (isset($mode)) { echo " value=\"$mode\"";} ?>/>
<table align="center" cellpadding="5" cellspacing="0" border="1" summary="Table listing search results">
   <tr>
      <th class="title" nowrap="nowrap">Select</th>
      <th class="title" nowrap="nowrap">SCA Name</th>
      <th class="title">Alternate Names</th>
      <th class="title">First Name</th>
      <th class="title">Last Name</th>
   </tr>
<?php 
      while ($data = mysql_fetch_array($result, MYSQL_BOTH))
      {
         $participant_id = $data['participant_id'];
         $atlantian_id = $data['atlantian_id'];
         $user_id = $data['user_id'];
         $sca_name = $data['sca_name'];
         $preferred_sca_name = $data['preferred_sca_name'];
         $alternate_names = $data['alternate_names'];
         // Preferred name does not match SCA name and isn't in alternate names list
         if ($sca_name != $preferred_sca_name && stripos($alternate_names, $preferred_sca_name) === FALSE)
         {
            if (strlen($alternate_names) > 0)
            {
               $alternate_names .= ", " . $preferred_sca_name;
            }
            else
            {
               $alternate_names = $preferred_sca_name;
            }
         }
         $first_name = $data['first_name'];
         $last_name = $data['last_name'];
         if ($participant_id == "")
         {
            $participant_id = 0;
         }
         if ($user_id == "")
         {
            $user_id = 0;
         }
         if ($atlantian_id == "")
         {
            $atlantian_id = 0;
         }
         $combo_id = $participant_id . "_" . $user_id . "_" . $atlantian_id;
?>
   <tr>
      <td class="title"><input type="radio" name="form_combo_id" id="form_combo_id" value="<?php echo $combo_id; ?>"/></td>
      <td class="data"><?php echo $sca_name; ?></td>
      <td class="data" nowrap="nowrap"><?php echo $alternate_names; ?></td>
      <td class="data"><?php echo $first_name; ?></td>
      <td class="data"><?php echo $last_name; ?></td>
   </tr>
<?php 
      }
?>
   <tr>
      <th class="title" colspan="5"><input type="submit" name="submit" value="<?php echo $SUBMIT_SELECT; ?>"/></th>
   </tr>
</table>
</form>
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
<hr style="color:<?php echo $accent_color; ?>"/>
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
include("../header.php");
?>
<h2 style="text-align:center">Select Participant</h2>
<p style="text-align:center">You are not authorized to access this page.</p>
<?php
}
include("../footer.php");
?>



