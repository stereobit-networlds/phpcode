<?php

//$__GTK['dpc_editor']['dpc_editor'] = 'DPC Editor';

require_once ("editor.gtk.php"); 


class dpc_editor extends scintilla { //editor {
	
	function dpc_editor($parent) {	  	  
	  
	  //editor::editor($parent);	  
	  
	  //$this->cedit->set_editable(true);  
	  
	  scintilla::scintilla($parent);
	}
	
	function new_dpc() {
	     global $shell;
	
		 $text = "";
		 
		 if (!$this->ischanged()) {
		 
		   $this->deltext();
		   $this->instext($text);
		   $this->setchange(false);			   	
		 }
		 else {
			$shell->event_queue('savedpc','newdpc');
		 }			   
	}
	
	function open_dpc($dpc) {
	     global $shell;
			
	     //if (!$this->ischanged()) {			 		
	       $text = $this->readfile($dpc);
		   if ($text) {
		      $this->deltext();
			  $this->instext($text);
		   }
		 /*}  
		 else {
		   $shell->event_queue('savedpc','opendpc');
		 } */  			 		 
	}			
	
	function save_dpc($dpc) {
	
	     $res = $this->writefile($dpc);	
		 
		 //if ($res) 
		 $this->setchange(false);		 
	}	
	
	function _close() {
	    global $shell;
			
	    if ($this->ischanged()) {
		  $shell->event_queue('savedpc','close');
          //$shell->event_queue('saveas','close');		//exit has no efect to saveas dpc
		}  

	}	
	
	function exit_() {
	    global $shell;
			
	    if ($this->ischanged()) {
		  $shell->event_queue('savedpc','exit');
          //$shell->event_queue('saveas','exit');		//exit has no efect to saveas dpc
		}  
		else 
		  $shell->event_queue('exit'); 
	}
	
	function free() {
	    
		scintilla::free();
	}				
	
}

	 
/*    function gtk_dpc_editor() {
        global $windows;
		
        if (!isset($windows['dpc_editor'])) {	
		  		
		  $window = &new GtkWindow;
		  $windows['dpc_editor'] = $window;
		  $window->connect('delete-event', 'delete_event');
		  $window->set_title('DPC Editor');
	      $window->set_usize(400, 400);		  
		  $window->set_border_width(0);
		  
		  $instance = &new dpc_editor($window);		  
		  
	      $window->show_all();
		  //$window->realize();		  							  
		}
        elseif ($windows['dpc_editor']->flags() & GTK_VISIBLE)
            $windows['dpc_editor']->hide();
        else
            $windows['dpc_editor']->show();			
	}	*/	
		
?>
