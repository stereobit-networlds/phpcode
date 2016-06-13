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
public backup.rcfscanner;
private cp.rcpmenu /cgi-bin;
#endif
private cp.rccontrolpanel /cgi-bin;
',1);

$cptemplate = GetGlobal('controller')->calldpc_method('rcserver.paramload use FRONTHTMLPAGE+cptemplate');

	switch ($_GET['t']) {
		case 'cpmakeaccfile' : $p = $_GET['iframe'] ? 'cp-fscanner-detail' : 'cp-fscanner'; break;
		case 'cpsreport'     : $p = 'cp-fscanner-detail'; break;
		case 'cpscanrep'     : $p = $_GET['iframe'] ? 'cp-fscanner-detail' : 'cp-fscanner'; break;
		default              : $p = $_GET['iframe'] ? 'cp-fscanner-detail' : 'cp-fscanner';
	}
	
    $mc_page = (GetSessionParam('LOGIN')) ? $p : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>