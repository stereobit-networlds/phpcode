<?php

$__GTK['bin_manager']['bin_manager'] = 'BIN Manager'; 
$__GTKXY['bin_manager']['x'] = 300;
$__GTKXY['bin_manager']['y'] = 400;

class bin_manager {
    
    var $arg1; 	
    var $bin_dir;
	
	var $book_closed_xpm,
	    $book_open_xpm,
		$mini_page_xpm;
	var	$ctree_data;
	var $ctree;
	
	var $show_buttons;
	
	function bin_manager($parent=null,$binpath="",$showbuttons=1) {
	  global $argv,$argc;	
	  global $transparent;
	  global $window;
	  
	  $this->arg1 = $argv[1];	  
	  
      if ($binpath) $this->bin_dir = $binpath; 
	           else $this->bin_dir = "\webos\bin";
			   
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
					   				   
					   
		$this->mini_bin_xpm = array("16 16 4 1",
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
							   
		  $transparent = $window->style->white; //&new GdkColor(0, 0, 0);

		  list($this->ctree_data['pixmap1'], $this->ctree_data['mask1']) = Gdk::pixmap_create_from_xpm_d($window->window, $transparent, $this->book_closed_xpm);
		  list($this->ctree_data['pixmap2'], $this->ctree_data['mask2']) = Gdk::pixmap_create_from_xpm_d($window->window, $transparent, $this->book_open_xpm);  
		  list($this->ctree_data['pixmap3'], $this->ctree_data['mask3']) = Gdk::pixmap_create_from_xpm_d($window->window, $transparent, $this->mini_bin_xpm);
		  list($this->ctree_data['pixmap4'], $this->ctree_data['mask4']) = Gdk::pixmap_create_from_xpm_d($window->window, $transparent, $this->mini_lib_xpm);		  
							   
		  if ($parent!=null) $this->tree_control($parent);
	}

	function read_bins() {

	    if (is_dir($this->bin_dir)) {
          $mydir = dir($this->bin_dir);
		 
          while ($fileread = $mydir->read ()) {
	   
           //read directories
		   if (($fileread!='.') && ($fileread!='..'))  {

	          if (is_dir($this->bin_dir."/".$fileread)) {

                 $mysubdir = dir($this->bin_dir."/".$fileread);
                 while ($subfileread = $mysubdir->read ()) {	
				 
		           if (($subfileread!='.') && ($subfileread!='..'))  {
  	                 if (((stristr ($subfileread,".exe.php")) || 
					      (stristr ($subfileread,".lib.php"))) /*&&
				         (!stristr ($subfileread,".bak"))*/) {
				         $mybin[$fileread][] = $subfileread;
			         }				     
				   }
				 }
			  }
			  else {		   
			     switch ($this->arg1) {	   
				   case '-bin' :
  	                             if (((stristr ($fileread,".sh")) || //unix shell 
					                  (stristr ($fileread,".bat")) || //windows batch
					                  (stristr ($fileread,".exe.php")) || 
					                  (stristr ($fileread,".lib.php"))) &&
				                     (!stristr ($fileread,".bak"))) {
				                   $mybin['\\'][] = $fileread;
			                     }
				   default :				 
				 }
			  }
			  //echo $fileread,"\n";	
		   }
	      }
	      $mydir->close ();
        }
		return ($mybin);
	}		   
	
	//external
	function rebuild() {
	
	  $this->rebuild_tree(null,$this->ctree);
	}
	
	function rebuild_tree($button)	{

			$this->ctree->freeze();
			$this->ctree->clear();

			$text = array('Bin', 'Bin modules info');

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

					
			$this->build_bin_tree($parent);
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

	
	function build_bin_tree($parent) {	
		    
			$binarray = $this->read_bins();
			//print_r($gtkarray);
			
            reset($binarray);
            while (list ($bin_group_name, $bin_group) = each ($binarray)) {

			  $text[0] = $bin_group_name;
			  $text[1] = $bin_group_name . " module";				  		  			
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
										   
															   
			  if (is_array($bin_group))	{						   
                while (list ($bin_name, $bin) = each ($bin_group)) {
				  if (stristr($bin,".exe.php")) {
				    $text[0] = str_replace(".php","",$bin);
				    $text[1] = $bin_group_name;// . " main class";				  					
				    $sibling = $this->ctree->insert_node($subparent, null, $text, 5,
											   $this->ctree_data['pixmap3'],
											   $this->ctree_data['mask3'], 
											   null, null,
											   true, false);			  
				  }
				  elseif (stristr($bin,".lib.php")) {
				    $text[0] = str_replace(".php","",$bin);
				    $text[1] = $bin_group_name;// . " library";										  
				    $sibling = $this->ctree->insert_node($subparent, null, $text, 5,
											   $this->ctree_data['pixmap4'],
											   $this->ctree_data['mask4'], 
											   null, null,
											   true, false);					  
				  }	//.sh and .bat has not .php extension !!!!						   
				  /*elseif ((stristr($bin,".sh")) || (stristr($bin,".bat"))) {
				    $text[0] = $bin;//str_replace(".bat","",$bin);
				    $text[1] = $bin_group_name;// . " library";										  
				    $sibling = $this->ctree->insert_node($subparent, null, $text, 5,
											   $this->ctree_data['pixmap4'],
											   $this->ctree_data['mask4'], 
											   null, null,
											   true, false);					  
				  }	*/			  
			      if ($parent && $ctree->line_style == GTK_CTREE_LINES_TABBED)
					$this->ctree->node_set_row_style($sibling, $parent->row->style);											   
				}	
			  }
			}
	}
	
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
			    $fullname = "bin/" . $fpath . "/" . $fname[0] . ".php";				
				
			    $shell->event_queue('add_module',$fullname); 
			  }	
			  else {			
			    //echo "no leaf\n";
				
			    $binarray = $this->read_bins();
			    //print_r($dpcarray);				
				
		        $parent = $this->ctree->node_get_pixtext($node,0);
				$binroot = $parent[0];	
				//print $dpcroot;
				$bins = $binarray[$binroot];
				//print_r($dpcs);	
				
				foreach ($bins as $num=>$binmodule) {				
			      $fullname = "bin/" . $binroot . "/" . $binmodule;				
				
			      $shell->event_queue('add_module',$fullname); 				
				}  
			  }	
			  
			  $i++;
			} 
	}
	
	function edit($button) {
			global $shell;	
				
			$i=0;
			while (($node = $this->ctree->selection[$i]) !== null) {	
			  
			  if ($node->is_leaf) {
			    //echo "leaf\n";
				//print_r($node);
				
			    $fpath = $this->ctree->node_get_text($node,1); 		
			    $fname = $this->ctree->node_get_pixtext($node,0);
			  
			    $fullname = $this->bin_dir . "\\" . $fpath . "\\" . $fname[0] . ".php";
 			    //echo $fullname."\n";
				
			    $shell->event_queue('editdpc',$fullname);								 
			  }	
			  else {			
			    //echo "no leaf\n";
			  }	
			  
			  $i++;
			} 
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

		  $this->ctree = &new GtkCTree(2, 0, array('BIN Modules', 'BIN Info'));
		  $scrolled_win->add($this->ctree);
		  //$ctree->show();

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

		      case '-bin' : $button3 = &new GtkButton('Edit');
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
	
	function menu($container) {
	   global $shell;
	
	   $header2 = &new GtkMenuItem("Bin");	
	
	   $editmenu = &new GtkMenu();    	   
	   
	   switch ($this->arg1) {
	     case '-bin' :	      
		              $edit = &new GtkMenuItem("Edit");
	                  $edit->connect_object("activate", array($this, "edit"),null);		   
	                  $editmenu->append($edit);	
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
}

	 
    function gtk_bin_manager() {
        global $windows;
		global $shell;
		
        if (!isset($windows['bin_manager'])) {	
		  		
		  $window = &new GtkWindow;
		  $windows['bin_manager'] = $window;
		  $window->connect('delete-event', 'delete_event');
		  $window->set_title('bin Manager');
	      $window->set_usize(300, 400);		  
		  $window->set_border_width(0);
		  
		  $shell->win_binmanager = &new bin_manager($window);		  
		  
	      $window->show_all();
		  //$window->realize();		  							  
		}
        elseif ($windows['bin_manager']->flags() & GTK_VISIBLE)
            $windows['bin_manager']->hide();
        else
            $windows['bin_manager']->show();			
	}		
		
?>
