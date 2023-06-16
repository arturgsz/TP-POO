<?php 
//require_once "container.php";
require_once "Persist.php";
require_once "UserAuthenticate.php";
abstract class Log extends Persist{

    protected int $log_index;


    static public function showLogs(){
       
        if(!UserAuthenticate::Authentication())
            throw(new Exception("Impossivel gerar relatório de Logs, não há usuario no sistema"));

        echo "\n".get_called_class()."s do Sistema:\n\n";
        print_r(self::getRecords());
    }

    public function setIndex($index){
        $this->log_index = $index;
    }
    abstract static public function getFileName();
}


?>