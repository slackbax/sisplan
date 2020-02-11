<?php

include ("../../class/classMyDBC.php");
include ("../../class/classHoras.php");
include ("../../src/fn.php");

if (extract($_POST)):
    $h = new Horas();

    if ($pl == 1):
        $dateProg = setDateBD('01/' . $date);
    else:
        $dateProg = setDateBD('01/01/' . $date);
    endif;
    
    echo $h->getExistsByDate($pl, $dateProg);
endif;