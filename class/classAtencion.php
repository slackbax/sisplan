<?php

class Atencion {
    
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
        
        $stmt = $db->Prepare("SELECT a.* FROM prm_atencion a
                                    WHERE a.at_id = ?");
        
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $obj = new stdClass();
        
        $row = $result->fetch_assoc();
        $obj->at_id = $row['at_id'];
        $obj->at_actid = $row['act_id'];
        $obj->at_perid = $row['per_id'];
        $obj->at_fecha = $row['at_fecha'];
        $obj->at_cantidad = $row['at_cantidad'];
		$obj->at_estabid = $row['est_id'];

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
        
        $stmt = $db->Prepare("SELECT at_id FROM prm_atencion");
        
        $stmt->execute();
        $result = $stmt->get_result();
        $lista = [];
        
        while ($row = $result->fetch_assoc()):
            $lista[] = $this->get($row['at_id'], $db);
        endwhile;
        
        unset($db);
        return $lista;
    }

	/**
	 * @param $per
	 * @param $fecha
	 * @param $comite
	 * @param $est
	 * @param $db
	 * @return array
	 */
    public function getByPerComite($per, $fecha, $comite, $est, $db = null) {
        if (is_null($db)):
            $db = new myDBC();
        endif;
        
        $com = ($comite) ? TRUE : FALSE;

        $stmt = $db->Prepare("SELECT a.* FROM prm_atencion a
                                    JOIN prm_actividad ac ON a.act_id = ac.act_id
                                    WHERE a.per_id = ? AND a.at_fecha = ? AND ac.act_comite = ? AND a.est_id = ?");
        
        $stmt->bind_param("isii", $db->clearText($per), $db->clearText($fecha), $com, $db->clearText($est));
        $stmt->execute();
        $result = $stmt->get_result();
        $lista = [];
        
        while ($row = $result->fetch_assoc()):
            $lista[] = $this->get($row['at_id'], $db);
        endwhile;
        
        unset($db);
        return $lista;
    }

	/**
	 * @param $tat
	 * @param $act
	 * @param $per
	 * @param $fecha
	 * @param $db
	 * @return stdClass
	 */
    public function getByParams($tat, $act, $per, $fecha, $estab, $db = null) {
        if (is_null($db)):
            $db = new myDBC();
        endif;
        
        $stmt = $db->Prepare("SELECT a.* FROM prm_atencion a
                                    WHERE a.tat_id = ? AND a.act_id = ? AND a.per_id = ? AND a.at_fecha = ? AND a.est_id = ?");
        
        $stmt->bind_param("iiisi", $db->clearText($tat), $db->clearText($act), $db->clearText($per), $db->clearText($fecha), $db->clearText($estab));
        $stmt->execute();
        $result = $stmt->get_result();
        $obj = new stdClass();
        
        $row = $result->fetch_assoc();
        $obj->at_id = $row['at_id'];
        $obj->at_actid = $row['act_id'];
        $obj->at_perid = $row['per_id'];
        $obj->at_fecha = $row['at_fecha'];
        $obj->at_cantidad = $row['at_cantidad'];
		$obj->at_estabid = $row['est_id'];

        unset($db);
        return $obj;
    }

	/**
	 * @param $tat
	 * @param $act
	 * @param $per
	 * @param $fecha
	 * @param $db
	 * @return array
	 */
    public function set($tat, $act, $per, $fecha, $estab, $db = null) {
        if (is_null($db)):
            $db = new myDBC();
        endif;
        
        try {
            $stmt = $db->Prepare("INSERT INTO prm_atencion (tat_id, act_id, per_id, at_fecha, at_cantidad, est_id) 
                                     VALUES (?, ?, ?, ?, 1, ?)");

            if (!$stmt):
                throw new Exception("La inserción de la atención falló en su preparación.");
            endif;

            $bind = $stmt->bind_param("iiisi", $db->clearText($tat), $db->clearText($act), $db->clearText($per), $db->clearText($fecha), $db->clearText($estab));
            if (!$bind):
                throw new Exception("La inserción de la atención falló en su binding.");
            endif;
            
            echo "INSERT INTO prm_atencion (tat_id, act_id, per_id, at_fecha, at_cantidad, estab) VALUES ($tat, $act, $per, $fecha, 1, $estab)";
            if (!$stmt->execute()):
                throw new Exception("La inserción de la atención falló en su ejecución.");
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
	 * @param $id
	 * @param $db
	 * @return array
	 */
    public function update($id, $db = null) {
        if (is_null($db)):
            $db = new myDBC();
        endif;
        
        try {
            $stmt = $db->Prepare("UPDATE prm_atencion SET at_cantidad = at_cantidad + 1 WHERE at_id = ?");

            if (!$stmt):
                throw new Exception("La inserción de la atención falló en su preparación.");
            endif;

            $bind = $stmt->bind_param("i", $db->clearText($id));
            if (!$bind):
                throw new Exception("La inserción de la atención falló en su binding.");
            endif;

            if (!$stmt->execute()):
                throw new Exception("La inserción de la atención falló en su ejecución.");
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

