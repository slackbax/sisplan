<?php

session_start();
include ("../class/classMyDBC.php");
include ("../class/classDistribucion.php");
include ("../class/classDistHoras.php");
include ("../src/fn.php");
$_admin = false;

if (isset($_SESSION['prm_useradmin']) && $_SESSION['prm_useradmin']):
    $_admin = true;
    $_SESSION['prm_estid'] = 100;
endif;

if (extract($_POST)):
    $db = new myDBC();
    $di = new Distribucion();
    $dh = new DistHoras();
    
    $date = setDateBD('01/' . $date);
    $dist = $di->getByEstabPlanta($pl, $_SESSION['prm_estid'], $db);
    $count_d = 0;
    
    try {
        $db->autoCommit(FALSE);
    
        foreach ($dist as $i => $d):
            //print_r($d);

            $chk = $di->getCountByPerDate($d->dist_perid, $d->dist_estid, $date, $db);

            if ($chk == 0):
                $ins = $di->set($d->dist_perid, $d->dist_estid, $d->dist_descripcion, $date, $d->dist_jusid, $d->dist_serid, $d->dist_espid, $d->dist_vacaciones, $d->dist_permisos, $d->dist_congreso, $_SESSION['prm_userid'], $db);

                if (!$ins['estado']):
                    throw new Exception('Error al copiar los datos de la distribución. ' . $ins['msg']);
                endif;
                
                $count_d++;

                $horas = $dh->getByDist($d->dist_id, $db);
                
                foreach ($horas as $v => $h):
                    $ins_h = $dh->set($ins['msg'], $h->dh_acpid, $h->dh_cantidad, $h->dh_rendimiento, $db);
                
                    if (!$ins_h['estado']):
                        throw new Exception('Error al copiar los datos de las horas. ' . $ins_h['msg']);
                    endif;
                endforeach;

                //print_r($horas);
            endif;
        endforeach;

        $db->Commit();
        $db->autoCommit(TRUE);
        $response = array('type' => true, 'msg' => $count_d);
        echo json_encode($response);
        
    } catch (Exception $e) {
        $db->Rollback();
        $db->autoCommit(TRUE);
        $response = array('type' => false, 'msg' => $e->getMessage());
        echo json_encode($response);
    }
endif;