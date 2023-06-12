<?php
require_once "./src/System.php";

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
//print_r($company);
$airplane = new Airplane($company, "ougpib","iyg","PT-abc","5","50");
//print_r($airplane);

$dateSaida = new DateTime('now');
$dateChegada = new DateTime('now');
$dateSaida->setTime("10", "30");
$dateChegada->setTime("20","00");

$dateSaida1 = new DateTime('now');
$dateChegada1 = new DateTime('now');
$dateSaida1->setTime("21", "10");
$dateChegada1->setTime("23","30");

$freq = [false, true, true, false, false, false, true];

$line1 = new FlightLine($airport1, $airport2, $dateSaida, $dateChegada,
                        $airplane, true, $freq, 100, 80, 15);

$line2 = new FlightLine($airport1, $airport3, $dateSaida, $dateChegada,
                        $airplane, true, $freq, 300, 80,15);

$line3 = new FlightLine($airport2, $airport3, $dateSaida1, $dateChegada1,
                        $airplane, true, $freq, 100, 80, 15);


$birth = new DateTime;
$birth->setDate(2003,12,3);                     
$passanger = new Passenger("cruze", "sousa", "70123394627", "BRASILEIRO", $birth, "16746", false,"curcru","cruzee@gmail.com","1234");
$passanger->addCredit(2000);

$paths = Travel::showPossibleTravels($airport1, $airport3,new DateTime('2023-06-14 8:00'),2);

$travel = new Travel($paths[1], $passanger->getKey());
$travel->showSeats();

$travel->buyTravel(4, 2, 2);

print_r(FlightTicket::getRecords());
print_r(Travel::getRecords());
// print_r(Flight::getRecords());
print_r(Passenger::getByKey($passanger->getKey()));


