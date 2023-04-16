<?php
/* FlightTicket.php
 * This is the class for the FlightTicket object.
 */
include_once('Client.php');
include_once('Travel.php');

class FlightTicket
{
    // Attributes
    private int $code;
    private Client $client;
    private string $seat;
    private float $price;
    private int $luggadge;
    private Travel $ptr; //mudar classe Flight para travel
    
    // Constructor
    public function __construct(Client $client, string $seat, int $luggadge, Travel &$ptr)
    {
        $this->client = $client;
        $this->seat = $seat;
        $this->luggadge = $luggadge;
        $this->ptr = &$ptr; //DUVIDAS: como fazer passagem por referencia;
        $this->code = $this->Creat_Code();
    }

    public function Creat_Code()
    {   
        return rand(0, 99999); //five digits code (number)
    }

    //Getters and Setters
    public function getCode()
    {
        return $this->code;
    }
    
    public function getLuggadge()
    {
        return $this->luggadge;
    }

    public function setLuggadge(int $luggadge)
    {
        $this->luggadge = $luggadge;
    }

    public function getPrice()
    {
        return $this->price;
    }
    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    public function getSeat()
    {
        return $this->seat;
    }

    public function setSeat(string $seat)
    {
        $this->seat = $seat;
    }

    public function getClient()
    {
        return $this->client;
    }

    // Destructor
    public function __destruct()
    {
        echo "Flight Ticket with code {$this->code} was destroyed.";
    }
}
