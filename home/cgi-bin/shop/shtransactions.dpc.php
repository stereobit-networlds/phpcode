<?php

$__DPCSEC['SHTRANSACTIONS_DPC']='1;1;1;2;2;2;2;2;9';

if ((!defined("SHTRANSACTIONS_DPC")) && (seclevel('SHTRANSACTIONS_DPC',decode(GetSessionParam('UserSecID')))) ) {
define("SHTRANSACTIONS_DPC",true);

$__DPC['SHTRANSACTIONS_DPC'] = 'shtransactions';

//require_once("transactions.dpc.php");
//GetGlobal('controller')->include_dpc('transactions/transactions.dpc.php');
$d = GetGlobal('controller')->require_dpc('transactions/transactions.dpc.php');
require_once($d);

//in case of page cntrl pxml not exist so load
$d = GetGlobal('controller')->require_dpc('shell/pxml.lib.php');
require_once($d);
/*$e = GetGlobal('controller')->require_dpc('gui/datepick.dpc.php');
require_once($e);
$f = GetGlobal('controller')->require_dpc('libs/browserSQL.lib.php');
require_once($f);*/

//this transfer all actions,commands,attr from parent to child and parent disabled(=null)
//it is important for inherit to still procced the commands of parent
GetGlobal('controller')->get_parent('TRANSACTIONS_DPC','SHTRANSACTIONS_DPC');
//print_r($__ACTIONS['SHTRANSACTIONS_DPC']);

$__EVENTS['SHTRANSACTIONS_DPC'][6]='transviewhtml';

$__ACTIONS['SHTRANSACTIONS_DPC'][6]='transviewhtml';

//overwrite for cmd line purpose
$__LOCALE['SHTRANSACTIONS_DPC'][0]='SHTRANSACTIONS_CNF;Transaction List;Λίστα Συναλλαγών';	   
$__LOCALE['SHTRANSACTIONS_DPC'][1]='_COST;Cost;Κόστος';	
$__LOCALE['SHTRANSACTIONS_DPC'][2]='_LOADCART;Load;Στο καλάθι';	
$__LOCALE['SHTRANSACTIONS_DPC'][3]='_PREVIEWCART;Preview;Προβολή';	
	   
class shtransactions extends transactions {

   var $path, $prpath;
   var $initial_word;
   
   static $staticpath, $myf_button_class; 

   var $tmpl_path, $tmpl_name;   

   function shtransactions() {
   
       transactions::transactions();
	   
	   self::$staticpath = paramload('SHELL','urlpath');
	   $this->prpath = paramload('SHELL','prpath');
	   
	   //override if exist
	   if ($tpath = paramload('SHTRANSACTIONS','path'))
	     $this->path = $this->prpath . $tpath;	

       $this->initial_word = remote_paramload('SHTRANSACTIONS','trid',$this->prpath);  
	   //echo $this->initial_word,'>';
	   $this->tmpl_path = remote_paramload('FRONTHTMLPAGE','path',$this->prpath);
	   $this->tmpl_name = remote_paramload('FRONTHTMLPAGE','template',$this->prpath);	   	   	   
	   
	   $bc = remote_paramload('SHTRANSACTIONS','buttonclass',$this->prpath); 
	   self::$myf_button_class = $bc ? $bc : 'myf_button';
	   	   
   }
   
   //override
   function event($event=null) {
   
       switch ($event) {
	     case 'transviewhtml' : $this->viewTransactionHtml();
		                        die();
		                        break;
								
		 default              : transactions::event($event);						
	   }
   }
   
   //override
   function action()  { 

		 //$out = $this->title();
		 //$out .= $this->form();
         //$out = setNavigator(localize('_TRANSLIST',getlocal()));
         $out .= $this->viewTransactions();

	   return ($out);
   }   
   
   //overwrite
   function saveTransaction($data='',$user='',$payway=null,$roadway=null,$qty=null,$cost=null,$costpt=null) {
   
      //execute default save and get id
      $id = transactions::saveTransaction($data,$user,$payway,$roadway,$qty,$cost,$costpt);
   
      //save xml file
      $xml = new pxml();

	  $xml->addtag('ORDER',null,null,"id=".$id);							
	  $xml->addtag('XUL','ORDER',null,null); 
      $xml->addtag('GTKWINDOW','XUL',null,null);
							
	  $ret = $xml->getxml();
	  $this->save2disk($id,$ret);
	  
	  unset($xml);   
							
	  return ($id);						
   }
   
   function save2disk($id,$data) {
   
      $file = $this->path . $id . ".xml"; 
	  //echo $file,$data;
      $fd = fopen($file, 'w');
      fwrite($fd, $data);
      fclose($fd);   
   }

    //override use tid instead of recid in db mode
	function setTransactionStatus($trid,$state) {
       $db = GetGlobal('db');
	   
	   //if ($this->storetype=='DB') {  //db		   
	     
	   
	     $sSQL = "update transactions set tstatus=" . $state .
	             " where tid='" . $this->initial_word. $trid ."'";
         $result = $db->Execute($sSQL);
		
	     //print $sSQL.'>';
	     //print $db->Affected_Rows() . ">>>>";
         if ($db->Affected_Rows()) return true;
	                          else return false;   	   
	  /* }
	   else {//echo "XML";  //xml and txt
	   
         if (is_dir($this->path)) {
           $i=1;
           $mydir = dir($this->path); //echo 'PATH:',$fpath;

           while ($fileread = $mydir->read()) {//echo $fileread,"<br>";
             if ((!is_dir($fpath.$fileread)) && ($fileread!='.') && 
			                                    ($fileread!='..') && 
												($fileread!='id.'.$this->storetype) && 
												(strstr($fileread,'.'.$this->storetype))) {	   
	     
	           if (stristr($fileread,$trid)) {
			     //echo $fileread;
				 $parts = explode("_",$fileread);
				 $parts[2] = $state . "." . $this->storetype;
				 $newname = implode("_",$parts);
				 //echo $newname;
				 rename($this->path.$fileread,$this->path.$newname);
				 $mydir->close();		   
				 return (true);
		       }
		     }	 
		   }  
	     }
         $mydir->close();		     
	   }	*/					  
	}
	
	function getTransactionStatus($trid) {
       $db = GetGlobal('db');
	   
	   $sSQL = "select tstatus from transactions" . 
	           " where tid='" . $this->initial_word. $trid ."'";
       $result = $db->Execute($sSQL);	
	   
	   $ret = $result->field['tstatus'];
	   return ($ret);
	}
	
	function setTransactionStoreData($trid,$fieldname,$value=null) {
       $db = GetGlobal('db');
	   	   
	   $sSQL = "update transactions set $fieldname='" . $value .
	           "' where tid='" . $this->initial_word. $trid ."'";
       $result = $db->Execute($sSQL);
		
	     //print $sSQL.'>';
	     //print $db->Affected_Rows() . ">>>>";
       if ($db->Affected_Rows()) 
	     return true;
	   else 
	     return false;   	   
	}
	
	function getTransactionStoreData($fieldname,$trid) {
       $db = GetGlobal('db');
	   	   
	   $sSQL = "select $fieldname from transactions " .
	           "where tid='" . $this->initial_word. $trid ."'";
       $result = $db->Execute($sSQL);
		
	     //print $sSQL.'>';
		 //print_r($result);
	     //print $db->Affected_Rows() . ">>>>";
       $ret = $result->fields[$fieldname]; 
	   return $ret;   	   
	}	 
	
	//called by shpaypal to check txn_id
	function checkPaypalTXNID($txnid) {
       $db = GetGlobal('db');
	   	   
       $sSQL = "select type1 from transactions where payway='PAYPAL' and type1=";
	   $sSQL .= $db->qstr($txnid);
       $result = $db->Execute($sSQL);
		
       if ($result->fields['type1']) 
	     return false;//exist ???
	   else 
	     return true;//not exist ok  	
	} 
	
	//called by shpiraeus to check txn_id
	function checkPiraeusTicket($txnid) {
       $db = GetGlobal('db');
	   	   
       $sSQL = "select type1 from transactions where payway='PIRAEUS' and type1=";
	   $sSQL .= $db->qstr($txnid);
       $result = $db->Execute($sSQL);
		
       if ($result->fields['type1']) 
	     return false;//exist ???
	   else 
	     return true;// not exist ok  	
	} 
	
	//replace 2 func above
	function is_unique($id,$fieldnametocheck=null,$valtocheck=null,$field=null) {
       $db = GetGlobal('db');
	   
	   $f = $field ? 'type2':'type1';
	
       $sSQL = "select $f from transactions where ";
	   
	   if ($fieldnametocheck)
	     $sSQL .= $fieldnametocheck."=" . $db->qstr($valtocheck) . " and ";
	   
	   $f . "=" . $db->qstr($id);
		 
	   $sSQL .= $db->qstr($txnid);
       $result = $db->Execute($sSQL);
		
       if ($result->fields[$f]) 
	     return false;//exist ???
	   else 
	     return true;// not exist ok  		
	}	 
	
	function saveTransactionHtml($id, $data, $template=null) {
		$file = $this->path . $id . ".html"; 
		//echo $file,'>',$template;//,$data;
		
		if (defined('TWIGENGINE_DPC')) {
		
			$dd = GetGlobal('controller')->calldpc_method('twigengine.render use '.$template.'++'.$data);
        }
        else {  		
		
			//d must be serialized array of tokens when template	
			$d = unserialize($data);		
			//echo $data;
			//print_r($d);
		
			if ($template) {
				//printout template
				$printcart_template = $template;
				$tm = $this->prpath . 'html/'. str_replace('.',getlocal().'.',$printcart_template) ;
				//echo $tm;
			} 		
		
			if (($tm) && (is_readable($tm))) {
				//echo $tm;
				$myprintcarttemplate = file_get_contents($tm);
		  
				//tokens=array=d seems to not come ok..so recall
				$tokens[] = GetGlobal('controller')->calldpc_var('shcart.transaction_id');//$this->transaction_id;
				if (iniload('JAVASCRIPT'))
					$tokens[] = GetGlobal('controller')->calldpc_method('javascript.JS_function use js_printwin+'.localize('_PRINT',getlocal()));
				else
					$tokens[] = '&nbsp;';//dummy
				$tokens[] = GetGlobal('controller')->calldpc_method('shcustomers.showcustomerdata use ++cusdetails.htm');
				$tokens[] = GetSessionParam('orderdetails');
				$tokens[] = GetSessionParam('ordercart');
		  
				$dd = $this->combine_tokens($myprintcarttemplate,$tokens,true);		
			}
			else {
				$headtitle = paramload('SHELL','urltitle');			
				$hpage = new phtml('../themes/style.css',$d,"<B><h1>$headtitle</h1></B>");
				$dd = $hpage->render();
				unset($hpage);		
			}
		}//if
		
        $fd = fopen($file, 'w');
        fwrite($fd, $dd, strlen($dd));
        fclose($fd);   		
	} 
	
	function getTransactionHtml($id) {
        $file = $this->path . $id . ".html"; 
	    //echo $file;//,$data;
		if (!$this->isTransOwner($id)) {
		  $ret = 'Invalid transaction id'; 		
		  return ($ret);
		}		
		
	    if (is_readable($file)) {
		
		  $ret = file_get_contents($file);
		}
		else
		  $ret = 'file not exist!';  
		
		return ($ret);		
	} 	
	
	//override
	function getTransaction($trid) {
       $db = GetGlobal('db');
	   
	   if ($this->storetype=='DB') {  //db	
	   	   
	     $sSQL = "select * from transactions where tid=" . $db->qstr($trid);
	     $res = $db->Execute($sSQL);
	     //print_r ($res->fields[5]);
	     if ($res) { 
	       $out = $res->fields[5]; 
		   return ($out);
	     }
	   }
	} 
	
	
	//return array of relative sales id's
	function getRelativeSales($limit=null,$id=null) {
       $db = GetGlobal('db');
	   $id = $id?$id:GetReq('id');
	   
	   //search serialized data for id
	   $sSQL = "select tid,tdata from transactions " .
	           "where tdata like'%" . $id ."%' order by tid desc";
       $result = $db->Execute($sSQL,2);
	   //echo $sSQL;
	   
	   foreach ($result as $n=>$rec) {	
         $tdata = $rec['tdata'];
		 
		 if ($tdata) {
		   $cdata = unserialize($tdata);
		   if (count($cdata)>1) {//if many items
		     foreach ($cdata as $i=>$buffer_data) {
		 
		       $param = explode(";",$buffer_data);
		       if ($param[0] != $id) 
		         $ret[] = $param[0]; //save code
			 
		       if (count($ret)>$limit) break; //limit to fetch	 
		     }	 
		   }
		 } 
	   }
	   return $ret;   	   	
	}	
	
	
	function getTransactionsList() {
       $db = GetGlobal('db');
       $UserName = GetGlobal('UserName');	
	   $name = $UserName?decode($UserName):null;		   
	   
	   if (!$name) return;
	   	
	   if ($this->storetype=='DB') {  //db	
	   	   
	     $sSQL = "select tid,tdate,ttime,tstatus,payway,roadway,cost,costpt from transactions where cid=" . $db->qstr($name) . 
		         "order by tid DESC";
				 
		 /*$browser = new browseSQL(localize('_TRANSLIST',getlocal()));
	     $out .= $browser->render($db,$sSQL,"transactions","transview",15,$this,1,0,1,0); //do not search internal because of form conflict
	     unset ($browser);*/					 
				 
	     $res = $db->Execute($sSQL,2);
	     //print_r ($res->fields[5]);
		 $i=0;
	     if (!empty($res)) { 
	       foreach ($res as $n=>$rec) {
		    $i+=1;
			
           /* if ($this->admint==1) {
			   //print checkbox 
			   $checkbox = "<input type=\"checkbox\" name=\"" . $rec[0] . 
			                                     "\" value=\"" . $rec[0] . "\">"; 
			}
			elseif ($this->admint==2) {
			   //print checkbox only if status!=1
			   $checkbox = "<input type=\"checkbox\" name=\"" . $rec[0] . 
			                                    "\" value=\"" . $rec[0] . "\">"; 
			}												  
			else $checkbox = "";*/			
			
            $transtbl[] = //$checkbox . $i . ";" . 
                         $rec[0] . ";" .
			             $rec[0] . ";" .
						 /*$rec[3] .*/ $rec[4] . "/" . $rec[5] . ";" .
			             $rec[1] . " / " . $rec[2] . ";" .	
			             number_format($rec[7],2,',','.');// . ";" .						 					 
			             //number_format($rec[7],2,',','.')/*str_replace(".",",",$rec[7])*/;		   
		   }
		   
           //browse
		   //print_r($transtbl); 
		   $ppager = GetReq('pl')?GetReq('pl'):10;
           $browser = new browse($transtbl,/*localize('_TRANSLIST',getlocal())*/null,$this->getpage($transtbl,$this->searchtext));
	       $out .= $browser->render("transview",$ppager,$this,1,0,0,0);
	       unset ($browser);	
		      
	     }
		 else {
           //empty message
	       $w = new window(/*localize('_CART',getlocal())*/null,localize('_EMPTY',getlocal()));
	       $out .= $w->render("center::40%::0::group_win_body::left::0::0::");//" ::100%::0::group_form_headtitle::center;100%;::");
	       unset($w);

		 }		 
	   }	
	   
	   return ($out);
	} 	
	
	//override
	function viewTransactions() {
       $db = GetGlobal('db');
	   $a = GetReq('a');
       $UserName = GetGlobal('UserName');	   
	   
	   if (!$UserName) {
	     if (defined('SHLOGIN_DPC')) {
		   $out = GetGlobal('controller')->calldpc_method("shlogin.quickform use +transview+shtransactions>viewTransactions");
		 }
	     //else
	       //$out = ("You must be logged in to view this page.");
		   
		 return ($out);  
	   }	 
	   
	   $apo = GetParam('apo'); //echo $apo;
	   $eos = GetParam('eos');	//echo $eos;   

       $myaction = seturl("t=transview");	   
	   
       if (seclevel('TRANSADMIN_',$this->userLevelID)) {
	     $this->admint=1;
         $out .= "<form method=\"POST\" action=\"";
         $out .= "$myaction";
         $out .= "\" name=\"Transview\">";		 
	   }
	   elseif (seclevel('TRANSCANCEL_',$this->userLevelID)) { 
	     $this->admint=2;	   
         $out .= "<form method=\"POST\" action=\"";
         $out .= "$myaction";
         $out .= "\" name=\"Transview\">";		   
	   }
	   else {
         $out .= "<form method=\"POST\" action=\"";
         $out .= "$myaction";
         $out .= "\" name=\"Transview\">";		   
	   }

	 
	   $out .= $this->getTransactionsList();	 
		 
	   if ($this->admint) {
		/*     if ($this->admint==1) {
	           $out .= "<input type=\"submit\" name=\"FormAction\" value=\"$this->status0\">&nbsp;";		 
	           $out .= "<input type=\"submit\" name=\"FormAction\" value=\"$this->status1\">&nbsp;";
			   $out .= "<input type=\"submit\" name=\"FormAction\" value=\"$this->status2\">&nbsp;";			   
			   $out .= "<input type=\"submit\" name=\"FormAction\" value=\"$this->status4\">";			   
			 }
			 elseif ($this->admint==2) {
			   $out .= "<input type=\"submit\" name=\"FormAction\" value=\"$this->status2\">&nbsp;";
			   $out .= "<input type=\"submit\" name=\"FormAction\" value=\"$this->status4\">";			   
			 }*/
			 
             $out .= "<input type=\"hidden\" name=\"FormName\" value=\"Transview\">";
             $out .= "</FORM>";			 		   
			 	
	   }  
	   		 

       /*$out .= $this->searchform();	    
		 
	   $dater = new datepicker();	
	   $out .= $dater->renderspace(seturl("t=transview&a=$a"),"transview");		 
	   unset($dater);
       */
						
	   
	   return ($out);
	}	
	
	//overide
	function details($id,$storebuffer=null) {
	   
	   if (defined('SHCART_DPC')) 
	     $ret = GetGlobal('controller')->calldpc_method('shcart.previewcart use '.$id.'+transview');
		 
	   return ($ret);
	}
	
	function viewTransactionHtml($id=null) {
	    $id = $id?$id:GetReq('tid');
		
		if (!$this->isTransOwner($id)) {
		  echo 'Invalid tranascrion id';
		  die();		
		}
	
        $file = $this->path . $id . ".html"; 
	    //echo $file;
		if (is_readable($file)) {
		  $ret = file_get_contents($file);
		
		  //return ($ret);	
		  echo $ret;
		  die();
		}
		else
		  return false;
	} 		
	
	//override
    function viewtrans($id,$fname,$lname,$status,$ddate,$dtime) {
	   $p = GetReq('p');
	   $a = GetReq('a');
	   
	   $link = 'trload/'.$id.'/';//seturl("t=loadcart&tid=$id");// , $id);
	   $cload_button = $this->myf_button(localize('_LOADCART',getlocal()),$link);
	   
       //if ($this->admint>0) {//==1) {
			   //print checkbox 
			   $data[] = $fname;//"<input type=\"checkbox\" name=\"" . $fname . "\" value=\"" . $fname . "\">"; 
	           $attr[] = "left;1%";											  
	   //}
	   /*elseif ($this->admint==2) {
			   //print checkbox only if status!=1
			   $data[] = "<input type=\"checkbox\" name=\"" . $fname . 
			                                  "\" value=\"" . $fname . "\">"; 
	           $attr[] = "left;1%";											  
	   }	*/											  	   
	   
							  
	   	   
	   $data[] = $cload_button;//$link;   
	   $attr[] = "left;10%";
	   
	   /*switch ($status) {
			  case 0 : $data[] = $this->status0; break;
			  case 1 : $data[] = $this->status1; break;	
			  case 2 : $data[] = $this->status2; break;				  		  
			  case 3 : $data[] = $this->status3; break;
			  case 4 : $data[] = $this->status4; break;
	   }	
	   $data[] = $fname;       
	   $attr[] = "left;10%";		   
	   */
	   
	   if (is_readable($this->path . $id . ".html")) {	
	     $lnk = 'trview/'.$id.'/';//seturl('t=transviewhtml&tid='.$id);//,$lname);
		 $preview_button = $this->myf_button(localize('_PREVIEWCART',getlocal()),$lnk);
       }
	   else 
	     //$lnk = $lname;
         $preview_button = $lname;		 
	   
	   $data[] = $preview_button;//$lnk;   
	   $attr[] = "left;50%";   
	   
	   $data[] = $status;   
	   $attr[] = "left;20%";	      
	   
	   $data[] = $ddate /*. '/' . $dtime*/;   
	   $attr[] = "right;10%";	
	   
	   //$data[] = $dtime;   
	   //$attr[] = "right;1%";	

	   $mtemplate='fptrans.htm';
	   $mt = $this->prpath . $this->tmpl_path .'/'. $this->tmpl_name .'/'. str_replace('.',getlocal().'.',$mtemplate) ;
	   //echo $t,'>';
	   if (($mtemplate) && is_readable($mt)) {
	     //line	
		 $mytemplate = file_get_contents($mt);
		 $out = $this->combine_tokens($mytemplate,$data);
		 
  		 //cart details
	     $_template='fptransline.htm';
	     $_t = $this->prpath . $this->tmpl_path .'/'. $this->tmpl_name .'/'. str_replace('.',getlocal().'.',$_template) ;
	     //echo $_t,'>';
	     if (($_template) && is_readable($_t)) {
			$linetemplate = file_get_contents($_t);
			$tokens[] = $this->details($id);
			//$tokens[] = $id;
			//$tokens[] = $status;
			$tokens[] = $line;//???
			$out .= $this->combine_tokens($linetemplate,$tokens);
		 }
         		 
	   }	   
	   else { //no template
	   
	   $myarticle = new window('',$data,$attr);
       $line = $myarticle->render("center::100%::0::group_dir_body::left::0::0::");
	   unset ($data);
	   unset ($attr);
	   
       if ($this->details) {//disable cancel and delete form buttons due to form elements in details????
	     $mydata = $line . '<br/>' . $this->details($id);
		 
         if (defined('WINDOW2_DPC')) {
	       $cartwin = new window2($id . '/' . $status,$mydata,null,1,null,'HIDE',null,1);
	       $out = $cartwin->render();//"center::100%::0::group_article_body::left::0::0::"
	       unset ($cartwin);		   
		 }
		 else {
	       $cartwin = new window($id . '/' . $status,$mydata);
	       $out = $cartwin->render();//"center::100%::0::group_article_body::left::0::0::"
	       unset ($cartwin);		 
		 }
	   }	
	   else {   
	     //echo 'z';
		 $out .= $line . '<hr>';
	   }	   
	   
       }//no template
	   
	   return ($out);
	}
	
	//security function to not vew trans of other users
	function isTransOwner($id=null) {
       $db = GetGlobal('db');
	   $id = $id?$id:GetReq('tid');
	   $myuser = GetGlobal('UserID');	
       $user = $myuser ? decode($myuser) : null;
	   
	   //search serialized data for id
	   $sSQL = "select tid from transactions" .
	           " where tid=" . $db->qstr($id) . ' and cid=' . $db->qstr($user);
       $result = $db->Execute($sSQL,2);
	   //echo $sSQL;
	   
	   if ($result->fields['tid']==$id)
	       return true;
		   
	   return false;	   
    }	   
		
	//override
	function headtitle() {
	   $p = GetReq('p');
	   $t = GetReq('t');
	   $sort = GetReq('sort');  
	
       $data[] = seturl("t=$t&a=&g=1&p=$p&sort=$sort&col=0" ,  "Id" );
	   $attr[] = "left;5%";							  
	   $data[] = seturl("t=$t&a=&g=2&p=$p&sort=$sort&col=1" , localize('_TRANSACTION',getlocal()) );
	   $attr[] = "center;20%";
	   $data[] = seturl("t=$t&a=&g=3&p=$p&sort=$sort&col=2" , localize('_TRANSTAT',getlocal()) );
	   $attr[] = "center;50%";
	   $data[] = seturl("t=$t&a=&g=4&p=$p&sort=$sort&col=3" , localize('_DATE',getlocal()) );
	   $attr[] = "center;20%";
	   $data[] = seturl("t=$t&a=&g=4&p=$p&sort=$sort&col=4" , localize('_COST',getlocal()) );
	   $attr[] = "center;10%";	 

	   $mtemplate='fptrans.htm';
	   $mt = $this->prpath . $this->tmpl_path .'/'. $this->tmpl_name .'/'. str_replace('.',getlocal().'.',$mtemplate) ;
	   //echo $t,'>';
	   if (($mtemplate) && is_readable($mt)) {
	   
		//$mytemplate = file_get_contents($mt);
		//$out = $this->combine_tokens($mytemplate,$data);
		return null;//deactivate
	   }	   
	   else {	   

  	    $mytitle = new window('',$data,$attr);
	    $out = $mytitle->render(" ::100%::0::group_form_headtitle::center;100%;::");
	    unset ($data);
	    unset ($attr);
       }	   
	   
	   return ($out);
	}	

	//tokens method	 $x
	function combine_tokens($template_contents,$tokens, $execafter=null) {
	
	    if (!is_array($tokens)) return;
		
		if ((!$execafter) && (defined('FRONTHTMLPAGE_DPC'))) {
		  $fp = new fronthtmlpage(null);
		  $ret = $fp->process_commands($template_contents);
		  unset ($fp);
          //$ret = GetGlobal('controller')->calldpc_method("fronthtmlpage.process_commands use ".$template_contents);		  		
		}		  		
		else
		  $ret = $template_contents;
		  
		//echo $ret;
	    foreach ($tokens as $i=>$tok) {
            //echo $tok,'<br>';
		    $ret = str_replace("$".$i,$tok,$ret);
	    }
		//clean unused token marks
		for ($x=$i;$x<20;$x++)
		  $ret = str_replace("$".$x,'',$ret);
		//echo $ret;
		
		//execute after replace tokens
		if (($execafter) && (defined('FRONTHTMLPAGE_DPC'))) {
		  $fp = new fronthtmlpage(null);
		  $retout = $fp->process_commands($ret);
		  unset ($fp);
          
		  return ($retout);
		}		
		
		return ($ret);
	}	
	
	protected static function myf_button($title,$link=null,$image=null) {
	   $path = self::$staticpath;//$this->urlpath;//
	   $bc = self::$myf_button_class;
	   
	   if (($image) && (is_readable($path."/images/".$image.".png"))) {
	      //echo 'a';
	      $imglink = "<a href=\"$link\" title='$title'><img src='images/".$image.".png'/></a>";
	   }
	   
	   if (preg_match('/MSIE/i',$_SERVER['HTTP_USER_AGENT'])) { 
	      //echo 'ie';
		  $_b = $imglink ? $imglink : "[$title]";
		  $ret = "&nbsp;<a href=\"$link\">$_b</a>&nbsp;";
		  return ($ret);
	   }	
	   
	   if ($imglink)
	       return ($imglink);
	
       //else button	
	   if ($link)
	      $ret = "<a href=\"$link\">";
		  
	   $ret .= "<input type=\"button\" class=\"$bc\" value=\"".$title."\" />";
	   
	   if ($link)
          $ret .= "</a>";	   
		  
	   return ($ret);
	}	
	
};
}
?>