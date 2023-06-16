<?php

require_once "Persist.php";
require_once "UserAuthenticate.php";

abstract class PersistLogAuthenticate extends Persist{

    public function save() {
            
        if(!self::Authentication())
            throw(new Exception("Erro. Não há usuário logado no sistema\n"));
            
            new WriteLog(parent::getByKey($this->getKey()), $this);
            parent::save();               
    }

    public function delete(){
        if(!self::Authentication())
            throw(new Exception("Erro. Não há usuário logado no sistema\n"));
        
            parent::delete();
            new WriteLog($this, null);      
    }

    static public function getRecordsByField( $p_field, $p_value ) {            
        if(!self::Authentication())
        throw(new Exception("Erro. Não há usuário logado no sistema\n"));
            
        $objs = parent::getRecordsByField($p_field, $p_value);
        if(!empty($objs)){
            foreach($objs as $obj){
            new ReadLog($obj);
            }        
        }
        return $objs;
    }
   
    static public function getByKey( $index ) {            
        if(!self::Authentication())
        throw(new Exception("Erro. Não há usuário logado no sistema\n"));
         
        $obj =  parent::getByKey($index);
        new ReadLog($obj);
        return $obj;
    }

    static public function getRecords() {            
        if(!self::Authentication())
        throw(new Exception("Erro. Não há usuário logado no sistema\n"));
         
        $objs = parent::getRecords();
        foreach($objs as $obj){
            new ReadLog($obj);
        }
        return $objs;
    }

    public function getKey(){
        if(!self::Authentication())
        throw(new Exception("Erro. Não há usuário logado no sistema\n"));
        
        return parent::getKey();
    }

    public function update(){
        if(!self::Authentication())
        throw(new Exception("Erro. Não há usuário logado no sistema\n"));

        return parent::update();
    }
    static private function Authentication():bool{
        try{
           $bool= UserAuthenticate::Authentication();
           return $bool;
        }catch( Exception $e){
            echo $e->getMessage().get_called_class();
            return false;
        }
    }

}


