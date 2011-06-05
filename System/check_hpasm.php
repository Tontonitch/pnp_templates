<?php

///////////////////////////////
// Functions definition
///////////////////////////////
include_once('functions.php');

///////////////////////////////
// Variables definition
///////////////////////////////
# Define some colors ..
$_WARNRULE = '#FFFF00';
$_CRITRULE = '#FF0000';
$_MAXRULE = '#000000';
$_AREA = '#EACC00';
$_LINE = '#000000';
$temp_colors = array(0 => "#00FA9A","#008080","#1E90FF","#0000CD","#4B0082","#FF00FF","#EE82EE","#FF69B4","#800000","#FF6347","#8B4513","#FFA500","#808000");
$fan_colors = array(0 => "#008000","#00FF7F","#00FFFF","#4682B4","#191970","#8A2BE2","#C71585","#FF1493","#A52A2A","#D19275","#D2B48C","#F0E68C","#BDB76B","#FFD700","#00FF00","#3CB371");

///////////////////////////////
// Main part
///////////////////////////////
# Initial Logic ...
$temp_sources = array();
$fan_sources = array();
$unknown_sources = array();

foreach ($this->DS as $KEY=>$VAL) {
    if ( preg_match('/temp_/',$VAL['NAME']) == 1 ) {
        $temp_sources[] = $KEY + 1;
        }
    elseif ( preg_match('/fan_/',$VAL['NAME']) == 1 ) {
        $fan_sources[] = $KEY + 1;
        }
    else {
        $unknown_source[] = $KEY + 1;
    }
}

// Set graph index to 0
$graph_count = 0;
$source_count = 0;
foreach ($temp_sources as $i) {
    $source_count = $source_count + 1;
    if($source_count == 1) {
        // Passage au graphique suivant
        $graph_count = $graph_count + 1;
        // Definition du graphique
        $vlabel = "°c";
        $ds_name[$graph_count] = "Temperatures";
        $opt[$graph_count] = '--vertical-label "' . $vlabel . '" --title "Temperatures for ' . $hostname . ' elements" --lower-limit=0 --rigid';
        $opt[$graph_count] .= ' --watermark="Template: check_hpasm by Yannick Charton"';
        $def[$graph_count] = "";
    }
    // Then add ds info to the graph
    $label = rrd::cut($NAME[$i], 20);
    $def[$graph_count] .= "DEF:var" . $source_count . "=$RRDFILE[$i]:$DS[$i]:AVERAGE ";
    $def[$graph_count] .= "LINE1:var" . $source_count . $temp_colors[$source_count] . ":\"$label \" ";
    $def[$graph_count] .= "GPRINT:var" . $source_count . ":LAST:\"last\:%5.0lf$vlabel \" " ;
    $def[$graph_count] .= "GPRINT:var" . $source_count . ":AVERAGE:\"avg\:%5.0lf$vlabel \" " ;
    $def[$graph_count] .= "GPRINT:var" . $source_count . ":MAX:\"max\:%5.0lf$vlabel \\n\" " ;
}

$source_count = 0;
foreach ($fan_sources as $i) {
    $source_count = $source_count + 1;
    if($source_count == 1) {
        // Passage au graphique suivant
        $graph_count = $graph_count + 1;
        // Definition du graphique
        $vlabel = "%";
        $ds_name[$graph_count] = "Fans";
        $opt[$graph_count] = '--vertical-label "' . $vlabel . '" --title "Fans on ' . $hostname . '" --lower-limit=0 --upper=101 --rigid';
        $opt[$graph_count] .= ' --watermark="Template: check_hpasm by Yannick Charton"';
        $def[$graph_count] = "";
    }
    // Then add ds info to the graph
    $label = rrd::cut($NAME[$i], 20);
    $def[$graph_count] .= "DEF:var" . $source_count . "=$RRDFILE[$i]:$DS[$i]:AVERAGE ";
    $def[$graph_count] .= "LINE1:var" . $source_count . $fan_colors[$source_count] . ":\"$label \" ";
    $def[$graph_count] .= "GPRINT:var" . $source_count . ":LAST:\"last\:%5.0lf%% \" " ;
    $def[$graph_count] .= "GPRINT:var" . $source_count . ":AVERAGE:\"avg\:%5.0lf%% \" " ;
    $def[$graph_count] .= "GPRINT:var" . $source_count . ":MAX:\"max\:%5.0lf%% \\n\" " ;
}

?>

