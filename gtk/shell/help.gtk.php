<?php

//$__GTK['help']['help'] = 'Help';
//$__GTKXY['help']['x'] = 300;
//$__GTKXY['help']['y'] = 400;

class help {
	
	var $frame;
	
	var $help_path;
	var $titles;
	var $files;
	var $types;	
	var $help;
	
	var $htmluse;
	var $sysenv;
	
	function help($container=null) {	
	    global $config;  	  		
	
	    $this->frame = array();	
		$this->titles = array();
		$this->help = array();
	   
	    $this->sysenv =  paramload('INSTALL','SYSENV');
	   
	    $this->help_path = paramload('INSTALL','APPDIR') .
		                   paramload('HELP','helpath');
						   
		$this->htmluse = paramload('HELP','htmluse');				   
						   
	    $this->titles = arrayload('HELP','helps');
		$this->files = arrayload('HELP','filepath');
		$this->types = arrayload('HELP','filetype');
		
		if (is_array($this->titles)) {
	      //print_r($this->titles);
		  foreach ($this->titles as $id=>$title) {
		
		   $this->help[$title] = $this->help_path . $this->files[$id] . $this->types[$id];
		  }
		} 					   
		//print_r($this->help);

		//if ($container) $this->help_control($container);	       
	}
	
	function help_window($page=null) {	
	
	      $window = &new GtkWindow();
	      $window->connect('delete-event', 'delete_event');
	      $window->set_title('Help');
	      $window->set_usize(600, 400);
	      $window->set_position(GTK_WIN_POS_CENTER);	  	
		  		  	
  		  $this->help_control($window);
		  
		  $this->show($page);		  	 
		  
	      //$window->set_modal(true);		  
	      $window->show_all();			  

	}			
	
	function help_control(&$container) {	
	
        $basebox = &new GtkVBox();
		$container->add($basebox);			
		
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
		
		$this->create_help_pages();			
	}		
		
	
	function page_switch() {			
	}		
	
	function show($alias='') {//echo $alias,"\n";
	
        if ($alias) {
	      $p = $this->frame[$alias];
          if ($p) $this->notebook->set_page($p);		      
		     else $this->notebook->set_page(0);	  		 
		}
		else {
		  $this->notebook->set_page(0);  
		}  
	}		
	
	function create_help($title,$url=null,$page=0) {
	
	       static $autopage=0;

		   $child = &new GtkFrame($title);
		   $child->set_border_width(1);
		   
           $vbox = &new GtkVBox();
           $child->add($vbox);
           $vbox->show();		   
		   
           $t = new PEAR_Frontend_Gtk_WidgetHTML;
           //$t->test(dirname(__FILE__).'/tests/test3.html');

           $t->loadURL($url);
           $t->tokenize();
           $t->Interface();
           $vbox->pack_start($t->widget);		   
		   
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
		   
		   if (!$page) $p = $autopage++;
			      else $p = $page;			   
		   
		   $this->frame[$title] = $page; 		   	
	}	
	
	function execute_help($file) {
	
	       shell_exec($file);	       
	}
	
	
    function create_help_pages() {
	
	       //$this->create_help("Contents","http://localhost",0);
	       //$this->create_help("Scintilla","http://localhost:3333",1);	   
	       //$this->create_help("Php","http://localhost:3333",2);			   		   
		   
		   $i=0;
		   foreach ($this->help as $title=>$url) {
		   
		     if ((stristr($url,'.html')) || (stristr($url,'.htm'))) {
			   //echo 'html';
   			   if (!$this->htmluse) { 
  	             $this->create_help($title,$url,$i);	
			     $i+=1;			   		
			   }   
			 }
			     
		   }
		   
	       $this->create_help("About","http://localhost:3333",$i);			   
	}
	
	function menu($container) {

	   $header = &new GtkMenuItem("Help");
	   
	   $helpmenu = &new GtkMenu();	
	      
	/*   $glb = &new GtkMenuItem("Contents");
	   $glb->connect_object("activate", array($this, 'help_window'),"Contents");	   
	   $helpmenu->append($glb);	 	      
	   
	   $edi = &new GtkMenuItem("Scintilla Editor");
	   $edi->connect_object("activate", array($this, 'help_window'),"Scintilla");	   
	   $helpmenu->append($edi);	    	   		         
	   
	   $php = &new GtkMenuItem("PHP parser");
	   $php->connect_object("activate", array($this, 'help_window'),"Php");	   
	   $helpmenu->append($php);		*/   
	   
	   foreach ($this->help as $title=>$url) {	
	   
	   	     if ((stristr($url,'.html')) || (stristr($url,'.htm'))) {
			 
	           $$title = &new GtkMenuItem($title);
			   
			   if (!$this->htmluse) {
	             $$title->connect_object("activate", array($this, 'help_window'),$title);	   
			   }	 
			   else {
	             $path = setsyspath($url,$this->sysenv); 		   
			     $$title->connect_object("activate", array($this, 'execute_help'),"$this->htmluse $path");	   	 
			   }	 
	           $helpmenu->append($$title);				   
			 }
			 else {
			 
	           $$title = &new GtkMenuItem($title);
	           $$title->connect_object("activate", array($this, 'execute_help'),$url);	   
	           $helpmenu->append($$title);			 
			 }
	   }
	   
	   $sep = &new GtkMenuItem();	      
	   $helpmenu->append($sep);		
	   
	   $abo = &new GtkMenuItem("About...");
	   $abo->connect_object("activate", array($this, 'help_window'),"About");	   
	   $helpmenu->append($abo);		      
   	   
	   	    	
	   $header->set_submenu($helpmenu);
	   
	   $container->append($header);	   	   
	}						
}	
		
?>
