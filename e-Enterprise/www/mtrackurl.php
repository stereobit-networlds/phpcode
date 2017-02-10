<?php
define('SMTP_PHPMAILER','true');

require_once('cp/dpc/system/pcntl.lib.php'); 
$page = &new pcntl('
super javascript;
super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;		

public cms.cmsrt;
public cp.rctrackurl;

',1);	 

$lan = getlocal();
echo $page->render(null,$lan,null,"index.html");
?>