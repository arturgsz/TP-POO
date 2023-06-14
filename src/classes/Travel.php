<?php

require_once "Flight.php";
require_once "FlightLine.php";
require_once "FlightTicket.php";
require_once "Passenger.php";
require_once "FlightPath.php";

enum TravelStatus{
    case Trajeto_definido;
    case Passagem_adquirida;
    case CheckIn;
    case EmVool;
    case Viagem_realizada;
    case Viagem_cancelada;    
    case NO_SHOW;
}

class Travel extends FlightPath{

protected array $flightTicketsKey;
protected array $flightsKey;
protected int $passangerKey;
protected float $price;
protected TravelStatus $status;
protected float $miliage = 0;
protected static $local_filename = "Travel.txt";

public function __construct(FlightPath $flightPath, int $passangerKey){
//funciona e constroi a travel
$this->passangerKey = $passangerKey;
    ($this->flightsKey)[0] = ((Flight::getRecordsByField("flightCode", $flightPath->flightCode))[0])->getkey();
    
    if(!empty($flightPath->connectionFlightCode)){
        ($this->flightsKey)[1] = ((Flight::getRecordsByField("flightCode", $flightPath->connectionFlightCode))[0])->getKey();
    }
    $this->miliage = $this->calcMiliage();
    $this->status = TravelStatus::Trajeto_definido;

    try{
        $this->save(); 
      }catch(Exception $e){
         echo $e->getMessage();
         throw($e);
      }

    (Passenger::getByKey($this->passangerKey))->setTravel($this->getKey());
}
public function showSeats(){
    $flight1 = Flight::getByKey(($this->flightsKey)[0]);
    echo "Os lugares livres para o voo ".$flight1->getFlightCode()." são:\n";
    print_r($flight1->availableSeats());

    if(!empty(($this->flightsKey)[1])){
        $flight2 = Flight::getByKey(($this->flightsKey)[1]);
        echo "Os lugares livres para o voo de escala ".$flight2->getFlightCode()." são:\n";
        print_r($flight2->availableSeats());
    }
}   
public function buyTravel(int $seat1, ?int $seat2, int $luggadge){

    if(!($this->validateSeat($seat1, $seat2)))
        throw(new Exception("O lugar requerido não está mais disponivel"));

    if($luggadge < 0 || $luggadge > 3)
        throw(new Exception("Número de bagagens inválido"));

    try{
        $ticket1 = new FlightTicket(($this->flightsKey)[0],$this->passangerKey, $seat1, $luggadge, $this->getKey());
        ($this->flightTicketsKey)[0] = $ticket1->getKey();
        $this->price = $ticket1->getPrice();
        
        if(!empty(($this->flightsKey)[1])){
            $ticket2 = new FlightTicket(($this->flightsKey)[1],$this->passangerKey, $seat2, $luggadge, $this->getKey());
            ($this->flightTicketsKey)[1] = $ticket2->getKey();
            $this->price += $ticket2->getPrice();
        }
    
    }catch(Exception $e){
        throw($e);
    }
    try{
        (Passenger::getByKey(($this->passangerKey)))->pay($this->price);

    }catch(Exception $e){
        $ticket1->delete();
        $ticket2->delete();
        throw($e);
    }
    $this->status = TravelStatus::Passagem_adquirida;
    $this->save();
}
public function checkIn(){

}

public function setTravelState(TravelStatus $state){
    $this->status = $state;
    $this->save();
}
public function getTravelState(): TravelStatus{
    return $this->status;
}

public function TookOff(){

}
public function Landed(){

}

public function calcMiliage(): float{
    $miliage = 0;
        if(!($this->payFine(($this->flightsKey)[0]))){
         
            $miliage += Flight::getByKey(($this->flightsKey)[0])->getFlightLine()->getMiliage();

        }
        if(!empty($this->flightsKey[1])){
            if(!($this->payFine(($this->flightsKey)[1]))){
                $miliage += Flight::getByKey(($this->flightsKey)[1])->getFlightLine()->getMiliage();

            }
        }
        echo $miliage;
        return $miliage;
}
//Uma vez a flight é terminada
public function atributeMiliage(){
    $departure = Flight::getByKey($this->flightsKey[0])->getDeparture();
    Passenger::getByKey($this->passangerKey)->getPointsObj()->AddPontos($this->miliage, $departure);

}

public function payFine($flightKey): bool{

    $payFine = true;
    $passenger = Passenger::getByKey($this->passangerKey); 

    if($passenger->isVip()){
        $companyPass = $passenger->getVipFlightCompany();
        $companyFlight = (Flight::getByKey($flightKey))->getFlightLine()->getCompanyKey();
        if($companyFlight == $companyPass->getKey())
            $payFine = false;
    }
    return $payFine;
}

private function getFine(): float{
    $fine = 0;

    if($this->payFine(($this->flightsKey)[0]))
        $fine += Flight::getByKey(($this->flightsKey)[0])->getFlightLine()->getFine();

    if(!empty(($this->flightsKey)[1])){
        if($this->payFine(($this->flightsKey)[1]))
            $fine += Flight::getByKey(($this->flightsKey)[1])->getFlightLine()->getFine();
    }
    return $fine;
}

public function editTravel(int $seat1, ?int $seat2, int $luggadge){

    $flight1time = Flight::getByKey($this->flightsKey[0])->getDeparture();
    $flight1time->modify("-4 hours");
    $time = new DateTime('now');

    if($time > $flight1time)
        throw(new Exception("O prazo para alteração na passagem foi esgotado\n"));

    if(!($this->validateSeat($seat1, $seat2)))
        throw(new Exception("O lugar requerido não está mais disponivel\n"));
    

    Passenger::getByKey($this->passangerKey)->addCredit($this->price - $this->getFine());

    $ticket1 = FlightTicket::getByKey($this->flightTicketsKey[0]);
    $ticket1->cancelTicket();


    if(!empty(($this->flightTicketsKey)[1])){
        $ticket2 = FlightTicket::getByKey($this->flightTicketsKey[1]);
        $ticket2->cancelTicket();
    }
        echo "Confirmado multa de alteração de R$".$this->getFine()."\n";

    $this->status = TravelStatus::Trajeto_definido;
    $this->buyTravel($seat1, $seat2, $luggadge);
}

private function validateSeat(int $st1, int $st2): bool{
    if(empty($this->flightsKey[1])){
            if((Flight::getByKey($this->flightsKey[0])->isFreeSeat($st1))){
                return true;
            }
    }else{
        if((Flight::getByKey($this->flightsKey[0])->isFreeSeat($st1))== true &&
           (Flight::getByKey($this->flightsKey[1])->isFreeSeat($st2))== true){
            return true;
        }
    }
    return false;
}

public function cancelTravel(){
$add = $this->price - $this->getFine();

Passenger::getByKey($this->passangerKey)->addCredit($add);

$ticket1 = FlightTicket::getByKey($this->flightTicketsKey[0]);
$ticket1->cancelTicket();

if(!empty(($this->flightTicketsKey)[1])){
    $ticket2 = FlightTicket::getByKey($this->flightTicketsKey[1]);
    $ticket2->cancelTicket();
}
unset($this->flightTicketsKey);
echo "Confirmado multa de cancelamento de R$".$this->getFine()."\n";

$this->status = TravelStatus::Viagem_cancelada;
$this->save();
}

public function refund(){
    Passenger::getByKey($this->passangerKey)->addCredit($this->price);

    FlightTicket::getByKey($this->flightTicketsKey[0])->cancelTicket();
    
    if(!empty($this->flightTicketsKey[1]))
        FlightTicket::getByKey($this->flightTicketsKey[1])->cancelTicket();
    
    $this->status = TravelStatus::Viagem_cancelada;
    $this->save();
}

public function showTicketscards(){
    echo "Cartão de embarque para o voo:\n"
    ($this->flightTicketsKey)[0]->showFlightTicket();
    if(!empty(($this->flightTicketsKey)[1])){
        echo "Cartão de embarque para o voo de conexão:\n"
        ($this->flightTicketsKey)[1]->showFlightTicket();
    }     
}

static function showPossibleTravels(Airport $origin, Airport $destiny, DateTime $date, int $passangers): array{
    $date->modify('+40 minutes');
    
    $PossibleFlightPath = array(

        "lineKey" => null,
        "connectionKey" =>null,
        "Flight1Key" => null,
        "Flight2Key" => null

    );
    $PossibleFlightPaths = array($PossibleFlightPath);
    unset($PossibleFlightPaths[0]);

    //Descobre quais lines ligam 2 aeroportos
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

    if(empty(($PossibleFlightPaths)))
        throw(new Exception("Não há linhas de voo que connectam os 2 aeroportos\n"));

    //Filtra as linhas descobertas por horário e possibilidade de conexao, faz ligação com flight 
    foreach($PossibleFlightPaths as $key => $possiblePath){
            
            foreach((FlightLine::getByKey($possiblePath["lineKey"]))->getFlights() as $flight ){
                if(  (Flight::getByKey($flight))->getDeparture() >= $date){   
                    
                    if(empty($possiblePath["connectionKey"])){   
                    $possiblePath["Flight1Key"] = $flight;
                   
                    $PossibleFlightPaths[$key] = $possiblePath;

                    break;
                    
                    }else{

                        $date1 = (Flight::getByKey($flight))->getArrivel();
                        $date1->modify('+20 minutes');
                        $date2 = (Flight::getByKey($flight))->getArrivel();
                        $date2->modify('+2 hours');

                        foreach((FlightLine::getByKey($possiblePath["connectionKey"]))->getFlights() as $key2 => $Aconnection){

                            if((Flight::getByKey($Aconnection))->getDeparture() >= $date1 &&
                               (Flight::getByKey($Aconnection))->getDeparture() <= $date2){
                           
                                $possiblePath["Flight2Key"] = $Aconnection;
                                $possiblePath["Flight1Key"] = $flight;
                                $PossibleFlightPaths[$key] = $possiblePath;
                                break 2;
                            }
                        }     
                    }  
                }
        }      
    }
    if(empty(($PossibleFlightPaths)))
    throw(new Exception("Não há voos proximos do horario buscado\n"));
    
    //Filtra por disponilidade de assentos    
    foreach($PossibleFlightPaths as $key1 => $path){
        if(empty($path["Flight1Key"])){
            unset($PossibleFlightPaths[$key1]);
        }else{
            if((Flight::getByKey($path["Flight1Key"]))->numberAvailableseats() < $passangers)
            unset($PossibleFlightPaths[$key1]);
            
            if(!empty($path["Flight2Key"])){
                if((Flight::getByKey($path["Flight2Key"]))->numberAvailableseats() < $passangers)
                unset($PossibleFlightPaths[$key1]);
            }
        }
    }
    
    if(empty(($PossibleFlightPaths)))
    throw(new Exception("Os voos neste horário já estão ocupados\n"));
    
    //Formata as informações para o usuario 
    $flightPaths = [];
    $j = 1;
    foreach($PossibleFlightPaths as $path){
        if(empty($path["Flight2Key"])){
            $flight1 = Flight::getByKey($path["Flight1Key"]);

            $flightPaths[$j] = new FlightPath(
            (($flight1->getFlightLine())->getOrigin())->getName(),
            (($flight1->getFlightLine())-> getDestiny())->getName(),
            $flight1->getDeparture(),
            $flight1->getFlightCode(),
            ($flight1->getFlightLine())->getPrice()
            );
            
        }else{
            $flight1 = Flight::getByKey($path["Flight1Key"]);
            $flight2 = Flight::getByKey($path["Flight2Key"]);

            $Apath = new FlightPath(
            (($flight1->getFlightLine())->getOrigin())->getName(),
            (($flight2->getFlightLine())-> getDestiny())->getName(),
            $flight1->getDeparture(),
            $flight1->getFlightCode(),
            (($flight1->getFlightLine())->getPrice() + ($flight2->getFlightLine())->getPrice())
            );
            $Apath->setForConnection(
                (($flight2->getFlightLine())-> getOrigin())->getName(),
                $flight2->getFlightCode(),
                $flight2->getDeparture()
            );
            $flightPaths[$j] = $Apath;
        }
        $j++;
    }

    //Retorna em formato conhecido
    print_r($flightPaths);
    return $flightPaths;

}

static public function getFilename()
    {
        return get_called_class()::$local_filename;
    }
}

