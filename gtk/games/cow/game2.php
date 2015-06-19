<?
dl('php_gtk.' . (strstr(PHP_OS, 'WIN') ? 'dll' : 'so'));

/*built around the GtkLayout example in the manual*/
/*need to set the path to the image directory here*/
DEFINE('IM_PATH','../scripts/bull');

/* callback that forces a redraw of simple child widgets */
function exposure($adj, $layout) {
  $layout->queue_draw();
}

Class PictureButton extends GtkButton {
	function PictureButton ($text, $image_name, $window, $orientation, $tt_text) {
		$this->GtkButton();
		@list($pixmap, $mask) = Gdk::pixmap_create_from_xpm($window->window,null,$image_name);
		$button_image = &new GtkPixmap($pixmap, $mask);
		$button_box = &new GtkHBox();
		$button_box->pack_start($button_image);
		$this->add($button_box);
	}
}

function clicker($button,$layout)
	{
	global $currentX,$currentY;
		$xy=explode(":",$button->get_name());
		$thisX=$xy[0];$thisY=$xy[1];
		if($thisX+100==$currentX && $thisY==$currentY){$newX=$thisX+100;$newY=$thisY;$move=true;}
		if($thisX-100==$currentX && $thisY==$currentY){$newX=$thisX-100;$newY=$thisY;$move=true;}
		if($thisY+100==$currentY && $thisX==$currentX){$newX=$thisX;$newY=$thisY+100;$move=true;}
		if($thisY-100==$currentY && $thisX==$currentX){$newX=$thisX;$newY=$thisY-100;$move=true;}
		if($move==true)
			{
				$layout->move($button,$currentX,$currentY);$button->set_name("$currentX:$currentY");
				$currentX=$thisX;$currentY=$thisY;
			}
	}

function rand_start($button,$layout)
	{
	global $currentX,$currentY;
	$d = dir(IM_PATH); 
		while($entry=$d->read())
			{ 
				if(substr($entry,-3,3)=='xpm')
					{
						$ims[]=IM_PATH.'/'.$entry;
					}
			} 
	$d->close(); 

	$z=0;$w=0;$count=0;
	for($y=1;$y<5;$y++){
		for($x=1;$x<5;$x++){
				$yak[$x][$y]=&new PictureButton('',$ims[$count], $window, "HORZ",'');
					$yak[$x][$y]->connect('clicked','clicker',$layout);
						$yak[$x][$y]->set_usize(100,100);
							$yak[$x][$y]->set_border_width(0);
								$yak[$x][$y]->set_name("$z:$w");
									$yak[$x][$y]->set_relief(GTK_RELIEF_NONE);
				$layout->put($yak[$x][$y],$z,$w);
					if(strstr($ims[$count],'300300.xpm'))
						{
						//this is the bottom right corner (of original image)//
						//need to know its name to be able to hide it//
									$tempX=$x;$tempY=$y;
						}
				$count++;$z=$z+100;
			}
		$w=$w+100;$z=0;
	}
	$layout->show_all();
/* hide the `blank` */
$yak[$tempX][$tempY]->hide();
}

function solve($button,$layout)
	{
	$layout->freeze();
	$z=0;$w=0;
	for($y=1;$y<5;$y++){
		for($x=1;$x<5;$x++){
				$yak[$x][$y]=&new PictureButton('',IM_PATH."/b".$z.$w.".xpm", $window, "HORZ",'');
					$yak[$x][$y]->connect('clicked','clicker',$layout);
						$yak[$x][$y]->set_usize(100,100);
							$yak[$x][$y]->set_border_width(0);
								$yak[$x][$y]->set_name("$z:$w");
									$yak[$x][$y]->set_relief(GTK_RELIEF_NONE);
										$layout->put($yak[$x][$y],$z,$w);
				$z=$z+100;
			}
		$w=$w+100;
		$z=0;
	}
	$layout->show_all();
	
}

$window = &new GtkWindow();
$window->set_position(GTK_WIN_POS_CENTER);
$window->set_title('Layout');
$window->set_usize(420, 455);
$window->connect_object('destroy', array('gtk', 'main_quit'));
$window->realize();

/* create and add the scrolled window to the main window */
$scrolledwindow = &new GtkScrolledWindow();
$window->add($scrolledwindow);

/* create and add the layout widget to the scrolled window */
$layout = &new GtkLayout(null, null);
$scrolledwindow->add($layout);
$scrolledwindow->realize();

$layout->set_size(420, 455);

$solveit=&new GtkButton('Solve it');
	$solveit->set_border_width(0); 
		$solveit->set_usize(395,20);
			$solveit->connect('clicked','solve',$layout);

$butz=&new GtkFrame('::bull::');
	$buts=&new GtkVbox();
		$buts->pack_start($solveit,false,false,1);
			$buts->pack_start($scramble,false,false,1);
	$butz->add($buts);
$layout->put($butz,0,400);

/* get the adjustment objects and connect them to the callback.  This
   part should not be necessary under *nix systems */
$hadj = $scrolledwindow->get_hadjustment();
$vadj = $scrolledwindow->get_vadjustment();
$hadj->connect('value-changed', 'exposure', $layout);
$vadj->connect('value-changed', 'exposure', $layout);

$currentX=300;
$currentY=300;

$layout->realize();
$window->show_all();
rand_start('',$layout);
gtk::main();
?>