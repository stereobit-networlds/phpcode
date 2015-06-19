<?php


class visual_manager {

    var $vistable;
	var $artable;
	
	function visual_manager($container) {	  	  
	  
       $this->visual_control2($container);
	}
	
	
	function new_() {			   				   
	}
	
	function load($pathfile) {	
	
	    $this->scan_records($pathfile);
		//print_r($this->artable);	 
		
		$this->reset_vistable();
		
		$this->render();		 
	}			
	
	function save($pathfile) {	 
	}	
	
	
	function scan_records($pathfile) {
			
	    $article_file = file ($pathfile);	
		
	    //reset artable
	    $this->artable = null;
  
	    reset ($article_file);
	    //while (list ($line_num, $line) = each ($article_file)) {
        foreach ($article_file as $line_num => $line) {			
		   $split = explode (";", $line);

		   if (strcmp($split[0],"ARTICLE")==0) {
		   
		      //check for previous readed article
		      if ($data) {		  
			    $record .= $data;
				$this->artable[] = $record;
				$data = "";				
			  }	
			  		   
			  $record  = $split[1] . "|"; //column id
              $record .= $split[2] . "|"; //security id
			  $record .= $split[3] . "|"; //title
			  $record .= $split[4] . "|"; //attributes
			  $record .= $split[5] . "|"; //cached			  
		   }
		   elseif (strcmp($split[0],"<HEAD>")==0) {
			  $record .= $data;		   
			  $this->h_table[] = $record;	
			  $data = null;	
			  $record = null;   
		   }		   
		   elseif (strcmp($split[0],"<FOOT>")==0) {
		      $record .= $data;		   
			  $this->f_table[] = $record;	
			  $data = null;	   
			  $record = null;
		   }		   
           else {  //article body
              $data .= $line;// . "\n";
           }
		}
    }	
	
	function render() {
	
		//$this->vistable->freeze();	
	
	    $y=0;
        foreach ($this->artable as $recnum => $record) {		
		   $params = explode ("|", $record);
		   
	       $id         = $params[0];
           $secid      = $params[1];
		   $title      = $params[2];
		   $attributes = $params[3];
		   $cached     = $params[4];
		   $data       = $params[5];		   	
		   

		   $uartid = ++$meter;
		   $rdata = "$id:$secid:$title";
		   
		   $this->add_article($rdata,$id*100,$y);
		   
		   $y+=30;
		   
		   //$button = &new GtkButton($rdata);
		   //$this->vistable->attach($button,1,1,0,0);
		   
	       //$vm = new window("",seturl("t=ar_modify&a=$uartid&g=$rdata","<h2>$rdata</h2>"));
	       //$winart = $vm->render();
	       //unset ($vm);		   		   
           //$column[$id] .= $winart;
		   //$colattr[$id] = "left;33%;";// . floor(100/count($column)); counr doesn't know the final max id'  
   	    }	
		
		$this->vistable->show_all();
		
		//$this->vistable->thaw();		
	}
	
	
	function add_article($title,$x,$y) {
	
        $art = &new GtkButton($title);
		$art->set_name($title);
	    //$art->connect_object('clicked', array($this, 'clickbox'),$pro,'properties');
	    $this->vistable->put($art,$x,$y);//pack_start($art,false);		
		
	    $this->vistable->show_all();			
	}	
	
	function rem_article($title) {
	    
		foreach ($this->vistable->children() as $num=>$child) {
		   if ($title==$child->get_name()) $this->vistable->remove($child);
		}
	}	
	
	function reset_vistable() {
	    
		//foreach ($this->vistable->children() as $num=>$child) {
		  // $this->vistable->remove($child);
		//}
	}	
	
	function visual_control($container) {
	
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
	
	   $layout->queue_draw();
	}
	
	function visual_control2($container) {
	
	   $scrolledwindow = &new GtkScrolledWindow();
	   $container->add($scrolledwindow); 	
	
	   $this->vistable = &new GtkLayout(null,null);
	   $scrolledwindow->add($this->vistable); 
	   
	   $this->vistable->set_size(640, 480);	
	   
	   /* get the adjustment objects and connect them to the callback.  This   part should not be necessary under *nix systems */
	   $hadj = $scrolledwindow->get_hadjustment();
	   $vadj = $scrolledwindow->get_vadjustment();
	   $hadj->connect('value-changed', array($this,'exposure'), $this->vistable);
	   $vadj->connect('value-changed', array($this,'exposure'), $this->vistable);	      
	}		
	
}		
?>
