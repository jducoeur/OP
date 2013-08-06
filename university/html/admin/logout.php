<?php
include('../db/session.php');
include_once("../db/defines.php");

if (isset($_SESSION['s_username']))
{
   $old_user = $_SESSION['s_username'];
   unset($_SESSION['s_username']);
}
if (isset($_SESSION['s_user_id']))
{
   unset($_SESSION['s_user_id']);
}
if (isset($_SESSION['s_atlantian_id']))
{
   unset($_SESSION['s_atlantian_id']);
}
if (isset($_SESSION['s_sca_name']))
{
   unset($_SESSION['s_sca_name']);
}
if (isset($_SESSION['s_email']))
{
   unset($_SESSION['s_email']);
}

// Special Admin privileges
if (isset($_SESSION[$OP_ADMIN]))
{
   unset($_SESSION[$OP_ADMIN]);
}
if (isset($_SESSION[$BACKLOG_ADMIN]))
{
   unset($_SESSION[$BACKLOG_ADMIN]);
}
if (isset($_SESSION[$AWARD_ADMIN]))
{
   unset($_SESSION[$AWARD_ADMIN]);
}
if (isset($_SESSION[$SPIKE_ADMIN]))
{
   unset($_SESSION[$SPIKE_ADMIN]);
}
if (isset($_SESSION[$UNIVERSITY_ADMIN]))
{
   unset($_SESSION[$UNIVERSITY_ADMIN]);
}

// GOofS Admin privileges
if (isset($_SESSION[$SENESCHAL_ADMIN]))
{
   unset($_SESSION[$SENESCHAL_ADMIN]);
}
if (isset($_SESSION[$EXCHEQUER_ADMIN]))
{
   unset($_SESSION[$EXCHEQUER_ADMIN]);
}
if (isset($_SESSION[$HERALD_ADMIN]))
{
   unset($_SESSION[$HERALD_ADMIN]);
}
if (isset($_SESSION[$MARSHAL_ADMIN]))
{
   unset($_SESSION[$MARSHAL_ADMIN]);
}
if (isset($_SESSION[$MOL_ADMIN]))
{
   unset($_SESSION[$MOL_ADMIN]);
}
if (isset($_SESSION[$MOAS_ADMIN]))
{
   unset($_SESSION[$MOAS_ADMIN]);
}
if (isset($_SESSION[$CHRONICLER_ADMIN]))
{
   unset($_SESSION[$CHRONICLER_ADMIN]);
}
if (isset($_SESSION[$CHIRURGEON_ADMIN]))
{
   unset($_SESSION[$CHIRURGEON_ADMIN]);
}
if (isset($_SESSION[$WEBMINISTER_ADMIN]))
{
   unset($_SESSION[$WEBMINISTER_ADMIN]);
}
if (isset($_SESSION[$CHATELAINE_ADMIN]))
{
   unset($_SESSION[$CHATELAINE_ADMIN]);
}

// Order Admin privileges
for ($i = 1; $i <= count($ORDER_ARRAY); $i++)
{
   if (isset($_SESSION[$ORDER_ARRAY[$i]['auth']]))
   {
      unset($_SESSION[$ORDER_ARRAY[$i]['auth']]);
   }
   if (isset($_SESSION[$ORDER_ARRAY[$i]['session_id_field']]))
   {
      unset($_SESSION[$ORDER_ARRAY[$i]['session_id_field']]);
   }
}
session_unset();
session_destroy();

include("../header.php");
?>
<p align="center" class="title2">Logout</p>
<?php

if (isset($old_user) && !empty($old_user))
{
   echo '<p style="text-align:center">Logged out.</p>';
}
else
{
   echo '<p style="text-align:center">You were not logged in.</p>';
}
?>
<p style="text-align:center"><a href="index.php">Return to Login</a></p>
<?php
include("../footer.php");
?>
