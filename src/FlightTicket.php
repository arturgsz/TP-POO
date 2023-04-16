<?php
/* FlightTicket.php
 * This is the class for the FlightTicket object.
 */
include_once('Client.php');

class FlightTicket
{
    // Attributes
    private string $code;
    private Client $client;
    private int $seat;
    private float $price;
    private float $price_luggadge;
    private float $price_fight;
    private int $luggadge = 0;
 //   private Travel $ptr; //ponteiro de travel, como implementar?
    
    // Constructor
    public function __construct(int $seat, float $price_luggadge,
                                float $price_flight, string $code)
    {
        $this->seat = $seat;
        $this->price_luggadge = $price_luggadge;
        $this->price_fight = $price_flight;
        $this->price = $this->calc_price();

        $this->code = $code."-".$seat;
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

    public function getPrice()
    {
        return $this->price;
    }

    public function getSeat()
    {
        return $this->seat;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function setLuggadge(int $luggadge)
    {
        $this->luggadge = $luggadge;
    }

    public function setSeat(string $seat)
    {
        $this->seat = $seat;
    }
    
    public function calc_price(): float{
        return $this->price_fight + $this->price_luggadge * $this->luggadge;
    }
    // Destructor
    public function __destruct()
    {
        echo "Flight Ticket with code {$this->code} was destroyed.";
    }
}
