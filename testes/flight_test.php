<?php
include "./src/System.php";

try{
    $ad = new Adress("Rua Desembargador Paulo Mota","Ouro Preto","Belo Horizonte","MG",561,31201201,-19.456099, -43.024858);
}catch( Exception $e){
    echo $e->getMessage()."\n";
}
try{
    User::getRecords();
    Adress::getRecords();

}catch(Exception $e){
    echo $e->getMessage();
}

$us = new UserAuthenticate();
$us->LogIn("Cruze","1234");

System::cleanDB();

$ad1 = new Adress("piód","lj","pihihg8p","pihpih","25","354","1546","46796");
$ad2 = new Adress("khbç","ljb","pihihg8p","pihpih","25","354","156","46796");
$ad3 = new Adress("iyiyf","ljb","pihihg8p","pihpih","25","354","156","46796");
$airport1 = new Airport("santso durmod", "GRU",$ad1 ,"santos","santos@gmail.com","1234");
$airport2 = new Airport("santoso master", "GRU",$ad2 ,"sant","saos@gmail.com","1234");
$airport3 = new Airport("santoso Duplo", "GRU",$ad2 ,"santinho","saougos@gmail.com","1234");

$company = new FlightCompany("azul","AE","bougo","ouhouo","AE","aul","azul@gmail.com","1234");
$company2 = new FlightCompany("gool","GO","bougo","ouhouo","GO","goo","aul@gmail.com","1234");

//print_r($company);
$airplane = new Airplane($company, "ougpib","iyg","PT-abc","5","50");
$airplane2 = new Airplane($company2, "ougpib","iyg","PT-abc","5","50");

//print_r($airplane);

$dateSaida = new DateTime('now');
$dateChegada = new DateTime('now');
$dateSaida->setTime("10", "30");
$dateChegada->setTime("20","00");

$dateSaida1 = new DateTime('now');
$dateChegada1 = new DateTime('now');
$dateSaida1->setTime("21", "10");
$dateChegada1->setTime("23","30");

$freq = [true, false, false, true, false, true, false];

$line1 = new FlightLine("AE2456",$airport1, $airport2, $dateSaida, $dateChegada,
                        $airplane, $company,true, $freq,100, 80, 15);

$line2 = new FlightLine("AE1234",$airport1, $airport3, $dateSaida, $dateChegada,
                        $airplane, $company, true, $freq, 300, 80,15);

$line3 = new FlightLine("GO2568",$airport2, $airport3, $dateSaida1, $dateChegada1,
                        $airplane2, $company2, true, $freq, 100, 80, 15);


$birth = new DateTime;
$birth->setDate(2003,12,3);                     
$passanger = new Passenger("cruze", "sousa", "70123394627", "BRASILEIRO", $birth, "16746","curcru","cruzee@gmail.com","1234");
$passanger->addCredit(2000);

$Milhas = new MiliageProgram ('Milhas-AZUL', $company->getKey());
$Milhas->AddCategoria('Azul Inicial', 0);
$Milhas->addPassanger($passanger);

$paths = Travel::showPossibleTravels($airport1, $airport3,new DateTime('2023-06-14 8:00'),2);

$travel = new Travel($paths[1], $passanger->getKey());
$travel->showSeats();
$travel->buyTravel(4, 2, 2);

$travel->showTicketscards();
$travel->checkIn();
$travel->onBoard();

$flight1 = $travel->getFlightsKey(0);
$flight2 = $travel->getFlightsKey(1);


$flight1->setFlightState(FlightState::Crew_Preparada);
$flight2->setFlightState(FlightState::Crew_Preparada);

$flight1->planeTookOff(new DateTime());
$flight1->planeLanded(new DateTime());


$flight2->planeTookOff(new DateTime());
$flight2->planeLanded(new DateTime());

print_r(FlightTicket::getRecords());
print_r(Travel::getRecords());
print_r(Points::getRecords());
print_r(Passenger::getByKey($passanger->getKey()));
//  WriteLog::showLogs();
//  ReadLog::showLogs();

System::cleanDB();
