<?php
#
# Copyright (c) 2006-2008 Joerg Linge (http://www.pnp4nagios.org)
# $Id: check_oracle_health_connection-time.php 523 2008-09-26 17:10:20Z pitchfork $
#

#
# Define some colors ..
#
$_WARNRULE = '#FFFF00';
$_CRITRULE = '#FF0000';
$_MAXRULE = '#000000';
$_AREA = '#1E90FF';
$_LINE = '#000000';

$warning = "";
$minimum = "";
$critical = "";
$warning = "";
$vlabel = "";

if ($WARN[1] != "") {
        $warning = $WARN[1];
}
if ($CRIT[1] != "") {
        $critical = $CRIT[1];
}
if ($MIN[1] != "") {
        $lower = " --lower-limit=" . $MIN[1];
        $minimum = $MIN[1];
}
if ($MAX[1] != "") {
        $upper = " --upper-limit=" . $MAX[1];
        $maximum = $MAX[1];
}
if ($UNIT[1] == "%%") {
	$vlabel = "%";
}
else {
	$vlabel = $UNIT[1];
}

$opt[1] = "--vertical-label \"Nb blocking locks\" --title \"$hostname - Locks\" ";
$opt[1] .= '--watermark="Template: check_oracle_health_blocking-locks.php by Yannick Charton"';
$ds_name[1] = 'Blocking Locks';
$def[1] = "";

if ($warning != "") {
        $def[1] .= "HRULE:" . $warning . $_WARNRULE . ':"Warning on\: ' . $warning . 's" ';
}
if ($critical != "") {
        $def[1] .= "HRULE:" . $critical . $_CRITRULE . ':"Critical on\: ' . $critical . 's\n" ';
}

$def[1] =  "DEF:var1=$RRDFILE[1]:$DS[1]:MAX " ;
$def[1] .= "AREA:var1" . $_AREA . ":\"Blocking locks\" ";
$def[1] .= "LINE1:var1" . $_LINE . ":\"\" ";
$def[1] .= "GPRINT:var1:LAST:\"%3.2lf LAST \" "; 
$def[1] .= "GPRINT:var1:MAX:\"%3.2lf MAX \" "; 
$def[1] .= "GPRINT:var1:AVERAGE:\"%3.2lf AVERAGE \\n\" "; 

?>
