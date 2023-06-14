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
    protected $passengersKey = [];
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

    public function AddPassenger(int $passengerKey) : bool
    {
      $passenger_ = Passenger::getByKey($passengerKey);
      if(array_push($this->passengers, $passenger_) and array_push($this->passengersKey, $passengerKey)){
        $this->save();
        return true;
      }
      else {return false;}
    }

    public function RemovePassenger($passengerKey) : bool
    {
      $passenger_ = Passenger::getByKey($passengerKey);
      //UNSET remove elemento
      unset($this->passengers[array_search($passenger_, $this->passengers)]);
      unset($this->passengersKey[array_search($passengerKey, $this->passengersKey)]);
      
      //Checa se ainda há aquele passageiro no array
      if(array_search($passenger_, $this->passengers) == NULL ) { 
      	$this->save();
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

    public function getPassengersKey() : array
    {
        return $this->passengersKey;
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
