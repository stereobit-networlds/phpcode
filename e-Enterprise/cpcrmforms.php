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
public crm.rccrmforms;
private cp.rcpmenu /cgi-bin;
#endif
private cp.rccontrolpanel /cgi-bin;
public i18n.i18nL;

',1);

$cptemplate = GetGlobal('controller')->calldpc_method('rcserver.paramload use FRONTHTMLPAGE+cptemplate');

	switch ($_GET['t']) {
		case 'cpcrmformsubdetail': 
								switch (GetReq('module')) {
									case 'formcode' : $p = 'cp-crmforms-code'; break;
									case 'formhtml' : $p = 'cp-crmforms-html'; break;
									default         : $p = 'cp-crmforms-detail';
								}	
								break;		
		case 'cpcrmformdata'  : $p = 'cp-crmforms-detail'; break;
		case 'cpcrmformdetail': 
								switch (GetReq('module')) {
									case 'formcode' : $p = 'cp-crmforms-code'; break;
									case 'formhtml' : $p = 'cp-crmforms-html'; break;
									default         : $p = 'cp-crmforms-detail';
								}	
								break;
		case 'cpcrmformshow'  : $p = 'cp-crmforms-edit'; break;
		case 'cpcrmfshow'     : $p = 'cp-crmforms-edit'; break;
		default               : $p = $_GET['iframe'] ? 'cp-crmforms-edit' : 'cp-crmforms';
	}
	
    $mc_page = (GetSessionParam('LOGIN')) ? $p : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>