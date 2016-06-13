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
public crm.crmforms;
public crm.crmplus;
public crm.crmtransactions;
public crm.crmtasks;
public crm.crminbox;
public crm.crmstats;
public crm.crmcustomer;
public crm.crmdashboard;
public crm.rccrm;
private cp.rcpmenu /cgi-bin;
#endif
private cp.rccontrolpanel /cgi-bin;
',1);

$cptemplate = GetGlobal('controller')->calldpc_method('rcserver.paramload use FRONTHTMLPAGE+cptemplate');

	switch ($_GET['t']) {
		case 'cpcrmrun'       : $p = 'cp-crm-subdetail'; break; 
		case 'cpcrmdetails'   : $p = 'cp-crm-subdetail'; break;
		case 'cpcrmshowcus'   : $p = 'cp-crm-detail'; break;
		case 'cpcrmshowusr'   : $p = 'cp-crm-detail'; break;
		case 'cpcrmdashboard' : $p = 'cp-crm-dashboard'; break;
		default               : $p = $_GET['iframe'] ? 'cp-crm-detail' : 'cp-crm';
	}
	
    $mc_page = (GetSessionParam('LOGIN')) ? $p : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>