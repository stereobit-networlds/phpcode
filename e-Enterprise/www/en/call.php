<?php
require_once('cp/dpc2/system/pcntl.lib.php'); 
$htmlpage = &new pcntl('
super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;

#---------------------------------load and create libs
use i18n.i18n;
/use xwindow.window;

#---------------------------------load not create dpc (internal use)
include networlds.clientdpc;
/include gui.form;
include mail.smtpmail;

load_extension recaptcha refby _RECAPTCHA_;	
			
security CART_DPC 1 1:1:1:1:1:1:1:1;
security SHCART_DPC 1 1:1:1:1:1:1:1:1;
security TRANSACTIONS_DPC 1 1:1:1:1:1:1:1:1;
security SHTRANSACTIONS_DPC 1 1:1:1:1:1:1:1:1;

#---------------------------------load all and create after dpc ojects
private frontpage.fronthtmlpage /cgi-bin;
public cms.cmsrt;
public cms.cmsvstats;
public cms.cmslogin;
public elements.confbar;
private shop.shlangs /cgi-bin;
private shop.shusers /cgi-bin;
/private shop.shcustomers /cgi-bin;
private stereobit.shform /cgi-bin;
public jsdialog.jsdialogStream;
public i18n.i18nL;

',0);
 
//$mc_page = 'contact';
//$mc_page = GetGlobal('controller')->calldpc_method('frontpage.mcSelectPage use +contact');
//$headerStyle = ($mc_page=='home') ? 1 : 2;

	switch ($_GET['t']) {
		case 'useractivate' : if ($_GET['sectoken']) {
			                     //$msg = 'Account activated';
								 $mc_page = 'cp-login';
								 echo $htmlpage->render(null,getlocal(),null,'metro/index.php');
		                      }	 
		                      break;
	    case 'chpass' : if (GetReq('sectoken')) {
						  $mc_page = 'cp-chpass';
						  echo $htmlpage->render(null,getlocal(),null,'metro/index.php');
		                }  
		                else {
						  $mc_page = 'cp-lock';
						  echo $htmlpage->render(null,getlocal(),null,'metro/index.php');
						}  
		                break;
		case 'shremember':	
						  $mc_page = 'cp-lock';
						  echo $htmlpage->render(null,getlocal(),null,'metro/index.php');
                          break;   
						  
        default        :  $mc_page = 'call';
		                  echo $htmlpage->render(null,getlocal(),null,'cardio-en.html');
	}	
	$user = GetGlobal('UserName') ? decode(GetGlobal('UserName')) : '';
	_m("cmsvstats.update_page_statistics use fp+$mc_page+".$user);		  
?>