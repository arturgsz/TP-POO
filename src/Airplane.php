<?php
/* Airplane.php
 * This is the class for the Airplane object.
 */
class Airplane
{
    // Attributes
    private string $manufacturer;
    private string $model;
    private string $airplane_register; 
    private int $capacity_passenger; 
    private float $capacity_cargo; 

    // Constructor
    public function __construct(string $manufacturer, 
                                string $model,
                                string $airplane_register,
                                int $capacity_passenger,
                                float $capacity_cargo)
    {
        if(Airplane::confereRegistro($airplane_register)){
          $this->airplane_register = $airplane_register; 
          
          $this->manufacturer = $manufacturer;
          $this->model = $model;
  
          $this->capacity_passenger = $capacity_passenger;
          $this->capacity_cargo= $capacity_cargo; 
          
        } else {
            $this->__destruct();
        }  
    }

    //função para conferir o registro
    //arrumar a validaçao 
    public function confereRegistro(string $airplane_register) : bool
    {
      /*
        $prefixo = $airplane_register[0] . $airplane_register[1]; 
        if(intval($airplane_register[3]) >= 65 && intval($airplane_register[3]) <= 90) {
          echo "entrou";
        }
        if(($prefixo == 'PT' || $prefixo == 'PR' || $prefixo == 'PP' || $prefixo == 'PS') &&
          ($airplane_register[2] == '-') && ($airplane_register[3] >= 65 && $airplane_register[3] <= 90) &&
          ($airplane_register[4] >= 65 && $airplane_register[4] <= 90) &&
          ($airplane_register[5] >= 65 && $airplane_register[5] <= 90))
            return true;
        else{
            
            echo "Registro de aeronave inválido";
            return false;
    }
    */
      return true;
  }

    // Getters and Setters
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getRegistration()
    {
        return $this->airplane_register;
    }

    public function getPassengerCapacity()
    {
        return $this->capacity_passenger;
    }

    public function getWeightCapacity()
    {
        return $this->capacity_cargo;
    }

    public function setManufacturer(string $manufacturer)
    {
        $this->manufacturer = $manufacturer;
    }

    public function setModel(string $model)
    {
        $this->model = $model;
    }

    public function setRegistration(string $registration)
    {
        $this->airplane_register = $airplane_register;
    }

    public function setPassengerCapacity(int $passenger_capacity)
    {
        $this->capacity_passenger = $capacity_passenger;
    }

    public function setWeightCapacity(float $weight_capacity)
    {
        $this->capacity_cargo = $capacity_cargo;
    }

    // Destructor
    public function __destruct()
    {
        echo "Airplane object destroyed.";
    }
}
