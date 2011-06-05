<?php
#
# check_netappfiler -s cp
#
# RRDtool Options
$opt[1] = "--vertical-label seconds -l 0 -r --title \"CP ops in progress on $hostname\"";
$ds_name[1] = 'NetApp CP ops in progress';
$opt[2] = "--vertical-label \"operations\" -l 0 -r --title \"Reasons for CP ops on $hostname\"";
$ds_name[2] = 'NetApp Reasons for CP ops';
#
#
$def[1] = "";
$def[2] = "";

# Graphen Definitions

$def[1] .= "DEF:progress=$RRDFILE[1]:$DS[1]:AVERAGE "; 

$def[2] .= "DEF:total=$RRDFILE[2]:$DS[1]:AVERAGE "; 
$def[2] .= "DEF:snapshot=$RRDFILE[3]:$DS[1]:AVERAGE "; 
$def[2] .= "DEF:lowwater=$RRDFILE[4]:$DS[1]:AVERAGE "; 
$def[2] .= "DEF:highwater=$RRDFILE[5]:$DS[1]:AVERAGE "; 
$def[2] .= "DEF:logfull=$RRDFILE[6]:$DS[1]:AVERAGE "; 
$def[2] .= "DEF:b2b=$RRDFILE[7]:$DS[1]:AVERAGE "; 
$def[2] .= "DEF:flush=$RRDFILE[8]:$DS[1]:AVERAGE "; 
$def[2] .= "DEF:sync=$RRDFILE[9]:$DS[1]:AVERAGE "; 
$def[2] .= "DEF:lowvbuf=$RRDFILE[10]:$DS[1]:AVERAGE "; 
$def[2] .= "DEF:deferred=$RRDFILE[11]:$DS[1]:AVERAGE "; 
$def[2] .= "DEF:lowdatavecs=$RRDFILE[12]:$DS[1]:AVERAGE "; 


$def[1] .= "AREA:progress#6666ffcc: ";
$def[1] .= "LINE1:progress#0000ff:\"Time in progress:\" ";
$def[1] .= "GPRINT:progress:LAST:\"%3.1lfs \" ";

$def[2] .= "LINE2:total#000000:\"Total\:           \" ";
$def[2] .= "GPRINT:total:LAST:\"%0.0lf \\n\" ";
$def[2] .= "AREA:snapshot#ff0000:\"Snapshot\:        \" ";
$def[2] .= "GPRINT:snapshot:LAST:\"%0.0lf \\n\" ";
$def[2] .= "AREA:lowwater#0000ff:\"Low water mark\:  \":STACK ";
$def[2] .= "GPRINT:lowwater:LAST:\"%0.0lf \\n\" ";
$def[2] .= "AREA:highwater#ccccff:\"High water mark\: \":STACK ";
$def[2] .= "GPRINT:highwater:LAST:\"%0.0lf \\n\" ";
$def[2] .= "AREA:logfull#00ff00:\"Log full\:        \":STACK ";
$def[2] .= "GPRINT:logfull:LAST:\"%0.0lf \\n\" ";
$def[2] .= "AREA:b2b#ff00ff:\"Back-to-back\:    \":STACK ";
$def[2] .= "GPRINT:b2b:LAST:\"%0.0lf \\n\" ";
$def[2] .= "AREA:flush#00ffff:\"FS flush\:        \":STACK ";
$def[2] .= "GPRINT:flush:LAST:\"%0.0lf \\n\" ";
$def[2] .= "AREA:sync#ffff00:\"FS sync\:         \":STACK ";
$def[2] .= "GPRINT:sync:LAST:\"%0.0lf \\n\" ";
$def[2] .= "AREA:lowvbuf#7f7f7f:\"Low vBuffer\:     \":STACK ";
$def[2] .= "GPRINT:lowvbuf:LAST:\"%0.0lf \\n\" ";
$def[2] .= "AREA:deferred#cc0000:\"Deferred\:        \":STACK ";
$def[2] .= "GPRINT:deferred:LAST:\"%0.0lf \\n\" ";
$def[2] .= "AREA:lowdatavecs#ffccff:\"Low data Vecs\:   \":STACK ";
$def[2] .= "GPRINT:lowdatavecs:LAST:\"%0.0lf \\n\" ";
$def[2] .= "LINE2:total#000000 ";

?>
