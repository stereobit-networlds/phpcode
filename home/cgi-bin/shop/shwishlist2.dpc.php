<?php

$__DPCSEC['SHWISHLIST2_DPC']='1;1;1;2;2;2;2;2;9';

if ((!defined("SHWISHLIST2_DPC")) && (seclevel('SHWISHLIST2_DPC',decode(GetSessionParam('UserSecID')))) ) {
define("SHWISHLIST2_DPC",true);

$__DPC['SHWISHLIST2_DPC'] = 'shwishlist2';


$d = GetGlobal('controller')->require_dpc('shop/shwishlist.dpc.php');
require_once($d);


GetGlobal('controller')->get_parent('SHWISHLIST_DPC','SHWISHLIST2_DPC');

$__EVENTS['SHWISHLIST2_DPC'][10]='wsadditem';
$__EVENTS['SHWISHLIST2_DPC'][11]='wsdelitem';
$__EVENTS['SHWISHLIST2_DPC'][12]='cmpadditem';
$__EVENTS['SHWISHLIST2_DPC'][13]='cmpdelitem';
$__EVENTS['SHWISHLIST2_DPC'][14]='cmplist';

$__ACTIONS['SHWISHLIST2_DPC'][10]='wsadditem';
$__ACTIONS['SHWISHLIST2_DPC'][11]='wsdelitem';
$__ACTIONS['SHWISHLIST2_DPC'][12]='cmpadditem';
$__ACTIONS['SHWISHLIST2_DPC'][13]='cmpdelitem';
$__ACTIONS['SHWISHLIST2_DPC'][14]='cmplist';

//overwrite for cmd line purpose
$__LOCALE['SHWISHLIST2_DPC'][0]='_WISHLIST;Wishlist;Wishlist';	   
$__LOCALE['SHWISHLIST2_DPC'][1]='_COMPARE;Compare;Σύγκριση';	
$__LOCALE['SHWISHLIST2_DPC'][2]='_ADDTOWISHLIST;add to wishlist;προσθήκη στη wishlist';
$__LOCALE['SHWISHLIST2_DPC'][3]='_ADDTOCOMPARE;add to compare;προσθήκη για σύγκριση';
/*$__LOCALE['SHWISHLIST2_DPC'][4]='_NAME;List name;Όνομα Λίστας';
$__LOCALE['SHWISHLIST2_DPC'][5]='_ADDWSTITLE;Add to Wish List;Εισαγωγή σε Wish List';
*/	   
class shwishlist2 extends shwishlist {

    var $tmpl_path, $tmpl_name;

    function __construct() {
   
       shwishlist::__construct();	

	   $this->tmpl_path = remote_paramload('FRONTHTMLPAGE','path',$this->path);
	   $this->tmpl_name = remote_paramload('FRONTHTMLPAGE','template',$this->path); 	    
    }
   
    //override
    function event($event=null) {
   
       switch ($event) {
	   
	     case 'cmpadditem'     : $this->cmpadd(); break;
		 case 'cmpdelitem'     : $this->cmprem(); break;	   
		 
	     case 'wsadditem'     : $this->add(); break;
		 case 'wsdelitem'     : $this->rem(); break;
		 default              : shwishlist::event($event);						
	   }
    }
   
    //override
    function action($action=null) {

       switch ($action) {
	     case 'cmpadditem'    : 
		 case 'cmpdelitem'    : 	   
	     case 'cmplist'       : $out .= $this->viewCompareList();
                                break;		 
	     case 'wsadditem'     : 
		 case 'wsdelitem'     : 	   						
		 default              : $out .= $this->viewWishList();
	   }
	   
	   return ($out);
    } 
	
	function add() {
	    if (!$id=GetReq('id')) return;
        $db = GetGlobal('db');
        $UserName = GetGlobal('UserName');	
        $name = $UserName?decode($UserName):null;		
		if ($name) {
			$sSQL = "insert into wishlist (tid,cid,listname) values (" . 
					$db->qstr($id) .",". 
					$db->qstr($name) .",'wishlist'".
					")";				 
			//echo $sSQL;
			$res = $db->Execute($sSQL);		
			return ($res);
		}
		return false;
	}
	
	function rem() {
	    if (!$id=GetReq('id')) return;
        $db = GetGlobal('db');
        $UserName = GetGlobal('UserName');	
        $name = $UserName?decode($UserName):null;
        if ($name) {		
			$sSQL = "delete from wishlist where tid=" . 
					$db->qstr($id) ." and cid=". $db->qstr($name) .
					" and listname='wishlist'";				 
			//echo $sSQL;
			$res = $db->Execute($sSQL);		
			return ($res);	
		}
		return false;
	}
	
	function wishcount() {
        $db = GetGlobal('db');
        $UserName = GetGlobal('UserName');	
        $name = $UserName?decode($UserName):null;
        if ($name) {		
			$sSQL = "select count(tid) from wishlist where " . 
					"cid=". $db->qstr($name) .
					" and listname='wishlist'";				 
			//echo $sSQL;
			$res = $db->Execute($sSQL);		
			return ($res->fields[0]);	
		}
		return 0;
	}	
	
	//override... items not lists
	function getWSLists() {
        $db = GetGlobal('db');
        $UserName = GetGlobal('UserName');	
	    $name = $UserName?decode($UserName):null;
	    if (!$name) {
		    if (defined('SHLOGIN_DPC')) {
				$out = GetGlobal('controller')->calldpc_method('shlogin.form');
				return($out);
			}
			else
			    return;
		
		}//return; 
	   
	    $sSQL = "select tid from wishlist where cid=" . $db->qstr($name) . 
		        "and listname='wishlist' order by recid DESC";				 
		//echo $sSQL;
	    $res = $db->Execute($sSQL,2);
	    //print_r ($res->fields[5]);
		
		if (defined('SHKATALOGMEDIA_DPC')) {
			//$out = GetGlobal('controller')->calldpc_method("shkatalogmedia.list_katalog ++fpkatalog-wishlist.htm++1+1++1+1+");		
			$out = 'test';
			return ($out);
		}
		
	    $lan = getlocal()?getlocal():'0';	  
	    $template_file='wishlist.htm';	   
	    $tfile = $this->path . $this->tmpl_path .'/'. $this->tmpl_name .'/'. str_replace('.',$lan.'.',$template_file) ; 	
	    $template_file2='wishlist-line.htm';		
		$tfile2 = $this->path . $this->tmpl_path .'/'. $this->tmpl_name .'/'. str_replace('.',$lan.'.',$template_file2) ; 	
	    //echo $tfile;
        if (is_readable($tfile)) {
		  $contents = file_get_contents($tfile);	   
		  $contents2 = file_get_contents($tfile2); //echo $contents2;
	      $template = 1;	     
	    }			
		
		$i=0;
	    if (!empty($res)) { 
		
	        foreach ($res as $n=>$rec) {
				$i+=1;		
				//echo $tfile2,'<br/>';
				$code = $rec['tid'];
				$item = GetGlobal('controller')->calldpc_method("shkatalogmedia.item_var use +$code+1+1");
				if ($template) {
				    $tokens = null;
				    $tokens[] = $item[27]; 
					$tokens[] = $item[6];
				    $tokens[] = $item[11];
					$tokens[] = $item[12];
					$tokens[] = $item[18];
					$tokens[] = $item[20];
					//print_r($tokens);
					$transtbl[] = $this->combine_tokens($contents2,$tokens);
				}
				else
				    $transtbl[] = $rec[5] . ";" .$rec[0] . ";" .$rec[4] . ";" .$rec[1] . ";" .$rec[3];   
		    }
		   
            //browse
		    if ($template) {
			    //print_r($transtbl);
			    $maintoken[] = (!empty($transtbl)) ? implode('',$transtbl) : null;
		    }
		    else {
				//print_r($transtbl); 
				$ppager = GetReq('pl')?GetReq('pl'):10;
				$browser = new browse($transtbl,null,$this->getpage($transtbl,$this->searchtext));
				$out .= $browser->render("wishview",$ppager,$this,1,0,0,0);
				unset ($browser);	
		    }  
	    }
		else {
		    if ($template) {
			    $out = null;
			}
			else {//empty message
				$w = new window(null,localize('_EMPTY',getlocal()));
				$out .= $w->render("center::40%::0::group_win_body::left::0::0::");//" ::100%::0::group_form_headtitle::center;100%;::");
				unset($w);
            } 
		}
		
		if ($template) 
			$out = $this->combine_tokens($contents,$maintoken);	  
			
		return ($out);		
	} 	
	
	//override
	function viewWishList() {
       $db = GetGlobal('db');
	   $a = GetReq('a');
       $UserName = GetGlobal('UserName');	   
	   
	   if (!$UserName) {
	     if (defined('SHLOGIN_DPC')) {
		   $out = GetGlobal('controller')->calldpc_method("shlogin.quickform use +wsview+wishlist>viewWishList");
		 }
	     else
	       $out = ("You must be logged in to view this page.");
		   
		 return ($out);  
	   }	 

	   $out .= $this->getWSLists();	 
		 
	   return ($out);
	}		
	
	
	/********************* compare items ***********************/
	
	function cmpadd() {
	    if (!$id=GetReq('id')) return;
		if ($this->cmpcount()>3) return;
        $db = GetGlobal('db');
        $UserName = GetGlobal('UserName');	
        $name = $UserName?decode($UserName):null;		
		if ($name) {
			$sSQL = "insert into wishlist (tid,cid,listname) values (" . 
					$db->qstr($id) .",". 
					$db->qstr($name) .",'compare'".
					")";				 
			//echo $sSQL;
			$res = $db->Execute($sSQL);		
			return ($res);
		}
		return false;
	}
	
	function cmprem() {
	    if (!$id=GetReq('id')) return;
        $db = GetGlobal('db');
        $UserName = GetGlobal('UserName');	
        $name = $UserName?decode($UserName):null;
        if ($name) {		
			$sSQL = "delete from wishlist where tid=" . 
					$db->qstr($id) ." and cid=". $db->qstr($name) .
					" and listname='compare'";				 
			//echo $sSQL;
			$res = $db->Execute($sSQL);		
			return ($res);	
		}
		return false;
	}	
	
	function cmpcount() {
        $db = GetGlobal('db');
        $UserName = GetGlobal('UserName');	
        $name = $UserName?decode($UserName):null;
        if ($name) {		
			$sSQL = "select count(tid) from wishlist where " . 
					"cid=". $db->qstr($name) .
					" and listname='compare'";				 
			//echo $sSQL;
			$res = $db->Execute($sSQL);		
			return ($res->fields[0]);	
		}
		return 0;
	}		
	
	function getCMPLists() {
        $db = GetGlobal('db');
        $UserName = GetGlobal('UserName');	
	    $name = $UserName?decode($UserName):null;
	    if (!$name) {
		    if (defined('SHLOGIN_DPC')) {
				$out = GetGlobal('controller')->calldpc_method('shlogin.form');
				return($out);
			}
			else
			    return;
		
		}//return;
	   
	    $lan = getlocal()?getlocal():'0';	  
	    $template_file='compare.htm';	   
	    $tfile = $this->path . $this->tmpl_path .'/'. $this->tmpl_name .'/'. str_replace('.',$lan.'.',$template_file) ; 	
	    $template_file2='compare-line.htm';		
		$tfile2 = $this->path . $this->tmpl_path .'/'. $this->tmpl_name .'/'. str_replace('.',$lan.'.',$template_file2) ; 	
	    //echo $tfile;
        if (is_readable($tfile)) {
		  $contents = file_get_contents($tfile);	   
		  $contents2 = file_get_contents($tfile2); //echo $contents2;
	      $template = 1;	     
	    }	 
	   
	    $sSQL = "select tid from wishlist where cid=" . $db->qstr($name) . 
		        "and listname='compare' order by recid DESC";				 
		//echo $sSQL;
	    $res = $db->Execute($sSQL,2);
		
	    //print_r ($res->fields[5]);
		$i=0;
	    if (!empty($res)) { 
		
	        foreach ($res as $n=>$rec) {
				$i+=1;		
				//echo $tfile2,'<br/>';
				$code = $rec['tid'];
				$item = GetGlobal('controller')->calldpc_method("shkatalogmedia.item_var use +$code+1+1");
				if ($template) {
				    $tokens = null;
				    $tokens[] = $item[27]; 
					$tokens[] = $item[6];
				    $tokens[] = $item[11];
					$tokens[] = $item[12];
					$tokens[] = $item[18];
					$tokens[] = $item[20];
					//print_r($tokens);
					$transtbl[] = $this->combine_tokens($contents2,$tokens);
				}
				else
				    $transtbl[] = $rec[5] . ";" .$rec[0] . ";" .$rec[4] . ";" .$rec[1] . ";" .$rec[3];   
		    }
		   
            //browse
		    if ($template) {
			    //print_r($transtbl);
			    $maintoken[] = (!empty($transtbl)) ? implode('',$transtbl) : null;
		    }
		    else {
				//print_r($transtbl); 
				$ppager = GetReq('pl')?GetReq('pl'):10;
				$browser = new browse($transtbl,null,$this->getpage($transtbl,$this->searchtext));
				$out .= $browser->render("wishview",$ppager,$this,1,0,0,0);
				unset ($browser);	
		    }  
	    }
		else {
		    if ($template) {
			    $out = null;
			}
			else {//empty message
				$w = new window(null,localize('_EMPTY',getlocal()));
				$out .= $w->render("center::40%::0::group_win_body::left::0::0::");//" ::100%::0::group_form_headtitle::center;100%;::");
				unset($w);
            } 
		}
		
		if ($template) 
			$out = $this->combine_tokens($contents,$maintoken);	  
			
		return ($out);		
	} 	
	
	function viewCompareList() {
       $db = GetGlobal('db');
	   $a = GetReq('a');
       $UserName = GetGlobal('UserName');	   
	   
	   if (!$UserName) {
	     if (defined('SHLOGIN_DPC')) {
		   $out = GetGlobal('controller')->calldpc_method("shlogin.quickform use +wsview+wishlist>viewWishList");
		 }
	     else
	       $out = ("You must be logged in to view this page.");
		   
		 return ($out);  
	   }	 

	   $out .= $this->getCMPLists();	 
		 
	   return ($out);
	}		

	//tokens method	
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
		    $ret = str_replace("$".$i."$",$tok,$ret);
	    }
		//clean unused token marks
		for ($x=$i;$x<30;$x++)
		  $ret = str_replace("$".$x."$",'',$ret);
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
};
}
?>