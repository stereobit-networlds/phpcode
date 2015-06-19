<?php
 

class winframe {	

    var $windows;		
	
	function winframe() {
		  	  
	    $this->windows = array();
	}
	
	function add_winframe($class_container,$label,$w=400,$h=250,$b=0,$hidden=0,$type=null) {
	    $alias = str_replace(" ","_",$label);		
	
        if (!isset($this->windows[$alias])) {		
		  
		  switch ($type) {		
		    case 'POPUP'  : $window = &new GtkWindow(GTK_WINDOW_POPUP); break;
		    case 'DIALOG' : $window = &new GtkWindow(GTK_WINDOW_DIALOG); break;
		    case 'TLEVEL' : $window = &new GtkWindow(GTK_WINDOW_TOPLEVEL); break;			
		    default       : $window = &new GtkWindow();						
		  }
		  $this->windows[$alias] = $window;
		  $window->connect('delete-event', 'delete_event');
		  $window->set_title($label);
	      $window->set_usize($w, $h);		  
		  $window->set_border_width($b);
		  
		  $this->{$alias} = &new $class_container($window);		   		  
		  
	      $window->show_all();	  		
		  					  
		  if ($hidden) $this->windows[$alias]->hide();		  
		}
        elseif ($this->windows[$alias]->flags() & GTK_VISIBLE)
            $this->windows[$alias]->hide();
        else
            $this->windows[$alias]->show();	
	}
	
	function showhide_winframe($alias,$state='SHOW') {
	
        if (isset($this->windows[$alias])) {	
		  
		  switch ($state) {
		    case 'SHOW' : $this->windows[$alias]->show(); break;
			case 'HIDE' : $this->windows[$alias]->hide(); break;
			default     : $this->windows[$alias]->show();
		  }
		
		}	
	}	
	
	function closeall_winframe() {
	
	    reset($this->windows);
	
	    foreach ($this->windows as $alias=>$win) {
          //if (isset($this->windows[$alias])) 
			  $this->windows[$alias]->hide(); 
	    }
	}	
	
}	
		
?>
