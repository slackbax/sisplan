<?php

class Profesion {

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

		$stmt = $db->Prepare("SELECT * FROM prm_profesion
                                    WHERE prof_id = ?");

		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->prof_id = $row['prof_id'];
		$obj->prof_nombre = utf8_encode($row['prof_nombre']);

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

		$stmt = $db->Prepare("SELECT prof_id FROM prm_profesion ORDER BY prof_nombre ASC");

		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['prof_id'], $db);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $name
	 * @param $db
	 * @return stdClass
	 */
	public function getByName($name, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$result = $db->runQuery('SELECT * FROM prm_profesion WHERE prof_nombre = "' . utf8_decode($name) . '"');

		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->prof_id = $row['prof_id'];
		$obj->prof_nombre = utf8_encode($row['prof_nombre']);

		unset($db);
		return $obj;
	}

	/**
	 * @param $name
	 * @param $db
	 * @return array
	 */
	public function set($name, $db = null) {
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$r = $db->runQuery('INSERT INTO prm_profesion (prof_nombre) VALUES ("' . utf8_decode($name) . '")');

		echo 'INSERT INTO prm_profesion (prof_nombre) VALUES ("' . $name . '")<br>';
		if ($r):
			$res = $db->runQuery('SELECT MAX(prof_id) AS prof_id FROM prm_profesion');
			$row = $res->fetch_assoc();

			$result = array('estado' => true, 'msg' => $row['prof_id']);
			return $result;
		else:
			$result = array('estado' => false, 'msg' => 'false');
			return $result;
		endif;
	}
}

