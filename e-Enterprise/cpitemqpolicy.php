<?php
require_once('dpc2/system/pcntlajax.lib.php'); 
$page = &new pcntlajax('

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
public jqgrid.mygrid;
public cms.cmsrt;
#ifdef SES_LOGIN
public bshop.rcitemqpolicy;
public cp.rcpmenu;
#endif
public cp.rccontrolpanel;
public i18n.i18nL;

',1);

$cptemplate = _m('rcserver.paramload use FRONTHTMLPAGE+cptemplate');

	switch ($_GET['t']) {
		case 'cpitemqform'    : $p = 'cp-itemqpolicy-edit'; break;
		case 'cpitemqdel'     : $p = 'cp-itemqpolicy-edit'; break;
		case 'cpitemqfetch'   : $p = 'cp-itemqpolicy-edit'; break;
		default               : $p = $_GET['iframe'] ? 'cp-itemqpolicy-edit' : 'cp-itemqpolicy';
	}
	
    $mc_page = (GetSessionParam('LOGIN')) ? $p : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>