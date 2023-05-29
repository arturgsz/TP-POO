<?php
/* Airport.php
 * This is the class for the Airport object.
 */

require_once 'Adress.php';

class Airport
{
    // Attributes
    private string $name;
    private string $sigla;  //possui três letras
    private string $city;
    private string $state;
    private Adress $adress;
  

    // Constructor
    public function __construct(string $name,
                                string $sigla,
                                string $city,
                                string $state,
                                Adress $adress)
    {
      $this->name = $name;
      
      if(Airport::confereSigla($sigla)){
        $sigla = mb_strtoupper($sigla);
        $this->sigla = $sigla;
      }
    
      $this->city = $city;
      $this->state = $state;
      $this->adress = $adress;
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

    public function getCity() : string
    {
        return $this->city;
    }

    public function getState() : string
    {
        return $this->state;
    }

    public function getAdress() : Adress
    {
        return $this->adress;
    }
  
    public function setSigla(string $sigla) :void
    {
      if(Airport::confereSigla($sigla)){
        $sigla = mb_strtoupper($sigla);
        $this->sigla = $sigla;
      }
    }
  
    public function informacoes() : void
    {
      echo ("INFORMAÇÕES DO AERPORTO: {$this->getName()}" . PHP_EOL .
            "Sigla: {$this->getSigla()}" . PHP_EOL .
            "Cidade: {$this->getCity()}" . PHP_EOL .
            "Estado: {$this->getState()}" . PHP_EOL . PHP_EOL);
    }

    // Destructor
    public function __destruct()
    {
        echo "The object Airport {$this->name} was destroyed." . PHP_EOL;
    }
}