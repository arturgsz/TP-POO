<?php

require_once "Persist.php";
require_once "Flight.php";
require_once "FlightCompany.php";
require_once "FlightLine.php";
require_once "FlightTicket.php";
require_once "Passenger.php";

enum TravelStatus{
    case Trajeto_definido;
    case Passagem_adquirida;
    case CheckIn;
    case NO_SHOW;
    case Embarque;
    case EmVool;
    case Desembarque;
    case Viagem_realizada;
    case Viagem_cancelada;
}

class Travel extends Persist{

protected array $flightTicketsKey;
protected int $passagerKey;
protected float $price;
protected TravelStatus $status;
protected static $local_filename = "Travel.txt";

public function __construct($PossibleFlightPath, $passangerKey){

//funciona e constroi a travel



//devolve um erro

}

public function checkIn(){

}

public function setTravelState(TravelStatus $state){

}


public function cancelTravel(){



}

public function refund(){



}


static function showPossibleTravels(Airport $origin, Airport $destiny): array{

    $PossibleFlightPath = array(

        "lineKey" => null,
        "connectionKey" =>null,
        // "flightCode" => null,
        // "connectionCode" =>null,
        // "price" => null,
        // "dateTime" => null,
        // "numberFreeSeats" =>null
    );
    $PossibleFlightPaths = array($PossibleFlightPath);
    unset($PossibleFlightPaths[0]);

    //Descobre quais lines ligam 2 pontos
    $flightLineOrigin = FlightLine::getRecordsByField("airportOriginKey",$origin->getKey()); 
    foreach($flightLineOrigin as $lineOrigin){

        if(($lineOrigin->getDestiny())->getKey() == $destiny->getKey()){
            //O voo é uma linha direta
            $somePath = $PossibleFlightPath;
            $somePath["lineKey"] = $lineOrigin->getKey();
            array_push($PossibleFlightPaths, $somePath);
        
        }else{
            //o voo pode conter ligações
            $connection = ($lineOrigin->getDestiny())->getKey();
                $possibleConnections = FlightLine::getRecordsByField("airportOriginKey", $connection);

                foreach($possibleConnections as $possibleConnection){
                    if(($possibleConnection->getDestiny())->getKey() == $destiny->getKey()){
                        //O voo é uma possivel conexao
                        $someConnectedPath = $PossibleFlightPath;
                        $someConnectedPath["lineKey"] = $lineOrigin->getKey();
                        $someConnectedPath["connectionKey"] = $possibleConnection->getKey();
                        array_push($PossibleFlightPaths, $someConnectedPath);
                    
                    }
                }
        }
    }



    
    return $PossibleFlightPaths;
}

static public function getFilename()
    {
        return get_called_class()::$local_filename;
    }
}

