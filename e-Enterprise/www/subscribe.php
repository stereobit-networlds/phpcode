<?php
require_once('cp/dpc2/system/pcntl.lib.php'); 
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

security CART_DPC 1 1:1:1:1:1:1:1:1:1:1;
security SHCART_DPC 1 1:1:1:1:1:1:1:1:1:1;
security TRANSACTIONS_DPC 1 1:1:1:1:1:1:1:1:1:1;
security SHTRANSACTIONS_DPC 1 1:1:1:1:1:1:1:1:1:1;
security CUSTOMERSMNG_ 1 1:1:1:1:1:1:1:1:1:1;
security UPDATECUSTOMER_ 1 1:1:1:1:1:1:1:1:1:1;
/security ACCOUNTMNG_ 1 1:1:1:1:1:1:1:1:1:1;		

/---------------------------------load all and create after dpc objects
private frontpage.fronthtmlpage /cgi-bin;
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
private shop.shusers /cgi-bin;
private shop.shcustomers /cgi-bin;
private shop.shcart /cgi-bin;
public cms.cmssubscribe;
public i18n.i18nL;

',1);

$nosubform = ((GetParam('t')=='subscribe') || ((GetReq('t')=='unsubscribe'))) ? 1 : 0;

//$mc_page = 'subscribe';
$mc_page = _m('frontpage.mcSelectPage use +subscribe');
$user = GetGlobal('UserName') ? decode(GetGlobal('UserName')) : '';
_m("cmsvstats.update_page_statistics use fp+$mc_page+".$user);

$headerStyle = ($mc_page=='home') ? 1 : 2;
	  
echo $htmlpage->render(null,getlocal(),null,'media-center/index.php');
?>