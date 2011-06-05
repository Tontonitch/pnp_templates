<?php

function size_hum_read($size,$cur_unit)
{
 switch($cur_unit)
 {
  case 'B' : $i=0; break;
  case 'KB' : $i=1; break;
  case 'MB': $i=2; break;
  case 'GB': $i=3; break;
  default : $i=0;
 }
 $iec = array("B", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB");
 while (($size/1024)>1)
 {$size=$size/1024;
  $i++;
 }
 return substr($size,0,strpos($size,'.')+4).$iec[$i];
}

function stringTruncation($string, $limit, $break, $pad)
{
 // return with no change if string is shorter than $limit
 if(strlen($string) <= $limit) return $string;
 $string = substr($string, 0, $limit);
 if(false !== ($breakpoint = strrpos($string, $break)))
 { $string = substr($string, 0, $breakpoint);
 }
 return $string . $pad;
}

function stringTruncation2($string, $limit, $pad)
{
 // return with no change if string is shorter than $limit
 if(strlen($string) <= $limit)
 { return $string;
 }
 else 
 { $string = substr($string, 0, $limit - 3);
   return $string . $pad;
 }
}

function stringTruncation_io($string)
{
 $string = preg_replace("/_io.*$/","",$string);
 return $string;
}


?>
