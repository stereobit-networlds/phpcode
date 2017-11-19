<?php
require_once('cp/dpc/system/pcntl.lib.php'); 
$htmlpage = &new pcntl('
super javascript;

load_extension adodb refby _ADODB_; 
super database;

/---------------------------------load and create libs
use i18n.i18n;

/---------------------------------load not create dpc 
include mail.smtpmail;

load_extension recaptcha refby _RECAPTCHA_;	
			
/---------------------------------load all and create after dpc ojects
public cms.cmsrt;
public cms.cmsvstats;
public cms.cmslogin;
public cms.cmssubscribe;
public cms.cmsmenu;
public bshop.shusers;
private stereobit.shform /cgi-bin;
public jsdialog.jsdialogStream;
public i18n.i18nL;

',1);

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