<?php
require_once('cp/dpc/system/pcntlhtml.lib.php'); 


$page = &new pcntl('
super rcserver.rcssystem;
load_extension adodb refby _ADODB_; 
super database;
include networlds.clientdpc;
#shop.rcitems;
',0);

      $lan = getlocal();
      $db = GetGlobal('db');
	  if (!$itmcode = GetReq('id')) return;
	  //$stype = GetReq('type')?GetReq('type'):'.jpg';
	  $stype = GetReq('type')?GetReq('type'):'SMALL';
	  	  
      $sSQL = "select data,type,code from pphotos ";
	  $sSQL .= " WHERE code='" . $itmcode . "'";
	  //if (isset($type))
	    //$sSQL .= " and type='". $type ."'";
	  if (isset($stype))
	    $sSQL .= " and stype='". $stype ."'";		

	  
	  $resultset = $db->Execute($sSQL,2);	
	  $result = $resultset;	  
	  
	  $image_type = $result->fields['type'] ? str_replace('.','',$result->fields['type']) :'jpg';
	  
	  header('Content-type: ' . 'image/'.$image_type);
	  if ($result->fields['code']) //photo exists
        echo base64_decode($result->fields['data']);
	  else {//additional photo or standart nopic
	    echo null;
      }  
	  
	  die();
?>