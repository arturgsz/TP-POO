<?php 

class ReadLog{
    
    public string $user_loguin;
    private string $user_email;
    private string $date;
    private string $entity_name;
    private string $data_acceced;

    public function __construct(){



        $this->date = date('d-m-y h:i:s'); 
    }

   


}   

?>