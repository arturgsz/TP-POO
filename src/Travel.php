<?php
/* Travel.php
 * This is the class for the Travel object.
 */

class Travel
{
    // Attributes
    private string $name; 
    private DateTime $departure_time;
    private DateTime $arrival_time;
    private $sigla_code;
    //private FlightLines $line;

    // Constructor
    public function __construct(string $name, DateTime $departure_time, DateTime $arrival_time, FlightLines $line)
    {
        $this->name = $name;
        $this->departure_time = $departure_time;
        $this->arrival_time = $arrival_time;
        //$this->line = $line;
    }

    //Funcao que cria codigo
    public function create_code() : void
    {
        
    }
    
    // Getters and Setters

    public function getName()
    {
        return $this->name;
    }

    public function getDepartureTime()
    {
        return $this->departure_time;
    }

    public function getArrivalTime()
    {
        return $this->arrival_time;
    }

    /*public function getLine()
    {
        return $this->line;
    }*/

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setDepartureTime(DateTime $departure_time)
    {
        $this->departure_time = $departure_time;
    }

    public function setArrivalTime(DateTime $arrival_time)
    {
        $this->arrival_time = $arrival_time;
    }

    /*public function setLine(FlightLines $line)
    {
        $this->line = $line;
    }*/

    // Destructor
    public function __destruct()
    {
        echo "Travel object destroyed";
    }
}
