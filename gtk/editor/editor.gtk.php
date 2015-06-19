<?php

//$__GTK['editor']['editor'] = 'Text Editor'; 

class editor {
    
    var $cedit;	
	var $changed_flag; 
	var $text;	 
	
	function editor($parent) {  	  
	  
	  $this->edit_control($parent);
	  	
	  $this->changed_flag = false;	
	  $this->text = "";    
	}
	
	function edit_control(&$container) {	
		  		  	
          $vbox = &new GtkVBox();
		  $container->add($vbox);
		  //$vbox->show();		  	
		  
		  $scrolled_win = &new GtkScrolledWindow();
		  $scrolled_win->set_border_width(0);
		  $scrolled_win->set_policy(GTK_POLICY_AUTOMATIC, GTK_POLICY_ALWAYS);
		  $vbox->pack_start($scrolled_win);

		  $this->cedit = &new GtkText();
		  $this->cedit->connect_object('changed', array($this,'text_changed'));		  
		  $scrolled_win->add($this->cedit);	
		  
		  //$this->write("xxxxxxx");
		  //$this->write("1111111",4);  		  
	}	
	
	
	function write($text,$pos=0) {
          $this->cedit->freeze();	
		  $this->cedit->insert_text("$text\n",$pos);
          $this->cedit->thaw();		  	
	}
	
	function instext($text) {
          $this->cedit->freeze();	
          $font = gdk::font_load('-unknown-Arial-normal-r-normal--*-120-96-96-p-0-iso8859-1');    
          $this->cedit->insert($font,null,null,$text);
          $this->cedit->thaw();	
	}
	
	function deltext() {
          $this->cedit->freeze();	
          $this->cedit->delete_text(0,-1);
          $this->cedit->thaw();		 	
	}
	
	function readfile($file) {
	
	     $textfile = file($file);	
		 $out = implode("",$textfile);

		 return ($out);
	}	
	
	function writefile($file) {
	
	     $text = $this->cedit->get_chars(0,-1);
	
         if ($fp = fopen ($file , "w")) {
                   fwrite ($fp, $text);
                   fclose ($fp);
				   
				   return (true);
	     }
	     else {
				   return (false);
		 }
	}	
	
	function text_changed() {
	
	      $this->changed_flag = true; //echo "z";
	}
	
	function ischanged() {
	
	      return ($this->changed_flag); //echo "?";
	}
	
	function setchange($truefalse) {

	      $this->changed_flag = $truefalse;
	}	
	
	function free() {
	
	     $this->cedit->destroy();
		 $this->cedit = null;
		 unset($this->cedit);
	}			
	
}

	/* 
    function gtk_editor() {
        global $windows;
		
        if (!isset($windows['editor'])) {	
		  		
		  $window = &new GtkWindow;
		  $windows['editor'] = $window;
		  $window->connect('delete-event', 'delete_event');
		  $window->set_title('Editor');
	      $window->set_usize(400, 400);		  
		  $window->set_border_width(0);
		  
		  $instance = &new editor($window);		  
		  
	      $window->show_all();
		  //$window->realize();		  							  
		}
        elseif ($windows['editor']->flags() & GTK_VISIBLE)
            $windows['editor']->hide();
        else
            $windows['editor']->show();			
	}*/		
		
?>
