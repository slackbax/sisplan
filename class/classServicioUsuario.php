<?php

class ServicioUsuario {

	/**
	 * @param $id
	 * @param $db
	 * @return stdClass
	 */
	public function getByUser($id, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT su.*, s.*, u.*, est.* 
									FROM prm_servicio_usuario su 
									JOIN prm_servicio s ON su.ser_id = s.ser_id 
									JOIN prm_usuario u ON su.us_id = u.us_id
									JOIN prm_cr cr ON s.cr_id = cr.cr_id
									JOIN prm_establecimiento est ON u.est_id = est.est_id
                                    WHERE su.us_id = ?");

		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();

		/*Servicio*/

		$obj->ser_id = $row['ser_id'];
		$obj->ser_nombre = utf8_encode($row['ser_nombre']);

		/*Usuario*/

		$obj->us_id = $row['us_id'];
		$obj->us_nombres = utf8_encode($row['us_nombres']);
		$obj->us_ap = utf8_encode($row['us_ap']);
		$obj->us_am = utf8_encode($row['us_am']);
		$obj->us_email = $row['us_email'];
		$obj->us_username = $row['us_username'];

		/*Centro de Responsabilidad*/

		$obj->cr_id = $row['cr_id'];
		$obj->cr_nombre = utf8_encode($row['cr_nombre']);

		/*Establecimiento*/

		$obj->est_id = $row['est_id'];
		$obj->est_comid = $row['com_id'];
		$obj->est_nombre = utf8_encode($row['est_nombre']);

		unset($db);
		return $obj;
	}

	/**
	 * @param $id
	 * @param $db
	 * @return stdClass
	 */
	public function getByServ($id, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT su.*, s.*, u.*, est.* 
									FROM prm_servicio_usuario su 
									JOIN prm_servicio s ON su.ser_id = s.ser_id 
									JOIN prm_usuario u ON su.us_id = u.us_id
									JOIN prm_cr cr ON s.cr_id = cr.cr_id
									JOIN prm_establecimiento est ON u.est_id = est.est_id
                                    WHERE su.ser_id= ?");

		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();

		/*Servicio*/

		$obj->ser_id = $row['ser_id'];
		$obj->ser_nombre = utf8_encode($row['ser_nombre']);

		/*Usuario*/

		$obj->us_id = $row['us_id'];
		$obj->us_nombres = utf8_encode($row['us_nombres']);
		$obj->us_ap = utf8_encode($row['us_ap']);
		$obj->us_am = utf8_encode($row['us_am']);
		$obj->us_email = $row['us_email'];
		$obj->us_username = $row['us_username'];

		/*Centro de Responsabilidad*/

		$obj->cr_id = $row['cr_id'];
		$obj->cr_nombre = utf8_encode($row['cr_nombre']);

		/*Establecimiento*/

		$obj->est_id = $row['est_id'];
		$obj->est_comid = $row['com_id'];
		$obj->est_nombre = utf8_encode($row['est_nombre']);

		unset($db);
		return $obj;
	}
}