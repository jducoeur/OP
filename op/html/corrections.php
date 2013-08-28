<?php 
$title = "Corrections";
include("header.php");

include("disabled.php");

$SUBMIT_REQUEST = "Request Correction";

// Data submitted
if (isset($_POST['submit']) && $_POST['submit'] == $SUBMIT_REQUEST)
{
   $form_sca_name = stripslashes(trim($_POST['form_sca_name']));
   $form_email = stripslashes(trim($_POST['form_email']));
   $form_correction = stripslashes(trim($_POST['form_correction']));

   $errmsg = "";

   // Verify data filled in
   if ($form_sca_name == '')
   {
      $errmsg .= "Please enter your SCA name.<br/>";
   }

   if ($form_email == '')
   {
      $errmsg .= "Please enter your email address.<br/>";
   }
   else if (!validate_email($form_email))
   {
      $errmsg .= "Please correct your email address to include one @ and no spaces.<br/>";
   }

   if ($form_correction == '')
   {
      $errmsg .= "Please enter your correction request.<br/>";
   }

   if (strlen($errmsg) == 0)
   {
      // Build Headers
      $headers = "From:  $form_sca_name <$form_email>\n";
      $headers .= "Sender:  <$OP_EMAIL>\n";
      $headers .= "X-Mailer:  PHP/" . phpversion() . "\n";

      // Build sender
      $sender = $form_sca_name . "\n" . $form_email;

      // Build subject
      $subject = "OP Correction Request\n";

      // Build Body
      $body = $subject . "\n";
      $body .= $form_correction . "\n";
      $body .= "\n" . $sender;

      //echo "<pre>$body</pre>"; // DEBUG

      $response = "Your request has been sent to the Clerk of Precedence.";
      // Send mail
      if (!mail($OP_EMAIL, $subject, $body, $headers))
      {
         $response = "We're sorry; we are unable to send your request at this time.  Please try again later.";
      }
   }
}
?>
<p class="title2" align="center">Request Corrections to the Order of Precedence</p>
<?php
if (isset($errmsg) && strlen($errmsg) > 0)
{
   echo '<p align="center" style="color:red;font-weight:bold">' . $errmsg . '</p>';
}
if (!isset($errmsg) || (isset($errmsg) && strlen($errmsg) > 0))
{
?>
<table align="center" width="80%" border="0" cellpadding="5" cellspacing="0" summary="table for layout">
   <tr>
      <td class="title2" align="center">OP CORRECTION REQUEST FORM</td>
   </tr>
   <tr>
      <td class="datacenter">
      Please fill in your SCA Name and Email so that the Clerk of Precedence may contact you regarding the status of your request.  
      <br/><br/>
      If you are submitting this request on behalf of someone else, you should still enter YOUR name and email address in the SCA Name and Email fields, and 
      include the SCA name of the person on whose behalf you are sending the request in the Correction Request field.  
      Otherwise it surprises people when I reply to emails they never sent, and you don't get to hear about the status of a request you made.  :)
      </td>
   </tr>
   <tr><td>&nbsp;</td></tr>
</table>

<form action="corrections.php" method="post">
<table align="center" border="1" cellpadding="5" cellspacing="0" summary="Request Form">
   <tr>
      <th colspan="2" class="title">Request</th>
   </tr>
   <tr>
      <th class="titleright"><label for="form_sca_name">SCA Name</label></th>
      <td class="data"><input type="text" name="form_sca_name" id="form_sca_name" size="50"<?php if (isset($form_sca_name) && $form_sca_name != '') { echo " value=\"$form_sca_name\"";} ?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_email">Email</label></th>
      <td class="data"><input type="text" name="form_email" id="form_email" size="50"<?php if (isset($form_email) && $form_email != '') { echo " value=\"$form_email\"";} ?>/></td>
   </tr>
   <tr>
      <th class="titleright"><label for="form_correction">Correction Request</label></th>
      <td class="data">
      <textarea name="form_correction" id="form_correction" rows="8" cols="60"><?php if (isset($form_correction) && $form_correction != '') { echo $form_correction;} ?></textarea>
      </td>
   </tr>
   </tr>
   <tr>
      <th colspan="2" class="title"><input type="submit" name="submit" value="<?php echo $SUBMIT_REQUEST; ?>"/></th>
   </tr>
</table>
</form>
<br/>
<p class="title2" align="center">Device Images</p>
<table align="center" width="80%" border="0" cellpadding="5" cellspacing="0" summary="table for layout">
   <tr>
      <td class="data">
      If you have an image of your device that you would like to have included on the OP and Order web sites, please send an email to <b>op AT atlantia.sca.org</b>.
      <br/><br/>
      The email should include:
      <ul>
         <li>Your legal name</li>
         <li>Permission to use the image on atlantia.sca.org web sites</li>
         <li>Your full SCA name, as listed on the OP site, so your device can be linked up properly to your data</li>
         <li>Your device image attached</li>
      </ul>
      The preferred image format is a GIF image with a transparent background, sized about 200 x 240 pixels.  JPG and BMP images will also be accepted.  
      Please ask first (via email, op AT atlantia.sca.org) before sending other image formats to confirm they can be converted.
      </td>
   </tr>
</table>
<?php
}
else
{
?>
<p align="center"><?php echo $response; ?></p>
<?php
}
include("footer.php");
?>



