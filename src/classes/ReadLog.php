<?php 

require_once "UserAuthenticate.php";
require_once "Log.php";

class ReadLog extends Log{
    protected string $user_loguin;
    protected string $date;
    protected string $class_name;
    protected array $data_fields_acecced;
    protected int $index_element_viewed;

    public function __construct($obj){

        $this->index_element_viewed = $obj->getKey();
        $this->class_name = get_class($obj);
        $this->data_fields_acecced = $obj->getVars();   
        $this->user_loguin = UserAuthenticate::getLogedUser();
        $this->date = date('d-m-y h:i:s'); 

        $this->save();
    }
    
     static public function getFileName()
    {
        return "ReadLog.txt";
    }

}   

?>