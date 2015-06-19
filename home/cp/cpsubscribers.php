<?php
//define ('SENDMAIL_PHPMAILER',null);
//define ('SMTP_PHPMAILER','true');

require_once('dpc/system/pcntl.lib.php'); 
$page = &new pcntl('
super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;

#---------------------------------load and create libs
use xwindow.window,xwindow.window2,browser;
use jqgrid.jqgrid;

#---------------------------------load not create dpc (internal use)
include networlds.clientdpc;
include frontpage.fronthtmlpage;
include gui.tinyMCE;
include gui.datepick;
include mail.smtpmail;
		

#---------------------------------load all and create after dpc objects
jqgrid.mygrid;
gui.ajax;
phpdac.rccontrolpanel;
shop.rcshmail;
shop.rckategories;
shop.rcitems;
shop.shtags;
phpdac.rcfs;
phpdac.rcupload;
private phpdac.rctedit /cgi-bin;
private phpdac.rctedititems /cgi-bin;
private phpdac.rcshsubsqueue /cgi-bin;
',0);
echo $page->render(null,$lan,null,'cp_em.html');
?>