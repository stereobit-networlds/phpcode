<?php
$start=microtime(true);
require_once('cp/dpc/system/pcntl.lib.php'); 
$htmlpage = &new pcntl('
super javascript;

load_extension adodb refby _ADODB_; 
super database;

use i18n.i18n;
load_extension recaptcha refby _RECAPTCHA_;	

/---------------------------------load all and create after dpc objects
public twig.twigengine;
public cms.cmsrt;
public cms.cmsvstats;
public cms.cmslogin;
public cms.cmsmenu;
public bshop.shkategories; 
public bshop.shkatalogmedia;
public bshop.shnsearch;
public bshop.shwishcmp;
public bshop.shtags;
public bshop.shusers;
public bshop.shcustomers;
public bshop.shcart;
public bshop.shtransactions;
private stereobit.shform /cgi-bin;
public jsdialog.jsdialogStream;
public i18n.i18nL;

',1);
$lan=getlocal();
$t = $_GET['t'];

	switch ($t) {
		case 'captchaimage' : die(_m('cmsrt.captchaImage')); break;
		
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
						  
        default        : 

						if ($t=='index') { 
							/*when in cart procedure disable common subscribe form in every page -footer-*/	
							$nosubform = ((GetParam('t')=='viewcart') || ((GetReq('t')=='calc')) ||
										  (GetReq('t')=='cart-order') || ((GetReq('t')=='cart-submit')) || 
										  (GetReq('t')=='cart-cancel') || ((GetReq('t')=='cart-checkout')) ||
										  (GetReq('t')=='addtocart') || ((GetReq('t')=='removefromcart')) ||
										  (GetParam('FormAction')==_v('shcart.checkout')) ||
										  (GetParam('FormAction')==_v('shcart.order')) ||
										  (GetParam('FormAction')==_v('shcart.submit'))) ? 1 : 0;
	  
							$mc_page = 'home-2';//_m('frontpage.mcSelectPage use +klist');	
							$headerStyle = ($mc_page=='home') ? 1 : 2;
							echo $htmlpage->render(null,getlocal(),null,'media-center/index.php');	  
						}
						elseif ($t) {
							$mc_page = $t ? $t : 'home-2';
							echo $htmlpage->render(null,getlocal(),null,'media-center/index.php');
						}
						else {/*land page */
							$mc_page = 'index'; //dummy arg for stats
							echo $htmlpage->render(null,getlocal(),null,'home-gr.html'); 
						}	
	}
	$user = GetGlobal('UserName') ? decode(GetGlobal('UserName')) : '';
	_m("cmsvstats.update_page_statistics use fp+$mc_page+".$user);

$time = (microtime(true) - $start)/60;//5.4$_SERVER["REQUEST_TIME_FLOAT"]);// /60;
echo "<!-- 	$time -->";	
?>