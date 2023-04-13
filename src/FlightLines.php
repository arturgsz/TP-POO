<?php
/* FlightLines.php
 * This is the class for the Flight Lines object.
 */

require_once 'Airport.php';
require_once 'Airplane.php';

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

  private Airplane $default_plane; 
  private string $FlightLine_code;
  private bool $operational;
  
  private Frequency $frequency;
  
  public function __construct(Airport $origin,
                              Airport $destiny,
                              DateTime $expected_departure_time,
                              DateTime $expected_arrival_time,
                              Airplane $default_plane,
                              bool $operational,
                              Frequency $frequency)
  {
    $this->origin = $origin;
    $this->destiny = $destiny;

    $this->expected_departure_time = $expected_departure_time;
    $this->expected_arrival_time = $expected_arrival_time;
      
    $this->FlightLine_code = $default_plane->getsiglaFlightCompany();
    $this->operational = $operational;

    $this->frequency = $frequency;
  }
  
  public function getCompany() : string
  {
    return $this->FlightLine_code;
  }

  // Setters and Getters
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
  public function setExpectedDepartureTime(DateTime $expected_departure_time) : DateTime
  {
    $this->expected_departure_time = $expected_departure_time;
  }

  public function setExpectedArrivalTime(DateTime $expected_arrival_time) : DateTime
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
    return $this->$default_plane;
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
    $this->Airplane = $Airplane;
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