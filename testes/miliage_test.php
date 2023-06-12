<?php
require_once "../src/System.php";

$us = new UserAuthenticate();
$us->LogIn("Cruze","1234");

System::cleanDB();

//Passageiros
$Birth_Artur = new DateTime('16-06-03');
$Passenger_Artur = new Passenger('Artur', 'Souza', '02339430640','Brasileiro', $Birth_Artur,'MG20928340', true, 'Turito', 'arturgs@email.com','galo');
$Passenger_ArturKey = $Passenger_Artur->getKey();

//Pontos Artur
$Ponto_Artur = new Points (0, new DateTime("now"));
$Ponto_ArturKey = $Ponto_Artur->getKey();
$Ponto_Artur->AddPontos(149.0, new DateTime("now"));
$DataPonto1 = new DateTime("now"); $DataPonto1->setDate(2023, 05, 23);
$Ponto_Artur->AddPontos(100.0, $DataPonto1);
$DataPonto2 = new DateTime("now"); $DataPonto2->setDate(2022, 05, 23); //Ponto com data inválida
$Ponto_Artur->AddPontos(901.0, new DateTime('16-05-22'));

//FlightCompany
$Azul = new FlightCompany('AZUL', '002','Azul Linhas Aéreas Brasileiras S.A.','36.613.535/0001-85','AD', 'azul', 'azul@email.com', 'azulcomvc');
$AzulKey = $Azul->getKey();
//Avião
$Embraer_175_AD = new Airplane ($Azul, 'Embraer', '175', 'PP-RUZ', 180, 600);
//Aeroporto
$Adress_AeroConfins = new Adress ('LMG-800 Km 7,9', 'Sem Bairro', 'Confins', 'Minas Gerais', 0, 31270705, -19.6340855, -44.0354364);
$Aeroporto_Confins = new Airport('Aeroporto Confins', 'PMP', $Adress_AeroConfins, 'aeroconfins', 'aeroconfins@email.com', '1234');

//Criando Programa Milhagem
$Milhas = new MiliageProgram ('Milhas-AZUL', $AzulKey);
$Milhas->AddCategoria('Azul Inicial', 0);
$Milhas->AddCategoria('Azul Safira', 100);
$Milhas->showSubCategorias();
$SubCategorias = $Milhas->getArraySubCategorias();
$AzulSafira = $Milhas->getSubCategoria(1);
$AzulSafira->AddPassenger($Passenger_ArturKey);
$AzulSafiraKey = $AzulSafira->getKey();


$Passenger_Artur->vip(1234, $AzulKey, $Ponto_ArturKey);
echo "PONTOS " . $Passenger_Artur->getPoints() . "\n" ;

$Company =  $Passenger_Artur->getVipFlightCompany();

var_dump($Company);
echo "---------------------------------\n";