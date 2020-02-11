<?php

include 'class/classMyDBC.php';
include 'class/classSMS.php';
include 'class/classPersona.php';
include 'src/fn.php';

ini_set("soap.wsdl_cache_enabled", 0);
ini_set("soap.wsdl_cache_ttl", 0);

$url = 'https://ida.itdchile.cl/services/smsApiService?wsdl';
$urlPac = 'http://10.6.9.64/ms_contactabilidad/DatosContactabilidad.asmx?wsdl';
$client = new SoapClient($url, array("trace" => 1, "exception" => 0));
$clientPac = new SoapClient($urlPac, array("trace" => 1, "exception" => 0));

$db = new myDBC();
$sms = new Sms();
$per = new Persona();

// PASSWORD DINAMICO WEBSERVICE PACIENTES
$password = ((date('z') + 1) * date('Y')) . date('D')[0];

$dayoftheweek = date('N');
$today = date('Y-m-d');

// AGENDADOS 7 dias habiles
$date = ($dayoftheweek < 4) ? date('Y-m-d', strtotime($today . ' + 9 days')) : date('Y-m-d', strtotime($today . ' + 11 days'));

// RECORDATORIOS 3 dias habiles
$date_rem = ($dayoftheweek < 3) ? date('Y-m-d', strtotime($today . ' + 3 days')) : date('Y-m-d', strtotime($today . ' + 5 days'));
$arr_dates = array($date_rem, $date);

// ESPECIALIDADES
$arr_spec = array(4,5,6,18,19,20,21,35,40,41,47,49,52,53,54,61,67,88,89,90,91,92,93,96,97,98,99,107,108,109,110,111,113,115,118,123,139,199,242,244,245,246,248,249,250,260,268,269,272,273,275,276,278,279,281,287,289,290,309,311,428);

echo $password . "<br>";

try {
	// TOTAL SMS ENVIADOS
	$total = 0;
	$total_ns = 0;

	/*
	foreach ($arr_dates as $date):
		foreach ($arr_spec as $esp):
			$soap_request = "<?xml version=\"1.0\"?>\n";
			$soap_request .= "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:tem=\"http://tempuri.org/\">\n";
			$soap_request .= "	<soapenv:Header>\n";
			$soap_request .= "	  <tem:AuthHeader>\n";
			$soap_request .= "	    <tem:Username>s!n3tSur..!</tem:Username>\n";
			$soap_request .= "	    <tem:Password>" . $password . "</tem:Password>\n";
			$soap_request .= "	  </tem:AuthHeader>\n";
			$soap_request .= "  </soapenv:Header>\n";
			$soap_request .= "  <soapenv:Body>\n";
			$soap_request .= "    <tem:ObtDatos>\n";
			$soap_request .= "      <tem:fecha>" . $date . "</tem:fecha>\n";
			$soap_request .= "		<tem:subespecialidad>" . $esp . "</tem:subespecialidad>\n";
			$soap_request .= "    </tem:ObtDatos>\n";
			$soap_request .= "  </soapenv:Body>\n";
			$soap_request .= "</soapenv:Envelope>";

			$header = array(
				"Content-type: text/xml",
				"Content-length: " . strlen($soap_request)
			);

			$soap_do = curl_init();
			curl_setopt($soap_do, CURLOPT_URL, $urlPac);
			curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt($soap_do, CURLOPT_TIMEOUT, 10);
			curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($soap_do, CURLOPT_POST, true);
			curl_setopt($soap_do, CURLOPT_POSTFIELDS, $soap_request);
			curl_setopt($soap_do, CURLOPT_HTTPHEADER, $header);

			$result = curl_exec($soap_do);
			$vals = [];
			$index = [];
			if ($result === false) {
				$err = 'Curl error: ' . curl_error($soap_do);
				print $err;
			} else {
				$xml = $result;
				$xml_parser = xml_parser_create();
				xml_parse_into_struct($xml_parser, $xml, $vals, $index);
				xml_parser_free($xml_parser);
			}

			curl_close($soap_do);

			$arr_pac = [];
			$obj = new stdClass();

			foreach ($vals as $i => $v):
				if ($v['tag'] == 'RUT_PAC'):
					$tmp = explode('-', $vals[$i]['value']);
					$obj->pac_rut = number_format($tmp[0], 0, '', '.') . '-' . $tmp[1];
				endif;
				if ($v['tag'] == 'FICHA_PAC') $obj->pac_ficha = $vals[$i]['value'];
				if ($v['tag'] == 'NOMBRES_PAC'):
					$tmp = explode(' ', $vals[$i]['value']);
					$obj->pac_nombre = ucwords(mb_strtolower($tmp[0], 'UTF-8'));
				endif;
				if ($v['tag'] == 'APPAT_PAC') $obj->pac_ap = $vals[$i]['value'];
				if ($v['tag'] == 'APMAT_PAC') $obj->pac_am = $vals[$i]['value'];
				if ($v['tag'] == 'RUT_PRO'):
					$tmp = explode('-', $vals[$i]['value']);
					$obj->pro_rut = number_format($tmp[0], 0, '', '.') . '-' . $tmp[1];

					$per_data = $per->getByRut($obj->pro_rut);
					$obj->pro_id = $per_data->per_id;
				endif;
				if ($v['tag'] == 'NOMBRE_PRO'):
					$obj->pro_nom = ($vals[$i]['value'] == 'EVALUACION') ? 'EV.' : 'D.';
				endif;
				if ($v['tag'] == 'APPAT_PRO') $obj->pro_ap = $vals[$i]['value'];
				if ($v['tag'] == 'LUGAR'):
					$obj->lugar_raw = $vals[$i]['value'];
					$tmp = explode(' ', $vals[$i]['value']);
					$check = ($tmp[0] == 'PRESENTARSE') ? $tmp[1] : $tmp[0];
					switch ($check):
						case 'ZOCALO':
							$p = 'ZOCALO CAA';
							break;
						case 'PRIMER':
							$p = '1er PISO';
							break;
						case 'SEGUNDO':
							$p = '2do PISO';
							break;
						case 'TERCER':
							$p = '3er PISO';
							break;
						case 'CUARTO':
							$p = '4to PISO';
							break;
						case 'QUINTO':
							$p = '5to PISO';
							break;
						case 'POLI':
							$p = 'POLI ESP.';
							break;
						case 'CAA':
							$p = 'POLI ESP.';
							break;
						default:
							$p = '';
							break;
					endswitch;

					if ($p == ''):
						if (strpos($vals[$i]['value'], '1') !== false) $p = '1er PISO';
						if (strpos($vals[$i]['value'], '2') !== false) $p = '2do PISO';
						if (strpos($vals[$i]['value'], '3') !== false) $p = '3er PISO';
						if (strpos($vals[$i]['value'], '4') !== false) $p = '4to PISO';
						if (strpos($vals[$i]['value'], '5') !== false) $p = '5to PISO';
					endif;

					$obj->lugar = $p;
				endif;
				if ($v['tag'] == 'FECHA'):
					$tmp = explode(' ', $vals[$i]['value']);
					$obj->fecha = $tmp[0];
					$tmp2 = explode('-', $tmp[0]);
					$obj->fecha_db = $tmp2[2] . '-' . $tmp2[1] . '-' . $tmp2[0];
				endif;
				if ($v['tag'] == 'HORA') $obj->hora = $vals[$i]['value'];
				if ($v['tag'] == 'FONO_MOVIL'):
					$obj->pac_fono = str_replace('+', '', $vals[$i]['value']);
				endif;
				if ($v['tag'] == 'SUBESPECIALIDAD'):
					$obj->subesp = $vals[$i]['value'];
					$arr_pac[] = $obj;
					$obj = new stdClass();
				endif;
			endforeach;

			//echo "<pre>";
			//print_r($arr_pac);
			//echo "</pre>";

			foreach ($arr_pac as $i => $v):
				if (isset($v->pac_fono) and !empty($v->pac_fono) and ($v->pac_fono != '56000000000') and ($v->pac_fono != '56900000000')):
					$msj = $v->pac_nombre . ", le informamos citacion en H. Regional:\n" . $v->subesp . ", " . $v->fecha . " " . $v->hora . ", " . $v->pro_nom . " " . $v->pro_ap . ", " . $v->lugar . "\nConfirmar en Hospital/CESFAM";
					if ($total % 5 == 0) sleep(1);

					$arr = array(
						'in0' => 'agarridoc',
						'in1' => 'agarridoc7359',
						'in2' => $v->pac_fono,
						'in3' => $msj
					);

					//echo '<pre>';
					//print_r($arr);
					//echo '</pre>';
					//echo "(id_sms, $v->pro_id, $v->pac_rut, $v->pac_fono, '$msj', $v->fecha_db $v->hora)<br>";

					$result = $client->__soapCall("sendSms", array($arr));
					//echo "<pre>";
					//print_r($result);
					//echo "</pre>";

					$ins = $sms->set($result->out->entry[2]->value, $v->pro_id, $v->pac_rut, $v->pac_fono, $msj, $v->fecha_db . " " . $v->hora, $db);

					if (!$ins['estado']):
						throw new Exception('Error al guardar los datos del mensaje. ' . $ins['msg']);
					endif;

					//echo $total."<br>";
					$total++;
				else:
					//echo "(NOT-SENT, $v->pro_id, $v->pac_rut, '', $v->subesp, $v->fecha_db $v->hora)<br>";

					$ins = $sms->set('NOT-SENT', $v->pro_id, $v->pac_rut, '', $v->subesp, $v->fecha_db . " " . $v->hora, $db);

					if (!$ins['estado']):
						throw new Exception('Error al guardar los datos del mensaje. ' . $ins['msg']);
					endif;
					$total_ns++;
				endif;
			endforeach;
		endforeach;
	endforeach;
	*/
	unset($db);

	//echo "ENVIADOS: " . $total;
	//echo "<br>NO ENVIADOS: " . $total_ns;
} catch (SoapFault $exception) {
	echo 'Exception Thrown: ' . $exception->faultstring . '<br><br>';
	echo "<pre>";
	print_r($client);
	echo "</pre>";

	echo htmlentities($clientPac->__getLastRequest());
	//var_dump($clientPac->__getLastResponse());
	var_dump($clientPac->__getLastRequestHeaders());
} catch (Exception $e) {
	$db->Rollback();
	$db->autoCommit(TRUE);
	$response = array('type' => false, 'msg' => $e->getMessage());
	echo json_encode($response);
}