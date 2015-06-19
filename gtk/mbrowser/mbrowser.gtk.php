<?php

//$__GTK['mbrowser']['mbrowser'] = 'Multi Browser'; 
//$__GTKXY['mbrowser']['x'] = 640;
//$__GTKXY['mbrowser']['y'] = 480; 

class mbrowser {
     
	var $prj_dir;
	var $public_name;
	var $url;
	
	var $console;
	var $cedit;
	var $t;
	
	function mbrowser() {
	  
	  $this->console = null;
	  $this->cedit = null;	  
	  	  
	}
	
	function run($prjpath="",$urlpath="",$publicn="") {
	  global $T_project;	
	  
	  if ($publicn) $this->public_name = $publicn;
	           else $this->public_name = "action.func";  
	
      if ($prjpath) $this->prj_dir = $prjpath; 
	           else $this->prj_dir = "\webos\projects\\".$T_project."\public\\";	
	
      if ($urlpath) $this->url = $urlpath; 
	           else $this->url = "http://localhost/".$T_project.'/';	
			   
	
	  $this->mbrowser_window();		   
	
	}
	
	function mbrowser_window() {	
	
	      $window = &new GtkWindow();
	      $window->connect('delete-event', 'delete_event');
	      $window->set_title('MultiBrowser');
	      $window->set_usize(600, 400);
	      $window->set_position(GTK_WIN_POS_CENTER);	  	
		  		  	
	      $this->mbrowser_control($window);
		  
	      $window->set_modal(true);		  
	      $window->show_all();			  

	}		
	
	function mbrowser_control(&$container) {	
		  		  	
      $vbox = &new GtkVBox();
	  $container->add($vbox);
		  
	  //holds quick buttons
	  $hbox = &new GtkHBox(false, 5);
	  $hbox->set_border_width(0);
	  $vbox->pack_start($hbox, false);	
	  
      $button = &new GtkButton('Restart');
	  $button->connect_object('clicked', array($this, 'restart'));
	  $hbox->pack_start($button);			  	  	
		  
	  $this->quads($vbox);
		  	  
	}	
	
	function quads($container) {
	
      $vpaned = &new GtkVPaned;
	  $container->pack_start($vpaned, true, true, 0);
	  
	  $vpaned->set_border_width(0);

  	  $hpaned_01 = &new GtkHPaned;
	  $vpaned->add1($hpaned_01);
	  
	  $hpaned_02 = &new GtkHPaned;	  
	  $vpaned->add2($hpaned_02);
	  
      //1 quad
  	  $frame = &new GtkFrame;
	  $frame->show();
	  $frame->set_shadow_type(GTK_SHADOW_IN);
	  $frame->set_usize(320, 240);
	  $hpaned_01->add1($frame);

	  $this->html_browser($frame);	  

      //2 quad	  
  	  $frame = &new GtkFrame;
	  $frame->show();
	  $frame->set_shadow_type(GTK_SHADOW_IN);
	  //$frame->set_usize(60, 60);
	  $hpaned_01->add2($frame);
		  
	  //$this->console22 = &new console($frame); 

	  //3 quad
 	  $frame = &new GtkFrame;
	  $frame->show();
	  $frame->set_shadow_type(GTK_SHADOW_IN);
	  $frame->set_usize(320, 240);
	  $hpaned_02->add1($frame);
		
	  $this->console = new console($frame);
	  $this->console_browser();	
		
	  //4 quad		
	  $frame = &new GtkFrame;
	  $frame->show();
	  $frame->set_shadow_type(GTK_SHADOW_IN);
	  //$frame->set_usize(60, 80);
	  $hpaned_02->add2($frame);
	  
	  $this->edit($frame);	  

	}	
	
	function edit($container) {
	
      $vbox = &new GtkVBox();
	  $container->add($vbox);	
	
	  $scrolled_win = &new GtkScrolledWindow();
	  $scrolled_win->set_border_width(0);
	  $scrolled_win->set_policy(GTK_POLICY_AUTOMATIC, GTK_POLICY_ALWAYS);
	  $vbox->pack_start($scrolled_win);

	  $this->cedit = &new GtkText();
	  //$this->cedit->connect_object('changed', array($this,'text_changed'));		  
	  $scrolled_win->add($this->cedit);	
	}	
	
	function html_browser($container) {
	
       $vbox = &new GtkVBox();
       $container->add($vbox);
       $vbox->show();
	   
       $this->t = new PEAR_Frontend_Gtk_WidgetHTML;
       //$t->test(dirname(__FILE__).'/tests/test3.html');

       $this->t->loadURL($this->url);
       $this->t->tokenize();
       $this->t->Interface();
       $vbox->pack_start($this->t->widget);	
	}	
	
	function console_browser() {
	
	   $runfile = $this->prj_dir . $this->public_name;
	
	   if (is_file($runfile)) {
	   
	     if (is_dir($this->prj_dir)) {
		   
	       $this->console->write("php -q ".$runfile);		 
		   
	       chdir($runpath);	
	       $out = shell_exec("php -q ".$runfile);
	   
           $this->console->write($out);		   
		   
		 }
		 else
		   $this->console->write("Invalid directory! (".$this->public_name.")");	
	   }   
	   else
	     $this->console->write("Invalid file! (".$runfile.")");	
	}
	
	function restart() {
	  global $shell;	
	  global $T_project;	
	  
	  if ($publicn) $this->public_name = $publicn;
	           else $this->public_name = "action.func";  
	
      if ($prjpath) $this->prj_dir = $prjpath; 
	           else $this->prj_dir = "\webos\projects\\".$T_project."\public\\";	
	
      if ($urlpath) $this->url = $urlpath; 
	           else $this->url = "http://localhost/".$T_project.'/';	    

      $shell->console->write("Restart ...".$T_project);	  		
	  
	  //restart actions to quads.......................................
	//  $this->console->deltext();
	//  $this->console_browser();		
	  
    //  $this->t->loadURL($this->url);
    //  $this->t->tokenize();
    //  $this->t->Interface();	      
	}
	
	function menu($container,$menu_on=0) {

	   //$header = &new GtkMenuItem("Options");
	   
	   //$mbrs = &new GtkMenu();	
	   
	   if ($menu_on) {	   
	     $run = &new GtkMenuItem("Run 2");
	     $run->connect_object("activate", array($this, "run"));	   
	     $container->append($run);	 	      
       }
	    	
	   //$header->set_submenu($mbrs);
	   
	   //$container->append($header);	   	   
	}		
	
}		
?>
