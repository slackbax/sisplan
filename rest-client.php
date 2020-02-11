<?php

require_once('vendor/autoload.php');

use GuzzleHttp\Client;

$client = new Client();

$array = [
	'tipo_campania' => '34',
	'registros' => [
		[
			'id_externo' => 'ID000001',
			'telefono_1' => '999195279',
			'mensaje' => 'Mensaje de prueba'
		]
	]
];

$res = $client->get('https://wsindakeltun.econecta.cl/api/cliente',
	[
		'auth' => ['gbenavente', 'gbenavente@123.']

	]
);

echo $res->getBody();

echo "<br>";

$res = $client->get('https://wsindakeltun.econecta.cl/api/tipo_campanias',
	[
		'auth' => ['gbenavente', 'gbenavente@123.']
	]
);

echo $res->getBody();

echo "<br>";

try {
	$res = $client->post('https://wsindakeltun.econecta.cl/api/citas',
		[
			'auth' => [
				'gbenavente',
				'gbenavente@123.'
			],
			'json' => $array
		]
	);
} catch (\GuzzleHttp\Exception\ServerException $e) {
	echo $e->getMessage();
} catch (\GuzzleHttp\Exception\ClientException $e) {
	echo $e->getMessage();
}

echo $res->getBody();
