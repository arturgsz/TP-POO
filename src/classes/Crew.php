<?php
/* Crew.php
 * This is the class for the Crew object.
 */

require_once 'Airport.php';
require_once 'Adress.php';
require_once "User.php";

class Crew extends User
{
  protected string $name;
  protected string $surname;
  protected string $cpf;
  protected string $nacionality;
  protected DateTime $birth;
  protected string $email;
  protected string $flight_doc;
  protected int $adressKey;
  protected int $flightcompanyKey;
  protected int $base_airportKey;
  protected int $myUserKey;
  protected string $cargo;
  protected static $local_filename = "Crew.txt";
       

  
  public function __construct(string $name,
                              string $surname,
                              string $cpf,
                              string $nacionality,
                              DateTime $birth,
                              string $flight_doc,
                              string $cargo,
                              Adress $adress,
                              FlightCompany $flightcompany,
                              Airport $base_airport,
                              string $login,
                              string $email,
                              string $password)
  {
    $this->name = $name;
    $this->surname = $surname;
    $this->nacionality = $nacionality;
    $this->flight_doc = $flight_doc;
    $this->cargo = strtoupper($cargo);
    $this->adressKey = $adress->getKey();
    $this->flightcompanyKey = $flightcompany->getKey();
    $this->base_airportKey = $base_airport->getKey();  
    
      
    if(mb_strtoupper($nacionality) == 'BRASILEIRO' || 
       mb_strtoupper($nacionality) == 'BRASILEIRA'){
      
      if($this->CpfValidation($cpf))
        $this->cpf = $cpf;
      else 
        throw new Exception ("CPF Invalido");

      if($this->EmailValidation ($email))
        $this->email = $email;
      else
        throw new Exception ("Email Invalido");
    
      if($this->BirthValidation($birth))
        $this->birth = $birth;
      else
        throw new Exception ("Nascimento Invalido");
    }
    
    try{
        $MyUser = new User($login, $email, $password);
        $MyUser->setUserType(get_called_class());
        $this->myUserKey = $MyUser->getKey();

    }catch( Exception $e){
        echo $e->getMessage();
        throw($e);
    }
    try{
      $this->save(); 
    }catch(Exception $e){
      
      echo $e->getMessage();
      throw($e);
    }
}

//Validations    
  public function CpfValidation($cpf) : bool
  {
  // Extrai somente os números
  $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
  $this->cpf = $cpf;
  // Verifica se foi informado todos os digitos corretamente
  if (strlen($cpf) != 11) {
      echo "CPF invalido" . PHP_EOL;
      return false;
  }
  // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
  if (preg_match('/(\d)\1{10}/', $cpf)) {
      echo "CPF invalido" . PHP_EOL;
      return false;
  }
  // Faz o calculo para validar o CPF
  for ($t = 9; $t < 11; $t++) {
      for ($d = 0, $c = 0; $c < $t; $c++) {
          $d += $cpf[$c] * (($t + 1) - $c);
      }
      $d = ((10 * $d) % 11) % 10;
      if ($cpf[$c] != $d) {
         // echo "CPF invalido" . PHP_EOL;
          return false;
      }
  } 
  return true;
  }

  public function BirthValidation(DateTime $birth) : bool
  {
    $d = $birth->format('d');
    $m = $birth->format('m');
    $y = $birth->format('Y');
    
    $hoje = new DateTime();
    $hd = $hoje->format('d');
    $hm = $hoje->format('m');
    $hy = $hoje->format('Y');
                     
    if(checkdate($m, $d, $y)){
      if($y > $hy || ($y == $hy && $m > $hm) ||
        ($y == $hy && $m == $hm && $d > $hd)){
        //echo "Nascimento invalido" . PHP_EOL;
        return false;
      } 
      return true;
    }
    else{
      //echo "Data de nascimento invalidado" . PHP_EOL;
      return false;
    }
  }

 // Setters and Getters
  public function getName() : string
  {
      return $this->name;
  }

  public function getSurname() : string
  {
      return $this->surname;
  }

  public function getCpf() : string
  {
      return $this->cpf;
  }


  public function getNacionality() : string
  {
      return $this->nacionality;
  }

  public function getBirth() : DateTime
  {
      return $this->birth;
  }

  public function getCargo() : string
  {
    return $this->cargo;
  }
    
  public function getAirport() : Airport
  {
    $airport = Airport::getByKey($this->base_airportKey);
    return $airport;
  }

  public function getFlightCompany() : FlightCompany
  {
    return FlightCompany::getByKey($this->flightcompanyKey);
  }
  
  public function getAdress() : Adress
  {
    return Adress::getByKey($this->adressKey);
  }
  
  public function getFlight_doc() : string
  {
    return $this->flight_doc;
  }

  
  public function setAirport(Airport $base_airport) : void
  {
    $this->base_airportKey = $base_airport->getKey();
  }

  public function setFlightCompany(FlightCompany $flightcompany) : void
  {
    $this->flightcompanyKey = $flightcompany->getKey();
  }

  public function setAdress(Adress $adress) : void
  {
    $this->adressKey = $adress->getKey();
  }

  public function setFlight_doc(string $flight_doc) : void
  {
    $this->flight_doc = $flight_doc;
  }

  
  // Destructor
  public function __destruct()
  {
   //  echo "Crew {$this->name} has been deleted.";
  }
  static public function getFilename()
  {
      return get_called_class()::$local_filename;
  }
}