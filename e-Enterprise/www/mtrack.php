<?php
define('SMTP_PHPMAILER','true');

require_once('cp/dpc/system/pcntl.lib.php'); 
$page = &new pcntl('
super javascript;

load_extension adodb4 refby _ADODB_; 		
super database;

public cms.cmsrt;
public mail.smtpmail;
public bmail.maildbqueue;

',1);	 

$ret = _m('maildbqueue.sendmail_tracker');
?>