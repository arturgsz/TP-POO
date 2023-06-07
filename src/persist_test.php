<?php 
include_once "global.php";
$sed = new UserAuthenticate();
$sed->LogIn("cruze", "123");

$user = new User("santos", "kv","123");
$user = new User("turito", "kib","123");

$ad = new Adress("bs", "swntsa","MG", "gv","38", "350","6165","
  44");

//  $airport1 = new Airport("c port", "SFT", $ad);
//  $airport2 = new Airport("cnv port", "SFT", $ad );
//  $airport3 = new Airport("guss port", "SFT", $ad );


$airport = Airport::getBykey(2);
// $ad1 = $airport->getAdress();
// print_r($ad1);

 print_r($airport);
// $airport->setSigla("GSC");
// print_r($airport);

//echo $airport->getAdress()->getRua()+ PHP.en;
//$airplane->save();

//$airport->delete();
//$airplane->save();
// $airplane->save();
// $airplane->save();

//$dump = Adress::getRecords();
//print_r($dump);
$dumpad = Adress::getRecords();
print_r($dumpad);

$dump = Airport::getRecords();
print_r($dump);

// $id = "3";
// $af = Airport::getRecordsByField("index", $id);
//print_r($af);


?>