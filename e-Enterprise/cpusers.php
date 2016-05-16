<?php
require_once('dpc2/system/pcntl.lib.php'); 
$page = &new pcntl('
super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;

/---------------------------------load and create libs
use gui.swfcharts;
use jqgrid.jqgrid;

/---------------------------------load not create dpc (internal use)
include networlds.clientdpc;
include gui.form;
/include gui.datepick;
include mail.smtpmail;

security ACCOUNTMNG_ 1 1:1:1:1:1:1:1:1;
security USERMNG_ 1 1:1:1:1:1:1:1:1;
security USERSMNG_ 1 1:1:1:1:1:1:1:1;
security SIGNUP_ 1 1:1:1:1:1:1:1:1;
security DELETEUSR_ 1 1:1:1:1:1:1:1:1;
security UPDATEUSR_ 1 1:1:1:1:1:1:1:1;
			
/---------------------------------load all and create after dpc objects
private frontpage.fronthtmlpage /cgi-bin;
#ifdef SES_LOGIN
public jqgrid.mygrid;
public shop.shsubscribe;
private shop.rcitems /cgi-bin;
private shop.rcusers /cgi-bin;
private shop.rccustomers /cgi-bin;
private shop.rctransactions /cgi-bin;
#endif
private cp.rcpmenu /cgi-bin;
private cp.rccontrolpanel /cgi-bin;
',1);

$cptemplate = GetGlobal('controller')->calldpc_method('rcserver.paramload use FRONTHTMLPAGE+cptemplate');

    $mc_page = (GetSessionParam('LOGIN')) ? 'cp-users' : 'cp-login'; //del grid line issue
	//$mc_page = (GetSessionParam('LOGIN')) ? 'cp-tags' : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>