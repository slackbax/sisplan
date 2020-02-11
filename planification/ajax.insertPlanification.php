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

if ($_POST):
    foreach ($_POST as $key => $value):
        $init = substr($key, 0, 1);
    
        if ($value != '' and $value != 0.0 and $init != 't'):
            $data[$key] = $value;
        endif;
    endforeach;
    
    $data['idesc'] = $_POST['idesc'];
    
    $db = new myDBC();
    $di = new Distribucion();
    $dh = new DistHoras();
    $date = $_POST['idate'];
    $justif = $_POST['ijustif'];
    $serv = $_POST['iserv'];
    $esp = $_POST['iesp'];
    $dateProg = setDateBD('01/' . $date);
    
    try {
        $db->autoCommit(FALSE);
        
        $act = $di->setLast($data['id'], $esp, $_SESSION['prm_estid'], $serv, $db);
        
        if (!$act['estado']):
            throw new Exception('Error al actualizar los datos de la planificación. ' . $act['msg']);
        endif;
        
        $ins_d = $di->set($data['id'], $_SESSION['prm_estid'], $data['idesc'], $dateProg, $justif, $serv, $esp, $_POST['ivacaciones'], $_POST['ipermiso'], $_POST['icongreso'], $_SESSION['prm_userid'], $db);

        if (!$ins_d['estado']):
            throw new Exception('Error al guardar los datos de la planificación. ' . $ins_d['msg']);
        endif;
        
        foreach($data as $key => $value):
            $insert = false;
        
            switch ($key):
                case 'disp':            $thor = 1; $rend = 0; $insert = true; break;
                case 'universidad':     $thor = 2; $rend = 0; $insert = true; break;
                case 'becados':         $thor = 3; $rend = 0; $insert = true; break;
                case 'sala':            $thor = 4; $rend = $data['rsala']; $insert = true; break;
                case 'consultasn':      $thor = 5; $rend = $data['rconsultasn']; $insert = true; break;
                case 'controles':       $thor = 6; $rend = $data['rcontroles']; $insert = true; break;
                case 'comite':          $thor = 7; $rend = $data['rcomite']; $insert = true; break;
                case 'consultaa':       $thor = 8; $rend = $data['rconsultaa']; $insert = true; break;
                case 'procedimiento':   $thor = 9; $rend = $data['rprocedimiento']; $insert = true; break;
                case 'pabellon':        $thor = 10; $rend = $data['rpabellon']; $insert = true; break;
                case 'eleconsulta':     $thor = 11; $rend = $data['releconsulta']; $insert = true; break;
                case 'entrevista':      $thor = 12; $rend = $data['rentrevista']; $insert = true; break;
                case 'consultoria':     $thor = 13; $rend = $data['rconsultoria']; $insert = true; break;
                case 'visitas':         $thor = 14; $rend = $data['rvisitas']; $insert = true; break;
                case 'intcomunitaria':  $thor = 15; $rend = $data['rintcomunitaria']; $insert = true; break;
                case 'salaexam':        $thor = 16; $rend = $data['rsalaexam']; $insert = true; break;
                case 'intenlace':       $thor = 17; $rend = 0; $insert = true; break;
                case 'reclinicas':      $thor = 18; $rend = 0; $insert = true; break;
                case 'admin':           $thor = 19; $rend = 0; $insert = true; break;
                case 'visacion':        $thor = 20; $rend = 0; $insert = true; break;
                case 'capacitacion':    $thor = 21; $rend = 0; $insert = true; break;
                case 'gimnasio':        $thor = 22; $rend = $data['rgimnasio']; $insert = true; break;
                case 'educacion':       $thor = 23; $rend = $data['reducacion']; $insert = true; break;
                case 'intervencion':    $thor = 24; $rend = $data['rintervencion']; $insert = true; break;
                case 'talleres':        $thor = 25; $rend = $data['rtalleres']; $insert = true; break;
                case 'vida':            $thor = 26; $rend = $data['rvida']; $insert = true; break;
                default:                break;
            endswitch;
            
            if ($insert):
                $ins = $dh->set($ins_d['msg'], $thor, $value, $rend, $db);
            
                if (!$ins['estado']):
                    throw new Exception('Error al guardar los datos de la planificación. ' . $ins['msg']);
                endif;
            endif;
        endforeach;

        $db->Commit();
        $db->autoCommit(TRUE);
        $response = array('type' => true, 'msg' => 'OK');
        echo json_encode($response);
        
    } catch (Exception $e) {
        $db->Rollback();
        $db->autoCommit(TRUE);
        $response = array('type' => false, 'msg' => $e->getMessage());
        echo json_encode($response);
    }
endif;

