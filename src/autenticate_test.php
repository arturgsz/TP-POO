<?php 
require_once "System.php";

//$us = new User("Cruze", "cruze@gmail.com","1234");
 $sed = new UserAuthenticate();
 $sed->LogIn("Cruze", "1234");

$ad = new Adress("ougdwc","giy","vi","ogu","561","465","48","145");

//  $op = Adress::getRecordsByField("rua","oudwc");
// //  print_r($op);
//$user = new User("Cr7u", "ckj4e@gmail.com","1234");
 //$client = new Client("Osvaldo", "Pereira","70123394627","Osvald",'Osvald@gmail.com', "1234");
 
// print_r(User::getRecordsByField("login", "Cru"));
// print_r(User::getRecordsByField("email","cruzbkje@gmail.com"));


//System::cleanDB();
 print_r(Client::getRecords());
 print_r(User::getRecords());
 print_r(Adress::getRecords());
// //  WriteLog::showLogs();
// ReadLog::showLogs();
// print_r(Client::getRecords());
// print_r(User::getRecords());
// print_r(Adress::getRecords());


// $airport = Airport::getByKey(3);
// print_r($airport);

// $airport->setSigla("OKW");
// print_r($airport);
// $dump2 = User::getRecords();
// $dump3 = Adress::getRecords();
// $dump4 = Airport::getRecords();
//print_r($dump2);

//WriteLog::showLogs();
//ReadLog::showLogs();
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