<?php
require_once('cp/dpc2/system/pcntlajax.lib.php'); 
$htmlpage = &new pcntlajax('
super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;

/---------------------------------load and create libs
use i18n.i18n;
use xwindow.window;

/---------------------------------load not create dpc (internal use)
include networlds.clientdpc;
include mail.smtpmail;
include mchoice;
			

security CART_DPC 1 1:1:1:1:1:1:1:1:1:1;
security SHCART_DPC 1 1:1:1:1:1:1:1:1:1:1;
security TRANSACTIONS_DPC 1 1:1:1:1:1:1:1:1:1:1;
security SHTRANSACTIONS_DPC 1 1:1:1:1:1:1:1:1:1:1;

/---------------------------------load all and create after dpc objects
private frontpage.fronthtmlpage /cgi-bin;
private shop.shlogin /cgi-bin;
public shop.rcvstats;
public elements.confbar;
private shop.shlangs /cgi-bin;
private shop.shkategories /cgi-bin; 
private shop.shkatalogmedia /cgi-bin;
private shop.shnsearch /cgi-bin;
private shop.shwishcmp /cgi-bin;
private shop.shtags /cgi-bin;
private shop.shmenu /cgi-bin;
private shop.shsubscribe /cgi-bin;
private shop.shusers /cgi-bin;
private shop.shcustomers /cgi-bin;
private shop.shcart /cgi-bin;
private shop.shtransactions /cgi-bin;
public i18n.i18nL;

',1);

$lan=getlocal();
	  
//$mc_page = GetReq('t') ? GetReq('t') : (isset($_GET['mc_page']) ? $_GET['mc_page'] : 'klist');	  
$mc_page = GetGlobal('controller')->calldpc_method('frontpage.mcSelectPage use +klist');	
$headerStyle = ($mc_page=='home') ? 1 : 2;
echo $htmlpage->render(null,getlocal(),null,'media-center/index.php');	  
?>