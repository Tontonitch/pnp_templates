<?php
#
# Copyright (c) Yannick Charton
# Plugin: check_snmp_netint.pl
#

$rrd_num_stp_state = "";
$rrd_num_stp_changetime = "";
$rrd_num_in_bps = "";
$rrd_num_out_bps = "";
$rrd_num_in_error = "";
$rrd_num_out_error = "";
$rrd_num_in_discard = "";
$rrd_num_out_discard = "";
$rrd_num_speed_bps = "";
$stp_portstate = array(0 => "unknown","disabled","blocking","listening","learning","forwarding","broken");

foreach ($this->DS as $KEY=>$VAL) {
    if ( preg_match('/stp_state/',$VAL['NAME']) == 1 ) {
        $rrd_num_stp_state = $KEY + 1;
        }
    elseif ( preg_match('/stp_changetime/',$VAL['NAME']) == 1 ) {
        $rrd_num_stp_changetime = $KEY + 1;
        }
    elseif ( preg_match('/in_bps/',$VAL['NAME']) == 1 ) {
        $rrd_num_in_bps = $KEY + 1;
        }
    elseif ( preg_match('/out_bps/',$VAL['NAME']) == 1 ) {
        $rrd_num_out_bps = $KEY + 1;
        }
    elseif ( preg_match('/in_error/',$VAL['NAME']) == 1 ) {
        $rrd_num_in_error = $KEY + 1;
        }
    elseif ( preg_match('/out_error/',$VAL['NAME']) == 1 ) {
        $rrd_num_out_error = $KEY + 1;
        }
    elseif ( preg_match('/in_discard/',$VAL['NAME']) == 1 ) {
        $rrd_num_in_discard = $KEY + 1;
        }
    elseif ( preg_match('/out_discard/',$VAL['NAME']) == 1 ) {
        $rrd_num_out_discard = $KEY + 1;
        }
    elseif ( preg_match('/speed_bps/',$VAL['NAME']) == 1 ) {
        $rrd_num_speed_bps = $KEY + 1;
        }    
}

###############################
# Traffic graph
###############################

$ds_name[1] = 'Interface traffic'; 
$opt[1] = " --vertical-label \"bits/s\" -b 1000 --title \"Interface Traffic for $hostname / $servicedesc\" ";
$opt[1] .= "--watermark=\"Template: check_snmp_netint.php by Yannick Charton\" ";
$def[1] = "";
if ( $rrd_num_in_bps ) {
$def[1] .= "DEF:in_bps=$RRDFILE[$rrd_num_in_bps]:$DS[1]:AVERAGE " ;
$def[1] .= "DEF:out_bps=$RRDFILE[$rrd_num_out_bps]:$DS[1]:AVERAGE " ;

$def[1] .= "AREA:in_bps#32CD32:\"in_bps  \" " ;
$def[1] .= "GPRINT:in_bps:LAST:\"%7.2lf%Sbps last\" " ;
$def[1] .= "GPRINT:in_bps:AVERAGE:\"%7.2lf%Sbps avg\" " ;
$def[1] .= "GPRINT:in_bps:MAX:\"%7.2lf%Sbps max\\n\" " ;
$def[1] .= "LINE1:out_bps#0000CD:\"out_bps \" " ;
$def[1] .= "GPRINT:out_bps:LAST:\"%7.2lf%Sbps last\" " ;
$def[1] .= "GPRINT:out_bps:AVERAGE:\"%7.2lf%Sbps avg\" " ;
$def[1] .= "GPRINT:out_bps:MAX:\"%7.2lf%Sbps max\\n\" ";
if( $rrd_num_speed_bps != "" ) {
    if ($MAX[$rrd_num_in_bps] != "0" and $MAX[$rrd_num_in_bps] != "0") {
        $speed = "".$MAX[$rrd_num_in_bps]."";
        if ($speed >= 1000000000) {$speed = $speed / 1000000000 . "Gbps";}
        elseif ($speed >= 1000000) {$speed = $speed / 1000000 . "Mbps";}
        elseif ($speed >= 1000) {$speed = $speed / 1000 . "Kbps";}
        else {$speed = $speed . "Kbps";}
        }
    else
    {   $speed = "undef";
    }
    $def[1] .= 'COMMENT:"Interface speed\:     ' . $speed . '\\n" ';
}if( $rrd_num_stp_state != "" ) {
    $current_stp_state_num = $ACT[$rrd_num_stp_state];
    $current_stp_state_string = "$stp_portstate[$current_stp_state_num]";
    $def[1] .= 'COMMENT:"Spanning tree state\: ' . $current_stp_state_string . '\\n" ';
}
}

###############################
# Error/discard packets graph
###############################

if (($rrd_num_in_error != "") && ($rrd_num_out_error != "") && ($rrd_num_in_discard != "") && ($rrd_num_out_discard != "")) {
$ds_name[2] = 'Error/discard packets'; 
$opt[2] = " --vertical-label \"pkts/min\" -b 1000 --title \"Error/discard packets for $hostname / $servicedesc\" ";
$opt[2] .= "--watermark=\"Template: check_snmp_netint.php by Yannick Charton\" ";
$def[2] = "DEF:in_error=$RRDFILE[$rrd_num_in_error]:$DS[1]:AVERAGE " ;
$def[2] .= "DEF:in_discard=$RRDFILE[$rrd_num_in_discard]:$DS[1]:AVERAGE " ;
$def[2] .= "DEF:out_error=$RRDFILE[$rrd_num_out_error]:$DS[1]:AVERAGE " ;
$def[2] .= "DEF:out_discard=$RRDFILE[$rrd_num_out_discard]:$DS[1]:AVERAGE " ;

$def[2] .= "AREA:in_error#FFD700:\"in_error    \" " ;
$def[2] .= "GPRINT:in_error:LAST:\"%5.1lf%S last\" " ;
$def[2] .= "GPRINT:in_error:AVERAGE:\"%5.0lf%S avg\" " ;
$def[2] .= "GPRINT:in_error:MAX:\"%5.1lf%S max\\n\" " ;
$def[2] .= "STACK:out_error#FF8C00:\"out_error   \" " ;
$def[2] .= "GPRINT:out_error:LAST:\"%5.1lf%S last\" " ;
$def[2] .= "GPRINT:out_error:AVERAGE:\"%5.0lf%S avg\" " ;
$def[2] .= "GPRINT:out_error:MAX:\"%5.1lf%S max\\n\" ";
$def[2] .= "STACK:in_discard#7B68EE:\"in_discard  \" " ;
$def[2] .= "GPRINT:in_discard:LAST:\"%5.1lf%S last\" " ;
$def[2] .= "GPRINT:in_discard:AVERAGE:\"%5.0lf%S avg\" " ;
$def[2] .= "GPRINT:in_discard:MAX:\"%5.1lf%S max\\n\" ";
$def[2] .= "STACK:out_discard#BA55D3:\"out_discard \" " ;
$def[2] .= "GPRINT:out_discard:LAST:\"%5.1lf%S last\" " ;
$def[2] .= "GPRINT:out_discard:AVERAGE:\"%5.0lf%S avg\" " ;
$def[2] .= "GPRINT:out_discard:MAX:\"%5.1lf%S max\\n\" ";
}
?>
