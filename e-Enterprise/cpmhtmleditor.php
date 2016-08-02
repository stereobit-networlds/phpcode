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

	switch ($_GET['t']) {
	    case 'cpmhtmleditor' : $p = $_GET['ajax'] ? 'cp-ajax-ckeditor' : ($_GET['iframe'] ? 'cp-iframe-ckeditor' : 'cp-ckeditor'); break;
		case 'cpmvphoto'     : $p = $_GET['ajax'] ? 'cp-ajax-mvphoto' : 'cp-mvphoto'; break;
		case 'cpmvdel'       : $p = $_GET['ajax'] ? 'cp-ajax-mvphoto' : 'cp-mvphoto'; break;
		default              : $p = ($_POST['insfast'] ? 'cp-uploadimage' : 'cp-htmleditor');
	}
    $mc_page = (GetSessionParam('LOGIN')) ? $p : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>