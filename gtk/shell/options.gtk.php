<?php

//$__GTK['options']['options'] = 'Options';
//$__GTKXY['options']['x'] = 300;
//$__GTKXY['options']['y'] = 400;

class options {
	
	var $frame;
	var $configuration;
	var $opchanged;
	
	function options($container=null) {
	    global $config;	  	  		
	
		$this->frame = array();	
        $this->configuration = $config;
		$this->opchanged = false;	   
		
		//if ($container) $this->options_control($container);     
	}
	
	function options_window($page=null) {	
	
		  $this->opchanged = false;	
	
	      $window = &new GtkWindow();
	      $window->connect('delete-event', 'delete_event');		  
	      $window->set_title('Options');
	      $window->set_usize(300, 400);
	      $window->set_position(GTK_WIN_POS_CENTER);	  	
		  		  	
  		  $this->options_control($window);	 
		  
		  $this->show($page);	
		  
	      $window->set_modal(true);		  
	      $window->show_all();			  

	}		
	
	function options_control(&$container) {	
		  		  	
        $basebox = &new GtkVBox();
		$container->add($basebox);	
		
        $tabbox = &new GtkVBox();
		$basebox->add($tabbox);				
		
		//create pages	
		
		$this->notebook = new GtkNotebook;
		$this->notebook->connect('switch_page', array($this,'page_switch'));
		$this->notebook->set_tab_pos(GTK_POS_TOP);
		$tabbox->pack_start($this->notebook, true, true, 0);
		$this->notebook->set_border_width(1);
		$this->notebook->set_scrollable(true);
 	    $this->notebook->set_show_tabs(true);		
		$this->notebook->realize();		
			
		$i = 0;
		foreach ($this->configuration as $s=>$o) {
		  $this->create_options_tab($s,$o,$i++);
		}


	    $separator = &new GtkHSeparator();
	    $basebox->pack_start($separator, false);
	    $separator->show();	
		
        $bbox = &new GtkHBox(false,5);
	    $bbox->set_border_width(5);		
		$basebox->pack_start($bbox,false);				  
		
	    $button1 = &new GtkButton('Ok');
	    $bbox->pack_start($button1,false);  
	    $button1->connect('clicked', array($this,'_exit'));
	    $button1->connect('clicked', 'destroy_event');				
		
	    $button2 = &new GtkButton('Cancel');
	    $bbox->pack_start($button2,false);  
	    $button2->connect('clicked', 'destroy_event');			
			
	}	
	
	function _exit() {
	
	   echo '>>>',$this->opchanged,"\n";
		
	   
	   //if ($this->opchanged==true) {
         $nAnswer = MessageBox( "Changes affect after restart. Exit now ?", "Exit", MB_YESNO + MB_ICONQUESTION + MB_DEFBUTTON2 + MB_CENTER);
	   
         if( $nAnswer == IDYES) {
	        gtk::main_quit();		 
         }
	   //} 		
	}
		
	
	function page_switch() {			
	}
	
	function show($alias='') {
	
	    //echo $alias,"\n";
	
        if ($alias) {
	      $p = $this->frame[$alias];
          if ($p) $this->notebook->set_page($p);		      
		     else $this->notebook->set_page(0);		  		 
		}
		else {
		  $this->notebook->set_page(0);  
		}  
	}
	
	function options_changed() {
	   
	    $this->opchanged = true;
	}		
	
	function create_options($container,$section) {
        $box = &new GtkVBox();
		$container->add($box);		
		
		$scroll_win = &new GtkScrolledWindow();
		//$scroll_win->set_border_width(0);
		$scroll_win->set_policy(GTK_POLICY_AUTOMATIC, GTK_POLICY_ALWAYS);
		$box->pack_start($scroll_win);
		
	    $vmbox = &new GtkVBox();
	    //$vmbox->set_border_width(0);
	    $scroll_win->add_with_viewport($vmbox);				
	
	    reset($section); //print_r($section);
		$i=0;
	    foreach ($section as $rec=>$val) {

	      $hbox = &new GtkHBox();
	      $hbox->set_border_width(0);
	      $vmbox->pack_start($hbox, false,false,0);			
		
		  $this->label{$rec}{$i} = &new GtkLabel($rec);
          $this->label{$rec}{$i}->set_justify(GTK_JUSTIFY_LEFT);		  		  
		  $hbox->pack_start($this->label{$rec}{$i},false);//,false,false,0);
		  
		  $this->field{$rec}{$i} = &new GtkEntry();
		  $this->field{$rec}{$i}->set_text($val);
		  $this->field{$rec}{$i}->set_max_length(64);	
          //$this->field{$section}{$i}->set_justify(GTK_JUSTIFY_RIGHT);		  	  
		  $this->field{$rec}{$i}->connect_object('changed', array($this,'options_changed'));		  
		  $hbox->pack_start($this->field{$rec}{$i});//,false,false,0);			  
		  
		  $i+=1;
		}	
	}			

	function create_options_tab($section,$options,$page=0) {
	
	       static $autopage = 0;

		   $child = &new GtkFrame($section);
		   $child->set_border_width(1);
		   
		   $this->create_options($child,$this->configuration[$section]);		   
		   
		   $child->show_all();			   		
		   
		   $label_box = &new GtkHBox(false, 0);			
		   $label = &new GtkLabel("$section");
		   $label_box->pack_start($label, false, true, 0);
		   $label_box->show_all();
			
		   $menu_box = &new GtkHBox(false, 0);	
		   $label = &new GtkLabel("$section");
		   $menu_box->pack_start($label, false, true, 0);
		   $menu_box->show_all();			   				 		   
			
		   $this->notebook->append_page_menu($child, $label_box, $menu_box);
		   
		   if (!$page) $p = $autopage++;
			      else $p = $page;
				  
		   if ($autopage>count($this->configuation)) $autopage=0;//carefull not to go over 3 = 0,1,2,3 editors!!!(close action)
							  		   
		   
		   $this->frame[$section] = $p;		   	
	}
	
    function create_option_pages() {
	
	       $this->create_env_options("Environment");
	       $this->create_code_options("Code");	   
	}
	
	function menu($container) {
	   global $T_project;

	   $header = &new GtkMenuItem("Options");
	   
	   $optionmenu = &new GtkMenu();	
	   
	   foreach ($this->configuration as $s=>$o) {
         $$s = &new GtkMenuItem($s);
	     $$s->connect_object("activate", array($this, "options_window"),$s);	   
	     $optionmenu->append($$s);		   
	   }
	   
	   $sep = &new GtkMenuItem();	      
	   $optionmenu->append($sep);		     
	   
	   //$this->winframe->properties->menu($projmenu); 
	   //i must call this when a project is on otherwise no object properties exist !!!
	   	    	
	   $header->set_submenu($optionmenu);
	   
	   $container->append($header);	   	   
	}						
}	
		
?>
