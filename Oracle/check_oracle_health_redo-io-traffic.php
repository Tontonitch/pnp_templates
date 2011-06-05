<?php
#
# Pnp template for check_oracle_health redo-io checkcommand.
# Includes the possibility to choose if and how datasources are gathered.
# Exemple: $gather_graphs=1 means all percent datasources are plotted on a unique graph, while
# all bytes datasources are plotted on separate graphs.
# By Yannick Charton (tontonitch-pro@yahoo.fr)
# Based on Joerg Linge templates
#


#
# Define some colors ..
#
$_WARNRULE = '#FFFF00';
$_CRITRULE = '#FF0000';
$_MAXRULE = '#000000';

#
# Define some variables ..
#
$for_check_command="check_oracle_health redo-io";

#
# Initial Logic ...
#

$opt[1] = "--vertical-label \"MB/s\" -X0 --title \"Redo IO $hostname / $servicedesc\" --lower=0 --alt-y-grid --rigid";
$opt[1] .= ' --watermark="Template for '.$for_check_command.' by Yannick Charton"';
$ds_name[1] = 'Oracle redo IO';

$def[1] =  "DEF:var1=$RRDFILE[1]:$DS[1]:AVERAGE " ;
$def[1] .= "AREA:var1#F2F2F2:\"\" " ;
$def[1] .= "LINE1:var1#696969:\"Redo IO\" " ;
$def[1] .= "GPRINT:var1:LAST:\"%3.4lf MB/s LAST \" "; 
$def[1] .= "GPRINT:var1:MAX:\"%3.4lf MB/s MAX \" "; 
$def[1] .= "GPRINT:var1:AVERAGE:\"%3.4lf MB/s AVERAGE \\n\" "; 

if ($WARN[1] != "") {
        $def[1] .= "HRULE:" . $WARN[1] . $_WARNRULE . ':"Warning on\:  ' . $WARN[1] . ' MB/s\n" ';
}
if ($CRIT[1] != "") {
        $def[1] .= "HRULE:" . $CRIT[1] . $_CRITRULE . ':"Critical on\: ' . $CRIT[1] . ' MB/s\n" ';
}
?>
