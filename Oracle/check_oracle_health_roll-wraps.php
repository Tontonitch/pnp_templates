<?php
#
# Copyright (c) 2009 Yannick Charton
# Plugin: check_oracle_health_roll-wraps
#
#

#
# Define some colors ..
#
$_WARNRULE = '#FFFF00';
$_CRITRULE = '#FF0000';
$_MAXRULE = '#000000';
$_AREA = '#EACC00';
$_LINE = '#000000';

#
# Initial Logic ...
#

$opt[1] = "--title \"$hostname / $servicedesc\" --lower=0 --rigid";
$ds_name[1] = 'Oracle rollback wraps';

$def[1] =  "DEF:var1=$RRDFILE[1]:$DS[1]:AVERAGE ";
if ($WARN[1] != "") {
        $def[1] .= "HRULE:$WARN[1]#FFFF00 ";
}
if ($CRIT[1] != "") {
        $def[1] .= "HRULE:$CRIT[1]#FF0000 ";
}
$def[1] .= "AREA:var1" . $_AREA . ":\"$NAME[1] \" ";
$def[1] .= "LINE1:var1" . $_LINE . ":\"\" ";
$def[1] .= "GPRINT:var1:LAST:\"%6.2lf%S last\" " ;
$def[1] .= "GPRINT:var1:AVERAGE:\"%6.2lf%S avg\" " ;
$def[1] .= "GPRINT:var1:MAX:\"%6.2lf%S max\\n\" " ;

$def[1] .= 'COMMENT:"Template for\: check_oracle_health_roll-wraps\r" ';
$def[1] .= 'COMMENT:"Check Command ' . $TEMPLATE[1] . '\r" ';
?>