<?php

class PersonaEstablecimiento {
	public function __construct()
	{
	}

	/**
	 * @param $id
	 * @param $db
	 * @return stdClass
	 */
	public function get($id, $db = null)
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT *
                                    FROM prm_persona_establecimiento pe
									JOIN prm_tipo_contrato ptc on pe.con_id = ptc.con_id
                                    WHERE pes_id = ?");

		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->pes_id = $row['pes_id'];
		$obj->per_id = $row['per_id'];
		$obj->est_id = $row['est_id'];
		$obj->con_id = $row['con_id'];
		$obj->con_descripcion = $row['con_descripcion'];
		$obj->pes_correlativo = $row['pes_correlativo'];
		$obj->pes_horas = $row['pes_horas'];

		unset($db);
		return $obj;
	}

	/**
	 * @param $db
	 * @return array
	 */
	public function getAll($db = null)
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT per_id FROM prm_persona");

		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['per_id'], $db);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $per
	 * @param $est
	 * @param null $db
	 * @return mixed
	 */
	public function getTotalContratos($per, $est, $db = null)
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT SUM(pes_horas) as horas
                                    FROM prm_persona_establecimiento pe
									JOIN prm_tipo_contrato ptc on pe.con_id = ptc.con_id
                                    WHERE per_id = ? AND est_id = ?");

		$stmt->bind_param("ii", $per, $est);
		$stmt->execute();
		$result = $stmt->get_result();

		$row = $result->fetch_assoc();
		return $row['horas'];
	}

	/**
	 * @param $id
	 * @param $estab
	 * @param $cont
	 * @param $corr
	 * @param $horas
	 * @param null $db
	 * @return array
	 */
	public function set($id, $estab, $cont, $corr, $horas, $db = null)
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		try {
			$stmt = $db->Prepare("INSERT INTO prm_persona_establecimiento (per_id, est_id, con_id, pes_correlativo, pes_horas) 
                                     VALUES (?, ?, ?, ?, ?)");

			if (!$stmt):
				throw new Exception("La inserción del contrato falló en su preparación.");
			endif;

			$id = $db->clearText($id);
			$estab = $db->clearText($estab);
			$cont = $db->clearText($cont);
			$corr = $db->clearText($corr);
			$horas = $db->clearText($horas);
			$bind = $stmt->bind_param("iiiii", $id, $estab, $cont, $corr, $horas);
			if (!$bind):
				throw new Exception("La inserción del contrato falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La inserción del contrato falló en su ejecución.");
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
	 * @param $rut
	 * @param $nombre
	 * @param $prof
	 * @param null $db
	 * @return array
	 */
	public function mod($rut, $nombre, $prof, $db = null)
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		try {
			$stmt = $db->Prepare("UPDATE prm_persona SET per_nombres = ?, prof_id = ? WHERE per_rut = ?");

			if (!$stmt):
				throw new Exception("La edición de la persona falló en su preparación.");
			endif;

			$nombre = utf8_decode($db->clearText($nombre));
			$prof = $db->clearText($prof);
			$rut = utf8_decode($db->clearText($rut));
			$bind = $stmt->bind_param("iss", $nombre, $prof, $rut);
			if (!$bind):
				throw new Exception("La edición de la persona falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La edición de la persona falló en su ejecución.");
			endif;

			$result = array('estado' => true, 'msg' => true);
			$stmt->close();
			return $result;
		} catch (Exception $e) {
			$result = array('estado' => false, 'msg' => $e->getMessage());
			return $result;
		}
	}
}