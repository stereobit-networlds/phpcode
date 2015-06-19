<?php

//$__GTK['sec_editor']['sec_editor'] = 'Security Editor';

require_once ("editor.gtk.php"); 

class sec_editor extends scintilla {//editor {

    var $mfile;
	
	function sec_editor($parent) {	
	
	  $this->mfile = paramload('PROJECT','MSECFILE'); //echo $this->mfile,'>>>>>';  	  
	  
	  //editor::editor($parent);	  
	  
	  //$this->cedit->set_editable(true);  
	  
      scintilla::scintilla($parent);		  
	}
	
	function add_dpc($dpc) {
	
	     $item = explode(";",$dpc);		 	   
						   
		 $text = strtoupper($item[0]) . "_DPC;0;0;0;0;0;0;0;0;0\n";
		 
		 //$this->instext($text);
		 $this->write($text,0);
		 
		 $this->setchange(true);		 	
	}
	
	function remove_dpc($dpc) {
		 
	     //$oldtext = $this->cedit->get_chars(0,-1);
	     //$oldtext = $this->scintilla->get_chars(0,-1);	//??????????????	 
		 
		 $tofind = $dpc;
		 //$newtext = str_replace($tofind,"#",$oldtext);
		 
		 $lines = explode("\n",$oldtext); 
		 //print_r($lines);
		 
		 foreach ($lines as $nline=>$line) {
		   if (($line) && (!stristr($line,$tofind))) $newtext .= $line . "\n";
		 }		 
		 
		 $this->deltext();
		 $this->instext($newtext);		 	 
		 
		 $this->setchange(true);	     
	}	
	
	function new_() {
	
		 $text = "";
		 
	     $this->deltext();
		 $this->instext($text);
		 $this->setchange(false);			   				   
	}
	
	function load($path) {
	     global $shell;
					 		
	     $text = $this->readfile($path."/".$this->mfile);//"\modules.csv");
		 
		 if ($text) {
		      $this->deltext();
			  $this->instext($text);
			  
            $shell->set_console_message("Security loaded.");			  
		 } 
		 else {
            $shell->set_console_message("Security NOT loaded!!");			 		 
			
			$this->recreate_question($path);	
	     }		
	}			
	
	function save($path) {
	     global $shell;	
	
	     $res = $this->writefile($path."/".$this->mfile);//"\modules.csv");	
		 
         if ($res) $shell->set_console_message("Security saved.");
		      else $shell->set_console_message("Security NOT saved!!");		 	
					 
		 $this->setchange(false);		 
	}	
	
	function recreate_question($path) {
	
       $nAnswer = MessageBox( "Security file doesn't exist. Recreate file ?", "Warning", MB_YESNO + MB_ICONQUESTION + MB_DEFBUTTON2 + MB_CENTER);
	   
       if( $nAnswer == IDYES) {	   	 
		  $this->recreate_security($path);
       } 	
	}	
	
	function recreate_security($path) {
	     global $shell;
		 
		 $name = $shell->get_project_title();
		 
		 $project_file = $path . "/" . $name . ".prj.php";
		 
		 //echo $project_file,">>>>";
		 
		 $dpcs = file($project_file); //print_r($dpcs);
		 foreach ($dpcs as $line=>$dpc) {
		   
		    if (trim($dpc)!=null) $this->add_dpc($dpc); 
		 }

         $this->save($path); 
	}
	
	function free() {
	    
		scintilla::free();
	}	
	
}

	 
 /*   function gtk_sec_editor() {
        global $windows;
		
        if (!isset($windows['sec_editor'])) {	
		  		
		  $window = &new GtkWindow;
		  $windows['sec_editor'] = $window;
		  $window->connect('delete-event', 'delete_event');
		  $window->set_title('Security Editor');
	      $window->set_usize(400, 400);		  
		  $window->set_border_width(0);
		  
		  $instance = &new sec_editor($window);		  
		  
	      $window->show_all();
		  //$window->realize();		  							  
		}
        elseif ($windows['sec_editor']->flags() & GTK_VISIBLE)
            $windows['sec_editor']->hide();
        else
            $windows['sec_editor']->show();			
	}	*/	
		
?>
