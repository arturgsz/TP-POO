<?php

require_once 'Persist.php';

class User extends Persist{

    protected string $login;
    protected string $email;
    private string $password;
    protected int $is_online = 1;

    protected static $local_filename = "User.txt";

    public function __construct(string $login, string $email, string $password){

        $this->login = $login;
        $this->email = $email;
        $this->password = md5($password);

       if (
        self::getRecordsByField("login", $this->login) == null &&
        self::getRecordsByField("email", $this->email) == null
        ){
            $this->save();
        }else{

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

    private function validateEmail(){
        //a fazer
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

    static public function getFilename()
    {
        return get_called_class()::$local_filename;
    }

}


?>