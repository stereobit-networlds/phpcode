<?php

//$__GTK['loc_editor']['loc_editor'] = 'Locales Editor';

require_once ("editor.gtk.php"); 

class code_editor extends scintilla {//editor {
	
	function code_editor($parent) {	  	  
	  
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

	     $text = $this->readfile($pathfile); //echo ">>>>",$text;
		 
		 if ($text) {
		 
		    $this->deltext();
			$this->instext($text);
			  
            $shell->set_console_message("FPManager file loaded.");			  
		 } 
		 else
            $shell->set_console_message("FPManager file NOT loaded!!");			 		 
	}			
	
	function save($pathfile) {
	     global $shell;	
	
	     $res = $this->writefile($pathfile);	
		 
         if ($res) $shell->set_console_message("FPManager file saved.");
		      else $shell->set_console_message("FPManager file NOT saved!!");		 	
					 
		 $this->setchange(false);		 
	}	
	
	function free() {
	    
		scintilla::free();
	}		
	
}	
		
?>
