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
use cp.cpflotcharts;

/---------------------------------load not create dpc (internal use)
include networlds.clientdpc;	

/---------------------------------load all and create after dpc objects
private frontpage.fronthtmlpage /cgi-bin;
#ifdef SES_LOGIN
public jqgrid.mygrid;
public cms.cmsrt;
public shop.rcshop;
private cp.rcpmenu /cgi-bin;
#endif
private cp.rccontrolpanel /cgi-bin;
public i18n.i18nL;

',1);

$cptemplate = GetGlobal('controller')->calldpc_method('rcserver.paramload use FRONTHTMLPAGE+cptemplate');

	switch ($_GET['t']) {
		case 'cpshopformsubdetail': 
								switch (GetReq('module')) {
									case 'istats'     :
									case 'irelatives' : $p = 'cp-shop-items'; break;
									case 'iqpolicy'   : $p = 'cp-shop-qpolicy'; break;
									case 'ipurchases' : $p = 'cp-shop-transactions'; break;
									case 'dashboard'  : $p = 'cp-shop-dashboard'; break;
									default           : $p = 'cp-shop-detail';
								}	
								break;		
		case 'cpshopformdata'  : $p = 'cp-shop-detail'; break;
		case 'cpshopformdetail': 
								switch (GetReq('module')) {
									case 'istats'     :									
									case 'irelatives' : $p = 'cp-shop-items'; break;
									case 'iqpolicy'   : $p = 'cp-shop-qpolicy'; break;
									case 'ipurchases' : $p = 'cp-shop-transactions'; break;
									case 'dashboard'  : $p = 'cp-shop-dashboard'; break;
									default           : $p = 'cp-shop-detail';
								}	
								break;
		case 'cpcmsformshow'  : $p = 'cp-shop-edit'; break;
		case 'cpcmsfshow'     : $p = 'cp-shop-edit'; break;
		default               : $p = $_GET['iframe'] ? 'cp-shop-edit' : 'cp-shop';
	}
	
    $mc_page = (GetSessionParam('LOGIN')) ? $p : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>