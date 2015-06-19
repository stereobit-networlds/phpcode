<?php

//$__GTK['loc_editor']['loc_editor'] = 'Locales Editor';

require_once ("editor.gtk.php"); 

class loc_editor extends scintilla {//editor {

    var $lfile;
	
	function loc_editor($parent) {	  	  
	 
	  $this->lfile = paramload('PROJECT','MLOCFILE');
	  
	  //editor::editor($parent);	  
	  
	  //$this->cedit->set_editable(true);  
	  
	  scintilla::scintilla($parent);	  
	}
	
	function add_dpc($dpc) {
	
	     $item = explode(";",$dpc);			 
		 
		 $text = strtoupper($item[0]) . "_DPC;\n";
		 
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
	
		 $text = str_replace(" ","",$this->init_locales());//""; 
		 
	     $this->deltext();
		 $this->instext($text);
		 $this->setchange(false);			   				   
	}
	
	function load($path) {
	     global $shell;
					 		
	     $text = $this->readfile($path."/".$this->lfile);
		 
		 if ($text) {
		    $this->deltext();
			$this->instext($text);
			  
            $shell->set_console_message("Locales loaded.");			  
		 } 
		 else {
            $shell->set_console_message("Locales NOT loaded!!");	
			
			$this->recreate_question($path);		 		 
		 }	
	}			
	
	function save($path) {
	     global $shell;	
	
	     $res = $this->writefile($path."/".$this->lfile);	
		 
         if ($res) $shell->set_console_message("Locales saved.");
		      else $shell->set_console_message("Locales NOT saved!!");		 	
					 
		 $this->setchange(false);		 
	}	
	
	
	function init_locales() {
	
	  $out = "_LANG;English;Greek;
              Monday;Monday;Δευτέρα;
              Tuesday;Tuesday;Τρίτη;
              Wednesday;Wednesday;Τετάρτη;
              Thursday;Thursday;Πέμπτη;
              Friday;Friday;Παρασκευή;
              Saturday;Saturday;Σάββατο;
              Sunday;Sunday;Κυριακή;
              January;January;Ιανουαρίου;
              February;February;Φεβρουαρίου;
              March;March;Μαρτίου;
              April;April;Απριλίου;
              May;May;Μαίου;
              June;June;Ιουνίου;
              July;July;Ιουλίου;
              August;August;Αυγούστου;
              September;September;Σεπτεμβρίου;
              October;October;Οκτωβρίου;
              November;November;Νοεμβρίου;
              December;December;Δεκεμβρίου;
              _LOCAL;Language;Γλώσσα;
              _HOME;My Home;Αρχική;
              _ADMIN;Admin;Διαχείρηση;
              _COMMANDS;Commands;Εντολές;
              _THEME;Theme;Θέμα;
              _MORE;More;Περισσότερα;
              _CODE;Code;Κωδικός;
              _ADVANCE;Advance;Για προχωρημένους;
              _CPANEL;Control;Διαχείρηση;
              _COMLINE;Command;Εντολή;
              _DATE;Date;Ημερ/νία;
              _TIME;Time;Ωρα;
              _BUY;Buy;Αγορά;
              _ADD;Add;Προσθήκη;
              _REM;Remove;Αφαίρεση;
              _ITEM;Item;Είδος;
              _NOACCESS;No Access;Μη Προσβάσιμο;
              _IMAGE;Picture;Εικόνα;";
			  
			  return ($out);	
	}	
	
	function recreate_question($path) {
	
       $nAnswer = MessageBox( "Locale file doesn't exist. Recreate file ?", "Warning", MB_YESNO + MB_ICONQUESTION + MB_DEFBUTTON2 + MB_CENTER);
	   
       if( $nAnswer == IDYES) {	   	 
		  $this->recreate_locales($path);
       } 	
	}	
	
	function recreate_locales($path) {
	     global $shell;
		 
		 $name = $shell->get_project_title();
		 
		 $project_file = $path . "/" . $name . ".prj.php";	
	
	     //get defaults
		 $text = str_replace(" ","",$this->init_locales());//""; 
	     $this->deltext();
		 $this->instext($text);
         $this->save($path); 	
		 
		 		 
		 //read added dpc
		 $dpcs = file($project_file); //print_r($dpcs);
		 foreach ($dpcs as $line=>$dpc) {
		   
		    if (trim($dpc)!=null) $this->add_dpc($dpc); 
		 }		 
		 
	}
	
	function free() {
	    
		scintilla::free();
	}		
	
}

	/* 
    function gtk_loc_editor() {
        global $windows;
		
        if (!isset($windows['loc_editor'])) {	
		  		
		  $window = &new GtkWindow;
		  $windows['loc_editor'] = $window;
		  $window->connect('delete-event', 'delete_event');
		  $window->set_title('Locales Editor');
	      $window->set_usize(400, 400);		  
		  $window->set_border_width(0);
		  
		  $instance = &new loc_editor($window);		  
		  
	      $window->show_all();
		  //$window->realize();		  							  
		}
        elseif ($windows['loc_editor']->flags() & GTK_VISIBLE)
            $windows['loc_editor']->hide();
        else
            $windows['loc_editor']->show();			
	}		*/
		
?>
