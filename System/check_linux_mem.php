<?php
#
# Copyright (c) 2009 Yannick Charton
# Plugin: check_mem
#
#
$opt[1] = "--vertical-label % --title \"Memory usage for $hostname\" --lower-limit=0 --upper-limit=100 --rigid ";
$ds_name[1] = 'Memory usage';
$opt[2] = "--vertical-label % --title \"Swap usage for $hostname\" --lower-limit=0 --upper-limit=100 --rigid ";
$ds_name[2] = 'Swap usage';
#
#
#
$def[1] =  "DEF:var1=$RRDFILE[1]:$DS[1]:AVERAGE ";
$def[1] .= "DEF:var2=$RRDFILE[2]:$DS[2]:AVERAGE ";
$def[1] .= "DEF:var3=$RRDFILE[3]:$DS[3]:AVERAGE ";
$def[1] .= "DEF:var4=$RRDFILE[4]:$DS[4]:AVERAGE ";
$def[1] .= "DEF:var5=$RRDFILE[5]:$DS[5]:AVERAGE ";
$def[2] =  "DEF:var6=$RRDFILE[6]:$DS[6]:AVERAGE ";

$def[1] .= "HRULE:$WARN[1]#FFFF00 ";
$def[1] .= "HRULE:$CRIT[1]#FF0000 ";

$def[1] .= "AREA:var1#FFFF00:\"Used        \" " ;
$def[1] .= "GPRINT:var1:LAST:\"%6.2lf last\" " ;
$def[1] .= "GPRINT:var1:AVERAGE:\"%6.2lf avg\" " ;
$def[1] .= "GPRINT:var1:MAX:\"%6.2lf max\\n\" " ;
#$def[1] .= "STACK:var2#D3D3D3:\"Shared      \" " ;
#$def[1] .= "GPRINT:var2:LAST:\"%6.2lf last\" " ;
#$def[1] .= "GPRINT:var2:AVERAGE:\"%6.2lf avg\" " ;
#$def[1] .= "GPRINT:var2:MAX:\"%6.2lf max\\n\" " ;
$def[1] .= "STACK:var3#D3D3D3:\"Buffers     \" " ;
$def[1] .= "GPRINT:var3:LAST:\"%6.2lf last\" " ;
$def[1] .= "GPRINT:var3:AVERAGE:\"%6.2lf avg\" " ;
$def[1] .= "GPRINT:var3:MAX:\"%6.2lf max\\n\" ";
$def[1] .= "STACK:var4#DCDCDC:\"Cached      \" " ;
$def[1] .= "GPRINT:var4:LAST:\"%6.2lf last\" " ;
$def[1] .= "GPRINT:var4:AVERAGE:\"%6.2lf avg\" " ;
$def[1] .= "GPRINT:var4:MAX:\"%6.2lf max\\n\" ";

$def[2] .= "HRULE:$WARN[6]#FFFF00 ";
$def[2] .= "HRULE:$CRIT[6]#FF0000 ";

$def[2] .= "AREA:var6#FFFF00:\"Swap used\" " ;
$def[2] .= "GPRINT:var6:LAST:\"%6.2lf last\" " ;
$def[2] .= "GPRINT:var6:AVERAGE:\"%6.2lf avg\" " ;
$def[2] .= "GPRINT:var6:MAX:\"%6.2lf max\\n\" " ;

$def[2] .= 'COMMENT:"Template for\: check_linux_mem\r" ';
$def[2] .= 'COMMENT:"Check Command ' . $TEMPLATE[1] . '\r" ';
?>
