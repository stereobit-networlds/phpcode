<?php
require_once('cp/dpc2/system/pcntl.lib.php'); 
$htmlpage = &new pcntl('
super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;

use i18n.i18n;
include networlds.clientdpc;
load_extension recaptcha refby _RECAPTCHA_;	

security CART_DPC 1 1:1:1:1:1:1:1:1:1:1;
security SHCART_DPC 1 1:1:1:1:1:1:1:1:1:1;
security TRANSACTIONS_DPC 1 1:1:1:1:1:1:1:1:1:1;
security SHTRANSACTIONS_DPC 1 1:1:1:1:1:1:1:1:1:1;
/security ACCOUNTMNG_ 1 1:1:1:1:1:1:1:1:1:1;

/---------------------------------load all and create after dpc objects
private frontpage.fronthtmlpage /cgi-bin;
public twig.twigengine;
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
/private shop.shsubscribe /cgi-bin;
private shop.shusers /cgi-bin;
private shop.shcustomers /cgi-bin;
private shop.shcart /cgi-bin;
private shop.shtransactions /cgi-bin;
private stereobit.shform /cgi-bin;
/private stereobit.jsdialog /cgi-bin;
public jsdialog.jsdialogStream;
public i18n.i18nL;

',1);

$lan=getlocal();
$t = $_GET['t'];

	switch ($t) {
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

						if ($t=='index') { /*e-shop start page*/
							//echo GetParam('FormAction');
							/*when in cart procedure disable common subscribe form in every page -footer-*/	
							$nosubform = ((GetParam('t')=='viewcart') || ((GetReq('t')=='calc')) ||
										  (GetReq('t')=='cart-order') || ((GetReq('t')=='cart-submit')) || 
										  (GetReq('t')=='cart-cancel') || ((GetReq('t')=='cart-checkout')) ||
										  (GetReq('t')=='addtocart') || ((GetReq('t')=='removefromcart')) ||
										  (GetParam('FormAction')==GetGlobal('controller')->calldpc_var('shcart.checkout')) ||
										  (GetParam('FormAction')==GetGlobal('controller')->calldpc_var('shcart.order')) ||
										  (GetParam('FormAction')==GetGlobal('controller')->calldpc_var('shcart.submit'))) ? 1 : 0;
							//echo 'nosubform:',$nosubform; 
							//$mc_page = GetReq('t') ? GetReq('t') : (isset($_GET['mc_page']) ? $_GET['mc_page'] : 'klist');	  
							$mc_page = 'home-2';//GetGlobal('controller')->calldpc_method('frontpage.mcSelectPage use +klist');	
							//echo $mc_page,'>2';
							$headerStyle = ($mc_page=='home') ? 1 : 2;
							echo $htmlpage->render(null,getlocal(),null,'media-center/index.php');	  
						}
						elseif ($t) {
							$mc_page = $t ? $t : 'home-2';
							echo $htmlpage->render(null,getlocal(),null,'media-center/index.php');
						}
						else {/*land page */
						    $mc_page = 'index';
							echo $htmlpage->render(null,getlocal(),null,'home-en.html'); 
						}	
	}	
	$user = GetGlobal('UserName') ? decode(GetGlobal('UserName')) : '';
	_m("cmsvstats.update_page_statistics use fp+$mc_page+".$user);		
?>