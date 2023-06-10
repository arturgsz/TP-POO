<?php
/* Passenger.php
 * This is the class for the Passenger object.
 */
require_once "Persist.php";
require_once "User.php";
require_once "Travel.php";
class Passenger extends User
{
    // Attributes
    protected string $name;
    protected string $surname;
    protected string $cpf;
    protected string $nacionality;
    protected DateTime $birth;
    protected string $document;
    protected float $balance;
    protected bool $vip;
	protected float $miliage;
    protected array $flights;
    protected int $myUserKey;
    //private Ticket $ticket;
    protected static $local_filename = "Passenger.txt";
       

    // Constructor
    public function __construct(string $name, 
                                string $surname, 
                                string $cpf,
                                string $nacionality,
                                DateTime $birth,
                                string $document,
                                bool $vip,
                                string $login, 
                                string $email,
                                string $password)
    {
        $this->name = $name;
        $this->surname = $surname;    
        $this->nacionality = $nacionality;
        $this->document = $document;
        $this->vip = $vip;

        
        if($this->CpfValidation($cpf))
            $this->cpf = $cpf;
        else
            throw(new Exception("CPF invalido!\n"));
        
        if($this->BirthValidation($birth))
            $this->birth = $birth;
        else 
            throw(new Exception("Data de nascimento inválida!\n"));
        
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


    public function showTravels(){
        $tickets = FlightTicket::getRecordsByField("PassengerKey", $this->getKey());
        echo "As viagens realizadas por voçe foram: \n\n";
        print_r($tickets);
    }
    //adicionar aqui toda vez que o passageiro executar um voo
    

    public function addCredit($add){
        $this->balance += $add;
        $this->save();
    }
    public function showBalance(){
        echo $this->name." seu saldo é de ".$this->balance."R$\n";
    }
    public function pay($price){
        if($this->balance < $price)
            throw(new Exception("O Cliente não possui saldo suficiente"));
        
        $this->balance -=$price;
        $this->save();
    }


    public function Add_flight (FlightLine $flight) : void
    {
      //$flight_new = $flight->getKey();
      array_push($this->flights, FlightLine::getByKey($flight));
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
    public function getMiliage() : int
    {
        return $this->miliage;
    }
        
    // Destructor
    public function __destruct()
    {
      //  echo "The object Passenger {$this->name} {$this->surname} was destroyed.";
    }
    static public function getFilename()
    {
        return get_called_class()::$local_filename;
    }
}