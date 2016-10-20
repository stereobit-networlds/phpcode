<?php
require_once('dpc2/system/pcntl.lib.php'); 
$page = &new pcntl('
super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;

/---------------------------------load and create libs
use i18n.i18n;
use gui.swfcharts;
use jqgrid.jqgrid;

/---------------------------------load not create dpc (internal use)
include networlds.clientdpc;

/---------------------------------load all and create after dpc objects
private frontpage.fronthtmlpage /cgi-bin;
#ifdef SES_LOGIN
public jqgrid.mygrid;
public gui.ajax;
private shop.rccustomers /cgi-bin;
public shop.rcitems;
private shop.rctransactions /cgi-bin;
private cp.rcpmenu /cgi-bin;
#endif
private cp.rccontrolpanel /cgi-bin;
public i18n.i18nL;

',1);

$cptemplate = GetGlobal('controller')->calldpc_method('rcserver.paramload use FRONTHTMLPAGE+cptemplate');


    $mc_page = (GetSessionParam('LOGIN')) ? 'cp-customers' : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>