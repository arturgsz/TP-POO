<?php
/* FlightLines.php
 * This is the class for the Flight Lines object.
 */

include_once('Airport.php');
include_once('FlightCompany.php');
include_once('Flight.php');

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
    private Airport $origin;
    private Airport $destination; //Mudar nome na UML
    private DateTime $expected_departure_time; //Mudar nome na UML
    private DateTime $expected_arrival_time; //Adicionar na UML
    private FlightCompany $company;
    private Frequency $frequency; //Adicionar na UML
    private bool $operational; //Mudar nome na UML

    // Container of Lines
    private $flights = array();

    // Constructor
    public function __construct(Airport $origin, Airport $destination, DateTime $expected_departure_time, DateTime $expected_arrival_time, FlightCompany $company, Frequency $frequency)
    {
        $this->origin = $origin;
        $this->destination = $destination;
        $this->expected_departure_time = $expected_departure_time;
        $this->expected_arrival_time = $expected_arrival_time;
        $this->company = $company;
        $this->frequency = $frequency;
        $this->operational = true; //default
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
    public function addFlight(Flight $flight)
    {
        array_push($this->flights, $flight);
    }

    // Destructor
    public function __destruct()
    {
        echo $this->toString() . " has been deleted.";
    }
}
