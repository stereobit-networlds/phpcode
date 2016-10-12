<?php
require_once('dpc2/system/pcntl.lib.php'); 
$page = &new pcntl('
super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;

use i18n.i18n;
use xwindow.window,xwindow.window2;
use gui.swfcharts;

include networlds.clientdpc;

private frontpage.fronthtmlpage /cgi-bin;
#ifdef SES_LOGIN
private shop.rckategories /cgi-bin;
private shop.rcitems /cgi-bin;
private shop.rctags /cgi-bin;
private cp.cpmhtmleditor /cgi-bin;
private cp.rcpmenu /cgi-bin;
#endif
private cp.rccontrolpanel /cgi-bin;
public i18n.i18nL;

',1);
	
$cptemplate = GetGlobal('controller')->calldpc_method('rcserver.paramload use FRONTHTMLPAGE+cptemplate');
$postok = defined('CPMHTMLEDITOR_DPC') ? GetGlobal('controller')->calldpc_var('cpmhtmleditor.postok') : false;

	switch ($_GET['t']) {
		case 'cpmnewitem'    : $p = $_POST['insert'] && $postok ? 'cp-uploadimage' : 'cp-htmleditor-newitem'; break;
		case 'cpmedititem'   : $p = 'cp-htmleditor-edititem'; break;
		case 'cpmvphotoadddb':
		case 'cpmvphotodeldb':
		case 'cpmvphoto'     : $p = $_GET['ajax'] ? 'cp-ajax-mvphoto' : 'cp-mvphoto'; break;
		case 'cpmvdel'       : $p = $_GET['ajax'] ? 'cp-ajax-mvphoto' : 'cp-mvphoto'; break;
		
		case 'cpmhtmleditor' :		
		default              : $p = GetParam('ajax') ? 'cp-ajax-ckeditor' : (GetParam('iframe') ? 'cp-iframe-ckeditor' : 'cp-ckeditor'); 
	}
    $mc_page = (GetSessionParam('LOGIN')) ? $p : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>