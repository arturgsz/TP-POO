<?php

require_once './src/Travel.php';
require_once './src/Airplane.php';

$flightCompany = new FlightCompany('LATAM','JJ','Tam Linhas Aéreas S/a - Processos','12.345.678/0001-12','LT');
$airplane = new Airplane($flightCompany,'Boeing','A-320', 'PR-GUO', 2, 2.5);

$airportGarulhos = new Airport('Aeroporto de Garulhos','ABC','Garulhos','São Paulo');
$airportBH = new Airport('Aeroporto de Belo Horizonte','DEF','Belo Horizonte','Minas Gerais');

$data_departure_time = new Datetime('2014-06-20 11:45:00'); //partida padrão
$data_arrival_time = new DateTime('2014-06-20 13:45:00'); 
$FlightLines = new FlightLines($airportGarulhos, $airportBH, $data_departure_time,$data_arrival_time, $airplane, true, Frequency::DAILY);

//testando a classe Travel
$Travel = new Travel($FlightLines);

//registrando a hora de partida 
$Travel->horaDePartida('1234');

//registrando a hora de chegada
$Travel->horaDeChegada('1234');

var_dump($Travel); echo PHP_EOL;
$Travel->informacoesDoVoo();


