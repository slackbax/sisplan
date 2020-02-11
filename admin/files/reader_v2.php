<?php
$time_start = microtime(true);
require_once('../../class/classMyDBC.php');
require_once('../../class/classPersona.php');
require_once('../../class/classProfesion.php');
require_once('../../class/classActividad.php');
require_once('../../class/classAtencionTipo.php');
require_once('../../class/classAtencion.php');
require_once('../../src/Spout/Autoloader/autoload.php');

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

$reader = ReaderFactory::create(Type::XLSX); // for XLSX files
//$reader = ReaderFactory::create(Type::CSV); // for CSV files
//$reader = ReaderFactory::create(Type::ODS); // for ODS files

$fileName = '../../upload/data.xlsx';

$db = new myDBC();
$p = new Persona();
$pr = new Profesion();
$ac = new Actividad();
$ta = new AtencionTipo();
$a = new Atencion();

$rData = [];
$head = true;
$nReg = false;
$newP = $newC = [];
$txt = "";
$fecha = '2019-01-01';
$establecimiento = 100;

$counter = 0;
$count_meds = 0;
$count_nomeds = 0;
$count_newp = 0;
$count_newac = 0;
$pers = [];

// BORRADO DE HORAS CON FECHA $idate
//$d_hor = $h->delAll($idate, $itplanta, $db);

//if (!$d_hor['estado']):
//    throw new Exception('Error al eliminar los datos antiguos de las horas de contrato. ' . $d_hor['msg']);
//endif;

$reader->open($fileName);

foreach ($reader->getSheetIterator() as $sheet):
	foreach ($sheet->getRowIterator() as $row):
		$dates = false;

		// SI NO ES FILA DE CABECERA
		if(!$head):
			$counter++;

			if (isset($row[64]) and !empty(trim($row[64])) and substr(trim($row[64]), -3) == 'A07'):
				$count_meds++;
				$rut = number_format( intval(trim($row[47])), 0, '', '.' ) . '-' . trim($row[48]);
				$prof = trim(substr(trim($row[64]), 0, -4));
				$act = trim($row[10]);
				$tipoat = trim($row[57]);

				echo "<br>leido $count_meds ($rut, $act, $tipoat) ";

				try {
					$per = $p->getByRut($rut, $db);
					$profe = $pr->getByName($prof, $db);
					$activ = $ac->getByName($act, $db);
					$taten = $ta->getByName($tipoat, $db);

					if (is_null($per->per_id)):
						$count_newp++;

						if (is_null($profe->prof_id)):
							$ins_pr = $pr->set($prof, $db);

							if (!$ins_pr['estado']):
								throw new Exception('Error al insertar la profesion. ' . $ins_pr['msg']);
							endif;

							$profe = new stdClass();
							$profe->prof_id = $ins_pr['msg'];
						endif;

						$ins_p = $p->set($rut, $profe->prof_id, trim($row[49]), trim($row[50]), trim($row[51]), '', $db);

						$pers[] = array( 'rut' => $rut, 'profesion' => $profe->prof_id, 'nombre' => trim($row[49]), 'ap' => trim($row[50]), 'am' => trim($row[51]), 'rec' => '' );

						if (!$ins_p['estado']):
							throw new Exception('Error al insertar la persona. ' . $ins_p['msg']);
						endif;

						$ins_pe = $p->setEstablecimiento($ins_p['msg'], $establecimiento);

						if (!$ins_pe['estado']):
							throw new Exception('Error al insertar la persona en su establecimiento. ' . $ins_pe['msg']);
						endif;

						$per = new stdClass();
						$per->per_id = $ins_p['msg'];
					endif;

					if (is_null($activ->act_id)):
						$count_newac++;
						$comite = (strpos($act, 'COMITE') !== false) ? 'TRUE' : 'FALSE';

						$ins_a = $ac->set($act, $comite, $db);

						if (!$ins_a['estado']):
							throw new Exception('Error al insertar la actividad. ' . $ins_a['msg']);
						endif;

						$activ = new stdClass();
						$activ->act_id = $ins_a['msg'];
					endif;

					$atencion = $a->getByParams($taten->tat_id, $activ->act_id, $per->per_id, $fecha, $establecimiento, $db);

					if (is_null($atencion->at_id)):
						//inserta atencion
						$ins = $a->set($taten->tat_id, $activ->act_id, $per->per_id, $fecha, $establecimiento, $db);

						if (!$ins['estado']):
							throw new Exception('Error al insertar la atención. ' . $ins['msg']);
						endif;
					else:
						$ins = $a->update($atencion->at_id, $db);
						echo "<br>update $atencion->at_id";

						if (!$ins['estado']):
							throw new Exception('Error al updatear la atención. ' . $ins['msg']);
						endif;
					endif;

				} catch (Exception $e) {
					//printf("Error: %s.\n", $stmt->error);
					echo $e->getMessage();
					break;
				}
			else:
				$count_nomeds++;
			endif;
		endif;

		$head = false;

	endforeach;
endforeach;

/*
echo "<pre>";
print_r($rData);
echo "</pre>";
echo count($rData);
 * 
 */
echo "TOTAL: " . $counter . "<br>";
echo "MEDICOS: " . $count_meds . "<br>";
echo "NO MEDICOS: " . $count_nomeds . "<br>";
echo "PERSONAS: " . $count_newp . "<br>";
echo "<pre>";
print_r($pers);
echo "</pre>";
echo "ACTIVIDADES: " . $count_newac . "<br>";
$reader->close();
/*
$txt .= "<p><strong>PERSONAS NUEVAS</strong></p>";
if (count($newP) > 0):
    foreach ($newP as $key => $val):
        $txt .= "<p>$val</p>";
    endforeach;
else:
    $txt .= '<p>No hay personas nuevas en el listado.</p>';
endif;
$txt .= "<br><br>";
$txt .= "<p><strong>CONTRATOS NUEVOS</strong></p>";
if (count($newC) > 0):
    foreach ($newC as $key => $val):
        $txt .= "<p>$val</p>";
    endforeach;
else:
    $txt .= '<p>No hay contratos nuevos en el listado.</p>';
endif;
 * 
 */

$time_end = microtime(true);

//dividing with 60 will give the execution time in minutes other wise seconds
$execution_time = ($time_end - $time_start)/60;

//execution time of the script
echo '<b>Total Execution Time:</b> '.$execution_time.' Mins';