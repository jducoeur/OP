<?php
$LOCKOUT = 0;

// Administration defines
$OP_ADMIN = "op_admin";
$BACKLOG_ADMIN = "backlog_admin";
$AWARD_ADMIN = "award_admin";
$SPIKE_ADMIN = "spike_admin";
$UNIVERSITY_ADMIN = "university_admin";

$SENESCHAL_ADMIN = "seneschal_admin";
$EXCHEQUER_ADMIN = "exchequer_admin";
$HERALD_ADMIN = "herald_admin";
$MARSHAL_ADMIN = "marshal_admin";
$MOL_ADMIN = "mol_admin";
$MOAS_ADMIN = "moas_admin";
$CHRONICLER_ADMIN = "chronicler_admin";
$CHIRURGEON_ADMIN = "chirurgeon_admin";
$WEBMINISTER_ADMIN = "webminister_admin";
$CHATELAINE_ADMIN = "chatelaine_admin";

$CHIVALRY_ADMIN = "chivalry_admin";
$LAUREL_ADMIN = "laurel_admin";
$PELICAN_ADMIN = "pelican_admin";
$ROSE_ADMIN = "rose_admin";

$WHITESCARF_ADMIN = "whitescarf_admin";
$PEARL_ADMIN = "pearl_admin";
$DOLPHIN_ADMIN = "dolphin_admin";
$KRAKEN_ADMIN = "kraken_admin";
$SEASTAG_ADMIN = "seastag_admin";
$YEWBOW_ADMIN = "yewbow_admin";

// Order IDs
$LAUREL_ORDER_ID     = 1;
$PEARL_ORDER_ID      = 2;
$PELICAN_ORDER_ID    = 3;
$DOLPHIN_ORDER_ID    = 4;
$ROSE_ORDER_ID       = 5;
$YEWBOW_ORDER_ID     = 6;
$KRAKEN_ORDER_ID     = 7;
$SEASTAG_ORDER_ID    = 8;
$WHITESCARF_ORDER_ID = 9;
$CHIVALRY_ORDER_ID   = 10;

$ORDER_ARRAY = array(
   $LAUREL_ORDER_ID  => array("access"           => "laurel",
                              "auth"             => "laurel_admin",
                              "pend"             => "laurel_pend",
                              "table"            => "laurel",  
                              "id_field"         => "laurel_id",
                              "announce"         => "laurel_announcement",
                              "announce_id"      => "laurel_announcement_id",
                              "faq"              => "laurel_faq",
                              "faq_id"           => "laurel_faq_id",
                              "session_id_field" => "s_laurel_id",  
                              "session_auth"     => "laurel_admin",
                              "order_name"       => "Order of the Laurel",
                              "short_name"       => "Laurel",
                              "website"          => "http://laureltest.atlantia.sca.org",
                              "principal_email"  => "laureltest@atlantia.sca.org",
                              "award_id"         => "12",
                              "society_level"    => "1",
                              "manual"           => "0",
                              "as"               => "1",
                              "checklist"        => "1",
                              "info"             => "1",
                              "ask"              => "1",
                              "advice"           => "0"
                              ),
   $PEARL_ORDER_ID   => array("access"           => "pearl",
                              "auth"             => "pearl_admin",
                              "pend"             => "pearl_pend",
                              "table"            => "pearl",
                              "id_field"         => "pearl_id",
                              "announce"         => "pearl_announcement",
                              "announce_id"      => "pearl_announcement_id",
                              "faq"              => "pearl_faq",
                              "faq_id"           => "pearl_faq_id",
                              "session_id_field" => "s_pearl_id",
                              "session_auth"     => "pearl_admin",
                              "order_name"       => "Order of the Pearl",
                              "short_name"       => "Pearl",
                              "website"          => "http://pearltest.atlantia.sca.org",
                              "principal_email"  => "pearltest@atlantia.sca.org",
                              "award_id"         => "21",
                              "society_level"    => "0",
                              "manual"           => "1",
                              "as"               => "1",
                              "checklist"        => "0",
                              "info"             => "0",
                              "ask"              => "0",
                              "advice"           => "0"
                              ),
   $PELICAN_ORDER_ID => array("access"           => "pelican",
                              "auth"             => "pelican_admin",
                              "pend"             => "pelican_pend",
                              "table"            => "pelican",
                              "id_field"         => "pelican_id",
                              "announce"         => "pelican_announcement",
                              "announce_id"      => "pelican_announcement_id",
                              "faq"              => "pelican_faq",
                              "faq_id"           => "pelican_faq_id",
                              "session_id_field" => "s_pelican_id",
                              "session_auth"     => "pelican_admin",
                              "order_name"       => "Order of the Pelican",
                              "short_name"       => "Pelican",
                              "website"          => "http://pelicantest.atlantia.sca.org",
                              "principal_email"  => "pelicantest@atlantia.sca.org",
                              "award_id"         => "13",
                              "society_level"    => "1",
                              "manual"           => "0",
                              "as"               => "0",
                              "checklist"        => "0",
                              "info"             => "0",
                              "ask"              => "1",
                              "advice"           => "0"
                              ),
   $DOLPHIN_ORDER_ID => array("access"           => "dolphin",
                              "auth"             => "dolphin_auth",
                              "pend"             => "dolphin_pend",
                              "table"            => "dolphin",
                              "id_field"         => "dolphin_id", 
                              "announce"         => "dolphin_announcement",
                              "announce_id"      => "dolphin_announcement_id",
                              "faq"              => "dolphin_faq",
                              "faq_id"           => "dolphin_faq_id",
                              "session_id_field" => "s_dolphin_id",
                              "session_auth"     => "dolphin_admin",
                              "order_name"       => "Order of the Golden Dolphin",
                              "short_name"       => "Golden Dolphin",
                              "website"          => "http://dolphintest.atlantia.sca.org",
                              "principal_email"  => "dolphintest@atlantia.sca.org",
                              "award_id"         => "25",
                              "society_level"    => "0",
                              "manual"           => "0",
                              "as"               => "0",
                              "checklist"        => "0",
                              "info"             => "1",
                              "ask"              => "1",
                              "advice"           => "0"
                              ),
   $ROSE_ORDER_ID    => array("access"           => "rose",
                              "auth"             => "rose_admin",
                              "pend"             => "rose_pend",
                              "table"            => "rose",
                              "id_field"         => "rose_id",
                              "announce"         => "rose_announcement",
                              "announce_id"      => "rose_announcement_id",
                              "faq"              => "rose_faq",
                              "faq_id"           => "rose_faq_id",
                              "session_id_field" => "s_rose_id",
                              "session_auth"     => "rose_admin",
                              "order_name"       => "Order of the Rose",
                              "short_name"       => "Rose",
                              "website"          => "http://rose.atlantia.sca.org",
                              "principal_email"  => "rosetest@atlantia.sca.org",
                              "award_id"         => "16",
                              "society_level"    => "1",
                              "manual"           => "0",
                              "as"               => "0",
                              "checklist"        => "0",
                              "info"             => "1",
                              "ask"              => "1",
                              "advice"           => "0"
                              ),
   $YEWBOW_ORDER_ID  => array("access"           => "yewbow",
                              "auth"             => "yewbow_admin",
                              "pend"             => "yewbow_pend",
                              "table"            => "yewbow",
                              "id_field"         => "yewbow_id",
                              "announce"         => "yewbow_announcement",
                              "announce_id"      => "yewbow_announcement_id",
                              "faq"              => "yewbow_faq",
                              "faq_id"           => "yewbow_faq_id",
                              "session_id_field" => "s_yewbow_id",
                              "session_auth"     => "yewbow_admin",
                              "order_name"       => "Order of the Yew Bow",
                              "short_name"       => "Yew Bow",
                              "website"          => "http://yewbow.atlantia.sca.org",
                              "principal_email"  => "yewbowtest@atlantia.sca.org",
                              "award_id"         => "24",
                              "society_level"    => "0",
                              "manual"           => "0",
                              "as"               => "0",
                              "checklist"        => "0",
                              "info"             => "1",
                              "ask"              => "1",
                              "advice"           => "0"
                              ),
   $KRAKEN_ORDER_ID  => array("access"           => "kraken",
                              "auth"             => "kraken_admin",
                              "pend"             => "kraken_pend",
                              "table"            => "kraken",
                              "id_field"         => "kraken_id",
                              "announce"         => "kraken_announcement",
                              "announce_id"      => "kraken_announcement_id",
                              "faq"              => "kraken_faq",
                              "faq_id"           => "kraken_faq_id",
                              "session_id_field" => "s_kraken_id",
                              "session_auth"     => "kraken_admin",
                              "order_name"       => "Order of the Kraken",
                              "short_name"       => "Kraken",
                              "website"          => "http://kraken.atlantia.sca.org",
                              "principal_email"  => "krakentest@atlantia.sca.org",
                              "award_id"         => "22",
                              "society_level"    => "0",
                              "manual"           => "0",
                              "as"               => "0",
                              "checklist"        => "0",
                              "info"             => "1",
                              "ask"              => "1",
                              "advice"           => "0"
                              ),
   $SEASTAG_ORDER_ID => array("access"           => "seastag",
                              "auth"             => "seastag_admin",
                              "pend"             => "seastag_pend",
                              "table"            => "seastag",
                              "id_field"         => "seastag_id",
                              "announce"         => "seastag_announcement",
                              "announce_id"      => "seastag_announcement_id",
                              "faq"              => "seastag_faq",
                              "faq_id"           => "seastag_faq_id",
                              "session_id_field" => "s_seastag_id",
                              "session_auth"     => "seastag_admin",
                              "order_name"       => "Order of the Sea Stag",
                              "short_name"       => "Sea Stag",
                              "website"          => "http://seastag.atlantia.sca.org",
                              "principal_email"  => "seastag@atlantia.sca.org",
                              "award_id"         => "23",
                              "society_level"    => "0",
                              "manual"           => "0",
                              "as"               => "0",
                              "checklist"        => "0",
                              "info"             => "1",
                              "ask"              => "1",
                              "advice"           => "0"
                              ),
   $WHITESCARF_ORDER_ID => array("access"        => "whitescarf",
                              "auth"             => "whitescarf_admin",
                              "pend"             => "whitescarf_pend",
                              "table"            => "whitescarf",
                              "id_field"         => "whitescarf_id",
                              "announce"         => "whitescarf_announcement",
                              "announce_id"      => "whitescarf_announcement_id",
                              "faq"              => "whitescarf_faq",
                              "faq_id"           => "whitescarf_faq_id",
                              "session_id_field" => "s_whitescarf_id",
                              "session_auth"     => "whitescarf_admin",
                              "order_name"       => "Order of the White Scarf",
                              "short_name"       => "White Scarf",
                              "website"          => "http://whitescarf.atlantia.sca.org",
                              "principal_email"  => "whitescarftest@atlantia.sca.org",
                              "award_id"         => "21",
                              "society_level"    => "0",
                              "manual"           => "0",
                              "as"               => "0",
                              "checklist"        => "0",
                              "info"             => "1",
                              "ask"              => "1",
                              "advice"           => "0"
                              ),
   $CHIVALRY_ORDER_ID => array("access"          => "chivalry",
                              "auth"             => "chivalry_admin",
                              "pend"             => "chivalry_pend",
                              "table"            => "chivalry",
                              "id_field"         => "chivalry_id",
                              "announce"         => "chivalry_announcement",
                              "announce_id"      => "chivalry_announcement_id",
                              "faq"              => "chivalry_faq",
                              "faq_id"           => "chivalry_faq_id",
                              "session_id_field" => "s_chivalry_id",
                              "session_auth"     => "chivalry_admin",
                              "order_name"       => "Order of the Chivalry",
                              "short_name"       => "Chivalry",
                              "website"          => "http://chivalry.atlantia.sca.org",
                              "principal_email"  => "chivalrytest@atlantia.sca.org",
                              "award_id"         => "14",
                              "society_level"    => "1",
                              "manual"           => "0",
                              "as"               => "0",
                              "checklist"        => "0",
                              "info"             => "1",
                              "ask"              => "1",
                              "advice"           => "0"
                              )
);

?>