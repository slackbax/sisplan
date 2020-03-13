<?php

session_start();
include("../class/classMyDBC.php");
include("../src/fn.php");
$_admin = false;

if (isset($_SESSION['prm_useradmin']) && $_SESSION['prm_useradmin']):
	$_admin = true;
endif;

if (isset($_GET['iplanta']))
	$planta = $_GET['iplanta'];

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
$table = 'prm_persona_establecimiento';

// Table's primary key
$primaryKey = 'pes_id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array('db' => 'per_rut', 'dt' => 0, 'field' => 'per_rut'),
	array('db' => 'per_nombres', 'dt' => 1, 'field' => 'per_nombres'),
	array('db' => 'prof_nombre', 'dt' => 2, 'field' => 'prof_nombre'),
	array('db' => 'con_descripcion', 'dt' => 3, 'field' => 'con_descripcion'),
	array('db' => 'est_nombre', 'dt' => 4, 'field' => 'est_nombre'),
	array('db' => 'pes_correlativo', 'dt' => 5, 'field' => 'pes_correlativo'),
	array('db' => 'pes_horas', 'dt' => 6, 'field' => 'pes_horas')
);

$joinQuery = ' FROM prm_persona_establecimiento pe';
$joinQuery .= ' JOIN prm_persona p ON pe.per_id = p.per_id';
$joinQuery .= ' JOIN prm_profesion pr ON p.prof_id = pr.prof_id';
$joinQuery .= ' JOIN prm_tipo_contrato c ON pe.con_id = c.con_id';
$joinQuery .= ' JOIN prm_establecimiento e ON pe.est_id = e.est_id';

$extraWhere = '';

if (isset($planta) and $planta != ''):
	switch ($planta):
		case '0':
			$cond = "p.prof_id = 14";
			break;
		case '1':
			$cond = "p.prof_id <> 14 AND p.prof_id <> 4 AND p.prof_id <> 16";
			break;
		case '2':
			$cond = "p.prof_id = 4 OR p.prof_id = 16";
			break;
		default:
			break;
	endswitch;

	$extraWhere = $cond;
endif;

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
