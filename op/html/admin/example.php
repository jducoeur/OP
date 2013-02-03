<?php
include_once('../db/host_defines.php');
include_once("session.php");

$dbhost = 'mysql.database.atlantia.sca.org';
$dbname = 'atlantia_op';
$user = 'atlantia_op';
$pass = 'password';  // Fill in your DB user password here

function db_connect()
{
   global $dbhost, $dbname, $user, $pass;
   
   /* Connecting, selecting database */
   $link = mysql_connect($dbhost, $user, $pass)
      or die("Could not connect: " . mysql_error());
   mysql_select_db($dbname) 
      or die("Could not select database");
   //echo "DEBUG: Open OP DB (Default): $link<br/>";
   return $link;
}

function db_disconnect($link)
{
   //echo "DEBUG: Close DB connection: $link<br/>";
   mysql_close($link);
}

function generate_password($uname)
{
   srand((double)microtime()*1000000);
   $ran = rand(0,1000000);
   $npasswd = "$ran$uname";
   $passwd = substr(md5($npasswd),0, 16);
   return $passwd;
}

/**
* Quote a variable to make it safe for SQL
*/
function quote_smart($value)
{
   // Stripslashes if we need to
   if (get_magic_quotes_gpc()) 
   {
      $value = stripslashes($value);
   }

   // Quote it if it's not a number
   if (!is_numeric($value)) 
   {
      $value = "'" . mysql_real_escape_string(trim($value)) . "'";
   }

   return $value;
}

/**
* Quote a variable to make it right for CSV load
*/
function csv_quote($value)
{
   // Stripslashes if we need to
   if (get_magic_quotes_gpc()) 
   {
      $value = stripslashes($value);
   }

   // Double quote it if it's not a number
   if (!is_numeric($value)) 
   {
      $value = "\"" . str_replace('"', '""', $value) . "\"";
   }

   return $value;
}

function format_mysql_date($date_field)
{
   return date("Y-m-d", strtotime($date_field));
}

/**
 * Converts the array data into a comma separated list suitable for an SQL IN clause
 */
function create_in_clause_from_array($arr)
{
   $in_clause = "";
   for ($i = 0; $i < count($arr); $i++)
   {
      if (strlen($in_clause) > 0)
      {
         $in_clause .= ",";
      }
      $in_clause .= $arr[$i];
   }
   return $in_clause;
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

function clean($str)
{
   return html_entity_decode(stripslashes(strip_tags(trim($str))));
}

?>