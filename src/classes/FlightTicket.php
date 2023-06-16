<?php
/* FlightTicket.php
 * This is the class for the FlightTicket object.
 */

//require_once 'Flight.php' ;
require_once "Travel.php";
require_once 'Passenger.php';
//require_once 'PersistLogAuthenticate.php';

class FlightTicket extends PersistLogAuthenticate
{ 
    protected int $FlightKey;
    protected string $code;
    protected int $passengerKey;
    protected int $travelKey;
    protected int $seat;
    protected float $price;

    protected static $local_filename = "FlightTicket.txt";
       
    
    // Constructor
    public function __construct(int $flightKey,
                                int $passenger,
                                int $seat,
                                int $luggadge,
                                int $travelKey
                                )
    {
      $this->FlightKey = $flightKey;
      $this->passengerKey = $passenger;
      $this->travelKey = $travelKey;
      $this->price = $this->calc_price($luggadge);
    
      try{
        (Flight::getByKey($this->FlightKey))->secureSeat($seat, $this->getKey(true));
      }catch(Exception $e){
        
        throw($e);
      }
      $this->seat = $seat;    
      $this->code = ((Flight::getByKey($this->FlightKey))->getFlightCode())."-".$this->getKey(true);
      
      try{
        $this->save(); 
      }catch(Exception $e){
         echo $e->getMessage();
         throw($e);
      }
    }

    public function showFlightTicket(){
      $passenger = Passenger::getByKey($this->passengerKey);
      $flight = Flight::getByKey($this->FlightKey);
      $flightLine = $flight->getFlightLine();
      $origin = $flightLine->getOrigin();
      $destiny = $flightLine->getDestiny();
      $embarque = $flight->getDeparture();
      $embarque->modify("-40 minutes");


      $reset = "\033[0m";
      $bold = "\033[1m";
      $underline = "\033[4m";
      $color = "\033[36m"; // Cor ciano

      echo "{$color}{$bold}{$underline}============================================={$reset}\n";
      echo "{$color}{$bold}{$underline}          BILHETE DE VOO{$reset}\n";
      echo "{$color}{$bold}{$underline}============================================={$reset}\n";
      echo "{$color}Nome do passageiro:{$reset} {$passenger->getName()} {$passenger->getSurname()}\n";
      echo "{$color}Destino:{$reset} {$destiny->getName()}\n";
      echo "{$color}Origem:{$reset} {$origin->getName()}\n";
      echo "{$color}Horário de embarque:{$reset} {$embarque->format('d-m-Y H:i:s')}\n";
      echo "{$color}Horário do voo:{$reset} {$embarque->modify("+40 minutes")->format('d-m-Y H:i:s')}\n";
      echo "{$color}Código do voo:{$reset} {$flight->getFlightCode()}\n";
      echo "{$color}Assento:{$reset} {$this->seat}\n";
      echo "{$color}{$bold}{$underline}============================================={$reset}\n";
    
    }

    public function getTravel(): Travel{
      return Travel::getByKey($this->travelKey);
    }
    private function calc_price(int $luggadge): float
    { 
        
      $flightLine = (Flight::getByKey($this->FlightKey))->getFlightLine();
      //preço do Voo         //nº de bagagem    *     valor unitario
      
      if(Travel::getByKey($this->travelKey)->payFine($this->FlightKey)){
        return $flightLine->getPrice() + $luggadge*($flightLine->getLugadgeprice());
      }else{
        if($luggadge >0 ){
          return  $flightLine->getPrice() + ($luggadge-1)*($flightLine->getLugadgeprice())/2;
        }else
          return $flightLine->getPrice();
      }  
    }

    public function cancelTicket(){
      Flight::getByKey($this->FlightKey)->cancelSeat($this->seat);
      
      $this->delete();
    }
    //Getters and Setters
    public function getFlight() : Flight
    {
      return Flight:: getByKey($this->FlightKey);
    }
    public function getCode() 
    {
        return $this->code;
    }     
    public function getPassenger() : Passenger
    {
     return Passenger::getByKey($this->passengerKey);
    }  
    public function getSeat(){
      return $this->seat;
    }
    static public function getFilename()
    {
        return get_called_class()::$local_filename;
    }

    public function getPrice(): float{
      return $this->price;
    }

  }

