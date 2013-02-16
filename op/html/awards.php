<?php 
$title = "The Awards of the Kingdom of East";
include("header.php");
$pagewidth = "80%";
if (isset($printable) && $printable == 1)
{
   $pagewidth = 650;
}
?>
<p class="title2" align="center">The Awards of the Kingdom of <?php echo $KINGDOM_NAME; ?></p>

<p align="center">
<a href="awards.php"><?php echo $KINGDOM_ADJ; ?> Award Descriptions</a> | <a href="award_table_only.php"><?php echo $KINGDOM_ADJ; ?> Awards by Precedence</a> | <a href="award_discipline.php"><?php echo $KINGDOM_ADJ; ?> Awards by Discipline</a>
</p>

<table align="center" width="<?php echo $pagewidth; ?>" cellpadding="5" cellspacing="0" border="0" summary="">
   <tr>
      <td width="100%">
      <table align="center" width="100%" cellpadding="5" cellspacing="0" border="1" summary="">
         <tr>
            <th colspan="2" align="center" valign="middle" class="title">Kingdom of the <?php echo $KINGDOM_NAME; ?></th>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="images/east.gif" width="195" height="236" alt="Arms of <?php echo $KINGDOM_NAME; ?>" border="0"/></th>
            <td class="data"><b><?php echo $KINGDOM_NAME; ?></b> is the Second Kingdom of the Society for Creative Anachronism. </td>
         </tr>
      </table>
      <br/><br/>
      <table align="center" width="100%" cellpadding="5" cellspacing="0" border="1" summary="">
         <tr>
            <th width="40%" align="center" valign="middle" class="title">Royal Peerages</th>
            <td class="data">The Royal Peers of the East receive a Patent of Arms (PoA) at Their decoronation provided the Monarch stepping down did not already have a PoA or Bestowed Peerage prior to Their coronation. 
            The Queens or Consorts of East are inducted into the Order of the Rose upon completion of Their first reign of the order so deems appropriate.</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle" class="title">Landed/Territorial Baronage</th>
            <td class="data"></td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle" class="title">Court Baronage</th>
            <td class="data">In East, the Court Baronage may carry a Grant of Arms.</td>
         </tr>
      </table>
      <br/><br/>
      <table align="center" width="100%" cellpadding="5" cellspacing="0" border="1" summary="">
         <tr>
            <th colspan="2" align="center" valign="middle" class="title">Orders of High Merit</th>
         </tr>
         
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>silver_crescent.gif" width="130" height="130" alt="Badge of the Order of the Silver Crescent" border="0"/></th>
            <td class="data"><b>Order of the Silver Crescent:</b> The Order of the Silver Crescent may be given to gentles in the
              East Kingdom who have distinguished themselves by service to the Kingdom, whether by long service within one of the
              areas of the Kingdom whereby the entire Kingdom is held to benefit, or by continuing service in ways which directly 
              benefit a large portion of the Kingdom. First awarded June 13, A.S. 6 by Akbar III and Khadijah III.</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>otc.gif" width="130" height="130" alt="Badge of the Order of the Tyger's Combattant" border="0"/></th>
            <td class="data"><b>Order of the Tyger's Combattant:</b> The Order of the Tygers Combatant may be given to gentles in the
              East Kingdom who have distinguished themselves by prowess at arms, whether by attaining a standard of excellence such as 
              makes them noteworthy in the eyes of the Kingdom or by attempting more than one weapons form and, while not attaining 
              mastery in any one, surpassing competence in several. Established October 9, A.S. 11 by Laeghaire and Ysabeau II.</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>maunche.gif" width="130" height="130" alt="Badge of the Order of the Maunche" border="0"/></th>
            <td class="data"><b>Order of the Maunche:</b> The Order of the Maunche may be given to gentles in the East Kingdom who have 
              distinguished themselves by service to the arts and sciences, whether by attaining a standard of excellence as makes 
              them noteworthy in the eyes of the Kingdom or by attempting more than one art form and, while not attaining mastery in 
              any one, surpassing competence in several. Established October 9, A.S. 11 by Laeghaire and Ysabeau II.</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>sagitarius.gif" width="130" height="130" alt="Badge of the Order of the Sagitarius" border="0"/></th>
            <td class="data"><b>Order of the Sagitarius:</b> The Order of the Sagittarius may be give to gentles in the East 
              Kingdom who have shown superior prowess at the target archery range and have distinguished themselves in archery 
              in one of the following areas; teaching and demonstrating the art of archery, making archery equipment or by 
              helping to arrange archery at events and/or sites and thus demonstrating and overall impact to archery in the 
              Kingdom. Established January 22, A.S. 18 by Viktor and Sedalia.</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>ogr.gif" width="130" height="130" alt="Badge of the Order of the Golden Rapier" border="0"/></th>
            <td class="data"><b>Order of the Golden Rapier:</b> The Order of the Golden Rapier may be given to gentles in the East Kingdom who 
              have distinguished themselves by excellence in the art of fence by consistently demonstrating superior prowess in the lists, by 
              teaching, and by helping to promote and expand the knowledge of their art. Established April 26, A.S. 26 by Ruslan and Margaret.
            </td>
         </tr>
         
      </table>
      <br/><br/>
      
      <table align="center" width="100%" cellpadding="5" cellspacing="0" border="1" summary="">
         <tr>
            <th colspan="2" align="center" valign="middle" class="title">Non-Precedence Orders</th>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>qoc.gif" width="130" height="130" alt="Badge of the Queen's Order of Courtesy" border="0"/></th>
            <td class="data"><b>Queen's Order of Courtesy (QoC):</b> Presented by the consort to those who show exemplary courtesy to all. 
              The token is a right-hand glove bearing a blue rose charged with a gold rose. First awarded October 19, A.S. 9 by 
              Cariadoc II and Diana II.</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>tiger_cub.gif" width="130" height="130" alt="Badge of the Order of the Tyger's Cub" border="0"/></th>
            <td class="data"><b>The Order of the Tyger's Cub:</b> The Order of the Tyger's Cub may be awarded by the Crown to 
              children under the age of eighteen in the East Kingdom who have displayed admirable virtue and decorum at events. 
              The Companions of the Order will be entitled to act as pages to the Royalty of the East Kingdom until such time as 
              they reach the age of eighteen.</td> 
         </tr>
        <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>silver_rapier.gif" width="130" height="130" alt="Badge of the Order of the Silver Rapier" border="0"/></th>
            <td class="data"><b>The Order of the Silver Rapier:</b> Given for martial skill upon the rapier field. Established August 2, A.S. 43, by Konrad and Brenwen.</td>
         </tr>
      </table>
      <br/><br/>
      <table align="center" width="100%" cellpadding="5" cellspacing="0" border="1" summary="">
         <tr>
            <th colspan="2" align="center" valign="middle" class="title">Kingdom Awards</th>
         </tr>
         <tr>
            <td class="datacenter" colspan="2" valign="middle">The following awards are specific to the Kingdom of East. These awards carry no precedence, however that does not lessen their significance. 
            These awards are given as the Monarchs desire and recipients may receive each of these more than once.</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>burdened_tiger.gif" width="130" height="130" alt="Badge for the Order of the Burdened Tyger" border="0"/></th>
            <td class="data"><b>The Order of the Burdened Tyger:</b> The Order of the Burdened Tyger may be awarded by the Crown to those gentles 
              associated with running an event or an aspect of an event which the Crown attended, and which They feel was well above
              the normal standard of excellence in the East Kingdom. The Order of the Burdened Tyger is not to be presented at the 
              event for which it is being awarded. As the Order of the Burdened Tyger is awarded for a specific event, a gentle may 
              receive it any number of times for any number of different events. Established February 14, A.S. 10 by Aonghais II and 
              Ysabeau.</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>gawain.gif" width="130" height="130" alt="Badge for the Order of Gawain" border="0"/></th>
            <td class="data"><b>The Order of Gawain:</b> Given by the Crown to honor and recognize those young people, up to 
              and including the age of 17, who have distinguished themselves by acts of valor, honor, chivalry, courtesy, 
              and leadership within a youth martial activity.  Established by Gryffith and aikaterine, april 22, a.S. 41.</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>troub.gif" width="130" height="130" alt="Badge for the Troubadour" border="0"/></th>
            <td class="data"><b>The Troubadour:</b> Given for vocal entertainment, especially for encouraging others to participate.</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>terp.gif" width="130" height="130" alt="Badge for the Terpsichore" border="0"/></th>
            <td class="data"><b>The Terpsichore:</b> Given for consistent and unselfish devotion in teaching dance and polite court movement.</td>
         </tr>
         <tr> 
           <th width="40%" align="center" valign="middle" style="font-style:italic"></th>
           
              <td class="data"><b>King's Order of Excellence:</b> given by the Sovereign to those who maintain a high 
                standard of authenticity in their dress, behavior, persona, and goods, in the feast hall, in their 
                encampments, and on the field. Established 16 march, a.S. XXv by rhys and Elaina.</td>
         </tr>
         <tr> 
           <th width="40%" align="center" valign="middle" style="font-style:italic"></th>
           
              <td class="data"><b>Order of Artemis:</b> given by the Crown for prowess in combat archery on the field 
                of battle, who have demonstrated service to the Kingdom such as marshalling, commanding, building 
                equipment, teaching and service to the Queen on and off the field. (is award is bestowed upon a 
                single individual once.) Established by lucan and Yana, march 24, a.S. 41</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle" style="font-style:italic"></th>
            <td class="data"><b>The Tyger of the East:</b> given by the Crown to the individual who most embodies and personifies
              the ideals of the East Kingdom. This honor is infrequently granted. Established april 26, A.S. XXXvII by Darius and roxane</td>
         </tr>
         
      </table>
      <br/><br/>
    
      
     
      </td>
   </tr>
</table>
<?php include("footer.php");?>



