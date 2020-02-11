<?php

include("../../class/classMyDBC.php");
include("../../class/classFile.php");
include("../../src/fn.php");

if (extract($_POST)):
	$db = new myDBC();
	$file = new File();

	try {
		$db->autoCommit(FALSE);
		$fl = $file->del($id, BASEFOLDER, $db);

		if (!$fl['estado']):
			throw new Exception('Error al eliminar el documento. ' . $fl['msg']);
		endif;

		$db->Commit();
		$db->autoCommit(TRUE);
		$response = array('type' => true, 'msg' => 'OK');
		echo json_encode($response);
	} catch (Exception $e) {
		$db->Rollback();
		$db->autoCommit(TRUE);
		$response = array('type' => false, 'msg' => $e->getMessage());
		echo json_encode($response);
	}

endif;