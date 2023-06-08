<?php
/* Vehicle.php
 * This is the class for the Vehicle object.
 */

require_once 'Persist.php';

class Vehicle extends Persist
{
    // Attributes
    protected string $model;
    protected string $license_plate;
    protected int $capacidade;
    protected static $local_filename = "Vehicle.txt";
       
    // Constructor
    public function __construct(string $model, 
                                string $license_plate, 
                                int $capacidade)
    {
        $this->model = $model;
        $this->license_plate = $license_plate;
        $this->capacidade = $capacidade;
    
        try{
            $this->save(); 
         }catch(Exception $e){
             echo $e->getMessage();
             throw($e);
         }
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
      //  echo "The vehicle with license plate {$this->license_plate} was destroyed.";
    }
    static public function getFilename()
    {
        return get_called_class()::$local_filename;
    }
}
