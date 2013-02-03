<p align="center">
<a href="awards.php">Atlantian Award Descriptions</a> | <a href="award_table_only.php">Atlantian Awards by Precedence</a> | <a href="award_discipline.php">Atlantian Awards by Discipline</a>
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
            Royal Peer: One becomes a Viscount or Viscountess after ruling a principality once. These are from foreign principalities, or from the time when Atlantia was a principality of the East Kingdom. 
            Atlantia has no principalities at this time.
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
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>white_scarf.gif" width="40" height="40" alt="Order of the White Scarf" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $WHITE_SCARF_ID; ?>">White Scarf</a>
            <br/>
            Grant Level: One receives a White Scarf for prowess in rapier combat.
            </td>
            <td class="datacenter" width="33%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>sea_stag.gif" width="40" height="40" alt="Order of the Sea Stag" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_group_id=<?php echo $SEA_STAG_GROUP; ?>">Sea Stag</a>
            <br/>
            Grant Level: One becomes a Sea Stag through excellence in teaching armored combat, rapier combat, combat and target archery, thrown weapons, siege warfare, or youth combat.
            </td>
            <td class="datacenter" width="33%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>kraken.gif" width="40" height="40" alt="Order of the Kraken" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_group_id=<?php echo $KRAKEN_GROUP; ?>">Kraken</a>
            <br/>
            Grant Level: One is awarded the Kraken for excellence in armored combat (non-belted fighters).
            </td>
         </tr>
         <tr>
            <td class="datacenter" width="33%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>yew_bow.gif" width="40" height="40" alt="Order of the Yew Bow" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_group_id=<?php echo $YEW_BOW_GROUP; ?>">Yew Bow</a>
            <br/>
            Grant Level: One is awarded the Yew Bow for excellence with bow and arrow (both target and combat), thrown weapons, or siegecraft.
            </td>
            <td class="datacenter" width="33%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>pearl.gif" width="40" height="40" alt="Order of the Pearl" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_group_id=<?php echo $PEARL_GROUP; ?>">Pearl</a>
            <br/>
            Grant Level: One becomes a Pearl through teaching and excellence in the arts and sciences.
            </td>
            <td class="datacenter" width="33%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>golden_dolphin.gif" width="40" height="40" alt="Order of the Golden Dolphin" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_group_id=<?php echo $DOLPHIN_GROUP; ?>">Golden Dolphin</a>
            <br/>
            Grant Level: One becomes a Golden Dolphin through excellence in service and leadership.
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
      <th class="title">Orders of Merit</th>
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
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>coral_branch.gif" width="40" height="40" alt="Order of the Coral Branch" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $CORAL_BRANCH_ID; ?>">Coral Branch</a>
            <br/>
            AoA Level: Non-polling order given to those who excel in the arts and sciences in the kingdom.
            </td>
            <td class="datacenter" width="33%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>opal.gif" width="40" height="40" alt="Order of the Opal" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $OPAL_ID; ?>">Opal</a>
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
   <tr>
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
            <td class="datacenter" width="50%" valign="top">
            <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $SUPPORTERS_ID; ?>">Supporters</a>
            <br/>
            </td>
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
            <td class="datacenter" width="50%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>qoc.gif" width="40" height="40" alt="Queen's Order of Courtesy" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $QOC_ID; ?>">Queen's Order of Courtesy</a>
            <br/>
            An accolade to courtesy as designated by the Queen.
            </td>
            <td class="datacenter" width="50%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>nonpareil.gif" width="40" height="40" alt="Order of the Nonpareil" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $NONPAREIL_ID; ?>">Order of the Nonpareil</a>
            <br/>
            One is awarded the Nonpareil for personifying what it is to be an Atlantian. This award may only be given once per reign.
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
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>sharks_tooth.gif" width="40" height="40" alt="Award of the Shark's Tooth" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $SHARKS_TOOTH_ID; ?>">Shark's Tooth</a>
            <br/>
            One is awarded a Shark's Tooth for an act of bravery on the field.
            </td>
            <td class="datacenter" width="33%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>silver_nautilus.gif" width="40" height="40" alt="Award of the Silver Nautilus" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $SILVER_NAUTILUS_ID; ?>">Silver Nautilus</a>
            <br/>
            One is awarded the Silver Nautilus in recognition of skill in the arts and sciences.
            </td>
            <td class="datacenter" width="33%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>fountain.gif" width="40" height="40" alt="Award of the Fountain" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $FOUNTAIN_ID; ?>">Fountain</a>
            <br/>
            One is awarded the Fountain in recognition of service to the kingdom.
            </td>
         </tr>
         <tr>
            <td class="datacenter" width="33%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>kae.gif" width="40" height="40" alt="King's Award of Excellence" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $KAE_ID; ?>">King's Award of Excellence</a>
            <br/>
            One is awarded the KAE for excellence in service to the King and kingdom.
            </td>
            <td class="datacenter" width="33%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>undine.gif" width="40" height="40" alt="Award of the Undine" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $UNDINE_ID; ?>">Undine</a>
            <br/>
            One is awarded the Undine for excellence in service to the Queen.
            </td>
            <td class="datacenter" width="33%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>herring.gif" width="40" height="40" alt="Award of the Herring" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $HERRING_ID; ?>">Herring</a>
            <br/>
            One is awarded the Herring for extraordinary achievement as an autocrat.
            </td>
         </tr>
         <tr>
            <td class="datacenter" width="33%" valign="top" colspan="3">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>vexillum_atlantiae.gif" width="40" height="40" alt="Award of the Vexillum Atlantiae" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $VEXILLUM_ID; ?>">Vexillum Atlantiae</a>
            <br/>
            A group is awarded the Vexillum Atlantiae for an act of bravery on the field.
            </td>
         </tr>
      </table>
      </td>
   </tr>
   <tr>
      <th class="title">Youth Awards</th>
   </tr>
   <tr>
      <td class="datacenter">
      <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" summary="Table for layout">
         <tr>
            <td class="datacenter" width="33%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>sea_urchin.gif" width="40" height="40" alt="Order of the Sea Urchin" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $SEA_URCHIN_ID; ?>">Sea Urchin</a>
            <br/>
            Youth are awarded the Sea Urchin for contributions to the Kingdom in service, martial activities, and/or arts and sciences.
            </td>
            <td class="datacenter" width="33%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>arielle.gif" width="40" height="40" alt="Award of Arielle" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $ARIELLE_ID; ?>">Arielle</a>
            <br/>
            The Award of Arielle is given to youth for acts of courtesy.
            </td>
            <td class="datacenter" width="33%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>royal_aug.gif" width="40" height="40" alt="Royal Augmentation of Arms" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $AUG; ?>">Royal Augmentation of Arms</a>
            <br/>
            Children of Atlantia's Monarchs may be awarded a royal augmentation.
            </td>
         </tr>
      </table>
      <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" summary="Table for layout">
         <tr>
            <td class="datacenter" width="33%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>hippocampus.gif" width="40" height="40" alt="Order of the Hippocampus" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $HIPPOCAMPUS_ID; ?>">Hippocampus</a>
            <br/>
            Youth are awarded the Hippocampus for excellence in service and leadership.
            </td>
            <td class="datacenter" width="33%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>sea_tyger.gif" width="40" height="40" alt="Order of the Sea Tyger" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $SEA_TIGER_ID; ?>">Sea Tyger</a>
            <br/>
            Youth are awarded the Sea Tyger for excellence in youth combat.
            </td>
            <td class="datacenter" width="33%" valign="top">
            <img src="<?php echo $AWARD_IMAGE_DIR; ?>alcyon.gif" width="40" height="40" alt="Order of the Alcyon" border="0" align="middle"/> <a href="<?php echo $HOME_DIR; ?>op_award.php?award_id=<?php echo $ALCYON_ID; ?>">Alcyon</a>
            <br/>
            Youth are awarded the Alcyon for excellence in arts and sciences.
            </td>
         </tr>
      </table>
      </td>
   </tr>
</table>
