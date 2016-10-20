<?php
require_once('dpc2/system/pcntlajax.lib.php'); 
$page = &new pcntlajax('

#define ESHOP CONF_ESHOP_ENABLE

super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;

/---------------------------------load and create libs
use i18n.i18n;
use gui.swfcharts;
use jqgrid.jqgrid;

/---------------------------------load not create dpc (internal use)
include networlds.clientdpc;

#if ESHOP > 0			
	security CART_DPC 1 1:1:1:1:1:1:1:1;
	security SHCART_DPC 1 1:1:1:1:1:1:1:1;
	security TRANSACTIONS_DPC 1 1:1:1:1:1:1:1:1;
	security SHTRANSACTIONS_DPC 1 1:1:1:1:1:1:1:1;
#endif				

/---------------------------------load all and create after dpc objects
private frontpage.fronthtmlpage /cgi-bin;
#ifdef SES_LOGIN
public jqgrid.mygrid;
private shop.rckategories /cgi-bin;
private shop.shkatalogmedia /cgi-bin;
private shop.rcitems /cgi-bin;
private shop.shcustomers /cgi-bin;
private shop.shcart /cgi-bin;
private shop.rctransactions /cgi-bin;
private cp.rcpmenu /cgi-bin;
#endif
private cp.rccontrolpanel /cgi-bin;
public i18n.i18nL;

',1);

$cptemplate = GetGlobal('controller')->calldpc_method('rcserver.paramload use FRONTHTMLPAGE+cptemplate');

    $mc_page = (GetSessionParam('LOGIN')) ? 'cp-transactions' : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>