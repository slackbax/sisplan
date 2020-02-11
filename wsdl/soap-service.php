<?php

ini_set("soap.wsdl_cache_enabled", 0); // disabling WSDL cache
ini_set("soap.wsdl_cache_ttl", 0);
include("../class/classMyDBC.php");
include("../class/classDocumento.php");

class DocumentSearchService extends Documento {

    private $apiKey = 'ad9bda471fdca2b1ba0f481df7327e6d';

    public function APIValidate($auth) {

        if (md5($auth->apiKey) != $this->apiKey) {
            throw new SoapFault("Server", "Llave de autenticación incorrecta.");
        }
    }

    function getDocumentByData($data) {
        
        try {
            $tmp = explode("&", $data);

            $doc = $this->getByRutNumType($tmp[0], $tmp[1], $tmp[2]);
            
            if (empty($doc)): throw new Exception; endif;
            
            return json_encode($doc[0]);
            
        } catch (Exception $e) {
            throw new SoapFault("Server", "No se ha encontrado el documento con esos parámetros.");
        }
    }

}

$server = new SoapServer("WebService.wsdl");
$server->setClass("DocumentSearchService");
$server->handle();
