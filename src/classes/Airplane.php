<?php
/* Airplane.php
 * This is the class for the Airplane object.
 */
require_once 'FlightCompany.php';
require_once 'Persist.php';

class Airplane extends Persist
{
  protected int $flightCompanyKey; //pertencimento
  protected string $manufacturer;
  protected string $model;
  protected string $airplane_register; 
  protected int $capacity_passenger;
  protected float $capacity_cargo;
  //esse valor é dado pela Companhia Aerea
  protected static $local_filename = "Airplane.txt";
       


  public function __construct(FlightCompany $flightCompany,
                              string $manufacturer,
                              string $model,
                              string $airplane_register,
                              int $capacity_passenger,
                              float $capacity_cargo)
  {
    $this->flightCompanyKey = $flightCompany->getKey();
    $this->manufacturer = $manufacturer;
    $this->model = $model;
  
    if(Airplane::confereRegistro($airplane_register)){
      $airplane_register = strtoupper($airplane_register);
      $this->airplane_register = $airplane_register; 
    } 
    
    $this->capacity_passenger = $capacity_passenger;
    $this->capacity_cargo= $capacity_cargo;   

    try{
      $this->save(); 
    }catch(Exception $e){
       echo $e->getMessage();
       throw($e);
    }
  }

  //função para conferir o registro  
  private function confereRegistro(string $airplane_register) : bool
  {
    $prefixo = $airplane_register[0] . $airplane_register[1];
    $letras = $airplane_register[3] . $airplane_register[4] . $airplane_register[5];
    $letras = strtoupper($letras);
      
    if(($prefixo == 'PT' || $prefixo == 'PR' || $prefixo == 'PP' || $prefixo == 'PS') &&($airplane_register[2] == '-') && ((strlen($letras)) == 3) && ((gettype($letras)) == 'string'))
    return true;
    
    else {
      //tratar o erro(registro inválido)
      echo "Registro de aeronave inválido" . PHP_EOL;
      return false;
    }
  }

  //Pertencimento a uma companhia aerea
  public function getFlightCompany() : FlightCompany
  {
    return FlightCompany::getByKey($this->flightCompanyKey);
  }

  // Getters and Setters
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

  // public function getLuggadge() : float
  // {
  //   return $this->luggadge;
  // }
  
  public function setManufacturer(string $manufacturer) : void
  {

    $this->manufacturer = $manufacturer;
    $this->save();  
  }

  public function setModel(string $model) : void
  {
    $this->model = $model;
  }

  public function setRegistration(string $airplane_register) : void
  {
    if(Airplane::confereRegistro($airplane_register)){
      $airplane_register = strtoupper($airplane_register);
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

  public function informacoes() : void
  {
    echo ("INFORMAÇÕES DA AERONAVE" . PHP_EOL .
          "Fabricante: {$this->getManufacturer()}" . PHP_EOL .
          "Modelo: {$this->getModel()}" . PHP_EOL . 
          "Capacidade de Passageiros: {$this->getPassengerCapacity()} " . PHP_EOL . 
          "Capacidade de Carga: {$this->getWeightCapacity()}" . PHP_EOL .
          "Registro: {$this->getRegistration()}" . PHP_EOL .
          "Pertence a Companhia Aerea: {$this->getFlightCompany()->getName()}" . PHP_EOL );
          //"Valor unitario da bagagem: {$this->getLuggadge()}" . PHP_EOL . PHP_EOL); 
  }

  // Destructor
  public function __destruct()
  {
   // echo "Airplane object destroyed." . PHP_EOL;
  }
  static public function getFilename()
  {
      return get_called_class()::$local_filename;
  }

}
