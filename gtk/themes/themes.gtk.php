<?php

$__GTK['themes']['themes'] = 'Themes';
$__GTKXY['themes']['x'] = 200;
$__GTKXY['themes']['y'] = 300;

require_once("property.gtk.php");

class themes {

    var $projectpath;
	var $themepath;

	var $current_theme;
	var $default_theme;
	
	var $property;	
	
	var $theme_window;	
	var $basebox;
	
	function themes($container) {		  	  	
	
	    $this->default_theme = 'default';
	    $this->current_theme = 'default';
		
		$this->theme_window = &$container;		
		
        $this->basebox = &new GtkVBox();
		$container->add($this->basebox);		
		 
	    $this->themes_control($this->basebox);		 
		    
	}
	
	function themes_control(&$container) {	
	
        $this->property = &new property($container);	//load property tabs
		
        $themebox = &new GtkHBox(false,1);
		$container->pack_start($themebox,false);		
		
		//theme buttons				 
		$button1 = &new GtkButton('New');
		$themebox->pack_start($button1);  
		$button1->connect('clicked', array($this,'create_theme'));
		
		$button11 = &new GtkButton('Load');
		$themebox->pack_start($button11);  
		$button11->connect('clicked', array($this,'select_theme'));		
		  
		$button2 = &new GtkButton('Copy');
		$themebox->pack_start($button2);
		$button2->connect('clicked', array($this,'copy_theme'));		  

		$button3 = &new GtkButton('Save');
		$themebox->pack_start($button3);
		$button3->connect('clicked', array($this,'save'));	
		  
		$button4 = &new GtkButton('FPManager');
		$themebox->pack_start($button4);
		$button4->connect('clicked', array($this,'load_manager'));			
	}	
	
	
	function new_($themename='default',$createmap=1) {
	    global $shell;	
	
		$projectpath = $shell->prj_path.$shell->get_project_title();
	    $themepath = $projectpath . "\\themes\\";				
		
		//create default theme dir
		mkdir($themepath."$themename.theme");
		//create icons dir
		mkdir($themepath."$themename.theme\icons");		
		//create files
		$this->create_theme_files($themepath.$themename.".theme\\",$themename);
		
		if ($createmap) $this->create_mapfile();
		
		$this->property->new_();	
		
        if (!$shell->winframe->FPManager) $shell->winframe->add_winframe('manager','FPManager',600,400,0,1);		
		$shell->winframe->FPManager->new_($themename);	
			
	}
	
	function load($theme='default') {
	    global $shell;
	
		$this->current_theme = $theme;
		
		$this->set_title($this->current_theme);
		
		//print "\nload current:".$this->current_theme;				
		
		$this->property->load($theme);
					
        if (!$shell->winframe->FPManager) $shell->winframe->add_winframe('manager','FPManager',600,400,0,1);						
		$shell->winframe->FPManager->load($theme);						
	}
	
	function save() {
	    global $shell;
		
		$this->current_theme = $this->get_theme_title();
	
		//print "\nsave current:".$this->current_theme;
			
		$this->property->save($this->current_theme);		
	
		$shell->winframe->FPManager->save($this->current_theme);		
	}	
	
	function copy_($theme='copyofdefault') {
	    global $shell;	
	
		$projectpath = $shell->prj_path.$shell->project_name;	
	    $themepath = $projectpath . "\\themes\\";			
	    
		//create default theme dir
		mkdir($themepath."$theme.theme");
		//create icons dir
		mkdir($themepath."$theme.theme\icons");		
		//create files
		$this->copy_theme_files($themepath."$theme.theme\\",$theme);	
	    
	}
	
	
	function get_themes_list() {
	   global $shell;	

	   $projectpath = $shell->prj_path.$shell->get_project_title();		
	   $themepath = $projectpath . "\\themes\\";	
	
       if ($themepath) {
	   	
       $themesdir = dir($themepath); //get directory path
       $dmeter=0;
       $themes = array(); 
   
       //parse theme directory
       while ($filename = $themesdir->read ()) {
   
         if (stristr ($filename,'.theme')) {
	       $mytheme = str_replace (".theme", "", $filename);  
           $themes[] = $mytheme;		
	       $dmeter += 1; 
	     }  
       }
	 
       $themesdir->close ();	
	   }

	   return ($themes);
	}	
	
	function create_theme_files($path,$themename) {
	    global $shell;	   
	   
	     //create body.xgi
	     $text = "";
	
         if ($fp = fopen ($path.$themename.".xgi" , "w")) {
                   fwrite ($fp, $text);
                   fclose ($fp);
	     }
	     else {
                   $shell->console->write("Frontpage NOT created !!!");
		 }
		 
		 //copy css file
		 if (!copy(paramload('PROTYPO','CSS'),$path."$themename.css"))
                   $shell->console->write("CSS file NOT created !!!");		   		 
		 //copy themename ini file 
		 if (!copy(paramload('PROTYPO','INI'),$path."$themename.ini"))
                   $shell->console->write("Default Theme INI file NOT created !!!");	 
	}	
	
	function create_mapfile() {
	     global $shell;	

		 $projectpath = $shell->prj_path.$shell->get_project_title();		
	
		 //copy theme map file to public dir	
		 if (!copy(paramload('PROTYPO','MAP'),$projectpath."\public\maptheme.ini"))
                   $shell->console->write("Theme Map file NOT created !!!");		 		 	
	}	
	
	function copy_theme_files($targetpath,$themename) {
	    global $shell;	
		
		$this->current_theme = $this->get_theme_title();		
		
		$mytheme = $this->current_theme;
		if (!$mytheme) $mytheme = 'default';
 
	    $projectpath = $shell->prj_path.$shell->get_project_title();		
	    $sourcepath = $projectpath . "\\themes\\" . $mytheme . ".theme\\";	
				   
	    //echo $sourcepath."body.xgi",">>>",$mytheme;
	   
		 //copy body file
		 if (!copy($sourcepath.$this->current_theme.".xgi",$targetpath."$themename.xgi"))
                   $shell->console->write("Fp file NOT copied !!!");		 
		 //copy css file
		 if (!copy($sourcepath.$this->current_theme.".css",$targetpath."$themename.css"))
                   $shell->console->write("CSS file NOT copied !!!");		   		 
		 //copy themename ini file 
		 if (!copy($sourcepath.$this->current_theme.".ini",$targetpath."$themename.ini"))
                   $shell->console->write("Default Theme INI file NOT copied !!!");	 
	}
			
	
	function select_theme() {
	
	   $window = &new GtkWindow;
	   $window->connect('delete-event', 'delete_event');
	   $window->set_title('Select Theme ...');
       $window->set_position(GTK_WIN_POS_CENTER);	   
	   $window->set_usize(200, 80);		  
	   $window->set_border_width(1);
	   
       $vbox = &new GtkVBox();
	   $window->add($vbox);	
	   
	   $hbox = &new GtkHBox(false, 5);
	   $hbox->set_border_width(5);
	   $vbox->pack_start($hbox, false);	   		   
	   
	   $name = &new GtkLabel("Theme List :");
       $name->set_justify(GTK_JUSTIFY_LEFT);		  		  
	   $hbox->pack_start($name,false,false,0);
		  
	   $theme_strings = $this->get_themes_list();	
		
	   if ($theme_strings!=null) {	
			
		  $themelist = &new GtkCombo();
		  $themelist->set_popdown_strings(array_values($theme_strings));	 
	  	
		  $cb_entry = $themelist->entry;
		  $cb_entry->set_editable(false);		
		  $cb_entry->set_text($this->get_theme_title());
		  //$cb_entry->select_region(0, -1);
		  $hbox->pack_start($themelist);		
	   }	
	   
	   $hbox2 = &new GtkHBox(false, 5);
	   $hbox2->set_border_width(5);
	   $vbox->pack_start($hbox2, false);		   	   
	   
       $button = &new GtkButton('Ok');
	   $button->connect('clicked', array($this,'get_theme_name'),$cb_entry);	   
	   $button->connect('clicked', 'destroy_event',$window);	   
	   $hbox2->pack_start($button,false);
	  
       $button = &new GtkButton('Cancel');
	   $button->connect('clicked', 'destroy_event',$window);	   
	   $hbox2->pack_start($button,false);	  	   
				  
	   $window->set_modal(true);		  
	   $window->show_all();		     
	}
	
	function get_theme_name($button,$comboitem) {
		
		$name = $comboitem->get_text();		
				
		$this->load($name);
	}
	
	function create_theme() {
	   global $pr_name;
	
	   $window = &new GtkWindow;
	   $window->connect('delete-event', 'delete_event');
	   $window->set_title('New Theme');
       $window->set_position(GTK_WIN_POS_CENTER);	   
	   $window->set_usize(200, 80);		  
	   $window->set_border_width(1);
	   
       $vbox = &new GtkVBox();
	   $window->add($vbox);	
	   
	   $hbox = &new GtkHBox(false, 5);
	   $hbox->set_border_width(5);
	   $vbox->pack_start($hbox, false);	   		   
	   
	   $name = &new GtkLabel("Theme name:");
       $name->set_justify(GTK_JUSTIFY_LEFT);		  		  
	   $hbox->pack_start($name,false,false,0);
		  
	   $prname = &new GtkEntry();
	   $prname->set_text("myTheme");
	   $prname->set_max_length(64);		  
	   //$prname->connect_object('changed', array($this,'properties_changed'));		  
	   $hbox->pack_start($prname,false,false,0);
	   
	   $hbox2 = &new GtkHBox(false, 5);
	   $hbox2->set_border_width(5);
	   $vbox->pack_start($hbox2, false);		   	   
	   
       $button = &new GtkButton('Ok');
	   //$button->connect_object('clicked', array($this, 'event_queue'),"newprj");
	   $button->connect('clicked', array($this,'set_theme_name'),$prname);	   
	   $button->connect('clicked', 'destroy_event',$window);	   
	   $hbox2->pack_start($button,false);
	  
       $button = &new GtkButton('Cancel');
	   $button->connect('clicked', 'destroy_event',$window);	   
	   $hbox2->pack_start($button,false);	  	   
				  
	   $window->set_modal(true);		  
	   $window->show_all();		
	}
	
	function set_theme_name($button,$textitem) {
	
	    $name = $textitem->get_text();
		
		$this->new_($name,0);		
	}	
	
	function copy_theme() {
	   global $pr_name;
	
	   $window = &new GtkWindow;
	   $window->connect('delete-event', 'delete_event');
	   $window->set_title('Copy Theme');
       $window->set_position(GTK_WIN_POS_CENTER);	   
	   $window->set_usize(200, 80);		  
	   $window->set_border_width(1);
	   
       $vbox = &new GtkVBox();
	   $window->add($vbox);	
	   
	   $hbox = &new GtkHBox(false, 5);
	   $hbox->set_border_width(5);
	   $vbox->pack_start($hbox, false);	   		   
	   
	   $name = &new GtkLabel("Theme name:");
       $name->set_justify(GTK_JUSTIFY_LEFT);		  		  
	   $hbox->pack_start($name,false,false,0);
		  
	   $prname = &new GtkEntry();
	   $prname->set_text("copiedTheme");
	   $prname->set_max_length(64);		  
	   //$prname->connect_object('changed', array($this,'properties_changed'));		  
	   $hbox->pack_start($prname,false,false,0);
	   
	   $hbox2 = &new GtkHBox(false, 5);
	   $hbox2->set_border_width(5);
	   $vbox->pack_start($hbox2, false);		   	   
	   
       $button = &new GtkButton('Ok');
	   //$button->connect_object('clicked', array($this, 'event_queue'),"newprj");
	   $button->connect('clicked', array($this,'copy_theme_name'),$prname);	   
	   $button->connect('clicked', 'destroy_event',$window);	   
	   $hbox2->pack_start($button,false);
	  
       $button = &new GtkButton('Cancel');
	   $button->connect('clicked', 'destroy_event',$window);	   
	   $hbox2->pack_start($button,false);	  	   
				  
	   $window->set_modal(true);		  
	   $window->show_all();		
	}
	
	function copy_theme_name($button,$textitem) {
	
	    $name = $textitem->get_text();
		
		$this->copy_($name);		
	}	
	
	function set_title($title) {
	
	   $this->theme_window->set_title('Themes - '.$title);
	   $this->theme_window->set_name($title);	    
	}
	
	function get_theme_title() {
	
	   return ($this->theme_window->get_name());	
	}	
	
	function load_manager() {
	   global $shell;
	
       $shell->winframe->add_winframe('manager','FPManager');		
	}
	
	function free() {
	    global $shell;
		
        if ($shell->winframe->FPManager) {						
		  $shell->winframe->FPManager->free();
		  $shell->winframe->showhide_winframe('FPManager','HIDE');
		}
				
		$this->property->free();	
	}
					
}			
?>
