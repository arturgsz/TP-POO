<?php

require_once 'Persist.php';

class User extends Persist{

    private string $login;
    private string $email;
    private string $password;
    private bool $is_online = false;

    protected static $local_filename = "User.txt";

    public function __construct(string $login, string $email, string $password){

        $this->login = $login;
        $this->email = $email;
        $this->password = $password;

       if (
        self::getRecordsByField("login", $this->login) == null &&
        self::getRecordsByField("email", $this->email) == null
        ){
            $this->save();
        }else{
            throw(new Exception(" Ja possui um usuario cadastrado com esse email/login"));
        }
        
    }

    public function login(string $email, string $senha){
        
        if(self::getRecordsByField("is_online", "true") == null){
            if($email == $this->email && $senha == $this->password){
                $this->is_online = true;
            }else{
                throw( new Exception("Email ou senha inválidos"));
            }
        }else{
            throw( new Exception("O sistema ja possui um usuario logado"));
        }

    }

    public function logout(){
        $this->is_online = false;
    }

    public function __destruct(){
       $this->logout();
    }

    static public function getFilename()
    {
        return get_called_class()::$local_filename;
    }

}


?>