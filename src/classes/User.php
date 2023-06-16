<?php

require_once 'PersistLogAuthenticate.php';

class User extends PersistLogAuthenticate{

    public string $login;
    protected string $email;
    protected string $password;
    protected string $user_type;
    protected int $is_online = 1;

    protected static $local_filename = "User.txt";

    public function __construct(string $login, string $email, string $password){

       if(!$this->EmailValidation($email))
            throw( new Exception("Email inválido"));
        
        $this->login = $login;
        $this->email = $email;
        $this->password = md5($password);                
        $this->user_type = "User Mestre";
        
        if (
        self::getRecordsByField("login", $this->login) == null &&
        self::getRecordsByField("email", $this->email) == null
        ){ 

            try{
                $this->save(); 
             }catch(Exception $e){
                 echo $e->getMessage();
                 throw($e);
             }
        }else{
            //echo "Erro! O email ou login passados não estão disponiveis\n";
            throw(new Exception("Erro! O email ou login passados não estão disponiveis\n"));

        }
    }

    public function login(string $pass): bool{      
        $password = md5($pass);

            if($password == $this->password){
                $this->is_online = 0;
                return true;
            }else{
                throw( new Exception("Senha inválida\n"));
            }
    }

    public function EmailValidation($email) : bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
         }
         else{
            //echo "Email invalido" . PHP_EOL;
            return false;
        }  
    }

    public function logout(){
        $this->is_online = 1;
        $this->save();
    }

    public function __destruct(){

    }
    public function getLogin(){
        return $this->login;
    }
    public function getUserType(){
        return $this->user_type;
    }

    protected function setUserType($type){
        $this->user_type = $type;
        $this->save();
    }
    static public function getFilename()
    {
        return get_called_class()::$local_filename;
    }

}


?>