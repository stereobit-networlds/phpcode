﻿<?php
require_once('cp/dpc/system/pcntlhtml.lib.php'); 
$htmlpage = &new pcntl('
super javascript;

load_extension adodb refby _ADODB_; 
super database;

/---------------------------------load and create libs
use i18n.i18n;

/---------------------------------load not create dpc
include mail.smtpmail;
			
/---------------------------------load all and create after dpc ojects
public cms.cmsrt;
public cms.cmsvstats;
/public cms.cmslogin;
public bshop.shlogin;
public cms.cmsmenu;
public cms.cmssubscribe;
public bshop.shkategories; 
public bshop.shkatalogmedia;
public bshop.shnsearch;
public bshop.shwishcmp;
public bshop.shtags;
public bshop.shmenu;
public bshop.shusers;
public bshop.shcustomers;
public bshop.shcart;
public bshop.shtransactions;
public jsdialog.jsdialogStream;
public i18n.i18nL;
',1);
 
$mc_page = '400';
$headerStyle = 1;
echo $htmlpage->render(null,getlocal(),null,'media-center/index.php');
?>