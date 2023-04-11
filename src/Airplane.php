<?php
/* Airplane.php
 * This is the class for the Airplane object.
 */

class Airplane
{
    // Attributes
    private string $manufacturer;
    private string $model;
    private string $registration; //MUDAR NOME NA UML
    private int $passenger_capacity; //MUDAR NOME NA UML
    private float $weight_capacity; //MUDAR NOME NA UML

    // Constructor
    public function __construct(string $manufacturer, string $model, string $registration, int $passenger_capacity, float $weight_capacity)
    {
        if(Airplane::confereRegistro($registration)){
        $this->registration = $registration; 
        
        $this->manufacturer = $manufacturer;
        $this->model = $model;

        $this->passenger_capacity = $passenger_capacity;
        $this->weight_capacity = $weight_capacity; 
        
        }else{
            $this->__destruct();
        }  
    }

    //função para conferir o registro
    public function confereRegistro(string $registration) : bool
    {
        $prefixo = $registration[0] . $registration[1]; 
        if(($prefixo == 'PT' || $prefixo == 'PR' || $prefixo == 'PP' || $prefixo == 'PS') &&
          ($registration[2] == '-') && ($registration[3] >= 65 && $registration[3] <= 90) &&
          ($registration[4] >= 65 && $registration[4] <= 90) &&
          ($registration[5] >= 65 && $registration[5] <= 90))
            return true;
        else{
            
            echo "Registro de aeronave inválido";
            return false;
    }}

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
        return $this->registration;
    }

    public function getPassengerCapacity()
    {
        return $this->passenger_capacity;
    }

    public function getWeightCapacity()
    {
        return $this->weight_capacity;
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
        $this->registration = $registration;
    }

    public function setPassengerCapacity(int $passenger_capacity)
    {
        $this->passenger_capacity = $passenger_capacity;
    }

    public function setWeightCapacity(float $weight_capacity)
    {
        $this->weight_capacity = $weight_capacity;
    }

    // Destructor
    public function __destruct()
    {
        echo "Airplane object destroyed.";
    }
}
