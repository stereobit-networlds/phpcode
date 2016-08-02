<?php
require_once('cp/dpc2/system/pcntlhtml.lib.php'); 
$htmlpage = &new pcntl('
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

/---------------------------------load not create extensions (internal use)	
load_extension recaptcha refby _RECAPTCHA_;		

/---------------------------------load all and create after dpc objects
private frontpage.fronthtmlpage /cgi-bin;
public shop.rcvstats;
private shop.shlogin /cgi-bin;
public elements.confbar;
private shop.shlangs /cgi-bin;
private shop.shkategories /cgi-bin; 
private shop.shkatalogmedia /cgi-bin;
private shop.shnsearch /cgi-bin;
private shop.shtags /cgi-bin;
private shop.shmenu /cgi-bin;
/private shop.shslideshow /cgi-bin;
/private shop.shsubscribe /cgi-bin;
private shop.shusers /cgi-bin;
private shop.shcustomers /cgi-bin;
private shop.shcart /cgi-bin;
/private shop.shtransactions /cgi-bin;
public i18n.i18nL;

',1);

$mc_page = GetGlobal('controller')->calldpc_method('frontpage.mcSelectPage use +privacy');
$headerStyle = ($mc_page=='home') ? 1 : 2;
	  
echo $htmlpage->render(null,getlocal(),null,'media-center/index.php');  
?>