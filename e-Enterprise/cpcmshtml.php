<?php
require_once('dpc/system/pcntl.lib.php'); 
$page = new pcntl('

super javascript;
/super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;

/---------------------------------load and create libs
use i18n.i18n;
use jqgrid.jqgrid;

/---------------------------------load not create dpc (internal use)
include networlds.clientdpc;	

/---------------------------------load all and create after dpc objects
public jqgrid.mygrid;
public cms.cmsrt;
#ifdef SES_LOGIN
public cms.rccmshtml;
public cp.rcpmenu;
#endif
public cp.rccontrolpanel;
public i18n.i18nL;

',1);

$cptemplate = _m('cmsrt.paramload use FRONTHTMLPAGE+cptemplate');

	switch ($_GET['t']) {
		case 'cpcmssave'      : 
		case 'cpcmsformshow'  : $p = 'cp-cmshtml-edit'; break;
		case 'cpcmsfshow'     : $p = 'cp-cmshtml-edit'; break;
		
		case 'cpcmshtml'      :
		default               : $p = 'cp-cmshtml';
	}
	
    $mc_page = (GetSessionParam('LOGIN')) ? $p : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>