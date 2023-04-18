<?php
/*
Esse é um arquivo de teste
Testando a funcionalidade da classe Airplane
*/
require_once './src/Airplane.php';

$flightCompanyLatam = new FlightCompany('LATAM','JJ','Tam Linhas Aéreas S/a - Processos','12.345.678/0001-12','LT');

$airplane= new Airplane($flightCompanyLatam,'Boeing','A-320', 'PR-GUO', 2, 2.5);

//getFlightCompany() -> o retorno dessa função é um objeto da classe por isso o uso do var_dump
var_dump($airplane->getFlightCompany());

//getManufacturer()
echo ($airplane->getManufacturer()) . PHP_EOL; //Boeing

//getModel
echo ($airplane->getModel()) . PHP_EOL; //A-320

//getRegistration()
echo ($airplane->getRegistration()) . PHP_EOL; // PR-GUO

//getPassengerCapacity()
echo ($airplane->getPassengerCapacity()) . PHP_EOL; //2

//getWeightCapacity()
echo ($airplane->getWeightCapacity()) . PHP_EOL; //2.5
$airplane->informacoes();

/*
As funções setters não possuem retorno (void)
*/
//setManufacturer(string $manufacturer)
$airplane->setManufacturer('Airbus');

//setModel(string $model)
$airplane->setModel('A320-212');

//setRegistration(string $airplane_register)
$airplane->setRegistration('PR-TYD');

//setPassengerCapacity(int $capacity_passenger)
$airplane->setPassengerCapacity(3);

//setWeightCapacity(float $capacity_cargo)
$airplane->setWeightCapacity(3.5);

echo "--------------------------------------------------------". PHP_EOL;
echo "As informações do objeto da classe Airplane foram modificadas pelos métodos setters" . PHP_EOL . PHP_EOL;

$airplane->informacoes();

