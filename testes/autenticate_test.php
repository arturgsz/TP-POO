<?php 
require_once "./src/System.php";

    try{
        $ad = new Adress("ougdwc","giy","vi","ogu","561","465","48","145");
    }catch( Exception $e){
        echo $e->getMessage()."\n";
    }

    User::getRecords();
    Adress::getRecords();

 $sed = new UserAuthenticate();
 
 try{
    $s = new UserAuthenticate();

}catch( Exception $e){
    echo $e->getMessage()."\n";
}

 $sed->LogIn("Cruz", "1234");

 $sed->LogIn("Cruze", "1234");

    System::cleanDB();

 $sed->LogIn("Cruze", "1234");

 UserAuthenticate::LogOut();

 User::getRecords();

 $sed->LogIn("Cruze", "1234");



$ad1 = new Adress("ougdwc","giy","vi","ogu","561","465","48","145");
$ad2 = new Adress("oc","giy","vi","ogu","561","465","48","145");
$ad3 = new Adress("oc","giy","vi","ogu","561","465","48","145");


$op = Adress::getRecordsByField("rua","oc");
print_r($op);


$user = new User("Cr7u", "ckj4e@gmail.com","1234");
$client = new Client("Osvaldo", "Pereira","70123394627","Osvald",'Osvald@gmail.com', "1234");
$air = new Airport("santosPort","GRU",$ad1,"santosPort","santosPort@gmail.com","1234");

print_r(User::getRecords());
print_r(Client::getRecords());

UserAuthenticate::LogOut();
$sed->LogIn("santosPort","1234");

print_r(Airport::getRecords());

WriteLog::showLogs();
ReadLog::showLogs();

