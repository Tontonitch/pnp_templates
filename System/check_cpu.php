<?php
#
# Copyright (c) 2009 Yannick Charton
# Plugin: check_cpu
#
#
$opt[1] = "--vertical-label % --title \"CPU usage for $hostname\" --upper-limit 100 --lower-limit 0 --rigid";
$ds_name[1] = 'CPU usage';
#
#
#
$def[1] =  "DEF:var1=$RRDFILE[1]:$DS[1]:AVERAGE ";
$def[1] .= "DEF:var2=$RRDFILE[2]:$DS[2]:AVERAGE " ;
$def[1] .= "DEF:var3=$RRDFILE[3]:$DS[3]:AVERAGE " ;
$def[1] .= "DEF:var4=$RRDFILE[4]:$DS[4]:AVERAGE " ;
$def[1] .= "HRULE:$WARN[1]#FFFF00 ";
$def[1] .= "HRULE:$CRIT[1]#FF0000 ";
$def[1] .= "AREA:var1#FFD700:\"user  \" " ;
$def[1] .= "GPRINT:var1:LAST:\"%6.2lf last\" " ;
$def[1] .= "GPRINT:var1:AVERAGE:\"%6.2lf avg\" " ;
$def[1] .= "GPRINT:var1:MAX:\"%6.2lf max\\n\" " ;
$def[1] .= "STACK:var2#F08080:\"sys   \" " ;
$def[1] .= "GPRINT:var2:LAST:\"%6.2lf last\" " ;
$def[1] .= "GPRINT:var2:AVERAGE:\"%6.2lf avg\" " ;
$def[1] .= "GPRINT:var2:MAX:\"%6.2lf max\\n\" " ;
$def[1] .= "STACK:var3#800080:\"iowait\" " ;
$def[1] .= "GPRINT:var3:LAST:\"%6.2lf last\" " ;
$def[1] .= "GPRINT:var3:AVERAGE:\"%6.2lf avg\" " ;
$def[1] .= "GPRINT:var3:MAX:\"%6.2lf max\\n\" ";

$def[1] .= 'COMMENT:"Template for\: check_cpu\r" ';
$def[1] .= 'COMMENT:"Check Command ' . $TEMPLATE[1] . '\r" ';
?>
