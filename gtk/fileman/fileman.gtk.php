<?php

//$__GTK['file_manager']['open'] = 'Open'; 
//$__GTK['file_manager']['save'] = 'Save'; 

class file_manager {
    
	var $mode;
	var $readcom;
	var $writecom;
	var $callback;
	
	function file_manager($mode,$path,$readcom,$writecom,$afterdo) {
	  		  
	  $this->mode = $mode;	 
	  $this->readcom = $readcom;
	  $this->writecom = $writecom;
	  $this->callback = $afterdo;
	}
	
    function ok($button, $fs) {
	  global $shell;
	
	  $file = $fs->get_filename();
	  
	  //print "$this->mode selected '" . $fs->get_filename() . "'\n";
	  //$fs->hide();
	  
	  switch ($this->mode) {
	    case 'open' : $shell->event_queue($this->readcom,$file); break;	  
	    case 'save' : $shell->event_queue($this->writecom,$file); break;
	  }
	  
	  if ($this->callback!="") $shell->event_queue($this->callback);
    }
	
	function cancel($button,$fs) {
	  global $shell;
	
	  //$fs->hide(); 
	  if ($this->callback!="") $shell->event_queue($this->callback);	  
	}	
}
	
	 
    function gtk_file_manager($mode,$title,$path,$instance,$readcom,$writecom,$afterdo,$isfile) {
	    global $windows;
		global $T_project;
		global $shell;
		
		//print $path;
		
        //if (!isset($windows[$instance])) {	
		
		  ${$instance} = &new file_manager($mode,$path,$readcom,$writecom,$afterdo,$isfile);
		
		  $window = &new GtkFileSelection($title);
		  $windows[$instance] = $window;
		  $window->hide_fileop_buttons();
		  $window->set_position(GTK_WIN_POS_CENTER);
		  $window->connect('delete_event', 'delete_event');
		  
		  if ($mode='save') {
		    if ($isfile) //dpc or lib file 
			  $window->set_filename($shell->project_name);
			else  //project
		      $window->set_filename($shell->prj_path.$T_project."\\".$T_project.".prj.php");
		  }	
		  else {
		    $window->set_filename($path); 
		  }	
		   
		  if (!$isfile) $window->complete("$T_project.prj.php");		  

		  $button_ok = $window->ok_button;
		  $button_ok->connect('clicked', array(${$instance},'ok'), $window);
		  //$button_ok->connect('clicked', 'close_window');
	      $button_ok->connect('clicked', 'destroy_event',$window);		  		  
		  
		  $button_cancel = $window->cancel_button;
		  $button_cancel->connect('clicked', array(${$instance},'cancel'), $window);		  
		  //$button_cancel->connect('clicked', 'close_window');
	      $button_cancel->connect('clicked', 'destroy_event',$window);		  

		  $action_area = $window->action_area;

		  $button = &new GtkButton('Hide Fileops');
		  //$button->show();
		  $button->connect_object('clicked', create_function('$w', '$w->hide_fileop_buttons();'), $window);
		  $action_area->pack_start($button, false, false, 0);

		  $button = &new GtkButton('Show Fileops');
		  //$button->show();
		  $button->connect_object('clicked', create_function('$w', '$w->show_fileop_buttons();'), $window);
		  $action_area->pack_start($button, false, false, 0);
		  
		  $window->set_modal(true);
	      $window->show_all();		  	  							  
		/*}
        elseif ($windows[$instance]->flags() & GTK_VISIBLE)
            $windows[$instance]->hide();
        else
            $windows[$instance]->show();*/
	}	
	
	
	//NOT USED ?????
	
	function gtk_open() {
        //if (!opendialog()) 
		gtk_file_manager('open','Open Project',"v:\\webos\\dpc\\","","default");
	}	
	
	function gtk_save() {
        //if (!opendialog()) 
		gtk_file_manager('save','Save Project',"v:\\webos\\projects\\","","default");
	}	
	
	function filehandle($mode,$title,$path,$instance,$readcom,$writecom,$afterdo="",$isfile=0) {

		gtk_file_manager($mode,$title,$path,$instance,$readcom,$writecom,$afterdo,$isfile);	
	}
		
?>
