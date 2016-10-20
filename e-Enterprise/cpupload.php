<?php
require_once('dpc2/system/pcntl.lib.php'); 
$page = &new pcntl('
super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_;
super database;

/---------------------------------load and create libs
use i18n.i18n;
use xwindow.window;
use gui.swfcharts;

/---------------------------------load not create dpc (internal use)
include networlds.clientdpc;
include gui.form;
	
/---------------------------------load all and create after dpc objects
private frontpage.fronthtmlpage /cgi-bin;
#ifdef SES_LOGIN
private shop.rckategories /cgi-bin;
private shop.rcitems /cgi-bin;
private phpdac.rcupload /cgi-bin;
private cp.rcpmenu /cgi-bin;
#endif
private cp.rccontrolpanel /cgi-bin;
public i18n.i18nL;

',1);

$cptemplate = GetGlobal('controller')->calldpc_method('rcserver.paramload use FRONTHTMLPAGE+cptemplate');

    $mc_page = (GetSessionParam('LOGIN')) ? 'cp-upload' : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>