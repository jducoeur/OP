<?php
// redirect
// Purpose: Redirects page to new relative URL
function redirect($url)
{
   if (headers_sent()) 
   {
      return false;
   }
   else
   {
      $protocol = strtolower(strtok($_SERVER['SERVER_PROTOCOL'], "/"));
      $host = $_SERVER['SERVER_NAME'];
      $port = "";
      if (($protocol == "http" && $_SERVER['SERVER_PORT'] != 80) ||
         ($protocol == "https" && $_SERVER['SERVER_PORT'] != 443))
      {
         $port = ":" . $_SERVER['SERVER_PORT'];
      }
      $path = dirname($_SERVER['PHP_SELF']);
      if (substr($url, 1, 1) != "/")
      {
         $url = "/" . $url;
      }
      else
      {
         $path = "";
      }
      header("Location: $protocol://$host$port$path$url");
      exit();
   }
}

/**
 * Returns the email address with "@" replaced by " AT "
 * @param email The email address to convert
 * @return String The email address formatted for spam reduction
 */
function format_email($email)
{
   $good_email = str_replace ('@', ' AT ', $email);
   return $good_email;
}

/**
 * Returns the email address with "@" replaced by " AT " using the mailto.php link
 * @param email The email address to convert
 * @return String The email address formatted for spam reduction
 */
function format_link_email($email)
{
   $good_email = "<a href=\"" . $HOME_DIR . "functions/mailto.php?u=" . strtok($email, "@") . "&amp;d=" . strtok("@") . "\" target=\"redir\">" . str_replace ('@', ' AT ', $email) . "</a>";
   return $good_email;
}

function value_or_null($value)
{
   $retval = 'NULL';
   if (trim($value) != '' && trim($value) != 'NULL')
   {
      $retval = quote_smart(trim($value));
   }
   return $retval;
}

function value_or_zero($value)
{
   $retval = 0;
   if (trim($value) != '')
   {
      $retval = quote_smart(trim($value));
   }
   return $retval;
}

function date_value_or_null($value)
{
   $retval = 'NULL';
   if (trim($value) != '' && trim($value) != 'NULL')
   {
      $retval = quote_smart(trim($value));
   }
   return $retval;
}

function validate_date($date_field)
{
   $retval = true;
   if (strtotime($date_field) === FALSE)
   {
      $retval = false;
   }
   return $retval;
}

function validate_date_format($date_field)
{
   $retval = true;
   if (!(preg_match('/\d\d\d\d\-\d\d\-\d\d/', $date_field) > 0))
   {
      $retval = false;
   }
   else
   {
      $year = substr($date_field, 0, 4);
      $month = substr($date_field, 5, 2);
      $day = substr($date_field, 8, 2);
      if ($year < 1966 || $year > 2050)
      {
         $retval = false;
      }
      else if ($month < 1 || $month > 12)
      {
         $retval = false;
      }
      else if ($day < 1 || $day > 31)
      {
         $retval = false;
      }
      else if (($month == 2 && $day > 29) ||
               (($month == 4 || $month == 6 || $month == 9 || $month == 11) && $day > 30))
      {
         $retval = false;
      }
   }
   return $retval;
}

function validate_date_time_format($date_time_field)
{
   $retval = true;
   if (!validate_date_format($date_time_field))
   {
      $retval = false;
   }
   else if (!(preg_match('/\d\d\d\d\-\d\d\-\d\d \d\d:\d\d:\d\d/', $date_time_field) > 0))
   {
      $retval = false;
   }
   else
   {
      $hour = substr($date_time_field, 11, 2);
      $minute = substr($date_time_field, 14, 2);
      $second = substr($date_time_field, 17, 2);
      if ($hour < 0 || $hour > 23)
      {
         $retval = false;
      }
      else if ($minute < 0 || $minute > 59)
      {
         $retval = false;
      }
      else if ($second < 0 || $second > 59)
      {
         $retval = false;
      }
   }
   return $retval;
}

function validate_email($email)
{
   $retval = true;
   // Verify email has @ and no spaces
   $AT_SIGN = "@";
   $SPACE = " ";
   $test_email = strip_tags(html_entity_decode(trim($email)));
   $firstpos = strpos($test_email, $AT_SIGN);
   $lastpos = strrpos($test_email, $AT_SIGN);
   $spacepos = strpos($test_email, $SPACE);
   if ($firstpos === false || $firstpos == 0 || $firstpos != $lastpos || ($lastpos == (strlen($test_email) - 1)) || !($spacepos === false))
   {
      $retval = false;
   }
   return $retval;
}

function validate_number($number)
{
   $retval = true;
   $num_check = strip_tags(trim($number));
   if (!is_numeric($num_check))
   {
      $retval = false;
   }
   return $retval;
}

function validate_range_number($number, $min, $max)
{
   $retval = true;
   $num_check = strip_tags(trim($number));
   if (!is_numeric($num_check))
   {
      $retval = false;
   }
   else if (is_numeric($num_check))
   {
      if (is_numeric($min))
      {
         if (!($num_check >= $min))
         {
            $retval = false;
         }
      }
      if (is_numeric($max))
      {
         if (!($num_check <= $max))
         {
            $retval = false;
         }
      }
   }
   return $retval;
}

function validate_positive_number($number)
{
   return validate_range_number($number, 1, 'NULL');
}

function validate_zero_plus_number($number)
{
   return validate_range_number($number, 0, 'NULL');
}

function validate_integer($number)
{
   $retval = true;
   $num_check = strip_tags(trim($number));
   if (!is_numeric($num_check) || strstr($num_check, "."))
   {
      $retval = false;
   }
   return $retval;
}

function validate_range_integer($number, $min, $max)
{
   $retval = true;
   $num_check = strip_tags(trim($number));
   if (!validate_integer($num_check))
   {
      $retval = false;
   }
   else
   {
      if (is_numeric($min))
      {
         if (!($num_check >= $min))
         {
            $retval = false;
         }
      }
      if (is_numeric($max))
      {
         if (!($num_check <= $max))
         {
            $retval = false;
         }
      }
   }
   return $retval;
}

function validate_positive_integer($number)
{
   return validate_range_integer($number, 1, 'NULL');
}

function validate_zero_plus_integer($number)
{
   return validate_range_integer($number, 0, 'NULL');
}

function clean($str)
{
   return html_entity_decode(stripslashes(strip_tags(trim($str))));
}

function format_full_month_date($date_field)
{
   return date("F Y", strtotime($date_field));
}

function format_full_date($date_field)
{
   return date("F j, Y", strtotime($date_field));
}

function format_short_month_date($date_field)
{
   return date("n/Y", strtotime($date_field));
}

function format_short_date($date_field)
{
   return date("n/j/Y", strtotime($date_field));
}

function format_sca_date($date_field)
{
   $date_str = date("F j, Y", strtotime($date_field));
   $date_str .= " (AS " . get_AS_year($date_field) . ")";
   return $date_str;
}

function get_AS_year($date_field)
{
   $AS1_YEAR = 1966;
   $AS1_MONTH = 5;
   $time_field = strtotime($date_field);
   $year = date("Y", $time_field);
   $month = date("n", $time_field);

   if ($month >= $AS1_MONTH)
   {
      $current_as_year = $year - $AS1_YEAR + 1;
   }
   else
   {
      $current_as_year = $year - $AS1_YEAR;
   }
   return $current_as_year;
}

function format_time($time_field)
{
   return date("g:i A", strtotime($time_field));
}

/* Format phone number into (123) 456-7890 format */
function format_phone($phone)
{
   $phone_number = $phone;
   // Are we in the wrong format?
   if (!(preg_match('/(\d\d\d) \d\d\d\-\d\d\d\d/', $phone) > 0))
   {
      // Remove spaces and punctuation
      $phone_tmp = str_replace ('.', '', $phone_number);
      $phone_tmp = str_replace ('-', '', $phone_tmp);
      $phone_tmp = str_replace ('(', '', $phone_tmp);
      $phone_tmp = str_replace (')', '', $phone_tmp);
      $phone_tmp = str_replace (' ', '', $phone_tmp);
      if (preg_match('/\d\d\d\d\d\d\d\d\d\d/', $phone_tmp) > 0)
      {
         $phone_number = '(' . substr($phone_tmp, 0, 3) . ') ' . substr($phone_tmp, 3, 3) . '-' . substr($phone_tmp, 6, 4);
         if (strlen($phone_tmp) > 10)
         {
            $phone_number .= " " . substr($phone_tmp, 10);
         }
      }
   }
   return $phone_number;
}

function validate_phone($phone)
{
   $retval = true;
   // Verify phone has 10 digits, separated by parens, periods and/or spaces
   $regex = '/^[(]?[2-9]{1}[0-9]{2}[) -.]{0,2}' . '[2-9]{1}[0-9]{2}[- .]?' . '[0-9]{4}[ ]?' . '((x|ext)[.]?[ ]?[0-9]{1,5})?$/';
   $test_phone = strip_tags(html_entity_decode(trim($phone)));
   if (preg_match($regex, $test_phone) == 0)
   {
      $retval = false;
   }
   return $retval;
}

function format_money($money_field)
{
   return "$" . number_format($money_field, 2);
}

function is_active($last_login)
{
   $active = 0;
   $curr_year = date("Y");
   $last_year = $curr_year - 1;
   $curr_day = date("-m-d");
   $a_year_ago = $last_year . $curr_day;
   $log_date = format_mysql_date($last_login);
   if ($log_date > $a_year_ago)
   {
      $active = 1;
   }
   return $active;
}

function value_or_nbsp($value)
{
   $retval = $value;
   if (trim($value) == '')
   {
      $retval = "&nbsp";
   }
   return $retval;
}
?>