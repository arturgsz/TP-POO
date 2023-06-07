<?php 
require_once "container.php";

abstract class Log{

    protected int $log_index;

    protected function save(){
        $container = new Container(get_called_class()::getFileName());
        $container->addObject($this);
        $container->persist();
    }

    static public function showLogs(){
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