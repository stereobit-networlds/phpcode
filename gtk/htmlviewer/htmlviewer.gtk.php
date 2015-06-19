<?php

$__GTK['htmlviewer']['htmlviewer'] = 'HTML Viewer';
$__GTKXY['htmlviewer']['x'] = 600;
$__GTKXY['htmlviewer']['y'] = 400; 
 
require_once("WidgetHTML.php"); 

class htmlviewer  {

    var $con; 
	
	function htmlviewer($container) {	
	
	  $this->htmlviewer_control($container);  
	}	
	
	function htmlviewer_control(&$container) {				
	
       $vbox = &new GtkVBox();
       $container->add($vbox);
       $vbox->show();
	   
       $t = new PEAR_Frontend_Gtk_WidgetHTML;
       //$t->test(dirname(__FILE__).'/tests/test3.html');

       $t->loadURL("http://localhost/");//www.php.net");
       $t->tokenize();
       $t->Interface();
       $vbox->pack_start($t->widget);

	   
       /*$button = &new GtkButton('Quit');
       $vbox->pack_start($button, false, false);
       $button->connect_object('clicked', array($window, 'destroy'));
       $button->show();*/	   
	   	
	}
}


	 
    function gtk_htmlviewer() {
        global $windows;
		global $shell;
		
        if (!isset($windows['htmlviewer'])) {		
		  		
		  $window = &new GtkWindow;
		  $windows['htmlviewer'] = $window;
		  $window->connect('delete-event', 'delete_event');
		  $window->set_title('htmlviewer');		  
          $window->set_position(GTK_WIN_POS_CENTER);
          $window->set_usize(600,400);		  		  
		  $window->set_border_width(0);		  
		  
		  $shell->htmlviewer = new htmlviewer($window);		  
		  
	      $window->show_all();	  							  
		}
        elseif ($windows['htmlviewer']->flags() & GTK_VISIBLE)
            $windows['htmlviewer']->hide();
        else
            $windows['htmlviewer']->show();			
	}		
		
?>
