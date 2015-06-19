<?php
require_once('dpc/system/pcntlajax.lib.php'); 
$page = &new pcntlajax('
super cache,log;
super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;

#---------------------------------load and create libs
use xwindow.window,xwindow.window2,browser,gui.swfcharts;
use jqgrid.jqgrid;

#---------------------------------load not create dpc (internal use)
networlds.clientdpc;
#include frontpage.fronthtmlpage;
include gui.form;

#---------------------------------load all and create after dpc objects
private frontpage.fronthtmlpage /cgi-bin;
jqgrid.mygrid;
gui.ajax;
database.dataforms;
phpdac.rccontrolpanel;
gui.ajax;
private shop.rckategories /cgi-bin;

',0);
$lan = getlocal();

echo $page->render(null,$lan,null,'cp_em.html');
?>