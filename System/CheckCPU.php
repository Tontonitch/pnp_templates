<?php
#
# Copyright (c) 2006-2008 Joerg Linge (http://www.pnp4nagios.org)
# Plugin: check_load
# $Id: check_load.php 367 2008-01-23 18:10:31Z pitchfork $
#
#
$opt[1] = "--vertical-label % -l0  --title \"Cpu usage for $hostname\" --upper-limit 100 --lower-limit 0 --rigid";
$ds_name[1] = 'Cpu usage';
#
#
#
$def[1] =  "DEF:var1=$RRDFILE[1]:$DS[1]:AVERAGE " ;
$def[1] .= "DEF:var2=$RRDFILE[2]:$DS[2]:AVERAGE " ;
$def[1] .= "DEF:var3=$RRDFILE[3]:$DS[3]:AVERAGE " ;
$def[1] .= "HRULE:$WARN[1]#FFFF00 ";
$def[1] .= "HRULE:$CRIT[1]#FF0000 ";
$def[1] .= "AREA:var3#FF0000:\"$NAME[3] \" " ;
$def[1] .= "GPRINT:var3:LAST:\"Last\: %6.2lf%%\" " ;
$def[1] .= "GPRINT:var3:AVERAGE:\"Avg\: %6.2lf%%\" " ;
$def[1] .= "GPRINT:var3:MAX:\"Max\: %6.2lf%%\\n\" " ;
$def[1] .= "AREA:var2#EA8F00:\"$NAME[2]  \" " ;
$def[1] .= "GPRINT:var2:LAST:\"Last\: %6.2lf%%\" " ;
$def[1] .= "GPRINT:var2:AVERAGE:\"Avg\: %6.2lf%%\" " ;
$def[1] .= "GPRINT:var2:MAX:\"Max\: %6.2lf%%\\n\" " ;
$def[1] .= "AREA:var1#EACC00:\"$NAME[1]  \" " ;
$def[1] .= "GPRINT:var1:LAST:\"Last\: %6.2lf%%\" " ;
$def[1] .= "GPRINT:var1:AVERAGE:\"Avg\: %6.2lf%%\" " ;
$def[1] .= "GPRINT:var1:MAX:\"Max\: %6.2lf%%\\n\" ";
?>
