<?php
require_once "PersistLogAuthenticate.php";

class FlightPath extends PersistLogAuthenticate{
    protected string $origin_airport;
    protected string $connection_aiport;    
    protected string $destiny_airport;
    protected DateTime $DepartureTime; 
    protected string $flightCode;
    protected string $connectionFlightCode;
    protected DateTime $connectionDepartureTime;
    protected float $flightPriceByPassanger;

protected function __construct(string $origin_airport,    
                                string $destiny_airport,
                                DateTime $DepartureTime,
                                string $flightCode,
                                float $flightPriceByPassanger
                                ){

    $this->origin_airport = $origin_airport;
    $this->destiny_airport = $destiny_airport;
    $this->DepartureTime  = $DepartureTime;
    $this->flightCode =  $flightCode;
    $this->flightPriceByPassanger = $flightPriceByPassanger;
    $this->connection_aiport = "Sem conexão. Linha direta.";
} 
protected function setForConnection(string $connection_aiport,
                                string $connectionFlightCode,
                                DateTime $connectionDepartureTime){
    
    $this->connection_aiport = $connection_aiport;
    $this->connectionFlightCode = $connectionFlightCode;
    $this->connectionDepartureTime = $connectionDepartureTime;

}
public function getDepartureTime(){
    return $this->DepartureTime;
}
static public function getFilename()
    {
        return get_called_class()::$local_filename;
    }

}
