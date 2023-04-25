<?php
/*
Esse é um arquivo de teste
Testando todas as funcionalidades da classe Travel
*/

require_once './src/FlightLines.php';
require_once './src/Airplane.php';
require_once './src/Airport.php';
require_once './src/FlightCompany.php';
require_once './src/Travel.php';

$flightCompanyLatam = new FlightCompany('LATAM','JJ','Tam Linhas Aéreas S/a - Processos','12.345.678/0001-12','LT',34.2);

$flightCompanyGol = new FlightCompany('GOL', 'GG', 'Gol Linhas Aéreas Inteligentes S.A.', '147.258.369-74','GO',38.2);

$airplaneBoeing = new Airplane($flightCompanyLatam,'Boeing','A-320', 'PR-GUO', 2, 2.5);

$airplaneGol = new Airplane($flightCompanyGol,'Boeing', '737-700','PR-GGE',5,58);

//Aeroporto de Garulhos
$airportGarulhos = new Airport('Aeroporto de Garulhos','ABC','Garulhos','São Paulo');
//Aeroporto de Belo Horizonte
$airportBH = new Airport('Aeroporto de Belo Horizonte','DEF','Belo Horizonte','Minas Gerais');

$data_departure_time = new Datetime('2014-06-20 11:45:00'); //partida padrão
$data_arrival_time = new DateTime('2014-06-20 13:45:00'); 

$FlightLines = new FlightLines($airportGarulhos, $airportBH, $data_departure_time,$data_arrival_time, $airplaneBoeing, true, Frequency::DAILY, 200.0,50.2);

$Travel = new Travel($FlightLines);

//getCode()
echo ($Travel->getCode()) . PHP_EOL;

//getFlightCode()
echo ($Travel->getFlightCode()) . PHP_EOL;

//getAirplane()
var_dump($Travel->getAirplane()); echo PHP_EOL;

//getFlightLine()
var_dump($Travel->getFlightLine()); echo PHP_EOL;

//getDepartureTime()
echo ($Travel->getDepartureTime()->format('Y/m/d H:i:s')) . PHP_EOL;

//getArrivalTime()
echo ($Travel->getArrivalTime()->format('Y/m/d H:i:s')) . PHP_EOL;

//getDuracao
echo "{$Travel->getDuracao()->h} horas e {$Travel->getDuracao()->i} minutos" . PHP_EOL;

//getPrice()
echo ($Travel->getPrice()) . PHP_EOL;

//getLuggadge()
echo ($Travel->getLuggadge()) . PHP_EOL;

$Travel->informacoes();
echo "--------------------------------------------------" . PHP_EOL;


//setAirplane(Airplane $airplane)
$Travel->setAirplane($airplaneGol);
var_dump($Travel->getAirplane()); echo PHP_EOL;

//Registrando o horário que realmente aconteceu a Travel
$new_data_departure_time = '2014-06-20 11:47:00';
$new_data_arrival_time = '2014-06-20 13:48:00';

//setDepartureTime(string $new_departure_time)
$Travel->setDepartureTime($new_data_departure_time);
echo ($Travel->getDepartureTime()->format('Y/m/d H:i:s')) . PHP_EOL;

//setArrivalTime(string $new_arrival_time)
$Travel->setArrivalTime($new_data_arrival_time);
echo ($Travel->getArrivalTime()->format('Y/m/d H:i:s')) . PHP_EOL;
echo "{$Travel->getDuracao()->h} horas e {$Travel->getDuracao()->i} minutos" . PHP_EOL;

//echo "MUDANÇAS DAS FUNÇÕES SETTERS: " . PHP_EOL;
echo "--------------------------------------------------" . PHP_EOL . PHP_EOL;

echo ($Travel->getLuggadge()) . PHP_EOL;
$Travel->informacoes();
