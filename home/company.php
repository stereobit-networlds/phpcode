<?php
require_once('cp/dpc/system/pcntlhtml.lib.php'); 
$htmlpage = &new pcntl('
super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;

#---------------------------------load and create libs
use xwindow.window,browser;
#use xwindow.window2;
use filesystem.downloadfile;

#---------------------------------load not create dpc (internal use)
include networlds.clientdpc;
include mail.smtpmail;

	
#---------------------------------load not create extensions (internal use)	
#load_extension PHP_XML_Dumper refby _PHP_XML_DUMPER_;
load_extension recaptcha refby _RECAPTCHA_;	

security CART_DPC 1 1:1:1:1:1:1:1:1;
security SHCART_DPC 1 1:1:1:1:1:1:1:1;
security TRANSACTIONS_DPC 1 1:1:1:1:1:1:1:1;
security SHTRANSACTIONS_DPC 1 1:1:1:1:1:1:1:1;

#---------------------------------load all and create after dpc objects
private frontpage.fronthtmlpage /cgi-bin;
shop.rcvstats;
private shop.shlogin /cgi-bin;
elements.confbar;
private shop.shlangs /cgi-bin;
private shop.shkategories /cgi-bin; 
private shop.shkatalogmedia /cgi-bin;
private shop.shnsearch /cgi-bin;
private shop.shwishcmp /cgi-bin;
private shop.shtags /cgi-bin;
private shop.shmenu /cgi-bin;
#private shop.shslideshow /cgi-bin;
#private shop.shsubscribe /cgi-bin;
private shop.shusers /cgi-bin;
private shop.shcustomers /cgi-bin;
private shop.shcart /cgi-bin;
#private shop.shtransactions /cgi-bin;
',0);
  
//$mc_page = 'about';
$mc_page = GetGlobal('controller')->calldpc_method('frontpage.mcSelectPage use +company');
$headerStyle = ($mc_page=='home') ? 1 : 2; 
echo $htmlpage->render(null,getlocal(),null,'media-center/index.php');  
?>