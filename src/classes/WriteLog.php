<?php 

require_once "UserAuthenticate.php";
require_once "Log.php";
date_default_timezone_set("America/Sao_Paulo");

class WriteLog extends Log{
    
    protected string $user_loguin;
    protected string $date;
    protected string $class_name;
    protected $data_before;
    protected $data_after;

    public function __construct($obj_before, $obj_after){

        $this->data_before = $obj_before;
        $this->data_after = $obj_after;
        
        if(!empty($obj_before))
            $this->class_name = get_class($obj_before); 
        else 
            $this->class_name = get_class($obj_after);

        $this->user_loguin = UserAuthenticate::getLogedUser();
        $this->date = date("d-m-y h:i:s A"); 

        $this->save();
        echo "Log number ".$this->getKey()."\n";
    }
     static public function getFileName()
    {
        return "WriteLog.txt";
    }


}   

?>