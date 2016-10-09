<?php
$start=microtime(true);
require_once('cp/dpc2/system/pcntl.lib.php'); 
$htmlpage = &new pcntl('
super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;

/---------------------------------load and create libs
use i18n.i18n;
use xwindow.window,browser;

/---------------------------------load not create dpc (internal use)
include networlds.clientdpc;
include mchoice;
include mail.smtpmail;
include gui.msgbox;
	
/---------------------------------load not create extensions (internal use)
load_extension adodb refby _RECAPTCHA_; 	
/load_extension PHP_XML_Dumper refby _PHP_XML_DUMPER_;	

security CART_DPC 1 1:1:1:1:1:1:1:1:1:1;
security SHCART_DPC 1 1:1:1:1:1:1:1:1:1:1;
security TRANSACTIONS_DPC 1 1:1:1:1:1:1:1:1:1:1;
security SHTRANSACTIONS_DPC 1 1:1:1:1:1:1:1:1:1:1;
/security ACCOUNTMNG_ 1 1:1:1:1:1:1:1:1:1:1;

/---------------------------------load all and create after dpc objects
private frontpage.fronthtmlpage /cgi-bin;
public twig.twigengine;
public cms.cmsrt;
public cms.cmsvstats;
public cms.cmslogin;
public elements.confbar;
private shop.shlangs /cgi-bin;
private shop.shkategories /cgi-bin; 
private shop.shkatalogmedia /cgi-bin;
private shop.shnsearch /cgi-bin;
private shop.shwishcmp /cgi-bin;
private shop.shtags /cgi-bin;
private shop.shmenu /cgi-bin;
/private shop.shslideshow /cgi-bin;
private shop.shsubscribe /cgi-bin;
private shop.shusers /cgi-bin;
private shop.shcustomers /cgi-bin;
private shop.shcart /cgi-bin;
private shop.shtransactions /cgi-bin;
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