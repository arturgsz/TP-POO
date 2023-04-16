<?php
/* Passenger.php
 * This is the class for the Passenger object.
 */

class Passenger
{
    // Attributes
    private string $name;
    private string $surname;
    private string $cpf;
    private string $email;
    private string $nacionality;
    private DateTime $birth;
    private string $document;
    private bool $vip;
    
    //private Ticket $ticket;

    // Constructor
    public function __construct(string $name, 
                                string $surname, 
                                string $document)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->document = $document;
    }

    // Getters and Setters
    public function getName() : string
    {
        return $this->name;
    }

    public function getSurname() : string
    {
        return $this->surname;
    }

    public function getDocument() : string
    {
        return $this->document;
    }

    // Destructor
    public function __destruct()
    {
        echo "The object client {$this->name} {$this->surname} was destroyed." . PHP_EOL;
    }
}