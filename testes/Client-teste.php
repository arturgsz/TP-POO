<?php
/*
Esse é um arquivo de teste
Testando todas as funcionalidades da classe Client
*/
require_once './src/Client.php';

$client = new Client('Kathelyn','Gaioni','12.345.678');

//getName()
echo ($client->getName()) . PHP_EOL;

//getSurname
echo ($client->getSurname()) . PHP_EOL;

//getDocument()
echo ($client->getDocument()) . PHP_EOL . PHP_EOL;

$client->informacoes();