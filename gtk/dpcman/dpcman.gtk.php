<?php

$__GTK['dpc_manager']['dpc_manager'] = 'DPC Manager'; 
$__GTKXY['dpc_manager']['x'] = 300;
$__GTKXY['dpc_manager']['y'] = 400;

require_once("dpcman.lib.php");

class dpc_manager {

    var $arg1;    
    var $dpc_dir;
	
	var $book_closed_xpm,
	    $book_open_xpm,
		$mini_page_xpm;
	var	$ctree_data;
	var $ctree;
	
	var $show_buttons;
	
	var $targets;
	var $dpc_file;
	
	function dpc_manager($parent=null,$dpcpath="",$showbuttons=1) {
	  global $argv,$argc;
	  global $transparent;
	  global $window;
	  global $shell;
	  global $ver,$dptype,$dontaskver,$dontaskveredit;
	  
	  $this->arg1 = $argv[1];
	  
	  $ver = 0;
	  $dptype = 1;
      $dontaskver=0;	  	  
      $dontaskveredit=0;		  
	  
      $this->targets = array(array('text/plain', 0, -1));	  
	  
	  $this->dpc_file = new dpc_file;
	  
      if ($dpcpath) $this->dpc_dir = $dpcpath; 
	           else $this->dpc_dir = $shell->app_path . paramload('INSTALL','DPCDIR');//"\webos\dpc";
			   
	  $this->show_buttons = $showbuttons;		   		  	  

      $this->book_closed_xpm = array("16 16 6 1",
						 "       c None s None",
						 ".      c black",
						 "X      c red",
						 "o      c yellow",
						 "O      c #808080",
						 "#      c white",
						 "                ",
						 "       ..       ",
						 "     ..XX.      ",
						 "   ..XXXXX.     ",
						 " ..XXXXXXXX.    ",
						 ".ooXXXXXXXXX.   ",
						 "..ooXXXXXXXXX.  ",
						 ".X.ooXXXXXXXXX. ",
						 ".XX.ooXXXXXX..  ",
						 " .XX.ooXXX..#O  ",
						 "  .XX.oo..##OO. ",
						 "   .XX..##OO..  ",
						 "    .X.#OO..    ",
						 "     ..O..      ",
						 "      ..        ",
						 "                ");

        $this->book_open_xpm = array("16 16 4 1",
					   "       c None s None",
					   ".      c black",
					   "X      c #808080",
					   "o      c white",
					   "                ",
					   "  ..            ",
					   " .Xo.    ...    ",
					   " .Xoo. ..oo.    ",
					   " .Xooo.Xooo...  ",
					   " .Xooo.oooo.X.  ",
					   " .Xooo.Xooo.X.  ",
					   " .Xooo.oooo.X.  ",
					   " .Xooo.Xooo.X.  ",
					   " .Xooo.oooo.X.  ",
					   "  .Xoo.Xoo..X.  ",
					   "   .Xo.o..ooX.  ",
					   "    .X..XXXXX.  ",
					   "    ..X.......  ",
					   "     ..         ",
					   "                ");
					   				   
					   
		$this->mini_dpc_xpm = array("16 16 4 1",
							   "       c None s None",
							   ".      c black",
							   "X      c white",
							   "o      c #808080",
							   "                ",
							   "   .......      ",
							   "   .XXXXX..     ",
							   "   .XoooX.X.    ",
							   "   .XXXXX....   ",
							   "   .XooooXoo.o  ",
							   "   .XXXXXXXX.o  ",
							   "   .XooooooX.o  ",
							   "   .XXXXXXXX.o  ",
							   "   .XooooooX.o  ",
							   "   .XXXXXXXX.o  ",
							   "   .XooooooX.o  ",
							   "   .XXXXXXXX.o  ",
							   "   ..........o  ",
							   "    oooooooooo  ",
							   "                ");	
							   
		$this->mini_lib_xpm = array("16 16 4 1",
							   "       c None s None",
							   ".      c black",
							   "X      c white",
							   "o      c #808080",
							   "                ",
							   "   ...          ",
							   "   .X.     .    ",
							   "   .Xo     X.   ",
							   "   .Xo     Xo.  ",
							   "   .Xo  .. Xo.  ",
							   "   .Xo  X. Xo.  ",
							   "   .Xo  Xo Xo.  ",
							   "   .Xo  .. Xo.  ",
							   "   .Xo  Xo X.X  ",
							   "   .Xo  Xo X.X  ",
							   "   .Xo  Xo X.X  ",
							   "   .XXXoXo.XXo  ",
							   "   ...........  ",
							   "    oooooooooo  ",
							   "                ");							   

          $window->realize();							   
		  $transparent = $window->style->white; //&new GdkColor(0, 0, 0);

		  list($this->ctree_data['pixmap1'], $this->ctree_data['mask1']) = Gdk::pixmap_create_from_xpm_d($window->window, $transparent, $this->book_closed_xpm);
		  list($this->ctree_data['pixmap2'], $this->ctree_data['mask2']) = Gdk::pixmap_create_from_xpm_d($window->window, $transparent, $this->book_open_xpm);  
		  list($this->ctree_data['pixmap3'], $this->ctree_data['mask3']) = Gdk::pixmap_create_from_xpm_d($window->window, $transparent, $this->mini_dpc_xpm);
		  list($this->ctree_data['pixmap4'], $this->ctree_data['mask4']) = Gdk::pixmap_create_from_xpm_d($window->window, $transparent, $this->mini_lib_xpm);		  
							   
		  if ($parent!=null) $this->tree_control($parent);                    		  
	}
	
	function tree_control(&$container) {	
		  		  	
          $vbox = &new GtkVBox();
		  $container->add($vbox);
		  //$vbox->show();		  	
		  
		  $scrolled_win = &new GtkScrolledWindow();
		  $scrolled_win->set_border_width(0);
		  $scrolled_win->set_policy(GTK_POLICY_AUTOMATIC, GTK_POLICY_ALWAYS);
		  $vbox->pack_start($scrolled_win);
		  //$scrolled_win->show();

		  $this->ctree = &new GtkCTree(2, 0, array('DPC Modules', 'DPC Info'));
		  $scrolled_win->add($this->ctree);
		  //$ctree->show();
		  
	      //drug & drop feature			 
 	      $this->ctree->connect('drag_data_received', array($this,'dnd_remove_received'));
	      $this->ctree->drag_dest_set(GTK_DEST_DEFAULT_ALL, $this->targets, GDK_ACTION_COPY);			 
		  

		  $this->ctree->set_column_auto_resize(0, true);
		  $this->ctree->set_column_width(1, 200);
		  $this->ctree->set_selection_mode(GTK_SELECTION_EXTENDED);
		  $this->ctree->set_line_style(GTK_CTREE_LINES_SOLID);
		  $line_style = GTK_CTREE_LINES_SOLLID;		  		  
		
		  if ($this->show_buttons) {
		  
		    $hbox = &new GtkHBox(false, 5);
		    $hbox->set_border_width(5);
		    $vbox->pack_start($hbox, false);	  
		  
		    $button1 = &new GtkButton('Rebuild');
		    $hbox->pack_start($button1);  
		    $button1->connect('clicked', array($this,'rebuild_tree'));
		  
		    switch ($this->arg1) {	  
			
		      case '-dpc' : $button3 = &new GtkButton('Edit');
		                    $hbox->pack_start($button3);
		                    $button3->connect('clicked', array($this,'edit'));			  			  
							break;
			
			  default :     $button2 = &new GtkButton('Add');
		                    $hbox->pack_start($button2);
		                    $button2->connect('clicked', array($this,'select'));					
							
			}
          }
		  
	      $this->ctree->connect('click_column', array($this,'ctree_click_column'),$this->ctree);		  
		  $this->ctree->set_usize(0, 300);		  
		 
		  $this->rebuild_tree(null);			
	  
	}	
	
	//NOT USED !!! IT READS ALL THE TREE
    function read_dpc_filesystem($path) {

	  if (is_dir($path)) {
          $mydir = dir($path);
		 
          while ($fileread = $mydir->read ()) {
		  
		    if (($fileread!='.') && ($fileread!='..'))  {		  
			
			   $subpath = $path."/".$fileread;
			   
	           if (is_dir($subpath)) {//read directories
			   
			     $array2save[$fileread] = $this->read_dpc_filesystem($subpath);
               }	
			   else {//read files 
			         switch ($this->arg1) {	   

				       case '-dpc' :if (((stristr ($fileread,".dpc.php")) || 
					                     (stristr ($fileread,".lib.php"))) &&
				                         (!stristr ($fileread,"-")) && //= versioned file
										 (!stristr ($fileread,"~"))) { //=opened file
										 
				                       $array2save[$fileread] = $subpath;
			                        }	
									break;
					   default     :			   
  	                                if ((stristr ($subfileread,".dpc.php")) &&
				                        (!stristr ($subfileread,"~"))) { //=opened file
				                       $mydpc[$fileread][] = $subpath;
			                        }	
					 }			   
			         //$array2save[$fileread] = $subpath;
			   }  	  
		    }
		  }  
      }  
	  
	  return ($array2save); 
    }	

	//USED !!!!!!! IT READS 2 TREE LEVELS 
	function read_dpcs() {

	    if (is_dir($this->dpc_dir)) {
		
          $mydir = dir($this->dpc_dir);
		 
          while ($fileread = $mydir->read ()) {
	   
           //read directories
		   if (($fileread!='.') && ($fileread!='..'))  {

	          if (is_dir($this->dpc_dir."/".$fileread)) {

                 $mysubdir = dir($this->dpc_dir."/".$fileread);
                 while ($subfileread = $mysubdir->read ()) {	
				 
		           if (($subfileread!='.') && ($subfileread!='..'))  {
				   
			         switch ($this->arg1) {	   

				       case '-dpc' :if (((stristr ($subfileread,".dpc.php")) || 
					                     (stristr ($subfileread,".lib.php"))) &&
				                         (!stristr ($subfileread,"-")) && //= versioned file
										 (!stristr ($subfileread,"~"))) { //=opened file
				                       $mydpc[$fileread][] = $subfileread;
			                        }	
									break;
					   default     :			   
  	                                if ((stristr ($subfileread,".dpc.php")) &&
				                        (!stristr ($subfileread,"~"))) { //=opened file
				                       $mydpc[$fileread][] = $subfileread;
			                        }	
					 }							     
				   }
				 }
			  }
			  else {	
			     switch ($this->arg1) {	   
				   case '-dpc' :
  	                             if (((stristr ($fileread,".dpc.php")) || 
					                  (stristr ($fileread,".lib.php"))) &&
                                      (!stristr ($fileread,"-")) && //= versioned file
									  (!stristr ($fileread,"~"))) {							  
				                   $mydpc['\\'][] = $fileread;
			                     }
				   default :				 
				 }
			  }	
		   }
	      }
	      $mydir->close ();
        }
		
		return ($mydpc);
	}		   
	
	//external
	function rebuild() {
	
	  $this->rebuild_tree(null,$this->ctree);
	}
	
	function rebuild_tree($button)	{

			$this->ctree->freeze();
			$this->ctree->clear();

			$text = array('Dpc', 'Dpc modules info');

			$parent = $this->ctree->insert_node(null, null, $text, 5,
										  $this->ctree_data['pixmap1'],
										  $this->ctree_data['mask1'],
										  $this->ctree_data['pixmap2'],
										  $this->ctree_data['mask2'], 			
										  false, true);
										  										  

			$style = &new GtkStyle();
			$style->base[GTK_STATE_NORMAL] = new GdkColor(0, 45000, 55000);
			$this->ctree->node_set_row_data($parent, $style);

			if ($this->ctree->line_style == GTK_CTREE_LINES_TABBED)
				$this->ctree->node_set_row_style($parent, $style);

					
			$this->build_dpc_tree($parent);
			$this->ctree->thaw();
	}	

    function ctree_click_column($ctree,$column)	{
			
			if ($column == $ctree->sort_column) {
				if ($ctree->sort_type == GTK_SORT_ASCENDING)
					$ctree->set_sort_type(GTK_SORT_DESCENDING);
				else
					$ctree->set_sort_type(GTK_SORT_ASCENDING);
			} else
				$ctree->set_sort_column($column);

			$this->ctree->sort_recursive();
	}
	
	
	function build_dpc_tree($parent) {	
		    
		  $dpcarray = $this->read_dpcs();
		  //print_r($dpcarray);
		  
		  if ($dpcarray) {
		  
            reset($dpcarray);
			//print_r($dpcarray);
            while (list ($dpc_group_name, $dpc_group) = each ($dpcarray)) {

			  $text[0] = $dpc_group_name;
			  $text[1] = $dpc_group_name . " module";				  		  			
			  $subparent = $this->ctree->insert_node($parent, $subparent, $text, 5,
										   $this->ctree_data['pixmap1'],
										   $this->ctree_data['mask1'],
										   $this->ctree_data['pixmap2'],
										   $this->ctree_data['mask2'],
										   false, false);
										   
			  $style = &new GtkStyle();
			  $style->base[GTK_STATE_NORMAL] = new GdkColor(0, 45000, 55000);
			  $this->ctree->node_set_row_data($subparent, $style);

			  if ($this->ctree->line_style == GTK_CTREE_LINES_TABBED)
				  $this->ctree->node_set_row_style($subparent, $style);
										   
															   
			  if (is_array($dpc_group))	{						   
                while (list ($dpc_name, $dpc) = each ($dpc_group)) {
				  if (stristr($dpc,".dpc.php")) {
				    $text[0] = str_replace(".php","",$dpc);
				    $text[1] = $dpc_group_name;// . " main class";				  					
				    $sibling = $this->ctree->insert_node($subparent, null, $text, 5,
											   $this->ctree_data['pixmap3'],
											   $this->ctree_data['mask3'], 
											   null, null,
											   true, false);	
											   
                    //drug and drop
		            $this->ctree->connect('drag_data_get', array($this,'dnd_move_get'));
		            $this->ctree->drag_source_set(GDK_BUTTON1_MASK|GDK_BUTTON3_MASK, $this->targets, GDK_ACTION_COPY);
														   		  
				  }
				  elseif (stristr($dpc,".lib.php")) {
				    $text[0] = str_replace(".php","",$dpc);
				    $text[1] = $dpc_group_name;// . " library";										  
				    $sibling = $this->ctree->insert_node($subparent, null, $text, 5,
											   $this->ctree_data['pixmap4'],
											   $this->ctree_data['mask4'], 
											   null, null,
											   true, false);					  
				  }							   
			      if ($parent && $ctree->line_style == GTK_CTREE_LINES_TABBED)
					$this->ctree->node_set_row_style($sibling, $parent->row->style);											   
				}	
			  }
			}
		  }	
	}
	

	
	//create a dpc module	
	function create() {
	   global $ver,$dptype;
	   
	   $ver = 0;
	   $dptype = 1;	   
	
	   $window = &new GtkWindow;
	   $window->connect('delete-event', 'delete_event');
	   $window->set_title('Create distributed php ...');
       $window->set_position(GTK_WIN_POS_CENTER);	   
	   $window->set_usize(340, 160);		  
	   $window->set_border_width(1);
	   
       $vbox = &new GtkVBox();
	   $window->add($vbox);	
	   
	   $hbox = &new GtkHBox(false, 5);
	   $hbox->set_border_width(5);
	   $vbox->pack_start($hbox, false);	   		   
	   
	   $name = &new GtkLabel("Dpc Name");
       $name->set_justify(GTK_JUSTIFY_LEFT);		  		  
	   $hbox->pack_start($name,false,false,0);
		  
	   $prname = &new GtkEntry();
	   $prname->set_text("");
	   $prname->set_max_length(64);		  
	   //$prname->connect_object('changed', array($this,'properties_changed'));		  
	   $hbox->pack_start($prname,false,false,0);
	    
	   
	   
	   $isdpc = &new GtkRadioButton(null, 'Distributed php module');
	   $isdpc->connect('clicked', array($this,'toggle_dptype'),$isdpc,1);	   
	   $isdpc->set_active(true);
	   $vbox->pack_start($isdpc);
	   $isdpc->show();
	   
	   $islib = &new GtkRadioButton($isdpc, 'Distributed php library');
	   $islib->connect('clicked', array($this,'toggle_dptype'),$islib,2);		   
	   //$this->update->set_active(true);
	   $vbox->pack_start($islib);
	   $islib->show();	
	   
	   $separator = &new GtkHSeparator();
	   $vbox->pack_start($separator, false);
	   $separator->show();	
	   
	   $versioning = &new GtkCheckButton('Allow code versioning ?');
	   $versioning->set_active(false);	   
	   $versioning->connect('clicked', array($this,'toggle_ver'),$versioning);		   
	   $vbox->pack_start($versioning);
	   $versioning->show();	   
	   
	   $separator = &new GtkHSeparator();
	   $vbox->pack_start($separator, false);
	   $separator->show();	   
	   
	   
	   $hbox2 = &new GtkHBox(false, 5);
	   $hbox2->set_border_width(5);
	   $vbox->pack_start($hbox2, false);		   	   
	   
       $button = &new GtkButton('Ok');
	   $button->connect('clicked', array($this,'create_ok'),$prname);	   
	   $button->connect('clicked', 'destroy_event',$window);	   
	   $hbox2->pack_start($button,false);
	  
       $button = &new GtkButton('Cancel');
	   $button->connect('clicked', 'destroy_event',$window);	   
	   $hbox2->pack_start($button,false);	  	   
				  
	   $window->set_modal(true);		  
	   $window->show_all();	   
	}	
	
	function toggle_ver($widget) {
	   global $ver;
	   
	   if ($widget->get_active()==true) $ver=1;
	                               else $ver=0;
				 
	   //echo $ver;			 
	}
	
	function toggle_dptype($widget,$dummy,$id) {
	   global $dptype;
	   
	   if ($widget->get_active()==true) $dptype=$id;
				 
	   //echo '>',$dptype;			 
	}	
	
	function create_ok($button, $field_name) {
	   global $shell,$ver,$dptype;
			
	   $dpc_name = $field_name->get_text();		
	   $pron = explode(".",$dpc_name);
	   
	   if (($pron[0]) && ($pron[1])) {	   
		 
		 $dpcp = $shell->dpc_path . $pron[0];
		 
		 if (!is_dir($dpcp)) {
		   mkdir($dpcp);
		   $shell->set_console_message("Create dpc directory (".$dpcp.")");	   
		 } 
		 
		 
	     if ($dptype==1) {
		   $dpcf = $pron[1] .".dpc";
		   $data = $this->dpc_file->create_dpc_module_text($pron[1]);
		 }  
		 elseif ($dptype==2) {
		   $dpcf = $pron[1] .".lib";
		   $data = $this->dpc_file->create_dpc_library_text($pron[1]);
		 }  
		 
		 $dpcfile = $dpcp."/".$dpcf .".php";
		 $dpcverfile = $dpcp."/".$dpcf .".ver";		 
		 
		 if (is_file($dpcfile)) {
		 
           $nAnswer = MessageBox( "Dpc already exist !", "Error", MB_OK + MB_ICONSTOP + MB_DEFBUTTON1 + MB_CENTER);	   		 
		 }
		 else {
		   $out = '<?php require ("/dpc/start.dpc.php"); start(); ?>';
		              //release.level.branch,seaquence=delta numbering
		   $verdata = "0.1.0.0;" . date('d-m-Y h:i:s A') . ";details" . "\n"; 
	    
           if ($fp = fopen ($dpcfile , "w")) {
                   fwrite ($fp, $data);
                   fclose ($fp);
				   
		           $shell->set_console_message("Dpc file created.");				   
 		           $shell->set_status_message("Dpc file created.");
				   
                   $shell->event_queue('editdpc',$dpcfile);				   				   
	       }
	       else {
		           $shell->set_console_message("Dpc file NOT created !!!");		
		           $shell->set_status_message("Dpc file NOT created !!!");						   
		   }
		   
		   //ver file
		   if ($ver) {
             if ($fp = fopen ($dpcverfile , "w")) {
                   fwrite ($fp, $verdata);
                   fclose ($fp);	
				   
		           $shell->set_console_message("Dpc versioning file created !!!");						   	   
			 }	
	         else {
		           $shell->set_console_message("Dpc versioning file NOT created !!!");								   
		     }			    
		   }			  
			
	       $this->rebuild();	
		   //update shell
		   $shell->project_name = $dpcfile;
		   $shell->set_window_title($shell->project_name);		   	  
		 }  
	   }
	   else {
           $nAnswer = MessageBox( "Unknown dpc name !", "Error", MB_OK + MB_ICONSTOP + MB_DEFBUTTON1 + MB_CENTER);	   
	   }		
	}
	
	//edit a dpc module
	function edit() {
	   global $shell,$dontaskveredit;	
				
	   $i=0;
	   while (($node = $this->ctree->selection[$i]) !== null) {	
			  
		 if ($node->is_leaf) {
			//echo "leaf\n";
			//print_r($node);
				
			$fpath = $this->ctree->node_get_text($node,1); 		
			$fname = $this->ctree->node_get_pixtext($node,0);
			  
			$fullname = $this->dpc_dir . $fpath . "/" . $fname[0] . ".php";
 			//echo $fullname."\n";
			$dpcverfile = str_replace(".php",".ver",$fullname); //echo $dpcverfile;
			
			//check versionig
			if (is_file($dpcverfile)) { 
			
			   $c_ver = $this->dpc_file->get_current_version($dpcverfile);   
			
		       if ($dontaskveredit==0) {	
	             $window = &new GtkWindow;
	             $window->connect('delete-event', 'delete_event');
	             $window->set_title('Load version ...');
                 $window->set_position(GTK_WIN_POS_CENTER);	   
	             $window->set_usize(340, 300);		  
	             $window->set_border_width(1);
	   
                 $vbox = &new GtkVBox();
	             $window->add($vbox);	
				 
	             //init version list control
                 $this->dpc_file->init_version_control(); 				 
				 //init selection version
				 $this->dpc_file->verfile = $fullname; //default version = current
				 //select version
				 $this->dpc_file->select_version_control($vbox,$fname[0],$fpath);
				    		   				 				 				 
				 
				 //question
	             $dontask = &new GtkCheckButton("Don't ask me again! (Current version)");
	             $dontask->set_active(false);	   
	             $dontask->connect('clicked', array($this,'toggle_ask_edit'),$dontask);		   
	             $vbox->pack_start($dontask,false,false,0);
	             $dontask->show();				 
				 
	             $hbox2 = &new GtkHBox(false, 5);
	             $hbox2->set_border_width(5);
	             $vbox->pack_start($hbox2, false);		   	   
	   
                 $button = &new GtkButton('Ok');
	             $button->connect('clicked', array($this,'edit_ok'),$this->dpc_file->verfile); 
	             $button->connect('clicked', 'destroy_event',$window);	   
	             $hbox2->pack_start($button,false);
	  
                 $button = &new GtkButton('Cancel');
	             $button->connect('clicked', 'destroy_event',$window);	   
	             $hbox2->pack_start($button,false);	  	   
				  
	             $window->set_modal(true);		  
	             $window->show_all();			   				
			   }
			   else {
		         $this->edit_ok('dummy',$fullname);				   
			   }
			} 
			else {  	
		       $this->edit_ok('dummy',$fullname);							 
		    }		
		  }	
		  else {			
			    //echo "no leaf\n";
		  }	
			  
		  $i++;
		} 	
	}			
	
	function toggle_ask_edit($widget) {
	   global $dontaskveredit;
	   
	   if ($widget->get_active()==true) $dontaskveredit=1;
	                               else $dontaskveredit=0;
				 
	   //echo $ver;			 
	}	
	
	function edit_ok($widget,$file) {
	   global $shell;
	   
	   $sfile = null;
	 
	   if (is_object($widget))//!='dummy')  //it means that versioning is enabled
	     $sfile = $this->dpc_file->clist_get_selection();
	   //echo $sfile;
	   if ($sfile) $file = $sfile;
	
	   //check if file is already open
	   $pf = explode("/",$file);
	   $max = count($pf)-1;
	   $pf[$max] = '~'.$pf[$max];
	   $opened = implode("/",$pf); //echo $opened;
	   
	   if (!is_file($opened)) {
	     //create  ~file
		 copy($file,$opened); 
	     //update shell
	     $shell->project_name = $file;
	     $shell->set_window_title($shell->project_name);					
		 //edit file 		
	     $shell->event_queue('editdpc',$file);	   
	   }
	   else {//error msg don't' open
         $nAnswer = MessageBox( "File is already open !", "Error", MB_OK + MB_ICONSTOP + MB_DEFBUTTON1 + MB_CENTER);	   	   
	   } 	 
	}	
	
	
	function save() {
	        global $shell,$dontaskver;
			
			$oldver = null;
			
			$dpcfile = $shell->get_project_title();
			
			//WARNING : previous versions saved as name-x.x.x.x has no ver file!!!!	
			$fpart = explode("-",$dpcfile);
			if ($fpart[1]) { //means the file is a previous version
			   
			   if (stristr($fpart[1],".dpc")) 
			     $vpart = explode(".dpc",$fpart[1]);
			   elseif (stristr($fpart[1],".lib")) 
			     $vpart = explode(".lib",$fpart[1]);
				 
			   $oldver = $vpart[0]; //echo $oldver;
			   
               $nAnswer = MessageBox( "WARNING : You try to alter an old version !", "Warning", MB_OK + MB_ICONSTOP + MB_DEFBUTTON1 + MB_CENTER);	 
			}			
			else //it is the last version
			  $dpcverfile = str_replace(".php",".ver",$dpcfile); //echo $dpcverfile;
			
			//check versionig
			//WARNING : previous versions saved as name-x.x.x.x has no ver file!!!!
			if ((is_file($dpcverfile)) || ($oldver)) { 
			
			   if ($oldver)
			     $c_ver = $this->dpc_file->compute_next_version(explode(".",$oldver));
			   else	 
			     $c_ver = $this->dpc_file->get_current_version($dpcverfile);   
			
		       if ($dontaskver==0) {	   
	             $window = &new GtkWindow;
	             $window->connect('delete-event', 'delete_event');
	             $window->set_title('Save version ...');
                 $window->set_position(GTK_WIN_POS_CENTER);	   
	             $window->set_usize(340, 160);		  
	             $window->set_border_width(1);
	   
                 $vbox = &new GtkVBox();
	             $window->add($vbox);	
				    		   
				 //release
	             $hbox0 = &new GtkHBox(false, 5);
	             $hbox0->set_border_width(1);
	             $vbox->pack_start($hbox0, false);					 
				 
	             $rel = &new GtkLabel("Release  ");
                 $rel->set_justify(GTK_JUSTIFY_LEFT);		  		  
	             $hbox0->pack_start($rel,false,false,0);
		  
	             $release = &new GtkEntry();
	             $release->set_text($c_ver[0]);
	             $release->set_max_length(2);		  	  
	             $hbox0->pack_start($release,false,false,0);					 				 
				 
				 //level
	             $hbox1 = &new GtkHBox(false, 5);
	             $hbox1->set_border_width(1);
	             $vbox->pack_start($hbox1, false);
				 				 
	             $lev = &new GtkLabel("Level       ");
                 $lev->set_justify(GTK_JUSTIFY_LEFT);		  		  
	             $hbox1->pack_start($lev,false,false,0);
		  
	             $level = &new GtkEntry();
	             $level->set_text($c_ver[1]);
	             $level->set_max_length(2);		  	  
	             $hbox1->pack_start($level,false,false,0);	
				 
				 //branch
	             $hbox2 = &new GtkHBox(false, 5);
	             $hbox2->set_border_width(1);
	             $vbox->pack_start($hbox2, false);	
				 				 
	             $bra = &new GtkLabel("Brunch    ");
                 $bra->set_justify(GTK_JUSTIFY_LEFT);		  		  
	             $hbox2->pack_start($bra,false,false,0);
		  
	             $branch = &new GtkEntry();
	             $branch->set_text($c_ver[2]);
	             $branch->set_max_length(2);		  	  
	             $hbox2->pack_start($branch,false,false,0);	
				 
				 //sequence
	             $hbox3 = &new GtkHBox(false, 5);
	             $hbox3->set_border_width(1);
	             $vbox->pack_start($hbox3, false);					 
				 
	             $seq = &new GtkLabel("Sequence");
                 $seq->set_justify(GTK_JUSTIFY_LEFT);		  		  
	             $hbox3->pack_start($seq,false,false,0);
		  
	             $sequence = &new GtkEntry();
	             $sequence->set_text($c_ver[3]);
	             $sequence->set_max_length(2);		  	  
	             $hbox3->pack_start($sequence,false,false,0);					 				 				 
				 
				 //question
	             $dontask = &new GtkCheckButton("Don't ask me again! (auto)");
	             $dontask->set_active(false);	   
	             $dontask->connect('clicked', array($this,'toggle_ask'),$dontask);		   
	             $vbox->pack_start($dontask);
	             $dontask->show();				 
				 
	             $hbox2 = &new GtkHBox(false, 5);
	             $hbox2->set_border_width(5);
	             $vbox->pack_start($hbox2, false);		   	   
	   
                 $button = &new GtkButton('Ok');
	             $button->connect('clicked', array($this,'save_ok'),$release,$level,$branch,$sequence,$oldver);	   
	             $button->connect('clicked', 'destroy_event',$window);	   
	             $hbox2->pack_start($button,false);
	  
                 $button = &new GtkButton('Cancel');
	             $button->connect('clicked', 'destroy_event',$window);	   
	             $hbox2->pack_start($button,false);	  	   
				  
	             $window->set_modal(true);		  
	             $window->show_all();	 				 			
			   }
			   else {
			   
			     $this->save_ok(); 
			   }
			}
			else {
			
			  $shell->event_queue('writedpc',$dpcfile);
			}
	}
	
	function toggle_ask($widget) {
	   global $dontaskver;
	   
	   if ($widget->get_active()==true) $dontaskver=1;
	                               else $dontaskver=0;
				 
	   //echo $ver;			 
	}	
	
	function save_ok($widget=null,$release=null,$level=null,$branch=null,$sequence=null,$oldver=null) {
	   global $shell;
		
	   if ($oldver) {
	     $dpcfile = str_replace("-".$oldver,"",$shell->get_project_title()); //=standart name
	   }		
	   else {
	     $dpcfile = $shell->get_project_title();
	   }	 
		 
	   $dpcverfile = str_replace(".php",".ver",$dpcfile); 	
	   
	   if ($release==null) {//check if data is passed
         //read last rec = version to save	   
	     $c_ver = $this->dpc_file->get_current_version($dpcverfile);//=last ver
	   }	 
	   else	 {
	   
	     $rel = $release->get_text();
	     $lev = $level->get_text();
	     $bra = $branch->get_text();
	     $seq = $sequence->get_text();
	   	   
	     //get the data fields version (manual or suggested)
	     $c_ver = array(0=>$rel,1=>$lev,2=>$bra,3=>$seq);   
	   }
	   
	   //make name changes
	   if (stristr($dpcfile,'.dpc')) { //is a dpc file
	   
	     $ver = "-" . $c_ver[0] . "." . $c_ver[1] . "." . $c_ver[2] .       
					 ($c_ver[3] ? "." . $c_ver[3] : "")  . '.dpc';
	   
	     //$ver = "-" . $c_ver[0] . "." . $c_ver[1] . "." . $c_ver[2] . "." . $c_ver[3] . '.dpc';
	     $newvername = str_replace(".dpc",$ver,$dpcfile);
	   }	 
	   elseif (stristr($dpcfile,'.lib')) { //is a lib file 
	   
	     $ver = "-" . $c_ver[0] . "." . $c_ver[1] . "." . $c_ver[2] .       
					 ($c_ver[3] ? "." . $c_ver[3] : "")  . '.lib';	   
	   
	     //$ver = "-" . $c_ver[0] . "." . $c_ver[1] . "." . $c_ver[2] . "." . $c_ver[3] . '.lib';	   
	     $newvername = str_replace(".lib",$ver,$dpcfile);		 
	   }
	   
	   //save current file as a version file
	   if (is_file($newvername)) //file exist
	     $nAnswer = MessageBox( "Error : Version exist! Version not saved!", "Error", MB_OK + MB_ICONSTOP + MB_DEFBUTTON1 + MB_CENTER);	 
	   else {//save
	     $shell->event_queue('writedpc',$newvername); //just save the verszion (remains in load the proto file which saved after)
		 if ($oldver) {//in case of an old ver saving load the saved file
		   $shell->event_queue('readdpc',$newvername);
		   
	       //update shell
	       $shell->project_name = $newvername;
	       $shell->set_window_title($shell->project_name);			   
		 }  
	   }	 
	   
	   //save the file with the standart name   
	   //WARNING : if old version don't save lastest version = standart name
	   if (!$oldver) {
	     $shell->event_queue('writedpc',$dpcfile);	
		 
	     //compute next version
	     $n_ver = $this->dpc_file->compute_next_version($c_ver);
	   
	     $dataline = $n_ver[0] . "." . $n_ver[1] . "." . $n_ver[2] . "." . $n_ver[3] . ";" . 
	                 date('d-m-Y h:i:s A') . ";details" . "\n";
	
	     //save next version to file			   
	     $this->dpc_file->set_next_version($dpcverfile,$dataline);	   
	   }
	   //echo $oldver;
	   
       $this->rebuild();		   
	}
	
	//close an opened dpc file (~ file deleted)
	function _close() {
	   global $shell;
	   
	   $dpcfile = $shell->get_project_title();	
	   
	   if (is_file($dpcfile)) {
	     //delete ~ file
	     $pf = explode("/",$dpcfile);
	     $max = count($pf)-1;
	     $pf[$max] = '~'.$pf[$max];
	     $opened = implode("/",$pf); //echo $opened;
	   
	     if (is_file($opened)) {	   
	      //$file = str_replace("~","",$opened);
		  //$bakfile = str_replace(".php",".bak",$file);
	      unlink($opened);  
	     }
	   }	
	   
	   //update shell
	   $shell->set_window_title("");		    
	}
	
	//auto-comments system
	function remark() {
	   global $shell;
	
	   $dpcfile = $shell->get_project_title();
	   
	   if ($dpcfile) { 
	      
         $nAnswer = MessageBox( "You selected to execute the auto generate comment function.\nPlease be carefull to your answers of procedure.", "Auto Comment", MB_YESNO + MB_ICONQUESTION + MB_DEFBUTTON2 + MB_CENTER);
	   
         if( $nAnswer == IDYES) {	    
		    if ((stristr($dpcfile,".dpc")) || (stristr($dpcfile,".lib"))) {
		      $this->remark_ok();
			}  
			else
			 $nexit = MessageBox( "No file selected", "Error", MB_OK + MB_ICONERROR + MB_DEFBUTTON2 + MB_CENTER);   
         } 			  
	   }	
	}
	
	function remark_ok() {
	   global $shell;	
	
	   $dpcfile = $shell->get_project_title();	
	  
	   $this->dpc_file->add_dpc_comments($dpcfile);
	}
	
	//ADD DPC
	function select($button) {
	        global $shell;					
									
			$i=0;
			while (($node = $this->ctree->selection[$i]) !== null) {	
			  
			  if ($node->is_leaf) {
			    //echo "leaf\n";
				//print_r($node);
			    $fpath = $this->ctree->node_get_text($node,1); 		
			    $fname = $this->ctree->node_get_pixtext($node,0); 
 			    //print $fpath . "\\" . $fname[0] . "\n";				
			    //$fullname = "dpc/" . $fpath . "/" . $fname[0] . ".php";	
				$dpc_module =  $fpath . "." . str_replace(".dpc","",$fname[0]); //echo $dpc_module;			
				
			    $shell->event_queue('add_module',$dpc_module);//fullname); 
			  }	
			  else {			
			    //echo "no leaf\n";
				
			    $dpcarray = $this->read_dpcs();
			    //print_r($dpcarray);				
				
		        $parent = $this->ctree->node_get_pixtext($node,0);
				$dpcroot = $parent[0];	
				//print $dpcroot;
				$dpcs = $dpcarray[$dpcroot];
				//print_r($dpcs);	
				
				foreach ($dpcs as $num=>$dpcm) {				
			      //$fullname = "dpc/" . $dpcroot . "/" . $dpcm;
				  $dpc_module =  $dpcroot . "." . str_replace(".dpc.php","",$dpcm); //echo $fullname;			
				
			      $shell->event_queue('add_module',$dpc_module);//fullname);				  							
				}  
			  }	
			  
			  $i++;
			} 
	}
		
	//drug and drop TO schema = add module
	function dnd_move_get($widget, $context, $selection_data, $info, $time) {
	
			$i=0;
			while (($node = $this->ctree->selection[$i]) !== null) {	
			  
			  if ($node->is_leaf) {
			    //echo "leaf\n";
				//print_r($node);
			    $fpath = $this->ctree->node_get_text($node,1); 		
			    $fname = $this->ctree->node_get_pixtext($node,0); 
 			    //print $fpath . "\\" . $fname[0] . "\n";				
			    //$fullname = "dpc/" . $fpath . "/" . $fname[0] . ".php";				
				$fullname =  $fpath . "." . str_replace(".dpc","",$fname[0]); //echo $fullname;			
				
			  }	
			  else {			
			    //echo "no leaf\n";
				
			    $dpcarray = $this->read_dpcs();
			    //print_r($dpcarray);				
				
		        $parent = $this->ctree->node_get_pixtext($node,0);
				$dpcroot = $parent[0];	
				//print $dpcroot;
				$dpcs = $dpcarray[$dpcroot];
				//print_r($dpcs);	
				
				foreach ($dpcs as $num=>$dpcmodule) {				
			      //$fullname .= "dpc/" . $dpcroot . "/" . $dpcmodule . ","; //multiple select separated by comma				
				  $fullname .= $dpcroot . "." . str_replace(".dpc.php","",$dpcmodule) . ","; 			 				
				}  
			  }	
			  
			  $i++;
			} 
	
			$dnd_string = $fullname;
			$selection_data->set($selection_data->target, 9, $dnd_string);
	}	
	
	//drug FROM module schema = remove module
	function dnd_remove_received($widget, $context, $x, $y, $data, $info, $time) {
	    global $shell;
	
		if ($data && $data->format == 8) {
	
			    $module = $data->data; 	
				//$this->show($module);	//errors
				$shell->event_queue('remove_module',$module);
	    }		
	}			
			
	
	function menu($container,$menu_on=0,$container2=null,$toolbar_on=0) {
	   global $shell;
	
	   if ($menu_on) {
	     $header2 = &new GtkMenuItem("Dpc");	
		 
	     $editmenu = &new GtkMenu();    	   
	   
	     switch ($this->arg1) {
		   case '-dpc' :	   
		                $crt = &new GtkMenuItem("Create");
	                    $crt->connect_object("activate", array($this, "create"),null);		   							
	                    $editmenu->append($crt);	
								   
		                $edit = &new GtkMenuItem("Edit");
	                    $edit->connect_object("activate", array($this, "edit"),null);		   
	                    $editmenu->append($edit);	
						
		                $save = &new GtkMenuItem("Save");
	                    $save->connect_object("activate", array($this, "save"),null);		   
	                    $editmenu->append($save);	
						
		                $comm = &new GtkMenuItem("Auto Comment");
	                    $comm->connect_object("activate", array($this, "remark"),null);		   
	                    $editmenu->append($comm);							
												
					    break;
		   default     :   
	                    $add = &new GtkMenuItem("Add");
	                    $add->connect_object("activate", array($this, "select"),null);		   
	                    $editmenu->append($add);
	     }	 	   
	   
	     $sep = &new GtkMenuItem();	   
	     $editmenu->append($sep);	         
	   
	     $rebuild = &new GtkMenuItem("Rebuild");
	     $rebuild->connect_object("activate", array($this, "rebuild"),null);	   
	     $editmenu->append($rebuild);		   
	   	    	
	     $header2->set_submenu($editmenu);
	   
	     $container->append($header2);		
	   }
	   
	   if ($toolbar_on) {
	     
	   }	 
	 }
	 
 
}

	 
 /*   function gtk_dpc_manager() {
        global $windows;
		global $shell;
		
        if (!isset($windows['dpc_manager'])) {	
		  		
		  $window = &new GtkWindow;
		  $windows['dpc_manager'] = $window;
		  $window->connect('delete-event', 'delete_event');
		  $window->set_title('DPC Manager');
	      $window->set_usize(300, 400);		  
		  $window->set_border_width(0);
		  
		  $shell->win_dpcmanager = &new dpc_manager($window);		  
		  
	      $window->show_all();
		  //$window->realize();		  							  
		}
        elseif ($windows['dpc_manager']->flags() & GTK_VISIBLE)
            $windows['dpc_manager']->hide();
        else
            $windows['dpc_manager']->show();			
	}	*/	
		
?>
