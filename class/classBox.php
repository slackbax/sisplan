<?php

class Box {

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

		$stmt = $db->Prepare("SELECT * 
									FROM prm_box b
									JOIN prm_estab_lugar pel on b.lug_id = pel.lug_id
									LEFT JOIN prm_box_tipo tipo on b.box_id = tipo.box_id
									LEFT JOIN prm_tipo_box ptb on tipo.tbox_id = ptb.tbox_id
                                    WHERE b.box_id = ?");

		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->box_id = $row['box_id'];
		$obj->lugar_id = $row['lug_id'];
		$obj->lugar_nombre = utf8_encode($row['lug_nombre']);
		$obj->box_numero = $row['box_numero'];
		$obj->box_descripcion = utf8_encode($row['box_descripcion']);
		$obj->box_activo = $row['box_activo'];
		$obj->bot_descripcion = utf8_encode($row['tbox_descripcion']);

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

		$stmt = $db->Prepare("SELECT b.box_id FROM prm_box b ORDER BY b.box_descripcion");

		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['box_id']);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $box
	 * @param $fecha
	 * @param $db
	 * @return stdClass
	 */
	public function getOccupation($box, $fecha, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT WEEKDAY(bh.bh_fecha) AS dia, bh.*, bx.*, pr.*, per.per_rut, per.per_nombres, bc.*, pel.* 
									FROM prm_bloque_hora bh
									JOIN prm_box bx ON bh.box_id = bx.box_id
									JOIN prm_persona per ON bh.per_id = per.per_id
									JOIN prm_profesion pr ON per.prof_id = pr.prof_id 
									JOIN prm_estab_lugar pel on bx.lug_id = pel.lug_id
									LEFT JOIN prm_box_caracteristica bc ON bx.box_id = bc.box_id 
									AND bh.bles_id = 1
									WHERE bh.box_id = ? and bh.bh_fecha = ? 
									GROUP BY bh.bh_id, bh.bh_fecha, bh.bh_hora_ini
									ORDER BY bh.bh_fecha, bh.bh_hora_ini");

		$stmt->bind_param("is", $box, $fecha);
		$stmt->execute();
		$result = $stmt->get_result();

		$row = $result->fetch_assoc();
		$obj = new stdClass();
		$obj->box = $row['box_id'];
		$obj->fecha = $row['bh_fecha'];
		$obj->hora_ini = $row['bh_hora_ini'];
		$obj->box_numero = $row['box_numero'];
		$obj->prof_nombre = $row['prof_nombre'];
		$obj->per_nombres = $row['per_nombres'];

		unset($db);
		return $obj;
	}

	/**
	 * @param $box
	 * @param $fechai
	 * @param $fechat
	 * @param $db
	 * @return stdClass
	 */
	public function getOccupationByFecha($box, $fechai, $fechat, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT WEEKDAY(bh.bh_fecha) AS dia, bh.*, bx.*, pr.*, per.per_rut, per.per_nombres, bc.* 
									FROM prm_bloque_hora bh
									JOIN prm_box bx ON bh.box_id = bx.box_id
									JOIN prm_persona per ON bh.per_id = per.per_id
									JOIN prm_profesion pr ON per.prof_id = pr.prof_id 
									LEFT JOIN prm_box_caracteristica bc ON bx.box_id = bc.box_id 
									AND bh.bles_id = 1
									WHERE bh.box_id = ? and bh.bh_fecha  BETWEEN ? AND ?
									GROUP BY bh.bh_id, bh.bh_fecha, bh.bh_hora_ini
									ORDER BY bh.bh_fecha, bh.bh_hora_ini");

		$stmt->bind_param("iss", $box, $fechai, $fechat);
		$stmt->execute();
		$result = $stmt->get_result();

		$row = $result->fetch_assoc();
		$obj = new stdClass();
		$obj->dia = $row['dia'];
		$obj->box = $row['box_id'];
		$obj->fecha = $row['bh_fecha'];
		$obj->hora_ini = $row['bh_hora_ini'];
		$obj->hora_ter = $row['bh_hora_ter'];
		$obj->rango_hora = $row['bh_hora_ini'] . " a " . $row['bh_hora_ter'];;
		$obj->box_numero = $row['box_numero'];
		$obj->prof_nombre = $row['prof_nombre'];
		$obj->per_nombres = $row['per_nombres'];

		unset($db);
		return $obj;
	}

	/**
	 * @param $floor
	 * @param $type
	 * @param $db
	 * @return array
	 */
	public function getByFloor($floor, $type, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$str_type = (!empty($type)) ? ' AND tbox_id = ' . $type : '';

		$stmt = $db->Prepare("SELECT b.box_id 
								FROM prm_box b
								LEFT JOIN prm_box_tipo tipo on b.box_id = tipo.box_id
								WHERE b.lug_id = ? $str_type
								GROUP BY box_id");

		$stmt->bind_param("s", $floor);
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['box_id']);
		endwhile;

		unset($db);
		return $lista;
	}

}