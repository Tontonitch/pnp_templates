<?php

#
# Pnp template for CheckDriveSize (NSClient++) checkcommand. Tested for NSClient++ 0.3.6 & 0.3.8
# Includes the possibility to choose if and how datasources are gathered.
# Exemple: $gather_graphs=1 means all percent datasources are plotted on a unique graph, while
# all bytes datasources are plotted on separate graphs.
# By Yannick Charton (tontonitch-pro@yahoo.fr)
# Based on Joerg Linge templates
#

#
# Performance data sample
#
# '0_nb_active_connections'=0 '0_peak_active_connections'=6 '0_total_connections'=72 '0_total_connections_refus'=426 
# '1_nb_active_connections'=0 '1_peak_active_connections'=6 '1_total_connections'=79 '1_total_connections_refus'=430
#

#
# Define some colors ..
#

$_WARNRULE  = '#FFFF00';
$_CRITRULE  = '#FF0000';
$_MAXRULE   = '#000000';
$_LINE      = '#000000';

#
# Define some variables ..
#
$for_check_command="check_oracle_cman.pl";

#
# Initial Logic ...
#
    
foreach($this->DS as $KEY => $VAL){
    $maximum  = "";
    $minimum  = "";
    $critical = "";
    $warning  = "";

    if ($VAL['WARN'] != "")   {$warning = $VAL['WARN'];}
    if ($VAL['CRIT'] != "")   {$critical = $VAL['CRIT'];}
    if ($VAL['MIN'] != "")    {$minimum = $VAL['MIN'];}
    if ($VAL['MAX'] != "")    {$maximum = $VAL['MAX'];}

    # Define the labels
    list($gateway_id, $label) = preg_split("/_/", $VAL['NAME'], 2);
    $label_c = rrd::cut($label, 30);
    $current_graph_active = ($gateway_id*2)+1;
    $current_graph_total  = ($gateway_id*2)+2;
    
    # CMAN Connection Statistics
    if( preg_match('/active_/', $label) == 1 ) {
        if(!isset($ds_name[$current_graph_active])){
            $ds_name[$current_graph_active] = "CMAN - Active connection statistics";
            $opt[$current_graph_active] = '--vertical-label "connections" -X0 --title "Active connection statistics - gateway '.$gateway_id.'" --rigid --lower=0';
            $opt[$current_graph_active] .= ' --watermark="Template for '.$for_check_command.' by Yannick Charton"';
            $def[$current_graph_active] = "";
        }
        $def[$current_graph_active] .= rrd::def     ("var$KEY", $VAL['RRDFILE'], $VAL['DS'], "AVERAGE");
        if (preg_match('/nb_active_connections$/', $label)) {
            $def[$current_graph_active] .= rrd::area   ("var$KEY", '#8470FF', $label_c );
            $def[$current_graph_active] .= rrd::line1   ("var$KEY", '#696969');
            $def[$current_graph_active] .= rrd::gprint  ("var$KEY", array("LAST","MAX","AVERAGE"), "%8.1lf");
        }elseif (preg_match('/peak_active_connections$/', $label)) {
            $def[$current_graph_active] .= rrd::line1   ("var$KEY", '#191970', $label_c );
            $def[$current_graph_active] .= rrd::gprint  ("var$KEY", array("LAST"), "%8.1lf");
        }
    } elseif(preg_match('/total_/', $label) == 1 ) {
        if(!isset($ds_name[$current_graph_total])){
            $ds_name[$current_graph_total] = "CMAN - Total connection statistics";
            $opt[$current_graph_total] = '--vertical-label "connections/s" -X0 --alt-y-grid --title "Total connection statistics - gateway '.$gateway_id.'" --rigid --lower=0';
            $opt[$current_graph_total] .= ' --watermark="Template for '.$for_check_command.' by Yannick Charton"';
            $def[$current_graph_total] = "";
        }
        $def[$current_graph_total] .= rrd::def     ("var$KEY", $VAL['RRDFILE'], $VAL['DS'], "AVERAGE");
        if (preg_match('/total_connections$/', $label)) {
            $def[$current_graph_total] .= rrd::area    ("var$KEY", '#8FBC8F', $label_c );
            $def[$current_graph_total] .= rrd::gprint  ("var$KEY", array("LAST","MAX","AVERAGE"), "%5.3lf c/s");
        }elseif (preg_match('/total_connections_refus$/', $label)) {
            $def[$current_graph_total] .= rrd::area    ("var$KEY", '#DC143C', $label_c, 'STACK' );
            $def[$current_graph_total] .= rrd::gprint  ("var$KEY", array("LAST","MAX","AVERAGE"), "%5.3lf c/s");
        }
    }
}

?>

