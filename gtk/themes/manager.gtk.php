<?php

$__GTK['manager']['manager'] = 'FPManager';
$__GTKXY['manager']['x'] = 600;
$__GTKXY['manager']['y'] = 400;

require("former.gtk.php");				
require("visualman.gtk.php"); 

class manager {
	
	var $codedit;
	var $status;
	var $stuf;	
	
	function manager($container) {	  	  		
	   
		$this->manager_control($container);     
	}
	
	function manager_control(&$container) {	
	    global $shell;
		  		  	
        $basebox = &new GtkVBox();
		$container->add($basebox);	
		
        //holds menu
	    $mbox = &new GtkVBox(false, 5);
	    $mbox->set_border_width(0);
	    $basebox->pack_start($mbox, false);
		
		$this->menu($mbox);				
		
		//create pages	
		$this->notebook = new GtkNotebook;
		$this->notebook->show();
		$this->notebook->connect('switch_page', array($this,'page_switch'));
		$this->notebook->set_tab_pos(GTK_POS_TOP);
		$basebox->pack_start($this->notebook, true, true, 0);
		$this->notebook->set_border_width(1);
		$this->notebook->set_scrollable(true);
 	    $this->notebook->set_show_tabs(true);		
		$this->notebook->realize();		
		
		//$this->create_manager_pages();	
		
        //holds statusbar
	    $tbox = &new GtkVBox(false, 5);
	    $tbox->set_border_width(0);
	    $basebox->pack_start($tbox, false);
		
        $this->status = &new GtkStatusbar();
        $this->stuff = array('Here we go...', 'lower case alpha', 'UPPER CASE ALPHA', 'numeric', 'return', 'spacebar', 'non-alphanumeric');
        $this->status->push($this->status->get_context_id($this->stuff[0]), $this->stuff[0]);
        $tbox->pack_end($this->status, false);
        $this->status->show();
							
	}	
	
	
	function new_($themename='default') {
	    global $shell;	
	
		$this->create_manager_pages();	
			
		$projectpath = $shell->prj_path.$shell->get_project_title();	

	    $this->visualman->load("$projectpath\\themes\\$themename.theme\\$themename.xgi");	
	    $this->codedit->load("$projectpath\\themes\\$themename.theme\\$themename.xgi");	
	}
	
	function load($themename='default') {	
	    global $shell;	
		
		$this->create_manager_pages();			
	
		$projectpath = $shell->prj_path.$shell->get_project_title();					
			
	    $this->visualman->load("$projectpath\\themes\\$themename.theme\\$themename.xgi");			
	    $this->codedit->load("$projectpath\\themes\\$themename.theme\\$themename.xgi");	
	}
	
	function save($themename='default') {	
	    global $shell;	
		
		$projectpath = $shell->prj_path.$shell->get_project_title();		
	
	    $this->visualman->save("$projectpath\\themes\\$themename.theme\\$themename.xgi");	
	    $this->codedit->save("$projectpath\\themes\\$themename.theme\\$themename.xgi");
	}	
		
	
	function page_switch() {	
	
        //change status
	
        /* prevent the message stack building up */
        //$popcontext = $this->status->get_context_id($this->stuff[$i]);
        //$status->pop($popcontext);
  	

        /* create and push the new message according to the value */
        //$pushcontext = $this->status->get_context_id($this->stuff[$i]);
        //if ($string && $string!==' ') 
        //  $status->push($pushcontext, $string.' is a '.$this->stuff[$i].' character');
        //else 
		//  $status->push($pushcontext, $stuff[$i]);
	
        //$this->status->push($this->status->get_context_id($this->stuff[1]), $this->stuff[1]);
	}			
	
	function create_visual_manager($title) {

		   $child = &new GtkFrame($title);
		   $child->set_border_width(1);
		   
		   $this->visualman = &new visual_manager($child);		   
		   
		   $child->show_all();			
		   
		   $label_box = &new GtkHBox(false, 0);			
		   $label = &new GtkLabel("$title");
		   $label_box->pack_start($label, false, true, 0);
		   $label_box->show_all();
			
		   $menu_box = &new GtkHBox(false, 0);	
		   $label = &new GtkLabel("$title");
		   $menu_box->pack_start($label, false, true, 0);
		   $menu_box->show_all();			   				 
			
		   $this->notebook->append_page_menu($child, $label_box, $menu_box);		   	
	}	
	
	function create_code_manager($title) {
	
		   $child = &new GtkFrame($title);
		   $child->set_border_width(1);
		   
		   $this->codedit = &new code_editor($child);	
		   	   
		   $child->show_all();							 
			 
		   $label_box = &new GtkHBox(false, 0);			
		   $label = &new GtkLabel("$title");
		   $label_box->pack_start($label, false, true, 0);
		   $label_box->show_all();
			
		   $menu_box = &new GtkHBox(false, 0);	
		   $label = &new GtkLabel("$title");
		   $menu_box->pack_start($label, false, true, 0);
		   $menu_box->show_all();			 
			 
		   $this->notebook->append_page_menu($child, $label_box, $menu_box);	
	}
	
	function create_former_manager($title) {
	
		   $child = &new GtkFrame($title);
		   $child->set_border_width(1);
		   
		   $this->former = &new former($child);	
		   	   
		   $child->show_all();							 
			 
		   $label_box = &new GtkHBox(false, 0);			
		   $label = &new GtkLabel("$title");
		   $label_box->pack_start($label, false, true, 0);
		   $label_box->show_all();
			
		   $menu_box = &new GtkHBox(false, 0);	
		   $label = &new GtkLabel("$title");
		   $menu_box->pack_start($label, false, true, 0);
		   $menu_box->show_all();			 
			 
		   $this->notebook->append_page_menu($child, $label_box, $menu_box);	
	}	
	
    function create_manager_pages() {
	
	       $this->create_visual_manager("Visual");
	       $this->create_code_manager("Code");	   
	       $this->create_former_manager("Former");			   
	}	
	
	function destroy_manager_pages() {
	
	   for ($i=1;$i>=0;$i--) {
		  $this->notebook->remove_page($i);
	   }		
	}
	
	function menu($container) {
	
       $menubar = &new GtkMenuBar();
	   $container->pack_start($menubar, false, false, 0); 	   
	   
	   $header1 = &new GtkMenuItem("File");	     
	   
	   $filemenu = &new GtkMenu();	      
	   
	   $neo = &new GtkMenuItem("New");
	   $neo->connect_object("activate", array($this, "event_queue"),"new");	   
	   $filemenu->append($neo); 	   
	      
	   $open = &new GtkMenuItem("Open");
	   $open->connect_object("activate", array($this, "event_queue"),"open");	   
	   $filemenu->append($open);    
	   
	   $save = &new GtkMenuItem("Save");
	   $save->connect_object("activate", array($this, "event_queue"),"save");	   
	   $filemenu->append($save); 	
	   
	   $saveas = &new GtkMenuItem("Save As ...");
	   $saveas->connect_object("activate", array($this, "event_queue"),"saveas");	   
	   $filemenu->append($saveas); 	     
	   
	   $close = &new GtkMenuItem("Close");
	   $close->connect_object("activate", array($this, "event_queue"),"close");	   
	   $filemenu->append($close);	   
	   
	   $separator = &new GtkMenuItem();
	   $separator->set_sensitive(false);
	   $filemenu->append($separator);
	   
	   //$exit = &new GtkMenuItem("Exit");
	   //$exit->connect_object("activate", array($this, "event_queue"),"sexit"); //exitprj
	   //$filemenu->append($exit); 
	      
	   $header1->set_submenu($filemenu);	
	   
	   $menubar->append($header1);	
	}
	
	function free() {
	
	  $this->destroy_manager_pages();	
	}			
}	
		
?>
