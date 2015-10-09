<?php
include_once('host_defines.php');
include_once('admin_defines.php');
include_once('award_defines.php');

$OP_EMAIL = "shepherds.crook@eastkingdom.org";
$COURT_REP_EMAIL = "shepherds.crook@eastkingdom.org";  
$IMAGES_DIR = $HOME_DIR . "images/";
$BRANCH_IMAGE_DIR = $IMAGES_DIR . "branches/";
$DEVICE_IMAGE_DIR = $IMAGES_DIR . "devices/";
$AWARD_IMAGE_DIR = $IMAGES_DIR . "awards/";

date_default_timezone_set("America/New_York");

// Precedence values
$ORDER_HIGH_MERIT_P   = 12;
$GOA_P                = 14;
$ORDER_MERIT_P        = 15;
$UNDER_OP_LEVEL       = 20;
$PRINCIPALITY_AWARD_P = "17, 21";
$BARONIAL_AWARD_P     = "18, 22";
// Award Types requiring special processing
$MONARCH              =  1;  // Coronation
$HEIR                 =  2;  // Coronation
$PPRINCE              =  3;  // Coronation
$PHEIR                =  4;  // Coronation
$DUCAL                =  5;  // Coronation
$COUNTY               =  6;  // Coronation
$VISCOUNTY            =  7;
$BESTOWED_PEER        =  8;
$POA_LEVEL            =  9;  // Patent of Arms
$LANDED_BARONAGE      = 10;  // Investiture
$COURT_BARONAGE_GOA   = 11;
$ORDER_HIGH_MERIT     = 12;
$ORDER_MERIT          = 14;
$COURT_BARONAGE_AOA   = 16;
$KINGDOM_AWARD        = 18;
$PRINCIPALITY_AWARD   = 19;
$BARONIAL_AWARD       = 20;
$RETIRED_BARONAGE     = 22;  // Investiture

$BAD_AWARD_ID = 10000;

// Note that these all are aliases for names in award_defines.php:
// Award IDs of "extra" awards
// TODO (JustinDuC, 3/5/13): really, probably none of these should exist. Everywhere that we
// have award IDs coded in, we should instead have the code being more database-driven
// instead, using categories.
$POA      = $PATENT_OF_ARMS_ID;
$GOA      = $GRANT_OF_ARMS_ID;
$AOA      = $AWARD_OF_ARMS_ID;
$AUG      = $KINGDOM_AUGMENTATION_OF_ARMS_ID;
$KING     = $KING_OF_THE_EAST_ID;
$QUEEN    = $QUEEN_OF_THE_EAST_KINGDOM_ID;
$PRINCE   = $CROWN_PRINCE_ID;
$PRINCESS = $CROWN_PRINCESS_ID;
$DUKE     = $DUKE_ID;
$DUCHESS  = $DUKE_ID;
$COUNT    = $COUNT_ID;
$COUNTESS = $COUNT_ID;
$ROSE     = $ROSE_ID;

// Award ID Lists -- not used?
// $CHIVALRY             =  "14,15";
// Territorial Baronage Award IDs
// TODO: this needs to be made to fit the incoming data:
$TERRITORIAL_BARONAGE = "18,19";
// Court Baronage Award IDs
$COURT_BARONAGE       = $COURT_BARONY_ID;

// Award IDs
$DUCAL_ID               =  $DUKE_ID;
$COUNTY_ID              =  $COUNT_ID;
$VISCOUNTY_ID           =  $VISCOUNT_ID;
// TODO: these need to be fixed!
//Updated by Amacks to match the DB - 2015-08-17
$LANDED_BARONAGE_ID     =  10;
$RETIRED_BARONAGE_ID    =  9;
//$COURT_BARONAGE_AOA_ID  =  33;
// TODO: this is meaningless in the East, and should be removed:
$RETIRED_BARONAGE_NA_ID = $BAD_AWARD_ID;
// TODO: this exists for purposes of a hack that is wrong in the East:
$COURT_BARONAGE_GOA_ID  = $BAD_AWARD_ID;

$LAUREL             = $LAUREL_ID;
$PELICAN            = $PELICAN_ID;
$KNIGHT             = $KNIGHT_ID;
$M_AT_ARMS          = $MASTER_AT_ARMS_ID;
$ROSE_AOA           = $ROSE_ID;
// TODO: the East historically doesn't distinguish this way:
$ROSE_NO_ARMS       = $BAD_AWARD_ID;
$MOD                = $MOD_ID;

/*
$WHITE_SCARF_ID     = 20;
$PEARL_ID           = 21;
$KRAKEN_ID          = 22;
$SEA_STAG_ID        = 23;
$YEW_BOW_ID         = 24;
$DOLPHIN_ID         = 25;

$PEARL_AOA_ID       = 754;
$DOLPHIN_AOA_ID     = 758;
$OPAL_ID            = 27;
$CORAL_BRANCH_ID    = 28;
$MISSILIERS_ID      = 29;
$SILVER_OSPREY_ID   = 30;
$SEA_DRAGON_ID      = 31;
$LANCERS_ID         = 768;
*/

  //eastern awards
// TODO: in the medium term, the code should be fixed so that these aliases aren't needed.
// In the longer run, the code should be rewritten to be DB-driven, so that the variables
// are no longer used at all.
$CRESCENT_ID        = $SILVER_CRESCENT_ID;
//$MAUNCHE_ID         = 234; 
$OTC = $TYGERS_COMBATTANT_ID;
$SAGITTARIUS = $SAGITTARIUS_ID;
$OGR = $GOLDEN_RAPIER_ID;
$QOC = $QUEENS_ORDER_OF_COURTESY_ID;
$BURDENED_TYGER = $BURDENED_TYGER_ID;
$TYGER_CUB = $TYGERS_CUB_ID;
$TROUBADOUR=$TROUBADOUR_ID;
$TERPSICHORE=$TERPSICHORE_ID;
$QUEEN_CYPHER = $QUEENS_CYPHER_ID;
$KING_CYPHER=$KINGS_CYPHER_ID;
$KING_ORDER_EXCELENCE=$KINGS_ORDER_OF_EXCELLENCE_ID;
$BLUE_TYGER_LEGION=$BLUE_TYGER_LEGION_ID;
$QUEEN_HONOR_DESTINCTION=$QUEENS_HONOR_OF_DISTINCTION_ID;
$TYGER_OF_VALOR=$TYGER_OF_VALOR_ID;
$GIFT_OF_GOLDEN_TYGER=$GOLDEN_LYRE_ID;
$KINGDOM_AUGMENTATION_ARMS=$KINGDOM_AUGMENTATION_OF_ARMS_ID;
$ROYAL_AUGMENTATION_ARMS=$ROYAL_AUGMENTATION_OF_ARMS_ID;
$TYGER_OF_EAST=$TYGER_OF_THE_EAST_ID;
$SILVER_RAPIER=$SILVER_RAPIER_ID;
$GAWAIN=$GAWAIN_ID;
$ARTEMIS=$ARTEMIS_ID;
 

// TODO: what is this?
$SUPPORTERS_ID      = $BAD_AWARD_ID;
$CBARON             = $COURT_BARONY_ID;
// TODO: this is wrong -- we track the barony and the GOA separately:
$CBARON_GOA         = $COURT_BARONY_ID;

/*
$QOC_ID             = 36;
$NONPAREIL_ID       = 37;

$SHARKS_TOOTH_ID    = 38;
$SILVER_NAUTILUS_ID = 39;
$KAE_ID             = 40;
$UNDINE_ID          = 41;
$HERRING_ID         = 42;
$FOUNTAIN_ID        = 43;
$VEXILLUM_ID        = 802;

$SEA_URCHIN_ID      = 44;
$HIPPOCAMPUS_ID     = 45;
$ARIELLE_ID  = 46;
$SEA_TIGER_ID       = 751;
$ALCYON_ID          = 752;

$ACADEMIE_DESPEE_ID = 48;
$SILVER_NEEDLE_ID   = 49;

$MARINUS_STEWARDS  = 134;
*/

// Award Groups
$CHIVALRY_GROUP         = 1;
$ROSE_GROUP             = 2;
$COURT_BARONAGE_GROUP   = 3;
//$PEARL_GROUP            = 4;
//$KRAKEN_GROUP           = 5;
//$SEA_STAG_GROUP         = 6;
//$YEW_BOW_GROUP          = 7;
//$DOLPHIN_GROUP          = 8;
$RETIRED_BARONAGE_GROUP = 9;

// Kingdoms
$ATLANTIA_NAME = 'East';
$KINGDOM_NAME = 'East';
$KINGDOM_ADJ = 'Eastern';
$KINGDOM_RES = 'Easterner';
$KINGDOM_ID = 20;

// TODO: fix these!
$WEST = 1;
$EAST = 2;
$MIDDLE = 3;
$ATENVELDT = 4;
$MERIDIES = 5;
$CAID = 6;
$ANSTEORRA = 7;
$ATLANTIA = 8;
$AN_TIR = 9;
$CALONTIR = 10;
$TRIMARIS = 11;
$OUTLANDS = 13;
$DRACHENWALD = 14;
$ARTEMISIA = 15;
$AETHELMEARC = 16;
$EALDORMERE = 12;
$LOCHAC = 17;
$NORTHSHIELD = 18;
$GLEANN_ABHANN = 112;

// Atlantia's GoA date for Orders of Merit -> Orders of High Merit
//$GOA_DATE = '2003-04-01';

// Gender codes
$MALE = 'M';
$FEMALE = 'F';
$UNKNOWN = 'U';
$NONE = 'N';

// Titles
$LORD = 'Lord';
$LADY = 'Lady';
$FOUNDING_BARON = 'Founding Baron ';
$FOUNDING_BARONESS = 'Founding Baroness ';

// Branch Types
$BT_KINGDOM      = 1;
$BT_PRINCIPALITY = 2;
$BT_BARONY       = 3;
$BT_SHIRE        = 4;
$BT_STRONGHOLD   = 5;
$BT_CANTON       = 6;
$BT_COLLEGE      = 7;

// Modes
$MODE_ADD = "add";
$MODE_EDIT = "edit";

// Selection Types
$TYPE_ATLANTIAN = "1";
$TYPE_AWARD = "2";
$TYPE_BACKLOG = "3";
$TYPE_MERGE = "4";
$TYPE_EVENT = "1";
$TYPE_COURT = "2";

// Court Types
$COURT_TYPE_ROYAL = "R";
$COURT_TYPE_BARONIAL = "B";

// Court Times
$COURT_TIME_ALL = 1;
$COURT_TIME_MORNING = 2;
$COURT_TIME_AFTERNOON = 3;
$COURT_TIME_FIELD1 = 5;
$COURT_TIME_FIELD2 = 6;
$COURT_TIME_FIELD3 = 7;
$COURT_TIME_EVENING = 10;
$COURT_TIME_FEAST = 11;

// Deletion Types
$DEL_TYPE_ATLANTIAN = 1;
$DEL_TYPE_EVENT = 2;
$DEL_TYPE_CR = 3;
$DEL_TYPE_AWARD = 4;

$DELTYPE[$DEL_TYPE_ATLANTIAN] = "Easterner";
$DELTYPE[$DEL_TYPE_EVENT] = "Event";
$DELTYPE[$DEL_TYPE_CR] = "Court Report";
$DELTYPE[$DEL_TYPE_AWARD] = "Award";

// Scroll Status values
$SS_NEEDED        = 1; // 'P', 'Promissory'
$SS_ASSIGNED      = 2; // 'I', 'In Production'
$SS_COMPLETE      = 3; // 'S', 'Scroll'
$SS_NOT_REQUIRED  = 4; // 'N', 'Not required'
$SS_REQUEST       = 5; // 'R', 'Eligible for assignment because it was requested'

$UT_OP_ADMIN      = 1;  // OP Administrator
$UT_BACKLOG_ADMIN = 2;  // Backlog Administator
?>
