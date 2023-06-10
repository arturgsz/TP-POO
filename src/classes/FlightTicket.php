<?php
/* FlightTicket.php
 * This is the class for the FlightTicket object.
 */

require_once 'Flight.php' ;
require_once 'Passenger.php';
require_once 'Persist.php';

class FlightTicket extends Persist
{ 
    protected int $FlightKey;
    protected string $code;
    protected int $passengerKey;
    protected int $seat;
    protected float $price;
    protected float $miliage;
    protected static $local_filename = "FlightTicket.txt";
       
    
    // Constructor
    public function __construct(int $flightKey,
                                int $passenger,
                                int $seat,
                                int $luggadge
                                )
    {
      $this->FlightKey = $flightKey;
      $this->passengerKey = $passenger;
      $this->price = $this->calc_price($luggadge);
      $this->miliage = $this->miliagePoints();
    
      try{
        $this->save(); 
      }catch(Exception $e){
         echo $e->getMessage();
         throw($e);
      }
    
      try{
        (Flight::getByKey($this->FlightKey))->secureSeat($seat, $this->getKey());
      }catch(Exception $e){
        
        throw($e);
      }
      $this->seat = $seat;    
      $this->code = ((Flight::getByKey($this->FlightKey))->getFlightCode())."-".$this->getKey();

      $this->save();
    }

    public function showFlightTicket(){
      //TO DO
    }

    public function miliagePoints() {
      //$passeger = (Passenger::getByKey($this->passengerKey));
      

    }


    private function calc_price(int $luggadge): float
    { 
        
      $flightLine = (Flight::getByKey($this->FlightKey))->getFlightLine();
      //preço do Voo         //nº de bagagem    *     valor unitario
      return $flightLine->getPrice() + $luggadge*($flightLine->getLugadgeprice());
       
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
    
    static public function getFilename()
    {
        return get_called_class()::$local_filename;
    }
  }


    // private function Check_in() : bool
    // {
    //   //implementar
    // }

    // private function On_board() : bool
    // {
    //   //implementar
    // }
    
       
    // public function getOrigin() : string
    // {
    //   return $this->origin;
    // }
    // public function getDestiny() : string
    // {
    //   return $this->destiny;
    // }
    // public function getLuggadge() : int
    // {
    //     return $this->luggadge;
    // }
    // public function getPrice() : float
    // {
    //     return $this->price_flight;
    // }
    // public function getSeat() : int
    // {
    //     return $this->seat;
    // }
    // public function setLuggadge(int $luggadge)
    // {
    //     $this->luggadge = $luggadge;
    //     $this->price_flight = FlightTicket::calc_price($this->luggadge);
    // }
    // public function setSeat(int $seat)
    // {
    //     $this->seat = $seat;
    // }
    
    // Destructor
    // public function __destruct()
    // {
    //  //   echo "Flight Ticket with code {$this->code} was destroyed.";
    // }