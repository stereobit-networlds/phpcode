<?php

$__GTK['file_manager']['open'] = 'Open'; 
$__GTK['file_manager']['save'] = 'Save'; 

$__dialogs[0] = 'open';
$__dialogs[1] = 'save';

class file_manager {
    
    var $root_dir; 
	var $mode;
	
	function file_manager($mode,$label='',$path='') {
	  
      $this->root_dir = "c:\webos\dpc";		  
	  $this->mode = $mode;	 
	}
	
    function ok($button, $fs) {
	  print "$this->mode selected '" . $fs->get_filename() . "'\n";
	  $fs->hide();
	  
	  switch ($this->mode) {
	  }
    }
	
}
	
	 
    function gtk_file_manager($mode="open",$title="Open",$path="") {
	    global $windows;
		
        if (!isset($windows[$mode])) {	
		
		  $instance = &new file_manager($mode,$title,$path);
		
		  $window = &new GtkFileSelection($title);
		  $windows[$mode] = $window;
		  $window->hide_fileop_buttons();
		  $window->set_position(GTK_WIN_POS_CENTER);
		  $window->connect('delete_event', 'delete_event');

		  $button_ok = $window->ok_button;
		  $button_ok->connect('clicked', array($instance,'ok'), $window);

		  $button_cancel = $window->cancel_button;
		  $button_cancel->connect('clicked', 'close_window');

		  $action_area = $window->action_area;

		  $button = &new GtkButton('Hide Fileops');
		  //$button->show();
		  $button->connect_object('clicked', create_function('$w', '$w->hide_fileop_buttons();'), $window);
		  $action_area->pack_start($button, false, false, 0);

		  $button = &new GtkButton('Show Fileops');
		  //$button->show();
		  $button->connect_object('clicked', create_function('$w', '$w->show_fileop_buttons();'), $window);
		  $action_area->pack_start($button, false, false, 0);
		  
	      $window->show_all();		  	  							  
		}
        elseif ($windows[$mode]->flags() & GTK_VISIBLE)
            $windows[$mode]->hide();
        else
            $windows[$mode]->show();
	}	
	
	function gtk_open($label="Open",$path='') {
        //if (!opendialog()) 
		gtk_file_manager("open",$label,$path);
	}	
	
	function gtk_save($label="Save",$path='') {
        //if (!opendialog()) 
		gtk_file_manager("save",$label,$path);
	}	
	
	function opendialog() {
	    global $__dialogs;
		global $windows;
	/*	
		print_r($windows);
		
        foreach ($__dialogs as $d => $w) {
		   if ((isset($windows[$w]) && ($windows[$w]->flags() & GTK_VISIBLE))
		     return true;
		}
		return false;*/
	}
		
?>
