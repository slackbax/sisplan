<?php

include ("../class/classMyDBC.php");
include ("../class/classDistribucion.php");
include ("../src/fn.php");

if (extract($_POST)):
    $dh = new Distribucion();
    
    echo json_encode($dh->getDetail($id));
endif;
