<?php    
    include_once('Container.php');

    abstract class Persist {
      //  private ?string $filename;
        private ?int $index = null;            
        private static array $nextKey;
        public function save() {
            
            if ( $this->index != null ){             
                $this->edit();
            
            }else{  
                $this->insert(); 
            }                          
        }

        private function insert() {           
            $container = new container(get_called_class()::getFilename());
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
            $objs = $container->getObjects();  
            $matchObjects = array();         
            
            foreach( $objs as $ob) {
                if ( $ob->$p_field == $p_value ){
                    array_push( $matchObjects, $ob );  
                }                  
                                   
            }
             if ( count($matchObjects) > 0 )
                return $matchObjects;
             else
                return null;
        }
        static public function getRecordsByDoubleField( $p_field1, $p_value1, $p_field2, $p_value2 ) {            
            
            $container = new container(get_called_class()::getFilename());
            $objs = $container->getObjects();  
            $matchObjects = array();         
            
            foreach( $objs as $ob) {
                if ( $ob->$p_field1 == $p_value1 &&
                     $ob->$p_field2 == $p_value2){
                    array_push( $matchObjects, $ob );  
                }                  
                                   
            }
            if ( count($matchObjects) > 0 )
                return $matchObjects;
             else
                return null;
        }
       
        static public function getByKey( $index ) {            
 
            if(empty($index))
                return null;

            $container = new container(get_called_class()::getFilename());       
            
            try{
                $obj = $container->getByKey($index);
                return $obj;
            }catch(Exception $e){
                throw($e);
                //return null;
            }
     
        }

        static public function getRecords() {            
                
            $container = new container(get_called_class()::getFilename());
            $objs = $container->getObjects();            
            return $objs;
        }

        public function setIndex( int $index ) {
            $this->index = $index;
            (self::$nextKey)[get_class($this)] = ++$index;
        }
        
        public function getKey(){
            if(func_num_args() == 0){
                return $this->index;
            }else 
            if(func_get_arg(0) == true){
                if(!empty($this->index))
                    return $this->index;
                else{
                    if(empty((self::$nextKey)[get_class($this)]))
                        return 1;
                    else
                        return (self::$nextKey)[get_class($this)];
                }                
            }
        }

        public function update(){
            return self::getByKey($this->getKey());
        }

        public function getVars(): array{
            return get_class_vars(get_class($this));
        }

        abstract static public function getFilename();

    }