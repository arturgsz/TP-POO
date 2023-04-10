<?php
/* FlightTicket.php
 * This is the class for the FlightTicket object.
 */
include_once('Client.php');
include_once('Travel.php');

class FlightTicket
{
    // Attributes
    private string $code;
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
    }

    // What code do I have to creat here?
    public function Create_Code()
    {

    }

    // Destructor
    public function __destruct()
    {
        echo "Flight Ticket with code {$this->code} was destroyed.";
    }
}
