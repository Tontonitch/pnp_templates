<?php
#
# Copyright (c) 2009 Yannick Charton
# Plugin: check_cpu
#
#
$opt[1] = "--vertical-label operations/s --title \"OPS for $hostname\" --lower-limit 0 --rigid";
$ds_name[1] = 'NetApp OPS';
#
#
#
$def[1] =  "DEF:nfs=$RRDFILE[1]:$DS[1]:AVERAGE ";
$def[1] .= "DEF:cifs=$RRDFILE[2]:$DS[2]:AVERAGE ";
if ($WARN[1] != "") {
        $def[1] .= "HRULE:$WARN[1]#FFFF00 ";
}
if ($CRIT[1] != "") {
        $def[1] .= "HRULE:$CRIT[1]#FF0000 ";
}
$def[1] .= "LINE1:nfs#87CEEB:\"nfs    \" " ;
$def[1] .= "GPRINT:nfs:LAST:\"last\: %6.2lf ops/s\" " ;
$def[1] .= "GPRINT:nfs:AVERAGE:\"avg\: %6.2lf ops/s\" " ;
$def[1] .= "GPRINT:nfs:MAX:\"max\: %6.2lf ops/s\\n\" " ;
$def[1] .= "LINE1:cifs#8FBC8F:\"cifs   \" " ;
$def[1] .= "GPRINT:cifs:LAST:\"last\: %6.2lf ops/s\" " ;
$def[1] .= "GPRINT:cifs:AVERAGE:\"avg\: %6.2lf ops/s\" " ;
$def[1] .= "GPRINT:cifs:MAX:\"max\: %6.2lf ops/s\\n\" " ;

$def[1] .= 'COMMENT:"Template for\: check_netapp_ops\r" ';
$def[1] .= 'COMMENT:"Check Command ' . $TEMPLATE[1] . '\r" ';
?>
