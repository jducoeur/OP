<?php
include_once('host_defines.php');
include_once('admin_defines.php');

$OP_EMAIL = "arbradley@gmail.com";
$COURT_REP_EMAIL = "arbradley@gmail.com";  
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
// Award requiring special processing
$ST_AIDAN = 47; // Add Augmentation of Arms
// Award IDs of "extra" awards
$POA      = 17; // Patent of Arms
$GOA      = 26; // Grant of Arms
$AOA      = 34; // Award of Arms
$AUG      = 35; // Augmentation of Arms
$KING     =  1; // King (Sovereign)
$QUEEN    =  2; // Queen (Consort)
$PRINCE   =  3; // Prince (Sovereign)
$PRINCESS =  4; // Princess (Consort)
$DUKE     =  9; // Duke
$DUCHESS  =  9; // Duchess
$COUNT    = 10; // Count
$COUNTESS = 10; // Countess
$ROSE     = 16; // Rose

// Award ID Lists
$CHIVALRY             =  "14,15";
// Territorial Baronage Award IDs
$TERRITORIAL_BARONAGE = "18,19";
// Court Baronage Award IDs
$COURT_BARONAGE       = "33,759";

// Award IDs
$DUCAL_ID               =   9;
$COUNTY_ID              =  10;
$VISCOUNTY_ID           =  11;
$LANDED_BARONAGE_ID     =  18;
$RETIRED_BARONAGE_ID    =  19;
$COURT_BARONAGE_AOA_ID  =  33;
$RETIRED_BARONAGE_NA_ID = 781;
$COURT_BARONAGE_GOA_ID  = 759;

$LAUREL             = 12;
$PELICAN            = 13;
$KNIGHT             = 14;
$M_AT_ARMS          = 15;
$ROSE_AOA           = 279;
$ROSE_NO_ARMS       = 760;

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

  //eastern awards
$CRESCENT_ID        = 233;
$MAUNCHE_ID         = 234; 
$OTC = 235;
$SAGITTARIUS = 236;
$OGR = 237;
$QOC = 238;
$BURDENED_TYGER = 239;
$TYGER_CUB=240;
$TROUBADOUR=241;
$TERPSICHORE=242;
$QUEEN_CYPHER = 243;
$KING_CYPHER=244;
$KING_ORDER_EXCELENCE=245;
$BLUE_TYGER_LEGION=246;
$QUEEN_HONOR_DESTINCTION=247;
$TYGER_OF_VALOR=248;
$GIFT_OF_GOLDEN_TYGER=249;
$KINGDOM_AUGMENTATION_ARMS=250;
$ROYAL_AUGMENTATION_ARMS=251;
$TYGER_OF_EAST=252;
$ROYAL_MANDARIN_OF_COURT=620;
 


$SUPPORTERS_ID      = 32;
$CBARON             = 33;
$CBARON_GOA         = 759;

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

// Award Groups
$CHIVALRY_GROUP         = 1;
$ROSE_GROUP             = 2;
$COURT_BARONAGE_GROUP   = 3;
$PEARL_GROUP            = 4;
$KRAKEN_GROUP           = 5;
$SEA_STAG_GROUP         = 6;
$YEW_BOW_GROUP          = 7;
$DOLPHIN_GROUP          = 8;
$RETIRED_BARONAGE_GROUP = 9;

// Kingdoms
$ATLANTIA_NAME = 'East';
$KINGDOM_NAME = 'East';
$KINGDOM_ADJ = 'Eastern';
$KINGDOM_RES = 'Easterner';

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

// East's GoA date for Orders of Merit -> Orders of High Merit
$GOA_DATE = '2003-04-01';

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
