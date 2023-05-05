<?php
/*
Esse é o arquivo de teste da classe FlightLines
*/
require_once 'src/FlightLines.php';
require_once './src/FlightLines.php';
require_once './src/Airplane.php';
require_once './src/Airport.php';
require_once './src/FlightCompany.php';

$flightCompanyLatam = new FlightCompany('LATAM','JJ','Tam Linhas Aéreas S/a - Processos','12.345.678/0001-12','LT', 34.2);

$airplaneBoeing= new Airplane($flightCompanyLatam,'Boeing','A-320', 'PR-GUO', 2, 2.5);

//Aeroporto de Garulhos
$airportGarulhos = new Airport('Aeroporto de Garulhos','ABC','Garulhos','São Paulo');
//Aeroporto de Belo Horizonte
$airportBH = new Airport('Aeroporto de Belo Horizonte','DEF','Belo Horizonte','Minas Gerais');

$data_departure_time = new Datetime('2023-05-05 11:45:00'); //partida padrão
$data_arrival_time = new DateTime('2023-05-05 13:45:00'); 

$FlightLines = new FlightLines($airportGarulhos, $airportBH, $data_departure_time,$data_arrival_time, $airplaneBoeing, true,['Sun','Mon'], 200.0);


//getOrigin() -> o retorno dessa função é um objeto da classe Airport
var_dump($FlightLines->getOrigin()); echo PHP_EOL;

//getDestiny() -> o retorno dessa função é um objeto da classe Airport
var_dump($FlightLines->getDestiny()); echo PHP_EOL;

//getAirplane() -> o retorno dessa função é um objeto da classe Airplane
var_dump($FlightLines->getAirplane()); echo PHP_EOL;

//getCode()
echo ($FlightLines->getCode()) . PHP_EOL;

//getExpectedDepartureTime()
echo ($FlightLines->getExpectedDepartureTime()->format('Y/m/d H:i:s')) . PHP_EOL;

//getExpectedArrivalTime()
echo ($FlightLines->getExpectedArrivalTime()->format('Y/m/d H:i:s')) . PHP_EOL;

//getDuracao()
echo "{$FlightLines->getDuracao()->d} dia(s) {$FlightLines->getDuracao()->h} hora(s) e {$FlightLines->getDuracao()->i} minuto(s)" . PHP_EOL;

//getPrice
echo ($FlightLines->getPrice()) . PHP_EOL;

//getlugadgeprice()
echo ($FlightLines->getlugadgeprice()) . PHP_EOL;

//getFrequency() -> o retorno da função é do tipo enum Frequency
var_dump($FlightLines->getFrequency()); echo PHP_EOL;

//isOperacional() -> o retorno dessa função é bool
var_dump($FlightLines->isOperational());

$FlightLines->informacoes();

/*
  As funções setters não possuem retorno
*/
//Mudança no Aeroporto de Origem e no Aeroporto de destino

//Aeroporto de Confins
$airportConfins = new Airport('Aeroporto de Confins','ADC','Confins','Minas Gerais');
//Aeroporto de Curitiba
$airportCuritiba = new Airport('Aeroporto Internacional Afonso Pena','AFP','Curitiba','Parana');

//setOrigin(Airport $origin)
$FlightLines->setOrigin($airportConfins); echo PHP_EOL;

//setDestiny(Airport $destiny)
$FlightLines->setDestiny($airportCuritiba); echo PHP_EOL;

//Mudança na Aeronave
$airplaneAirbus = new Airplane($flightCompanyLatam,'Airbus','A320-212','PR-TYD',3,3.5);

//setAirplane(Airplane $Airplane)
$FlightLines->setAirplane($airplaneAirbus);

//Mudança na Frequencia
//setFrequency(Frequency $frequency)
$FlightLines->setFrequency(['Tue']);

//setOperational(bool $operational)
$FlightLines->setOperational(False);


//setPrice(float $price)
$FlightLines->setPrice(300);

//Mudança no horário do FlightLines
$new_data_departure_time = '2023-05-08 12:00:00';
$new_data_arrival_time = '2023-05-08 15:00:00';

$FlightLines->setExpectedDepartureTime($new_data_departure_time);
$FlightLines->setExpectedArrivalTime($new_data_arrival_time);

$FlightLines->informacoes();
//var_dump($FlightLines->getTravel());
//$FlightLines->VoosCriados();