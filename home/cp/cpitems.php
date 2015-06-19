<?php
require_once('dpc/system/pcntlajax.lib.php'); 
$page = &new pcntlajax('
super cache,log;
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
phpdac.rccontrolpanel;
phpdac.rcupload;
#mail.abcmail;
#shop.rcshmail;
#shop.rcshsubscribers;
#shop.rckategories;
private shop.rcitems /cgi-bin;
#phpdac.rccustomers;
#rc.rcreport;
#rcserver.rcsidewin;
shop.rcvstats;
shop.rctransactions;
',0);

$lan = getlocal();

echo $page->render(null,$lan,null,'cp_em.html');
?>

