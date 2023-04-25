<?php

require_once './src/FlightCompany.php';
require_once './src/Airplane.php';
require_once './src/Airport.php';
require_once './src/FlightLines.php';
require_once './src/FlightTicket.php';

$client = new Client('Kathelyn','Gaioni','12.345.678');

$flightCompanyLatam = new FlightCompany('LATAM','JJ','Tam Linhas Aéreas S/a - Processos','12.345.678/0001-12','LT', 34.2);

$airplaneBoeing= new Airplane($flightCompanyLatam,'Boeing','A-320', 'PR-GUO', 2, 2.5);

//Aeroporto de Garulhos
$airportGarulhos = new Airport('Aeroporto de Garulhos','ABC','Garulhos','São Paulo');
//Aeroporto de Belo Horizonte
$airportBH = new Airport('Aeroporto de Belo Horizonte','DEF','Belo Horizonte','Minas Gerais');

$data_departure_time = new Datetime('2014-06-20 11:45:00'); //partida padrão
$data_arrival_time = new DateTime('2014-06-20 13:45:00'); 

$FlightLines = new FlightLines($airportGarulhos, $airportBH, $data_departure_time,$data_arrival_time, $airplaneBoeing, true, Frequency::DAILY, 200.0);

$Travel = new Travel($FlightLines);
                                                
$FlightTicket = new FlightTicket($Travel, $client, 2, 2);

//getTravel()
var_dump($FlightTicket->getTravel());

//getCode
echo ($FlightTicket->getCode()) . PHP_EOL;

//getClient()
var_dump($FlightTicket->getClient()); echo PHP_EOL;

//getOrigin()
echo ($FlightTicket->getOrigin()) . PHP_EOL;

//getDestiny()
echo ($FlightTicket->getDestiny()) . PHP_EOL;

//getLuggadge()
echo ($FlightTicket->getLuggadge()) . PHP_EOL;

//getPrice()
echo ($FlightTicket->getPrice()) . PHP_EOL;

//getSeat()
echo ($FlightTicket->getSeat()) . PHP_EOL;

$FlightTicket->informacoes();

/*
  Os métodos setters não possuem retorno 
*/

//setLuggadge(int $luggadge)
$FlightTicket->setLuggadge(3); // 3 bagagens
echo ($FlightTicket->getLuggadge()) . PHP_EOL;

//setSeat(string $seat)
$FlightTicket->setSeat(1); //assento nº 1
echo ($FlightTicket->getSeat()) . PHP_EOL;

echo "------------------------------------------------" . PHP_EOL . PHP_EOL;
$FlightTicket->informacoes();
