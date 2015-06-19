<?php

//$__GTK['schema']['schema'] = 'Schema';
//$__GTKXY['schema']['x'] = 200;
//$__GTKXY['schema']['y'] = 300;

require_once("schema.lib.php");

class schema {

    var $basebox;
	var $xpm;
	var $xpm_link;
	var $xpm_obj;
	var $layout;
	var $targets;
	var $tooltips;
	var $selected;
	//var $mod_obj;
	var $changed;
	var $xbox,$ybox;
	
	function schema($container) {	
	  global $mod_obj,$con_obj;
	  global $shell;
	
	  $this->xbox = 20;
	  $this->ybox = 20;
	  $this->changed = false;
	  $mod_obj = null; //IT DOESN'T WORK AS $THIS->mod_obj ?????????'
	  $con_obj = null; //IT DOESN'T WORK AS $THIS->mod_obj ?????????'	  
	  $this->selected = null;
	  $this->tooltips = &new GtkTooltips();
	
	  $this->targets = array(array('text/plain', 0, -1));
			  	  
	   
      $this->xpm = array("16 16 6 1",
						 "       c None s None",
						 ".      c black",
						 "X      c red",
						 "o      c yellow",
						 "O      c #808080",
						 "#      c white",
						 "                ",
						 "       ..       ",
						 "     ..XX.      ",
						 "   ..XXXXX.     ",
						 " ..XXXXXXXX.    ",
						 ".ooXXXXXXXXX.   ",
						 "..ooXXXXXXXXX.  ",
						 ".X.ooXXXXXXXXX. ",
						 ".XX.ooXXXXXX..  ",
						 " .XX.ooXXX..#O  ",
						 "  .XX.oo..##OO. ",
						 "   .XX..##OO..  ",
						 "    .X.#OO..    ",
						 "     ..O..      ",
						 "      ..        ",
						 "                ");	
						 
		$this->xpm_obj  = $shell->xpm_path . "gui_obj.xpm";					 
		$this->xpm_link = $shell->xpm_path . "gui_link.xpm";				    
	   
	    $this->schema_control($container);     
	}
	
	function schema_control(&$container) {
	    global $window;
		
        $window->realize();							   
		//$transparent = $window->style->white;		
        $transparent_color = &new GdkColor(0,0,0);					
					
        $hbox = &new GtkHBox();
		$container->add($hbox);		
		  	
		  
		/*$scrolled_win = &new GtkScrolledWindow();
		$scrolled_win->set_border_width(0);
		$scrolled_win->set_policy(GTK_POLICY_AUTOMATIC, GTK_POLICY_ALWAYS);
		$vbox->pack_start($scrolled_win);
		
		$this->basebox = &new GtkVBox();//Layout();
	    $this->basebox->connect('button-press-event', array($this, 'clickon'),'data');		
		$scrolled_win->add_with_viewport($this->basebox);		*/
		
		
        $schemabox = &new GtkVBox();
		$hbox->add($schemabox);			
		
	    $scroll = &new GtkScrolledWindow();
		$scroll->set_border_width(0);		
	    //$scroll->set_usize(600,420);
	    $schemabox->pack_start($scroll);//, false, false);		
	    //$scroll->set_policy(GTK_POLICY_AUTOMATIC,GTK_POLICY_AUTOMATIC);
		$scroll->set_policy(GTK_POLICY_AUTOMATIC, GTK_POLICY_ALWAYS);		
	    $scroll->show();
		
		$this->layout = &new GtkLayout(null,null);
		$this->layout->set_name('SHELL');			
		
		$newstyle = &new GtkStyle();
		$white = &new GdkColor('#FFFFFF');
		$newstyle->bg[GTK_STATE_NORMAL] = $white;
		$this->layout->set_style($newstyle);		
		$scroll->add($this->layout);
		
		$x = gdk::screen_width();
		$y = gdk::screen_height();
		$this->layout->set_size($x, $y); 
		   
		$hadj = $scroll->get_hadjustment();
		$vadj = $scroll->get_vadjustment();
		$hadj->connect('value-changed', array($this,'exposure'), $this->layout);
		$vadj->connect('value-changed', array($this,'exposure'), $this->layout);
		    
		//layout pre-paint.. (DELETED BY RESET_SCEMA METHOD!!!!!!!)	
		$button_Hero = &new GtkButton();
		$ReliefStyle = "GTK_RELIEF_NONE";
		$button_Hero->set_relief($ReliefStyle);
				
		list ($gdkpixmap, $mask) = Gdk::pixmap_create_from_xpm_d($window->window,$transparent_color,$this->xpm);
		$pixmap = &new GtkPixmap($gdkpixmap, $mask);
		$this->layout->put($pixmap,10,10);
		$pixmap->show();
		
		list ($gdkpixmap, $mask) = Gdk::pixmap_create_from_xpm_d($window->window,$transparent_color,$this->xpm);
		$pixmap = &new GtkPixmap($gdkpixmap, $mask);
		$this->layout->put($pixmap,10,150);
		$pixmap->show();	
		
		
		$button_New = &new GtkButton();
		$this->layout->put($button_New,450,225);
		//$button_New->connect('clicked', 'New_Game');	
		$button_New->show();	
		list ($gdkpixmap, $mask) = Gdk::pixmap_create_from_xpm_d($window->window,$transparent_color,$this->xpm);
		$pixmap = &new GtkPixmap($gdkpixmap, $mask);
		$button_New->add($pixmap);
		$pixmap->show();	
		
		$button_Load = &new GtkButton();
		$this->layout->put($button_Load,450,265);
		//$button_Load->connect('clicked', 'LoadGame2');
		$button_Load->show();	
		list ($gdkpixmap, $mask) = Gdk::pixmap_create_from_xpm_d($window->window,$transparent_color,$this->xpm);
		$pixmap = &new GtkPixmap($gdkpixmap, $mask);
		$button_Load->add($pixmap);
		$pixmap->show();	
		
		$button_Prefer = &new GtkButton();
		$this->layout->put($button_Prefer,450,305);
		//$button_Prefer->connect('clicked', 'not_implemented_yet');
		$button_Prefer->show();	
		list ($gdkpixmap, $mask) = Gdk::pixmap_create_from_xpm_d($window->window,$transparent_color,$this->xpm);
		$pixmap = &new GtkPixmap($gdkpixmap, $mask);
		$button_Prefer->add($pixmap);
		$pixmap->show();	
		
		//general press
	    //$this->layout->connect('button-press-event', array($this, 'on_click'),'data');		
		
		//drag and drop attr for move inside
		$this->layout->connect('drag_data_received', array($this,'dnd_move_received'));
		$this->layout->drag_dest_set(GTK_DEST_DEFAULT_ALL, $this->targets, GDK_ACTION_COPY);		

		//drag and drop attr for add module
		$this->layout->connect('drag_data_received', array($this,'dnd_add_received'));
		$this->layout->drag_dest_set(GTK_DEST_DEFAULT_ALL, $this->targets, GDK_ACTION_COPY);		
				
				
		$this->layout->show_all();	
		
		
	    $separator = &new GtkVSeparator();
	    $hbox->pack_start($separator, false);
	    $separator->show();	
				
		//TOOLBAR
		//box
        $toolbox = &new GtkHBox(false,5);
	    $toolbox->set_border_width(5);		
		$hbox->pack_start($toolbox,false);	
		
	    //hold toolbar 
        $hb = &new GtkHandleBox();
        $hb->set_usize(30,100);
        $hb->set_handle_position(GTK_POS_TOP);	   
        $toolbox->pack_start($hb,false,false); 		
				
		$this->schema_toolbar($hb); //create toolbar
		
		$this->menu(); //create popup menu				 
	}	
	

    function exposure($adj, $layout) {
	
	    $layout->hide();
	    $layout->show();
    }	
	
	function schema_toolbar($container) {
	   global $shell;
	   
	   
	   $counter = 0;
       $toolbar = &new GtkToolBar(GTK_ORIENTATION_VERTICAL, GTK_TOOLBAR_ICONS | GTK_TOOLBAR_TEXT | GTK_TOOLBAR_BOTH);
	  
       //$toolbar->insert_space($counter++);	
	   
       $this->property_tool_button = &new GtkButton();
       $this->property_tool_button->set_usize(25,25);
       $this->property_tool_button->set_relief(GTK_RELIEF_NONE);
       $transparent = $container->style->white;	  
       list($pixmap, $mask) = gdk::pixmap_create_from_xpm($container->window,$transparent,$shell->xpm_path."exit.xpm");
       $px = &new GtkPixmap($pixmap, $mask);
       $this->property_tool_button->add($px);
       //$this->property_tool_button->connect_object('clicked', array($this, 'shell_event'),'properties');	   
	   $this->property_tool_button->connect_object('clicked', array($this, 'on_click_module'),$this->property_tool_button,'properties');	   
       //$this->property_tool_button->show();
	   //drag and drop module for properties view/edit
	   $this->property_tool_button->connect('drag_data_received', array($this,'dnd_properties_received'));
	   $this->property_tool_button->drag_dest_set(GTK_DEST_DEFAULT_ALL, $this->targets, GDK_ACTION_COPY);		
				   	     
	  
       $this->remove_tool_button = &new GtkButton();
       $this->remove_tool_button->set_usize(25,25);
       $this->remove_tool_button->set_relief(GTK_RELIEF_NONE);
       $transparent = $container->style->white;	  
       list($pixmap, $mask) = gdk::pixmap_create_from_xpm($container->window,$transparent,$shell->xpm_path."exit.xpm");
       $px = &new GtkPixmap($pixmap, $mask);
       $this->remove_tool_button->add($px);
       $this->remove_tool_button->connect_object('clicked', array($this, 'on_click_module'),$this->remove_tool_button,'remove_module');
       //$this->remove_tool_button->show();
	   //drag and drop module for removing	   
	   $this->remove_tool_button->connect('drag_data_received', array($this,'dnd_remove_received'));
	   $this->remove_tool_button->drag_dest_set(GTK_DEST_DEFAULT_ALL, $this->targets, GDK_ACTION_COPY);	   
	  
	   //add button  
       $toolbar->set_space_style(GTK_TOOLBAR_SPACE_LINE);
       $toolbar->insert_widget($this->property_tool_button,'Properties','Properties',$counter++);	   
       $toolbar->insert_widget($this->remove_tool_button,'Remove','Remove',$counter++);
       //$toolbar->insert_space(1);		
	  
       $container->add($toolbar);		  	
       //$container->show();	  
	}
	
	//popup menu
	function menu() {
	
       $this->popmenu = &new GtkMenu();
  	   $accel = $this->popmenu->ensure_uline_accel_group();   

       $open = &new GtkMenuItem("Remove");
       $open->lock_accelerators();
       $this->popmenu->append($open);
       $open->connect_object('activate', array($this, 'on_click_module'),$this->remove_tool_button,'remove_module');	   
	   	   
	   
       $save = &new GtkMenuItem("Properties");
       $save->lock_accelerators();
       $this->popmenu->append($save); 
       $save->connect_object('activate', array($this, 'on_click_module'),$this->property_tool_button,'properties');	   
	   
       $separator = &new GtkMenuItem();
       $separator->set_sensitive(false);
       $this->popmenu->append($separator);

       $exit = &new GtkMenuItem("");
       $accel_label = $exit->child;
       $accel_key = $accel_label->parse_uline("E_xit");
       $exit->add_accelerator('activate', $accel, $accel_key, GDK_CONTROL_MASK,GTK_ACCEL_VISIBLE);
       $exit->lock_accelerators();
       $exit->connect_object('activate', array('gtk', 'main_quit'));
	   
       $this->popmenu->append($exit);
	   
       $this->popmenu->show_all();
   
	}		
	
	
	
	//DRUG N' DROP'
	
	//move receive data
	function dnd_move_get($widget, $context, $selection_data, $info, $time) {
	
	        //print_r($widget);
	
			$dnd_string = $widget->get_name();//"Perl is the only language that looks\nthe same before and after RSA encryption";
			$selection_data->set($selection_data->target, 8, $dnd_string);
	}
	

	//drop to layout = move 
	function dnd_move_received($widget, $context, $x, $y, $data, $info, $time)	{
	        global $mod_obj;
	
			if ($data && $data->format == 8) {
	
			    $module = $data->data; //print ">>>>>".$module;					
			    //find children module widget
		        foreach ($this->layout->children() as $num=>$child) {
		          if ($module==$child->get_name()) $this->layout->move($child,$x,$y);
		        }				
		  		//$this->layout->move($this->mod_{$module},1,1);
				//print "Drop data of type " . $data->target->string . " was:$data->data\n";

				$mod_obj[$module]['x'] = $x;
				$mod_obj[$module]['y'] = $y;
				//print_r($mod_obj);
				
				$this->move_connections($module);
				
				$this->changed = true;
		    }		
	}
	
	//drop to module = connect 
	function dnd_connect_received($widget, $context, $x, $y, $data, $info, $time)	{
	        global $mod_obj;
	
			if ($data && $data->format == 8) {
              	$module = $data->data; 
				
				$module1 = $module;
				$module2 = $widget->get_name();
				
				$this->add_connection($module1,$module2,$x,$y);
			    print ">>>>>".$module1.":".$module2."\n";		
		    }		
	}	
	
	//drop to properties button = properties view/edit 
	function dnd_properties_received($widget, $context, $x, $y, $data, $info, $time) {
	        global $shell;
	
			if ($data && $data->format == 8) {
	
			    $module = $data->data; 	
                $shell->event_queue('properties',$module);
		    }		
	}	

	//drop to remove button = module remove 
	function dnd_remove_received($widget, $context, $x, $y, $data, $info, $time) {
	        global $shell;
	
			if ($data && $data->format == 8) {
	
			    $module = $data->data; 	
                $shell->event_queue('remove_module',$module);
				
				$this->changed = true;
		    }	
	}		
	
	//drop to layout (from dpc tree) = module add 
	function dnd_add_received($widget, $context, $x, $y, $data, $info, $time) {
	        global $shell;
	
			if ($data && $data->format == 9) {
	
			    $modules = explode(",",$data->data);
				
				//multiple adding separated by comma
				foreach ($modules as $id=>$module) { 	
                  if ($module) {
				    $shell->event_queue('add_module',$module);
				    //echo $module;
				  }	
				}
				
				$this->changed = true;
		    }		
	}	
	
	
					
	
	//module box
	function add_module($module,$x=10,$y=10,$loading=0) {//echo $module;
	    global $window;
		global $mod_obj;
		
        $window->realize();							   	
        $transparent_color = &new GdkColor(0,0,0);					
		
		$this->layout->freeze();
		
		$this->mod_{$module} = &new GtkButton();
		$this->mod_{$module}->set_name($module);	
        $this->mod_{$module}->set_relief(GTK_RELIEF_NONE);			
		$this->mod_{$module}->set_usize($this->xbox,$this->ybox);		
		$this->tooltips->set_tip($this->mod_{$module}, $module, 'ContextHelp/buttons/1');		
		
		$this->layout->put($this->mod_{$module},$x,$y);
		
		//general press
	    $this->mod_{$module}->connect('button-press-event', array($this, 'on_click'), 'data');
		//properties
        //$this->mod_{$module}->connect_object('clicked', array($this, 'on_click_module'),$this->mod_{$module},'properties');			
		
        //drug and drop get for move
		$this->mod_{$module}->connect('drag_data_get', array($this,'dnd_move_get'));
		$this->mod_{$module}->drag_source_set(GDK_BUTTON1_MASK|GDK_BUTTON3_MASK, $this->targets, GDK_ACTION_COPY);
		
		//drag and drop get for connect
		//$this->mod_{$module}->connect('drag_data_get', array($this,'dnd_connect_get'));
		//$this->mod_{$module}->drag_source_set(GDK_BUTTON1_MASK|GDK_BUTTON3_MASK, $this->targets, GDK_ACTION_COPY);					
				
		//drag and drop attr for connect as received
		$this->mod_{$module}->connect('drag_data_received', array($this,'dnd_connect_received'));
		$this->mod_{$module}->drag_dest_set(GTK_DEST_DEFAULT_ALL, $this->targets, GDK_ACTION_COPY);					
			
				
		$this->mod_{$module}->show();	
		//list ($gdkpixmap, $mask) = Gdk::pixmap_create_from_xpm_d($window->window,$transparent_color,$this->xpm);
		list ($gdkpixmap, $mask) = Gdk::pixmap_create_from_xpm($window->window,$transparent_color,$this->xpm_obj);
		$pixmap = &new GtkPixmap($gdkpixmap, $mask);
		$this->mod_{$module}->add($pixmap);
		$pixmap->show();	
			
		$this->layout->thaw();
		
		//print_r($this->mod_{$module});
		//print_r($this->layout);	
		
		$n = explode(".",$module);
		$attr['widget'] = & $this->mod_{$module};			
		$attr['parent'] = $n[0];
		$attr['name'] = $n[1];
		$attr['x'] = $x;
		$attr['y'] = $y;
		$attr['cto'] = array();
		$attr['cfr'] = array();		
		$mod_obj[$module] = $attr;
			
		if (!$loading) $this->changed = true;					
	}	
	
	function remove_module($module) {
	    global $mod_obj;
		
		//remove connection first
		$this->remove_connections($module);		
		
		//remove module itself
		$this->layout->freeze();	
		foreach ($this->layout->children() as $id=>$child) {
		   if ($module==$child->get_name()) $this->layout->remove($child);
		}			
		$this->layout->thaw();		
		
		foreach ($mod_obj as $id=>$child) {
		   if ($module==$id) $mod_obj[$id] = 'x';
		}	
		
		$this->changed = true;			
	}	
	
	function on_click_module($button,$param) {
	  global $shell;
	  
	  $module_name = $button->get_name();	  
	  $this->selected = $module_name;
	  //echo $this->selected;	  
			  
	  $shell->event_queue($param,$module_name);
	}	
			
	
	
	//connection box
	function add_connection($module1,$module2,$x=0,$y=0,$loading=0) {//echo $module;
	    global $window;
		global $mod_obj, $con_obj;
		
        $window->realize();							   		
		
		//print_r($mod_obj[$module1]);
		//print_r($mod_obj[$module1]);	
		
		//if there is a between connection don't re-draw connection box'
		if ( (($con_obj[$module1 .'_'.$module2]) && ($con_obj[$module1 .'_'.$module2]!='x')) || //one way connection
		     (($con_obj[$module2 .'_'.$module1]) && ($con_obj[$module2 .'_'.$module1]!='x')) ) { //.. oposite
			 
           $nAnswer = MessageBox( "Link already exist !", "Error", MB_OK + MB_ICONSTOP + MB_DEFBUTTON1 + MB_CENTER);	 
			 
		}
		else {	//draw..

		  $points = compute_line($mod_obj[$module1]['x'],
		                         $mod_obj[$module1]['y'],
				  			     $mod_obj[$module2]['x'],
							     $mod_obj[$module2]['y'],$this->xbox,$this->ybox);
		
          $transparent_color = &new GdkColor(0,0,0);					
		
		  $this->layout->freeze();
		
		  $con_name = $module1 .'_'.$module2;	
				
		  $this->con_name = &new GtkButton();
		  $this->con_name->set_name($con_name);
          $this->con_name->set_relief(GTK_RELIEF_NONE);				
		  $this->con_name->set_usize($points['xm'],$points['ym']);		
		  //$this->tooltips->set_tip($this->con_name, $this->con_name, 'ContextHelp/buttons/1');		
		  $this->layout->put($this->con_name,$points['x'],$points['y']);
		
		  //button press
	      //$this->con_name->connect('button-press-event', array($this, 'on_click'), 'data');
          $this->con_name->connect_object('clicked', array($this, 'on_click_connection'),$this->con_name,'properties');			
						
				
		  $this->con_name->show();	
		  list ($gdkpixmap, $mask) = Gdk::pixmap_create_from_xpm($window->window,$transparent_color,$this->xpm_link);
		  $pixmap = &new GtkPixmap($gdkpixmap, $mask);
		  $this->con_name->add($pixmap);
		  $pixmap->show();	
			
		  $this->layout->thaw();	
		}//.............just update con_obj	
			
		
		//if you try to re-connect an already connected object ..don't 	
		if (($con_obj[$module1 .'_'.$module2]) && ($con_obj[$module1 .'_'.$module2]!='x')) {
		}
		else { //ok
		  //connection attributes
		  $con_obj[$con_name]['widget'] = & $this->con_name;		
		  $con_obj[$con_name]['x'] = $points['x'];
		  $con_obj[$con_name]['y'] = $points['y'];			
		  $con_obj[$con_name]['xm'] = $points['xm'];
		  $con_obj[$con_name]['ym'] = $points['ym'];			
		
		  //$con_obj[$con_name]['connections'][$module1] = $module2;		
		
		  //module attributes
		  $mod_obj[$module1]['cto'][$module2] = $module2;
		  $mod_obj[$module2]['cfr'][$module1] = $module1;
		}		
		//print_r($mod_obj);	
		//print_r($con_obj);	
		
   		if (!$loading) $this->changed=true;	
	}	
	
	function move_connections($ofmodule) {
	    global $mod_obj,$con_obj;
		
		$this->layout->freeze();		

		//move connections to
		foreach ($mod_obj[$ofmodule]['cto'] as $num=>$module_to) {
		  
		  if (($module_to) && ($module_to!='x')) {
		  	$con_name = $ofmodule .'_'.$module_to;
			//echo $con_name;
			
		    $points = compute_line($mod_obj[$ofmodule]['x'],
		                           $mod_obj[$ofmodule]['y'],
							       $mod_obj[$module_to]['x'],
							       $mod_obj[$module_to]['y'],$this->xbox,$this->ybox);	
			//echo $con_name;					   
			//print_r($points);					   
				
			$this->con_name = $con_obj[$con_name]['widget'];
		    $this->con_name->set_usize($points['xm'],$points['ym']);			
		    $this->layout->move($this->con_name,$points['x'],$points['y']);								   		
			
		    $con_obj[$con_name]['x'] = $points['x'];
		    $con_obj[$con_name]['y'] = $points['y'];			
		    $con_obj[$con_name]['xm'] = $points['xm'];
		    $con_obj[$con_name]['ym'] = $points['ym'];	
		  }
		}
		//move connections from
		foreach ($mod_obj[$ofmodule]['cfr'] as $num=>$module_from) {
		
		  if (($module_from) && ($module_from!='x')) {  
		  	$con_name = $module_from .'_'.$ofmodule;
			//echo $con_name;
			
		    $points = compute_line($mod_obj[$module_from]['x'],
		                           $mod_obj[$module_from]['y'],
							       $mod_obj[$ofmodule]['x'],
							       $mod_obj[$ofmodule]['y'],$this->xbox,$this->ybox);	
			//echo $con_name;									   
			//print_r($points);					   
								
			$this->con_name = $con_obj[$con_name]['widget'];								   
		    $this->con_name->set_usize($points['xm'],$points['ym']);			
		    $this->layout->move($this->con_name,$points['x'],$points['y']);									   					
			
		    $con_obj[$con_name]['x'] = $points['x'];
		    $con_obj[$con_name]['y'] = $points['y'];			
		    $con_obj[$con_name]['xm'] = $points['xm'];
		    $con_obj[$con_name]['ym'] = $points['ym'];	
	      }
		}	
		
		$this->layout->thaw();				
	}	
	
	function remove_connections($ofmodule) {
	    global $mod_obj,$con_obj;
		
		$this->layout->freeze();		
	    
		//delete connections to
		foreach ($mod_obj[$ofmodule]['cto'] as $num=>$module_to) {
		  
		  if ($module_to) {
		  	$con_name = $ofmodule .'_'.$module_to;
			//echo $con_name;
			
			//delete from gtk					
		    foreach ($this->layout->children() as $id=>$child) {
		      if ($con_name==$child->get_name()) $this->layout->remove($child);
		    }								   		
			//delete from con array			
		    $con_obj[$con_name] = 'x';	
			//delete from objects link arrays			
			$mod_obj[$module_to]['cfr'][$ofmodule] = 'x';
		  }
		}
		//delete connections from
		foreach ($mod_obj[$ofmodule]['cfr'] as $num=>$module_from) {
		
		  if ($module_from) {  
		  	$con_name = $module_from .'_'.$ofmodule;
			//echo $con_name;
			
			//delete from gtk					
		    foreach ($this->layout->children() as $id=>$child) {
		      if ($con_name==$child->get_name()) $this->layout->remove($child);
		    }									   					
			//delete from con array
		    $con_obj[$con_name] = 'x';
			//delete from objects link arrays
			$mod_obj[$module_from]['cto'][$ofmodule] = 'x';
	      }
		}	
		
		$this->layout->thaw();
		
	    $this->changed=true;				
	}	
	
	function on_click_connection($button,$param) {
	  global $shell;
	  global $mod_obj,$con_obj;
	  
	  $con_name = $button->get_name();	  
  
      print_r($con_obj);
	}		
	
	
	function on_click($widget, $event, $data) {
	    global $window;
		global $mod_obj;
		
		$module_name = $widget->get_name();
		$this->selected = $module_name;
		//echo $this->selected;		
	
        //update (=copy properties) widget name of toolbar buttons, then a click do the task
        $this->property_tool_button->set_name($module_name);		
        $this->remove_tool_button->set_name($module_name);	
	
        switch($event->button) {
		  case 1:/* do something appropriate to a left click */
		         //print_r($mod_obj);
		         echo 1;					 
		         break;
		  case 2:/* do something appropriate to a middle click */
		         echo 2;
				 //$style = &new GtkStyle();
				 //gtk::draw_vline($style,$window, GTK_STATE_NORMAL ,10,10,10);
		         break;
		  case 3:/* do something appropriate to a right click */
		         echo 3;
				 //popup menu
                 $this->popmenu->popup(null, null, null, $event->button, $event->time);				 
		         break;
	    }
	}
	
	
	
	
	function reset_schema() {
	    global $mod_obj,$con_obj;
		
		$this->layout->freeze();		
		foreach ($this->layout->children() as $num=>$child) {
		   $this->layout->remove($child);
		}	
		$this->layout->thaw();			
		
		$mod_obj = null;		
		$con_obj = null;
	}	
	
	function rebuild_schema($modules,$connections) {
	    global $mod_obj,$con_obj;
	
	    //print_r($modules);
	    //print_r($connections);	
		
	    $y=30;	
		foreach ($modules as $mod=>$data) {
		
		   if (($data['x']) && ($data['y'])) {
		     $x = $data['x']; 
			 $y = $data['y'];
		   }
		   else {
			 $x = 10;
			 $y+= 30;		   
		   }
		   
           $this->add_module($mod,$x,$y,1);		
		}	
		
		foreach ($connections as $con=>$data) {
		
		   $module = explode("_",$con);
		
           if (($data) && ($data!='x'))
		     $this->add_connection($module[0],$module[1],null,null,1);		
		}		
	}
	
	
	
	function new_() {
	
	    $this->reset_schema();
		
	}
	
	function load($prjpath) {
	    global $shell;	
		global $mod_obj, $con_obj;			
	
	    $this->reset_schema();
	
	    $file = $prjpath . "\schema.shm"; //echo $file;
		
	    //read file
        if ($fp = fopen ($file , "r")) {
                   $data = fread ($fp, filesize($file));
                   fclose ($fp);
				   
				   //echo $data;
				   $part = explode("<@@@@@>",$data);
				   //print_r($part);	
				   
		           $this->rebuild_schema(unserialize($part[1]),unserialize($part[2]));					   
				   
   		           $shell->set_console_message("Schema loaded.");			   
	    }
	    else {
		           $shell->set_console_message("Schema NOT loaded !!!");		
		}	
	
   	/*	$loaded = explode("\n",$part[0]);//file($file);
		//print_r($loaded);

		if (is_array($loaded)) {
		
		  $y=30;		
	      foreach ($loaded as $line=>$dpc) {	//echo $dpc;	  	
		    
			if (trim($dpc)!="") {
			  $attr = explode(",",trim($dpc)); //print_r($attr);
			
			  if (($attr[1]) && ($attr[2])) {
			    $x = $attr[1];
				$y = $attr[2];
			  }	
			  else {
			    $x = 10;
				$y+= 30;
			  }		  
 		      //$this->add_module($attr[0],$x,$y,1);			  
			  
			}  
		  }
          $shell->set_console_message("Schema loaded.");		  
		}
		else
		  $shell->set_console_message("Schema NOT loaded !!!");		*/
		  			  
	}	
	
	
	function save($prjpath) {
	    global $shell;
		global $mod_obj, $con_obj;	
		
		//print_r($mod_obj);
		
		foreach ($mod_obj as $id=>$attr) {
		   $out .= $id . "," . $attr['x'] . "," . $attr['y'] . "\n";
		   //print_r($attr);
		}		
		$out .= "<@@@@@>";	
		$out .= serialize($mod_obj);		
		$out .= "<@@@@@>";	
		$out .= serialize($con_obj);
				       
	    //save file
	    $file = $prjpath . "\schema.shm";
	
        if ($fp = fopen ($file , "w")) {
                   fwrite ($fp, $out);
                   fclose ($fp);
				   
		           $shell->set_console_message("Schema file saved.");	
				   $this->changed=false;
				   			   
				   return (true);
	    }
	    else {
		           $shell->set_console_message("Schema NOT saved !!!");		
				   return (false);
		}		
	}
	
	function exit_() {
	    global $shell;
			
	    if ($this->changed==true) {
		
          $nAnswer = MessageBox( "Project not saved. Save project ?", "Save", MB_YESNO + MB_ICONQUESTION + MB_DEFBUTTON2 + MB_CENTER);
	   
          if( $nAnswer == IDYES) {
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
	
	function free() {
	   global $mod_obj,$con_obj;
	
	   unset($mod_obj);
	   unset($con_obj);	   
	   unset($this->selected);
	}
}	
		
?>
