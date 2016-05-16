<?php
require_once('dpc/system/pcntl.lib.php'); 
$page = &new pcntl('

super javascript;
super rcserver.rcssystem;

/---------------------------------load and create libs
use xwindow.window,xwindow.window2,browser;

/---------------------------------load not create dpc (internal use)
include frontpage.fronthtmlpage;

/---------------------------------load all and create after dpc objects
public cpanel.rcpanel;

',1);
echo $page->render(null,0,null,'cp_nocache.html');//'template4.htm');
?>

