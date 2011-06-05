<?php

#
# Pnp template for check_oracle_health sysstat checkcommand.
# By Yannick Charton (tontonitch-pro@yahoo.fr)
# Based on Joerg Linge templates
#

#
# Define some colors ..
#

$_WARNRULE  = '#FFFF00';
$_CRITRULE  = '#FF0000';
$_MAXRULE   = '#000000';
$_AREA_PRCT = '#256aef';
$_AREA_BYTE = '#8FBC8F';
$_LINE      = '#000000';
$colors     = array("#CC3300","#CC3333","#CC3366","#CC3399","#CC33CC",
"#CC33FF","#336600","#336633","#336666","#336699","#3366CC","#3366FF",
"#33CC33","#33CC66","#609978","#922A99","#997D6D","#174099","#1E9920",
"#E88854","#AFC5E8","#57FA44","#FA6FF6","#008080","#D77038","#272B26",
"#70E0D9","#0A19EB","#E5E29D","#930526","#26FF4A","#ABC2FF","#E2A3FF",
"#808000","#000000","#00FAFA","#E5FA79","#F8A6FF","#FF36CA","#B8FFE7",
"#CD36FF","#CC3300","#CC3333","#CC3366","#CC3399","#CC33CC","#CC33FF",
"#336600","#336633","#336666","#336699","#3366CC","#3366FF","#33CC33",
"#33CC66","#609978","#922A99","#997D6D","#174099","#1E9920","#E88854",
"#AFC5E8","#57FA44","#FA6FF6","#008080","#D77038","#272B26","#70E0D9",
"#0A19EB","#E5E29D","#930526","#26FF4A","#ABC2FF","#E2A3FF","#808000",
"#000000","#00FAFA","#E5FA79","#F8A6FF","#CC3300","#CC3333","#CC3366",
"#CC3399","#CC33CC","#CC33FF","#336600","#336633","#336666","#336699",
"#3366CC","#3366FF","#33CC33","#33CC66","#609978","#922A99","#997D6D",
"#174099","#1E9920","#E88854","#AFC5E8","#57FA44","#FA6FF6","#008080",
"#D77038","#272B26","#70E0D9","#0A19EB","#E5E29D","#930526","#26FF4A",
"#ABC2FF","#E2A3FF","#808000","#000000","#00FAFA","#E5FA79","#F8A6FF",
"#FF36CA","#B8FFE7","#CD36FF");

#
# Define some variables ..
#

## Parameters
$display_mode = 0;  # 0: display only per sec graphs
                    # 1: display only counter graphs
                    # 2: display per sec graphs + counter graphs

#Other variables
$num_graph=0;
$for_check_command="check_oracle_health sysstat";

#
# Initial Logic ...
#

foreach($this->DS as $KEY => $VAL){
    $maximum  = "";
    $minimum  = "";
    $critical = "";
    $warning  = "";
    $vlabel   = "";
    $lower    = "";
    $upper    = "";

    if ($VAL['WARN'] != "")   {$warning = $VAL['WARN'];}
    if ($VAL['CRIT'] != "")   {$critical = $VAL['CRIT'];}
    if ($VAL['MIN'] != "")    {$lower = " --lower=" . $VAL['MIN']; $minimum = $VAL['MIN'];}
    if ($VAL['MAX'] != "")    {$maximum = $VAL['MAX'];}
    if ($VAL['UNIT'] == "%%") {$vlabel = "%"; $upper = " --upper=101 "; $lower = " --lower=0 ";}
        else                  {$vlabel = $VAL['UNIT'];}

    # Percentage graph

    if((($display_mode == 0) || ($display_mode == 2)) && (preg_match('/_per_sec$/',$VAL['LABEL']))){
        $num_graph++;
        $label = substr($VAL['LABEL'], 0,-8);
        $label = rrd::cut($label, 20);
        $ds_name[$num_graph] = "Sysstats per second - $label";
        $opt[$num_graph] = '--vertical-label "per second" --title "Sysstats per second - '.$label.'"  --rigid' . $upper . $lower;
        $opt[$num_graph] .= ' --watermark="Template for '.$for_check_command.' by Yannick Charton"';
        if(!isset($def[$num_graph])){$def[$num_graph] = "";}
        $def[$num_graph] .= rrd::def     ("var$KEY", $VAL['RRDFILE'], $VAL['DS'], "AVERAGE");
        $def[$num_graph] .= rrd::line1   ("var$KEY", $colors[$KEY], $label );
        $def[$num_graph] .= rrd::gprint  ("var$KEY", array("LAST","MAX","AVERAGE"), "%8.2lf/s");
//        if ($warning != "") {
//            $def[$num_graph] .= rrd::hrule($warning, $_WARNRULE, "Warning\:  $warning$vlabel \\n");
//        }
//        if ($critical != "") {
//            $def[$num_graph] .= rrd::hrule($critical, $_CRITRULE, "Critical\: $critical$vlabel \\n");
//        }
    } elseif ($display_mode > 0) {
        $num_graph++;
        $label = rrd::cut($label, 20);
        $ds_name[$num_graph] = "Sysstats count - $label";
        $opt[$num_graph] = '--vertical-label "count" --title "Sysstats count - '.$label.'"  --rigid' . $upper . $lower;
        $opt[$num_graph] .= ' --watermark="Template for '.$for_check_command.' by Yannick Charton"';
        if(!isset($def[$num_graph])){$def[$num_graph] = "";}
        $def[$num_graph] .= rrd::def     ("var$KEY", $VAL['RRDFILE'], $VAL['DS'], "AVERAGE");
        $def[$num_graph] .= rrd::line1   ("var$KEY", $colors[$KEY], $label );
        $def[$num_graph] .= rrd::gprint  ("var$KEY", array("LAST","MAX","AVERAGE"), "%11.2lf");
//        if ($warning != "") {
//            $def[$num_graph] .= rrd::hrule($warning, $_WARNRULE, "Warning\:  $warning$vlabel \\n");
//        }
//        if ($critical != "") {
//            $def[$num_graph] .= rrd::hrule($critical, $_CRITRULE, "Critical\: $critical$vlabel \\n");
//        }
    }
}

?>

