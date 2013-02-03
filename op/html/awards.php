<?php 
$title = "The Awards of the Kingdom of Atlantia";
include("header.php");
$pagewidth = "80%";
if (isset($printable) && $printable == 1)
{
   $pagewidth = 650;
}
?>
<p class="title2" align="center">The Awards of the Kingdom of Atlantia</p>

<p align="center">
<a href="awards.php">Atlantian Award Descriptions</a> | <a href="award_table_only.php">Atlantian Awards by Precedence</a> | <a href="award_discipline.php">Atlantian Awards by Discipline</a>
</p>

<table align="center" width="<?php echo $pagewidth; ?>" cellpadding="5" cellspacing="0" border="0" summary="">
   <tr>
      <td width="100%">
      <table align="center" width="100%" cellpadding="5" cellspacing="0" border="1" summary="">
         <tr>
            <th colspan="2" align="center" valign="middle" class="title">Kingdom of Atlantia</th>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="images/atlantia.gif" width="195" height="236" alt="Arms of Atlantia" border="0"/></th>
            <td class="data"><b>Atlantia</b> is the Eighth Kingdom of the Society for Creative Anachronism. It began as a principality of the East kingdom in the 11th year of the Society (1977). 
            Given due time, Atlantia came into her own and gained kingdom status in the sixteenth year of the Society (1981).</td>
         </tr>
      </table>
      <br/><br/>
      <table align="center" width="100%" cellpadding="5" cellspacing="0" border="1" summary="">
         <tr>
            <th width="40%" align="center" valign="middle" class="title">Royal Peerages</th>
            <td class="data">The Royal Peers of Atlantia receive a Patent of Arms (PoA) at Their decoronation provided the Monarch stepping down did not already have a PoA or Bestowed Peerage prior to Their coronation. 
            The Queens or Consorts of Atlantia are inducted into the Order of the Rose upon completion of Their first reign.</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle" class="title">Landed/Territorial Baronage</th>
            <td class="data">In Atlantia, the Landed/Territorial Baronage is Granted Arms at their investiture provided they do not already have a GoA or higher ranking accolade.</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle" class="title">Court Baronage</th>
            <td class="data">In Atlantia, the Court Baronage carries an Award of Arms per Corpora.</td>
         </tr>
      </table>
      <br/><br/>
      <table align="center" width="100%" cellpadding="5" cellspacing="0" border="1" summary="">
         <tr>
            <th colspan="2" align="center" valign="middle" class="title">Orders of High Merit</th>
         </tr>
         <tr>
            <td class="datacenter" colspan="2" valign="middle">As of April 1, 2003, Their Royal Majesties Cuan and Padraigin did institute a new set of Orders of Merit. The former Award of Arms 
            level Orders (Sea Stag, Kraken, Yew Bow, Golden Dolphin and Pearl) were changed to Grant Level, and are now Orders of High Merit. </td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>pearl.gif" width="130" height="130" alt="Badge of the Order of the Pearl" border="0"/></th>
            <td class="data"><b>Order of the Pearl:</b> Honors and recognizes those subjects of the Kingdom who have distinguished themselves by their efforts and willingness to teach other subjects 
            of the Society the arts and sciences of the period, and/or their excellence in the arts and sciences of the period.  
            This was formerly an AoA level, polling order.  As of April 1, 2003, the Pearl became a Grant level polling order. 
            The first Pearl was given to Muirean nic Ruaidhri, while Atlantia was a principality on April 29, 1977, during the reign of TRH Alaric and Yseult.</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>sea_stag.gif" width="130" height="130" alt="Badge of the Order of the Sea Stag" border="0"/></th>
            <td class="data"><b>Order of the Sea Stag:</b> Honors and recognizes those subjects who have distinguished themselves by their teaching of armored combat, rapier combat, combat and target archery, 
            thrown weapons, siege warfare, or youth combat.  
            This was formerly an AoA level, polling order.  As of April 1, 2003, the Sea Stag became a Grant level polling order, and was expanded to include all martial disciplines, not just heavy weapons. 
            Jacques Martel de Normande, called the Jovial was the first recipient of this award on June 11, 1977, given during the reign of TRH Laeghaire and Ysabeau.</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>golden_dolphin.gif" width="130" height="130" alt="Badge of the Order of the Golden Dolphin" border="0"/></th>
            <td class="data"><b>Order of the Golden Dolphin:</b> Honors and recognizes those subjects of the Kingdom who have distinguished themselves by their exceptional service and leadership in the Kingdom of Atlantia. 
            This was formerly an AoA level, polling order.  As of April 1, 2003, the Golden Dolphin became a Grant level polling order. 
            The first member of the Golden Dolphin was Vuong Manh, received while Atlantia was still a principality, on July 16, 1977, during the reign of TRH Laeghaire and Ysabeau.</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>yew_bow.gif" width="130" height="130" alt="Badge of the Order of the Yew Bow" border="0"/></th>
            <td class="data"><b>Order of the Yew Bow:</b> Honors and recognizes those subjects who have distinguished themselves by their excellence with bow and arrow (both target and combat), thrown weapons, or siegecraft. 
            In November 1993, the former Order of the King's Missiliers, for combat archery, and the former order of the Nimrod, for target archery, were closed, and their recipients were considered recipients of the new (now former) Award of Yew and Sinew.
            The award was later renamed the Yew Bow.  The award was closed and the order created as an AoA level, polling order on January 1, 2002.  
            All recipients of the former Award of the Yew Bow are considered to be members of this order. 
            As of April 1, 2003, the Yew Bow became a Grant level polling order, and was expanded from just archery to include siege and thrown weapons. 
            The first to receive this accolade at the hands of TRM Baudoin and Caterina were Randall Arrowsmith (under the name Order of the King's Missiliers) 
            and Aelfred of Cres (under the name Order of the Nimrod) on October 3, 1987.</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>white_scarf.gif" width="130" height="130" alt="Badge of the Order of the White Scarf" border="0"/></th>
            <td class="data"><b>The Academie d'Espee, Order of the White Scarf of Atlantia:</b> Given to those subjects who have excelled in the exercise and advance of the noble art of fence, and have distinguished 
            themselves as examples of the precepts to which it is devoted. Recipient will have "played the prize" for this accolade.  
            The Academie d'Espee was originally a non-armigerous award, created in April 1993.  TRM Cuan and Arianwen did confer the first upon Niall McKennett on April 3, 1993.
            With the signing of the White Scarf Treaty, the award was closed on April 20, 1996, and the new Order of the White Scarf, an AoA level order, replaced it.  
            TRM Galmr and Katharina bestowed the first White Scarf to Godfrey de la Fosse on April 20, 1996, followed by the other 13 members of the Academie.
            As of October 1, 2001, the White Scarf became a Grant Level, polling order. </td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>kraken.gif" width="130" height="130" alt="Badge of the Order of the Kraken" border="0"/></th>
            <td class="data"><b>Order of the Kraken:</b> Honors and recognizes those non-belted fighters who have distinguished themselves by consistent excellence on the field. 
            All past recipients of the non-armigerous Award of the Kraken (established April 1996, closed January 2002) will be considered to be recipients of this award. 
            The Order of the Kraken was created as an AoA level, non-polling order on January 1, 2002.  As of April 1, 2003, the Kraken became a Grant level polling order. 
            The first Kraken was given on March 17, 1996, to Bors Borden by TRM Cuan and Brigit.</td>
         </tr>
      </table>
      <br/><br/>
      <table align="center" width="100%" cellpadding="5" cellspacing="0" border="1" summary="">
         <tr>
            <th colspan="2" align="center" valign="middle" class="title">Orders of Merit</th>
         </tr>
         <tr>
            <td class="datacenter" colspan="2" valign="middle">As of April 1, 2003, Their Royal Majesties Cuan and Padraigin did institute a new set of Orders of Merit. The former Award of Arms 
            level Orders (Sea Stag, Kraken, Yew Bow, Golden Dolphin and Pearl) were changed to Grant Level. The following Orders have been added to the Atlantian Award Structure. </td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>opal.gif" width="130" height="130" alt="Badge for the Order of the Opal" border="0"/></th>
            <td class="data"><b>The Order of the Opal:</b> Honors and recognizes those subjects of the Kingdom who have distinguished themselves by their service to Atlantia. 
            This award conveys an Award of Arms to those who do not already have an AoA. 
            The first recipient of this accolade was Gwendolyn Tremayne, given by Their Royal Majesties Cuan and Padraigin at Their Last Court on April 5, 2003.</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>coral_branch.gif" width="130" height="130" alt="Badge for the Order of the Coral Branch" border="0"/></th>
            <td class="data"><b>The Order of the Coral Branch:</b> Honors and recognizes those subjects of the Kingdom who have distinguished themselves in their effort in arts and sciences of the period. 
            This is also a non-polling order that conveys an Award of Arms to those that do not already have one.  This award was briefly known as the Bright Leaf, until January 2004.
            Their Royal Majesties Logan and Isabel gave Halima al Shafi the first Coral Branch at Their First Court on April 5, 2003.</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>silver_osprey.gif" width="130" height="130" alt="Badge for the Order of the Silver Osprey" border="0"/></th>
            <td class="data"><b>The Order of the Silver Osprey:</b> Honors and recognizes those non-belted fighters who have distinguished themselves by consistent effort on the field. 
            As with the Opal and Coral Branch, the Silver Osprey is an Award of Arms level, non-polling order. 
            The first Silver Osprey was conveyed to Melchior der Graowulf by Their Royal Majesties Logan and Isabel at the Feast of Thirty on May 17, 2003.</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>kings_missiliers.gif" width="130" height="130" alt="Badge for the Order of the King's Missiliers" border="0"/></th>
            <td class="data"><b>The Order of the King's Missiliers:</b> Honors and recognizes those subjects who have distinguished themselves by their effort with bow and arrow (both target and combat), 
            thrown weapons, and siege craft. 
            This, as with the rest of the Orders of Merit, is a non-polling, Award of Arms level order.  This is NOT the former award, this is a new one, just the same name.  
            The first member of this Order of the King's Missiliers was Briana Maclukas, given by Their Royal Majesties Ragnarr and Kyneburh at Twelfth Night on January 10, 2004.</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>sea_dragon.gif" width="130" height="130" alt="Badge for the Order of the Sea Dragon" border="0"/></th>
            <td class="data"><b>The Order of the Sea Dragon:</b> Honors and recognizes rapier fighters who have distinguished themselves by consistent effort on the field.  The Sea Dragon is an Award of Arms level, 
            non-polling order, created in January 2004. The first Sea Dragon was conveyed to Dante di Pietro by Their Royal Majesties Cuan and Padraigin at the Night of Fools on April 17, 2004.</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>quintain.gif" width="130" height="130" alt="Badge for the Order of the Quintain" border="0"/></th>
            <td class="data"><b>The Order of the Quintain:</b> Honors and recognizes those who have distinguished themselves and shown excellence in the pursuit of equestrian activities, in service or valor.
            The Quintain is an Award of Arms level, non-polling order, created in January 2007. 
            The first Quintain was conveyed to Afshin Darius by Their Royal Majesties Valharic and Arielle at the Tournament of Chivalry on April 21, 2007.</td>
         </tr>
      </table>
      <br/><br/>
      <table align="center" width="100%" cellpadding="5" cellspacing="0" border="1" summary="">
         <tr>
            <th colspan="2" align="center" valign="middle" class="title">Non-Precedence Orders</th>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>qoc.gif" width="130" height="130" alt="Badge of the Queen's Order of Courtesy" border="0"/></th>
            <td class="data"><b>Queen's Order of Courtesy (QoC):</b> Given by the Queen to those subjects she deems worthy by reason of their consistently exemplary courtesy to subjects of all ranks in the Realm 
            and in the Society at large. The Queen may call upon the members to assist her with their aid or advice in encouraging courteous behavior, whenever she may deem this necessary, 
            and the members are bound to assist the Queen to the best of their abilities. The token given is usually a medallion bearing an escallop. This award is different from the 
            Orders of Merit and Orders of High Merit in that it conveys no arms. The first was given to Vuong Manh on April 16, 1977, during the reign of TRH Alaric and Yseult.</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>nonpareil.gif" width="130" height="130" alt="Badge of the Order of the Nonpareil" border="0"/></th>
            <td class="data"><b>The Order of the Nonpareil:</b> Honors and recognizes those who have shown excellence, honor, courtesy or chivalry above and beyond any duty. The members of this Order exemplify 
            what it means to be an Atlantian. This award may be given only once per reign and is conveyed solely at the discretion of the Crown. <!--Each member may receive this accolade but once. -->
            There is no precedence for this accolade, however, it is probably the highest honor one who lives in Atlantia could be given. 
            TRM Kane and Muirgen at the Tourney of Ymir conveyed this accolade unto Forgal Kerstetter on the February 26, 1994.</td>
         </tr>
      </table>
      <br/><br/>
      <table align="center" width="100%" cellpadding="5" cellspacing="0" border="1" summary="">
         <tr>
            <th colspan="2" align="center" valign="middle" class="title">Kingdom Awards</th>
         </tr>
         <tr>
            <td class="datacenter" colspan="2" valign="middle">The following awards are specific to the Kingdom of Atlantia. These awards carry no precedence, however that does not lessen their significance. 
            These awards are given as the Monarchs desire and recipients may receive each of these more than once.</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>sharks_tooth.gif" width="130" height="130" alt="Badge for the Award of the Shark's Tooth" border="0"/></th>
            <td class="data"><b>The Shark's Tooth:</b> Recognizes and honors those who have performed acts of valor for the Kingdom of Atlantia. This award is the gift of the King and Queen jointly or individually. 
            The first Shark's Tooth was presented to Cunen Beornhelm on October 3, 1987, at the Coronation of Boudoin and Caterina.</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>silver_nautilus.gif" width="130" height="130" alt="Badge for the Award of the Silver Nautilus" border="0"/></th>
            <td class="data"><b>The Award of the Silver Nautilus:</b> Honors and recognizes those who have distinguished themselves by an extraordinary achievement in the Arts and Sciences. This award is the gift 
            of the King and Queen jointly or individually.  The award was created in April 1996.  Alessandro di Firenze was the first to receive this accolade on April 13, 1996, at the hands of TRM Cuan and Brigit.</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>fountain.gif" width="130" height="130" alt="Badge for the Award of the Fountain" border="0"/></th>
            <td class="data"><b>The Fountain:</b> Recognizes and honors those who have performed acts of service for the Kingdom of Atlantia. This award is the gift of the King and Queen jointly or individually. 
            The award was created, though unnamed, in January 2002.  The first Fountain was given by TRM Cuan and Padraigin at Gulf Wars to James of Middle Aston on March 13, 2003.</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle" style="font-style:italic"><img src="<?php echo $AWARD_IMAGE_DIR; ?>kae.gif" width="130" height="130" alt="Example Badge for the King's Award of Excellence" border="0"/>
            <br/>The Badge for a KAE is typically<br/>the initial of the name of the giving King<br/>in blue on a gold rondel</th>
            <td class="data"><b>The King's Award of Excellence (KAE):</b> Honors and recognizes those who have distinguished themselves by their excellent contributions to the Kingdom of Atlantia. This award is 
            a gift solely of the King to whomever he deems deserving. The recipients of this award shall be entitled to wear a gold pendant upon which is scribed, in blue, the initial of the given 
            name of the King who bestowed the award. The first recipient of the KAE was at the hands of HRM Galmr to Henry Best on November 8, 1991.</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle" style="font-style:italic"><img src="<?php echo $AWARD_IMAGE_DIR; ?>undine.gif" width="130" height="130" alt="Example Badge for the Award of the Undine" border="0"/>
            <br/>The Badge for an Undine is typically<br/>the initial of the name of the giving Queen<br/>in gold on a blue rondel</th>
            <td class="data"><b>The Undine:</b> Honors and recognizes those subjects who have distinguished themselves with exceptional service to the Queen of Atlantia. This award is a gift solely of the Queen 
            to whomever she deems deserving. The recipients of this award shall be entitled to wear a blue pendant upon which shall be scribed, in gold, the initial of the given name of the Queen 
            who bestowed the award. The first Undine was given while Atlantia was still a Principality on September 24, 1977, to Thomas Edmund de Warrick at the Investiture of Laeghaire and Ysabeau.</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>herring.gif" width="130" height="130" alt="Badge for the Award of the Herring" border="0"/></th>
            <td class="data"><b>The Award of the Herring:</b> Honors and recognizes those who have distinguished themselves by extraordinary achievement as autocrats. 
            This award was added to kingdom law in February 2000.  It has also been called the Award of the Silver Herring.
            Ann Etheridge of Somerset was given this recognition while Atlantia was still a principality on May 28, 1977, during the reign of TRH Alaric and Yseult.</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>vexillum_atlantiae.gif" width="130" height="130" alt="Badge for the Award of the Vexillum Atlantiae" border="0"/></th>
            <td class="data"><b>The Vexillum Atlantiae:</b> Recognizes and honors groups who have performed acts of valor for the Kingdom of Atlantia. This award is the gift of the King and Queen jointly or individually. 
            The award was created in June 2007.  The first Vexillum Atlantiae was given by TRM Valharic and Arielle at Pennsic War to the heavy fighters of Windmasters' Hill on August 10, 2007.</td>
         </tr>
      </table>
      <br/><br/>
      <table align="center" width="100%" cellpadding="5" cellspacing="0" border="1" summary="">
         <tr>
            <th colspan="2" align="center" valign="middle" class="title">Youth Awards</th>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>sea_urchin.gif" width="130" height="130" alt="Badge for the Award of the Sea Urchin" border="0"/></th>
            <td class="data"><b>The Award of the Sea Urchin:</b> Honors and recognizes those young people (up to and including the age of 17) who have distinguished themselves by their contributions to the Kingdom of Atlantia in service, martial activities and/or arts and sciences. 
            With the addition of the Hippocampus in August 1998, the eligible recipients for this award were changed from children age 16 and under to children age 12 and under. 
            In February 2009, this recognition was designated an award and the age range expanded to all youth 17 and under.
            The first Sea Urchin was given to Elizabeth of Marinus on September 26, 1992, at the hands of TRM Steffan and Twila.</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>hippocampus.gif" width="130" height="130" alt="Badge fore the Award of the Hippocampus" border="0"/></th>
            <td class="data"><b>The Order of the Hippocampus:</b> Honors and recognizes those young people (up to and including the age of 17), whose service and contributions to the Kingdom of Atlantia have distinguished them in the eyes of 
            the Crown and Kingdom. 
            This award was created in August 1998, originally for youth ages 10 to 17.  In February 2009, this award was elevated to an order and the age range expanded to all youth 17 and under.  
            Wil Elmsford was the first recipient of this award at Pennsic, on August 12, 1998, as given by TRM Michael and Seonaid.</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>sea_tyger.gif" width="130" height="130" alt="Badge for the Award of the Sea Tyger" border="0"/></th>
            <td class="data"><b>The Order of the Sea Tyger:</b>  Honors and recognizes those young people (up to and including the age of 17) who have distinguished themselves by acts of valor 
            and chivalry on the Youth Combat field.  In February 2009, this award was elevated to an order.
            This award was established by TRM Michael and Seonaid in August, 2006.  They gave the first Sea Tyger to Jasmine Mcklinchey during Their Last Court on September 2, 2006.</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>alcyon.gif" width="130" height="130" alt="Badge for the Award of the Alcyon" border="0"/></th>
            <td class="data"><b>The Order of the Alcyon:</b> Honors and recognizes those young people (up to and including the age of 17) who have distinguished themselves by their labors and
            achievements in the arts and sciences.  In February 2009, this award was elevated to an order.
            This award was established by TRM Michael and Seonaid in August, 2006.  They gave the first Alcyon to William Simoneson during Their Last Court on September 2, 2006.</td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>arielle.gif" width="130" height="130" alt="Badge for the Award of Arielle" border="0"/></th>
            <td class="data"><b>The Award of Arielle:</b> Honors and recognizes those young people (up to and including the age of 17) who have distinguished themselves by acts of courtesy. 
            This award was established by TRM Logan and Isabel in August, 2003.  They gave the first, and only, Golden Gazelle to Katerina Sina Samovicha during Their Last Court on September 6, 2003.
            The Golden Gazelle was closed in September 2006.  The award was reestablished as the Award of Arielle by TRM Jason and Gerhild in February 2009.
            </td>
         </tr>
         <tr>
            <th width="40%" align="center" valign="middle"><img src="<?php echo $AWARD_IMAGE_DIR; ?>royal_aug.gif" width="130" height="130" alt="Badge of the Royal Augmentation of Arms" border="0"/></th>
            <td class="data"><b>Royal Augmentation of Arms:</b> In Atlantia, children under the age of 18 of the reigning King and Queen may be referred to as 
            Prince(ss) Royale.  This status is limited to the duration of the reign and conveys no precedence beyond the reign. 
            At the conclusion of the reign, the Crown may gift these children with a Royal Augmentation of Arms, an escallop purpure.
            This award was established by TRM Sinclair and Kari in June 2008 and awarded to all qualifying children of Their Majesties and Their
            predecessors at that time.
            </td>
         </tr>
      </table>
      <p class="blurb">
      This article was compiled straight from the Great Book of Law for the Kingdom of Atlantia (<a href="http://law.atlantia.sca.org">http://law.atlantia.sca.org</a>) with input from the article 
      written by Mistress Jessa d'Avondale. 
      <br/><br/>
      Updated by Mistress Mordeyrn Tremayne with special thanks to the Atlantian College of Heralds, Mistress Jaelle, Angelus Tremayne, and Lady Alianor atte Red Swanne for editing this 
      compilation for content and accuracy.
      <br/><br/>
      Last updated by Maestra Cassandra Arabella Giordani, June 2009.
      </p>
      <p align="center"><a href="award_discipline.php">View awards by discipline</a></p>
      </td>
   </tr>
</table>
<?php include("footer.php");?>



