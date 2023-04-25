<?php
/*
Esse é um arquivo de teste
Testando as funcionalidades da classe FlightCompany
*/
require_once './src/FlightCompany.php';


$flightCompanyLatam = new FlightCompany('LATAM','JJ','Tam Linhas Aéreas S/a - Processos','12.345.678/0001-12','LT', 34.2);

//getName()
echo ($flightCompanyLatam->getName()) . PHP_EOL; //LATAM

//getCode()
echo ($flightCompanyLatam->getCode()) . PHP_EOL; // JJ

//getRazaoSocial()
echo ($flightCompanyLatam->getRazaoSocial()) . PHP_EOL; //Tam Linhas Aéreas S/a - Processos

//getCnpj()
echo ($flightCompanyLatam->getCnpj()) . PHP_EOL; //12.345.678/0001-12

//getSigla()
echo ($flightCompanyLatam->getSigla()) . PHP_EOL; //LT

//getLuggadge()
echo ($flightCompanyLatam->getLuggadge()) . PHP_EOL . PHP_EOL; //34.2

/*
As funções setters não possuem retorno
*/
echo "As funções setters modificam as informações anteriores" . PHP_EOL . PHP_EOL;

//setName(string $name)
$flightCompanyLatam->setName('Azul'); 
echo ($flightCompanyLatam->getName()) . PHP_EOL; //AZUL

//setCode(string $code)
$flightCompanyLatam->setCode('AB'); 
echo ($flightCompanyLatam->getCode()) . PHP_EOL; //AB

//setRazaoSocial(string $razao_social)
$flightCompanyLatam->setRazaoSocial('Azul Linhas Aéreas Brasileiras');
echo ($flightCompanyLatam->getRazaoSocial()) . PHP_EOL; //Azul Linhas Aéreas Brasileiras

//setCnpj(string $cnpj)
$flightCompanyLatam->setCnpj('12.245.678/0001-01');
echo ($flightCompanyLatam->getCnpj()) . PHP_EOL; //12.245.678/0001-01

//setSigla(string $sigla)
$flightCompanyLatam->setSigla('AD');
echo ($flightCompanyLatam->getSigla()) . PHP_EOL; //AD

//setLuggadge(float $luggadge)
$flightCompanyLatam->setLuggadge(38.7);
echo ($flightCompanyLatam->getLuggadge()) . PHP_EOL; //38.7


echo "----------------------------------------------------" . PHP_EOL;

//informações após modificações das funçoes setters
$flightCompanyLatam->informacoes();
