<?php
session_start();
include ("../../class/classMyDBC.php");
include ("../../src/fn.php");

if (extract($_POST)):
    $db = new myDBC();

    $tempArr = explode('/', $idate);

    if (count($tempArr) > 1):
        $idate = $tempArr[1] . '-' . $tempArr[0] . '-01';
    else:
        $idate = $tempArr[0] . '-01-01';
    endif;
    
    try {
        $db->autoCommit(FALSE);
        
        $targetPath = $_SERVER['DOCUMENT_ROOT'] . BASEFOLDER . 'upload';

        foreach ($_FILES as $aux => $file):
            $tempFile = $file['tmp_name'][0];
            $fileName = 'data.xlsx';
            $targetFile = rtrim($targetPath,'/') . '/' . $fileName;
            
            if(!move_uploaded_file($tempFile, $targetFile)):
                throw new Exception("Error al subir el documento. " . print_r(error_get_last()));
            endif;
            
            //chmod($targetFile, 0777);
        endforeach;
        
        include ('reader_v2.php');

        $db->Commit();
        $db->autoCommit(TRUE);
        $response = array('type' => true, 'msg' => $txt);
        echo json_encode($response);
        
    } catch (Exception $e) {
        $db->Rollback();
        $db->autoCommit(TRUE);
        $response = array('type' => false, 'msg' => $e->getMessage());
        echo json_encode($response);
    }
endif;

?>