<?php
include_once("db.php");

$SUBMIT_SELECT = "Select Award";
$SUBMIT_SAVE = "Save Award";
$SUBMIT_DELETE = "Delete Award";

$submit = "";
if (isset($_POST['submit']))
{
   $submit = clean($_POST['submit']);
}
$errmsg = "";

// Only allow authorized users
if (isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN])
{
   $mode = $MODE_ADD;
   if (isset($_REQUEST['mode']))
   {
      $mode = clean($_REQUEST['mode']);
   }

   // Selected someone?
   $form_atlantian_id = 0;
   if (isset($_REQUEST['atlantian_id']))
   {
      $form_atlantian_id = clean($_REQUEST['atlantian_id']);
   }
   else if (isset($_POST['form_atlantian_id']))
   {
      $form_atlantian_id = clean($_POST['form_atlantian_id']);
   }

   // Selected new award for add?
   $form_award_id = 0;
   if (isset($_REQUEST['award_id']))
   {
      $form_award_id = clean($_REQUEST['award_id']);
   }
   else if (isset($_POST['form_award_id']))
   {
      $form_award_id = clean($_POST['form_award_id']);
   }

   // Selected existing award for edit?
   $form_atlantian_award_id = 0;
   if (isset($_REQUEST['atlantian_award_id']))
   {
      $form_atlantian_award_id = clean($_REQUEST['atlantian_award_id']);
   }
   else if (isset($_POST['form_atlantian_award_id']))
   {
      $form_atlantian_award_id = clean($_POST['form_atlantian_award_id']);
   }

   // Added from court report
   $form_court_report_id = 0;
   if (isset($_REQUEST['form_court_report_id']))
   {
      $form_court_report_id = $_REQUEST['form_court_report_id'];
   }

   // Added from event/court report
   $form_event_id = 0;
   if (isset($_REQUEST['form_event_id']))
   {
      $form_event_id = $_REQUEST['form_event_id'];
   }

   $db_refresh = true;
   if ($submit != "")
   {
      $form_atlantian_id = clean($_POST['form_atlantian_id']);
      $form_branch_id = "";
      if (isset($_POST['form_branch_id']))
      {
         $form_branch_id = clean($_POST['form_branch_id']);
      }
      $form_award_date = "";
      if (isset($_POST['form_award_date']))
      {
         $form_award_date = clean($_POST['form_award_date']);
      }
      $form_sequence = "";
      if (isset($_POST['form_sequence']))
      {
         $form_sequence = clean($_POST['form_sequence']);
      }
      $form_comments = "";
      if (isset($_POST['form_comments']))
      {
         $form_comments = clean($_POST['form_comments']);
      }
      $form_retired_date = "";
      if (isset($_POST['form_retired_date']))
      {
         $form_retired_date = clean($_POST['form_retired_date']);
      }
      if (isset($_POST['form_select_branch']))
      {
         $form_select_branch = clean($_POST['form_select_branch']);
      }
      $form_premier = 0;
      if (isset($_POST['form_premier']))
      {
         $form_premier = clean($_POST['form_premier']);
      }
      $form_resigned_date = "";
      if (isset($_POST['form_resigned_date']))
      {
         $form_resigned_date = clean($_POST['form_resigned_date']);
      }
      $form_revoked_date = "";
      if (isset($_POST['form_revoked_date']))
      {
         $form_revoked_date = clean($_POST['form_revoked_date']);
      }
      $form_gender = $UNKNOWN;
      if (isset($_POST['form_gender']))
      {
         $form_gender = clean($_POST['form_gender']);
      }
      $form_private = 0;
      if (isset($_POST['form_private']))
      {
         $form_private = clean($_POST['form_private']);
      }
      // Backlog
      $form_scroll_status_id = "";
      if (isset($_POST['form_scroll_status_id']))
      {
         $form_scroll_status_id = clean($_POST['form_scroll_status_id']);
      }
      $form_scroll_assignees = "";
      if (isset($_POST['form_scroll_assignees']))
      {
         $form_scroll_assignees = clean($_POST['form_scroll_assignees']);
      }
      $form_scroll_assigned_date = "";
      if (isset($_POST['form_scroll_assigned_date']))
      {
         $form_scroll_assigned_date = clean($_POST['form_scroll_assigned_date']);
      }

      // Validation
      if ($mode == $MODE_ADD && $submit == $SUBMIT_SELECT && !validate_positive_integer($form_award_id))
      {
         $errmsg .= "Please select a valid Award.<br/>";
      }
      if ($form_award_date != '') 
      {
         if (strtotime($form_award_date) === FALSE)
         {
            $errmsg .= "Please enter a valid date for the Award Date.<br/>";
         }
         else
         {
            $form_award_date = format_mysql_date($form_award_date);
         }
      }
      if (($form_sequence != '') && (!validate_zero_plus_integer($form_sequence)))
      {
         $errmsg .= "Please enter a valid number for the Sequence.<br/>";
      }
      if ($form_retired_date != '') 
      {
         if (strtotime($form_retired_date) === FALSE)
         {
            $errmsg .= "Please enter a valid date for the Retired Date.<br/>";
         }
         else
         {
            $form_retired_date = format_mysql_date($form_retired_date);
         }
      }
      if ($form_resigned_date != '') 
      {
         if (strtotime($form_resigned_date) === FALSE)
         {
            $errmsg .= "Please enter a valid date for the Resigned Date.<br/>";
         }
         else
         {
            $form_resigned_date = format_mysql_date($form_resigned_date);
         }
      }
      if ($form_revoked_date != '') 
      {
         if (strtotime($form_revoked_date) === FALSE)
         {
            $errmsg .= "Please enter a valid date for the Revoked Date.<br/>";
         }
         else
         {
            $form_revoked_date = format_mysql_date($form_revoked_date);
         }
      }
      if ($form_scroll_assigned_date != '') 
      {
         if (strtotime($form_scroll_assigned_date) === FALSE)
         {
            $errmsg .= "Please enter a valid date for the Scroll Assigned Date.<br/>";
         }
         else
         {
            $form_scroll_assigned_date = format_mysql_date($form_scroll_assigned_date);
         }
      }
      /* Glynis' dumbass flag request */
      if ($form_award_id == $COURT_BARONAGE_GOA_ID && $form_branch_id == $ATLANTIA)
      {
         $errmsg .= "Atlantia does not bestow grant-level Court Baronage - please select Court Baronage (AoA) for Atlantian awards.<br/>";
      }

      /* Connecting, selecting database */
      $db_link = db_admin_connect();

      if ($errmsg == "")
      {
         if ($submit == $SUBMIT_DELETE)
         {
            $delete_query = "DELETE FROM $DBNAME_OP.atlantian_award WHERE atlantian_award_id = " . value_or_null($form_atlantian_award_id);
            $delete_result = mysql_query($delete_query) 
               or die("DELETE from OP failed : " . mysql_error());
         }
         else if ($submit == $SUBMIT_SAVE)
         {
            if ($form_event_id == 0)
            {
               $form_event_id = '';
            }
            if ($form_court_report_id == 0)
            {
               $form_court_report_id = '';
            }
            // Update
            if ($mode == $MODE_EDIT && $form_atlantian_award_id > 0)
            {
               // Retire current baronage
               if ($form_retired_date != "" && $form_award_id == $LANDED_BARONAGE_ID)
               {
                  $form_award_id = $RETIRED_BARONAGE_ID;
               }
               $update_query = "UPDATE $DBNAME_OP.atlantian_award SET " .
                               "atlantian_id = " . value_or_null($form_atlantian_id) .
                               ", award_id = " . value_or_null($form_award_id) .
                               ", branch_id = " . value_or_null($form_branch_id) .
                               ", award_date = " . value_or_null($form_award_date) .
                               ", sequence = " . value_or_zero($form_sequence) .
                               ", premier = " . value_or_zero($form_premier) .
                               ", comments = " . value_or_null($form_comments) .
                               ", retired_date = " . value_or_null($form_retired_date) .
                               ", resigned_date = " . value_or_null($form_resigned_date) .
                               ", revoked_date = " . value_or_null($form_revoked_date) .
                               ", gender = " . value_or_null($form_gender) .
                               ", event_id = " . value_or_null($form_event_id) .
                               ", court_report_id = " . value_or_null($form_court_report_id) .
                               ", last_updated = " . value_or_null(date("Y-m-d")) .
                               ", last_updated_by = " . value_or_null($_SESSION["s_user_id"]) .
                               ", private = " . value_or_zero($form_private) .
                               ", scroll_status_id = " . value_or_null($form_scroll_status_id) .
                               ", scroll_assignees = " . value_or_null($form_scroll_assignees) .
                               ", scroll_assigned_date = " . value_or_null($form_scroll_assigned_date) .
                               " WHERE atlantian_award_id = " . value_or_null($form_atlantian_award_id);

               $update_result = mysql_query($update_query) 
                  or die("UPDATE failed : " . mysql_error());
            }
            // Insert
            else // if ($mode == $MODE_ADD && $form_atlantian_award_id == 0)
            {
               $insert_query = "INSERT INTO $DBNAME_OP.atlantian_award (atlantian_id, award_id, branch_id, award_date, sequence, premier, comments, retired_date, resigned_date, revoked_date, gender, event_id, court_report_id, last_updated, last_updated_by, private, scroll_status_id, scroll_assignees, scroll_assigned_date) VALUES (" .
                               value_or_null($form_atlantian_id) . ", ".
                               value_or_null($form_award_id) . ", " .
                               value_or_null($form_branch_id) . ", " .
                               value_or_null($form_award_date) . ", " .
                               value_or_zero($form_sequence) . ", " .
                               value_or_zero($form_premier) . ", " .
                               value_or_null($form_comments) . ", " .
                               value_or_null($form_retired_date) . ", " .
                               value_or_null($form_resigned_date) . ", " .
                               value_or_null($form_revoked_date) . ", " .
                               value_or_null($form_gender) . ", " .
                               value_or_null($form_event_id) . ", " .
                               value_or_null($form_court_report_id) . ", " .
                               value_or_null(date("Y-m-d")) . ", " .
                               value_or_null($_SESSION["s_user_id"]) . ", " .
                               value_or_zero($form_private) . ", " .
                               value_or_null($form_scroll_status_id) . ", " .
                               value_or_null($form_scroll_assignees) . ", " .
                               value_or_null($form_scroll_assigned_date) .
                               ")";

               $insert_result = mysql_query($insert_query) 
                  or die("INSERT failed : " . mysql_error());
               $form_atlantian_award_id = mysql_insert_id();

               // Is this an award that requires special processing?
               // St. Aidan
               if ($form_award_id == $ST_AIDAN)
               {
                  // Insert Augmentation of Arms
                  $insert_query = "INSERT INTO $DBNAME_OP.atlantian_award (atlantian_id, award_id, branch_id, award_date, sequence, comments, event_id, court_report_id, last_updated, last_updated_by, private, scroll_status_id, scroll_assignees, scroll_assigned_date) VALUES (" .
                                  value_or_null($form_atlantian_id) . ", ".
                                  $AUG . ", " .
                                  $ATLANTIA . ", " .
                                  value_or_null($form_award_date) . ", " .
                                  value_or_zero($form_sequence) . ", " .
                                  value_or_null("Saint Aidan") . ", " .
                                  value_or_null($form_event_id) . ", " .
                                  value_or_null($form_court_report_id) . ", " .
                                  value_or_null(date("Y-m-d")) . ", " .
                                  value_or_null($_SESSION["s_user_id"]) . ", " .
                                  value_or_zero($form_private) . ", " .
                                  value_or_null($form_scroll_status_id) . ", " .
                                  value_or_null($form_scroll_assignees) . ", " .
                                  value_or_null($form_scroll_assigned_date) .
                                  ")";

                  $insert_result = mysql_query($insert_query) 
                     or die("INSERT failed : " . mysql_error());
                  $augmentation_id = mysql_insert_id();
               }
               // Check for other types
               else
               {
                  $award_query = "SELECT award.type_id FROM $DBNAME_OP.award WHERE award_id = " . value_or_null($form_award_id);

                  $award_result = mysql_query($award_query) 
                     or die("Award query failed : " . mysql_error());

                  $award_data = mysql_fetch_array($award_result, MYSQL_BOTH);
                  $type_id = $award_data['type_id'];
                  // If we just added a bestowed peerage for a member of Saint Aidan, automatically retire them from Saint Aidan
                  if ($type_id == $BESTOWED_PEER)
                  {
                     $aidan_query = "SELECT atlantian_award_id, award_id, award_date, retired_date FROM $DBNAME_OP.atlantian_award WHERE atlantian_id = " . value_or_null($form_atlantian_id) . " AND award_id = " . $ST_AIDAN;
                     $aidan_result = mysql_query($aidan_query) 
                        or die("Aidan query failed : " . mysql_error());

                     $num = mysql_num_rows($aidan_result);

                     if ($num > 0)
                     {
                        $aidan_data = mysql_fetch_array($aidan_result, MYSQL_BOTH);
                        $aidan_ret_date = $aidan_data['retired_date'];
                        $aidan_id = $aidan_data['atlantian_award_id'];
                        if ($aidan_ret_date == "")
                        {
                           $aidan_update = "UPDATE $DBNAME_OP.atlantian_award SET retired_date = " . value_or_null($form_award_date) . 
                                           ", last_updated = " . value_or_null(date("Y-m-d")) .
                                           ", last_updated_by = " . value_or_null($_SESSION["s_user_id"]) .
                                           " WHERE atlantian_award_id = " . value_or_null($aidan_id);
                           $aidan_result = mysql_query($aidan_update) 
                              or die("Aidan update failed : " . mysql_error());
                        }
                     }
                  }

                  // Atlantian Territorial Baronage GoA+ check
                  if ($type_id == $LANDED_BARONAGE || $type_id == $RETIRED_BARONAGE)
                  {
                     $arms_kingdom = get_kingdom_id($form_branch_id);
                     if ($arms_kingdom == $ATLANTIA)
                     {
                        $award_check_query = "SELECT atlantian_award_id FROM $DBNAME_OP.atlantian_award JOIN $DBNAME_OP.award ON atlantian_award.award_id = award.award_id JOIN $DBNAME_OP.precedence ON precedence.type_id = award.type_id " .
                                             "WHERE precedence.precedence <= " . value_or_null($GOA_P) . " AND award_date < " . value_or_null($form_award_date) . " AND atlantian_id = " . value_or_null($form_atlantian_id);
                        $award_check_result = mysql_query($award_check_query) 
                           or die("Award check query failed : " . mysql_error());

                        $num = mysql_num_rows($award_check_result);
                        // Need to add GoA for Atlantian Territorial Baronage not already of AoA rank
                        if ($num == 0)
                        {
                           $add_arms_query = "INSERT INTO $DBNAME_OP.atlantian_award (atlantian_id, award_id, branch_id, award_date, sequence, event_id, court_report_id, last_updated, last_updated_by, private, scroll_status_id, scroll_assignees, scroll_assigned_date) VALUES (" .
                                             value_or_null($form_atlantian_id) . ", " .
                                             $GOA . ", " .
                                             $ATLANTIA . ", " .
                                             value_or_null($form_award_date) . ", " .
                                             value_or_zero($form_sequence) . ", " .
                                             value_or_null($form_event_id) . ", " .
                                             value_or_null($form_court_report_id) . ", " .
                                             value_or_null(date("Y-m-d")) . ", " .
                                             value_or_null($_SESSION["s_user_id"]) . ", " .
                                             value_or_zero($form_private) . ", " .
                                             value_or_null($form_scroll_status_id) . ", " .
                                             value_or_null($form_scroll_assignees) . ", " .
                                             value_or_null($form_scroll_assigned_date) .
                                             ")";

                           $add_arms_result = mysql_query($add_arms_query) 
                              or die("INSERT of Arms failed : " . mysql_error());
                           $arms_id = mysql_insert_id();
                        }
                     }
                  }

                  // POA Check
                  if ($type_id == $BESTOWED_PEER || $type_id == $COUNTY)
                  {
                     $award_check_query = "SELECT atlantian_award_id FROM $DBNAME_OP.atlantian_award WHERE atlantian_id = " . value_or_null($form_atlantian_id) . " AND award_id = " . $POA;
                  }
                  // GOA Check
                  else if ($type_id == $ORDER_HIGH_MERIT || $type_id == $LANDED_BARONAGE || $type_id == $RETIRED_BARONAGE || $type_id == $COURT_BARONAGE_GOA)
                  {
                     $award_check_query = "SELECT atlantian_award_id FROM $DBNAME_OP.atlantian_award WHERE atlantian_id = " . value_or_null($form_atlantian_id) . " AND award_id = " . $GOA;
                  }
                  // AOA Check
                  else if ($type_id == $ORDER_MERIT || $type_id == $COURT_BARONAGE_AOA)
                  {
                     $award_check_query = "SELECT atlantian_award_id FROM $DBNAME_OP.atlantian_award WHERE atlantian_id = " . value_or_null($form_atlantian_id) . " AND award_id = " . $AOA;
                  }
                  // Run check if we need to
                  if (isset($award_check_query) && $award_check_query != '')
                  {
                     $award_check_result = mysql_query($award_check_query) 
                        or die("Award check query failed : " . mysql_error());

                     $num = mysql_num_rows($award_check_result);
                     $add_arms = "";
                     $arms_kingdom = "";
                     // Need to add Arms
                     if ($num == 0)
                     {
                        if ($type_id == $COUNTY)
                        {
                           $arms_kingdom = $form_branch_id;
                           $add_arms = get_type_arms_by_kingdom($type_id, $arms_kingdom);
                        }
                        else if ($form_award_id == $ROSE)
                        {
                           $arms_kingdom = $form_branch_id;
                           $add_arms = get_rose_arms_by_kingdom($arms_kingdom);
                        }
                        else if ($type_id == $BESTOWED_PEER)
                        {
                           $arms_kingdom = $form_branch_id;
                           $add_arms = $POA;
                        }
                        else if ($type_id == $LANDED_BARONAGE || $type_id == $RETIRED_BARONAGE)
                        {
                           $arms_kingdom = get_kingdom_id($form_branch_id);
                           $add_arms = get_type_arms_by_kingdom($type_id, $arms_kingdom);
                        }
                        else if ($type_id == $COURT_BARONAGE_AOA || $type_id == $COURT_BARONAGE_GOA)
                        {
                           $arms_kingdom = $form_branch_id;
                           $add_arms = get_type_arms_by_kingdom($type_id, $arms_kingdom);
                        }
                        else if ($type_id == $ORDER_HIGH_MERIT)
                        {
                           $arms_kingdom = get_award_group_id($form_award_id);
                           $add_arms = $GOA;
                        }
                        else if ($type_id == $ORDER_MERIT)
                        {
                           $arms_kingdom = get_award_group_id($form_award_id);
                           $add_arms = $AOA;
                        }
                        if ($add_arms != "")
                        {
                           $add_arms_query = "INSERT INTO $DBNAME_OP.atlantian_award (atlantian_id, award_id, branch_id, award_date, sequence, last_updated, last_updated_by) VALUES (" .
                                             value_or_null($form_atlantian_id) . ", " .
                                             $add_arms . ", " .
                                             $arms_kingdom . ", " .
                                             value_or_null($form_award_date) . ", " .
                                             value_or_zero($form_sequence) . ", " .
                                             value_or_null(date("Y-m-d")) . ", " .
                                             value_or_null($_SESSION["s_user_id"]) .
                                             ")";
                           /*
                           $add_arms_result = mysql_query($add_arms_query) 
                              or die("INSERT of Arms failed : " . mysql_error());
                           $arms_id = mysql_insert_id();
                           */
                        }
                     }
                  }
               } // check for extra awards
            }
         } // SUBMIT_SAVE
      }
      // Errors - display them without changing added data
      else
      {
         $db_refresh = false;
      }
      db_disconnect($db_link);
   } // submit

   /* Connecting, selecting database */
   $link = db_connect();

   /* Performing SQL query */
   if ($form_atlantian_id > 0)
   {
      $atlantian_query = 
         "SELECT atlantian_id, sca_name ".
         "FROM $DBNAME_AUTH.atlantian ".
         "WHERE atlantian_id = ". $form_atlantian_id ;

      $atlantian_result = mysql_query($atlantian_query) 
         or die("Atlantian Query failed : " . mysql_error());

      $atlantian_data = mysql_fetch_array($atlantian_result, MYSQL_BOTH);

      $form_atlantian_id = $atlantian_data['atlantian_id'];
      $form_scaname = trim($atlantian_data['sca_name']);
   }

   if ($form_atlantian_award_id > 0 && $submit != $SUBMIT_DELETE)
   {
      $idquery = 
         "SELECT atlantian_award_id, award_id, award_date, sequence, premier, comments, retired_date, resigned_date, revoked_date, gender, event_id, court_report_id, private, " .
         "atlantian_award.scroll_status_id, scroll_assignees, scroll_assigned_date, atlantian_award.branch_id, branch, scroll_status, scroll_status_code " .
         "FROM $DBNAME_OP.atlantian_award LEFT OUTER JOIN $DBNAME_BRANCH.branch ON atlantian_award.branch_id = branch.branch_id " .
         "LEFT OUTER JOIN $DBNAME_OP.scroll_status ON atlantian_award.scroll_status_id = scroll_status.scroll_status_id " .
         "WHERE atlantian_award_id = ". value_or_null($form_atlantian_award_id);

      $idresult = mysql_query($idquery) 
         or die("ID Query failed : " . mysql_error());

      $iddata = mysql_fetch_array($idresult, MYSQL_BOTH);

      $form_atlantian_award_id = $iddata['atlantian_award_id'];
      $form_award_id = $iddata['award_id'];
      if ($db_refresh)
      {
         $form_award_date = $iddata['award_date'];
         $form_sequence = $iddata['sequence'];
         $form_premier = $iddata['premier'];
         $form_comments = $iddata['comments'];
         $form_retired_date = $iddata['retired_date'];
         $form_resigned_date = $iddata['resigned_date'];
         $form_revoked_date = $iddata['revoked_date'];
         $form_gender = $iddata['gender'];
         $form_event_id = $iddata['event_id'];
         $form_court_report_id = $iddata['court_report_id'];
         $form_private = $iddata['private'];
         $form_branch_id = $iddata['branch_id'];
         $form_branch = $iddata['branch'];
         $form_scroll_status_id = $iddata['scroll_status_id'];
         $form_scroll_assignees = $iddata['scroll_assignees'];
         $form_scroll_assigned_date = $iddata['scroll_assigned_date'];
         $form_scroll_status = $iddata['scroll_status'];
         $form_scroll_status_code = $iddata['scroll_status_code'];
      }
   }
   if ($form_award_id > 0)
   {
      $award_query = 
         "SELECT award.award_id, award.award_name, award.type_id, award.branch_id, ".
         "branch.branch, award.select_branch, award_group_id ".
         "FROM $DBNAME_OP.award LEFT OUTER JOIN $DBNAME_BRANCH.branch ON award.branch_id = branch.branch_id ".
         "WHERE award.award_id = ". value_or_null($form_award_id);

      $award_result = mysql_query($award_query) 
         or die("Award Query failed : " . mysql_error());

      $award_data = mysql_fetch_array($award_result, MYSQL_BOTH);

      $form_award_id = $award_data['award_id'];
      $form_award_group_id = $award_data['award_group_id'];
      $form_award_name = trim($award_data['award_name']);
      if (!isset($form_branch_id) || $form_branch_id == "")
      {
         $form_branch_id = trim($award_data['branch_id']);
      }
      if (!isset($form_branch) || $form_branch == "")
      {
         $form_branch = trim($award_data['branch']);
      }
      $form_select_branch = $award_data['select_branch'];
   }

   $event_display = "";
   $court_display = "";
   if ($form_court_report_id > 0)
   {
      $cr_query = "SELECT c.court_report_id, c.event_id, c.court_type, c.court_date, c.court_time, c.kingdom_id, kingdom.branch as kingdom, " .
                  "e.event_name, e.branch_id, e.start_date, e.end_date, event_group.branch, " .
                  "principality.principality_display, reign.monarchs_display, baronage.baronage_display, barony.branch as barony " .
                  "FROM $DBNAME_OP.court_report c JOIN $DBNAME_OP.event e ON c.event_id = e.event_id " .
                  "LEFT OUTER JOIN $DBNAME_BRANCH.branch kingdom ON c.kingdom_id = kingdom.branch_id " .
                  "LEFT OUTER JOIN $DBNAME_BRANCH.branch event_group ON e.branch_id = event_group.branch_id " .
                  "LEFT OUTER JOIN $DBNAME_OP.principality ON c.principality_id = principality.principality_id " .
                  "LEFT OUTER JOIN $DBNAME_OP.reign ON c.reign_id = reign.reign_id " .
                  "LEFT OUTER JOIN $DBNAME_OP.baronage ON c.baronage_id = baronage.baronage_id " .
                  "LEFT OUTER JOIN $DBNAME_BRANCH.branch barony ON baronage.branch_id = barony.branch_id " .
                  "WHERE c.court_report_id = " . value_or_null($form_court_report_id);

      $cr_result = mysql_query($cr_query) 
         or die("Court Report Query failed : " . mysql_error());

      $cr_data = mysql_fetch_array($cr_result, MYSQL_BOTH);

      $form_court_report_id = clean($cr_data['court_report_id']);
      $form_event_id = clean($cr_data['event_id']);
      $form_event_name = clean($cr_data['event_name']);
      $form_start_date = clean($cr_data['start_date']);
      $form_end_date = clean($cr_data['end_date']);
      $branch = clean($cr_data['branch']);
      $form_court_type = clean($cr_data['court_type']);
      $form_court_date = clean($cr_data['court_date']);
      $form_court_time = clean($cr_data['court_time']);
      $form_c_branch_id = clean($cr_data['branch_id']);
      $form_c_kingdom_id = clean($cr_data['kingdom_id']);

      if ($form_atlantian_award_id == 0)
      {
         $form_award_date = $form_court_date;
         if (isset($form_select_branch) && $form_select_branch == 1)
         {
            $form_branch_id = get_kingdom_id($form_c_kingdom_id);
         }
      }
      $names = "";
      $group = "";
      if ($form_court_type == $COURT_TYPE_ROYAL)
      {
         $monarchs = clean($cr_data['monarchs_display']);
         $principality = clean($cr_data['principality_display']);
         if ($monarchs != "")
         {
            $names = $monarchs;
         }
         else if ($principality != "")
         {
            $names = $principality;
         }
         $group = clean($cr_data['kingdom']);
      }
      if ($form_court_type == $COURT_TYPE_BARONIAL)
      {
         $names = clean($cr_data['baronage_display']);
         $group = clean($cr_data['barony']);
      }
      if ($names != "")
      {
         $names = " - $names";
      }
      if ($group != "")
      {
         $group = " ($group)";
      }
      $court_display = translate_court_type($form_court_type) . $group . $names . " - " . translate_court_time($form_court_time);

      $event_display = $form_event_name . " (" . $branch . ") ";
      if ($form_start_date == $form_end_date && $form_start_date != '')
      {
         $event_display .= format_short_date($form_start_date);
      }
      else if ($form_start_date != $form_end_date && $form_start_date != '' && $form_end_date != '')
      {
         $event_display .= format_short_date($form_start_date) . " - " . format_short_date($form_end_date);
      }
   }
   else if ($form_event_id > 0)
   {
      $e_query = "SELECT event.event_id, event.event_name, event.start_date, event.end_date, branch.branch, event.branch_id " .
                 "FROM $DBNAME_OP.event LEFT OUTER JOIN $DBNAME_BRANCH.branch ON event.branch_id = branch.branch_id " .
                 "WHERE event.event_id = " . value_or_null($form_event_id);

      $e_result = mysql_query($e_query) 
         or die("Event Query failed : " . mysql_error());

      $e_data = mysql_fetch_array($e_result, MYSQL_BOTH);

      $form_event_id = clean($e_data['event_id']);
      $form_event_name = clean($e_data['event_name']);
      $form_start_date = clean($e_data['start_date']);
      $form_end_date = clean($e_data['end_date']);
      $branch = clean($e_data['branch']);
      $form_e_branch_id = clean($e_data['branch_id']);

      if ($form_atlantian_award_id == 0)
      {
         $form_award_date = $form_start_date;
         if (isset($form_select_branch) && $form_select_branch == 1)
         {
            $form_branch_id = get_kingdom_id($form_e_branch_id);
         }
      }

      $event_display = $form_event_name . " (" . $branch . ") ";
      if ($form_start_date == $form_end_date && $form_start_date != '')
      {
         $event_display .= format_short_date($form_start_date);
      }
      else if ($form_start_date != $form_end_date && $form_start_date != '' && $form_end_date != '')
      {
         $event_display .= format_short_date($form_start_date) . " - " . format_short_date($form_end_date);
      }
   }
   // Setup pick lists for events/court reports if award date is set and there are potential matches
   if (isset($form_award_date) && $form_award_date != '') 
   {
      // The award is Atlantian
      if (isset($form_branch_id) && $form_branch_id != 0 && $form_branch_id != '' && get_kingdom_id($form_branch_id) == $ATLANTIA)
      {
         // No event or court report selected - let an event be selected
         if (($form_event_id == 0 || $form_event_id == '') && ($form_court_report_id == 0 || $form_court_report_id == ''))
         {
            $e2_query = "SELECT event_id, event_name, start_date, end_date, branch " .
                        "FROM $DBNAME_OP.event LEFT OUTER JOIN $DBNAME_BRANCH.branch ON event.branch_id = branch.branch_id " .
                        "WHERE start_date <= " . value_or_null($form_award_date) . " AND end_date >= " . value_or_null($form_award_date) . " " .
                        "ORDER BY start_date";

            $e2_result = mysql_query($e2_query) 
               or die("Event 2 query failed : " . mysql_error());
         }
         if ($form_event_id > 0 && ($form_court_report_id == 0 || $form_court_report_id == ''))
         {
            $c2_query = "SELECT c.court_report_id, c.event_id, c.court_type, c.court_date, c.court_time, e.event_name, e.branch_id, kingdom.branch as kingdom, " .
                        "principality.principality_display, reign.monarchs_display, baronage.baronage_display, barony.branch as barony " .
                        "FROM $DBNAME_OP.court_report c JOIN event e ON c.event_id = e.event_id " .
                        "LEFT OUTER JOIN $DBNAME_BRANCH.branch kingdom ON c.kingdom_id = kingdom.branch_id " .
                        "LEFT OUTER JOIN $DBNAME_OP.principality ON c.principality_id = principality.principality_id " .
                        "LEFT OUTER JOIN $DBNAME_OP.reign ON c.reign_id = reign.reign_id " .
                        "LEFT OUTER JOIN $DBNAME_OP.baronage ON c.baronage_id = baronage.baronage_id " .
                        "LEFT OUTER JOIN $DBNAME_BRANCH.branch barony ON baronage.branch_id = barony.branch_id " .
                        "WHERE court_date = " . value_or_null($form_award_date) . " " .
                        "AND c.event_id = " . value_or_null($form_event_id) . " " .
                        "ORDER BY court_time";

            $c2_result = mysql_query($c2_query) 
               or die("Court Report 2 query failed : " . mysql_error());
         }
      }
   }

   /* Printing results in HTML */
   $title = ucfirst($mode) . " Atlantian Award";
   include('header.php');
?>
<p class="title2"><?php echo ucfirst($mode); ?> <?php echo $KINGDOM_ADJ; ?> Award</p>
<?php
if (isset($errmsg) && strlen($errmsg) > 0)
{
   echo '<p align="center" style="color:red;font-weight:bold">' . $errmsg . '</p>';
}
?>

<table border="1" cellpadding="5" cellspacing="0" summary="Table used for layout and formatting">
<?php 
   /* PAGE 1 - Select Existing Award */ 
   if ($form_atlantian_id > 0 && $form_award_id == 0 && $form_atlantian_award_id == 0)
   {
      $award_query = NULL;
      $id_field = NULL;
      if ($mode == $MODE_EDIT)
      {
         $id_field = 'atlantian_award_id';
         $award_query = 
            "(SELECT award.award_id, award.award_name, award.award_name_male, award.award_name_female, award.type_id, award.select_branch, " .
            "atlantian_award.atlantian_award_id, atlantian_award.award_date, atlantian_award.sequence, atlantian_award.premier, atlantian_award.retired_date, " .
            "branch.branch, branch.branch_id, precedence.precedence ".
            "FROM $DBNAME_OP.award, $DBNAME_OP.atlantian_award, $DBNAME_BRANCH.branch, $DBNAME_OP.precedence ".
            "WHERE award.award_id = atlantian_award.award_id  ".
            "AND award.type_id = precedence.type_id ".
            "AND award.branch_id = branch.branch_id ".
            "AND atlantian_award.atlantian_id = ". $form_atlantian_id . ") ".
            "UNION ".
            "(SELECT award.award_id, award.award_name, award.award_name_male, award.award_name_female, award.type_id, award.select_branch, " .
            "atlantian_award.atlantian_award_id, atlantian_award.award_date, atlantian_award.sequence, atlantian_award.premier, atlantian_award.retired_date, " .
            "branch.branch, branch.branch_id, precedence.precedence ".
            "FROM $DBNAME_OP.award, $DBNAME_OP.atlantian_award, $DBNAME_BRANCH.branch, $DBNAME_OP.precedence ".
            "WHERE award.award_id = atlantian_award.award_id  ".
            "AND award.type_id = precedence.type_id ".
            "AND atlantian_award.branch_id = branch.branch_id ".
            "AND atlantian_award.atlantian_id = ". $form_atlantian_id . ") ".
            "UNION ".
            "(SELECT award.award_id, award.award_name, award.award_name_male, award.award_name_female, award.type_id, award.select_branch, " .
            "atlantian_award.atlantian_award_id, atlantian_award.award_date, atlantian_award.sequence, atlantian_award.premier, atlantian_award.retired_date, " .
            "null AS branch, null AS branch_id, precedence.precedence ".
            "FROM $DBNAME_OP.award, $DBNAME_OP.atlantian_award, $DBNAME_OP.precedence ".
            "WHERE award.award_id = atlantian_award.award_id  ".
            "AND award.type_id = precedence.type_id ".
            "AND atlantian_award.branch_id IS NULL ".
            "AND award.branch_id IS NULL ".
            "AND atlantian_award.atlantian_id = ". $form_atlantian_id . ") ".
            "ORDER BY precedence, award_date, sequence";
      }
      else // if ($mode == $MODE_ADD)
      {
         $id_field = 'award_id';
         $award_query = 
            "SELECT award.award_id, award.award_name, award.title_id, award.type_id, award.select_branch, award.branch_id, branch.branch ".
            "FROM $DBNAME_OP.precedence JOIN $DBNAME_OP.award ON precedence.type_id = award.type_id LEFT OUTER JOIN $DBNAME_BRANCH.branch ON award.branch_id = branch.branch_id " .
            "WHERE award.type_id NOT IN (" . $MONARCH . ") " .
            "ORDER BY branch.display_order, award.closed, precedence.precedence, award.award_id";
      }

      $award_result = mysql_query($award_query) 
         or die("Award query failed : " . mysql_error());
   ?>
   <form action="edit_ind_award.php?mode=<?php echo $mode; ?>" method="post">
   <?php 
      if ($form_atlantian_id > 0) 
      { 
   ?>
      <input type="hidden" name="form_atlantian_id" id="form_atlantian_id" value="<?php echo $form_atlantian_id; ?>"/>
   <?php 
      }
      if ($form_event_id > 0) 
      { 
   ?>
      <input name="form_event_id" id="form_event_id" type="hidden" value="<?php echo $form_event_id; ?>"/>
   <tr>
      <th class="titleright">Event:</th>
      <td class="data"><?php echo $event_display; ?></td>
   </tr>
   <?php 
      }
      if ($form_court_report_id > 0) 
      { 
   ?>
      <input name="form_court_report_id" id="form_court_report_id" type="hidden" value="<?php echo $form_court_report_id; ?>"/>
   <tr>
      <th class="titleright">Court:</th>
      <td class="data"><?php echo $court_display; ?></td>
   </tr>
   <?php 
      }
   ?>
   <tr>
      <th class="titleright"><?php echo $KINGDOM_RES; ?>:</th>
      <td class="data"><?php echo $form_scaname; ?></td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_<?php echo $id_field; ?>">Select Award</label>:</th>
      <td class="data">
      <select name="form_<?php echo $id_field; ?>" id="form_<?php echo $id_field; ?>">
   <?php 
      if ($mode == $MODE_ADD)
      {
         $rg_id = -1;
      }
      while ($award_data = mysql_fetch_array($award_result, MYSQL_BOTH)) 
      {
         if ($mode == $MODE_ADD)
         {
            $new_rg_id = $award_data['branch_id'];
            // Display group name if new group
            if ($rg_id != $new_rg_id)
            {
               if ($rg_id == -1)
               {
                  echo '<option value="">----- SCA -----</option>';
               }
               else
               {
                  echo '<option value="">----- ' . strtoupper($award_data['branch']) . ' -----</option>';
               }
               $rg_id = $new_rg_id;
            }
         }
         $display_string = get_award_display_string($award_data, $mode);
         echo '<option value="' . $award_data[$id_field] . '">' . $display_string . '</option>';
      }
   ?>
      </select>
      </td>
   </tr>
   <tr>
      <td class="title" colspan="2"><input name="submit" id="submit" type="submit" value="<?php echo $SUBMIT_SELECT; ?>"/></td>
   </tr>
   </form>
   <?php 
   }
   /*  PAGE 2 - Add/Edit Atlantian Award */ 
   else if ($form_atlantian_id > 0 && ($form_award_id > 0 || $form_atlantian_award_id > 0) && (($submit != $SUBMIT_SAVE && $submit != $SUBMIT_DELETE) || $errmsg != ""))
   {
   ?>
   <form action="edit_ind_award.php?mode=<?php echo $mode; ?>" method="post">
      <input name="form_select_branch" id="form_select_branch" type="hidden" value="<?php echo $form_select_branch; ?>"/>
   <?php 
      if ($form_atlantian_id > 0) 
      { 
   ?>
      <input name="form_atlantian_id" id="form_atlantian_id" type="hidden" value="<?php echo $form_atlantian_id; ?>"/>
   <?php 
      }
      if ($form_award_id > 0) 
      { 
   ?>
      <input name="form_award_id" id="form_award_id" type="hidden" value="<?php echo $form_award_id; ?>"/>
   <?php 
      }
      if ($form_atlantian_award_id > 0) 
      { 
   ?>
      <input name="form_atlantian_award_id" id="form_atlantian_award_id" type="hidden" value="<?php echo $form_atlantian_award_id; ?>"/>
   <?php 
      }
      if ($form_event_id > 0) 
      { 
   ?>
      <input name="form_event_id" id="form_event_id" type="hidden" value="<?php echo $form_event_id; ?>"/>
   <tr>
      <th class="titleright">Event:</th>
      <td class="data"><?php echo $event_display; ?></td>
   </tr>
   <?php 
      }
      else if (isset($e2_result) && mysql_num_rows($e2_result) > 0)
      {
   ?>
   <tr>
      <th class="titleright">Event:</th>
      <td class="data">
      <select name="form_event_id" id="form_event_id"/>
         <option value=""></option>
      <?php 
         while ($e2_data = mysql_fetch_array($e2_result, MYSQL_BOTH))
         {
            $pl_event_display = $e2_data['event_name'] . " (" . $e2_data['branch'] . ") ";
            if ($e2_data['start_date'] == $e2_data['end_date'] && $e2_data['start_date'] != '')
            {
               $pl_event_display .= format_short_date($e2_data['start_date']);
            }
            else if ($e2_data['start_date'] != $e2_data['end_date'] && $e2_data['start_date'] != '' && $e2_data['end_date'] != '')
            {
               $pl_event_display .= format_short_date($e2_data['start_date']) . " - " . format_short_date($e2_data['end_date']);
            }
            echo '<option value="' . $e2_data['event_id'] . '"'; 
            if (isset($form_event_id) && ($form_event_id == $e2_data['event_id']))
            {
               echo ' selected="selected"';
            }
            echo '>' . $pl_event_display . '</option>';
         }

         /* Free resultset */
         mysql_free_result($e2_result);
      ?>
      </select>
      </td>
   </tr>
   <?php 
      }
      if ($form_court_report_id > 0) 
      { 
   ?>
      <input name="form_court_report_id" id="form_court_report_id" type="hidden" value="<?php echo $form_court_report_id; ?>"/>
   <tr>
      <th class="titleright">Court:</th>
      <td class="data"><?php echo $court_display; ?></td>
   </tr>
   <?php 
      }
      else if (isset($c2_result) && mysql_num_rows($c2_result) > 0)
      {
   ?>
   <tr>
      <th class="titleright">Court:</th>
      <td class="data">
      <select name="form_court_report_id" id="form_court_report_id"/>
         <option value=""></option>
      <?php 
         while ($c2_data = mysql_fetch_array($c2_result, MYSQL_BOTH))
         {
            $court_type = $c2_data['court_type'];
            $names = "";
            $group = "";
            if ($court_type == $COURT_TYPE_ROYAL)
            {
               $monarchs = clean($c2_data['monarchs_display']);
               $principality = clean($c2_data['principality_display']);
               if ($monarchs != "")
               {
                  $names = $monarchs;
               }
               else if ($principality != "")
               {
                  $names = $principality;
               }
               $group = clean($c2_data['kingdom']);
            }
            if ($court_type == $COURT_TYPE_BARONIAL)
            {
               $names = clean($c2_data['baronage_display']);
               $group = clean($c2_data['barony']);
            }
            if ($names != "")
            {
               $names = " - $names";
            }
            if ($group != "")
            {
               $group = " ($group)";
            }
            $pl_court_display = translate_court_type($court_type) . $group . $names . " - " . translate_court_time($c2_data['court_time']);
            echo '<option value="' . $c2_data['court_report_id'] . '"'; 
            if (isset($form_court_report_id) && ($form_court_report_id == $c2_data['court_report_id']))
            {
               echo ' selected="selected"';
            }
            echo '>' . $pl_court_display . '</option>';
         }

         /* Free resultset */
         mysql_free_result($c2_result);
      ?>
      </select>
      </td>
   </tr>
   <?php 
      }
   ?>
   <tr>
      <th class="titleright"><?php echo $KINGDOM_RES; ?>:</th>
      <td class="data"><?php echo $form_scaname; ?></td>
   </tr>
   <tr>
      <th class="titleright">Award:</th>
      <td class="data"><?php echo $form_award_name; ?></td>
   </tr>
      <?php
      if ($form_select_branch == 0)
      {
      ?>
   <tr>
      <th class="titleright">Branch:</th>
      <td class="data"><?php if (trim($form_branch) != '') { echo $form_branch; } else { echo 'Not Applicable'; } ?></td>
   </tr>
      <?php
      }
      else
      {
         /* Get pick list - Kingdoms or Baronies only */
         $branch_type = $BT_KINGDOM;
         $branch_type_name = "Kingdom";
         if ($form_award_id == $VISCOUNTY_ID)
         {
            $branch_type .= "," . $BT_PRINCIPALITY;
            $branch_type_name = "Principality";
         }
         else if ($form_award_id == $LANDED_BARONAGE_ID || $form_award_id == $RETIRED_BARONAGE_ID || $form_award_id == $RETIRED_BARONAGE_NA_ID)
         {
            $branch_type = $BT_BARONY;
            $branch_type_name = "Barony";
         }
      ?>
   <tr>
      <th class="titleright"><label for="form_branch_id"><?php echo $branch_type_name; ?></label>:</th>
      <td class="data">
      <select name="form_branch_id" id="form_branch_id">
         <option value="">Unknown</option>
         <option value="<?php echo $ATLANTIA; ?>"<?php if (isset($form_branch_id) && ($form_branch_id == $ATLANTIA)) { echo ' selected="selected"'; } ?>><?php echo $ATLANTIA_NAME; ?> (Kingdom)</option>
      <?php 
         $pl_query = "SELECT branch_id, branch, incipient, branch.branch_type_id, branch_type " .
                     "FROM $DBNAME_BRANCH.branch, $DBNAME_BRANCH.branch_type " .
                     "WHERE branch.branch_type_id = branch_type.branch_type_id " .
                     "AND branch.branch_type_id IN (" . $branch_type . ") " .
                     "AND branch_id <> $ATLANTIA " .
                     "ORDER BY branch.branch_type_id, branch.branch";

         $pl_result = mysql_query($pl_query)
            or die("Pick List Query failed: " . mysql_error());

         while ($pl_data = mysql_fetch_array($pl_result, MYSQL_BOTH))
         {
            $branch_display = $pl_data['branch'] . " (";
            if ($pl_data['incipient'] == 1)
            {
               $branch_display .= "Incipient ";
            }
            $branch_display .= $pl_data['branch_type'] . ")";
            if ($pl_data['branch_type_id'] != $BT_KINGDOM)
            {
               $branch_display .= ", " . get_kingdom($pl_data['branch_id']);
            }
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
      <?php
      }
      ?>
   <tr>
      <th class="titleright"><label for="form_award_date">Award Date</label>:</th>
      <td class="data"><input name="form_award_date" id="form_award_date" type="text" size="10"<?php if (isset($form_award_date)) { echo ' value="' . $form_award_date . '"'; }?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_sequence">Sequence</label>:</th>
      <td class="data"><input name="form_sequence" id="form_sequence" type="text" size="10"<?php if (isset($form_sequence)) { echo ' value="' . $form_sequence . '"'; }?>/></td>
   </tr>
      <?php
      $premier_field_name = "Premier";
      if ($form_award_id == $LANDED_BARONAGE_ID || $form_award_id == $RETIRED_BARONAGE_ID || $form_award_id == $RETIRED_BARONAGE_NA_ID)
      {
         $premier_field_name = "Founding";
      }
      ?>
   <tr>
      <th class="titleright"><label for="form_premier"><?php echo $premier_field_name; ?></label>:</th>
      <td class="data"><input name="form_premier" id="form_premier" type="checkbox" value="1"<?php if (isset($form_premier) && $form_premier == 1) { echo ' checked="checked"'; }?>/></td>
   </tr>
      <?php
      if (false)//$form_award_group_id == $YEW_BOW_GROUP || $form_award_id == $SUPPORTERS_ID || $form_award_id == $AUG || $form_award_id == $MARINUS_STEWARDS)
      {
      ?>
   <tr>
      <th class="titleright"><label for="form_comments">Comments</label>:</th>
      <td class="data"><input name="form_comments" id="form_comments" type="text" size="30"<?php if (isset($form_comments)) { echo ' value="' . $form_comments . '"'; }?>/></td>
   </tr>
      <?php
      }
      if (false)//$form_award_id == $ST_AIDAN || $form_award_id == $RETIRED_BARONAGE_ID || $form_award_id == $LANDED_BARONAGE_ID || $form_award_id == $RETIRED_BARONAGE_NA_ID)
      {
      ?>
   <tr>
      <th class="titleright"><label for="form_retired_date">Retired Date</label>:</th>
      <td class="data"><input name="form_retired_date" id="form_retired_date" type="text" size="10"<?php if (isset($form_retired_date)) { echo ' value="' . $form_retired_date . '"'; }?>/></td>
   </tr>
      <?php
      }
      ?>
   <tr>
      <th class="titleright"><label for="form_resigned_date">Resigned Date</label>:</th>
      <td class="data"><input name="form_resigned_date" id="form_resigned_date" type="text" size="10"<?php if (isset($form_resigned_date)) { echo ' value="' . $form_resigned_date . '"'; }?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_revoked_date">Revoked Date</label>:</th>
      <td class="data"><input name="form_revoked_date" id="form_revoked_date" type="text" size="10"<?php if (isset($form_revoked_date)) { echo ' value="' . $form_revoked_date . '"'; }?>/></td>
   </tr>
      <?php
      if ($form_award_id == $RETIRED_BARONAGE_ID || $form_award_id == $LANDED_BARONAGE_ID || $form_award_id == $RETIRED_BARONAGE_NA_ID)
      {
      ?>
   <tr>
      <th class="titleright"><label for="form_gender">Gender</label></th>
      <td class="data"><input name="form_gender" id="form_genderM" type="radio" value="<?php echo $MALE; ?>"<?php if (isset($form_gender) && $form_gender == $MALE) { echo ' CHECKED'; }?>/>Male 
      &nbsp;&nbsp;<input name="form_gender" id="form_genderF" type="radio" value="<?php echo $FEMALE; ?>"<?php if (isset($form_gender) && $form_gender == $FEMALE) { echo ' CHECKED'; }?>/>Female
      &nbsp;&nbsp;<input name="form_gender" id="form_genderU" type="radio" value="<?php echo $UNKNOWN; ?>"<?php if (isset($form_gender) && $form_gender == $UNKNOWN) { echo ' CHECKED'; }?>/>Unknown
      &nbsp;&nbsp;<input name="form_gender" id="form_genderN" type="radio" value="<?php echo $NONE; ?>"<?php if (isset($form_gender) && $form_gender == $NONE) { echo ' CHECKED'; }?>/>None
      </td>
   </tr>
      <?php
      }
      ?>
   <tr>
      <th class="titleright"><label for="form_private">Private</label>:</th>
      <td class="data"><input name="form_private" id="form_private" type="checkbox" value="1"<?php if (isset($form_private) && $form_private == 1) { echo ' checked="checked"'; }?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_scroll_status_id">Scroll Status</label>:</th>
      <td class="data">
      <select name="form_scroll_status_id" id="form_scroll_status_id">
         <option value="">Unknown</option>
      <?php 
         $pl_query = "SELECT scroll_status_id, scroll_status, scroll_status_code " .
                     "FROM $DBNAME_OP.scroll_status " .
                     "ORDER BY scroll_status_id";

         $pl_result = mysql_query($pl_query)
            or die("Pick List Query failed: " . mysql_error());

         while ($pl_data = mysql_fetch_array($pl_result, MYSQL_BOTH))
         {
            $pl_display = $pl_data['scroll_status'] . " (" . $pl_data['scroll_status_code'] . ")";
            echo '<option value="' . $pl_data['scroll_status_id'] . '"'; 
            if (isset($form_scroll_status_id) && ($form_scroll_status_id == $pl_data['scroll_status_id']))
            {
               echo ' selected="selected"';
            }
            echo '>' . $pl_display . '</option>';
         }

         /* Free resultset */
         mysql_free_result($pl_result);
      ?>
      </select>
      </td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_scroll_assignees">Scribe(s)</label>:</th>
      <td class="data"><input name="form_scroll_assignees" id="form_scroll_assignees" type="text" size="30"<?php if (isset($form_scroll_assignees)) { echo ' value="' . $form_scroll_assignees . '"'; }?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_scroll_assigned_date">Scroll Assigned Date</label>:</th>
      <td class="data"><input name="form_scroll_assigned_date" id="form_scroll_assigned_date" type="text" size="10"<?php if (isset($form_scroll_assigned_date)) { echo ' value="' . $form_scroll_assigned_date . '"'; }?>/></td>
   </tr>
   <tr>
      <td class="title" colspan="2"><input name="submit" id="submit" type="submit" value="<?php echo $SUBMIT_SAVE; ?>"/>&nbsp;&nbsp;&nbsp;<?php if ($mode == $MODE_EDIT) {?><input name="submit" id="submit" type="submit" value="<?php echo $SUBMIT_DELETE; ?>"/><?php } ?>&nbsp;&nbsp;&nbsp;<input type="reset" value="Reset Form"/></td>
   </tr>
   </form>
<?php 
   }
   // PAGE 3 - Display Results
   else if (($submit == $SUBMIT_SAVE || $submit == $SUBMIT_DELETE) && $errmsg == "")
   {
      if ($form_event_id > 0) 
      { 
   ?>
   <tr>
      <th class="titleright">Event:</th>
      <td class="data"><?php echo $event_display; ?></td>
   </tr>
   <?php 
      }
      if ($form_court_report_id > 0) 
      { 
   ?>
   <tr>
      <th class="titleright">Court:</th>
      <td class="data"><?php echo $court_display; ?></td>
   </tr>
   <?php 
      }
?>
   <tr>
      <th class="titleright" valign="top"><?php echo $KINGDOM_RES; ?>:</th>
      <td class="data"><?php echo $form_scaname; ?></td>
   </tr>
   <tr>
      <th class="titleright" valign="top">Award Name:</th>
      <td class="data"><?php echo $form_award_name; ?>
      <?php
      if (isset($augmentation_id))
      {
         echo '<BR>Augmentation of Arms';
      }
      else if (isset($arms_id))
      {
         if ($add_arms == $POA)
         {
            echo '<BR>Patent of Arms';
         }
         else if ($add_arms == $GOA)
         {
            echo '<BR>Grant of Arms';
         }
         else if ($add_arms == $AOA)
         {
            echo '<BR>Award of Arms';
         }
      }
      ?>
      </td>
   </tr>
   <tr>
      <th class="titleright" valign="top">Branch:</th>
      <td class="data"><?php if (isset($form_branch) && $form_branch != '') { echo $form_branch; } else if ($form_select_branch == 1) { echo "<i>Unknown</i>"; } else { echo 'Not Applicable'; } ?></td>
   </tr>
<?php
      if ($submit == $SUBMIT_DELETE)
      {
?>
   <tr>
      <th colspan="2" class="title" valign="top">DELETED</th>
   </tr>
<?php
      }
      else
      {
?>
   <tr>
      <th class="titleright" valign="top">Award Date:</th>
      <td class="data"><?php echo $form_award_date; ?></td>
   </tr>
   <tr>
      <th class="titleright" valign="top">Sequence:</th>
      <td class="data"><?php echo $form_sequence; ?></td>
   </tr>
<?php
         $premier_field_name = "Premier";
         if ($form_award_id == $LANDED_BARONAGE_ID || $form_award_id == $RETIRED_BARONAGE_ID || $form_award_id == $RETIRED_BARONAGE_NA_ID)
         {
            $premier_field_name = "Founding";
         }
         $premier_display = "No";
         if ($form_premier == 1)
         {
            $premier_display = "Yes";
         }
?>
   <tr>
      <th class="titleright" valign="top"><?php echo $premier_field_name; ?>:</th>
      <td class="data"><?php echo $premier_display; ?></td>
   </tr>
<?php
         if ($form_comments != "")
         {
?>
   <tr>
      <th class="titleright" valign="top">Comments:</th>
      <td class="data"><?php echo $form_comments; ?></td>
   </tr>
<?php
         }
         if ($form_retired_date != "")
         {
?>
   <tr>
      <th class="titleright" valign="top">Retired Date:</th>
      <td class="data"><?php echo $form_retired_date; ?></td>
   </tr>
<?php
         }
         if ($form_resigned_date != "")
         {
?>
   <tr>
      <th class="titleright" valign="top">Resigned Date:</th>
      <td class="data"><?php echo $form_resigned_date; ?></td>
   </tr>
<?php
         }
         if ($form_revoked_date != "")
         {
?>
   <tr>
      <th class="titleright" valign="top">Revoked Date:</th>
      <td class="data"><?php echo $form_revoked_date; ?></td>
   </tr>
<?php
         }
         if ($form_award_id == $LANDED_BARONAGE_ID || $form_award_id == $RETIRED_BARONAGE_ID || $form_award_id == $RETIRED_BARONAGE_NA_ID)
         {
?>
   <tr>
      <th class="titleright" valign="top">Gender:</th>
      <td class="data"><?php echo $form_gender; ?></td>
   </tr>
<?php
         }
         if ($form_scroll_status != "")
         {
?>
   <tr>
      <th class="titleright" valign="top">Scroll Status:</th>
      <td class="data"><?php echo $form_scroll_status; ?></td>
   </tr>
<?php
         }
         if ($form_scroll_assignees != "")
         {
?>
   <tr>
      <th class="titleright" valign="top">Scribe(s):</th>
      <td class="data"><?php echo $form_scroll_assignees; ?></td>
   </tr>
<?php
         }
         if ($form_scroll_assigned_date != "")
         {
?>
   <tr>
      <th class="titleright" valign="top">Scroll Assigned Date:</th>
      <td class="data"><?php echo $form_scroll_assigned_date; ?></td>
   </tr>
<?php
         }
         $private_display = "No";
         if ($form_private == 1)
         {
            $private_display = "Yes";
         }
?>
   <tr>
      <th class="titleright" valign="top">Private:</th>
      <td class="data"><?php echo $private_display; ?></td>
   </tr>
<?php
      }
?>
   <tr>
      <td class="title" colspan="2">
      <table border="0" align="center" cellpadding="5" summary="layout">
         <tr>
            <td align="right">
            <form action="edit_ind_award.php" method="post">
               <input type="hidden" name="form_atlantian_id" id="form_atlantian_id" value="<?php echo $form_atlantian_id; ?>"/>
               <input type="hidden" name="mode" id="mode" value="<?php echo $MODE_ADD; ?>"/>
               <input type="submit" value="Add Award for <?php echo $form_scaname; ?>"/>
            </form>
            </td>
            <td align="left">
            <form action="edit_ind_award.php" method="post">
               <input type="hidden" name="form_atlantian_id" id="form_atlantian_id" value="<?php echo $form_atlantian_id; ?>"/>
               <input type="hidden" name="mode" id="mode" value="<?php echo $MODE_EDIT; ?>"/>
               <input type="submit" value="Edit Awards for <?php echo $form_scaname; ?>"/>
            </form>
            </td>
         </tr>
         <tr>
            <td colspan="2" align="center">
            <form action="edit_ind.php" method="post">
               <input type="hidden" name="form_atlantian_id" id="form_atlantian_id" value="<?php echo $form_atlantian_id; ?>"/>
               <input type="hidden" name="mode" id="mode" value="<?php echo $MODE_EDIT; ?>"/>
               <input type="submit" value="Edit Person <?php echo $form_scaname; ?>"/>
            </form>
            </td>
         </tr>
         <?php if ($form_court_report_id > 0) { ?>
         <tr>
            <td align="right">
            <form action="court_report.php" method="post">
               <input type="hidden" name="form_court_report_id" id="form_court_report_id" value="<?php echo $form_court_report_id; ?>"/>
               <input type="hidden" name="mode" id="mode" value="<?php echo $MODE_EDIT; ?>"/>
               <input type="submit" value="Edit Court Report"/>
            </form>
            </td>
            <td align="left">
            <form action="select_ind.php" method="post">
               <input type="hidden" name="form_event_id" id="form_event_id" value="<?php echo $form_event_id; ?>"/>
               <input type="hidden" name="form_court_report_id" id="form_court_report_id" value="<?php echo $form_court_report_id; ?>"/>
               <input type="hidden" name="type" id="type" value="<?php echo $TYPE_AWARD; ?>"/>
               <input type="hidden" name="mode" id="mode" value="<?php echo $MODE_ADD; ?>"/>
               <input type="submit" value="Add Award for Court Report"/>
            </form>
            </td>
         </tr>
         <?php } ?>
      </table>
      </td>
   </tr>
<?php
   }
   if (isset($idresult))
   {
      /* Free resultset */
      mysql_free_result($idresult);
   }
   /* Closing connection */
   db_disconnect($link);
?>
</table>
<?php
}
else
{
include("header.php");
?>
   <p class="title2">Add/Edit <?php echo $KINGDOM_ADJ; ?> Award</p>
   <P>You are not authorized to access this page.</p>
<?php
}
?>
<?php include('footer.php'); ?>
