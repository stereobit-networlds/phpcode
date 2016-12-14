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
	
/---------------------------------load not create extensions (internal use)
/load_extension adodb refby _RECAPTCHA_; 	

security CART_DPC 1 1:1:1:1:1:1:1:1:1:1;
security SHCART_DPC 1 1:1:1:1:1:1:1:1:1:1;
security TRANSACTIONS_DPC 1 1:1:1:1:1:1:1:1:1:1;
security SHTRANSACTIONS_DPC 1 1:1:1:1:1:1:1:1:1:1;
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

$mc_page = _m('frontpage.mcSelectPage use index+home++1');
$user = GetGlobal('UserName') ? decode(GetGlobal('UserName')) : '';
_m("cmsvstats.update_page_statistics use fp+$mc_page+".$user);

if ($mc_page == 'home') { 
	$_GET['style'] = 'alt2';
	$_GET['mc_page'] = 'home';
}	
else
	$_GET['style'] = 'alt';

$headerStyle = ($mc_page=='home') ? 1 : 2;
echo $htmlpage->render(null,getlocal(),null,'media-center/index.php');

$time = (microtime(true) - $start)/60;//5.4$_SERVER["REQUEST_TIME_FLOAT"]);// /60;
echo "<!-- 	$time -->";
?>