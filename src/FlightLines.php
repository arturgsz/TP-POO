<?php
/* FlightLines.php
 * This is the class for the Flight Lines object.
 */
//require_once 'Airport.php';
require_once 'Airplane.php';

class FlightLines {
  private Airplane $default_plane;
  private string $company;

  public function __construct(Airplane $default_plane)
  {
    $this->company = $default_plane->getsiglaFlightCompany();
  }
  public function getCompany() : string
  {
    return $this->company;
  }



/*
include_once('Airport.php');
include_once('FlightCompany.php');
include_once('Travel.php');
include_once('Airplane.php');

//Usado na frenquencia dos voos
enum Frequency
{
    case DAILY;
    case WEEKLY;
    case MONTHLY;
}

class FlightLines
{
    // Attributes
    private string $line_code;
    private static int $counter = 0;
    private Airport $origin;
    private Airport $destination; //Mudar nome na UML
    private DateTime $expected_departure_time; //Mudar nome na UML
    private DateTime $expected_arrival_time; //Adicionar na UML
    private FlightCompany $company;
    private Frequency $frequency; //Adicionar na UML
    private Airplane $airplane;
    private bool $operational; //Mudar nome na UML

    // Container of Lines
    private $travels= array();

    // Constructor
    public function __construct(Airport $origin, Airport $destination, DateTime $expected_departure_time, DateTime $expected_arrival_time, FlightCompany $company, Frequency $frequency, Airplane $airplane)
    {
        $this->origin = $origin;
        $this->destination = $destination;
        $this->expected_departure_time = $expected_departure_time;
        $this->expected_arrival_time = $expected_arrival_time;
        $this->company = $company;
        $this->frequency = $frequency;
        $this->airplane = $airplane;
        $this->operational = true; //default
        
        FlightLines::$counter++;
        if(FlightLines::$counter > 9999){
           FlightLines::$counter = 0;
        }
        $this->line_code = $this->create_code();
    }

    private function create_code(): string{
       return $this->company->getSigla().(1000 + FlightLines::$counter);
    }

    // Setters and Getters
    public function getOrigin()
    {
        return $this->origin;
    }

    public function getDestination()
    {
        return $this->destination;
    }

    public function getExpectedDepartureTime()
    {
        return $this->expected_departure_time;
    }

    public function getExpectedArrivalTime()
    {
        return $this->expected_arrival_time;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function getFrequency()
    {
        return $this->frequency;
    }

    public function getAirplane()
    {
        return $this->airplane;
    }

    public function isOperational()
    {
        return $this->operational;
    }

    public function setOrigin(Airport $origin)
    {
        $this->origin = $origin;
    }

    public function setDestination(Airport $destination)
    {
        $this->destination = $destination;
    }

    public function setExpectedDepartureTime(DateTime $expected_departure_time)
    {
        $this->expected_departure_time = $expected_departure_time;
    }

    public function setExpectedArrivalTime(DateTime $expected_arrival_time)
    {
        $this->expected_arrival_time = $expected_arrival_time;
    }

    public function setCompany(FlightCompany $company)
    {
        $this->company = $company;
    }

    public function setAirplane(Airplane $airplane)
    {
        $this->airplane = $airplane;
    }

    public function setFrequency(Frequency $frequency)
    {
        $this->frequency = $frequency;
    }

    public function setOperational(bool $operational)
    {
        $this->operational = $operational;
    }

    // Methods
    public function toString()
    {
        return "Flight Line: " . $this->origin->getName() . " to " . $this->destination->getName() . " with " . $this->company->getName() . " at " . $this->expected_departure_time->format('H:i') . " and expected arrival at " . $this->expected_arrival_time->format('H:i');
    }


    // Container of Lines Methods
    public function addFlight(Travel $travel)
    {
        array_push($this->travels, $travel);
    }

    */

    // Destructor
    public function __destruct()
    {
        echo $this->toString() . " has been deleted.";
    }
}
