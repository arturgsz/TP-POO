<?php
/* Vehicle.php
 * This is the class for the Vehicle object.
 */

class Vehicle
{
    // Attributes
    private string $model;
    private string $license_plate;
    private int $capacidade;

    // Constructor
    public function __construct(string $model, 
                                string $license_plate, 
                                int $capacidade)
    {
        $this->model = $model;
        $this->license_plate = $license_plate;
        $this->capacidade = $capacidade;
    }



    // Getters and Setters
    public function getModel() : string
    {
        return $this->model;
    }
    public function getLicense_plate() : string
    {
        return $this->license_plate;
    }
    public function getCapacidade() : int
    {
        return $this->capacidade;
    }

    // Destructor
    public function __destruct()
    {
        echo "The vehicle with license plate {$this->license_plate} was destroyed.";
    }
}
