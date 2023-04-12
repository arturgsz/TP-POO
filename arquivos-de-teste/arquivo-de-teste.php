<?php

require_once './src/Airplane.php';
require_once './src/Airport.php';
require_once './src/Cliente.php';


//testando a classe Airplane
$airplane = new Airplane('Boeing','A-320', 'PR-GUO', 2, 2.5);
var_dump($airplane);

echo PHP_EOL;

$airport = new Airport('Aeroporto de Garulhos','ABC','Garulhos','São Paulo');
var_dump($airport);

echo PHP_EOL;

$client = new Client('Kathelyn','Gaioni','12.345.678');
var_dump($client);
