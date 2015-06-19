<?php

//$__GTK['prj_editor']['prj_editor'] = 'Project Editor';

require_once ("editor.gtk.php"); 

class prj_editor extends editor {
    
	
	function prj_editor($parent) {		  	  
	  
	  editor::editor($parent);	  	  
	 	  
	  $this->cedit->set_editable(true);			  
	  
      //scintilla::scintilla($parent);		  
	  	  
	}	
			
	function load($prj) {
	     global $shell;

	     //if (!$this->ischanged()) {			 		
		 
	       $text = $this->readfile($prj);
		   if ($text) {
		      $this->deltext();
			  $this->instext($text);
		   }
		 /*}  
		 else {
		   $shell->event_queue('saveprj','openprj');
		 } */   	
	}
	
	function save($prj) {
		 	
	     $res = $this->writefile($prj);	
		 
		 //if ($res) 
		 $this->setchange(false); 
	}		
			
	
	function new_() {
	     global $shell;
	
		 $text = "\n";
		 
		 if (!$this->ischanged()) {
		 
		   $this->deltext();
		   $this->instext($text);
		   $this->setchange(false);			   	
		 }
		 else {
			$shell->event_queue('saveprj','newprj');
		 }		   
	}
	
	function exit_() {//echo 'PROJECT';
	    global $shell;
			
	    if ($this->ischanged()) {
          $nAnswer = MessageBox( "Project not saved. Save project ?", "Save", MB_YESNO + MB_ICONQUESTION + MB_DEFBUTTON2 + MB_CENTER);
	   
          if( $nAnswer == IDYES) {
            //$shell->event_queue('saveprj','exitdpc');			 
            $shell->event_queue('save');			 
            $shell->event_queue('exityes');				
          }
		  else	{
            $shell->event_queue('exit');		  
		  }	
		}  
		else 
		  $shell->event_queue('exit');
	}		
 	
	
	function add_dpc($dpc) { //echo $dpc;
	
		 //$text = $dpc . "\n";
		 //$dpcreq = str_replace("dpc/","\$argdpc/",$dpc);
		 //$text = "require (\"" . $dpcreq . "\");";
		 
		 //$darr = explode ("/",$dpc);
		 //$text = $darr[1].".".trim($darr[2],".dpc.php").";"; //echo $text;
		 
		 $text = $dpc . ";";
		 
	     $oldtext = $this->cedit->get_chars(0,-1);
		 
		 $lines = explode("\n",$oldtext); 
		 //print_r($lines);
		 $maxl = count($lines);
		 foreach ($lines as $nline=>$line) {
		   //if ($nline==1) $newtext .= $text . "\n";		 
		   if (($nline>=0) && ($nline<=$maxl)) 
		     $newtext .= $line . "\n";
		 }	
		 $newtext .= $text . "\n";		 
		 
		 $this->deltext();
		 $this->instext($newtext);		 	 
		 
		 //$this->instext($text);
		 //$this->write($text,$this->cedit->get_position());
		 
		 $this->setchange(true);		 	
	}
	
	function remove_dpc($dpc) { //echo $dpc;
		 
		 $tofind = $dpc; //strtolower($dpc);//.".dpc.php"; 
		 //print $tofind;
		 
	     $oldtext = $this->cedit->get_chars(0,-1);
		 
		 $lines = explode("\n",$oldtext); 
		 //print_r($lines);
		 
		 foreach ($lines as $nline=>$line) {
		   if (($line) && (!stristr($line,$tofind))) $newtext .= $line . "\n";
		 }
		 
		 $this->deltext();
		 $this->instext($newtext);		 
		 	 
		 
		 $this->setchange(true);	     
	}
	
	//overwtitten
	/*function writefile($file) {
	
		 $this->write("<?php\n",0);	
	
	     $mtext = $this->cedit->get_chars(0,-1);
	     $charlen =  strlen($mtext);
		 //print $charlen.">>>>";
		 
		 $this->write("\n?>\n",$charlen);	
		 
		 editor::writefile($file);	 
	}*/
	
	function free() {
	    
		editor::free();
	}		
	
}

	 
 /*   function gtk_prj_editor() {
        global $windows;
		
        if (!isset($windows['prj_editor'])) {	
		  		
		  $window = &new GtkWindow;
		  $windows['prj_editor'] = $window;
		  $window->connect('delete-event', 'delete_event');
		  $window->set_title('Project Editor');
	      $window->set_usize(400, 400);		  
		  $window->set_border_width(0);
		  
		  $instance = &new prj_editor($window);		  
		  
	      $window->show_all();
		  //$window->realize();		  							  
		}
        elseif ($windows['prj_editor']->flags() & GTK_VISIBLE)
            $windows['prj_editor']->hide();
        else
            $windows['prj_editor']->show();			
	}		*/
		
?>
