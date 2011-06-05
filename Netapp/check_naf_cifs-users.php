<?php
#
# check_netappfiler -s cp
#
# RRDtool Options
$opt[1] = "--vertical-label \"Nb users\" -l 0 -r --title \"CIFS users on $hostname\"";
$ds_name[1] = 'NetApp CIFS users';
#
#
$def[1] = "";

# Graph Definition

$def[1] .= "DEF:users=$RRDFILE[1]:$DS[1]:AVERAGE "; 
$def[1] .= "AREA:users#6666ffcc: ";
$def[1] .= "LINE1:users#0000ff:\"Cifs users:\" ";
$def[1] .= "GPRINT:users:LAST:\"Last\: %3.1lf \" ";
$def[1] .= "GPRINT:users:MAX:\"Max\: %3.1lf \" ";

?>
