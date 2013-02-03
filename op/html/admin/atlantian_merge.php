<?php
include_once("db.php");

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

if (isset($_SESSION[$OP_ADMIN]) && $_SESSION[$OP_ADMIN])
{
   if ($first_atlantian_id == 0 || $second_atlantian_id == 0)
   {
      $no_edit_selection = true;
   }

   $SUBMIT_MERGE = "Merge Atlantian";

   // Data submitted
   if (isset($_POST['submit']) && $_POST['submit'] == $SUBMIT_MERGE)
   {
      // Validation
      $errmsg = '';

      //-------------------------------
      // Verify all fields are selected
      //-------------------------------
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
         $errmsg .= "Please select the date created.<br/>";
      }
      else
      {
         $select_date_created = clean($_POST['select_date_created']);
      }

      //-------------------------------
      // If all selected, gather form data based on selections
      //-------------------------------
      if ($errmsg == '')
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

         // Validate data
         //-------------------------------
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

         // GET SELECTED AWARDS
         $form_atlantian_award_id = "";
         if (isset($_POST['form_atlantian_award_id']))
         {
            $form_atlantian_award_id = create_in_clause_from_array($_POST['form_atlantian_award_id']);
         }

         //-------------------------------
         // Update database if valid
         //-------------------------------
         if ($errmsg == '')
         {
            // Assume keep first ID, delete second ID
            $keep_atlantian_id = $first_atlantian_id;
            $del_atlantian_id = $second_atlantian_id;

            $link = db_admin_connect();

            // Is one of these records tied to an account?  Make sure the first Atlantian ID is listed first
            $sort_dir = "ASC";
            if ($first_atlantian_id < $second_atlantian_id)
            {
               $sort_dir = "DESC";
            }
            $account_query = "SELECT * FROM $DBNAME_AUTH.user_auth WHERE atlantian_id IN (" . $first_atlantian_id . ", " . $second_atlantian_id . ") ORDER BY atlantian_id $sort_dir";
            $account_result = mysql_query($account_query)
               or die("Error retrieving Accounts: " . mysql_error());
            $num_accounts = mysql_num_rows($account_result);
            // If one account is tied, use that Atlantian ID
            if ($num_accounts == 1)
            {
               $account_data = mysql_fetch_array($account_result, MYSQL_BOTH);
               $account_atlantian_id = $account_data['atlantian_id'];
               if ($account_atlantian_id == $second_atlantian_id)
               {
                  $keep_atlantian_id = $second_atlantian_id;
                  $del_atlantian_id = $first_atlantian_id;
               }
            }
            // If both Atlantian IDs have accounts, keep the account most recently logged in
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

               // Determine which account was used most recently
               if ($account_last_log != "" && $account_last_log2 != "")
               {
                  // Account with second Atlantian ID was used most recently
                  if ($account_last_log2 > $account_last_log)
                  {
                     $keep_atlantian_id = $second_atlantian_id;
                     $del_atlantian_id = $first_atlantian_id;
                  }
               }
               // Account with second Atlantian ID is the only one that has been used
               else if ($account_last_log == "" && $account_last_log2 != "")
               {
                  $keep_atlantian_id = $second_atlantian_id;
                  $del_atlantian_id = $first_atlantian_id;
               }
            }
            // If not, use the lower Atlantian ID
            else
            {
               if ($first_atlantian_id > $second_atlantian_id)
               {
                  $keep_atlantian_id = $second_atlantian_id;
                  $del_atlantian_id = $first_atlantian_id;
               }
            }

            // Update the selected Atlantian ID with all the selected data fields

            // Get previous SCA Name
            $name_query = "SELECT sca_name, preferred_sca_name FROM $DBNAME_AUTH.atlantian WHERE atlantian_id = " . value_or_null($keep_atlantian_id);

            $name_result = mysql_query($name_query)
               or die("Error retrieving Atlantian SCA Name: " . mysql_error());

            $name_data = mysql_fetch_array($name_result, MYSQL_BOTH);

            $prev_name = $name_data['sca_name'];
            $prev_pref_name = $name_data['preferred_sca_name'];

            // If the current SCA name does not match the previous SCA name, and the previous SCA and preferred names matched
            if ($prev_name != $form_sca_name && $prev_name == $prev_pref_name)
            {
               // Update the preferred name to continue to match the SCA name
               $form_preferred_sca_name = $form_sca_name;
            }

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

            $sql_result = mysql_query($sql_stmt)
               or die("Error updating Atlantian data: " . mysql_error());

            //------------------------
            // UPDATE OP DATA
            //------------------------
            $atlantian_award_clause = "";
            if ($form_atlantian_award_id != "")
            {
               $atlantian_award_in_clause = " AND atlantian_award_id IN (" . $form_atlantian_award_id . ")";
               $atlantian_award_not_in_clause = " AND atlantian_award_id NOT IN (" . $form_atlantian_award_id . ")";
            }

            // Update all selected awards with the selected Atlantian ID
            $upd_award = "UPDATE $DBNAME_OP.atlantian_award SET " .
               "atlantian_id = " . value_or_null($keep_atlantian_id) .
               ", last_updated = " . value_or_null(date("Y-m-d")) .
               ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) . 
               " WHERE atlantian_id = " . value_or_null($del_atlantian_id) . 
               $atlantian_award_in_clause;
            $del_result = mysql_query($upd_award)
               or die("Error updating Atlantian awards in OP: " . mysql_error());

            // Update all non-selected awards with the to-be-deleted Atlantian ID
            $upd_award = "UPDATE $DBNAME_OP.atlantian_award SET atlantian_id = $del_atlantian_id WHERE atlantian_id = $keep_atlantian_id " . $atlantian_award_not_in_clause;
            $del_result = mysql_query($upd_award)
               or die("Error updating Atlantian awards in OP: " . mysql_error());

            // Delete all remaining awards with the non-selected Atlantian ID
            $delete = "DELETE FROM $DBNAME_OP.atlantian_award WHERE atlantian_id = $del_atlantian_id";
            $del_result = mysql_query($delete)
               or die("Error deleting Atlantian awards from OP: " . mysql_error());

            //------------------------
            // UPDATE UNIVERSITY DATA
            //------------------------
            // How many Participant records with these two Atlantian IDs?
            $query = "SELECT * FROM $DBNAME_UNIVERSITY.participant " . 
               "WHERE atlantian_id IN (" . value_or_null($keep_atlantian_id) . ", " . value_or_null($del_atlantian_id) . ") " .
               "ORDER BY atlantian_id $sort_dir";
            $result = mysql_query($query)
               or die("Participant Query Failed: " . $query . "<br/>" . mysql_error());
            $num_participants = mysql_num_rows($result);

            // Just one?  Update participant record with keep Atlantian ID
            if ($num_participants == 1)
            {
               $update = "UPDATE $DBNAME_UNIVERSITY.participant SET " .
                  "atlantian_id = " . value_or_null($keep_atlantian_id) .
                  ", last_updated = " . value_or_null(date("Y-m-d")) .
                  ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) .
                  " WHERE atlantian_id = " . value_or_null($del_atlantian_id);
               $update_result = mysql_query($update)
                  or die("Error updating University Participant: " . mysql_error());
            }
            // More than one?
            else if ($num_participants == 2)
            {
               // First participant
               $data = mysql_fetch_array($result, MYSQL_BOTH);
               $participant_id = clean($data['participant_id']);
               $university_participant_id = clean($data['university_participant_id']);
               $b_old_university_id = clean($data['b_old_university_id']);
               $b_university_id = clean($data['b_university_id']);
               $f_university_id = clean($data['f_university_id']);
               $m_university_id = clean($data['m_university_id']);
               $d_university_id = clean($data['d_university_id']);
               $keep_participant_id = $participant_id;

               // Second participant
               $data = mysql_fetch_array($result, MYSQL_BOTH);
               $participant_id_2 = clean($data['participant_id']);
               $university_participant_id_2 = clean($data['university_participant_id']);
               $b_old_university_id_2 = clean($data['b_old_university_id']);
               $b_university_id_2 = clean($data['b_university_id']);
               $f_university_id_2 = clean($data['f_university_id']);
               $m_university_id_2 = clean($data['m_university_id']);
               $d_university_id_2 = clean($data['d_university_id']);
               $del_participant_id = $participant_id_2;

               // Determine which participant record to keep - is one historical?
               if (($university_participant_id_2 > 0 && $university_participant_id == "") || 
                   ($b_old_university_id_2 > 0 && $b_old_university_id == "") || 
                   ($b_university_id_2 > 0 && $b_university_id == "") || 
                   ($f_university_id_2 > 0 && $f_university_id == "") || 
                   ($m_university_id_2 > 0 && $m_university_id == "") || 
                   ($d_university_id_2 > 0 && $d_university_id == ""))
               {
                  $keep_participant_id = $participant_id_2;
                  $del_participant_id = $participant_id;
               }
               mysql_free_result($result);

               // Would there be duplicate registration records if we merged?
               $p_sort_dir = "ASC";
               if ($participant_id < $participant_id_2)
               {
                  $p_sort_dir = "DESC";
               }
               // How many Registration records with these two Participant IDs?
               $query = "SELECT * FROM $DBNAME_UNIVERSITY.registration " . 
                  "WHERE participant_id IN (" . value_or_null($participant_id) . ", " . value_or_null($participant_id_2) . ") " .
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
                     $del_result = mysql_query($delete)
                        or die("Error deleting duplicate university registrations: " . mysql_error());
                  }

                  // Update remaining registration records with keep participant ID
                  $update = "UPDATE $DBNAME_UNIVERSITY.registration SET participant_id = " . value_or_null($keep_participant_id) .
                     ", last_updated = " . value_or_null(date("Y-m-d")) .
                     ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) .
                     " WHERE participant_id = " . value_or_null($del_participant_id);
                  $update_result = mysql_query($update)
                     or die("Error updating university registrations: " . mysql_error());
               }
               // Delete duplicate participant record
               $delete = "DELETE FROM $DBNAME_UNIVERSITY.participant WHERE participant_id = " . value_or_null($del_participant_id);
               $del_result = mysql_query($delete)
                  or die("Error deleting duplicate university participant: " . mysql_error());

               // Update remaining participant record with keep Atlantian ID
               $update = "UPDATE $DBNAME_UNIVERSITY.participant SET " .
                  "atlantian_id = " . value_or_null($keep_atlantian_id) .
                  ", sca_name = " . value_or_null($form_preferred_sca_name) .
                  ", last_updated = " . value_or_null(date("Y-m-d")) .
                  ", last_updated_by = " . value_or_null($_SESSION['s_user_id']) .
                  " WHERE participant_id = " . value_or_null($keep_participant_id);
               $update_result = mysql_query($update)
                  or die("Error updating university participant: " . mysql_error());
            }

            //------------------------
            // UPDATE AUTH DATA
            //------------------------
            // Delete user account for non-selected Atlantian ID
            if ($num_accounts == 2)
            {
               $delete = "DELETE FROM $DBNAME_AUTH.user_auth WHERE atlantian_id = $del_atlantian_id";
               $del_result = mysql_query($delete)
                  or die("Error deleting Atlantian from user_auth: " . mysql_error());

               $set_clause = "SET ";
               // Determine order access permissions on remaining account
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
                  if ($i > 0)
                  {
                     $set_clause .= ", ";
                  }
                  $set_clause .= $ORDER_ARRAY[$i]['pend'] . " = " . $account_order_perms[$i]['pend'];
                  $set_clause .= ", " . $ORDER_ARRAY[$i]['access'] . " = " . $account_order_perms[$i]['access'];
               }

               $update = "UPDATE $DBNAME_AUTH.user_auth $set_clause WHERE atlantian_id = $keep_atlantian_id";
               $update_result = mysql_query($update)
                  or die("Error updating permissions in user_auth: " . mysql_error());
            }

            // Delete non-selected Atlantian ID from auth
            $delete = "DELETE FROM $DBNAME_AUTH.atlantian WHERE atlantian_id = $del_atlantian_id";
            $del_result = mysql_query($delete)
               or die("Error deleting Atlantian from auth: " . mysql_error());

            // Close DB
            db_disconnect($link);

            // Redirect to edit page
            redirect("atlantian.php?atlantian_id=$keep_atlantian_id&mode=$MODE_EDIT");
         }
      } // Valid
   } // Submit

   //-------------------------------
   // Read Existing Atlantian if this isn't a submit
   //-------------------------------
   if ($first_atlantian_id > 0 && $second_atlantian_id > 0 && ((!(isset($_POST['submit']))) || (isset($_POST['submit']) && $errmsg != '')))
   {
      $link = db_connect();
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

      db_disconnect($link);
   }

// Get pick lists
$branch_data_array = get_branch_pick_list();

$title = "Merge Atlantian";
include("header.php");
?>
<script type="text/javascript">
function selectAll(selValue)
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
</script>
<p align="center" class="title2">Merge Atlantian</p>
<p align="center" class="title2">Atlantian Information</p>
<?php 
   if (isset($no_edit_selection) && $no_edit_selection)
   {
?>
<p align="center" class="title3" style="color:red">Two Atlantians were not selected for Merge.  Please use a navigation link to the left.</p>
<?php 
   }
   else
   {
?>
<?php 
      if (isset($errmsg) && $errmsg != '')
      {
?>
<p align="center" class="title3" style="color:red">Please correct the following errors:<br/><br/><?php echo $errmsg; ?></p>
<?php 
      }
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
?>
<table align="center" cellpadding="5" cellspacing="0" border="1">
   <tr>
      <th class="title" colspan="3" bgcolor="#FFFF99">Contact Information</th>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Atlantian ID</td>
      <td class="data"><input type="radio" name="select_atlantian_id" id="select_atlantian_id" onclick="javascript:selectAll(1);" value="<?php echo $first_atlantian_id; ?>" />Select All for Atlantian ID <?php echo $first_atlantian_id; ?></td>
      <td class="data"><input type="radio" name="select_atlantian_id" id="select_atlantian_id" onclick="javascript:selectAll(2);" value="<?php echo $second_atlantian_id; ?>" />Select All for Atlantian ID <?php echo $second_atlantian_id; ?></td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">First Name</td>
      <td class="data">
      <input type="radio" name="select_first_name" id="select_first_name" value="form_first_name" <?php if (isset($select_first_name) && $select_first_name == "form_first_name") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" name="form_first_name" id="form_first_name" size="20" maxlength="50"<?php if (isset($form_first_name) && $form_first_name != '') { echo " value=\"$form_first_name\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_first_name" id="select_first_name" value="form_first_name2" <?php if (isset($select_first_name) && $select_first_name == "form_first_name2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" name="form_first_name2" id="form_first_name2" size="20" maxlength="50"<?php if (isset($form_first_name2) && $form_first_name2 != '') { echo " value=\"$form_first_name2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Middle Name</td>
      <td class="data">
      <input type="radio" name="select_middle_name" id="select_middle_name" value="form_middle_name" <?php if (isset($select_middle_name) && $select_middle_name == "form_middle_name") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" name="form_middle_name" id="form_middle_name" size="30" maxlength="50"<?php if (isset($form_middle_name) && $form_middle_name != '') { echo " value=\"$form_middle_name\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_middle_name" id="select_middle_name" value="form_middle_name2" <?php if (isset($select_middle_name) && $select_middle_name == "form_middle_name2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" name="form_middle_name2" id="form_middle_name2" size="30" maxlength="50"<?php if (isset($form_middle_name2) && $form_middle_name2 != '') { echo " value=\"$form_middle_name2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Last Name</td>
      <td class="data">
      <input type="radio" name="select_last_name" id="select_last_name" value="form_last_name" <?php if (isset($select_last_name) && $select_last_name == "form_last_name") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" name="form_last_name" id="form_last_name" size="30" maxlength="50"<?php if (isset($form_last_name) && $form_last_name != '') { echo " value=\"$form_last_name\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_last_name" id="select_last_name" value="form_last_name2" <?php if (isset($select_last_name) && $select_last_name == "form_last_name2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" name="form_last_name2" id="form_last_name2" size="30" maxlength="50"<?php if (isset($form_last_name2) && $form_last_name2 != '') { echo " value=\"$form_last_name2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <th class="titleright" bgcolor="#FFFFCC"><label for="form_gender">Gender</label></th>
      <td class="data">
      <input type="radio" name="select_gender" id="select_gender" value="form_gender" <?php if (isset($select_gender) && $select_gender == "form_gender") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input name="form_gender" id="form_genderM" type="radio" value="<?php echo $MALE; ?>"<?php if (isset($form_gender) && $form_gender == $MALE) { echo ' CHECKED'; }?>/>Male 
      &nbsp;&nbsp;<input name="form_gender" id="form_genderF" type="radio" value="<?php echo $FEMALE; ?>"<?php if (isset($form_gender) && $form_gender == $FEMALE) { echo ' CHECKED'; }?>/>Female
      &nbsp;&nbsp;<input name="form_gender" id="form_genderU" type="radio" value="<?php echo $UNKNOWN; ?>"<?php if (isset($form_gender) && $form_gender == $UNKNOWN) { echo ' CHECKED'; }?>/>Unknown
      &nbsp;&nbsp;<input name="form_gender" id="form_genderN" type="radio" value="<?php echo $NONE; ?>"<?php if (isset($form_gender) && $form_gender == $NONE) { echo ' CHECKED'; }?>/>None
      </td>
      <td class="data">
      <input type="radio" name="select_gender" id="select_gender" value="form_gender2" <?php if (isset($select_gender) && $select_gender == "form_gender2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input name="form_gender2" id="form_genderM2" type="radio" value="<?php echo $MALE; ?>"<?php if (isset($form_gender2) && $form_gender2 == $MALE) { echo ' CHECKED'; }?>/>Male 
      &nbsp;&nbsp;<input name="form_gender2" id="form_genderF2" type="radio" value="<?php echo $FEMALE; ?>"<?php if (isset($form_gender2) && $form_gender2 == $FEMALE) { echo ' CHECKED'; }?>/>Female
      &nbsp;&nbsp;<input name="form_gender2" id="form_genderU2" type="radio" value="<?php echo $UNKNOWN; ?>"<?php if (isset($form_gender2) && $form_gender2 == $UNKNOWN) { echo ' CHECKED'; }?>/>Unknown
      &nbsp;&nbsp;<input name="form_gender2" id="form_genderN2" type="radio" value="<?php echo $NONE; ?>"<?php if (isset($form_gender2) && $form_gender2 == $NONE) { echo ' CHECKED'; }?>/>None
      </td>
   </tr>
   <tr>
      <th class="titleright" bgcolor="#FFFFCC"><label for="form_deceased">Deceased</label></th>
      <td class="data">
      <input type="radio" name="select_deceased" id="select_deceased" value="form_deceased" <?php if (isset($select_deceased) && $select_deceased == "form_deceased") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="checkbox" name="form_deceased" id="form_deceased" value="1"<?php if (isset($form_deceased) && $form_deceased == 1) { echo ' CHECKED'; }?>>
      &nbsp;
      <b>Date</b> <input type="text" name="form_deceased_date" id="form_deceased_date" size="11" maxlength="10"<?php if (isset($form_deceased_date) && $form_deceased_date != '') { echo " value=\"$form_deceased_date\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_deceased" id="select_deceased" value="form_deceased2" <?php if (isset($select_deceased) && $select_deceased == "form_deceased2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="checkbox" name="form_deceased2" id="form_deceased2" value="1"<?php if (isset($form_deceased2) && $form_deceased2 == 1) { echo ' CHECKED'; }?>>
      &nbsp;
      <b>Date</b> <input type="text" name="form_deceased_date2" id="form_deceased_date2" size="11" maxlength="10"<?php if (isset($form_deceased_date2) && $form_deceased_date2 != '') { echo " value=\"$form_deceased_date2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Email</td>
      <td class="data">
      <input type="radio" name="select_email" id="select_email" value="form_email" <?php if (isset($select_email) && $select_email == "form_email") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" name="form_email" id="form_email" size="50" maxlength="100"<?php if (isset($form_email) && $form_email != '') { echo " value=\"$form_email\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_email" id="select_email" value="form_email2" <?php if (isset($select_email) && $select_email == "form_email2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" name="form_email2" id="form_email2" size="50" maxlength="100"<?php if (isset($form_email2) && $form_email2 != '') { echo " value=\"$form_email2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Alternate Email</td>
      <td class="data">
      <input type="radio" name="select_alternate_email" id="select_alternate_email" value="form_alternate_email" <?php if (isset($select_alternate_email) && $select_alternate_email == "form_alternate_email") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_alternate_email" id="form_alternate_email" size="50" maxlength="100"<?php if (isset($form_alternate_email) && $form_alternate_email != '') { echo " value=\"$form_alternate_email\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_alternate_email" id="select_alternate_email" value="form_alternate_email2" <?php if (isset($select_alternate_email) && $select_alternate_email == "form_alternate_email2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_alternate_email2" id="form_alternate_email2" size="50" maxlength="100"<?php if (isset($form_alternate_email2) && $form_alternate_email2 != '') { echo " value=\"$form_alternate_email2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Address Line 1</td>
      <td class="data">
      <input type="radio" name="select_address1" id="select_address1" value="form_address1" <?php if (isset($select_address1) && $select_address1 == "form_address1") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_address1" id="form_address1" size="50" maxlength="100"<?php if (isset($form_address1) && $form_address1 != '') { echo " value=\"$form_address1\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_address1" id="select_address1" value="form_address12" <?php if (isset($select_address1) && $select_address1 == "form_address12") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_address12" id="form_address12" size="50" maxlength="100"<?php if (isset($form_address12) && $form_address12 != '') { echo " value=\"$form_address12\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Address Line 2</td>
      <td class="data">
      <input type="radio" name="select_address2" id="select_address2" value="form_address2" <?php if (isset($select_address2) && $select_address2 == "form_address2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_address2" id="form_address2" size="50" maxlength="100"<?php if (isset($form_address2) && $form_address2 != '') { echo " value=\"$form_address2\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_address2" id="select_address2" value="form_address22" <?php if (isset($select_address2) && $select_address2 == "form_address22") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_address22" id="form_address22" size="50" maxlength="100"<?php if (isset($form_address22) && $form_address22 != '') { echo " value=\"$form_address22\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">City</td>
      <td class="data">
      <input type="radio" name="select_city" id="select_city" value="form_city" <?php if (isset($select_city) && $select_city == "form_city") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_city" id="form_city" size="50" maxlength="50"<?php if (isset($form_city) && $form_city != '') { echo " value=\"$form_city\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_city" id="select_city" value="form_city2" <?php if (isset($select_city) && $select_city == "form_city2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_city2" id="form_city2" size="50" maxlength="50"<?php if (isset($form_city2) && $form_city2 != '') { echo " value=\"$form_city2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">State</td>
      <td class="data">
      <input type="radio" name="select_state" id="select_state" value="form_state" <?php if (isset($select_state) && $select_state == "form_state") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_state" id="form_state" size="5" maxlength="2"<?php if (isset($form_state) && $form_state != '') { echo " value=\"$form_state\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_state" id="select_state" value="form_state2" <?php if (isset($select_state) && $select_state == "form_state2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_state2" id="form_state2" size="5" maxlength="2"<?php if (isset($form_state2) && $form_state2 != '') { echo " value=\"$form_state2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Zip</td>
      <td class="data">
      <input type="radio" name="select_zip" id="select_zip" value="form_zip" <?php if (isset($select_zip) && $select_zip == "form_zip") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_zip" id="form_zip" size="20" maxlength="10"<?php if (isset($form_zip) && $form_zip != '') { echo " value=\"$form_zip\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_zip" id="select_zip" value="form_zip2" <?php if (isset($select_zip) && $select_zip == "form_zip2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_zip2" id="form_zip2" size="20" maxlength="10"<?php if (isset($form_zip2) && $form_zip2 != '') { echo " value=\"$form_zip2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Country</td>
      <td class="data">
      <input type="radio" name="select_country" id="select_country" value="form_country" <?php if (isset($select_country) && $select_country == "form_country") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_country" id="form_country" size="50" maxlength="50"<?php if (isset($form_country) && $form_country != '') { echo " value=\"$form_country\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_country" id="select_country" value="form_country2" <?php if (isset($select_country) && $select_country == "form_country2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_country2" id="form_country2" size="50" maxlength="50"<?php if (isset($form_country2) && $form_country2 != '') { echo " value=\"$form_country2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Home Phone</td>
      <td class="data">
      <input type="radio" name="select_phone_home" id="select_phone_home" value="form_phone_home" <?php if (isset($select_phone_home) && $select_phone_home == "form_phone_home") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_phone_home" id="form_phone_home" size="30" maxlength="20"<?php if (isset($form_phone_home) && $form_phone_home != '') { echo " value=\"$form_phone_home\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_phone_home" id="select_phone_home" value="form_phone_home2" <?php if (isset($select_phone_home) && $select_phone_home == "form_phone_home2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_phone_home2" id="form_phone_home2" size="30" maxlength="20"<?php if (isset($form_phone_home2) && $form_phone_home2 != '') { echo " value=\"$form_phone_home2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Work Phone</td>
      <td class="data">
      <input type="radio" name="select_phone_work" id="select_phone_work" value="form_phone_work" <?php if (isset($select_phone_work) && $select_phone_work == "form_phone_work") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_phone_work" id="form_phone_work" size="30" maxlength="20"<?php if (isset($form_phone_work) && $form_phone_work != '') { echo " value=\"$form_phone_work\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_phone_work" id="select_phone_work" value="form_phone_work2" <?php if (isset($select_phone_work) && $select_phone_work == "form_phone_work2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_phone_work2" id="form_phone_work2" size="30" maxlength="20"<?php if (isset($form_phone_work2) && $form_phone_work2 != '') { echo " value=\"$form_phone_work2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Mobile Phone</td>
      <td class="data">
      <input type="radio" name="select_phone_mobile" id="select_phone_mobile" value="form_phone_mobile" <?php if (isset($select_phone_mobile) && $select_phone_mobile == "form_phone_mobile") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_phone_mobile" id="form_phone_mobile" size="30" maxlength="20"<?php if (isset($form_phone_mobile) && $form_phone_mobile != '') { echo " value=\"$form_phone_mobile\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_phone_mobile" id="select_phone_mobile" value="form_phone_mobile2" <?php if (isset($select_phone_mobile) && $select_phone_mobile == "form_phone_mobile2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_phone_mobile2" id="form_phone_mobile2" size="30" maxlength="20"<?php if (isset($form_phone_mobile2) && $form_phone_mobile2 != '') { echo " value=\"$form_phone_mobile2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Call Times</td>
      <td class="data">
      <input type="radio" name="select_call_times" id="select_call_times" value="form_call_times" <?php if (isset($select_call_times) && $select_call_times == "form_call_times") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_call_times" id="form_call_times" size="30" maxlength="20"<?php if (isset($form_call_times) && $form_call_times != '') { echo " value=\"$form_call_times\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_call_times" id="select_call_times" value="form_call_times2" <?php if (isset($select_call_times) && $select_call_times == "form_call_times2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_call_times2" id="form_call_times2" size="30" maxlength="20"<?php if (isset($form_call_times2) && $form_call_times2 != '') { echo " value=\"$form_call_times2\"";} ?>>
      </td>
   </tr>
   <tr>
      <th class="titleright" bgcolor="#FFFFCC"><label for="form_publish_name">Publish Name</label></th>
      <td class="data">
      <input type="radio" name="select_publish_name" id="select_publish_name" value="form_publish_name" <?php if (isset($select_publish_name) && $select_publish_name == "form_publish_name") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_publish_name" id="form_publish_name" size="5" maxlength="1"<?php if (isset($form_publish_name) && $form_publish_name == 1) { echo " value=\"1\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_publish_name" id="select_publish_name" value="form_publish_name2" <?php if (isset($select_publish_name) && $select_publish_name == "form_publish_name2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_publish_name2" id="form_publish_name2" size="5" maxlength="1"<?php if (isset($form_publish_name2) && $form_publish_name2 == 1) { echo " value=\"1\"";} ?>>
      </td>
   </tr>
   <tr>
      <th class="titleright" bgcolor="#FFFFCC"><label for="form_publish_address">Publish Address</label></th>
      <td class="data">
      <input type="radio" name="select_publish_address" id="select_publish_address" value="form_publish_address" <?php if (isset($select_publish_address) && $select_publish_address == "form_publish_address") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_publish_address" id="form_publish_address" size="5" maxlength="1"<?php if (isset($form_publish_address) && $form_publish_address == 1) { echo " value=\"1\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_publish_address" id="select_publish_address" value="form_publish_address2" <?php if (isset($select_publish_address) && $select_publish_address == "form_publish_address2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_publish_address2" id="form_publish_address2" size="5" maxlength="1"<?php if (isset($form_publish_address2) && $form_publish_address2 == 1) { echo " value=\"1\"";} ?>>
      </td>
   </tr>
   <tr>
      <th class="titleright" bgcolor="#FFFFCC"><label for="form_publish_email">Publish Email</label></th>
      <td class="data">
      <input type="radio" name="select_publish_email" id="select_publish_email" value="form_publish_email" <?php if (isset($select_publish_email) && $select_publish_email == "form_publish_email") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_publish_email" id="form_publish_email" size="5" maxlength="1"<?php if (isset($form_publish_email) && $form_publish_email == 1) { echo " value=\"1\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_publish_email" id="select_publish_email" value="form_publish_email2" <?php if (isset($select_publish_email) && $select_publish_email == "form_publish_email2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_publish_email2" id="form_publish_email2" size="5" maxlength="1"<?php if (isset($form_publish_email2) && $form_publish_email2 == 1) { echo " value=\"1\"";} ?>>
      </td>
   </tr>
   <tr>
      <th class="titleright" bgcolor="#FFFFCC"><label for="form_publish_alternate_email">Publish Alternate Email</label></th>
      <td class="data">
      <input type="radio" name="select_publish_alternate_email" id="select_publish_alternate_email" value="form_publish_alternate_email" <?php if (isset($select_publish_alternate_email) && $select_publish_alternate_email == "form_publish_alternate_email") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_publish_alternate_email" id="form_publish_alternate_email" size="5" maxlength="1"<?php if (isset($form_publish_alternate_email) && $form_publish_alternate_email == 1) { echo " value=\"1\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_publish_alternate_email" id="select_publish_alternate_email" value="form_publish_alternate_email2" <?php if (isset($select_publish_alternate_email) && $select_publish_alternate_email == "form_publish_alternate_email2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_publish_alternate_email2" id="form_publish_alternate_email2" size="5" maxlength="1"<?php if (isset($form_publish_alternate_email2) && $form_publish_alternate_email2 == 1) { echo " value=\"1\"";} ?>>
      </td>
   </tr>
   <tr>
      <th class="titleright" bgcolor="#FFFFCC"><label for="form_publish_phone_home">Publish Home Phone</label></th>
      <td class="data">
      <input type="radio" name="select_publish_phone_home" id="select_publish_phone_home" value="form_publish_phone_home" <?php if (isset($select_publish_phone_home) && $select_publish_phone_home == "form_publish_phone_home") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_publish_phone_home" id="form_publish_phone_home" size="5" maxlength="1"<?php if (isset($form_publish_phone_home) && $form_publish_phone_home == 1) { echo " value=\"1\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_publish_phone_home" id="select_publish_phone_home" value="form_publish_phone_home2" <?php if (isset($select_publish_phone_home) && $select_publish_phone_home == "form_publish_phone_home2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_publish_phone_home2" id="form_publish_phone_home2" size="5" maxlength="1"<?php if (isset($form_publish_phone_home2) && $form_publish_phone_home2 == 1) { echo " value=\"1\"";} ?>>
      </td>
   </tr>
   <tr>
      <th class="titleright" bgcolor="#FFFFCC"><label for="form_publish_phone_work">Publish Work Phone</label></th>
      <td class="data">
      <input type="radio" name="select_publish_phone_work" id="select_publish_phone_work" value="form_publish_phone_work" <?php if (isset($select_publish_phone_work) && $select_publish_phone_work == "form_publish_phone_work") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_publish_phone_work" id="form_publish_phone_work" size="5" maxlength="1"<?php if (isset($form_publish_phone_work) && $form_publish_phone_work == 1) { echo " value=\"1\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_publish_phone_work" id="select_publish_phone_work" value="form_publish_phone_work2" <?php if (isset($select_publish_phone_work) && $select_publish_phone_work == "form_publish_phone_work2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_publish_phone_work2" id="form_publish_phone_work2" size="5" maxlength="1"<?php if (isset($form_publish_phone_work2) && $form_publish_phone_work2 == 1) { echo " value=\"1\"";} ?>>
      </td>
   </tr>
   <tr>
      <th class="titleright" bgcolor="#FFFFCC"><label for="form_publish_phone_mobile">Publish Mobile Phone</label></th>
      <td class="data">
      <input type="radio" name="select_publish_phone_mobile" id="select_publish_phone_mobile" value="form_publish_phone_mobile" <?php if (isset($select_publish_phone_mobile) && $select_publish_phone_mobile == "form_publish_phone_mobile") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_publish_phone_mobile" id="form_publish_phone_mobile" size="5" maxlength="1"<?php if (isset($form_publish_phone_mobile) && $form_publish_phone_mobile == 1) { echo " value=\"1\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_publish_phone_mobile" id="select_publish_phone_mobile" value="form_publish_phone_mobile2" <?php if (isset($select_publish_phone_mobile) && $select_publish_phone_mobile == "form_publish_phone_mobile2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_publish_phone_mobile2" id="form_publish_phone_mobile2" size="5" maxlength="1"<?php if (isset($form_publish_phone_mobile2) && $form_publish_phone_mobile2 == 1) { echo " value=\"1\"";} ?>>
      </td>
   </tr>
   <tr>
      <th class="title" colspan="3" bgcolor="#FFFF99">SCA Information</th>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">SCA Name</td>
      <td class="data">
      <input type="radio" name="select_sca_name" id="select_sca_name" value="form_sca_name" <?php if (isset($select_sca_name) && $select_sca_name == "form_sca_name") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" name="form_sca_name" id="form_sca_name" size="50" maxlength="255"<?php if (isset($form_sca_name) && $form_sca_name != '') { echo " value=\"$form_sca_name\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_sca_name" id="select_sca_name" value="form_sca_name2" <?php if (isset($select_sca_name) && $select_sca_name == "form_sca_name2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" name="form_sca_name2" id="form_sca_name2" size="50" maxlength="255"<?php if (isset($form_sca_name2) && $form_sca_name2 != '') { echo " value=\"$form_sca_name2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Preferred SCA Name</td>
      <td class="data">
      <input type="radio" name="select_preferred_sca_name" id="select_preferred_sca_name" value="form_preferred_sca_name" <?php if (isset($select_preferred_sca_name) && $select_preferred_sca_name == "form_preferred_sca_name") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" name="form_preferred_sca_name" id="form_preferred_sca_name" size="50" maxlength="255"<?php if (isset($form_preferred_sca_name) && $form_preferred_sca_name != '') { echo " value=\"$form_preferred_sca_name\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_preferred_sca_name" id="select_preferred_sca_name" value="form_preferred_sca_name2" <?php if (isset($select_preferred_sca_name) && $select_preferred_sca_name == "form_preferred_sca_name2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" name="form_preferred_sca_name2" id="form_preferred_sca_name2" size="50" maxlength="255"<?php if (isset($form_preferred_sca_name2) && $form_preferred_sca_name2 != '') { echo " value=\"$form_preferred_sca_name2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Branch</td>
      <td class="data">
      <input type="radio" name="select_branch_id" id="select_branch_id" value="form_branch_id" <?php if (isset($select_branch_id) && $select_branch_id == "form_branch_id") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
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
      <input type="radio" name="select_branch_id" id="select_branch_id" value="form_branch_id2" <?php if (isset($select_branch_id) && $select_branch_id == "form_branch_id2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
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
      <td class="titleright" bgcolor="#FFFFCC">Date Name Registered</td>
      <td class="data">
      <input type="radio" name="select_name_reg_date" id="select_name_reg_date" value="form_name_reg_date" <?php if (isset($select_name_reg_date) && $select_name_reg_date == "form_name_reg_date") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" name="form_name_reg_date" id="form_name_reg_date" size="15" maxlength="10"<?php if (isset($form_name_reg_date) && $form_name_reg_date != '') { echo " value=\"$form_name_reg_date\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_name_reg_date" id="select_name_reg_date" value="form_name_reg_date2" <?php if (isset($select_name_reg_date) && $select_name_reg_date == "form_name_reg_date2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" name="form_name_reg_date2" id="form_name_reg_date2" size="15" maxlength="10"<?php if (isset($form_name_reg_date2) && $form_name_reg_date2 != '') { echo " value=\"$form_name_reg_date2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Date Device Registered</td>
      <td class="data">
      <input type="radio" name="select_device_reg_date" id="select_device_reg_date" value="form_device_reg_date" <?php if (isset($select_device_reg_date) && $select_device_reg_date == "form_device_reg_date") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" name="form_device_reg_date" id="form_device_reg_date" size="15" maxlength="10"<?php if (isset($form_device_reg_date) && $form_device_reg_date != '') { echo " value=\"$form_device_reg_date\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_device_reg_date" id="select_device_reg_date" value="form_device_reg_date2" <?php if (isset($select_device_reg_date) && $select_device_reg_date == "form_device_reg_date2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" name="form_device_reg_date2" id="form_device_reg_date2" size="15" maxlength="10"<?php if (isset($form_device_reg_date2) && $form_device_reg_date2 != '') { echo " value=\"$form_device_reg_date2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Blazon</td>
      <td class="data">
      <input type="radio" name="select_blazon" id="select_blazon" value="form_blazon" <?php if (isset($select_blazon) && $select_blazon == "form_blazon") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" name="form_blazon" id="form_blazon" size="50" maxlength="65535"<?php if (isset($form_blazon) && $form_blazon != '') { echo " value=\"$form_blazon\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_blazon" id="select_blazon" value="form_blazon2" <?php if (isset($select_blazon) && $select_blazon == "form_blazon2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" name="form_blazon2" id="form_blazon2" size="50" maxlength="65535"<?php if (isset($form_blazon2) && $form_blazon2 != '') { echo " value=\"$form_blazon2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Alternate Names</td>
      <td class="data">
      <input type="radio" name="select_alternate_names" id="select_alternate_names" value="form_alternate_names" <?php if (isset($select_alternate_names) && $select_alternate_names == "form_alternate_names") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" name="form_alternate_names" id="form_alternate_names" size="50" maxlength="255"<?php if (isset($form_alternate_names) && $form_alternate_names != '') { echo " value=\"$form_alternate_names\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_alternate_names" id="select_alternate_names" value="form_alternate_names2" <?php if (isset($select_alternate_names) && $select_alternate_names == "form_alternate_names2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" name="form_alternate_names2" id="form_alternate_names2" size="50" maxlength="255"<?php if (isset($form_alternate_names2) && $form_alternate_names2 != '') { echo " value=\"$form_alternate_names2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Heraldic Rank</td>
      <td class="data">
      <input type="radio" name="select_heraldic_rank_id" id="select_heraldic_rank_id" value="form_heraldic_rank_id" <?php if (isset($select_heraldic_rank_id) && $select_heraldic_rank_id == "form_heraldic_rank_id") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="hidden" name="form_heraldic_rank_id" id="form_heraldic_rank_id"<?php if (isset($form_heraldic_rank_id) && $form_heraldic_rank_id != '') { echo " value=\"$form_heraldic_rank_id\"";} ?>>
      <input type="text" readonly="readonly" name="form_heraldic_rank" id="form_heraldic_rank" size="50" maxlength="50"<?php if (isset($form_heraldic_rank) && $form_heraldic_rank != '') { echo " value=\"$form_heraldic_rank\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_heraldic_rank_id" id="select_heraldic_rank_id" value="form_heraldic_rank_id2" <?php if (isset($select_heraldic_rank_id) && $select_heraldic_rank_id == "form_heraldic_rank_id2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="hidden" name="form_heraldic_rank_id2" id="form_heraldic_rank_id2"<?php if (isset($form_heraldic_rank_id2) && $form_heraldic_rank_id2 != '') { echo " value=\"$form_heraldic_rank_id2\"";} ?>>
      <input type="text" readonly="readonly" name="form_heraldic_rank2" id="form_heraldic_rank2" size="50" maxlength="50"<?php if (isset($form_heraldic_rank2) && $form_heraldic_rank2 != '') { echo " value=\"$form_heraldic_rank2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Heraldic Title</td>
      <td class="data">
      <input type="radio" name="select_heraldic_title" id="select_heraldic_title" value="form_heraldic_title" <?php if (isset($select_heraldic_title) && $select_heraldic_title == "form_heraldic_title") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_heraldic_title" id="form_heraldic_title" size="50" maxlength="255"<?php if (isset($form_heraldic_title) && $form_heraldic_title != '') { echo " value=\"$form_heraldic_title\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_heraldic_title" id="select_heraldic_title" value="form_heraldic_title2" <?php if (isset($select_heraldic_title) && $select_heraldic_title == "form_heraldic_title2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_heraldic_title2" id="form_heraldic_title2" size="50" maxlength="255"<?php if (isset($form_heraldic_title2) && $form_heraldic_title2 != '') { echo " value=\"$form_heraldic_title2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Heraldic Interests</td>
      <td class="data">
      <input type="radio" name="select_heraldic_interests" id="select_heraldic_interests" value="form_heraldic_interests" <?php if (isset($select_heraldic_interests) && $select_heraldic_interests == "form_heraldic_interests") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_heraldic_interests" id="form_heraldic_interests" size="50" maxlength="255"<?php if (isset($form_heraldic_interests) && $form_heraldic_interests != '') { echo " value=\"$form_heraldic_interests\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_heraldic_interests" id="select_heraldic_interests" value="form_heraldic_interests2" <?php if (isset($select_heraldic_interests) && $select_heraldic_interests == "form_heraldic_interests2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_heraldic_interests2" id="form_heraldic_interests2" size="50" maxlength="255"<?php if (isset($form_heraldic_interests2) && $form_heraldic_interests2 != '') { echo " value=\"$form_heraldic_interests2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Website</td>
      <td class="data">
      <input type="radio" name="select_website" id="select_website" value="form_website" <?php if (isset($select_website) && $select_website == "form_website") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_website" id="form_website" size="50" maxlength="100"<?php if (isset($form_website) && $form_website != '') { echo " value=\"$form_website\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_website" id="select_website" value="form_website2" <?php if (isset($select_website) && $select_website == "form_website2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_website2" id="form_website2" size="50" maxlength="100"<?php if (isset($form_website2) && $form_website2 != '') { echo " value=\"$form_website2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Biography</td>
      <td class="data">
      <input type="radio" name="select_biography" id="select_biography" value="form_biography" <?php if (isset($select_biography) && $select_biography == "form_biography") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <textarea readonly="readonly" name="form_biography" id="form_biography" rows="5" cols="50"><?php if (isset($form_biography) && $form_biography != '') { echo $form_biography; } ?></textarea>
      </td>
      <td class="data">
      <input type="radio" name="select_biography" id="select_biography" value="form_biography2" <?php if (isset($select_biography) && $select_biography == "form_biography2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <textarea readonly="readonly" name="form_biography" id="form_biography" rows="5" cols="50"><?php if (isset($form_biography2) && $form_biography2 != '') { echo $form_biography2; } ?></textarea>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Membership Number</td>
      <td class="data">
      <input type="radio" name="select_membership_number" id="select_membership_number" value="form_membership_number" <?php if (isset($select_membership_number) && $select_membership_number == "form_membership_number") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_membership_number" id="form_membership_number" size="20" maxlength="10"<?php if (isset($form_membership_number) && $form_membership_number != '') { echo " value=\"$form_membership_number\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_membership_number" id="select_membership_number" value="form_membership_number2" <?php if (isset($select_membership_number) && $select_membership_number == "form_membership_number2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_membership_number2" id="form_membership_number2" size="20" maxlength="10"<?php if (isset($form_membership_number2) && $form_membership_number2 != '') { echo " value=\"$form_membership_number2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Expiration Date</td>
      <td class="data">
      <input type="radio" name="select_expiration_date" id="select_expiration_date" value="form_expiration_date" <?php if (isset($select_expiration_date) && $select_expiration_date == "form_expiration_date") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_expiration_date" id="form_expiration_date" size="15" maxlength="10"<?php if (isset($form_expiration_date) && $form_expiration_date != '') { echo " value=\"$form_expiration_date\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_expiration_date" id="select_expiration_date" value="form_expiration_date2" <?php if (isset($select_expiration_date) && $select_expiration_date == "form_expiration_date2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_expiration_date2" id="form_expiration_date2" size="15" maxlength="10"<?php if (isset($form_expiration_date2) && $form_expiration_date2 != '') { echo " value=\"$form_expiration_date2\"";} ?>>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Pending Expiration Date</td>
      <td class="data">
      <input type="radio" name="select_expiration_date_pending" id="select_expiration_date_pending" value="form_expiration_date_pending" <?php if (isset($select_expiration_date_pending) && $select_expiration_date_pending == "form_expiration_date_pending") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_expiration_date_pending" id="form_expiration_date_pending" size="15" maxlength="10"<?php if (isset($form_expiration_date_pending) && $form_expiration_date_pending != '') { echo " value=\"$form_expiration_date_pending\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_expiration_date_pending" id="select_expiration_date_pending" value="form_expiration_date_pending2" <?php if (isset($select_expiration_date_pending) && $select_expiration_date_pending == "form_expiration_date_pending2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_expiration_date_pending2" id="form_expiration_date_pending2" size="15" maxlength="10"<?php if (isset($form_expiration_date_pending2) && $form_expiration_date_pending2 != '') { echo " value=\"$form_expiration_date_pending2\"";} ?>>
      </td>
   </tr>
   <tr>
      <th class="titleright" bgcolor="#FFFFCC"><label for="form_background_check_result">Background Check</label></th>
      <td class="data">
      <input type="radio" name="select_background_check" id="select_background_check" value="form_background_check_result" <?php if (isset($select_background_check) && $select_background_check == "form_background_check_result") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_background_check_result" id="form_background_check_result" size="3" maxlength="1"<?php if (isset($form_background_check_result) && $form_background_check_result == 1) { echo " value=\"1\"";} ?>>
      &nbsp;
      <b>Date</b> <input type="text" readonly="readonly" name="form_background_check_date" id="form_background_check_date" size="11" maxlength="10"<?php if (isset($form_background_check_date) && $form_background_check_date != '') { echo " value=\"$form_background_check_date\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_background_check" id="select_background_check" value="form_background_check_result2" <?php if (isset($select_background_check) && $select_background_check == "form_background_check_result2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_background_check_result2" id="form_background_check_result2" size="3" maxlength="1"<?php if (isset($form_background_check_result2) && $form_background_check_result2 == 1) { echo " value=\"1\"";} ?>>
      &nbsp;
      <b>Date</b> <input type="text" readonly="readonly" name="form_background_check_date2" id="form_background_check_date2" size="11" maxlength="10"<?php if (isset($form_background_check_date2) && $form_background_check_date2 != '') { echo " value=\"$form_background_check_date2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <th class="titleright" bgcolor="#FFFFCC"><label for="form_inactive">Inactive</label></th>
      <td class="data">
      <input type="radio" name="select_inactive" id="select_inactive" value="form_inactive" <?php if (isset($select_inactive) && $select_inactive == "form_inactive") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="checkbox" name="form_inactive" id="form_inactive" value="1"<?php if (isset($form_inactive) && $form_inactive == 1) { echo ' CHECKED'; }?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_inactive" id="select_inactive" value="form_inactive2" <?php if (isset($select_inactive) && $select_inactive == "form_inactive2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="checkbox" name="form_inactive2" id="form_inactive2" value="1"<?php if (isset($form_inactive2) && $form_inactive2 == 1) { echo ' CHECKED'; }?>/>
      </td>
   </tr>
   <tr>
      <th class="titleright" bgcolor="#FFFFCC"><label for="form_revoked">Revoked and Denied</label></th>
      <td class="data">
      <input type="radio" name="select_revoked" id="select_revoked" value="form_revoked" <?php if (isset($select_revoked) && $select_revoked == "form_revoked") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="checkbox" name="form_revoked" id="form_revoked" value="1"<?php if (isset($form_revoked) && $form_revoked == 1) { echo ' CHECKED'; }?>/>
      &nbsp;
      <b>Date</b> <input type="text" name="form_revoked_date" id="form_revoked_date" size="11" maxlength="10"<?php if (isset($form_revoked_date) && $form_revoked_date != '') { echo " value=\"$form_revoked_date\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_revoked" id="select_revoked" value="form_revoked2" <?php if (isset($select_revoked) && $select_revoked == "form_revoked2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="checkbox" name="form_revoked2" id="form_revoked2" value="1"<?php if (isset($form_revoked2) && $form_revoked2 == 1) { echo ' CHECKED'; }?>/>
      &nbsp;
      <b>Date</b> <input type="text" name="form_revoked_date2" id="form_revoked_date2" size="11" maxlength="10"<?php if (isset($form_revoked_date2) && $form_revoked_date2 != '') { echo " value=\"$form_revoked_date2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <th class="title" colspan="3" bgcolor="#FFFF99">System Information</th>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Device File Name</td>
      <td class="data">
      <input type="radio" name="select_device_file_name" id="select_device_file_name" value="form_device_file_name" <?php if (isset($select_device_file_name) && $select_device_file_name == "form_device_file_name") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" name="form_device_file_name" id="form_device_file_name" size="50" maxlength="255"<?php if (isset($form_device_file_name) && $form_device_file_name != '') { echo " value=\"$form_device_file_name\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_device_file_name" id="select_device_file_name" value="form_device_file_name2" <?php if (isset($select_device_file_name) && $select_device_file_name == "form_device_file_name2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" name="form_device_file_name2" id="form_device_file_name2" size="50" maxlength="255"<?php if (isset($form_device_file_name2) && $form_device_file_name2 != '') { echo " value=\"$form_device_file_name2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Device File Credit</td>
      <td class="data">
      <input type="radio" name="select_device_file_credit" id="select_device_file_credit" value="form_device_file_credit" <?php if (isset($select_device_file_credit) && $select_device_file_credit == "form_device_file_credit") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" name="form_device_file_credit" id="form_device_file_credit" size="50" maxlength="255"<?php if (isset($form_device_file_credit) && $form_device_file_credit != '') { echo " value=\"$form_device_file_credit\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_device_file_credit" id="select_device_file_credit" value="form_device_file_credit2" <?php if (isset($select_device_file_credit) && $select_device_file_credit == "form_device_file_credit2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" name="form_device_file_credit2" id="form_device_file_credit2" size="50" maxlength="255"<?php if (isset($form_device_file_credit2) && $form_device_file_credit2 != '') { echo " value=\"$form_device_file_credit2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Picture File Name</td>
      <td class="data">
      <input type="radio" name="select_picture_file_name" id="select_picture_file_name" value="form_picture_file_name" <?php if (isset($select_picture_file_name) && $select_picture_file_name == "form_picture_file_name") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_picture_file_name" id="form_picture_file_name" size="50" maxlength="255"<?php if (isset($form_picture_file_name) && $form_picture_file_name != '') { echo " value=\"$form_picture_file_name\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_picture_file_name" id="select_picture_file_name" value="form_picture_file_name2" <?php if (isset($select_picture_file_name) && $select_picture_file_name == "form_picture_file_name2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_picture_file_name2" id="form_picture_file_name2" size="50" maxlength="255"<?php if (isset($form_picture_file_name2) && $form_picture_file_name2 != '') { echo " value=\"$form_picture_file_name2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Picture File Credit</td>
      <td class="data">
      <input type="radio" name="select_picture_file_credit" id="select_picture_file_credit" value="form_picture_file_credit" <?php if (isset($select_picture_file_credit) && $select_picture_file_credit == "form_picture_file_credit") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_picture_file_credit" id="form_picture_file_credit" size="50" maxlength="255"<?php if (isset($form_picture_file_credit) && $form_picture_file_credit != '') { echo " value=\"$form_picture_file_credit\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_picture_file_credit" id="select_picture_file_credit" value="form_picture_file_credit2" <?php if (isset($select_picture_file_credit) && $select_picture_file_credit == "form_picture_file_credit2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_picture_file_credit2" id="form_picture_file_credit2" size="50" maxlength="255"<?php if (isset($form_picture_file_credit2) && $form_picture_file_credit2 != '') { echo " value=\"$form_picture_file_credit2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">OP Notes</td>
      <td class="data">
      <input type="radio" name="select_op_notes" id="select_op_notes" value="form_op_notes" <?php if (isset($select_op_notes) && $select_op_notes == "form_op_notes") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" name="form_op_notes" id="form_op_notes" size="50" maxlength="65535"<?php if (isset($form_op_notes) && $form_op_notes != '') { echo " value=\"$form_op_notes\"";} ?>/>
      </td>
      <td class="data">
      <input type="radio" name="select_op_notes" id="select_op_notes" value="form_op_notes2" <?php if (isset($select_op_notes) && $select_op_notes == "form_op_notes2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" name="form_op_notes2" id="form_op_notes2" size="50" maxlength="65535"<?php if (isset($form_op_notes2) && $form_op_notes2 != '') { echo " value=\"$form_op_notes2\"";} ?>/>
      </td>
   </tr>
   <tr>
      <td class="titleright" bgcolor="#FFFFCC">Date Created</td>
      <td class="data">
      <input type="radio" name="select_date_created" id="select_date_created" value="form_date_created" <?php if (isset($select_date_created) && $select_date_created == "form_date_created") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_date_created" id="form_date_created" size="15" maxlength="10"<?php if (isset($form_date_created) && $form_date_created != '') { echo " value=\"$form_date_created\"";} ?>>
      </td>
      <td class="data">
      <input type="radio" name="select_date_created" id="select_date_created" value="form_date_created2" <?php if (isset($select_date_created) && $select_date_created == "form_date_created2") { echo ' CHECKED'; }?> />&nbsp;&nbsp;
      <input type="text" readonly="readonly" name="form_date_created2" id="form_date_created2" size="15" maxlength="10"<?php if (isset($form_date_created2) && $form_date_created2 != '') { echo " value=\"$form_date_created2\"";} ?>>
      </td>
   </tr>
</table>
<?php
         $i = 0;
         for ($j = 0; $j < 2; $j++)
         {
            $a_id = $first_atlantian_id;
            $s_name = $form_sca_name;
            if ($j == 1)
            {
               $a_id = $second_atlantian_id;
               $s_name = $form_sca_name2;
            }
            $link = db_connect();
            $award_query = "SELECT atlantian_award.*, award.award_name, branch.branch, rg.branch AS rg, " .
                           "event.event_name, reign.monarchs_display, principality.principality_display, baronage.baronage_display, " .
                           "event_loc.branch as event_location " .
                           "FROM $DBNAME_OP.atlantian_award JOIN $DBNAME_OP.award ON atlantian_award.award_id = award.award_id " .
                           "JOIN $DBNAME_OP.precedence ON award.type_id = precedence.type_id " .
                           "LEFT OUTER JOIN $DBNAME_BRANCH.branch ON atlantian_award.branch_id = branch.branch_id " .
                           "LEFT OUTER JOIN $DBNAME_BRANCH.branch rg ON award.branch_id = rg.branch_id " .
                           "LEFT OUTER JOIN $DBNAME_OP.court_report ON atlantian_award.court_report_id = court_report.court_report_id " .
                           "LEFT OUTER JOIN $DBNAME_OP.event ON atlantian_award.event_id = event.event_id " .
                           "LEFT OUTER JOIN $DBNAME_BRANCH.branch event_loc ON event.branch_id = event_loc.branch_id " .
                           "LEFT OUTER JOIN $DBNAME_OP.reign ON court_report.reign_id = reign.reign_id " .
                           "LEFT OUTER JOIN $DBNAME_OP.principality ON court_report.principality_id = principality.principality_id " .
                           "LEFT OUTER JOIN $DBNAME_OP.baronage ON court_report.baronage_id = baronage.baronage_id " .
                           "WHERE atlantian_id = $a_id ORDER BY precedence, award_date, sequence";
            /* Performing SQL query */
            $award_result = mysql_query($award_query) 
               or die("Award Query failed : " . mysql_error());
            $num_awards = mysql_num_rows($award_result);
?>
<p align="center" class="title2">Awards for <?php echo $s_name; ?></p>
<p class="datacenter">
Click the Select checkbox next to an award to keep it with the merged record.<br/>
Uncheck the Select checkbox next to an award to delete it permanently from the OP database.<br/>
<img src="<?php echo $IMAGES_DIR; ?>private.gif" width="15" height="15" alt="Marked Private" border="0"/> Lock icon indicates record is marked private.
</p>
<?php
            if ($num_awards > 0)
            {
?>
<table align="center" cellpadding="5" cellspacing="0" border="1" summary="">
   <tr>
      <th class="title" bgcolor="#FFFFCC">Select</td>
      <th class="title" bgcolor="#FFFFCC">Award Name</td>
      <th class="title" bgcolor="#FFFFCC">Award Date</td>
      <th class="title" bgcolor="#FFFFCC">Event</td>
      <th class="title" bgcolor="#FFFFCC">Bestowed By</td>
      <th class="title" bgcolor="#FFFFCC">Sequence</td>
   </tr>
<?php
               while ($award_data = mysql_fetch_array($award_result, MYSQL_BOTH))
               {
                  $atlantian_award_id = $award_data['atlantian_award_id'];
                  $atlantian_id = $award_data['atlantian_id'];
                  $award_id = $award_data['award_id'];
                  $award_name = clean($award_data['award_name']);
                  $branch = clean($award_data['branch']);
                  $rg = clean($award_data['rg']);
                  $rg_display = $branch;
                  if ($rg_display == null || $rg_display == '')
                  {
                     $rg_display = $rg;
                  }
                  if ($rg_display != null && $rg_display != '')
                  {
                     $rg_display = " (" . $rg_display . ")";
                  }
                  $award_date = $award_data['award_date'];
                  if ($award_date == "" || $award_date == "0000-00-00")
                  {
                     $award_date = "<i>Unknown</i>";
                  }
                  else
                  {
                     $award_date = format_short_date($award_date);
                  }
                  $event_name = clean($award_data['event_name']);
                  $event_loc = clean($award_data['event_location']);
                  $event_name_display = $event_name;
                  if ($event_loc != "")
                  {
                     $event_name_display .= " (" . $event_loc . ")";
                  }
                  $bestow_display = "";
                  $monarchs_display = clean($award_data['monarchs_display']);
                  $principality_display = clean($award_data['principality_display']);
                  $baronage_display = clean($award_data['baronage_display']);
                  if ($monarchs_display != "")
                  {
                     $bestow_display = $monarchs_display;
                  }
                  else if ($baronage_display != "")
                  {
                     $bestow_display = $baronage_display;
                  }
                  else if ($principality_display != "")
                  {
                     $bestow_display = $principality_display;
                  }
                  $sequence = $award_data['sequence'];
                  $private = $award_data['private'];
                  $private_display = "";
                  if ($private == 1)
                  {
                     $private_display = "<img src=\"" . $IMAGES_DIR . "private.gif\" width=\"15\" height=\"15\" alt=\"Marked Private\" border=\"0\"/> ";
                  }
                  if ($event_name_display == "")
                  {
                     $event_name_display = "&nbsp;";
                  }
                  if ($bestow_display == "")
                  {
                     $bestow_display = "&nbsp;";
                  }
?>
   <tr>
      <td>
         <input type="checkbox" name="form_atlantian_award_id[]" id="form_atlantian_award_id" value="<?php echo $atlantian_award_id; ?>" checked="checked" />
      </td>
      <td class="data"><?php echo $award_name . $rg_display; ?></td>
      <td class="datacenter"><?php echo $award_date; ?></td>
      <td class="data"><?php echo $event_name_display; ?></td>
      <td class="data"><?php echo $bestow_display; ?></td>
      <td class="data"><?php echo $sequence; ?></td>
   </tr>
<?php
                  $i++;
               } // end while
?>
</table>
<?php
            } // end num_awards > 0
?>
<p align="center"><?php echo $num_awards; ?> award<?php if ($num_awards == 0 || $num_awards > 1) { echo "s"; } ?> given.</p>
<?php
         } // end for atlantian_ids
?>
<p class="datacenter">
<input type="submit" name="submit" id="submit" value="<?php echo $SUBMIT_MERGE; ?>"/>
</p>
</form>
<?php
         db_disconnect($link);
      } // else no selection
}
// Not authorized
else
{
include("header.php");
?>
<p align="center" class="title2">Merge Atlantian</p>
<p align="center" class="title2">You are not authorized to access this page.</p>
<?php
}
include("footer.php");
?>