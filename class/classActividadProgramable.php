<?php

class ActividadProgramable
{

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

        $stmt = $db->Prepare("SELECT * FROM prm_actividad_prog WHERE acp_id = ?");

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $obj = new stdClass();

        $row = $result->fetch_assoc();
        $obj->acp_id = $row['acp_id'];
        $obj->acp_tacid = $row['tac_id'];
        $obj->acp_espid = $row['esp_id'];
        $obj->acp_codigo = $row['acp_codigo'];
        $obj->acp_descripcion = utf8_encode($row['acp_descripcion']);
        $obj->acp_desc_corta = utf8_encode($row['acp_desc_reporte']);
        $obj->acp_rendimiento = $row['acp_rendimiento'];

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

        $stmt = $db->Prepare("SELECT acp_id FROM prm_actividad_prog");

        $stmt->execute();
        $result = $stmt->get_result();
        $lista = [];

        while ($row = $result->fetch_assoc()):
            $lista[] = $this->get($row['acp_id'], $db);
        endwhile;

        unset($db);
        return $lista;
    }

    /**
     * @param $type
     * @param null $excep
     * @param null $db
     * @return array
     */
    public function getByType($type, $excep = null, $db = null)
    {
        if (is_null($db)):
            $db = new myDBC();
        endif;

        $string = '';
        if (!is_null($excep)):
            $string = ' AND acp_id NOT IN (';
            foreach ($excep as $item)
                $string .= $item . ',';

            $string = substr($string, 0,-1);
            $string .= ')';
        endif;

        $stmt = $db->Prepare('SELECT * FROM prm_actividad_prog WHERE tac_id = ?' . $string . ' AND acp_vigente IS TRUE ORDER BY acp_codigo');

        $stmt->bind_param("i", $type);
        $stmt->execute();
        $result = $stmt->get_result();
        $lista = [];

        while ($row = $result->fetch_assoc()):
            $lista[] = $this->get($row['acp_id'], $db);
        endwhile;

        unset($db);
        return $lista;
    }

    /**
     * @param null $db
     * @return array
     */
    public function getNoPoli($db = null)
    {
        if (is_null($db)):
            $db = new myDBC();
        endif;

        $stmt = $db->Prepare('SELECT * FROM prm_actividad_prog WHERE tac_id = 1 AND acp_id NOT IN (4,5,21) AND acp_vigente IS TRUE ORDER BY acp_codigo');

        $stmt->execute();
        $result = $stmt->get_result();
        $lista = [];

        while ($row = $result->fetch_assoc()):
            $lista[] = $this->get($row['acp_id'], $db);
        endwhile;

        unset($db);
        return $lista;
    }
}

