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
rc.rccontrolpanel;
private shop.servicepack /cgi-bin;
',0);
echo $page->render(null,getlocal(),null,'cp_em.html');
?>