<?php
$start=microtime(true);
require_once('cp/dpc/system/pcntl.lib.php'); 
$htmlpage = &new pcntl('
super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;

/---------------------------------load and create libs
use i18n.i18n;

/---------------------------------load not create dpc (internal use)
include networlds.clientdpc;
include mail.smtpmail;

security CART_DPC 1 1:1:1:1:1:1:1:1:1:1;
security SHCART_DPC 1 1:1:1:1:1:1:1:1:1:1;
security TRANSACTIONS_DPC 1 1:1:1:1:1:1:1:1:1:1;
security SHTRANSACTIONS_DPC 1 1:1:1:1:1:1:1:1:1:1;
security CUSTOMERSMNG_ 1 1:1:1:1:1:1:1:1:1:1;
security UPDATECUSTOMER_ 1 1:1:1:1:1:1:1:1:1:1;
/security ACCOUNTMNG_ 1 1:1:1:1:1:1:1:1:1:1;

/---------------------------------load all and create after dpc objects
public twig.twigengine;
public cms.cmsrt;
public cms.cmsvstats;
public cms.cmslogin;
public cms.cmsmenu;
public cms.cmssubscribe;
public bshop.shkategories; 
public bshop.shkatalogmedia;
public bshop.shnsearch;
public bshop.shwishcmp;
public bshop.shtags;
public bshop.shusers;
public bshop.shcustomers;
public bshop.shcart;
public bshop.shtransactions;
public jsdialog.jsdialogStream;
public i18n.i18nL;

',1);

    /*when in cart procedure disable common subscribe form in every page -footer-*/	
    $nosubform = ((GetParam('t')=='viewcart') || ((GetReq('t')=='calc')) ||
	              (GetReq('t')=='cart-order') || ((GetReq('t')=='cart-submit')) || 
		          (GetReq('t')=='cart-cancel') || ((GetReq('t')=='cart-checkout')) ||
				  (GetReq('t')=='addtocart') || ((GetReq('t')=='removefromcart')) ||
				  (GetParam('FormAction')==_v('shcart.checkout')) ||
				  (GetParam('FormAction')==_v('shcart.order')) ||
				  (GetParam('FormAction')==_V('shcart.submit'))) ? 1 : 0;
	  
    $mc_page = _m('frontpage.mcSelectPage use +klist');	
    $headerStyle = ($mc_page=='home') ? 1 : 2;
    echo $htmlpage->render(null,getlocal(),null,'media-center/index.php');	

$time = (microtime(true) - $start)/60;//5.4$_SERVER["REQUEST_TIME_FLOAT"]);// /60;
echo "<!-- 	$time -->";
?>