<?php
require_once('dpc2/system/pcntlajax.lib.php'); 
$page = &new pcntlajax('

super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;

/---------------------------------load and create libs
use filesystem.downloadfile;
use jqgrid.jqgrid;

/---------------------------------load not create dpc (internal use)
include networlds.clientdpc;	

/---------------------------------load all and create after dpc objects
private frontpage.fronthtmlpage /cgi-bin;
#ifdef SES_LOGIN
public jqgrid.mygrid;
public backup.rcbackup;
private cp.rcpmenu /cgi-bin;
#endif
private cp.rccontrolpanel /cgi-bin;
',1);

$cptemplate = GetGlobal('controller')->calldpc_method('rcserver.paramload use FRONTHTMLPAGE+cptemplate');

$insDownload = GetGlobal('controller')->calldpc_var('rcbackup.instDownload');

	switch ($_GET['t']) {
		case 'cpbackupdn'   : $p = 'cp-backup-detail'; break;
		case 'cpbackupget'   : $p = 'cp-backup-detail'; break;
		case 'cpbackupsave'  : $p = $insDownload ? 'cp-backup-detail' : 'cp-backup'; break;
		case 'cpbackupdtl'   : $p = $_GET['iframe'] ? 'cp-backup-detail' : 'cp-backup'; break;
		default              : $p = $_GET['iframe'] ? 'cp-backup-detail' : 'cp-backup';
	}
	
    $mc_page = (GetSessionParam('LOGIN')) ? $p : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>