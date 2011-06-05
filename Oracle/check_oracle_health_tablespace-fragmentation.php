<?php
#
# Copyright (c) 2006-2008 Joerg Linge (http://www.pnp4nagios.org)
# Default Template used if no other template is found.
# Don`t delete this file !
# $Id: default.php 555 2008-11-16 16:35:59Z pitchfork $
#
# Function definitions

include_once('functions.php');

function stringTruncation_fsfi($string)
{
 $string = preg_replace("/_fsfi/","",$string);
 return $string;
}

#
# Define some colors ..
#
$_WARNRULE = '#FFFF33';
$_CRITRULE = '#FF3333';
$_WARNRULE_AREA = '#FFFF66';
$_CRITRULE_AREA = '#FF6666';
$_MAXRULE = '#000000';
$_AREA = '#EACC00';
$_LINE = '#000000';
$colors = array(0 => "#00FA9A","#008080","#1E90FF","#0000CD","#4B0082","#FF00FF","#EE82EE","#FF69B4","#800000","#FF6347","#8B4513","#FFA500","#808000","#008000","#00FF7F","#00FFFF","#4682B4","#191970","#8A2BE2","#C71585","#FF1493","#A52A2A","#D19275","#D2B48C","#F0E68C","#BDB76B","#FFD700","#00FF00","#3CB371");
#
# Initial Logic ...
#

$minimum = 0;
$warning = "";
$critical = "";
$maximum = 100;
$vlabel = "%";

$opt[1] = '--vertical-label "%" --title "' . $hostname . ' / Free Space Fragmentation Index" --lower-limit=0 --upper-limit=100';
$ds_name[1] = 'Oracle FSFI';
$def[1] = "";

$warning = $WARN_MIN[1];
$critical = $CRIT_MIN[1];
if ($warning != "") {
    $def[1] .= "AREA:" . $warning . $_WARNRULE_AREA . ":\"\" ";
    $def[1] .= "HRULE:" . $warning . $_WARNRULE . ':"Warning on\: ' . $warning . $vlabel . '" ';
}
if ($critical != "") {
    $def[1] .= "AREA:" . $critical . $_CRITRULE_AREA . ":\"\" ";
    $def[1] .= "HRULE:" . $critical . $_CRITRULE . ':"Critical on\: ' . $critical . $vlabel . '\n" ';
}

foreach ($this->DS as $KEY=>$VAL) {
    $def[1] .= "DEF:var" . $KEY . "=" .$VAL['RRDFILE'].":".$VAL['DS'].":AVERAGE ";
    $VAL['NAME'] = stringTruncation_fsfi($VAL['NAME']);
    $VAL['NAME'] = str_pad($VAL['NAME'],18,' ',STR_PAD_RIGHT);
    $def[1] .= "LINE1:var" . $KEY . $colors[$KEY] . ":\"" . $VAL['NAME'] . "\" ";
    $def[1] .= "GPRINT:var" . $KEY . ":LAST:\"Last\:%3.2lf%s%%\"\t ";
#    $def[1] .= "GPRINT:var" . $KEY . ":MIN:\"  Min\:%3.2lf%s%%\"\t ";
    $def[1] .= "GPRINT:var" . $KEY . ":AVERAGE:\"Avg\:%3.2lf%s%%\"\t ";
    $def[1] .= "GPRINT:var" . $KEY . ":MAX:\"Max\:%3.2lf%s%%\\n\" ";
}

$def[1] .= 'COMMENT:"Template for\: check_oracle_health_tablespace-fragmentation\r" ';
$def[1] .= 'COMMENT:"Check Command ' . $TEMPLATE[1] . '\r" ';
?>
