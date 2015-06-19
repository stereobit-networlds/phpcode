<?php

$__GTK['console']['console'] = 'Console';

require_once ("editor.gtk.php"); 

class console extends editor {

    var $con; 
	
	function console($container) {	  	  
	  
	   editor::editor($container);
	   
 	   //$this->cedit->set_editable(true);
	   //$this->write("Initialize console ... ");	  
	}	
	
	function free() {
	    
		editor::free();
	}					
	
}


	/* 
    function gtk_console() {
        global $windows;
		global $shell;
		
        if (!isset($windows['console'])) {	
		  		
		  $window = &new GtkWindow;
		  $windows['console'] = $window;
		  $window->connect('delete-event', 'delete_event');
		  $window->set_title('Console');
	      $window->set_usize(400, 250);		  
		  $window->set_border_width(0);
		  
		  //if ($shell->console) $shell->win_console = &$shell->console;
		    //              else 
						  $shell->win_console = new console($window);		  
		  
	      $window->show_all();	  							  
		}
        elseif ($windows['console']->flags() & GTK_VISIBLE)
            $windows['console']->hide();
        else
            $windows['console']->show();			
	}	*/	
		
?>
