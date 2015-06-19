<?php
require_once('cp/dpc/system/pcntlhtml.lib.php'); 
$htmlpage = &new pcntl('
super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;

#---------------------------------load and create libs
use xwindow.window;
#use xwindow.window2,browser;

#---------------------------------load not create dpc (internal use)
include networlds.clientdpc;
include gui.form;
include mail.smtpmail;

load_extension recaptcha refby _RECAPTCHA_;	
			
security CART_DPC 1 1:1:1:1:1:1:1:1;
security SHCART_DPC 1 1:1:1:1:1:1:1:1;
security TRANSACTIONS_DPC 1 1:1:1:1:1:1:1:1;
security SHTRANSACTIONS_DPC 1 1:1:1:1:1:1:1:1;

#---------------------------------load all and create after dpc ojects
private frontpage.fronthtmlpage /cgi-bin;
private shop.shlogin /cgi-bin;
shop.rcvstats;
elements.confbar;
private shop.shlangs /cgi-bin;
private shop.shkategories /cgi-bin;
private shop.shkatalogmedia /cgi-bin;
private shop.shnsearch /cgi-bin;
private shop.shtags /cgi-bin;
private shop.shmenu /cgi-bin;
private shop.shusers /cgi-bin;
private shop.shcustomers /cgi-bin;
private shop.shcart /cgi-bin;
private shop.shtransactions /cgi-bin;
',0);
 
$mc_page = '403';
$headerStyle = 1;
echo $htmlpage->render(null,getlocal(),null,'media-center/index.php');
?>