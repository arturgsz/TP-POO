<?php
require_once './src/Travel.php';

//testando a classe Travel
$FlightLines1 = new FlightLines('JJ');
$FlightLines2 = new FlightLines('JJ');

$Travel1 = new Travel($FlightLines1);
$Travel2 = new Travel($FlightLines2);

var_dump($Travel1); echo PHP_EOL ; var_dump($Travel2); echo PHP_EOL;

//registrando a hora de partida 
$Travel1->horaDePartida('1234');

//registrando a hora de chegada
$Travel1->horaDeChegada('1234');

var_dump($Travel1);