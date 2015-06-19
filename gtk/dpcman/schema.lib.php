<?php

function compute_line($mod1x,$mod1y,$mod2x,$mod2y,$offsetx=0,$offsety=0) {

   //print $mod1x.":".$mod1y.":".$mod2x.":".$mod2y."\n";
   
   if (($mod2x>$mod1x) && ($mod2y>$mod1y)) {
     
	 $ret['x'] = $mod1x + $offsetx; 
	 $ret['y'] = $mod1y + $offsety;
	 $ret['xm'] = $mod2x - $mod1x - $offsetx;
	 $ret['ym'] = $mod2y - $mod1y - $offsety;	 	 	 
   }
   elseif (($mod2x>$mod1x) && ($mod2y<$mod1y)) {
   
	 $ret['x'] = $mod1x + $offsetx; 
	 $ret['y'] = $mod2y + $offsety;
	 $ret['xm'] = $mod2x - $mod1x - $offsetx;
	 $ret['ym'] = $mod1y - $mod2y - $offsety;   
   }
   elseif (($mod2x<$mod1x) && ($mod2y>$mod1y)) {
   
	 $ret['x'] = $mod2x + $offsetx; 
	 $ret['y'] = $mod1y + $offsety;
	 $ret['xm'] = $mod1x - $mod2x - $offsetx;
	 $ret['ym'] = $mod2y - $mod1y - $offsety;	   
   }
   elseif (($mod2x<$mod1x) && ($mod2y<$mod1y)) {
   
	 $ret['x'] = $mod2x + $offsetx; 
	 $ret['y'] = $mod2y + $offsety;
	 $ret['xm'] = $mod1x - $mod2x - $offsetx;
	 $ret['ym'] = $mod1y - $mod2y - $offsety;   
   }

   //$ret = array('x'=>0,'y'=>0,'xm'=>0,'ym'=>0);
   //print_r($ret);
   
   return $ret;
}

?>