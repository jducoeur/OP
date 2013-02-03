<?php
include_once("host_defines.php");
include_once("order_defines.php");

$DBNAME_UNIVERSITY = 'atlantia_university';
$DBNAME_REGNUM = 'atlantia_regnum';
$DBNAME_ORDER = 'atlantia_order';
$DBNAME_OP = 'atlantia_op';
$DBNAME_SPIKE = 'atlantia_spike';
$DBNAME_BRANCH = 'atlantia_branch';
$DBNAME_AUTH = 'atlantia_auth';
$DBNAME_WARRANT = 'atlantia_warrant';
$DBNAME = $DBNAME_UNIVERSITY;

$DBUSER = 'atlantia_agent';
$DBPASS = 'password';

$DBUSER_ADMIN = 'atlantia_admin';
$DBPASS_ADMIN = 'password';

$CHANCELLOR_EMAIL = "university@atlantia.sca.org";
$REGISTRAR_EMAIL = "registrar@atlantia.sca.org";
$IMAGES_DIR = $HOME_DIR . "images/";
$ADMIN_DIR = $HOME_DIR . "admin/";

// Office Titles
$CHANCELLOR = "University Chancellor";
$REGISTRAR = "University Registrar";

// Kingdoms
$ATLANTIA_NAME = 'Atlantia';
$ATLANTIA = 8;

// Participant Types
$TYPE_INSTRUCTOR = 1;
$TYPE_STUDENT = 2;

// Course Status
$STATUS_APPROVED = 1;
$STATUS_PENDING = 2;
$STATUS_CANCELED = 3;

// Registration Status
$STATUS_REGISTERED = 1;
$STATUS_ATTENDED = 2;
$STATUS_WAITLIST = 3;

// Degree Status
$STATUS_EARNED = 1;
$STATUS_PRINTED = 2;
$STATUS_DELIVERED = 3;

// Course Categories
$CATEGORY_AS = "AS";
$CATEGORY_CM = "CM";
$CATEGORY_H = "H";
$CATEGORY_HE = "HE";
$CATEGORY_HS = "HS";
$CATEGORY_MA = "MA";
$CATEGORY_MD = "MD";
$CATEGORY_T = "T";
$CATEGORY_Q = "Q";
$CATEGORY_R = "R";
$CATEGORY_NC = "NC";

// Degree Requirements
$BACHELOR_CREDITS = 26;
$FELLOWSHIP_UNIVERSITIES = 3;

// Degree Types
$TYPE_BACHELOR = "B";
$TYPE_FELLOW = "F";
$TYPE_MASTER = "M";
$TYPE_DOCTOR = "D";

// Gender codes
$MALE = 'M';
$FEMALE = 'F';
$UNKNOWN = 'U';
$NONE = 'N';

// Modes
$MODE_ADD = "add";
$MODE_EDIT = "edit";

// Search/Selection Types
$ST_PARTICIPANT = 1;
$ST_MERGE = 2;
$ST_DOCTORATE = 3;
$ST_INSTRUCTOR = 4;
$ST_STUDENT = 5;
$ST_CHANCELLOR = 6;

// Local Branch Types
$BT_KINGDOM      = 1;
$BT_PRINCIPALITY = 2;
$BT_BARONY       = 3;
$BT_SHIRE        = 4;
$BT_STRONGHOLD   = 5;
$BT_CANTON       = 6;
$BT_COLLEGE      = 7;

$FULL_CLASS = "<b>FULL</b>";
$UNLIMITED_CLASS = "&infin;";

include_once("admin_defines.php");
?>