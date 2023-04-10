<?php
/* Client.php
 * This is the class for the Client object.
 */

class Client
{
    // Attributes
    private string $name;
    private string $surname;
    private string $document;

    // Constructor
    public function __construct(string $name, string $surname, string $document)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->document = $document;
    }

    // Getters and Setters
    public function getName()
    {
        return $this->name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function getDocument()
    {
        return $this->document;
    }

    // Destructor
    public function __destruct()
    {
        echo "The client {$this->name} {$this->surname} was destroyed.";
    }
}
