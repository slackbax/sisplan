<?php

include ("../class/classMyDBC.php");
include ("../class/classDistHoras.php");
include ("../src/fn.php");

if (extract($_POST)):
    $dh = new DistHoras();
    $dateProg = setDateBD('01/01/' . $date);
    
    echo $dh->getNumByPerDate($id, $dateProg);
endif;

?>
