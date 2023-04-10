<?php
/* FullTicket.php
 * This is the class for the FullTicket
 * object.
 */
include_once('FlightTicket');

class FullTicket
{
    // Attributes
    private $tickets = [];
    private float $price = 0;

    //Methods
    public function Add_ticket(FlightTicket $flightTicket)
    {
        array_push($tickets, $flightTicket->price); //conferir se é assim
    }

    public function Calc_price()
    {
        for($i=0; $i < count($tickets); $i++){
            $price += $tickets[$i];
        }
        return $this->price;
    }

    // Destructor
    public function __destruct()
    {
        echo "Full Ticket object was destroyed.";
    }
}
