<?php
/* FlightTicket.php
 * This is the class for the FlightTicket object.
 */

require_once 'Travel.php' ;
require_once 'Passenger.php';
require_once 'Persist.php';

class FlightTicket extends Persist
{ 
    protected Travel $Travel;
    protected string $code;
    protected Passenger $Passenger;
    protected int $seat;
    protected string $origin;
    protected string $destiny;
    protected float $price_flight;
    protected int $luggadge; //numero de bagagens - até 3 bagagens de 23kg
    protected static $local_filename = "FlightTicket.txt";
       
    
    // Constructor
    public function __construct(Travel $Travel//,
                                //Passenger $Passenger,
                                //int $seat,
                                //int $luggadge
                                )
    {
      $this->Travel = $Travel;
      $this->code = rand(1000,9999);
      $this->Passenger = $Passenger;
      $this->seat = $seat;
      $this->origin = $Travel->getFlightLine()->getOrigin()->getName();
      $this->destiny = $Travel->getFlightLine()->getDestiny()->getName();
      $this->luggadge = $luggadge;      
      $this->price_flight = FlightTicket::Calc_price($this->luggadge);        
    
      try{
        $this->save(); 
      }catch(Exception $e){
         echo $e->getMessage();
         throw($e);
      }
    }

    private function Calc_price(int $luggadge) : float
    { 
                     //preço do Voo         //nº de bagagem    *     valor unitario
      return ($this->getTravel()->getPrice() + $luggadge *
              ($this->getTravel()->getLuggadge()));
       
    }
  
    private function Check_in() : bool
    {
      //implementar
    }

    private function On_board() : bool
    {
      //implementar
    }
    
    
    //Getters and Setters
    public function getTravel() : Travel
    {
      return $this->Travel;
    }
    public function getCode() 
    {
        return $this->code;
    }     
    public function getPassenger() : Passenger
    {
     return $this->Passenger;
    }  
    public function getOrigin() : string
    {
      return $this->origin;
    }
    public function getDestiny() : string
    {
      return $this->destiny;
    }
    public function getLuggadge() : int
    {
        return $this->luggadge;
    }
    public function getPrice() : float
    {
        return $this->price_flight;
    }
    public function getSeat() : int
    {
        return $this->seat;
    }
    public function setLuggadge(int $luggadge)
    {
        $this->luggadge = $luggadge;
        $this->price_flight = FlightTicket::calc_price($this->luggadge);
    }
    public function setSeat(int $seat)
    {
        $this->seat = $seat;
    }
    
    // Destructor
    public function __destruct()
    {
     //   echo "Flight Ticket with code {$this->code} was destroyed.";
    }
    static public function getFilename()
    {
        return get_called_class()::$local_filename;
    }
  }
