<?php
#
# Copyright (c) 2009 Yannick Charton
# Plugin: check_snmp_mem.pl
#

#
# Define some colors ..
#
$_WARNRULE = '#FFFF00';
$_CRITRULE = '#FF0000';
$_MAXRULE  = '#000000';
$_AREA     = '#256aef';
$_LINE     = '#000000';

if ($WARN[1] != "") {
        $warning = $WARN[1];
}
if ($CRIT[1] != "") {
        $critical = $CRIT[1];
}
if ($MAX[1] != "") {
        $maximum = $MAX[1];
}

$opt[1] = "--vertical-label bytes --title \"Memory usage for $hostname\" --lower-limit=0 --upper-limit=$maximum --rigid ";
$ds_name[1] = 'Memory usage';
#
#
#
$def[1] =  "DEF:mem=$RRDFILE[1]:$DS[1]:AVERAGE ";

$def[1] .= "HRULE:$warning$_WARNRULE ";
$def[1] .= "HRULE:$critical$_CRITRULE ";
$def[1] .= "HRULE:$maximum$_MAXRULE ";

$def[1] .= "AREA:mem#FFFF00:\"Used \" " ;
$def[1] .= "GPRINT:mem:LAST:\"Last\: %6.2lf%SB \" " ;
$def[1] .= "GPRINT:mem:AVERAGE:\"Avg\: %6.2lf%SB \" " ;
$def[1] .= "GPRINT:mem:MAX:\"Max\: %6.2lf%SB \\n\" " ;

$def[1] .= "CDEF:max=mem,0,*,$maximum,+ ";
$def[1] .= "GPRINT:max:LAST:\"Total DRAM\: %6.2lf%SB \\n\" ";

$def[1] .= 'COMMENT:"Template for\: check_snmp_mem.pl\r" ';
$def[1] .= 'COMMENT:"Check Command ' . $TEMPLATE[1] . '\r" ';
?>
