<?php

//$__GTK['loc_editor']['loc_editor'] = 'Locales Editor';

require_once ("editor.gtk.php"); 

class css_editor extends scintilla { //editor {
	
	function css_editor($parent) {
	  global $shell;	  	  
	  
	  //editor::editor($parent);	  
	  
	  //$this->cedit->set_editable(true);  
	  
      scintilla::scintilla($parent);	  	  
	}
	
	
	function new_() {
	
		 $text = ""; 
		 
	     $this->deltext();
		 $this->instext($text);
		 $this->setchange(false);			   				   
	}
	
	function load($pathfile) {
	     global $shell;

	     $text = $this->readfile($pathfile);
		 
		 if ($text) {
		      $this->deltext();
			  $this->instext($text);
			  
            $shell->set_console_message("CSS loaded.");			  
		 } 
		 else
            $shell->set_console_message("CSS NOT loaded!!");			 		 
	}			
	
	function save($pathfile) {
	     global $shell;	
	
	     $res = $this->writefile($pathfile);	
		 
         if ($res) $shell->set_console_message("CSS saved.");
		      else $shell->set_console_message("CSS NOT saved!!");		 	
					 
		 $this->setchange(false);		 
	}
	
	function free() {
	    
		scintilla::free();
	}			
	
}

	/* 
    function gtk_css_editor() {
        global $windows;
		
        if (!isset($windows['css_editor'])) {	
		  		
		  $window = &new GtkWindow;
		  $windows['css_editor'] = $window;
		  $window->connect('delete-event', 'delete_event');
		  $window->set_title('CSS Editor');
	      $window->set_usize(400, 400);		  
		  $window->set_border_width(0);
		  
		  $instance = &new css_editor($window);		  
		  
	      $window->show_all();
		  //$window->realize();		  							  
		}
        elseif ($windows['css_editor']->flags() & GTK_VISIBLE)
            $windows['css_editor']->hide();
        else
            $windows['css_editor']->show();			
	}	*/	
		
?>
