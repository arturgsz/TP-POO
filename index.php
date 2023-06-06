<?php
require_once("./src/classes/FlightCompany.php");
require_once("./src/classes/Airplane.php");
require_once("./src/classes/Airport.php");
require_once("./src/classes/Travel.php");
require_once("./src/classes/FlightLines.php");
require_once("./src/classes/Passenger.php");
require_once("./src/classes/FlightTicket.php");

//Criando e testando Flight Companies
try{
//Companhia Latam criada sem erros:
$Latam = new FlightCompany('LATAM','JJ','Tam Linhas Aéreas S/a - Processos','12.345.678/0001-12','LT', 34.2);
echo "Flight Company: LATAM"; echo "<br>";
var_dump($Latam);
echo "<br>---<br>";
//ERRO: sigla nao atende os requisitos:
echo "Flight Company: GOL"; echo "<br>";
$Gol = new FlightCompany('Gol','G3GE','GOl Linhas Aéreas S/a - Processos','12.345.678/0001-12','LTDE', 34.2);
var_dump($Gol);
echo "<br>---<br>";
echo "<br>";
}catch(Exception $e){
  echo "<br>---<br>";
}


//Criando avião
$AirBus_A380_PPART = new Airplane ($Latam, 'AirBus', 'A380', 'PP-ART', 90, 1390);
echo "Airplane: AIRBUS_A380"; echo "<br>";
var_dump($AirBus_A380_PPART);
echo "<br>---<br>";
$Boeing_A320_PRGUO = new Airplane($Latam,'Boeing','A-320', 'PR-GUO', 2, 2.5);
echo "Airplane: BOEING_A320"; echo "<br>";
var_dump($Boeing_A320_PRGUO);
echo "<br>---<br>";


// Criando aeroportos;
$Adress_AeroPamp = new Adress ('Praça Bagatelle', 'São Luis', 'Belo Horizonte', 204, 31270705, 1, 0);
$Aeroporto_Pampulha = new Airport('Aeroporto Pampulha', 'PLU', 'Belo Horizonte', 'Minas Gerais', $Adress_AeroPamp);
var_dump($Aeroporto_Pampulha);
echo "Airport: PAMPULHA"; echo "<br>";
echo "<br>---<br>";
$Adress_AeroGru = new Adress ('Rod. Hélio Smidt', 'Aeroporto', 'Guarulhos', 0, 7190100, 1 , 3);
$Aeroporto_Guarulhos = new Airport('Aeroporto de Guarulhos', 'GRU', 'Guarulhos', 'São Paulo', $Adress_AeroGru);
echo "Airport: GUARULHOS"; echo "<br>";
var_dump($Aeroporto_Guarulhos);
echo "<br>---<br>";
  

//Criando Flight Lines
$departure = new DateTime('2023-02-14 12:00');
$arrival = new DateTime('2023-02-14 13:40');
$freq = [];
$Pampulha_Guarulhos = new FlightLines($Aeroporto_Pampulha, $Aeroporto_Guarulhos,
                                      $departure, $arrival,
                                      $AirBus_A380_PPART, true, $freq, 110.90);

echo "Flight Line: PAMPULHA to GUARULHOS"; echo "<br>";
var_dump($Pampulha_Guarulhos);
echo "<br>---<br>";


//Criando Passenger
echo "Passenger: ARTUR"; echo "<br>";
$nascimento_Artur = new DateTime('16-06-2003');
$Passenger_Artur = new Passenger('Artur', 'Souza', '02339430640', 'arturgdes2003@gmail.com',
                                 'Brasileiro', $nascimento_Artur, "doc123", false);
var_dump($Passenger_Artur);
echo "<br>---<br>";


//Passenger com erro no email
try{
echo "Passenger: JULIETA"; echo "<br>";
$nascimento_Julieta = new DateTime('13-07-1972');
$Passenger_Julieta = new Passenger('Julieta', 'Souza', '567.432.466-20', 'julietasouza@gmail',
                                 'Brasileira', $nascimento_Julieta, "doc345", false);
var_dump($Passenger_Julieta);
echo "<br>---<br>";
}catch(Exception $e){
  echo "<br>---<br>";
}


//Criando Travel
echo "Travel: TRAVEL: PAMPULHA - GUARULHOS"; echo "<br>";
$Travel_Pampulha_Guarulhos = new Travel ($Pampulha_Guarulhos);
$Travel_Pampulha_Guarulhos->informacoes();
echo "<br>---<br>";
echo $Travel_Pampulha_Guarulhos->getCode();
echo "<br>---<br>";


//Criando Flight Ticket
echo "Flight Ticket: TICKET PAMPULHA-GUARULHOS"; echo "<br>";
$Ticket_Pampulha_Guarulhos = new FlightTicket ($Travel_Pampulha_Guarulhos, $Passenger_Artur, 10, 1);
//var_dump($Ticket_Pampulha_Guarulhos);
var_dump($Ticket_Pampulha_Guarulhos);
echo "<br>---<br>";

$Travel_Pampulha_Guarulhos->MostraAssentos();


//Criando Crew Members
$nascimento_jose = new DateTime('16-06-2003');
$nascimento_ronaldo = new DateTime('14-11-2003');
$Adress_Jose = new Adress ('Rod. Hélio Smidt', 'Aeroporto', 'Guarulhos', 0, 7190100, 1 , 2);
$Adress_Ronald = new Adress ('Rua Desembargador Paulo Mota', 'Ouro Preto', 'Belo Horizonte', 40, 7190100, 0 , 1);

$Pilot1 = Crew("Jose", "Almeida", "727.206.050-69", "brasileiro", $nascimento_jose, "email@email.com", "documento", $Adress_Jose, $Latam, $Aeroporto_Pampulha);

$Pilot2 = Crew("Ronaldo", "Gonçalves", "142.593.620-20", "brasileiro", $nascimento_ronaldo, "ronaldogsa@gmail.com", "documento", $Adress_Ronald, $Latam, $Aeroporto_Pampulha);

//Criando Veiculo
$monza_tubarao = new Vehicle ("Monza Tubarão 94", "MON-1994", 5);

//Criando Route:
$crew_members = [$Pilot1, $Pilot2];
$horavoo = new DateTime('2023-02-14 13:40');
$rota1 = new Route ($crew_members, $Aeroporto_Pampulha, $monza_tubarao, $horavoo);
$rota1->descricaoRota();