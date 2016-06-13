<?php
define('SMTP_PHPMAILER','true');

require_once('cp/dpc2/system/pcntl.lib.php'); 
$page = new pcntl('
super rcserver.rcssystem;
load_extension adodb4 refby _ADODB_; 		
super database;

/frontpage.fronthtmlpage;
public mail.smtpmail;
public mail.maildbqueue;

',1);	 

$ret = GetGlobal('controller')->calldpc_method('maildbqueue.sendmail_tracker');

echo "&nbsp;"; //null
?>
