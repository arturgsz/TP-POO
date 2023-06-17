<?php
require_once "./src/System.php";


//Testando funcionalidades sem fazer nenhum login:

//Tentando criar objeto Adress sem login:
try{
    $ad = new Adress("Rua Desembargador Paulo Mota","giy","vi","ogu","561","465","48","145");
}catch( Exception $e){
    echo $e->getMessage()."\n";
}
User::getRecords();
Adress::getRecords();

//LOGIN
$aut = new UserAuthenticate();
$aut->LogIn("Cruze","1234");
System::cleanDB(); 

//-------------------------------------------------------------------------------------------------

//Cadastro de 2 companhias Aéreas:
$Latam = new FlightCompany('LATAM', '101','Latam Airlines do Brasil S.A.','12.345.678/0001-12','LA', 'latam', 'latam@email.com', 'latambr' );
$Azul = new FlightCompany('AZUL', '002','Azul Linhas Aéreas Brasileiras S.A.','36.613.535/0001-85','AD', 'azul', 'azul@email.com', 'azulniao');
$AzulKey  = $Azul->getKey();

//-------------------------------------------------------------------------------------------------

//Criando avião:
$AirBus_A380_PPART = new Airplane ($Latam, 'AirBus', 'A380', 'PP-ART', 90, 1390);

//-------------------------------------------------------------------------------------------------

//Cadastro Cliente
$Client_Santos = new Client ('Gabriel', 'Santos', '037.405.230-18', 'Santos', 'santastico@email.com', 'varginha');

//Cadastro Passageiro Vip
$Birth_Artur = new DateTime('16-06-03');
$Passenger_Artur = new Passenger('Artur', 'Souza', '02339430640','Brasileiro', $Birth_Artur,'MG20928340', 'souza', 'arturgs@email.com', 'divi');
$Passenger_ArturKey = $Passenger_Artur->getKey();
$Ponto_Artur = new Points ();
$Ponto_ArturKey = $Ponto_Artur->getKey();
$Passenger_Artur->addCredit(2000);
$Company_Artur =  $Passenger_Artur->getVipFlightCompany();

//-------------------------------------------------------------------------------------------------

//Criando Programa Milhagem
$Milhas = new MiliageProgram ('Milhas-AZUL', $AzulKey);
$Milhas->AddCategoria('Azul Inicial', 0);
$Milhas->AddCategoria('Azul Safira', 100);
echo "\nMOSTRANDO SUBCATEGORIAS DO PROGRAMA DE MILHAGEM: \n";
$Milhas->showSubCategorias();
$SubCategorias = $Milhas->getArraySubCategorias();
$AzulSafira = $Milhas->getSubCategoria(1);
$AzulSafira->AddPassenger($Passenger_ArturKey);
$AzulSafiraKey = $AzulSafira->getKey();

//-------------------------------------------------------------------------------------------------

//Cadastro de 2 aeronaves
echo "\nREGISTRANDO AERONAVE INVÁLIDA: \n";
$Embraer_175_LA = new Airplane ($Latam, 'Embraer', '175', 'PX-RUZ', 180, 600); //Avião Latam - sigla inválida
$Embraer_175_AD = new Airplane ($Azul, 'Embraer', '175', 'PP-RUZ', 180, 600); //Avião Azul - sigla válida

//Cadastro aviões extras - para realizar outros voos
$Embraer_175_CNF_CGH = new Airplane ($Azul, 'Embraer', '175', 'PP-RUZ', 180, 600);
$Embraer_175_GRU_GIG = new Airplane ($Azul, 'Embraer', '175', 'PP-RUZ', 180, 600);
$Embraer_175_CGH_CWB = new Airplane ($Azul, 'Embraer', '175', 'PP-RUZ', 180, 600);

//-------------------------------------------------------------------------------------------------

//Cadastro aeroportos
//CONFINS
$Adress_Confins = new Adress ('LMG-800 Km 7,9', 'Sem bairro', 'Confins', 'Minas Gerais', 0, 33500900, -19.634099, -43.965396); //endereço
$Aeroporto_Confins = new Airport('Aeroporto de Confins', 'CNF', $Adress_Confins, 'confins', 'confins@email.com', '1234');
//GUARULHOS
$Adress_Guarulhos = new Adress ('Rod. Hélio Smidt', 'Sem bairro', 'Guarulhos', 'São Paulo', 0, 7190100, -23.4306151, -46.475226); //endereço
$Aeroporto_Guarulhos = new Airport('Aeroporto de Guarulhos', 'CNF', $Adress_Guarulhos, 'guarulhos', 'guarulhos@gmail.com', '1357');
//CONGONHAS
$Adress_Congonhas = new Adress ('Av. Washington Luís', 'Vila Congonhas' , 'São Paulo', 'São Paulo', 0, 4626911, -23.6262496, -46.6616868); //endereço
$Aeroporto_Congonhas = new Airport('Aeroporto de Congonhas', 'CGH', $Adress_Congonhas, 'congonhas', 'congonhas@gmail.com', '2468');
//GALEÃO
$Adress_Galeao = new Adress ('Av. Vinte de janeiro', 'Sem bairro', 'Rio de Janeiro', 'Rio de Janeiro', 0, 21942900, -22.8147011,-43.2485675); //endereço
$Aeroporto_Galeao = new Airport('Aeroporto do Galeão', 'GIG', $Adress_Galeao, 'rj', 'rj@email.com', 'xurrasco021');
//AFONSO PENA
$Adress_AfonsoPena = new Adress ('Av. Rocha Pombo', 'Aguas Belas', 'São José dos Pinhais', 'Paraná', 0, 83010900, -25.5315016, -49.176215); //endereço
$Aeroporto_AfonsoPena = new Airport('Aeroporto do Galeão', 'CWB', $Adress_AfonsoPena, 'galeão', 'galeao@gmail.com', 'gal0');

//-------------------------------------------------------------------------------------------------

//Cadastro voo AC1329 (sigla inválida) da Azul ligando os aeroportos de Confins e Guarulhos
$dateSaidaAD1329 = new DateTime('now');
$dateChegadaAD1329 = new DateTime('now');
$dateSaidaAD1329->setTime("17", "10");
$dateChegadaAD1329->setTime("19","30");
$freqAD1329 = [true, true, true, true, true, true, true]; //Diário

//echo "\nREGISTRANDO CÓDIGO DE LINHA AÉREA INVÁLIDO: \n";
$VooAC1329 = new FlightLine("AC1329", $Aeroporto_Confins, $Aeroporto_Guarulhos, $dateSaidaAD1329, $dateChegadaAD1329,
                        $Embraer_175_AD, $Azul, true, $freqAD1329,100, 80, 49);

//Cadastro voo AD1329 (sigla válida) da Azul ligando os aeroportos de Confins e Guarulhos
$VooAD1329 = new FlightLine("AD1329", $Aeroporto_Confins, $Aeroporto_Guarulhos, $dateSaidaAD1329, $dateChegadaAD1329,
                        $Embraer_175_AD, $Azul, true, $freqAD1329,100, 80, 49);

//Cadastro de voos diários de:

//Guarulhos Confins (volta)
$dateSaidaGRU_CNF = new DateTime('now');
$dateChegadaGRU_CNF = new DateTime('now');
$dateSaidaGRU_CNF->setTime("21", "10");
$dateChegadaGRU_CNF->setTime("23","30");
$freqGRU_CNF = [true, true, true, true, true, true, true]; //Diário

$VooAD1330 = new FlightLine("AD1330", $Aeroporto_Guarulhos, $Aeroporto_Confins, $dateSaidaGRU_CNF, $dateChegadaGRU_CNF,
                        $Embraer_175_AD, $Azul, true, $freqGRU_CNF,100, 80, 49);


//Confins – Congonhas
//IDA
$dateSaidaCNF_CGH = new DateTime('now');
$dateChegadaCNF_CGH = new DateTime('now');
$dateSaidaCNF_CGH->setTime("07", "00");
$dateChegadaCNF_CGH->setTime("10","15");
$freqCNF_CGH = [true, true, true, true, true, true, true]; //Diário

$VooAD1606 = new FlightLine("AD1606", $Aeroporto_Confins, $Aeroporto_Congonhas, $dateSaidaCNF_CGH, $dateChegadaCNF_CGH,
                        $Embraer_175_CNF_CGH, $Azul, true, $freqCNF_CGH, 110, 50,29);

//VOLTA
$dateSaidaCGH_CNF = new DateTime('now');
$dateChegadaCGH_CNF = new DateTime('now');
$dateSaidaCGH_CNF->setTime("17", "45");
$dateChegadaCGH_CNF->setTime("21","00");
$freqCGH_CNF = [true, true, true, true, true, true, true]; //Diário

$VooAD1607 = new FlightLine("AD1607", $Aeroporto_Congonhas, $Aeroporto_Confins, $dateSaidaCGH_CNF, $dateChegadaCGH_CNF,
                        $Embraer_175_CGH_CNF, $Azul, true, $freqCGH_CNF, 110, 50,29);



//Guarulhos – Galeão
//IDA
$dateSaidaGRU_GIG = new DateTime('now');
$dateChegadaGRU_GIG = new DateTime('now');
$dateSaidaGRU_GIG->setTime("10", "00");
$dateChegadaGRU_GIG->setTime("12","45");
$freqGRU_GIG = [true, true, true, true, true, true, true]; //Diário

$VooAD2003 = new FlightLine("AD2003", $Aeroporto_Guarulhos, $Aeroporto_Galeao, $dateSaidaGRU_GIG, $dateChegadaGRU_GIG,
                        $Embraer_175_GRU_GIG, $Azul, true, $freqGRU_GIG, 179, 80, 30);

//VOLTA
$dateSaidaGIG_GRU = new DateTime('now');
$dateChegadaGIG_GRU = new DateTime('now');
$dateSaidaGIG_GRU->setTime("17", "00");
$dateChegadaGIG_GRU->setTime("19","15");
$freqGIG_GRU = [true, true, true, true, true, true, true]; //Diário

$VooAD2004 = new FlightLine("AD2004", $Aeroporto_Galeao, $Aeroporto_Guarulhos, $dateSaidaGIG_GRU, $dateChegadaGIG_GRU,
                        $Embraer_175_GRU_GIG, $Azul, true, $freqGIG_GRU, 179, 80, 30);



//Congonhas – Afonso Pena
//IDA
$dateSaidaCGH_CWB = new DateTime('now');
$dateChegadaCGH_CWB = new DateTime('now');
$dateSaidaCGH_CWB->setTime("12", "00");
$dateChegadaCGH_CWB->setTime("16","45");
$freqCGH_CWB = [true, true, true, true, true, true, true]; //Diário

$VooAD4545 = new FlightLine("AD4545", $Aeroporto_Congonhas, $Aeroporto_AfonsoPena, $dateSaidaCGH_CWB, $dateChegadaCGH_CWB,
                        $Embraer_175_CGH_CWB, $Azul, true, $freqCGH_CWB, 200, 45, 80);

//VOLTA
$dateSaidaCWB_CGH = new DateTime('now');
$dateChegadaCWB_CGH = new DateTime('now');
$dateSaidaCWB_CGH->setTime("12", "00");
$dateChegadaCWB_CGH->setTime("16","45");
$freqCWB_CGH = [true, true, true, true, true, true, true]; //Diário

$VooAD4545 = new FlightLine("AD4545", $Aeroporto_AfonsoPena, $Aeroporto_Congonhas, $dateSaidaCWB_CGH, $dateChegadaCWB_CGH,
                        $Embraer_175_CGH_CWB, $Azul, true, $freqCWB_CGH, 200, 45, 80);


//-------------------------------------------------------------------------------------------------   
                     
//Gerando Viagens disponíveis para os proximos 30 dias



//-------------------------------------------------------------------------------------------------   

//Cliente comprando passagem para passageiro vip


//Comprando passagem Confins / Afonso Pena

//print
echo "\nROTA PARA BUSCAR TRIPULAÇÃO VIAGEM: \n";

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
$nascimento_ronaldo = new DateTime('14-11-03');
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
$data = new DateTime("now"); $data->setTime("18", "30");
$Rota = new Route($crewKey, $Aeroporto_Confins, $veiculo, $data);

//Printando Rota:
$Rota->descricaoRota();
