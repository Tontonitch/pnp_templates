<?php
$opt[1] = " --slope-mode --vertical-label \"Count\" -b 1000 --title \"CIFS Statistics for $hostname\" ";
$ds_name[1] = 'NetApp CIFS Statistics';

$def[1] = "DEF:total_ops=$RRDFILE[1]:$DS[1]:AVERAGE " ;
$def[1] .= "DEF:total_calls=$RRDFILE[2]:$DS[1]:AVERAGE " ;
$def[1] .= "DEF:bad_calls=$RRDFILE[3]:$DS[1]:AVERAGE " ;
$def[1] .= "DEF:get_attrs=$RRDFILE[4]:$DS[1]:AVERAGE " ;
$def[1] .= "DEF:reads=$RRDFILE[5]:$DS[1]:AVERAGE " ;
$def[1] .= "DEF:writes=$RRDFILE[6]:$DS[1]:AVERAGE " ;
$def[1] .= "DEF:locks=$RRDFILE[7]:$DS[1]:AVERAGE " ;
$def[1] .= "DEF:opens=$RRDFILE[8]:$DS[1]:AVERAGE " ;
$def[1] .= "DEF:dirops=$RRDFILE[9]:$DS[1]:AVERAGE " ;
$def[1] .= "DEF:others=$RRDFILE[10]:$DS[1]:AVERAGE " ;
# Total Ops
$def[1] .= "LINE1:total_ops#003300:\"total ops\\t\\t\" " ;
$def[1] .= "GPRINT:total_ops:LAST:\"%7.2lf %S last\\t\" " ;
$def[1] .= "GPRINT:total_ops:AVERAGE:\"%7.2lf %S avg\\t\" " ;
$def[1] .= "GPRINT:total_ops:MAX:\"%7.2lf %S max\\n\" ";
# Total Calls
$def[1] .= "LINE1:total_calls#ff309b:\"total calls\\t\" " ;
$def[1] .= "GPRINT:total_calls:LAST:\"%7.2lf %S last\\t\" " ;
$def[1] .= "GPRINT:total_calls:AVERAGE:\"%7.2lf %S avg\\t\" " ;
$def[1] .= "GPRINT:total_calls:MAX:\"%7.2lf %S max\\n\" ";
# Bad Calls
$def[1] .= "LINE1:bad_calls#ff0000:\"bad calls\\t\\t\" " ;
$def[1] .= "GPRINT:bad_calls:LAST:\"%7.2lf %S last\\t\" " ;
$def[1] .= "GPRINT:bad_calls:AVERAGE:\"%7.2lf %S avg\\t\" " ;
$def[1] .= "GPRINT:bad_calls:MAX:\"%7.2lf %S max\\n\" ";
# Get Attrs
$def[1] .= "LINE1:get_attrs#00803b:\"get attrs\\t\\t\" " ;
$def[1] .= "GPRINT:get_attrs:LAST:\"%7.2lf %S last\\t\" " ;
$def[1] .= "GPRINT:get_attrs:AVERAGE:\"%7.2lf %S avg\\t\" " ;
$def[1] .= "GPRINT:get_attrs:MAX:\"%7.2lf %S max\\n\" ";
# Reads
$def[1] .= "LINE1:reads#003bff:\"reads\\t\\t\" " ;
$def[1] .= "GPRINT:reads:LAST:\"%7.2lf %S last\\t\" " ;
$def[1] .= "GPRINT:reads:AVERAGE:\"%7.2lf %S avg\\t\" " ;
$def[1] .= "GPRINT:reads:MAX:\"%7.2lf %S max\\n\" ";
# Writes
$def[1] .= "LINE1:writes#00ff04:\"writes\\t\\t\" " ;
$def[1] .= "GPRINT:writes:LAST:\"%7.2lf %S last\\t\" " ;
$def[1] .= "GPRINT:writes:AVERAGE:\"%7.2lf %S avg\\t\" " ;
$def[1] .= "GPRINT:writes:MAX:\"%7.2lf %S max\\n\" ";
# Locks
$def[1] .= "LINE1:locks#ff8c00:\"locks\\t\\t\" " ;
$def[1] .= "GPRINT:locks:LAST:\"%7.2lf %S last\\t\" " ;
$def[1] .= "GPRINT:locks:AVERAGE:\"%7.2lf %S avg\\t\" " ;
$def[1] .= "GPRINT:locks:MAX:\"%7.2lf %S max\\n\" ";
# Opens
$def[1] .= "LINE1:opens#c0c600:\"opens\\t\\t\" " ;
$def[1] .= "GPRINT:opens:LAST:\"%7.2lf %S last\\t\" " ;
$def[1] .= "GPRINT:opens:AVERAGE:\"%7.2lf %S avg\\t\" " ;
$def[1] .= "GPRINT:opens:MAX:\"%7.2lf %S max\\n\" ";
# Dirops
$def[1] .= "LINE1:dirops#bf2bff:\"dirops\\t\\t\" " ;
$def[1] .= "GPRINT:dirops:LAST:\"%7.2lf %S last\\t\" " ;
$def[1] .= "GPRINT:dirops:AVERAGE:\"%7.2lf %S avg\\t\" " ;
$def[1] .= "GPRINT:dirops:MAX:\"%7.2lf %S max\\n\" ";
# Others
$def[1] .= "LINE1:others#6dacff:\"others\\t\\t\" " ;
$def[1] .= "GPRINT:others:LAST:\"%7.2lf %S last\\t\" " ;
$def[1] .= "GPRINT:others:AVERAGE:\"%7.2lf %S avg\\t\" " ;
$def[1] .= "GPRINT:others:MAX:\"%7.2lf %S max\\n\" ";
?>
