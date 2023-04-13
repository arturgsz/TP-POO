<?php

require_once './src/FlightLines.php';

$airportGarulhos = new Airport('Aeroporto de Garulhos','ABC','Garulhos','São Paulo');

$airportBH = new Airport('Aeroporto de Belo Horizonte','DEF','Belo Horizonte','Minas Gerais');

$airplane = new Airplane('Boeing','A-320', 'PR-GUO', 2, 2.5);

$data_departure_time = new Datetime('2014-06-20 11:45');
$data_arrival_time = new DateTime('2014-06-20 13:45');

$FlightLines = new FlightLines($airportGarulhos, $airportBH, $data_departure_time,$data_arrival_time, $airplane, true, Frequency::DAILY);

var_dump($FlightLines); echo PHP_EOL;

//usar var_dump e não echo para imprimir variaveis DateTime e enum(frequency)
var_dump($FlightLines->getExpectedDepartureTime());
var_dump($FlightLines->getFrequency());