<?php
require_once('dpc2/system/pcntlajax.lib.php'); 
$page = &new pcntlajax('

super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;

/---------------------------------load and create libs
use i18n.i18n;
use filesystem.downloadfile;
use jqgrid.jqgrid;

/---------------------------------load not create dpc (internal use)
include networlds.clientdpc;	

/---------------------------------load all and create after dpc objects
private frontpage.fronthtmlpage /cgi-bin;
#ifdef SES_LOGIN
public jqgrid.mygrid;
public cms.cmsrt;
public cms.rccmstemplates;
private cp.rcpmenu /cgi-bin;
#endif
private cp.rccontrolpanel /cgi-bin;
public i18n.i18nL;

',1);

$cptemplate = GetGlobal('controller')->calldpc_method('rcserver.paramload use FRONTHTMLPAGE+cptemplate');

	switch ($_GET['t']) {
		case 'cpcmsformsubdetail': 
								switch (GetReq('module')) {
									case 'formitems'  : $p = 'cp-cmstemplates-items'; break;
									case 'formscript' : $p = 'cp-cmstemplates-script'; break;
									case 'formcode' : $p = 'cp-cmstemplates-code'; break;
									case 'formhtml' : $p = 'cp-cmstemplates-html'; break;
									default         : $p = 'cp-cmstemplates-detail';
								}	
								break;		
		case 'cpcmsformdata'  : $p = 'cp-cmstemplates-detail'; break;
		case 'cpcmsformdetail': 
								switch (GetReq('module')) {
									case 'formitems'  : $p = 'cp-cmstemplates-items'; break;
									case 'formscript' : $p = 'cp-cmstemplates-script'; break;
									case 'formcode' : $p = 'cp-cmstemplates-code'; break;
									case 'formhtml' : $p = 'cp-cmstemplates-html'; break;
									default         : $p = 'cp-cmstemplates-detail';
								}	
								break;
		case 'cpcmsformshow'  : $p = 'cp-cmstemplates-edit'; break;
		case 'cpcmsfshow'     : $p = 'cp-cmstemplates-edit'; break;
		default               : $p = $_GET['iframe'] ? 'cp-cmstemplates-edit' : 'cp-cmstemplates';
	}
	
    $mc_page = (GetSessionParam('LOGIN')) ? $p : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>