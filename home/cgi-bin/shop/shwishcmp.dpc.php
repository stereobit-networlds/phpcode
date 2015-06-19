<?php
if (defined("SHKATALOGMEDIA_DPC")) {
$__DPCSEC['SHWISHCMP_DPC']='1;1;1;2;2;2;2;2;9';

if ((!defined("SHWISHCMP")) /*&& (seclevel('SHWISHCMPC',decode(GetSessionParam('UserSecID'))))*/ ) {
define("SHWISHCMP_DPC",true);

$__DPC['SHWISHCMP_DPC'] = 'shwishcmp';


//$d = GetGlobal('controller')->require_dpc('shop/shwishlist.dpc.php');
//require_once($d);

//GetGlobal('controller')->get_parent('SHWISHLIST_DPC','SHWISHLIST2_DPC');

$__EVENTS['SHWISHCMP_DPC'][0]='wishcmp';
$__EVENTS['SHWISHCMP_DPC'][1]='wishview';
$__EVENTS['SHWISHCMP_DPC'][2]='wsadditem';
$__EVENTS['SHWISHCMP_DPC'][3]='wsdelitem';
$__EVENTS['SHWISHCMP_DPC'][4]='cmpadditem';
$__EVENTS['SHWISHCMP_DPC'][5]='cmpdelitem';
$__EVENTS['SHWISHCMP_DPC'][6]='cmplist';
$__EVENTS['SHWISHCMP_DPC'][7]='wslist';

$__ACTIONS['SHWISHCMP_DPC'][0]='wishcmp';
$__ACTIONS['SHWISHCMP_DPC'][1]='wishview';
$__ACTIONS['SHWISHCMP_DPC'][2]='wsadditem';
$__ACTIONS['SHWISHCMP_DPC'][3]='wsdelitem';
$__ACTIONS['SHWISHCMP_DPC'][4]='cmpadditem';
$__ACTIONS['SHWISHCMP_DPC'][5]='cmpdelitem';
$__ACTIONS['SHWISHCMP_DPC'][6]='cmplist';
$__ACTIONS['SHWISHCMP_DPC'][7]='wslist';

//overwrite for cmd line purpose
$__LOCALE['SHWISHCMP_DPC'][0]='SHWISHCMP_DPC;Wish list;Wish list';
$__LOCALE['SHWISHCMP_DPC'][1]='_WISHLIST;Wishlist;Wishlist';	   
$__LOCALE['SHWISHCMP_DPC'][2]='_COMPARE;Compare;Σύγκριση';	
$__LOCALE['SHWISHCMP_DPC'][3]='_ADDTOWISHLIST;add to wishlist;προσθήκη στη wishlist';
$__LOCALE['SHWISHCMP_DPC'][4]='_ADDTOCOMPARE;add to compare;προσθήκη για σύγκριση';
$__LOCALE['SHWISHCMP_DPC'][5]='SHWISHLIST_CNF;Wish List;Wish List';
 
class shwishcmp extends shkatalogmedia {


    function __construct() {
   
       shkatalogmedia::shkatalogmedia();	

    }
   
    function event($event=null) {
   
       switch ($event) {
	   
	     case 'cmpadditem'     : $this->cmpadd(); break;
		 case 'cmpdelitem'     : $this->cmprem(); break;	   
		 
	     case 'wsadditem'     : $this->add(); break;
		 case 'wsdelitem'     : $this->rem(); break;
		 default              : //shwishlist::event($event);						
	   }
    }
   
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
	
	function getWSLists() {
        $db = GetGlobal('db');
        $UserName = GetGlobal('UserName');	
	    $name = $UserName?decode($UserName):null; 

        $sSQL = "select id,sysins,code1,pricepc,price2,sysins,itmname,itmfname,uniname1,uniname2,active,code4," .
	            "price0,price1,cat0,cat1,cat2,cat3,cat4,itmdescr,itmfdescr,itmremark,ypoloipo1,resources,".
				$this->getmapf('code').
				$lastprice .
				" from products, wishlist";
		$sSQL .= " WHERE ";					
		$sSQL .= $this->getmapf('code'). "= wishlist.tid and cid=" . $db->qstr($name);
		$sSQL .= "and listname='wishlist' order by wishlist.recid DESC";	
		//echo $sSQL;
		$this->result = $db->Execute($sSQL,2);
	    //print_r ($res->fields[5]);
		
		$out = $this->list_katalog(null,null,'fpkatalog-wishlist.htm',null,1,null,1);		
		//$out = 'test';
		return ($out);
		
		/*NOT USED*/
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

	    $sSQL = "select tid from wishlist where cid=" . $db->qstr($name) . 
		        "and listname='wishlist' order by recid DESC";	
	    $res = $db->Execute($sSQL,2);		
		//echo $sSQL;
		$i=0;
	    if (!empty($res)) { 
		
	        foreach ($res as $n=>$rec) {
				$i+=1;		
				//echo $tfile2,'<br/>';
				$code = $rec['tid'];
				$item = $this->item_var(null,$code,1,1);
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
		
        $sSQL = "select id,sysins,code1,pricepc,price2,sysins,itmname,itmfname,uniname1,uniname2,active,code4," .
	            "price0,price1,cat0,cat1,cat2,cat3,cat4,itmdescr,itmfdescr,itmremark,ypoloipo1,resources,".
				$this->getmapf('code').
				$lastprice .
				" from products, wishlist";
		$sSQL .= " WHERE ";					
		$sSQL .= $this->getmapf('code'). "= wishlist.tid and cid=" . $db->qstr($name);
		$sSQL .= "and listname='compare' order by wishlist.recid DESC";	
		//echo $sSQL;
		$this->result = $db->Execute($sSQL,2);
	    //print_r ($res->fields[5]);
		
		$out = $this->list_katalog(null,null,'fpkatalog-compare.htm',null,1,null,1);		
		//$out = 'test';
		return ($out);
	   
	    /*NOT USED TABLE VIEW ?*/
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

	function getpage($array,$id){
	
	   if (count($array)>0) {
         //while(list ($num, $data) = each ($array)) {
         foreach ($array as $num => $data) {
		    $msplit = explode(";",$data);
			if ($msplit[1]==$id) return floor(($num+1) / $this->pagenum)+1;
		 }	  
		 
		 return 1;
	   }	 
	}

    function browse($packdata,$view) {
	
	   $data = explode("||",$packdata); //print_r($data);
	
       $out = $this->view_ws($data[0],$data[1],$data[2],$data[3],$data[4]);//,$data[5]);

	   return ($out);
	}		
	
    function view_ws($id,$did,$ddate,$dtime,$status) {
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
}
else die("SHKATALOGMEDIA DPC REQUIRED!");
?>