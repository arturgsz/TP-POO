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
    protected float $balance = 0;
    protected bool $vip = false;
	protected float $miliage;
    protected $TravelsKey = [];
    protected int $myUserKey;
    //private Ticket $ticket;

    //VIP passenger atributos
    protected int $register_number;
    public int $pointsKey;
    protected int $milliage_subprogramKey;
    protected int $flight_companyKey;
    protected static $local_filename = "Passenger.txt";
       

    // Constructor
    public function __construct(string $name, 
                                string $surname, 
                                string $cpf,
                                string $nacionality,
                                DateTime $birth,
                                string $document,
                                string $login, 
                                string $email,
                                string $password)
    {
        $this->name = $name;
        $this->surname = $surname;    
        $this->nacionality = $nacionality;
        $this->document = $document;
        
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

    //Vip "Construct"
    public function Vip(): void
    {   
        if($this->vip)
            return;
        
        $this->vip = true;
        $this->register_number = rand(100,500)+ $this->getKey();
        $points = new Points();
        $this->pointsKey = $points->getKey();
        $this->flight_companyKey = ((MiliageSubprogram::getByKey($this->milliage_subprogramKey))->getMiliageProgram())->getCompanyKey();

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
    public function isVip(){
        return $this->vip;
    }

    public function showTravels(){
        $tickets = FlightTicket::getRecordsByField("PassengerKey", $this->getKey());
        echo "As viagens realizadas por voce foram: \n\n\n";
        
            foreach($tickets as $ticket){
               
                $flight = $ticket->getFlight();
                echo "Viagem em ".$flight->getDeparture().":\n\n";
                
                echo "Origem: ".$flight->getFlightLine()->getOrigin()->getName()."\n";
                echo "Destino: ".$flight->getFlightLine()->getDestiny()->getName()."\n";
                echo "Código: ".$ticket->getCode()."\n";
                echo "Assento: ".$ticket->getSeat()."\n\n";
           
            }
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


    public function Add_travel (int $travelKey) : void
    {
      //$flight_new = $flight->getKey();
      array_push($this->TravelsKey, $travelKey);
      $this->save();
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
    
    //Vip Methods
    public function getPoints() : float
    {         
        if($this->vip == true){return(Points::getByKey($this->pointsKey))->getPontos_acumulados();}
        else{throw(new Exception("O passageiro não é vip"));}
    }   

    public function getPointsObj(){
        if(!empty($this->pointsKey))
            return Points::getByKey($this->pointsKey);
    }
    
    public function getVipFlightCompany() : FlightCompany
    {         
        if($this->vip == true){return(FlightCompany::getByKey($this->flight_companyKey));}
        else{throw(new Exception("O passageiro não é vip\n"));}
    }
    public function getVipFlightCompanKey(){
        if(!empty($this->flight_companyKey))
            return $this->flight_companyKey;
        else 
        throw(new Exception("O passageiro não é vip\n"));
    }

    public function getSubProgram() : MiliageSubprogram
    {         
        if($this->vip == true){return(MiliageSubprogram::getByKey($this->milliage_subprogramKey));}
        else{throw(new Exception("O passageiro não é vip\n"));}
    }

    // Getters and Setters
    public function getRegister_number() : int
    {
        if($this->vip == true){return $this->register_number;}
        else {throw(new Exception("O passageiro não é vip\n"));}
    }

    public function getMiliage_subprogram()
    {
       return (MiliageSubprogram::getByKey($this->milliage_subprogramKey))->getName();
    }
    
    public function setTravel($TravelKey){
        array_push($this->TravelsKey, $TravelKey);
        $this->save();
    }

    public function setMiliageSubprogram(int $subProgramKey){
        $this->milliage_subprogramKey = $subProgramKey;
        $this->save();
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