<?php
/* Client.php
 * This is the class for the Passenger object.
 */

class Client
{
    // Attributes
    private string $name;
    private string $surname;
    private string $cpf;
    private string $email;
    private string $nacionality;
    private Datetime $birth;
    private string $document;
    private bool $vip;
    private $flights = [];
    //private Ticket $ticket;

    // Constructor
    public function __construct(string $name, 
                                string $surname, 
                                string $cpf,
                                string $email,
                                string $nacionality,
                                Datetime $birth,
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

    public function getBirth() : Datetime
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
    
    //Validations
    
    public function CpfValidation($cpf)
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

    public function EmailValidation($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
         }
         else{
            return false;
        }  
    }

    
    // Função que printa na tela as informações do passageiro
    // Deve ficar em travel 
    // public function Show_Passenger(){ 
    // for ($i=0; $i < count($this->flights); $i++)
    //     echo"Nome do passageiro: {$this->name[$i]}\n";
    //     echo"Sobrenome do passageiro: {$this->surname[$i]}\n";
    //     echo"CPF do passageiro: {$this->cpf[$i]}\n";
    //     echo"Email do passageiro: {$this->email[$i]}\n";
    //     echo"Nacionalidade do passageiro: {$this->nacionality[$i]}\n";
        
    // } 
    
    
    
  
    
    // Destructor
    public function __destruct()
    {
        echo "The object client {$this->name} {$this->surname} was destroyed." . PHP_EOL;
    }
}