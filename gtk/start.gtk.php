<?php

if (!class_exists('gtk')) {
	if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
		dl('php_gtk.dll');
	else
		dl('php_gtk.so');
}

    Gtk::rc_parse(dirname($argv[0]).'/testgtkrc');//echo dirname($argv[0]).'/testgtkrc';

	$splashwindow = &new GtkWindow("dialog");//GTK_WINDOW_DIALOG);//GTK_WINDOW_POPUP);


	//hauptfenster($splashwindow,"Moment bitte, KGE wird geladen...",300,200);
	$splashwindow->set_policy(1, 1, 1);
	$splashwindow->set_name('splash window');		
	$splashwindow->set_title('Splash');
	$splashwindow->set_usize(200, 150);
	$splashwindow->set_position(GTK_WIN_POS_CENTER);	
	
	$splashwindow->realize();
    $transparent = $splashwindow->style->white;
    list($pixmap, $mask) = Gdk::pixmap_create_from_xpm($splashwindow->window, $transparent, "gtk/xpm/kge.xpm");

	$box1 = &new GtkVBox(true,1);
	$splashwindow->add($box1);	

    $splashwindow->shape_combine_mask( $mask,0, 0 );
    $pixmapwid=&new GtkPixmap($pixmap, $mask);
    $box1->pack_start($pixmapwid,1);
	
	$lab = &new GtkLabel("Loading...");
    $box1->pack_start($lab,1);//false,true,0);	
	
	$splashwindow->show_all();	

    //echo '>>>>>',$argv[1];
    require("gtk/system/system.gtk.php"); $lab->set_text("Loading ... system!");


    $config = parse_ini_file("./gtk/config.ini",1); $lab->set_text("Parsing ...");
    //echo count($config);


	require("gtk/shell/shell.gtk.php");            $lab->set_text("Loading ... shell!");
	require("gtk/shell/options.gtk.php");          $lab->set_text("Loading ... options!");
	require("gtk/shell/help.gtk.php");             $lab->set_text("Loading ... help!");
	require("gtk/htmlviewer/htmlviewer.gtk.php");  $lab->set_text("Loading ... html viewer!");
	require("gtk/scintilla/scintilla.gtk.php");    $lab->set_text("Loading ... scintilla!");
	require("gtk/editor/dpcedit.gtk.php");         $lab->set_text("Loading ... dpc editor!");
	//require("gtk/webserver/webserver.gtk.php");

	switch ($argv[1]) {
  		case '-bin' : require("gtk/dpcman/binman.gtk.php");  $lab->set_text("Loading ... bin manager!"); 				
        		      break;
				
  		case '-gtk' : require("gtk/dpcman/gtkman.gtk.php");  $lab->set_text("Loading ... gtk manager!");				
        		      break;
				
  		case '-dpc' : require("gtk/dpcman/dpcman.gtk.php");  $lab->set_text("Loading ... dpc manager!"); 				
					  break;
  
 	    default     : require("gtk/dpcman/dpcman.gtk.php");      $lab->set_text("Loading ... dpc manager!");
                	  require("gtk/dpcman/properties.gtk.php");  $lab->set_text("Loading ... properties!");
		              require("gtk/dpcman/schema.gtk.php");	   $lab->set_text("Loading ... schema!");
				      require("gtk/dpcman/prjman.gtk.php");	   $lab->set_text("Loading ... project manager!");			 
                	  //require("gtk/themes/former.gtk.php");	   $lab->set_text("Loading ... form manager!");			
                	  //require("gtk/themes/visualman.gtk.php"); $lab->set_text("Loading ... visual manager!");  
                	  require("gtk/themes/manager.gtk.php");     $lab->set_text("Loading ... theme manager!");
                	  require("gtk/themes/themes.gtk.php");      $lab->set_text("Loading ... themes!");
                	  require("gtk/editor/prjedit.gtk.php");     $lab->set_text("Loading ... project editor!");
                	  require("gtk/editor/secedit.gtk.php");     $lab->set_text("Loading ... security editor!");
                	  require("gtk/editor/locedit.gtk.php");     $lab->set_text("Loading ... locales editor!");	
                	  require("gtk/editor/cssedit.gtk.php");     $lab->set_text("Loading ... css editor!");
                	  require("gtk/editor/codedit.gtk.php");     $lab->set_text("Loading ... code editor!");
                	  require("gtk/mbrowser/mbrowser.gtk.php");  $lab->set_text("Loading ... mbrowser!");
    }
	require("gtk/framework/framework.gtk.php");   $lab->set_text("Loading ... framework!");
	require("gtk/framework/winframe.gtk.php");    $lab->set_text("Loading ... windows frames!");
	require("gtk/fileman/fileman.gtk.php");       $lab->set_text("Loading ... file manager!");
	require("gtk/filedialog/filedialog.gtk.php"); $lab->set_text("Loading ... file dialog!");
	require("gtk/editor/console.gtk.php");        $lab->set_text("Loading ... console!");
	require("gtk/mbox/mbox.gtk.php");             $lab->set_text("Loading ... mbox!");



	$windows = array();  
	$lab->set_text("Starting ..."); 
	$splashwindow->realize();
	sleep(0);

/*
 * Called when the window is being destroyed. Simply quit the main loop.
 */
function destroy()
{
	Gtk::main_quit();
}

function delete_event($window, $event)
{
	$window->hide();
	return true;
}

function destroy_event($widget)
{
	$window = $widget->get_toplevel();
	$window->destroy();
	return true;
}

function close_window($widget)
{
	$window = $widget->get_toplevel();
	$window->hide();
}

function splash() {

	$splashwindow = &new GtkWindow("dialog");//GTK_WINDOW_DIALOG);//GTK_WINDOW_POPUP);


	//hauptfenster($splashwindow,"Moment bitte, KGE wird geladen...",300,200);
	$splashwindow->set_policy(1, 1, 1);
	$splashwindow->set_name('splash window');		
	$splashwindow->set_title('Splash');
	$splashwindow->set_usize(200, 150);
	$splashwindow->set_position(GTK_WIN_POS_CENTER);	
	
	$splashwindow->realize();
    $transparent = $splashwindow->style->white;
    list($pixmap, $mask) = Gdk::pixmap_create_from_xpm($splashwindow->window, $transparent, "gtk/xpm/kge.xpm");

	$box1 = &new GtkVBox(true,1);
	$splashwindow->add($box1);	

    $splashwindow->shape_combine_mask( $mask,0, 0 );
    $pixmapwid=&new GtkPixmap($pixmap, $mask);
    $box1->pack_start($pixmapwid,1);
	
	$lab = &new GtkLabel("Loading...");
    $box1->pack_start($lab,1);//false,true,0);	

	//$hbox = &new GtkHBox(true,1);
	//$splashwindow->add($hbox);
	
    //$splashwindow->hide_all();
	$splashwindow->show_all();
	
	//for ($i=0;$i<5000;$i++) {
	  //echo $i;
	//}
	
    print "\n--ok splash\n";	
	
	//destroy_event($splashwindow);	

}

/* Run the main loop. */
//Gtk::rc_parse(dirname($argv[0]).'/testgtkrc');
//main();

    //$sw =  gdk::screen_width();
    //$sh =  gdk::screen_height();
	
	//$splash = splash();
	//destroy_event($splashwindow);
	
	$window = &new GtkWindow();
	//$window->set_policy(false, false, false);
	$window->set_title('WebOS');
	$window->set_usize(640, 480);
	$window->set_position(GTK_WIN_POS_CENTER);

	$window->connect_object('destroy', array('gtk', 'main_quit'));
	$window->connect_object('delete-event', array('gtk', 'false'));
	
	$shell = &new shell($window);	

	$window->show_all();	
	

Gtk::main();


?>
