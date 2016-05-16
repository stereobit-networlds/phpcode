<?php
require_once('dpc2/system/pcntl.lib.php'); 
$page = &new pcntl('

super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;

/---------------------------------load and create libs
use gui.swfcharts;
use mail.bounce_driver;

/---------------------------------load not create dpc (internal use)
include networlds.clientdpc;
/include gui.form;

/---------------------------------load all and create after dpc objects
private frontpage.fronthtmlpage /cgi-bin;
#ifdef SES_LOGIN
private cp.rcbmailbounce /cgi-bin;
private cp.rcpmenu /cgi-bin;
#endif
private cp.rccontrolpanel /cgi-bin;
',1);

$cptemplate = GetGlobal('controller')->calldpc_method('rcserver.paramload use FRONTHTMLPAGE+cptemplate');

$mc_page = (GetSessionParam('LOGIN')) ? 'cp-bmailbounce' : 'cp-login';
echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>