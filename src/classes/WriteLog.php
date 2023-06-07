<?php 

require_once "UserAuthenticate.php";
require_once "Log.php";

class WriteLog extends Log{
    
    protected string $user_loguin;
    protected string $date;
    protected string $class_name;
    protected $data_before;
    protected $data_after;

    public function __construct($obj_before, $obj_after){

        $this->data_before = $obj_before;
        $this->data_after = $obj_after;

        $this->class_name = get_class($obj_before);  
        $this->user_loguin = UserAuthenticate::getLogedUser();
        $this->date = date('d-m-y h:i:s'); 

        $this->save();
    }
     static public function getFileName()
    {
        return "WriteLog.txt";
    }


}   

?>