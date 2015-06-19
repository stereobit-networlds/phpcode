<?php

//$__GTK['shell']['shell'] = 'Shell'; 

class shell {

    var $console;
	var $dpcmanager;
	var $codemanager;
	var $prjmanager;
	var $gtkmanager;	
	var $dpceditor;
	var $prjeditor;
	var $framework;
	var $winframe;
	var $scintilla;
	var $htmlviewer;
	var $mbrowser;
	var $help;
	var $options;
	
	var $app_path;
	var $prj_path;
	var $dpc_path;
	var $gtk_path;
	var $bin_path;
	var $xpm_path;
	var $project_name;	
	//var $setini;
	
	var $menubar;
	
	var $arg1;

    function shell(&$container,$style=0) {
       global $__GTK;	
	   global $argc,$argv;
	   global $config;
	   global $setini;
	   
	   $this->arg1 = $argv[1]; //get cmd param
	   
       //$config = parse_ini_file("./gtk/config.ini",1);//echo count($config); //moved to start.gtk
	   //print_r($config);   
	   
	   if (count($config)>1) {
	     $this->app_path = paramload('INSTALL','APPDIR');//echo $this->app_path,'>>>';//"c:\webos"; 
	     $this->gtk_path = $this->app_path . paramload('INSTALL','GTKDIR');//"\gtk\\";
         $this->bin_path = $this->app_path . paramload('INSTALL','BINDIR');//"\bin\\";	   
	     $this->prj_path = $this->app_path . paramload('INSTALL','PRJDIR');//"\projects\\";
         $this->dpc_path = $this->app_path . paramload('INSTALL','DPCDIR');//"\dpc\\";		   
         $this->xpm_path = $this->app_path . paramload('INSTALL','XPMDIR');//"\dpc\\";			 
		 
   	     $ini="Ok";	
	   }	
	   else {
	     $ini="Error!!!!!!";	   
	   }
	   
	   $setini = $this->iniread();	 //IT DOESN'T WORK AS $THIS->SETINI ?????????'  
	    
   	   $this->project_name = null;   

	   $vbox = &new GtkVBox();
	   $container->add($vbox); 
	   
	   //$id = &new GtkInputDialog();
	   //$r = &new GtkHRuler();
	   //$vbox->pack_start($r,false);
	   //$r->show();
	   
	   //status bar
       /* add the statusbar first, else connecting other widgets to it is messy */
	   $status_on = $setini[1];
	   if ($status_on) {
	   
         $this->status = &new GtkStatusbar();
         $stuff = array('Here we go...', 'lower case alpha', 'UPPER CASE ALPHA', 'numeric', 'return', 'spacebar', 'non-alphanumeric');
         $this->status->push($this->status->get_context_id($stuff[0]), $stuff[0]);
         $vbox->pack_end($this->status, false);
         $this->status->show();	    
	   }
	    
       //holds menu
	   $vmbox = &new GtkVBox(false, 5);
	   $vmbox->set_border_width(0);
	   $vbox->pack_start($vmbox, false);

       $separator = &new GtkHSeparator();
	   $vbox->pack_start($separator, false);	
	   
	   $toolbars_on = $setini[2];
	   if ($toolbars_on) {
	   
	     //hold main menu toolbar 
         $this->main_t = &new GtkHandleBox();
         $this->main_t->set_usize(500,30);
         $this->main_t->set_handle_position(GTK_POS_LEFT);	   
         $vbox->pack_start($this->main_t,false,false); 	      

	     //hold view toolbar 
         $this->view_t = &new GtkHandleBox();
         $this->view_t->set_usize(500,30);
         $this->view_t->set_handle_position(GTK_POS_LEFT);	      
         $vbox->pack_start($this->view_t,false,false);
			   	   
	   }    
  	   
	   $this->winframe = &new winframe;	
	   	   
       $this->panel($vbox,$style);	  	   

       $this->setmenu($vmbox,$style,$toolbars_on);		  
	   
	   $this->event_queue("Initialize...",$ini);	//echo $ini,">>>>";	   

    }	
	
	function panel($container,$style=0) {
	  global $setini;
	
      $vpaned = &new GtkVPaned;
	  $container->pack_start($vpaned, true, true, 0);
	  
	  $vpaned->set_border_width(0);

  	  $hpaned = &new GtkHPaned;
	  $vpaned->add1($hpaned);
	  
	  //add scintilla
 	  $this->scintilla = new scintilla;	  
	  
	  switch ($this->arg1) {	
	     case '-bin' :   	
	     case '-gtk' :
		 case '-dpc' : 	$this->help = new help;  
						break;	 
	   	 default     : 	if (!$this->winframe->Themes) //load as hide-show win page 
		                     $this->winframe->add_winframe('themes','Themes',400,300,0,1);	
	                    if (!$this->winframe->Properties) //load as hide-show win page 
	                         $this->winframe->add_winframe('properties','Properties',300,400,0,1);//,"POPUP");		      		   						  
						$this->mbrowser = new mbrowser;  
						$this->help = new help;  
						$this->options = new options;  
	  }	  
	  
	  if (!$style) {	
  	    $frame = &new GtkFrame;
	    $frame->show();
	    $frame->set_shadow_type(GTK_SHADOW_IN);
	    $frame->set_usize(160, 360);
	    $hpaned->add1($frame);

		switch ($this->arg1) {
          case '-bin' : $this->dpcmanager = &new bin_manager($frame,$this->bin_path,0); break;		
          case '-gtk' : $this->dpcmanager = &new gtk_manager($frame,$this->gtk_path,0); break;
 	      case '-dpc' : 
					    $treebox = &new GtkVBox();
	                    $frame->add($treebox); 
						$this->dpcmanager = &new dpc_manager($treebox,$this->dpc_path,0);
						$this->codemanager = &new dpc_code($treebox);
		                break;  
		  default     : $treebox = &new GtkVBox();
	                    $frame->add($treebox); 
		                $this->dpcmanager = &new dpc_manager($treebox,$this->dpc_path,0);	
						$this->prjmanager = &new prj_manager($treebox,$this->prj_path,0);	
		}

      }
	  else {
		switch ($this->arg1) {
          case '-bin' : $this->dpcmanager = &new bin_manager(null,$this->bin_path,0); break;		
          case '-gtk' : $this->dpcmanager = &new gtk_manager(null,$this->gtk_path,0); break;
 	      case '-dpc' : 
						$treebox = &new GtkVBox();
	                    $frame->add($treebox); 
						$this->dpcmanager = &new dpc_manager($treebox,$this->dpc_path,0);
						$this->codemanager = &new dpc_code($treebox);
		                break;
		  default     : $treebox = &new GtkVBox();
	                    $frame->add($treebox); 
		                $this->dpcmanager = &new dpc_manager(null,$this->dpc_path,0);
						$this->prjmanager = &new prj_manager(null,$this->prj_path,0);	
		}		   	  
	  }
	  
  	  $frame = &new GtkFrame;
	  $frame->show();
	  $frame->set_shadow_type(GTK_SHADOW_IN);
	  $frame->set_usize(60, 60);
	  $hpaned->add2($frame);
		  
	  $this->framework = &new framework($frame);//,'prj_editor,dpc_editor','A,B');
	  //$this->framework->add_frame('prj_editor','Project Editor');
	  //$this->framework->add_frame('dpc_editor','Dpc Editor');	  

      //console frame	  
	  $console_on = $setini[0];	
	  if ($console_on) {
        $frame = &new GtkFrame;
	    $frame->show();
	    $frame->set_shadow_type(GTK_SHADOW_IN);
	    $frame->set_usize(60, 80);
	    $vpaned->add2($frame);
	
        $this->console = &new console($frame);	
      }
	}	
	
	function setmenu($container,$style=0,$toolbars_on=0) {
	
       $this->menubar = &new GtkMenuBar();
	   $container->pack_start($this->menubar, false, false, 0); 	   
	   
	   $this->menu($this->menubar,1,$this->main_t,$toolbars_on);	//file menu
       $this->scintilla->menu($this->menubar);	//edit menu  
	   $this->view_menu($this->menubar,1,$this->view_t,$toolbars_on); //view menu 
	   if (!$style) $this->dpcmanager->menu($this->menubar,$toolbars_on);
	   
	   switch ($this->arg1) {	
	     case '-bin' :   	
	     case '-gtk' :
		 case '-dpc' : 
		               $this->help->menu($this->menubar); 
		               break;
	     default     : 
		               $this->prmenu($this->menubar,1,$this->main_t,0);	
					   $this->options->menu($this->menubar); 
					   $this->help->menu($this->menubar);   
	   }
	}
	
	function menu($container1,$menu_on=0,$container2=null,$toolbar_on=0) {
	   global $window;
	   
       $window->realize();							      	 
	    	        
	   if ($menu_on) {
	     $header1 = &new GtkMenuItem("File");	
	     $filemenu = &new GtkMenu();	   
	   }	 
	   
	   if ($toolbar_on) 
         $toolbar = &new GtkToolBar(GTK_ORIENTATION_HORIZONTAL, GTK_TOOLBAR_ICONS | GTK_TOOLBAR_TEXT | GTK_TOOLBAR_BOTH);
	  	  	     
	   
	   if ($menu_on) {	   
	     $neo = &new GtkMenuItem("New");
	    /* switch ($this->arg1) {
	       case '-bin' : $neo->connect_object("activate", array($this, "event_queue"),"newdpc"); break;	   
	       case '-gtk' : $neo->connect_object("activate", array($this, "event_queue"),"newdpc"); break;
	       case '-dpc' : $neo->connect_object("activate", array($this, "event_queue"),"newdpc"); break;		 
 	       default     : $neo->connect_object("activate", array($this, "event_queue"),"wizard");
	     }*/
		 //smart new
	     $neo->connect_object("activate", array($this, "event_queue"),"snew");			 
	     $filemenu->append($neo); 	
	   }
	   if ($toolbar_on) {
         $tneo = &new GtkButton();
         $tneo->set_usize(25,25);
         $tneo->set_relief(GTK_RELIEF_NONE);
         $transparent = $window->style->white;	  
         list($pixmap, $mask) = gdk::pixmap_create_from_xpm($window->window,$transparent,$this->xpm_path."new.xpm");
         $px = &new GtkPixmap($pixmap, $mask);
         $tneo->add($px);		
	     /*switch ($this->arg1) {
	       case '-bin' : $tneo->connect_object('clicked', array($this, "event_queue"),"newdpc"); break;	   
	       case '-gtk' : $tneo->connect_object('clicked', array($this, "event_queue"),"newdpc"); break;
	       case '-dpc' : $tneo->connect_object('clicked', array($this, "event_queue"),"newdpc"); break;		 
 	       default     : $tneo->connect_object('clicked', array($this, "event_queue"),"wizard");
	     }*/
		 //smart new
	     $tneo->connect_object("clicked", array($this, "event_queue"),"snew");			 
	     //add button  
         $toolbar->set_space_style(GTK_TOOLBAR_SPACE_LINE);
         $toolbar->insert_widget($tneo,'New','New',0);	 	   
	   }   
	    
	   if ($menu_on) {			  
	     $open = &new GtkMenuItem("Open");
	     $open->connect_object("activate", array($this, "event_queue"),"open");	   
	     $filemenu->append($open);
	   }   
	   if ($toolbar_on) {
         $topen = &new GtkButton();
         $topen->set_usize(25,25);
         $topen->set_relief(GTK_RELIEF_NONE);
         $transparent = $window->style->white;	  
         list($pixmap, $mask) = gdk::pixmap_create_from_xpm($window->window,$transparent,$this->xpm_path."open.xpm");
         $px = &new GtkPixmap($pixmap, $mask);
         $topen->add($px);
         $topen->connect_object('clicked', array($this, 'event_queue'),'open');
	     //add button  
         $toolbar->set_space_style(GTK_TOOLBAR_SPACE_LINE);
         $toolbar->insert_widget($topen,'Open','Open',1);		   
	   }	    
	   
	   if ($menu_on) {		   
	     $save = &new GtkMenuItem("Save");
	     $save->connect_object("activate", array($this, "event_queue"),"save");	   
	     $filemenu->append($save); 	
	   }
	   if ($toolbar_on) {
         $tsave = &new GtkButton();
         $tsave->set_usize(25,25);
         $tsave->set_relief(GTK_RELIEF_NONE);
         $transparent = $window->style->white;	  
         list($pixmap, $mask) = gdk::pixmap_create_from_xpm($window->window,$transparent,$this->xpm_path."save.xpm");
         $px = &new GtkPixmap($pixmap, $mask);
         $tsave->add($px);
         $tsave->connect_object('clicked', array($this, 'event_queue'),'save');
	     //add button  
         $toolbar->set_space_style(GTK_TOOLBAR_SPACE_LINE);
         $toolbar->insert_widget($tsave,'Save','Save',2);	   
	   }
	  
	   if ($menu_on) {		   	   
	     $saveas = &new GtkMenuItem("Save As ...");
	     $saveas->connect_object("activate", array($this, "event_queue"),"saveas");	   
	     $filemenu->append($saveas); 
	   }	     
	   if ($toolbar_on) {
         $tsaveas = &new GtkButton();
         $tsaveas->set_usize(25,25);
         $tsaveas->set_relief(GTK_RELIEF_NONE);
         $transparent = $window->style->white;	  
         list($pixmap, $mask) = gdk::pixmap_create_from_xpm($window->window,$transparent,$this->xpm_path."saveas.xpm");
         $px = &new GtkPixmap($pixmap, $mask);
         $tsaveas->add($px);
         $tsaveas->connect_object('clicked', array($this, 'event_queue'),'saveas');
	     //add button  
         $toolbar->set_space_style(GTK_TOOLBAR_SPACE_LINE);
         $toolbar->insert_widget($tsaveas,'Save As..','SaveAs',3);	   
	   }
	   
	   if ($menu_on) {		   	   
	     $close = &new GtkMenuItem("Close");
	     $close->connect_object("activate", array($this, "event_queue"),"close");	   
	     $filemenu->append($close);	 
	   }
	   if ($toolbar_on) {
         $tclose = &new GtkButton();
         $tclose->set_usize(25,25);
         $tclose->set_relief(GTK_RELIEF_NONE);
         $transparent = $window->style->white;	  
         list($pixmap, $mask) = gdk::pixmap_create_from_xpm($window->window,$transparent,$this->xpm_path."close.xpm");
         $px = &new GtkPixmap($pixmap, $mask);
         $tclose->add($px);
         $tclose->connect_object('clicked', array($this, 'event_queue'),'close');
	     //add button  
         $toolbar->set_space_style(GTK_TOOLBAR_SPACE_LINE);
         $toolbar->insert_widget($tclose,'Close','Close',4);	   
	   }	   
	   
   	   if ($menu_on) {	
	     //recent submenu
	     switch ($this->arg1) {
	       case '-bin' : break;	   
	       case '-gtk' : break;
	       case '-dpc' : break;		 
 	       default     : $this->recent_submenu($filemenu);    	   
	     }
	   	 
	   	   
	     $separator = &new GtkMenuItem();
	     $separator->set_sensitive(false);
	     $filemenu->append($separator);
	   }	 
	   
	   if ($toolbar_on) {
         $toolbar->insert_space(5);		   
	   }		   
	   
	   if ($menu_on) {		   
	     $exit = &new GtkMenuItem("Exit");
	     $exit->connect_object("activate", array($this, "event_queue"),"sexit"); //exitprj
	     $filemenu->append($exit); 
	   }
	   if ($toolbar_on) {
         $texit = &new GtkButton();
         $texit->set_usize(25,25);
         $texit->set_relief(GTK_RELIEF_NONE);
         $transparent = $window->style->white;	  
         list($pixmap, $mask) = gdk::pixmap_create_from_xpm($window->window,$transparent,$this->xpm_path."exit.xpm");
         $px = &new GtkPixmap($pixmap, $mask);
         $texit->add($px);
         $texit->connect_object('clicked', array($this, 'event_queue'),'sexit');
	     //add button  
         $toolbar->set_space_style(GTK_TOOLBAR_SPACE_LINE);
         $toolbar->insert_widget($texit,'Exit','Exit',6);		   
	   }	   
	      
	   if ($menu_on) {	
	     $header1->set_submenu($filemenu);	
	     $container1->append($header1);	
	   }	 
	   
	   if ($toolbar_on) {
         $container2->add($toolbar);	     
	   }	   
	}  

	function prmenu($container,$menu_on=0,$container2=null,$toolbar_on=0) {
	   global $window;
	   
       $window->realize();		

	   if ($menu_on) 
	     $header3 = &new GtkMenuItem("Project");
		 
	   if ($toolbar_on) 
         $toolbar = &new GtkToolBar(GTK_ORIENTATION_HORIZONTAL, GTK_TOOLBAR_ICONS | GTK_TOOLBAR_TEXT | GTK_TOOLBAR_BOTH);
	  	  		 
	   
   	   if ($menu_on) {	
	     $projmenu = &new GtkMenu();	//run executing this->run = load parameters at run   
	     $run = &new GtkMenuItem("Run");
	     $run->connect_object("activate", array($this, "event_queue"),"run");	   
	     $projmenu->append($run);	 	   
	   }	
	   if ($toolbar_on) {
         $tprojmenu = &new GtkButton();
         $tprojmenu->set_usize(25,25);
         $tprojmenu->set_relief(GTK_RELIEF_NONE);
         $transparent = $window->style->white;	  
         list($pixmap, $mask) = gdk::pixmap_create_from_xpm($window->window,$transparent,$this->xpm_path."close.xpm");
         $px = &new GtkPixmap($pixmap, $mask);
         $tprojmenu->add($px);
         $tprojmenu->connect_object('clicked', array($this, 'event_queue'),'run');
	     //add button  
         $toolbar->set_space_style(GTK_TOOLBAR_SPACE_LINE);
         $toolbar->insert_widget($tprojmenu,'Run','Run',4);	   
	   }		    
	   	
	   $this->mbrowser->menu($projmenu,$menu_on); //run menu at mbrowser no valid params
	   
   	   if ($menu_on) {	
	     $sep = &new GtkMenuItem();	      
	     $projmenu->append($sep);	   
       }
	   	
       //replace direct call to properties from shell
       $this->winframe->Properties->menu($projmenu,$menu_on);
	   
   	   if ($menu_on) {	
	     $header3->set_submenu($projmenu);
	     $container->append($header3);	   	   
	   }	
	 
	   if ($toolbar_on) {
         $container2->add($toolbar);	     
	   }      
	}
	
	
	function recent_submenu($container) {

	   $header3 = &new GtkMenuItem("Recent");
	   
	   $recmenu = &new GtkMenu();	//run executing this->run = load parameters at run    	      
	   
       $recentfiles = $this->gtk_path . "recfiles.txt";	 // echo $recentfiles; 
	   if (file_exists($recentfiles)) {
	   
   		  $reclist = array_reverse(file($recentfiles));

		  if (is_array($reclist)) { //print_r($reclist);
		
	        foreach ($reclist as $num=>$file) {	
			  
			  if ($file) { 
	            $fl = &new GtkMenuItem(trim($file));
	            $fl->connect_object("activate", array($this, "event_queue"),"readprj",trim($file));	   
	            $recmenu->append($fl);	 				  	
		      }
		    }
		  
            $this->set_console_message("Recent file list loaded.");		  
		  }
		  else
		    $this->set_console_message("recent file list NOT loaded !!!");		   
	     
	   }
	   
	   $sep = &new GtkMenuItem();	      
	   $recmenu->append($sep);		
	   
       $cl = &new GtkMenuItem("Clear List");
	   $cl->connect_object("activate", array($this, "clear_recent_files"));	   
	   $recmenu->append($cl);		      


	   $header3->set_submenu($recmenu);
	   	   
	   $container->append($header3);	   	   
	}	
	
	function view_submenu($container1,$menu_on=0) {

	   if ($menu_on) {
    	 $header0 = &new GtkMenuItem("Toolbar");
	     $view2menu = &new GtkMenu();	
		 
		 
		 $con = &new GtkMenuItem("Console");
	     $con->connect("activate", array($this,'setini'),0);	   
	     $view2menu->append($con);			   		 		   		 
		 
		 $sb = &new GtkMenuItem("Statusbar");
	     $sb->connect("activate", array($this,'setini'),1);	   
	     $view2menu->append($sb);		 

		 $tb = &new GtkMenuItem("Toolbars");
	     $tb->connect("activate", array($this,'setini'),2);	   
	     $view2menu->append($tb);			 		 
		  
   	     $header0->set_submenu($view2menu);	   
	     $container1->add($header0);			 
	   }		
	}
	
	function view_menu($container1,$menu_on=0,$container2=null,$toolbar_on=0) {
       global $__GTK;
	   global $__GTKXY;
	   global $window;
	   
       $window->realize();	
	   
	   $counter = 0;
	   
	   if ($menu_on) {
    	 $header0 = &new GtkMenuItem("View");
	     $viewmenu = &new GtkMenu();	
		 
		 //submenu
         $this->view_submenu($viewmenu,$menu_on);	   		 		   		 
		 
	     $separator = &new GtkMenuItem();
	     $separator->set_sensitive(false);
	     $viewmenu->append($separator);	 
		 
		  
	     //$viewmenu->set_submenu($header1);		 
	   }	 
	   
	   if ($toolbar_on)
         $toolbar = &new GtkToolBar(GTK_ORIENTATION_HORIZONTAL, GTK_TOOLBAR_ICONS | GTK_TOOLBAR_TEXT | GTK_TOOLBAR_BOTH);
	  	   
	
	   ksort($__GTK);
       foreach ($__GTK as $class => $command) {
	     foreach ($command as $function => $title) {
		   $x = $__GTKXY[$function]['x'];
		   $y = $__GTKXY[$function]['y'];
	
	       if ($menu_on) {
	         $vm = &new GtkMenuItem($title);
	         if (($x) && ($y)) $vm->connect("activate", array($this,'call_winframe'),$function,$title,$x,$y);
			              else $vm->connect("activate", array($this,'call_winframe'),$function,$title);	   
	         $viewmenu->append($vm);			     
		   }
	
	       if ($toolbar_on) {	 
             $button = &new GtkButton();
             $button->set_usize(25,25);
             $button->set_relief(GTK_RELIEF_NONE);
             $transparent = $window->style->white;	  
		     $xpm_name = str_replace(" ","_",$title).".xpm"; //echo $xpm_name,"\n";
             list($pixmap, $mask) = gdk::pixmap_create_from_xpm($window->window,$transparent,$this->xpm_path.$xpm_name);
             $px = &new GtkPixmap($pixmap, $mask);
             $button->add($px);
   
		     if (($x) && ($y)) $button->connect('clicked', array($this,'call_winframe'),$function,$title,$x,$y);
 		                  else $button->connect('clicked', array($this,'call_winframe'),$function,$title);						   
					   
             //$button->show();					   	  		     	
		  
	         //add button  
             $toolbar->set_space_style(GTK_TOOLBAR_SPACE_LINE);
             $toolbar->insert_widget($button,$title,$title,$counter++);	
		   }	
		     
	     }
	   }   
	  
     /*  $toolbar->insert_space($counter++);	  
	  
       $exit = &new GtkButton();
       $exit->set_usize(25,25);
       $exit->set_relief(GTK_RELIEF_NONE);
       $transparent = $container->style->white;	  
       list($pixmap, $mask) = gdk::pixmap_create_from_xpm($container->window,$transparent,$this->xpm_path."exit.xpm");
       $px = &new GtkPixmap($pixmap, $mask);
       $exit->add($px);
       $exit->connect_object('clicked', array($this, 'event_queue'),'exitprj');
       //$exit->show();
	  
	   //add button  
       $toolbar->set_space_style(GTK_TOOLBAR_SPACE_LINE);
       $toolbar->insert_widget($exit,'Exit','Exit',$counter);
       //$toolbar->insert_space(1);		*/  


       if ($menu_on) {
   	     $header0->set_submenu($viewmenu);	   
	     $container1->add($header0);		  
	   }	 
       if ($toolbar_on) $container2->add($toolbar);		  	
	   
       //$container->show();	  
	}	
	
    function event_queue($event,$param="") {
	  global $T_project;

	  $this->set_console_message("$event,$param");  	  
	  $this->set_status_message($event."($param)");
	
	  switch ($event) {
	    case 'snew'   : //smart new
						switch ($this->framework->current_page()) {
						  case "Dpc_Editor"     :switch ($this->arg1) {
						                            case '-dpc' : $this->dpcmanager->create();
													              break;
	                                                case '-bin' : 	   
	                                                case '-gtk' : 
	                                                              $this->event_queue('newdpc');
													              break;
 	                                                default     : $this->event_queue('newdpc');
						                         }
						                         break;
						  case "Security_Editor":												 
						  case "Schema_Editor"  :												 
						  case "Locales_Editor" :						  
						  case "Project_Editor" :$this->event_queue('wizard');	 
						                         break;	
						  default               :switch ($this->arg1) {
						                            case '-dpc' : $this->dpcmanager->create();
													              break;
	                                                case '-bin' : 	   
	                                                case '-gtk' : 
	                                                              $this->event_queue('newdpc');
													              break;
 	                                                default     : $this->event_queue('wizard');
						                         }
						}			
		                break;
	    case 'open'   : //smart open
						switch ($this->framework->current_page()) {
						  case "Dpc_Editor"     :switch ($this->arg1) {
						                            case '-dpc' : $this->dpcmanager->_close();//close if any
													              $this->dpcmanager->edit();
																  break;
	                                                case '-bin' : 	   
	                                                case '-gtk' : 
	                                                              filehandle('open','Open ... ',$this->dpc_path,'dpc_open_handle','readdpc','writedpc',"",1);
													              break;
 	                                                default     : filehandle('open','Open ... ',$this->dpc_path,'dpc_open_handle','readdpc','writedpc',"",1); 
						                         }
						                         break;
						  case "Security_Editor":												 
						  case "Schema_Editor"  :												 
						  case "Locales_Editor" :						  
						  case "Project_Editor" :filehandle('open','Open Project ... ',$this->prj_path,'project_open_handle','readprj','writeprj');	 
						                         break;	
						  default               :switch ($this->arg1) {
						                            case '-dpc' : $this->dpcmanager->edit();
													              break;
	                                                case '-bin' : 	   
	                                                case '-gtk' : 
	                                                              filehandle('open','Open ... ',$this->dpc_path,'dpc_open_handle','readdpc','writedpc',"",1);
													              break;
 	                                                default     : filehandle('open','Open ... ',$this->prj_path,'project_open_handle','readprj','writeprj');	 
						                         }
						}						 
		                break;
	    case 'save'   : //smart save
						switch ($this->framework->current_page()) {
						  case "Dpc_Editor"     :if ($this->framework->Dpc_Editor) 
						                           //filehandle('save','Save ... ',$this->dpc_path,'dpc_save_handle','readdpc','writedpc',"",1);
												   $this->event_queue("writedpc",$this->get_project_title());
												 break;
						  case "Security_Editor":												 
						  case "Schema_Editor"  :	
						  case "Locales_Editor" :						  											 
						  case "Project_Editor" :if ($this->framework->Project_Editor) {
						                           $pr_name =  $this->get_project_title();
												   if ($pr_name)
												     $this->event_queue("writeprj",$this->prj_path . $pr_name . "/$pr_name.prj.php");
												   else
						                             filehandle('save','Save Project ... ',$this->prj_path,'project_save_handle','readprj','writeprj');	 
                                                 }				  
 						                         break;										 
						} 
		                break;	
						
	    case 'saveas'   : //smart save
						switch ($this->framework->current_page()) {
						  case "Dpc_Editor"     :if ($this->framework->Dpc_Editor) {
						                           switch ($this->arg1) {
						                             case '-dpc' : $this->dpcmanager->save();
													               break;
	                                                 case '-bin' : 	   
	                                                 case '-gtk' : 
	                                                               filehandle('save','Save as ... ',$this->dpc_path,'dpc_save_handle','readdpc','writedpc',"",1);
													               break;
 	                                                 default     : filehandle('save','Save as ... ',$this->dpc_path,'dpc_save_handle','readdpc','writedpc',"",1);
						                           }  
												 }  
						                         break;
						  case "Security_Editor":												 
						  case "Schema_Editor"  :	
						  case "Locales_Editor" :						  											 
						  case "Project_Editor" :if ($this->framework->Project_Editor) {
						                             filehandle('save','Save Project as ... ',$this->prj_path,'project_save_handle','readprj','writeprj');	 
                                                 }				  
 						                         break;										 
						}
		                break;	
						
		case 'close'  :	switch ($this->framework->current_page()) {	
						  case "Dpc_Editor"     :if ($this->winframe) $this->winframe->closeall_winframe();		
                                                 if ($this->framework->Dpc_Editor) {
												   
												   if ($this->framework->Dpc_Editor->ischanged()) {
												          $nAnswer = MessageBox( "Document not saved. Close now ?", "Close", MB_YESNO + MB_ICONQUESTION + MB_DEFBUTTON2 + MB_CENTER);
	   
                                                          if( $nAnswer == IDNO) break;	   
												   }	  
												   $this->framework->Dpc_Editor->_close();//first 
						                           $this->framework->delete_frame('Dpc_Editor','0'); 												   
												   
						                           switch ($this->arg1) {
						                                  case '-dpc' : $this->dpcmanager->_close();
													                    $this->codemanager->_close();
													                    break;
	                                                      case '-bin' : 	   
	                                                      case '-gtk' : break;
 	                                                      default     :
						                           }												   												 
                                                 }
						                         break;
						  case "Security_Editor":												 
						  case "Schema_Editor"  :	
						  case "Locales_Editor" :						  											 
						  case "Project_Editor" :if ($this->winframe->Properties) {						
						                           $this->winframe->Properties->free();
						                           $this->winframe->showhide_winframe('Properties','HIDE');
						                         }
						                         if ($this->winframe->Themes) {						
						                           $this->winframe->Themes->free();
						                           $this->winframe->showhide_winframe('Themes','HIDE');
						                         }
						                         if ($this->winframe) $this->winframe->closeall_winframe();
												 if (count($this->framework->notepage)>0) {
												   $this->framework->closeall_frame();
												 }
												 $this->close_project();
												 
												 $this->prjmanager->_close();
 						                         break;																			
						}						
						break;
						
		case 'sexit'  : //smart exit
                        switch ($this->framework->current_page()) {	
						  case "Dpc_Editor"     :if ($this->framework->Dpc_Editor) {
						  
												   if ($this->framework->Dpc_Editor->ischanged()) {
												          $nAnswer = MessageBox( "Document not saved. Exit now ?", "Exit", MB_YESNO + MB_ICONQUESTION + MB_DEFBUTTON2 + MB_CENTER);
	   
                                                          if( $nAnswer == IDNO) break;							  
						                           } 
						                           switch ($this->arg1) {
						                                  case '-dpc' : $this->dpcmanager->_close();
													                    $this->codemanager->_close();
													                    break;
	                                                      case '-bin' : 	   
	                                                      case '-gtk' : break;
 	                                                      default     :
						                           }
												    
						                           $this->framework->Dpc_Editor->exit_();//last of all  		
												 }  
						                         break;
						  case "Security_Editor":												 
						  case "Schema_Editor"  :if ($this->framework->Schema_Editor) {
						                             $this->framework->Schema_Editor->exit_(); 
                                                 }				  
 						                         break;	
						  case "Locales_Editor" :						  											 
						  case "Project_Editor" :if ($this->framework->Project_Editor) {
						                             $this->framework->Project_Editor->exit_(); 
                                                 }				  
 						                         break;
						  default               :$this->exitnow();																	
						}
						break;
						
		case 'exityes': //final exit	
                        switch ($this->framework->current_page()) {	
						  case "Dpc_Editor"     :if ($this->winframe) $this->winframe->closeall_winframe();		
                                                 if ($this->framework->Dpc_Editor) {
						                             $this->framework->delete_frame('Dpc_Editor','0'); 
                                                 }
						                         break;
						  case "Security_Editor":												 
						  case "Schema_Editor"  :	
						  case "Locales_Editor" :						  											 
						  case "Project_Editor" :if ($this->winframe->Properties) {						
						                           $this->winframe->Properties->free();
						                           $this->winframe->showhide_winframe('Properties','HIDE');
						                         }
						                         if ($this->winframe->Themes) {						
						                           $this->winframe->Themes->free();
						                           $this->winframe->showhide_winframe('Themes','HIDE');
						                         }
						                         if ($this->winframe) $this->winframe->closeall_winframe();
												 if (count($this->framework->notepage)>0) {
												   $this->framework->closeall_frame();
												 }
												 $this->free();
 						                         break;																			
						}	
                        $this->free();   
						gtk::main_quit(); //EXITTTTTTTTTTTTTT!!!!!!!!!!!!!!					
						break;					
						
						//dpc editor				
	    case 'opendpc': filehandle('open','Open Dpc ... ',$this->dpc_path,'dpc_open_handle','readdpc','writedpc');
		                break;
		case 'savedpc': if ($this->framework->Dpc_Editor) filehandle('save','Save Dpc ... ',$this->dpc_path,'dpc_save_handle','readdpc','writedpc',$param);  
		                break;
	    case 'editdpc':						
		case 'readdpc': if (!$this->framework->Dpc_Editor) $this->framework->add_frame('dpc_editor','Dpc Editor','0');
		                $this->framework->Dpc_Editor->open_dpc($param);
		                $this->framework->select_page("Dpc_Editor");
						$this->codemanager->rebuild();		
	                    break; 
	    case 'newdpc'   : if (!$this->framework->Dpc_Editor) $this->framework->add_frame('dpc_editor','Dpc Editor','0');
		                $this->framework->Dpc_Editor->new_dpc();
		                $this->framework->select_page("Dpc_Editor");
						$this->codemanager->rebuild();		
	                    break;	
		case 'exitdpc': if ($this->framework->Dpc_Editor) $this->framework->Dpc_Editor->exit_();
		                else $this->exitnow();
						break;						
		case 'writedpc': if ($this->framework->Dpc_Editor) $this->framework->Dpc_Editor->save_dpc($param);
		                $this->codemanager->rebuild();
		                break;	
								
						//project editor										
	    case 'newprj' : if (!$this->framework->Project_Editor) $this->framework->add_frame('prj_editor','Project Editor');
						if (!$this->framework->Schema_Editor) $this->framework->add_frame('schema','Schema Editor');
						if (!$this->framework->Security_Editor) $this->framework->add_frame('sec_editor','Security Editor');
						if (!$this->framework->Locales_Editor) $this->framework->add_frame('loc_editor','Locales Editor');						
																																			
	                    $this->framework->Project_Editor->new_();
						$this->framework->Schema_Editor->new_();	
	                    $this->framework->Security_Editor->new_();	
                        $this->framework->Locales_Editor->new_();																	
		                $this->framework->select_page("Project_Editor");	
						
						if (!$this->winframe->Properties) $this->winframe->add_winframe('properties','Properties');	
						$this->winframe->Properties->new_();
						$this->winframe->Properties->show('ID');
						$this->winframe->showhide_winframe('Properties','SHOW');						
						
						if (!$this->winframe->Themes) $this->winframe->add_winframe('themes','Themes');						
						$this->winframe->Themes->new_();						
						$this->winframe->showhide_winframe('Themes','SHOW');						
						
						if ($this->framework->Schema_Editor) $this->framework->Schema_Editor->reset_schema();
						
						$this->prjmanager->rebuild();
						break;
						
		case 'saveprj': if ($this->framework->Project_Editor) filehandle('save','Save Project ... ',"$this->prj_path$T_project\\$T_project.prj.php",'project_save_handle','readprj','writeprj',$param);
		                break;
	    case 'openprj': filehandle('open','Open Project ... ',$this->prj_path,'project_open_handle','readprj','writeprj');	
		                break;
		case 'writeprj':$this->save();
		                if ($this->framework->Project_Editor) {
		                   $this->framework->Project_Editor->save($param);
		                   $this->framework->Security_Editor->save($this->prj_path.$T_project);						   
		                   $this->framework->Locales_Editor->save($this->prj_path.$T_project);						   
						   $this->winframe->Properties->save($this->prj_path.$T_project);
	   					   $this->framework->Schema_Editor->save($this->prj_path.$T_project);
						   $this->winframe->Themes->save();	
						   
						   $this->prjmanager->rebuild();					   
						}   
		                break;									
		case 'readprj': $this->load($param);
		                if (!$this->framework->Project_Editor) $this->framework->add_frame('prj_editor','Project Editor');
						if (!$this->framework->Schema_Editor) $this->framework->add_frame('schema','Schema Editor');		
						if (!$this->framework->Security_Editor) $this->framework->add_frame('sec_editor','Security Editor');
						if (!$this->framework->Locales_Editor) $this->framework->add_frame('loc_editor','Locales Editor');
						
		                $this->framework->Locales_Editor->load($this->prj_path.$T_project);						
		                $this->framework->Security_Editor->load($this->prj_path.$T_project);						
		                $this->framework->Project_Editor->load($param);
		                $this->framework->select_page("Project_Editor");		
						
						if (!$this->winframe->Properties) $this->winframe->add_winframe('properties','Properties');	
						$this->winframe->Properties->load($this->prj_path.$T_project."/public/");
						$this->winframe->Properties->show('ID');
						$this->winframe->showhide_winframe('Properties','SHOW');	
						
						if (!$this->winframe->Themes) $this->winframe->add_winframe('themes','Themes');						
						$this->winframe->Themes->load();
						$this->winframe->showhide_winframe('Themes','SHOW');																							
						
						$this->framework->Schema_Editor->load($this->prj_path.$T_project."/");			   
						
						$this->prjmanager->rebuild();
	                    break;				
		case 'exitprj': //if ($this->framework->Project_Editor) $this->framework->Project_Editor->exit_();
		                //if ($this->framework->Schema_Editor) $this->framework->Schema_Editor->exit_();
		                //else $this->exitnow();
						break;																	  
	    case 'add_module':if ($this->framework->Project_Editor) { 
		                  $this->framework->Project_Editor->add_dpc($param);
		                  //$this->framework->select_page("Project_Editor");
						}
		                if ($this->framework->Locales_Editor) $this->framework->Locales_Editor->add_dpc($param);						  
		                if ($this->framework->Security_Editor) $this->framework->Security_Editor->add_dpc($param);						  
						if ($this->framework->Schema_Editor) {
						  $this->framework->Schema_Editor->add_module($param);//$this->winframe->Properties->translate($param));
			              $this->framework->select_page("Schema_Editor");					
						}
						if ($this->winframe->Properties) $this->winframe->Properties->show($this->winframe->Properties->translate($param));
	                    break;
						
	    case 'remove_module':if ($this->framework->Project_Editor) $this->framework->Project_Editor->remove_dpc($param);
                          if ($this->framework->Locales_Editor) $this->framework->Locales_Editor->remove_dpc($param);		
		                  if ($this->framework->Security_Editor) $this->framework->Security_Editor->remove_dpc($param);
                          if ($this->framework->Schema_Editor) $this->framework->Schema_Editor->remove_module($param);			
						  $this->winframe->Properties->show();	
		                break;								 
						
		case 'properties' : if ($this->winframe->Properties) {
		                       $this->winframe->Properties->show($param);    
							   $this->winframe->showhide_winframe('Properties','SHOW');
							}   
		                break; 
						
		case 'wizard' : $this->wizard();	
		                break;	
		case 'run'    : $this->run();	
		                break;														
		case 'exit'   : $this->exitnow();	//question window
		                break;	
		case 'halt'   : gtk::main_quit(); 									
						
	  }
    }
	
	function exitnow() {
	
       $nAnswer = MessageBox( "Exit now ?", "Exit", MB_YESNO + MB_ICONQUESTION + MB_DEFBUTTON2 + MB_CENTER);
	   
       if( $nAnswer == IDYES) {	   
	      //gtk::main_quit();		 
		  $this->event_queue('exityes');
       } 	
	}
	
	
	function run() {
	   global $T_project;
	   
	   $runpath = $this->prj_path."$T_project\public\\";
	   $runfile = $this->prj_path."$T_project\public\action.func";
	   
	   if (is_file($runfile)) {
	   
	     if (is_dir($runpath)) {
		
	       //console
	       $this->console->write("php -q ".$runfile);		 
	       chdir($runpath);	
	       $out = shell_exec("php -q ".$runfile);
           $this->console->write($out);
		   
		   //multi browser
           //$this->mbrowser = &new mbrowser();		   
		   //$this->gtk_mbrowser($runpath,"http://localhost/$T_project/","action.func");
		   $this->mbrowser->run($runpath,"http://localhost/$T_project/","action.func");
		 }
		 else
		   $this->set_console_message("Invalid directory! (".$runpath.")");	
	   }   
	   else
	     $this->set_console_message("Invalid file! (".$runfile.")");
	}	
	
	function wizard() {
	
	   $window = &new GtkWindow;
	   $window->connect('delete-event', 'delete_event');
	   $window->set_title('New Project');
       $window->set_position(GTK_WIN_POS_CENTER);	   
	   $window->set_usize(200, 80);		  
	   $window->set_border_width(1);
	   
       $vbox = &new GtkVBox();
	   $window->add($vbox);	
	   
	   $hbox = &new GtkHBox(false, 5);
	   $hbox->set_border_width(5);
	   $vbox->pack_start($hbox, false);	   		   
	   
	   $name = &new GtkLabel("Project Name");
       $name->set_justify(GTK_JUSTIFY_LEFT);		  		  
	   $hbox->pack_start($name,false,false,0);
		  
	   $prname = &new GtkEntry();
	   $prname->set_text("");
	   $prname->set_max_length(64);		  
	   //$prname->connect_object('changed', array($this,'properties_changed'));		  
	   $hbox->pack_start($prname,false,false,0);
	   
	   $hbox2 = &new GtkHBox(false, 5);
	   $hbox2->set_border_width(5);
	   $vbox->pack_start($hbox2, false);		   	   
	   
       $button = &new GtkButton('Ok');
	   //$button->connect_object('clicked', array($this, 'event_queue'),"newprj");
	   $button->connect('clicked', array($this,'new_project_name'),$prname);	   
	   $button->connect('clicked', 'destroy_event',$window);	   
	   $hbox2->pack_start($button,false);
	  
       $button = &new GtkButton('Cancel');
	   $button->connect('clicked', 'destroy_event',$window);	   
	   $hbox2->pack_start($button,false);	  	   
				  
	   $window->set_modal(true);		  
	   $window->show_all();	   
	}
	
	function load($pathname) {
	   global $T_project;	
	   
	   $item = explode("\\",$pathname);
	   $max = count($item)-1;
       $ret = str_replace(".prj.php","",$item[$max]);	   
	   
	   //print $ret;
	   $this->project_name = $ret;
	   $T_project = $ret;	   
	   
	   if ($this->project_name!=null) {
	   
			   $this->set_window_title($this->project_name);	
			   
			   $this->addto_recent_files($pathname);	  	
			   
			   return true;   
	   }	 
	   	     
	   return false;
	}
	
	function save() {
	   global $T_project;	   
	   
	   if ($T_project!=null) {
			   //create action file
			   $this->create_action_file($this->prj_path.$T_project);		   
			   //create style file
			   $this->create_style_file($this->prj_path.$T_project);			   
			   
			   return true;
	   }
	   return false;	
	}
	
	function new_project_name($editctrl,$name) {
	   global $T_project;
	
	   $this->project_name = $name->get_text();
	   $T_project = $name->get_text();	   
	   
	   if ($this->project_name!=null) {
			   //print $this->project_name;
			   
			   //create project directories	  
               $this->create_directories($this->prj_path.$this->project_name);		   
	           			  
			   $this->set_window_title($this->project_name);			   
						  
			   $param = $this->prj_path.$this->project_name; 			  
	     	   $this->event_queue("newprj",$param);
			   
			   return true;
	   }
	   return false;
	}
	
	function set_window_title($title) {
	   global $window;
	   
	   $window->set_title('WebOs-'.$title);
	   $window->set_name($title);	   
	}
	
	function get_project_title() {
	   global $window;

	   return($window->get_name());	   
	}
	
	function create_directories($where) {
	
       mkdir($where.paramload('PROJECT','MAINDIR'));//"\\"); //project dir
       mkdir($where.paramload('PROJECT','PUBLICDIR'));//"\public");	 //public dir
	   mkdir($where.paramload('PROJECT','CACHEDIR'));//"\cache");	 //cache dir
	   mkdir($where.paramload('PROJECT','SESDIR'));//"\sessions");	 //sessions dir
	   mkdir($where.paramload('PROJECT','ARTDIR'));//"\artwork");	 //artwork dir	   
	   mkdir($where.paramload('PROJECT','IMGDIR'));//"\images");	     //images dir	   
	   mkdir($where.paramload('PROJECT','THEMEDIR'));//"\\themes");	 //themes dir	   
	}
	
	function create_action_file($where) {	
	
	    $file = $where . "\public\\".paramload('PROJECT','STARTFILE'); //action.func";
		$out = '<?php require ("/dpc/start.dpc.php"); start(); ?>';
	
        if ($fp = fopen ($file , "w")) {
                   fwrite ($fp, $out);
                   fclose ($fp);
				   
		           $this->set_console_message("Action file saved.");				   
				   return (true);
	    }
	    else {
		           $this->set_console_message("Action file NOT saved !!!");		
				   return (false);
		}	
	}	
	
	function create_style_file($where) {
	
	    if (copy($this->gtk_path."styles.css",$where."\\themes\styles.css")) {
		
		           $this->set_console_message("Style sheet file saved.");				   
				   return (true);		
		}
		else {
		           $this->set_console_message("Style sheet file NOT saved !!!");		
				   return (false);		
		} 
	}
	
	function call_winframe($dummy,$class,$title,$w=400,$h=250,$b=0) {
	
	    //print $class.">".$label;
	    $this->winframe->add_winframe($class,$title,$w,$h,$b);
	}
	
    function shell_window($window,$class,$alias,$title,$w=400,$h=250,$b=0) {
        global $windows;
		
        if (!isset($windows[$alias])) {	
		  		
		  $window = &new GtkWindow;
		  $windows[$alias] = $window;
		  $window->connect('delete-event', 'delete_event');
		  $window->set_title($title);
	      $window->set_usize($w, $h);		  
		  $window->set_border_width($b);
		  
		  $alias = &new $class($window); 		  
		  
	      $window->show_all();	  							  
		}
        elseif ($windows[$alias]->flags() & GTK_VISIBLE)
            $windows[$alias]->hide();
        else
            $windows[$alias]->show();			
	}
	
	function close_project() {
	    global $T_project;
		
		$T_project = null;
		unset ($T_project);
		
		$this->set_window_title("");	
	}	
	
	function free() {
	
	   $this->close_project();
	   
	   $this->iniwrite();
	}	
	
	//used by the recent list		
	function addto_recent_files($file) {

	    $recentfiles = $this->gtk_path . "recfiles.txt"; //echo $recentfiles;
		
		if (file_exists($recentfiles)) 
          $fp = fopen ($recentfiles , "a+");	
		else
          $fp = fopen ($recentfiles , "wb");	  
	    
        if ($fp) {
                   fwrite ($fp, $file."\r\n");
                   fclose ($fp);
				   
		           $this->set_console_message("Added to recent files successfully.");				   
				   return (true);
	    }
	    else {
		           $this->set_console_message("NOT added to recent files !!!");		
				   return (false);
		}		
	}
	//used by the recent list	
	function clear_recent_files() {
	
	    $recentfiles = $this->gtk_path . "recfiles.txt"; //echo $recentfiles;
		
		unlink($recentfiles);	
		$this->set_console_message("Recent files cleared !!!");
	}

	//used by the view submenu
	function setini($widget,$line) {
	  global $setini;
	
	  if ($setini[$line]==1) 
        $setini[$line] = 0;
	  else
	   	$setini[$line] = 1;
		
	  //print_r($setini);	
	}
	
	//used by the view submenu
	function iniread() {

	   $ini = $this->gtk_path . "webos.ini"; 
	    
	   if (file_exists($ini)) {
	   
          if ($fp = fopen ($ini , "r")) {
                   $data = fread ($fp, filesize($ini));
                   fclose ($fp);
	      }	   	   
          
		  if ($data) {	   
   		    $sets = explode("<@>",$data);
		    $myini = unserialize($sets[0]);
		  }
		  else {
		    $myini = array();
		  }
	      //print_r($myini);		   
		  //$this->console->write("Reading ini settings successfully.");				   
		  return ($myini);
	    }
	    else {
		  //$this->console->write("Ini setting NOT readed !!!");		
		  return (false);
		}	
	}
	
	//used by the view submenu	
	function iniwrite() {
	    global $setini;
	
	    $ini = $this->gtk_path . "webos.ini"; 	//echo $ini;  
	    
        if ($fp = fopen ($ini , "wb")) {
		
				   $tow = serialize($setini) . "<@>";	 
					 
                   fwrite ($fp, $tow);
                   fclose ($fp);
				   
		           $this->set_console_message("Writing ini settings successfully.");				   
				   return (true);
	    }
	    else {
		           $this->set_console_message("Ini setting NOT saved !!!");		
				   return (false);
		}		
	}	
	
	function set_status_message($msg) {

	  if ($this->status)
        $this->status->push($this->status->get_context_id($msg), $msg);		
	}
	
	function set_console_message($msg) {
	
      if ($this->console) 
	    $this->console->write($msg);	
    }

}	

    function shell_window($window,$class,$alias,$title,$w=400,$h=250,$b=0) {
        global $windows;
		global $shell;
		
        if (!isset($windows[$alias])) {	
		  		
		  $window = &new GtkWindow;
		  $windows[$alias] = $window;
		  $window->connect('delete-event', 'delete_event');
		  $window->set_title($title);
	      $window->set_usize($w, $h);		  
		  $window->set_border_width($b);
		  
		  $shell->{$alias} = &new $class($window); 		  
		  
	      $window->show_all();	  							  
		}
        elseif ($windows[$alias]->flags() & GTK_VISIBLE)
            $windows[$alias]->hide();
        else
            $windows[$alias]->show();			
	}	

?>
