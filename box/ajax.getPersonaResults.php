<?php

include("../class/classMyDBC.php");
include("../class/classPersona.php");

if (extract($_POST)):
	$per = new Persona();
	echo json_encode($per->getByString($string));
endif;