<?php

include("../class/classMyDBC.php");
include("../class/classBox.php");

if (extract($_POST)):
    $box = new Box();
    echo json_encode($box->getByFloor($id, $type));
endif;