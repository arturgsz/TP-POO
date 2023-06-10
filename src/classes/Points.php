<?php
/* Point.php
 * This is the class for the Vehicle object.
 */
require_once "Persist.php";

class Points extends Persist
{
    // Attributes

    private $pontos = [];
    private $dataspontos = [];
    private $pontostotais = 0;

    protected static $local_filename = "Points.txt";       
    //QUANDO FOR PERCORRER O ARRAY DE PONTOS E DATETIMES, SEMPRE USAR O FOREACH
  
    // Constructor
    public function __construct(float $pontos, DateTime $dataponto) 
    {
      array_push($this->pontos, $pontos);
      array_push($this->dataspontos, $dataponto);
    
      try{
        $this->save(); 
     }catch(Exception $e){
         echo $e->getMessage();
         throw($e);
     }
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
      $this->RemovePontos();
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
        return $this->dataspontos;
    }

    // Destructor
    public function __destruct()
    {
      //  echo "The Points class was destroyed.";
    }
    static public function getFilename()
    {
        return get_called_class()::$local_filename;
    }
}
