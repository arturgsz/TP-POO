<?php
require_once("./src/FlightCompany.php");
require_once("./src/Airplane.php");
require_once("./src/Airport.php");
require_once("./src/Travel.php");
require_once("./src/FlightLines.php");
require_once("./src/Passenger.php");
require_once("./src/FlightTicket.php");

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
$Aeroporto_Pampulha = new Airport('Aeroporto Pampulha', 'PLU', 'Belo Horizonte', 'Minas Gerais');
var_dump($Aeroporto_Pampulha);
echo "Airport: PAMPULHA"; echo "<br>";
echo "<br>---<br>";
$Aeroporto_Guarulhos = new Airport('Aeroporto de Guarulhos', 'GRU', 'Guarulhos', 'São Paulo');
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
                                 'Brasileiro', $nascimento_Artur, false);
var_dump($Passenger_Artur);
echo "<br>---<br>";

//Passenger com erro no email
try{
echo "Passenger: JULIETA"; echo "<br>";
$nascimento_Julieta = new DateTime('13-07-1972');
$Passenger_Artur = new Passenger('Julieta', 'Souza', '567.432.466-20', 'julietasouza@gmail',
                                 'Brasileira', $nascimento_Julieta, false);
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
echo $Travel_Pampulha_Guarulhos->getTravelCode();
echo "<br>---<br>";

//Criando Flight Ticket
echo "Flight Ticket: TICKET PAMPULHA-GUARULHOS"; echo "<br>";
$Ticket_Pampulha_Guarulhos = new FlightTicket ($Travel_Pampulha_Guarulhos, $Passenger_Artur, 10, 1);
//var_dump($Ticket_Pampulha_Guarulhos);
$Ticket_Pampulha_Guarulhos->informacoes();
echo "<br>---<br>";