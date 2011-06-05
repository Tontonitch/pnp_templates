<?php
#
# By Yannick Charton (tontonitch-pro@yahoo.fr)
# Based on Joerg Linge templates
#

#
# Define some colors ..
#
$_WARNRULE = '#FFFF00';
$_CRITRULE = '#FF0000';
$_AREA     = '#256aef';
$_LINE     = '#000000';
#
# Initial Logic ...
#

$opt[1] = '--vertical-label "ratio (%)" --title "' . $hostname .' / SGA data buffer hit ratio" --upper-limit=100 --lower-limit=0 --rigid';
$opt[1] .= ' --watermark="Template: check_oracle_health_sga-data-buffer-hit-ratio by Yannick Charton"';
$ds_name[1] = $LABEL[1];
$def[1]  = rrd::def     ("var1", $RRDFILE[1], $DS[1], "AVERAGE");
#$def[1] .= rrd::area    ("var1", $_AREA, "Hit ratio", 20);
$def[1] .= rrd::gradient("var1", "#90EE90", "#8FBC8F", "Hit ratio", 20);
$def[1] .= rrd::line1   ("var1", $_LINE );
$def[1] .= rrd::gprint  ("var1", array("LAST","MAX","AVERAGE"), "%3.2lf %S%%");

#if ($WARN_MIN[1] != "") {
#    $def[1] .= "HRULE:$WARN_MIN[1]" . $_WARNRULE . "\n";
#}
#if ($CRIT_MIN[1] != "") {
#    $def[1] .= "HRULE:$CRIT_MIN[1]" . $_CRITRULE . "\n";
#}


?>
