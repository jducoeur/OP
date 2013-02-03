<?php
include_once("db.php");
include_once("../db/db.php");
include_once("../db/session.php");

if (isset($_SESSION[$UNIVERSITY_ADMIN]) && $_SESSION[$UNIVERSITY_ADMIN])
{
   $first_participant_id = 0;
   if (isset($_REQUEST['first_participant_id']))
   {
      $first_participant_id = clean($_REQUEST['first_participant_id']);
   }

   $second_participant_id = 0;
   if (isset($_REQUEST['second_participant_id']))
   {
      $second_participant_id = clean($_REQUEST['second_participant_id']);
   }

   $first_atlantian_id = 0;
   if (isset($_REQUEST['first_atlantian_id']))
   {
      $first_atlantian_id = clean($_REQUEST['first_atlantian_id']);
   }

   $second_atlantian_id = 0;
   if (isset($_REQUEST['second_atlantian_id']))
   {
      $second_atlantian_id = clean($_REQUEST['second_atlantian_id']);
   }

   $first_user_id = 0;
   if (isset($_REQUEST['first_user_id']))
   {
      $first_user_id = clean($_REQUEST['first_user_id']);
   }

   $second_user_id = 0;
   if (isset($_REQUEST['second_user_id']))
   {
      $second_user_id = clean($_REQUEST['second_user_id']);
   }

   $atlantian_selection = 1;
   $participant_selection = 1;
   $user_selection = 1;
   $edit_selection = 1;

   $atlantian_id = 0;
   if (isset($_REQUEST['atlantian_id']))
   {
      $atlantian_id = clean($_REQUEST['atlantian_id']);
   }

   $participant_id = 0;
   if (isset($_REQUEST['participant_id']))
   {
      $participant_id = clean($_REQUEST['participant_id']);
   }

   $user_id = 0;
   if (isset($_REQUEST['user_id']))
   {
      $user_id = clean($_REQUEST['user_id']);
   }

   $link = db_connect();

   if ($first_atlantian_id == 0 || $first_user_id == 0)
   {
      $query = "SELECT atlantian_id, user_id FROM $DBNAME_UNIVERSITY.participant WHERE participant_id = " . value_or_null($first_participant_id);
      $result = mysql_query($query)
         or die("Error selecting first Atlantian: " . mysql_error());
      $data = mysql_fetch_array($result, MYSQL_BOTH);
      if ($data['atlantian_id'] != NULL)
      {
         $first_atlantian_id = clean($data['atlantian_id']);
      }
      if ($data['user_id'] != NULL)
      {
         $first_user_id = clean($data['user_id']);
      }
   }

   if ($second_atlantian_id == 0 || $second_user_id == 0)
   {
      $query = "SELECT atlantian_id, user_id FROM $DBNAME_UNIVERSITY.participant WHERE participant_id = " . value_or_null($second_participant_id);
      $result = mysql_query($query)
         or die("Error selecting second Atlantian: " . mysql_error());
      $data = mysql_fetch_array($result, MYSQL_BOTH);
      if ($data['atlantian_id'] != NULL)
      {
         $second_atlantian_id = clean($data['atlantian_id']);
      }
      if ($data['user_id'] != NULL)
      {
         $second_user_id = clean($data['user_id']);
      }
   }

   db_disconnect($link);

   if ($first_participant_id == 0 || $second_participant_id == 0)
   {
      $participant_selection = 0;
   }

   if ($first_atlantian_id == 0 || $second_atlantian_id == 0)
   {
      $atlantian_selection = 0;
   }

   if ($first_user_id == 0 || $second_user_id == 0)
   {
      $user_selection = 0;
   }

   $edit_selection = $participant_selection || $atlantian_selection || $user_selection;

   $no_atlantian = !($first_atlantian_id || $second_atlantian_id);
   $no_participant = !($first_participant_id || $second_participant_id);
   $no_user = !($first_user_id || $second_user_id);

   //echo "DEBUG: p1: [$first_participant_id] p2: [$second_participant_id] a1: [$first_atlantian_id] a2: [$second_atlantian_id] u1: [$first_user_id] u2: [$second_user_id]<br/>";
   //echo "DEBUG: p: [$participant_selection] a: [$atlantian_selection] u: [$user_selection] e: [$edit_selection]<br/>";
   $SUBMIT_MERGE = "Merge Participant";

   // Data submitted
   if (isset($_POST['submit']) && $_POST['submit'] == $SUBMIT_MERGE)
   {
      // Validation
      $errmsg = '';

      //-------------------------------
      // Verify all fields are selected
      //-------------------------------
      // Atlantian section
      if ($atlantian_selection)
      {
         // Contact Information
         if (!isset($_POST['select_first_name']))
         {
            $errmsg .= "Please select a first name.<br/>";
         }
         else
         {
            $select_first_name = clean($_POST['select_first_name']);
         }

         if (!isset($_POST['select_middle_name']))
         {
            $errmsg .= "Please select a middle name.<br/>";
         }
         else
         {
            $select_middle_name = clean($_POST['select_middle_name']);
         }

         if (!isset($_POST['select_last_name']))
         {
            $errmsg .= "Please select a last name.<br/>";
         }
         else
         {
            $select_last_name = clean($_POST['select_last_name']);
         }

         if (!isset($_POST['select_gender']))
         {
            $errmsg .= "Please select a gender.<br/>";
         }
         else
         {
            $select_gender = clean($_POST['select_gender']);
         }

         if (!isset($_POST['select_deceased']))
         {
            $errmsg .= "Please select deceased information.<br/>";
         }
         else
         {
            $select_deceased = clean($_POST['select_deceased']);
         }

         if (!isset($_POST['select_email']))
         {
            $errmsg .= "Please select an email address.<br/>";
         }
         else
         {
            $select_email = clean($_POST['select_email']);
         }

         if (!isset($_POST['select_alternate_email']))
         {
            $errmsg .= "Please select an alternate email address.<br/>";
         }
         else
         {
            $select_alternate_email = clean($_POST['select_alternate_email']);
         }

         if (!isset($_POST['select_address1']))
         {
            $errmsg .= "Please select a first address line.<br/>";
         }
         else
         {
            $select_address1 = clean($_POST['select_address1']);
         }

         if (!isset($_POST['select_address2']))
         {
            $errmsg .= "Please select a second address line.<br/>";
         }
         else
         {
            $select_address2 = clean($_POST['select_address2']);
         }

         if (!isset($_POST['select_city']))
         {
            $errmsg .= "Please select a city.<br/>";
         }
         else
         {
            $select_city = clean($_POST['select_city']);
         }

         if (!isset($_POST['select_state']))
         {
            $errmsg .= "Please select a state.<br/>";
         }
         else
         {
            $select_state = clean($_POST['select_state']);
         }

         if (!isset($_POST['select_zip']))
         {
            $errmsg .= "Please select a zip.<br/>";
         }
         else
         {
            $select_zip = clean($_POST['select_zip']);
         }

         if (!isset($_POST['select_country']))
         {
            $errmsg .= "Please select a country.<br/>";
         }
         else
         {
            $select_country = clean($_POST['select_country']);
         }

         if (!isset($_POST['select_phone_home']))
         {
            $errmsg .= "Please select a home phone number.<br/>";
         }
         else
         {
            $select_phone_home = clean($_POST['select_phone_home']);
         }

         if (!isset($_POST['select_phone_work']))
         {
            $errmsg .= "Please select a work phone number.<br/>";
         }
         else
         {
            $select_phone_work = clean($_POST['select_phone_work']);
         }

         if (!isset($_POST['select_phone_mobile']))
         {
            $errmsg .= "Please select a mobile phone number.<br/>";
         }
         else
         {
            $select_phone_mobile = clean($_POST['select_phone_mobile']);
         }

         if (!isset($_POST['select_call_times']))
         {
            $errmsg .= "Please select call times.<br/>";
         }
         else
         {
            $select_call_times = clean($_POST['select_call_times']);
         }

         if (!isset($_POST['select_publish_name']))
         {
            $errmsg .= "Please select a name publication permission.<br/>";
         }
         else
         {
            $select_publish_name = clean($_POST['select_publish_name']);
         }

         if (!isset($_POST['select_publish_address']))
         {
            $errmsg .= "Please select an address publication permission.<br/>";
         }
         else
         {
            $select_publish_address = clean($_POST['select_publish_address']);
         }

         if (!isset($_POST['select_publish_email']))
         {
            $errmsg .= "Please select an email publication permission.<br/>";
         }
         else
         {
            $select_publish_email = clean($_POST['select_publish_email']);
         }

         if (!isset($_POST['select_publish_alternate_email']))
         {
            $errmsg .= "Please select an alternate email publication permission.<br/>";
         }
         else
         {
            $select_publish_alternate_email = clean($_POST['select_publish_alternate_email']);
         }

         if (!isset($_POST['select_publish_phone_home']))
         {
            $errmsg .= "Please select a home phone publication permission.<br/>";
         }
         else
         {
            $select_publish_phone_home = clean($_POST['select_publish_phone_home']);
         }

         if (!isset($_POST['select_publish_phone_work']))
         {
            $errmsg .= "Please select a work phone publication permission.<br/>";
         }
         else
         {
            $select_publish_phone_work = clean($_POST['select_publish_phone_work']);
         }

         if (!isset($_POST['select_publish_phone_mobile']))
         {
            $errmsg .= "Please select a mobile phone publication permission.<br/>";
         }
         else
         {
            $select_publish_phone_mobile = clean($_POST['select_publish_phone_mobile']);
         }

         // SCA Information
         //-------------------------------
         if (!isset($_POST['select_sca_name']))
         {
            $errmsg .= "Please select an SCA name.<br/>";
         }
         else
         {
            $select_sca_name = clean($_POST['select_sca_name']);
         }

         if (!isset($_POST['select_preferred_sca_name']))
         {
            $errmsg .= "Please select a preferred SCA name.<br/>";
         }
         else
         {
            $select_preferred_sca_name = clean($_POST['select_preferred_sca_name']);
         }

         if (!isset($_POST['select_branch_id']))
         {
            $errmsg .= "Please select a home branch.<br/>";
         }
         else
         {
            $select_branch_id = clean($_POST['select_branch_id']);
         }

         if (!isset($_POST['select_name_reg_date']))
         {
            $errmsg .= "Please select a name registration date.<br/>";
         }
         else
         {
            $select_name_reg_date = clean($_POST['select_name_reg_date']);
         }

         if (!isset($_POST['select_device_reg_date']))
         {
            $errmsg .= "Please select a device registration date.<br/>";
         }
         else
         {
            $select_device_reg_date = clean($_POST['select_device_reg_date']);
         }

         if (!isset($_POST['select_blazon']))
         {
            $errmsg .= "Please select a blazon.<br/>";
         }
         else
         {
            $select_blazon = clean($_POST['select_blazon']);
         }

         if (!isset($_POST['select_alternate_names']))
         {
            $errmsg .= "Please select alternate names.<br/>";
         }
         else
         {
            $select_alternate_names = clean($_POST['select_alternate_names']);
         }

         if (!isset($_POST['select_heraldic_rank_id']))
         {
            $errmsg .= "Please select an heraldic rank.<br/>";
         }
         else
         {
            $select_heraldic_rank_id = clean($_POST['select_heraldic_rank_id']);
         }

         if (!isset($_POST['select_heraldic_title']))
         {
            $errmsg .= "Please select an heraldic title.<br/>";
         }
         else
         {
            $select_heraldic_title = clean($_POST['select_heraldic_title']);
         }

         if (!isset($_POST['select_heraldic_interests']))
         {
            $errmsg .= "Please select heraldic interests.<br/>";
         }
         else
         {
            $select_heraldic_interests = clean($_POST['select_heraldic_interests']);
         }

         if (!isset($_POST['select_website']))
         {
            $errmsg .= "Please select a website.<br/>";
         }
         else
         {
            $select_website = clean($_POST['select_website']);
         }

         if (!isset($_POST['select_biography']))
         {
            $errmsg .= "Please select a biography.<br/>";
         }
         else
         {
            $select_biography = clean($_POST['select_biography']);
         }

         if (!isset($_POST['select_membership_number']))
         {
            $errmsg .= "Please select a membership_number.<br/>";
         }
         else
         {
            $select_membership_number = clean($_POST['select_membership_number']);
         }

         if (!isset($_POST['select_expiration_date']))
         {
            $errmsg .= "Please select an expiration date.<br/>";
         }
         else
         {
            $select_expiration_date = clean($_POST['select_expiration_date']);
         }

         if (!isset($_POST['select_expiration_date_pending']))
         {
            $errmsg .= "Please select a pending expiration date.<br/>";
         }
         else
         {
            $select_expiration_date_pending = clean($_POST['select_expiration_date_pending']);
         }

         if (!isset($_POST['select_inactive']))
         {
            $errmsg .= "Please select inactive information.<br/>";
         }
         else
         {
            $select_inactive = clean($_POST['select_inactive']);
         }

         if (!isset($_POST['select_revoked']))
         {
            $errmsg .= "Please select revoked and denied information.<br/>";
         }
         else
         {
            $select_revoked = clean($_POST['select_revoked']);
         }

         if (!isset($_POST['select_background_check']))
         {
            $errmsg .= "Please select background check information.<br/>";
         }
         else
         {
            $select_background_check = clean($_POST['select_background_check']);
         }

         // System Information
         //-------------------------------
         if (!isset($_POST['select_device_file_name']))
         {
            $errmsg .= "Please select a device file name.<br/>";
         }
         else
         {
            $select_device_file_name = clean($_POST['select_device_file_name']);
         }

         if (!isset($_POST['select_device_file_credit']))
         {
            $errmsg .= "Please select a device file credit.<br/>";
         }
         else
         {
            $select_device_file_credit = clean($_POST['select_device_file_credit']);
         }

         if (!isset($_POST['select_picture_file_name']))
         {
            $errmsg .= "Please select a picture file name.<br/>";
         }
         else
         {
            $select_picture_file_name = clean($_POST['select_picture_file_name']);
         }

         if (!isset($_POST['select_picture_file_credit']))
         {
            $errmsg .= "Please select a picture file credit.<br/>";
         }
         else
         {
            $select_picture_file_credit = clean($_POST['select_picture_file_credit']);
         }

         if (!isset($_POST['select_op_notes']))
         {
            $errmsg .= "Please select OP notes.<br/>";
         }
         else
         {
            $select_op_notes = clean($_POST['select_op_notes']);
         }

         if (!isset($_POST['select_date_created']))
         {
            $errmsg .= "Please select the Atlantian date created.<br/>";
         }
         else
         {
            $select_date_created = clean($_POST['select_date_created']);
         }
      } // Atlantian section

      // Participant section
      if ($participant_selection)
      {
         if (!isset($_POST['select_preferred_sca_name']))
         {
            $errmsg .= "Please select a preferred SCA name.<br/>";
         }
         else
         {
            $select_preferred_sca_name = clean($_POST['select_preferred_sca_name']);
         }

         if (!isset($_POST['select_b_old_university_id']))
         {
            $errmsg .= "Please select the old Bachelors degree information.<br/>";
         }
         else
         {
            $select_b_old_university_id = clean($_POST['select_b_old_university_id']);
         }

         if (!isset($_POST['select_b_university_id']))
         {
            $errmsg .= "Please select the Bachelors degree information.<br/>";
         }
         else
         {
            $select_b_university_id = clean($_POST['select_b_university_id']);
         }

         if (!isset($_POST['select_f_university_id']))
         {
            $errmsg .= "Please select the Fellowship information.<br/>";
         }
         else
         {
            $select_f_university_id = clean($_POST['select_f_university_id']);
         }

         if (!isset($_POST['select_m_university_id']))
         {
            $errmsg .= "Please select the Masters degree information.<br/>";
         }
         else
         {
            $select_m_university_id = clean($_POST['select_m_university_id']);
         }

         if (!isset($_POST['select_d_university_id']))
         {
            $errmsg .= "Please select the Doctorate information.<br/>";
         }
         else
         {
            $select_d_university_id = clean($_POST['select_d_university_id']);
         }

         if (!isset($_POST['select_p_date_created']))
         {
            $errmsg .= "Please select the Participant date created.<br/>";
         }
         else
         {
            $select_p_date_created = clean($_POST['select_p_date_created']);
         }
      } // Participant section

      // User section
      if ($user_selection)
      {
         if (!isset($_POST['select_u_username']))
         {
            $errmsg .= "Please select a username.<br/>";
         }
         else
         {
            $select_u_username = clean($_POST['select_u_username']);
         }

         if (!isset($_POST['select_first_name']))
         {
            $errmsg .= "Please select a first name.<br/>";
         }
         else
         {
            $select_first_name = clean($_POST['select_first_name']);
         }

         if (!isset($_POST['select_last_name']))
         {
            $errmsg .= "Please select a last name.<br/>";
         }
         else
         {
            $select_last_name = clean($_POST['select_last_name']);
         }

         if (!isset($_POST['select_preferred_sca_name']))
         {
            $errmsg .= "Please select a preferred SCA name.<br/>";
         }
         else
         {
            $select_preferred_sca_name = clean($_POST['select_preferred_sca_name']);
         }

         if (!isset($_POST['select_email']))
         {
            $errmsg .= "Please select an email address.<br/>";
         }
         else
         {
            $select_email = clean($_POST['select_email']);
         }

         if (!isset($_POST['select_u_date_created']))
         {
            $errmsg .= "Please select the User Account date created.<br/>";
         }
         else
         {
            $select_u_date_created = clean($_POST['select_u_date_created']);
         }

         if (!isset($_POST['select_u_last_log']))
         {
            $errmsg .= "Please select the User Account last login date.<br/>";
         }
         else
         {
            $select_u_last_log = clean($_POST['select_u_last_log']);
         }
      } // User section

      //-------------------------------
      // If all selected, gather form data based on selections
      //-------------------------------
      if ($errmsg == '')
      {
         // Atlantian section
         if ($atlantian_selection)
         {
            $form_first_name = clean($_POST[$_POST['select_first_name']]);
            $form_middle_name = clean($_POST[$_POST['select_middle_name']]);
            $form_last_name = clean($_POST[$_POST['select_last_name']]);
            $form_email = clean($_POST[$_POST['select_email']]);
            $form_alternate_email = clean($_POST[$_POST['select_alternate_email']]);
            $form_address1 = clean($_POST[$_POST['select_address1']]);
            $form_address2 = clean($_POST[$_POST['select_address2']]);
            $form_city = clean($_POST[$_POST['select_city']]);
            $form_state = clean($_POST[$_POST['select_state']]);
            $form_zip = clean($_POST[$_POST['select_zip']]);
            $form_country = clean($_POST[$_POST['select_country']]);
            $form_phone_home = clean($_POST[$_POST['select_phone_home']]);
            $form_phone_work = clean($_POST[$_POST['select_phone_work']]);
            $form_phone_mobile = clean($_POST[$_POST['select_phone_mobile']]);
            $form_call_times = clean($_POST[$_POST['select_call_times']]);

            $form_publish_name = 0;
            if (isset($_POST[$_POST['select_publish_name']]))
            {
               $form_publish_name = clean($_POST[$_POST['select_publish_name']]);
            }
            $form_publish_email = 0;
            if (isset($_POST[$_POST['select_publish_email']]))
            {
               $form_publish_email = clean($_POST[$_POST['select_publish_email']]);
            }
            $form_publish_alternate_email = 0;
            if (isset($_POST[$_POST['select_publish_alternate_email']]))
            {
               $form_publish_alternate_email = clean($_POST[$_POST['select_publish_alternate_email']]);
            }
            $form_publish_address = 0;
            if (isset($_POST[$_POST['select_publish_address']]))
            {
               $form_publish_address = clean($_POST[$_POST['select_publish_address']]);
            }
            $form_publish_phone_home = 0;
            if (isset($_POST[$_POST['select_publish_phone_home']]))
            {
               $form_publish_phone_home = clean($_POST[$_POST['select_publish_phone_home']]);
            }
            $form_publish_phone_work = 0;
            if (isset($_POST[$_POST['select_publish_phone_work']]))
            {
               $form_publish_phone_work = clean($_POST[$_POST['select_publish_phone_work']]);
            }
            $form_publish_phone_mobile = 0;
            if (isset($_POST[$_POST['select_publish_phone_mobile']]))
            {
               $form_publish_phone_mobile = clean($_POST[$_POST['select_publish_phone_mobile']]);
            }

            $form_gender = $UNKNOWN;
            if (isset($_POST[$_POST['select_gender']]))
            {
               $form_gender = clean($_POST[$_POST['select_gender']]);
            }

            $form_inactive = 0;
            if (isset($_POST[$_POST['select_inactive']]))
            {
               $form_inactive = clean($_POST[$_POST['select_inactive']]);
            }

            $form_deceased = 0;
            $form_deceased_date = "";
            if (isset($_POST[$_POST['select_deceased']]))
            {
               $form_deceased = clean($_POST[$_POST['select_deceased']]);
               if ($form_deceased == 1)
               {
                  $form_inactive = 1;
               }
               if ($_POST['select_deceased'] == "form_deceased")
               {
                  $form_deceased_date = clean($_POST['form_deceased_date']);
               }
               else
               {
                  $form_deceased_date = clean($_POST['form_deceased_date2']);
               }
            }

            $form_revoked = 0;
            $form_revoked_date = "";
            if (isset($_POST[$_POST['select_revoked']]))
            {
               $form_revoked = clean($_POST[$_POST['select_revoked']]);
               if ($_POST['select_revoked'] == "form_revoked")
               {
                  $form_revoked_date = clean($_POST['form_revoked_date']);
               }
               else
               {
                  $form_revoked_date = clean($_POST['form_revoked_date2']);
               }
            }

            $form_sca_name = clean($_POST[$_POST['select_sca_name']]);
            $form_preferred_sca_name = clean($_POST[$_POST['select_preferred_sca_name']]);
            $form_branch_id = clean($_POST[$_POST['select_branch_id']]);
            $form_blazon = clean($_POST[$_POST['select_blazon']]);
            $form_name_reg_date = clean($_POST[$_POST['select_name_reg_date']]);
            $form_device_reg_date = clean($_POST[$_POST['select_device_reg_date']]);
            $form_alternate_names = clean($_POST[$_POST['select_alternate_names']]);
            $form_heraldic_rank_id = clean($_POST[$_POST['select_heraldic_rank_id']]);
            if ($_POST['select_heraldic_rank_id'] == "form_heraldic_rank_id")
            {
               $form_heraldic_rank = clean($_POST['form_heraldic_rank']);
            }
            else
            {
               $form_heraldic_rank = clean($_POST['form_heraldic_rank2']);
            }
            $form_heraldic_title = clean($_POST[$_POST['select_heraldic_title']]);
            $form_heraldic_interests = clean($_POST[$_POST['select_heraldic_interests']]);
            $form_website = clean($_POST[$_POST['select_website']]);
            $form_biography = clean($_POST[$_POST['select_biography']]);
            $form_membership_number = clean($_POST[$_POST['select_membership_number']]);
            $form_expiration_date = clean($_POST[$_POST['select_expiration_date']]);
            $form_expiration_date_pending = clean($_POST[$_POST['select_expiration_date_pending']]);

            $form_background_check_result = NULL;
            $form_background_check_date = "";
            if (isset($_POST[$_POST['select_background_check']]))
            {
               $form_background_check_result = clean($_POST[$_POST['select_background_check']]);
               if ($_POST['select_background_check'] == "form_background_check_result")
               {
                  $form_background_check_date = clean($_POST['form_background_check_date']);
               }
               else
               {
                  $form_background_check_date = clean($_POST['form_background_check_date2']);
               }
            }

            $form_device_file_name = clean($_POST[$_POST['select_device_file_name']]);
            $form_device_file_credit = clean($_POST[$_POST['select_device_file_credit']]);
            $form_picture_file_name = clean($_POST[$_POST['select_picture_file_name']]);
            $form_picture_file_credit = clean($_POST[$_POST['select_picture_file_credit']]);
            $form_op_notes = clean($_POST[$_POST['select_op_notes']]);
            $form_date_created = clean($_POST[$_POST['select_date_created']]);
         } // Atlantian selection

         // Participant section
         if ($participant_selection)
         {
            $form_preferred_sca_name = clean($_POST[$_POST['select_preferred_sca_name']]);
            $form_p_date_created = clean($_POST[$_POST['select_p_date_created']]);
            if (isset($_POST[$_POST['select_b_old_university_id']]))
            {
               $form_b_old_university_id = clean($_POST[$_POST['select_b_old_university_id']]);
               if ($_POST['select_b_old_university_id'] == "form_b_old_university_id")
               {
                  $form_b_old_degree_status_id = clean($_POST['form_b_old_degree_status_id']);
               }
               else
               {
                  $form_b_old_degree_status_id = clean($_POST['form_b_old_degree_status_id2']);
               }
            }
            if (isset($_POST[$_POST['select_b_university_id']]))
            {
               $form_b_university_id = clean($_POST[$_POST['select_b_university_id']]);
               if ($_POST['select_b_university_id'] == "form_b_university_id")
               {
                  $form_b_degree_status_id = clean($_POST['form_b_degree_status_id']);
               }
               else
               {
                  $form_b_degree_status_id = clean($_POST['form_b_degree_status_id2']);
               }
            }
            if (isset($_POST[$_POST['select_f_university_id']]))
            {
               $form_f_university_id = clean($_POST[$_POST['select_f_university_id']]);
               if ($_POST['select_f_university_id'] == "form_f_university_id")
               {
                  $form_f_degree_status_id = clean($_POST['form_f_degree_status_id']);
               }
               else
               {
                  $form_f_degree_status_id = clean($_POST['form_f_degree_status_id2']);
               }
            }
            if (isset($_POST[$_POST['select_m_university_id']]))
            {
               $form_m_university_id = clean($_POST[$_POST['select_m_university_id']]);
               if ($_POST['select_m_university_id'] == "form_m_university_id")
               {
                  $form_m_degree_status_id = clean($_POST['form_m_degree_status_id']);
               }
               else
               {
                  $form_m_degree_status_id = clean($_POST['form_m_degree_status_id2']);
               }
            }
            if (isset($_POST[$_POST['select_d_university_id']]))
            {
               $form_d_university_id = clean($_POST[$_POST['select_d_university_id']]);
               if ($_POST['select_d_university_id'] == "form_d_university_id")
               {
                  $form_d_degree_status_id = clean($_POST['form_d_degree_status_id']);
               }
               else
               {
                  $form_d_degree_status_id = clean($_POST['form_d_degree_status_id2']);
               }
            }
         }

         // User section
         if ($user_selection)
         {
            $form_u_username = clean($_POST[$_POST['select_u_username']]);
            $form_first_name = clean($_POST[$_POST['select_first_name']]);
            $form_last_name = clean($_POST[$_POST['select_last_name']]);
            $form_preferred_sca_name = clean($_POST[$_POST['select_preferred_sca_name']]);
            $form_email = clean($_POST[$_POST['select_email']]);
            $form_u_date_created = clean($_POST[$_POST['select_u_date_created']]);
            $form_u_last_log = clean($_POST[$_POST['select_u_last_log']]);
         }

         // Validate data
         //-------------------------------
         // Atlantian section
         if ($atlantian_selection)
         {
            if ($form_sca_name == '')
            {
               $errmsg .= "Please enter an SCA name.<br/>";
            }
            if ($form_deceased_date != '')
            {
               if (strtotime($form_deceased_date) === FALSE)
               {
                  $errmsg .= "Please enter a valid date for the Deceased Date.<br/>";
               }
               else
               {
                  $form_deceased_date = format_mysql_date($form_deceased_date);
                  $form_deceased = 1;
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
                  $form_revoked = 1;
               }
            }
            if ($form_email != '' && !validate_email($form_email))
            {
               $errmsg .= "Please enter an email address with one @ and no spaces.<br/>";
            }
            if ($form_alternate_email != '' && !validate_email($form_alternate_email))
            {
               $errmsg .= "Please enter an alternate email address with one @ and no spaces.<br/>";
            }
            if ($form_name_reg_date != '')
            {
               if (strtotime($form_name_reg_date) === FALSE)
               {
                  $errmsg .= "Please enter a valid date for the Name Registration Date.<br/>";
               }
               else
               {
                  $form_name_reg_date = format_mysql_date($form_name_reg_date);
               }
            }
            if ($form_device_reg_date != '')
            {
               if (strtotime($form_device_reg_date) === FALSE)
               {
                  $errmsg .= "Please enter a valid date for the Device Registration Date.<br/>";
               }
               else
               {
                  $form_device_reg_date = format_mysql_date($form_device_reg_date);
               }
            }
         } // Atlantian section

         // Participant section
         if ($participant_selection)
         {
            if ($form_preferred_sca_name == '')
            {
               $errmsg .= "Please enter a preferred SCA name.<br/>";
            }
            if ($form_p_date_created != '')
            {
               if (strtotime($form_p_date_created) === FALSE)
               {
                  $errmsg .= "Please enter a valid date for the Participant date created.<br/>";
               }
               else
               {
                  $form_p_date_created = format_mysql_date($form_p_date_created);
               }
            }
         } // Participant section

         // User section
         if ($user_selection)
         {
            if ($form_u_username == '')
            {
               $errmsg .= "Please enter a username.<br/>";
            }
            if ($form_first_name == '')
            {
               $errmsg .= "Please enter a first name.<br/>";
            }
            if ($form_last_name == '')
            {
               $errmsg .= "Please enter a last name.<br/>";
            }
            if ($form_email == '')
            {
               $errmsg .= "Please enter an email address.<br/>";
            }
            if ($form_u_date_created != '')
            {
               if (strtotime($form_u_date_created) === FALSE)
               {
                  $errmsg .= "Please enter a valid date for the User Account date created.<br/>";
               }
               else
               {
                  $form_u_date_created = format_mysql_date($form_u_date_created);
               }
            }
         } // User section

         //-------------------------------
         // Update database if valid
         //-------------------------------
         if ($errmsg == '')
         {
            //-------------------------------
            // Assume keep first ID, delete second ID
            //-------------------------------
            // Atlantian
            $keep_atlantian_id = $first_atlantian_id;
            $del_atlantian_id = $second_atlantian_id;
            // If there weren't two Atlantian IDs, use the one that was set
            if (!$atlantian_selection)
            {
               $keep_atlantian_id = $atlantian_id;
               $del_atlantian_id = 0;
            }
            if ($no_atlantian)
            {
               $keep_atlantian_id = NULL;
               $del_atlantian_id = NULL;
            }
            // Participant
            $keep_participant_id = $first_participant_id;
            $del_participant_id = $second_participant_id;
            // If there weren't two Participant IDs, use the one that was set
            if (!$participant_selection)
            {
               $keep_participant_id = $participant_id;
               $del_participant_id = 0;
            }
            if ($no_participant)
            {
               $keep_participant_id = NULL;
               $del_participant_id = NULL;
            }
            // User
            $keep_user_id = $first_user_id;
            $del_user_id = $second_user_id;
            // If there weren't two User IDs, use the one that was set
            if (!$user_selection)
            {
               $keep_user_id = $user_id;
               $del_user_id = 0;
            }
            if ($no_user)
            {
               $keep_user_id = NULL;
               $del_user_id = NULL;
            }

            $link = db_admin_connect();

            // Is one of these Atlantian records tied to an account?
            // Make sure the first Atlantian ID is listed first
            $sort_dir = "ASC";
            if ($first_atlantian_id < $second_atlantian_id)
            {
               $sort_dir = "DESC";
            }
            $account_query = "SELECT * FROM $DBNAME_AUTH.user_auth WHERE atlantian_id IN (" . $first_atlantian_id . ", " . $second_atlantian_id . ") " .
                             "OR user_id IN (" . $keep_user_id . ", " . $del_user_id . ") " . 
                             "ORDER BY atlantian_id $sort_dir";
            $account_result = mysql_query($account_query)
               or die("Error retrieving Accounts: " . mysql_error());
            $num_accounts = mysql_num_rows($account_result);
            //echo "DEBUG: num_accounts: $num_accounts<br/>\n";
            // If one account is tied, use that Atlantian ID
            if ($num_accounts == 1)
            {
               $account_data = mysql_fetch_array($account_result, MYSQL_BOTH);
               if (!$no_atlantian)
               {
                  $account_atlantian_id = $account_data['atlantian_id'];
                  if ($account_atlantian_id == $second_atlantian_id)
                  {
                     $keep_atlantian_id = $second_atlantian_id;
                     $del_atlantian_id = $first_atlantian_id;
                  }
               }
               $account_user_id = $account_data['user_id'];
               $keep_user_id = $account_user_id;
               if ($user_selection)
               {
                  if ($first_user_id == $account_user_id)
                  {
                     $del_user_id = $second_user_id;
                  }
                  else if ($second_user_id == $account_user_id)
                  {
                     $del_user_id = $first_user_id;
                  }
               }
               else if ($user_id > 0)
               {
                  if ($user_id != $account_user_id)
                  {
                     $del_user_id = $user_id;
                  }
               }
            }
            // If both Atlantian IDs have accounts, keep the account most recently logged in
            // and all the order access permissions
            else if ($num_accounts == 2)
            {
               // Get first account data
               $account_data = mysql_fetch_array($account_result, MYSQL_BOTH);
               $account_atlantian_id = $account_data['atlantian_id'];
               $account_user_id = $account_data['user_id'];
               $account_username = $account_data['username'];
               $account_last_log = $account_data['last_log'];
               for ($i = 1; $i <= count($ORDER_ARRAY); $i++)
               {
                  $account_permissions[$i]['pend'] = $account_data[$ORDER_ARRAY[$i]['pend']];
                  $account_permissions[$i]['access'] = $account_data[$ORDER_ARRAY[$i]['access']];
               }

               // Get second account data
               $account_data = mysql_fetch_array($account_result, MYSQL_BOTH);
               $account_atlantian_id2 = $account_data['atlantian_id'];
               $account_user_id2 = $account_data['user_id'];
               $account_username2 = $account_data['username'];
               $account_last_log2 = $account_data['last_log'];
               for ($i = 1; $i <= count($ORDER_ARRAY); $i++)
               {
                  $account_permissions2[$i]['pend'] = $account_data[$ORDER_ARRAY[$i]['pend']];
                  $account_permissions2[$i]['access'] = $account_data[$ORDER_ARRAY[$i]['access']];
               }

               $keep_user_id = $account_user_id;
               // Determine which account was used most recently
               if ($account_last_log != "" && $account_last_log2 != "")
               {
                  // Account with second Atlantian ID was used most recently
                  if ($account_last_log2 > $account_last_log)
                  {
                     if (!$no_atlantian)
                     {
                        $keep_atlantian_id = $second_atlantian_id;
                        $del_atlantian_id = $first_atlantian_id;
                     }
                     $keep_user_id = $account_user_id2;
                  }
               }
               // Account with second Atlantian ID is the only one that has been used
               else if ($account_last_log == "" && $account_last_log2 != "")
               {
                  if (!$no_atlantian)
                  {
                     $keep_atlantian_id = $second_atlantian_id;
                     $del_atlantian_id = $first_atlantian_id;
                  }
                  $keep_user_id = $account_user_id2;
               }

               if ($user_selection)
               {
                  if ($first_user_id == $keep_user_id)
                  {
                     $del_user_id = $second_user_id;
                  }
                  else if ($second_user_id == $keep_user_id)
                  {
                     $del_user_id = $first_user_id;
                  }
               }
               else if ($user_id > 0)
               {
                  if ($user_id != $keep_user_id)
                  {
                     $del_user_id = $user_id;
                  }
               }
            }
            // If not, use the lower Atlantian ID
            else if (!$no_atlantian)
            {
               if ($first_atlantian_id > $second_atlantian_id)
               {
                  $keep_atlantian_id = $second_atlantian_id;
                  $del_atlantian_id = $first_atlantian_id;
               }
            }

            //echo "DEBUG: u: [$user_id] u1: [$first_user_id] u2: [$second_user_id] uk: [$keep_user_id] ud: [$del_user_id]<br/>\n";
            // Update the selected Atlantian ID with all the selected data fields

            if (!$no_atlantian)
            {
               // Get previous SCA Name
               $name_query = "SELECT sca_name, preferred_sca_name, name_reg_date FROM $DBNAME_AUTH.atlantian WHERE atlantian_id = " . value_or_null($keep_atlantian_id);

               $name_result = mysql_query($name_query)
                  or die("Error retrieving Atlantian SCA Name: " . mysql_error());

               $name_data = mysql_fetch_array($name_result, MYSQL_BOTH);

               $prev_name = $name_data['sca_name'];
               $prev_pref_name = $name_data['preferred_sca_name'];
               $prev_name_date = $name_data['name_reg_date'];

               // If the previous SCA and preferred names matched
               if ($prev_name == $prev_pref_name)
               {
                  // But the new SCA name does not match the previous SCA name
                  if ($atlantian_selection && $prev_name != $form_sca_name)
                  {
                     // Update the preferred name to continue to match the SCA name
                     $form_preferred_sca_name = $form_sca_name;
                  }
                  // If the names matched and the SCA name is registered, use the registered name
                  if ($prev_name_date != "")
                  {
                     $form_preferred_sca_name = $prev_name;
                  }
               }

               // Default - single Atlantian ID
               $sql_stmt = "UPDATE $DBNAME_AUTH.atlantian SET " .
                  "first_name = " . value_or_null($form_first_name) .
                  ", last_name = " . value_or_null($form_last_name) .
                  ", email = " . value_or_null($form_email) .
                  ", preferred_sca_name = " . value_or_null($form_preferred_sca_name) .
                  ", last_updated = " . value_or_null(date("Y-m-d")) .
                  ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) .
                  " WHERE atlantian_id = " . value_or_null($keep_atlantian_id);

               // All fields if two Atlantian IDs
               if ($atlantian_selection)
               {
                  $sql_stmt = "UPDATE $DBNAME_AUTH.atlantian SET " .
                  "first_name = " . value_or_null($form_first_name) .
                  ", middle_name = " . value_or_null($form_middle_name) .
                  ", last_name = " . value_or_null($form_last_name) .
                  ", email = " . value_or_null($form_email) .
                  ", alternate_email = " . value_or_null($form_alternate_email) .
                  ", address1 = " . value_or_null($form_address1) .
                  ", address2 = " . value_or_null($form_address2) .
                  ", city = " . value_or_null($form_city) .
                  ", state = " . value_or_null($form_state) .
                  ", zip = " . value_or_null($form_zip) .
                  ", country = " . value_or_null($form_country) .
                  ", phone_home = " . value_or_null($form_phone_home) .
                  ", phone_work = " . value_or_null($form_phone_work) .
                  ", phone_mobile = " . value_or_null($form_phone_mobile) .
                  ", call_times = " . value_or_null($form_call_times) .
                  ", publish_name = " . value_or_zero($form_publish_name) .
                  ", publish_email = " . value_or_zero($form_publish_email) .
                  ", publish_alternate_email = " . value_or_zero($form_publish_alternate_email) .
                  ", publish_address = " . value_or_zero($form_publish_address) .
                  ", publish_phone_home = " . value_or_zero($form_publish_phone_home) .
                  ", publish_phone_work = " . value_or_zero($form_publish_phone_work) .
                  ", publish_phone_mobile = " . value_or_zero($form_publish_phone_mobile) .
                  ", gender = " . value_or_null($form_gender) .
                  ", deceased = " . value_or_zero($form_deceased) .
                  ", deceased_date = " . value_or_null($form_deceased_date) .
                  ", inactive = " . value_or_zero($form_inactive) .
                  ", revoked = " . value_or_zero($form_revoked) .
                  ", revoked_date = " . value_or_null($form_revoked_date) .
                  ", sca_name = " . value_or_null($form_sca_name) .
                  ", preferred_sca_name = " . value_or_null($form_preferred_sca_name) .
                  ", branch_id = " . value_or_null($form_branch_id) .
                  ", blazon = " . value_or_null($form_blazon) .
                  ", name_reg_date = " . value_or_null($form_name_reg_date) .
                  ", device_reg_date = " . value_or_null($form_device_reg_date) .
                  ", alternate_names = " . value_or_null($form_alternate_names) .
                  ", heraldic_rank_id = " . value_or_null($form_heraldic_rank_id) .
                  ", heraldic_title = " . value_or_null($form_heraldic_title) .
                  ", heraldic_interests = " . value_or_null($form_heraldic_interests) .
                  ", website = " . value_or_null($form_website) .
                  ", biography = " . value_or_null($form_biography) .
                  ", membership_number = " . value_or_null($form_membership_number) .
                  ", expiration_date = " . value_or_null($form_expiration_date) .
                  ", expiration_date_pending = " . value_or_null($form_expiration_date_pending) .
                  ", background_check_result = " . value_or_null($form_background_check_result) .
                  ", background_check_date = " . value_or_null($form_background_check_date) .
                  ", device_file_name = " . value_or_null($form_device_file_name) .
                  ", device_file_credit = " . value_or_null($form_device_file_credit) .
                  ", picture_file_name = " . value_or_null($form_picture_file_name) .
                  ", picture_file_credit = " . value_or_null($form_picture_file_credit) .
                  ", op_notes = " . value_or_null($form_op_notes) .
                  ", date_created = " . value_or_null($form_date_created) .
                  ", last_updated = " . value_or_null(date("Y-m-d")) .
                  ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) .
                  " WHERE atlantian_id = " . value_or_null($keep_atlantian_id);
               }

               //echo "DEBUG: $sql_stmt<br/>";
               $sql_result = mysql_query($sql_stmt)
                  or die("Error updating Atlantian data: " . mysql_error());

               // Only need to update Atlantian ID referenced data if there were two to choose from
               if ($atlantian_selection)
               {
                  //------------------------
                  // UPDATE OP DATA
                  //------------------------
                  // Update all awards with the selected Atlantian ID
                  $upd_award = "UPDATE $DBNAME_OP.atlantian_award SET " .
                     "atlantian_id = " . value_or_null($keep_atlantian_id) .
                     ", last_updated = " . value_or_null(date("Y-m-d")) .
                     ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) . 
                     " WHERE atlantian_id = " . value_or_null($del_atlantian_id);
                  $del_result = mysql_query($upd_award)
                     or die("Error updating Atlantian awards in OP: " . mysql_error());

                  //------------------------
                  // UPDATE ORDER DATA
                  //------------------------
                  // Update all orders with the selected Atlantian ID
                  $check_query = "UPDATE $DBNAME_ORDER.laurel SET " .
                     "atlantian_id = " . value_or_null($keep_atlantian_id) .
                     ", last_updated = " . value_or_null(date("Y-m-d")) .
                     ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) . 
                     " WHERE atlantian_id = " . value_or_null($del_atlantian_id);
                  $check_result = mysql_query($check_query)
                     or die("Error updating Order laurel for Atlantian keep: " . mysql_error());

                  $check_query = "UPDATE $DBNAME_ORDER.pearl SET " .
                     "atlantian_id = " . value_or_null($keep_atlantian_id) .
                     ", last_updated = " . value_or_null(date("Y-m-d")) .
                     ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) . 
                     " WHERE atlantian_id = " . value_or_null($del_atlantian_id);
                  $check_result = mysql_query($check_query)
                     or die("Error updating Order pearl for Atlantian keep: " . mysql_error());

                  $check_query = "UPDATE $DBNAME_ORDER.pelican SET " .
                     "atlantian_id = " . value_or_null($keep_atlantian_id) .
                     ", last_updated = " . value_or_null(date("Y-m-d")) .
                     ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) . 
                     " WHERE atlantian_id = " . value_or_null($del_atlantian_id);
                  $check_result = mysql_query($check_query)
                     or die("Error updating Order pelican for Atlantian keep: " . mysql_error());

                  $check_query = "UPDATE $DBNAME_ORDER.dolphin SET " .
                     "atlantian_id = " . value_or_null($keep_atlantian_id) .
                     ", last_updated = " . value_or_null(date("Y-m-d")) .
                     ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) . 
                     " WHERE atlantian_id = " . value_or_null($del_atlantian_id);
                  $check_result = mysql_query($check_query)
                     or die("Error updating Order dolphin for Atlantian keep: " . mysql_error());

                  $check_query = "UPDATE $DBNAME_ORDER.chivalry SET " .
                     "atlantian_id = " . value_or_null($keep_atlantian_id) .
                     ", last_updated = " . value_or_null(date("Y-m-d")) .
                     ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) . 
                     " WHERE atlantian_id = " . value_or_null($del_atlantian_id);
                  $check_result = mysql_query($check_query)
                     or die("Error updating Order chivalry for Atlantian keep: " . mysql_error());

                  $check_query = "UPDATE $DBNAME_ORDER.kraken SET " .
                     "atlantian_id = " . value_or_null($keep_atlantian_id) .
                     ", last_updated = " . value_or_null(date("Y-m-d")) .
                     ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) . 
                     " WHERE atlantian_id = " . value_or_null($del_atlantian_id);
                  $check_result = mysql_query($check_query)
                     or die("Error updating Order kraken for Atlantian keep: " . mysql_error());

                  $check_query = "UPDATE $DBNAME_ORDER.seastag SET " .
                     "atlantian_id = " . value_or_null($keep_atlantian_id) .
                     ", last_updated = " . value_or_null(date("Y-m-d")) .
                     ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) . 
                     " WHERE atlantian_id = " . value_or_null($del_atlantian_id);
                  $check_result = mysql_query($check_query)
                     or die("Error updating Order seastag for Atlantian keep: " . mysql_error());

                  $check_query = "UPDATE $DBNAME_ORDER.yewbow SET " .
                     "atlantian_id = " . value_or_null($keep_atlantian_id) .
                     ", last_updated = " . value_or_null(date("Y-m-d")) .
                     ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) . 
                     " WHERE atlantian_id = " . value_or_null($del_atlantian_id);
                  $check_result = mysql_query($check_query)
                     or die("Error updating Order yewbow for Atlantian keep: " . mysql_error());

                  $check_query = "UPDATE $DBNAME_ORDER.whitescarf SET " .
                     "atlantian_id = " . value_or_null($keep_atlantian_id) .
                     ", last_updated = " . value_or_null(date("Y-m-d")) .
                     ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) . 
                     " WHERE atlantian_id = " . value_or_null($del_atlantian_id);
                  $check_result = mysql_query($check_query)
                     or die("Error updating Order whitescarf for Atlantian keep: " . mysql_error());

                  $check_query = "UPDATE $DBNAME_ORDER.rose SET " .
                     "atlantian_id = " . value_or_null($keep_atlantian_id) .
                     ", last_updated = " . value_or_null(date("Y-m-d")) .
                     ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) . 
                     " WHERE atlantian_id = " . value_or_null($del_atlantian_id);
                  $check_result = mysql_query($check_query)
                     or die("Error updating Order rose for Atlantian keep: " . mysql_error());
               } // Atlantian selection
            } // Atlantian exits

            //------------------------
            // UPDATE UNIVERSITY DATA
            //------------------------
            // Just one participant record?  Update record with keep Atlantian ID
            if (!$participant_selection && $participant_id > 0)
            {
               $update = "UPDATE $DBNAME_UNIVERSITY.participant SET " .
                  "atlantian_id = " . value_or_null($keep_atlantian_id) .
                  ", user_id = " . value_or_null($keep_user_id) .
                  ", sca_name = " . value_or_null($form_preferred_sca_name) .
                  ", last_updated = " . value_or_null(date("Y-m-d")) .
                  ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) .
                  " WHERE participant_id = " . value_or_null($participant_id);
               //echo "DEBUG: $update<br/>";
               $update_result = mysql_query($update)
                  or die("Error updating University Participant: " . mysql_error());
            }
            // More than one?
            else if ($participant_selection)
            {
               // Would there be duplicate registration records if we merged?
               $p_sort_dir = "ASC";
               if ($first_participant_id < $second_participant_id)
               {
                  $p_sort_dir = "DESC";
               }
               // How many Registration records with these two Participant IDs?
               $query = "SELECT * FROM $DBNAME_UNIVERSITY.registration " . 
                  "WHERE participant_id IN (" . value_or_null($first_participant_id) . ", " . value_or_null($second_participant_id) . ") " .
                  "ORDER BY course_id, participant_id $p_sort_dir";
               $result = mysql_query($query)
                  or die("Registration Query Failed: " . $query . "<br/>" . mysql_error());
               $num_registrations = mysql_num_rows($result);

               if ($num_registrations > 0)
               {
                  $prev_registration_id = 0;
                  $prev_course_id = 0;
                  $prev_participant_type_id = 0;
                  $del_registration_id_list = "";
                  while ($data = mysql_fetch_array($result, MYSQL_BOTH))
                  {
                     $r_registration_id = clean($data['registration_id']);
                     $r_course_id = clean($data['course_id']);
                     $r_participant_type_id = clean($data['participant_type_id']);
                     // Duplicate course
                     if ($prev_course_id == $r_course_id)
                     {
                        // Keep the first entry
                        $del_registration_id = $r_registration_id;
                        if ($prev_participant_type_id != $r_participant_type_id)
                        {
                           // Keep the instructor entry
                           if ($r_participant_type_id == $TYPE_INSTRUCTOR)
                           {
                              $del_registration_id = $prev_registration_id;
                           }
                        }
                        if ($del_registration_id_list != "")
                        {
                           $del_registration_id_list .= ", ";
                        }
                        $del_registration_id_list .= $del_registration_id;
                     }
                     $prev_registration_id = $r_registration_id;
                     $prev_course_id = $r_course_id;
                     $prev_participant_type_id = $r_participant_type_id;
                  }

                  // Delete duplicate registrations
                  if ($del_registration_id_list != "")
                  {
                     $delete = "DELETE FROM $DBNAME_UNIVERSITY.registration WHERE registration_id IN ($del_registration_id_list)";
                     //echo "DEBUG: $delete<br/>";
                     $del_result = mysql_query($delete)
                        or die("Error deleting duplicate university registrations: " . mysql_error());
                  }

                  // Update remaining registration records with keep participant ID
                  $update = "UPDATE $DBNAME_UNIVERSITY.registration SET participant_id = " . value_or_null($keep_participant_id) .
                     ", last_updated = " . value_or_null(date("Y-m-d")) .
                     ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) .
                     " WHERE participant_id = " . value_or_null($del_participant_id);
                  //echo "DEBUG: $update<br/>";
                  $update_result = mysql_query($update)
                     or die("Error updating university registrations: " . mysql_error());
               }
               // Delete duplicate participant record
               $delete = "DELETE FROM $DBNAME_UNIVERSITY.participant WHERE participant_id = " . value_or_null($del_participant_id);
               //echo "DEBUG: $delete<br/>";
               $del_result = mysql_query($delete)
                  or die("Error deleting duplicate university participant: " . mysql_error());

               // Update remaining participant record
               $update = "UPDATE $DBNAME_UNIVERSITY.participant SET " .
                  "atlantian_id = " . value_or_null($keep_atlantian_id) .
                  ", user_id = " . value_or_null($keep_user_id) .
                  ", sca_name = " . value_or_null($form_preferred_sca_name) .
                  ", b_old_university_id = " . value_or_null($form_b_old_university_id) .
                  ", b_old_degree_status_id = " . value_or_null($form_b_old_degree_status_id) .
                  ", b_university_id = " . value_or_null($form_b_university_id) .
                  ", b_degree_status_id = " . value_or_null($form_b_degree_status_id) .
                  ", f_university_id = " . value_or_null($form_f_university_id) .
                  ", f_degree_status_id = " . value_or_null($form_f_degree_status_id) .
                  ", m_university_id = " . value_or_null($form_m_university_id) .
                  ", m_degree_status_id = " . value_or_null($form_m_degree_status_id) .
                  ", d_university_id = " . value_or_null($form_d_university_id) .
                  ", d_degree_status_id = " . value_or_null($form_d_degree_status_id) .
                  ", last_updated = " . value_or_null(date("Y-m-d")) .
                  ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) .
                  " WHERE participant_id = " . value_or_null($keep_participant_id);
               //echo "DEBUG: $update<br/>";
               $update_result = mysql_query($update)
                  or die("Error updating University Participant: " . mysql_error());
            }

            //------------------------
            // UPDATE AUTH DATA
            //------------------------
            // Delete extra user account
            if ($num_accounts == 2 || $user_selection)
            {
               $delete = "UPDATE $DBNAME_AUTH.user_auth SET atlantian_id = NULL, last_updated_by = " . value_or_null($_SESSION['s_user_id']) . " WHERE user_id = $del_user_id";
               //echo "DEBUG: $delete<br/>";
               $del_result = mysql_query($delete)
                  or die("Error updating last updated User from user_auth: " . mysql_error());
               $delete = "DELETE FROM $DBNAME_AUTH.user_auth WHERE user_id = $del_user_id";
               //echo "DEBUG: $delete<br/>";
               $del_result = mysql_query($delete)
                  or die("Error deleting User from user_auth: " . mysql_error());
            }
            // Update user account to keep
            if ($keep_user_id > 0)
            {
               $set_clause = "SET " .
                  "first_name = " . value_or_null($form_first_name) .
                  ", last_name = " . value_or_null($form_last_name) .
                  ", email = " . value_or_null($form_email) .
                  ", sca_name = " . value_or_null($form_preferred_sca_name) .
                  ", atlantian_id = " . value_or_null($keep_atlantian_id) .
                  ", last_updated = " . value_or_null(date("Y-m-d")) .
                  ", last_updated_by = " . value_or_null($_SESSION['s_user_id']);
               // Determine order access permissions on remaining account
               if (isset($account_order_perms))
               {
                  for ($i = 1; $i <= count($ORDER_ARRAY); $i++)
                  {
                     // If either account had access, the remaining account has access
                     $account_order_perms[$i]['access'] = $account_permissions[$i]['access'] || $account_permissions2[$i]['access'];
                     // If the account has access, it is not pending
                     if ($account_order_perms[$i]['access'] == 1)
                     {
                        $account_order_perms[$i]['pend'] = 0;
                     }
                     // If the account does not have access, if either account was pending, the remaining account is pending
                     else
                     {
                        $account_order_perms[$i]['pend'] = $account_permissions[$i]['pend'] || $account_permissions2[$i]['pend'];
                     }
                     $set_clause .= ", " . $ORDER_ARRAY[$i]['pend'] . " = " . $account_order_perms[$i]['pend'];
                     $set_clause .= ", " . $ORDER_ARRAY[$i]['access'] . " = " . $account_order_perms[$i]['access'];
                  }
               }

               $update = "UPDATE $DBNAME_AUTH.user_auth $set_clause WHERE user_id = $keep_user_id";
               //echo "DEBUG: $update<br/>";
               $update_result = mysql_query($update)
                  or die("Error updating User in user_auth: " . mysql_error());
            }

            if (!$no_atlantian)
            {
               // Delete non-selected Atlantian ID from auth
               $delete = "DELETE FROM $DBNAME_AUTH.atlantian WHERE atlantian_id = $del_atlantian_id";
               //echo "DEBUG: $delete<br/>";
               $del_result = mysql_query($delete)
                  or die("Error deleting Atlantian from auth: " . mysql_error());
            }

            // Close DB
            db_disconnect($link);

            // Redirect to edit page
            redirect("participant.php?participant_id=$keep_participant_id&mode=$MODE_EDIT");
         }
      } // Valid
   } // Submit

   //-------------------------------
   // Read existing data if this isn't a submit
   //-------------------------------
   if ((!(isset($_POST['submit']))) || (isset($_POST['submit']) && $errmsg != ''))
   {
      $link = db_connect();
      // Need to choose an Atlantian
      if ($atlantian_selection)
      {
         // Collect data on first Atlantian
         $query = "SELECT atlantian.*, heraldic_rank.heraldic_rank FROM $DBNAME_AUTH.atlantian LEFT OUTER JOIN $DBNAME_WARRANT.heraldic_rank ON atlantian.heraldic_rank_id = heraldic_rank.heraldic_rank_id WHERE atlantian.atlantian_id = " . value_or_null($first_atlantian_id);
         $result = mysql_query($query);
         $data = mysql_fetch_array($result, MYSQL_BOTH);

         $form_first_name = clean($data['first_name']);
         $form_middle_name = clean($data['middle_name']);
         $form_last_name = clean($data['last_name']);
         $form_email = clean($data['email']);
         $form_alternate_email = clean($data['alternate_email']);
         $form_address1 = clean($data['address1']);
         $form_address2 = clean($data['address2']);
         $form_city = clean($data['city']);
         $form_state = clean($data['state']);
         $form_zip = clean($data['zip']);
         $form_country = clean($data['country']);
         $form_phone_home = clean($data['phone_home']);
         $form_phone_work = clean($data['phone_work']);
         $form_phone_mobile = clean($data['phone_mobile']);
         $form_call_times = clean($data['call_times']);

         $form_publish_name = clean($data['publish_name']);
         $form_publish_email = clean($data['publish_email']);
         $form_publish_alternate_email = clean($data['publish_alternate_email']);
         $form_publish_address = clean($data['publish_address']);
         $form_publish_phone_home = clean($data['publish_phone_home']);
         $form_publish_phone_work = clean($data['publish_phone_work']);
         $form_publish_phone_mobile = clean($data['publish_phone_mobile']);

         $form_gender = clean($data['gender']);
         $form_deceased = clean($data['deceased']);
         $form_deceased_date = clean($data['deceased_date']);
         $form_inactive = clean($data['inactive']);
         $form_revoked = clean($data['revoked']);
         $form_revoked_date = clean($data['revoked_date']);
         $form_sca_name = clean($data['sca_name']);
         $form_name_reg_date = clean($data['name_reg_date']);
         $form_alternate_names = clean($data['alternate_names']);
         $form_blazon = clean($data['blazon']);
         $form_device_reg_date = clean($data['device_reg_date']);
         $form_device_file_name = clean($data['device_file_name']);
         $form_device_file_credit = clean($data['device_file_credit']);
         $form_op_notes = clean($data['op_notes']);
         $form_branch_id = clean($data['branch_id']);
         $form_preferred_sca_name = clean($data['preferred_sca_name']);
         $form_picture_file_name = clean($data['picture_file_name']);
         $form_picture_file_credit = clean($data['picture_file_credit']);
         $form_heraldic_rank_id = clean($data['heraldic_rank_id']);
         $form_heraldic_rank = clean($data['heraldic_rank']);
         $form_heraldic_title = clean($data['heraldic_title']);
         $form_heraldic_interests = clean($data['heraldic_interests']);
         $form_membership_number = clean($data['membership_number']);
         $form_expiration_date = clean($data['expiration_date']);
         $form_expiration_date_pending = clean($data['expiration_date_pending']);
         $form_website = clean($data['website']);
         $form_biography = clean($data['biography']);
         $form_date_created = clean($data['date_created']);
         $form_background_check_date = clean($data['background_check_date']);
         $form_background_check_result = clean($data['background_check_result']);

         // Collect data on second Atlantian
         $query = "SELECT atlantian.*, heraldic_rank.heraldic_rank FROM $DBNAME_AUTH.atlantian LEFT OUTER JOIN $DBNAME_WARRANT.heraldic_rank ON atlantian.heraldic_rank_id = heraldic_rank.heraldic_rank_id WHERE atlantian.atlantian_id = " . value_or_null($second_atlantian_id);
         $result = mysql_query($query);
         $data = mysql_fetch_array($result, MYSQL_BOTH);

         $form_first_name2 = clean($data['first_name']);
         $form_middle_name2 = clean($data['middle_name']);
         $form_last_name2 = clean($data['last_name']);
         $form_email2 = clean($data['email']);
         $form_alternate_email2 = clean($data['alternate_email']);
         $form_address12 = clean($data['address1']);
         $form_address22 = clean($data['address2']);
         $form_city2 = clean($data['city']);
         $form_state2 = clean($data['state']);
         $form_zip2 = clean($data['zip']);
         $form_country2 = clean($data['country']);
         $form_phone_home2 = clean($data['phone_home']);
         $form_phone_work2 = clean($data['phone_work']);
         $form_phone_mobile2 = clean($data['phone_mobile']);
         $form_call_times2 = clean($data['call_times']);

         $form_publish_name2 = clean($data['publish_name']);
         $form_publish_email2 = clean($data['publish_email']);
         $form_publish_alternate_email2 = clean($data['publish_alternate_email']);
         $form_publish_address2 = clean($data['publish_address']);
         $form_publish_phone_home2 = clean($data['publish_phone_home']);
         $form_publish_phone_work2 = clean($data['publish_phone_work']);
         $form_publish_phone_mobile2 = clean($data['publish_phone_mobile']);

         $form_gender2 = clean($data['gender']);
         $form_deceased2 = clean($data['deceased']);
         $form_deceased_date2 = clean($data['deceased_date']);
         $form_inactive2 = clean($data['inactive']);
         $form_revoked2 = clean($data['revoked']);
         $form_revoked_date2 = clean($data['revoked_date']);
         $form_sca_name2 = clean($data['sca_name']);
         $form_name_reg_date2 = clean($data['name_reg_date']);
         $form_alternate_names2 = clean($data['alternate_names']);
         $form_blazon2 = clean($data['blazon']);
         $form_device_reg_date2 = clean($data['device_reg_date']);
         $form_device_file_name2 = clean($data['device_file_name']);
         $form_device_file_credit2 = clean($data['device_file_credit']);
         $form_op_notes2 = clean($data['op_notes']);
         $form_branch_id2 = clean($data['branch_id']);
         $form_preferred_sca_name2 = clean($data['preferred_sca_name']);
         $form_picture_file_name2 = clean($data['picture_file_name']);
         $form_picture_file_credit2 = clean($data['picture_file_credit']);
         $form_heraldic_rank_id2 = clean($data['heraldic_rank_id']);
         $form_heraldic_rank2 = clean($data['heraldic_rank']);
         $form_heraldic_title2 = clean($data['heraldic_title']);
         $form_heraldic_interests2 = clean($data['heraldic_interests']);
         $form_membership_number2 = clean($data['membership_number']);
         $form_expiration_date2 = clean($data['expiration_date']);
         $form_expiration_date_pending2 = clean($data['expiration_date_pending']);
         $form_website2 = clean($data['website']);
         $form_biography2 = clean($data['biography']);
         $form_date_created2 = clean($data['date_created']);
         $form_background_check_date2 = clean($data['background_check_date']);
         $form_background_check_result2 = clean($data['background_check_result']);

         mysql_free_result($result);
      }

      // Need to select participant
      if ($participant_selection)
      {
         // Collect data on first Participant
         $query = "SELECT participant.* FROM $DBNAME_UNIVERSITY.participant WHERE participant.participant_id = " . value_or_null($first_participant_id);
         $result = mysql_query($query);
         $data = mysql_fetch_array($result, MYSQL_BOTH);

         $form_p_sca_name = clean($data['sca_name']);
         $form_p_date_created = clean($data['date_created']);
         $form_b_old_university_id = clean($data['b_old_university_id']);
         $form_b_old_degree_status_id = clean($data['b_old_degree_status_id']);
         $form_b_university_id = clean($data['b_university_id']);
         $form_b_degree_status_id = clean($data['b_degree_status_id']);
         $form_f_university_id = clean($data['f_university_id']);
         $form_f_degree_status_id = clean($data['f_degree_status_id']);
         $form_m_university_id = clean($data['m_university_id']);
         $form_m_degree_status_id = clean($data['m_degree_status_id']);
         $form_d_university_id = clean($data['d_university_id']);
         $form_d_degree_status_id = clean($data['d_degree_status_id']);

         // Collect data on second Participant
         $query = "SELECT participant.* FROM $DBNAME_UNIVERSITY.participant WHERE participant.participant_id = " . value_or_null($second_participant_id);
         $result = mysql_query($query);
         $data = mysql_fetch_array($result, MYSQL_BOTH);

         $form_p_sca_name2 = clean($data['sca_name']);
         $form_p_date_created2 = clean($data['date_created']);
         $form_b_old_university_id2 = clean($data['b_old_university_id']);
         $form_b_old_degree_status_id2 = clean($data['b_old_degree_status_id']);
         $form_b_university_id2 = clean($data['b_university_id']);
         $form_b_degree_status_id2 = clean($data['b_degree_status_id']);
         $form_f_university_id2 = clean($data['f_university_id']);
         $form_f_degree_status_id2 = clean($data['f_degree_status_id']);
         $form_m_university_id2 = clean($data['m_university_id']);
         $form_m_degree_status_id2 = clean($data['m_degree_status_id']);
         $form_d_university_id2 = clean($data['d_university_id']);
         $form_d_degree_status_id2 = clean($data['d_degree_status_id']);

         mysql_free_result($result);
      }

      // Need to select user
      if ($user_selection)
      {
         // Collect data on first User Account
         $query = "SELECT user_auth.* FROM $DBNAME_AUTH.user_auth WHERE user_auth.user_id = " . value_or_null($first_user_id);
         $result = mysql_query($query);
         $data = mysql_fetch_array($result, MYSQL_BOTH);

         $form_u_username = clean($data['username']);
         $form_u_first_name = clean($data['first_name']);
         $form_u_last_name = clean($data['last_name']);
         $form_u_email = clean($data['email']);
         $form_u_sca_name = clean($data['sca_name']);
         $form_u_date_created = clean($data['date_created']);
         $form_u_last_log = clean($data['last_log']);

         // Collect data on second User Account
         $query = "SELECT user_auth.* FROM $DBNAME_AUTH.user_auth WHERE user_auth.user_id = " . value_or_null($second_user_id);
         $result = mysql_query($query);
         $data = mysql_fetch_array($result, MYSQL_BOTH);

         $form_u_username2 = clean($data['username']);
         $form_u_first_name2 = clean($data['first_name']);
         $form_u_last_name2 = clean($data['last_name']);
         $form_u_email2 = clean($data['email']);
         $form_u_sca_name2 = clean($data['sca_name']);
         $form_u_date_created2 = clean($data['date_created']);
         $form_u_last_log2 = clean($data['last_log']);

         mysql_free_result($result);
      }

      $atlantian_id = 0;
      $participant_id = 0;
      $user_id = 0;

      // If there is one Atlantian ID, pull the common data from that record
      if (!$atlantian_selection && !$no_atlantian)
      {
         $atlantian_id = $first_atlantian_id;
         if ($second_atlantian_id > 0)
         {
            $atlantian_id = $second_atlantian_id;
         }
         // Collect data on Atlantian
         $query = "SELECT atlantian.* FROM $DBNAME_AUTH.atlantian WHERE atlantian.atlantian_id = " . value_or_null($atlantian_id);
         $result = mysql_query($query);
         $data = mysql_fetch_array($result, MYSQL_BOTH);

         $form_first_name = clean($data['first_name']);
         $form_middle_name = clean($data['middle_name']);
         $form_last_name = clean($data['last_name']);
         $form_email = clean($data['email']);
         $form_preferred_sca_name = clean($data['preferred_sca_name']);
      }

      // If there is one Participant ID, pull the common data from that record
      if (!$participant_selection)
      {
         $participant_id = $first_participant_id;
         if ($second_participant_id > 0)
         {
            $participant_id = $second_participant_id;
         }
         // Collect data on first Participant
         $query = "SELECT participant.* FROM $DBNAME_UNIVERSITY.participant WHERE participant.participant_id = " . value_or_null($participant_id);
         $result = mysql_query($query);
         $data = mysql_fetch_array($result, MYSQL_BOTH);

         $form_p_sca_name = clean($data['sca_name']);
      }

      // If there is one User ID, pull the common data from that record
      if (!$user_selection)
      {
         $user_id = $first_user_id;
         if ($second_user_id > 0)
         {
            $user_id = $second_user_id;
         }
         // Collect data on first User Account
         $query = "SELECT user_auth.* FROM $DBNAME_AUTH.user_auth WHERE user_auth.user_id = " . value_or_null($user_id);
         $result = mysql_query($query);
         $data = mysql_fetch_array($result, MYSQL_BOTH);

         $form_u_username = clean($data['username']);
         $form_u_first_name = clean($data['first_name']);
         $form_u_last_name = clean($data['last_name']);
         $form_u_email = clean($data['email']);
         $form_u_sca_name = clean($data['sca_name']);
      }

      db_disconnect($link);
   }

// Get pick lists
$branch_data_array = get_branch_pick_list();
$university_data_array = get_university_pick_list();
$degree_status_data_array = get_degree_status_pick_list();

$title = "Merge Participant";
include("../header.php");
?>
<script type="text/javascript">
function selectAllAtlantian(selValue)
{
   var form = document.forms[0];
   var selVal = selValue - 1;
   form.select_first_name[selVal].checked = true;
   form.select_middle_name[selVal].checked = true;
   form.select_last_name[selVal].checked = true;
   form.select_gender[selVal].checked = true;
   form.select_deceased[selVal].checked = true;
   form.select_email[selVal].checked = true;
   form.select_alternate_email[selVal].checked = true;
   form.select_address1[selVal].checked = true;
   form.select_address2[selVal].checked = true;
   form.select_city[selVal].checked = true;
   form.select_state[selVal].checked = true;
   form.select_zip[selVal].checked = true;
   form.select_country[selVal].checked = true;
   form.select_phone_home[selVal].checked = true;
   form.select_phone_work[selVal].checked = true;
   form.select_phone_mobile[selVal].checked = true;
   form.select_call_times[selVal].checked = true;
   form.select_publish_name[selVal].checked = true;
   form.select_publish_address[selVal].checked = true;
   form.select_publish_email[selVal].checked = true;
   form.select_publish_alternate_email[selVal].checked = true;
   form.select_publish_phone_home[selVal].checked = true;
   form.select_publish_phone_work[selVal].checked = true;
   form.select_publish_phone_mobile[selVal].checked = true;
   form.select_sca_name[selVal].checked = true;
   form.select_preferred_sca_name[selVal].checked = true;
   form.select_branch_id[selVal].checked = true;
   form.select_name_reg_date[selVal].checked = true;
   form.select_device_reg_date[selVal].checked = true;
   form.select_blazon[selVal].checked = true;
   form.select_alternate_names[selVal].checked = true;
   form.select_heraldic_rank_id[selVal].checked = true;
   form.select_heraldic_title[selVal].checked = true;
   form.select_heraldic_interests[selVal].checked = true;
   form.select_website[selVal].checked = true;
   form.select_biography[selVal].checked = true;
   form.select_membership_number[selVal].checked = true;
   form.select_expiration_date[selVal].checked = true;
   form.select_expiration_date_pending[selVal].checked = true;
   form.select_background_check[selVal].checked = true;
   form.select_inactive[selVal].checked = true;
   form.select_revoked[selVal].checked = true;
   form.select_device_file_name[selVal].checked = true;
   form.select_device_file_credit[selVal].checked = true;
   form.select_op_notes[selVal].checked = true;
   form.select_picture_file_name[selVal].checked = true;
   form.select_picture_file_credit[selVal].checked = true;
   form.select_date_created[selVal].checked = true;
}

function selectOneAtlantian(selValue)
{
   var form = document.forms[0];
   var selVal = selValue - 1;
   form.select_first_name[selVal].checked = true;
   form.select_last_name[selVal].checked = true;
   form.select_email[selVal].checked = true;
   form.select_preferred_sca_name[selVal].checked = true;
}

function selectAllParticipant(selValue)
{
   var form = document.forms[0];
   var selVal = selValue - 1;
   form.select_preferred_sca_name[selVal<?php if ($atlantian_selection) { echo "+2"; } else if (!$no_atlantian) { echo "+1"; }?>].checked = true;
   form.select_b_old_university_id[selVal].checked = true;
   form.select_b_university_id[selVal].checked = true;
   form.select_f_university_id[selVal].checked = true;
   form.select_m_university_id[selVal].checked = true;
   form.select_d_university_id[selVal].checked = true;
   form.select_p_date_created[selVal].checked = true;
}

function selectOneParticipant(selValue)
{
   var form = document.forms[0];
   var selVal = selValue - 1;
   form.select_preferred_sca_name[selVal<?php if ($atlantian_selection) { echo "+2"; } else if (!$no_atlantian) { echo "+1"; }?>].checked = true;
}

function selectAllUser(selValue)
{
   var form = document.forms[0];
   var selVal = selValue - 1;
   form.select_u_username[selVal].checked = true;
   form.select_first_name[selVal<?php if ($atlantian_selection) { echo "+2"; } else if (!$no_atlantian) { echo "+1"; }?>].checked = true;
   form.select_last_name[selVal<?php if ($atlantian_selection) { echo "+2"; } else if (!$no_atlantian) { echo "+1"; }?>].checked = true;
   form.select_email[selVal<?php if ($atlantian_selection) { echo "+2"; } else if (!$no_atlantian) { echo "+1"; }?>].checked = true;
   form.select_preferred_sca_name[selVal<?php if ($atlantian_selection && $participant_selection) { echo "+4"; } else if (($atlantian_selection && !$participant_selection && !$no_participant) || (!$atlantian_selection && !$no_atlantian && $participant_selection)) { echo "+3"; } else if ((!$atlantian_selection && !$participant_selection && !$no_atlantian && !$no_participant) || ($no_atlantian && $participant_selection) || ($no_participant && $atlantian_selection)) { echo "+2"; } else if ((!$no_atlantian && $no_participant) || ($no_atlantian && !$no_participant)) { echo "+1"; }?>].checked = true;
   form.select_u_date_created[selVal].checked = true;
   form.select_u_last_log[selVal].checked = true;
}

function selectOneUser(selValue)
{
   var form = document.forms[0];
   var selVal = selValue - 1;
   form.select_first_name[selVal<?php if ($atlantian_selection) { echo "+2"; } else if (!$no_atlantian) { echo "+1"; }?>].checked = true;
   form.select_last_name[selVal<?php if ($atlantian_selection) { echo "+2"; } else if (!$no_atlantian) { echo "+1"; }?>].checked = true;
   form.select_email[selVal<?php if ($atlantian_selection) { echo "+2"; } else if (!$no_atlantian) { echo "+1"; }?>].checked = true;
   form.select_preferred_sca_name[selVal<?php if ($atlantian_selection && $participant_selection) { echo "+4"; } else if (($atlantian_selection && !$participant_selection && !$no_participant) || (!$atlantian_selection && !$no_atlantian && $participant_selection)) { echo "+3"; } else if ((!$atlantian_selection && !$participant_selection && !$no_atlantian && !$no_participant) || ($no_atlantian && $participant_selection) || ($no_participant && $atlantian_selection)) { echo "+2"; } else if ((!$no_atlantian && $no_participant) || ($no_atlantian && !$no_participant)) { echo "+1"; }?>].checked = true;
   form.select_u_username.checked = true;
}
</script>
<p align="center" class="title2">Merge Participant</p>
<?php 
   //echo "DEBUG: p1: [$first_participant_id] p2: [$second_participant_id] a1: [$first_atlantian_id] a2: [$second_atlantian_id] u1: [$first_user_id] u2: [$second_user_id]<br/>";
   //echo "DEBUG: p: [$participant_selection] a: [$atlantian_selection] u: [$user_selection] e: [$edit_selection]<br/>";
   if (!$edit_selection)
   {
?>
<p align="center" class="title3" style="color:red">Two Participants were not selected for Merge.  Please use a navigation link to the left.</p>
<?php 
   }
   else
   {
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<?php 
      if (isset($mode))
      {
?>
<input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>"/>
<?php 
      }
      if (isset($first_atlantian_id) && $first_atlantian_id > 0)
      {
?>
   <input type="hidden" name="first_atlantian_id" id="first_atlantian_id" value="<?php echo $first_atlantian_id; ?>"/>
<?php 
      }
      if (isset($second_atlantian_id) && $second_atlantian_id > 0)
      {
?>
   <input type="hidden" name="second_atlantian_id" id="second_atlantian_id" value="<?php echo $second_atlantian_id; ?>"/>
<?php 
      }
      if (isset($first_participant_id) && $first_participant_id > 0)
      {
?>
   <input type="hidden" name="first_participant_id" id="first_participant_id" value="<?php echo $first_participant_id; ?>"/>
<?php 
      }
      if (isset($second_participant_id) && $second_participant_id > 0)
      {
?>
   <input type="hidden" name="second_participant_id" id="second_participant_id" value="<?php echo $second_participant_id; ?>"/>
<?php 
      }
      if (isset($first_user_id) && $first_user_id > 0)
      {
?>
   <input type="hidden" name="first_user_id" id="first_user_id" value="<?php echo $first_user_id; ?>"/>
<?php 
      }
      if (isset($second_user_id) && $second_user_id > 0)
      {
?>
   <input type="hidden" name="second_user_id" id="second_user_id" value="<?php echo $second_user_id; ?>"/>
<?php 
      }
      if (isset($errmsg) && $errmsg != '')
      {
?>
<p align="center" class="title3" style="color:red">Please correct the following errors:<br/><br/><?php echo $errmsg; ?></p>
<?php 
      }
      // There are two Atlantian records to choose from
      if ($atlantian_selection)
      {
?>
<p align="center" class="title2">Atlantian Information</p>
<table align="center" cellpadding="5" cellspacing="0" border="1">
   <tr>
      <th class="title" colspan="3" bgcolor="<?php echo $TITLE_BG_COLOR; ?>">Contact Information</th>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Atlantian ID</td>
      <td class="data"><input type="radio" name="select_atlantian_id" id="select_atlantian_id" onclick="javascript:selectAllAtlantian(1);" value="<?php echo $first_atlantian_id; ?>" />Select All for Atlantian ID <?php echo $first_atlantian_id; ?></td>
      <td class="data"><input type="radio" name="select_atlantian_id" id="select_atlantian_id" onclick="javascript:selectAllAtlantian(2);" value="<?php echo $second_atlantian_id; ?>" />Select All for Atlantian ID <?php echo $second_atlantian_id; ?></td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">First Name</td>
      <td class="data">
      <input type="radio" name="select_first_name" id="select_first_name" value="form_first_name" <?php if (isset($select_first_name) && $select_first_name == "form_first_name") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" name="form_first_name" id="form_first_name" size="20" maxlength="50"<?php if (isset($form_first_name) && $form_first_name != '') { echo " value=\"$form_first_name\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_first_name" id="select_first_name" value="form_first_name2" <?php if (isset($select_first_name) && $select_first_name == "form_first_name2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" name="form_first_name2" id="form_first_name2" size="20" maxlength="50"<?php if (isset($form_first_name2) && $form_first_name2 != '') { echo " value=\"$form_first_name2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Middle Name</td>
      <td class="data">
      <input type="radio" name="select_middle_name" id="select_middle_name" value="form_middle_name" <?php if (isset($select_middle_name) && $select_middle_name == "form_middle_name") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" name="form_middle_name" id="form_middle_name" size="30" maxlength="50"<?php if (isset($form_middle_name) && $form_middle_name != '') { echo " value=\"$form_middle_name\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_middle_name" id="select_middle_name" value="form_middle_name2" <?php if (isset($select_middle_name) && $select_middle_name == "form_middle_name2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" name="form_middle_name2" id="form_middle_name2" size="30" maxlength="50"<?php if (isset($form_middle_name2) && $form_middle_name2 != '') { echo " value=\"$form_middle_name2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Last Name</td>
      <td class="data">
      <input type="radio" name="select_last_name" id="select_last_name" value="form_last_name" <?php if (isset($select_last_name) && $select_last_name == "form_last_name") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" name="form_last_name" id="form_last_name" size="30" maxlength="50"<?php if (isset($form_last_name) && $form_last_name != '') { echo " value=\"$form_last_name\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_last_name" id="select_last_name" value="form_last_name2" <?php if (isset($select_last_name) && $select_last_name == "form_last_name2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" name="form_last_name2" id="form_last_name2" size="30" maxlength="50"<?php if (isset($form_last_name2) && $form_last_name2 != '') { echo " value=\"$form_last_name2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <th class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_gender">Gender</label></th>
      <td class="data">
      <input type="radio" name="select_gender" id="select_gender" value="form_gender" <?php if (isset($select_gender) && $select_gender == "form_gender") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input name="form_gender" id="form_genderM" type="radio" value="<?php echo $MALE; ?>"<?php if (isset($form_gender) && $form_gender == $MALE) { echo ' CHECKED'; }?>/>Male 
      &nbsp;&nbsp;<input name="form_gender" id="form_genderF" type="radio" value="<?php echo $FEMALE; ?>"<?php if (isset($form_gender) && $form_gender == $FEMALE) { echo ' CHECKED'; }?>/>Female
      &nbsp;&nbsp;<input name="form_gender" id="form_genderU" type="radio" value="<?php echo $UNKNOWN; ?>"<?php if (isset($form_gender) && $form_gender == $UNKNOWN) { echo ' CHECKED'; }?>/>Unknown
      &nbsp;&nbsp;<input name="form_gender" id="form_genderN" type="radio" value="<?php echo $NONE; ?>"<?php if (isset($form_gender) && $form_gender == $NONE) { echo ' CHECKED'; }?>/>None
      </td>
      <td class="data">
      <input type="radio" name="select_gender" id="select_gender" value="form_gender2" <?php if (isset($select_gender) && $select_gender == "form_gender2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input name="form_gender2" id="form_genderM2" type="radio" value="<?php echo $MALE; ?>"<?php if (isset($form_gender2) && $form_gender2 == $MALE) { echo ' CHECKED'; }?>/>Male 
      &nbsp;&nbsp;<input name="form_gender2" id="form_genderF2" type="radio" value="<?php echo $FEMALE; ?>"<?php if (isset($form_gender2) && $form_gender2 == $FEMALE) { echo ' CHECKED'; }?>/>Female
      &nbsp;&nbsp;<input name="form_gender2" id="form_genderU2" type="radio" value="<?php echo $UNKNOWN; ?>"<?php if (isset($form_gender2) && $form_gender2 == $UNKNOWN) { echo ' CHECKED'; }?>/>Unknown
      &nbsp;&nbsp;<input name="form_gender2" id="form_genderN2" type="radio" value="<?php echo $NONE; ?>"<?php if (isset($form_gender2) && $form_gender2 == $NONE) { echo ' CHECKED'; }?>/>None
      </td>
   </tr>
   <tr>
      <th class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_deceased">Deceased</label></th>
      <td class="data">
      <input type="radio" name="select_deceased" id="select_deceased" value="form_deceased" <?php if (isset($select_deceased) && $select_deceased == "form_deceased") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="checkbox" name="form_deceased" id="form_deceased" value="1"<?php if (isset($form_deceased) && $form_deceased == 1) { echo ' CHECKED'; }?>>
      &nbsp;
      <b>Date</b> <input type="text" name="form_deceased_date" id="form_deceased_date" size="11" maxlength="10"<?php if (isset($form_deceased_date) && $form_deceased_date != '') { echo " value=\"$form_deceased_date\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_deceased" id="select_deceased" value="form_deceased2" <?php if (isset($select_deceased) && $select_deceased == "form_deceased2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="checkbox" name="form_deceased2" id="form_deceased2" value="1"<?php if (isset($form_deceased2) && $form_deceased2 == 1) { echo ' CHECKED'; }?>>
      &nbsp;
      <b>Date</b> <input type="text" name="form_deceased_date2" id="form_deceased_date2" size="11" maxlength="10"<?php if (isset($form_deceased_date2) && $form_deceased_date2 != '') { echo " value=\"$form_deceased_date2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Email</td>
      <td class="data">
      <input type="radio" name="select_email" id="select_email" value="form_email" <?php if (isset($select_email) && $select_email == "form_email") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" name="form_email" id="form_email" size="50" maxlength="100"<?php if (isset($form_email) && $form_email != '') { echo " value=\"$form_email\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_email" id="select_email" value="form_email2" <?php if (isset($select_email) && $select_email == "form_email2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" name="form_email2" id="form_email2" size="50" maxlength="100"<?php if (isset($form_email2) && $form_email2 != '') { echo " value=\"$form_email2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Alternate Email</td>
      <td class="data">
      <input type="radio" name="select_alternate_email" id="select_alternate_email" value="form_alternate_email" <?php if (isset($select_alternate_email) && $select_alternate_email == "form_alternate_email") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_alternate_email" id="form_alternate_email" size="50" maxlength="100"<?php if (isset($form_alternate_email) && $form_alternate_email != '') { echo " value=\"$form_alternate_email\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_alternate_email" id="select_alternate_email" value="form_alternate_email2" <?php if (isset($select_alternate_email) && $select_alternate_email == "form_alternate_email2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_alternate_email2" id="form_alternate_email2" size="50" maxlength="100"<?php if (isset($form_alternate_email2) && $form_alternate_email2 != '') { echo " value=\"$form_alternate_email2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Address Line 1</td>
      <td class="data">
      <input type="radio" name="select_address1" id="select_address1" value="form_address1" <?php if (isset($select_address1) && $select_address1 == "form_address1") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_address1" id="form_address1" size="50" maxlength="100"<?php if (isset($form_address1) && $form_address1 != '') { echo " value=\"$form_address1\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_address1" id="select_address1" value="form_address12" <?php if (isset($select_address1) && $select_address1 == "form_address12") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_address12" id="form_address12" size="50" maxlength="100"<?php if (isset($form_address12) && $form_address12 != '') { echo " value=\"$form_address12\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Address Line 2</td>
      <td class="data">
      <input type="radio" name="select_address2" id="select_address2" value="form_address2" <?php if (isset($select_address2) && $select_address2 == "form_address2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_address2" id="form_address2" size="50" maxlength="100"<?php if (isset($form_address2) && $form_address2 != '') { echo " value=\"$form_address2\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_address2" id="select_address2" value="form_address22" <?php if (isset($select_address2) && $select_address2 == "form_address22") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_address22" id="form_address22" size="50" maxlength="100"<?php if (isset($form_address22) && $form_address22 != '') { echo " value=\"$form_address22\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">City</td>
      <td class="data">
      <input type="radio" name="select_city" id="select_city" value="form_city" <?php if (isset($select_city) && $select_city == "form_city") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_city" id="form_city" size="50" maxlength="50"<?php if (isset($form_city) && $form_city != '') { echo " value=\"$form_city\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_city" id="select_city" value="form_city2" <?php if (isset($select_city) && $select_city == "form_city2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_city2" id="form_city2" size="50" maxlength="50"<?php if (isset($form_city2) && $form_city2 != '') { echo " value=\"$form_city2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">State</td>
      <td class="data">
      <input type="radio" name="select_state" id="select_state" value="form_state" <?php if (isset($select_state) && $select_state == "form_state") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_state" id="form_state" size="5" maxlength="2"<?php if (isset($form_state) && $form_state != '') { echo " value=\"$form_state\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_state" id="select_state" value="form_state2" <?php if (isset($select_state) && $select_state == "form_state2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_state2" id="form_state2" size="5" maxlength="2"<?php if (isset($form_state2) && $form_state2 != '') { echo " value=\"$form_state2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Zip</td>
      <td class="data">
      <input type="radio" name="select_zip" id="select_zip" value="form_zip" <?php if (isset($select_zip) && $select_zip == "form_zip") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_zip" id="form_zip" size="20" maxlength="10"<?php if (isset($form_zip) && $form_zip != '') { echo " value=\"$form_zip\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_zip" id="select_zip" value="form_zip2" <?php if (isset($select_zip) && $select_zip == "form_zip2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_zip2" id="form_zip2" size="20" maxlength="10"<?php if (isset($form_zip2) && $form_zip2 != '') { echo " value=\"$form_zip2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Country</td>
      <td class="data">
      <input type="radio" name="select_country" id="select_country" value="form_country" <?php if (isset($select_country) && $select_country == "form_country") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_country" id="form_country" size="50" maxlength="50"<?php if (isset($form_country) && $form_country != '') { echo " value=\"$form_country\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_country" id="select_country" value="form_country2" <?php if (isset($select_country) && $select_country == "form_country2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_country2" id="form_country2" size="50" maxlength="50"<?php if (isset($form_country2) && $form_country2 != '') { echo " value=\"$form_country2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Home Phone</td>
      <td class="data">
      <input type="radio" name="select_phone_home" id="select_phone_home" value="form_phone_home" <?php if (isset($select_phone_home) && $select_phone_home == "form_phone_home") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_phone_home" id="form_phone_home" size="30" maxlength="20"<?php if (isset($form_phone_home) && $form_phone_home != '') { echo " value=\"$form_phone_home\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_phone_home" id="select_phone_home" value="form_phone_home2" <?php if (isset($select_phone_home) && $select_phone_home == "form_phone_home2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_phone_home2" id="form_phone_home2" size="30" maxlength="20"<?php if (isset($form_phone_home2) && $form_phone_home2 != '') { echo " value=\"$form_phone_home2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Work Phone</td>
      <td class="data">
      <input type="radio" name="select_phone_work" id="select_phone_work" value="form_phone_work" <?php if (isset($select_phone_work) && $select_phone_work == "form_phone_work") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_phone_work" id="form_phone_work" size="30" maxlength="20"<?php if (isset($form_phone_work) && $form_phone_work != '') { echo " value=\"$form_phone_work\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_phone_work" id="select_phone_work" value="form_phone_work2" <?php if (isset($select_phone_work) && $select_phone_work == "form_phone_work2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_phone_work2" id="form_phone_work2" size="30" maxlength="20"<?php if (isset($form_phone_work2) && $form_phone_work2 != '') { echo " value=\"$form_phone_work2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Mobile Phone</td>
      <td class="data">
      <input type="radio" name="select_phone_mobile" id="select_phone_mobile" value="form_phone_mobile" <?php if (isset($select_phone_mobile) && $select_phone_mobile == "form_phone_mobile") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_phone_mobile" id="form_phone_mobile" size="30" maxlength="20"<?php if (isset($form_phone_mobile) && $form_phone_mobile != '') { echo " value=\"$form_phone_mobile\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_phone_mobile" id="select_phone_mobile" value="form_phone_mobile2" <?php if (isset($select_phone_mobile) && $select_phone_mobile == "form_phone_mobile2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_phone_mobile2" id="form_phone_mobile2" size="30" maxlength="20"<?php if (isset($form_phone_mobile2) && $form_phone_mobile2 != '') { echo " value=\"$form_phone_mobile2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Call Times</td>
      <td class="data">
      <input type="radio" name="select_call_times" id="select_call_times" value="form_call_times" <?php if (isset($select_call_times) && $select_call_times == "form_call_times") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_call_times" id="form_call_times" size="30" maxlength="20"<?php if (isset($form_call_times) && $form_call_times != '') { echo " value=\"$form_call_times\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_call_times" id="select_call_times" value="form_call_times2" <?php if (isset($select_call_times) && $select_call_times == "form_call_times2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_call_times2" id="form_call_times2" size="30" maxlength="20"<?php if (isset($form_call_times2) && $form_call_times2 != '') { echo " value=\"$form_call_times2\"";} ?>>
      </td>
   </tr>
   <tr>
      <th class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_publish_name">Publish Name</label></th>
      <td class="data">
      <input type="radio" name="select_publish_name" id="select_publish_name" value="form_publish_name" <?php if (isset($select_publish_name) && $select_publish_name == "form_publish_name") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_publish_name" id="form_publish_name" size="5" maxlength="1"<?php if (isset($form_publish_name) && $form_publish_name == 1) { echo " value=\"1\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_publish_name" id="select_publish_name" value="form_publish_name2" <?php if (isset($select_publish_name) && $select_publish_name == "form_publish_name2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_publish_name2" id="form_publish_name2" size="5" maxlength="1"<?php if (isset($form_publish_name2) && $form_publish_name2 == 1) { echo " value=\"1\"";} ?>>
      </td>
   </tr>
   <tr>
      <th class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_publish_address">Publish Address</label></th>
      <td class="data">
      <input type="radio" name="select_publish_address" id="select_publish_address" value="form_publish_address" <?php if (isset($select_publish_address) && $select_publish_address == "form_publish_address") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_publish_address" id="form_publish_address" size="5" maxlength="1"<?php if (isset($form_publish_address) && $form_publish_address == 1) { echo " value=\"1\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_publish_address" id="select_publish_address" value="form_publish_address2" <?php if (isset($select_publish_address) && $select_publish_address == "form_publish_address2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_publish_address2" id="form_publish_address2" size="5" maxlength="1"<?php if (isset($form_publish_address2) && $form_publish_address2 == 1) { echo " value=\"1\"";} ?>>
      </td>
   </tr>
   <tr>
      <th class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_publish_email">Publish Email</label></th>
      <td class="data">
      <input type="radio" name="select_publish_email" id="select_publish_email" value="form_publish_email" <?php if (isset($select_publish_email) && $select_publish_email == "form_publish_email") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_publish_email" id="form_publish_email" size="5" maxlength="1"<?php if (isset($form_publish_email) && $form_publish_email == 1) { echo " value=\"1\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_publish_email" id="select_publish_email" value="form_publish_email2" <?php if (isset($select_publish_email) && $select_publish_email == "form_publish_email2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_publish_email2" id="form_publish_email2" size="5" maxlength="1"<?php if (isset($form_publish_email2) && $form_publish_email2 == 1) { echo " value=\"1\"";} ?>>
      </td>
   </tr>
   <tr>
      <th class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_publish_alternate_email">Publish Alternate Email</label></th>
      <td class="data">
      <input type="radio" name="select_publish_alternate_email" id="select_publish_alternate_email" value="form_publish_alternate_email" <?php if (isset($select_publish_alternate_email) && $select_publish_alternate_email == "form_publish_alternate_email") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_publish_alternate_email" id="form_publish_alternate_email" size="5" maxlength="1"<?php if (isset($form_publish_alternate_email) && $form_publish_alternate_email == 1) { echo " value=\"1\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_publish_alternate_email" id="select_publish_alternate_email" value="form_publish_alternate_email2" <?php if (isset($select_publish_alternate_email) && $select_publish_alternate_email == "form_publish_alternate_email2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_publish_alternate_email2" id="form_publish_alternate_email2" size="5" maxlength="1"<?php if (isset($form_publish_alternate_email2) && $form_publish_alternate_email2 == 1) { echo " value=\"1\"";} ?>>
      </td>
   </tr>
   <tr>
      <th class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_publish_phone_home">Publish Home Phone</label></th>
      <td class="data">
      <input type="radio" name="select_publish_phone_home" id="select_publish_phone_home" value="form_publish_phone_home" <?php if (isset($select_publish_phone_home) && $select_publish_phone_home == "form_publish_phone_home") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_publish_phone_home" id="form_publish_phone_home" size="5" maxlength="1"<?php if (isset($form_publish_phone_home) && $form_publish_phone_home == 1) { echo " value=\"1\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_publish_phone_home" id="select_publish_phone_home" value="form_publish_phone_home2" <?php if (isset($select_publish_phone_home) && $select_publish_phone_home == "form_publish_phone_home2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_publish_phone_home2" id="form_publish_phone_home2" size="5" maxlength="1"<?php if (isset($form_publish_phone_home2) && $form_publish_phone_home2 == 1) { echo " value=\"1\"";} ?>>
      </td>
   </tr>
   <tr>
      <th class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_publish_phone_work">Publish Work Phone</label></th>
      <td class="data">
      <input type="radio" name="select_publish_phone_work" id="select_publish_phone_work" value="form_publish_phone_work" <?php if (isset($select_publish_phone_work) && $select_publish_phone_work == "form_publish_phone_work") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_publish_phone_work" id="form_publish_phone_work" size="5" maxlength="1"<?php if (isset($form_publish_phone_work) && $form_publish_phone_work == 1) { echo " value=\"1\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_publish_phone_work" id="select_publish_phone_work" value="form_publish_phone_work2" <?php if (isset($select_publish_phone_work) && $select_publish_phone_work == "form_publish_phone_work2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_publish_phone_work2" id="form_publish_phone_work2" size="5" maxlength="1"<?php if (isset($form_publish_phone_work2) && $form_publish_phone_work2 == 1) { echo " value=\"1\"";} ?>>
      </td>
   </tr>
   <tr>
      <th class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_publish_phone_mobile">Publish Mobile Phone</label></th>
      <td class="data">
      <input type="radio" name="select_publish_phone_mobile" id="select_publish_phone_mobile" value="form_publish_phone_mobile" <?php if (isset($select_publish_phone_mobile) && $select_publish_phone_mobile == "form_publish_phone_mobile") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_publish_phone_mobile" id="form_publish_phone_mobile" size="5" maxlength="1"<?php if (isset($form_publish_phone_mobile) && $form_publish_phone_mobile == 1) { echo " value=\"1\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_publish_phone_mobile" id="select_publish_phone_mobile" value="form_publish_phone_mobile2" <?php if (isset($select_publish_phone_mobile) && $select_publish_phone_mobile == "form_publish_phone_mobile2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_publish_phone_mobile2" id="form_publish_phone_mobile2" size="5" maxlength="1"<?php if (isset($form_publish_phone_mobile2) && $form_publish_phone_mobile2 == 1) { echo " value=\"1\"";} ?>>
      </td>
   </tr>
   <tr>
      <th class="title" colspan="3" bgcolor="<?php echo $TITLE_BG_COLOR; ?>">SCA Information</th>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">SCA Name</td>
      <td class="data">
      <input type="radio" name="select_sca_name" id="select_sca_name" value="form_sca_name" <?php if (isset($select_sca_name) && $select_sca_name == "form_sca_name") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" name="form_sca_name" id="form_sca_name" size="50" maxlength="255"<?php if (isset($form_sca_name) && $form_sca_name != '') { echo " value=\"$form_sca_name\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_sca_name" id="select_sca_name" value="form_sca_name2" <?php if (isset($select_sca_name) && $select_sca_name == "form_sca_name2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" name="form_sca_name2" id="form_sca_name2" size="50" maxlength="255"<?php if (isset($form_sca_name2) && $form_sca_name2 != '') { echo " value=\"$form_sca_name2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Preferred SCA Name</td>
      <td class="data">
      <input type="radio" name="select_preferred_sca_name" id="select_preferred_sca_name" value="form_preferred_sca_name" <?php if (isset($select_preferred_sca_name) && $select_preferred_sca_name == "form_preferred_sca_name") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" name="form_preferred_sca_name" id="form_preferred_sca_name" size="50" maxlength="255"<?php if (isset($form_preferred_sca_name) && $form_preferred_sca_name != '') { echo " value=\"$form_preferred_sca_name\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_preferred_sca_name" id="select_preferred_sca_name" value="form_preferred_sca_name2" <?php if (isset($select_preferred_sca_name) && $select_preferred_sca_name == "form_preferred_sca_name2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" name="form_preferred_sca_name2" id="form_preferred_sca_name2" size="50" maxlength="255"<?php if (isset($form_preferred_sca_name2) && $form_preferred_sca_name2 != '') { echo " value=\"$form_preferred_sca_name2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Branch</td>
      <td class="data">
      <input type="radio" name="select_branch_id" id="select_branch_id" value="form_branch_id" <?php if (isset($select_branch_id) && $select_branch_id == "form_branch_id") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <select name="form_branch_id" id="form_branch_id">
         <option></option>
         <?php
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
      <td class="data">
      <input type="radio" name="select_branch_id" id="select_branch_id" value="form_branch_id2" <?php if (isset($select_branch_id) && $select_branch_id == "form_branch_id2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <select name="form_branch_id2" id="form_branch_id2">
         <option></option>
         <?php
            for ($i = 0; $i < count($branch_data_array); $i++)
            {
               echo '<option value="' . $branch_data_array[$i]['branch_id'] . '"';
               if (isset($form_branch_id2) && $form_branch_id2 == $branch_data_array[$i]['branch_id'])
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
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Date Name Registered</td>
      <td class="data">
      <input type="radio" name="select_name_reg_date" id="select_name_reg_date" value="form_name_reg_date" <?php if (isset($select_name_reg_date) && $select_name_reg_date == "form_name_reg_date") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_name_reg_date" id="form_name_reg_date" size="15" maxlength="10"<?php if (isset($form_name_reg_date) && $form_name_reg_date != '') { echo " value=\"$form_name_reg_date\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_name_reg_date" id="select_name_reg_date" value="form_name_reg_date2" <?php if (isset($select_name_reg_date) && $select_name_reg_date == "form_name_reg_date2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_name_reg_date2" id="form_name_reg_date2" size="15" maxlength="10"<?php if (isset($form_name_reg_date2) && $form_name_reg_date2 != '') { echo " value=\"$form_name_reg_date2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Date Device Registered</td>
      <td class="data">
      <input type="radio" name="select_device_reg_date" id="select_device_reg_date" value="form_device_reg_date" <?php if (isset($select_device_reg_date) && $select_device_reg_date == "form_device_reg_date") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_device_reg_date" id="form_device_reg_date" size="15" maxlength="10"<?php if (isset($form_device_reg_date) && $form_device_reg_date != '') { echo " value=\"$form_device_reg_date\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_device_reg_date" id="select_device_reg_date" value="form_device_reg_date2" <?php if (isset($select_device_reg_date) && $select_device_reg_date == "form_device_reg_date2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_device_reg_date2" id="form_device_reg_date2" size="15" maxlength="10"<?php if (isset($form_device_reg_date2) && $form_device_reg_date2 != '') { echo " value=\"$form_device_reg_date2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Blazon</td>
      <td class="data">
      <input type="radio" name="select_blazon" id="select_blazon" value="form_blazon" <?php if (isset($select_blazon) && $select_blazon == "form_blazon") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_blazon" id="form_blazon" size="50" maxlength="65535"<?php if (isset($form_blazon) && $form_blazon != '') { echo " value=\"$form_blazon\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_blazon" id="select_blazon" value="form_blazon2" <?php if (isset($select_blazon) && $select_blazon == "form_blazon2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_blazon2" id="form_blazon2" size="50" maxlength="65535"<?php if (isset($form_blazon2) && $form_blazon2 != '') { echo " value=\"$form_blazon2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Alternate Names</td>
      <td class="data">
      <input type="radio" name="select_alternate_names" id="select_alternate_names" value="form_alternate_names" <?php if (isset($select_alternate_names) && $select_alternate_names == "form_alternate_names") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_alternate_names" id="form_alternate_names" size="50" maxlength="255"<?php if (isset($form_alternate_names) && $form_alternate_names != '') { echo " value=\"$form_alternate_names\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_alternate_names" id="select_alternate_names" value="form_alternate_names2" <?php if (isset($select_alternate_names) && $select_alternate_names == "form_alternate_names2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_alternate_names2" id="form_alternate_names2" size="50" maxlength="255"<?php if (isset($form_alternate_names2) && $form_alternate_names2 != '') { echo " value=\"$form_alternate_names2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Heraldic Rank</td>
      <td class="data">
      <input type="radio" name="select_heraldic_rank_id" id="select_heraldic_rank_id" value="form_heraldic_rank_id" <?php if (isset($select_heraldic_rank_id) && $select_heraldic_rank_id == "form_heraldic_rank_id") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="hidden" name="form_heraldic_rank_id" id="form_heraldic_rank_id"<?php if (isset($form_heraldic_rank_id) && $form_heraldic_rank_id != '') { echo " value=\"$form_heraldic_rank_id\"";} ?>>
      <input type="text" readonly="readonly" name="form_heraldic_rank" id="form_heraldic_rank" size="50" maxlength="50"<?php if (isset($form_heraldic_rank) && $form_heraldic_rank != '') { echo " value=\"$form_heraldic_rank\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_heraldic_rank_id" id="select_heraldic_rank_id" value="form_heraldic_rank_id2" <?php if (isset($select_heraldic_rank_id) && $select_heraldic_rank_id == "form_heraldic_rank_id2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="hidden" name="form_heraldic_rank_id2" id="form_heraldic_rank_id2"<?php if (isset($form_heraldic_rank_id2) && $form_heraldic_rank_id2 != '') { echo " value=\"$form_heraldic_rank_id2\"";} ?>>
      <input type="text" readonly="readonly" name="form_heraldic_rank2" id="form_heraldic_rank2" size="50" maxlength="50"<?php if (isset($form_heraldic_rank2) && $form_heraldic_rank2 != '') { echo " value=\"$form_heraldic_rank2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Heraldic Title</td>
      <td class="data">
      <input type="radio" name="select_heraldic_title" id="select_heraldic_title" value="form_heraldic_title" <?php if (isset($select_heraldic_title) && $select_heraldic_title == "form_heraldic_title") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_heraldic_title" id="form_heraldic_title" size="50" maxlength="255"<?php if (isset($form_heraldic_title) && $form_heraldic_title != '') { echo " value=\"$form_heraldic_title\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_heraldic_title" id="select_heraldic_title" value="form_heraldic_title2" <?php if (isset($select_heraldic_title) && $select_heraldic_title == "form_heraldic_title2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_heraldic_title2" id="form_heraldic_title2" size="50" maxlength="255"<?php if (isset($form_heraldic_title2) && $form_heraldic_title2 != '') { echo " value=\"$form_heraldic_title2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Heraldic Interests</td>
      <td class="data">
      <input type="radio" name="select_heraldic_interests" id="select_heraldic_interests" value="form_heraldic_interests" <?php if (isset($select_heraldic_interests) && $select_heraldic_interests == "form_heraldic_interests") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_heraldic_interests" id="form_heraldic_interests" size="50" maxlength="255"<?php if (isset($form_heraldic_interests) && $form_heraldic_interests != '') { echo " value=\"$form_heraldic_interests\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_heraldic_interests" id="select_heraldic_interests" value="form_heraldic_interests2" <?php if (isset($select_heraldic_interests) && $select_heraldic_interests == "form_heraldic_interests2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_heraldic_interests2" id="form_heraldic_interests2" size="50" maxlength="255"<?php if (isset($form_heraldic_interests2) && $form_heraldic_interests2 != '') { echo " value=\"$form_heraldic_interests2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Website</td>
      <td class="data">
      <input type="radio" name="select_website" id="select_website" value="form_website" <?php if (isset($select_website) && $select_website == "form_website") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_website" id="form_website" size="50" maxlength="100"<?php if (isset($form_website) && $form_website != '') { echo " value=\"$form_website\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_website" id="select_website" value="form_website2" <?php if (isset($select_website) && $select_website == "form_website2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_website2" id="form_website2" size="50" maxlength="100"<?php if (isset($form_website2) && $form_website2 != '') { echo " value=\"$form_website2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Biography</td>
      <td class="data">
      <input type="radio" name="select_biography" id="select_biography" value="form_biography" <?php if (isset($select_biography) && $select_biography == "form_biography") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <textarea readonly="readonly" name="form_biography" id="form_biography" rows="5" cols="50"><?php if (isset($form_biography) && $form_biography != '') { echo $form_biography; } ?></textarea>
      </td>
      <td class="data">
      <input type="radio" name="select_biography" id="select_biography" value="form_biography2" <?php if (isset($select_biography) && $select_biography == "form_biography2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <textarea readonly="readonly" name="form_biography" id="form_biography" rows="5" cols="50"><?php if (isset($form_biography2) && $form_biography2 != '') { echo $form_biography2; } ?></textarea>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Membership Number</td>
      <td class="data">
      <input type="radio" name="select_membership_number" id="select_membership_number" value="form_membership_number" <?php if (isset($select_membership_number) && $select_membership_number == "form_membership_number") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_membership_number" id="form_membership_number" size="20" maxlength="10"<?php if (isset($form_membership_number) && $form_membership_number != '') { echo " value=\"$form_membership_number\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_membership_number" id="select_membership_number" value="form_membership_number2" <?php if (isset($select_membership_number) && $select_membership_number == "form_membership_number2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_membership_number2" id="form_membership_number2" size="20" maxlength="10"<?php if (isset($form_membership_number2) && $form_membership_number2 != '') { echo " value=\"$form_membership_number2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Expiration Date</td>
      <td class="data">
      <input type="radio" name="select_expiration_date" id="select_expiration_date" value="form_expiration_date" <?php if (isset($select_expiration_date) && $select_expiration_date == "form_expiration_date") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_expiration_date" id="form_expiration_date" size="15" maxlength="10"<?php if (isset($form_expiration_date) && $form_expiration_date != '') { echo " value=\"$form_expiration_date\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_expiration_date" id="select_expiration_date" value="form_expiration_date2" <?php if (isset($select_expiration_date) && $select_expiration_date == "form_expiration_date2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_expiration_date2" id="form_expiration_date2" size="15" maxlength="10"<?php if (isset($form_expiration_date2) && $form_expiration_date2 != '') { echo " value=\"$form_expiration_date2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Pending Expiration Date</td>
      <td class="data">
      <input type="radio" name="select_expiration_date_pending" id="select_expiration_date_pending" value="form_expiration_date_pending" <?php if (isset($select_expiration_date_pending) && $select_expiration_date_pending == "form_expiration_date_pending") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_expiration_date_pending" id="form_expiration_date_pending" size="15" maxlength="10"<?php if (isset($form_expiration_date_pending) && $form_expiration_date_pending != '') { echo " value=\"$form_expiration_date_pending\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_expiration_date_pending" id="select_expiration_date_pending" value="form_expiration_date_pending2" <?php if (isset($select_expiration_date_pending) && $select_expiration_date_pending == "form_expiration_date_pending2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_expiration_date_pending2" id="form_expiration_date_pending2" size="15" maxlength="10"<?php if (isset($form_expiration_date_pending2) && $form_expiration_date_pending2 != '') { echo " value=\"$form_expiration_date_pending2\"";} ?>>
      </td>
   </tr>
   <tr>
      <th class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_background_check_result">Background Check</label></th>
      <td class="data">
      <input type="radio" name="select_background_check" id="select_background_check" value="form_background_check_result" <?php if (isset($select_background_check) && $select_background_check == "form_background_check_result") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_background_check_result" id="form_background_check_result" size="3" maxlength="1"<?php if (isset($form_background_check_result) && $form_background_check_result == 1) { echo " value=\"1\"";} ?>>
      &nbsp;
      <b>Date</b> <input type="text" readonly="readonly" name="form_background_check_date" id="form_background_check_date" size="11" maxlength="10"<?php if (isset($form_background_check_date) && $form_background_check_date != '') { echo " value=\"$form_background_check_date\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_background_check" id="select_background_check" value="form_background_check_result2" <?php if (isset($select_background_check) && $select_background_check == "form_background_check_result2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_background_check_result2" id="form_background_check_result2" size="3" maxlength="1"<?php if (isset($form_background_check_result2) && $form_background_check_result2 == 1) { echo " value=\"1\"";} ?>>
      &nbsp;
      <b>Date</b> <input type="text" readonly="readonly" name="form_background_check_date2" id="form_background_check_date2" size="11" maxlength="10"<?php if (isset($form_background_check_date2) && $form_background_check_date2 != '') { echo " value=\"$form_background_check_date2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <th class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_inactive">Inactive</label></th>
      <td class="data">
      <input type="radio" name="select_inactive" id="select_inactive" value="form_inactive" <?php if (isset($select_inactive) && $select_inactive == "form_inactive") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="checkbox" name="form_inactive" id="form_inactive" value="1"<?php if (isset($form_inactive) && $form_inactive == 1) { echo ' CHECKED'; }?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_inactive" id="select_inactive" value="form_inactive2" <?php if (isset($select_inactive) && $select_inactive == "form_inactive2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="checkbox" name="form_inactive2" id="form_inactive2" value="1"<?php if (isset($form_inactive2) && $form_inactive2 == 1) { echo ' CHECKED'; }?>/>
      </td>
   </tr>
   <tr>
      <th class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_revoked">Revoked and Denied</label></th>
      <td class="data">
      <input type="radio" name="select_revoked" id="select_revoked" value="form_revoked" <?php if (isset($select_revoked) && $select_revoked == "form_revoked") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="checkbox" name="form_revoked" id="form_revoked" value="1"<?php if (isset($form_revoked) && $form_revoked == 1) { echo ' CHECKED'; }?>/>
      &nbsp;
      <b>Date</b> <input type="text" readonly="readonly" name="form_revoked_date" id="form_revoked_date" size="11" maxlength="10"<?php if (isset($form_revoked_date) && $form_revoked_date != '') { echo " value=\"$form_revoked_date\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_revoked" id="select_revoked" value="form_revoked2" <?php if (isset($select_revoked) && $select_revoked == "form_revoked2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="checkbox" name="form_revoked2" id="form_revoked2" value="1"<?php if (isset($form_revoked2) && $form_revoked2 == 1) { echo ' CHECKED'; }?>/>
      &nbsp;
      <b>Date</b> <input type="text" readonly="readonly" name="form_revoked_date2" id="form_revoked_date2" size="11" maxlength="10"<?php if (isset($form_revoked_date2) && $form_revoked_date2 != '') { echo " value=\"$form_revoked_date2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <th class="title" colspan="3" bgcolor="<?php echo $TITLE_BG_COLOR; ?>">System Information</th>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Device File Name</td>
      <td class="data">
      <input type="radio" name="select_device_file_name" id="select_device_file_name" value="form_device_file_name" <?php if (isset($select_device_file_name) && $select_device_file_name == "form_device_file_name") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_device_file_name" id="form_device_file_name" size="50" maxlength="255"<?php if (isset($form_device_file_name) && $form_device_file_name != '') { echo " value=\"$form_device_file_name\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_device_file_name" id="select_device_file_name" value="form_device_file_name2" <?php if (isset($select_device_file_name) && $select_device_file_name == "form_device_file_name2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_device_file_name2" id="form_device_file_name2" size="50" maxlength="255"<?php if (isset($form_device_file_name2) && $form_device_file_name2 != '') { echo " value=\"$form_device_file_name2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Device File Credit</td>
      <td class="data">
      <input type="radio" name="select_device_file_credit" id="select_device_file_credit" value="form_device_file_credit" <?php if (isset($select_device_file_credit) && $select_device_file_credit == "form_device_file_credit") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_device_file_credit" id="form_device_file_credit" size="50" maxlength="255"<?php if (isset($form_device_file_credit) && $form_device_file_credit != '') { echo " value=\"$form_device_file_credit\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_device_file_credit" id="select_device_file_credit" value="form_device_file_credit2" <?php if (isset($select_device_file_credit) && $select_device_file_credit == "form_device_file_credit2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_device_file_credit2" id="form_device_file_credit2" size="50" maxlength="255"<?php if (isset($form_device_file_credit2) && $form_device_file_credit2 != '') { echo " value=\"$form_device_file_credit2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Picture File Name</td>
      <td class="data">
      <input type="radio" name="select_picture_file_name" id="select_picture_file_name" value="form_picture_file_name" <?php if (isset($select_picture_file_name) && $select_picture_file_name == "form_picture_file_name") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_picture_file_name" id="form_picture_file_name" size="50" maxlength="255"<?php if (isset($form_picture_file_name) && $form_picture_file_name != '') { echo " value=\"$form_picture_file_name\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_picture_file_name" id="select_picture_file_name" value="form_picture_file_name2" <?php if (isset($select_picture_file_name) && $select_picture_file_name == "form_picture_file_name2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_picture_file_name2" id="form_picture_file_name2" size="50" maxlength="255"<?php if (isset($form_picture_file_name2) && $form_picture_file_name2 != '') { echo " value=\"$form_picture_file_name2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Picture File Credit</td>
      <td class="data">
      <input type="radio" name="select_picture_file_credit" id="select_picture_file_credit" value="form_picture_file_credit" <?php if (isset($select_picture_file_credit) && $select_picture_file_credit == "form_picture_file_credit") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_picture_file_credit" id="form_picture_file_credit" size="50" maxlength="255"<?php if (isset($form_picture_file_credit) && $form_picture_file_credit != '') { echo " value=\"$form_picture_file_credit\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_picture_file_credit" id="select_picture_file_credit" value="form_picture_file_credit2" <?php if (isset($select_picture_file_credit) && $select_picture_file_credit == "form_picture_file_credit2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_picture_file_credit2" id="form_picture_file_credit2" size="50" maxlength="255"<?php if (isset($form_picture_file_credit2) && $form_picture_file_credit2 != '') { echo " value=\"$form_picture_file_credit2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">OP Notes</td>
      <td class="data">
      <input type="radio" name="select_op_notes" id="select_op_notes" value="form_op_notes" <?php if (isset($select_op_notes) && $select_op_notes == "form_op_notes") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_op_notes" id="form_op_notes" size="50" maxlength="65535"<?php if (isset($form_op_notes) && $form_op_notes != '') { echo " value=\"$form_op_notes\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_op_notes" id="select_op_notes" value="form_op_notes2" <?php if (isset($select_op_notes) && $select_op_notes == "form_op_notes2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_op_notes2" id="form_op_notes2" size="50" maxlength="65535"<?php if (isset($form_op_notes2) && $form_op_notes2 != '') { echo " value=\"$form_op_notes2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Date Created</td>
      <td class="data">
      <input type="radio" name="select_date_created" id="select_date_created" value="form_date_created" <?php if (isset($select_date_created) && $select_date_created == "form_date_created") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_date_created" id="form_date_created" size="15" maxlength="10"<?php if (isset($form_date_created) && $form_date_created != '') { echo " value=\"$form_date_created\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_date_created" id="select_date_created" value="form_date_created2" <?php if (isset($select_date_created) && $select_date_created == "form_date_created2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_date_created2" id="form_date_created2" size="15" maxlength="10"<?php if (isset($form_date_created2) && $form_date_created2 != '') { echo " value=\"$form_date_created2\"";} ?>>
      </td>
   </tr>
</table>
<?php
      } // Atlantian selection
      // Only one Atlantian option
      else if (!$no_atlantian)
      {
         if (isset($atlantian_id) && $atlantian_id > 0)
         {
?>
   <input type="hidden" name="atlantian_id" id="atlantian_id" value="<?php echo $atlantian_id; ?>"/>
<?php 
         }
?>
<p align="center" class="title2">Atlantian Information</p>
<table align="center" cellpadding="5" cellspacing="0" border="1">
   <tr>
      <th class="title" colspan="2" bgcolor="<?php echo $TITLE_BG_COLOR; ?>">Atlantian Information</th>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Atlantian ID</td>
      <td class="data"><input type="radio" name="select_atlantian_id" id="select_atlantian_id" onclick="javascript:selectOneAtlantian(1);" value="<?php echo $atlantian_id; ?>" />Select All for Atlantian ID <?php echo $atlantian_id; ?></td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">First Name</td>
      <td class="data">
      <input type="radio" name="select_first_name" id="select_first_name" value="form_first_name" <?php if (isset($select_first_name) && $select_first_name == "form_first_name") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" name="form_first_name" id="form_first_name" size="20" maxlength="50"<?php if (isset($form_first_name) && $form_first_name != '') { echo " value=\"$form_first_name\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Last Name</td>
      <td class="data">
      <input type="radio" name="select_last_name" id="select_last_name" value="form_last_name" <?php if (isset($select_last_name) && $select_last_name == "form_last_name") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" name="form_last_name" id="form_last_name" size="30" maxlength="50"<?php if (isset($form_last_name) && $form_last_name != '') { echo " value=\"$form_last_name\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Email</td>
      <td class="data">
      <input type="radio" name="select_email" id="select_email" value="form_email" <?php if (isset($select_email) && $select_email == "form_email") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" name="form_email" id="form_email" size="50" maxlength="100"<?php if (isset($form_email) && $form_email != '') { echo " value=\"$form_email\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Preferred SCA Name</td>
      <td class="data">
      <input type="radio" name="select_preferred_sca_name" id="select_preferred_sca_name" value="form_preferred_sca_name" <?php if (isset($select_preferred_sca_name) && $select_preferred_sca_name == "form_preferred_sca_name") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" name="form_preferred_sca_name" id="form_preferred_sca_name" size="50" maxlength="255"<?php if (isset($form_preferred_sca_name) && $form_preferred_sca_name != '') { echo " value=\"$form_preferred_sca_name\"";} ?>>
      </td>
   </tr>
</table>
<?php
      } // Atlantian selection - one

      // There are two Participant records to choose from
      if ($participant_selection)
      {
?>
<p align="center" class="title2">Participant Information</p>
<table align="center" cellpadding="5" cellspacing="0" border="1">
   <tr>
      <th class="title" colspan="3" bgcolor="<?php echo $TITLE_BG_COLOR; ?>">Participant Information</th>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Participant ID</td>
      <td class="data"><input type="radio" name="select_participant_id" id="select_participant_id" onclick="javascript:selectAllParticipant(1);" value="<?php echo $first_participant_id; ?>" />Select All for Participant ID <?php echo $first_participant_id; ?></td>
      <td class="data"><input type="radio" name="select_participant_id" id="select_participant_id" onclick="javascript:selectAllParticipant(2);" value="<?php echo $second_participant_id; ?>" />Select All for Participant ID <?php echo $second_participant_id; ?></td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">SCA Name</td>
      <td class="data">
      <input type="radio" name="select_preferred_sca_name" id="select_preferred_sca_name" value="form_p_sca_name" <?php if (isset($select_preferred_sca_name) && $select_preferred_sca_name == "form_p_sca_name") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" name="form_p_sca_name" id="form_p_sca_name" size="50" maxlength="255"<?php if (isset($form_p_sca_name) && $form_p_sca_name != '') { echo " value=\"$form_p_sca_name\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_preferred_sca_name" id="select_preferred_sca_name" value="form_p_sca_name2" <?php if (isset($select_preferred_sca_name) && $select_preferred_sca_name == "form_p_sca_name2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" name="form_p_sca_name2" id="form_p_sca_name2" size="50" maxlength="255"<?php if (isset($form_p_sca_name2) && $form_p_sca_name2 != '') { echo " value=\"$form_p_sca_name2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Date Created</td>
      <td class="data">
      <input type="radio" name="select_p_date_created" id="select_p_date_created" value="form_p_date_created" <?php if (isset($select_p_date_created) && $select_p_date_created == "form_p_date_created") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_p_date_created" id="form_p_date_created" size="15" maxlength="10"<?php if (isset($form_p_date_created) && $form_p_date_created != '') { echo " value=\"$form_p_date_created\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_p_date_created" id="select_p_date_created" value="form_p_date_created2" <?php if (isset($select_p_date_created) && $select_p_date_created == "form_p_date_created2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_p_date_created2" id="form_p_date_created2" size="15" maxlength="10"<?php if (isset($form_p_date_created2) && $form_p_date_created2 != '') { echo " value=\"$form_p_date_created2\"";} ?>>
      </td>
   </tr>
   <tr>
      <th class="title" colspan="3" bgcolor="<?php echo $TITLE_BG_COLOR; ?>">Degree Information</th>
   </tr>
   <tr>
      <th class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Degree</th>
      <th class="titleleft" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_b_old_university_id"><label for="form_b_university_id"><label for="form_f_university_id"><label for="form_m_university_id"><label for="form_d_university_id">University Session</label></label></label></label></label>&nbsp;/&nbsp;<label for="form_b_old_degree_status_id"><label for="form_b_degree_status_id"><label for="form_f_degree_status_id"><label for="form_m_degree_status_id"><label for="form_d_degree_status_id">Degree Status</label></label></label></label></label></th>
      <th class="titleleft" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>"><label for="form_b_old_university_id2"><label for="form_b_university_id2"><label for="form_f_university_id2"><label for="form_m_university_id2"><label for="form_d_university_id2">University Session</label></label></label></label></label>&nbsp;/&nbsp;<label for="form_b_old_degree_status_id2"><label for="form_b_degree_status_id2"><label for="form_f_degree_status_id2"><label for="form_m_degree_status_id2"><label for="form_d_degree_status_id2">Degree Status</label></label></label></label></label></th>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Old Bachelors</td>
      <td class="data">
      <input type="radio" name="select_b_old_university_id" id="select_b_old_university_id" value="form_b_old_university_id" <?php if (isset($select_b_old_university_id) && $select_b_old_university_id == "form_b_old_university_id") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <select name="form_b_old_university_id" id="form_b_old_university_id">
         <option></option>
<?php
         for ($i = 0; $i < count($university_data_array); $i++)
         {
            echo '<option id="' . $university_data_array[$i]['university_code'] . '" value="' . $university_data_array[$i]['university_id'] . '"';
            if (isset($form_b_old_university_id) && $form_b_old_university_id == $university_data_array[$i]['university_id'])
            {
               echo ' selected';
            }
            echo '>' . $university_data_array[$i]['university_code'] . '</option>';
         }
?>
      </select>
      &nbsp;&nbsp;&nbsp;&nbsp;
      <select name="form_b_old_degree_status_id" id="form_b_old_degree_status_id">
         <option></option>
<?php
         for ($i = 0; $i < count($degree_status_data_array); $i++)
         {
            echo '<option id="' . $degree_status_data_array[$i]['degree_status'] . '" value="' . $degree_status_data_array[$i]['degree_status_id'] . '"';
            if (isset($form_b_old_degree_status_id) && $form_b_old_degree_status_id == $degree_status_data_array[$i]['degree_status_id'])
            {
               echo ' selected';
            }
            echo '>' . $degree_status_data_array[$i]['degree_status'] . '</option>';
         }
?>
      </select>
      </td>
      <td class="data">
      <input type="radio" name="select_b_old_university_id" id="select_b_old_university_id" value="form_b_old_university_id2" <?php if (isset($select_b_old_university_id) && $select_b_old_university_id == "form_b_old_university_id2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <select name="form_b_old_university_id2" id="form_b_old_university_id2">
         <option></option>
<?php
         for ($i = 0; $i < count($university_data_array); $i++)
         {
            echo '<option id="' . $university_data_array[$i]['university_code'] . '" value="' . $university_data_array[$i]['university_id'] . '"';
            if (isset($form_b_old_university_id2) && $form_b_old_university_id2 == $university_data_array[$i]['university_id'])
            {
               echo ' selected';
            }
            echo '>' . $university_data_array[$i]['university_code'] . '</option>';
         }
?>
      </select>
      &nbsp;&nbsp;&nbsp;&nbsp;
      <select name="form_b_old_degree_status_id2" id="form_b_old_degree_status_id2">
         <option></option>
<?php
         for ($i = 0; $i < count($degree_status_data_array); $i++)
         {
            echo '<option id="' . $degree_status_data_array[$i]['degree_status'] . '" value="' . $degree_status_data_array[$i]['degree_status_id'] . '"';
            if (isset($form_b_old_degree_status_id2) && $form_b_old_degree_status_id2 == $degree_status_data_array[$i]['degree_status_id'])
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
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Bachelors</td>
      <td class="data">
      <input type="radio" name="select_b_university_id" id="select_b_university_id" value="form_b_university_id" <?php if (isset($select_b_university_id) && $select_b_university_id == "form_b_university_id") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <select name="form_b_university_id" id="form_b_university_id">
         <option></option>
<?php
         for ($i = 0; $i < count($university_data_array); $i++)
         {
            echo '<option id="' . $university_data_array[$i]['university_code'] . '" value="' . $university_data_array[$i]['university_id'] . '"';
            if (isset($form_b_university_id) && $form_b_university_id == $university_data_array[$i]['university_id'])
            {
               echo ' selected';
            }
            echo '>' . $university_data_array[$i]['university_code'] . '</option>';
         }
?>
      </select>
      &nbsp;&nbsp;&nbsp;&nbsp;
      <select name="form_b_degree_status_id" id="form_b_degree_status_id">
         <option></option>
<?php
         for ($i = 0; $i < count($degree_status_data_array); $i++)
         {
            echo '<option id="' . $degree_status_data_array[$i]['degree_status'] . '" value="' . $degree_status_data_array[$i]['degree_status_id'] . '"';
            if (isset($form_b_degree_status_id) && $form_b_degree_status_id == $degree_status_data_array[$i]['degree_status_id'])
            {
               echo ' selected';
            }
            echo '>' . $degree_status_data_array[$i]['degree_status'] . '</option>';
         }
?>
      </select>
      </td>
      <td class="data">
      <input type="radio" name="select_b_university_id" id="select_b_university_id" value="form_b_university_id2" <?php if (isset($select_b_university_id) && $select_b_university_id == "form_b_university_id2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <select name="form_b_university_id2" id="form_b_university_id2">
         <option></option>
<?php
         for ($i = 0; $i < count($university_data_array); $i++)
         {
            echo '<option id="' . $university_data_array[$i]['university_code'] . '" value="' . $university_data_array[$i]['university_id'] . '"';
            if (isset($form_b_university_id2) && $form_b_university_id2 == $university_data_array[$i]['university_id'])
            {
               echo ' selected';
            }
            echo '>' . $university_data_array[$i]['university_code'] . '</option>';
         }
?>
      </select>
      &nbsp;&nbsp;&nbsp;&nbsp;
      <select name="form_b_degree_status_id2" id="form_b_degree_status_id2">
         <option></option>
<?php
         for ($i = 0; $i < count($degree_status_data_array); $i++)
         {
            echo '<option id="' . $degree_status_data_array[$i]['degree_status'] . '" value="' . $degree_status_data_array[$i]['degree_status_id'] . '"';
            if (isset($form_b_degree_status_id2) && $form_b_degree_status_id2 == $degree_status_data_array[$i]['degree_status_id'])
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
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Fellowship</td>
      <td class="data">
      <input type="radio" name="select_f_university_id" id="select_f_university_id" value="form_f_university_id" <?php if (isset($select_f_university_id) && $select_f_university_id == "form_f_university_id") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <select name="form_f_university_id" id="form_f_university_id">
         <option></option>
<?php
         for ($i = 0; $i < count($university_data_array); $i++)
         {
            echo '<option id="' . $university_data_array[$i]['university_code'] . '" value="' . $university_data_array[$i]['university_id'] . '"';
            if (isset($form_f_university_id) && $form_f_university_id == $university_data_array[$i]['university_id'])
            {
               echo ' selected';
            }
            echo '>' . $university_data_array[$i]['university_code'] . '</option>';
         }
?>
      </select>
      &nbsp;&nbsp;&nbsp;&nbsp;
      <select name="form_f_degree_status_id" id="form_f_degree_status_id">
         <option></option>
<?php
         for ($i = 0; $i < count($degree_status_data_array); $i++)
         {
            echo '<option id="' . $degree_status_data_array[$i]['degree_status'] . '" value="' . $degree_status_data_array[$i]['degree_status_id'] . '"';
            if (isset($form_f_degree_status_id) && $form_f_degree_status_id == $degree_status_data_array[$i]['degree_status_id'])
            {
               echo ' selected';
            }
            echo '>' . $degree_status_data_array[$i]['degree_status'] . '</option>';
         }
?>
      </select>
      </td>
      <td class="data">
      <input type="radio" name="select_f_university_id" id="select_f_university_id" value="form_f_university_id2" <?php if (isset($select_f_university_id) && $select_f_university_id == "form_f_university_id2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <select name="form_f_university_id2" id="form_f_university_id2">
         <option></option>
<?php
         for ($i = 0; $i < count($university_data_array); $i++)
         {
            echo '<option id="' . $university_data_array[$i]['university_code'] . '" value="' . $university_data_array[$i]['university_id'] . '"';
            if (isset($form_f_university_id2) && $form_f_university_id2 == $university_data_array[$i]['university_id'])
            {
               echo ' selected';
            }
            echo '>' . $university_data_array[$i]['university_code'] . '</option>';
         }
?>
      </select>
      &nbsp;&nbsp;&nbsp;&nbsp;
      <select name="form_f_degree_status_id2" id="form_f_degree_status_id2">
         <option></option>
<?php
         for ($i = 0; $i < count($degree_status_data_array); $i++)
         {
            echo '<option id="' . $degree_status_data_array[$i]['degree_status'] . '" value="' . $degree_status_data_array[$i]['degree_status_id'] . '"';
            if (isset($form_f_degree_status_id2) && $form_f_degree_status_id2 == $degree_status_data_array[$i]['degree_status_id'])
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
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Masters</td>
      <td class="data">
      <input type="radio" name="select_m_university_id" id="select_m_university_id" value="form_m_university_id" <?php if (isset($select_m_university_id) && $select_m_university_id == "form_m_university_id") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <select name="form_m_university_id" id="form_m_university_id">
         <option></option>
<?php
         for ($i = 0; $i < count($university_data_array); $i++)
         {
            echo '<option id="' . $university_data_array[$i]['university_code'] . '" value="' . $university_data_array[$i]['university_id'] . '"';
            if (isset($form_m_university_id) && $form_m_university_id == $university_data_array[$i]['university_id'])
            {
               echo ' selected';
            }
            echo '>' . $university_data_array[$i]['university_code'] . '</option>';
         }
?>
      </select>
      &nbsp;&nbsp;&nbsp;&nbsp;
      <select name="form_m_degree_status_id" id="form_m_degree_status_id">
         <option></option>
<?php
         for ($i = 0; $i < count($degree_status_data_array); $i++)
         {
            echo '<option id="' . $degree_status_data_array[$i]['degree_status'] . '" value="' . $degree_status_data_array[$i]['degree_status_id'] . '"';
            if (isset($form_m_degree_status_id) && $form_m_degree_status_id == $degree_status_data_array[$i]['degree_status_id'])
            {
               echo ' selected';
            }
            echo '>' . $degree_status_data_array[$i]['degree_status'] . '</option>';
         }
?>
      </select>
      </td>
      <td class="data">
      <input type="radio" name="select_m_university_id" id="select_m_university_id" value="form_m_university_id2" <?php if (isset($select_m_university_id) && $select_m_university_id == "form_m_university_id2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <select name="form_m_university_id2" id="form_m_university_id2">
         <option></option>
<?php
         for ($i = 0; $i < count($university_data_array); $i++)
         {
            echo '<option id="' . $university_data_array[$i]['university_code'] . '" value="' . $university_data_array[$i]['university_id'] . '"';
            if (isset($form_m_university_id2) && $form_m_university_id2 == $university_data_array[$i]['university_id'])
            {
               echo ' selected';
            }
            echo '>' . $university_data_array[$i]['university_code'] . '</option>';
         }
?>
      </select>
      &nbsp;&nbsp;&nbsp;&nbsp;
      <select name="form_m_degree_status_id2" id="form_m_degree_status_id2">
         <option></option>
<?php
         for ($i = 0; $i < count($degree_status_data_array); $i++)
         {
            echo '<option id="' . $degree_status_data_array[$i]['degree_status'] . '" value="' . $degree_status_data_array[$i]['degree_status_id'] . '"';
            if (isset($form_m_degree_status_id2) && $form_m_degree_status_id2 == $degree_status_data_array[$i]['degree_status_id'])
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
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Doctorate</td>
      <td class="data">
      <input type="radio" name="select_d_university_id" id="select_d_university_id" value="form_d_university_id" <?php if (isset($select_d_university_id) && $select_d_university_id == "form_d_university_id") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
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
      &nbsp;&nbsp;&nbsp;&nbsp;
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
      <td class="data">
      <input type="radio" name="select_d_university_id" id="select_d_university_id" value="form_d_university_id2" <?php if (isset($select_d_university_id) && $select_d_university_id == "form_d_university_id2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <select name="form_d_university_id2" id="form_d_university_id2">
         <option></option>
<?php
         for ($i = 0; $i < count($university_data_array); $i++)
         {
            echo '<option id="' . $university_data_array[$i]['university_code'] . '" value="' . $university_data_array[$i]['university_id'] . '"';
            if (isset($form_d_university_id2) && $form_d_university_id2 == $university_data_array[$i]['university_id'])
            {
               echo ' selected';
            }
            echo '>' . $university_data_array[$i]['university_code'] . '</option>';
         }
?>
      </select>
      &nbsp;&nbsp;&nbsp;&nbsp;
      <select name="form_d_degree_status_id2" id="form_d_degree_status_id2">
         <option></option>
<?php
         for ($i = 0; $i < count($degree_status_data_array); $i++)
         {
            echo '<option id="' . $degree_status_data_array[$i]['degree_status'] . '" value="' . $degree_status_data_array[$i]['degree_status_id'] . '"';
            if (isset($form_d_degree_status_id2) && $form_d_degree_status_id2 == $degree_status_data_array[$i]['degree_status_id'])
            {
               echo ' selected';
            }
            echo '>' . $degree_status_data_array[$i]['degree_status'] . '</option>';
         }
?>
      </select>
      </td>
   </tr>
</table>
<?php
      } // participant selection
      // Only one Participant option
      else
      {
         if (isset($participant_id) && $participant_id > 0)
         {
?>
   <input type="hidden" name="participant_id" id="participant_id" value="<?php echo $participant_id; ?>"/>
<?php 
         }
?>
<p align="center" class="title2">Participant Information</p>
<table align="center" cellpadding="5" cellspacing="0" border="1">
   <tr>
      <th class="title" colspan="2" bgcolor="<?php echo $TITLE_BG_COLOR; ?>">Participant Information</th>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Participant ID</td>
      <td class="data"><input type="radio" name="select_participant_id" id="select_participant_id" onclick="javascript:selectOneParticipant(1);" value="<?php echo $participant_id; ?>" />Select All for Participant ID <?php echo $participant_id; ?></td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">SCA Name</td>
      <td class="data">
      <input type="radio" name="select_preferred_sca_name" id="select_preferred_sca_name" value="form_p_sca_name" <?php if (isset($select_preferred_sca_name) && $select_preferred_sca_name == "form_p_sca_name") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" name="form_p_sca_name" id="form_p_sca_name" size="50" maxlength="255"<?php if (isset($form_p_sca_name) && $form_p_sca_name != '') { echo " value=\"$form_p_sca_name\"";} ?>/>
      </td>
   </tr>
</table>
<?php
      } // Participant selection - one

      // There are two User records to choose from
      if ($user_selection)
      {
?>
<p align="center" class="title2">User Account Information</p>
<table align="center" cellpadding="5" cellspacing="0" border="1">
   <tr>
      <th class="title" colspan="3" bgcolor="<?php echo $TITLE_BG_COLOR; ?>">User Account Information</th>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">User ID</td>
      <td class="data"><input type="radio" name="select_user_id" id="select_user_id" onclick="javascript:selectAllUser(1);" value="<?php echo $first_user_id; ?>" />Select All for User Account ID <?php echo $first_user_id; ?></td>
      <td class="data"><input type="radio" name="select_user_id" id="select_user_id" onclick="javascript:selectAllUser(2);" value="<?php echo $second_user_id; ?>" />Select All for User Account ID <?php echo $second_user_id; ?></td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">First Name</td>
      <td class="data">
      <input type="radio" name="select_first_name" id="select_first_name" value="form_u_first_name" <?php if (isset($select_first_name) && $select_first_name == "form_u_first_name") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" name="form_u_first_name" id="form_u_first_name" size="20" maxlength="50"<?php if (isset($form_u_first_name) && $form_u_first_name != '') { echo " value=\"$form_u_first_name\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_first_name" id="select_first_name" value="form_u_first_name2" <?php if (isset($select_first_name) && $select_first_name == "form_u_first_name2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" name="form_u_first_name2" id="form_u_first_name2" size="20" maxlength="50"<?php if (isset($form_u_first_name2) && $form_u_first_name2 != '') { echo " value=\"$form_u_first_name2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Last Name</td>
      <td class="data">
      <input type="radio" name="select_last_name" id="select_last_name" value="form_u_last_name" <?php if (isset($select_last_name) && $select_last_name == "form_u_last_name") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" name="form_u_last_name" id="form_u_last_name" size="30" maxlength="50"<?php if (isset($form_u_last_name) && $form_u_last_name != '') { echo " value=\"$form_u_last_name\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_last_name" id="select_last_name" value="form_u_last_name2" <?php if (isset($select_last_name) && $select_last_name == "form_u_last_name2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" name="form_u_last_name2" id="form_u_last_name2" size="30" maxlength="50"<?php if (isset($form_u_last_name2) && $form_u_last_name2 != '') { echo " value=\"$form_u_last_name2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Email</td>
      <td class="data">
      <input type="radio" name="select_email" id="select_email" value="form_u_email" <?php if (isset($select_email) && $select_email == "form_u_email") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" name="form_u_email" id="form_u_email" size="50" maxlength="100"<?php if (isset($form_u_email) && $form_u_email != '') { echo " value=\"$form_u_email\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_email" id="select_email" value="form_u_email2" <?php if (isset($select_email) && $select_email == "form_u_email2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" name="form_u_email2" id="form_u_email2" size="50" maxlength="100"<?php if (isset($form_u_email2) && $form_u_email2 != '') { echo " value=\"$form_u_email2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">SCA Name</td>
      <td class="data">
      <input type="radio" name="select_preferred_sca_name" id="select_preferred_sca_name" value="form_u_sca_name" <?php if (isset($select_preferred_sca_name) && $select_preferred_sca_name == "form_u_sca_name") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" name="form_u_sca_name" id="form_u_sca_name" size="50" maxlength="255"<?php if (isset($form_u_sca_name) && $form_u_sca_name != '') { echo " value=\"$form_u_sca_name\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_preferred_sca_name" id="select_preferred_sca_name" value="form_u_sca_name2" <?php if (isset($select_preferred_sca_name) && $select_preferred_sca_name == "form_u_sca_name2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" name="form_u_sca_name2" id="form_u_sca_name2" size="50" maxlength="255"<?php if (isset($form_u_sca_name2) && $form_u_sca_name2 != '') { echo " value=\"$form_u_sca_name2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Username</td>
      <td class="data">
      <input type="radio" name="select_u_username" id="select_u_username" value="form_u_username" <?php if (isset($select_u_username) && $select_u_username == "form_u_username") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_u_username" id="form_u_username" size="30" maxlength="50"<?php if (isset($form_u_username) && $form_u_username != '') { echo " value=\"$form_u_username\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_u_username" id="select_u_username" value="form_u_username2" <?php if (isset($select_u_username) && $select_u_username == "form_u_username2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_u_username2" id="form_u_username2" size="30" maxlength="50"<?php if (isset($form_u_username2) && $form_u_username2 != '') { echo " value=\"$form_u_username2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Date Created</td>
      <td class="data">
      <input type="radio" name="select_u_date_created" id="select_u_date_created" value="form_u_date_created" <?php if (isset($select_u_date_created) && $select_u_date_created == "form_u_date_created") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_u_date_created" id="form_u_date_created" size="15" maxlength="10"<?php if (isset($form_u_date_created) && $form_u_date_created != '') { echo " value=\"$form_u_date_created\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_u_date_created" id="select_u_date_created" value="form_u_date_created2" <?php if (isset($select_u_date_created) && $select_u_date_created == "form_u_date_created2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_u_date_created2" id="form_u_date_created2" size="15" maxlength="10"<?php if (isset($form_u_date_created2) && $form_u_date_created2 != '') { echo " value=\"$form_u_date_created2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Last Login Date</td>
      <td class="data">
      <input type="radio" name="select_u_last_log" id="select_u_last_log" value="form_u_last_log" <?php if (isset($select_u_last_log) && $select_u_last_log == "form_u_last_log") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_u_last_log" id="form_u_last_log" size="15" maxlength="10"<?php if (isset($form_u_last_log) && $form_u_last_log != '') { echo " value=\"$form_u_last_log\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_u_last_log" id="select_u_last_log" value="form_u_last_log2" <?php if (isset($select_u_last_log) && $select_u_last_log == "form_u_last_log2") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_u_last_log2" id="form_u_last_log2" size="15" maxlength="10"<?php if (isset($form_u_last_log2) && $form_u_last_log2 != '') { echo " value=\"$form_u_last_log2\"";} ?>>
      </td>
   </tr>
</table>
<?php
      } // user selection
      // Only one user option
      else
      {
         if (isset($user_id) && $user_id > 0)
         {
?>
   <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>"/>
<?php 
         }
?>
<p align="center" class="title2">User Account Information</p>
<table align="center" cellpadding="5" cellspacing="0" border="1">
   <tr>
      <th class="title" colspan="3" bgcolor="<?php echo $TITLE_BG_COLOR; ?>">User Account Information</th>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">User ID</td>
      <td class="data"><input type="radio" name="select_user_id" id="select_user_id" onclick="javascript:selectOneUser(1);" value="<?php echo $user_id; ?>" />Select All for User Account ID <?php echo $user_id; ?></td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">First Name</td>
      <td class="data">
      <input type="radio" name="select_first_name" id="select_first_name" value="form_u_first_name" <?php if (isset($select_first_name) && $select_first_name == "form_u_first_name") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" name="form_u_first_name" id="form_u_first_name" size="20" maxlength="50"<?php if (isset($form_u_first_name) && $form_u_first_name != '') { echo " value=\"$form_u_first_name\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Last Name</td>
      <td class="data">
      <input type="radio" name="select_last_name" id="select_last_name" value="form_u_last_name" <?php if (isset($select_last_name) && $select_last_name == "form_u_last_name") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" name="form_u_last_name" id="form_u_last_name" size="30" maxlength="50"<?php if (isset($form_u_last_name) && $form_u_last_name != '') { echo " value=\"$form_u_last_name\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Email</td>
      <td class="data">
      <input type="radio" name="select_email" id="select_email" value="form_u_email" <?php if (isset($select_email) && $select_email == "form_u_email") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" name="form_u_email" id="form_u_email" size="50" maxlength="100"<?php if (isset($form_u_email) && $form_u_email != '') { echo " value=\"$form_u_email\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">SCA Name</td>
      <td class="data">
      <input type="radio" name="select_preferred_sca_name" id="select_preferred_sca_name" value="form_u_sca_name" <?php if (isset($select_preferred_sca_name) && $select_preferred_sca_name == "form_u_sca_name") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" name="form_u_sca_name" id="form_u_sca_name" size="50" maxlength="255"<?php if (isset($form_u_sca_name) && $form_u_sca_name != '') { echo " value=\"$form_u_sca_name\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="<?php echo $SUBTITLE_BG_COLOR; ?>">Username</td>
      <td class="data">
      <input type="radio" name="select_u_username" id="select_u_username" value="form_u_username" <?php if (isset($select_u_username) && $select_u_username == "form_u_username") { echo ' CHECKED'; }?>/>&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_u_username" id="form_u_username" size="30" maxlength="50"<?php if (isset($form_u_username) && $form_u_username != '') { echo " value=\"$form_u_username\"";} ?>/>
      </td>
   </tr>
</table>
<?php
      } // User selection - one

?>
<p class="datacenter">
<input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_MERGE; ?>"/>
</p>
</form>
<?php
   } // else no selection
}
// Not authorized
else
{
   include("../header.php");
?>
<p align="center" class="title2">Merge Participant</p>
<p align="center" class="title2">You are not authorized to access this page.</p>
<?php
}
include("../footer.php");
?>