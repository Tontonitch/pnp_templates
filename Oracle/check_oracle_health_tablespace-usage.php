<?php

#
# Pnp template for check_oracle_health tablespace-usage checkcommand.
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
$gather_graphs=1;   # 0: don't gather graphs
                    # 1: gather "percent" graphs
                    # 2: gather "percent" & "bytes" graphs
#Other variables
$num_graph=0;
$num_graph_percent=0;
$num_graph_bytes=0;
$for_check_command="check_oracle_health tablespace-usage";

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
    if($VAL['UNIT'] == '%%'){
        $num_graph++;
        $label = substr($VAL['LABEL'], 4,-10);
        $label = rrd::cut($label, 20);
        if($gather_graphs > 0){
            if($num_graph_percent == 0){$num_graph_percent = $num_graph;}
            $ds_name[$num_graph_percent] = "Tablespace usages (%)";
            $opt[$num_graph_percent] = '--vertical-label "%" -X0 --title "Tablespace usages (%)" --rigid' . $upper . $lower;
            $opt[$num_graph_percent] .= ' --watermark="Template for '.$for_check_command.' by Yannick Charton"';
            if(!isset($def[$num_graph_percent])){$def[$num_graph_percent] = "";}
            $def[$num_graph_percent] .= rrd::def     ("var$KEY", $VAL['RRDFILE'], $VAL['DS'], "AVERAGE");
            $def[$num_graph_percent] .= rrd::line1   ("var$KEY", $colors[$KEY], $label );
            $def[$num_graph_percent] .= rrd::gprint  ("var$KEY", array("LAST","MAX","AVERAGE"), "%5.2lf%%");
        }
        else{
            $ds_name[$num_graph] = "Tablespace usages - $label";
            $opt[$num_graph] = '--vertical-label "%" -X0 --title "Tablespace usages -  '.$label.'"  --rigid' . $upper . $lower;
            $opt[$num_graph] .= ' --watermark="Template for '.$for_check_command.' by Yannick Charton"';
            if(!isset($def[$num_graph])){$def[$num_graph] = "";}
            $def[$num_graph] .= rrd::def     ("var$KEY", $VAL['RRDFILE'], $VAL['DS'], "AVERAGE");
            $def[$num_graph] .= rrd::area    ("var$KEY", $_AREA_PRCT, $label );
            $def[$num_graph] .= rrd::line1   ("var$KEY", $_LINE );
            $def[$num_graph] .= rrd::gprint  ("var$KEY", array("LAST","MAX","AVERAGE"), "%5.2lf%%");
            if ($warning != "") {
                $def[$num_graph] .= rrd::hrule($warning, $_WARNRULE, "Warning\:  $warning$vlabel \\n");
            }
            if ($critical != "") {
                $def[$num_graph] .= rrd::hrule($critical, $_CRITRULE, "Critical\: $critical$vlabel \\n");
            }
        }
    }
    #MB graphs
    elseif((preg_match('/^.*B$/',$vlabel)) && (preg_match('/^tbs_.*_usage$/',$VAL['LABEL']))){
        $num_graph++;
        $label = substr($VAL['LABEL'], 4,-6);
        $label = rrd::cut($label, 20);
        if($gather_graphs > 1){
            if($num_graph_bytes == 0){$num_graph_bytes = $num_graph;}
            $ds_name[$num_graph_bytes] = "Tablespace usages (Bytes)";
            $opt[$num_graph_bytes] = '--vertical-label "MB" --title "Tablespace usages (MB)" --lower=0';
            $opt[$num_graph_bytes] .= ' --watermark="Template for '.$for_check_command.' by Yannick Charton"';
            if(!isset($def[$num_graph_bytes])){$def[$num_graph_bytes] = "";}
            $def[$num_graph_bytes] .= rrd::def     ("var$KEY", $VAL['RRDFILE'], $VAL['DS'], "AVERAGE");
            $def[$num_graph_bytes] .= rrd::line1   ("var$KEY", $colors[$KEY], $label );
            $def[$num_graph_bytes] .= rrd::gprint  ("var$KEY", array("LAST","MAX","AVERAGE"), "%8.2lf$vlabel");
        }
        else{
            $num_graph++;
            $ds_name[$num_graph] = "Tablespace usages - $label";
            $opt[$num_graph] = '--vertical-label "MB" --title "Tablespace usages - '.$label.'" --lower=0';
            $opt[$num_graph] .= ' --watermark="Template for '.$for_check_command.' by Yannick Charton"';
            if(!isset($def[$num_graph])){$def[$num_graph] = "";}
            $def[$num_graph] .= rrd::def     ("var2$KEY", $VAL['RRDFILE'], $VAL['DS'], "MAX");
            $def[$num_graph] .= rrd::area    ("var2$KEY", '#C3FDB8');
            $def[$num_graph] .= rrd::def     ("var$KEY", $VAL['RRDFILE'], $VAL['DS'], "AVERAGE");
            $def[$num_graph] .= rrd::area    ("var$KEY", $_AREA_BYTE, $label );
            $def[$num_graph] .= rrd::line1   ("var$KEY", $_LINE );
            $def[$num_graph] .= rrd::gprint  ("var$KEY", array("LAST","MAX","AVERAGE"), "%8.2lf$vlabel");
            if ($warning != "") {
                $def[$num_graph] .= rrd::hrule($warning, $_WARNRULE, "Warning\:  $warning${vlabel} \\n");
            }
            if ($critical != "") {
                $def[$num_graph] .= rrd::hrule($critical, $_CRITRULE, "Critical\: $critical${vlabel} \\n");
            }
            if ($maximum != "") {
                $def[$num_graph] .= rrd::hrule($critical, $_MAXRULE, "Maximum\:  $maximum${vlabel} \\n");
            }
        }
    }
}

?>

