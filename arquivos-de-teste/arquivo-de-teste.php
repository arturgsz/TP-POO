<?php

require_once './src/FlightLines.php';
require_once './src/Client.php';


$flightCompany = new FlightCompany('LATAM','JJ','Tam Linhas Aéreas S/a - Processos','12.345.678/0001-12','LT');

//testando a classe Airplane
$airplane = new Airplane($flightCompany,'Boeing','A-320', 'PR-GUO', 2, 2.5);
var_dump($airplane);
echo PHP_EOL;

//testando a classe Client
$client = new Client('Kathelyn','Gaioni','12.345.678');
var_dump($client);

echo PHP_EOL;

//testando FlightLines
$airportGarulhos = new Airport('Aeroporto de Garulhos','ABC','Garulhos','São Paulo');

$airportBH = new Airport('Aeroporto de Belo Horizonte','DEF','Belo Horizonte','Minas Gerais');

$data_departure_time = new Datetime('2014-06-20 11:45'); //partida padrão
$data_arrival_time = new DateTime('2014-06-20 13:45'); 

$FlightLines = new FlightLines($airportGarulhos, $airportBH, $data_departure_time,$data_arrival_time, $airplane, true, Frequency::DAILY);

var_dump($FlightLines); echo PHP_EOL;

//usar var_dump e não echo para imprimir variaveis DateTime e enum(frequency)
var_dump($FlightLines->getExpectedDepartureTime());
var_dump($FlightLines->getFrequency());
