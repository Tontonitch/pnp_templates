<?php

#
# Pnp template for check_disk checkcommand (official nagios plugins).
# Includes the possibility to choose if and how datasources are gathered.
# Exemple: $gather_graphs=1 means all percent datasources are plotted on a unique graph, while
# all bytes datasources are plotted on separate graphs.
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
$colors     = array("#FFD700","#DAA520","#A0522D","#800080",
"#CC3300","#CC3333","#CC3366","#CC3399","#CC33CC","#CC33FF",
"#336600","#336633","#336666","#336699","#3366CC","#3366FF",
"#33CC33","#33CC66","#609978","#922A99","#997D6D","#174099",
"#1E9920","#E88854","#AFC5E8","#57FA44","#FA6FF6","#008080",
"#D77038","#272B26","#70E0D9","#0A19EB","#E5E29D","#930526",
"#26FF4A","#ABC2FF","#E2A3FF","#808000","#000000","#00FAFA",
"#E5FA79","#F8A6FF","#FF36CA","#B8FFE7","#CD36FF");

#
# Define some functions ..
#

function size_to_bytes($cur_unit,$size)
{
 $convert = array(
    "B"  => 1,
    "KB" => 1024,
    "MB" => bcpow('1024', '2'),
    "GB" => bcpow('1024', '3'),
    "TB" => bcpow('1024', '4'),
    "PB" => bcpow('1024', '5'),
    "EB" => bcpow('1024', '6'),
    "ZB" => bcpow('1024', '7'),
    "YB" => bcpow('1024', '8'),
    "K"  => 1024,
    "M"  => bcpow('1024', '2'),
    "G"  => bcpow('1024', '3'),
    "T"  => bcpow('1024', '4'),
    "P"  => bcpow('1024', '5'),
    "E"  => bcpow('1024', '6'),
    "Z"  => bcpow('1024', '7'),
    "Y"  => bcpow('1024', '8')
    );
 if(isset($convert["$cur_unit"])) {$size=$size*$convert["$cur_unit"];}
 return $size;
}

#
# Define some variables ..
#

## Parameters
$gather_graphs=1;   # 0: don't gather graphs
                    # 1: gather "percent" graphs
                    # 2: gather "percent" & "bytes" graphs
#Other variables
$num_graph=0;
$num_graph_percent=0;
$num_graph_bytes=0;
$for_check_command="check_disk (official nagios plugins)";

#
# Initial Logic ...
#

foreach($this->DS as $KEY => $VAL){
    $maximum_bytes  = "";
    $maximum_prct   = 100;
    $minimum_bytes  = "";
    $critical_bytes = "";
    $critical_prct  = "";
    $warning_bytes  = "";
    $warning_prct   = "";
    $vlabel         = "";

    if ($VAL['WARN'] != "")   {
        $warning_bytes = size_to_bytes($VAL['UNIT'],$VAL['WARN']);
        $warning_prct  = round($VAL['WARN'] / $VAL['MAX'] * 100);
    }
    if ($VAL['CRIT'] != "")   {
        $critical_bytes = size_to_bytes($VAL['UNIT'],$VAL['CRIT']);
        $critical_prct  = round($VAL['CRIT'] / $VAL['MAX'] * 100);
    }
    if ($VAL['MIN'] != "")    {$minimum_bytes = size_to_bytes($VAL['UNIT'],$VAL['MIN']);}
    if ($VAL['MAX'] != "")    {$maximum_bytes = size_to_bytes($VAL['UNIT'],$VAL['MAX']);}
    $vlabel = $VAL['UNIT'];

    # Define the labels
    $label   = $VAL['LABEL'];
    $label_c = preg_replace("/:/","\:",rrd::cut($label, 20));

    # Percentage graph
    $num_graph++;
    if($gather_graphs > 0){
        if($num_graph_percent == 0){$num_graph_percent = $num_graph;}
        $ds_name[$num_graph_percent] = "Disk space usages (%)";
        $opt[$num_graph_percent] = '--vertical-label "%" -X0 --title "Disk space usages (%)" --rigid --upper 101 --lower 0';
        $opt[$num_graph_percent] .= ' --watermark="Template for '.$for_check_command.' by Yannick Charton"';
        if(!isset($def[$num_graph_percent])){$def[$num_graph_percent] = "";}
        $def[$num_graph_percent] .= rrd::def     ("var$KEY", $VAL['RRDFILE'], $VAL['DS'], "AVERAGE");
        $def[$num_graph_percent] .= rrd::cdef    ("prctvar$KEY", "var$KEY,".$VAL['MAX'].",/,100,*");
        $def[$num_graph_percent] .= rrd::line1   ("prctvar$KEY", $colors[$KEY], $label_c );
        $def[$num_graph_percent] .= rrd::gprint  ("prctvar$KEY", array("LAST","MAX","AVERAGE"), "%5.2lf%%");
    }
    else{
        $ds_name[$num_graph] = "Disk space usages - $label (%)";
        $opt[$num_graph] = '--vertical-label "%" -X0 --title "Disk space usages -  '.$label.'"  --rigid --upper 101 --lower 0';
        $opt[$num_graph] .= ' --watermark="Template for '.$for_check_command.' by Yannick Charton"';
        if(!isset($def[$num_graph])){$def[$num_graph] = "";}
        $def[$num_graph] .= rrd::def     ("var$KEY", $VAL['RRDFILE'], $VAL['DS'], "AVERAGE");
        $def[$num_graph] .= rrd::cdef    ("prctvar$KEY", "var$KEY,".$VAL['MAX'].",/,100,*" );
        $def[$num_graph] .= rrd::area    ("prctvar$KEY", $_AREA_PRCT, $label_c );
        $def[$num_graph] .= rrd::line1   ("prctvar$KEY", $_LINE );
        $def[$num_graph] .= rrd::gprint  ("prctvar$KEY", array("LAST","MAX","AVERAGE"), "%5.2lf%%");
        if ($warning_prct != "") {
            $def[$num_graph] .= rrd::hrule($warning_prct, $_WARNRULE, "Warning\:  $warning_prct% \\n");
        }
        if ($critical_prct != "") {
            $def[$num_graph] .= rrd::hrule($critical_prct, $_CRITRULE, "Critical\: $critical_prct% \\n");
        }
    }
    
    # Bytes graphs
    $num_graph++;
    if($gather_graphs > 1){
        if($num_graph_bytes == 0){$num_graph_bytes = $num_graph;}
        $ds_name[$num_graph_bytes] = "Disk space usages (Bytes)";
        $opt[$num_graph_bytes] = '--vertical-label "Bytes" --title "Disk space usages (Bytes)" --lower=0';
        $opt[$num_graph_bytes] .= ' --watermark="Template for '.$for_check_command.' by Yannick Charton"';
        if(!isset($def[$num_graph_bytes])){$def[$num_graph_bytes] = "";}
        $def[$num_graph_bytes] .= rrd::def     ("var$KEY", $VAL['RRDFILE'], $VAL['DS'], "AVERAGE");
	$multiplicator = size_to_bytes($VAL['UNIT'],1);
        $def[$num_graph_bytes] .= rrd::cdef    ("bytesvar$KEY", "var$KEY,$multiplicator,*" );
        $def[$num_graph_bytes] .= rrd::line1   ("bytesvar$KEY", $colors[$KEY], $label_c );
        $def[$num_graph_bytes] .= rrd::gprint  ("bytesvar$KEY", array("LAST","MAX","AVERAGE"), "%8.2lf%SB");
    }
    else{
        $num_graph++;
        $ds_name[$num_graph] = "Disk space usages - $label (Bytes)";
        $opt[$num_graph] = '--vertical-label "Bytes" --title "Disk space usages - '.$label.'" --lower=0';
        $opt[$num_graph] .= ' --watermark="Template for '.$for_check_command.' by Yannick Charton"';
        if(!isset($def[$num_graph])){$def[$num_graph] = "";}
        $def[$num_graph] .= rrd::def     ("var$KEY", $VAL['RRDFILE'], $VAL['DS'], "AVERAGE");
        $multiplicator = size_to_bytes($VAL['UNIT'],1);
        $def[$num_graph] .= rrd::cdef    ("bytesvar$KEY", "var$KEY,$multiplicator,*" );
        $def[$num_graph] .= rrd::area    ("bytesvar$KEY", $_AREA_BYTE, $label_c );
        $def[$num_graph] .= rrd::line1   ("bytesvar$KEY", $_LINE );
        $def[$num_graph] .= rrd::gprint  ("bytesvar$KEY", array("LAST","MAX","AVERAGE"), "%8.2lf%SB");
        if ($warning_bytes != "") {
            $def[$num_graph] .= rrd::hrule($warning_bytes, $_WARNRULE, "Warning\:  ".$VAL['WARN']."${vlabel} \\n");
        }
        if ($critical_bytes != "") {
            $def[$num_graph] .= rrd::hrule($critical_bytes, $_CRITRULE, "Critical\: ".$VAL['CRIT']."${vlabel} \\n");
        }
        if ($maximum_bytes != "") {
            $def[$num_graph] .= rrd::hrule($maximum_bytes, $_MAXRULE, "Maximum\:  ".$VAL['MAX']."${vlabel} \\n");
        }
    }
}

?>

