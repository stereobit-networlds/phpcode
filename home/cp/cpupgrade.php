<?php
require_once('dpc/system/pcntl.lib.php'); 
$page = &new pcntl('

super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;

#---------------------------------load and create libs
use xwindow.window,xwindow.window2,browser;
use filesystem.downloadfile;

#---------------------------------load not create dpc (internal use)
include networlds.clientdpc;
#include gui.form;
			

#---------------------------------load all and create after dpc objects
frontpage.fronthtmlpage;
phpdac.shlogin;
phpdac.rcconfig;
phpdac.rcuwizard;


',0);
$lan = getlocal();
echo $page->render(null,$lan,null,"cpwizard$lan.html");//'cp_em.html');
?>