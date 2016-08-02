<?php
require_once('cp/dpc2/system/pcntlhtml.lib.php'); 
$htmlpage = &new pcntl('
super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;

/---------------------------------load and create libs
use xwindow.window;

/---------------------------------load not create dpc (internal use)
include networlds.clientdpc;
include mchoice;
include mail.smtpmail;
include gui.msgbox;
	
/---------------------------------load not create extensions (internal use)	
load_extension PHP_XML_Dumper refby _PHP_XML_DUMPER_;	

security CART_DPC 1 1:1:1:1:1:1:1:1:1:1;
security SHCART_DPC 1 1:1:1:1:1:1:1:1:1:1;
security TRANSACTIONS_DPC 1 1:1:1:1:1:1:1:1:1:1;
security SHTRANSACTIONS_DPC 1 1:1:1:1:1:1:1:1:1:1;


/---------------------------------load all and create after dpc objects
private frontpage.fronthtmlpage /cgi-bin;
private shop.shlogin /cgi-bin;
private shop.rcvstats /cgi-bin;
/public elements.confbar;
private shop.shlangs /cgi-bin;
private shop.shkategories /cgi-bin; 
private shop.shkatalogmedia /cgi-bin;
private shop.shnsearch /cgi-bin;
private shop.shtags /cgi-bin;
private shop.shmenu /cgi-bin;
private shop.shusers /cgi-bin;
private shop.shcustomers /cgi-bin;
private shop.shcart /cgi-bin;
/private shop.shtransactions /cgi-bin;
',1);

//$mc_page = GetReq('t') ? GetReq('t') : (isset($_GET['mc_page']) ? $_GET['mc_page'] : 'sitemap');	  
$mc_page = GetGlobal('controller')->calldpc_method('frontpage.mcSelectPage use +sitemap');	
$headerStyle = ($mc_page=='home') ? 1 : 2;
	
echo $htmlpage->render(null,getlocal(),null,'media-center/index.php');	
?>