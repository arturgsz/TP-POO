<?php
/* Airport.php
 * This is the class for the Airport object.
 */

require_once 'Adress.php';
require_once 'Persist.php';
require_once "User.php";

class Airport extends User
{
    // Attributes
    protected string $name;
    protected string $sigla;  //possui três letras
    protected int $adressKey;
    protected int $myUserKey;
    protected static $local_filename = "Airport.txt";
       
    // Constructor
    public function __construct(string $name,
                                string $sigla,
                                Adress $adress,
                                string $login,
                                string $email,
                                string $password)
    {
      $this->name = $name;
      
      if(Airport::confereSigla($sigla)){
        $sigla = mb_strtoupper($sigla);
        $this->sigla = $sigla;
      }

      $this->adressKey = $adress->getKey();
      
      try{
        $MyUser = new User($login, $email, $password);
        $MyUser->setUserType(get_called_class());
        $this->myUserKey = $MyUser->getKey();

      }catch( Exception $e){
        echo $e->getMessage();
        throw($e);
      } 
      
      try{
        $this->save(); 
      }catch(Exception $e){
         echo $e->getMessage();
         throw($e);
      }
    }

    //função para verificar a sigla dos aeroportos
    private function confereSigla($sigla) : bool
    {
      if( (mb_strlen($sigla)) == 3 && ((gettype($sigla)) == 'string'))
        return true;
      
      else {
        // chamar uma função de tratamento para a sigla
        echo "Sigla inválida para Airport" . PHP_EOL;
        return false;
                
      }
    }

    // Getters and Setters
    public function getName() : string
    {
        return $this->name;
    }

    public function getSigla() : string
    {
        return $this->sigla;
    }

    public function getAdress() : Adress
    {   $class = Adress::getByKey($this->adressKey);
        return $class;
    }
  
    public function setSigla(string $sigla) :void
    {
      if(Airport::confereSigla($sigla)){
        $sigla = mb_strtoupper($sigla);
        $this->sigla = $sigla;
      }
      $this->save();
    }
  
    public function informacoes() : void
    {
      $ad = Adress::getByKey($this->adressKey);

      echo ("INFORMAÇÕES DO AERPORTO: {$this->getName()}" . PHP_EOL .
            "Sigla: {$this->getSigla()}" . PHP_EOL .
            "Cidade: {$this->$ad->getCidade()}" . PHP_EOL .
            "Estado: {$this->$ad->getEstado()}" . PHP_EOL . PHP_EOL);
    }

    // Destructor
    public function __destruct()
    {
        //echo "The object Airport {$this->name} was destroyed." . PHP_EOL;
    }
static public function getFilename()
    {
        return get_called_class()::$local_filename;
    }
  }