<?php
/* FlightLines.php
 * This is the class for the Flight Lines object.
 */

require_once 'Airport.php';
require_once 'Airplane.php';
//require_once 'Travel.php';

class FlightLines 
{
  private Airport $origin; 
  private Airport $destiny;
  private DateTime $expected_departure_time;
  private DateTime $expected_arrival_time;
  private DateInterval $duracao_estimada; 
  
  private float $line_price;
  private float $lugadge_price; //valor unitario da bagagem

  private Airplane $airplane; 
  private string $code;
  
  private bool $operational;
  private $frequency = [];


  //TRAVEL - SPRINT2
  //private $travel = [];
  
  public function __construct(Airport $origin,
                              Airport $destiny,
                              DateTime $expected_departure_time,
                              DateTime $expected_arrival_time,
                              Airplane $airplane,
                              bool $operational,
                              array $frequency,
                              float $line_price)
  {
    $this->origin = $origin;
    $this->destiny = $destiny;

    $this->expected_departure_time = $expected_departure_time;
    $this->expected_arrival_time = $expected_arrival_time;

    $this->airplane = $airplane;
    $this->code = rand(1000,9999);

    $this->duracao_estimada = FlightLines::duracaoVoo($expected_departure_time,$expected_arrival_time);
    
    $this->operational = $operational;
    $this->frequency = $frequency;

    $this->line_price = $line_price;
    $this->lugadge_price = $airplane->getLuggadge();
  }

/*  private function newTravel()
  {
    $travel_ = new Travel($this->expected_departure_time,
                          $this->expected_arrival_time,
                          $this->line_price,
                          $this->lugadge_price,
                          $this->FlightLine_code,
                          $this->airplane->getPassengerCapacity());
    //Adding this travel to a array of travels                      
    $this->addTravel($travel_);
  }

  private function addTravel(Travel $travel)
  {
    array_push($this->travel, $travel);
  }
*/
  private function duracaoVoo($expected_departure_time,$expected_arrival_time) : DateInterval
  {
    $interval = $this->getExpectedArrivalTime()->diff($this->getExpectedDepartureTime());
    return $interval;   
  }

 // Setters and Getters
  
  //Airport
  public function getOrigin() : Airport
  {
    return $this->origin;
  }
  public function getDestiny() : Airport
  {
    return $this->destiny;
  }
  
  public function setOrigin(Airport $origin) : void
  {
    $this->origin = $origin;
  }
  public function setDestiny(Airport $destiny) : void
  {
    $this->destiny = $destiny;
  }
  
  //Airplane
  public function getAirplane() : Airplane
  {
    return $this->airplane;
  }
  public function setAirplane(Airplane $Airplane) : void
  {
    $this->airplane = $Airplane;
    $this->lugadge_price = $this->airplane->getLuggadge();
  }
  
  //FlightLines
  public function getCode() : string
  {
    return $this->code;
  }
  
  public function getExpectedDepartureTime() : DateTime
  {
    return $this->expected_departure_time;
  }
  
  public function getExpectedArrivalTime() : DateTime
  {
    return $this->expected_arrival_time;
  }
  
  public function getDuracao() : DateInterval
  {
    return $this->duracao_estimada;
  }
  public function getPrice() : float
  {
    return $this->line_price;
  }
  public function getlugadgeprice() : float
  {
    return $this->lugadge_price;
  }
  public function getFrequency() : array
  {
    return $this->frequency;
  }
  
  public function isOperational() : bool
  {
    return $this->operational;
  }
  
  public function setPrice(float $price) : void
  {
    $this->line_price = $price;
  }
  
  public function setFrequency(array $frequency) : void
  {
    $this->frequency = $frequency;
  }
  
  public function setOperational(bool $operational) : void
  {
    $this->operational = $operational;
  }


 public function setExpectedDepartureTime(string $new_expected_departure_time) : void
  {
    $this->expected_departure_time->modify($new_expected_departure_time);
    $this->duracao_estimada = FlightLines::duracaoVoo($new_expected_departure_time,$this->expected_arrival_time);
  }
  
  public function setExpectedArrivalTime(string $new_expected_arrival_time): void
   {
    $this->expected_arrival_time->modify($new_expected_arrival_time);
    $this->duracao_estimada = FlightLines::duracaoVoo($this->expected_departure_time,$new_expected_arrival_time); 
   }

   public function informacoes() : void
  {
    echo ("INFORMACOES DA FLIGHTLINE {$this->getCode()}" . PHP_EOL .
          "Origem: {$this->getOrigin()->getName()}" . PHP_EOL .
          "Destino: {$this->getDestiny()->getName()}" . PHP_EOL .
          "Horário: {$this->getExpectedDepartureTime()->format('Y/m/d H:i:s')}" . PHP_EOL .
          "Duração estimada: {$this->getduracao()->h} horas " .
           "{$this->getduracao()->i} minutos" . PHP_EOL .
          "Preço: {$this->getPrice()} " . PHP_EOL .
          "Frequência do Voo: {$this->getFrequency()->name}" . PHP_EOL .
          "Valor unitario da bagagem: {$this->getlugadgeprice()}" . PHP_EOL .
          "Esta linha está operando: ". PHP_EOL . PHP_EOL);           
  }

  
  // Destructor
  public function __destruct()
  {
     echo "FlightLine has been deleted." . PHP_EOL;
  }
}