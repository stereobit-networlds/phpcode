<?php
require_once('dpc2/system/pcntl.lib.php'); 
$page = &new pcntl('
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
private frontpage.fronthtmlpage /cgi-bin;
#ifdef SES_LOGIN
public jqgrid.mygrid;
public cms.cmsrt;
public bmail.rculists;
private cp.rcpmenu /cgi-bin;
#endif
private cp.rccontrolpanel /cgi-bin;
public i18n.i18nL;

',1);

$cptemplate = GetGlobal('controller')->calldpc_method('rcserver.paramload use FRONTHTMLPAGE+cptemplate');
   
    $t = $_POST['FormAction'] ? $_POST['FormAction'] : $_GET['t'];
	switch ($t) {
		
		case 'cpsubscribe'    	   :
		case 'cpunsubscribe'   	   :
		case 'cpadvsubscribe' 	   : $p = 'cp-bmail-ulists-subscribe'; break;		
		
		case 'cpactivatequeuerec'  :
		case 'cpdeactivatequeuerec': $p = 'cp-bmail-ulists-queue';  break;
		case 'cpulframe' 		   : $p = 'cp-iframe-jqgrid'; break;
		case 'cpviewtrace'         : $p = 'cp-iframe-jqgrid'; break;		
		case 'cpviewclicks'        :		
		case 'cpviewsubsqueue'     : 	
		case 'cpulists'   		   : 
		default           		   : $p = 'cp-bmail-ulists-queue'; 
	}	
    $mc_page = (GetSessionParam('LOGIN')) ? $p : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>