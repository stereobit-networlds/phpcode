<?php

define (FEOL,"\r\n");

class dpc_code {

   var $code_closed_xpm, $code_open_xpm;
   var $ctree_data, $ctree;	   
   var $dpc_dir;
		
   function dpc_code($parent=null) {
	  global $transparent;
	  global $window;
	  global $shell;   
   
	  $this->dpc_dir = $shell->app_path . paramload('INSTALL','DPCDIR');   
     
      $this->code_closed_xpm = array("16 16 6 1",
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

        $this->code_open_xpm = array("16 16 4 1",
					   "       c None s None",
					   ".      c black",
					   "X      c #808080",
					   "o      c white",
					   "                ",
					   "  ..            ",
					   " .Xo.    ...    ",
					   " .Xoo. ..oo.    ",
					   " .Xooo.Xooo...  ",
					   " .Xooo.oooo.X.  ",
					   " .Xooo.Xooo.X.  ",
					   " .Xooo.oooo.X.  ",
					   " .Xooo.Xooo.X.  ",
					   " .Xooo.oooo.X.  ",
					   "  .Xoo.Xoo..X.  ",
					   "   .Xo.o..ooX.  ",
					   "    .X..XXXXX.  ",
					   "    ..X.......  ",
					   "     ..         ",
					   "                ");
				
          $window->realize();							   
		  $transparent = $window->style->white;
		  					   
		  list($this->ctree_data['pixmap1'], $this->ctree_data['mask1']) = Gdk::pixmap_create_from_xpm_d($window->window, $transparent, $this->code_closed_xpm);
		  list($this->ctree_data['pixmap2'], $this->ctree_data['mask2']) = Gdk::pixmap_create_from_xpm_d($window->window, $transparent, $this->code_open_xpm); 					   	 
		  
		  if ($parent!=null) $this->tree_control($parent); 		  
   }
   
	function tree_control(&$container) {	
		  		  	
          $vbox = &new GtkVBox();
		  $container->add($vbox);
		  //$vbox->show();		  	
		  
		  $scrolled_win = &new GtkScrolledWindow();
		  $scrolled_win->set_border_width(0);
		  $scrolled_win->set_policy(GTK_POLICY_AUTOMATIC, GTK_POLICY_ALWAYS);
		  $vbox->pack_start($scrolled_win);
		  //$scrolled_win->show();

		  $this->ctree = &new GtkCTree(2, 0, array('Argument', 'Value'));
		  $scrolled_win->add($this->ctree);
		  //$ctree->show();
		  
	      //drug & drop feature			 
 	      //$this->ctree->connect('drag_data_received', array($this,'dnd_remove_received'));
	      //$this->ctree->drag_dest_set(GTK_DEST_DEFAULT_ALL, $this->targets, GDK_ACTION_COPY);			 
		  

		  $this->ctree->set_column_auto_resize(0, true);
		  $this->ctree->set_column_width(1, 200);
		  $this->ctree->set_selection_mode(GTK_SELECTION_EXTENDED);
		  $this->ctree->set_line_style(GTK_CTREE_LINES_SOLID);
		  $line_style = GTK_CTREE_LINES_SOLLID;		  		  
		
		  
	      $this->ctree->connect('click_column', array($this,'ctree_click_column'),$this->ctree);		  
		  $this->ctree->set_usize(0, 300);		  
		 
		  $this->rebuild_tree(null);			
	  
	}	 
	
	function rebuild() {
	
	  $this->rebuild_tree(null,$this->ctree);
	}
	
	function _close() {
	  
	  $this->rebuild_tree(null,$this->ctree);	  
	}
	
	function rebuild_tree($button)	{

			$this->ctree->freeze();
			$this->ctree->clear();

			$text = array('CodeTree', '');

			$parent = $this->ctree->insert_node(null, null, $text, 5,
										  $this->ctree_data['pixmap1'],
										  $this->ctree_data['mask1'],
										  $this->ctree_data['pixmap2'],
										  $this->ctree_data['mask2'], 			
										  false, true);
										  										  

			$style = &new GtkStyle();
			$style->base[GTK_STATE_NORMAL] = new GdkColor(0, 45000, 55000);
			$this->ctree->node_set_row_data($parent, $style);

			if ($this->ctree->line_style == GTK_CTREE_LINES_TABBED)
				$this->ctree->node_set_row_style($parent, $style);

					
			$this->build_code_tree($parent);
			$this->ctree->thaw();
	}	
	
    function ctree_click_column($ctree,$column)	{
			
			if ($column == $ctree->sort_column) {
				if ($ctree->sort_type == GTK_SORT_ASCENDING)
					$ctree->set_sort_type(GTK_SORT_DESCENDING);
				else
					$ctree->set_sort_type(GTK_SORT_ASCENDING);
			} else
				$ctree->set_sort_column($column);

			$this->ctree->sort_recursive();
	}
	
	function read_nodes($node,$parent=null) {	
	   
	  if (is_array($node)) {  
	     foreach ($node as $codearg=>$codeval) { 
		 
		    $text[0] = $codearg;
		    $text[1] = $codeval;						  		  			
			$subparent = $this->ctree->insert_node($parent, $subparent, $text, 5,
										   $this->ctree_data['pixmap1'],
										   $this->ctree_data['mask1'],
										   $this->ctree_data['pixmap2'],
										   $this->ctree_data['mask2'],
										   false, false);
										   
			$style = &new GtkStyle();
			$style->base[GTK_STATE_NORMAL] = new GdkColor(0, 45000, 55000);
			$this->ctree->node_set_row_data($subparent, $style);

 		    if ($this->ctree->line_style == GTK_CTREE_LINES_TABBED)
			    $this->ctree->node_set_row_style($subparent, $style);			 
		 
		    if (is_array($codeval)) {				
			  
			  $this->read_nodes($codeval,$subparent);  
			}
			/*else {  		  								
			
		      $sibling = $this->ctree->insert_node($subparent, null, $text, 5,
 				  					               $this->ctree_data['pixmap1'],
											       $this->ctree_data['mask1'], 
											       null, null,
											       true, false);
			}*/									   
		 } 
	   } 
	}
	
	function build_code_tree($parent) {	
	      global $shell;	
			
	      //get text from dpc editor
	      if ($shell->framework->Dpc_Editor) {			
		    
		    $textcode =  $shell->framework->Dpc_Editor->read();
			$codearray = $this->make_code_tree($textcode,1);
			//print_r($dpcarray);
			
			if (is_array($codearray)) {  
              reset($codearray);
			  $this->read_nodes($codearray,$parent);
			}
		  }	
		  else {
		    $codearray = null;
			$this->read_nodes($codearray,$parent);
		  }
		   		
	}			  
   
   //make code tree
   function make_code_tree($file,$istext=0) {
    
	  $codetree = null;
	
	  if ($istext) {
	    //read text data
	    $data = $file;
	  }
	  else {   
	    //read file
        if ($fp = fopen ($file , "r")) {
	  
           $data = fread ($fp, filesize($file));
           fclose ($fp);
	    }		  
	  }
	    
	  //prepare markers
	  $p_data = explode(FEOL,$data);
	  $ln=0;
	  foreach ($p_data as $id=>$line) {
	    $ln+=1;
	    $m_code .= trim($line) . "\r\n@$ln;\r\n";
	  }		
	  //echo count($p_data),"><><><";  
	  print_r($p_data);
	  
	  $a_part = explode('class',$m_code);
	  
	  //HEADER INFO
	  //$codetree['header']['code'] = $a_part[0];  
	  $codetree['_HEADER_']['_LINE_'] = 1;
	  
	  //CLASS INFO
	  $cmax = count($a_part);
	  for ($cl=1;$cl<$cmax;$cl++) { //for each class in file
	    
	    $b_part = explode('function',$a_part[$cl]);
		
		$clname = $this->getclassname($b_part[0]);
	    $codetree[$clname]['_LINE_'] = $this->getlinefile($b_part[0]);		
		
		$codetree[$clname]['_GLOBALS_'] = $this->getclassglobals($b_part[0]);
		
		//FUNC INFO
		$fmax = count($b_part);
	    for ($fn=1;$fn<$fmax;$fn++) {
	  
	       $funame = $this->getfuncname($b_part[$fn]);	   
	       //$codetree[$clname][$funame] = $b_part[$fn];
	       $codetree[$clname][$funame]['_LINE_'] = $this->getlinefile($b_part[$fn]);		   
		   $codetree[$clname][$funame]['_ARGS_'] = $this->getfunargs($b_part[$fn]); 		   
	    }	  
	  }
	  
	  print_r($codetree);
	  return ($codetree);
   }   
   
   
   //get code line number
   function getlinefile($pcode) {
   
      $line = explode(FEOL,$pcode);
	  
	  $l0 = explode("@",$line[1]);
	  $l1 = explode(";",$l0[1]); 
	  $l = $l1[0];
	  
	  return ($l);
   }    

   //get class name 
   function getclassname($pcode) {
   
      $line = explode(FEOL,$pcode);
	  
	  $p0 = explode("{",$line[0]);
	  //$p = explode("extends",$p0); //extends class keyword
	  //print_r($p);
	  
	  $clname = trim($p0[0]);
	  
	  return ($clname);
   }   
   
   //get function name
   function getfuncname($pcode) {
   
      $line = explode(FEOL,$pcode);
	  
	  $p = explode("(",$line[0]);
	  
	  return (trim($p[0]));
   }  
   
   //get function params
   function getfunargs($pcode) {
     
      $line = explode(FEOL,$pcode); //print_r($line);
	  
	  $p0 = explode("(",$line[0]); //print_r($p0);
	  $p1 = explode(")",$p0[1]);   //print_r($p1);
	  $p2 = explode(",",$p1[0]);   //print_r($p2);
	  
	  if (count($p2)>0) { //args >0
	    foreach ($p2 as $id=>$farg) { 
		
		  $fa = explode("=",$farg);  
		  
	      $p[$fa[0]] = $fa[1];
		}
		
	    return ($p);   
	  }	  
	  else
	    return 'NULL';	
   }
   
   //get class globals
   function getclassglobals($pcode) {
	  
	  $p = explode(";",$pcode);
	  foreach ($p as $id0=>$gcode) {
	   
	     if (stristr($gcode,"var")) {
		 
		   $pexpr = trim(str_replace("var","",$gcode)); 
	       $g = explode(",",$pexpr);
		   foreach ($g as $id1=>$gexpr) {
		    
			  $expr = trim($gexpr);  
			  
			  if (stristr($gexpr,"=")) { 
			
		        $part = explode("=",$expr);
			    foreach ($part as $var=>$val)
			      $treevar[$var] = $val;      
			  }	
			  else
			    $treevar[$expr] = 'NULL';
		   }
		 }  
	  }  
		
	  return ($treevar);   
   } 
   
   ////////////////////////////////////////////////////////////////////////
   //CODE GENERATION
   ////////////////////////////////////////////////////////////////////////
   
    function create_dpc_module_text($name) {

      $data = <<<EOF
<?php

~__DPCSEC['%DPCNAME%_DPC']='1;1;1;1;1;1;1;1;1';

if ( (!defined("%DPCNAME%_DPC")) && (seclevel('%DPCNAME%_DPC',decode(GetSessionParam('UserSecID')))) ) {
define("%DPCNAME%_DPC",true);

~__DPC['%DPCNAME%_DPC'] = '$name';

~__EVENTS['%DPCNAME%_DPC'][0]='test';

~__ACTIONS['%DPCNAME%_DPC'][0]='test';


class $name {


	function $name() {

	}

    function event(~event=null) {
	}	

	function action() {
        global ~__USERAGENT;
		
        switch (~__USERAGENT) {
	         case 'HTML' : break;
	         case 'HDML' :  break;				 
	         case 'GTK'  : 			 
	        case 'GTKXUL':  break;
	         case 'TEXT' :  break;
	         case 'CLI'  :  break;			 
	         case 'WAP'  :  break;			 
	         case 'XML'  :  break;				 
	    }
			
	    return (~out);
	}

};
}
?>
EOF;

     $s1 = str_replace('%DPCNAME%',strtoupper($name),$data);
     $ret = str_replace('~','$',$s1);
  
     return ($ret);
   }

   function create_dpc_library_text($name) {

     $data = <<<EOF
<?php


?>
EOF;

     $s1 = str_replace('%DPCNAME%',strtoupper($name),$data);
     $ret = str_replace('~','$',$s1);
  
     return ($ret);
   }  
   
   /////////////////////////////////////////////////////////////////////////
   //COMMENTS GENERATION
   /////////////////////////////////////////////////////////////////////////
   function remark_file($ver=null) {
   
     $data = <<<EOF
// +----------------------------------------------------------------------+
// | PHP version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2003 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/3_0.txt.                                  |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Alexiou Bill <balexiou@stereobit.com>                       |
// +----------------------------------------------------------------------+
//
//	 
EOF;
   
     return ($data);	 
   }
   
   function remark_class($comment=null,$ver=null) {
   
     $data = <<<EOF
/**@COMMENT@
 * A simple class to use ANSI Colorcodes.
 *
 * Of all the functions, you probably only want to use convert() and escape(). 
 * They are easier to use. However, if you want to access colorcodes more
 * directly, look into the other functions.
 *
 * @package Console_Color
 * @category Console
 * @author Stefan Walk <post@fuer-et.de>
 * @license http://www.php.net/license/3_0.txt PHP License
 * @version $ver
 *
 */
EOF;

     $data .= "\n";

     $out = str_replace("@COMMENT@",$comment,$data);
    
     return ($out);	 	 
   }
   
   function remark_function($comment=null) {
   
     $data = <<<EOF
	/**
     * @COMMENT@
     *
     * @access public
     * @param string xxx
     * @return string
     */ 
EOF;
     $data .= "\n";

     $out = str_replace("@COMMENT@",$comment,$data);
    
     return ($out);	 
   }            

}
?>