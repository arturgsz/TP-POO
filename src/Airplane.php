<?php
/* Airplane.php
 * This is the class for the Airplane object.
 */
require_once'FlightCompany.php';

class Airplane
{
  //pertencimento a uma Companhia Aerea
  private string $nameFlightCompany; 
  private string $siglaFlightCompany; 
  
  private string $manufacturer;
  private string $model;
  private string $airplane_register; 
  private int $capacity_passenger; 
  private float $capacity_cargo; 


  public function __construct(FlightCompany $FlightCompany,
                              string $manufacturer, 
                              string $model,
                              string $airplane_register,
                              int $capacity_passenger,
                              float $capacity_cargo)
  {
    $this->nameFlightCompany = $FlightCompany->getName();
    $this->siglaFlightCompany = $FlightCompany->getSigla();
    
    $this->manufacturer = $manufacturer;
    $this->model = $model;
  
    if(Airplane::confereRegistro($airplane_register)){
      $airplane_register = mb_strtoupper($airplane_register);
      $this->airplane_register = $airplane_register; 
    } 
    
    $this->capacity_passenger = $capacity_passenger;
    $this->capacity_cargo= $capacity_cargo;   
  }

  //função para conferir o registro  
  private function confereRegistro(string $airplane_register) : bool
  {
    $prefixo = $airplane_register[0] . $airplane_register[1];
    $letras = $airplane_register[3] . $airplane_register[4] . $airplane_register[5];
    $letras = mb_strtoupper($letras);
      
    if(($prefixo == 'PT' || $prefixo == 'PR' || $prefixo == 'PP' || $prefixo == 'PS') &&($airplane_register[2] == '-') && ((mb_strlen($letras)) == 3) && ((gettype($letras)) == 'string'))
    return true;
    
    else {
      //tratar o erro(registro inválido)
      echo "Registro de aeronave inválido" . PHP_EOL;
      return false;
    }
  }

  // Getters and Setters
  public function getsiglaFlightCompany() : string
  {
    return $this->siglaFlightCompany;
  }
  
  public function getManufacturer() : string
  {
    return $this->manufacturer;
  }

  public function getModel() : string
  {
     return $this->model;
  }

  public function getRegistration() : string
  {
    return $this->airplane_register;
  }

  public function getPassengerCapacity() : int
  {
    return $this->capacity_passenger;
  }

  public function getWeightCapacity() : float
  {
    return $this->capacity_cargo;
  }

  public function setManufacturer(string $manufacturer) : void
  {
    $this->manufacturer = $manufacturer;
  }

  public function setModel(string $model) : void
  {
    $this->model = $model;
  }

  public function setRegistration(string $airplane_register) : void
  {
    if(Airplane::confereRegistro($airplane_register)){
      $airplane_register = mb_strtoupper($airplane_register);
      $this->airplane_register = $airplane_register; 
    } 
  }

  public function setPassengerCapacity(int $capacity_passenger) : void
  {
    $this->capacity_passenger = $capacity_passenger;
  }

  public function setWeightCapacity(float $capacity_cargo) : void
  {
    $this->capacity_cargo = $capacity_cargo;
  }

  // Destructor
  public function __destruct()
  {
    echo "Airplane object destroyed." . PHP_EOL;
  }
}
