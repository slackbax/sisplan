<?php

class DistHoras {

	public function __construct() {
	}

	/**
	 * @param $id
	 * @param $db
	 * @return stdClass
	 */
	public function get($id, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT * FROM prm_dist_horas h
                                    JOIN prm_distribucion d ON h.dist_id = d.dist_id
                                    WHERE h.dh_id = ?");

		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->dh_id = $row['dh_id'];
		$obj->dh_distid = $row['dist_id'];
		$obj->dh_perid = $row['per_id'];
		$obj->dh_acpid = $row['acp_id'];
		$obj->dh_fecha = $row['dist_fecha'];
		$obj->dh_descripcion = $row['dist_descripcion'];
		$obj->dh_cantidad = $row['dh_cantidad'];
		$obj->dh_rendimiento = $row['dh_rendimiento'];

		unset($db);
		return $obj;
	}

	/**
	 * @param $db
	 * @return array
	 */
	public function getAll($db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT dh_id FROM prm_dist_horas");

		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['dh_id'], $db);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $id
	 * @param $db
	 * @return array
	 */
	public function getByDist($id, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT dh_id FROM prm_dist_horas WHERE dist_id = ?");

		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['dh_id'], $db);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $id
	 * @param $date
	 * @param $db
	 * @return mixed
	 */
	public function getNumByPerDate($id, $date, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT COUNT(dh_id) AS num FROM prm_dist_horas dh
                                    JOIN prm_distribucion d ON dh.dist_id = d.dist_id
                                    WHERE d.per_id = ? AND d.dist_fecha = ?");

		$stmt->bind_param("is", $id, $date);
		$stmt->execute();
		$result = $stmt->get_result();

		$row = $result->fetch_assoc();
		$obj = $row['num'];

		unset($db);
		return $obj;
	}

	/**
	 * @param $id
	 * @param $th
	 * @param $date
	 * @param $db
	 * @return stdClass
	 */
	public function getByPerTHDate($id, $th, $date, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$prev = date('Y-m-d', strtotime('-1 month', strtotime($date)));

		$stmt = $db->Prepare("SELECT * FROM prm_dist_horas dh
                                    JOIN prm_distribucion d ON dh.dist_id = d.dist_id
                                    WHERE d.per_id = ? AND dh.acp_id = ? AND d.dist_fecha = ?");

		$stmt->bind_param("iis", $id, $th, $prev);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();

		$obj->dh_id = $row['dh_id'];
		$obj->dh_perid = $row['per_id'];
		$obj->dh_acpid = $row['acp_id'];
		$obj->dh_fecha = $row['dist_fecha'];
		$obj->dh_cantidad = $row['dh_cantidad'];
		$obj->dh_rendimiento = $row['dh_rendimiento'];

		if ($obj->dh_id == ''):
			$obj->dh_fecha = $prev;
			$obj->dh_cantidad = '0.00';
			$obj->dh_rendimiento = '0.00';
		endif;

		unset($db);
		return $obj;
	}

	/**
	 * @param $dist
	 * @param $date
	 * @param $thor
	 * @param $db
	 * @return string
	 */
	public function getByTypePeople($dist, $date, $thor, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT dh_cantidad FROM prm_dist_horas dh
                                    JOIN prm_distribucion d ON dh.dist_id = d.dist_id
                                    WHERE d.dist_id = ? AND d.dist_fecha = ? AND acp_id = ?");

		$stmt->bind_param("isi", $dist, $date, $thor);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		$obj = $row['dh_cantidad'];
		if ($obj == ''): $obj = '0.00'; endif;

		unset($db);
		return $obj;
	}

	/**
	 * @param $dist
	 * @param $date
	 * @param $thor
	 * @param $db
	 * @return string
	 */
	public function getRendByTypePeople($dist, $date, $thor, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT (dh_cantidad * dh_rendimiento) AS rend FROM prm_dist_horas dh
                                    JOIN prm_distribucion d ON dh.dist_id = d.dist_id
                                    WHERE d.dist_id = ? AND d.dist_fecha = ? AND acp_id = ?");

		$stmt->bind_param("isi", $dist, $date, $thor);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		$obj = $row['rend'];
		if ($obj == ''): $obj = '0.00';
		else: $obj = number_format($obj, 2, '.', '');
		endif;

		unset($db);
		return $obj;
	}

	/**
	 * @param $dist
	 * @param $date
	 * @param $db
	 * @return string
	 */
	public function getByCCHospit($dist, $date, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT SUM(dh_cantidad) AS total FROM prm_dist_horas dh
                                    JOIN prm_distribucion d ON dh.dist_id = d.dist_id
                                    WHERE d.dist_id = ? AND d.dist_fecha = ? 
                                    AND (acp_id = 4 OR acp_id = 12 OR acp_id = 16 OR acp_id = 17)");

		$stmt->bind_param("is", $dist, $date);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		$obj = $row['total'];
		if ($obj == ''): $obj = '0.00';
		else: $obj = number_format($obj, 2, '.', '');
		endif;

		unset($db);
		return $obj;
	}

	/**
	 * @param $dist
	 * @param $date
	 * @param $db
	 * @return string
	 */
	public function getByCCConsulta($dist, $date, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT SUM(dh_cantidad) AS total FROM prm_dist_horas dh
                                    JOIN prm_distribucion d ON dh.dist_id = d.dist_id
                                    WHERE d.dist_id = ? AND d.dist_fecha = ? 
                                    AND (acp_id = 5 OR acp_id = 6 OR acp_id = 7 OR acp_id = 8
                                     OR acp_id = 11 OR acp_id = 13 OR acp_id = 14 OR acp_id = 15)");

		$stmt->bind_param("is", $dist, $date);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		$obj = $row['total'];
		if ($obj == ''): $obj = '0.00';
		else: $obj = number_format($obj, 2, '.', '');
		endif;

		unset($db);
		return $obj;
	}

	/**
	 * @param $dist
	 * @param $date
	 * @param $db
	 * @return string
	 */
	public function getByCCCirugia($dist, $date, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT SUM(dh_cantidad) AS total FROM prm_dist_horas dh
                                    JOIN prm_distribucion d ON dh.dist_id = d.dist_id
                                    WHERE d.dist_id = ? AND d.dist_fecha = ? 
                                    AND (acp_id = 10)");

		$stmt->bind_param("is", $dist, $date);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		$obj = $row['total'];
		if ($obj == ''): $obj = '0.00';
		else: $obj = number_format($obj, 2, '.', '');
		endif;

		unset($db);
		return $obj;
	}

	/**
	 * @param $dist
	 * @param $date
	 * @param $db
	 * @return string
	 */
	public function getByCCAClinico($dist, $date, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT SUM(dh_cantidad) AS total FROM prm_dist_horas dh
                                    JOIN prm_distribucion d ON dh.dist_id = d.dist_id
                                    WHERE d.dist_id = ? AND d.dist_fecha = ? 
                                    AND (acp_id = 9)");

		$stmt->bind_param("is", $dist, $date);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		$obj = $row['total'];
		if ($obj == ''): $obj = '0.00';
		else: $obj = number_format($obj, 2, '.', '');
		endif;

		unset($db);
		return $obj;
	}

	/**
	 * @param $dist
	 * @param $date
	 * @param $db
	 * @return string
	 */
	public function getByCCAAdmin($dist, $date, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT SUM(dh_cantidad) AS total FROM prm_dist_horas dh
                                    JOIN prm_distribucion d ON dh.dist_id = d.dist_id
                                    WHERE d.dist_id = ? AND d.dist_fecha = ? 
                                    AND (acp_id = 18 OR acp_id = 19 OR acp_id = 20 OR acp_id = 21)");

		$stmt->bind_param("is", $dist, $date);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		$obj = $row['total'];
		if ($obj == ''): $obj = '0.00';
		else: $obj = number_format($obj, 2, '.', '');
		endif;

		unset($db);
		return $obj;
	}

	/**
	 * @param $dist
	 * @param $thor
	 * @param $cant
	 * @param $rend
	 * @param $db
	 * @return array
	 */
	public function set($dist, $thor, $cant, $rend, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		try {
			$stmt = $db->Prepare("INSERT INTO prm_dist_horas (dist_id, acp_id, dh_cantidad, dh_rendimiento) 
                                    VALUES (?, ?, ?, ?)");

			if (!$stmt):
				throw new Exception("La inserción de la distribución de horas falló en su preparación.");
			endif;

			$bind = $stmt->bind_param("iidd", $db->clearText($dist), $db->clearText($thor), $db->clearText($cant), $db->clearText($rend));
			if (!$bind):
				throw new Exception("La inserción de la distribución de horas falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La inserción de la distribución de horas falló en su ejecución.");
			endif;

			$result = array('estado' => true, 'msg' => $stmt->insert_id);
			$stmt->close();
			return $result;
		} catch (Exception $e) {
			//printf("Error: %s.\n", $stmt->error);
			$result = array('estado' => false, 'msg' => $e->getMessage());
			return $result;
		}
	}
}

