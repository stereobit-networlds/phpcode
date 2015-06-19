<?php
$__DPCSEC['SHKATEGORIES_DPC']='1;1;1;1;1;1;2;2;9';

if ( (!defined("SHKATEGORIES_DPC")) && (seclevel('SHKATEGORIES_DPC',decode(GetSessionParam('UserSecID')))) ) {
define("SHKATEGORIES_DPC",true);

$__DPC['SHKATEGORIES_DPC'] = 'shkategories';

$__EVENTS['SHKATEGORIES_DPC'][0]='shkategories';
$__EVENTS['SHKATEGORIES_DPC'][1]='category';
$__EVENTS['SHKATEGORIES_DPC'][2]='openf';
$__EVENTS['SHKATEGORIES_DPC'][3]='kshow';
$__EVENTS['SHKATEGORIES_DPC'][4]='klist';

$__ACTIONS['SHKATEGORIES_DPC'][0]='shkategories';
$__ACTIONS['SHKATEGORIES_DPC'][1]='category';
$__ACTIONS['SHKATEGORIES_DPC'][2]='openf';
$__ACTIONS['SHKATEGORIES_DPC'][3]='kshow';
$__ACTIONS['SHKATEGORIES_DPC'][4]='klist';

$__LOCALE['SHKATEGORIES_DPC'][0]='SHKATEGORIES_DPC;Categories;Κατηγορίες';
$__LOCALE['SHKATEGORIES_DPC'][1]='SHSUBKATEGORIES_;Subcategories;Υποκατηγορίες';
$__LOCALE['SHKATEGORIES_DPC'][2]='_cfounded; categories found; κατηγορίες βρέθηκαν';

class shkategories {

    var $title, $path, $nav_on, $urlpath, $inpath;
	var $menu;
	var $title2;
	var $usetablelocales,$resourcepath,$resourcefilepath;
	var $depthview;
	var $selected_category;
	
	var $showcatbannerpath, $showcatimagepath;
	var $max_selection;
	var $rewrite, $notencodeurl;
	var $result_in_table;
	var $cseparator, $cat_result;
	var $imagex, $imagey;
	var $encodeimageid;
	var $tmpl_path, $tmpl_name;

	function shkategories() {
	  $GRX = GetGlobal('GRX');		
	
	  $this->title = localize('SHKATEGORIES_DPC',getlocal());	
	  $this->title2 = localize('SHSUBKATEGORIES_',getlocal());	  
	  
	  if ($remoteuser=GetSessionParam('REMOTELOGIN')) 
		  $this->path = paramload('SHELL','prpath')."instances/$remoteuser/";	
	  else
		  $this->path = paramload('SHELL','prpath');	
	  
	  $this->urlpath = paramload('SHELL','urlpath');
	  $this->inpath = paramload('ID','hostinpath');			  

      if ($GRX) {
			 $this->outpoint = loadTheme('point');
			 $this->bullet = loadTheme('bullet');
             $this->rightarrow = loadTheme('rarrow');
			 
			 if (remote_paramload('SHKATEGORIES','resources',$this->path)) {
               //$this->resourcepath = paramload('SHELL','urlbase') . paramload('DIRECTORY','resources');	 
               $ip = $_SERVER['HTTP_HOST'];
               $pr = paramload('SHELL','protocol');
               $subdir = paramload('ID','hostinpath');		   
			   $resources = remote_paramload('SHKATEGORIES','resources',$this->path);
	           $this->resourcepath = $pr . $ip . $subdir . $resources;	 			  
			   $this->resourcefilepath = $this->urlpath. $subdir . $resources;	 			    
			   $this->restype = remote_paramload('SHKATEGORIES','restype',$this->path);
			 }
			 else  
			   $this->resourcepath = null;
	  }
	  else {
			 $this->outpoint = "|";
			 $this->bullet = "&nbsp;";
	         $this->rightarrow = ">";
			 
             $this->resourcepath = null;	 
	  }	 
	  
	  $this->exclude = $this->get_exclude_trees();		   
      $this->home = localize(paramload('SHELL','rootalias'),getlocal()); 
	  $this->nav_on = remote_paramload('KATEGORIES','navigate',$this->path);
	  $this->menu = remote_paramload('SHKATEGORIES','menu',$this->path);	  
	  $this->usetablelocales = remote_paramload('SHKATEGORIES','locales',$this->path);	 
	  $this->depthview = remote_paramload('SHKATEGORIES','depthview',$this->path);	
	  
	  $this->showcatbannerpath = remote_paramload('SHKATEGORIES','catbannerpath',$this->path);	
	  //echo $this->showcatbannerpath,'>';
	  $this->showcatimagepath = remote_paramload('SHKATEGORIES','catimagepath',$this->path);		  	  
	  
	  $this->rewrite = remote_paramload('SHKATEGORIES','rewrite',$this->path);
	  $this->notencodeurl = remote_paramload('SHKATEGORIES','notencodeurl',$this->path);
	  $this->result_in_table = remote_paramload('SHKATEGORIES','resultintable',$this->path);
	  
	  $csep = remote_paramload('SHKATEGORIES','csep',$this->path); 
      $this->cseparator = $csep ? $csep : '^';	
	  //save as var for tags
	  $this->cat_result = null;
	  
	  //thumb xy ..overwriten by shkatalog/shkatlogmedia
	  $this->imagex = remote_paramload('SHKATEGORIES','imagex',$this->path);	
	  $this->imagey = remote_paramload('SHKATEGORIES','imagey',$this->path);		  
	  
	  $this->encodeimageid = remote_paramload('SHKATEGORIES','encodeimageid',$this->path);	  
	  $this->tmpl_path = remote_paramload('FRONTHTMLPAGE','path',$this->path);
	  $this->tmpl_name = remote_paramload('FRONTHTMLPAGE','template',$this->path);
	  
	  //on all pages
      $this->search_javascript();		  
	}  
	
	function event($event=null) {
	
	    switch ($event) {
          case 'openf' : 
		                        break;			
          case 'shkategories' :
		  default             :	//analyze dir...for tags klist,kshow cmd added	
                                //echo 'z';		
                                if ($cat=GetReq('cat'))								
									$this->cat_result = $this->analyzedir($cat);
                                //print_r($this->cat_result); 							
        }					
    }
	
	function action($action=null) {	
	
	    switch ($action) {	
          case 'openf'        : 
		                        break;		
          case 'shkategories' :
		  default             :	//when shkategories included as dpc banner comes first...
		                        //..rem not to do, handled by shkatalogmedia
		                        //$out = $this->show_category_banner();
		                        //$out .= 'test';//no view..$this->show_tree(null,3,$this->treeview);							  
		                        	
        }	
		
		return ($out);		
    }
	
	function search_javascript() {
	
      if (iniload('JAVASCRIPT')) {

	       $id = remote_paramload('SHKATEGORIES','idsearch',$this->path);	  
	  
	       $code2 = $this->js_make_search_url($id);	
		   $js = new jscript;	
           $js->load_js($code2,"",1);			   
		   unset ($js);
	  }			   	   	  
		   
	}	
	
	//for utf strings as products code..encode to digits for saving image
	public function encode_image_id($id=null) {
	    if (!$id) return null;

		if ($this->encodeimageid) {
			//encode 
			$out = join(array_map(function ($n) { return sprintf('%03d', $n); }, unpack('C*', $id)));
			//decode
			//$id = join(array_map('chr', str_split($numbers, 3)));		
		}
		else
		    $out = $id;
			
        return $out;
	}	
	
    public function decode_image_id($id=null) {	
	    if (!$id) return null;

		//encode 
		if ($this->encodeimageid) {
			//decode
			$out = join(array_map('chr', str_split($numbers, 3)));		
		}
		else
		   $out = $id;	
	}	
	
	function show_category_banner($template=null) {
       $db = GetGlobal('db');	
	   $cat = GetReq('cat');
	   /*if ($this->one_attachment)//????
		 $lan = null;
	   else
		 $lan = $lan?$lan:'0';	   */
	   $lan = getlocal()?getlocal():'0';
	   
	   $mytemplate = $template ? $this->select_template($template) : 
		                         $this->select_template('fpkatbanner');	   
	   
	   if ($this->showcatbannerpath) {		   
	     //echo $cat,'>';
	     $catdepth = explode($this->cseparator,$cat);
	     $alsoseedir = $this->urlpath . $this->inpath . '/' . $this->showcatbannerpath;
	     //echo $alsoseedir;
		   		   	   
	     //$mycurrentsubcat = str_replace(' ','_',array_pop($catdepth)); //last cat depth
	     //$mycurrentsubcat = str_replace(' ','_',array_shift($catdepth)); //first cat depth	   
	     //from inside to outer cat ...  
	     while ($mycurrentsubcat = str_replace(' ','_',array_pop($catdepth))) {
	   
	       //echo $mycurrentsubcat,'<br>';
 	  
           $sSQL = "select data from pattachments ";
	       $sSQL .= " WHERE (type='.html' or type='.htm') and code='" . $mycurrentsubcat . "'";
	       //if (isset($lan)) //, no one attach here lan=null
	         $sSQL .= " and (lan=" . $lan . ")";// or (lan=NULL)";	
	       //echo $sSQL;
	  
	       $resultset = $db->Execute($sSQL,2);	
	       $result = $resultset;
	       //print_r($result);	
	       if ($exist = $db->Affected_Rows()) {
		     //echo 'sql';
			 if ($mytemplate) {
			    $tok[] = $result->fields['data'];
			    $out .= $this->combine_tokens($mytemplate, $tok);
				return ($out);			 
			 }
			 else 
			   return ($result->fields['data']);
		   }		   
           else {			   
	         //$catname = '/see_also_banner.htm';
	         $nn = str_replace('/','-',$mycurrentsubcat); //replace title / with -	 
	         $catname = '/' . $nn . $lan . '.htm';
	         //echo $catname;

		     //if (is_dir($alsoseedir)) {
		     //echo 'dir';
		     if (is_readable($alsoseedir.$catname)) {
		       $htmlret = file_get_contents($alsoseedir.$catname);
			   if ($mytemplate) {
			      $tok[] = $htmlret;
			      $out .= $this->combine_tokens($mytemplate, $tok);
				  return ($out);
			   }
			   else
			     return ($htmlret);
		     }
		     //} 
		   }	 
	       //$ret = 'banner';
		 }//while  
	   } 
	   return null;//($ret);	 
	}
	
	function show_category_image() {
	   $cat = GetReq('cat');
	   $t = GetReq('t');
	   
	   if ($this->showcatimagepath) {	
	   
	     if ($cat) {
	   	   
	     //echo $cat,'>';
	     $catdepth = explode($this->cseparator,$cat);
	     $alsoseedir = $this->urlpath . $this->inpath . '/' . $this->showcatimagepath;
	     //echo $alsoseedir;
		 //print_r($catdepth);  		   	   
	     //$mycurrentsubcat = str_replace(' ','_',array_pop($catdepth)); //last cat depth
	     //$mycurrentsubcat = str_replace(' ','_',array_shift($catdepth)); //first cat depth	   
	     //from inside to outer cat ...  
	     while ($mycurrentsubcat = str_replace(' ','_',array_pop($catdepth))) {
	   
	       //echo $mycurrentsubcat,'<br>';

	       //$catname = '/see_also_banner.htm';
	       $nn = str_replace('/','-',$mycurrentsubcat); //replace title / with -
           
	       //if ($this->encodeimageid) { //check inside func
	          $catname = '/';
			  $catname.= $this->encode_image_id($nn);
			  $catname.= $this->restype; 
		      //echo $nn.'>'.$this->encodeimageid.'|<br/>';
	       /*}
		   else		   
		   	  $catname = '/' . $nn . $this->restype ;*/
		   //echo $catname,'>';	  

		   if (is_readable($alsoseedir.$catname)) {
		     $image = $this->showcatimagepath.$catname;
		     $htmlret = "<img src='$image' alt='' />";//file_get_contents($alsoseedir.$catname);
			 $ret = $htmlret;
			 return ($ret);
		   }
		   //echo 'image';
		 }//while
		   
		 }//if
		 else {
	       //if ($this->encodeimageid) {//check inside func
	          $tname = '/';
			  $tname.= $this->encode_image_id($tid);
			  $tname.= $this->restype; 
	       /*}	  
	       else 		 
		      $tname = '/' . $tid . $this->restype ; //echo '>',$this->showcatimagepath,$tname;
		   */	  
		   if (is_readable($alsoseedir.$tname)) {
		     $image = $this->showcatimagepath.$tname;
		     $htmlret = "<img src='$image' alt='' />";//file_get_contents($alsoseedir.$catname);
			 $ret = $htmlret;
			 return ($ret);
		   }		 
		 }
	   } 
	   return null;//($ret);	 
	}	
	
	protected function get_image_icon($catcode=null) {	
        $alsoseedir = $this->urlpath . $this->inpath . '/' . $this->showcatimagepath;
		//echo '>',$this->showcatimagepath,$tname;
		
        $x = $this->imagex ? "width=\"".$this->imagex."\"":null; 
        $y = $this->imagey ? "height=\"".$this->imagey."\"":null;			
		//echo $x, $y; //overwtiten by called class shkatalogmedia
		
	    if (!$catcode) {
		    $tname = 'nopic' . $this->restype ;
		}	
		else {
		   //echo $catcode,'<br/>';
	       //if ($this->encodeimageid) {//check inside func
			  $tname = $this->encode_image_id($catcode);
			  $tname.= $this->restype; 
	       /*}	  
	       else 		 
              $tname = urldecode($catcode) . $this->restype ;*/		
		} 	
		//echo $alsoseedir.$tname,'<br>';
		
		if (is_readable($alsoseedir.$tname)) 
		     $image = $this->showcatimagepath.$tname;
		else 
		     $image = $this->showcatimagepath. 'nopic' . $this->restype ;
		
		$htmlret = "<img src='$image' $x $y>";
		//echo $image,'>';
		$ret = $htmlret;
		return ($ret);		 
	}		
	
	//setof groups used by search to get def group per res for non view cats
	//group is null in this case
	//setofdepths is the real depth comes from
    function view_category($ddir,$type=1,$mode=0,$group=null,$cmd=null,$tokens=null,$setofgroups=null,$setofdepths=null,$template=null) {
	    //print_r($setofgroups);
		//echo $group;
	    //depthview
		$cdepth = $this->get_treedepth();//$group); //echo $cdepth;
		
		if (($this->depthview) && ($this->depthview<=$cdepth)) {
		  //don't show
		  return;
		}
		 
        if ($ddir)  {
		   //print_r($ddir);
		
	       $mytemplate=$template?$template:'fpkatlist.htm';
		   //echo '>',$mytemplate;	   
	       //$tfile = $this->urlpath .'/' . $this->inpath . '/cp/html/'. str_replace('.',getlocal().'.',$mytemplate) ; 	
		   $tfile = $this->path . $this->tmpl_path .'/'. $this->tmpl_name .'/'. str_replace('.',getlocal().'.',$mytemplate) ; 	
           //echo $tfile;  
           if (!is_readable($tfile)) {//bypass
             //startup
             switch ($type) {
			    case 1 : $to_be_print = $this->outpoint . "&nbsp;"; break;//overrided by template
		     }
		   }
		   else {
		     //enable tokens
			 $tokens = 1;//bypass func param
		     $this->bullet = null; //overided by template
			 $this->outpoint = null;
		   }	 
		   	  

		   $t = $cmd?$cmd:'shkategories';
		   //$ti come into loop
				 
		   $i=0;	
		   $this->max_selection = 0;	
		   	   	 
           reset($ddir);
           foreach ($ddir as $line_num => $line) {	
		   
		         //echo $line_num,' ',$line,'<br>';						    
				 if (stristr($t,'input=')) { //ti replaces first search with result name
				 //if ((GetParam('t')=='search') {
				   $text2find = GetParam('Input')?GetParam('Input'):GetReq('input'); 
				   $ti = str_replace($text2find,$line,$t);
				   //echo $ti,'<br>';
				 }
				 else
				   $ti = $t;
			 
				  //localization............................
                 if ($this->usetablelocales) {
				    $loctitle = $line;
					
				    $title = $loctitle;		
					
				    if (trim($group)!=null) {				  
				        $gr = /*rawurlencode(*/str_replace(' ','_',$group . $this->cseparator . $line_num);//);		   
				    }		
				    else { 
					  $search_array_group = $setofgroups[$line_num];
					  if ($search_array_group) {	
					    //print_r($search_array_group);					
					    $gr = /*rawurlencode(*/str_replace(' ','_',$search_array_group. $this->cseparator . $line_num);//);					
					  }  
					  else
             	        $gr = /*rawurlencode(*/str_replace(' ','_',$line_num);//);					
				    }		
				  }
				  else {
				    //echo $line_num,'--',$line,'<br>';
				    if (($clanguage=getlocal())!=$this->deflan)
				      $loctitle = localize($line_num,$clanguage);
				    else  
				      $loctitle = $line_num;	
				  
				    $title = $line_num;		
		  
				    if (trim($group)!=null) 
				      $gr = /*rawurlencode(*/str_replace(' ','_',$group . $this->cseparator . $line);//);		   
				    else  
             	      $gr = /*rawurlencode(*/str_replace(' ','_',$line);//); 
                  }
				  				  				  
				  
                  switch ($type) {
                    default : 
                    case  1 :  if ($tokens) {
					             $mytokens[] = seturl("t=$ti&cat=$gr",$loctitle,null,null,null,$this->rewrite) . " " . $this->outpoint . " ";
								 $tok2[$i][] = seturl("t=$ti&cat=$gr",$loctitle,null,null,null,$this->rewrite) . " " . $this->outpoint . " ";
								 $tok2[$i][] = $gr; //cat name
								 $tok2[$i][] = $loctitle; //cat title
								 $tok2[$i][] = seturl("t=$ti&cat=$gr",null,null,null,null,$this->rewrite);//url
								 $tok2[$i][] = $this->get_image_icon($gr);//$this->show_category_image();//image
							   }	 
					           else
					             $to_be_print .= seturl("t=$ti&cat=$gr",$loctitle,null,null,null,$this->rewrite) . " " . $this->outpoint . " ";
                               break;

                    case  2 :  if ($tokens)
					             $mytokens[] =  seturl("t=$ti&cat=$gr",$loctitle,null,null,null,$this->rewrite) . "<br>";
							   else	 
					             $to_be_print .=  seturl("t=$ti&cat=$gr",$loctitle,null,null,null,$this->rewrite) . "<br>";
                               break;
							   
                    case  3 :  //$toprn = $this->bullet;
					           //IMAGE RESOURCE
							   if ($this->resourcepath) {
							     //remove invalid filename chars
							     $filephoto = str_replace("/","_",$title);
							     $myiconfile = $this->resourcefilepath .$filephoto. $this->restype;
								 //echo $myiconfile,'<br>';
								 if (is_file($myiconfile)) 
							       $toprn = loadimagexy($this->resourcepath .$filephoto. $this->restype,45,30);
								 else
								   $toprn = $this->bullet;
							   }	 
							   else
							     $toprn = $this->bullet;
								 
							   if ($tokens) {	 
					             $mytokens[] = seturl("t=$ti&cat=$gr","<B>".$loctitle."</B",null,null,null,$this->rewrite);
							   }
							   else {	 
                                 $toprn .= seturl("t=$ti&cat=$gr","<B>".$loctitle."</B",null,null,null,$this->rewrite);
	                           //echo $t,'>';
	                           /*if (($template) && is_readable($tfile)) {	
		                         $mytemplate = file_get_contents($tfile);
								 
								 $mytokens[] = $toprn;
                                 //read subcategories..returning tokens
	                             $mytokens[] = $this->view_category($this->read_tree($gr),1,0,$gr,$cmd,1);								 
								 //exit recusrsion returning to_be_print
								 if ($mytokens) {
								   print_r($mytokens);
		                           $to_be_print .= $this->combine_n_tokens($mytemplate,$mytokens);							   				      							   
								 }  
							   }
							   else {*/
		                         $win1 = new window('',$toprn);
		                         $to_be_print .= $win1->render("center::100%::0::group_category_headtitle::left::0::0::");
		                         unset ($win1);
                               
                                 //read subcategories
	                             $data2[] = $this->view_category($this->read_tree($gr),1,0,$gr,$cmd);
                                 $attr2[] = "left;";	
		                         unset ($mydir);			
							   
		                         $win2 = new window('',$data2,$attr2);
		                         $to_be_print .= $win2->render("center::100%::0::group_category_title::left::0::0::");
		                         unset ($win2);

							     unset ($data2);
							     unset ($attr2);
							   //}
							   }
                               break;
							   
					case  4 :  if ($tokens) {
					             $mytokens[] = seturl("t=$ti&cat=$gr","<B>" . $loctitle . "</B>",null,null,null,$this->rewrite);
					           }
							   else {
					           $mycat = seturl("t=$ti&cat=$gr","<B>" . $loctitle . "</B>",null,null,null,$this->rewrite);				
 		                       $data[] = $mycat;	
                               $attr[] = "left;";									   
							   
		                       $win1 = new window('',$data,$attr);
		                       $to_be_print .= $win1->render("center::100%::0::group_category_title::left::0::0::");
		                       unset ($win1);

	                           unset ($data);    
	                           unset ($attr);							   					
							   }
					           break;		                             
                  }  
			  $i+=1;
			  $this->max_selection+=1;
	       }//foreach 
		   //echo $template,':',$tfile; 
		   if (is_readable($tfile)) {
		    //echo $template,':',$tfile; 
			if ($tokens) {
             //print_r($mytokens); 		  
			 $mydatatemplate = file_get_contents($tfile);
             //double combination...n and 0123 
			 $tokret = $this->combine_n_tokens($mydatatemplate, $mytokens, $tok2);

			 return ($tokret);
			}
		   }
		   else 
		     return ($to_be_print);		   
		    
	   }
       
	   /*if ($tokens)
	     return ($mytokens);
	   else	 
         return ($to_be_print);*/
	}		
	
	function show_tree($cmd=null,$group=null,$treespaces='',$sp=0,$mode=0,$wordlength=19,$notheme=null,$stylesheet=null) {		
	   $cat = /*rawurldecode(*/str_replace('_',' ',GetReq('cat'));//);
	   if (!$wordlength) $wordlength = 19;//for calldpc purposes
	   $mystylesheet = $stylesheet?$stylesheet:'group_category_title';	
	   $mystylesheet_selected = $mystylesheet . '_selected';   

	   static $cd = -1;
	   
	   //if ($mode) $mytype = $mode;
	   //      else $mytype = $this->dirview;	   
	   $t = $cmd?$cmd:'shkategories';
	   //$mytype=$this->dirview;	   
	   
	   //echo '>>',$cd;
	   $ptree = explode($this->cseparator,$cat); //print_r($ptree);
	   $depth = count($ptree)-1; //echo 'DEPTH:',$depth;
	   //echo $cat;    
	   $ddir = $this->read_tree($group);
 
	   $i=0;	 
       if ($ddir)  {	   
          reset($ddir);
          foreach ($ddir as $id => $line) {	
		    
		    if ($line) {
			
			  if ($this->usetablelocales) {
			  
			    if (trim($group)!=null) {
			      $folder = $group . $this->cseparator . $id; 
			      $gr = /*rawurlencode(*/str_replace(' ','_',$group . $this->cseparator . $id);//);			   
			    }	
			    else {
			      $folder = $id;
			      $gr = /*rawurlencode(*/str_replace(' ','_',$id);//); 
			    }	
				
				//$line = $line;			  
			  }
			  else {				
			    if (trim($group)!=null) {
			      $folder = $group . $this->cseparator . $line; 
			      $gr = /*rawurlencode(*/str_replace(' ','_',$group . $this->cseparator . $line);//);			   
			    }	
			    else {
			      $folder = $line;
			      $gr = /*rawurlencode(*/str_replace(' ','_',$line);//); 
			    }	
				
			    //after gr set ..localization............................!!!
			    if (($clanguage=getlocal())!=$this->deflan) {
			      $line = localize($line,$clanguage);			
			    }			
			  }//tabel locales
			  	
			  //$gr = $current_leaf;		 
			  $cgroup = $ptree[$cd+1]; //echo '>>',$cgroup;//$ptree[$depth];		 		

              $mycat = "$treespaces$this->outpoint <a href=\"" . seturl("t=$t&cat=$gr",null,null,null,null,$this->rewrite) . "\">";
			  
	          /*if ($cgroup==$line) 
			    $mycat .= "<b>" . summarize(($wordlength-$sp),$line) . "</b>";
			  else*/ 
			    $mycat .= summarize(($wordlength-$sp),$line);	
				
			  $mycat .= "</a>";
			  
			  if ($notheme) {
			    $out .= $mycat . '<br>';
			  }
			  else {					
 		        $data[] = $mycat;	
                $attr[] = "left;";			
				  
		        $win1 = new window('',$data,$attr);
			    if ($cgroup==$line)
			      $out .= $win1->render("center::99%::0::$mystylesheet_selected::left::0::0::");
			    else
		          $out .= $win1->render("center::99%::0::$mystylesheet::left::0::0::");
		        unset ($win1);

	            unset ($data);    
	            unset ($attr);
			  }	
			  //echo '>>>',$cd,'---',$this->depthview;
			  //echo $cgroup,'<br>',$line,'<br>-------<br>';
			  if ($cgroup==$line) {
			  	  $cd+=1;
				  if ($cd+1<$this->depthview) {//depth view param for hidden categories
				    $mysp=($cd+1) * 3;
				    $mytreespaces = str_repeat("&nbsp;",($cd+1)*3);	   
				    $out .= $this->show_tree($cmd,$folder,$mytreespaces,$mysp,$mode,$wordlength,$notheme);
				  }
			  }			  
			}//if line
			$i+=1;
		  }//foreach
	   }//if ddir	
	   
       return ($out); 			      
	}
	
	/*using accordion template*/
	function show_tree2($cmd=null,$group=null,$treespaces='',$sp=0,$mode=0,$wordlength=19,$notheme=null,$stylesheet=null,$template=null) {		
	   $cat = str_replace('_',' ',GetReq('cat'));
	   if (!$wordlength) $wordlength = 25;//for calldpc purposes
	   $mystylesheet = $stylesheet?$stylesheet:'group_category_title';	
	   $mystylesheet_selected = $mystylesheet . '_selected';	   
	   
       $tokens = array();
	   $template2 = 'fpkatnav-accordion-inner.htm';
	   $t2 = $this->path . $this->tmpl_path .'/'. $this->tmpl_name .'/'. str_replace('.',getlocal().'.',$template2) ;			 
	   //echo $t2;
	   $tmpl2_data = @file_get_contents($t2);
       //echo $tmpl2_data;	   
	   
	   static $cd = -1;
	   
	   //if ($mode) $mytype = $mode;
	   //      else $mytype = $this->dirview;	   
	   $t = $cmd?$cmd:'shkategories';
	   //$mytype=$this->dirview;	   
	   
	   //echo '>>',$cd;
	   $ptree = explode($this->cseparator,$cat); //print_r($ptree);
	   $depth = count($ptree)-1; //echo 'DEPTH:',$depth;
	   //echo $cat;    
	   $ddir = $this->read_tree($group);
 
	   $i=0;	 
       if ($ddir)  {
          //print_r($ddir);  	   
          reset($ddir);
          foreach ($ddir as $id => $line) {	
		    
		    if ($line) {
			
			  if ($this->usetablelocales) {
			  
			    if (trim($group)!=null) {
			      $folder = $group . $this->cseparator . $id; 
			      $gr = str_replace(' ','_',$group . $this->cseparator . $id);		   
			    }	
			    else {
			      $folder = $id;
			      $gr = str_replace(' ','_',$id);
			    }	
						  
			  }
			  else {				
			    if (trim($group)!=null) {
			      $folder = $group . $this->cseparator . $line; 
			      $gr = str_replace(' ','_',$group . $this->cseparator . $line);		   
				  $unfold=true;
			    }	
			    else {
			      $folder = $line;
			      $gr = str_replace(' ','_',$line);
				  $unfold=false;
			    }	
				
			    //after gr set ..localization............................!!!
			    if (($clanguage=getlocal())!=$this->deflan) {
			      $line = localize($line,$clanguage);			
			    }			
			  }//tabel locales
			  	
			  //$gr = $current_leaf;		 
			  $cgroup = $ptree[$cd+1]; //echo '>>',$cgroup;//$ptree[$depth];		 		

			  if (isset($template)) {
			    //echo '>>>',$cd,'---',$this->depthview;
				$tokens[0] = str_replace(' ','-',$line);//accordion id
				$tokens[1] = summarize(($wordlength-$sp),$line);//accordion cat name
				$tokens[2] = null;//seturl("t=$t&cat=$gr",null,null,null,null,$this->rewrite); //url
				//$out .= $this->combine_tokens($template,$tokens,true);
				//unset($tokens);
			  }
			  else {
				$mycat = "$treespaces$this->outpoint <a href=\"" . seturl("t=$t&cat=$gr",null,null,null,null,$this->rewrite) . "\">";
			  
				/*if ($cgroup==$line) 
					$mycat .= "<b>" . summarize(($wordlength-$sp),$line) . "</b>";
				else*/ 
					$mycat .= summarize(($wordlength-$sp),$line);	
				
				$mycat .= "</a>";
			  
				if ($notheme) {
					$out .= $mycat . '<br>';
				}
				else {					
					$data[] = $mycat;	
					$attr[] = "left;";			
				  
					$win1 = new window('',$data,$attr);
					if ($cgroup==$line)
						$out .= $win1->render("center::99%::0::$mystylesheet_selected::left::0::0::");
					else
						$out .= $win1->render("center::99%::0::$mystylesheet::left::0::0::");
					unset ($win1);

					unset ($data);    
					unset ($attr);
				}	
			  }
			  //echo '>>>',$cd,'---',$this->depthview;
			  //echo $cgroup,':',$line,':',$mode,'<br>';
			  if ($cgroup==$line) {
			  	  $cd+=1;
				  if ($cd+1<$this->depthview) {//depth view param for hidden categories
				    if (isset($template)) {
					    $subcat_tokens = $this->show_tree2($cmd,$folder,$mytreespaces,$mysp,$mode,$wordlength,$notheme,$mystylesheet,$template);
						//echo $subcat_tokens,'<br/>';
						$tokens[3] = 1;//isset($subcat_tokens) ? 1 : 0;//accordion expand-collapse
						$tokens[4] = isset($subcat_tokens) ? $this->combine_tokens($tmpl2_data,array('0'=>str_replace(' ','-',$line),'1'=>$subcat_tokens)) : null;
						$tokens[5] = $group ? 1 : 0; //check for subtree
						$out .= $this->combine_tokens($template,$tokens,true);
						//print_r($tokens);	
						unset($tokens);
						unset($subcat_tokens);
					}
					else {
						$mysp=($cd+1) * 3;
						$mytreespaces = str_repeat("&nbsp;",($cd+1)*3);	   
						$out .= $this->show_tree2($cmd,$folder,$mytreespaces,$mysp,$mode,$wordlength,$notheme,$mystylesheet,$template);
					}
				  }
			  }//=group
              else {
				   if (isset($template)) {//when mode=1 expand all tree
				        $subcat_tokens = $mode ? $this->show_tree2($cmd,$folder,$mytreespaces,$mysp,$mode,$wordlength,$notheme,$mystylesheet,$template) : null;
				        $tokens[3] = $mode ? 1 : 0;//accordion no expland-colapse
						$tokens[4] =  isset($subcat_tokens) ? $this->combine_tokens($tmpl2_data,array('0'=>str_replace(' ','-',$line),'1'=>$subcat_tokens)) : null;
						$tokens[5] = $group ? 1 : 0; //check for subtree
						
						/*show other root categories*/
						/*$out .= (!$group) ? $this->combine_tokens($template,$tokens,true) :
						                   '<li>'.seturl("t=$t&cat=$gr",summarize(($wordlength-$sp),$line),null,null,null,$this->rewrite).'</li>';*/
										   
                        if ($mode)
							$out .= $this->combine_tokens($template,$tokens,true);						
						else	
							/*hide other root categories*/				   
							$out .= ($group) ? '<li>'.seturl("t=$t&cat=$gr",summarize(($wordlength-$sp),$line),null,null,null,$this->rewrite).'</li>' : null;										   					
						
						//print_r($tokens);	
						unset($tokens);
						unset($subcat_tokens);	
				   }
				   else
				      null;
              }			  
			}//if line
			$i+=1;
		  }//foreach
	   }//if ddir	
	   //echo '<pre>';
	   //print_r($tokens);
	   //echo '</pre>';
       return ($out); 			      
	}	
	
	/*using accordion template version 3*/
	function show_tree3($cmd=null,$group=null,$treespaces='',$sp=0,$mode=0,$wordlength=19,$notheme=null,$stylesheet=null,$template=null) {		
	   $cat = str_replace('_',' ',GetReq('cat'));
	   if (!$wordlength) $wordlength = 25;//for calldpc purposes
	   $mystylesheet = $stylesheet?$stylesheet:'group_category_title';	
	   $mystylesheet_selected = $mystylesheet . '_selected';	   
	   
       $tokens = array();
	   $template2 = 'fpkatnav-accordion-inner.htm';
	   $t2 = $this->path . $this->tmpl_path .'/'. $this->tmpl_name .'/'. str_replace('.',getlocal().'.',$template2) ;			 
	   //echo $t2;
	   $tmpl2_data = @file_get_contents($t2);
       //echo $tmpl2_data;	   
	   
	   static $cd = -1;
	   
	   //if ($mode) $mytype = $mode;
	   //      else $mytype = $this->dirview;	   
	   $t = $cmd?$cmd:'shkategories';
	   //$mytype=$this->dirview;	   
	   
	   //echo '>>',$cd;
	   $ptree = explode($this->cseparator,$cat); //print_r($ptree);
	   $depth = count($ptree)-1; //echo 'DEPTH:',$depth;
	   //echo $cat;    
	   $ddir = $this->read_tree($group);
 
	   $i=0;	 
       if ($ddir)  {
          //print_r($ddir);  	   
          reset($ddir);
          foreach ($ddir as $id => $line) {	
		    
		    if ($line) {
			
			  if ($this->usetablelocales) {
			  
			    if (trim($group)!=null) {
			      $folder = $group . $this->cseparator . $id; 
			      $gr = str_replace(' ','_',$group . $this->cseparator . $id);		   
			    }	
			    else {
			      $folder = $id;
			      $gr = str_replace(' ','_',$id);
			    }	
						  
			  }
			  else {				
			    if (trim($group)!=null) {
			      $folder = $group . $this->cseparator . $line; 
			      $gr = str_replace(' ','_',$group . $this->cseparator . $line);		   
				  $unfold=true;
			    }	
			    else {
			      $folder = $line;
			      $gr = str_replace(' ','_',$line);
				  $unfold=false;
			    }	
				
			    //after gr set ..localization............................!!!
			    if (($clanguage=getlocal())!=$this->deflan) {
			      $line = localize($line,$clanguage);			
			    }			
			  }//tabel locales
			  	
			  //$gr = $current_leaf;		 
			  $cgroup = $ptree[$cd+1]; //echo '>>',$cgroup;//$ptree[$depth];		 		

			  if (isset($template)) {
			    //echo '>>>',$cd,'---',$this->depthview;
				$tokens[0] = str_replace(' ','-',$line);//accordion id
				$tokens[1] = summarize(($wordlength-$sp),$line);//accordion cat name
				$tokens[2] = null;//seturl("t=$t&cat=$gr",null,null,null,null,$this->rewrite); //url
				//$out .= $this->combine_tokens($template,$tokens,true);
				//unset($tokens);
			  }
			  else {
				$mycat = "$treespaces$this->outpoint <a href=\"" . seturl("t=$t&cat=$gr",null,null,null,null,$this->rewrite) . "\">";
			  
				/*if ($cgroup==$line) 
					$mycat .= "<b>" . summarize(($wordlength-$sp),$line) . "</b>";
				else*/ 
					$mycat .= summarize(($wordlength-$sp),$line);	
				
				$mycat .= "</a>";
			  
				if ($notheme) {
					$out .= $mycat . '<br>';
				}
				else {					
					$data[] = $mycat;	
					$attr[] = "left;";			
				  
					$win1 = new window('',$data,$attr);
					if ($cgroup==$line)
						$out .= $win1->render("center::99%::0::$mystylesheet_selected::left::0::0::");
					else
						$out .= $win1->render("center::99%::0::$mystylesheet::left::0::0::");
					unset ($win1);

					unset ($data);    
					unset ($attr);
				}	
			  }
			  //echo '>>>',$cd,'---',$this->depthview;
			  //echo $cgroup,':',$line,':',$mode,'<br>';
			  if ($cgroup==$line) {
			  	  $cd+=1;
				  if ($cd+1<$this->depthview) {//depth view param for hidden categories
				    if (isset($template)) {
					    $subcat_tokens = $this->show_tree3($cmd,$folder,$mytreespaces,$mysp,$mode,$wordlength,$notheme,$mystylesheet,$template);
						//echo $subcat_tokens,'<br/>';
						$tokens[3] = 1;//isset($subcat_tokens) ? 1 : 0;//accordion expand-collapse
						$tokens[4] = isset($subcat_tokens) ? $this->combine_tokens($tmpl2_data,array('0'=>str_replace(' ','-',$line),'1'=>$subcat_tokens)) : null;
						$tokens[5] = $group ? 1 : 0; //check for subtree
						$out .= $this->combine_tokens($template,$tokens,true);
						//print_r($tokens);	
						unset($tokens);
						unset($subcat_tokens);
					}
					else {
						$mysp=($cd+1) * 3;
						$mytreespaces = str_repeat("&nbsp;",($cd+1)*3);	   
						$out .= $this->show_tree3($cmd,$folder,$mytreespaces,$mysp,$mode,$wordlength,$notheme,$mystylesheet,$template);
					}
				  }
			  }//=group
              else {
				   if (isset($template)) {//when mode=1 expand all tree
				        $subcat_tokens = $mode ? $this->show_tree3($cmd,$folder,$mytreespaces,$mysp,$mode,$wordlength,$notheme,$mystylesheet,$template) : null;
				        $tokens[3] = $mode ? 1 : 0;//accordion no expland-colapse
						$tokens[4] =  isset($subcat_tokens) ? $this->combine_tokens($tmpl2_data,array('0'=>str_replace(' ','-',$line),'1'=>$subcat_tokens)) : null;
						$tokens[5] = $group ? 1 : 0; //check for subtree
						
						/*show other root categories*/
						/*$out .= (!$group) ? $this->combine_tokens($template,$tokens,true) :
						                   '<li>'.seturl("t=$t&cat=$gr",summarize(($wordlength-$sp),$line),null,null,null,$this->rewrite).'</li>';*/
										   
                        if ($mode)
							$out .= $this->combine_tokens($template,$tokens,true);						
						else	
							/*hide other root categories*/				   
							$out .= ($group) ? '<li>'.seturl("t=$t&cat=$gr",summarize(($wordlength-$sp),$line),null,null,null,$this->rewrite).'</li>' : null;										   					
						
						//print_r($tokens);	
						unset($tokens);
						unset($subcat_tokens);	
				   }
				   else
				      null;
              }			  
			}//if line
			$i+=1;
		  }//foreach
	   }//if ddir	
	   //echo '<pre>';
	   //print_r($tokens);
	   //echo '</pre>';
       return ($out); 			      
	}	
	
	
	//  SHOW SELECTED TREE FUNCTIONS
	function read_selected_tree($group,$cmd=null,$stylesheet=null,$outpoint=null,$br=1,$debug=null) {
	    $t = $cmd?$cmd:'klist';
	    //$mystylesheet = $stylesheet?$stylesheet:'group_category_title';		
	  	
	    $ddir = $this->read_tree($group,$debug,1);		
		
		$i=0;	 
        if ($ddir)  {	   
          reset($ddir);	
          foreach ($ddir as $id => $line) {  		  
		    if ($line) {
			  if (trim($group)!=null) {
			    $folder = $group . $this->cseparator . $line; 
			    $gr = /*rawurlencode(*/str_replace(' ','_',$group . $this->cseparator . $line);//);		

			    //after gr set ..localization............................!!!
			    if ($this->usetablelocales) {
				  $line = $line; //...no change
				}
			    else {
				  if (($clanguage=getlocal())!=$this->deflan) {
			        $line = localize($line,$clanguage);			
			      }			
				}
				
			    //$gr = $current_leaf;		 
			    $cgroup = $ptree[$cd+1]; //echo '>>',$cgroup;//$ptree[$depth];		 		
              
			    if ($outpoint)
			      $mycat .= str_repeat('&nbsp;',$outpoint) . $this->outpoint;
                $mycat .= "<a href=\"" . seturl("t=$t&cat=$gr",null,null,null,null,$this->rewrite) . "\">";
			    $mycat .= $line;		
			    $mycat .= "</a>";
				$mycat .= str_repeat("<br/>",$br);	
				
			    //extra subcats
				if (GetReq('cat')) //only if not in root
                  $mycat .= $this->show_selected_tree($cmd,str_replace('_',' ',$gr),null,null,null,$mystylesheet,3,0);//$subcats.'>';								

			  }	
			}
		  }
		}
		
		return ($mycat);   			  
	}
	
	function show_selected_branch($id,$line,$t=null,$myselcat=null,$expand=null,$stylesheet=null,$outpoint=null,$br=1,$template=null,$linkclass=null,$linksonly=null,$titlesonly=null,$idsonly=null) {
	       $mystylesheet = $stylesheet?$stylesheet:'group_category_title';	
		   //echo '>',$outpoint,'>',$myselcat,'|';
           if ($template) { //template
	         $tmpl = explode('.',$template);
	         $mytemplate = $this->select_template($tmpl[0],$cat);		
	       }
	       else			   
  	         $mytemplate = $this->select_template('fpcatcolumn',$cat);			   
			  
		    if ($line) {	
			  if ($this->usetablelocales) { 
			    if (trim($myselcat)!=null) {
			      $folder = $myselcat . $this->cseparator . $id; 
			      $gr = /*rawurlencode(*/str_replace(' ','_',$myselcat . $this->cseparator . $id);//);			   
			    }	
			    else {
			      $folder = $id;
			      $gr = /*rawurlencode(*/str_replace(' ','_',$id);//); 
			    }	
				
				//$line = $line;			  
			  }
			  else {		 	  
			    if (trim($myselcat)!=null) {
			      $folder = $myselcat . $this->cseparator . $line; 
			      $gr = /*rawurlencode(*/str_replace(' ','_',$myselcat . $this->cseparator . $line);//);			   
			    }	
			    else {
			      $folder = $line;
			      $gr = /*rawurlencode(*/str_replace(' ','_',$line);//); 
			    }	
				
			    //after gr set ..localization............................!!!
			    if (($clanguage=getlocal())!=$this->deflan) {
			      $line = localize($line,$clanguage);			
			    }	
			  }		
				
			  //$gr = $current_leaf;		 
			  //$cgroup = $ptree[$cd+1]; //echo '>>',$cgroup;//$ptree[$depth];		 		

			  if ($outpoint)
			    $mycat .= str_repeat('&nbsp;',$outpoint) . $this->outpoint;		  
              $mycat .= "<a href=\"" . seturl("t=$t&cat=$gr",null,null,null,null,$this->rewrite);
			  
			  if ($linkclass) 
			    $mycat .=  "\" class=\"$linkclass\">";
			  else 
			    $mycat .=  "\">";
				
			  $mycat .= $line;//summarize($wordlength,$line);		
			  $mycat .= "</a>";	
			  
			  $winbody = $this->read_selected_tree($folder,$t,$mystylesheet,$outpoint);
 		      $data[] = $winbody;
              $attr[] = "left;";	
			  
			  if (($winbody) && (defined('WINDOW2_DPC'))) {
			    if ($expand) 
				  $exd = 'SHOW';
				else
				  $exd = 'HIDE';  
				  
		        $win1 = new window2($line,$data,null,1,null,$exd,null,1);
	            $out .= $win1->render("center::99%::0::$mystylesheet::left::0::0::");
		        unset ($win1);		  
			  }
			  else {				  
				  
 			    if ($mytemplate) { 
                  //echo 'b',$mytemplate;				
			      $tokens[] = ($linksonly) ? seturl("t=$t&cat=$gr",null,null,null,null,$this->rewrite) :
				                             ($titlesonly ? $line : ($idsonly ? $id : $mycat));
				  $tokens[] = $winbody;
			      $out .= $this->combine_tokens($mytemplate, $tokens, true);					
			  	}
				else {	
                  //echo 'a';				
		          $win1 = new window($mycat,$data,$attr);
	              $out .= $win1->render("center::99%::0::$mystylesheet::left::0::0::");
		          unset ($win1);			  
				}
			  }
			  
			  unset($data);
			  unset($attr);
			  //$out .= '<br>';
			  $out .= str_repeat("<br/>",intval($br));
			}//if  	 
		  
		return ($out);  
	}
	
    function show_selected_tree($cmd=null,$group=null,$showroot=null,$expand=null,$viewlevel=null,$stylesheet=null,$outpoint=null,$br=1,$template=null,$linkclass=null,$linksonly=null,$titlesonly=null,$idsonly=null) {
	  $mystylesheet = $stylesheet?$stylesheet:'group_category_title';	
	  $cat = /*rawurldecode(*/str_replace('_',' ',GetReq('cat'));//);	
	  $g = /*rawurldecode(*/str_replace('_',' ',$group);//);	
      $myselcat = $g?$g:$cat;
	  //$br = $br?$br:1;
      //echo $group,'>';	  
	  
      static $cd = -1;
	  $wordlength = 19;//for calldpc purposes
	  $t = $cmd?$cmd:'klist';

	  $ptree = explode($this->cseparator,$myselcat); //print_r($ptree);
			  
	  if ($viewlevel) {
	    $depth = count($ptree);//-1 echo 'DEPTH:',$depth;
	    //echo $cat;    
		if ($depth>$viewlevel) {
		  foreach ($ptree as $p=>$pt) {
		    if ($p<$viewlevel) 
		      $pv[] = $pt;
		  }	
		  $myselcat = implode($this->cseparator,$pv);
		}
	  }
	  //else
        //$myselcat = $g?$g:$cat;	
		
	  	    
	  if ($showroot) 
	    $ddir = $this->read_tree(null,null,1);
	  elseif ($myselcat) 	
	    $ddir = $this->read_tree($myselcat,null,1);	
	  /*else	
	    $ddir = $this->read_tree(null,null,1);*/
		
	  /*if ($myselcat) 	
	    $ddir = $this->read_tree($myselcat,null,1);	
	  elseif ($showroot) 
	    $ddir = $this->read_tree(null,null,1);*/
	  //print_r($ddir);			
	  $i=0;	 
      if ($ddir)  {	   
          reset($ddir);
          foreach ($ddir as $id => $line) {		  
            $out .= ($showroot) ? 
			        $this->show_selected_branch($id,$line,$t,null,$expand,$mystylesheet,$outpoint,$br,$template,$linkclass,$linksonly,$titlesonly,$idsonly):
					$this->show_selected_branch($id,$line,$t,$myselcat,$expand,$mystylesheet,$outpoint,$br,$template,$linkclass,$linksonly,$titlesonly,$idsonly);
			
			$i+=1; 
		  }//foreach				
	  }//if ddir
	  
	  return ($out);
    }	
	//.....  SHOW SELECTED TREE FUNCTIONS	
	
	
	//  SHOW SELECTED TREE FUNCTIONS 2
	function read_selected_tree2($group,$cmd=null,$showroot=null,$expand=null,$stylesheet=null,$outpoint=null,$br=1,$template=null,$linkclass=null,$noencodeurl=null,$debug=null) {
	    $t = $cmd?$cmd:'klist';
	    $mystylesheet = $stylesheet?$stylesheet:'group_category_title';	
        //echo 'C:',$outpoint;
        //echo 'read:',$mystylesheet,$outpoint,'<br>';		
	  	
	    $ddir = $this->read_tree($group,$debug,1);		
		
		$i=0;	 
        if ($ddir)  {	   
          reset($ddir);	
          foreach ($ddir as $id => $line) {  		  
		    if ($line) {
			  if (trim($group)!=null) {
			    $folder = $group . $this->cseparator . $line; 
				if ($noencodeurl)
				  $gr = str_replace(' ','_',$group . $this->cseparator . $line);		
				else
			      $gr = /*rawurlencode(*/str_replace(' ','_',$group . $this->cseparator . $line);//);		

			    //after gr set ..localization............................!!!
			    if ($this->usetablelocales) {
				  $line = $line; //...no change
				}
			    else {
				  if (($clanguage=getlocal())!=$this->deflan) {
			        $line = localize($line,$clanguage);			
			      }			
				}
				
			    //$gr = $current_leaf;		 
			    $cgroup = $ptree[$cd+1]; //echo '>>',$cgroup;//$ptree[$depth];		 		
				
				//SPACE ON 2 LEVEL
				if ($outpoint==2) 
				  $mycat .= '<br>'; //br before   
                $mycat .= "<a href=\"" . seturl("t=$t&cat=$gr",null,null,null,null,$this->rewrite); //. "\">";
				
			    if ($linkclass)
			      $mycat .=  "\" class=\"$linkclass\">";
			    elseif ($outpoint)
				  $mycat .=  "\" class=\"". $mystylesheet . $outpoint . "\">";
			    else
                  $mycat .=  "\">";				
				  
			    if ($outpoint) {
				  //SPACES ON/OFF
			      //$mycat .= str_repeat('&nbsp;',$outpoint);// . '('.$outpoint.')'; //test depth
				  //SYMBOL ON/OFF
				  
				  //deactivated WINDOW2.................................
				  
				  if (/*(!defined('WINDOW2_DPC')) &&*/ ($outpoint>4)) //show this->outpoint symbol when spaces-outpoint > 4
				    $mycat .=  $this->outpoint;
				} 				
			    $mycat .= $line;		
			    $mycat .= "</a>";
				$mycat .= str_repeat("<br/>", intval($br));	
				
			    //extra subcats
				if (GetReq('cat')) {//only if not in root				
				  if ($noencodeurl)
				    $mycat .= $this->show_selected_tree2($cmd,str_replace('_',' ',$gr),$showroot,$expand,null,$mystylesheet,($outpoint*2),/*$br*/0,/*$template*/null,$linkclass,$noencodeurl);//$subcats.'>';								
				  else				
                    $mycat .= $this->show_selected_tree2($cmd,/*rawurldecode*/str_replace('_',' ',$gr),$showroot,$expand,null,$mystylesheet,($outpoint*2),/*$br*/0,/*$template*/null,$linkclass,$noencodeurl);//$subcats.'>';								
				} 

			  }	
			}
		  }
		}
		
		return ($mycat);   			  
	}
	
	function show_selected_branch2($id,$line,$t=null,$myselcat=null,$showroot=null,$expand=null,$stylesheet=null,$outpoint=null,$br=1,$template=null,$linkclass=null,$noencodeurl=null) {
	       $mystylesheet = $stylesheet?$stylesheet:'group_category_title';	
		   //echo 'branch:',$mystylesheet,$outpoint,'<br>';
		   
		   //echo 'b:',$outpoint;
           if ($template) { //template
	         $tmpl = explode('.',$template);
	         $mytemplate = $this->select_template($tmpl[0],$cat);		
			 $mytemplate_show = $this->select_template($tmpl[0].'_show',$cat);
			 $mytemplate_hide = $this->select_template($tmpl[0].'_hide',$cat);
	       }
	       else			   
  	         $mytemplate = $this->select_template('fpcatcolumn',$cat);			   
			  
		    if ($line) {	
			  if ($this->usetablelocales) {
			    if (trim($myselcat)!=null) {
				
				  if ($showroot) {//root selections is present
				    //echo 'showroot:<br>';
				    if ($myselcat==$line) {//selction cat = current listed cat
					  //echo 'cat selection:'.$id.'<br>';
			          $folder = $id;
			          $gr = $noencodeurl ? str_replace(' ','_',$id) : /*rawurlencode(*/str_replace(' ','_',$id);//);				  
					}  
					else {
					  //echo 'no selection:'.$id.'<br>';
					  $folder = null;
					  $gr = $noencodeurl ? str_replace(' ','_',$id) : /*rawurlencode(*/str_replace(' ','_',$id);//);
					}
				  }
				  else {
				    //echo 'no showroot:'.$id.'<br>';
			        $folder = $myselcat . $this->cseparator . $id; 
			        $gr = $noencodeurl ? str_replace(' ','_',$myselcat . $this->cseparator . $id) : /*rawurlencode(*/str_replace(' ','_',$myselcat . $this->cseparator . $id);//);			   
				  }
				  
			    }	
			    else {
				  //echo 'no selcat:<br>';
			      $folder = $id;
			      $gr = $noencodeurl ? str_replace(' ','_',$id) : /*rawurlencode(*/str_replace(' ','_',$id);//); 
			    }	
				
				//$line = $line;			  
			  }
			  else {		 	  
			    if (trim($myselcat)!=null) {
				
				  if ($showroot) {//root selections is present
				    //echo 'showroot:<br>';
				    if ($myselcat==$line) {//selction cat = current listed cat
					  //echo 'cat selection:'.$line.'<br>';
			          $folder = $line;
			          $gr = $noencodeurl ? str_replace(' ','_',$line) : /*rawurlencode(*/str_replace(' ','_',$line);//);				  
					}  
					else {
					  //echo 'no selection:'.$line.'<br>';
					  $folder = null;
					  $gr = $noencodeurl ? str_replace(' ','_',$line) : /*rawurlencode(*/str_replace(' ','_',$line);//);	
					}
				  }
				  else {				
			        $folder = $myselcat . $this->cseparator . $line; 
			        $gr = $noencodeurl ? str_replace(' ','_',$myselcat . $this->cseparator . $line) : /*rawurlencode(*/str_replace(' ','_',$myselcat . $this->cseparator . $line);//);	
                  }				  
			    }	
			    else {
			      $folder = $line;
			      $gr = $noencodeurl ? str_replace(' ','_',$line) : /*rawurlencode(*/str_replace(' ','_',$line);//); 
			    }	
				
			    //after gr set ..localization............................!!!
			    if (($clanguage=getlocal())!=$this->deflan) {
			      $line = localize($line,$clanguage);			
			    }	
			  }		
				
			  //$gr = $current_leaf;		 
			  //$cgroup = $ptree[$cd+1]; //echo '>>',$cgroup;//$ptree[$depth];		 		
			  
              $mycat .= "<a href=\"" . seturl("t=$t&cat=$gr",null,null,null,null,$this->rewrite);
			  
			  if ($linkclass)
			    $mycat .=  "\" class=\"$linkclass\">";
			  elseif ($outpoint)
				$mycat .=  "\" class=\"". $mystylesheet . $outpoint . "\">";
			  else
                $mycat .=  "\">";			  
				
			  if ($outpoint) {
			    //SPACES on/off
			    //$mycat .= str_repeat('&nbsp;',$outpoint);// . '('.$outpoint.')'; //test depth
				//SYMBOL ON/OFF
				//if (!defined('WINDOW2_DPC')) 
				  //$mycat .= $this->outpoint;
			  }					
				
			  $mycat .= $line;//summarize($wordlength,$line);		
			  $mycat .= "</a>";	

			  //echo $folder,'<br>'; 
			  $winbody = $folder ? $this->read_selected_tree2($folder,$t,null,$expand,$mystylesheet,($outpoint*2),/*$br*/1,$template,$linkclass,$noencodeurl) : null;
 		      $data[] = $winbody;
              $attr[] = "left;";	
			  //echo $winbody;
			  
			  //deactivated WINDOW2.................................
			  
			  /*if (($winbody) && (defined('WINDOW2_DPC'))) {//if winbody show/hide
			    if ($expand)  
				  $exd = 'SHOW';
				else
				  $exd = 'HIDE';  
				  
		        $win1 = new window2($line,$data,null,1,null,$exd,null,1);
	            $out .= $win1->render("center::99%::0::$mystylesheet::left::0::0::");
		        unset ($win1);		  
			  }
			  else {*/				    
 			    if ($mytemplate) {  
				  //echo 'b',$mytemplate;
			      $tokens[] = $mycat;
				  $tokens[] = $expand?$winbody:null;
				  //$out .= $this->combine_tokens($mytemplate, $tokens);	
				  if (($expand) && ($winbody)) //autohide if no winbody
			        $out .= $this->combine_tokens($mytemplate_show, $tokens, true);					
				  else
				    $out .= $this->combine_tokens($mytemplate_hide, $tokens, true);					
			  	}
				elseif ($outpoint) {//by pass window CSS
				  //as is mystylesheet+outpoint CSS
				  $out .= $mycat .'<br>'. $winbody;// . '<br>'; //SPACE BETWEEN SUBS
				}
				else {
                  //echo 'a';	
                  if (($expand) && ($winbody))				  
		            $win1 = new window($mycat,$data,$attr);
				  else 
				    $win1 = new window($mycat,null,null);
	              $out .= $win1->render("center::99%::0::$mystylesheet::left::0::0::");
		          unset ($win1);			  
				}
			  //}//deactivated WINDOW2.................................
			  
			  unset($data);
			  unset($attr);
			  //$out .= '<br>';
			  //SPACE BETWEEN SUBCATS
			  $out .= str_repeat("<br/>",intval($br));
			}//if  	 
		  
		return ($out);  
	}
	
    function show_selected_tree2($cmd=null,$group=null,$showroot=null,$expand=null,$viewlevel=null,$stylesheet=null,$outpoint=null,$br=1,$template=null,$linkclass=null,$noencodeurl=null) {
	  $mystylesheet = $stylesheet?$stylesheet:'group_category_title';	
	  $cat = /*rawurldecode(*/str_replace('_',' ',GetReq('cat'));//);	
	  $g = /*rawurldecode(*/str_replace('_',' ',$group);//);	
      $myselcat = $g?$g:$cat;
	  //$br = $br?$br:1;	
      //echo 'A:',$outpoint; 
      //$outpoint = $outpoint ? $outpoint : 2;  
      $noencodeurl = $this->notencodeurl?$this->notencodeurl:$noencodeurl;	  
	  
      static $cd = -1;
	  $wordlength = 19;//for calldpc purposes
	  $t = $cmd?$cmd:'klist';
	  
	  //echo $mystylesheet,$outpoint,'<br>';	  

	  $ptree = explode($this->cseparator,$myselcat); //print_r($ptree);
			  
	  if ($viewlevel) {
	    $depth = count($ptree);
		//echo 'DEPTH:',$depth,'VIEWLEVEL:',$viewlevel;
	    //echo $cat;    
		if ($depth>$viewlevel) {
		  foreach ($ptree as $p=>$pt) {
		    if ($p<$viewlevel) 
		      $pv[] = $pt;
		  }	
		  $myselcat = implode($this->cseparator,$pv);
		  //echo $myselcat;
		}
	  }
	  //else
        //$myselcat = $g?$g:$cat;	
		
	  	    
	  if ($showroot) 
	    $ddir = $this->read_tree(null,null,1);
	  else/*if ($myselcat) */	
	    $ddir = $this->read_tree($myselcat,null,1);	
	  /*elseif ($showroot) 
	    $ddir = $this->read_tree(null,null,1);*/
				
	  $i=0;	 
      if ($ddir)  {	   
          reset($ddir);
          foreach ($ddir as $id => $line) {		  
            $out .= $this->show_selected_branch2($id,$line,$t,$myselcat,$showroot,$expand,$mystylesheet,$outpoint,$br,$template,$linkclass,$noencodeurl);
			$i+=1; 
		  }//foreach				
	  }//if ddir
	  
	  return ($out);
    }	
	//.....  SHOW SELECTED TREE FUNCTIONS	2
	
	
	function show_navigator($cmd=null,$group=null,$notheme=null) {
		$group = $group?$group:str_replace('_',' ',GetReq('cat'));	  				  
		
        if (($this->nav_on) && ($group)) {		

          //directory path
		  
		  if ($notheme) {
		    $out .= $this->view_analyzedir($cmd,null,0,null);//$group,1);
		  }
		  else {		  	
            $data2[] = $this->view_analyzedir($cmd,null,0,null);//$group,1);
            $attr2[] = "left;";

            if ($data2)  {
		       $win2 = new window('',$data2,$attr2);
		       $out .= $win2->render("center::100%::0::group_dir_headtitle::left::0::0::");
		       unset ($win2);
		    }
	      }		
		} 
		
		return ($out);	
	}
	
	function show_submenu($cmd=null,$viewtype=3,$group=null,$notheme=null, $rendertable=false) {
		$group = $group?$group:str_replace('_',' ',GetReq('cat'));	
	
		$result = $this->read_tree($group);	
		$out = $this->view_category($result,$viewtype,$mode,$group,$cmd); 
		
	    //table generation
	    if ($rendertable) {
	     if ($this->result_in_table) { 
			$categories = explode('<SPLIT/>',$out); //<li> split..
			$ret = $this->make_table($categories, $this->result_in_table, 'fptreetable');  	  
		 }
		 else
		    $ret = $out;
	    }
		
        return ($ret);				
	}	
	
    function show_menu($cmd=null,$viewtype=3,$viewtree=0,$group=null,$title=null,$tree=null,$template=null) { 
	    
		$group = $group?$group:str_replace('_',' ',GetReq('cat'));	  				  
		
        if (($this->nav_on) && ($group) && ($template==null)) {		

          //directory path	
          $data2[] = $this->view_analyzedir($cmd,null,0,null);//$group,1);
          $attr2[] = "left;";

          if ($data2)  {
		     $win2 = new window('',$data2,$attr2);
		     $out .= $win2->render("center::100%::0::group_dir_headtitle::left::0::0::");
		     unset ($win2);
		  }
		} 
		
		//????????????????????????? DESTROY PAGE RESULT........paging
		//$result = $this->read_tree($group);	
		//$out .= $this->view_category($result,$viewtype,$mode,$group,$cmd); 

		if ($group) {
			
           $t = $this->path . $this->tmpl_path .'/'. $this->tmpl_name .'/'. str_replace('.',getlocal().'.',$template) ;
		   
           // view tree 
		   if (($template) && is_readable($t)) {	   
			  	   
	         //echo $t,'>';
	         //group element template
	         $template1 = 'fpkatnav-accordion-group.htm';
	         $t1 = $this->path . $this->tmpl_path .'/'. $this->tmpl_name .'/'. str_replace('.',getlocal().'.',$template1) ;			 
			 
			 switch ($viewtype) { 
				case 3  : /*experimental for unfolded kategories..*/
                case 2  : $stree[] = $this->show_tree3($cmd,null,'',0,1,60,1,null,@file_get_contents($t1));	break;	 			 
			    case 1  :
				default : $stree[] = $this->show_tree2($cmd,null,'',0,0,60,1,null,@file_get_contents($t1));		 
			 }
			 
		     $mytemplate = file_get_contents($t);
             $out = $this->combine_tokens($mytemplate,$stree);			 
		   }
		   else {
             $stree = $this->show_tree($cmd,null,'',0,0,60); 		   
		   
		     $data3[] = $stree; //tree view
		     $attr3[] = "left;30%"; 

		     $title?$title:'';
		   
		     $win2 = new window($title,$data3,$attr3);
		     $out .= $win2->render();//"center::100%::0::group_dir_title::left::0::0::");
		     unset ($win2); 			 
           }		
		}		
        return ($out);
    }			
	
	//read tree table
	function read_tree($g=null,$debug=null,$orderctg=null) {
       $db = GetGlobal('db');	
	   $lan = getlocal();
	   $mylan = $lan?$lan:'0';
	   //echo $this->usetablelocales,'>'; 	   
	   
       if ($this->usetablelocales)
	     $f = $mylan; 
	   else
	     $f = null; //duplicate select!!!cat123 as index, 01,11 as lang	  
	   
	   
	   if (strlen(trim($g))>0) {
	     $group = explode($this->cseparator,$g);   //print_r($group);
	     $mg = count($group);
	     $depth = ($mg ? $mg : 0); //echo 'DEPTH:',$depth;
	   }
	   else
	     $depth = 0;	
		 
	   if ($this->usetablelocales) {		     
	   
	     switch ($depth) {
	       case 1 : $sSQL = "select cat3,cat{$f}3,cat2,cat{$f}2 from categories where "; break;
		   case 2 : $sSQL = "select cat4,cat{$f}4,cat3,cat{$f}3,cat2,cat{$f}2 from categories where "; break;
		   case 3 : $sSQL = "select cat5,cat{$f}5,cat4,cat{$f}4,cat3,cat{$f}3,cat2,cat{$f}2 from categories where "; break;
		   case 4 : $sSQL = "select null from categories"; break;
		   default: $sSQL = "select cat2,cat{$f}2 from categories where "; break;
	     }
	     //$sSQL .= ' where '; 
	     switch ($depth) {
	       case 4 : 
	       case 3 : $sSQL .= "(cat4='" . str_replace('_',' ',$group[2]) . "' or cat{$f}4='" . str_replace('_',' ',$group[2]) . "') and ";
		   case 2 : $sSQL .= "(cat3='" . str_replace('_',' ',$group[1]) . "' or cat{$f}3='" . str_replace('_',' ',$group[1]) . "') and ";
		   case 1 : $sSQL .= "(cat2='" . str_replace('_',' ',$group[0]) . "' or cat{$f}2='" . str_replace('_',' ',$group[0]) . "') and "; //break;
		   default: $sSQL .= "ctgid>0 and active>0 and view>0";//"cat1='ΚΑΤΗΓΟΡΙΕΣ ΕΙΔΩΝ'";/*if (seclevel('SENPTREEADMIN_',$this->userLevelID)) {
/*		              $sSQL .= "CTGLEVEL1='ΚΑΤΗΓΟΡΙΕΣ ΕΙΔΩΝ'";
					}
					else {*/
					  //$sSQL .= " and cat2 not like 'LOST+FOUND')"; 
					//}  
	     }
		 //if ($debug)
	       //echo $sSQL;	   
	   }
	   else {
	     switch ($depth) {
	       case 1 : $sSQL = "select cat3,cat2 from categories where "; break;
		   case 2 : $sSQL = "select cat4,cat3,3,cat2 from categories where "; break;
		   case 3 : $sSQL = "select cat5,cat4,cat3,cat2 from categories where "; break;
		   case 4 : $sSQL = "select null from categories"; break;
		   default: $sSQL = "select cat2 from categories where "; break;
	     }
	     //$sSQL .= ' where '; 
	     switch ($depth) {
	       case 4 : 
	       case 3 : $sSQL .= "cat4='" . str_replace('_',' ',$group[2]) . "' and ";
		   case 2 : $sSQL .= "cat3='" . str_replace('_',' ',$group[1]) . "' and ";
		   case 1 : $sSQL .= "cat2='" . str_replace('_',' ',$group[0]) . "' and "; //break;
		   default: $sSQL .= "ctgid>0 and active>0 and view>0";//"cat1='ΚΑΤΗΓΟΡΙΕΣ ΕΙΔΩΝ'";/*if (seclevel('SENPTREEADMIN_',$this->userLevelID)) {
/*		              $sSQL .= "CTGLEVEL1='ΚΑΤΗΓΟΡΙΕΣ ΕΙΔΩΝ'";
					}
					else {*/
					  //$sSQL .= " and cat2 not like 'LOST+FOUND')"; 
					//}  	   
	     }	
       }
	   
	   //if ($orderctg)
	     $sSQL .= " order by ctgoutlnorder";//,ctgid asc";
		 
	   //echo $sSQL;   
	   //var_dump($this->exclude);
	   
       //cache queries 
	   //if ($this->cachequeries) $result = $db->CacheExecute($this->cachetime,$sSQL);
                           //else 
	   $result = $db->Execute($sSQL,2);
       //save as var for tags
	   //$this->cat_result = $result;
	 
	   //print_r($result);					   					   
	   if ($result) {      

	     while(!$result->EOF) {
		   
		   if ($this->usetablelocales) {
		     $f = $result->fields[0];
			 $v = $result->fields[1];
			 
		     if ($f) 
		       $res[$f] = $v;			 
		   }
		   else {
		     $f = $result->fields[0];
		     $_g = implode($this->cseparator,array_reverse($result->fields)); //echo $_g,"<br>";
		   
	         //if (($this->exclude) && (trim($f)) && (!in_array(trim($_g),$this->exclude)) ) 
		     if ($f) 
		       $res[$f] = $f; //echo $f,'<br>';
		   }	 
		   
		   $result->MoveNext();
		   $i+=1;
	     } 
		 
         //if ($this->usetablelocales)   						   	
         //print_r($res);
  		   	
	     return ($this->distinct($res));
	   }

	}	

	
	function set_tree_path($array_path) {
	  
	    //$ret = implode($this->cseparator,$array_path);
		$ret = null;
		$max = count($array_path);
		foreach ($array_path as $id=>$path) {
		  
		  if (trim($path)) {
		    if ($id==0) $ret .= $path; 
			       else $ret .= $this->cseparator . $path;
		  }    
		}
		
		return $ret;
	}	
	
    function isparent($group=null) {
	   
	    if ($this->alias) $group = $this->alias; 

		if (is_array($this->read_tree($group))) 
		  return true;
		else 
		  return false;
	}			
	
    //get depth of group	
    function get_treedepth($group=null) {  
	
	    if (!$group) $group = GetReq('cat');
		$selection = GetReq('sel');
	
        $splitx = explode ($this->cseparator, $group);
		
	    if ($selection!=array_pop($splitx)) 
		    $cats = explode ($this->cseparator, $group.$this->cseparator.$selection);
		else
		    $cats = explode ($this->cseparator, $group);
		         

        return (count($cats)-1);
    }		
	
    function analyzedir($group,$startup=0) {
	
	    //if executed at event...
		if ($this->cat_result)
		    return ($this->cat_result);
	
        $sel = GetReq('sel');
	    $db = GetGlobal('db');	
	    $lan = getlocal();
	    $f = $lan?$lan:'0';			
		
	    //if ($selection= GetReq('sel')) 
		  //$group .= $this->cseparator.$selection;
        $adir = array();
		
        if ($startup) { 
		  $adir[] = $this->home; //set home
		}  
  
        $splitx = explode ($this->cseparator, $group);   
		
        if ($this->usetablelocales)	{
		    $sSQL = "select distinct cat2,cat{$f}2,cat3,cat{$f}3,cat4,cat{$f}4,cat5,cat{$f}5 from categories where ";
			$depth = count($splitx)-1;
			//echo '>',$depth;
			switch ($depth) {
			  case 3  :$sSQL .= "cat5='".str_replace('_',' ',$splitx[3])."' and ";
			  case 2  :$sSQL .= "cat4='".str_replace('_',' ',$splitx[2])."' and ";
			  case 1  :$sSQL .= "cat3='".str_replace('_',' ',$splitx[1])."' and ";
			  case 0  :$sSQL .= "cat2='".str_replace('_',' ',$splitx[0])."'"; 
			  default :
			}
			
			$sSQL .= " and (ctgid>0 and active>0)";
			//echo $sSQL;
	        $result = $db->Execute($sSQL,2);
			//save as var for tags
            //$this->cat_result = $result; 
			
	        if ($result) {     
			  for ($i=0;$i<=$depth;$i++) {
			   $c = $i+2;
			   if ($result->fields["cat{$f}{$c}"])
		         $adir[$result->fields["cat{$c}"]] = $result->fields["cat{$f}{$c}"];			 
			 } 
		    }			  					
		}		      
		else {
		  foreach ($splitx as $id=>$category) {
		    //check @names and remove it form titles
		    $p = explode('@',$category);
		    $adir[] = $p[0];
		  } 
		   
 	      if (($sel) && ($sel!=$category))//last cat
		    $adir[] = $sel;			  
		}  
		
		
        //print_r ($adir);
		
		//save as var for tags
		$this->cat_result = $adir;
			
		//depthview restiction	
		if ($this->depthview) {	
		  $depthview = $this->depthview+$startup;
		  //for($i=0;$i<$depthview;$i++)
		  $i=0;
		  foreach ($adir as $a=>$b) {
		    if ($i<$depthview) {
		      $ret_adir[$a] = $b;
			}
			$i+=1;
		  }	
		}  
		else
		  $ret_adir = $adir;  	  
        
        //return ($adir);
		return ($ret_adir);
    }
	
    function view_analyzedir($cmd=null,$prefix=null,$startup=0,$symbol=null,$tokens=null,$nosymbol=null,$nolinks=null) { 	
		//$t = GetReq('t');//$this->dirview; //GetReq('t'); 
		$t = ($cmd?$cmd:GetReq('t'));	
		$g = str_replace(' ','_',GetReq('cat'));
		$a = GetReq('a');	   	
		
		if (($tokens) && ($prefix)) 
          $mytokens[] = $prefix;
		
	    $dmark = ($symbol) ? $symbol : $this->rightarrow;	
	
		//analyze dir		
        $adirs = $this->analyzedir($g,$startup);	
        if (!empty($adirs)) {		
				
          if ($this->usetablelocales)	{	
		
		    //startup meters
		    $max = count($adirs)-1; 
		    if ($startup) $m = 1;
		             else $m = 0;		
			$m2 = 0;		 	
		    foreach ($adirs as $id=>$cname) {	
			  
		      $locname = $cname;	
			  
    		  if ($m2<=$max) { //< .......... link last element 
			  
			    if ($m2==$max)
			      $title = "<B>$locname</B>";
				else  
				  $title = "$locname";			  
			  
                if ($cname != $this->home) {
				
		          if ($m2>$m) $curl .= $this->cseparator . str_replace(' ','_',$id);
			             else $curl .= str_replace(' ','_',$id);
					  
			      $mygroup = $curl;//rawurlencode($curl);
			   
			      $a = seturl("t=$t&cat=$mygroup",null,null,null,null,$this->rewrite);
				  $b = "<a href=\"" . seturl("t=$t&cat=$mygroup",null,null,null,null,$this->rewrite) . "\">" . $locname . "</a>&nbsp;" . $dmark . "&nbsp;";
		        }	
	            else {
   	              $a = seturl("t=",null,null,null,null,$this->rewrite);
				  $b = "<a href=\"" . seturl("t=",null,null,null,null,$this->rewrite) . "\">" . $locname . "</a>&nbsp;" . $dmark . "&nbsp;";					
			    }
				
			    $ablink = ($nolinks) ? $a : $b;						  
	          
		        if ($tokens) 
				   $mytokens[] = ($nolinks) ? $ablink.'@'.$locname.'@'.$mygroup : $ablink;				      
			    else 		  
                   $aprint .= $ablink;
			  }	
		      else { //m2 <= is link now....
                //current directory   

		        if ($tokens) 
				  $mytokens[] = $locname;				   
			    else 			   
                  $aprint .= "<B>$locname</B>" . "&nbsp;" . $dmark . "&nbsp;";		  
		      }		
			  $m2+=1;	 
			}//foreach  
		  //}//result	
		  }  				
	      else {			
		
			//startup meters
			$max = count($adirs)-1; 
			if ($startup) $m = 1;
					 else $m = 0;
		    //print_r($adirs);
		    foreach ($adirs as $id=>$cname) {	  
		
		      //localization............................
		      if (($clanguage=getlocal())!=$this->deflan)
		        $locname = str_replace('_',' ',localize($cname,$clanguage));
		      else  
		        $locname = str_replace('_',' ',$cname);	  
		  
		      if ($id<$max) {
               if ($cname != $this->home) {			   
		   
		         if ($id>$m) $curl .= $this->cseparator . $cname;
			            else $curl .= $cname;
					  
			     $mygroup = $curl;//rawurlencode($curl);
			     $a = seturl("t=$t&cat=$mygroup",null,null,null,null,$this->rewrite);
				 $b = "<a href=\"" . seturl("t=$t&cat=$mygroup",null,null,null,null,$this->rewrite) . "\">" . $locname . "</a>&nbsp;" . $dmark . "&nbsp;";
		       }	
	           else {
			     $a = seturl("t=",null,null,null,null,$this->rewrite);
				 $b = "<a href=\"" . seturl("t=",null,null,null,null,$this->rewrite) . "\">" . $locname . "</a>&nbsp;" . $dmark . "&nbsp;";		   
		       }	
			   
			   $ablink = ($nolinks) ? $a : $b;		   
		   
		       if ($tokens) 
				 $mytokens[] = $ablink; 
			   else 
				 $aprint .= (!$nolinks) ? $ablink : null;
		      }
		      else { //current directory   

			    if ($tokens) 			   
				  $mytokens[] = $locname;
			    else 
				  $aprint .= "<B>$locname</B>" . "&nbsp;" . $dmark . "&nbsp;";		   
		      }
		    }	
		  } //usetablelocales 
		}//adirs
		
		if ($tokens)
		  return ($mytokens);
		else  
          return ($prefix.$aprint);
    }	
	
	function getcurrentkategory($toplevel=null, $url=null) {
	  //$toplevel = 2;
	  $g = str_replace(' ','_',GetReq('cat'));	
	  //echo $toplevel,'>',GetReq('cat');
	  //analyze dir		
      $mycattree = $this->analyzedir($g);		
	  //print_r($mycattree);
	  if (empty($mycattree)) return;
	  
	  if ($toplevel) {
	    switch ($toplevel) {
		  case 2  ://prevlevel
		           $dummy = array_pop($mycattree);
				   if (!$ret = array_pop($mycattree)) 	  
				     $ret = $dummy;	 
		           break;
          case 1  ://toplevel
		  default :if ($url) 
		              $ret = seturl('t=klist&cat='. GetReq('cat'),array_pop($mycattree),null,null,null,$this->rewrite);
                   else 
		              $ret = array_pop(array_reverse($mycattree));	  
		}
	  }	
	  else {//actual
	    if ($url) 
		  $ret = seturl('t=klist&cat='. GetReq('cat'),array_pop($mycattree),null,null,null,$this->rewrite);
        else	  
	      $ret = array_pop($mycattree);	  	
	  }
	  //echo $ret,'>';	  
	  return ($ret);
	}	
	
    function tree_navigation($cmd=null,$prefix=null,$home=0,$dropdown_tmpl=null) {
	   //if ($prefix) $home=0; else $home=1;
       //if ($this->nav_on) {	
	   	
	   $template = 'fpkatnav.htm';	   
	   $t = $this->path . $this->tmpl_path .'/'. $this->tmpl_name .'/'. str_replace('.',getlocal().'.',$template) ; 
	   //element 1nd template
	   $template1 = 'fpkatnav-element.htm';
	   //$t1 = $this->path . $this->tmpl_path .'/'. $this->tmpl_name .'/'. str_replace('.',getlocal().'.',$template1) ;	   
	   //echo $t,'>';
	   if (($template) && is_readable($t)) {
	      //echo $template,'>';
		  $mytemplate = file_get_contents($t);
		
	      //dropdown 2nd template
	      $t2 = $this->path . $this->tmpl_path .'/'. $this->tmpl_name .'/'. str_replace('.',getlocal().'.',$dropdown_tmpl) ; 
          if (($dropdown_tmpl) && is_readable($t2)) {
		  
		  	$navdata = $this->view_analyzedir($cmd,$prefix,null,null,1,1,1);
			//print_r ($navdata);
			if (empty($navdata)) { //no dropdown
				//....
			}			
			else { // dropdown
			    //$mytemplate1 = file_get_contents($t1);
				$mytemplate2 = file_get_contents($t2);
			
				//foreach category element 
				//$category = null;
				foreach ($navdata as $n=>$data) {
					$tdata = explode('@',$data); //call view_analyzedir with nolinks,nosymbol param
					$tok[] = $tdata[0]; //url
					$tok[] = $tdata[1]; //title
					//$category .= ($n>0) ? $this->cseparator . $tdata[2] : $tdata[2]; //make category string
					$tok[] = $tdata[2];//$category;//^category
					$tok[] = ($n==count($navdata)-1) ? 1 : 0; //last element = current
					//$tok[] = $this->show_selected_tree('klist',$tdata[2],null,null,null,null,null,null,$template1);
					$navdata2[] = $this->combine_tokens($mytemplate2,$tok,true);
					//print_r($tok);
					unset($tok);
				}  
			  
				$out = $this->combine_tokens($mytemplate,$navdata2);
			}
          }
          else	{	  
		    $navdata = $this->view_analyzedir($cmd,$prefix,$home,null,1);
			$out = $this->combine_tokens($mytemplate,$navdata);
		  }	
		  //print_r($navdata);
		  //echo $mytemplate;
	   }
	   else {	
	   
          //directory path	
          $data2[] = $this->view_analyzedir($cmd,$prefix,$home);
          $attr2[] = "left;";	   	  

          if ($data2)  {
		     $win2 = new window('',$data2,$attr2);
		     $out .= $win2->render("center::100%::0::group_dir_headtitle::left::0::0::");
		     unset ($win2);
		  }  
	    }	  
		  
		//}				  
		  
		return ($out);
    }
	
    function get_exclude_trees() {
   
     $ret = GetPreSessionParam('sexclude');
	 //print_r($ret);
	 
	 if (is_array($ret)) {
	 
       return ($ret);
     }
	 else {
       $file = paramload('SHELL','prpath')."exclude_sen.txt";
   
       if (file_exists($file)) {
         $f = fopen($file,"r");
	     $data = fread($f,filesize($file));
	     fclose($f);
	   
	     $ret = explode(",",$data);
	   
	     SetPreSessionParam('sexclude',$ret);
	     //print_r($ret);
	     return ($ret); 	   
	   }
	 }
	 
	 return null;
    }		
	
	function distinct($arr) {
	  
	   if (is_array($arr)) {
	     $out = array_unique($arr);
		 
		 asort($out);
		 
		 return ($out);
	   }	 
	}
	
    function getgroup($localize=0) {
	
	    $group = GetReq("g");   

		$ret_a = explode($this->cseparator,$group);
		$max = count($ret_a)-1;
		
		//localization............................
		if ($localize) {
		  if (($clanguage=getlocal())!=$this->deflan)
		    $localizeit = localize($ret_a[$max],$clanguage);
		  else  
		    $localizeit = $ret_a[$max];			
		
		  return ($localizeit);	 
		}
		
		return ($ret_a[$max]);	
	}
	
	//old
    function getkategories_old($rec=null,$links=null,$lan=null,$cmd=null) {
	   $db = GetGlobal('db');
	   $cmd = $cmd?$cmd:'shkategories';
	   //print_r($rec);
	   //echo '>',$this->depthview;
	   //$lan = getlocal();
	   //$f = $lan ? $lan : '0';
	   
				
		if ((isset($lan)) && ($f=$lan>=0) && ($this->usetablelocales))	{
		    $sSQL = "select distinct cat2,cat{$f}2,cat3,cat{$f}3,cat4,cat{$f}4,cat5,cat{$f}5 from categories where ";

			if (($rec['cat0']) && ($this->depthview>=1)) $sSQL .= "cat2='".str_replace('_',' ',$rec['cat0'])."'"; 
			if (($rec['cat1']) && ($this->depthview>=2)) $sSQL .= "and cat3='".str_replace('_',' ',$rec['cat1'])."'";
			if (($rec['cat2']) && ($this->depthview>=3)) $sSQL .= "and cat4='".str_replace('_',' ',$rec['cat2'])."'";
			if (($rec['cat3']) && ($this->depthview>=4)) $sSQL .= "and cat5='".str_replace('_',' ',$rec['cat3'])."'";			  			  			  

			
			//$sSQL .= " and (ctgid>0 and active>0)";
			//echo $sSQL;
	        $result = $db->Execute($sSQL,2);	
	  					
		}	
		
		if ($lan) {
		  $_cat0 = $result->fields["cat{$f}2"]?$result->fields["cat{$f}2"]:str_replace(' ','_',$rec['cat0']);
		  $_cat1 = $result->fields["cat{$f}3"]?$result->fields["cat{$f}3"]:str_replace(' ','_',$rec['cat1']);
		  $_cat2 = $result->fields["cat{$f}4"]?$result->fields["cat{$f}4"]:str_replace(' ','_',$rec['cat2']);
		  $_cat3 = $result->fields["cat{$f}5"]?$result->fields["cat{$f}5"]:str_replace(' ','_',$rec['cat3']);
		}
		else {
		  $_cat0 = $result->fields["cat2"]?$result->fields["cat2"]:str_replace(' ','_',$rec['cat0']);
		  $_cat1 = $result->fields["cat3"]?$result->fields["cat3"]:str_replace(' ','_',$rec['cat1']);
		  $_cat2 = $result->fields["cat4"]?$result->fields["cat4"]:str_replace(' ','_',$rec['cat2']);
		  $_cat3 = $result->fields["cat5"]?$result->fields["cat5"]:str_replace(' ','_',$rec['cat3']);		
		}

				 
                 if (($rec['cat0']) && ($this->depthview>=1)) {
				      if ($links)
					    $ck[0] = seturl("t=$cmd&cat=".$rec['cat0'],$_cat0,null,null,null,$this->rewrite);
					  else
                        $ck[0] = $_cat0;
				 }  	
				 	
                 if (($rec['cat1']) && ($this->depthview>=2)) {
				      if ($links)
					    $ck[1] = seturl("t=$cmd&cat=".$rec['cat0'].$this->cseparator.$rec['cat1'],$_cat1,null,null,null,$this->rewrite);
					  else				   
                        $ck[1] = $_cat1;
				 }		

                 if (($rec['cat2']) && ($this->depthview>=3)) {
				      if ($links)
					    $ck[2] = seturl("t=$cmd&cat=".$rec['cat0'].$this->cseparator.$rec['cat1'].$this->cseparator.$rec['cat2'],$_cat2,null,null,null,$this->rewrite);
					  else					 
                        $ck[2] = $_cat2;
				 }		  
 
                 if (($rec['cat3']) && ($this->depthview>=4)) {
				    if ($links)
					  $ck[3] = seturl("t=$cmd&cat=".$rec['cat0'].$this->cseparator.$rec['cat1'].$this->cseparator.$rec['cat2'].$this->cseparator.$rec['cat3'],$_cat3,null,null,null,$this->rewrite);
					else				 
                      $ck[3] = $_cat3;
				 }	
				   
                 //............
                 if (($rec['cat4']) && ($this->depthview>=5)) {
				    if ($links)
					  $ck[4] = seturl("t=$cmd&cat=".$rec['cat0'].$this->cseparator.$rec['cat1'].$this->cseparator.$rec['cat2'].$this->cseparator.$rec['cat3'].$this->cseparator.$rec['cat4'],str_replace(' ','_',$rec['cat4']),null,null,null,$this->rewrite);
					else				 
                      $ck[4] = str_replace(' ','_',$rec['cat4']);
				 }	
				  	  	
                 if (!empty($ck))
                   $cat = implode($this->cseparator,$ck);//print_r($ck);
                 //echo $cat,'<br>';
                 unset($ck); //reset ck

                 return ($cat);
    }	

    function getkategories($rec=null,$links=null,$lan=null,$cmd=null, $debug=false) {
	   $db = GetGlobal('db');
	   $cmd = $cmd?$cmd:'shkategories';
	   //print_r($rec);
	   //echo '>',$this->depthview;
	   //echo $lan,'>';
	   
		if ((isset($lan)) && ($f=$lan>=0) && ($this->usetablelocales))	{
		    $sSQL = "select distinct cat2,cat{$f}2,cat3,cat{$f}3,cat4,cat{$f}4,cat5,cat{$f}5 from categories where ";

			if (($rec['cat0']) && ($this->depthview>=1)) $sSQL .= "cat2='".str_replace('_',' ',$rec['cat0'])."'"; 
			if (($rec['cat1']) && ($this->depthview>=2)) $sSQL .= "and cat3='".str_replace('_',' ',$rec['cat1'])."'";
			if (($rec['cat2']) && ($this->depthview>=3)) $sSQL .= "and cat4='".str_replace('_',' ',$rec['cat2'])."'";
			if (($rec['cat3']) && ($this->depthview>=4)) $sSQL .= "and cat5='".str_replace('_',' ',$rec['cat3'])."'";			  			  			  

			
			//$sSQL .= " and (ctgid>0 and active>0)";
			//if ($debug)
			  //echo $sSQL;
	        $result = $db->Execute($sSQL,2);	
	  					
		}	
		
		if ($lan) {
		  $_cat0 = $result->fields["cat{$f}2"]?$result->fields["cat{$f}2"]:str_replace(' ','_',$rec['cat0']);
		  $_cat1 = $result->fields["cat{$f}3"]?$result->fields["cat{$f}3"]:str_replace(' ','_',$rec['cat1']);
		  $_cat2 = $result->fields["cat{$f}4"]?$result->fields["cat{$f}4"]:str_replace(' ','_',$rec['cat2']);
		  $_cat3 = $result->fields["cat{$f}5"]?$result->fields["cat{$f}5"]:str_replace(' ','_',$rec['cat3']);
		}
		else {
		  $_cat0 = $result->fields["cat2"]?$result->fields["cat2"]:str_replace(' ','_',$rec['cat0']);
		  $_cat1 = $result->fields["cat3"]?$result->fields["cat3"]:str_replace(' ','_',$rec['cat1']);
		  $_cat2 = $result->fields["cat4"]?$result->fields["cat4"]:str_replace(' ','_',$rec['cat2']);
		  $_cat3 = $result->fields["cat5"]?$result->fields["cat5"]:str_replace(' ','_',$rec['cat3']);		
		}
								

				 
                 if (($rec['cat0']) && ($this->depthview>=1)) {
				      if ($links)
					    $ck[0] = seturl("t=$cmd&cat=".$rec['cat0'],$_cat0,null,null,null,$this->rewrite);
					  else
                        $ck[0] = $_cat0;
				 }  	
				 	
                 if (($rec['cat1']) && ($this->depthview>=2)) {
				      if ($links)
					    $ck[1] = seturl("t=$cmd&cat=".$rec['cat0'].$this->cseparator.$rec['cat1'],$_cat1,null,null,null,$this->rewrite);
					  else				   
                        $ck[1] = $_cat1;
				 }		

                 if (($rec['cat2']) && ($this->depthview>=3)) {
				      if ($links)
					    $ck[2] = seturl("t=$cmd&cat=".$rec['cat0'].$this->cseparator.$rec['cat1'].$this->cseparator.$rec['cat2'],$_cat2,null,null,null,$this->rewrite);
					  else					 
                        $ck[2] = $_cat2;
				 }		  
 
                 if (($rec['cat3']) && ($this->depthview>=4)) {
				    if ($links)
					  $ck[3] = seturl("t=$cmd&cat=".$rec['cat0'].$this->cseparator.$rec['cat1'].$this->cseparator.$rec['cat2'].$this->cseparator.$rec['cat3'],$_cat3,null,null,null,$this->rewrite);
					else				 
                      $ck[3] = $_cat3;
				 }	
				   
                 //............
                 if (($rec['cat4']) && ($this->depthview>=5)) {
				    if ($links)
					  $ck[4] = seturl("t=$cmd&cat=".$rec['cat0'].$this->cseparator.$rec['cat1'].$this->cseparator.$rec['cat2'].$this->cseparator.$rec['cat3'].$this->cseparator.$rec['cat4'],str_replace(' ','_',$rec['cat4']),null,null,null,$this->rewrite);
					else				 
                      $ck[4] = str_replace(' ','_',$rec['cat4']);
				 }	
				  	  	
                 if (!empty($ck))
                   $cat = implode($this->cseparator,$ck);//print_r($ck);
                 //echo $cat,'<br>';
                 unset($ck); //reset ck

                 return ($cat);
    }	
	
	function search_tree($text2find=null,$cmd='shkategories',$template=null) {
       $db = GetGlobal('db');			
	   $cat2findin = GetReq('cat');
	   $meter=0;	
	   $viewtype=1;
	   $lan = getlocal();   
	   $mylan = $lan?$lan:'0';
	   //echo $this->usetablelocales,'>'; 	   
       if ($this->usetablelocales)
	     $f = $mylan; 
	   else
	     $f = null; //duplicate select!!!cat123 as index, 01,11 as lang	  	   
		 
	   if (!$text2find) return;	 
	
	   for($i=2;$i<=5;$i++) {//echo $i,'<br>';
	   
         $sSQL = 'select ';//cat2,cat3,cat4,cat5 from categories where ';	   
	     if ($this->usetablelocales) {		 
		   switch ($i) {
		     case 2 : $sSQL .= "cat2,cat{$f}2"; break;
		     case 3 : $sSQL .= "cat2,cat{$f}2,cat3,cat{$f}3"; break;
		     case 4 : $sSQL .= "cat2,cat{$f}2,cat3,cat{$f}3,cat4,cat{$f}4"; break;
		     case 4 : $sSQL .= "cat2,cat{$f}2,cat3,cat{$f}3,cat4,cat{$f}4,cat5,cat{$f}5"; break;		   
		   }
		 }
		 else {
		   switch ($i) {
		     case 2 : $sSQL .= 'cat2'; break;
		     case 3 : $sSQL .= 'cat2,cat3'; break;
		     case 4 : $sSQL .= 'cat2,cat3,cat4'; break;
		     case 5 : $sSQL .= 'cat2,cat3,cat4,cat5'; break;		   		   		   
		   }		 
		 }
		 $sSQL.= ' from categories where ';
		 
	     if ($this->usetablelocales) {
	       $sSQL.= "(cat{$f}$i like ". $db->qstr('%'.strtolower($text2find).'%') . ' or ' . "cat{$f}$i like ". $db->qstr('%'.strtoupper($text2find).'%');		 
	     }	   
		 else {
	       $sSQL.= "(cat$i like ". $db->qstr('%'.strtolower($text2find).'%') . ' or ' . "cat$i like ". $db->qstr('%'.strtoupper($text2find).'%');
	   	 }  	   	   
         $sSQL .= ") and ctgid>0 and active>0 and view>0 and search>0";		 
         //echo $sSQL,'<br>';		 
	     $result = $db->Execute($sSQL,2);	
	   
	     //print_r($result);					   					   
	     if ($result) {      
         
	     while(!$result->EOF) {
		 
		   switch ($i) {
		     case 2 : $of = $result->fields['cat2']; $of2 = $result->fields["cat{$f}2"]; 
			          //$group = null; //..main cat..
					  $dp = 0;
					  break;
		     case 3 : $of = $result->fields['cat3']; $of2 = $result->fields["cat{$f}3"]; 
			          if (($this->depthview) && ($this->depthview>=1)) {
					    if ($result->fields['cat2']) $group = $result->fields['cat2']; 
						//echo $this->depthview,'-----',$result->fields['cat2'],':',$result->fields['cat3'],'<br>';	
					  }	
					  else
					    $group = $result->fields['cat2']; 	
					  $dp = 1;
					  break;
		     case 4 : $of = $result->fields['cat4']; $of2 = $result->fields["cat{$f}4"]; 
			          if (($this->depthview) && ($this->depthview>=1)) {
					    if ($result->fields['cat2']) $group = $result->fields['cat2'];
					    $group.= (($result->fields['cat3']) && ($this->depthview>=2)) ? $this->cseparator . $result->fields['cat3'] : null; 
					  }
					  else
					    $group = $result->fields['cat2'] . $this->cseparator . $result->fields['cat3'];
					  $dp = 2;	
			          break;
		     case 5 : $of = $result->fields['cat5']; $of2 = $result->fields["cat{$f}5"]; 
			          if (($this->depthview) && ($this->depthview>=1)) {
					    if ($result->fields['cat2']) $group = $result->fields['cat2'];// . $this->cseparator . $result->fields['cat3'] . $this->cseparator . $result->fields['cat4'];
					    $group.= (($result->fields['cat3']) && ($this->depthview>=2)) ? $this->cseparator . $result->fields['cat3'] : null; 
					    $group.= (($result->fields['cat4']) && ($this->depthview>=3)) ? $this->cseparator . $result->fields['cat4'] : null; 					  
						//echo $this->depthview,'--'.$group,'<br>';
					  }
					  else	
					    $group = $result->fields['cat2'] . $this->cseparator . $result->fields['cat3'] . $this->cseparator . $result->fields['cat4'];
					  $dp = 3;						
			          break;		   		   		   
		   }		 
		   //$f = $result->fields['cat2'];
		   //$_g = implode($this->cseparator,array_reverse($result->fields)); //echo $_g,"<br>";
		   
	       //if (($this->exclude) && (trim($f)) && (!in_array(trim($_g),$this->exclude)) ) 
		   if ($of) {
	         if ($this->usetablelocales) 
			   $res[$of] = $of2; //echo $of,'<br>';
			 else  
		       $res[$of] = $of; //echo $of,'<br>';
			 //echo $of,'>',$of2,'<br>';  
			 if ($group) $gr[$of] = $group;
			 if ($dp) $dpp[$of] = $dp;
			 //print_r($gr);
			 $hostcat  = $result->fields["cat{$f}2"]?$result->fields["cat{$f}2"].$this->bullet:null;
			 $hostcat .= $result->fields["cat{$f}3"]?$result->fields["cat{$f}3"].$this->bullet:null;
			 $hostcat .= $result->fields["cat{$f}4"]?$result->fields["cat{$f}4"].$this->bullet:null;
			 //$hostcat .= $result->fields['cat5']?$result->fields['cat5']:null;
			 
			 $hcat[] = $hostcat;		   
			 
		   }
		   		   
		   $result->MoveNext();
		   //$i+=1;
	     }//while
		 //echo $group;	
		 //print_r($gr);
		 //print_r($dpp);
	     if ($this->usetablelocales) 		 
           $data = $this->view_category($res,$viewtype,$mode,null/*$group*/,$cmd,null,$gr,$dpp,$template);
		 else
		   $data = $this->view_category($res,$viewtype,$mode,$group,$cmd,null,$gr,$dpp,$template);
		 //print_r($res);
		 //$ret .= $data?$data.'<hr>':null; 
		 //echo '>',$data;	   		 
		 if ($data) {
		   //print_r($hcat);
		   //$ret .= $data .'(' . $hostcat . ')' . '<hr>';
		   $mret[] = /*'<hr>' .*/ $data;// . '<hr>';
		   $meter+=1;
		 }
		 
		 unset($res); unset($result); unset($exists);
	       //return ($this->distinct($res));
	     }//result
		 	   
	   }//for !!!!!!
	   
	   //$ret .= $meter . ' ' . localize('_cfounded',getlocal()).'<br>';
	   if (is_array($mret)) {
	     foreach ($mret as $i=>$d)
	       $ret .= $d;		 
	   }	   
	   //echo $ret;
	   //return ($ret);
	   
	   //table generation
	   if ($ret) {
	     if ($this->result_in_table) { 
			$categories = explode('<SPLIT/>',$ret); //<li> split..
			$out = $this->make_table($categories, $this->result_in_table, 'fptreetable');  	  
		 }
		 else
		    $out = $ret;
	   }
       return ($out);	   
	}
	
	function grx_menu() {
	
	   if ($this->menu) {
	   
	    $menu_break = paramload('KATEGORIES','break');
	    $menu_fpro = paramload('KATEGORIES','fpro');
	    $menu_itype = paramload('KATEGORIES','itype');			
		
		//to be continued  	   
	   }
	}

	//called by getCombo, getKategoryCombo without select
	function js_make_search_url($id=null) {
	    $id_element= $id ? $id : 'input';
		$out = "	
function gocatsearch(url)
{
  //alert('url:'+url);
  var ret = url+'&input='+document.getElementById('$id_element').value;
  window.location.href = ret;
}
";

      return ($out);	
	}	
	
	function getCombo ($cid,$name,$cat=null,$style="",$size=10,$multiple="",$values=null,$selection='',$cmd=null,$tmpl=null,$noselect=null) {
	    $t = GetReq('t');
		$mycmd = $cmd?$cmd:'klist';
		$goto = seturl("t=$mycmd&cat=");
		$selected_cat = $cat?$cat:GetReq('cat');
		$cats = explode($this->cseparator,$selected_cat);
	    //print_r($values);
		
		$template = $this->select_template($tmpl);
		//echo $tmpl,'>',$template;
		
		$r = "";
		$select = "<select name=\"".$name."\" class=\"".$style."\"".( $size != 0 ? "size=\"".$size."\"" : "");		
		$select .= ($cmd) ? " onChange=\"location=this.options[this.selectedIndex].value+'&input='+get_sinput()+'&searchtype='+get_stype()+'&searchcase='+get_scase()\"" : 
	                        " onChange=\"location=this.options[this.selectedIndex].value\""; 
		$select .= ">";
		if ($template) 
			$tokens[] = ($noselect) ? null : $select;		
		else
            $r = ($noselect) ? null : $select;		
			  
		if (!empty($values)) {
          //no head title when noselect		
		  if ($template) {
		    $option_tokens[] = null; 
			$option_tokens[] = $name;
			$option_tokens[] = 0;
			$options[] = ($noselect) ? null : $this->combine_tokens($template, $option_tokens);
            unset($option_tokens);		
		  }	
          else		  
			$r .= ($noselect) ? null : "<option value=''>---$name---</option>";
		  
		  while (list ($value, $title) = each ($values)) {
		  
		    if ($selected_cat) {
			  switch ($cid) {
			    case 1 : $myvalue = $goto . $value; break;
			    case 2 : $myvalue = $goto . $cats[0] . $this->cseparator . $value; break;
			    case 3 : $myvalue = $goto . $cats[0] . $this->cseparator . $cats[1] . $this->cseparator . $value; break;
			    case 4 : $myvalue = $goto . $cats[0] . $this->cseparator . $cats[1] . $this->cseparator . $cats[2] . $this->cseparator .$value; break;
			    case 5 : $myvalue = $goto . $cats[0] . $this->cseparator . $cats[1] . $this->cseparator . $cats[2] . $this->cseparator . $cats[3] .$this->cseparator. $value; break;
				default: $myvalue = $goto . $selected_cat . $this->cseparator . $value;
			  }
			}  
			else
			  $myvalue = $goto . $value;
			  
		    $loctitle = localize($title,getlocal());
			
			if ($template) {
				$option_tokens[] = ($noselect) ? "javascript:gocatsearch('$myvalue')" : $myvalue; 
				$option_tokens[] = $loctitle;
				$option_tokens[] = ($value == $selection ? 1 : 0);
				$options[] = $this->combine_tokens($template, $option_tokens);
				unset($option_tokens);		
			}	
			else				
				$r .= "<option value=\"$myvalue\"".($value == $selection ? " selected" : "").">$loctitle</option>";
		  }	
	    }

        if ($template) {
            $tokens[] = (!empty($options)) ? implode('',$options) : null;
			$tokens[] = ($noselect) ? null : "</select>";
			$ret = implode('',$tokens);
			//echo $ret;
			return ($ret);
		}
		else {
			$r .= ($noselect) ? null : "</select>";
			return $r;
		}	
	}
	
	function asksql($cat,$presel=null) {
       $db = GetGlobal('db');	
	   $selcat = GetReq('cat');
	   $lan = getlocal();
	   $mylan = $lan?$lan:'0';	   
	   	
	   /*if ($selcat)
	     $goto = seturl('t=klist&cat='.$selcat);
	   else	*/
  	     //$goto = seturl('t=klist&cat=');
	     if ($this->usetablelocales) {		     
  	       $f = $mylan; 		
		   $mylancat = substr($cat,0,3). $f . substr($cat,-1); //echo $mylancat;
           $sSQL = "select $cat,$mylancat from categories where ctgid>0 and active>0 and view>0 and search>0";
		 }  
	     else {
		   $f = null;
           $sSQL = "select $cat from categories where ctgid>0 and active>0 and view>0 and search>0";	   
		 }  
		 
		 if ($presel) 
		   $sSQL .= ' and ' . $presel;
	     //echo $sSQL;
	     $result = $db->Execute($sSQL,2);	   	
	     //echo $result;
	     if ($result) {      

	       while(!$result->EOF) {
		   
	         if ($this->usetablelocales) {	
		       $f = $result->fields[0];
		       $ff = $result->fields[1];			   
		       if ($f) { 
			     if ($ff)
		           $data[$f] = $ff;
				 else
				   $data[$f] = $f;
			   }	 
			 }
			 else {
		       $f = $result->fields[0];
		       if ($f) 
		         $data[/*$goto.*/$f] = $f; //echo $f,'<br>';
			 }  
			   
		     //echo $f,'<br>';
		     $result->MoveNext();
		     $i+=1;
	       }   	
	       $mydata =  $this->distinct($data);
	     }	 
	     //print_r($mydata);
	     return ($mydata);
	}		
	
	function show_combo_results($title=null,$preselcat=null,$isleaf=null,$issearch=null) {
       $db = GetGlobal('db');	
	   $s1 = GetReq('s1');
	   $s2 = GetReq('s2');
	   $s3 = GetReq('s3');
	   $s4 = GetReq('s4');    
	   if ($issearch) {
	     $search_cmd = $issearch;
	   }
	   $cmd = $issearch?$search_cmd:'klist';
	   
	   $loctitle = localize($title,getlocal());
	   $mytitle = $loctitle?$loctitle:$this->title;
	   if ($isleaf)
	     $mytitle2 = $loctitle?$loctitle:$this->title2;
	   else
	     $mytitle2 = $this->title2;	 
	   
	   $cat = $preselcat?$preselcat:GetReq('cat');
	   $goto = $preselcat?seturl("t=$cmd&cat=".$preselcat):seturl("t=$cmd&cat=");	   
	   
	   $mydata = $this->asksql('cat2');
	   
	     $ret = "<form name=\"jumpy\">";
	   
	   if ($cat) {
	     $mycat = explode($this->cseparator,$cat);
		 //print_r($mycat);
	     
         if (!$isleaf) //dont show main combo when leaf (last cat)
		   $ret .= $this->getCombo(1,$mytitle,$cat,'myf_select',null,null,$mydata,$mycat[0],$search_cmd).'<br>';   	   
		 
	     if ($dv = $this->depthview) 	{
		   //echo $dv,'a';
		   if (($mycat[0])&&($dv>=2)) {
		   $mydata2 = $this->asksql('cat3',"cat2='$mycat[0]'");
		     if (!empty($mydata2))
		       $ret .= $this->getCombo(2,$mytitle2,$cat,'myf_select',null,null,$mydata2,$mycat[1],$search_cmd).'<br>';   	   
		     if (($mycat[1])&&($dv>=3)) {
		       $mydata3 = $this->asksql('cat4',"cat3='$mycat[1]' and cat2='$mycat[0]'");
			   if (!empty($mydata3))
		         $ret .= $this->getCombo(3,$mytitle2,$cat,'myf_select',null,null,$mydata3,$mycat[2],$search_cmd).'<br>'; 
		       if (($mycat[2])&&($dv>=4)) {
		         $mydata4 = $this->asksql('cat5',"cat4='$mycat[2]' and cat3='$mycat[1]' and cat2=$mycat[0]");
			     if (!empty($mydata4))
		           $ret .= $this->getCombo(4,$mytitle2,$cat,'myf_select',null,null,$mydata4,$mycat[3],$search_cmd); 		 		 
		       }
		     }
		   }		    		 
		 }
		 else {
		   if ($mycat[0]) {
		     $mydata2 = $this->asksql('cat3',"cat2='$mycat[0]'");
		     if (!empty($mydata2))
		       $ret .= $this->getCombo(2,$mytitle2,$cat,'myf_select',null,null,$mydata2,$mycat[1],$search_cmd).'<br>';   	   
		     if ($mycat[1]) {
		       $mydata3 = $this->asksql('cat4',"cat3='$mycat[1]' and cat2='$mycat[0]'");
			   if (!empty($mydata3))
		         $ret .= $this->getCombo(3,$mytitle2,$cat,'myf_select',null,null,$mydata3,$mycat[2],$search_cmd).'<br>'; 
		       if ($mycat[2]) {
		         $mydata4 = $this->asksql('cat5',"cat4='$mycat[2]' and cat3='$mycat[1]' and cat2=$mycat[0]");
			     if (!empty($mydata4))
		           $ret .= $this->getCombo(4,$mytitle2,$cat,'myf_select',null,null,$mydata4,$mycat[3],$search_cmd); 		 		 
		       }
		     }
		   }
		 }//depthview
	   }
	   else {	   
	     $ret .= $this->getCombo(1,$mytitle,$cat,'myf_select',null,null,$mydata,'',$search_cmd).'<br>';   
	     /*$ret .= $this->getCombo(2,'b','',null,null,null,'').'<br>'; 
	     $ret .= $this->getCombo(3,'c','',null,null,null,'').'<br>'; 
	     $ret .= $this->getCombo(4,'d','',null,null,null,'');*/
	   }
	   
	   $ret .= "</form>";
	   
	   return ($ret);
	}
  	
	public function getKategoryCombo($root,$name,$preselcat=null,$style="",$size=10,$multiple="",$values=null,$selection='',$cmd=null,$tmpl=null,$noselect=null) {
	   $search_cmd = $cmd ? $cmd : 'klist';
	   //echo $search_cmd;
       $mytitle = $name ? $name : $this->title;	   
	   $cat = $preselcat ? $preselcat : GetReq('cat');
	   
	   if ($root) {/*always return default main categories*/
	      $mydata = $this->asksql("cat2");
	      $ret = $this->getCombo(1,$mytitle,$cat,'myf_select',null,null,$mydata,$mycat[0],$search_cmd,$tmpl,$noselect);   	   	
		  return ($ret);
	   }	   
	   
	   if ($cat) {
		$mycat = explode($this->cseparator,$cat);
	   
		foreach ($mycat as $m=>$mcat) {
		  if ($m<=count(mycat))
			$mcatpresel[] = "cat".($m+2)."='". $mycat[$m]."'"; 
		}  
		$ps = (!empty($mcatpresel)) ? implode(' and ',$mcatpresel) : null;	  
		//echo $ps;
	   }	
	   
	   //echo ">cat".($m+2);
	   $mydata = $this->asksql("cat".(count($mycat)+2), $ps);
	   //echo '>',$m+2,'>',count($mycat)+2;
       $ret = $this->getCombo(count($mycat)+1,$mytitle,$cat,'myf_select',null,null,$mydata,$mycat[0],$search_cmd,$tmpl,$noselect);   	   	
	   
	   if ($ret==null) {/*default main categories*/
	      $mydata = $this->asksql("cat2");
	      $ret = $this->getCombo(1,$mytitle,$cat,'myf_select',null,null,$mydata,$mycat[0],$search_cmd,$tmpl,$noselect);   	   	
	   }	  
	   return ($ret);
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
	
	//n tokens method
	function combine_n_tokens($template_contents,$tokens,$tokens2=null) {
	    //print_r($tokens);
	    if (!is_array($tokens)) return;
		
		if (defined('FRONTHTMLPAGE_DPC')) {
		  $fp = new fronthtmlpage(null);
		  $ret = $fp->process_commands($template_contents);
		  unset ($fp);
          //$ret = GetGlobal('controller')->calldpc_method("fronthtmlpage.process_commands use ".$template_contents);		  		
		}		  		
		else
		  $ret = $template_contents;
		  
		//echo $ret,'>>>>>>>';
		//print_r($tokens2);
	    foreach ($tokens as $i=>$tok) {
            //echo $tok,'<br>';
			$n = str_replace('$N$',$tok,$ret);
			//echo $n;
			if (is_array($tokens2[$i])) {//mix combination
			   $nret .= $this->combine_tokens($n, $tokens2[$i]);
			}
			else
		      $nret .= $n;
	    }
		return ($nret);
	} 
	
	function select_template($tfile=null,$cat=null,$hasfileextension=null) {
	  $mytemplate = null;
	  
	  if (!$tfile) return;
	  
	  if ($hasfileextension)
	    $ext = null;
	  else
	    $ext = '.htm';
	  
	  if ($cat) {
	   $pcats = explode($this->cseparator,$cat);
	   
	   //template per category..search subcats..
	   foreach ($pcats as $c) {
         $ctemplate = $c.'@'.$tfile.$ext;
	     //$ct = $this->urlpath .'/' . $this->inpath . '/cp/html/'. str_replace('.',getlocal().'.',$ctemplate) ;
		 $ct = $this->path . $this->tmpl_path .'/'. $this->tmpl_name .'/'. str_replace('.',getlocal().'.',$ctemplate) ;
		 if (is_readable($ct)) {
		   $mytemplate = file_get_contents($ct);
		   return ($mytemplate);
		 }  
	   }
	   
	  } 
	  //default template
	  $template = $tfile . $ext;	
	  //echo $template,'<br>';   
	  //$t = $this->urlpath .'/' . $this->inpath . '/cp/html/'. str_replace('.',getlocal().'.',$template) ; 
	  $t = $this->path . $this->tmpl_path .'/'. $this->tmpl_name .'/'. str_replace('.',getlocal().'.',$template) ; 
	  //echo $t,'<br/>'; 	   
	  if ((!$mytemplate) && (is_readable($t))) 
		$mytemplate = file_get_contents($t);
	   	 
	  return ($mytemplate);	 
    }

	protected function make_table($items=null, $mylinemax=null, $template=null) {
	    $toprint = null;
		$mytemplate = $template ? $this->select_template($template) : 
		                          null;//$this->select_template('fpkatalogtable');
		//print_r($items);
	    if ($items[0]) {//if isset items[0]
		//if (!empty($items)) {
	        //make table
	        $itemscount = count($items);
	        $timestoloop = floor($itemscount/$mylinemax)+1;
	        $meter = 0;
			$linetoken = null;
			$tokens = array();
			
	        for ($i=0;$i<$timestoloop;$i++) {
	          //echo $i,$template,"---<br>";

	          if ($mytemplate) {
			    
				for ($j=0;$j<$mylinemax;$j++) {
					//echo $i*$j,"<br>";
					$linetoken .= $items[$meter];//(isset($items[$meter])? $items[$meter] : "&nbsp");	
					$meter+=1;	 
				}
				$tokens[] = $linetoken; //one element
                $toprint .= $this->combine_tokens($mytemplate, $tokens);					
				$linetoken = null; //reset
				$tokens = array(); //reset
			  }
			  else {
			  
				for ($j=0;$j<$mylinemax;$j++) {
					//echo $i*$j,"<br>";
					$viewdata[] = (isset($items[$meter])? $items[$meter] : "&nbsp");
					$viewattr[] = "center;10%";	
					$meter+=1;	 
				}				  
			  
				$myrec = new window('',$viewdata,$viewattr);
				if ($mytemplate) 
					$toprint .= $myrec->render("center::100%::0::::left::0::0::");		  
				else				  
					$toprint .= $myrec->render();//"center::100%::0::group_article_selected::left::4::4::");
					
				unset ($viewdata);
				unset ($viewattr);					
			  }		  
	        }
		}
			
        return ($toprint); 		
    }	
	
};
}
?>