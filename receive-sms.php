<?php

include 'class/classMyDBC.php';
include 'class/classSMSResponse.php';
include 'class/classPersona.php';
include 'src/fn.php';

ini_set("soap.wsdl_cache_enabled", 0);
ini_set("soap.wsdl_cache_ttl", 0);

$url = 'https://ida.itdchile.cl/services/smsApiService?wsdl';
$client = new SoapClient($url, array("trace" => 1, "exception" => 0));

$db = new myDBC();
$sms = new SmsResponse();

$arr = array(
	'in0' => 'agarridoc',
	'in1' => 'agarridoc7359'
);

$result = $client->__soapCall("getRecievedMessages", array($arr));
echo "<pre>";
print_r($result);
echo "</pre>";
$rsp = json_decode($result->out);

if ($result->out != 'NO MESSAGES'):
	foreach ($rsp as $v => $i):
		$obj = new stdClass();
		$tmp = explode(' ', $i->date);
		$obj->hora = $tmp[1];
		$tmp2 = explode('/', $tmp[0]);
		$obj->fecha = $tmp2[2] . '-' . $tmp2[1] . '-' . $tmp2[0];

		$ins = $sms->set($i->ani, utf8_decode($i->message), $obj->fecha . ' ' . $obj->hora, $db);

		if (!$ins['estado']):
			throw new Exception('Error al guardar los datos del mensaje. ' . $ins['msg']);
		endif;
	endforeach;
endif;
