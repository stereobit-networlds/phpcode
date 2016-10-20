<?php
require_once('dpc2/system/pcntl.lib.php'); 
$page = &new pcntl('
super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;

/---------------------------------load and create libs
use i18n.i18n;
use jqgrid.jqgrid;

/---------------------------------load not create dpc (internal use)
include networlds.clientdpc;
		
/---------------------------------load all and create after dpc objects
private frontpage.fronthtmlpage /cgi-bin;
#ifdef SES_LOGIN
public jqgrid.mygrid;
public cms.cmsrt;
public bmail.rcsubscribers /cgi-bin;
private cp.rcpmenu /cgi-bin;
#endif
private cp.rccontrolpanel /cgi-bin;
public i18n.i18nL;

',1);

$cptemplate = GetGlobal('controller')->calldpc_method('rcserver.paramload use FRONTHTMLPAGE+cptemplate');

	switch ($_GET['t']) {
		case 'cpsubsframe'     : $p = 'cp-iframe-jqgrid'; break;
		case 'cpsubscribers'   : 
		default                : $p = 'cp-subscribers'; 
	}	
    $mc_page = (GetSessionParam('LOGIN')) ? $p : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>