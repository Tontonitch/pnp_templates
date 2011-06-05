<?php
#
# Copyright (c) 2006-2008 Joerg Linge (http://www.pnp4nagios.org)
# Default Template used if no other template is found.
# Don`t delete this file !
# $Id: default.php 555 2008-11-16 16:35:59Z pitchfork $
#
# Function definitions

include_once('functions.php');

#
# Define some colors ..
#
$_WARNRULE = '#FFFF00';
$_CRITRULE = '#FF0000';
$_MAXRULE = '#000000';
$_AREA = '#EACC00';
$_LINE = '#000000';
$colors = array(0 => "#00FA9A","#008080","#1E90FF","#0000CD","#4B0082","#FF00FF","#EE82EE","#FF69B4","#800000","#FF6347","#8B4513","#FFA500","#808000","#008000","#00FF7F","#00FFFF","#4682B4","#191970","#8A2BE2","#C71585","#FF1493","#A52A2A","#D19275","#D2B48C","#F0E68C","#BDB76B","#FFD700","#00FF00","#3CB371","#00FA9A","#008080","#1E90FF","#0000CD","#4B0082","#FF00FF","#EE82EE","#FF69B4","#800000","#FF6347","#8B4513","#FFA500","#808000","#008000","#00FF7F","#00FFFF","#4682B4","#191970","#8A2BE2","#C71585","#FF1493","#A52A2A","#D19275","#D2B48C","#F0E68C","#BDB76B","#FFD700","#00FF00","#3CB371","#00FA9A","#008080","#1E90FF","#0000CD","#4B0082","#FF00FF","#EE82EE","#FF69B4","#800000","#FF6347","#8B4513","#FFA500","#808000","#008000","#00FF7F","#00FFFF","#4682B4","#191970","#8A2BE2","#C71585","#FF1493","#A52A2A","#D19275","#D2B48C","#F0E68C","#BDB76B","#FFD700","#00FF00","#3CB371","#00FA9A","#008080","#1E90FF","#0000CD","#4B0082","#FF00FF","#EE82EE","#FF69B4","#800000","#FF6347","#8B4513","#FFA500","#808000","#008000","#00FF7F","#00FFFF","#4682B4","#191970","#8A2BE2","#C71585","#FF1493","#A52A2A","#D19275","#D2B48C","#F0E68C","#BDB76B","#FFD700","#00FF00","#00FA9A","#008080","#1E90FF","#0000CD","#4B0082","#FF00FF","#EE82EE","#FF69B4","#800000","#FF6347","#8B4513","#FFA500","#808000","#008000","#00FF7F","#00FFFF","#4682B4","#191970","#8A2BE2","#C71585","#FF1493","#A52A2A","#D19275","#D2B48C","#F0E68C","#BDB76B","#FFD700","#00FF00");
#
# Initial Logic ...
#

$minimum = 0;
$warning = "";
$critical = "";
$maximum = "";
$vlabel = "";

$opt[1] = '--vertical-label "i/o per sec" --title "' . $hostname . ' / ' . $servicedesc . '" --lower-limit=0 --rigid';
$opt[1] .= ' --watermark="Template: check_oracle_health_datafile-io-traffic by Yannick Charton"';
$ds_name[1] = 'Oracle datafile IO';
$def[1] = "";

if ($warning != "") {
        $def[1] .= "HRULE:" . $warning . $_WARNRULE . ':"Warning on\: ' . $warning . $vlabel . '" ';
}
if ($critical != "") {
        $def[1] .= "HRULE:" . $critical . $_CRITRULE . ':"Critical on\: ' . $critical . $vlabel . '\n" ';
}
if ($maximum != "") {
        $def[1] .= "HRULE:" . $maximum . $_MAXRULE . ':"Full on\: ' . $maximum . $vlabel . '\n" ';
}

foreach ($this->DS as $KEY=>$VAL) {
    $def[1] .= "DEF:var" . $KEY . "=" .$VAL['RRDFILE'].":".$VAL['DS'].":MAX ";
    $VAL['NAME'] = stringTruncation_io($VAL['NAME']);
    $VAL['NAME'] = str_pad($VAL['NAME'],24,' ',STR_PAD_RIGHT);
    if($KEY == 0) {
        $def[1] .= "AREA:var" . $KEY . $colors[$KEY] . ":\"" . $VAL['NAME'] . "\" ";
    } else {
        $def[1] .= "STACK:var" . $KEY . $colors[$KEY] . ":\"" . $VAL['NAME'] . "\" ";
    }
    $def[1] .= "GPRINT:var" . $KEY . ":LAST:\"Last\:%3.2lf%s\" ";
#    $def[1] .= "GPRINT:var" . $KEY . ":MIN:\"  Min\:%3.2lf%s\" ";
    $def[1] .= "GPRINT:var" . $KEY . ":AVERAGE:\"Avg\:%3.2lf%s\" ";
    $def[1] .= "GPRINT:var" . $KEY . ":MAX:\"Max\:%3.2lf%s\\n\" ";
}

?>
