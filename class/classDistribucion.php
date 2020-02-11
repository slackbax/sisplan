<?php

class Distribucion {

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

		$stmt = $db->Prepare("SELECT * FROM prm_distribucion d
                                    WHERE d.dist_id = ?");

		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->dist_id = $row['dist_id'];
		$obj->dist_perid = $row['per_id'];
		$obj->dist_jusid = $row['jus_id'];
		$obj->dist_serid = $row['ser_id'];
		$obj->dist_espid = $row['esp_id'];
		$obj->dist_estid = $row['est_id'];
		$obj->dist_fecha = $row['dist_fecha'];
		$obj->dist_descripcion = $row['dist_descripcion'];
		$obj->dist_vacaciones = $row['dist_vacaciones'];
		$obj->dist_permisos = $row['dist_permisos'];
		$obj->dist_congreso = $row['dist_congreso'];

		unset($db);
		return $obj;
	}

	/**
	 * @return array
	 */
	public function getAll() {
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT dist_id FROM prm_distribucion");

		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['dist_id'], $db);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $date
	 * @param $db
	 * @return array
	 */
	public function getByDate($date, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT dist_id FROM prm_distribucion WHERE dist_fecha = ?");

		$stmt->bind_param("s", $date);
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['dist_id'], $db);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $per
	 * @param $date
	 * @param $db
	 * @return stdClass
	 */
	public function getByPerDate($per, $date, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT dist_id FROM prm_distribucion WHERE dist_fecha = ? AND per_id = ?");

		$stmt->bind_param("si", $date, $per);
		$stmt->execute();
		$result = $stmt->get_result();

		$row = $result->fetch_assoc();
		$obj = $this->get($row['dist_id']);

		unset($db);
		return $obj;
	}

	/**
	 * @param $per
	 * @param $estab
	 * @param $date
	 * @param $db
	 * @return mixed
	 */
	public function getCountByPerDate($per, $estab, $date, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT COUNT(dist_id) AS num FROM prm_distribucion WHERE dist_fecha = ? AND per_id = ? AND est_id = ?");

		$stmt->bind_param("sii", $db->clearText($date), $db->clearText($per), $db->clearText($estab));
		$stmt->execute();
		$result = $stmt->get_result();

		$row = $result->fetch_assoc();
		$obj = $row['num'];

		unset($db);
		return $obj;
	}

	/**
	 * @param $pl
	 * @param $estab
	 * @param $db
	 * @return array
	 */
	public function getByEstabPlanta($pl, $estab, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		switch ($pl):
			case '0':
				$cond = "p.prof_id = 6";
				break;
			case '1':
				$cond = "p.prof_id <> 6 AND p.prof_id <> 8";
				break;
			case '2':
				$cond = "p.prof_id = 8";
				break;
			default:
				break;
		endswitch;

		$stmt = $db->Prepare("SELECT dist_id FROM prm_distribucion d
                                    JOIN prm_persona p ON d.per_id = p.per_id
                                    WHERE $cond AND est_id = ? AND dist_ultima = TRUE");

		$stmt->bind_param("i", $db->clearText($estab));
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['dist_id'], $db);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $id
	 * @param $db
	 * @return array
	 */
	public function getDetail($id, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT * FROM prm_dist_horas
                                    WHERE dist_id = ?");

		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$obj = new stdClass();
			$obj->dh_cantidad = $row['dh_cantidad'];
			$obj->dh_rendimiento = $row['dh_rendimiento'];
			$total = $obj->dh_cantidad * $obj->dh_rendimiento;
			$obj->dh_total = ($total == 0 ? '<span style="color: silver">0.00</span>' : number_format($total, 2, '.', ''));

			$lista['th' . $row['acp_id']] = $obj;
			unset($obj);
		endwhile;

		$result_h = $db->runQuery("SELECT COUNT(acp_id) AS num FROM prm_actividad_prog");
		$row = $result_h->fetch_assoc();

		for ($i = 1; $i < $row['num'] + 1; $i++):
			if (!array_key_exists('th' . $i, $lista)):
				$obj = new stdClass();
				$obj->dh_cantidad = '<span style="color: silver">0.00</span>';
				$obj->dh_rendimiento = '<span style="color: silver">0.00</span>';
				$obj->dh_total = '<span style="color: silver">0.00</span>';

				$lista['th' . $i] = $obj;
				unset($obj);
			endif;
		endfor;

		$tdisp = $lista['th1']->dh_cantidad + $lista['th2']->dh_cantidad + $lista['th3']->dh_cantidad;
		$lista['tdisp'] = ($tdisp == 0 ? '<span style="color: silver">0.00</span>' : number_format($tdisp, 2, '.', ''));

		$tpoli = $lista['th5']->dh_cantidad + $lista['th6']->dh_cantidad + $lista['th7']->dh_cantidad + $lista['th8']->dh_cantidad;
		$lista['tpoli'] = ($tpoli == 0 ? '<span style="color: silver">0.00</span>' : number_format($tpoli, 2, '.', ''));

		$tapoli = $lista['th5']->dh_total + $lista['th6']->dh_total + $lista['th7']->dh_total + $lista['th8']->dh_total;
		$lista['tapoli'] = ($tapoli == 0 ? '<span style="color: silver">0.00</span>' : number_format($tapoli, 2, '.', ''));

		$total = $lista['th4']->dh_cantidad + $lista['th5']->dh_cantidad + $lista['th6']->dh_cantidad + $lista['th7']->dh_cantidad + $lista['th8']->dh_cantidad +
			$lista['th9']->dh_cantidad + $lista['th10']->dh_cantidad + $lista['th11']->dh_cantidad + $lista['th12']->dh_cantidad +
			$lista['th13']->dh_cantidad + $lista['th14']->dh_cantidad + $lista['th15']->dh_cantidad + $lista['th16']->dh_cantidad +
			$lista['th17']->dh_cantidad + $lista['th18']->dh_cantidad + $lista['th19']->dh_cantidad + $lista['th20']->dh_cantidad +
			$lista['th21']->dh_cantidad;
		$lista['total'] = ($total == 0 ? '<span style="color: silver">0.00</span>' : number_format($total, 2, '.', ''));

		unset($db);
		return $lista;
	}

	/**
	 * @param $dist
	 * @param $db
	 * @return string
	 */
	public function getTotalDisp($dist, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT SUM(dh_cantidad) AS suma FROM prm_dist_horas dh
                                    JOIN prm_distribucion d ON dh.dist_id = d.dist_id
                                    WHERE d.dist_id = ? AND (acp_id = 1 OR acp_id = 2 OR acp_id = 3)");

		$stmt->bind_param("i", $dist);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		$obj = $row['suma'];
		if ($obj == ''): $obj = '0.00'; endif;

		unset($db);
		return $obj;
	}

	/**
	 * @param $dist
	 * @param $db
	 * @return string
	 */
	public function getTotalPoli($dist, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT SUM(dh_cantidad) AS suma FROM prm_dist_horas dh
                                    JOIN prm_distribucion d ON dh.dist_id = d.dist_id
                                    WHERE d.dist_id = ? AND (acp_id = 5 OR acp_id = 6 OR acp_id = 7 OR acp_id = 8)");

		$stmt->bind_param("i", $dist);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		$obj = $row['suma'];
		if ($obj == ''): $obj = '0.00'; endif;

		unset($db);
		return $obj;
	}

	/**
	 * @param $dist
	 * @param $db
	 * @return string
	 */
	public function getTotal($dist, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT SUM(dh_cantidad) AS suma FROM prm_dist_horas dh
                                    JOIN prm_distribucion d ON dh.dist_id = d.dist_id
                                    WHERE d.dist_id = ? AND (acp_id = 1 OR acp_id = 2 OR acp_id = 3)");

		$stmt->bind_param("i", $dist);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		$obj = $row['suma'];
		if ($obj == ''): $obj = '0.00'; endif;

		unset($db);
		return $obj;
	}

	/**
	 * @param $per
	 * @param $estab
	 * @param $desc
	 * @param $date
	 * @param $justif
	 * @param $serv
	 * @param $esp
	 * @param $vacas
	 * @param $perm
	 * @param $cong
	 * @param $user
	 * @param $db
	 * @return array
	 */
	public function set($per, $estab, $desc, $date, $justif, $serv, $esp, $vacas, $perm, $cong, $user, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$jus = ($justif != '') ? $justif : NULL;

		try {
			$stmt = $db->Prepare("INSERT INTO prm_distribucion (per_id, us_id, est_id, dist_descripcion, dist_fecha, jus_id, ser_id, esp_id, dist_vacaciones, dist_permisos, dist_congreso, dist_ultima) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, TRUE)");

			if (!$stmt):
				throw new Exception("La inserción de la distribución falló en su preparación.");
			endif;

			$bind = $stmt->bind_param("iiissiiiiii", $db->clearText($per), $db->clearText($user), $db->clearText($estab), utf8_decode($db->clearText($desc)), $db->clearText($date), $jus, $serv, $esp, $db->clearText($vacas), $db->clearText($perm), $db->clearText($cong));
			if (!$bind):
				throw new Exception("La inserción de la distribución falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La inserción de la distribución falló en su ejecución.");
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

	/**
	 * @param $per
	 * @param $esp
	 * @param $est
	 * @param $ser
	 * @param $db
	 * @return array
	 */
	public function setLast($per, $esp, $est, $ser, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		try {
			$stmt = $db->Prepare("UPDATE prm_distribucion SET dist_ultima = FALSE 
                                    WHERE per_id = ? AND esp_id = ? AND est_id = ? AND ser_id = ?");

			if (!$stmt):
				throw new Exception("La actualización de la distribución falló en su preparación.");
			endif;

			$bind = $stmt->bind_param("iiii", $db->clearText($per), $db->clearText($esp), $db->clearText($est), $db->clearText($ser));
			if (!$bind):
				throw new Exception("La actualización de la distribución falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La actualización de la distribución falló en su ejecución.");
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

