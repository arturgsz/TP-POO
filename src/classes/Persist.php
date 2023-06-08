<?php    
    include_once('Container.php');
    require_once "UserAuthenticate.php";

    abstract class Persist {
      //  private ?string $filename;
        private ?int $index = null; 
        // public function __construct() {        
        //     if (func_num_args()==1) {
        //         $this->filename = func_get_arg(0);	                		
		// 	}  
        //     else if (func_num_args()==2) {
        //         $this->filename = func_get_arg(0);	
        //         $this->index = func_get_arg(1);              
		// 	}             
		// 	else {
		// 		throw( new Exception('Eror ao instanciar objeto da classe Persist - Número de parâmetros incorreto.'));
        //     }
        // }

        // public function __destruct() {
        //     //print "Destroying " . __CLASS__ . "\n";
        // }

        // public function load($p_obj) {           
        //    $class_vars = get_class_vars(get_class($p_obj));
        //     foreach ($class_vars as $name => $value) {
        //         echo "$name : $value\n";
        //         $this->$name = $value;            
        //     }
        // }             

        public function save() {
            
            if ( $this->index != null ){
                if(!self::Authentication()){
                    echo "->save(). Não há usuário logado no sistema\n";
                    return;
                }
                
                $this->edit();
            
            }else{ 
                if(!self::Authentication())
                    throw(new Exception("->__construct(). Não há usuário logado no sistema\n"));
               
                $this->insert(); 
            }           
                           
        }

        private function insert() {           
            $container = new container(get_called_class()::getFilename());
            //print_r(get_called_class()::getFilename()); exit();                     
            new WriteLog(null, $this);
            
            $container->addObject($this);
            $container->Persist();
        }

        private function edit() {            
            $container = new container(get_called_class()::getFilename());                  
            new WriteLog(self::getByKey($this->index), $this);

            $container->editObject( $this->index, $this );
            $container->Persist();
        }

        public function delete(){
            $container = new container(get_called_class()::getFilename());                  
            new WriteLog($this, null);
            
            echo "O objeto ".get_called_class()." foi deletado";
            
            $container->deleteObject($this->index);
            $container->Persist();
        }

        static public function getRecordsByField( $p_field, $p_value ) {            
            if(!self::Authentication()){
                echo "->getRecordsByField(). Não há usuário logado no sistema\n";
                return;
            }
            
            $container = new container(get_called_class()::getFilename());
            //$container = container::getInstance(get_called_class()::getFilename());          
            
            $objs = $container->getObjects();  
            $matchObjects = array();         
            
            foreach( $objs as $ob) {
                if ( $ob->$p_field == $p_value ){
                    new ReadLog($ob);
                    array_push( $matchObjects, $ob );  
                }                  
                                   
            }
             if ( count($matchObjects) > 0 )
                return $matchObjects;
             else
                return null;
             //     throw( new Exception('Registro não encontrado.'));
        }
       
        static public function getByKey( $index ) {            
            if(!self::Authentication()){
                echo "->getByKey(). Não há usuário logado no sistema\n";
                return;
            }
            
            $container = new container(get_called_class()::getFilename());       
            
            try{
                $obj = $container->getByKey($index);
                new ReadLog($obj);
                return $obj;
            }catch(Exception $e){
                //echo $e->getMessage();
                //echo get_called_class()::getFilename();
                throw($e);
                //return null;
            }
     
        }

        static public function getRecords() {            
            if(!self::Authentication()){
                echo "->getRecords(). Não há usuário logado no sistema\n";
                return;
            }
                
            $container = new container(get_called_class()::getFilename());
            //$container = container::getInstance(get_called_class()::getFilename());          
            $objs = $container->getObjects();            
            
            foreach($objs as $ob){
                new ReadLog($ob);
            }
            return $objs;
        }

        public function setIndex( int $index ) {
            $this->index = $index;
        }

        public function getKey(){
            return $this->index;
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

        public function getVars(): array{
            return get_class_vars(get_class($this));
        }

        abstract static public function getFilename();
    }