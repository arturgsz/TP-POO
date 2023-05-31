<?php 

include_once "global.php";
//$ad = new Adress("campos", "stsa", "gv","38", "350");

//$airplane = new Airport("cruain port", "SFT","goval", "Minas",$ad );

$airplane = (Airport::getRecordsByField("index","4"))[0];

$airplane->setSigla("OFQ");
//$airplane->save();
// $airplane->save();
// $airplane->save();

//$dump = Adress::getRecords();
//print_r($dump);

$dump = Airport::getRecords();
print_r($dump);

// $id = "3";
// $af = Airport::getRecordsByField("index", $id);
//print_r($af);





?>