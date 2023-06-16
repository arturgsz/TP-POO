<?php
/* MiliageSubprogram.php
 * This is the class for the MiliageProgram object.
 */

 require_once "PersistLogAuthenticate.php";

class MiliageSubprogram extends PersistLogAuthenticate
{
    // Attributes
    protected string $nome_categoria;  
    protected float $pontosmin;
    protected int $miliage_programKey;
    protected $passengersKey = [];
    protected static $local_filename = "MiliageSubprogram.txt";

    // Constructor
    public function __construct(string $nome_categoria, 
                                float $pontosmin,
                                int $miliage_programKey)
    {

        $this->nome_categoria = $nome_categoria;
        $this->pontosmin = $pontosmin;      
        $this->miliage_programKey = $miliage_programKey;
        
        try{
            $this->save(); 
         }catch(Exception $e){
             echo $e->getMessage();
             throw($e);
         }
    }

    public function AddPassenger(int $passengerKey)
    {
      //$passenger_ = Passenger::getByKey($passengerKey);
      if(array_push($this->passengersKey, $passengerKey)){
        Passenger::getByKey($passengerKey)->setMiliageSubprogram($this->getKey());
        $this->save();      
      }

    }

    public function RemovePassenger($passengerKey) : bool
    {
      $passenger_ = Passenger::getByKey($passengerKey);
      //UNSET remove elemento

      unset($this->passengersKey[array_search($passenger_, $this->passengersKey)]);

      //Checa se ainda há aquele passageiro no array
      if(array_search($passenger_, $this->passengersKey) == NULL ) { 
      	$this->save();  
        return true;
      
      }
      return false;
      // unset($this->passengers[array_search($passenger_, $this->passengers)]);
      // unset($this->passengersKey[array_search($passengerKey, $this->passengersKey)]);
      
      // //Checa se ainda há aquele passageiro no array
      // if(array_search($passenger_, $this->passengers) == NULL ) { 
      // 	$this->save();
      //   return true;
      // }
      // else {
      // 	return false;
      // }
      
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
        return $this->passengersKey;
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
