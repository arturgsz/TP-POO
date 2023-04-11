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
    private $price = 0;


    //Methods
    public function Add_ticket(FlightTicket $flightTicket)
    {
        array_push($tickets, $flightTicket->$this->price); //conferir se é assim
    }

    public function Calc_price()
    {
        for($i=0; $i < count($this->tickets); $i++){
            $this->price += $this->tickets[$i];
        }
        
        return $this->price;
    }

    //Getters and Setters
    public function getPrice()
    {
        return $this->price;
    }

    public function getTickets()
    {
        return $this->tickets;
    }

    // Destructor
    public function __destruct()
    {
        echo "Full Ticket object was destroyed.";
    }
}
