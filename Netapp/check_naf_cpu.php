<?php
#
# check_netappfiler -s cpu
#
# RRDtool Options
$opt[1] = "--vertical-label By -l 0 -r --title \"CPU usage $hostname / $servicedesc\"";
$ds_name[1] = 'NetApp CPU usage';
$opt[2] = "--vertical-label \"Context Switches\" -l 0 -r --title \"Context switches $hostname / $servicedesc\"";
$ds_name[2] = 'NetApp Context switches';
#
#
$def[1] = "";
$def[2] = "";

# Graphen Definitions

$def[1] .= "DEF:cpu_avg=$RRDFILE[1]:$DS[1]:AVERAGE "; 
$def[1] .= "DEF:cpu_min=$RRDFILE[1]:$DS[1]:MIN "; 
$def[1] .= "DEF:cpu_max=$RRDFILE[1]:$DS[1]:MAX "; 

$def[2] .= "DEF:cs_avg=$RRDFILE[2]:$DS[1]:AVERAGE "; 
$def[2] .= "DEF:cs_min=$RRDFILE[2]:$DS[1]:MIN "; 
$def[2] .= "DEF:cs_max=$RRDFILE[2]:$DS[1]:MAX "; 


$def[1] .= "AREA:cpu_max#6666ffcc: ";
$def[1] .= "AREA:cpu_min#ffffff ";
$def[1] .= "LINE1:cpu_avg#0000ff:\"CPU usage in pct:\" ";
$def[1] .= "GPRINT:cpu_avg:LAST:\"%3.1lf%% \" ";
$def[1] .= "GPRINT:cpu_min:MIN:\"(%3.1lf%% -\" ";
$def[1] .= "GPRINT:cpu_max:MAX:\"%3.1lf%%)\\n\" ";
$def[1] .= "HRULE:$WARN[1]#FFFF00:\"Warning $WARN[1]% \" " ;
$def[1] .= "HRULE:$CRIT[1]#FF0000:\"Critical $CRIT[1]% \" " ;

$def[2] .= "AREA:cs_max#ff6666cc ";
$def[2] .= "AREA:cs_min#ffffff ";
$def[2] .= "LINE1:cs_avg#ff0000:\"Context switches:\" ";
$def[2] .= "GPRINT:cs_avg:LAST:\"%3.1lf%S \" ";
$def[2] .= "GPRINT:cs_min:MIN:\"(%3.1lf%S -\" ";
$def[2] .= "GPRINT:cs_max:MAX:\"%3.1lf%S)\\n\" ";

?>
