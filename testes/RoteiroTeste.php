<?php
require_once("./src/classes/FlightCompany.php");
require_once("./src/classes/Airplane.php");
require_once("./src/classes/Airport.php");
require_once("./src/classes/Travel.php");
require_once("./src/classes/FlightLines.php");
require_once("./src/classes/Passenger.php");
require_once("./src/classes/FlightTicket.php");

//Testando funcionalidades sem fazer nenhum login:
//Criando avião:
$AirBus_A380_PPART = new Airplane ($Latam, 'AirBus', 'A380', 'PP-ART', 90, 1390);
//Criando aeroporto:
$Adress_AeroPamp = new Adress ('Praça Bagatelle', 'São Luis', 'Belo Horizonte', 204, 31270705, 1, 0);

//Cadastro de 2 companhias Aéreas:
//Companhia Latam criada sem erros:
$Latam = new FlightCompany('LATAM', '101','Latam Airlines do Brasil S.A.','12.345.678/0001-12','LA', 49.9);

$Azul = new FlightCompany('AZUL', '002','Azul Linhas Aéreas Brasileiras S.A.','36.613.535/0001-85','AD', 39.9);

//Cadastro de 2 aeronaves
$Embraer_175_LA = new Airplane ($Latam, 'Embraer', '175', 'PX-RUZ', 180, 600); //Avião Latam - sigla inválida
$Embraer_175_AD = new Airplane ($Azul, 'Embraer', '175', 'PP-RUZ', 180, 600); //Avião Azul - sigla válida

//Cadastro aeroportos
//CONFINS
$Adress_Confins = new Adress ('LMG-800 Km 7,9', 'Sem bairro', 'Confins', 'Minas Gerais', 0, 33500900, -19.634099, -43.965396); //endereço
$Aeroporto_Confins = new Airport('Aeroporto de Confins', 'CNF', $Adress_Confins);
//GUARULHOS
$Adress_Guarulhos = new Adress ('Rod. Hélio Smidt', 'Sem bairro', 'Guarulhos', 'São Paulo', 0, 07190100, -23.4306151, -46.475226); //endereço
$Aeroporto_Guarulhos = new Airport('Aeroporto de Guarulhos', 'CNF', $Adress_Guarulhos);
//CONGONHAS
$Adress_Congonhas = new Adress ('Av. Washington Luís', 'Vila Congonhas' , 'São Paulo', 'São Paulo', 0, 04626911, -23.6262496, -46.6616868); //endereço
$Aeroporto_Congonhas = new Airport('Aeroporto de Congonhas', 'CGH', $Adress_Congonhas);
//GALEÃO
$Adress_Galeao = new Adress ('Av. Vinte de janeiro', 'Sem bairro', 'Rio de Janeiro', 'Rio de Janeiro', 0, 21942900, -22.8147011,-43.2485675); //endereço
$Aeroporto_Galeao = new Airport('Aeroporto do Galeão', 'GIG', $Adress_Galeao);
//AFONSO PENA
$Adress_AfonsoPena = new Adress ('Av. Rocha Pombo', 'Aguas Belas', 'São José dos Pinhais', 'Paraná', 0, 83010900, -25.5315016, -49.176215); //endereço
$Aeroporto_AfonsoPena = new Airport('Aeroporto do Galeão', 'CWB', $Adress_AfonsoPena);

