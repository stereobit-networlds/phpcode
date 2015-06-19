<?php

require_once("dpccode.lib.php");

class dpc_file extends dpc_code {

    var $verfile;
	var $versionlist;
	
	var $name;
	var $path;

    function dpc_file() {
	
	   dpc_code::dpc_code();
	 
	   $this->verfile = null;
    }
	
	/////////////////////////////////////////////////////////////////////////
	//VERSIONING
	////////////////////////////////////////////////////////////////////////
	function get_current_version($verfile) {
	 
	   if (file_exists($verfile)) {
	   
          if ($fp = fopen ($verfile , "r")) {
                   $data = fread ($fp, 1024);
                   fclose ($fp);
	      }	   	   
          
		  if ($data) {	   
             //echo $data;
			 $part = explode(";",$data);
			 $verpart = explode(".",$part[0]);
		  }			   
		  return ($verpart);
	    }
	    else {	
		  return (array(0=>'0',1=>'1',2=>'0',3=>'0')); //initialize ver
		}		   
	}	
	
	function compute_next_version($verarray) {
	
	    $r = $verarray[0];
	    $l = $verarray[1];
	    $b = $verarray[2];
	    $s = $verarray[3];						
		
		if ($s<100) $s+=1;
		else {
		  $s=0; 
		  $b+=1;
		}  
		
        if ($b==100) {
		  $s=0;
		  $b=0;
		  $l+=1;
		}  
		
		if ($l==100) {
		  $s=0;
		  $b=0;
		  $l=0;
		  $r+=1;
		}  
		
		return (array(0=>$r,1=>$l,2=>$b,3=>$s)); 
	}
	
	function set_next_version($verfile,$data) {
		
		if (file_exists($verfile)) 
          $fp = fopen ($verfile , "r+"); //a+ = append at the end of file???	
		else
          $fp = fopen ($verfile , "wb");	  
	    
        if ($fp) {
		           //$old_data = fread($fp, filesize($verfile));
		  
		           fseek ($fp, 0, SEEK_SET); 
				   //rewind($fp);
                   fwrite ($fp, $data . $old_data);
                   fclose ($fp);
				   				   
				   return (true);
	    }
	    else {
				   return (false);
		}		
	}			   

   
   ///////////////////////////////////////////////////////////////////////////
   //SELECT VERSION CONTROL
   ///////////////////////////////////////////////////////////////////////////
   function select_version_control($container,$name,$path) {
   
		$this->name = $name;
		$this->path = $path;   
   
		$scrolled_win = &new GtkScrolledWindow();
		$scrolled_win->set_border_width(5);
		$scrolled_win->set_policy(GTK_POLICY_AUTOMATIC, GTK_POLICY_AUTOMATIC);

		$titles = array("Version", "Date", "CRC");
		$this->clist = &new GtkCList(3, $titles);
		$this->clist->set_column_width(0, 80);
		$this->clist->set_column_width(1, 180);		
		$this->clist->set_column_width(2, 20);		
		$this->clist->connect('click_column', array($this,'clist_click_column'));
		//$this->clist->connect('click_column', array($this,'clist_get_selection'));		
		$scrolled_win->add($this->clist);
		$this->clist->show();  
		
		$container->pack_start($scrolled_win); 
		
		$this->read_versions($name,$path);
		
		$this->build_versions_list($this->clist);
		
   }
	
   function init_version_control() {   
   
      $this->clist = null;
	  $this->versionlist = null;
	  $this->verfile = null;
   }	
   
   function clist_click_column($clist, $column) {
	
			if ($column == $clist->sort_column) {
				if ($clist->sort_type == GTK_SORT_ASCENDING)
					$clist->set_sort_type(GTK_SORT_DESCENDING);
				else
					$clist->set_sort_type(GTK_SORT_ASCENDING);
			} else
				$clist->set_sort_column($column);

			$clist->sort();
   }  
   
   function clist_get_selection($clist=null)	{
            global $shell;
		
		    $dpc_dir = $shell->dpc_path ;   
   
			$this->clist->freeze();
			$selection = $this->clist->selection;
			
			//print_r($selection);
			$delta = $this->clist->get_text($selection[0],0);
			if ($delta=='Current') $delta=null; //current version has no delta numbers
			
			if ($delta) {
			  if (stristr($this->name,'.dpc'))
			    $f = str_replace(".dpc","-$delta.dpc",$this->name);
			  elseif (stristr($this->name,'.lib'))
			    $f = str_replace(".lib","-$delta.lib",$this->name);
			}
			else
			  $f = $this->name;
			  
			$this->verfile = $dpc_dir . $this->path ."/". $f . ".php";  
			  
			//echo ">>>>",$this->verfile;
				
			$this->clist->thaw();
			
			return ($this->verfile);
   }    
   
   
   function read_versions($name,$path) {
        global $shell;
		
		$dpc_dir = $shell->dpc_path ;
		$n_part = explode(".",$name); 
        //echo $name,'-',$dpc_dir,$path;	
		
	    if (is_dir($dpc_dir.$path)) {
          $mydir = dir($dpc_dir.$path);
		 
          while ($fileread = $mydir->read ()) {
		  
		    if (((stristr ($fileread,$n_part[0])) && //=name before dot 
			     (stristr ($fileread,$n_part[1])))) {//extension (lib or dpc)) 
				 
			   //get file attr
			   $ok=0;
			   if ($fp = fopen($dpc_dir.$path."/".$fileread,"r")) {
			     $attr = fstat($fp);	 
			     fclose($fp);
				 $ok=1;
			   }
			   //print_r(array_slice($attr,13));

			   //echo $fileread."\n";
			   $f_part = explode("-",$fileread);
			   
			   if (stristr($f_part[1],'.dpc'))
			     $v_part = explode(".dpc",$f_part[1]);
			   elseif (stristr($f_part[1],'.lib'))
			     $v_part = explode(".lib",$f_part[1]);
				 
			   $ver = $v_part[0];// . $v_part[1] . $v_part[2] . 
 			         //(strlen($v_part[3])<=2 ? $v_part[3] : "0"); //is number or dpc/lib extension
					 
			   //echo $ver."\n";	
			   
			   $isok = ($ok ? 'Ok' : 'Error'); 
			   $date = date('d-m-Y h:i:s A',$attr['mtime']);
			   $this->versionlist[$ver] = array(0=>$ver,1=>$date,2=>$isok);
			}   
		  }  
		}   
   }
   
   function build_versions_list($clist) {
   
	  //$text = array('This', 'is an');
	
	  ksort($this->versionlist);
	  
	  $clist->freeze();	  
			
	  foreach ($this->versionlist as $id=>$v) {		
	  
         if (trim($id)!=null) {
			if ($clist->focus_row >= 0)
				$row = $clist->insert($clist->focus_row, $v);
			else
				$row = $clist->prepend($v);   
		 }		
	  }			
	  $d = date('d-m-Y h:i:s A');
	  $row = $clist->prepend(array(0=>'Current',1=>$d,2=>'Ok')); 
	  
	  $clist->thaw();	    
   }
   
   
   
   //COMMENTS GENERATION
   
   function add_dpc_comments($file,$cver='%VER%',$nver=null) {
      global $shell;
	  
	  $tcode = $this->make_code_tree($file);
	  
	  $remids = $this->make_remark_array($tcode);	 

      $this->rem_popup_ok(null,null,$remids,$cver);	    
   }
   
   
   function rem_popup($cid,$remids,$version=null) {
   
	  $window = &new GtkWindow;
	  $window->connect('delete-event', 'delete_event');
	  $window->set_title('Add remark ...');
      $window->set_position(GTK_WIN_POS_CENTER);	   
	  $window->set_usize(340, 160);		  
	  $window->set_border_width(1);
	   
      $vbox = &new GtkVBox();
	  $window->add($vbox);	

      //INFO
	  $hbox0 = &new GtkHBox(false, 5);
	  $hbox0->set_border_width(1);
	  $vbox->pack_start($hbox0, false);					 
				 
	  $inf = &new GtkLabel($cid);
      $inf->set_justify(GTK_JUSTIFY_LEFT);		  		  
	  $hbox0->pack_start($inf,false,false,0);
	  				    		   
	  //comments
	  $hbox1 = &new GtkHBox(false, 5);
	  $hbox1->set_border_width(1);
	  $vbox->pack_start($hbox1, false);					 
				 
	  $ccc = &new GtkLabel("Comments");
      $ccc->set_justify(GTK_JUSTIFY_LEFT);		  		  
	  $hbox1->pack_start($ccc,false,false,0);
		  
	  $comments = &new GtkEntry();
	  $comments->set_text($c_ver[0]);
	  $comments->set_max_length(255);		  	  
	  $hbox1->pack_start($comments,false,false,0);					 				 			 
			 
	  $hbox2 = &new GtkHBox(false, 5);
	  $hbox2->set_border_width(5);
	  $vbox->pack_start($hbox2, false);		   	   
	  
      $button = &new GtkButton('Ok');
	  $button->connect('clicked', array($this,'rem_popup_ok'),$comments,$remids,$version);	   
	  $button->connect('clicked', 'destroy_event',$window);	   
	  $hbox2->pack_start($button,false);
	  
      $button = &new GtkButton('Cancel');
	  $button->connect('clicked', 'destroy_event',$window);	   
	  $hbox2->pack_start($button,false);	  	   
				  
	  $window->set_modal(true);		  
	  $window->show_all();	    
   }
   
   function rem_popup_ok($widget,$remark,$remids,$ver) {
      global $shell;
   
      static $idcounter=0;
	  static $remarks = array();
	  static $sln=0; 	  
   
      $max = count($remids)+1;
    
      if ($remark!=null) {//first time called widget=null & remark = null
		  $comment = $remark->get_text();
		  $remarks[] = $comment.";".$remids[$idcounter-1];
	  }
      $idr = $remids[$idcounter];		
	  $attr = explode(";",$idr);	
	  		
	  //echo $comment,">>",$idr,"\n";
	  $idcounter+=1;
			
      if ($idcounter<$max) {
		//call popup
		$this->rem_popup($attr[2],$remids,$ver);
      }
	  else { //exit	  
  		$idcounter = 0;
		$nexit = MessageBox( "Function completed ! Apply comments?", "Apply ...", MB_YESNO + MB_ICONQUESTION + MB_DEFBUTTON2 + MB_CENTER); 	  
        if( $nexit == IDYES) {
		  print_r($remarks);
		  
		  //import comments to file
		  if ($shell->framework->Dpc_Editor) {
		    //for each comment
		    foreach ($remarks as $id=>$nodes) {
			  $n = explode(";",$nodes);
			  $rem = $n[0];
			  $line = $n[1];
			  $type = $n[2];
			  
			  switch ($type) {
			    case "_CLASS_"    : $xdata = $this->remark_class($rem); //create rem
				                    break;
			    case "_FUNCTION_" : $xdata = $this->remark_function($rem); //create rem
				                    break;			
			  }	
			  //$xdata = $this->remark_function($rem); 					
			  //find the $text enters 
			  $smax = strlen($xdata);
			  for ($i=0;$i<$smax;$i++) {
			    if ($xdata[$i]=="\n") $sln+=1;
			  }			  
			  echo $line,">>",$sln,"\n";
			  
		       if ($id>0) $shell->framework->Dpc_Editor->writeln($xdata,$line+$sln); //import rem in line..
			         else $shell->framework->Dpc_Editor->writeln($xdata,$line); //without adding rem lines
			}		
			//save file
			//$shell->event_queue("save");
	      }		
		}
		else {
		  $nexit = MessageBox( "Action canceled !", "Message", MB_OK + MB_ICONINFORMATION + MB_DEFBUTTON2 + MB_CENTER); 	  	  
		}
		//reset static counters
		$sln=0;
        $idcounter=0;		
		$remarks = null;			
	  }		
   }
   
   
   //return code lines of re4marks to apply
   function make_remark_array($codetree) {
   
	  foreach ($codetree as $tclass=>$cdata) {
	    
		if ($tclass=='_HEADER_') {
		}
		elseif ($tclass=='_FOOTER_') {
		}
		else { //class
		  $class_name = $tclass;
		  
		  if (is_array($cdata)) {
		  
		    foreach ($cdata as $tnode=>$cdata) {
			
			  if ($tnode=='_LINE_') {
			    //class comment
	  		    $line2write[] = ($cdata) . ';_CLASS_;'.$class_name.';'; 
				//echo $cdata-1,"\n";
			  }
			  elseif ($tnode=='_GLOBALS_') {
			  }
			  else {//method
			    $method_name = $tnode;
		        //echo $tnode;
				//function comment
				$line2write[] = ($cdata['_LINE_']) . ';_FUNCTION_;'.$class_name.'.'.$method_name.';'; 
				//echo $cdata['_LINE_'] - 1,"\n";
			  }	
		    }
		  } 
		}
	  } 
	  
	  return ($line2write);  
   }
   

   
}
?>