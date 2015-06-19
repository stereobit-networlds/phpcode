<?php


class former {

	
	function former($container) {	  	  
	  
       $this->visual_control($container);
	}
	
	
	function new_() {			   				   
	}
	
	function load($pathfile) {			 
	}			
	
	function save($pathfile) {	 
	}		
	
	function visual_control($container) {  
	
       //$this->drawing_area($container);
	   //$this->layout($container);
	   $this->panels($container);
	}	
	
	
	function panels($container) {
	
	   $vbox = &new GtkVBox();
	   $container->add($vbox);	
	   
       $v1 = &new GtkVPaned;
	   $v1->set_border_width(1);	  
	   $v1->set_handle_size(3);		   
	   $vbox->pack_start($v1, true, true, 0);	   
	   
       $v2 = &new GtkVPaned;
	   $v2->set_border_width(1);	
	   $v2->set_handle_size(3);	   
	   $vbox->pack_start($v2, true, true, 0);	   
	   
       $v3 = &new GtkVPaned;
	   $v3->set_border_width(1);	
	   $v3->set_handle_size(3);	   
	   $vbox->pack_start($v3, true, true, 0);		   
	   
       /*$h1 = &new GtkHPaned;
	   $h1->set_border_width(1);	
	   $h1->set_handle_size(3);	   	   	    
	   $v1->pack1($h1, true, true);	
	   
  	      $frame1 = &new GtkFrame;
	      $frame1->show();
	      $frame1->set_shadow_type(GTK_SHADOW_IN);
	      //$frame->set_usize(100, 100);
	      $h1->pack1($frame1,true,true);
		  
  	      $frame2 = &new GtkFrame;
	      $frame2->show();
	      $frame2->set_shadow_type(GTK_SHADOW_IN);
	      //$frame->set_usize(100, 100);
	      $h1->pack2($frame2,true,true);	*/	  	    
	   
	   //$this->splitter($vbox);  
	   //$this->splitter($vbox,0,1);  	   
	}
	
	function splitter($container,$top=1,$bot=1) {
	
        $v1 = &new GtkVPaned;
	    $v1->set_border_width(1);	  
	    $v1->set_handle_size(3);		   
	    $container->pack_start($v1, true, true, 0);		

		if ($top) { 
  	      $frame1 = &new GtkFrame;
	      $frame1->show();
	      $frame1->set_shadow_type(GTK_SHADOW_IN);
	      //$frame->set_usize(100, 100);
	      $v1->pack1($frame1,true,true);	
		}
		
		if ($bot) {
  	      $frame2 = &new GtkFrame;
	      $frame2->show();
	      $frame2->set_shadow_type(GTK_SHADOW_IN);
	      //$frame->set_usize(100, 100);
	      $v1->pack2($frame2,true,true);			
		}  
	}
	
	function layout($container) {
	
       /* create and add the scrolled window to the main window */
	   $scrolledwindow = &new GtkScrolledWindow();
	   $container->add($scrolledwindow);    
	   
	   /* create and add the layout widget to the scrolled window */
	   $layout = &new GtkLayout(null, null);
	   $scrolledwindow->add($layout);    
	   
	   /* set the layout to be bigger than the windows that contain it */
	   $x = gdk::screen_width(); 
	   $y = gdk::screen_height(); 
	   $layout->set_size($x, $y);    
	   
	   /* get the adjustment objects and connect them to the callback.  This   part should not be necessary under *nix systems */
	   $hadj = $scrolledwindow->get_hadjustment();
	   $vadj = $scrolledwindow->get_vadjustment();
	   $hadj->connect('value-changed', array($this,'exposure'), $layout);
	   $vadj->connect('value-changed', array($this,'exposure'), $layout);    
	   
	   /* populate the layout with a mixture of buttons and labels */
	   for ($i=0 ; $i < round($y/100); $i++)  {  
	     for ($j=0 ; $j < round($x/100); $j++)  {    
		   $buf =sprintf('Button %d, %d', $i, $j);    
		   if (($i + $j) % 2) $button = &new GtkButton($buf);    
		                 else $button = &new GtkLabel($buf);    
		   $layout->put($button, $j*100, $i*100);  
		 }
	   }  	
	}	
	
    /* callback that forces a redraw of simple child widgets */
	function exposure($adj, $layout) {  
	
	   //under *nix
	   //$layout->queue_draw();
	   
	   //under win32
       $layout->hide();
       $layout->show();
	   
	}	
	
    function drawing_area($container) {  
	
       $window = &new GtkWindow();
       $window->set_position(GTK_WIN_POS_CENTER);
       $window->connect_object('destroy', array('gtk', 'main_quit'));	
	
       $drawingarea = &new GtkDrawingArea();
       $drawingarea->size(200, 220);
       $drawingarea->set_events(GDK_BUTTON_PRESS_MASK | GDK_BUTTON_RELEASE_MASK);
       $window->add($drawingarea);	
	   
       $drawingarea->realize();
       $style = $drawingarea->style;
       $gdkwindow = $drawingarea->window;	
	   
       $drawingarea->connect('expose-event', array($this,'draw_it'), $style, $gdkwindow);
       $drawingarea->connect('button-press-event', array($this,'press_it'), $style, $gdkwindow);
       $drawingarea->connect('button-release-event', array($this,'redraw_it'));	      
	   
	   $window->show_all();
    }		
	
	
function draw_it($drawingarea, $event, $style, $gdkwindow) {
  /* access the GdkWindow's colormap to associate a color with a GdkGC */
  $colormap = $gdkwindow->colormap;
  $yellow = $gdkwindow->new_gc();
  $yellow->foreground = $colormap->alloc('yellow');
  $red = $gdkwindow->new_gc();
  $red->foreground = $colormap->alloc('red');
  $red->line_width = 7;

  /* set up fonts.  The first font here is set as part of the drawingarea's
     style property so that it will be used in gtk::draw_string(). */
  $font = gdk::font_load('-unknown-Arial-bold-r-normal--*-120-*-*-p-0-iso8859-1');
  $style->font = $font;
  $font2 = gdk::font_load('-unknown-Arial-bold-r-normal--*-720-*-*-p-0-iso8859-1');

  /* call the appropriate drawing functions */
  gdk::draw_rectangle($gdkwindow, $style->white_gc, true, 0, 0, 200, 220);
  gdk::draw_rectangle($gdkwindow, $yellow, true, 50, 50, 100, 100);
  gdk::draw_string($gdkwindow, $font2, $style->white_gc, 75, 130, '?');
  gdk::draw_line($gdkwindow, $red, 20, 20, 180, 180);
  gdk::draw_line($gdkwindow, $red, 20, 180, 180, 20);
  gtk::draw_string($style, $gdkwindow, GTK_STATE_NORMAL, 12, 210, 
                   'SAY       TO SQUARE EGGS!');
  gdk::draw_string($gdkwindow, $font, $red, 42, 210, 'NO');
}

function press_it($drawingarea, $event, $style, $gdkwindow) {
  /* make the drawingarea look like it has been pressed down */
  $rectangle = &new GdkRectangle(0, 0, 200, 220);
  gtk::paint_focus($style, $gdkwindow, $rectangle, $drawingarea, null, 0, 0, 
                    200, 220);
}

function redraw_it($drawingarea, $event) {
  /* trigger a new expose event */
  $drawingarea->queue_draw();
}

/* set up the main window that will hold the drawing area */
//$window = &new GtkWindow();
//$window->set_position(GTK_WIN_POS_CENTER);
//$window->connect_object('destroy', array('gtk', 'main_quit'));

/* set up the drawing area.  Sizing is taken from the parent, unless set. 
   We need to add events so that the drawingarea is sensitive to the mouse,
   using set_events() to do this because the widget is not realized yet. */
//$drawingarea = &new GtkDrawingArea();
//$drawingarea->size(200, 220);
//$drawingarea->set_events(GDK_BUTTON_PRESS_MASK | GDK_BUTTON_RELEASE_MASK);
//$window->add($drawingarea);

/* once the drawing area has been added to the window we can realize() it, 
   which means that we can now access its properties */
//$drawingarea->realize();
//$style = $drawingarea->style;
//$gdkwindow = $drawingarea->window;

/* drawing should always follow an expose event */
//$drawingarea->connect('expose-event', 'draw_it', $style, $gdkwindow);
//$drawingarea->connect('button-press-event', 'press_it', $style, 
//$gdkwindow);
//$drawingarea->connect('button-release-event', 'redraw_it');

//$window->show_all();
	
	
}		
?>
