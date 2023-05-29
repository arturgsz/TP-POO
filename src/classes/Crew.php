<?php
/* Crew.php
 * This is the class for the Crew object.
 */

require_once 'Airport.php';
require_once 'Adress.php';

class Crew extends persist
{
  private string $name;
  private string $surname;
  private string $cpf;
  private string $nacionality;
  private DateTime $birth;
  private string $email;
  private string $flight_doc;
  private Adress $adress;
  private FlightCompany $flightcompany;
  private Airport $base_airport;
  protected static $local_filename = "Crew.txt";
       

  
  public function __construct(string $name,
                              string $surname,
                              string $cpf,
                              string $nacionality,
                              DateTime $birth,
                              string $email,
                              string $flight_doc,
                              Adress $adress,
                              FlightCompany $flightcompany,
                              Airport $base_airport)
  {
    $this->name = $name;
    $this->surname = $surname;
    $this->nacionality = $nacionality;
    if(mb_strtoupper($nacionality) == 'BRASILEIRO' || 
       mb_strtoupper($nacionality) == 'BRASILEIRA'){
      if(Passenger::CpfValidation($cpf)){$this->cpf = $cpf;}
      else { throw new Exception ("CPF Invalido");}
    }else{$this->cpf = $cpf;}
    if(Passenger::EmailValidation ($email)){$this->email = $email;}
    else{ throw new Exception ("Email Invalido");}
    $this->nacionality = $nacionality;
    if(Passenger::BirthValidation($birth)){$this->birth = $birth;}
    else{ throw new Exception ("Nascimento Invalido");}

    $this->flight_doc = $flight_doc;
    $this->adress = $adress;
    $this->flightcompany = $flightcompany;
    $this->base_airport = $base_airport;
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
          echo "CPF invalido" . PHP_EOL;
          return false;
      }
  } 
  return true;
  }

  public function EmailValidation($email) : bool
  {
      if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
          return true;
       }
       else{
          echo "Email invalido" . PHP_EOL;
          return false;
      }  
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
        echo "Nascimento invalido" . PHP_EOL;
        return false;
      } 
      return true;
    }
    else{
      echo "Nascimento invalida=o" . PHP_EOL;
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

  public function getEmail() : string
  {
      return $this->email;
  }

  public function getNacionality() : string
  {
      return $this->nacionality;
  }

  public function getBirth() : DateTime
  {
      return $this->birth;
  }
    
  public function getAirport() : Airport
  {
    return $this->base_airport;
  }

  public function getFlightCompany() : FlightCompany
  {
    return $this->flightcompany;
  }
  
  public function getAdress() : Adress
  {
    return $this->adress;
  }
  
  public function getFlight_doc() : string
  {
    return $this->flight_doc;
  }

  
  public function setAirport(Airport $base_airport) : void
  {
    $this->base_airport = $base_airport;
  }

  public function setFlightCompany(FlightCompany $flightcompany) : void
  {
    $this->flightcompany = $flightcompany;
  }

  public function setAdress(Adress $adress) : void
  {
    $this->adress = $adress;
  }

  public function setFlight_doc(string $flight_doc) : void
  {
    $this->flight_doc = $flight_doc;
  }

  
  // Destructor
  public function __destruct()
  {
     echo "Crew {$this->name} has been deleted.";
  }
  static public function getFilename()
  {
      return get_called_class()::$local_filename;
  }
}