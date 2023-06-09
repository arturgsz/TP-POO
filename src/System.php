<?php
use FFI\Exception;
    function autoloader($pClassName) {
        echo __NAMESPACE__;
        $path = __DIR__ . '/classes/' . $pClassName . '.php';
        if (is_file($path)) {
            include_once $path;
        }
        else {
            $path = __DIR__ . '/classes/class.' . $pClassName . '.php';
            if (is_file($path)) {
                include_once $path;
            }
            else
                throw( new Exception('Não foi encontrada a definição da classe '.$pClassName.' na pasta classes.'));
        }
    }

    spl_autoload_register('autoloader');
    
    class System{

        static public function cleanDB(){
            
            if(!UserAuthenticate::Authentication())
                throw(new Exception("Não há usuário logado no sistema"));
            
            $us = "User.txt";
            $path = __DIR__ . '/classes/dataFiles/';
            $usPath = $path.$us;

            if (!is_file($usPath)) {
                throw(new Exception("Arquivo de dados do Usuario nao encontrado"));
            }

            $fileSystemIterator = new FilesystemIterator($path);

            foreach ($fileSystemIterator as $fileInfo){
                $fileName = $fileInfo->getFilename();
                
                if($fileName  == $us){
                    
                    $container = new Container($fileName);
                    $users = $container->getObjects();
                    $newUsers = array();
                    $newUsers[1] = $users[1];

                    $container->loadObjs($newUsers);
                    $container->persist();

                }else{
                    echo $fileName." Limpo com exito!\n";
                    file_put_contents($path.$fileName,"");
                }
                    
            }
            
            echo "\n\nDataBase limpo com exito!\n\n";
        
        }

        static public function update(){

        }
    }

   