<?php
require_once "../src/System.php";


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

//Criando avião:
$AirBus_A380_PPART = new Airplane ($Latam, 'AirBus', 'A380', 'PP-ART', 90, 1390);
//Criando aeroporto:

//Cadastro de 2 companhias Aéreas:
//Companhia Latam criada sem erros:
$Latam = new FlightCompany('LATAM', '101','Latam Airlines do Brasil S.A.','12.345.678/0001-12','LA', 'latam', 'latam@email.com', 'latambr' );

$Azul = new FlightCompany('AZUL', '002','Azul Linhas Aéreas Brasileiras S.A.','36.613.535/0001-85','AD', 'azul', 'azul@email.com', 'azulniao');

//Criando Programa Milhagem
$Milhas = new MiliageProgram ('Milhas-AZUL', $AzulKey);
$Milhas->AddCategoria('Azul Inicial', 0);
$Milhas->AddCategoria('Azul Safira', 100);
$Milhas->showSubCategorias();
$SubCategorias = $Milhas->getArraySubCategorias();
$AzulSafira = $Milhas->getSubCategoria(1);
$AzulSafira->AddPassenger($Passenger_ArturKey);
$AzulSafiraKey = $AzulSafira->getKey();

//Cadastro de 2 aeronaves
$Embraer_175_LA = new Airplane ($Latam, 'Embraer', '175', 'PX-RUZ', 180, 600); //Avião Latam - sigla inválida
$Embraer_175_AD = new Airplane ($Azul, 'Embraer', '175', 'PP-RUZ', 180, 600); //Avião Azul - sigla válida

//Cadastro aeroportos
//CONFINS
$Adress_Confins = new Adress ('LMG-800 Km 7,9', 'Sem bairro', 'Confins', 'Minas Gerais', 0, 33500900, -19.634099, -43.965396); //endereço
$Aeroporto_Confins = new Airport('Aeroporto de Confins', 'CNF', $Adress_Confins, 'confins', 'confins@email.com', '1234');
//GUARULHOS
$Adress_Guarulhos = new Adress ('Rod. Hélio Smidt', 'Sem bairro', 'Guarulhos', 'São Paulo', 0, 07190100, -23.4306151, -46.475226); //endereço
$Aeroporto_Guarulhos = new Airport('Aeroporto de Guarulhos', 'CNF', $Adress_Guarulhos, 'guarulhos', 'guarulhos@gmail.com', '1357');
//CONGONHAS
$Adress_Congonhas = new Adress ('Av. Washington Luís', 'Vila Congonhas' , 'São Paulo', 'São Paulo', 0, 04626911, -23.6262496, -46.6616868); //endereço
$Aeroporto_Congonhas = new Airport('Aeroporto de Congonhas', 'CGH', $Adress_Congonhas, 'congonhas', 'congonhas@gmail.com', '2468');
//GALEÃO
$Adress_Galeao = new Adress ('Av. Vinte de janeiro', 'Sem bairro', 'Rio de Janeiro', 'Rio de Janeiro', 0, 21942900, -22.8147011,-43.2485675); //endereço
$Aeroporto_Galeao = new Airport('Aeroporto do Galeão', 'GIG', $Adress_Galeao, 'rj', 'rj@email.com', 'xurrasco021');
//AFONSO PENA
$Adress_AfonsoPena = new Adress ('Av. Rocha Pombo', 'Aguas Belas', 'São José dos Pinhais', 'Paraná', 0, 83010900, -25.5315016, -49.176215); //endereço
$Aeroporto_AfonsoPena = new Airport('Aeroporto do Galeão', 'CWB', $Adress_AfonsoPena, 'galeão', 'galeao@gmail.com', 'gal0');

//Cadastro voo AC1329 (sigla inválida) da Azul ligando os aeroportos de Confins e Guarulhos
$dateSaidaAD1329 = new DateTime('now');
$dateChegadaAD1329 = new DateTime('now');
$dateSaidaAD1329->setTime("21", "10");
$dateChegadaAD1329->setTime("23","30");
$freqAD1329 = [true, true, true, true, true, true, true]; //Diário
//FALTA CHECAR SIGLA
$VooAC1329 = new FlightLine($Aeroporto_Confins, $Aeroporto_Guarulhos, $dateSaidaAD1329, $dateChegadaAD1329,
                        $Embraer_175_AD, $Azul, true, $freqAD1329,100, 80, 49);

//Cadastro voo AD1329 (sigla inválida) da Azul ligando os aeroportos de Confins e Guarulhos
$VooAD1329 = new FlightLine($Aeroporto_Confins, $Aeroporto_Guarulhos, $dateSaidaAD1329, $dateChegadaAD1329,
                        $Embraer_175_AD, $Azul, true, $freqAD1329,100, 80, 49);

//Cadastro de voos diários de:

//Confins – Guarulhos

//Confins – Congonhas

//Guarulhos – Galeão

//Congonhas – Afonso Pena

//Gerando Viagens disponíveis para os proximos 30 dias

//Cliente comprando passagem para passageiro vip
//Cadastro Cliente
$Client_Cruze = new Client ('Gabriel', 'Cruzati', '037.405.230-18', 'Cruze', 'Gcruzati@email.com', '1234');

//Cadastro Passageiro Vip
$Birth_Artur = new DateTime('16-06-2003');
$Passenger_Artur = new Passenger('Artur', 'Souza', '02339430640','Brasileiro', $Birth_Artur,'MG20928340', true, 'Turito', 'arturgs@email.com','galo');
$Passenger_Artur->vip(1234, $AzulKey, $Ponto_ArturKey);
$Passenger_Artur->addCredit(2000);
$Company_Artur =  $Passenger_Artur->getVipFlightCompany();

//Comprando passagem Confins / Afonso Pena



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

//Printando Rota:
$Rota->descricaoRota();
