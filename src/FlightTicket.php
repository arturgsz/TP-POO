<?php
/* FlightTicket.php
 * This is the class for the FlightTicket object.
 */

require_once './src/Travel.php' ;
require_once './src/Client.php';

class FlightTicket
{ 
    private Travel $Travel;
    private string $code;
    private Client $Client;
    private int $seat;

    private string $origin;
    private string $destiny;

    private float $price_flight;
    private int $luggadge; //numero de bagagens - até 3 bagagens de 23kg
    
    // Constructor
    public function __construct(Travel $Travel,
                                Client $Client,
                                int $seat,
                                int $luggadge)
    {
      $this->Travel = $Travel;
      $this->code = rand(1000,9999);
      $this->Client = $Client;
      $this->seat = $seat;

      $this->origin = $Travel->getFlightLine()->getOrigin()->getName();
      $this->destiny = $Travel->getFlightLine()->getDestiny()->getName();

      $this->luggadge = $luggadge;
      
      $this->price_flight = FlightTicket::calc_price($this->luggadge);
        
    }

    private function calc_price(int $luggadge) : float
    { 
                     //preço do Voo         //nº de bagagem    *     valor unitario
      return ($this->getTravel()->getPrice() + $luggadge * ($this->getTravel()->getLuggadge()));
       
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
     
    public function getClient() : Client
    {
     return $this->Client;
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

    public function setSeat(string $seat)
    {
        $this->seat = $seat;
    }
    

    public function informacoes() : void
    {
      echo ("INFORMAÇÕES DO TICKET {$this->getCode()}" . PHP_EOL .
            "Codigo do Voo: {$this->getTravel()->getFlightCode()}" . PHP_EOL .
            "Origem: {$this->getOrigin()}" . PHP_EOL .
            "Destino: {$this->getDestiny()}" . PHP_EOL .
            "Cliente: {$this->getClient()->getName()} {$this->getClient()->getSurname()}" . PHP_EOL .
            "Assento: {$this->getSeat()}" . PHP_EOL .
            "Preço Bagagem: {$this->getTravel()->getLuggadge()}" . PHP_EOL .
            "Preço Voo: {$this->getTravel()->getPrice()}" . PHP_EOL . 
            "Preço Total: (nº de bagagem) {$this->getLuggadge()} * {$this->getTravel()->getLuggadge()} + {$this->getTravel()->getPrice()} = {$this->getPrice()}" . PHP_EOL . PHP_EOL);
    }


    
    // Destructor
    public function __destruct()
    {
        echo "Flight Ticket with code {$this->code} was destroyed.";
    }
}
