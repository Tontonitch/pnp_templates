<?php
#
# Copyright (c) 2006-2008 Joerg Linge (http://www.pnp4nagios.org)
# Plugin: check_load
# $Id: check_load.php 367 2008-01-23 18:10:31Z pitchfork $
#
#
$opt[1] = "--vertical-label \"Nb of messages\" -l0  --title \"Log file scan $hostname / $servicedesc\" ";
$opt[1] .= ' --watermark="Template: check_logfiles by Yannick Charton"';
$ds_name[1] = 'Log file scan';
#
#
#
$def[1] =  "DEF:lines=$RRDFILE[1]:$DS[1]:MAX ";
$def[1] .= "DEF:warnings=$RRDFILE[2]:$DS[2]:MAX ";
$def[1] .= "DEF:criticals=$RRDFILE[3]:$DS[3]:MAX ";
$def[1] .= "DEF:unknowns=$RRDFILE[4]:$DS[4]:MAX ";
$def[1] .= "AREA:lines#98FB98:\"Processed messages \" " ;
$def[1] .= "GPRINT:lines:LAST:\"%6.2lf last\" " ;
$def[1] .= "GPRINT:lines:AVERAGE:\"%6.2lf avg\\n\" " ;
#$def[1] .= "GPRINT:lines:MAX:\"%6.2lf max\\n\" ";
$def[1] .= "AREA:criticals#FF6347:\"Critical messages  \" " ;
$def[1] .= "GPRINT:criticals:LAST:\"%6.2lf last\" " ;
$def[1] .= "GPRINT:criticals:AVERAGE:\"%6.2lf avg\\n\" " ;
#$def[1] .= "GPRINT:criticals:MAX:\"%6.2lf max\\n\" " ;
$def[1] .= "STACK:warnings#FFFF00:\"Warning messages   \" " ;
$def[1] .= "GPRINT:warnings:LAST:\"%6.2lf last\" " ;
$def[1] .= "GPRINT:warnings:AVERAGE:\"%6.2lf avg\\n\" " ;
#$def[1] .= "GPRINT:warnings:MAX:\"%6.2lf max\\n\" " ;
$def[1] .= "STACK:unknowns#C0C0C0:\"Unknown messages   \" " ;
$def[1] .= "GPRINT:unknowns:LAST:\"%6.2lf last\" " ;
$def[1] .= "GPRINT:unknowns:AVERAGE:\"%6.2lf avg\\n\" " ;
#$def[1] .= "GPRINT:unknowns:MAX:\"%6.2lf max\\n\" ";
?>
