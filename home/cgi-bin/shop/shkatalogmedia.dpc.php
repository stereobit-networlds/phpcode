<?php
$__DPCSEC['SHKATALOGMEDIA_DPC']='1;1;1;1;1;1;2;2;9';

if ( (!defined("SHKATALOGMEDIA_DPC")) && (seclevel('SHKATALOGMEDIA_DPC',decode(GetSessionParam('UserSecID')))) ) {

define("SHKATALOGMEDIA_DPC",true);

$__DPC['SHKATALOGMEDIA_DPC'] = 'shkatalogmedia';

$d = GetGlobal('controller')->require_dpc('shop/shkatalog.dpc.php');
require_once($d);

$e = GetGlobal('controller')->require_dpc('shell/pxml.lib.php');
require_once($e);

GetGlobal('controller')->get_parent('SHKATALOG_DPC','SHKATALOGMEDIA_DPC');

$__EVENTS['SHKATALOGMEDIA_DPC'][96]='sitemap';
$__EVENTS['SHKATALOGMEDIA_DPC'][97]='feed';
$__EVENTS['SHKATALOGMEDIA_DPC'][98]='showimage';
$__EVENTS['SHKATALOGMEDIA_DPC'][99]='shkatalogmedia';

$__ACTIONS['SHKATALOGMEDIA_DPC'][96]='sitemap';
$__ACTIONS['SHKATALOGMEDIA_DPC'][97]='feed';
$__ACTIONS['SHKATALOGMEDIA_DPC'][98]='showimage';
$__ACTIONS['SHKATALOGMEDIA_DPC'][99]='shkatalogmedia';

$__LOCALE['SHKATALOGMEDIA_DPC'][0]='SHKATALOGMEDIA_DPC;Catalogue;Καταλογος';
$__LOCALE['SHKATALOGMEDIA_DPC'][1]='pcs;pcs;τμχ';
$__LOCALE['SHKATALOGMEDIA_DPC'][2]='_array;Table;Ομάδα';
$__LOCALE['SHKATALOGMEDIA_DPC'][3]='_next;Next;Εμπρος';
$__LOCALE['SHKATALOGMEDIA_DPC'][4]='_prev;Prev;Πίσω';
$__LOCALE['SHKATALOGMEDIA_DPC'][5]='_recent;Recent;Πρόσφατα';
$__LOCALE['SHKATALOGMEDIA_DPC'][6]='_popular;Popular;Προτεινόμενα';
$__LOCALE['SHKATALOGMEDIA_DPC'][7]='_AVAILABILITY;Availability;Διαθεσιμότητα';
$__LOCALE['SHKATALOGMEDIA_DPC'][8]='_WEIGHT;Weight;Βάρος';
$__LOCALE['SHKATALOGMEDIA_DPC'][9]='_VOLUME;Volume;Όγκος';
$__LOCALE['SHKATALOGMEDIA_DPC'][10]='_DIMENSIONS;Dimensions;Διαστάσεις';
$__LOCALE['SHKATALOGMEDIA_DPC'][11]='_SIZE;Size;Μέγεθος';
$__LOCALE['SHKATALOGMEDIA_DPC'][12]='_COLOR;Color;Χρώμα';
$__LOCALE['SHKATALOGMEDIA_DPC'][13]='_DESCRIPTION;Description;Περιγραφή';
$__LOCALE['SHKATALOGMEDIA_DPC'][14]='_ADDITIONALINFO;Additional Informations;Πληροφορίες';
$__LOCALE['SHKATALOGMEDIA_DPC'][15]='_REVIEWS;Reviews;Αναφορές';
$__LOCALE['SHKATALOGMEDIA_DPC'][16]='_WITHTAX;with tax;με ΦΠΑ';
$__LOCALE['SHKATALOGMEDIA_DPC'][17]='_NOTAX;net value;χωρίς ΦΠΑ';

class shkatalogmedia extends shkatalog {

    var $title;
	var $resource, $xmax, $ymax, $allow_show_resource;
	var $url;
	var $onlyincategory;
	var $oneitemlist, $my_one_item;
	var $photodb;
	var $encoding, $feed_on;
	var $noloadjslightbox, $additional_files_perline;
	var $notreebrowser, $encodeimageid, $default_pager;
	var $asceding_class, $nav_on;
	var $pager_current_class;
	var $orderid, $sortdef, $bypass_order_list;

	function shkatalogmedia() {

	  shkatalog::shkatalog();
	  
	  //$this->url = paramload('SHELL','url');
	  $murl = arrayload('SHELL','ip');
      $this->url = $murl[0]; 

      $char_set  = arrayload('SHELL','char_set');	  
      $charset  = paramload('SHELL','charset');	  		
	  if (($charset=='utf-8') || ($charset=='utf8'))
	    $this->encoding = 'utf8';//must be utf8 not utf-8
	  else  
	    $this->encoding = $char_set[getlocal()]; 	  

      $this->title = localize('SHKATALOGMEDIA_DPC',getlocal());
	  $this->resource = array();
	  
      $fpresaddsize = remote_paramload('SHKATALOGMEDIA','fpresaddsize',$this->path);		  	  
	  $this->fprsize = $fpresaddsize?$fpresaddsize:1;
	  
	  $this->restype = $rt?$rt:$this->restype;	 //parent restype when no additional files....	  
	  
	  $rt = remote_arrayload('SHKATALOGMEDIA','restype',$this->path);
	  $rd = array('.jpg','.png','.swf','.pdf','.exe','.zip');
	  $this->advrestype = $rt?$rt:$rd;	 //advanced retypes to support multiple files as .png .swf ....
	  
	  //choose resource size..pre-select to make resources at event (gadget_js->make_swfobjects)
	  if ((GetReq('t'))=='klist') {//list
	    $this->xmax = $this->imagex; 
		$this->ymax = $this->imagey;
		$this->allow_show_resource = true;
	  }	
      elseif ((GetReq('t'))=='kshow') {//one item		
	    $this->xmax = $this->itemimagex ; 
		$this->ymax = $this->itemimagey ;	  
		$this->allow_show_resource = true;//false		
	  }	
	  else {//fp	  
	    $this->xmax = $this->imagex+$this->fprsize; 
		$this->ymax = $this->imagey+$this->fprsize;
		$this->allow_show_resource = true;		
	  }	
	  
	  $this->gadgets_js(); //without sql results..only js loading
	  $this->onlyincategory = remote_paramload('SHKATALOGMEDIA','onlyincategory',$this->path);	
	  $this->oneitemlist = remote_paramload('SHKATALOGMEDIA','oneitemlist',$this->path);
	  $this->photodb = remote_paramload('SHKATALOGMEDIA','photodb',$this->path);
	  
	  $this->my_one_item = null;
	  $this->feed_on = remote_paramload('SHKATALOGMEDIA','feed',$this->path);
	  
	  $adfperline = remote_paramload('SHKATALOGMEDIA','addfilesperline',$this->path);
	  $this->additional_files_perline = $adfperline ? $adfperline : null;	//3
      $this->externaljslightbox = remote_paramload('SHKATALOGMEDIA','externaljslightbox',$this->path);		  
	  $this->externalxmllinks = remote_paramload('SHKATALOGMEDIA','externalxmllinks',$this->path);
	  
	  $this->notreebrowser = remote_paramload('SHKATALOGMEDIA','notreebrowser',$this->path);
	  $this->encodeimageid = remote_paramload('SHKATALOGMEDIA','encodeimageid',$this->path);
	  
	  //def pager
	  $this->default_pager = remote_paramload('SHKATALOG','pager',$this->path);	 
	  //asc class
	  $aclass = remote_paramload('SHKATALOGMEDIA','ascedingclass',$this->path);
      $this->asceding_class = $aclass ? $aclass : 'myf_select_small';	  
	  //internal category navigation
	  $this->nav = remote_paramload('SHKATALOGMEDIA','catnav',$this->path);
	  
	  $pagecurrentclass = remote_paramload('SHKATALOGMEDIA','pagecurrentclass',$this->path);
	  $this->pager_current_class = $pagecurrentclass ? $pagecurrentclass : ' class="current"';
	  
	  $sort = remote_paramload('SHKATALOGMEDIA','sortdef',$this->path);  
	  //$this->sortdef = $sort ? $sort : 'ASC';	  
	  $asc = GetReq('asc')?GetReq('asc'):GetSessionParam('asc');
	  switch ($asc) {
	    case 1  : $this->sortdef = 'ASC'; break;
		case 2  : $this->sortdef = 'DESC'; break;
	    default : $this->sortdef = $sort ? $sort : 'ASC';
	  }		  
	  
	  $oid = remote_paramload('SHKATALOGMEDIA','orderid',$this->path);
	  $this->orderid = $oid ? $oid : 'orderid '.$this->sortdef;	  	  
	  
	  $bpsl = remote_paramload('SHKATALOGMEDIA','bypasssortlist',$this->path);
	  $this->bypass_order_list = $bpsl ? true : false;		  
    }
	
	function event($event=null) {
	
	    switch ($event) {
		
		  case 'sitemap'       : 
								 if ($dpc = GetReq('dpc')) {//special phpdac page..read
								   $dpccmd = str_replace(',','+',$dpc);	
                                   //echo '>',$dpccmd; 								   
								   GetGlobal('controller')->calldpc_method($dpccmd);		  
								 }  
		                      
								 $xml = $this->sitemap_feed(true);
								 die($xml);	//xml output
		                         break;		
		
		  case 'feed'          : if (GetReq('id'))
		                           $this->read_item();
								 elseif (GetReq('cat'))  
		                           $this->read_list();
								 else {//special phpdac page..read
								   $dpccmd = str_replace(',','+',GetReq('dpc'));	
                                   //echo '>',$dpccmd; 								   
								   GetGlobal('controller')->calldpc_method($dpccmd);		  
								 }  
								 $xml = $this->katalog_feed();
								 die($xml);	//xml output
		                         break;
		  //cart override
	      case 'addtocart'     : 
		  case 'removefromcart': 	                         
		                         break;		
		
		  case 'showimage'    : $this->show_photodb(GetReq('id'), GetReq('type'));
		                        //$id = GetGlobal('controller')->calldpc_var('shtags.tagitem');
		                        //$this->show_photodb($id, GetReq('type'));

		
		  case 'klist'        : $this->my_one_item = $this->read_list(); //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!1 moved in func
		                        $this->lightbox_js();
		                        GetGlobal('controller')->calldpc_method("rcvstats.update_category_statistics use ".GetReq('cat'));		  
		                        break;	

		  case 'kshow'        : $this->read_item($this->direction); 
		                        $this->lightbox_js();
		  		                //update statistics
	                            GetGlobal('controller')->calldpc_method("rcvstats.update_item_statistics use ".GetReq('id'));
                                break;
								
		  default             : //$this->gadgets_js();
		                        shkatalog::event($event);
		}			
    }	
	
	function action($action=null) {

	    switch ($action) {
		
		  case 'sitemap'       :
		  case 'feed'          :
		                         break;		
		
		  //cart override
	      case 'addtocart'     :
		  case 'removefromcart'://???carthandler
		                        if (($this->carthandler) || (GetSessionParam('fastpick')=='on')) {
		                          //$out .= $this->list_katalog(0);
								  
								  //$mycat = GetReq('cat');
								  //$out .= $this->show_kategory_items($mycat,1000);
								  
								  /*$myctitle = GetReq('ctitle')?GetReq('ctitle'):localize('_items',getlocal());
								  if (($cat) && ($cat{0}!='-'))
									$out = $this->tree_navigation('klist','',1);  
								  else
									$out = setNavigator($this->title,$myctitle);								  
								  */
								  /*if ($id=GetReq('id')) {
								    //event
									$this->read_item($this->direction); 
									$this->lightbox_js();								  
									//action
								    $out .= $this->show_item();
								  }
								  else*/if ($cat=GetReq('cat')) {
								    //event
									$this->my_one_item = $this->read_list(); //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!1 moved in func
									$this->lightbox_js();									  
									//action
									$out .= $this->tree_browser();							
									$out .= $this->list_katalog(0);											
								  }
								  else
								    $out = $this->default_action();
								}  
								else
								  $out = GetGlobal('controller')->calldpc_method("shcart.cartview");   
		                        break;			
		
		  case 'klist'        : $myctitle = GetReq('ctitle')?GetReq('ctitle'):localize('_items',getlocal());
		                        if (($c=GetReq('cat')) && ($c{0}!='-'))
		                          $out = $this->nav ? $this->tree_navigation('klist','',1) : null;  
		                        else
		                          $out = $this->nav ? setNavigator($this->title,$myctitle) : null;	
								  
								//banner up  
								if (in_array('beforeitemslist',$this->catbanner))//before
								  $out .= $this->show_category_banner();									  
								  
		                        //cat as items
								$out .= $this->nav ? $this->tree_browser() : null;
								//items  								
		                        $out .= $this->list_katalog(0);		
								
								//banner down
								if (in_array('afteritemslist',$this->catbanner))//after
								  $out .= $this->show_category_banner();														 
								break;

		  case 'kshow'        : $myctitle = GetReq('ctitle')?GetReq('ctitle'):localize('_items',getlocal());
		                        if (($c=GetReq('cat')) && ($c{0}!='-'))
		                          $out = $this->nav ? $this->tree_navigation('klist','',1) : null;  
		                        else
		                          $out = $this->nav ? setNavigator($this->title,$myctitle) : null;
								  
		  						if (in_array('beforeitem',$this->catbanner))
		                          $out .= $this->show_category_banner();	
								  
		                        $out .= $this->show_item();
								
								if (in_array('afteritem',$this->catbanner))
		                          $out .= $this->show_category_banner();	
		                        break;									
		  
		  default             : //echo $action,'>';
		                        if ($action=='katalog')
		                            $out .= $this->default_action();
			                    else 
									$out .= shkatalog::action($action);		
		                         
		  
		}	
		
		return ($out);
    }	
	
	protected function default_action() {
	    $db = GetGlobal('db');	
		$order = GetReq('order')?GetReq('order'):GetSessionParam('order');
		$asc = GetReq('asc')?GetReq('asc'):GetSessionParam('asc');
		$page = GetReq('page')?GetReq('page'):0;	
		
        $sSQL = "select id,sysins,code1,pricepc,price2,sysins,itmname,itmfname,uniname1,uniname2,active,code4," .// from abcproducts";// .
	            "price0,price1,cat0,cat1,cat2,cat3,cat4,itmdescr,itmfdescr,itmremark,ypoloipo1,".$this->getmapf('code')." from products ";
		$sSQL .= " WHERE itmactive>0 and active>0";			 
		//$sSQL .= ' ORDER BY';
		$itmnamesort = $this->bypass_order_list ? null : ",".$itmname;
		$sSQL .= " ORDER BY ". "{$this->orderid}";
		  
		switch ($order) {
		    case 1  : $sSQL .= $this->bypass_order_list ? null : ','.$itmname; break;
		    case 2  : $sSQL .= $this->bypass_order_list ? null : ','.'price0';break;  
		    case 3  : $sSQL .= $this->bypass_order_list ? null : ','.$this->getmapf('code'); break;//must be converted to the text equal????
		    case 4  : $sSQL .= $this->bypass_order_list ? null : ','.'cat0';break;			
		    case 5  : $sSQL .= $this->bypass_order_list ? null : ','.'cat1';break;
		    case 6  : $sSQL .= $this->bypass_order_list ? null : ','.'cat2';break;			
		    case 9  : $sSQL .= $this->bypass_order_list ? null : ','.'cat3';break;						
		    default : $sSQL .= $this->bypass_order_list ? null : ','.$this->get_order();
		}
		
        /*		
		switch ($asc) {
		    case 1  : $sSQL .= ' ASC'; break;
		    case 2  : $sSQL .= ' DESC';break;
		    default : $sSQL .= " {$this->sortdef}";//$this->get_asc();//' ASC';
		}*/
		$sSQL .= $this->bypass_order_list ? null : " {$this->sortdef}";

		/*if ($this->pager) {
		    $p = $page * $this->pager;
		    $sSQL .= " LIMIT $p,".$this->pager; //page element count
		}
		else*/
			$sSQL .= " LIMIT 100";
								 
	    $this->result = $db->Execute($sSQL,2);
		$this->max_items = $db->Affected_Rows();
	    $this->max_selection = $this->get_max_result();								
        //echo $sSQL;
		//print_r($resultset);

		//$out .= $this->show_category_banner(); 
				
		//$out .= 'a'.$this->tree_navigation('klist');
		//$out .= 'b'.$this->show_menu('klist',1,0,'PRODUCTS'.$this->cseparator.'WOL','title',1);
		
		$group = null;//'WOL';
		$out .= $this->show_submenu('klist',1,$group,null,1);
			
		if (!$this->onlyincategory) 
		    $out .= $this->list_katalog(0);//null,'katalog',null,null,1); 
		
/*
	    if ($showasc) 
	        $out .= $this->show_asceding($cmd,null,$this->asceding_class,$nopager);
			
		if ($this->pager) 
		  $out .= $this->show_paging($cmd,$mytemplate,$nopager);					
		
	    if ((count($this->result)>0) && ($no_additional_info==null))   
	      $out .= $this->show_availabillity_table(null,1);	   
	
	    //echo '<pre>'; print_r($this->resource); echo '</pre>';
	   
	    if ($resources) 
		  $out .= $this->make_swfobjects($this->result,$this->xmax,$this->ymax);		  	   		   
*/		  

        //feed links
	    $out .= $this->get_xml_links();
		
		return ($out);
	}
	
	//override handle cat/sub cat navigation
	function tree_browser() {
	  $cat = GetReq('cat'); 
	  $out = null;
	  
	  if ($this->notreebrowser)
	      return null;
	  
	  //echo 'z';
	  //$tbrowse = $this->treebrowser;
	  //$tvtype = $this->treeviewtype;	

	  //$mytemplate = $this->select_template('fptreetable');	  
	  
	  //$out = $this->show_menu('klist',1,0,$cat,null,1); //tree view
//	  $out = $this->show_submenu('klist',1);  //submenu only
	  //$out = $this->show_navigator('klist'); //nav only	..empty
	  
	  //table generation
	  /*$subcat = $this->show_submenu('klist',1);  //submenu only
	  if ($subcat) {
		$categories = explode('<SPLIT/>',$subcat); //<li> split..
		$out = $this->make_table($categories, $this->linemax, 'fptreetable');  	  
	  }*/
	  //include in func...
	  $out = $this->show_submenu('klist',1,null,null,1);  //submenu only
	  
	  return ($out);
	  
	}	
	
	//override DISABLED
	function lightbox_js() {
	
        /*if ((iniload('JAVASCRIPT')) && ($this->lightbox) && (!$this->externaljslightbox)) {	
		  
	      //$code = $this->make_swfobjects($this->result,$this->xmax,$this->ymax); //no need..called in list
		  
		  $js = new jscript;
		  
		  $js->load_js("lightbox/prototype.js");	      		      
		  $js->load_js("lightbox/scriptaculous.js?load=effects,builder");
		  $js->load_js("lightbox/lightbox.js");		  		  
		  $js->load_js("swfobject/swfobject.js");	      		      	  		  
          //$js->load_js($code,null,1);		   			   
		  unset ($js);
	    }*/		
	}	
	
	//called from constructor for func call at fp..always DISABLED
	function gadgets_js() {
	
        /*if (iniload('JAVASCRIPT'))  {	
		
	      //$code = $this->make_swfobjects($this->xmax,$this->ymax); //no need..called in lists
		  
		  $js = new jscript;  
		  $js->load_js("swfobject/swfobject.js");	      		      	  		  
          //$js->load_js($code,null,1);		   			   
		  unset ($js);
	    }*/		
	}
	
	function getiteminfo($id) {
	
       $ret = $this->read_item(null,$id);
	   return ($ret);	
	}
	
	//DISABLED
	function make_resource_table($id,$resource=null) {
	   //echo $resource;
	   /*if ($rs = $resource) {
	     $mres = explode(';',$rs);
		 //print_r($mres);
		 foreach ($mres as $r) {
		   $myr = explode(':>>',$r);
		   //print_r($myr);
		   $resource_table[$myr[0]] = urlencode($myr[1]);
		 }
		   
	     $this->resource[$id] = (array) $resource_table;
		 //print_r($this->resource[$id]);
	   }*/  
	} 
	
	function get_resource($id,$source=null) {
	
	  switch ($source) {
	    case 'http'    : $ret = $this->resource[$id]['http']; break;
	    case 'mpeg'    : $ret = $this->resource[$id]['mpeg']; break;			
	    case 'mp3'     : $ret = $this->resource[$id]['mp3']; break;			
	    case 'avi'     : $ret = $this->resource[$id]['avi']; break;			
	    case 'swf'     : $ret = urldecode($this->resource[$id]['swf']); break;		
	    case 'embed'   : $ret = urldecode($this->resource[$id]['embed']); break;			
	    default        : $ret = $this->resource[$id][0];
	  }
	  
	  return ($ret);   
	}	  		
	
	
	//swf object selected from db DISABLED
	function make_swfobjects($dbres=null,$x=null,$y=null) {
/*	  $myx = $x?$x:'300';
	  $myy = $y?$y:'120';*/
/*
swfobject.embedSWF(swfUrl, id, width, height, version, expressInstallSwfurl, flashvars, params, attributes, callbackFn) has five required and five optional arguments: 
swfUrl (String, required) specifies the URL of your SWF 
id (String, required) specifies the id of the HTML element (containing your alternative content) you would like to have replaced by your Flash content 
width (String, required) specifies the width of your SWF 
height (String, required) specifies the height of your SWF 
version (String, required) specifies the Flash player version your SWF is published for (format is: "major.minor.release" or "major") 
expressInstallSwfurl (String, optional) specifies the URL of your express install SWF and activates Adobe express install. Please note that express install will only fire once (the first time that it is invoked), that it is only supported by Flash Player 6.0.65 or higher on Win or Mac platforms, and that it requires a minimal SWF size of 310x137px. 
flashvars (Object, optional) specifies your flashvars with name:value pairs 
params (Object, optional) specifies your nested object element params with name:value pairs 
attributes (Object, optional) specifies your object's attributes with name:value pairs 
callbackFn (JavaScript function, optional) can be used to define a callback function that is called on both success or failure of embedding a SWF file (see API documentation) 
*/	
      //print_r($dbres);
      //if (($dbres->sql) && (count($dbres)>0)) {	
/*	  if (!empty($dbres)) {
	    //foreach id....items
	    foreach ($dbres as $n=>$rec) { 
		
		  $id = $rec[$this->getmapf('code')];
		  
	      if ($source = $this->get_resource($id,'swf')) {
		    //$source = "http://tutorials.hostmonster.com/flash/HM_autoresponder_demo_skin.swf"; //test override source
            $ret .= "swfobject.embedSWF(\"$source\", \"$id\", \"$myx\", \"$myy\", \"9.0.0\"); 
";
		  }	
		}
      }  		
      //echo $ret;
	  return ("<script language='javascript'>" . $ret . "</script>");*/
	
	}
	
	//swf object from local filesystem
	function make_local_swfobjects($res=null,$x=null,$y=null) {
	  /*$myx = $x?$x:'300';
	  $myy = $y?$y:'120';
	  
	  if (!empty($res)) {
	     foreach ($res as $id=>$rswf) {
		    //$rswf = "http://tutorials.hostmonster.com/flash/HM_autoresponder_demo_skin.swf"; //test override source
            $ret .= "swfobject.embedSWF(\"$rswf\", \"$id\", \"$myx\", \"$myy\", \"9.0.0\"); 
";
         }
      }  		
      //echo $ret;
	  return ("<script language='javascript'>" . $ret . "</script>");
	  */
	}	
	
	//DISABLED
	function show_swfobject($id,$content=null,$x=null,$y=null) {
	
	  /*$myaltcontent = $content?$content:"<p>Alternative content</p>";
	  //echo $myaltcontent;
	
	  //embed with js
      $ret = "<div id=\"$id\">" . $myaltcontent . "</div>";

      return ($ret);*/
	}
	
	function show_pdfobject($id,$content=null,$x=null,$y=null) {
	  $cat = GetReq('cat');	
	  //$cat = GetGlobal('controller')->calldpc_var('shtags.tagcat');
	  $addfx = $this->addfx?$this->addfx:100;
	  $addfy = $this->addfy?$this->addfy:null;	
	  $pdf_icon = '/images/icon_pdf.png';	
	  $icon = "<img src=\"" . $pdf_icon . "\"  width=\"$addfx\"";
	  $icon.= $addfy ? "height=\"$addfy\"":null; 
	  $icon.= "border=\"0\" alt=\"". localize('_PDF',getlocal()) . "\">";  
	
	  if (defined('SHDOWNLOAD_DPC')) {
	    if (GetGlobal('controller')->calldpc_var("shdownload.direct"))
		  $ret = seturl("t=download&cat=$cat&id=".$id,$icon);//???? to be direct link 
		else  
	      $ret = seturl("t=download&cat=$cat&id=".$id,$icon);
	  }
	  else {
	    //$ret = 'pdf'.$id; 
		
		$pdf_file = $this->imgpath . $id . '.pdf';					 
		$ret = "<A href=\"$pdf_file\">" . $icon . "</A>";
			 
	  }	
	  
      return ($ret);
	}
	
	function show_exeobject($id,$content=null,$x=null,$y=null,$ct='.exe') {
	  $cat = GetReq('cat');
	  //$cat = GetGlobal('controller')->calldpc_var('shtags.tagcat');
	  $addfx = $this->addfx?$this->addfx:100;
	  $addfy = $this->addfy?$this->addfy:null;	
	  $exe_icon = '/images/icon_exe.png';	
	  $icon = "<img src=\"" . $exe_icon . "\"  width=\"$addfx\"";
	  $icon.= $addfy ? "height=\"$addfy\"":null; 
	  $icon.= "border=\"0\" alt=\"". localize('_EXE',getlocal()) . "\">";  
		  
	
	  if (defined('SHDOWNLOAD_DPC')) {	
	    if (GetGlobal('controller')->calldpc_var("shdownload.direct"))
		  $ret = seturl("t=download&cat=$cat&id=".$id,$icon);//???? to be direct link 
		else  
	      $ret = seturl("t=download&cat=$cat&id=".$id,$icon);
	  }
	  else {
	    //$ret = $ct.$id;	
		
		$exefile = $this->imgpath . $id . '.exe';					 
		$ret = "<A href=\"$exe_file\">" . $icon . "</A>";		
	  }	

      return ($ret);
	}	
	
	//override
	function do_quick_search($text2find,$incategory=null) {
        $db = GetGlobal('db');	
		$page = GetReq('page')?GetReq('page'):0;
	    $asc = GetReq('asc')?GetReq('asc'):GetSessionParam('asc');
	    $order = GetReq('order')?GetReq('order'):GetSessionParam('order');		
		$stype = GetParam('searchtype'); //echo $stype;
		$scase = GetParam('searchcase'); //echo $scase;
		
		//$incategory = $incategory ? $incategory : GetGlobal('controller')->calldpc_var('shtags.tagcat');//!!!!!NO RESULT
		$incategory = $incategory?$incategory:GetReq('cat');		
		
	    $lan = getlocal();
	    $itmname = $lan?'itmname':'itmfname';
	    $itmdescr = $lan?'itmdescr':'itmfdescr';						
	  
	    $dataerror = null;	
		
		$lastprice = $this->getmapf('lastprice')?','.$this->getmapf('lastprice'):null;	
		
		if ($text2find) {
		
		  $parts = explode(" ",$text2find);//get special words in text like code:  
	
	      $sSQL = "select id,sysins,code1,pricepc,price2,sysins,itmname,itmfname,uniname1,uniname2,active,code4," .// from abcproducts";// .
	            "price0,price1,cat0,cat1,cat2,cat3,cat4,itmdescr,itmfdescr,itmremark,ypoloipo1,".
				$this->getmapf('code').
				$lastprice .
				" from products ";
		  	
		  $sSQL .= " where ";
		  
		  switch ($parts[0]) {
		  
		    case 'code:' :  $sSQL .= " ( ".$this->getmapf('code')." like '%" . $this->decodeit($parts[1]) . "%')";
			                break;
		  
		  default://normal search
		  
		    if (defined("SHNSEARCH_DPC")) {
              $sSQL .= '('. GetGlobal('controller')->calldpc_method('shnsearch.findsql use '.$text2find.'+'.$this->getmapf('code').'<@>'.$itmname.'<@>'.$itmdescr.'<@>itmremark++'.$stype.'+'.$scase);		  
            }
			else { 			  	
	          $sSQL .= '(' . " ( $itmname like '%" . strtolower($text2find) . "%' or " .
		               " $itmname like '%" . strtoupper($text2find) . "%')";	
		      $sSQL .= " or ";		   
	          $sSQL .= " ( $itmdescr like '%" . strtolower($text2find) . "%' or " .
		               " $itmdescr like '%" . strtoupper($text2find) . "%')";				 
		      $sSQL .= " or ";		   
	          $sSQL .= " ( itmremark like '%" . strtolower($text2find) . "%' or " .
		               " itmremark like '%" . strtoupper($text2find) . "%')";				 					 
		      $sSQL .= " or ";		   			 
	          $sSQL .= " ( ".$this->getmapf('code')." like '%" . strtolower($text2find) . "%' or " .
		               " ".$this->getmapf('code')." like '%" . strtoupper($text2find) . "%')";						 
		    }			   
	   				 
		  }//switch....................................................					
		  $sSQL .= ')' ;
		  
          if ($incategory) {	
		    $cats = explode($this->cseparator,$incategory);
		    foreach ($cats as $c=>$mycat)
		      $sSQL .= ' and cat'.$c ." ='" . $mycat . "'";		  	  
		  }
		   							  
		  $sSQL .= " and itmactive>0 and active>0";	
		  $search_sql = $sSQL;	
		  $itmnamesort = $this->bypass_order_list ? null : ",".$itmname;
		  $sSQL .= " ORDER BY ". "{$this->orderid}";			  
		  
		  switch ($order) {
		    case 1  : $sSQL .= $this->bypass_order_list ? null : ','.$itmname; break;
			case 2  : $sSQL .= $this->bypass_order_list ? null : ','.'price0';break;  
		    case 3  : $sSQL .= $this->bypass_order_list ? null : ','.$this->getmapf('code'); break;//must be converted to the text equal????
			case 4  : $sSQL .= $this->bypass_order_list ? null : ','.'cat1';break;			
			case 5  : $sSQL .= $this->bypass_order_list ? null : ','.'cat2';break;
			case 6  : $sSQL .= $this->bypass_order_list ? null : ','.'cat3';break;			
			case 9  : $sSQL .= $this->bypass_order_list ? null : ','.'cat4';break;						
		    default : $sSQL .= $this->bypass_order_list ? null : ','.$itmname;
		  }
		  
		  /*switch ($asc) {
		    case 1  : $sSQL .= ' ASC'; break;
			case 2  : $sSQL .= ' DESC';break;
		    default : $sSQL .= " {$this->sortdef}";
		  }*/
		  $sSQL .= $this->bypass_order_list ? null : " {$this->sortdef}";
		  
		  //LIMITED SEARCH
		  if ($this->pager) {
		    $p = $page * $this->pager;
		    $sSQL .= " LIMIT $p,".$this->pager; //page element count
		  }
		  
		  //echo $page,'>',$sSQL;		  
		  	
		  if ($dataerror==null) {
		    //echo $sSQL;		  
	        $resultset = $db->Execute($sSQL,2); 
	   	    //print_r($resultset);
	        $this->result = $resultset; 
			//print_r($this->result);
			$this->meter = $db->Affected_Rows();
			$this->max_items = $db->Affected_Rows();
	        $this->max_selection = $this->get_max_result($text2find);	
			//$this->msg = '<hr>' . $this->max_selection . ' ' . localize('_founded',getlocal());
			//echo $this->msg,'>';																		
	      }
		  else {
		    $this->msg = $dataerror;		
			//echo $dataerror;
		  }	
	   	}
	}		
	
	//override
	function get_max_result($text2find=null) {
        $db = GetGlobal('db');
		$cat = GetReq('cat');	  
	    //$cat = GetGlobal('controller')->calldpc_var('shtags.tagcat');
		if ($cat{0}=='-') {
		    $negative = true;
			$cat = substr($cat,1);//drop -
		}			
		$cat_tree = explode($this->cseparator,str_replace('_',' ',$cat));		
		$oper = $negative?' not like ':'='; 
		
	    $lan = getlocal();
	    $itmname = $lan?'itmname':'itmfname';
	    $itmdescr = $lan?'itmdescr':'itmfdescr';	
		$stype = GetParam('searchtype'); //echo $stype;
		$scase = GetParam('searchcase'); //echo $scase;					
				
		$sSQL = "select count(id) from products where ";
		
		if ($text2find) {
		
		  if (defined("SHNSEARCH_DPC")) {
              $whereClause = GetGlobal('controller')->calldpc_method('shnsearch.findsql use '.$text2find.'+'.$this->getmapf('code').'<@>'.$itmname.'<@>'.$itmdescr.'<@>itmremark++'.$stype.'+'.$scase);		  
          }
		  else {		
						  
	         $whereClause = " ( $itmname like '%" . strtolower($text2find) . "%' or " .
		               " $itmname like '%" . strtoupper($text2find) . "%')";	
		     $whereClause .= " or ";		   
	         $whereClause .= " ( $itmdescr like '%" . strtolower($text2find) . "%' or " .
		               " $itmdescr like '%" . strtoupper($text2find) . "%')";				 
		     $whereClause .= " or ";		   
	         $whereClause .= " ( itmremark like '%" . strtolower($text2find) . "%' or " .
		               " itmremark like '%" . strtoupper($text2find) . "%')";				 					 
		     $whereClause .= " or ";		   			 
	         $whereClause .= " ( ".$this->getmapf('code')." like '%" . strtolower($text2find) . "%' or " .
		               " ".$this->getmapf('code')." like '%" . strtoupper($text2find) . "%')";								  		
		  }	
		  //search in cat...				  
          if ($cat_tree[0])
			    $whereClause .= ' and cat0'.$oper . $db->qstr(/*rawurldecode*/str_replace('_',' ',$cat_tree[0]));		  
		  if ($cat_tree[1])	
		 	    $whereClause .= 'and cat1'.$oper . $db->qstr(/*rawurldecode*/str_replace('_',' ',$cat_tree[1]));		 
		  if ($cat_tree[2])	
			    $whereClause .= 'and cat2'.$oper . $db->qstr(/*rawurldecode*/str_replace('_',' ',$cat_tree[2]));		   
		  if ($cat_tree[3])	
			    $whereClause .= 'and cat3'.$oper . $db->qstr(/*rawurldecode*/str_replace('_',' ',$cat_tree[3]));
		   						  
		}
		else {//katalog page
		      	  
		     if ($cat_tree[0])
			    $whereClause .= ' cat0'.$oper . $db->qstr(/*rawurldecode*/str_replace('_',' ',$cat_tree[0]));	
			 elseif ($this->onlyincategory)
			 	$whereClause .= ' cat1=\'\' ';					  
		     if ($cat_tree[1])	
		 	    $whereClause .= ' and cat1'.$oper . $db->qstr(/*rawurldecode*/str_replace('_',' ',$cat_tree[1]));
			 elseif ($this->onlyincategory)
			 	$whereClause .= ' and cat1=\'\' ';						 
		     if ($cat_tree[2])	
			    $whereClause .= ' and cat2'.$oper . $db->qstr(/*rawurldecode*/str_replace('_',' ',$cat_tree[2]));		
			 elseif ($this->onlyincategory)
			 	$whereClause .= ' and cat2=\'\' ';				   
		     if ($cat_tree[3])	
			    $whereClause .= ' and cat3'.$oper . $db->qstr(/*rawurldecode*/str_replace('_',' ',$cat_tree[3]));
			 elseif ($this->onlyincategory)
			 	$whereClause .= ' and cat3=\'\' ';				
		   		
		}
		    
		$sSQL .= $whereClause;				 
		$sSQL .= " and itmactive>0 and active>0";
		//echo $sSQL;	 
	    $resultset = $db->Execute($sSQL,2);
		//print_r($resultset);		
 	    $this->max_cat_items = $resultset->fields[0];//$db->Affected_Rows();			 					
		
		return ($this->max_cat_items);
	}	

	function show_photodb($itmcode=null, $stype=null, $type=null) {
      $db = GetGlobal('db');
	  if (!$itmcode) return;
	  $type = $type?$type:$this->restype;
	  	  
      $sSQL = "select data,type,code from pphotos ";
	  $sSQL .= " WHERE code='" . $itmcode . "'";
	  if (isset($type))
	    $sSQL .= " and type='". $type ."'";
	  if (isset($stype))
	    $sSQL .= " and stype='". $stype ."'";		
      //echo $sSQL;
	  
	  $resultset = $db->Execute($sSQL,2);	
	  $result = $resultset;	  
	  $mime_type = 'image/'.str_replace('.','',$result->fields['type']);
	  $mime_type = 'image/jpeg';
	  //echo $mime_type;
	  header('Content-type: ' . $mime_type);

	  if ($result->fields['code']) //photo exists
        echo base64_decode($result->fields['data']);
	  else {//additional photo or standart nopic
	    echo null;
      }  
	  
	  die();
	}	
	
	//override
	function get_photo_url($code, $photosize=null) {
      $db = GetGlobal('db');
	  if (!$code) return;  
	  
	  //when we have 3 type of scale image
	  switch ($photosize) {
	       case 3  : $tpath = $this->thubpath_large; 
		             $stype = 'LARGE';
		             break;	   
	       case 2  : $tpath = $this->thubpath_medium; 
		             $stype = 'MEDIUM';
		             break;	   
	       case 1  : $tpath = $this->thubpath_small;
                     $stype = 'SMALL';		   
		             break;
	       default : $tpath = $this->thubpath;	
                     $stype = '';		   
	  }
	  
	  if ($interface = $this->photodb) {
	  
        $sSQL = "select code from pphotos ";
	    $sSQL .= " WHERE code='" . $code . "'";
	    $sSQL .= " and type='". $this->restype ."'";
	    if (isset($stype))
	      $sSQL .= " and stype='". $stype ."'";	
		//echo $sSQL;
	    $resultset = $db->Execute($sSQL,2);	
	    $result = $resultset;
      }
      else
       $result = null;	  
	   
	  if ($result->fields[0]) { 
	     //echo $code;
         if (is_numeric($interface))	  
	       $photo = seturl('t=showimage&id='.$code.'&type='.$stype);
		 else  
		   $photo = $interface . '?id='.$code.'&type='.$stype;
	  }
	  else {//ordinal image
	  
	     //if ($this->encodeimageid) //check inside func
		 $code = $this->encode_image_id($code);			  
	  
		 $pfile = $code;//sprintf("%05s",$code); //echo $pfile,"<br>";

	     $photo_file = $this->urlpath . '/' .$tpath . $pfile . $this->restype;	  
	     //echo $photo_file,'<br>'; 
	     if (!file_exists($photo_file)) {
	       $photo = $tpath . 'nopic' . $this->restype;	
		 }
	     else {
	       $photo = $tpath . $pfile . $this->restype;	
		 }  
	   }//if
	   
	   return ($photo);	 	
	}	
	
	//override
	function list_photo($code,$x=100,$y=null,$imageclick=1,$mycat=null,$photosize=null,$clickphotosize=null,$altname=null) {
	   $page = GetReq('page')?GetReq('page'):0;		
	   $cat = $mycat?$mycat:GetReq('cat');  
	   //$cat = $mycat ? $mycat : GetGlobal('controller')->calldpc_var('shtags.tagcat');
	   $xfulldist = $this->itemfimagex?$this->itemfimagex:640;
	   $yfulldist = $this->itemfimagey?$this->itemfimagey:null; //free y 480;
	   $a_name = $altname ? $altname : $code;   
	   
	   $photo = $this->get_photo_url($code,$photosize);//define size
	   
	   if (($resource = $this->get_resource($code,'embed')) && ($this->allow_show_resource)) {
	     $xrep = str_replace('$x$',$this->xmax,$resource);
         $ret = str_replace('$y$',$this->ymax,$xrep);	   
	   }	   
	   elseif (($resource = $this->get_resource($code,'swf')) && ($this->allow_show_resource)) {
	   
	     $myresource = "<img src=\"" . $photo . "\" width=\"$x\"";
		 $myresource.= $y ? "height=\"$y\"":null;
         $myresource.= "border=\"0\" alt=\"". localize('_IMAGE',getlocal()) . "\">";
		 $mylinkedresource = seturl('t=kshow&cat='.$cat.'&id='.$code.'&page='.$page,$myresource);// . "</A>";
		 
	     $ret = $this->show_swfobject($code,$mylinkedresource);
	   }	   
	   else {
	   
	   //echo $imageclick,'<br>';	   
	   if (($imageclick==null) || ((is_numeric($imageclick)) && ($imageclick>=0))) {
	    
	     if ($imageclick==1) {//phot url	
	   
           $clickphoto = $clickphotosize?$this->get_photo_url($code,$clickphotosize):
		                                 $this->get_photo_url($code,$photosize);
		   
           if (iniload('JAVASCRIPT')) {	
				   
		     if ($this->lightbox) {
                $plink = "<A href=\"$clickphoto\" rel='lightbox[$code]' title='$a_name'>";			 
			 }
			 else {
  	           $plink = "<a href=\"#\" ";	   
	           //call javascript for opening a new browser win for the img		   
	           //$params = $photo . ";Image;width=300,height=200;";
	           $params = "$clickphoto;$xfulldist;$yfulldist;<B>$title</B><br>$descr;";			 

			   $js = new jscript;
	           $plink .= $js->JS_function("js_popimage",$params); 
			   unset ($js); 

	           $plink .= ">";
			 }
	       }
	       else
             $plink = "<A href=\"$photo\">";

			$lo = "<img src=\"" . $photo . "\" width=\"$x\"";
 			$lo.= $y ? "height=\"$y\"" : null; 
			$lo.= "border=\"0\" alt=\"$a_name". localize('_IMAGE',getlocal()) . "\">" . "</A>"; 
	        $ret = $plink . $lo;
		  }
		  elseif ($imageclick==2) {//product url
		  
            $myresource = "<img src=\"" . $photo . "\" width=\"$x\"";
 			$myresource.= $y ? "height=\"$y\"" : null;
			$myresource.= "border=\"0\" alt=\"$a_name". localize('_IMAGE',getlocal()) . "\">";
		  
		    $purl = seturl("t=kshow"."&cat=".$cat."&id=".$code,null,null,null,null,$this->rewrite); 
		    $plink = "<A href=\"$purl\">";
            $ret = $plink . $myresource . "</A>";           
		  }
		  elseif ($imageclick==0) {//item link
		  
		    $myresource = "<img src=\"" . $photo . "\" width=\"$x\"";
			$myresource.= $y ? "height=\"$y\"" : null;
			$myresource.= "border=\"0\" alt=\"$a_name". localize('_IMAGE',getlocal()) . "\">";
		    $ret = seturl('t=kshow&cat='.$cat.'&page='.$page.'&id='.$code,$myresource,null,null,null,$this->rewrite);// . "</A>";
		  } 
		  else {//item link
		  
            $myresource = "<img src=\"" . $photo . "\" width=\"$x\"";
			$myresource.= $y ? "height=\"$y\"" : null;
			$myresource.= "border=\"0\" alt=\"$a_name". localize('_IMAGE',getlocal()) . "\">";		  
		    $ret = seturl('t=kshow&cat='.$cat.'&page='.$page.'&id='.$code,$myresource,null,null,null,$this->rewrite);// . "</A>";
		  } 
		}
		else {
		  $plink = "<A href=\"$imageclick\">";
          $ret = $plink . "<img src=\"" . $photo . "\" width=\"$x\" height=\"$y\" border=\"0\" " . "></A>";           		
	    } 	   		
	    }//resource
		
	    return ($ret);
	}				
	
	//override
	function read_list() {
        $db = GetGlobal('db');	
	    $asc = GetReq('asc')?GetReq('asc'):GetSessionParam('asc');
	    $order = GetReq('order')?GetReq('order'):GetSessionParam('order');	
		$page = GetReq('page')?GetReq('page'):0;
		$negative = false;
	    $lan = getlocal();
	    $mylan = $lan?$lan:'0';
	    $itmname = $mylan?'itmname':'itmfname';
	    $itmdescr = $mylan?'itmdescr':'itmfdescr';	
        $lastprice = $this->getmapf('lastprice')?','.$this->getmapf('lastprice'):null;			
	   
	    if ($this->usetablelocales)
	      $f = $mylan; 
	    else
	      $f = null;		
		

		$cat = GetReq('cat');	
        //$cat = GetGlobal('controller')->calldpc_var('shtags.tagcat');	//?????
		
		if ($cat{0}=='-') {
		    $negative = true;
			$cat = substr($cat,1);//drop -
		}	 
		
		//echo $negative,'>';
		
		$oper = $negative?' not like ':'='; 			
		
		if ($cat!=null) {		   
		  
		  $cat_tree = explode($this->cseparator,str_replace('_',' ',$cat)); 
			
		   
	      $sSQL = "select id,sysins,code1,pricepc,price2,sysupd,itmname,itmfname,uniname1,uniname2,active,code4," .// from abcproducts";// .
	              "price0,price1,cat0,cat1,cat2,cat3,cat4,itmdescr,itmfdescr,itmremark,ypoloipo1,resources,".
				  $this->getmapf('code').
				  $lastprice . ",orderid" .
				  " from products ";
		  $sSQL .= " WHERE ";		   
		      	  
		  if ($cat_tree[0])
		    $whereClause .= ' cat0'.$oper . $db->qstr(/*rawurldecode*/str_replace('_',' ',$cat_tree[0]));		
		  elseif ($this->onlyincategory)
		 	$whereClause .= ' (cat0 IS NULL OR cat0=\'\') ';				  
		  if ($cat_tree[1])	
		    $whereClause .= ' and cat1'.$oper . $db->qstr(/*rawurldecode*/str_replace('_',' ',$cat_tree[1]));	
		  elseif ($this->onlyincategory)
			$whereClause .= ' and (cat1 IS NULL OR cat1=\'\') ';	 
		  if ($cat_tree[2])	
		    $whereClause .= ' and cat2'.$oper . $db->qstr(/*rawurldecode*/str_replace('_',' ',$cat_tree[2]));	
		  elseif ($this->onlyincategory)
			 	$whereClause .= ' and (cat2 IS NULL OR cat2=\'\') ';		   
		  if ($cat_tree[3])	
		    $whereClause .= ' and cat3'.$oper . $db->qstr(/*rawurldecode*/str_replace('_',' ',$cat_tree[3]));
		  elseif ($this->onlyincategory)
			$whereClause .= ' and (cat3 IS NULL OR cat3=\'\') ';
		   		
		    
		  $sSQL .= $whereClause;				 
		  $sSQL .= " and itmactive>0 and active>0";			   
		  $sSQL .= " ORDER BY {$this->orderid}";
		  
		  switch ($order) {
		      case 1  : $sSQL .= $this->bypass_order_list ? null : ','.$itmname; break;
			  case 2  : $sSQL .= $this->bypass_order_list ? null : ',price0';break;  
		      case 3  : $sSQL .= $this->bypass_order_list ? null : ','.$this->getmapf('code'); break;//must be converted to the text equal????
			  case 4  : $sSQL .= $this->bypass_order_list ? null : ',cat0';break;			
			  case 5  : $sSQL .= $this->bypass_order_list ? null : ',cat1';break;
			  case 6  : $sSQL .= $this->bypass_order_list ? null : ',cat2';break;			
			  case 9  : $sSQL .= $this->bypass_order_list ? null : ',cat3';break;						
		      default : $sSQL .= $this->bypass_order_list ? null : ','.$itmname;
		  }
		  
		  /*switch ($asc) {
		    case 1  : $sSQL .= ' ASC'; break;
			case 2  : $sSQL .= ' DESC';break;
		    default : $sSQL .= " {$this->sortdef}";
		  }*/
		  $sSQL .= $this->bypass_order_list ? null : " {$this->sortdef}";
		  
		  if ($this->pager) {
		    $p = $page * $this->pager;
		    $sSQL .= " LIMIT $p,".$this->pager; //page element count
		  }
			
	      //echo $sSQL;
	   
	      $resultset = $db->Execute($sSQL,2);
	      //$ret = $db->fetch_array_all($resultset);	 
		  //if ($this->usetablelocales) 
	   	    //print_r($resultset);  
	      $this->result = $resultset; 
 	      $this->max_items = $db->Affected_Rows();//count($this->result);
	      
	      if ($this->max_items==1) {
		    //echo $this->result->fields[$this->getmapf('code')];
			return ($this->result->fields[$this->getmapf('code')]); //to view the item without click on dir
		  }
		  else { 
		    //echo '>',$this->max_items;
	        $this->max_selection = $this->get_max_result();			
			return (null);
		  }	
		}
		
	}	
	
	//override
	function read_item($direction=null,$item_id=null) {
        $db = GetGlobal('db');	
		//$item = GetReq('id');	
	    if ($item_id) {
		  $item = $item_id;
		  //SetReq('id',$item_id);//for edit purposes
		  $_GET['id'] = $item_id;//for edit purposes
		  //print_r($_GET);		  
		}  
		else {	
		  $id = GetReq('id');// ? GetReq('id') : GetGlobal('controller')->calldpc_var('shtags.tagitem');//????
		  $item = GetReq('listm')?GetReq('listm'):$id;//GetReq('id');
		}  
		
		if (GetReq('cat')!=null) {
		  $cat = GetReq('cat');		
		  //$cat = GetGlobal('controller')->calldpc_var('shtags.tagcat');
		}  	
		  
        $lastprice = $this->getmapf('lastprice')?','.$this->getmapf('lastprice'):null;			  	
		
	    $sSQL = "select id,sysins,code1,pricepc,price2,sysins,itmname,itmfname,uniname1,uniname2,active,code4," .// from abcproducts";// .
	            "price0,price1,cat0,cat1,cat2,cat3,cat4,itmdescr,itmfdescr,itmremark,ypoloipo1,resources,".
				$this->getmapf('code') .
				$lastprice .				
				",weight,volume,dimensions,size,color from products ";
				
		switch ($direction) {
		
		  case 'next':
		  $next_sql = "select id from products where ".$this->getmapf('code').">";
		  $next_sql.= $this->codetype=='string'?$db->qstr($item):$item;$item;
	      //if (isset($cat)) $next_sql .= " and type=" . $db->qstr($cat);
		  //if (isset($subcat)) $next_sql .= ' and type2=' . $db->qstr($subcat);		
		  $next_sql .= " and active=1";
		  		  
	      $rset = $db->Execute($next_sql,2);
	      //$nret = $db->fetch_array($rset);	 //only one set
	      $this->list_item = $next_item = $nret[0]?$nret[0]:$item; 			  
		  $sSQL .= " WHERE ".$this->getmapf('code')."=";
		  $sSQL .= $this->codetype=='string'?$db->qstr($next_item):$next_item;
		  
		  if (($lock = $this->itemlockparam) && (!GetGlobal('UserID')))
		    $sSQL .=  ' and ' . $lock . ' is null';		  
		  break;
		  
		  case 'prev':
		  $prev_sql = "select ".$this->getmapf('code')." from products where ".$this->getmapf('code')."<";
		  $prev_sql.= $this->codetype=='string'?$db->qstr($item):$item;$item;
	      //if (isset($cat)) $prev_sql .= " and type=" . $db->qstr($cat);
		  //if (isset($subcat)) $prev_sql .= ' and type2=' . $db->qstr($subcat);		
		  $prev_sql .= " and active=1";
		  		  		  
	      $rset = $db->Execute($prev_sql,2);
	      //$nret = $db->fetch_array($rset);	 //only one set
	      $this->list_item = $prev_item = $nret[0]?$nret[0]:$item; 		  		  
		  $sSQL .= " WHERE ".$this->getmapf('code')."=";
  		  $sSQL .= $this->codetype=='string'?$db->qstr($prev_item):$prev_item;
		  
		  if (($lock = $this->itemlockparam) && (!GetGlobal('UserID')))
		    $sSQL .=  ' and ' . $lock . ' is null';		  
		  break;
		   
		  default : 
		  $sSQL .= " WHERE ".$this->getmapf('code')."=";
		  $sSQL .= $this->codetype=='string'?$db->qstr($item):$item;
		  
		  if (($lock = $this->itemlockparam) && (!GetGlobal('UserID')))
		    $sSQL .=  ' and ' . $lock . ' is null';		  
		} 	  
	   
	   $sSQL .= " LIMIT 1";
	   //echo $sSQL;
	   
	   $resultset = $db->Execute($sSQL,2);
	   //$ret = $db->fetch_array_all($resultset);	 
	   //print_r($ret);  
	   $this->result = $resultset; 	
	   //print_r($this->result);	
	   
	   return ($resultset);   
	}		
	
	//override
	function show_paging($pagecmd=null,$mytemplate=null,$nopager=null) {
	   //echo 'nopager:',$nopager;
	   if ($nopager) return;
		
	   $cat = /*rawurlencode(*/GetReq('cat');//);
	   $order = GetReq('order')?GetReq('order'):GetSessionParam('order');
	   $asc = GetReq('asc')?GetReq('asc'):GetSessionParam('asc');	
	   $t = GetReq('t'); 	
	   $page = GetReq('page')?GetReq('page'):0;
	   $pager = GetReq('pager')?GetReq('pager'):$this->pager;//has already get the val ftom session
	   
	   $pcmd = $pagecmd?$pagecmd:'klist';
		  
	   //echo '|paging>',$this->max_items,':',$this->max_cat_items,':',$this->max_selection;
	   $mp = $this->max_cat_items;//$this->get_max_result(); //$this->max_selection
	   $max_page = floor($mp/$this->pager);//<<<<<<<<<<<<<<<-1;	 plus ceil  
	   //echo $max_page.">>>>".$mp.">>>>".$this->pager;
	   $cutter = 2;//5	 
	   
	   if ($mp<=$pager) return;  
	   //echo 'z';
	   //press button template
	   $tmpl_file='fppager-button.htm';	   
	   $template_button = $this->path . $this->tmpl_path .'/'. $this->tmpl_name .'/'. str_replace('.',getlocal().'.',$tmpl_file) ;	   
	   $tmplcontents = file_get_contents($template_button);	   
	   //if ($this->max_items==$this->pager) {	 
	   if ($page<$max_page) {//&& ($mp<$pager)) { 
	       //(($pager==10)||($pager==20)||($pager==30)||($pager==50)||($pager==100))) {//pager has max items val when show all selected	 
	   
	     //next pages
		 $m = 0;
		 for($p=$page+1;$p<$max_page;$p++) {
		   if ($m<$cutter) {
		     if ($tmplcontents) {			
				$next_page_no = seturl('t='.$pcmd.'&cat='.$cat.'&page='.$p,$p+1,null,null,null,$this->rewrite);
				$next .= $this->combine_template($tmplcontents,'',$next_page_no);
			 } 
		     else { 		   
 		       $next_page_no = seturl('t='.$pcmd.'&cat='.$cat.'&page='.$p,$p+1,null,null,null,$this->rewrite);
		       $next .= "|" . $next_page_no;
			 }  
		   }
		   $m+=1;
		 }	   
	   	 if (($next) && (!$tmplcontents)) $next .= "|";
	     $page_next = $page + 1;
		 if ($tmplcontents) {			
			$next_label = seturl('t='.$pcmd.'&cat='.$cat.'&page='.$page_next,/*localize('_next',getlocal())*/'&gt;',null,null,null,$this->rewrite);
			$next .= $this->combine_template($tmplcontents,'',$next_label);
		 } 
		 else 
	        $next .= seturl('t='.$pcmd.'&cat='.$cat.'&page='.$page_next,/*localize('_next',getlocal())*/'&gt;',null,null,null,$this->rewrite);
	   }
	    
	   if ($page>0) {
	     $page_prev = $page - 1;
		 if ($tmplcontents) {		
            $prev_label = seturl('t='.$pcmd.'&cat='.$cat.'&page='.$page_prev,/*localize('_prev',getlocal())*/'&lt;',null,null,null,$this->rewrite);		 
			$prev = $this->combine_template($tmplcontents,'',$prev_label);
		 } 
		 else 
	        $prev = seturl('t='.$pcmd.'&cat='.$cat.'&page='.$page_prev,/*localize('_prev',getlocal())*/'&lt;',null,null,null,$this->rewrite);
		 
         //prev pages
		 $m = $page-$cutter;
		 for($p=0;$p<$page;$p++) {
		   if ($p>=$m) {
		     $prev_page_no = seturl('t='.$pcmd.'&cat='.$cat.'&page='.$p,$p+1,null,null,null,$this->rewrite);
		     if ($tmplcontents) 
				$prev .= $this->combine_template($tmplcontents,'',$prev_page_no);
		     else 
		        $prev .= "|" . $prev_page_no;
		   }
		 }  
		 
		 if (($next) && (!$tmplcontents)) $prev .= "|";
	   }	 
	   $cp = $page+1;
	   if ($tmplcontents) 
		 $current = $this->combine_template($tmplcontents, $this->pager_current_class ,"<a href=\"#\">$cp</a>"); 
	   else
         $current = "[$cp]";	   
			
	     
	   //template
	   $template_file='fppager.htm';	   
	   $tfile = $this->path . $this->tmpl_path .'/'. $this->tmpl_name .'/'. str_replace('.',getlocal().'.',$template_file) ; 	
       //echo $tfile;
       //in thios case mytemplate disbled
       if (is_readable($tfile)) {
	   	 $page_titles = $prev . $current . $next;	
		 $contents = file_get_contents($tfile);	   		 	    		 
	     $ret = $this->combine_template($contents,$page_titles);	    
	   }
	   else {
	     $page_titles_big = '<h3>'. $prev . $current . $next .'</h3>';
		 
	     $mywin = new window('',$page_titles_big);
	     if ($mytemplate)
	       $ret = $mywin->render("center::100%::0::::right::0::0::");	   
	     else
	       $ret = $mywin->render("center::100%::0::group_article_selected::right::5::5::");	   
	   } 
	   return ($ret);
	}	

	//override
	function show_asceding($cmd=null,$mytemplate=null,$style=null,$notview=null) {
	
	   if ($this->global_hide_asceding) return; 
	   if ($notview) return;
	
	   $cat = /*rawurlencode(*/GetReq('cat');//);//encoded????
	   $t = GetReq('t');   
	   $cmd=$cmd?$cmd:'klist';
	   //print_r($_SESSION);
	   $asc = GetReq('asc') ? SetSessionParam('asc',GetReq('asc')) : GetSessionParam('asc');
	   $order = GetReq('order') ? SetSessionParam('order',GetReq('order') ) : GetSessionParam('order');	
	   $pager = GetReq('pager') ? SetSessionParam('pager',GetReq('pager')) : GetSessionParam('pager');		   	   
	   
	   //code/item/axia
	   $a = localize('_title',getlocal());
	   $b = localize('_axia',getlocal());
	   $c = localize('_code',getlocal());	   
	   $data = array(1=>$a,2=>$b,3=>$c);
	   if ($this->deforder)
	     $do = 3;
	   else
	     $do = 1;	 
	   $selected_order = GetReq('order')?GetReq('order'):(GetSessionParam('order') ? GetSessionParam('order') : $do);
	   $combo_char = $this->make_combo(seturl('t='.$cmd.'&cat='.$cat.'&order=#'),$data,null,$selected_order,$style);
	   	      	   		   
	   //asc/desc
	   $a = localize('_asc',getlocal());
	   $b = localize('_desc',getlocal());
	   $data = array(1=>$a,2=>$b);
	   if ($this->defasc<0)
	     $da = 2;
	   else
	     $da = 1;	 
	   $selected_asc = GetReq('asc')?GetReq('asc') : (GetSessionParam('asc') ? GetSessionParam('asc') : $do);   
	   $combo_asceding = $this->make_combo(seturl('t='.$cmd.'&cat='.$cat.'&asc=#'),$data,null,$selected_asc,$style);
	   
	   //pager
	   $max = $this->max_selection;
	   /*$data = array(12=>localize('_first',getlocal()).' 12',24=>localize('_first',getlocal()).' 24',
	                 36=>localize('_first',getlocal()).' 36',48=>localize('_first',getlocal()).' 48',
	                 60=>localize('_first',getlocal()).' 60',$max=>localize('_all',getlocal()));
	   */
       $data2 = array();  	
	   for ($i=1;$i<4;$i++) {
	      $n = ($this->default_pager * $i);
          $data2[$n] = localize('_array',getlocal()).' '.$n;
       }		  
	   $combo_pager = $this->make_combo(seturl('t='.$cmd.'&cat='.$cat.'&pager=#'),$data2,null,$this->pager,$style);
	   	  		   
	   //template	   
	   $template_file='fpsort.htm';	   
	   $tfile = $this->path . $this->tmpl_path .'/'. $this->tmpl_name .'/'. str_replace('.',getlocal().'.',$template_file) ; 	
       
       //in thios case mytemplate disbled
       if (is_readable($tfile)) {
		 $contents = file_get_contents($tfile);	 	   	   		 	      
	     $out = $this->combine_template($contents,localize('_order',getlocal()),$combo_char,$combo_asceding,$combo_pager);	    
	   }
	   else {	   
	   
	     $viewdata[] = localize('_order',getlocal()) . $combo_char . $combo_asceding . $combo_pager;//$ascending;
	     $viewattr[] = "left;100%";//"right;20%";	   
	   
	     $mywin = new window('',$viewdata,$viewattr);	   
		 
	     if ($mytemplate)
	   	   $out = $mywin->render("center::100%::0::::left::0::0::");   
	     else	 
	       $out = $mywin->render("center::100%::0::group_article_selected::left::5::5::");
	     unset ($viewdata);
	     unset ($viewattr);	
	   }	 
	   
	   return ($out);	      
	}		
	
	//override
	function list_katalog($imageclick=null,$cmd=null,$template=null,$no_additional_info=null,$external_read=null,$photosize=null,$resources=null,$nopager=null,$nolinemax=null,$originfunction=null) {
	   $cmd = $cmd?$cmd:'klist';
	   $lan = getlocal();
	   $itmname = $lan?'itmname':'itmfname';
	   $itmdescr = $lan?'itmdescr':'itmfdescr';
	   $pz = $photosize?$photosize:1;		   
	   $xdist = $this->imagex?$this->imagex:100;
	   $ydist = $this->imagey?$this->imagey:null;//free y 75;	
       $cat = GetReq('cat');//GetGlobal('controller')->calldpc_var('shtags.tagcat');	   
	   //echo $cat,':',$tagcat; 
	   $custom_template=false;

	   if ($nolinemax)
	     $mylinemax = null;
	   else
	     $mylinemax = $this->linemax;  	   
	   
	   if ($this->imageclick>0)
	     $myimageclick = 1;
	   else	 
	     $myimageclick = $imageclick;
		   
       if (($template) && (!stristr($template,'searchres'))) { /*custom template list*/
	     //echo $template;
		 $custom_template=true;
	     $tmpl = explode('.',$template);
	     $mytemplate = $this->select_template($tmpl[0],$cat);		
	   }
	   elseif (($template) && (stristr($template,'searchres'))) { /*search list*/
	     $tmpl = explode('.',$template);
		 //search template
	     $mytemplate = $this->select_template($tmpl[0],$cat);		
	     //list-table search alternative template
	     $mytemplate_alt = $this->select_template($tmpl[0].'-alt',$cat);	   
	   }
	   else { /*katalog list*/
	     //default template
	     $mytemplate = $this->select_template('fpkatalog',$cat);		
	     //list-table alternative template
	     $mytemplate_alt = $this->select_template('fpkatalog-alt',$cat);
	   }
       
       if ($this->oneitemlist) {
	     if (!$this->result->sql) { //AUTOMATED...when sql exist by prev query dont read a new
		   $is_one_item = $this->read_list(); //read records
	       if ($is_one_item) { 
	         //echo $is_one_item,'>';
		     $this->read_item($this->direction,$is_one_item);
		     $out = $this->show_item();
		     return ($out);
	       }		   
		 }
		 elseif (!$external_read) { //event read the list..if not called by a phpdac page call
		   if ($itemcode = $this->my_one_item) {
	         //echo $this->my_one_item,'>';
		     $this->read_item($this->direction,$itemcode);
		     $out = $this->show_item();
		     return ($out);		   
		   }	   
		 }		 
       } 	   
	   //print_r($this->result);
	   
	   if ($this->msg) $out = $this->msg;	   
	   
	   //set if show this up and down (2) or only up (1) or nothing 0
	   //if ((!$this->listcontrols)||($this->listcontrols>1))	   

	   //if (count($this->result)>0) {	
	   if (!empty($this->result)) {		   

		$pp = $this->read_policy();

        //top asc		
		//if ($this->max_cat_items>0)	 	   
	      //$out .= $this->show_asceding($cmd,$mytemplate,$this->asceding_class,$nopager);	

		$records = $this->result;  //echo 'B';  
	
	    foreach ($this->result as $n=>$rec) {
		
		   //memory limit prevention
		   //echo 'mem limit 33554432:',memory_get_peak_usage(true);//memory_get_usage();
		   $mem = memory_get_peak_usage(true);//memory_get_usage();
		   /*if ($mem>16000000) {
		     $mem_msg = '<br><h2>WARNING:Memory allocation failed, reduce page view limit!</h2>';
		     break;
		   }*/	
		   
		   $item_code = $this->getmapf('code');
		   
		   if ($resources)		   
		     $this->make_resource_table($rec[$item_code],$rec['resources']);		   

           $cat = $this->getkategories($rec);
		   $ucat = $cat;//urlencode($cat);

		   if ($rec[$pp]>0) { 
		     $myp = $this->spt($rec[$pp]);
		     $price = $myp?$myp:'&nbsp;';//($myp?number_format($myp,$this->decimals,',','.'):"&nbsp;");
		   }	 
		   else 	 
		     $price = $this->zeroprice_msg;		
		 
		   //$lastprice = $rec[$this->getmapf('lastprice')]?'<del>'.number_format($rec[$this->getmapf('lastprice')],$this->decimals,',','.').'&nbsp;&euro;</del><br/>':null;		 		   
		   
		   if ((GetGlobal('UserID')) || (seclevel('SHKATALOG_CART',$this->userLevelID))) {//logged in or sec ok
		     $cart_code = $rec[$this->getmapf('code')];
			 $cart_title = $this->replace_spchars($rec[$itmname]);
			 $cart_group = $cat;
			 $cart_page = GetReq('page')?GetReq('page'):0;
			 $cart_descr = $this->replace_spchars($rec[$itmdescr]);
			 $cart_photo = $rec[$this->getmapf('code')];//$this->get_photo_url($rec[$this->getmapf('code')],$pz);
			 $cart_price = $price;
			 $cart_qty = 1;//???
			 if (defined("SHCART_DPC"))
				$cart = GetGlobal('controller')->calldpc_method("shcart.showsymbol use $cart_code;$cart_title;$path;$MYtemplate;$cart_group;$cart_page;;$cart_photo;$cart_price;$cart_qty;+$cat+$cart_page",1);//'cart';
			 else
                $cart = null;  			 
			 $array_cart = $this->read_array_policy($rec[$item_code],$price,"$cart_code;$cart_title;$path;$MYtemplate;$cart_group;$cart_page;;$cart_photo;$cart_price;$cart_qty");	   
		   }
		   
		   $availability = $this->show_availability($rec['ypoloipo1']);	
		   $details = seturl('t=kshow&cat='.$ucat.'&page='.$page.'&id='.$rec[$item_code].'#DETAILS',$this->details_button,null,null,null,$this->rewrite);	   
           $detailink = seturl('t=kshow&cat='.$ucat.'&page='.$page.'&id='.$rec[$item_code].'#DETAILS',$this->details_button,null,null,null,$this->rewrite);		   
		   $itemlink = seturl('t=kshow&cat='.$ucat.'&page='.$page.'&id='.$rec[$item_code],null,null,null,null,$this->rewrite);
		   $itemlinkname = seturl('t=kshow&cat='.$ucat.'&page='.$page.'&id='.$rec[$item_code],$rec[$itmname],null,null,null,$this->rewrite);		   
		   		   
		   
		   if ($mytemplate) {
		   
              //// tokens method												 
		      $tokens[] = $itemlinkname;//$rec[$itmname];
			  $tokens[] = $rec[$itmdescr];
			  $tokens[] = $this->list_photo($rec[$item_code],$xdist,$ydist,$myimageclick,$ucat,$pz,null,$rec[$itmname]);
			  //$tokens[] = $rec['uniname1']; 
			  //units + qty
			  if (defined("SHCART_DPC")) 
			    $in_cart = GetGlobal('controller')->calldpc_method("shcart.getCartItemQty use ".$rec[$item_code]);
			  $incart = $in_cart?':<B>'.$in_cart.'</B>':null;
			  $units = $rec['uniname2'] ? 
			           localize($rec['uniname1'],getlocal()) .'/'. localize($rec['uniname2'],getlocal()):
					   localize($rec['uniname1'],getlocal());  
			  $tokens[] = $units;// . $incart;			  
			  
			  $tokens[] = $rec['itmremark'];//$this->getmapf('code')], 
			  $tokens[] = /*$lastprice .*/ number_format(floatval($price),$this->decimals,',','.');//$price;
			  $tokens[] = $cart;
			  $tokens[] = $availability;
			  $tokens[] = $details;
			  $tokens[] = $detailink;
			  $tokens[] = $rec[$item_code];
			  $tokens[] = $itemlink;	
			  
			  $tokens[] = $in_cart?$in_cart:'0';
			  $tokens[] = $array_cart;

              $tokens[] = $this->get_photo_url($rec[$item_code],$pz);	
              $tokens[] = $rec[$this->getmapf('lastprice')];	
              $tokens[] = $rec[$itmname]; 
			  
			  if (GetReq('id') || GetReq('cat') || ($originfunction))
			     $tokens[] = $this->get_xml_links(null,null,$originfunction);			  
			  else
                 $tokens[] = null;   

              $tokens[] = $this->item_has_discount($rec[$item_code]);
              $tokens[] = "addcart/$cart_code;$cart_title;$path;$MYtemplate;$cart_group;$cart_page;;$cart_photo;$cart_price;$cart_qty/$cat/$cart_page/";				  
		      
			  /*if ($mylinemax>1) {//table view
			    $items[] = $this->combine_tokens($mytemplate, $tokens, true);//<<exec after tokens replace		
				unset($tokens);													 
			  }									 
			  else {							 			  	
			    $toprint .= $this->combine_tokens($mytemplate, $tokens, true);//<<exec after tokens replace		
				unset($tokens);
			  }*/
			  if (!$custom_template) {
                $items_grid[] = $this->combine_tokens($mytemplate, $tokens, true);//<<exec after tokens replace
                $items_list[] = $this->combine_tokens($mytemplate_alt, $tokens, true);//<<exec after tokens replace			  
			  }
			  else
			    $items_custom[] = $this->combine_tokens($mytemplate, $tokens, true);//<<exec after tokens replace
				
			  unset($tokens);			  
		   }	 				   	   	   
		   else {		   				   	

	         $viewdata[] = $this->list_photo($rec[$item_code],$xdist,$ydist,$myimageclick,$ucat,$pz,null,$rec[$itmname]);
	         $viewattr[] = "left;5%";		   					   	   	   
		   
		     $viewdata[] = "<b>" . /*($rec[$itmname]?$rec[$itmname]:"&nbsp;")*/($rec[$itmname]?$itemlinkname:"&nbsp;") . "</b><br>" . 
						 ($rec[$itmdescr]?$rec[$itmdescr]:"&nbsp;");
		     $viewattr[] = "left;70%";	
		   
		   
	         $viewdata[] = "<b>" . $rec[$this->getmapf('code')] . "</b>" .//. "<br>" . localize($rec['uniname1'],getlocal())."<br>".
		                 "<h2>". number_format(floatval($price),$this->decimals,',','.') . "&#8364"/*writecl($price,'#FF0000','#FFFFFF')*/."</h2><br>" .
						 $cart . $availability;
	         $viewattr[] = "center;25%";			   		   
		   	   		   	   		   	   		   
		   
	         $myrec = new window('',$viewdata,$viewattr);
	         $toprint .= $myrec->render("center::100%::0::group_article_selected::left::5::5::");
	         unset ($viewdata);
	         unset ($viewattr);	
		   
		     $toprint .= "<hr/>";
		   }//template	
		  }//foreach 
		  
		  //table generation
		  if (!$custom_template) { 
            if (($mytemplate) && ($mytemplate_alt)) 	
              $toprint .= $this->make_table_list($items_grid, $items_list, 'fpkatalogtable', 'fpkataloglist');			
	        else
           	  $toprint .= $this->make_table($items, $mylinemax, 'fpkatalogtable');	  
			  
	        //set if show this up and down (2) or only up (1) or nothing 0
	        //if ((!$this->listcontrols)||($this->listcontrols>2))
			//echo 'list_katalog>',$this->max_cat_items,'>',$this->get_max_result(),'>',$this->max_selection;
  		    //if ($this->max_cat_items>0) {
		      //called as phpdac command
	          //$toprint .= $this->show_asceding($cmd,$mytemplate,$this->asceding_class,$nopager);
			
			  //if (!$nopager) ..func attr
	          $toprint .= $this->show_paging($cmd,$mytemplate,$nopager);		  
		    //}
		  }	
          else //custom template
		    $toprint .= (!empty($items_custom)) ? implode('',$items_custom) : null;
             		  
	   }//empty result
	   //else
		  //$toprint .= $this->show_lastentries();	
		  //$toprint .= "<h2>" .localize('_nofound',getlocal()). "</h2><br>";
	
	   if ($mytemplate) {
	     $out .= $toprint . $mem_msg;
	   }
	   else {
         $mywin = new window(/*$this->title*/'',$toprint . $mem_msg);
         $out .= $mywin->render();	
	   }	 
	   
	   /*page footer*/
	   if (!$custom_template) {
	     if ((count($this->result)>0) && ($no_additional_info==null)) {
	 	   if ($this->max_cat_items>0)
	         $out .= $this->show_availabillity_table(null,1);	      	 
	     }	   	 		
		 
	     if ($resources)
		   $out .= $this->make_swfobjects($this->result,$this->xmax,$this->ymax);	

         //feed links
	     /*if (GetReq('id') || GetReq('cat') || ($originfunction))
           $out .= $this->get_xml_links(null,null,$originfunction);*/			 
	   }
	   return ($out);	
	}	
	
	//override
    function list_katalog_table($linemax=2,$imgx=null,$imgy=null,$imageclick=0,$showasc=0,$cmd=null,$template=null,$no_additional_info=null,$lang=null,$external_read=null,$photosize=null,$resources=null,$nopager=null,$originfunction=null,$notable=null) {
	   $cmd = $cmd?$cmd:'klist';	
	   $page = GetReq('page')?GetReq('page'):0;			   
	   $lan = $lang?$lang:getlocal();
	   $itmname = $lan?'itmname':'itmfname';
	   $itmdescr = $lan?'itmdescr':'itmfdescr';	   
	   $pz = $photosize?$photosize:1;
	   $xdist = ($imgx?$imgx:160);
	   $ydist = ($imgy?$imgy:120);
	   $cat = GetReq('cat');
	   //$cat = GetGlobal('controller')->calldpc_var('shtags.tagcat');

	   if (remote_paramload('SHKATALOG','imageclick',$this->path)>0)
	     $myimageclick = 1;
	   else	 
	     $myimageclick = $imageclick;	   
	   
	   $mytemplate = $this->select_template($template,$cat,1);

	   //if (!$this->result->sql) { //AUTOMATED...when sql exist by prev query dont read a new
	   	 //echo 'z<br>';      	
	     //$is_one_item = $this->read_list(); 
		 //SERVER ERROR 500 when on table view beside list view..disable it
	     /*if ($is_one_item) {
	       //echo $is_one_item,'>';
		   $this->read_item($this->direction,$is_one_item);
		   $out = $this->show_item();
		   return ($out);
	     }*/		   
	   //}
	   
       if ($this->oneitemlist) {
	     if (!$this->result->sql) { //AUTOMATED...when sql exist by prev query dont read a new
		   $is_one_item = $this->read_list(); //read records
	       if ($is_one_item) { 
	         //echo $is_one_item,'>';
		     $this->read_item($this->direction,$is_one_item);
		     $out = $this->show_item();
		     return ($out);
	       }		   
		 }
		 elseif (!$external_read) { //event read the list..if not called by a phpdac page call
		   if ($itemcode = $this->my_one_item) {
	         //echo $this->my_one_item,'>';
		     $this->read_item($this->direction,$itemcode);
		     $out = $this->show_item();
		     return ($out);		   
		   }
		 }		 
       } 		   
		
	   if ($this->msg) $ret = $this->msg;

	   //if (count($this->result)>0) {	
	   if (!empty($this->result)) {
	   
        $pp = $this->read_policy();		
	    //$ret .= $this->show_asceding();		
	
	    foreach ($this->result as $n=>$rec) {
		
		   $mem = memory_get_peak_usage(true);//memory_get_usage();
		   /*if ($mem>16000000) {
		     $mem_msg = '<br><h2>WARNING:Memory allocation failed, reduce page view limit!</h2>';
		     break;
		   }*/	
		   
		   $item_code = $this->getmapf('code');
		   
		   if ($resources)
		     $this->make_resource_table($rec[$item_code],$rec['resources']);
		
           $cat = $this->getkategories($rec);	
		   $ucat = $cat;//urlencode($cat);
		
		   if ($rec[$pp]>0) { 
		     $myp = $this->spt($rec[$pp]);
		     $price = $myp?$myp:'&nbsp;';//($myp?number_format($myp,$this->decimals,',','.'):"&nbsp;");
		   }	
		   else 	 
		     $price = $this->zeroprice_msg;
			 
		   //$lastprice = $rec[$this->getmapf('lastprice')]?'<del>'.number_format(floatval($rec[$this->getmapf('lastprice')]),$this->decimals,',','.').'&nbsp;&euro;</del><br/>':null;
		   			 
		   $pfile = sprintf("%05s",$rec[$item_code]); //echo $pfile,"<br>";
		   
		   if (($user=GetGlobal('UserID')) || (seclevel('SHKATALOG_CART',$this->userLevelID))) {//logged in or sec ok		   
		     $cart_code = $rec[$item_code];
			 $cart_title = $this->replace_spchars($rec[$itmname]);
			 $cart_group = $cat;
			 $cart_page = GetReq('page')?GetReq('page'):0;
			 $cart_descr = $this->replace_spchars($rec[$itmdescr]);
			 $cart_photo = $rec[$item_code];//$this->get_photo_url($rec[$this->getmapf('code')],$pz);
			 $cart_price = $price;
			 $cart_qty = 1;//???
			 if (defined("SHCART_DPC"))
				$icon_cart = GetGlobal('controller')->calldpc_method("shcart.showsymbol use $cart_code;$cart_title;$path;$MYtemplate;$cart_group;$cart_page;;$cart_photo;$cart_price;$cart_qty;+$cat+$cart_page",1);//'cart';
			 else	
			    $icon_cart = null;
			 $array_cart = $this->read_array_policy($rec[$item_code],$price,"$cart_code;$cart_title;$path;$MYtemplate;$cart_group;$cart_page;;$cart_photo;$cart_price;$cart_qty");	   
		   }
           else
		     $icon_cart = null;			 			 
		     //echo $user,'>',$icon_cart;
		   
		   $availability = $this->show_availability($rec['ypoloipo1']);		
		   $details = seturl('t=kshow&cat='.$ucat.'&page='.$page.'&id='.$rec[$item_code].'#DETAILS',$this->details_button,null,null,null,$this->rewrite);	   
           $detailink = seturl('t=kshow&cat='.$ucat.'&page='.$page.'&id='.$rec[$item_code].'#DETAILS',$this->details_button,null,null,null,$this->rewrite);		   
		   $itemlink = seturl('t=kshow&cat='.$ucat.'&page='.$page.'&id='.$rec[$item_code],null,null,null,null,$this->rewrite);
		   $itemlinkname = seturl('t=kshow&cat='.$ucat.'&page='.$page.'&id='.$rec[$item_code],$rec[$itmname],null,null,null,$this->rewrite);			   
		   

		   if ($mytemplate) {
		   
             //// tokens method												 
		     $tokens[] = $itemlinkname;//$rec[$itmname];
			 $tokens[] = $rec[$itmdescr];
			 $tokens[] = $this->list_photo($rec[$item_code],$xdist,$ydist,$myimageclick,$ucat,$pz,null,$rec[$itmname]);
			 
			 //$tokens[] = localize($rec['uniname1'],getlocal()); 
			 //units + qty
			 if (defined("SHCART_DPC"))			 
			  $in_cart = GetGlobal('controller')->calldpc_method("shcart.getCartItemQty use ".$rec[$item_code]);
			 $incart = $in_cart?':<B>'.$in_cart.'</B>':null;
			 $units = $rec['uniname2'] ? 
			          localize($rec['uniname1'],getlocal()).'/'.localize($rec['uniname2'],getlocal()) :
					  localize($rec['uniname1'],getlocal());  
			 $tokens[] = $units;// . $incart;			 
			 
			 $tokens[] = $rec['itmremark'];//$this->getmapf('code')], 
			 $tokens[] = /*$lastprice .*/ number_format(floatval($price),$this->decimals,',','.');//$price;
			 $tokens[] = $icon_cart;
			 $tokens[] = $availability;
			 $tokens[] = $details;
			 $tokens[] = $detailink;
			 $tokens[] = $rec[$item_code];
			 $tokens[] = $itemlink;			
			 
			 $tokens[] = $in_cart?$in_cart:'0';//null;
			 $tokens[] = $array_cart;
			 
			 $tokens[] = $this->get_photo_url($rec[$item_code],$pz);
			 $tokens[] = $rec[$this->getmapf('lastprice')];
			 $tokens[] = $rec[$itmname]; 
			 
			 if (GetReq('id') || GetReq('cat') || ($originfunction))
			    $tokens[] = $this->get_xml_links(null,null,$originfunction);			  
			 else
                $tokens[] = null; 	

             $tokens[] = $this->item_has_discount($rec[$item_code]);
             $tokens[] = "addcart/$cart_code;$cart_title;$path;$MYtemplate;$cart_group;$cart_page;;$cart_photo;$cart_price;$cart_qty/$cat/$cart_page/";				 
			 			 	 
			 $items[] = $this->combine_tokens($mytemplate, $tokens, true);	
			 unset($tokens);													 
		   }	 				   	   	   
		   else {
		       $viewdata[] = "<b>".($rec[$itmname]?$itemlinkname:"&nbsp;") . "</b><br>" . 
						 /*localize('_descr',getlocal()) . ":" .*/ ($rec[$itmdescr] ? $rec[$itmdescr] : "&nbsp;") . "<br>" . 
		                 localize('_uniname1',getlocal()) . ":" . ($rec['uniname1'] ? localize($rec['uniname1'],getlocal()) : "&nbsp;") . "<br>" .
                         localize('_code',getlocal()) . ":" . $rec[$item_code] . "<br>" .						 
						 /*localize('_axia',getlocal()) . ":" .*/ 
						 "<b>". writecl(number_format(floatval($price),$this->decimals,',','.').'&nbsp;&#8364','#FFFFFF','#FF0000')."</b>";/* . "<br><br>" .
						 seturl('t=kshow&cat='.$rec[1].'&id='.$rec['id'].'&page='.$page,'Περισσότερα...');*/
		       $viewattr[] = "left;60%";					 		   
		      
		       $viewdata[] = $this->list_photo($rec[$item_code],$xdist,$ydist,$myimageclick,$ucat,$pz,null,$rec[$itmname]).
		                 '<br>' . $icon_cart . $availability;
	           $viewattr[] = "left;40%";
		   
	           //$viewdata[] = "&nbsp;";
	           //$viewattr[] = "left;10%";			   		   
		   	   		   	   		   	   		   
		   
	           $myrec = new window('',$viewdata,$viewattr);
	           $items[] = $myrec->render("center::100%::0::group_article_table::left::3::3::");
	           unset ($viewdata);
	           unset ($viewattr);	
		   }//if template
		   
		}//foreach	
	   
		if ($notable) {/*single product view called by phpdac funcs*/
		    $nt = (!empty($items)) ? implode('',$items) : null;
		    return ($nt);
		}	
		//else	
	    //make table			
		$ret .= $this->make_table($items, $linemax, 'fpkatalogtable');  	  
	      				
	    //called as phpdac command
	    //if ($showasc) 
	        //$ret .= $this->show_asceding($cmd,null,$this->asceding_class,$nopager);
			
		if ($this->pager) 
		  $ret .= $this->show_paging($cmd,$mytemplate,$nopager);					
		
	   }
	   else //count	
		  $toprint .= "<h2>" .localize('_nofound',getlocal()). "</h2><br>";	   	

	   if ((count($this->result)>0) && ($no_additional_info==null))   
	     $ret .= $this->show_availabillity_table(null,1);	   
	
	   //echo '<pre>'; print_r($this->resource); echo '</pre>';
	   
	   if ($resources) {
	      //$x = $imgx?$imgx:$this->xmax;
		  //$y = $imhy?$imgy:$this->ymax;
		  $ret .= $this->make_swfobjects($this->result,$this->xmax,$this->ymax);		  	   
	   } 

       //feed links
	   /*if (GetReq('id') || GetReq('cat') || ($originfunction))
         $ret .= $this->get_xml_links(null,null,$originfunction);*/		   
	
	   return ($ret);	
    } 
	
	//overrided
	function show_item($template=null,$no_additional_info=null,$lang=null,$lnktype=1,$pcat=null,$boff=null,$tax=null) {
	   global $current_item;//use global becouse of same page info transfer
	   
	   $lan = $lang?$lang:getlocal();
	   $itmname = $lan?'itmname':'itmfname';
	   $itmdescr = $lan?'itmdescr':'itmfdescr';
	   $page = GetReq('page')?GetReq('page'):0;	
	   
	   $cat = $pcat?$pcat:GetReq('cat');
       //$cat = $pcat ? $pcat : GetGlobal('controller')->calldpc_var('shtags.tagcat');   	   	   
	   
	   $id = GetReq('id');
	   //$id = GetGlobal('controller')->calldpc_var('shtags.tagitem');
	   
	   $listm = $this->list_item?$this->list_item:GetReq('id');	  
	   $xdist = $this->itemimagex?$this->itemimagex:200;
	   $ydist = $this->itemimagey?$this->itemimagey:null; //free y 100;	
	   $buttons_OFF = $boff?$boff:$this->buttons_OFF;
	   //echo $buttons_OFF,'>';
	   
	   $mytemplate = $this->select_template('fpitem',$cat);	 
	   
	   //print_r($this->result->fields); echo 'z',count($this->result->fields);
	   if (count($this->result->fields)>1) {	
	   
		$pp = $this->read_policy();	   
	   
	    foreach ($this->result as $n=>$rec) {
		
		   $item_code = $this->getmapf('code');
           $this->make_resource_table($rec[$item_code],$rec['resources']);		
		   
           $cat = $this->getkategories($rec);					 
		   
		   if ($rec[$pp]>0) { 
		     $myp = $this->spt($rec[$pp],$tax);
			 //echo $tax,':',$myp,'<br>';
		     $price = $myp?$myp:'&nbsp;';//($myp?number_format($myp,$this->decimals,',','.'):"&nbsp;");
		   }	
		   else 	 
		     $price = $this->zeroprice_msg;	
			 
		   //$lastprice = $rec[$this->getmapf('lastprice')]?'<del>'.number_format(floatval($rec[$this->getmapf('lastprice')]),$this->decimals,',','.').'&nbsp;&euro;</del><br/>':null;			   						 
		   
           $recar[localize('_code',getlocal())]=($rec[$item_code]!=null?$rec[$item_code]:"&nbsp;");		   
		   $recar[localize('_item',getlocal())]=($rec[$itmname]!=null?$rec[$itmname]:"&nbsp;");
		   $recar[localize('_descr',getlocal())]=($rec[$itmdescr]?$rec[$itmdescr]:"&nbsp;");
		   $recar[localize('_uniname1',getlocal())] = ($rec['uniname1']!=null ? localize($rec['uniname1'],getlocal()) : "&nbsp;"); 
		   $recar[localize('_code',getlocal())]=($rec[$item_code]?$rec[$item_code]:"&nbsp;"); 
		   $recar[localize('_axia',getlocal())]= number_format(floatval($price),$this->decimals,',','.') . "<br><br>";

		   $table2show = $this->make_table_to_show($recar);	   
		   
		   //SAVE TO RETRIEVE BY SPONSORS WHEN HAVE SPONSORAS BY TYPE, MODEL etc.
		   $this->datarecord = (array) $recar;			   
		   
	       //save vehicle for aditional services as forum
	       $current_item = $rec['itmname']. " " . " (" . $rec[$item_code] . ")";
		   //echo $current_vehicle;
		   SetSessionParam('CURRENT_ITEM',$current_item);

		   
		   $icon_back  = loadTheme('icon_back','Επιστροφή...');
		   $icon_prev  = loadTheme('icon_prev','Προηγούμενο...');
		   $icon_next  = loadTheme('icon_next','Επόμενο...');		   		   
		   //$icon_getit = loadTheme('icon_getit','Εκδήλωση ενδιαφέροντος...');
		   $icon_print = loadTheme('icon_print',localize('_PRINT',getlocal())); 

		   $mybuttons = seturl('t=klist&cat='.$cat.'&page='.$page,$icon_back) .
				 	    seturl('t=kprev&cat='.$cat.'&page='. $page . '&direction=prev&id='.$id.'&listm='.$listm,$icon_prev) .						 
					    seturl('t=knext&cat='.$cat.'&page='. $page. '&direction=next&id='.$id.'&listm='.$listm,$icon_next) .						 
					    $this->printlink($icon_print);
						 

		   if ((GetGlobal('UserID')) || (seclevel('SHKATALOG_CART',$this->userLevelID))) {//logged in or sec ok
		     $cart_code = $rec[$item_code];
			 $cart_title = $this->replace_spchars($rec[$itmname]);
			 $cart_group = $cat;
			 $cart_page = GetReq('page')?GetReq('page'):0;
			 $cart_descr = $this->replace_spchars($rec[$itmdescr]);
			 $cart_photo = $rec[$item_code];//$this->get_photo_url($rec[$this->getmapf('code')],1);
			 $cart_price = $price;
			 $cart_qty = 1;//???
			 if (defined("SHCART_DPC"))
				$icon_cart = GetGlobal('controller')->calldpc_method("shcart.showsymbol use $cart_code;$cart_title;$path;$MYtemplate;$cart_group;$cart_page;;$cart_photo;$cart_price;$cart_qty;+$cat+$cart_page",1);//'cart';
			 else
                $icon_cart = null;			 
			 $array_cart = $this->read_array_policy($rec[$item_code],$price,"$cart_code;$cart_title;$path;$MYtemplate;$cart_group;$cart_page;;$cart_photo;$cart_price;$cart_qty");	   
		   }
           else
		     $icon_cart = null;
			
		   $availability = $this->show_availability($rec['ypoloipo1']);	 
		   $detailink = seturl("t=kshow&cat=$cat&page=$page&id=".$rec[$item_code],null,null,null,null,$this->rewrite).'#DETAILS';//,$this->details_button);		   
			 
	       $linkphoto = $this->list_photo($rec[$item_code],$xdist,$ydist,$lnktype,$cat,2,3,$rec[$itmname]);	
		   //echo $lnktype,'>';			
		   
		   if ($mytemplate) {	 		 	      
		   
 	         $toprn .= $this->make_swfobjects($this->result,$this->xmax,$this->ymax);	
			 
             $ahtml = $this->show_aditional_html_files($rec[$item_code]);			 
             $atext = $this->show_aditional_txt_files($rec[$item_code]);				 		 		   			  
			 $afile = $this->show_aditional_files($rec[$item_code],1,$rec[$itmname]);			 
			 
             //$details = "<a name=\"DETAILS\"><p>"; //flickering...
			 //$details .= $this->read_array_policy($rec[$this->getmapf('code')],$price,"$cart_code;$cart_title;$path;$MYtemplate;$cart_group;$cart_page;;$cart_photo;$cart_price;$cart_qty");	
			 $details = $ahtml . $atext . $afile;
			 //$details .= "</p>";				 		   

             //// tokens method												 
		     $tokens[] = $rec[$itmname];
			 $tokens[] = $rec[$itmdescr];
			 $tokens[] = $linkphoto;
			 
			 //$tokens[] = $rec['uniname1']; 
			 //units + qty
			 if (defined("SHCART_DPC"))			 
			  $in_cart = GetGlobal('controller')->calldpc_method("shcart.getCartItemQty use ".$rec[$item_code]);
			 $incart = $in_cart?':<B>'.$in_cart.'</B>':null;
			 $units = $rec['uniname2'] ? 
			          localize($rec['uniname1'],getlocal()).'/'.localize($rec['uniname2'],getlocal()):
					  localize($rec['uniname1'],getlocal());  
			 $tokens[] = $units;// . $incart;			 
			 
			 $tokens[] = $rec['itmremark'];//$this->getmapf('code')], 
			 $tokens[] = /*$lastprice .*/ number_format(floatval($price),$this->decimals,',','.');//$price;
			 $tokens[] = $icon_cart; //6
			 $tokens[] = $availability;
			 $tokens[] = $detailink;
			 $tokens[] = $details;
			 $tokens[] = $rec[$item_code];
			 
			 $tokens[] = $in_cart?$in_cart:'0';//null;
			 $tokens[] = $array_cart;

             $tokens[] = $ahtml;
			 $tokens[] = $atext;  			 
			 $tokens[] = $afile;
			 
             $tokens[] = $rec[$this->getmapf('lastprice')];	
             $tokens[] = $this->get_photo_url($rec[$item_code],1);
             $tokens[] = $this->get_photo_url($rec[$item_code],2);			 
			 $tokens[] = $this->get_photo_url($rec[$item_code],3);			 
			 
			 $tokens[] = $rec['weight'];
			 $tokens[] = $rec['volume'];
			 $tokens[] = $rec['dimensions'];
			 $tokens[] = $rec['size'];
			 $tokens[] = $rec['color'];	
			 
			 $tokens[] = $this->get_xml_links();
             $tokens[] = $this->item_has_discount($rec[$item_code]);
             $tokens[] = "addcart/$cart_code;$cart_title;$path;$MYtemplate;$cart_group;$cart_page;;$cart_photo;$cart_price;$cart_qty/$cat/$cart_page/";			 
			 
			 //print_r($tokens);
			 $toprn .= $this->combine_tokens($mytemplate, $tokens, true);
			 unset($tokens);
												 
			 //$toprn .= $details;	//in template moved inside tokens								 
			 
             $toprint .= $toprn; //..copy print ver to toprint flow..
			 //add buttons			 
			 $toprint .= $buttons_OFF?"&nbsp;":$mybuttons;					  
           }
		   else {		   
		   
		     $bb = $buttons_OFF?"&nbsp;":$mybuttons;
		     $viewdata[] = $table2show .
			  			   $bb .
						   $icon_cart .
						   $availability;
		     $viewattr[] = "left;50%";	
		   
		     //printout...
		     $printdata[] = $table2show;
		     $printattr[] = "left;50%";			   
           
		     //photo in window
		     $pwin = new window('Φωτογραφία',$linkphoto);
		     $pphoto = $pwin->render();
		     unset ($pwin);	 
			 
	         $viewdata[] = $pphoto . 
			               $this->read_array_policy($rec[$item_code],$price,"$cart_code;$cart_title;$path;$MYtemplate;$cart_group;$cart_page;;$cart_photo;$cart_price;$cart_qty") . 
		                   $this->show_aditional_files($rec[$item_code],1,$rec[$itmname]) .
						   $this->show_aditional_html_files($rec[$item_code]) .
						   $this->show_aditional_txt_files($rec[$item_code]); 
	         $viewattr[] = "left;50%";
		   
		     //printout...
		     $printdata[] = $pphoto . 
			                $this->read_array_policy($rec[$item_code],$price,"$cart_code;$cart_title;$path;$MYtemplate;$cart_group;$cart_page;;$cart_photo;$cart_price;$cart_qty") . 
		                    $this->show_aditional_files($rec[$item_code],null,$rec[$itmname]) .
			 			    $this->show_aditional_html_files($rec[$item_code]) .
							$this->show_aditional_txt_files($rec[$item_code]);
		     $printattr[] = "left;50%";			   		   
		   	   		   	   		
		     $toprint .= $this->set_anchor('photo');									   	   		   
		   
             $toprint .= "<a name=\"DETAILS\">";
		   
	         $myrec = new window('',$viewdata,$viewattr);
		     if ($mytemplate) 
               $toprint .= $myrec->render("center::100%::0::::left::0::0::");		  
		     else			   
	           $toprint .= $myrec->render("center::100%::0::group_article_selected::left::3::3::");
	         unset ($viewdata);
	         unset ($viewattr);
			 
			 $toprint .= $this->make_swfobjects($this->result,$this->xmax,$this->ymax);		  	   		   	
		   
		     //printout
	         $myprn = new window('',$printdata,$printattr);
		     if ($mytemplate) 
               $toprn .= $myrec->render("center::100%::0::::left::0::0::");		  
		     else			   
	           $toprn = $myprn->render("center::100%::0::group_article_selected::left::3::3::");
	         unset ($printdata);
	         unset ($printattr);		
		   
		   }//mytemplate 		   
		   
		   SetSessionParam('printpage',$toprn);	 
		   
		   //AUTOMATED....
		   /*if (defined('ABCFORUM_DPC')) {
		   
		     $frm = GetGlobal('controller')->calldpc_method('abcforum.display_forums');
		     $toprint .= $frm;//'Forum';
		   }*/
	       if ($mytemplate) {		  
	         $out = $toprint;
	       }
	       else {
             $mywin = new window(/*$this->title*/'',$toprint);
             $out = $mywin->render("center::100%::0::group_article_selected::left::2::2::");	
	       }
	   	 
           if ($no_additional_info==null)	   
	         $out .= $this->show_availabillity_table(null,1); 

           //feed links
           //$out .= $this->get_xml_links();				 
		    		
	 	}//foreach	   
	   }//if recs
	   else {
	      //  echo 'z';
		  if ($this->itemlockparam) {
		    if ($goto = $this->itemlockgoto)
			  $out = GetGlobal('controller')->calldpc_method($goto);
			else
			  $out = "<h2>".localize('_lockrec',getlocal())."</h2>";
		  }
		  else 
		    $out = "<h2>".localize('_norec',getlocal())."</h2>";
	   }	  	  	   
  	   
	   return ($out);	
	}		
	

    //overrided
	function show_aditional_files($id,$nojs=null,$altname=null,$tmpl=null) {
	     if (!$id) return;
	     $cat = GetReq('cat');
		 $title = $altname ? $altname : $id;
	     //$cat = $cat ? $cat : GetGlobal('controller')->calldpc_var('shtags.tagcat');
		 //$id = $id ? $id : GetGlobal('controller')->calldpc_var('shtags.tagitem');
		 $name = $id;
		 //if ($this->encodeimageid) //check inside func
		 $id = $this->encode_image_id($id); 
		 
	     $addfx = $this->addfx?$this->addfx:100;
	     $addfy = $this->addfy?$this->addfy:null;//free y size //75;	
 
	
	     $this->allow_show_resource = true; //enable it after show main item image		
	
	     $template= $tmpl ? $tmpl : 'fpitemaddfiles.htm';	   
	     $t = $this->path . $this->tmpl_path .'/'. $this->tmpl_name .'/'. str_replace('.',getlocal().'.',$template) ; 
	     //echo $t,'>';
	     if (($template) && is_readable($t)) {
		   $mytemplate = file_get_contents($t);
	     }	   	
         
         $slide_index = 1; //start at 1, 1=main image 		 
		 //multiple images
		 for($i='A';$i<='Z';$i++) {
		 
           $slide_index+=1;		 
		   
		   foreach ($this->advrestype as $restype) { 
		   //work with uphoto path only......
		   	   
		   $ad_photo_big = $this->imgpath .  $id . $i . $restype;
		   $aditional_pic_file = $this->urlpath .'/'. $this->imgpath . $id . $i . $restype;

		   if (file_exists($aditional_pic_file)) {//echo $aditional_pic_file,'<br/>';
		     //$photos .= "<br><br><img src=\"" . $ad_photo . "\"  alt=\"". localize('_IMAGE',getlocal()) . "\">";

			 switch ($restype) {
			 
			    case '.zip' :
				case '.exe' : $exeresource = $this->show_exeobject($id.$i,null,null,null,$restype);
				              if ($mytemplate) { 
			                    $remarks = 'EXE,ZIP';//$this->show_aditional_txt_files($id);			 
                                $items[] =  $this->combine_template($mytemplate,$id.$i,'',$exeresource,$remarks);
			                  }
			                  else									 			 
			                    $items[] = $exeresource;
				              break;
							  
				case '.pdf' : $pdfresource = $this->show_pdfobject($id.$i);
				              if ($mytemplate) { 
			                    $remarks = 'PDF';//$this->show_aditional_txt_files($id);			 
                                $items[] =  $this->combine_template($mytemplate,$id.$i,'',$pdfresource,$remarks);
			                  }
			                  else									 			 
			                    $items[] = $pdfresource;
				              break;							  
			 
			    case '.swf' : $swficon = null;//'swf object';//null;
			                  $adnresource = $this->show_swfobject($id.$i,$swficon); 
							  if ($mytemplate) { 
			                    $remarks = 'SWF';//$this->show_aditional_txt_files($id);			 
                                $items[] =  $this->combine_template($mytemplate,$id.$i,'',$adnresource,$remarks);
			                  }
			                  else									 			 
			                    $items[] = $adnresource;
								
							  $swf_array[$id.$i] = $this->url .  'images/uphotos/' . $id . $i . $restype;//$aditional_pic_file;	
							  //print_r($swf_array);
				              break;
                
				default    : //image... .jpg, .png
				
                             if ((iniload('JAVASCRIPT')) /*&& (!$nojs)*/) {	
		                       if ($this->lightbox) {
                                 $plink = "<A href=\"$ad_photo_big\" rel='lightbox[$name]' title='$title'>";			 
			                   }
			                   else {				 
  	                             $plink = "<a href=\"#\" ";	   
	                             //call javascript for opening a new browser win for the img		   
	                             //$params = $photo . ";Image;width=300,height=200;";
	                             $params = "$ad_photo_big;640;480;<B>$title</B><br>$descr;";			 

			                     $js = new jscript;
	                             $plink .= $js->JS_function("js_popimage",$params); 
			                     unset ($js); 

	                             $plink .= ">";
			                   }	 
	                         }
	                         else {
			                   $addtional_photo_link = seturl('t=kshow&cat='.GetReq('cat').'&id='.GetReq('id').'&thub='.$i.'#photo');
			                   $plink = "<A href=\"$addtional_photo_link\">";				 
                               //$plink = "<A href=\"$photo\">";			 
		                     }  
			 
			                 $lo = "<img src=\"" . $ad_photo_big . "\"  width=\"$addfx\" ";
							 $lo.= $addfy ? "height=\"$addfy\"" : null; 
							 $lo.= "border=\"0\" alt=\"". localize('_IMAGE',getlocal()) . "\">" . "</A>"; 
			                 $adnphoto = $plink . $lo;
			 
			                 if ($mytemplate) { 
			                   $remarks = 'PHOTO';//$this->show_aditional_txt_files($id);			 
                               $items[] =  $this->combine_template($mytemplate,$id.$i,'',$adnphoto,$remarks,$slide_index,$ad_photo_big,($slide_index-1));
			                 }
			                 else									 			 
			                   $items[] = $adnphoto;
			 
			 }//switch
			 			   
			 //echo $restype,' exit';    			   
			 break;  //exit loop of restypes
			 
		   }//file exists
		   }//foreach	 
		 }//for		 
		 
		 
		 //...........................plus multiple resources...(resource products table field)		 
		 //echo $id;
		 //print_r($this->resource[$id]);
		 //print_r($this->result);
		 $resarray = $this->resource[$id];
		 if (!empty($resarray)) {
		   foreach  ($resarray as $rtype=>$resource) {
		   
		     switch ($rtype) {
	           case 'http'    : $resource = $this->resource[$id]['http']; break;
	           case 'mpeg'    : $resource = $this->resource[$id]['mpeg']; break;			
	           case 'mp3'     : $resource = $this->resource[$id]['mp3']; break;			
	           case 'avi'     : $resource = $this->resource[$id]['avi']; break;			
	           case 'swf'     : $swficon = null;
			                    $resource = $this->show_swfobject($id,$swficon); 
								break;		
	           case 'embed'   : $resource = $this->get_resource($id,'embed');/*$this->resource[$id]['embed'];*/ break;			
	           default        : $deficon = null;
			                    $resource = $this->show_swfobject($id,$deficon); 
								break;		
			 }
			 
			 if ($mytemplate) { 
			    $remarks = $this->show_aditional_txt_files($id.$rtype);
                $items[] =  $this->combine_template($mytemplate,$rtype,'',$resource,$remarks);
			                                     /*$rec['uniname1'] , 
												 $rec['itmremark'],//$this->getmapf('code')], 
												 $price,
												 $icon_cart,
												 $availability,
												 $detailink,
												 $details);			 */
			 }
			 else									 			 
			   $items[] = $resource;			 
		   }
		 }
		 //echo 'z';
		 //print_r($items);
	     //echo $this->additional_files_perline;
		 
	     $itemscount = count($items);
		 		 
		 if (($itemscount>0) && ($this->additional_files_perline>1))	 {

		   $out = $this->make_table($items, $this->additional_files_perline, 'fptreetable');
		   
		   //local filesystem swf rendering
		   if (!empty($swf_array))		 
		     $out .= $this->make_local_swfobjects($swf_array,$addfx,$addfy);		   
		   
		 }
		 else {
		   $out = (!empty($items)) ? implode('',$items) : null; //without table template
		   //echo $out;
		 }  
		 

		 return ($out);		 
	}
	
	//overrwriiten
	function show_aditional_html_files($id) {	
         $db = GetGlobal('db');	
	     $lan = getlocal();
		 
		 if ($this->one_attachment)
		   $slan = null;
		 else
		   $slan = $lan?$lan:'0';
		 //echo $slan,'>';  
	     $code = $this->getmapf('code');	  
         $sSQL = "select data from pattachments ";
	     $sSQL .= " WHERE (type='.html' or type='.htm') and code='" . $id . "'";
	     if (isset($slan))
	       $sSQL .= " and lan=" . $slan;	
	     //echo $sSQL;
	  
	     $resultset = $db->Execute($sSQL,2);	
	     $result = $resultset;
	     //print_r($result);	
	     if ($exist = $db->Affected_Rows()) {
		   //echo 'sql';
		   $ret = $result->fields['data'];
		 }		   
         else {		   

		   $mainhtml = $this->htmlpath . $id . $slan;		 
           if (file_exists($mainhtml.'.html')) {		
		     $ret = file_get_contents($mainhtml.'.html');	
		   }
		   elseif (file_exists($mainhtml. '.htm')) {		
		     $ret = file_get_contents($mainhtml.'.htm');	
		   }
		 }
		 //multiple html
		 for($i='A';$i<='I';$i++) {
		   
		   $aditional_html_file = $this->htmlpath . $id . $slan . $i;
		   if (file_exists($aditional_html_file.',html')) {
		     $ret .= file_get_contents($aditional_html_file);
		   }
		   elseif (file_exists($aditional_html_file.',htm')) {
		     $ret .= file_get_contents($aditional_html_file.'.htm');
		   }		   
		 }
		 
		 return ($ret);  		 
	}	
	
	
	function show_p($p,$items=10,$linemax=null,$imgx=100,$imgy=75,$imageclick=0,$template=null,$ainfo=null,$external_read=null,$photosize=null) {
        $db = GetGlobal('db');		
	    $lan = $lang?$lang:getlocal();
	    $itmname = $lan?'itmname':'itmfname';
	    $itmdescr = $lan?'itmdescr':'itmfdescr';				
		$pz = $photosize?$photosize:1;	
		$lastprice = $this->getmapf('lastprice')?','.$this->getmapf('lastprice'):null;		
	                                                                                //,date1
        $sSQL = "select id,sysins,code1,pricepc,price2,sysins,itmname,itmfname,uniname1,uniname2,active,code4," .// from abcproducts";// .
	            "price0,price1,cat0,cat1,cat2,cat3,cat4,itmdescr,itmfdescr,itmremark,ypoloipo1,resources,".
				$this->getmapf('code').
				$lastprice .
				" from products ";
		$sSQL .= " WHERE ";	
		
		if ($selected_item = GetReq('id')) 
		  $sSQL .= $this->getmapf('code') . " not like '" . $selected_item ."' and ";
		  		
		$sSQL .= $p." >0 and ".$p." IS NOT NULL and itmactive>0 and active>0";	
		$sSQL .= " ORDER BY {$this->orderid}";
		$sSQL .= $this->bypass_order_list ? null : 
		         ($this->orderid ? ",$itmname {$this->sortdef} " : "$itmname {$this->sortdef} ");
		$sSQL .= $items ? " LIMIT " . $items: null;			
	    //echo $sSQL,'<br>';
		
	    $resultset = $db->Execute($sSQL,2);	
		$this->result = $resultset;
		
		$xmax = $imgx?$imgx:100;
		$ymax = $imgy?$imgy:75;		
		
		if ($linemax>1)
		  $out = $this->list_katalog_table($linemax,$xmax,$ymax,$imageclick,0,null,$template,$ainfo,null,$external_read,$pz,1,1,"shkatalogmedia.show_p use $p,$items");
		else  	
          $out = $this->list_katalog(null,null,$template,$ainfo,$external_read,$pz,null,null,$linemax,"shkatalogmedia.show_p use $p,$items");
		  
		return ($out);	
	}		
	
	function show_pcat($p,$category=null,$items=10,$linemax=null,$imgx=100,$imgy=75,$imageclick=0,$template=null,$ainfo=null,$external_read=null,$photosize=null) {
        $db = GetGlobal('db');		
	    $lan = $lang?$lang:getlocal();
	    $itmname = $lan?'itmname':'itmfname';
	    $itmdescr = $lan?'itmdescr':'itmfdescr';
		$mycat = $category?$category:GetReq('cat');	//auto browse current cat	   
		$cat = explode($this->cseparator,$mycat);			
		$pz = $photosize?$photosize:1;	
		$lastprice = $this->getmapf('lastprice')?','.$this->getmapf('lastprice'):null;		
	                                                                                //,date1
        $sSQL = "select id,sysins,code1,pricepc,price2,sysins,itmname,itmfname,uniname1,uniname2,active,code4," .// from abcproducts";// .
	            "price0,price1,cat0,cat1,cat2,cat3,cat4,itmdescr,itmfdescr,itmremark,ypoloipo1,resources,".
				$this->getmapf('code').
				$lastprice .
				" from products ";
		$sSQL .= " WHERE ";	
		
		foreach ($cat as $i=>$c) {
		  $myc = str_replace('_',' ',$c);		
		  $sSQL .= " cat{$i}='$myc' and ";	
		}  
		//only items inside category ..when category param not specified
	    if ((!$category) && ($this->onlyincategory)) {
		  $ii = $i+1;
		  $sSQL .= " (cat{$ii} IS NULL or cat{$ii}='') and ";		
		}  		
		
		if (($selected_item = GetReq('id')) && (!$xor)) 
		  $sSQL .= $this->getmapf('code') . " not like '" . $selected_item ."' and ";
		  
		//MULTIPLE CHECKS  !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		if ($selected_cat0 = $fields['cat0']) 
		  $sSQL .= "cat0 not like '" . $selected_cat0 . "' and ";		  
		  	
		if ($selected_cat1 = $fields['cat1']) 
		  $sSQL .= "cat1 not like '" . $selected_cat1 . "' and ";		 
		  		  
		if ($selected_cat2 = $fields['cat2']) 
		  $sSQL .= "cat2 not like '" . $selected_cat2 . "' and ";
		  
		if ($selected_cat3 = $fields['cat3']) 
		  $sSQL .= "cat3 not like '" . $selected_cat3 . "' and ";		
		
		if ($selected_item = GetReq('id')) 
		  $sSQL .= $this->getmapf('code') . " not like '" . $selected_item ."' and ";
		  		
		$sSQL .= $p." >0 and ".$p." IS NOT NULL and itmactive>0 and active>0";	
		$sSQL .= " ORDER BY {$this->orderid} ";
		$sSQL .= $this->bypass_order_list ? null : 
		         ($this->orderid ? ",$itmname {$this->sortdef} " : "$itmname {$this->sortdef} ");		
		$sSQL .= $items ? " LIMIT " . $items : null;			
	    //echo $sSQL,'<br>';
		
	    $resultset = $db->Execute($sSQL,2);	
		$this->result = $resultset;
		
		$xmax = $imgx?$imgx:100;
		$ymax = $imgy?$imgy:75;		
		
		if ($linemax>1)
		  $out = $this->list_katalog_table($linemax,$xmax,$ymax,$imageclick,0,null,$template,$ainfo,null,$external_read,$pz,1,1,"shkatalogmedia.show_pcat use $p,$category,$items");
		else  	
          $out = $this->list_katalog(null,null,$template,$ainfo,$external_read,$pz,null,null,$linemax,"shkatalogmedia.show_pcat use $p,$category,$items");
		  
		return ($out);	
	}

	function show_orderid($ascdesc=null,$category=null,$items=10,$linemax=null,$imgx=100,$imgy=75,$imageclick=0,$template=null,$ainfo=null,$external_read=null,$photosize=null) {
        $db = GetGlobal('db');		
	    $lan = $lang?$lang:getlocal();
	    $itmname = $lan?'itmname':'itmfname';
	    $itmdescr = $lan?'itmdescr':'itmfdescr';
		$mycat = $category?$category:GetReq('cat');	//auto browse current cat	   
		$cat = explode($this->cseparator,$mycat);			
		$pz = $photosize?$photosize:1;	
		$lastprice = $this->getmapf('lastprice')?','.$this->getmapf('lastprice'):null;		
	                                                                                //,date1
        $sSQL = "select id,sysins,code1,pricepc,price2,sysins,itmname,itmfname,uniname1,uniname2,active,code4," .// from abcproducts";// .
	            "price0,price1,cat0,cat1,cat2,cat3,cat4,itmdescr,itmfdescr,itmremark,ypoloipo1,resources,".
				$this->getmapf('code').
				$lastprice .
				" from products ";
		$sSQL .= " WHERE ";	
		
		foreach ($cat as $i=>$c) {
		  $myc = str_replace('_',' ',$c);		
		  $sSQL .= " cat{$i}='$myc' and ";	
		}  
		//only items inside category ..when category param not specified
	    if ((!$category) && ($this->onlyincategory)) {
		  $ii = $i+1;
		  $sSQL .= " (cat{$ii} IS NULL or cat{$ii}='') and ";		
		}  		
		
		if (($selected_item = GetReq('id')) && (!$xor)) 
		  $sSQL .= $this->getmapf('code') . " not like '" . $selected_item ."' and ";
		  
		//MULTIPLE CHECKS  !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		if ($selected_cat0 = $fields['cat0']) 
		  $sSQL .= "cat0 not like '" . $selected_cat0 . "' and ";		  
		  	
		if ($selected_cat1 = $fields['cat1']) 
		  $sSQL .= "cat1 not like '" . $selected_cat1 . "' and ";		 
		  		  
		if ($selected_cat2 = $fields['cat2']) 
		  $sSQL .= "cat2 not like '" . $selected_cat2 . "' and ";
		  
		if ($selected_cat3 = $fields['cat3']) 
		  $sSQL .= "cat3 not like '" . $selected_cat3 . "' and ";		
		
		if ($selected_item = GetReq('id')) 
		  $sSQL .= $this->getmapf('code') . " not like '" . $selected_item ."' and ";
		  		
		$sSQL .= "orderid >0 and orderid IS NOT NULL and itmactive>0 and active>0";	
		$mysort = $ascdesc ? ($ascdesc=='ASC'?'ASC':'DESC') : $this->sortdef; 
		$sSQL .= " ORDER BY orderid ";// $mysort ";//!!!!!=MUST ASC (=DEFAULT WHEN NOT WRITTEN )
		$sSQL .= $this->bypass_order_list ? null : ",$itmname $mysort ";//MUST DESC		
		$sSQL .= $items ? " LIMIT " . $items : null;			
	    //echo $sSQL,'<br>';
		
	    $resultset = $db->Execute($sSQL,2);	
		$this->result = $resultset;
		
		$xmax = $imgx?$imgx:100;
		$ymax = $imgy?$imgy:75;		
		
		if ($linemax>1)
		  $out = $this->list_katalog_table($linemax,$xmax,$ymax,$imageclick,0,null,$template,$ainfo,null,$external_read,$pz,1,1,"shkatalogmedia.show_pcat use $p,$category,$items");
		else  	
          $out = $this->list_katalog(null,null,$template,$ainfo,$external_read,$pz,null,null,$linemax,"shkatalogmedia.show_pcat use $p,$category,$items");
		  
		return ($out);	
	}	
	
	function show_orderidis($orderid=null,$items=10,$linemax=null,$imgx=100,$imgy=75,$imageclick=0,$template=null,$ainfo=null,$external_read=null,$photosize=null) {
        $db = GetGlobal('db');		
	    $lan = $lang?$lang:getlocal();
	    $itmname = $lan?'itmname':'itmfname';
	    $itmdescr = $lan?'itmdescr':'itmfdescr';
		$mycat = $category?$category:GetReq('cat');	//auto browse current cat	   
		$cat = explode($this->cseparator,$mycat);			
		$pz = $photosize?$photosize:1;	
		$lastprice = $this->getmapf('lastprice')?','.$this->getmapf('lastprice'):null;		
	                                                                                //,date1
        $sSQL = "select id,sysins,code1,pricepc,price2,sysins,itmname,itmfname,uniname1,uniname2,active,code4," .// from abcproducts";// .
	            "price0,price1,cat0,cat1,cat2,cat3,cat4,itmdescr,itmfdescr,itmremark,ypoloipo1,resources,".
				$this->getmapf('code').
				$lastprice .
				" from products ";
		$sSQL .= " WHERE ";		
			
		$sSQL .= "orderid = $orderid and orderid IS NOT NULL and itmactive>0 and active>0";	
		$sSQL .= " ORDER BY orderid ";
		$sSQL .= $this->bypass_order_list ? null : ",$itmname {$this->sortdef} ";		
		$sSQL .= $items ? " LIMIT " . $items : null;			
	    //echo $sSQL,'<br>';
		
	    $resultset = $db->Execute($sSQL,2);	
		$this->result = $resultset;
		
		$xmax = $imgx?$imgx:100;
		$ymax = $imgy?$imgy:75;		
		
		if ($linemax>1)
		  $out = $this->list_katalog_table($linemax,$xmax,$ymax,$imageclick,0,null,$template,$ainfo,null,$external_read,$pz,1,1,"shkatalogmedia.show_pcat use $p,$category,$items");
		else  	
          $out = $this->list_katalog(null,null,$template,$ainfo,$external_read,$pz,null,null,$linemax,"shkatalogmedia.show_pcat use $p,$category,$items");
		  
		return ($out);	
	}	
	
	function show_resources($contition,$items=10,$linemax=null,$imgx=100,$imgy=null,$imageclick=0,$template=null,$ainfo=null,$external_read=null,$photosize=null,$ofield=null,$desc=null) {
        $db = GetGlobal('db');		
	    $lan = $lang?$lang:getlocal();
	    $itmname = $lan?'itmname':'itmfname';
	    $itmdescr = $lan?'itmdescr':'itmfdescr';				
		$pz = $photosize?$photosize:1;	
		$lastprice = $this->getmapf('lastprice')?','.$this->getmapf('lastprice'):null;	
        $ordfield = $ofield ? $ofield : $itmname;
        $ascd = $desc ? "desc" : "asc"; 		
	                                                                                //,date1
        $sSQL = "select id,sysins,code1,pricepc,price2,sysins,itmname,itmfname,uniname1,uniname2,active,code4," .// from abcproducts";// .
	            "price0,price1,cat0,cat1,cat2,cat3,cat4,itmdescr,itmfdescr,itmremark,ypoloipo1,resources,".
				$this->getmapf('code').
				$lastprice .
				" from products ";
		$sSQL .= " WHERE ";	
		
		if ($selected_item = GetReq('id')) 
		  $sSQL .= $this->getmapf('code') . " not like '" . $selected_item ."' and ";
		  		
		$sSQL .= $contition."='".$this->toggler[1]."' and itmactive>0 and active>0";	
		//$sSQL .= " ORDER BY $itmname asc ";
		$sSQL .= " ORDER BY " . $ordfield . " ".  $ascd;
		$sSQL .= $items ? " LIMIT " . $items : null;			
	    //echo $sSQL,'<br>';
		
	    $resultset = $db->Execute($sSQL,2);	
		$this->result = $resultset;
		
		$xmax = $imgx?$imgx:100;
		$ymax = $imgy?$imgy:null; //free y 75;		
		
		if ($linemax>1)
		  $out = $this->list_katalog_table($linemax,$xmax,$ymax,$imageclick,0,null,$template,$ainfo,null,$external_read,$pz,1,1,"shkatalogmedia.show_resources use $contition,$items");
		else  	
          $out = $this->list_katalog(null,null,$template,$ainfo,$external_read,$pz,1,1,1,"shkatalogmedia.show_resources use $contition,$items");
		  
		return ($out);	
	}			
	 
	//override
	function show_special($contition,$items=10,$days=12,$linemax=null,$imgx=100,$imgy=null,$imageclick=0,$template=null,$ainfo=null,$external_read=null,$photosize=null) {
        $db = GetGlobal('db');		
	    $lan = $lang?$lang:getlocal();
	    $itmname = $lan?'itmname':'itmfname';
	    $itmdescr = $lan?'itmdescr':'itmfdescr';		
	    $date2check = time() - ($days * 24 * 60 * 60);
	    $entrydate = date('Y-m-d',$date2check);		
		$pz = $photosize?$photosize:1;	
        $lastprice = $this->getmapf('lastprice')?','.$this->getmapf('lastprice'):null;				
	                                                                                //,date1
        $sSQL = "select id,sysins,code1,pricepc,price2,sysins,itmname,itmfname,uniname1,uniname2,active,code4," .// from abcproducts";// .
	            "price0,price1,cat0,cat1,cat2,cat3,cat4,itmdescr,itmfdescr,itmremark,ypoloipo1,resources,".
				$this->getmapf('code').
				$lastprice .
				" from products ";
		$sSQL .= " WHERE ";	
		
		if ($selected_item = GetReq('id')) 
		  $sSQL .= $this->getmapf('code') . " not like '" . $selected_item ."' and ";
		  		
		$sSQL .= $contition."='".$this->toggler[1]."' and itmactive>0 and active>0";	
		$sSQL .= " ORDER BY {$this->orderid}";			
		$sSQL .= $this->bypass_order_list ? null : 
		         ($this->orderid ? ",$itmname {$this->sortdef} " : "$itmname {$this->sortdef} ");
		$sSQL .= $items ? " LIMIT " . $items : null;		 
	    //echo $sSQL;
		
	    $resultset = $db->Execute($sSQL,2);	
		$this->result = $resultset;
		
		$xmax = $imgx?$imgx:100;
		$ymax = $imgy?$imgy:null;//free y 75;		
		
		if ($linemax>1)
		  $out = $this->list_katalog_table($linemax,$xmax,$ymax,$imageclick,0,null,$template,$ainfo,null,$external_read,$pz,1,1,"shkatalogmedia.show_special use $contition,$items");
		else  	
          $out = $this->list_katalog(null,null,$template,$ainfo,null,$external_read,$pz,1,1,1,"shkatalogmedia.show_special use $contition,$items");
		  
		return ($out);	
	}	
	
	function show_special_online($field2check,$items=10,$linemax=null,$imgx=100,$imgy=null,$imageclick=0,$template=null,$ainfo=null,$external_read=null,$photosize=null,$key=null) {
        $db = GetGlobal('db');
		$dbbuffer = GetGlobal('_sqlbuffer');		
	    $lan = $lang?$lang:getlocal();
	    $itmname = $lan?'itmname':'itmfname';
	    $itmdescr = $lan?'itmdescr':'itmfdescr';
		$pz = $photosize?$photosize:1;						
		$p = null;
        $lastprice = $this->getmapf('lastprice')?','.$this->getmapf('lastprice'):null;			
		$table2check = 'products';
		$fields = $this->result->fields;				
		//print_r($fields);
		//echo $key,'>';
		
		if  ($p = GetReq($field2check)) {
	
		    $mode = 'uri';
	    } 
		elseif (($p = $fields[$field2check]) || (!empty($dbbuffer))) {//current query exist..default selection...querydepth = 0
		  
		    $mode = 'query'; //already executed query			  
		}
		else {
		  if ($key) {//default mode for origin function...	
		    $mode = null; 	// default 
		    $p = str_replace('_SLASH_','/',str_replace('_COMMA_',',',str_replace('_AMP_','&',$key))); //get data from origin func		
		  }
		  else {
		    //echo '>>>>>>>',$field2check,':',$p,':',$mode,'>>>>>>';
		    return;		
		  } 
		}
	    //echo '>>>>>>>',$field2check,':',$p,':',$mode,'>>>>>>';				
	                                                                                //,date1
        $sSQL = "select id,sysins,code1,pricepc,price2,sysins,itmname,itmfname,uniname1,uniname2,active,code4," .// from abcproducts";// .
	            "price0,price1,cat0,cat1,cat2,cat3,cat4,itmdescr,itmfdescr,itmremark,ypoloipo1,resources,".
				$this->getmapf('code').
				$lastprice .
				" from products ";
		$sSQL .= " WHERE (";	
		
		switch ($mode) {

		  case 'query':	//print_r($dbbuffer);
	                    $rbuf = array_reverse($dbbuffer);		  						
						//print_r($rbuf);
						$myselect = explode('products',$sSQL);	
						$a = trim($myselect[0]);	  
                        foreach ($rbuf as $bfid=>$bfdata) { 
			              $bfsql = explode('products',$bfdata['query']);//exclude where ..we want only select fields to be the same
						  $b = trim($bfsql[0]);
						  //echo '<br>',$bfid,'<br>',$b,':<br>',$a;						  
				          //if ($myselect[0]==$bfsql[0]) {//check identical queries
						  if (strcmp($a,$b)==0) {//check identical queries
                            //echo '<pre>';print_r($rbuf);echo '</pre>';						  
				            //echo '<br>TRUE<br>',$bfid,$bfdata['query'],'<br>',$myselect[0],'>>>>';
					        //override p val 
							//print_r($bfdata);
				            $p = $bfdata['data'][$field2check]; 
							$sp = str_replace('/','_SLASH_',str_replace(',','_COMMA_',str_replace('&','_AMP_',$p)));//url rewrite error '/'
                            $key = urlencode($sp);	//holds data pass as func origin arg								
							break;
				          }	
			            }						
						//$p = $rbuf[0]->data->$field2check;
		                $sSQL .= $field2check . "="  .(is_numeric($p)?$p:"'".$p."'"); 
		                break;
						
		  case 'uri'  :	$sSQL .= $field2check . "="  .(is_numeric($p)?$p:"'".$p."'");	  
		                break;	
		  
		  default     : $sSQL .= $field2check . "="  .(is_numeric($p)?$p:"'".$p."'");//arg special 
		                break;						
		} 
		
		//if ($advsql = $this->sql_search_relative_titles($fields[$itmdescr],'cat2'))
		  //$sSQL .= ' or ' . $this->getmapf('code') . ' in (' . $advsql . ')';		  		
		
		$sSQL .= ") and itmactive>0 and active>0";
		 	
		if ($selected_item = GetReq('id')) 
		  $sSQL .= " and " . $this->getmapf('code') . " not like '" . $selected_item . "'";
		  
		//MULTIPLE CHECKS  
		//if ($selected_cat = $fields['cat2']) 
		 // $sSQL .= " and " . "cat2 not like '" . $selected_cat . "'";		  		
		$sSQL .= " ORDER BY {$this->orderid}";
		$sSQL .= $this->bypass_order_list ? null : 
		         ($this->orderid ? ",$itmname {$this->sortdef} " : "$itmname {$this->sortdef} ");		
		$sSQL .= $items ? " LIMIT " . $items : null;		
        //echo $mode;		
	    //echo '???',$sSQL,'---<hr>',$p;
		
	    $resultset = $db->Execute($sSQL,2);	
		$this->result = $resultset;
		
		$xmax = $imgx?$imgx:100;
		$ymax = $imgy?$imgy:null;//free y 75;		
		
		if ($linemax>1)
		  $out = $this->list_katalog_table($linemax,$xmax,$ymax,$imageclick,0,null,$template,$ainfo,null,$external_read,$pz,0,1,"shkatalogmedia.show_special_online use $field2check,$items,null,null,null,0,null,null,null,null,$key");
		else  	
          $out = $this->list_katalog(null,null,$template,$ainfo,$external_read,$pz,0,1,1,"shkatalogmedia.show_special_online use $field2check,$items,null,null,null,0,null,null,null,null,$key");
		  		  
		return ($out);	
	}			
	
	//alias
	function show_relatives($key,$field2check=null,$items=10,$linemax=null,$imgx=100,$imgy=null,$imageclick=0,$template=null,$ainfo=null,$external_read=null,$photosize=null) {
	
      $ret = show_special_online($field2check,$items,$linemax,$imgx,$imgy,$imageclick,$template,$ainfo,$external_read,$photosize,$key);	
	  return ($ret);
	}
	
	//??? NOT USED ????
	function sql_search_relative_titles($mastertitle,$field2check) {
        $db = GetGlobal('db');	
	    $lan = $lang?$lang:getlocal();
	    $itmname = $lan?'itmname':'itmfname';
	    $itmdescr = $lan?'itmdescr':'itmfdescr';
		$remarks = 'itmremark';	
		$sqlout = null;		
	
	    $mt = explode(' ',trim($mastertitle));
        //print_r($mt);
        $sSQL = "select ".$this->getmapf('code')." from products where "; //whole words...
		  		
	    foreach ($mt as $i=>$lex) {
		
		  if (($la = trim($lex)) && (strlen($la)>4))  {//words max than 4 chars
		
		  $ulex = strtoupper($lex);
		  $dlex = strtolower($lex);
          
		  $sqlout[$lex] = "$itmname like '%$lex%' ";// or $itmdescr like '%$lex%' or $remarks like '%$lex%'";// or "; //as is
		  //$sSQL .= "$itmname like '% $ulex %' or $itmdescr like '% $ulex %' or $remarks like '% $ulex %' or "; //upper case		
		  //$sSQL .= "$itmname like '% $dlex %' or $itmdescr like '% $dlex %' or $remarks like '% $dlex %'"; //lower case		
		  
		  }//if lex
		} 
		
        //print_r($sqlout);  
		if ($sqlout) {
		  $sSQL .= implode(' or ',$sqlout);		  
		  return ($sSQL);
		}
		else
		  return null;
	} 
	
	function show_relative_sales($id,$items=10,$linemax=null,$imgx=100,$imgy=null,$imageclick=0,$template=null,$ainfo=null,$external_read=null,$photosize=null) {
	   $myid = $id?$id:GetReq('id');
       $db = GetGlobal('db');		
	   $lan = $lang?$lang:getlocal();
	   $itmname = $lan?'itmname':'itmfname';
	   $itmdescr = $lan?'itmdescr':'itmfdescr';		
	   //$date2check = time() - ($days * 24 * 60 * 60);
	   //$entrydate = date('Y-m-d',$date2check);		
	   $pz = $photosize?$photosize:1;	  
       $lastprice = $this->getmapf('lastprice')?','.$this->getmapf('lastprice'):null;		    
	
       if ( (defined('SHTRANSACTIONS_DPC')) && (seclevel('SHTRANSACTIONS_DPC',decode(GetSessionParam('UserSecID')))) ) {

	     $itemslist = GetGlobal('controller')->calldpc_method('shtransactions.getRelativeSales use '.$items.'+'.$myid);
	     //print_r($itemslist); //echo 'z';
		 
		 if (!empty($itemslist)) {
		 
           $sSQL = "select id,sysins,code1,pricepc,price2,sysins,itmname,itmfname,uniname1,uniname2,active,code4," .// from abcproducts";// .
	               "price0,price1,cat0,cat1,cat2,cat3,cat4,itmdescr,itmfdescr,itmremark,ypoloipo1,resources,".
				   $this->getmapf('code') .
				   $lastprice .
				   " from products ";
		   $sSQL .= " WHERE (";	
		
		   foreach ($itemslist as $i=>$code)
		     $preSQL[] = $this->getmapf('code') . " = '" . $code ."'";
			 
		   $sSQL .= implode(' or ',$preSQL);
		  		
		   $sSQL .= ") and itmactive>0 and active>0";	
		   $sSQL .= " ORDER BY {$this->orderid} ";			
		   $sSQL .= $this->bypass_order_list ? null : 
		            ($this->orderid ? ",$itmname {$this->sortdef} " : "$itmname {$this->sortdef} ");		
		   $sSQL .= $items ? " LIMIT " . $items : null;
	       //echo $sSQL;
		
	       $resultset = $db->Execute($sSQL,2);	
		   $this->result = $resultset;
		
		   $xmax = $imgx?$imgx:100;
		   $ymax = $imgy?$imgy:null;//free y 75;		
		
		   if ($linemax>1)
		     $out = $this->list_katalog_table($linemax,$xmax,$ymax,$imageclick,0,null,$template,$ainfo,null,$external_read,$pz,1,1,"shkatalogmedia.show_relative_sales use $myid,$items");
		   else  	
             $out = $this->list_katalog(null,null,$template,$ainfo,$external_read,$pz,null,1,1,"shkatalogmedia.show_relative_sales use $myid,$items");
		 }	 		 		 
	   }
	   return ($out);  
	}
	
	//override
	function show_kategory_items($category=null,$items=10,$linemax=null,$imgx=100,$imgy=null,$imageclick=0,$template=null,$ainfo=null,$external_read=null,$photosize=null,$xor=null) {
        $db = GetGlobal('db');
	    $lan = $lang?$lang:getlocal();
	    $itmname = $lan?'itmname':'itmfname';
	    $itmdescr = $lan?'itmdescr':'itmfdescr';			
		$mycat = $category?$category:GetReq('cat');	//auto browse current cat	   
		$cat = explode($this->cseparator,$mycat);		
		$pz = $photosize?$photosize:1;
        $lastprice = $this->getmapf('lastprice')?','.$this->getmapf('lastprice'):null;			
				
		//auto browse current cat
		$fields = $this->result->fields; //prev query exclude cat		
	    //echo 'z'; print_r($fields);                                                                            //,date1
        $sSQL = "select id,sysins,code1,pricepc,price2,sysins,itmname,itmfname,uniname1,uniname2,active,code4," .// from abcproducts";// .
	            "price0,price1,cat0,cat1,cat2,cat3,cat4,itmdescr,itmfdescr,itmremark,ypoloipo1,".
				$this->getmapf('code').
				$lastprice.
				" from products ";
		$sSQL .= " WHERE ";	
		foreach ($cat as $i=>$c) {
		  $myc = str_replace('_',' ',$c);		
		  $sSQL .= " cat{$i}='$myc' and ";	
		}  
		//only items inside category ..when category param not specified
	    if ((!$category) && ($this->onlyincategory)) {
		  $ii = $i+1;
		  $sSQL .= " (cat{$ii} IS NULL or cat{$ii}='') and ";		
		}  		
		
		if (($selected_item = GetReq('id')) && (!$xor)) 
		  $sSQL .= $this->getmapf('code') . " not like '" . $selected_item ."' and ";
		  
		//MULTIPLE CHECKS  !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		if ($selected_cat0 = $fields['cat0']) 
		  $sSQL .= "cat0 not like '" . $selected_cat0 . "' and ";		  
		  	
		if ($selected_cat1 = $fields['cat1']) 
		  $sSQL .= "cat1 not like '" . $selected_cat1 . "' and ";		 
		  		  
		if ($selected_cat2 = $fields['cat2']) 
		  $sSQL .= "cat2 not like '" . $selected_cat2 . "' and ";
		  
		if ($selected_cat3 = $fields['cat3']) 
		  $sSQL .= "cat3 not like '" . $selected_cat3 . "' and ";
		  		  		  
		  
		$sSQL .= "itmactive>0 and active>0";	
		$sSQL .= " ORDER BY {$this->orderid}";	
		$sSQL .= $this->bypass_order_list ? null : 
		         ($this->orderid ? ",$itmname {$this->sortdef} " : "$itmname {$this->sortdef} ");		
		$sSQL .= $items ? " LIMIT " . $items : null;			
	    //echo $sSQL;
		
	    $resultset = $db->Execute($sSQL,2);	
		$this->result = $resultset;
		
		$xmax = $imgx?$imgx:100;
		$ymax = $imgy?$imgy:null;//free y 75;	
		
		if ($linemax>1) 
		  $out = $this->list_katalog_table($linemax,$xmax,$ymax,$imageclick,0,null,$template,$ainfo,null,$external_read,$pz,1,1,"shkatalogmedia.show_kategory_items use $category,$items");
		else  	
          $out = $this->list_katalog(null,null,$template,$ainfo,$external_read,$pz,null,1,1,"shkatalogmedia.show_kategory_items use $category,$items"); 
		  
		return ($out);	
	}	
	
	//for sitemap call
	function show_sitemap_items($category=null,$items=10,$linemax=null,$imgx=100,$imgy=null,$imageclick=0,$template=null,$ainfo=null,$external_read=null,$photosize=null,$xor=null) {
        $db = GetGlobal('db');
	    $lan = $lang?$lang:getlocal();
	    $itmname = $lan?'itmname':'itmfname';
	    $itmdescr = $lan?'itmdescr':'itmfdescr';			
		$mycat = $category?$category:GetReq('cat');	//auto browse current cat	   
		$cat = explode($this->cseparator,$mycat);		
		$pz = $photosize?$photosize:1;
        $lastprice = $this->getmapf('lastprice')?','.$this->getmapf('lastprice'):null;			
				
		//auto browse current cat
		$fields = $this->result->fields; //prev query exclude cat		
	    //echo 'z'; print_r($fields);                                                                            //,date1
        $sSQL = "select id,sysins,code1,pricepc,price2,sysins,itmname,itmfname,uniname1,uniname2,active,code4," .// from abcproducts";// .
	            "price0,price1,cat0,cat1,cat2,cat3,cat4,itmdescr,itmfdescr,itmremark,ypoloipo1,".
				$this->getmapf('code').
				$lastprice.
				" from products ";
		$sSQL .= " WHERE ";		  		  
		$sSQL .= "itmactive>0 and active>0";	
		$sSQL .= " ORDER BY sysupd DESC LIMIT 2000";// . $items;	//<<<<<<		
	    //echo $sSQL;
		
	    $resultset = $db->Execute($sSQL,2);	
		$this->result = $resultset;
		
		$xmax = $imgx?$imgx:100;
		$ymax = $imgy?$imgy:null;//free y 75;	
		
		if ($linemax>1) 
		  $out = $this->list_katalog_table($linemax,$xmax,$ymax,$imageclick,0,null,$template,$ainfo,null,$external_read,$pz,1,1,"shkatalogmedia.show_kategory_items use $category,$items");
		else  	
          $out = $this->list_katalog(null,null,$template,$ainfo,$external_read,$pz,null,1,1,"shkatalogmedia.show_kategory_items use $category,$items"); 
		  
		return ($out);	
	}		
	
	function show_sitemap($template=null) {
       $db = GetGlobal('db');
	   //$lan = GetReq('lan')>=0?GetReq('lan'):getlocal();	//in case of post sitemap set lan param uri   
	   $lan = getlocal() ? getlocal() : '0';
	   $itmname = $lan?'itmname':'itmfname';
	   $itmdescr = $lan?'itmdescr':'itmfdescr';	 
	   $start = GetReq('start');
	   $headcat = GetReq('headcat')?GetReq('headcat'):"";	   
	   $meter = $start?$start-1:0;  

       $mytemplate = $template ? $this->select_template($template) : null;	   
	   
	   	
       $sSQL = "select id,itmname,itmfname,cat0,cat1,cat2,cat3,cat4,itmdescr,itmfdescr,itmremark,".$this->getmapf('code')." from products ";
	   $sSQL .= " WHERE ";
	   $sSQL .= "itmactive>0 and active>0";	
	   //$sSQL .= " GROUP BY cat0,$itmname";
	   $sSQL .= " ORDER BY cat0,cat1,cat2,cat3,cat4,$itmname asc ";
	   $sSQL .= $start ? " LIMIT $start,10000" : " LIMIT 10000";			
	   //echo $sSQL;
		
	   $resultset = $db->Execute($sSQL,2);	
	   $result = $resultset;
		   
	   if (!empty($result)) {		   
	    
		if ($headcat)//next page start with headcat
  	      $out = '<h2>' . str_replace('_',' ',$headcat) . '</h2><hr/>';
	
	    foreach ($result as $n=>$rec) {
		
		   //memory limit prevention
		   //echo 'mem limit 33554432:',memory_get_peak_usage(true);//memory_get_usage();
		   
		   /*$mem = memory_get_peak_usage(true);//memory_get_usage();
		   if ($mem>16000000) {
		     $np = $meter-1;
		     $nextpage = "<br><h2><a href='sitemap.php?start=$np&headcat=$headcat'> Next Page</a></h2>";
		     $out .= $nextpage;//'<br><h2>WARNING:Memory allocation failed, reduce page view limit!</h2>';
		     break;
		   }*/
		   //echo 'z';
		   if (!empty($rec)) {
		   
		     $meter+=1;
             $cat = $this->getkategories($rec,1,$lan,'klist');		 
             $linkcat = $this->getkategories($rec,null);	
			 		   
			 if (strtolower($headcat)!=strtolower($cat)) {//paging start
			   $headcat = $cat;
			   //echo $headcat;
			   if (strstr($headcat,'</A>'.$this->cseparator.'<A')) //link
			     $ret .= '<h2>' . str_replace('</A>'.$this->cseparator.'<A','</A>'.$this->rightarrow.'<A', str_replace('_',' ',$headcat)) . '</h2><hr>';
			   else			   
			     $ret .= '<h2>' . str_replace($this->cseparator,$this->rightarrow,str_replace('_',' ',$headcat)) . '</h2><hr>';
			 }
			 $title = $rec[$this->getmapf('code')] . "&nbsp;" . $rec[$itmname] /*. "&nbsp;" . $rec[$itmdescr] . "&nbsp;" .  $rec[$itmremark]*/;
			 
		     $itemlinkname = seturl('t=kshow&cat='.$linkcat.'&id='.$rec[$this->getmapf('code')],$title,null,null,null,$this->rewrite );		   
			 
			 if ($mytemplate) {
			    $tokens = array(); //reset 
				$tokens[] = $meter; 
				$tokens[] = $itemlinkname; 
				$tokens[] = $rec[$this->getmapf('code')];
				$tokens[] = $rec[$itmname];
                $ret .= $this->combine_tokens($mytemplate, $tokens);			 
			 }
			 else
			    $ret .= $meter . "&nbsp;" . $itemlinkname . "<br/>";	
		     //$ret .= "<hr>";		   
		   }
		 }
		 
		 if (($mytemplate) && (stristr($mytemplate,'<SPLIT/>')) && ($this->linemax)) {
		    $items = explode('<SPLIT/>',$ret); //<li> split..
			$out .= $this->make_table($items, $this->linemax, 'fpkatalogtable'); 
		 }
		 else
		    $out .= $ret;
	   }   
	   
       //feed links
       $ret .= $this->get_xml_links(null,null,'shkatalogmedia.show_sitemap_items');		   
	   
	   return ($ret);		   		   	
	}
	
	function read_item_attr($item=null,$attr=null,$islink=null) {
        $db = GetGlobal('db');		
	    $lan = $lang?$lang:getlocal();
	    $itmname = $lan?'itmname':'itmfname';
	    $itmdescr = $lan?'itmdescr':'itmfdescr';				
		$pz = $photosize?$photosize:1;	
		$lastprice = $this->getmapf('lastprice')?','.$this->getmapf('lastprice'):null;	
		
		if (!$item) 
		  $item = GetReq('id');	
		  //$item = GetGlobal('controller')->calldpc_var('shtags.tagitem');
		
        $sSQL = "select id,sysins,code1,pricepc,price2,sysins,itmname,itmfname,uniname1,uniname2,active,code4," .// from abcproducts";// .
	            "price0,price1,cat0,cat1,cat2,cat3,cat4,itmdescr,itmfdescr,itmremark,ypoloipo1,resources,weight,volume,".
			    $this->getmapf('code').
				$lastprice .
				" from products ";
		$sSQL .= " WHERE ";
		$sSQL .= $this->getmapf('code') . "= '" . $item ."'";
		//echo $sSQL;
	    $resultset = $db->Execute($sSQL,2);	
		$result = $resultset;
		//print_r($result);
	    foreach ($result as $n=>$rec) {
		  if ($islink) {
		    $cat = $this->getkategories($rec);
			$ucat = $cat;//urlencode($cat);
		  	$itemlink = seturl('t=kshow&cat='.$ucat.'&id='.$rec[$this->getmapf('code')],$rec[$attr]);
			return ($itemlink);
		  }
		  else
		    return ($rec[$attr]);	
		}  									
	}
	
	function read_item_weight($itemsarray=null,$items=10,$linemax=null,$imgx=100,$imgy=null,$imageclick=0,$template=null,$ainfo=null,$external_read=null,$photosize=null) {
        $db = GetGlobal('db');		
	    $lan = $lang?$lang:getlocal();
	    $itmname = $lan?'itmname':'itmfname';
	    $itmdescr = $lan?'itmdescr':'itmfdescr';				
		$pz = $photosize?$photosize:1;	
		$lastprice = $this->getmapf('lastprice')?','.$this->getmapf('lastprice'):null;
		
		if (!$itemsarray) return;		
	                                                                                //,date1
        $sSQL = "select id,sysins,code1,pricepc,price2,sysins,itmname,itmfname,uniname1,uniname2,active,code4," .// from abcproducts";// .
	            "price0,price1,cat0,cat1,cat2,cat3,cat4,itmdescr,itmfdescr,itmremark,ypoloipo1,resources,weight,volume,".
			    $this->getmapf('code').
				$lastprice .
				" from products ";
		$sSQL .= " WHERE ";	
		
        if (strstr($itemsarray,';')) {
		
		  $items = explode(';',$itemsarray);
		
		  foreach ($items as $code)
		    $tempSQL[] = $this->getmapf('code') . "= '" . $code ."'";
			
		  $sSQL .= implode(' OR ',$tempSQL);	
		} 
		else //one item
		  $sSQL .= $this->getmapf('code') . "= '" . $itemsarray ."'";
		  		
		
	    //echo $sSQL,'<br>';
		
	    $resultset = $db->Execute($sSQL,2);	
		$this->result = $resultset;
		
		$xmax = $imgx?$imgx:100;
		$ymax = $imgy?$imgy:null;//free y 75;		
		
		if ($linemax>1)
		  $out = $this->list_katalog_table($linemax,$xmax,$ymax,$imageclick,0,null,$template,$ainfo,null,$external_read,$pz,1);
		elseif ($linemax==1)  	
          $out = $this->list_katalog(null,null,$template,$ainfo,null,$external_read,$pz,1,null,$linemax);
		else {//return val
		  
		   foreach ($this->result as $n=>$rec) {
		     $out[$rec[$this->getmapf('code')]] = floatval($rec['weight']);
		   }
           //print_r($out);
		}  
		
		return ($out);	
	}		
	
	//override
	function show_last_viewed_items($items=10,$linemax=null,$imgx=100,$imgy=null,$imageclick=0,$template=null,$ainfo=null,$external_read=null,$photosize=null,$nopager=null,$notable=null) {
        $db = GetGlobal('db');
        $UserName = GetGlobal('UserName');			
	    $lan = $lang?$lang:getlocal();
	    $itmname = $lan?'itmname':'itmfname';
	    $itmdescr = $lan?'itmdescr':'itmfdescr';				
		
		$c = $category?$category:GetReq('cat');	//auto browse current cat
		//$c = $category ? $category : GetGlobal('controller')->calldpc_var('shtags.tagcat'); 
		
		$cat = explode($this->cseparator,$c);		
	    $date2check = time() - ($days * 24 * 60 * 60);
	    $entrydate = date('Y-m-d',$date2check);		
		$pz = $photosize?$photosize:1;
		$resources = 1;
			
		
        $sSQL = "select products.id,sysins,code1,pricepc,price2,sysins,itmname,itmfname,uniname1,uniname2,active,code4,".
	            "price0,price1,cat0,cat1,cat2,cat3,cat4,itmdescr,itmfdescr,itmremark,ypoloipo1,resources,weight,volume,".$this->getmapf('code').
				",stats.id,stats.tid from products, stats ";
		$sSQL .= " WHERE stats.tid=products.".$this->getmapf('code')." and products.itmactive>0 and products.active>0";				
		
		if ($UserName)
		  $sSQL .= " and (attr2='" . decode($UserName) . "' or attr2='". session_id() . "')";
		else  
		  $sSQL .= " and attr2='" . session_id() . "'";
		  
		$sSQL .= " GROUP BY stats.tid ORDER BY stats.id DESC limit " . $items;
		
		//echo $sSQL;	
	    $resultset = $db->Execute($sSQL,2);	
		//print_r($resultset);
		$this->result = $resultset;
		
		$xmax = $imgx?$imgx:100;
		$ymax = $imgy?$imgy:null;// free y 75;		
		
		//echo $nopager,'>',$photosize;

		if ($linemax>1)
		  $out = $this->list_katalog_table($linemax,$xmax,$ymax,$imageclick,0,null,$template,$ainfo,null,$external_read,$pz,$resources,$nopager,null,$notable);
		else  	
          $out = $this->list_katalog(null,null,$template,$ainfo,$external_read,$pz,$resources,$nopager,1);
		  
		return ($out);				
	}	
	
	//override
	function show_offers($items=10,$cat=null,$linemax=null,$imgx=100,$imgy=null,$imageclick=0,$template=null,$ainfo=null,$external_read=null,$photosize=null,$nopager=null,$notable=null) {
        $db = GetGlobal('db');
	    $lan = $lang?$lang:getlocal();
	    $itmname = $lan?'itmname':'itmfname';
	    $itmdescr = $lan?'itmdescr':'itmfdescr';				
		
	    //$date2check = time() - ($days * 24 * 60 * 60);
	    //$entrydate = date('Y-m-d',$date2check);
		$pz = $photosize?$photosize:1;			
	                                                                                //,date1
        $sSQL = "select id,sysins,code1,pricepc,price2,sysins,itmname,itmfname,uniname1,uniname2,active,code4," .// from abcproducts";// .
	            "price0,price1,cat0,cat1,cat2,cat3,cat4,itmdescr,itmfdescr,itmremark,ypoloipo1,".$this->getmapf('code')." from products ";
		$sSQL .= " WHERE ";	
		//echo $cat;
		if ($cat) {
		  $c = explode($this->cseparator, str_replace('_',' ',$cat)); //print_r($cat);
		  foreach ($c as $cc=>$category)
			$sSQL .= "cat".$cc."='" . $category . "' and ";
	    }
		
		if ($selected_item = GetReq('id')) 
		  $sSQL .= $this->getmapf('code') . " not like '" . $selected_item ."' and ";
		  		
		$sSQL .= $this->getmapf('offer')."='".$this->toggler[1]."' and itmactive>0 and active>0";	
		$sSQL .= " ORDER BY ". "{$this->orderid}";			
		$sSQL .= $this->bypass_order_list ? null : 
		         ($this->orderid ? ",$itmname {$this->sortdef} " : "$itmname {$this->sortdef} ");		
		$sSQL .= $items ? " LIMIT " . $items : null;			
	    //echo $sSQL;
		
	    $resultset = $db->Execute($sSQL,2);	
		$this->result = $resultset;
		
		$xmax = $imgx?$imgx:100;
		$ymax = $imgy?$imgy:null;// free y 75;		
		
		if ($linemax>1)
		  $out = $this->list_katalog_table($linemax,$xmax,$ymax,$imageclick,0,null,$template,$ainfo,null,$external_read,$pz,$resources,$nopager,null,$notable);
		else  	
          $out = $this->list_katalog(null,null,$template,$ainfo,$external_read,$pz,$nopager,$linemax);
		  
		return ($out);	
	}	
		
	
    function katalog_feed($read_all=false, $off_categories=false, $off_items=false) {
      $db = GetGlobal('db');
	  $lan = getlocal();	  
	  $itmname = $lan?'itmname':'itmfname';
	  $itmdescr = $lan?'itmdescr':'itmfdescr';	  
      $format = GetReq('format')?GetReq('format'):'rss2';	
      //echo '>',$format;	
	  $code = $this->getmapf('code');
      $i=0;	  
	  $isutf8 = (stristr($this->encoding, 'utf8')) ? true : false;
	  //echo $isutf8,'>';
	  if ($read_all)
	    $this->read_all_items();

      $xml = new pxml();
      $xml->encoding = $this->encoding;	//must be utf8 not utf-8
	  //echo $this->encoding;
		  
      $this->xml_formater($xml,$format,1);	  

	  //categories  
	  if (!$off_categories) {
	  
      $ddir = $this->read_tree(GetReq('cat'),null,1);
	  
	  if (!empty($ddir)) {
	        foreach ($ddir as $g=>$lan_g) {
			
			       $cat = GetReq('cat');
				   $c = $cat ? $cat.$this->cseparator.$g : $g;
				   $cat_url = 'http://' . $this->url . '/' . seturl('t=klist&cat='. $c ,null,null,null,null,$this->rewrite);
			
		           $p[] = $g;
			       $p[] = $lan_g;//$isutf8 ? $lan_g : iconv($this->encoding, "UTF-8", $lan_g);
                   $p[] = $cat_url;			   
			       $p[] = $cat;//urlencode($cat);//GetReq('cat');//$cat;
			       $p[] = $lan_g;//$isutf8 ? $lan_g : iconv($this->encoding, "UTF-8", $lan_g);
			       $p[] = null;
			       $p[] = null;
				   $p[] = null;
				   $p[] = null;
				   $p[] = null;
				   $p[] = null;
				   $p[] = null;	
                   $p[] = null; 				   
				   
			       $this->xml_formater($xml,$format,null,$p);
				   unset($p);	//holds record data to pass it at xml formater				  	 
			 
			       $i+=1;
            }				   
	  }
	  }//off
	  
	  //items  
	  if (!$off_items) {
	  if (!empty($this->result)) {		  	
		
	    foreach ($this->result as $n=>$rec) {
			  
            $cat = $this->getkategories($rec); //GetReq('cat')..no category in url..			  

            //$pp = GetGlobal('controller')->calldpc_method($mykatalogscript.".read_policy");			  
			
		    //if ($rec[$pp]>0) { //check price... 
				   //$myp = GetGlobal('controller')->calldpc_method($mykatalogscript.".spt use ".$rec[$pp]."+".$ptax); 
					 
				   //echo $ptax,$myp;
				   /*if ($decimal_point)
		             $price = number_format($myp,2,$decimal_point,'.');
				   else
				     $price = number_format($myp,2); */	

                   $price = number_format(floatval($price1),2);					 
			       //echo $price,'>';
				      			      		   
				   $item_url = 'http://' . $this->url . '/' . seturl('t=kshow&cat='./*urlencode(*/$cat/*)*/.'&id='.$rec[$code],null,null,null,null,$this->rewrite);
                   if ($this->photodb)
				     $item_photo_url = 'http://' . $this->url . '/showphoto.php?id='.$rec[$code].'&type=LARGE';
				   else
				     $item_photo_url = 'http://' . $this->url . '/' . $this->img_large . '/' . $rec[$code] . $this->restype;
				   
				   
		           $p[] = $rec[$code];
			       $p[] = $rec[$itmname];//$isutf8 ? $rec[$itmname] : iconv($this->encoding, "UTF-8", $rec[$itmname]);
                   $p[] = $item_url;			   
			       $p[] = $cat;//urlencode($cat);//GetReq('cat');//$cat;
			       $p[] = $rec[$itmdescr];//$isutf8 ? $rec[$itmdescr] : iconv($this->encoding, "UTF-8", $rec[$itmdescr]);
			       $p[] = $item_photo_url;
			       $p[] = $price;
				   $p[] = $rec['cat0'];//$isutf8 ? $rec['cat0'] :iconv($this->encoding, "UTF-8",$rec['cat0']);
				   $p[] = $rec['cat1'];//$isutf8 ? $rec['cat1'] :iconv($this->encoding, "UTF-8",$rec['cat1']);
				   $p[] = $rec['cat2'];//$isutf8 ? $rec['cat2'] :iconv($this->encoding, "UTF-8",$rec['cat2']);
				   $p[] = $rec['cat3'];//$isutf8 ? $rec['cat3'] :iconv($this->encoding, "UTF-8",$rec['cat3']);
				   $p[] = $rec['cat4'];//$isutf8 ? $rec['cat4'] :iconv($this->encoding, "UTF-8",$rec['cat4']);	
                   $p[] = $rec['itmremark'];//$isutf8 ? $rec['itmremark'] :iconv($this->encoding, "UTF-8", $rec['itmremark']); 				   
				   
			       $this->xml_formater($xml,$format,null,$p);
				   unset($p);	//holds record data to pass it at xml formater				  	 
			 
			       $i+=1;	
			//}//price check 
			  
		}
	  } //else echo '--';
	  }//off
	  //else echo 'off';
      //if i..
	  $data = $xml->getxml(1);
	  return($data);	  
    }	
	
    function sitemap_feed($read_all=false) {
	  $db = GetGlobal('db');
      $i=0;	  
      $format = 'sitemap';	
	  $code = $this->getmapf('code');	  
	  $isutf8 = (stristr($this->encoding, 'utf-8')) ? true : false;
	  //echo $isutf8,'>';
	  //if ($read_all)
	    //$this->read_all_items();
       $sSQL = "select id,sysupd,cat0,cat1,cat2,cat3,cat4,".$code." from products ";
	   $sSQL .= " WHERE ";
	   $sSQL .= "itmactive>0 and active>0 ";	
	   //$sSQL .= " GROUP BY cat0,$itmname";
	   //$sSQL .= " ORDER BY sysins desc ";//id asc ";
	   $sSQL .= " ORDER BY id,sysupd DESC LIMIT 6000";// . $items;			
	   //echo $sSQL;
		
	   $resultset = $db->Execute($sSQL,2);			

      $xml = new pxml();
      $xml->encoding = $this->encoding;	
		  
      $this->xml_formater($xml,$format,1);	  
	  //echo 'z';
	  
	  //items  
	  if (!empty($resultset)) {		  	
		//echo 'result';
	    foreach ($resultset as $n=>$rec) {
			//echo $n,'<br/>';  
			$cat = $this->getkategories($rec);	      			      		   
			$item_url = 'http://' . $this->url . '/' . seturl('t=kshow&cat='./*urlencode(*/$cat/*)*/.'&id='.$rec[$code],null,null,null,null,$this->rewrite);

		    $p[] = $item_url;
			//in case of 0000-00-00..is null
			$p[] = (substr($rec['sysupd'],0,1)!='0') ? array_shift(explode(' ',$rec['sysupd'])) : null;		   

			$this->xml_formater($xml,$format,null,$p);
			unset($p);	//holds record data to pass it at xml formater				  	 
			 
			$i+=1;	
            //if ($i==1111) break; //stop to test			
		}
	  } 

	  $data = $xml->getxml(1);
	  return($data);	  
    }		

	function xml_formater(& $xml,$format=null,$init=null,$params=null,$encoding=null) {
	
	      $date = date(DATE_RFC822);//'m-d-Y');
		  $cat_title = $this->getcurrentkategory();//iconv($this->encoding, "UTF-8", $this->getcurrentkategory());
	      $lan_descr = getlocal() ? 'gr' : 'en';
	   
	      if ($init) {
		  
		     if ($this->encoding)
			   $enc = $this->encoding;
			 else
			   $enc = $xml->charset;

             switch ($format) {
			   case 'sitemap' : $enc ='utf8';
			                    $xml->addtag('urlset',null,null,"xmlns=http://www.sitemaps.org/schemas/sitemap/0.9");							
                                break; 			   
	           case 'skroutz' : $enc ='utf8';
			                    $xml->addtag('skroutzstore',null,null,"url=$this->url|name=$xml->urltitle|encoding=$enc");							
	                            $xml->addtag('products','skroutzstore',null,null);
								break;
			   case 'rss1'    : echo 'rss1';
	   					        break; 								
			   case 'rss2'    : $enc ='utf-8';
			                    $xml->addtag('rss',null,null,"version=2.0");							
	                            $xml->addtag('channel','rss',$xml->urltitle,null);
	                            $xml->addtag('title','channel',$xml->urltitle.', '.$cat_title,null);								
	                            $xml->addtag('link','channel','http://' . $this->url,null);									
	                            $xml->addtag('description','channel',$xml->urltitle.', '.$cat_title,null);									
	                            $xml->addtag('language','channel',$lan_descr,null);									
	                            $xml->addtag('pubDate','channel',$date,null);									
	                            $xml->addtag('lastBuildDate','channel',$date,null);	
	                            $xml->addtag('docs','channel',null,null);																	
	                            $xml->addtag('generator','channel','stereobit.networlds PHPDAC 2.1',null);									
	                            $xml->addtag('managingEditor','channel',$xml->urltitle,null);									
	                            $xml->addtag('webMaster','channel',null,null);									
	                            $xml->addtag('ttl','channel','15',null);									
	   					        break; 
			   case 'atom'    : $enc ='utf-8';
			                    $xml->addtag('feed',null,null,"xmlns=http//www.w3.org/2005/Atom");							
	                            $xml->addtag('title','feed',$xml->urltitle,null);
	                            $xml->addtag('subtitle','feed',null,null);								
	                            $xml->addtag('link','feed','/',"href=http://".$this->url."/atom/|rel=self");									
	                            $xml->addtag('link','feed','/',"href=http://".$this->url);									
	                            $xml->addtag('id','feed',null,null);									
	                            $xml->addtag('updated','feed',null,null);									
	                            $xml->addtag('author','feed',$xml->urltitle,null);	
	                            $xml->addtag('name','author',$xml->urltitle,null);																	
	                            $xml->addtag('email','author',null,null);									
	   					        break; 								
               default        : $xml->addtag('default-xml',null,null,"url=$this->url|name=$xml->urltitle|encoding=$enc");							
	                            $xml->addtag('products','default-xml',null,null);
												
		     }		  
		     return 1;
		  }
		  else {
             //product loop xml tags 		  
             switch ($format) {
			   case 'sitemap' : 
			   $xml->addtag('url','urlset',null,null);
			   
               //$xml->addtag('name','url',$xml->cdata($params[1]),null); 
			   $xml->addtag('loc','url',$params[0],null); 
			   if ($params[1]) //in case of 0000-00-00..is null
				$xml->addtag('lastmod','url',$params[1],null);  			   
			   $xml->addtag('changefreq','url','daily',null); 
			   $xml->addtag('priority','url','0.5',null);
			   break;
			 
	           case 'skroutz' : 
			   $cats = explode($this->cseparator,$params[3]);	
			   $manufacturer = str_replace('_',' ',array_shift($cats));
			   $category = str_replace('_',' ',$params[3]);
			   $category = str_replace($this->cseparator,'/',$category);
	           $xf = ($this->itemfimagex?$this->itemfimagex:640);
	           $yf = ($this->itemfimagey?$this->itemfimagey:480);	
	           $xt = ($this->imagex?$this->imagex:160);
	           $yt = ($this->imagey?$this->imagey:120);				   		   
			   	  
               $xml->addtag('product','products',null,"id=".$params[0]);
			   
               $xml->addtag('name','product',$xml->cdata($params[1]),null);  //cdata val
               $xml->addtag('link','product',$params[2],null);  //http://... val
               $xml->addtag('price_with_vat','product',$params[6],null);  //price 11.11
               $xml->addtag('category','product',$xml->cdata($category),"id=".$params[3]); //cdata val = descr, id=code
               $xml->addtag('image','product',$params[5],"width=$xf|height=$yf");  //http://... image
               $xml->addtag('thumbnail','product',$params[5],"width=$xt|height=$yt");  //http://... thumbnail
               $xml->addtag('manufacturer','product',$xml->cdata($manufacturer),null);  //cdata val
               $xml->addtag('shipping','product',null,"type=accurate|currency=euro");  //ship cost 11.11
               $xml->addtag('sku','product','/',null);  //...
               $xml->addtag('ssku','product','/',null);  //...
               $xml->addtag('description','product',$xml->cdata($params[4]),null);  //cdata val		  
		       break;
			   case 'rss1'    : //echo 'rss1';
	   		   break; 								
			   case 'rss2'    : //echo 'rss2';
	           $xml->addtag('item','channel',null,null);				   
			   
               $xml->addtag('title','item',$xml->cdata($params[1]),null);				   
               $xml->addtag('link','item',$params[2],null);
               $xml->addtag('description','item',$xml->cdata($params[4]),null);				   			   				   			   
			   $xml->addtag('author','item',$xml->urltitle,null);
			   $xml->addtag('category','item',$xml->cdata($params[3]),null);
			   $xml->addtag('comments','item',$xml->cdata(strip_tags($params[12])),null);
               $xml->addtag('pubDate','item',$date,null);				   			   
               $xml->addtag('guid','item',$params[0],null);			   
	           break; 
			   case 'atom'    : //echo 'atom';
	           $xml->addtag('entry','feed',null,null);				   
			   
               $xml->addtag('title','entry',$params[1],null);				   
               $xml->addtag('link','entry',$params[2],null);
               $xml->addtag('id','entry',$params[0],null);				   			   				   			   
               $xml->addtag('updated','entry',$date,null);				   			   
               $xml->addtag('summary','entry',$params[4],null);				   
	   		   break; 
			   default ://seo links
               $xml->addtag('product','products',null,"id=");
			   
               $xml->addtag('name','product',$xml->cdata('name'),null);  //cdata val
               $xml->addtag('link','product',null,null);  //http://... val
               $xml->addtag('price_with_vat','product',null,null);  //price 11.11
               $xml->addtag('category','product',$xml->cdata('category'),"id=\"\""); //cdata val = descr, id=code
               $xml->addtag('image','product',null,"width=|height=");  //http://... image
               $xml->addtag('thumbnail','product',null,"width=|height=");  //http://... thumbnail
               $xml->addtag('manufacturer','product',$xml->cdata('manufacturer'),null);  //cdata val
               $xml->addtag('shipping','product',null,"type=|currency=");  //ship cost 11.11
               $xml->addtag('description','product',$xml->cdata('description'),null);  //cdata val		  			   
			 }
			 //dump xml  
			 //echo '<pre>';
			 //$xml->dumpxml();
			 //print_r($xml->index);
			 //echo '</pre>';
			 
		     return 1;
		  }
		  
		  return 0;
	}	

	function get_xml_links($mylan=null,$feed_id=null,$dpcfeed=null) {
	  $lan = $mylan?$mylan:getlocal();//by hand per htm 0,1 page
	  $lnk = array();
	  $id = GetReq('id');
	  $cat = GetReq('cat'); //echo $cat;
	  $page = GetReq('page')?GetReq('page'):'0';
	  $feed_cmd = $feed_id ? $feed_id : 'feed';	  
	  //echo $this->feed_on,'>';
	  //$dpcfeed = $dpcfeed?$dpcfeed:'shkatalogmedia.show_p use p3,999';//special phpdac page without params
	  
	  $mytemplate = $this->select_template('xml-links');
	  
      //RSS	
	  if (stristr($this->feed_on,'rss')) {
        if ($dpcfeed) //special phpdac page without params			  
		  $lnk['RSS'] = seturl("t=$feed_cmd&dpc=$dpcfeed&format=rss2",null,null,null,null,$this->rewrite);  
	    elseif ($id)
	      $lnk['RSS'] = seturl("t=$feed_cmd&cat=$cat&page=$page&id=$id&format=rss2",null,null,null,null,$this->rewrite);
	    elseif ($cat)
	      $lnk['RSS'] = seturl("t=$feed_cmd&cat=$cat&page=$page&format=rss2",null,null,null,null,$this->rewrite); 
		else  
		  $lnk['RSS'] = seturl("t=$feed_cmd&format=rss2",null,null,null,null,$this->rewrite); 
	  }
	  //ATOM
	  if (stristr($this->feed_on,'atom')) {	  
        if ($dpcfeed) //special phpdac page without params		  
		  $lnk['ATOM'] = seturl("t=$feed_cmd&dpc=$dpcfeed&format=atom",null,null,null,null,$this->rewrite);//special phpdac page without params		  
	    elseif ($id)
	      $lnk['ATOM'] = seturl("t=$feed_cmd&cat=$cat&page=$page&id=$id&format=atom",null,null,null,null,$this->rewrite);
	    elseif ($cat)
	      $lnk['ATOM'] = seturl("t=$feed_cmd&cat=$cat&page=$page&format=atom",null,null,null,null,$this->rewrite);	  
		else  
		  $lnk['ATOM'] = seturl("t=$feed_cmd&format=atom",null,null,null,null,$this->rewrite);	  
	  }	
	  //print_r($lnk);	

	  if (!empty($lnk)) {
	    foreach ($lnk as $t=>$w) {
	      //echo $w,$t,'<br>';	    
		  if ($w) {
		    $icon_file = $this->urlpath.'/'.$this->infolder.'/images/'.strtolower($t).'.png';
			//echo $icon_file,'>';
		    if (is_readable($icon_file)) 
				$mylink = "<img src=\"". $this->infolder.'/images/'.strtolower($t).'.png' ."\" border=\"0\" alt=\"$t\">";
			else 
				$mylink = $t;
			  
			if ($mytemplate)
				$tokens[] = "<A href=\"$w\">".$mylink."</A>";
            else				
	            $ret .= "<A href=\"$w\">".$mylink."</A>&nbsp;";
		  }	
		  //echo $ret,'<br>';
	    }
		
	    if (!empty($tokens))
			$out = $this->combine_tokens($mytemplate, $tokens);
	    else 
			$out = "<hr/>" . $ret;		
	  }

	  return ($out);  
	}	
	
    //read dir for rss page
	function read_all_items() {
       $db = GetGlobal('db');
	   $lan = GetReq('lan')>=0?GetReq('lan'):getlocal();	//in case of post sitemap set lan param uri   
	   $itmname = $lan?'itmname':'itmfname';
	   $itmdescr = $lan?'itmdescr':'itmfdescr';	 
	   $start = GetReq('start');
	   //$headcat = GetReq('headcat')?GetReq('headcat'):"";	   
	   //$meter = $start?$start-1:0;  	 
	   
	   	
       $sSQL = "select id,itmname,itmfname,cat0,cat1,cat2,cat3,cat4,itmdescr,itmfdescr,itmremark,".$this->getmapf('code')." from products ";
	   $sSQL .= " WHERE ";
	   $sSQL .= "itmactive>0 and active>0 ";	
	   //$sSQL .= " GROUP BY cat0,$itmname";
	   $sSQL .= " ORDER BY cat0,cat1,cat2,cat3,cat4,$itmname asc ";
	   $sSQL .= $start ? " LIMIT $start,10000" : " LIMIT 10000";			
	   //echo $sSQL;
		
	   $resultset = $db->Execute($sSQL,2);	
	   // $result = $resultset;
	   $this->result = $resultset; 
 	   $this->max_items = $db->Affected_Rows();//count($this->result);	   
       return (null);//$this->max_items);		   
	}
	
	function show_last_edited_items($items=10,$linemax=null,$imgx=100,$imgy=null,$imageclick=0,$template=null,$ainfo=null,$photosize=null,$nopager=null) {	
	     $limit = $items ? $items : 5;
         $db = GetGlobal('db');	
	     $lan = getlocal();
         $db = GetGlobal('db');		
		 $pz = $photosize?$photosize:1;			 
		 
		 if ($this->one_attachment)
		   $slan = null;
		 else
		   $slan = $lan?$lan:'0';
		 //echo $slan,'>';  
		 
	     $code = $this->getmapf('code');	  
		 
         $sSQL = "select code from pattachments ";
	     $sSQL .= " WHERE (type='.html' or type='.htm')";
	     if (isset($slan))
	       $sSQL .= " and lan=" . $slan;
		 $sSQL .= " ORDER BY id desc ";	
         $sSQL .= $items ? " LIMIT " . $items : null;		 
	     //echo $sSQL;
	  
	     $resultset = $db->Execute($sSQL,2);	
	     $result = $resultset;
	     //print_r($result);	
	     if ($exist = $db->Affected_Rows()) {
		   //echo 'sql';
		   $ret = $result->fields['data'];
		 }	

         $sSQL2 = "select id,sysins,code1,pricepc,price2,sysins,itmname,itmfname,uniname1,uniname2,active,code4," .// from abcproducts";// .
	            "price0,price1,cat0,cat1,cat2,cat3,cat4,itmdescr,itmfdescr,itmremark,ypoloipo1,resources,".
				$this->getmapf('code').	" from products ";
		 $sSQL2 .= " WHERE ";
         foreach ($result as $n=>$rec) {
		    $or[] = $this->getmapf('code') ."='". $rec['code'] ."'";
         }
         $sSQL2 .= '(' . implode(' or ',$or) . ')'; 
		 $sSQL2 .= " and (itmactive>0 and active>0)";
		 $sSQL2 .= " ORDER BY " . $this->getmapf('code') . " desc LIMIT " . $items;			 
         //echo $sSQL2;
		 
	     $resultset = $db->Execute($sSQL2,2);	
		 $this->result = $resultset;		 
		 
		 if ($linemax>1)
		  $out = $this->list_katalog_table($linemax,$xmax,$ymax,$imageclick,0,null,$template,$ainfo,null,$external_read,$pz,$nopager);
		 else  	
          $out = $this->list_katalog(null,null,$template,$ainfo,$external_read,$pz,$nopager,$linemax);
		  
		 return ($out);			 
	}	
	
	function item_var($field=null,$code=null, $photosize=null, $array=null) {	
        $db = GetGlobal('db');		
	    $lan = $lang?$lang:getlocal();
	    $itmname = $lan?'itmname':'itmfname';
	    $itmdescr = $lan?'itmdescr':'itmfdescr';				
		$pz = $photosize?$photosize:1;	
		$lastprice = $this->getmapf('lastprice')?','.$this->getmapf('lastprice'):null;		
		
		$itemcode = $code ? $code : GetReq('id');
	    $retfield = $field ? $field : $itmname;	                       
						   
        $sSQL = "select id,sysins,code1,pricepc,price2,sysupd,$itmname,uniname1,uniname2,active,code4," .// from abcproducts";// .
	            "price0,price1,cat0,cat1,cat2,cat3,cat4,$itmdescr,itmremark,ypoloipo1,resources,weight,volume,dimensions,size,color,".
				$this->getmapf('code').
				$lastprice .
				" from products ";
		$sSQL .= " WHERE " . $this->getmapf('code') . "='" . $itemcode ."'";	
		
		/*if ($selected_item = GetReq('id')) 
		  $sSQL .= $this->getmapf('code') . " not like '" . $selected_item ."' and ";
		  		
		$sSQL .= $p." >0 and ".$p." IS NOT NULL and itmactive>0 and active>0";	
		$sSQL .= " ORDER BY $itmname asc ";
		$sSQL .= $items?" LIMIT " . $items: null;			*/
	    //echo $sSQL,'<br>';
		
	    $resultset = $db->Execute($sSQL,2);	
		
		if (($retfield=='sysins') || ($retfield=='sysupd'))
			$ret = date("d-m-Y", strtotime($resultset->fields[$retfield]));
		else
			$ret = $resultset->fields[$retfield];
		
        $out = ($array) ? $resultset->fields : $ret;
		return ($out);	
	}	

	//select price type..overriten error when no cart
	function spt($price,$tax=null) {
      //echo $tax;
	  
	  if ($tax) {
        $p = $this->pricewithtax($price,$tax);	  
	  }
	  elseif ($this->is_reseller) {
	    $p = $price;
	  }	
	  elseif ((defined('SHCART_DPC')) && 
	         (GetGlobal('controller')->calldpc_var('shcart.showtaxretail'))) {//retal handl
	    $p = $this->pricewithtax($price,$tax);
	  }
	  else
	    $p = $price;		
	  //echo '>',$p;
	  return ($p);
	}
	
	//override multiple prices based on file array
	function read_array_policy($itemcode=null,$price=null,$cart_details=null,$policyqty=null) {
	  $cat = $pcat?$pcat:GetReq('cat');
	  $cart_page = GetReq('page')?GetReq('page'):0;	  	
	  $file = $this->path . $itemcode . '.txt'; //echo $file;
	  $cartd = explode(';',$cart_details);
	  //echo $file;
	  
	  if (is_readable($file)) {
	
	    $data_array = parse_ini_file($file,1);
	    //print_r($data_array);
		if ($policyqty) {
		  if (is_array($data_array['QTY'])) {
		    foreach ($data_array['QTY'] as $ix=>$ax) {
			  if ($policyqty>=$ax) {
			    //echo $ax,'>';
			    $pc = intval($data_array['PRICE'][$ix]);
			    $retprice = $price?$price+($price*$pc/100):$pc;
				//print_r($data_arra
			  }
			}
			return ($retprice);
		  }
		}
		else {
		  $style = $data_array['style'];
		  $titlesON = $data_array['titles'];
		  $elements = $titlesON?1:0;	
		  $template = $data_array['template']?$data_array['template']:'fpitempolicy';
		  
	      //loop template 
	      $loop_template= $template.".htm";
	      $tpl = $this->path . $this->tmpl_path .'/'. $this->tmpl_name .'/'. str_replace('.',getlocal().'.',$loop_template) ;
	      if (is_readable($tpl)) {//file temaplate
		  
		    $mylooptemplate = file_get_contents($tpl);
			
			foreach ($data_array['PRICE'] as $ix=>$ax) {
			  $data[] = $data_array['QTY'][$ix];
	 
			  $cartd[8] = $price?$price+($price*$ax/100):$ax;//'22.23';
			  $cartd[9] = intval($data_array['QTY'][$ix]);//prev line //'12';
			  
		      $data[] =	number_format($cartd[8],$this->decimals,',','.');		  
			  
			  $cartout = implode(';',$cartd);
			  $data[] = GetGlobal('controller')->calldpc_method("shcart.showsymbol use $cartout;+$cat+$cart_page+0+".$cartd[9],1);
			  $data[] = $itemcode;
			  $data[] = "addcart/$cartout/$cat/0/";
			 
			  $body .= $this->combine_tokens($mylooptemplate,$data,true);	
			  //echo $body,'>';
			  unset($data);			  
			}		
	      }			  	  
          else { //standart template 
		    if (is_array($data_array['QTY'])) {
			  $percent = intval(100/(count($data_array['QTY'])+$elements)); //echo $percent;	
			  if ($titlesON) {				  
		        $viewdata[] = localize('_QTY',getlocal());//$i;
		        $viewattr[] = "right;$percent%";		  
			  }
		      foreach ($data_array['QTY'] as $ix=>$ax) {
				
		        $viewdata[] = $ax;
		        $viewattr[] = "right;$percent%";
			  } 
	          $myline = new window('',$viewdata,$viewattr);
	          $body = $myline->render($style);
	          unset ($viewdata); unset($viewattr);				 
		    }		
		
		    if (is_array($data_array['PRICE'])) {
			  $percent = intval(100/(count($data_array['PRICE'])+$elements)); //echo $percent;
			  if ($titlesON) {		  
		        $viewdata[] = localize('_PRICE',getlocal());//$i;
		        $viewattr[] = "right;$percent%";		  
			  }
		      foreach ($data_array['PRICE'] as $ix=>$ax) {
			    
			    $cartd[8] = $price?$price+($price*$ax/100):$ax;//'22.23';
				$cartd[9] = intval($data_array['QTY'][$ix]);//prev line //'12';
				//echo $cartd[9],'>';
				$cartout = implode(';',$cartd);
			    $icon_cart = GetGlobal('controller')->calldpc_method("shcart.showsymbol use $cartout;+$cat+$cart_page+0+".$cartd[9],1);

			    $val = number_format($cartd[8],$this->decimals,',','.');

		        $viewdata[] = /*'<del>'.$price.'</del><br/>'.*/$val . $icon_cart;
		        $viewattr[] = "right;$percent%";
			  } 
	          $myline = new window('',$viewdata,$viewattr);
	          $body .= $myline->render($style);
	          unset ($viewdata); unset($viewattr);				 
		    }
		  }//template
        }
		//echo $body;
		return ($body);  
	  }	
	}	
	
	public function item_has_discount($id=null) {
		if (!$id) return false;
		$file = $this->path . $id . '.txt';
		
		if (is_readable($file)) 
		    return true;
			
		return false;	
	}
	
	/*two view methods for items */
	protected function make_table_list($items_table=null, $items_list=null, $template_table=null, $template_list=null) {
	    $toprint = null;
		$mytemplate_table = $this->select_template($template_table);
		$mytemplate_list = $this->select_template($template_list);
		$mytemplate_tablelist = $this->select_template('fpkatalog-grid-list');
		$tokens = array();
		
        if ($mytemplate_tablelist) { 
		
			$table_token[] = (!empty($items_table)) ? implode('',$items_table) : null; 
			//echo $table_token[0];
			$tokens[] = $this->combine_tokens($mytemplate_table, $table_token);

			$list_token[] = (!empty($items_list)) ? implode('',$items_list) : null; 
			//echo $list_token[0];
			$tokens[] = $this->combine_tokens($mytemplate_list, $list_token);
            //print_r($tokens);
			$toprint = $this->combine_tokens($mytemplate_tablelist, $tokens);
			//echo $toprint;
			unset ($tokens);
			unset ($table_token);
			unset ($list_token);
		}	
        return ($toprint); 		
    }	

	//override
	function replace_spchars($string) {
	
	  $r1 = str_replace('"',"'",$string);
	  $r2 = str_replace('+',"plus",$r1);	  
	  $r3 = str_replace('/',"-",$r2);
	  //$r3 = str_replace(')',"-",$r2);
	  
	  return ($r3);
	}		
	
};			  
}
?>