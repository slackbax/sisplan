<?php

include("../class/classMyDBC.php");
include("../src/fn.php");
session_start();

$f_ini = (isset($_GET['idate'])) ? setDateBD($_GET['idate']) : setDateBD($_GET['date_i']);
$f_ter = (isset($_GET['idatet'])) ? setDateBD($_GET['idatet']) : setDateBD($_GET['date_t']);

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use
$table = 'prm_bloque_hora';

// Table's primary key
$primaryKey = 'bh_id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array('db' => 'lug_nombre', 'dt' => 0, 'field' => 'lug_nombre',
		'formatter' => function ($d, $row) {
			return utf8_encode($d);
		}
	),
	array('db' => 'box_numero', 'dt' => 1, 'field' => 'box_numero',
		'formatter' => function ($d, $row) {
			return utf8_encode($d);
		}
	),
	array('db' => 'per_rut', 'dt' => 2, 'field' => 'per_rut'),
	array('db' => 'per_nombres', 'dt' => 3, 'field' => 'per_nombres',
		'formatter' => function ($d, $row) {
			return utf8_encode($d);
		}
	),
	array('db' => 'per_ap', 'dt' => 4, 'field' => 'per_ap',
		'formatter' => function ($d, $row) {
			return utf8_encode($d);
		}
	),
	array('db' => 'per_am', 'dt' => 5, 'field' => 'per_am',
		'formatter' => function ($d, $row) {
			return utf8_encode($d);
		}
	),
	array('db' => 'act_nombre', 'dt' => 6, 'field' => 'act_nombre',
		'formatter' => function ($d, $row) {
			return utf8_encode($d);
		}
	),
	array('db' => 'ssub_nombre', 'dt' => 7, 'field' => 'ssub_nombre',
		'formatter' => function ($d, $row) {
			return utf8_encode($d);
		}
	),
	array('db' => 'bh_fecha', 'dt' => 8, 'field' => 'bh_fecha',
		'formatter' => function ($d, $row) {
			return getDateToForm($d);
		}
	),
	array('db' => 'bh_hora_ini', 'dt' => 9, 'field' => 'bh_hora_ini'),
	array('db' => 'bh_hora_ter', 'dt' => 10, 'field' => 'bh_hora_ter')
);

$str_estab = (isset($_GET['iestab'])) ? 'AND el.est_id = ' . $_GET['iestab'] : 'AND el.est_id = ' . $_SESSION['prm_estid'];
$str_lugar = (!empty($_GET['ipiso'])) ? 'AND el.lug_id = ' . $_GET['ipiso'] : '';
$str_box = (!empty($_GET['ibox'])) ? 'AND b.box_id = ' . $_GET['ibox'] : '';

$joinQuery = "FROM prm_bloque_hora AS bh";
$joinQuery .= " JOIN prm_persona AS p ON bh.per_id = p.per_id ";
$joinQuery .= " JOIN prm_actividad AS a ON bh.act_id = a.act_id ";
$joinQuery .= " JOIN prm_sin_subespecialidad AS ss ON bh.ssub_id = ss.ssub_id ";
$joinQuery .= " JOIN prm_box AS b ON bh.box_id = b.box_id ";
$joinQuery .= " JOIN prm_estab_lugar AS el ON b.lug_id = el.lug_id ";
$extraWhere = "bh_programado IS FALSE AND bh_ultima IS TRUE AND bh_fecha BETWEEN '" . $f_ini . "' AND '" . $f_ter . "' $str_estab $str_lugar $str_box";

$groupBy = "";
$having = "";

// SQL server connection information
$sql_details = array(
	'user' => DB_USER,
	'pass' => DB_PASSWORD,
	'db' => DB_DATABASE,
	'host' => DB_HOST
);

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require('../src/ssp2.class.php');

echo json_encode(
	SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
);
