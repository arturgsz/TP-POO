<?php
/* Passenger.php
 * This is the class for the Passenger object.
 */

class Passenger extends Persist
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
	  private float $miliage;

    private $flights = [];
    //private Ticket $ticket;
    protected static $local_filename = "Passenger.txt";
       

    // Constructor
    public function __construct(string $name, 
                                string $surname, 
                                string $cpf,
                                string $email,
                                string $nacionality,
                                DateTime $birth,
                                string $document,
                                bool $vip)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->cpf = $cpf;
        $this->email = $email;
        $this->nacionality = $nacionality;
        $this->birth = $birth;
        $this->document = $document;
        $this->vip = $vip;
    
        $this->save();
    }

      //Validations
    
    public function CpfValidation($cpf) : bool
    {
    // Extrai somente os números
    $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        return false;
    }
    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }
    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
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
            return false;
        }  
    }
  
    public function BirthValidation(DateTime $birth) : bool
    {
        $d = $birth->format('d');
        $m = $birth->format('m');
        $y = $birth->format('y');
        if(checkdate($d, $m, $y)){
            return true;
        }
        else{
            return false;
        }
    }

    //adicionar aqui toda vez que o passageiro executar um voo
    public function Add_flight (FlightLine $flight) : void
    {
      array_push($this->flights, $flight);
    }

    public function Show_flight () : void
    {
      echo "Voos de: " . $this->name  . " " . $this->surname . "<br>";
      for($i = 0; $i < sizeof($this->flights); $i++){
        echo $this->flights[$i]->origin . " até " . $this->flights[$i]->destiny . "<br>";
        echo "Início do voo: " . $this->flights[$i]->expected_departure_time . " por R$" .
          $this->flights[$i]->line_price . "<br>";
      }
      echo "<br";
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
    public function getDocument() : string
    {
        return $this->document;
    }
    public function getVip() : bool
    {
        return $this->vip;
    }
    public function getFlights() : array
    {
        return $this->flights;
    }
    public function getMiliage() : int
    {
        return $this->miliage;
    }
        
    // Destructor
    public function __destruct()
    {
        echo "The object Passenger {$this->name} {$this->surname} was destroyed.";
    }
    static public function getFilename()
    {
        return get_called_class()::$local_filename;
    }
}