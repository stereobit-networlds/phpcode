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
include gui.htmlarea;
			

#---------------------------------load all and create after dpc objects
phpdac.rccontrolpanel;
phpdac.rcconfig;


',0);

$lan = getlocal();

echo $page->render(null,$lan,null,'cpgroup_em.html');
?>