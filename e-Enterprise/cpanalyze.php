<?php
require_once('dpc/system/pcntl.lib.php'); 
$page = new pcntl('
super javascript;
/super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;

use mail.bounce_driver;
use jqgrid.jqgrid;

/---------------------------------load not create dpc (internal use)
include networlds.clientdpc;

public jqgrid.mygrid;
public cms.cmsrt;
#ifdef SES_LOGIN
public cp.rcanalyzer;
public cp.rcpmenu;
#endif
public cp.rccontrolpanel;

',1);	 

$cptemplate = _m('rcserver.paramload use FRONTHTMLPAGE+cptemplate');

$mc_page = (GetSessionParam('LOGIN')) ? 'cp-tags' : 'cp-login';
echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>
