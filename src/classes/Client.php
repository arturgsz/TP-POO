<?php
/* Client.php
 * This is the class for the Client object.
 */

class Client extends persist
{
    // Attributes
    private string $name;
    private string $surname;
    private string $cpf;
    private string $email;
    protected static $local_filename = "Client.txt";
       
    
    // Constructor
    public function __construct(string $name, 
                                string $surname, 
                                string $cpf,
                                string $email)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->cpf = $cpf;
        $this->email = $email;
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
    public function EmailValidation($email) : bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
         }
         else{
            return false;
        }  
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
        echo "The object client {$this->name} {$this->surname} was destroyed.";
    }
    static public function getFilename()
    {
        return get_called_class()::$local_filename;
    }
}