<?php
require_once('cp/dpc/system/pcntl.lib.php'); 
$htmlpage = &new pcntl('
super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;

/---------------------------------load and create libs
use xwindow.window;

/---------------------------------load not create dpc (internal use)
include networlds.clientdpc;

load_extension recaptcha refby _RECAPTCHA_;	
			
security CART_DPC 1 1:1:1:1:1:1:1:1:1:1;
security SHCART_DPC 1 1:1:1:1:1:1:1:1:1:1;
security TRANSACTIONS_DPC 1 1:1:1:1:1:1:1:1:1:1;
security SHTRANSACTIONS_DPC 1 1:1:1:1:1:1:1:1:1:1;

/---------------------------------load all and create after dpc ojects
public cms.cmsrt;
public cp.rcnewsletter;
',1);

//$ns_page = '3adbd8c3d5dc79e3aad164b0e0fc8a93.html'; 
 
//$r = $_GET['r'] ? $_GET['r'] : $_COOKIE['mc']; //the page always copied to the r base64 encode mail of viewer
//if (!$r) die('');//'Not allowed!'); //if not a mail receiver, not allow to see
$r = $_GET['a'];// ? $_GET['a'] : $_COOKIE['mc'];

$ns_page = $r ? urldecode($r) .'.html' :'cp_em.html'; //as default event the page is copied and ready 
//echo $ns_page; //redir to subscribe when no tag ???
echo $htmlpage->render(null,getlocal(),null,$ns_page);//'media-center/index.php');
?>