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
$def[1]  = "DEF:var1=$RRDFILE[1]:$DS[1]:MAX " ;   #used
$def[1] .= "DEF:var2=$RRDFILE[2]:$DS[1]:MAX " ;   #system
$def[1] .= "DEF:var3=$RRDFILE[3]:$DS[1]:MAX " ;   #user
$def[1] .= "DEF:var4=$RRDFILE[4]:$DS[1]:MAX " ;   #nice
$def[1] .= "DEF:var5=$RRDFILE[5]:$DS[1]:MAX " ;   #iowait
$def[1] .= "DEF:var6=$RRDFILE[6]:$DS[1]:MAX " ;   #irq
$def[1] .= "DEF:var7=$RRDFILE[7]:$DS[1]:MAX " ;   #softirq
$def[1] .= "LINE1:var1#000000:\" used   \" " ;
$def[1] .= "GPRINT:var1:LAST:\"%7.2lf %S LAST\" ";
$def[1] .= "GPRINT:var1:MAX:\"%7.2lf %S MAX\" ";
$def[1] .= "GPRINT:var1:AVERAGE:\"%7.2lf %S AVERAGE\\n\" ";
$def[1] .= "AREA:var2#EACC00:\" system \" " ;
$def[1] .= "GPRINT:var2:LAST:\"%7.2lf %S LAST\" ";
$def[1] .= "GPRINT:var2:MAX:\"%7.2lf %S MAX\" ";
$def[1] .= "GPRINT:var2:AVERAGE:\"%7.2lf %S AVERAGE\\n\" ";
$def[1] .= "AREA:var3#00FF00:\" user   \":STACK " ;
$def[1] .= "GPRINT:var3:LAST:\"%7.2lf %S LAST\" ";
$def[1] .= "GPRINT:var3:MAX:\"%7.2lf %S MAX\" ";
$def[1] .= "GPRINT:var3:AVERAGE:\"%7.2lf %S AVERAGE\\n\" ";
$def[1] .= "AREA:var4#005500:\" nice   \":STACK " ;
$def[1] .= "GPRINT:var4:LAST:\"%7.2lf %S LAST\" ";
$def[1] .= "GPRINT:var4:MAX:\"%7.2lf %S MAX\" ";
$def[1] .= "GPRINT:var4:AVERAGE:\"%7.2lf %S AVERAGE\\n\" ";
$def[1] .= "AREA:var5#FF0000:\" iowait \":STACK " ;
$def[1] .= "GPRINT:var5:LAST:\"%7.2lf %S LAST\" ";
$def[1] .= "GPRINT:var5:MAX:\"%7.2lf %S MAX\" ";
$def[1] .= "GPRINT:var5:AVERAGE:\"%7.2lf %S AVERAGE\\n\" ";
$def[1] .= "AREA:var6#FFFF00:\" irq    \":STACK " ;
$def[1] .= "GPRINT:var6:LAST:\"%7.2lf %S LAST\" ";
$def[1] .= "GPRINT:var6:MAX:\"%7.2lf %S MAX\" ";
$def[1] .= "GPRINT:var6:AVERAGE:\"%7.2lf %S AVERAGE\\n\" ";
$def[1] .= "AREA:var7#555500:\" softirq\":STACK " ;
$def[1] .= "GPRINT:var7:LAST:\"%7.2lf %S LAST\" ";
$def[1] .= "GPRINT:var7:MAX:\"%7.2lf %S MAX\" ";
$def[1] .= "GPRINT:var7:AVERAGE:\"%7.2lf %S AVERAGE\\n\" ";
if($WARN[1] != ""){
  $def[1] .= "HRULE:".$WARN[1]."#FFFF00:\"Warning Level  ".$WARN[1]."% \" " ;
}
if($CRIT[1] != ""){
  $def[1] .= "HRULE:".$CRIT[1]."#FF0000:\"Critical Level  ".$CRIT[1]."%\\n\" " ;
}
$def[1] .= 'COMMENT:"Template for\: check_linux_cpu\r" ';
$def[1] .= 'COMMENT:"Check Command ' . $TEMPLATE[1] . '\r" ';
?>
