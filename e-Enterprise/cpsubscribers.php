<?php
//define ('SENDMAIL_PHPMAILER',null);
//define ('SMTP_PHPMAILER','true');

require_once('dpc2/system/pcntl.lib.php'); 
$page = &new pcntl('
super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;

/---------------------------------load and create libs
use xwindow.window,xwindow.window2,browser,gui.swfcharts;
use jqgrid.jqgrid;

/---------------------------------load not create dpc (internal use)
include networlds.clientdpc;
/include gui.datepick;
/include mail.smtpmail;
		

/---------------------------------load all and create after dpc objects
private frontpage.fronthtmlpage /cgi-bin;
#ifdef SES_LOGIN
public jqgrid.mygrid;
public gui.ajax;
public shop.rcshmail;
public shop.rckategories;
public shop.shtags;
public phpdac.rcfs;
public phpdac.rcupload;
private shop.rcitems /cgi-bin;
private phpdac.rctedit /cgi-bin;
private phpdac.rctedititems /cgi-bin;
private phpdac.rcshsubsqueue /cgi-bin;
private cp.rcpmenu /cgi-bin;
#endif
private cp.rccontrolpanel /cgi-bin;

',1);

$cptemplate = GetGlobal('controller')->calldpc_method('rcserver.paramload use FRONTHTMLPAGE+cptemplate');

	switch ($_GET['t']) {
		case 'cpadvsubscribe'  : $p = $_GET['ajax'] ? 'cp-ajax-mvphoto' : 'cp-jqgrid'; break;
		case 'cpviewsubsqueue' : $p = $_GET['ajax'] ? 'cp-ajax-mvphoto' : 'cp-jqgrid'; break;
		default                : $p = 'cp-mailwizard';
	}	
    $mc_page = (GetSessionParam('LOGIN')) ? $p : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>