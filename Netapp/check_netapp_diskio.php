<?php
#
# Copyright (c) 2009 Yannick Charton
# Plugin: check_cpu
#
#
$opt[1] = "--vertical-label bytes/s --title \"Disk IO for $hostname\" --lower-limit 0 --rigid";
$ds_name[1] = 'NetApp Disk IO';
#
#
#
$def[1] =  "DEF:read=$RRDFILE[1]:$DS[1]:AVERAGE ";
$def[1] .= "DEF:write=$RRDFILE[2]:$DS[2]:AVERAGE ";
if ($WARN[1] != "") {
        $def[1] .= "HRULE:$WARN[1]#FFFF00 ";
}
if ($CRIT[1] != "") {
        $def[1] .= "HRULE:$CRIT[1]#FF0000 ";
}
$def[1] .= "LINE1:read#87CEEB:\"Read    \" " ;
$def[1] .= "GPRINT:read:LAST:\"last\: %6.2lf%S/s\" " ;
$def[1] .= "GPRINT:read:AVERAGE:\"avg\: %6.2lf%S/s\" " ;
$def[1] .= "GPRINT:read:MAX:\"max\: %6.2lf%S/s\\n\" " ;
$def[1] .= "LINE1:write#8FBC8F:\"Write   \" " ;
$def[1] .= "GPRINT:write:LAST:\"last\: %6.2lf%S/s\" " ;
$def[1] .= "GPRINT:write:AVERAGE:\"avg\: %6.2lf%S/s\" " ;
$def[1] .= "GPRINT:write:MAX:\"max\: %6.2lf%S/s\\n\" " ;

$def[1] .= 'COMMENT:"Template for\: check_netapp_diskio\r" ';
$def[1] .= 'COMMENT:"Check Command ' . $TEMPLATE[1] . '\r" ';
?>
