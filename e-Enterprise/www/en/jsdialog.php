<?php
require_once('cp/dpc2/system/pcntl.lib.php'); 
$page = new pcntl('
super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 		
super database;

public cms.cmsrt;
public jsdialog.jsdialogStream;
',1);	 

//$title = localize('_defaultTitle', getlocal());
//$text = localize('_defaultText', getlocal());

//echo $_SERVER['PHP_SELF'];
/*if (stristr($_SERVER['PHP_SELF'], 'jsdialog.php'))
	echo '1'; //not to view when call directly
else*/
	//echo GetGlobal('controller')->calldpc_method("jsdialog.defaultDialog use $text+$title");
	
//echo "&nbsp;"; //null
echo $page->render(null,getlocal(),null,'empty.html');
?>
