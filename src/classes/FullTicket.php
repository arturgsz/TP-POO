<?php
/* FullTicket.php
 * This is the class for the FullTicket
 * object.
 */
include_once('FlightTicket');
require_once ('Persist.php');

class FullTicket extends Persist
{
    // Attributes
    protected $tickets = [];
    protected float $price = 0;
    protected static $local_filename = "FullTicket.txt";
       
    public function __construct(){

        $this->save();
    }

    //Methods
    public function Add_ticket(FlightTicket $flightTicket) : void
    {
        array_push($this->tickets, $flightTicket);
    }

    public function Calc_price() : float
    {
        for($i=0; $i < count($this->tickets); $i++){
            $this->price += $this->tickets[$i]->price;
        }
    }

    public function alteracao () : void
    {
      //implementar
    }
  
    public function cancelamento () : void
    {
      //implementar
    }
  
    //Getters
    public function getPrice() : float
    {
        return $this->price;
    }
    public function getTickets() : array
    {
        return $this->tickets;
    }

    // Destructor
    public function __destruct()
    {
        echo "Full Ticket object was destroyed.";
    }

static public function getFilename()
    {
        return get_called_class()::$local_filename;
    }
}
