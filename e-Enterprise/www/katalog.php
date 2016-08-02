<?php
require_once('cp/dpc2/system/pcntl.lib.php'); 
$htmlpage = &new pcntl('
super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;

use i18n.i18n;
use xwindow.window;

include networlds.clientdpc;
include mail.smtpmail;
include mchoice.mchoice;

security CART_DPC 5 5:5:5:5:5:5:5:5:5:5;
security SHCART_DPC 5 5:5:5:5:5:5:5:5:5:5;
security TRANSACTIONS_DPC 5 5:5:5:5:5:5:5:5:5:5;
security SHTRANSACTIONS_DPC 5 5:5:5:5:5:5:5:5:5:5;
/security ACCOUNTMNG_ 5 5:5:5:5:5:5:5:5:5:5;

/---------------------------------load all and create after dpc objects
private frontpage.fronthtmlpage /cgi-bin;
public twig.twigengine;
private cp.shlogin /cgi-bin;
private shop.rcvstats /cgi-bin;
public elements.confbar;
private shop.shlangs /cgi-bin;
private shop.shkategories /cgi-bin; 
private shop.shkatalogmedia /cgi-bin;
private shop.shnsearch /cgi-bin;
private shop.shwishcmp /cgi-bin;
private shop.shtags /cgi-bin;
private shop.shmenu /cgi-bin;
/private shop.shsubscribe /cgi-bin;
private shop.shusers /cgi-bin;
private shop.shcustomers /cgi-bin;
private shop.shcart /cgi-bin;
private shop.shtransactions /cgi-bin;
public i18n.i18nL;

',1);

$lan=getlocal();

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
    //$mc_page = GetReq('id') ? 'kshow' : 'klist';//GetReq('t') ? GetReq('t') : (isset($_GET['mc_page']) ? $_GET['mc_page'] : 'klist');	  
    $mc_page = GetGlobal('controller')->calldpc_method('frontpage.mcSelectPage use +klist');	
	//echo $mc_page,'>2';
    $headerStyle = ($mc_page=='home') ? 1 : 2;
    echo $htmlpage->render(null,getlocal(),null,'media-center/index.php');	  
//}
?>