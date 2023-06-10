<?php

//require_once "FlightTicket";
require_once "Persist.php";
require_once "Passenger.php";
require_once "FlightLine.php";
require_once "Airport.php";
require_once "Airplane.php";
require_once "Route.php";
require_once "Crew.php";
require_once "Travel.php";
date_default_timezone_set("America/Sao_Paulo");

enum FlightState{
    case Passagens_a_venda;
    case Crew_Preparada;
    case Embarque;
    case Em_vool;
    case Desembarque;
    case Voo_realziado;
    case Voo_cancelado;
}

class Flight extends Persist
{      
    // Attributes
    protected DateTime $expectedDepartureTime;
    protected DateTime $expectedArrivelTime;
    protected DateTime $departureTime;
    protected DateTime $arrivelTime;
    protected string $flightCode;
    protected array $ticketsKey;
    protected array $freeSeats;
    protected int $flightLineKey;
    protected FlightState $state;
    protected array $crewMembersKeys;
    protected int $routeKey;
    protected int $airplaneKey;
    

    protected static $local_filename = "Flight.txt";
       
    public function __construct(int $flightLineKey,
                                DateTime $departureTime,
                                DateTime $arrivelTime){

        $this->flightLineKey = $flightLineKey;
        $this->expectedDepartureTime = $departureTime;
        $this->expectedArrivelTime = $arrivelTime;
        $this->airplaneKey = ((FlightLine::getByKey($this->flightLineKey))->getAirplane())->getKey();
        $this->state = FlightState::Passagens_a_venda;

        //Trabalhar com os assentos;
        $maxPassenger = ((FlightLine::getByKey($this->flightLineKey))->getAirplane())->getPassengerCapacity();
        for($i= 1; $i<=$maxPassenger; $i++){
            ($this->freeSeats)[$i] = "Free";
        }

        try{
            $this->save(); 
         }catch(Exception $e){
             echo $e->getMessage();
             throw($e);
         }
    
        $this->flightCode = (FlightLine::getByKey($this->flightLineKey)->getCode()).$this->getKey();    
        $this->save();
    }

    //Methods
    
    public function assingCrew(array $crewMembersKeys, int $vehicleKey){
        if($this->state != FlightState::Passagens_a_venda)
            throw(new Exception("Não é possivel cadastrar uma tripulação"));
        
        $crewIsGood = false; 
        $piloto = 0; $copiloto = 0; $comissario = 0;
        foreach($crewMembersKeys as $crew_memberKey){
            $crewObj = Crew::getByKey($crew_memberKey);
            if($crewObj->getCargo() == 'PILOTO'){$piloto++;}
            if($crewObj->getCargo() == 'COPILOTO' or 
                $crewObj->getCargo() == 'CO-PILOTO' or $crewObj->getCargo() == 'CO PILOTO'){$copiloto++;}
            if($crewObj->getCargo() == 'COMISSARIO' or $crewObj->getCargo() == 'COMISSÁRIO'){$comissario++;}
        }
        if($piloto == 1 and $copiloto == 1 and $comissario >=2){$crewIsGood = true;}
        
        if($crewIsGood){
            $this->crewMembersKeys = $crewMembersKeys;
            $this->state = FlightState::Crew_Preparada;
            $airport = FlightLine::getByKey($this->flightLineKey)->getOrigin();
            $veiculo = Vehicle::getByKey($vehicleKey);
            $rota = new Route($crewMembersKeys, $airport, $veiculo, $this->expectedDepartureTime);
            $rota->distanciaTotal();
            $this->routeKey = $rota->getKey();
            $this->save();
            
       }else{
        throw(new Exception("A tripulação não possui membros o suficiente para o voo"));
       }
    }

    public function setDeparture(dateTime $departure){
        if($this->state != FlightState::Crew_Preparada)
        throw(new Exception("Não há uma tripulação preparada para o voo"));
        
        $this->departureTime = $departure;
        $this->state = FlightState::Em_vool;
        $this->save();
    }
    public function setArrivel(dateTime $arrivel){
        if($this->state != FlightState::Em_vool)
        throw(new Exception("Não é possivel setar um horio de desembarque"));
        
        $this->arrivelTime = $arrivel;
        $this->state = FlightState::Desembarque;
        $this->save();
    }

    public function cancelFlight(){
        if($this->state == FlightState::Passagens_a_venda ||
        $this->state == FlightState::Crew_Preparada ||
        $this->state == FlightState::Embarque){

        foreach($this->ticketsKey as $ticketKey){
            (FlightTicket::getByKey($ticketKey))->refund();    
        }
        $this->state = FlightState::Voo_cancelado;
        $this->save();
        }else{
            throw(new Exception("Não é possivel cancelar o voo"));
        }
    }

    public function flightWasDone(){
        if($this->state == FlightState::Desembarque){
            $this->state = FlightState::Voo_realziado;
            $this->save();
        }else{
            throw(new Exception("Não é possivel terminar o voo"));
        }
    }
    public function availableSeats(){
        if($this->state != FlightState::Passagens_a_venda &&
           $this->state != FlightState::Crew_Preparada)
        throw(new Exception("Não é possivel mostrar acentos"));
        
        return $this->freeSeats;
    }

    public function secureSeat(int $seat, int $ticketKey){
       
        if($this->state != FlightState::Passagens_a_venda &&
        $this->state != FlightState::Crew_Preparada)
             throw(new Exception("Não é possivel reservar acentos"));
       
        if(($this->freeSeats)[$seat] == "Free"){

            ($this->freeSeats)[$seat] = "Reserved";
            ($this->ticketsKey)[$seat] = $ticketKey;
        }else{
            throw( new Exception("O assento não está mais disponivel"));
        }
    
        $this->save();
    }

    public function cancelSeat(int $seat){
        if($this->state != FlightState::Passagens_a_venda &&
        $this->state != FlightState::Crew_Preparada)
            throw(new Exception("Não é possivel cancelar a passagem"));
        
        ($this->freeSeats)[$seat] = "Free";
        ($this->ticketsKey)[$seat] = null;
        $this->save();
    }

    public function showRoute(){
        $rota = Route::getByKey($this->routeKey);
        $rota->descricaoRota();
    }

    public function setAirplane(Airplane $airplane){
        $this->airplaneKey = $airplane->getKey();
    }

    public function getDeparture(): DateTime{
        return $this->expectedDepartureTime;
    }

    public function getFlightLine(){
        return FlightLine::getByKey($this->flightLineKey);
    }

    public function getFlightCode(){
        return $this->flightCode;
    }

    static public function getFilename()
        {
            return get_called_class()::$local_filename;
        }
    }
    // public function Add_ticket(FlightTicket $flightTicket) : void
    // {
    //     array_push($this->tickets, $flightTicket);
    // }

    // public function Calc_price()
    // {
    //     $price = 0;
    //     for($i=0; $i < count($this->tickets); $i++){
    //         $price += $this->tickets[$i]->price;
    //     }
    //     return $price;
    // }

    // public function alteracao () : void
    // {
    //   //implementar
    // }
  
    // public function cancelamento () : void
    // {
    //   //implementar
    // }
  
    // //Getters
    // public function getPrice() : float
    // {
    //     return $this->price;
    // }
    // public function getTickets() : array
    // {
    //     return $this->tickets;
    // }

    // // Destructor
    // public function __destruct()
    // {
    //    // echo "Full Ticket object was destroyed.";
    // }




