<p align="center">
<a href="awards.php">Eastern Award Descriptions</a> | <a href="award_table_only.php">Eastern Awards by Precedence</a> | <a href="award_discipline.php">Eastern Awards by Discipline</a>
</p>
<table width="<?php echo $pagewidth; ?>" align="center" cellpadding="5" cellspacing="0" border="1" summary="Table for layout">
   <tr>
      <th class="title">Royal Peers</th>
   </tr>
   <tr>
      <td class="datacenter">
      <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" summary="Table for layout">
         <tr>
            <td class="datacenter" width="33%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>duchy.gif" width="65" height="30" alt="Dukes/Duchesses" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $DUCAL_ID; ?>">Dukes/Duchesses</a>
            <br/>
            Royal Peer: One becomes a duke or duchess after ruling a kingdom twice.
            </td>
            <td class="datacenter" width="33%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>county.gif" width="65" height="30" alt="Counts/Countesses" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $COUNTY_ID; ?>">Counts/Countesses</a>
            <br/>
            Royal Peer: One becomes a count or countess after ruling a kingdom once.
            </td>
            <td class="datacenter" width="33%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>viscounty.gif" width="65" height="30" alt="Viscounts/Viscountesses" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $VISCOUNTY_ID; ?>">Vicounts/Vicountesses</a>
            <br/>
            Royal Peer: One becomes a Viscount or Viscountess after ruling a principality once. These are from foreign principalities, or from the time when East was a principality of the East Kingdom. 
            East has no principalities at this time.
            </td>
         </tr>
      </table>
      </td>
   </tr>
   <tr>
      <th class="title">Bestowed Peers</th>
   </tr>
   <tr>
      <td class="datacenter">
      <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" summary="Table for layout">
         <tr>
            <td class="datacenter" width="25%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>knight.gif" width="40" height="40" alt="Order of the Chivalry (Knighthood)" border="0" align="middle"/> 
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>m_at_arms.gif" width="40" height="40" alt="Order of the Chivalry (Masters/Mistresses at Arms)" border="0" align="middle"/> 
            <a href="<?php echo $HOME_DIR; ?>op_award.php?award_group_id=<?php echo $CHIVALRY_GROUP; ?>">Chivalry</a>
            <br/>
            Bestowed Patent: One becomes a Knight or Master/Mistress at Arms through martial prowess on the field.
            </td>
            <td class="datacenter" width="25%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>laurel.gif" width="40" height="40" alt="Order of the Laurel" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $LAUREL; ?>">Laurels</a>
            <br/>
            Bestowed Patent: One becomes a Laurel through excellence in the arts and sciences.
            </td>
            <td class="datacenter" width="25%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>pelican.gif" width="40" height="40" alt="Order of the Pelican" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $PELICAN; ?>">Pelicans</a>
            <br/>
            Bestowed Patent: One becomes a Pelican through excellence in service.
            </td>
            <td class="datacenter" width="25%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>rose.gif" width="40" height="40" alt="Order of the Rose" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_group_id=<?php echo $ROSE_GROUP; ?>">Order of the Rose</a>
            <br/>
            Bestowed Patent: One becomes a member of the Order of the Rose after completing one reign as Consort.
            </td>
         </tr>
      </table>
      </td>
   </tr>
   <!--
   <tr>
      <th class="title">Patents of Arms</th>
   </tr>
   <tr>
      <td class="datacenter">
      <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" summary="Table for layout">
         <tr>
            <td class="datacenter" valign="top">
            <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $POA; ?>">Patent of Arms</a>
            <br/>
            </td>
         </tr>
      </table>
      </td>
   </tr>
   -->
   <tr>
      <th class="title">Landed Baronage</th>
   </tr>
   <tr>
      <td class="datacenter">
      <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" summary="Table for layout">
         <tr>
            <td class="datacenter" width="50%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>baron.gif" width="65" height="30" alt="Territorial Baronage" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $LANDED_BARONAGE_ID; ?>">Territorial Baronage</a>
            <br/>
            </td>
            <td class="datacenter" width="50%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>baron.gif" width="65" height="30" alt="Retired Territorial Baronage" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_group_id=<?php echo $RETIRED_BARONAGE_GROUP; ?>">Retired Territorial Baronage</a>
            <br/>
            </td>
         </tr>
      </table>
      </td>
   </tr>
   <tr>
      <th class="title">Orders of High Merit</th>
   </tr>
   <tr>
      <td class="datacenter">
      <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" summary="Table for layout">
         <tr>
            <td class="datacenter" width="33%" valign="top">
                       <img src="<?php echo $AWARD_IMAGE_DIR; ?>silver_crescent.gif" width="40" height="40" alt="Order of the Silver Crescent" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $CRESCENT_ID; ?>">Silver Crescent</a>
            <br/>
            AoA Level: One receives a Silver Crescent for Service.
            </td>
                        <td class="datacenter" width="33%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>otc.gif" width="40" height="40" alt="Order of the Tyger's Combatant" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $OTC; ?>">Tyger's Combatant</a>
            <br/>
            AoA Level: One becomes a Tyger's Combatant through excellence in armored combat or youth combat.
            </td>
            <td class="datacenter" width="33%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>maunche.gif" width="40" height="40" alt="Order of the Maunche" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $MAUNCHE_ID; ?>">Maunche</a>
            <br/>
            AoA Level: One is awarded the Maunche for excellence in Arts and Sciences.
            </td>
         </tr>
         <tr>
            <td class="datacenter" width="33%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>sagitarius.gif" width="40" height="40" alt="Order of the Sagitarius" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_group_id=<?php echo $SAGITTARIUS; ?>">Sagitarius</a>
            <br/>
            AoA Level: One is awarded the Sagitarius for excellence with bow and arrow.
            </td>
            <td class="datacenter" width="33%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>ogr.gif" width="40" height="40" alt="Order of the Golden Rapier" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $OGR; ?>">Order of the Golden Rapier</a>
            <br/>
            AoA Level: One becomes an OGR through excellence in Rapier Combat.
            </td>
         </tr>
      </table>
      </td>
   </tr>
   <tr>
      <th class="title">Grants of Arms</th>
   </tr>
   <tr>
      <td class="datacenter">
      <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" summary="Table for layout">
         <tr>
            <td class="datacenter" valign="top">
            <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $GOA; ?>">Grant of Arms</a>
            <br/>
            </td>
         </tr>
      </table>
      </td>
   </tr>
   <tr>
     <!-- <th class="title">Orders of Merit</th>
   </tr>
   <tr>
      <td class="datacenter">
      <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" summary="Table for layout">
         <tr>
            <td class="datacenter" width="33%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>silver_osprey.gif" width="40" height="40" alt="Order of the Silver Osprey" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $SILVER_OSPREY_ID; ?>">Silver Osprey</a>
            <br/>
            AoA Level: Non-polling order given to those who excel in fighting in the kingdom.
            </td>
            <td class="datacenter" width="33%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>sea_dragon.gif" width="40" height="40" alt="Order of the Sea Dragon" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $SEA_DRAGON_ID; ?>">Sea Dragon</a>
            <br/>
            AoA Level: Non-polling order given to those who excel in Rapier fighting in the kingdom.
            </td>
            <td class="datacenter" width="33%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>kings_missiliers.gif" width="40" height="40" alt="Order of the King's Missiliers" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $MISSILIERS_ID; ?>">King's Missiliers</a>
            <br/>
            AoA Level: Non-polling order given to those who excel in archery (both target and combat), thrown weapons, or siegecraft in the kingdom.
            </td>
         </tr>
         <tr>
            <td class="datacenter" width="33%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>coral_branch.gif" width="40" height="40" alt="Order of the Maunche" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $MAUNCHE_ID; ?>">Maunche</a>
            <br/>
            AoA Level: Non-polling order given to those who excel in the arts and sciences in the kingdom.
            </td>
            <td class="datacenter" width="33%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>opal.gif" width="40" height="40" alt="Order of the Silver Crescent" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $CRESCENT_ID; ?>">Silver Crescent</a>
            <br/>
            AoA Level: Non-polling order given to those who excel in service to the kingdom.
            </td>
            <td class="datacenter" width="33%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>quintain.gif" width="40" height="40" alt="Order of the Quintain" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $LANCERS_ID; ?>">Quintain</a>
            <br/>
            AoA Level: Non-polling order given to those who excel in equestrian in the kingdom.
            </td>
         </tr>
      </table>
      </td>
   </tr>
   <tr> -->
      <th class="title">Court Baronage</th>
   </tr>
   <tr>
      <td class="datacenter">
      <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" summary="Table for layout">
         <tr>
            <td class="datacenter" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>cbaron.gif" width="65" height="30" alt="Court Baronage" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_group_id=<?php echo $COURT_BARONAGE_GROUP; ?>">Court Baron/Baroness</a>
            <br/>
            </td>
         </tr>
      </table>
      </td>
   </tr>
   <tr>
      <th class="title">Awards of Arms</th>
   </tr>
   <tr>
      <td class="datacenter">
      <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" summary="Table for layout">
         <tr>
            <td class="datacenter" valign="top">
            <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $AOA; ?>">Award of Arms</a>
            <br/>
            </td>
         </tr>
      </table>
      </td>
   </tr>
   <tr>
      <th class="title">Non-Armigerous Society Awards</th>
   </tr>
   <tr>
      <td class="datacenter">
      <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" summary="Table for layout">
         <tr>
		 <!--
            <td class="datacenter" width="50%" valign="top">
            <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $SUPPORTERS_ID; ?>">Supporters</a>
            <br/>
            </td>
		-->
            <td class="datacenter" width="50%" valign="top">
            <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $AUG; ?>">Augmentation of Arms</a>
            <br/>
            </td>
         </tr>
      </table>
      </td>
   </tr>
   <tr>
      <th class="title">Non-Armigerous Kingdom Orders</th>
   </tr>
   <tr>
      <td class="datacenter">
      <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" summary="Table for layout">
         <tr>
            <td class="datacenter" width="33%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>qoc.gif" width="40" height="40" alt="Queen's Order of Courtesy" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $QOC; ?>">Queen's Order of Courtesy</a>
            <br/>
            An accolade to courtesy as designated by the Queen.
            </td>
           <td class="datacenter" width="33%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>tiger_cub.gif" width="40" height="40" alt="Tyger's Cub" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $TYGER_CUB; ?>">Order of the Tyger's Cub</a>
            <br/>
            The Order of the Tyger's Cub may be awarded to children under the age of eighteen who have displayed admirable virtue and decorum at events.
            </td>
            <td class="datacenter" width="33%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>silver_rapier.gif" width="40" height="40" alt="Silver Rapier" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $SILVER_RAPIER; ?>">Order of the Silver Rapier</a>
            <br/>
            Given for martial skill upon the rapier field.
            </td>
        </tr>
        
      </table>
      </td>
   </tr>
   <tr>
      <th class="title">Non-Armigerous Kingdom Awards</th>
   </tr>
   <tr>
      <td class="datacenter">
      <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" summary="Table for layout">
         <tr>
             <td class="datacenter" width="33%" valign="top">
           <img src="<?php echo $AWARD_IMAGE_DIR; ?>burdened_tiger.gif" width="40" height="40" alt="Burdened Tyger" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $BURDENED_TYGER; ?>">Burdened Tyger</a>
            <br/>
            The Order of the Burdened Tyger may be awarded to gentles associated with running an event which was well above the normal standard of excellence in the East Kingdom.
            </td> 
            <td class="datacenter" width="33%" valign="top">
          <img src="<?php echo $AWARD_IMAGE_DIR; ?>troub.gif" width="40" height="40" alt="Troubadour" border="0" align="middle"/><a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $TROUBADOUR; ?>">Troubadour</a>
            <br/>
             Given for vocal entertainment, especially for encouraging others to participate.
           </td> 
             <td class="datacenter" width="33%" valign="top">
          <img src="<?php echo $AWARD_IMAGE_DIR; ?>terp.gif" width="40" height="40" alt="Terpsichore" border="0" align="middle"/><a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $TERPSICHORE; ?>">Terpsichore</a>
            <br/>
             Given for consistent and unselfish devotion in teaching dance and polite court movement.
           </td> 
         </tr>
         <tr>
             <td class="datacenter" width="33%" valign="top">
           <img src="<?php echo $AWARD_IMAGE_DIR; ?>gawain.gif" width="40" height="40" alt="Gawain" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $GAWAIN; ?>">Order of Gawain</a>
            <br/>
            The Order of Gawain is given to youth who excell in martial activities.
            </td> 
            <td class="datacenter" width="33%" valign="top">
          <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $ARTEMIS; ?>">Artemis</a>
            <br/>
             Given for prowess in combat archery.
           </td> 
             <td class="datacenter" width="33%" valign="top">
            <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $KING_ORDER_EXCELENCE; ?>">King's Order of Excellence</a>
            <br/>
            One is awarded the KOE for excellence in service to the King and kingdom.
            </td>
         </tr>
         <tr>
            
           <td class="datacenter" width="33%" valign="top">
               <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $TYGER_OF_EAST; ?>">Tyger of the East</a>
            <br/>
            One is awarded the Tyger of the East for personifying what it is to be an Easterner.
            </td>
            
         </tr>
        
      </table>
      </td>
   </tr>
   
      
</table>
