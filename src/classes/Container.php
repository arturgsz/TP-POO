<?php
    #[AllowDynamicProperties]
    //namespace Persist;
    class Container {
        private string $folder = 'dataFiles';
        private string $filename;
        private ?array $objects;
        static private $ptr_container = null;
        static private $criticalSection = false;

        public function __construct() {        
            if (func_num_args()==1) {
                //$this->filename = func_get_arg(0);
                $this->setFilename(func_get_arg(0));
                $this->objects = array();	
                $this->load();			
			} 
            else if ( func_num_args()==0 ) {    
                $this->filename = 'testFile.txt';
            }
			else {
				throw( new Exception('Eror ao instanciar objeto da classe Container - Número de parâmetros incorreto.'));
            }
            self::$criticalSection = true;
        }

        public function __destruct() {
            self::$criticalSection = false;
        }

        static function getInstance( string $filename ) {  
            while ( self::$criticalSection )
                sleep(1);        
            if ( self::$ptr_container == null )
                self::$ptr_container = new container($filename);
            else
            self::$ptr_container->setFilename($filename);
            return self::$ptr_container;
        }

        public function setFilename(string $filename) {
            $this->filename = __DIR__ . '/'.$this->folder.'/' .$filename;
        }

        public function addObject( $p_obj ) {
            
         $key = intval(array_key_last($this->objects)) + 1;
              
            $this->objects[$key] = $p_obj; 
            $this->objects[$key]->setIndex($key);

        }

        public function editObject( $p_index, $p_obj ) {
            $this->objects[$p_index] = $p_obj;
        }

        // Deletes an object from objects array
        public function deleteObject( $p_index ) {
            unset($this->objects[$p_index]);

        }

        public function getObjects () {
            $this->load();			
            return $this->objects;
        }
        public function getByKey ($key) {
            $this->load();			
            
            if(!empty( $this->objects[$key]))
                return $this->objects[$key];
           
            else
            throw(new Exception("O objeto procurado não existe ou foi deletado\n"));

        }

        public function load() {
            if (is_file($this->filename)) {
                $dados = file_get_contents($this->filename);
                if ( $dados <> '' ) {
                    $jogador = unserialize($dados);
                    $this->objects = $jogador->objects;
                    //print_r($jogador); exit();
                }            
            }
            else
            $this->objects = array();
        }

        public function persist() { 
                            
            $serialized = serialize($this);
            file_put_contents( $this->filename, $serialized );   
        }

        /* get's e set's aqui */
        public function __sleep(){
            return array(
                "filename", "objects"
            );
        }
        public function __wakeup(){
            
        }

       
    }