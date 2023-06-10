<?php
require_once "../src/System.php";

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


$freq = [false, true, true, false, false, false, true];

$line1 = new FlightLine($airport1, $airport2, $dateSaida, $dateChegada,
                        $airplane, true, $freq, 20000, 80);

$line2 = new FlightLine($airport1, $airport3, $dateSaida, $dateChegada,
                        $airplane, true, $freq, 20000, 80);

$line3 = new FlightLine($airport2, $airport3, $dateSaida, $dateChegada,
                        $airplane, true, $freq, 20000, 80);

print_r(FlightLine::getRecords());


// $flight = Flight::getByKey(3);
// $flight->secureSeat("3","5");
// $flight->secureSeat("1","5");
// $flight->secureSeat("4","5");

// $flight->cancelSeat("4");
// print_r($flight->availableSeats());

//print_r(Flight::getRecords());

print_r(Travel::showPossibleTravels($airport1, $airport3));




