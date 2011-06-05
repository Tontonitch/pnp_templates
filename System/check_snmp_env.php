<?php

///////////////////////////////
// Functions definition
///////////////////////////////
include_once('functions.php');

///////////////////////////////
// Variables definition
///////////////////////////////
# Define some colors ..
$_WARNRULE = '#FFFF00';
$_CRITRULE = '#FF0000';
$_MAXRULE = '#000000';
$_AREA = '#EACC00';
$_LINE = '#000000';
$colors = array("CC3300","CC3333","CC3366","CC3399","CC33CC","CC33FF","336600","336633","336666","336699","3366CC","3366FF","33CC33","33CC66","609978","922A99","997D6D","174099","1E9920","E88854","AFC5E8","57FA44","FA6FF6","008080","D77038","272B26","70E0D9","0A19EB","E5E29D","930526","26FF4A","ABC2FF","E2A3FF","808000","000000","00FAFA","E5FA79","F8A6FF","FF36CA","B8FFE7","CD36FF","CC3300","CC3333","CC3366","CC3399","CC33CC","CC33FF","336600","336633","336666","336699","3366CC","3366FF","33CC33","33CC66","609978","922A99","997D6D","174099","1E9920","E88854","AFC5E8","57FA44","FA6FF6","008080","D77038","272B26","70E0D9","0A19EB","E5E29D","930526","26FF4A","ABC2FF","E2A3FF","808000","000000","00FAFA","E5FA79","F8A6FF","CC3300","CC3333","CC3366","CC3399","CC33CC","CC33FF","336600","336633","336666","336699","3366CC","3366FF","33CC33","33CC66","609978","922A99","997D6D","174099","1E9920","E88854","AFC5E8","57FA44","FA6FF6","008080","D77038","272B26","70E0D9","0A19EB","E5E29D","930526","26FF4A","ABC2FF","E2A3FF","808000","000000","00FAFA","E5FA79","F8A6FF","FF36CA","B8FFE7","CD36FF");


///////////////////////////////
// Main part
///////////////////////////////
# Initial Logic ...

$vlabel = "°c";
$ds_name[1] = "Temperatures";
$opt[1] = '--vertical-label "' . $vlabel . '" --title "Temperatures for ' . $hostname . ' elements" --lower-limit=0 --rigid';
$opt[1] .= ' --watermark="Template: check_snmp_env.pl by Yannick Charton"';
$def[1] = "";

foreach ($this->DS as $KEY=>$VAL) {
    $def[1] .= rrd::def     ("var$KEY", $VAL['RRDFILE'], $VAL['DS'], "AVERAGE");
    $label = rrd::cut($VAL['NAME'], 32);
    $def[1] .= rrd::line1   ("var$KEY", "#".$colors[$KEY], $label );
    $def[1] .= rrd::gprint  ("var$KEY", array("LAST","MAX","AVERAGE"), "%3.1lf".$vlabel);
}

?>
