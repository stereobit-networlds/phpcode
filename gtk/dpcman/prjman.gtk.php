<?php

class prj_manager {

   var $code_closed_xpm, $code_open_xpm;
   var $ctree_data, $ctree;	   
   var $prj_dir;
   var $project_title;
		
   function prj_manager($parent=null) {
	  global $transparent;
	  global $window;
	  global $shell;   
     
	  $this->project_title = "";
     
      $this->code_closed_xpm = array("16 16 6 1",
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

        $this->code_open_xpm = array("16 16 4 1",
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
			
          $window->realize();							   
		  $transparent = $window->style->white;
		  					   
		  list($this->ctree_data['pixmap1'], $this->ctree_data['mask1']) = Gdk::pixmap_create_from_xpm_d($window->window, $transparent, $this->code_closed_xpm);
		  list($this->ctree_data['pixmap2'], $this->ctree_data['mask2']) = Gdk::pixmap_create_from_xpm_d($window->window, $transparent, $this->code_open_xpm); 					   	 
		  
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

		  $this->ctree = &new GtkCTree(2, 0, array('Filesystem', 'Details'));
		  $scrolled_win->add($this->ctree);
		  //$ctree->show();
		  
	      //drug & drop feature			 
 	      //$this->ctree->connect('drag_data_received', array($this,'dnd_remove_received'));
	      //$this->ctree->drag_dest_set(GTK_DEST_DEFAULT_ALL, $this->targets, GDK_ACTION_COPY);			 
		  

		  $this->ctree->set_column_auto_resize(0, true);
		  $this->ctree->set_column_width(1, 200);
		  $this->ctree->set_selection_mode(GTK_SELECTION_EXTENDED);
		  $this->ctree->set_line_style(GTK_CTREE_LINES_SOLID);
		  $line_style = GTK_CTREE_LINES_SOLLID;		  		  
		
		  
	      $this->ctree->connect('click_column', array($this,'ctree_click_column'),$this->ctree);		  
		  $this->ctree->set_usize(0, 300);		  
		 
		  //$this->rebuild_tree(null);	//not now!!!		
	  
	}	 
	
	function rebuild() {
	
	      $this->rebuild_tree(null,$this->ctree);
	}
	
	function _close() {
	
	      $this->project_title = null;
	      $this->rebuild_tree(null,$this->ctree);	
	}
	
	function rebuild_tree($button)	{
	        global $shell;

			$this->ctree->freeze();
			$this->ctree->clear();

			$text = array('Project', $shell->get_project_title());//$this->project_title);

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

					
			$this->build_project_tree($parent);
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
	
	function read_nodes($node,$parent=null) {	
	
	  if (is_array($node)) {
	     foreach ($node as $codearg=>$codeval) { 
		 
		    $text[0] = $codearg;
		    $text[1] = $codeval;						  		  			
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
		 
		    if (is_array($codeval)) {				
			  
			  $this->read_nodes($codeval,$subparent);  
			}
			/*else {  		  								
			
		      $sibling = $this->ctree->insert_node($subparent, null, $text, 5,
 				  					               $this->ctree_data['pixmap1'],
											       $this->ctree_data['mask1'], 
											       null, null,
											       true, false);
			}*/									   
		 } 
	  }	 
	}
	
	function build_project_tree($parent) {	
	      global $shell;

	      //get text from dpc editor
	      if ($shell->framework->Project_Editor) {			
		  
	        $this->project_title = $shell->get_project_title();
			
	        if ($this->project_title) {
			
              $this->prj_dir = $shell->app_path . paramload('INSTALL','PRJDIR') . $this->project_title; 
		      //echo $this->prj_dir,">>>>>>>>>>>>>>";
			  
			  $prjarray = $this->make_project_tree($this->prj_dir);
			  print_r($prjarray);
			  
			  if (is_array($prjarray)) {
                reset($prjarray);
			    $this->read_nodes($prjarray,$parent);
			  }
			}  
		  }
		
	}			  
   
   
   function read_filesystem($path) {

	  if (is_dir($path)) {
          $mydir = dir($path);
		 
          while ($fileread = $mydir->read ()) {
		  
		    if (($fileread!='.') && ($fileread!='..'))  {		  
			
			   $subpath = $path."/".$fileread;
			   
	           if (is_dir($subpath)) {//read directories
			   
			     $array2save[$fileread] = $this->read_filesystem($subpath);
               }	
			   else {//read files 
			     $array2save[$fileread] = $subpath;
			   }  	  
		    }
		  }  
      }  
	  
	  return ($array2save); 
   }
   
   //make file tree
   function make_project_tree($path) {

      echo $path,"\n";    
	  $prjtree = null;

      $prjtree = $this->read_filesystem($path);
	   
	  //print_r($prjtree);
	  return ($prjtree);
   }   
   

}
?>