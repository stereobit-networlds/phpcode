<?php
define('SMTP_PHPMAILER','true');

require_once('cp/dpc2/system/pcntl.lib.php'); 
$page = &new pcntl('
super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;		

/---------------------------------load all and create after dpc objects
public frontpage.fronthtmlpage;
/private frontpage.fronthtmlpage /cgi-bin;
/public mail.smtpmail;
/public mail.maildbqueue;
public phpdac.rctrackurl;

',0);	 
//echo GetGlobal('controller')->calldpc_method('rctrackurl.urlTracker');
$lan = getlocal();
echo $page->render(null,$lan,null,"index.html");

//in case of no redir
/*$location = GetGlobal('controller')->calldpc_var('rctrackurl.location');
echo "<html><head></head><body>";
echo "<a href='$location'>Press here to redirect</a>";
echo "</body></html>";*/
?>