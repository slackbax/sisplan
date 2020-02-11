<?php

session_start();
include("../class/classMyDBC.php");
include("../class/classPersona.php");
include("../class/classDistribucionProg.php");
include("../class/classDistHorasProg.php");
include("../class/classActividadProgramable.php");
include("../src/fn.php");
$_admin = false;
$di = new DistribucionProg();
$h = new DistHorasProg();
$ap = new ActividadProgramable();

if (isset($_SESSION['prm_useradmin']) && $_SESSION['prm_useradmin']):
	$_admin = true;
endif;

$fecha = $_GET['iyear'] . '-' . $_GET['iperiodo'] . '-01';
$fecha_ter = $_GET['iyear'] . '-12-31';

$planta = $_GET['iplanta'];
$apro = $_GET['iappr'];

$est = (!$_admin) ? $_SESSION['prm_estid'] : $_GET['iest'];

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
$table = 'prm_persona';

// Table's primary key
$primaryKey = 'prm_persona.per_id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array(
		'db' => 'per_nombres',
		'dt' => 0,
		'formatter' => function ($d, $row) {
			return utf8_encode($d);
		}
	),
	array(
		'db' => 'ser_nombre',
		'dt' => 1,
		'formatter' => function ($d, $row) {
			return utf8_encode($d);
		}
	),
	array(
		'db' => 'esp_nombre',
		'dt' => 2,
		'formatter' => function ($d, $row) {
			return utf8_encode($d);
		}
	),
	array(
		'db' => 'disp_descripcion',
		'dt' => 3,
		'formatter' => function ($d, $row) {
			return utf8_encode($d);
		}
	),
	array(
		'db' => 'disp_fecha_ini',
		'dt' => 4,
		'formatter' => function ($d, $row) use ($di) {
			return getDateBD($d);
		}
	),
	array(
		'db' => 'prm_distribucion_prog.disp_id',
		'dt' => 5,
		'formatter' => function ($d, $row) use ($h) {
			$num = $h->getByDistTH($d, 1);
			return $num->dhp_cantidad;
		}
	),
	array(
		'db' => 'prm_distribucion_prog.disp_id',
		'dt' => 6,
		'formatter' => function ($d, $row) use ($h) {
			$num = $h->getByDistTH($d, 2);
			return $num->dhp_cantidad;
		}
	),
	array(
		'db' => 'prm_distribucion_prog.disp_id',
		'dt' => 7,
		'formatter' => function ($d, $row) use ($h) {
			$num = $h->getByDistTH($d, 3);
			return $num->dhp_cantidad;
		}
	),
	array(
		'db' => 'prm_distribucion_prog.disp_id',
		'dt' => 8,
		'formatter' => function ($d, $row) use ($di) {
			$num = $di->getTotalDisp($d);
			return $num;
		}
	)
);

$a_i = 9;
//actividades policlinico
$ind = array(4,5,21);
foreach ($ind as $i):
	$actp = $ap->get($i);

	$ar = array(
		'db' => 'prm_distribucion_prog.disp_id',
		'dt' => $a_i,
		'formatter' => function ($d, $row) use ($h, $i) {
			$num = $h->getByDistTH($d, $i);
			return $num->dhp_cantidad;
		}
	);

	array_push($columns, $ar);
	$a_i++;
endforeach;

//TOTAL POLI
$ar = array(
	'db' => 'prm_distribucion_prog.disp_id',
	'dt' => 12,
	'formatter' => function ($d, $row) {
		$h = new DistribucionProg();
		$num = $h->getTotalPoli($d);
		unset($h);
		return $num;
	}
);
array_push($columns, $ar);

$a_i = 13;
for ($i = 6; $i < 21; $i++):
	$actp = $ap->get($i);

	$ar = array(
		'db' => 'prm_distribucion_prog.disp_id',
		'dt' => $a_i,
		'formatter' => function ($d, $row) use ($h, $i) {
			$num = $h->getByDistTH($d, $i);
			return $num->dhp_cantidad;
		}
	);

	array_push($columns, $ar);
	$a_i++;
endfor;

//28
for ($i = 22; $i < 55; $i++):
	$actp = $ap->get($i);

	$ar = array(
		'db' => 'prm_distribucion_prog.disp_id',
		'dt' => $a_i,
		'formatter' => function ($d, $row) use ($h, $i) {
			$num = $h->getByDistTH($d, $i);
			return $num->dhp_cantidad;
		}
	);

	array_push($columns, $ar);
	$a_i++;
endfor;

//TOTAL
$ar = array(
	'db' => 'prm_distribucion_prog.disp_id',
	'dt' => 61,
	'formatter' => function ($d, $row) use ($di) {
		$num = $di->getTotal($d);
		return $num;
	}
);
array_push($columns, $ar);

//BOTONES
$ar = array(
	'db' => 'prm_distribucion_prog.disp_id',
	'dt' => 62,
	'formatter' => function ($d, $row) use ($di, $_admin) {
		$dist = $di->get($d);

		$string = '';

		if (!$dist->disp_aprobada and $_admin):
			$string .= ' <button id="aprid_' . $d . '" class="approve btn btn-xs btn-success" data-tooltip="tooltip" data-placement="top" title="Aprobar"><i class="fa fa-check"></i></button>';
		endif;

		return $string;
	}
);
array_push($columns, $ar);

$joins = ' JOIN prm_persona_establecimiento ON prm_persona.per_id = prm_persona_establecimiento.per_id ';
$joins .= ' JOIN prm_distribucion_prog ON prm_persona_establecimiento.pes_id = prm_distribucion_prog.pes_id ';
$joins .= ' LEFT JOIN prm_especialidad ON prm_distribucion_prog.esp_id = prm_especialidad.esp_id ';
$joins .= ' LEFT JOIN prm_servicio ON prm_distribucion_prog.ser_id = prm_servicio.ser_id ';

$str = '';

switch ($planta):
	case '0':
		$str = "AND prm_persona.prof_id = 14";
		break;
	case '1':
		$str = "AND prm_persona.prof_id <> 14 AND prm_persona.prof_id <> 4 AND prm_persona.prof_id <> 16";
		break;
	case '2':
		$str = "AND prm_persona.prof_id = 4 OR prm_persona.prof_id = 16";
		break;
	default:
		break;
endswitch;

switch ($est):
	case '':
		$str .= "";
		break;
	default:
		$str .= " AND prm_persona_establecimiento.est_id = $est ";
		break;
endswitch;

switch ($apro):
	case '0':
		$str .= " AND prm_distribucion_prog.disp_aprobada = TRUE";
		break;
	case '1':
		$str .= " AND prm_distribucion_prog.disp_aprobada = FALSE";
		break;
	default:
		break;
endswitch;

$where = " (prm_distribucion_prog.disp_fecha_ini = '" . $fecha . "' AND prm_distribucion_prog.disp_fecha_ter = '" . $fecha_ter . "' $str) ";

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

require('../src/ssp.class.php');

echo json_encode(
	SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $joins, null, $where)
);
