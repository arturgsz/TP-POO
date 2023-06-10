<?php
/* Client.php
 * This is the class for the Client object.
 */
require_once 'User.php';
require_once "Persist.php";

class Client extends User{
    
    // Attributes
    protected string $name;
    protected string $surname;
    protected string $cpf;
    protected static $local_filename = "Client.txt";
    protected int $myUserKey;
    
    // Constructor
    public function __construct(string $name, 
                                string $surname, 
                                string $cpf,
                                string $login,
                                string $email,
                                string $password)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->cpf = $cpf;
        
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

    // Destructor
    public function __destruct()
    {
       // echo "The object client {$this->name} {$this->surname} was destroyed.";
    }
    static public function getFilename()
    {
        return get_called_class()::$local_filename;
    }
}