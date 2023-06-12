<?php
require_once "../src/System.php";
require_once "../src/classes/Airport.php";
require_once "../src/classes/Vehicle.php";
require_once "../src/classes/Crew.php";

$us = new UserAuthenticate();
$us->LogIn("Cruze","1234");

System::cleanDB();
//Filght Company
$Latam = new FlightCompany('LATAM', '101','Latam Airlines do Brasil S.A.','12.345.678/0001-12','LA', 'latam', 'latam@email.com', '1234');

//Cadastrando Aeroporto
$Adress_AeroConfins = new Adress ('LMG-800 Km 7,9', 'Sem Bairro', 'Confins', 'Minas Gerais', 0, 31270705, -19.6340855, -44.0354364);
$Aeroporto_Confins = new Airport('Aeroporto Confins', 'PMP', $Adress_AeroConfins, 'aeroconfins', 'aeroconfins@email.com', '1234');

//Cadastrando Veículo
$veiculo = new Vehicle ('Monza Tubarão 98', 'BRA098', 5);

//Cadastrando Crew
//Piloto
$nascimento_jose = new DateTime('14-03-1966');
$Adress_Jose = new Adress ('Rua Mascarenhas de Morais', 'São Luis', 'Belo Horizonte', 'Minas Gerais', 200, 31270720, -19.8521326, -43.9605512);
$Piloto = new Crew("Jose", "Almeida", "727.206.050-69", "piloto", $nascimento_jose, "email@email.com", "documento", $Adress_Jose, $Latam,
                    $Aeroporto_Confins, 'ZePcleariloto', 'zepiloto@email.com','zezinho');
$PilotoKey = $Piloto->getKey();
//Copiloto
$nascimento_ronaldo = new DateTime('14-11-2003');
$Adress_Ronald = new Adress ('Rua Desembargador Paulo Mota', 'Ouro Preto', 'Belo Horizonte', 'Minas Gerais', 40, 7190100, -19.8718988,-43.9827534);
$CoPiloto = new Crew("Ronaldo", "Gonçalves", "142.593.620-20", "copiloto", $nascimento_ronaldo, "ronaldogsa@gmail.com", "documento", $Adress_Ronald,
                    $Latam, $Aeroporto_Confins, 'potter', 'potter@email.com', 'popoti');
$CoPilotoKey = $CoPiloto->getKey();
//Comissario1
$nascimento_cleber = new DateTime('10-09-1990');
$Adress_Cleber = new Adress ('Rua Alameda dos Coqueiros', 'São Luís', 'Belo Horizonte', 'Minas Gerais', 936, 31270820, -19.8579028,-43.9699043);
$Comissario1 = new Crew("Cleber", "Gladiador", "732.283.140-30", "comissario", $nascimento_cleber, "clebin@gmail.com", "documento", $Adress_Cleber,
                        $Latam, $Aeroporto_Confins, 'cleber', 'cleber@email.com', 'clebin');
$Comissario1Key = $Comissario1->getKey();                
//Comissario2
$nascimento_tulio = new DateTime('27-02-1998');
$Adress_Tulio = new Adress ('Avenida Fleming', 'Ouro Preto', 'Belo Horizonte', 'Minas Gerais', 1187, 31310490,-19.8647609,-43.9856754);
$Comissario2 = new Crew("Tulio", "Guedes", "373.005.770-75", "comissario", $nascimento_tulio, "tuliogdes@gmail.com", "documento", $Adress_Tulio,
                        $Latam, $Aeroporto_Confins, 'tulio', 'tulio@email.com', 'tutui');
$Comissario2Key = $Comissario2->getKey();    

//Criando Rota
$crewKey = [$PilotoKey, $CoPilotoKey, $Comissario1Key, $Comissario2Key];
$data = new DateTime("now"); $data->setTime("12", "30");
$Rota = new Route($crewKey, $Aeroporto_Confins, $veiculo, $data);

$Rota->descricaoRota();