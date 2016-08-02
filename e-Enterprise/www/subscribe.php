<?php
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
mail.smtpmail;
	
/---------------------------------load not create extensions (internal use) 		

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
private shop.shusers /cgi-bin;
private shop.shcustomers /cgi-bin;
private shop.shcart /cgi-bin;
private shop.shsubscribe /cgi-bin;
public i18n.i18nL;

',1);

    $nosubform = ((GetParam('t')=='subscribe') || 
	              ((GetReq('t')=='unsubscribe'))) ? 1 : 0;

//$mc_page = 'subscribe';
$mc_page = GetGlobal('controller')->calldpc_method('frontpage.mcSelectPage use +subscribe');
$headerStyle = ($mc_page=='home') ? 1 : 2;
	  
echo $htmlpage->render(null,getlocal(),null,'media-center/index.php');
?>