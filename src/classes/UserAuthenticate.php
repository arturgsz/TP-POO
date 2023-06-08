<?php

require_once "User.php";
require_once "Container.php";

 class UserAuthenticate{

    static private bool $user_online =  false;
    static private int $open_sessions = 0;
    static private ?User $user = null;

public function __construct(){
   // self::solveFirstUser();
    
    if(self::$open_sessions == 0)
        ++self::$open_sessions; 
    else{
        //throw( new Exception("Erro! O sistema ja possui uma sessâo de autentificação, a destrua para criar outra\n"));
        echo "Erro! O sistema ja possui uma sessâo de autentificação, a destrua para criar outra\n";
        $this->__destruct();
    }  
}

    static public function Authentication(): bool{
        if(self::$user_online)
        return true;
        else 
        throw(new Exception("Erro em "));
}

static private function getLogedUserObj(){
    
    if(!empty(self::$user))
        return self::$user;
    else
    throw (new Exception("Erro! Não há usuario logado no sistema\n"));    

}
private function getUserByLogin($login){
    $container = new container("User.txt");

    $objs = $container->getObjects();        
            
            foreach( $objs as $ob) {
                if ( $ob->getLogin() == $login )                   
                return $ob;                    
            }
                throw(new Exception("Não foi possivel encontrar o usuario\n"));

}
static public function getLogedUser(){
    return (self::getLogedUserObj())->getLogin();        
}


 public function LogIn(string $login, string $password){

    if(self::$user_online == false){
        try{
            $user = $this->getUserByLogin($login);
        
        }catch( Exception $e){
            echo $e->getMessage();
            return;
        }
          
        try{
            $bool = $user->login($password);
            self::$user_online = $bool;  
            self::$user = $user;
            $user->save();
            
            echo "\nBem vindo! Mr.".self::getLogedUser()." tu es um ".(self::getLogedUserObj())->getUserType()."\n\n";

        }catch( Exception $e){ 
            echo $e->getMessage();
            return;
        }   
    }else{
        echo "O sistema ja possui um usuário logado\n";
    }
}

static public function LogOut(){
    try{
        echo "Até logo! Mr.".self::getLogedUser()."\n\n";
        
        $user = self::getLogedUserObj();
        $user->logout();
        self::$user_online = false; 
        self::$user = null;

    }catch( Exception $e){
        echo $e->getMessage();
    }   
}
public function __destruct(){
    --self::$open_sessions; 
    if(self::$user_online == true)
        self::LogOut();
}

// static public function solveFirstUser(){
//     if(!file_exists("/dataFiles/User.txt")){
//         try{
//         $user = new User("cruze", "Cruze@gmail.com", "1234");
//         }catch(Exception $e){

//         }
//         $container = new Container("User.txt");
//         $container->addObject($user);
//         $container->persist();

//     }
// }

}
?>