<?php
require_once('dpc2/system/pcntlajax.lib.php'); 
$page = &new pcntlajax('

super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;

/---------------------------------load and create libs
/use gui.swfcharts;
use jqgrid.jqgrid;

/---------------------------------load not create dpc (internal use)
include networlds.clientdpc;	

/---------------------------------load all and create after dpc objects
private frontpage.fronthtmlpage /cgi-bin;
#ifdef SES_LOGIN
public jqgrid.mygrid;
private shop.rcitemrel /cgi-bin;
private cp.rcpmenu /cgi-bin;
#endif
private cp.rccontrolpanel /cgi-bin;
',1);

$cptemplate = GetGlobal('controller')->calldpc_method('rcserver.paramload use FRONTHTMLPAGE+cptemplate');

	switch ($_GET['t']) {
		case 'cpirelmod'     : $p = $_GET['iframe'] ? 'cp-itemrel-detail' : 'cp-itemrel'; break;
		case 'cpireljoinitem': $p = $_GET['iframe'] ? 'cp-itemrel-detail' : 'cp-itemrel'; break;
		case 'cpireljoincat' : $p = $_GET['iframe'] ? 'cp-itemrel-detail' : 'cp-itemrel'; break;
		case 'cpitemrel'     : $p = $_GET['iframe'] ? 'cp-itemrel-detail' : 'cp-itemrel'; break;
		default              : $p = $_GET['iframe'] ? 'cp-itemrel-detail' : 'cp-itemrel';
	}
	
    $mc_page = (GetSessionParam('LOGIN')) ? $p : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>