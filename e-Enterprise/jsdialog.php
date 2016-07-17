<?php
require_once('dpc2/system/pcntl.lib.php'); 
$page = new pcntl('
super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 		
super database;

private frontpage.fronthtmlpage /cgi-bin;
public jsdialog.jsdialogStreamSrv;

',1);	 

//echo "&nbsp;"; //null
echo $page->render(null,getlocal(),null,'empty.html');
?>
