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

//Cadastro voo AC1329 (sigla inválida) da Azul ligando os aeroportos de Confins e Guarulhos

//Cadastro voo AD1329 (sigla inválida) da Azul ligando os aeroportos de Confins e Guarulhos


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

//Comprando passagem Confins / Afonso Pena



//Cadastrando Crew
//Piloto
$nascimento_carlos = new DateTime('14-03-1966');
$Adress_Jose = new Adress ('Rod. Hélio Smidt', 'Aeroporto', 'Guarulhos', 0, 7190100, 1 , 2);
$Piloto = new Crew("Jose", "Almeida", "727.206.050-69", "brasileiro", $nascimento_jose, "email@email.com", "documento", $Adress_Jose, $Latam, $Aeroporto_Pampulha);

//Copiloto
$nascimento_ronaldo = new DateTime('14-11-2003');
$Adress_Ronald = new Adress ('Rua Desembargador Paulo Mota', 'Ouro Preto', 'Belo Horizonte', 40, 7190100, 0 , 1);
$CoPiloto = new Crew("Ronaldo", "Gonçalves", "142.593.620-20", "brasileiro", $nascimento_ronaldo, "ronaldogsa@gmail.com", "documento", $Adress_Ronald, $Latam, $Aeroporto_Pampulha);