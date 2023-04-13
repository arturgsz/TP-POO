<?php

require_once './src/Travel.php';
require_once './src/Airplane.php';

$airplane = new Airplane('Boeing','A-320', 'PR-GUO', 2, 2.5);

//testando a classe Travel
$FlightLines1 = new FlightLines($airplane);
$FlightLines2 = new FlightLines($airplane);

$Travel1 = new Travel($FlightLines1);
$Travel2 = new Travel($FlightLines2);

var_dump($Travel1); echo PHP_EOL ; 
var_dump($Travel2); echo PHP_EOL;

//registrando a hora de partida 
$Travel1->horaDePartida('1234');

//registrando a hora de chegada
$Travel1->horaDeChegada('1234');

var_dump($Travel1); echo PHP_EOL;

