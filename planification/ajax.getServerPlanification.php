<?php

include ("../class/classMyDBC.php");
include ("../class/classPersona.php");
include ("../class/classDistHoras.php");
include ("../src/fn.php");

if (isset($_POST['fecha'])):
    $fecha = $_POST['fecha'];
elseif (isset($_POST['idate'])):
    $f = explode('/', $_POST['idate']);
    $fecha = $f[1] . '-' . $f[0] . '-01';
endif;

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
        'db'        => 'DISTINCT(prm_persona.per_id)',
        'dt'        => 0,
        'formatter' => function( $d, $row ) {
            $p = new Persona();
            $per = $p->get($d);
            
            return $per->per_ap . ' ' . $per->per_am . ' ' . $per->per_nombres;
        }
    ),
    array(
        'db'        => 'prm_persona.per_id',
        'dt'        => 1,
        'formatter' => function( $d, $row ) {
            $h = new DistHoras();
            global $fecha;
            $num = $h->getByTypePeople($d, $fecha, 1);
            unset($h);
            return $num;
        }
    ),
    array( 
        'db'        => 'prm_persona.per_id',
        'dt'        => 2,
        'formatter' => function( $d, $row ) {
            $h = new DistHoras();
            global $fecha;
            $num = $h->getByTypePeople($d, $fecha, 2);
            unset($h);
            return $num;
        }
    ),
    array( 
        'db'        => 'prm_persona.per_id',
        'dt'        => 3,
        'formatter' => function( $d, $row ) {
            $h = new DistHoras();
            global $fecha;
            $num = $h->getByTypePeople($d, $fecha, 3);
            unset($h);
            return $num;
        }
    ),
    array(
        'db'        => 'prm_persona.per_id',
        'dt'        => 4,
        'formatter' => function( $d, $row ) {
            $h = new DistHoras();
            global $fecha;
            $num = $h->getTotalDisp($d, $fecha);
            unset($h);
            return $num;
        }
    ),
    array(
        'db'        => 'prm_persona.per_id',
        'dt'        => 5,
        'formatter' => function( $d, $row ) {
            $h = new DistHoras();
            global $fecha;
            $num = $h->getByTypePeople($d, $fecha, 4);
            unset($h);
            return $num;
        }
    ),
    array( 
        'db'        => 'prm_persona.per_id',
        'dt'        => 6,
        'formatter' => function( $d, $row ) {
            $h = new DistHoras();
            global $fecha;
            $num = $h->getByTypePeople($d, $fecha, 5);
            unset($h);
            return $num;
        }
    ),
    array( 
        'db'        => 'prm_persona.per_id',
        'dt'        => 7,
        'formatter' => function( $d, $row ) {
            $h = new DistHoras();
            global $fecha;
            $num = $h->getByTypePeople($d, $fecha, 6);
            unset($h);
            return $num;
        }
    ),
    array( 
        'db'        => 'prm_persona.per_id',
        'dt'        => 8,
        'formatter' => function( $d, $row ) {
            $h = new DistHoras();
            global $fecha;
            $num = $h->getByTypePeople($d, $fecha, 7);
            unset($h);
            return $num;
        }
    ),
    array( 
        'db'        => 'prm_persona.per_id',
        'dt'        => 9,
        'formatter' => function( $d, $row ) {
            $h = new DistHoras();
            global $fecha;
            $num = $h->getByTypePeople($d, $fecha, 8);
            unset($h);
            return $num;
        }
    ),
    array(
        'db'        => 'prm_persona.per_id',
        'dt'        => 10,
        'formatter' => function( $d, $row ) {
            $h = new DistHoras();
            global $fecha;
            $num = $h->getTotalPoli($d, $fecha);
            unset($h);
            return $num;
        }
    ),
    array( 
        'db'        => 'prm_persona.per_id',
        'dt'        => 11,
        'formatter' => function( $d, $row ) {
            $h = new DistHoras();
            global $fecha;
            $num = $h->getByTypePeople($d, $fecha, 9);
            unset($h);
            return $num;
        }
    ),
    array( 
        'db'        => 'prm_persona.per_id',
        'dt'        => 12,
        'formatter' => function( $d, $row ) {
            $h = new DistHoras();
            global $fecha;
            $num = $h->getByTypePeople($d, $fecha, 10);
            unset($h);
            return $num;
        }
    ),
    array( 
        'db'        => 'prm_persona.per_id',
        'dt'        => 13,
        'formatter' => function( $d, $row ) {
            $h = new DistHoras();
            global $fecha;
            $num = $h->getByTypePeople($d, $fecha, 11);
            unset($h);
            return $num;
        }
    ),
    array( 
        'db'        => 'prm_persona.per_id',
        'dt'        => 14,
        'formatter' => function( $d, $row ) {
            $h = new DistHoras();
            global $fecha;
            $num = $h->getByTypePeople($d, $fecha, 12);
            unset($h);
            return $num;
        }
    ),
    array( 
        'db'        => 'prm_persona.per_id',
        'dt'        => 15,
        'formatter' => function( $d, $row ) {
            $h = new DistHoras();
            global $fecha;
            $num = $h->getByTypePeople($d, $fecha, 13);
            unset($h);
            return $num;
        }
    ),
    array( 
        'db'        => 'prm_persona.per_id',
        'dt'        => 16,
        'formatter' => function( $d, $row ) {
            $h = new DistHoras();
            global $fecha;
            $num = $h->getByTypePeople($d, $fecha, 14);
            unset($h);
            return $num;
        }
    ),
    array( 
        'db'        => 'prm_persona.per_id',
        'dt'        => 17,
        'formatter' => function( $d, $row ) {
            $h = new DistHoras();
            global $fecha;
            $num = $h->getByTypePeople($d, $fecha, 15);
            unset($h);
            return $num;
        }
    ),
    array( 
        'db'        => 'prm_persona.per_id',
        'dt'        => 18,
        'formatter' => function( $d, $row ) {
            $h = new DistHoras();
            global $fecha;
            $num = $h->getByTypePeople($d, $fecha, 16);
            unset($h);
            return $num;
        }
    ),
    array( 
        'db'        => 'prm_persona.per_id',
        'dt'        => 19,
        'formatter' => function( $d, $row ) {
            $h = new DistHoras();
            global $fecha;
            $num = $h->getByTypePeople($d, $fecha, 17);
            unset($h);
            return $num;
        }
    ),
    array( 
        'db'        => 'prm_persona.per_id',
        'dt'        => 20,
        'formatter' => function( $d, $row ) {
            $h = new DistHoras();
            global $fecha;
            $num = $h->getByTypePeople($d, $fecha, 18);
            unset($h);
            return $num;
        }
    ),
    array( 
        'db'        => 'prm_persona.per_id',
        'dt'        => 21,
        'formatter' => function( $d, $row ) {
            $h = new DistHoras();
            global $fecha;
            $num = $h->getByTypePeople($d, $fecha, 19);
            unset($h);
            return $num;
        }
    ),
    array( 
        'db'        => 'prm_persona.per_id',
        'dt'        => 22,
        'formatter' => function( $d, $row ) {
            $h = new DistHoras();
            global $fecha;
            $num = $h->getByTypePeople($d, $fecha, 20);
            unset($h);
            return $num;
        }
    ),
    array( 
        'db'        => 'prm_persona.per_id',
        'dt'        => 23,
        'formatter' => function( $d, $row ) {
            $h = new DistHoras();
            global $fecha;
            $num = $h->getByTypePeople($d, $fecha, 21);
            unset($h);
            return $num;
        }
    ),
    array(
        'db'        => 'prm_persona.per_id',
        'dt'        => 24,
        'formatter' => function( $d, $row ) {
            $h = new DistHoras();
            global $fecha;
            $num = $h->getTotal($d, $fecha);
            unset($h);
            return $num;
        }
    ),
    array(
        'db'        => 'prm_persona.per_id',
        'dt'        => 25,
        'formatter' => function( $d, $row ) {
            $p = new Persona();
            $per = $p->get($d);
            $string = '';
            
            $string .= '<button id="id_' . $d .'" data-toggle="modal" data-target="#progDetail" class="programModal btn btn-xs btn-info" data-tooltip="tooltip" data-placement="top" title="Ver detalles"><i class="fa fa-search-plus"></i></button>';
            
            unset($per);
            unset($p);
            return $string;
        }
    )
);
    
$joins = ' JOIN prm_dist_horas ON prm_persona.per_id = prm_dist_horas.per_id ';

$where = " (prm_dist_horas.dh_fecha = '". $fecha . "' AND prm_persona.tpla_id = '1') ";
 
// SQL server connection information
$sql_details = array(
    'user' => DB_USER,
    'pass' => DB_PASSWORD,
    'db'   => DB_DATABASE,
    'host' => DB_HOST
);
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require( '../src/ssp.class.php' );

echo json_encode(
        SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $joins, null, $where )
);
