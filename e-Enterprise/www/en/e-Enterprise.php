<?php
include ('cp/dpc2/ippserver/ListenerIPP.php');
$listener = new IPPListener('e-Enterprise.printer' ,'BASIC' ,80 ,array('admin'=>'3964dae4','guest'=>'13add271','billy'=>'88e815c2',));
$listener->ipp_send_reply(); 
?>