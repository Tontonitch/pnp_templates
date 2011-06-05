<?php
#
# Copyright (c) 2010 Yannick Charton
# Plugin: check_snmp_process
#

# Define some colors ..
#-------------------------
$_WARNRULE = '#FFFF00';
$_CRITRULE = '#FF0000';
$_AREA     = '#90EE90';
$_LINE     = '#000000';


# Number of processes graph
#-------------------------
$ds_name[1] = 'Number of processes';
$opt[1] = " --vertical-label \"nb of processes\" -b 1000 --title \"$hostname / Number of $servicedesc processes\" --lower-limit 0 --rigid";
$opt[1] .= " --watermark=\"Template: $TEMPLATE[1] by Yannick Charton\" ";
$def[1] = "DEF:nb_proc=$RRDFILE[3]:$DS[1]:AVERAGE ";
$def[1] .= "AREA:nb_proc".$_AREA.":\"Nb processes\" ";
$def[1] .= "LINE1:nb_proc".$_LINE.":\"\" ";
$def[1] .= "GPRINT:nb_proc:LAST:\"%3.0lf last\" " ;
$def[1] .= "GPRINT:nb_proc:AVERAGE:\"%3.0lf avg\" " ;
$def[1] .= "GPRINT:nb_proc:MAX:\"%3.0lf max\\n\" " ;

# Cpu used
#-------------------------
if(isset($RRDFILE[3])){
$ds_name[2] = 'Cpu usage';
$opt[2] = " --vertical-label \"%\" -b 1000 --title \"$hostname / Cpu used by $servicedesc\" --lower-limit 0 --rigid";
$opt[2] .= " --watermark=\"Template: $TEMPLATE[1] by Yannick Charton\" ";
$def[2] = "DEF:cpu_used=$RRDFILE[2]:$DS[1]:AVERAGE ";
$def[2] .= "AREA:cpu_used".$_AREA.":\"Cpu used\" ";
$def[2] .= "LINE1:cpu_used".$_LINE.":\"\" ";
$def[2] .= "GPRINT:cpu_used:LAST:\"%4.1lf%% last\" " ;
$def[2] .= "GPRINT:cpu_used:AVERAGE:\"%4.1lf%% avg\" " ;
$def[2] .= "GPRINT:cpu_used:MAX:\"%4.1lf%% max\\n\" " ;
}

# Ram used
#-------------------------
if(isset($RRDFILE[2])){
$ds_name[3] = 'Ram usage';
$opt[3] = " --vertical-label \"MBytes\" -b 1024 --title \"$hostname / Ram used by $servicedesc\" --lower-limit 0 --rigid";
$opt[3] .= " --watermark=\"Template: $TEMPLATE[1] by Yannick Charton\" ";
$def[3] = "DEF:ram_used=$RRDFILE[1]:$DS[1]:AVERAGE ";
$def[3] .= "AREA:ram_used".$_AREA.":\"Ram used\" ";
$def[3] .= "LINE1:ram_used".$_LINE.":\"\" ";
$def[3] .= "GPRINT:ram_used:LAST:\"Last\: %6.2lf %SMB\" " ;
$def[3] .= "GPRINT:ram_used:AVERAGE:\"Avg\: %6.2lf %SMB\" " ;
$def[3] .= "GPRINT:ram_used:MAX:\"Max\: %6.2lf %SMB\\n\" " ;
}

?>
