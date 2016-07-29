<?php
//define ('SENDMAIL_PHPMAILER',null);
//define ('SMTP_PHPMAILER','true');

require_once('dpc2/system/pcntl.lib.php'); //2
$page = &new pcntl('
super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;

/---------------------------------load and create libs
/use xwindow.window,xwindow.window2,browser;
use gui.swfcharts;
use jqgrid.jqgrid;
use cp.cpflotcharts;

/---------------------------------load not create dpc (internal use)
include networlds.clientdpc;
include mail.smtpmail;

/---------------------------------load all and create after dpc objects
private frontpage.fronthtmlpage /cgi-bin;
#ifdef SES_LOGIN
public twig.twigengine;
public jqgrid.mygrid;
public gui.ajax;
public phpdac.rcfs;
public crm.crmforms;
private cp.rcpmenu /cgi-bin;
private cp.rccollections /cgi-bin;
private cp.rcbulkmail /cgi-bin;
#endif
private cp.rccontrolpanel /cgi-bin;

',1);

$cptemplate = GetGlobal('controller')->calldpc_method('rcserver.paramload use FRONTHTMLPAGE+cptemplate');

	$t = $_POST['FormAction'] ? $_POST['FormAction'] : $_GET['t'];
	switch ($t) {
		case 'cptemplatesav'   :
		case 'cptemplatenew'   : $p = $_GET['ajax'] ? 'cp-ajax-mvphoto' : 'cp-bulkmail-new'; break;
		case 'cppreviewcamp'   : $p = $_GET['ajax'] ? 'cp-ajax-mvphoto' : 'cp-bulkmail-preview'; break;
		case 'cpmailstats'     : $p = $_GET['ajax'] ? 'cp-ajax-mvphoto' : 'cp-mailstats'; break;
		case 'cpsubscribe'     :
		case 'cpunsubscribe'   :
		case 'cpadvsubscribe'  : $p = $_GET['ajax'] ? 'cp-ajax-mvphoto' : 'cp-advsubscribe'; break;
		case 'cpactivatequeuerec'  :
		case 'cpdeactivatequeuerec':		
		case 'cpviewclicks'    :
		case 'cpviewtrace'     :		
		case 'cpviewsubsqueue' : $p = $_GET['ajax'] ? 'cp-ajax-mvphoto' : 'cp-mailqueue'; break;
		case 'cpsavemailadv'   : $p = $_GET['ajax'] ? 'cp-ajax-mvphoto' : 'cp-bulkmail-post'; break;
		case 'cpdeletecamp'    :
		case 'cpviewcamp'      : $p = $_GET['ajax'] ? 'cp-ajax-mvphoto' : 'cp-bulkmail-post'; break;		
		
		case 'cpsubsend'       : //$submitmails = GetGlobal('controller')->calldpc_var('rcbulkmail.sendOk');
		                         //$p = $submitmails==true ? 'cp-mailstats' : 'cp-bulkmail-post'; break;		
								 $p = 'cp-bulkmail-post'; break; //anyway
								 
		default                : $p = 'cp-bulkmail-edit';
	}	
    $mc_page = (GetSessionParam('LOGIN')) ? $p : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');

?>