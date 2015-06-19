<?php

//$__GTK['framework']['framework'] = 'Framework';
 

class framework {

	var $book_closed_xpm,
	    $book_open_xpm;	
	var $book_closed,
	    $book_open;
	var $book_closed_mask,
	    $book_open_mask;	
		
	var $notebook;	
	var $notepage;			
	
	function framework($parent,$containers='',$labels='') {	
	
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
					   
		  $this->notepage = array();					   

	      $this->frame_control($parent,$containers,$labels);	  	  
	}	
	
	function frame_control(&$container,$class_containers,$class_labels) {	
		  		  	
          $vbox = &new GtkVBox();
		  $container->add($vbox);		  	
		  
		  $this->notebook = new GtkNotebook;
		  $this->notebook->show();
		  $this->notebook->connect('switch_page', array($this,'page_switch'));
		  $this->notebook->set_tab_pos(GTK_POS_BOTTOM);
		  $vbox->pack_start($this->notebook, true, true, 0);
		  $this->notebook->set_border_width(1);
		  $this->notebook->set_scrollable(true);
		  $this->notebook->realize();
		  
		  list($this->book_open, $this->book_open_mask) = Gdk::pixmap_create_from_xpm_d($this->notebook->window, null, $this->book_open_xpm);
		  list($this->book_closed, $this->book_closed_mask) = Gdk::pixmap_create_from_xpm_d($this->notebook->window, null, $this->book_closed_xpm);
		  
		  
		  if ($class_containers) $this->create_pages(&$this->notebook, $class_containers, $class_labels);		  
  		  
	}	
	
	function add_frame($class_container,$label,$page='AUTO') {
	        static $autopage=0; 
	
		    $child = &new GtkFrame($label);
		    $child->set_border_width(1);

		    $vbox = &new GtkVBox(true, 0);
		    $vbox->set_border_width(1);
		    $child->add($vbox);
			
			$alias = str_replace(" ","_",$label); //echo $alias,"\n";
		    $this->{$alias} = &new $class_container($vbox);

		    $child->show_all();
			
		    $label_box = &new GtkHBox(false, 0);
		    $pixwid = &new GtkPixmap($this->book_closed, $this->book_closed_mask);
		    $label_box->pack_start($pixwid, false, true, 0);
		    $pixwid->set_padding(3, 1);			

		    $label = &new GtkLabel("$label");
		    $label_box->pack_start($label, false, true, 0);
		    $label_box->show_all();
			
		    $menu_box = &new GtkHBox(false, 0);
		    $pixwid = &new GtkPixmap($this->book_closed, $this->book_closed_mask);
		    $menu_box->pack_start($pixwid, false, true, 0);
		    $pixwid->set_padding(3, 1);			

		    $label = &new GtkLabel("$label");
		    $menu_box->pack_start($label, false, true, 0);
		    $menu_box->show_all();
		
		    $this->notebook->append_page_menu($child, $label_box, $menu_box);
			
			//save pagenum
			if ($page=='AUTO') {
			  $p = $autopage++;  //echo 'zzzzzzzzz';
			}  
			else 
			  $p = $page;
			//echo $p,"\n";	
			  
			if ($autopage>3) $autopage=0;//carefull not to go over 3 = 0,1,2,3 editors!!!(close action)
				   
			$this->notebook->set_page($p);
			$this->notepage[$alias] = $p;	
			
			//print_r($this->notepage);      
	}
	
	function delete_frame($alias,$page='AUTO') {	
		   
		   if ($this->notepage) {
		     //get page from array
	         if ($page=='AUTO') 
			   $p = $this->notepage[$alias];
			 else
			   $p = $page;  
			 //echo $p,"\n";
			 
			 $this->{$alias}->free();		   
	
	         $this->{$alias} = null;
			 unset($this->{$alias});
		   
		     //remove page	
	         $this->notebook->remove_page($p);
			 //remove page num
			 $this->notepage[$alias] = 'x';
		   }	 
	}
	
	function closeall_frame() {
	
	      reset($this->notepage);
		  
	      foreach ($this->notepage as $alias=>$page) {
		    //echo $alias ."\n";
			 $this->{$alias}->free();				
	         $this->{$alias} = null;
			 unset($this->{$alias});			 			
			//$this->delete_frame($alias);
		  }
		  //manual delete 4 pages 0..3
		  for ($i=3;$i>=0;$i--) {
		    $this->notebook->remove_page($i);
		  }	
		  
		  unset($this->notepage);
	}
	
    function create_pages($notebook, $containers, $labels) {

	      $class_container = explode(",",$containers);
		  $class_label = explode(",",$labels);
	
	      foreach ($class_container as $num=>$class) {
		  
		    $child = &new GtkFrame("$lab");
		    $child->set_border_width(1);

		    $vbox = &new GtkVBox(true, 0);
		    $vbox->set_border_width(1);
		    $child->add($vbox);
			
			$lab = $class_label[$num];
			$alias = str_replace(" ","_",$lab);
		    $this->{$alias} = &new $class($vbox);

		    $child->show_all();
			
		    $label_box = &new GtkHBox(false, 0);
		    $pixwid = &new GtkPixmap($this->book_closed, $this->book_closed_mask);
		    $label_box->pack_start($pixwid, false, true, 0);
		    $pixwid->set_padding(3, 1);			

		    $label = &new GtkLabel("$lab");
		    $label_box->pack_start($label, false, true, 0);
		    $label_box->show_all();
			
		    $menu_box = &new GtkHBox(false, 0);
		    $pixwid = &new GtkPixmap($this->book_closed, $this->book_closed_mask);
		    $menu_box->pack_start($pixwid, false, true, 0);
		    $pixwid->set_padding(3, 1);			

		    $label = &new GtkLabel("Page $i");
		    $menu_box->pack_start($label, false, true, 0);
		    $menu_box->show_all();
		
		    $notebook->append_page_menu($child, $label_box, $menu_box);
			
			//save pagenum
			$this->notebook->set_page($num);			
			$this->notepage[$alias] = $num;
	    }		
	}		
	
	function select_page($alias) {
	    
		   //get page from array
	       $page = $this->notepage[$alias];
		   //set page
		   $this->notebook->set_page($page);
	}
	
	function current_page() {
		   //set page
		   $page = $this->notebook->get_current_page();
		   //echo $page,">>>>";
		   	    
		   //get alias from array
		   if ($page>=0) { //means that at leat one fram exist
		     foreach ($this->notepage as $alias=>$p)
		       if ($p==$page) return ($alias);
		   }	 
		   return -1;	 
	}	
	
    function page_switch($notebook, $page, $page_num) {

	    /* The second parameter of the 'switch_page' callback
	    doesn't work as expected; in fact, the GtkNotebookPage is
	    not passed to it. So we'll do a dirty workaround here. */

	    /* Set the icon of all pages to closed pixmap */
	/*    foreach ($notebook->children() as $child) {
		  $tab_label = $notebook->get_tab_label($child);
		  $children = $tab_label->children();
		  $pixwid = $children[0];
		  $pixwid->set($this->book_closed, $this->book_closed_mask);
	    }
*/
	    /* Set the icon of the current page to open pixmap */
	/*    $tab_label = $notebook->get_tab_label($notebook->get_nth_page($page_num));
	    $children = $tab_label->children();
	    $pixwid = $children[0];
	    $pixwid->set($this->book_open, $this->book_open_mask);*/
    }	
	
}	
?>
