<?php
require_once('dpc/system/pcntl.lib.php'); 
$page = &new pcntl('
super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;

#---------------------------------load and create libs
use xwindow.window,xwindow.window2,browser;
use gui.swfcharts;
#use jqgrid.jqgrid;...output started error

#---------------------------------load not create dpc (internal use)
include networlds.clientdpc;
include gui.form;

#---------------------------------load not create extensions (internal use)		
#load_extension http_class refby _HTTPCL_; 

#---------------------------------load all and create after dpc objects
frontpage.fronthtmlpage;
#jqgrid.mygrid;
gui.ajax;
mail.smtpmail;
shop.rckategories;
shop.rcitems;
shop.rcmaildbqueue;
shop.rctransactions;
shop.shusers;
shop.shcustomers;
phpdac.rcimportdb;
phpdac.rcupload;
phpdac.rcconfig;
private phpdac.rccontrolpanel /cgi-bin;
',0);
$lan = getlocal();
echo $page->render(null,$lan,null,'cp_em.html');
?>