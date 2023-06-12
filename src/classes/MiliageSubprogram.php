<?php
/* MiliageSubprogram.php
 * This is the class for the MiliageProgram object.
 */

 require_once "Persist.php";

class MiliageSubprogram extends Persist
{
    // Attributes
    protected string $nome_categoria;  
    protected float $pontosmin;
    protected int $miliage_programKey;
    protected $passengers = [];
    protected static $local_filename = "MiliageSubprogram.txt";

    // Constructor
    public function __construct(string $nome_categoria, 
                                float $pontosmin)
    {

        $this->nome_categoria = $nome_categoria;
        $this->pontosmin = $pontosmin;      
    
        try{
            $this->save(); 
         }catch(Exception $e){
             echo $e->getMessage();
             throw($e);
         }
    }

    public function AddPassenger(Passenger $passenger) : bool
    {
      $passengerKey = $passenger->getKey();
      $passenger_ = Airport::getByKey($passengerKey);
      if(array_push($this->passengers, $passenger_)){
        return true;
      }
      else {return false;}
    }

    public function RemovePassenger($passenger) : bool
    {
      $passengerKey = $passenger->getKey();
      $passenger_ = Airport::getByKey($passengerKey);
      //UNSET remove elemento
      unset($this->passengers[array_search($passenger_, $this->passengers)]);

      //Checa se ainda há aquele passageiro no array
      if(array_search($passenger_, $this->passengers) == NULL ) { 
      	return true;
      }
      else {
      	return false;
      }

    }

    // Getters and Setters
    public function getName() : string
    {
        return $this->nome_categoria;
    }
    public function getMiliageProgram()
    {
        return MiliageProgram::getByKey($this->miliage_programKey);
    }  
  
    public function getPontos_minimos() : float
    {
        return $this->pontosmin;
    }
    public function getPassengers() : array
    {
        return $this->passengers;
    }
  
    // Destructor
    public function __destruct()
    {
      //  echo "The MiliagesubProgram {$this->nome_categoria} was destroyed.";
    }
       
    static public function getFilename()
    {
        return get_called_class()::$local_filename;
    }
}
