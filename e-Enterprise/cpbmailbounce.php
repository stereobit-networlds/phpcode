<?php
require_once('dpc/system/pcntl.lib.php'); 
$page = new pcntl('

super javascript;
/super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;

/---------------------------------load and create libs
use mail.bounce_driver;

/---------------------------------load not create dpc (internal use)
include networlds.clientdpc;

/---------------------------------load all and create after dpc objects
public cms.cmsrt;
#ifdef SES_LOGIN
public bmail.rcbmailbounce;
public cp.rcpmenu;
#endif
public cp.rccontrolpanel;
',1);

$cptemplate = _m('rcserver.paramload use FRONTHTMLPAGE+cptemplate');

$mc_page = (GetSessionParam('LOGIN')) ? 'cp-bmailbounce' : 'cp-login';
echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>