<?php

include("../../class/classMyDBC.php");
include("../../class/classFile.php");

if (extract($_POST)):
	$file = new File();
	echo json_encode($file->get($id));
endif;