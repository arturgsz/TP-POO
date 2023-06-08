<?php 
require_once "container.php";
require_once "UserAuthenticate.php";
abstract class Log{

    protected int $log_index;

    
    protected function save(){
        $container = new Container(get_called_class()::getFileName());
        $container->addObject($this);
        $container->persist();
    }

    static public function showLogs(){
       
        if(!UserAuthenticate::Authentication())
            throw(new Exception("Impossivel gerar relatório de Logs, não há usuario no sistema"));

        $container = new Container(get_called_class()::getFileName());
        $objs = $container->getObjects();
        
        echo "\n".get_called_class()."s do Sistema:\n\n";
        print_r($objs);
    }

    public function setIndex($index){
        $this->log_index = $index;
    }
    abstract static public function getFileName();
}


?>