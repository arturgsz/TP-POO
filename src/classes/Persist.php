<?php    
    include_once('Container.php');
    abstract class Persist {
        private ?string $filename;
        private ?int $index = null; 
        public function __construct() {        
            if (func_num_args()==1) {
                $this->filename = func_get_arg(0);	                		
			}  
            else if (func_num_args()==2) {
                $this->filename = func_get_arg(0);	
                $this->index = func_get_arg(1);              
			}             
			else {
				throw( new Exception('Eror ao instanciar objeto da classe Persist - Número de parâmetros incorreto.'));
            }
        }

        public function __destruct() {
            //print "Destroying " . __CLASS__ . "\n";
        }

        public function load($p_obj) {           
           $class_vars = get_class_vars(get_class($p_obj));
            foreach ($class_vars as $name => $value) {
                echo "$name : $value\n";
                $this->$name = $value;            
            }
        }             

        public function save() {
            if ( $this->index != null ) 
                $this->edit();            
            else               
                $this->insert();            
        }

        private function insert() {           
            $container = new container(get_called_class()::getFilename());
            //print_r(get_called_class()::getFilename()); exit();                     
            $container->addObject($this);
            $container->Persist();
        }

        private function edit() {            
            $container = new container(get_called_class()::getFilename());                  
            $container->editObject( $this->index, $this );
            $container->Persist();
        }

        public function delete(){
            $container = new container(get_called_class()::getFilename());                  
            $container->deleteObject($this->index);
            $container->Persist();
        }

        static public function getRecordsByField( $p_field, $p_value ) {            
            $container = new container(get_called_class()::getFilename());
            //$container = container::getInstance(get_called_class()::getFilename());          
            
            $objs = $container->getObjects();  
            $matchObjects = array();         
            
            foreach( $objs as $ob) {
                if ( $ob->$p_field == $p_value )                   
                array_push( $matchObjects, $ob );                    
            }
            // if ( count($matchObjects) > 0 )
                return $matchObjects;
            // else
            //     throw( new Exception('Registro não encontrado.'));
        }
       
        static public function getByKey( $index ) {            
            $container = new container(get_called_class()::getFilename());
            
            try{
                $obj = $container->getByKey($index);
                return $obj;
            }catch(Exception $e){
                echo $e->getMessage();
                return null;
            }
     
        }

        static public function getRecords() {            
            $container = new container(get_called_class()::getFilename());
            //$container = container::getInstance(get_called_class()::getFilename());          
            $objs = $container->getObjects();            
            return $objs;
        }

        public function setIndex( int $index ) {
            $this->index = $index;
        }

        public function getKey(){
            return $this->index;
        }

        abstract static public function getFilename();
    }