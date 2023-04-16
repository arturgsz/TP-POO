<?php
/* FlightLines.php
 * This is the class for the Flight Lines object.
 */

require_once 'Airport.php';
require_once 'Airplane.php';
require_once 'Travel.php';

enum Frequency
{
    case DAILY;
    case WEEKLY;
    case MONTHLY;
}

class FlightLines 
{
  private Airport $origin; 
  private Airport $destiny;
  private DateTime $expected_departure_time;
  private DateTime $expected_arrival_time;
  private DateInterval $duracao_estimada; 
  private float $line_price;
  private float $lugadge_price;

  private Airplane $airplane; 
  private string $FlightLine_code;
  
  private bool $operational;
  private Frequency $frequency;

  //TRAVEL - SPRINT2
  private $travel = [];
  
  public function __construct(Airport $origin,
                              Airport $destiny,
                              DateTime $expected_departure_time,
                              DateTime $expected_arrival_time,
                              Airplane $airplane,
                              bool $operational,
                              Frequency $frequency,
                              float $line_price,
                              float $lugadge_price)
  {
    $this->origin = $origin;
    $this->destiny = $destiny;

    $this->expected_departure_time = $expected_departure_time;
    $this->expected_arrival_time = $expected_arrival_time;

    $this->airplane = $airplane;
    $this->FlightLine_code = $airplane->getsiglaFlightCompany();

    $this->duracao_estimada = FlightLines::duracaoVoo($expected_departure_time,$expected_arrival_time);
    
    $this->operational = $operational;
    $this->frequency = $frequency;

    $this->line_price = $line_price;
    $this->lugadge_price = $lugadge_price;
  }

  private function newTravel()
  {
    $travel_ = new Travel($this->expected_departure_time,
                          $this->expected_arrival_time,
                          $this->line_price,
                          $this->lugadge_price,
                          $this->airplane->getPassengerCapacity());
    //Adding this travel to a array of travels                      
    $this->addTravel($travel_);
  }

  private function addTravel(Travel $travel)
  {
    array_push($this->travel, $travel);
  }

  private function duracaoVoo($expected_departure_time,$expected_arrival_time) : DateInterval
  {
    $interval = $expected_arrival_time->diff($expected_departure_time);
    return $interval;
  }
  
  // Setters and Getters
  public function getCompany() : string
  {
    return $this->FlightLine_code;
  }

  public function getOrigin() : Airport
  {
    return $this->origin;
  }

  public function getDestiny() : Airport
  {
    return $this->destiny;
  }

  public function getExpectedDepartureTime() : DateTime
  {
    return $this->expected_departure_time;
  }

  public function getExpectedArrivalTime() : DateTime
  {
    return $this->expected_arrival_time;
  }

  public function setExpectedDepartureTime(DateTime $expected_departure_time)
  {
    $this->expected_departure_time = $expected_departure_time;
  }

  public function setExpectedArrivalTime(DateTime $expected_arrival_time)
  {
    $this->expected_arrival_time = $expected_arrival_time;
  }
  
  public function getFrequency() : Frequency
  {
    return $this->frequency;
  }

  public function setFrequency(Frequency $frequency) :void
  {
    $this->frequency = $frequency;
  }


  public function getAirplane() : Airplane
  {
    return $this->airplane;
  }

  public function isOperational() :bool
  {
    return $this->operational;
  }
    
  public function setOrigin(Airport $origin) : void
  {
    $this->origin = $origin;
  }

  public function setDestination(Airport $destiny) : void
  {
    $this->destiny = $destiny;
  }

  public function setAirplane(Airplane $Airplane) : void
  {
    $this->airplane = $Airplane;
  }

  public function setOperational(bool $operational) : void
  {
    $this->operational = $operational;
  }

  // Destructor
  public function __destruct()
  {
     echo "FlightLine has been deleted." . PHP_EOL;
  }
}