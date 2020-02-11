<?php

class Actividad {
    
    public function __construct() {}

	/**
	 * @param $id
	 * @param $db
	 * @return stdClass
	 */
    public function get($id, $db = null) {
        if (is_null($db)):
            $db = new myDBC();
        endif;
        
        $stmt = $db->Prepare("SELECT * FROM prm_actividad
                                    WHERE act_id = ?");
        
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $obj = new stdClass();
        
        $row = $result->fetch_assoc();
        $obj->act_id = $row['act_id'];
        $obj->act_nombre = utf8_encode($row['act_nombre']);
        $obj->act_comite = $row['act_comite'];
		$obj->act_multi = $row['act_multi'];

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
        
        $stmt = $db->Prepare("SELECT act_id FROM prm_actividad ORDER BY act_nombre ASC");
        
        $stmt->execute();
        $result = $stmt->get_result();
        $lista = [];
        
        while ($row = $result->fetch_assoc()):
            $lista[] = $this->get($row['act_id'], $db);
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

		$stmt = $db->Prepare("SELECT * FROM prm_actividad WHERE act_nombre = ?");

		$stmt->bind_param("s", utf8_decode($db->clearText($name)));
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		$obj = new stdClass();

		$obj->act_id = $row['act_id'];
		$obj->act_nombre = utf8_encode($row['act_nombre']);
		$obj->act_comite = $row['act_comite'];

		unset($db);
		return $obj;
	}

	/**
	 * @param $id
	 * @param $db
	 * @return array
	 */
	public function getBySubespecialidad($id, $db = null) {
        if (is_null($db)):
            $db = new myDBC();
        endif;

		$stmt = $db->Prepare("SELECT act_id FROM prm_actividad_subesp WHERE ssub_id = ?");

		$stmt->bind_param("i", $db->clearText($id));
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['act_id'], $db);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $name
	 * @param $comite
	 * @param $db
	 * @return array
	 */
    public function set($name, $comite, $db = null) {
        if (is_null($db)):
            $db = new myDBC();
        endif;
        
        $r = $db->runQuery('INSERT INTO prm_actividad (act_nombre, act_comite) VALUES ("' . utf8_decode($name) . '", ' . $comite . ')');

        if ($r):
            $res = $db->runQuery('SELECT MAX(act_id) AS act_id FROM prm_actividad');
            $row = $res->fetch_assoc();
            
            $result = array('estado' => true, 'msg' => $row['act_id']);
            return $result;
        else:
            $result = array('estado' => false, 'msg' => 'false');
            return $result;
        endif;
    }
}

