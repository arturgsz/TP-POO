<?php
/* Airport.php
 * This is the class for the Airport object.
 */

class Airport
{
    // Attributes
    private string $name;
    private string $sigla;  //possui três letras
    private string $city;
    private string $state;

    // Constructor
    public function __construct(string $name,
                                string $sigla,
                                string $city,
                                string $state)
    {
      $this->name = $name;
      
      if(Airport::confereSigla($sigla)){
        $sigla = mb_strtoupper($sigla);
        $this->sigla = $sigla;
      }
        
      
      $this->city = $city;
      $this->state = $state;
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
    public function getName()
    {
        return $this->name;
    }

    public function getSigla()
    {
        return $this->sigla;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setSigla(string $sigla)
    {
      if(Airport::confereSigla($sigla)){
        $sigla = mb_strtoupper($sigla);
        $this->sigla = $sigla;
      }
    }

    public function setCity(string $city)
    {
        $this->city = $city;
    }

    public function setState(string $state)
    {
        $this->state = $state;
    }

    // Destructor
    public function __destruct()
    {
        echo "The object Airport {$this->name} was destroyed." . PHP_EOL;
    }
}
