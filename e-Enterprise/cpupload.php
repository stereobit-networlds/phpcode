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

/---------------------------------load not create dpc (internal use)
include networlds.clientdpc;
	
/---------------------------------load all and create after dpc objects
public jqgrid.mygrid;
public cms.cmsrt;
#ifdef SES_LOGIN
public bshop.rckategories;
public bshop.rcitems;
public cms.rcupload;
public cp.rcpmenu;
#endif
public cp.rccontrolpanel;
public i18n.i18nL;

',1);

$cptemplate = _m('rcserver.paramload use FRONTHTMLPAGE+cptemplate');

    $mc_page = (GetSessionParam('LOGIN')) ? 'cp-upload' : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>