<?php
session_start();
include("../../class/classMyDBC.php");
include("../../class/classFile.php");
include("../../src/fn.php");

if (extract($_POST)):
	$db = new myDBC();
	$fl = new File();

	try {
		$db->autoCommit(FALSE);
		$ins = $fl->mod($iid, $_SESSION['uc_userid'], $iname, $idescrip, 'TRUE', $db);

		if (!$ins['estado']):
			throw new Exception('Error al modificar los datos del documento. ' . $ins['msg']);
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