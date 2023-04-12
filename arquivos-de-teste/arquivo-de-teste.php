<?php

require_once './src/Airplane.php';
require_once './src/Airport.php';
require_once './src/Cliente.php';
require_once './src/FlightCompany.php'; //inclui FlightLines


//testando a classe Airplane
$airplane = new Airplane('Boeing','A-320', 'PR-GUO', 2, 2.5);
var_dump($airplane);

echo PHP_EOL;

//testeando a classe Airport
$airport = new Airport('Aeroporto de Garulhos','ABC','Garulhos','São Paulo');
var_dump($airport);

echo PHP_EOL;

//testando a classe Client
$client = new Client('Kathelyn','Gaioni','12.345.678');
var_dump($client);

echo PHP_EOL;

//testando a classe FlightCompany
$flightCompany = new FlightCompany('LATAM','JJ','Tam Linhas Aéreas S/a - Processos','12.345.678/0001-12','LT');
var_dump($flightCompany);
