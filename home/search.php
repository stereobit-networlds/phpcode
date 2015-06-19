<?php
require_once('cp/dpc/system/pcntlajax.lib.php'); 
$htmlpage = &new pcntlajax('
super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;

#---------------------------------load and create libs
use xwindow.window;
#use xwindow.window2,browser;

#---------------------------------load not create dpc (internal use)
include networlds.clientdpc;
include mail.smtpmail;
include mchoice;
			

security CART_DPC 1 1:1:1:1:1:1:1:1;
security SHCART_DPC 1 1:1:1:1:1:1:1:1;
security TRANSACTIONS_DPC 1 1:1:1:1:1:1:1:1;
security SHTRANSACTIONS_DPC 1 1:1:1:1:1:1:1:1;

#---------------------------------load all and create after dpc objects
private frontpage.fronthtmlpage /cgi-bin;
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

if ((stristr(GetReq('t'),'cart')) || (stristr(GetReq('t'),'calc')) /*|| 
    (GetReq('t')=='signup')*/) {
 
    if (GetGlobal('UserName'))
      $mypage = "p_main_in$lan.html";
    else
      $mypage = "p_main$lan.html";
	  
	echo $htmlpage->render(null,getlocal(),null,$mypage);  
}
else {

    /*if (GetGlobal('UserName'))
      $mypage = "p_root_in$lan.html";
    else
      $mypage = "p_root$lan.html";*/
	  
    //$mc_page = GetReq('t') ? GetReq('t') : (isset($_GET['mc_page']) ? $_GET['mc_page'] : 'klist');	  
    $mc_page = GetGlobal('controller')->calldpc_method('frontpage.mcSelectPage use +klist');	
    $headerStyle = ($mc_page=='home') ? 1 : 2;
    echo $htmlpage->render(null,getlocal(),null,'media-center/index.php');	  
}
?>