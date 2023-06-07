<?php
/* Point.php
 * This is the class for the Vehicle object.
 */

class Points extends Persist
{
    // Attributes

    private $pontos = [];
    private $dataspontos = [];
    private $pontostotais = 0;

       
    //QUANDO FOR PERCORRER O ARRAY DE PONTOS E DATETIMES, SEMPRE USAR O FOREACH
  
    // Constructor
    public function __construct(float $pontos, DateTime $dataponto) 
    {
      array_push($this->pontos, $pontos);
      array_push($this->dataspontos, $dataponto);
    
      $this->save();
    }

    public function AddPontos(float $pontos, DateTime $dataponto)
    {
      array_push($this->pontos, $pontos);
      array_push($this->dataspontos, $dataponto);
    }

    public function RemovePontos()
    {
      $hoje = new DateTime();
      foreach ($this->pontos as $i => $v) {
        $intervalo = $this->dataspontos[$i]->diff($hoje);
        if(intval($intervalo->format('%Y')) >= 1){
        	unset($this->pontos[$i]);
          unset($this->dataspontos[$i]);
        }
      }
      
    }

    public function getPontos_acumulados() : float
    {
      $this->pontostotais = 0;
     foreach ($this->pontos as $p)
       {
         $this->pontostotais += $p;
       }
      return $this->pontostotais;
    }


    // Getters and Setters
    public function getPontos() : array
    {
        $this->RemovePontos();
        return $this->pontos;
    }
    public function getDatapontos() : array
    {
        $this->RemovePontos();
        return $this->datapontos;
    }

    // Destructor
    public function __destruct()
    {
        echo "The Points class was destroyed.";
    }
    static public function getFilename()
    {
        return get_called_class()::$local_filename;
    }
}
