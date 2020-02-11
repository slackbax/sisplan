<?php

session_start();
include ("../class/classMyDBC.php");
include ("../class/classPersona.php");
include ("../src/fn.php");
$_admin = false;

if (isset($_SESSION['prm_useradmin']) && $_SESSION['prm_useradmin']):
    $_admin = true;
endif;

if (extract($_POST)):
    $p = new Persona();
    
    $est = (!$_admin) ? $_SESSION['prm_estid'] : '';
    $idate = setDateBD('01/' . $idate);
    
    $npr = (isset($inoprog)) ? 'on' : '';
    
    echo json_encode($p->getNPByDate($idate, $iplanta, $est, $npr));
endif;