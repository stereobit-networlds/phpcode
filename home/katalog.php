<?php
require_once('cp/dpc/system/pcntlajax.lib.php'); 
$htmlpage = &new pcntlajax('
super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;

#---------------------------------load and create libs
use xwindow.window,browser;
#use xwindow.window2;

#---------------------------------load not create dpc (internal use)
include networlds.clientdpc;
#include frontpage.frontpage,cache.supercache;
include gui.msgbox;
include mail.smtpmail;
include mchoice.mchoice;
	
#---------------------------------load not create extensions (internal use)
load_extension PHP_XML_Dumper refby _PHP_XML_DUMPER_;	

security CART_DPC 1 1:1:1:1:1:1:1:1;
security SHCART_DPC 1 1:1:1:1:1:1:1:1;
security TRANSACTIONS_DPC 1 1:1:1:1:1:1:1:1;
security SHTRANSACTIONS_DPC 1 1:1:1:1:1:1:1:1;
#security ACCOUNTMNG_ 1 1:1:1:1:1:1:1:1;

#---------------------------------load all and create after dpc objects
private frontpage.fronthtmlpage /cgi-bin;
twig.twigengine;
private shop.shlogin /cgi-bin;
shop.rcvstats;
elements.confbar;
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

',0);

$lan=getlocal();
/*
if ((stristr(GetReq('t'),'cart')) || (stristr(GetReq('t'),'calc')) || 
    (GetReq('t')=='savenewcus') || ((GetReq('t')=='savenewdeliv')) ||
	((GetReq('t')=='dologin'))) {
//if ((GetReq('t')=='viewcart')||(GetReq('t')=='signup')||(GetReq('t')=='addtocart')) {
 
    $mc_page = GetGlobal('controller')->calldpc_method('frontpage.mcSelectPage use +shcart');	
	//echo $mc_page,'>1';
    $headerStyle = ($mc_page=='home') ? 1 : 2;
    echo $htmlpage->render(null,getlocal(),null,'media-center/index.php');		
  }
else {*/
	//echo GetParam('FormAction');
    /*when in cart procedure disable common subscribe form in every page -footer-*/	
    $nosubform = ((GetParam('t')=='viewcart') || ((GetReq('t')=='calc')) ||
	              (GetReq('t')=='cart-order') || ((GetReq('t')=='cart-submit')) || 
		          (GetReq('t')=='cart-cancel') || ((GetReq('t')=='cart-checkout')) ||
				  (GetReq('t')=='addtocart') || ((GetReq('t')=='removefromcart')) ||
				  (GetParam('FormAction')==GetGlobal('controller')->calldpc_var('shcart.checkout')) ||
				  (GetParam('FormAction')==GetGlobal('controller')->calldpc_var('shcart.order')) ||
				  (GetParam('FormAction')==GetGlobal('controller')->calldpc_var('shcart.submit'))) ? 1 : 0;
	//echo 'nosubform:',$nosubform; 
    //$mc_page = GetReq('t') ? GetReq('t') : (isset($_GET['mc_page']) ? $_GET['mc_page'] : 'klist');	  
    $mc_page = GetGlobal('controller')->calldpc_method('frontpage.mcSelectPage use +klist');	
	//echo $mc_page,'>2';
    $headerStyle = ($mc_page=='home') ? 1 : 2;
    echo $htmlpage->render(null,getlocal(),null,'media-center/index.php');	  
//}
?>