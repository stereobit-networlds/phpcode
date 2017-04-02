<?php
require_once('cp/dpc/system/pcntl.lib.php'); 
$page = new pcntl('
super javascript;
/super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 		
super database;

public cms.cmsrt;
public jsdialog.jsdialogStream;
',1);	 

if (GetReq('t')=='jsdcode') {
	$d =  date('Y-m-d H:i:s');
	$respond = _m("jsdialogStream.say use $d+++2000");
	die($respond);
}
//else
echo $page->render(null,getlocal(),null,'empty.html');
?>
