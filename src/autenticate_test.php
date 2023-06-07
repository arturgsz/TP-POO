<?php 
require_once "global.php";

// $ad = new Adress("ougdwc","giy","vi","ogu","561","465","48","145");
// $dump1 = Adress::getRecords();
// //print_r($dump1);

// $us = new UserAuthenticate();
// $us1 = new UserAuthenticate();

$sed = new UserAuthenticate();
$sed->LogIn("cruze", "123");

$airport = Airport::getByKey(3);
print_r($airport);

$airport->setSigla("OKW");
print_r($airport);
// $dump2 = User::getRecords();
// $dump3 = Adress::getRecords();
// $dump4 = Airport::getRecords();
//print_r($dump2);

WriteLog::showLogs();
ReadLog::showLogs();
// UserAuthenticate::LogOut();

// $dump3 = Airport::getRecords();
// print_r($dump3);

// $us->LogIn("cru", "1234");

// $dump4 = Adress::getRecords();
// print_r($dump4);


//echo UserAuthenticate::Authentication();
//UserAuthenticate::LogOut();
//UserAuthenticate::LogIn("santaqo", "1234");
 //$us = new User("cru", "email36","1234");
// $us = new User("santaqo", "email415","1234");

//$user = User::getByKey(1);

//$user->login("1234");

//$dump = User::getRecordsByField("is_online", "true");



?>