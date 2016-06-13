<?php
require_once('dpc2/system/pcntlajax.lib.php'); 
$page = &new pcntlajax('

super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;

/---------------------------------load and create libs
use filesystem.downloadfile;
use jqgrid.jqgrid;

/---------------------------------load not create dpc (internal use)
include networlds.clientdpc;	

/---------------------------------load all and create after dpc objects
private frontpage.fronthtmlpage /cgi-bin;
#ifdef SES_LOGIN
public jqgrid.mygrid;
public crm.crmgantti;
public crm.crmacal;
public crm.reservations;
/public transport.transport;
public crm.rccrm;
public crm.rccrmplus;
private cp.rcpmenu /cgi-bin;
#endif
private cp.rccontrolpanel /cgi-bin;
',1);

$cptemplate = GetGlobal('controller')->calldpc_method('rcserver.paramload use FRONTHTMLPAGE+cptemplate');

	switch ($_GET['t']) {
		case 'cpcrmprun'      : $p = 'cp-crmplus-subdetail'; break; 
		case 'cpcrmpdetails'  : $p = 'cp-crmplus-subdetail'; break;
		case 'cpcrmgant'      : $p = 'cp-crmplus-detail'; break;
		case 'cpcrmpdashboard': $p = 'cp-crmplus-dashboard'; break;
		default               : $p = $_GET['iframe'] ? 'cp-crmplus-detail' : 'cp-crmplus';
	}
	
    $mc_page = (GetSessionParam('LOGIN')) ? $p : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>