<?php

function paramload($section,$param) {
  global $config;

  if (is_array($config[$section]))     
	return ($config[$section][$param]);

}

function arrayload($section,$array) {
  global $config;
  
  if (is_array($config[$section])) {
    $data = $config[$section][$array];
	
	if ($data) return(explode(",",$data));
	//return ($out);
  }  
}

 function readini($inifile) {
     $inivals = array();
	 
	 if (file_exists($inifile)) {
     $ini_file = file ($inifile);
	 
	 if (is_array($ini_file)) {
        //while (list ($line_num, $line) = each ($ini_file)) {
	    foreach ($ini_file as $line_num => $line) {
		   $split = explode ("=", $line);
           $inivals[$split[0]] = rtrim($split[1]);   
        }	 
	 }
	 return ($inivals);
	 }
 }
 
 function setsyspath($path,$type='UNIX') {
  
   switch ($type) {
    case 'WINDOWS':
    case 'MSDOS': $outpath = ereg_replace("/","\\",$path); break;	
	default     :
	case 'LINUX':
    case 'UNIX' : $outpath = ereg_replace("[\x5c\]","/",$path); break;	
   }

   if ($outpath) return ($outpath); 
            else return ($path);
 } 

?>