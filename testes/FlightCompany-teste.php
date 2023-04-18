<?php
/*
Esse é um arquivo de teste
Testando as funcionalidades da classe FlightCompany
*/
require_once './src/FlightCompany.php';


$flightCompanyLatam = new FlightCompany('LATAM','JJ','Tam Linhas Aéreas S/a - Processos','12.345.678/0001-12','LT');

//getName()
echo ($flightCompanyLatam->getName()) . PHP_EOL; //LATAM

//getCode()
echo ($flightCompanyLatam->getCode()) . PHP_EOL; // JJ

//getRazaoSocial()
echo ($flightCompanyLatam->getRazaoSocial()) . PHP_EOL; //Tam Linhas Aéreas S/a - Processos

//getCnpj
echo ($flightCompanyLatam->getCnpj()) . PHP_EOL; //12.345.678/0001-12

//getSigla
echo ($flightCompanyLatam->getSigla()) . PHP_EOL; //LT


/*
As funções setters não possuem retorno
*/

//setName(string $name)
$flightCompanyLatam->setName('Azul') . PHP_EOL; 

//setCode(string $code)
$flightCompanyLatam->setCode('AB') . PHP_EOL; 

//setRazaoSocial(string $razao_social)
$flightCompanyLatam->setRazaoSocial('Azul Linhas Aéreas Brasileiras'). PHP_EOL;

//setCnpj(string $cnpj)
$flightCompanyLatam->setCnpj('12.245.678/0001-01') . PHP_EOL;

//setSigla(string $sigla)
$flightCompanyLatam->setSigla('AD') . PHP_EOL;

echo "----------------------------------------------------" . PHP_EOL;

//informações após modificações das funçoes setters
echo "As funções setters modificaram as informações anteriores" . PHP_EOL . PHP_EOL;

$flightCompanyLatam->informacoes();
