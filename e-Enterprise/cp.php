<?php
require_once('dpc2/system/pcntl.lib.php'); 
$page = &new pcntl('
super javascript;
super rcserver.rcssystem;
load_extension adodb refby _ADODB_; 
super database;
/---------------------------------load and create libs
use i18n.i18n;
use gui.swfcharts;
/use jqgrid.jqgrid;
use cp.cpflotcharts;

/---------------------------------load not create dpc (internal use)
include networlds.clientdpc;
include mail.smtpmail;

load_extension recaptcha refby _RECAPTCHA_;	

/---------------------------------load all and create after dpc objects
/public jqgrid.mygrid;
public cms.cmsrt;

#ifdef SES_LOGIN
public crm.crmforms;
public crm.rccrmtrace;
#endif

public bmail.rculiststats;
public cp.rcpmenu;
public cp.shlogin;
public cp.rccontrolpanel;
public i18n.i18nL;

',1);

$cptemplate = _m('rcserver.paramload use FRONTHTMLPAGE+cptemplate');


	switch ($_GET['t']) {
	    case 'chpass'   : 	$mc_page = (GetReq('sectoken')) ? 'cp-chpass' : 'cp-lock';
							break;
						
		case 'shremember':	$mc_page = 'cp-lock';
                            break;  
        case 'lang'     :   						
        default       	:	
							if (($user = $_POST['cpuser']) && ($pass = $_POST['cppass'])) 
								$login = _m("shlogin.do_login use ".$user.'+'.$pass.'+1');	//editmode
						
							if ((GetSessionParam('LOGIN'))||($login)) { 
								$cpGet = _v('rcpmenu.cpGet');
								$id = $cpGet['id'];
								$cat = $cpGet['cat'];
								$dashboard = (isset($id)) ? 'cp-itemstats' : ( (isset($cat)) ? 'cp-catstats' : 'cp-dashboard' );
						
								$seclevid = $GLOBALS['ADMINSecID'] ? $GLOBALS['ADMINSecID'] : GetSessionParam('ADMINSecID');
								$default_page = ($seclevid<6) ? 'cp-mailstats' : $dashboard; 
								$mc_page = (($p=GetReq('t')) && ($p!='cp'))  ? str_replace('cp', 'cp-', GetReq('t')) : $default_page;
							}
							else
								$mc_page = 'cp-login';
						
    }
  
	echo $page->render(null, getlocal(), null, $cptemplate.'/index.php');
?>