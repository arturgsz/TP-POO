<?php
/*
Esse é um arquivo de teste
Testando todas as funcionalidades da classe Airport
*/
require_once './src/Airport.php';

//nova instância da classe Aeroporto
$airportGarulhos = new Airport('Aeroporto de Garulhos','ABC','Garulhos','São Paulo');

//getName()
echo ($airportGarulhos->getName()) . PHP_EOL;

//getSigla()
echo ($airportGarulhos->getSigla()) , PHP_EOL;

//getCity
echo ($airportGarulhos->getCity()) . PHP_EOL;

//getState()
echo ($airportGarulhos->getState()) . PHP_EOL . PHP_EOL;

$airportGarulhos->informacoes();

/*
  As funções setters não possuem retorno
*/

//setName(string $name)
$airportGarulhos->setName('Aeroporto de Belo Horizonte');

//setSigla(string $sigla)
$airportGarulhos->setSigla('ABH');

//setCity(string $city)
$airportGarulhos->setCity('Belo Horizonte');

//setState(string $state)
$airportGarulhos->setState('Minas Gerais');

echo "--------------------------------------------------------" . PHP_EOL;
echo "Mudança de informações pelos métodos setters:" . PHP_EOL . PHP_EOL;
$airportGarulhos->informacoes();
