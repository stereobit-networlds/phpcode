<?php

class property {

    var $maparray;
	var $iniarray;
	var $dpcarray;
    var $notebook;	
	var $cssedit;
	
	
	function property($container) {	  	  	
	   
	    $this->maparray = array();
	    $this->iniarray = array();
	    $this->dpcarray = array();			
		
		$this->maparray = $this->read_ini(paramload('PROTYPO','MAP'));//"./gtk/themes/protypo.ini");			   
		$this->iniarray = $this->read_ini(paramload('PROTYPO','INI'));//"./gtk/themes/default.ini");		
		$this->dpcarray = $this->read_ini(paramload('PROTYPO','DPC'));//"./gtk/dpcman/protypo.ini",1);		
	   
	    $this->property_control($container);     
	}
	
	function property_control(&$container) {	
	    global $shell;
		  		  	
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
		
		//$this->create_theme_pages();	//REMOVE !!! ADD DOWN !!!!		
	}	
	
	
	function new_($themename='default') {
	    global $shell;	
		
		$this->create_theme_pages();	//ADD HERE!!!!	
	
		$projectpath = $shell->prj_path.$shell->get_project_title();		
	
		$this->maparray = $this->read_ini("$projectpath\public\maptheme.ini");
	    $this->load_properties($this->maparray,"Map");			   
		$this->iniarray = $this->read_ini("$projectpath\\themes\\$themename.theme\\$themename.ini");	
	    $this->load_properties($this->iniarray,"Init");		
		
		$this->cssedit->load("$projectpath\\themes\\$themename.theme\\$themename.css");
	}
	
	function load($themename='default') {
	    global $shell;	
		
		$this->create_theme_pages();	//ADD HERE !!	
	
		$projectpath = $shell->prj_path.$shell->get_project_title();		
	
	    //update properties
		$this->maparray = $this->read_ini("$projectpath\public\maptheme.ini");
	    $this->load_properties($this->maparray,"Map");			   
		$this->iniarray = $this->read_ini("$projectpath\\themes\\$themename.theme\\$themename.ini");	
	    $this->load_properties($this->iniarray,"Init");			
	
		$this->cssedit->load("$projectpath\\themes\\$themename.theme\\$themename.css");				
	}
	
	function save($themename='default') {
	    global $shell;	
		
		$projectpath = $shell->prj_path.$shell->get_project_title();
	
	    $this->save_properties($this->maparray,"Map","$projectpath\public\maptheme.ini");
	    $this->save_properties($this->iniarray,"Init","$projectpath\\themes\\$themename.theme\\$themename.ini");			
	
		$this->cssedit->save("$projectpath\\themes\\$themename.theme\\$themename.css");	
	}	
	
	
	function read_ini($ini,$multid=0) {
	    
		$ret = parse_ini_file($ini,$multid);
	    //print_r($ret);
		
		return ($ret);
	}	
	
	function properties_changed() {
	}		
	
	function page_switch() {			
	}			
	
	//get the prototype properties from array
	function get_properties($container,$prot_array,$alias,$select=0,$from=0) {	
		   	
        $box = &new GtkVBox();
		$container->add($box);		
		
		$scroll_win = &new GtkScrolledWindow();
		//$scroll_win->set_border_width(0);
		$scroll_win->set_policy(GTK_POLICY_AUTOMATIC, GTK_POLICY_ALWAYS);
		$box->pack_start($scroll_win);
		
	    $vmbox = &new GtkVBox();
	    //$vmbox->set_border_width(0);
	    $scroll_win->add_with_viewport($vmbox);				
	
	    reset($prot_array);
		$i=0;
	    foreach ($prot_array as $rec=>$val) {

	      $hbox = &new GtkHBox();
	      $hbox->set_border_width(0);
	      $vmbox->pack_start($hbox, false,false,0);			
		
		  $this->label{$alias}{$i} = &new GtkLabel($rec);
          $this->label{$alias}{$i}->set_justify(GTK_JUSTIFY_LEFT);		  		  
		  $hbox->pack_start($this->label{$alias}{$i},false);//,false,false,0);
		  
		  $this->field{$alias}{$i} = &new GtkEntry();
		  $this->field{$alias}{$i}->set_text($val);
		  $this->field{$alias}{$i}->set_max_length(64);	
          //$this->field{$alias}{$i}->set_justify(GTK_JUSTIFY_RIGHT);		  	  
		  $this->field{$alias}{$i}->connect_object('changed', array($this,'properties_changed'));		  
		  $hbox->pack_start($this->field{$alias}{$i});//,false,false,0);	
		  
		  if (($select)&& ($i>=$from)) {
		    $this->button{$alias}{$i} = &new GtkButton("...");			  
		    $this->button{$alias}{$i}->connect('clicked', array($this,'select_theme_file'),$this->field{$alias}{$i},"Select ...","\\themes\default.theme\\");		  	  		  
		    $hbox->pack_start($this->button{$alias}{$i},false);//,false,false,0);		  		  
		  }
		  
		  $i+=1;
		}
	}		
	
	//load properties  
	function load_properties($prot_array,$alias) {
	
	    if (is_array($prot_array)) { //print_r($prot_array);
	      reset($prot_array);
		  $i=0;
	      foreach ($prot_array as $rec=>$val) {		  
		  
		    //echo $rec,"=",$val,"\n";
		    $this->field{$alias}{$i}->set_text($val);
		    $i+=1;
		  }		
		}  
	}	
	
	//save properties  
	function save_properties($prot_array,$alias,$pathfile) {
	    global $shell;
		
		$out = "";
	
	    if (is_array($prot_array)) {
	      reset($prot_array);
		  $i=0;
	      foreach ($prot_array as $rec=>$val) {		  
		  
		    $prot_array[$rec] = $this->field{$alias}{$i}->get_text();
			$out .= "$rec=$prot_array[$rec]\n";
		    $i+=1;
		  }		
		} 
		
        if ($fp = fopen ($pathfile , "w")) {
                   fwrite ($fp, $out);
                   fclose ($fp);
				   
                   $shell->set_console_message("$alias saved.");				   
	    }
	    else {
                   $shell->set_console_message("$alias NOT saved !!!");
		} 
	}	
	
	function get_dpc_icons($container,$prot_array,$alias) {		
	
        $box = &new GtkVBox();
		$container->add($box);		
		
		$scroll_win = &new GtkScrolledWindow();
		//$scroll_win->set_border_width(0);
		$scroll_win->set_policy(GTK_POLICY_AUTOMATIC, GTK_POLICY_ALWAYS);
		$box->pack_start($scroll_win);
		
	    $vmbox = &new GtkVBox();
	    //$vmbox->set_border_width(0);
	    $scroll_win->add_with_viewport($vmbox);				
	
	    reset($prot_array);
		$i=0;
	    foreach ($prot_array as $rec=>$val) {

	      $hbox = &new GtkHBox();
	      $hbox->set_border_width(0);
	      $vmbox->pack_start($hbox, false,false,0);			
		
		  $this->label{$alias}{$i} = &new GtkLabel($rec);
          $this->label{$alias}{$i}->set_justify(GTK_JUSTIFY_LEFT);		  		  
		  $hbox->pack_start($this->label{$alias}{$i},false);//,false,false,0);
		  
		  $this->field{$alias}{$i} = &new GtkEntry();
		  $this->field{$alias}{$i}->set_text("");
		  $this->field{$alias}{$i}->set_max_length(64);	
          //$this->field{$alias}{$i}->set_justify(GTK_JUSTIFY_RIGHT);		  	  
		  $this->field{$alias}{$i}->connect_object('changed', array($this,'properties_changed'));		  
		  $hbox->pack_start($this->field{$alias}{$i});//,false,false,0);	
		  
		  $this->button{$alias}{$i} = &new GtkButton("...");			  
		  $this->button{$alias}{$i}->connect('clicked', array($this,'select_theme_file'),$this->field{$alias}{$i},"Select ...","\\themes\default.theme\\icons\\");		  	  		  
		  $hbox->pack_start($this->button{$alias}{$i},false);//,false,false,0);		  		  
		  
		  $i+=1;
		}	
	}
	
    function select_theme_file($window,$object_field,$title="Select ...",$path="") {
	      global $shell;			  		
		
		  $window = &new GtkFileSelection($title);
		  $window->hide_fileop_buttons();
		  $window->set_position(GTK_WIN_POS_CENTER);
		  $window->connect('delete_event', 'delete_event');
		  $window->set_filename($shell->prj_path.$shell->project_name.$path); 
					   
		  $window->complete("*.*");

		  $button_ok = $window->ok_button;
		  $button_ok->connect('clicked', array($this,'select_ok'), $window, $object_field);
	      $button_ok->connect('clicked', 'destroy_event',$window);		  		  
		  
		  $button_cancel = $window->cancel_button;
	      $button_cancel->connect('clicked', 'destroy_event',$window);		  

		  $action_area = $window->action_area;
		  
		  $window->set_modal(true);
	      $window->show_all();
	}	
	
    function select_ok($button, $fs, $field_object) {
	
	    $file = $fs->get_filename();
		
		$only_filename = explode("\\",$file);
		
	    $field_object->set_text($only_filename[count($only_filename)-1]);
	}  		
	
	
	
	function create_map_theme($title) {
	
		   $child = &new GtkFrame($title);
		   $child->set_border_width(1);
		   
		   $this->get_properties($child,$this->maparray,$title,1,2);	
		   	   
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
		   //print_r($this->frame);			
	}
	
	function create_ini_theme($title) {

		   $child = &new GtkFrame($title);
		   $child->set_border_width(1);
		   
		   $this->get_properties($child,$this->iniarray,$title);
		   		   
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
	
	function create_css_theme($title) {
	
		   $child = &new GtkFrame($title);
		   $child->set_border_width(1);
		   
		   $this->cssedit = &new css_editor($child);	
		   	   
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
	
	function create_dpc_theme($title) {

		   $child = &new GtkFrame($title);
		   $child->set_border_width(1);
		   
		   $this->get_dpc_icons($child,$this->dpcarray,$title);
		   		   
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
	
    function create_theme_pages() {
	
	   $this->create_map_theme("Map");
	   $this->create_ini_theme("Init");
	   $this->create_css_theme("CSS");	   
	   $this->create_dpc_theme("Icons");	   
	}	
	
	function destroy_theme_pages() {
	
	   for ($i=3;$i>=0;$i--) {
		  $this->notebook->remove_page($i);
	   }		
	}
	
	function free() {
	  
	  $this->destroy_theme_pages();
	}			
}	
		
?>
