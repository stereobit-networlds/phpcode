<?php
require_once('dpc/system/pcntl.lib.php'); 
$page = &new pcntl('
super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_;
super database;

#---------------------------------load and create libs
use xwindow.window,xwindow.window2,browser;

#---------------------------------load not create dpc (internal use)
include networlds.clientdpc;
include frontpage.fronthtmlpage;
include gui.form;
	
#---------------------------------load all and create after dpc objects
phpdac.rccontrolpanel;
#shop.shkategories;
#shop.shkatalogmedia;
shop.rckategories;
shop.rcitems;
phpdac.rcupload;

',0);
$lan = getlocal();

if (GetReq('editmode')==1)
  echo $page->render(null,$lan,null,'cp_em.html');
else
  echo $page->render(null,$lan,null,'cpgroup.html');
?>