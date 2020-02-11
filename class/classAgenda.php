<?php

class Agenda {

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

		$stmt = $db->Prepare("SELECT * FROM prm_agenda a
									JOIN prm_persona per ON a.per_id = per.per_id
									JOIN prm_profesion pr ON pr.prof_id = per.prof_id
									JOIN prm_actividad ac ON a.act_id = ac.act_id
									JOIN prm_sin_subespecialidad pss on a.ssub_id = pss.ssub_id
									JOIN prm_sin_especialidad pse on pss.sesp_id = pse.sesp_id
									JOIN prm_sin_agrupacion psa on pse.sagr_id = psa.sagr_id
									JOIN prm_especialidad e on a.esp_id = e.esp_id
									JOIN prm_box b ON a.box_id = b.box_id
									JOIN prm_estab_lugar pel on b.lug_id = pel.lug_id
									WHERE age_id = ?");

		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->age_id = $row['age_id'];
		$obj->esp_id = $row['esp_id'];
		$obj->esp_nombre = utf8_encode($row['esp_nombre']);
		$obj->sagr_id = $row['sagr_id'];
		$obj->sesp_id = $row['sesp_id'];
		$obj->sesp_nombre = utf8_encode($row['sesp_nombre']);
		$obj->ssub_id = $row['ssub_id'];
		$obj->ssub_nombre = utf8_encode($row['ssub_nombre']);
		$obj->act_id = $row['act_id'];
		$obj->act_nombre = utf8_encode($row['act_nombre']);
		$obj->act_multi = $row['act_multi'];
		$obj->act_comite = $row['act_comite'];
		$obj->act_cxc = ($row['act_comite'] == 0 and ($row['sagr_id'] == 1 or $row['sagr_id'] == 2));
		$obj->box_id = $row['box_id'];
		$obj->box_numero = utf8_encode($row['box_numero']);
		$obj->lugar_id = $row['lug_id'];
		$obj->lugar_nombre = utf8_encode($row['lug_nombre']);
		$obj->us_id = $row['us_id'];
		$obj->age_periodo = $row['age_periodo'];
		$obj->age_dia = $row['age_dia'];
		$obj->age_hora_ini = $row['age_hora_ini'];
		$obj->age_hora_ter = $row['age_hora_ter'];
		$obj->age_cuposObs = utf8_encode($row['age_observacion']);
		$obj->age_ultima = $row['age_ultima'];

		/*Persona*/
		$obj->per_id = $row['per_id'];
		$obj->per_prid = $row['prof_id'];
		$obj->per_profesion = utf8_encode($row['prof_nombre']);
		$obj->per_rut = utf8_encode($row['per_rut']);
		$obj->per_nombres = utf8_encode($row['per_nombres'] . " " . $row['per_ap'] . " " . $row['per_am']);
		$obj->per_ap = utf8_encode($row['per_ap']);
		$obj->per_am = utf8_encode($row['per_am']);
		$obj->per_rec = utf8_encode($row['per_rec']);

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

		$stmt = $db->Prepare("SELECT age_id FROM prm_agenda");

		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['age_id'], $db);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $id
	 * @param $db
	 * @return array
	 */
	public function getCupos($id, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT acu_id, ac.tcu_id, ptc.tcu_descripcion, acu_numero
									FROM prm_agenda_cupos ac
									JOIN prm_tipo_cupo ptc on ac.tcu_id = ptc.tcu_id
									WHERE age_id = ?");

		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$obj = new stdClass();
			$obj->acu_id = $row['acu_id'];
			$obj->age_id = $id;
			$obj->tcu_id = $row['tcu_id'];
			$obj->tcu_descripcion = utf8_encode($row['tcu_descripcion']);
			$obj->acu_numero = $row['acu_numero'];

			$lista[] = $obj;
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $person
	 * @param $est
	 * @param $year
	 * @param $periodo
	 * @param $db
	 * @return array
	 */
	public function getEventsByPerson($person, $est, $year, $periodo, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT age_id
									FROM prm_agenda a
									JOIN prm_box b ON a.box_id = b.box_id
									JOIN prm_estab_lugar pel on b.lug_id = pel.lug_id
									WHERE per_id = ? AND est_id = ?
									AND YEAR(age_periodo) = ? AND MONTH(age_periodo) = ?
									AND age_ultima IS TRUE");

		$stmt->bind_param("iiss", $person, $est, $year, $periodo);
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$obj = $this->get($row['age_id'], $db);
			$lista[] = $obj;
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $person
	 * @param $esp
	 * @param $est
	 * @param $year
	 * @param $periodo
	 * @param $db
	 * @return array
	 */
	public function getEventsByPersonEsp($person, $esp, $est, $year, $periodo, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT age_id
									FROM prm_agenda a
									JOIN prm_box b ON a.box_id = b.box_id
									JOIN prm_estab_lugar pel on b.lug_id = pel.lug_id
									WHERE per_id = ? AND esp_id = ? AND est_id = ?
									AND YEAR(age_periodo) = ? AND MONTH(age_periodo) = ?
									AND age_ultima IS TRUE");

		$stmt->bind_param("iiiss", $person, $esp, $est, $year, $periodo);
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$obj = $this->get($row['age_id'], $db);
			$lista[] = $obj;
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $person
	 * @param $est
	 * @param $year
	 * @param $db
	 * @return array
	 */
	public function getLastAgenda($person, $est, $year, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT age_id
									FROM prm_agenda a
									JOIN prm_box b ON a.box_id = b.box_id
									JOIN prm_estab_lugar pel on b.lug_id = pel.lug_id
									WHERE per_id = ? AND est_id = ?
									AND YEAR(age_periodo) = ?
									AND age_ultima IS TRUE");

		$stmt->bind_param("iis", $person, $est, $year);
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$obj = $this->get($row['age_id'], $db);
			$lista[] = $obj;
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $box
	 * @param $year
	 * @param $periodo
	 * @param $db
	 * @return array
	 */
	public function getOccupationByPeriodo($box, $year, $periodo, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT age_id
									FROM prm_agenda
									WHERE box_id = ? 
									AND YEAR(age_periodo) = ? AND MONTH(age_periodo) = ?
									AND age_ultima IS TRUE");

		$stmt->bind_param("iss", $box, $year, $periodo);
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$obj = $this->get($row['age_id'], $db);
			$lista[] = $obj;
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $box
	 * @param $year_i
	 * @param $periodo_i
	 * @param $db
	 * @return array
	 */
	public function getOccupationByLastPeriodo($box, $year_i, $periodo_i, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT age_id
									FROM prm_agenda
									WHERE box_id = ? AND YEAR(age_periodo) = ? AND MONTH(age_periodo) = ?
									AND age_ultima IS TRUE");

		$stmt->bind_param("iss", $box, $year_i, $periodo_i);
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['age_id'], $db);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $year
	 * @param $period
	 * @param $est
	 * @param $planta
	 * @param $cr
	 * @param $serv
	 * @param $db
	 * @return array
	 */
	public function getAgendasByFilters($year, $period, $est, $planta, $cr, $serv, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		if ($period == ''):
			$month = date('n');

			if ($month >= 1 and $month < 4):
				$period = '01';
			elseif ($month >= 4 and $month < 7):
				$period = '04';
			elseif ($month >= 7 and $month < 10):
				$period = '07';
			else:
				$period = '10';
			endif;
		endif;

		$estab = ($est != '') ? "AND pel.est_id = $est" : '';

		switch ($planta):
			case '0':
				$cond = "AND p.prof_id = 6";
				break;
			case '1':
				$cond = "AND p.prof_id <> 6 AND p.prof_id <> 8";
				break;
			case '2':
				$cond = "AND p.prof_id = 8";
				break;
			default:
				$cond = '';
				break;
		endswitch;

		$scr = ($cr != '') ? "AND s.cr_id = $cr" : '';
		$sserv = ($serv != '') ? "AND d.ser_id = $serv" : '';

		$stmt = $db->Prepare("SELECT p.per_id, p.per_rut, p.per_nombres, p.per_ap, p.per_am, pr.prof_id, pr.prof_nombre
                                    FROM prm_agenda a
                                    JOIN prm_persona p ON a.per_id = p.per_id
                                    JOIN prm_profesion pr ON p.prof_id = pr.prof_id
                                    JOIN prm_distribucion_prog d on p.per_id = d.per_id
                                    JOIN prm_servicio s ON d.ser_id = s.ser_id
                                    JOIN prm_box b ON a.box_id = b.box_id
                                    JOIN prm_estab_lugar pel on b.lug_id = pel.lug_id
                                    WHERE YEAR(age_periodo) = ? AND MONTH(age_periodo) = $period
                                    $estab $cond $scr $sserv
                                    AND age_ultima = TRUE
                                    GROUP BY p.per_id
                                    ORDER BY p.per_ap ASC, p.per_am ASC, p.per_nombres ASC");

		$stmt->bind_param("s", $db->clearText($year));
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$obj = new stdClass();
			$obj->ayear = $year;
			$obj->aperiod = $period;
			$obj->estab = $est;
			$obj->per_id = $row['per_id'];
			$obj->per_rut = $row['per_rut'];
			$obj->per_nombres = utf8_encode($row['per_nombres']);
			$obj->per_ap = utf8_encode($row['per_ap']);
			$obj->per_am = utf8_encode($row['per_am']);
			$obj->per_profid = $row['prof_id'];
			$obj->per_profesion = utf8_encode($row['prof_nombre']);
			$lista[] = $obj;
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $periodo
	 * @param $year
	 * @param $est
	 * @param $planta
	 * @param $serv
	 * @param $esp
	 * @param $db
	 * @return array
	 */
	public function getAgendasByPeriod($periodo, $year, $est, $planta, $serv, $esp, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$estab = ($est != '') ? "AND pel.est_id = $est" : '';

		switch ($planta):
			case '0':
				$cond = "AND p.prof_id = 6";
				break;
			case '1':
				$cond = "AND p.prof_id <> 6 AND p.prof_id <> 8";
				break;
			case '2':
				$cond = "AND p.prof_id = 8";
				break;
			default:
				$cond = '';
				break;
		endswitch;

		$per_date = $year . '-' . $periodo . '-00';

		$stmt = $db->Prepare("SELECT p.per_id, p.per_rut, p.per_nombres, p.per_ap, p.per_am, pr.prof_id, pr.prof_nombre
                                    FROM prm_agenda a
                                    JOIN prm_persona p ON a.per_id = p.per_id
                                    JOIN prm_profesion pr ON p.prof_id = pr.prof_id
                                    JOIN prm_distribucion_prog d on p.per_id = d.per_id
                                    JOIN prm_servicio s ON d.ser_id = s.ser_id
                                    JOIN prm_box b ON a.box_id = b.box_id
                                    JOIN prm_estab_lugar pel on b.lug_id = pel.lug_id
                                    WHERE age_periodo = ? AND a.esp_id = ?
                                    $estab $cond
                                    AND age_ultima = TRUE
                                    GROUP BY p.per_id
                                    ORDER BY p.per_ap ASC, p.per_am ASC, p.per_nombres ASC");

		$stmt->bind_param("si", $db->clearText($per_date), $db->clearText($esp));
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$obj = new stdClass();
			$obj->a_year = $year;
			$obj->a_month = $periodo;
			$obj->a_est = $est;
			$obj->a_serv = $serv;
			$obj->a_esp = $esp;
			$obj->per_id = $row['per_id'];
			$obj->per_rut = $row['per_rut'];
			$obj->per_nombres = utf8_encode($row['per_nombres']);
			$obj->per_ap = utf8_encode($row['per_ap']);
			$obj->per_am = utf8_encode($row['per_am']);
			$obj->per_profid = $row['prof_id'];
			$obj->per_profesion = utf8_encode($row['prof_nombre']);
			$lista[] = $obj;
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $periodo
	 * @param $year
	 * @param $est
	 * @param $planta
	 * @param $servicio
	 * @param $espec
	 * @param $db
	 * @return mixed
	 */
	public function getAgendables($periodo, $year, $est, $planta, $servicio, $espec, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$cond = '';

		switch ($planta):
			case '0':
				$cond = "AND p.prof_id = 6";
				break;
			case '1':
				$cond = "AND p.prof_id <> 6 AND p.prof_id <> 8";
				break;
			case '2':
				$cond = "AND p.prof_id = 8";
				break;
			default:
				break;
		endswitch;

		$estab = ($est != '') ? "AND pe.est_id = $est" : "";
		$spec = ($espec != '') ? "AND dp.esp_id = $espec" : '';

		$stmt = $db->Prepare("SELECT DISTINCT(p.per_id), p.per_rut, per_nombres, per_ap, per_am, prof_nombre
									FROM prm_persona p
									JOIN prm_distribucion_prog dp ON p.per_id = dp.per_id
									LEFT JOIN prm_profesion ps ON p.prof_id = ps.prof_id
									JOIN prm_persona_establecimiento pe ON p.per_id = pe.per_id
									WHERE (jus_id IS OR jus_id <> 5 OR jus_id <> 20 OR jus_id <> 21 OR jus_id <> 23 OR jus_id <> 24)
									AND ser_id = ?
									AND YEAR(disp_fecha_ini) = ?
									AND disp_ultima = TRUE
									AND p.per_id NOT IN 
										(SELECT p.per_id FROM prm_agenda p WHERE age_periodo = ? AND p.esp_id = ? AND age_ultima IS TRUE)
									$cond $estab $spec");

		$date = $year . '-' . $periodo . '-00';
		$stmt->bind_param("issi", $servicio, $db->clearText($year), $db->clearText($date), $espec);
		$stmt->execute();
		$result = $stmt->get_result();
		$lista['data'] = [];

		while ($row = $result->fetch_assoc()):
			$obj = new stdClass();
			$obj->dist_year = $year;
			$obj->dist_month = $periodo;
			$obj->dist_serv = $servicio;
			$obj->dist_est = $est;
			$obj->dist_esp = $espec;
			$obj->per_id = $row['per_id'];
			$obj->per_rut = utf8_encode($row['per_rut']);
			$obj->per_nombres = utf8_encode($row['per_nombres']);
			$obj->per_ap = utf8_encode($row['per_ap']);
			$obj->per_am = utf8_encode($row['per_am']);
			$obj->per_profesion = utf8_encode($row['prof_nombre']);
			$lista['data'][] = $obj;
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $per
	 * @param $esp
	 * @param $act
	 * @param $subesp
	 * @param $box
	 * @param $user
	 * @param $periodo
	 * @param $dia
	 * @param $ini
	 * @param $fin
	 * @param $cuposObs
	 * @param $db
	 * @return array
	 */
	public function set($per, $esp, $act, $subesp, $box, $user, $periodo, $dia, $ini, $fin, $cuposObs, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		try {
			$stmt = $db->Prepare("INSERT INTO prm_agenda (per_id, esp_id, act_id, ssub_id, box_id, us_id, age_periodo, age_dia, age_hora_ini, age_hora_ter, age_observacion, age_ultima) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, TRUE)");
			/*
			echo "INSERT INTO prm_agenda (per_id, esp_id, act_id, ssub_id, box_id, us_id, tcu_id, age_periodo, age_dia, age_hora_ini, age_hora_ter, age_cupos, age_observacion, age_ultima)
                                    VALUES ($per, $esp, $act, $subesp, $box, $user, $tipoCupo, $periodo, $dia, $ini, $fin, $cupos, $cuposObs, TRUE)";
			*/
			if (!$stmt):
				throw new Exception("La inserción de la agenda falló en su preparación.");
			endif;

			$bind = $stmt->bind_param("iiiiiisssss", $db->clearText($per), $db->clearText($esp), $db->clearText($act), $db->clearText($subesp), $db->clearText($box), $db->clearText($user),
				$db->clearText($periodo), $db->clearText($dia), $db->clearText($ini), $db->clearText($fin), utf8_decode($db->clearText($cuposObs)));
			if (!$bind):
				throw new Exception("La inserción de la agenda falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La inserción de la agenda falló en su ejecución.");
			endif;

			$result = array('estado' => true, 'msg' => $stmt->insert_id);
			$stmt->close();
			return $result;
		} catch (Exception $e) {
			$result = array('estado' => false, 'msg' => $e->getMessage());
			return $result;
		}
	}

	/**
	 * @param $id
	 * @param $tipo
	 * @param $numero
	 * @param $db
	 * @return array
	 */
	public function setCupos($id, $tipo, $numero, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		try {
			$stmt = $db->Prepare("INSERT INTO prm_agenda_cupos (age_id, tcu_id, acu_numero) VALUES (?, ?, ?)");

			if (!$stmt):
				throw new Exception("La inserción de los cupos de agenda falló en su preparación.");
			endif;

			$bind = $stmt->bind_param("iid", $db->clearText($id), $db->clearText($tipo), $db->clearText($numero));
			if (!$bind):
				throw new Exception("La inserción de los cupos de agenda falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La inserción de los cupos de agenda falló en su ejecución.");
			endif;

			$result = array('estado' => true, 'msg' => $stmt->insert_id);
			$stmt->close();
			return $result;
		} catch (Exception $e) {
			$result = array('estado' => false, 'msg' => $e->getMessage());
			return $result;
		}
	}

	/**
	 * @param $per
	 * @param $esp
	 * @param $db
	 * @return array
	 */
	public function setLast($per, $esp, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		try {
			$stmt = $db->Prepare("UPDATE prm_agenda SET age_ultima = FALSE WHERE per_id = ? AND esp_id = ?");

			if (!$stmt):
				throw new Exception("La actualización de la agenda falló en su preparación.");
			endif;

			$bind = $stmt->bind_param("ii", $db->clearText($per), $db->clearText($esp));
			if (!$bind):
				throw new Exception("La actualización de la agenda falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La actualización de la agenda falló en su ejecución.");
			endif;

			$result = array('estado' => true, 'msg' => 'OK');
			$stmt->close();
			return $result;
		} catch (Exception $e) {
			$result = array('estado' => false, 'msg' => $e->getMessage());
			return $result;
		}
	}
}