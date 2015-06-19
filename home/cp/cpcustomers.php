<?php
require_once('dpc/system/pcntl.lib.php'); 
$page = &new pcntl('
super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;

#---------------------------------load and create libs
use xwindow.window,xwindow.window2,gui.swfcharts;
use jqgrid.jqgrid;

#---------------------------------load not create dpc (internal use)
include networlds.clientdpc;
include frontpage.fronthtmlpage;
include gui.form;
include gui.datepick;
include mail.smtpmail;
	

#---------------------------------load all and create after dpc objects
jqgrid.mygrid;
gui.ajax;
database.dataforms;
mail.abcmail;
phpdac.rccustomers;
shop.rcitems;
shop.rctransactions;
',0);

$lan = getlocal();
echo $page->render(null,$lan,null,'cp_em.html');
?>
