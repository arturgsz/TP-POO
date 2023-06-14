<?php
/* MiliageProgram.php
 * This is the class for the MiliageProgram object.
 */
require_once "FlightCompany.php";
require_once 'MiliageSubprogram.php';
require_once "Passenger.php";
require_once "Persist.php";

class MiliageProgram extends Persist
{
    // Attributes
    protected $nome;
    protected array $sub_categorias;
    protected int $companyKey;
    
    protected static $local_filename = "MiliageProgram.txt";
       
    // Constructor
    public function __construct(string $nome, int $companyKey)
    {
      $this->companyKey = $companyKey;
      $this->nome = $nome;
      $this->sub_categorias = [];

      try{
        $this->save(); 
      }catch(Exception $e){
         echo $e->getMessage();
         throw($e);
      }

    }

    // public function AddCategoria (MiliageSubprogram $subprogram) : void
    // {
    //   array_push($this->sub_categorias, $subprogram);
      
    // }
  

    public function AddCategoria (string $nome_categoria, int $pontosmin) 
    {
      $subProgram = new MiliageSubprogram ($nome_categoria, $pontosmin, $this->getKey());
      // $a1 = $this->sub_categorias;
	    // //$a2 = array($nome_categoria => $pontosmin);
      // $a2 = array($subProgram);
	    // $this->sub_categorias = (array_merge($a1,$a2));
      array_push($this->sub_categorias, $subProgram->getKey());
      asort($this->sub_categorias);

      $this->save();
    }
  
    public function addPassanger(Passenger $passanger){
        
        $passangerKey = $passanger->getKey();
        (MiliageSubprogram::getByKey($this->sub_categorias[0]))->AddPassenger($passangerKey);
        Passenger::getByKey($passangerKey)->Vip();
      
      }

		//public function UpdateSubProgramTiers(){

  //     foreach($subprogram as $this->sub_categorias){
					
  //         foreach($passenger as $subprogram->getpassengers()){
		// 					$passenger_miliage = $passenger->getMiliage();

  //               foreach($sub as $this->sub_categorias){

  //                if( $sub->getPontosMin() < $passenger_miliage){
  //                     $subprogram->removePassenger($passanger);
  //                     $sub->AddPassenger($passenger);
  //                 }
  //               }
  //         }           
	//   }	
  //   }		

  //$this->sub_categorias[$k]->AddPassenger($passenger);
  public function UpdateSubProgramTiers() {
    for ($i = 0; $i < sizeof($this->sub_categorias); $i++) {
        
      $passengers = $this->sub_categorias[$i]->getPassengers();

        for ($j = 0; $j < sizeof($passengers); $j++) {
            $passenger_miliage = $passengers[$j]->getMiliageProgram();
          
              for($k = 0; $k < sizeof($this->sub_categorias); $k++){
                  $pontosmin_sub = $this->sub_categorias[$k]->getPontos_minimos();

                if ($passenger_miliage >= $this->sub_categorias[$k]->getPontos_minimos() && 
                    $passenger_miliage < $this->sub_categorias[$k + 1]->getPontos_minimos()) {
                    // fica na atual
                  }
                if($passenger_miliage < $this->sub_categorias[$k]->getPontos_minimos()){
                    // volta para a anterior
                    $this->sub_categorias[$k]->RemovePassenger($passengers[$j]);
                    $this->sub_categorias[$k-1]->AddPassenger($passengers[$j]);
                  }
                if($passenger_miliage >= $this->sub_categorias[$k+1]->getPontosMin()){
                    // vai para a próxima
                    $this->sub_categorias[$k]->RemovePassenger($passengers[$j]);
                    $this->sub_categorias[$k+1]->AddPassenger($passengers[$j]);
                  }
            }
        }
    }
  }
  public function showSubCategorias() {
    echo "SubCategorias de " . $this->nome ." : \n";
    for($i = 0; $i < sizeof($this->sub_categorias); $i++)
    {
      echo "[".$i."] " . $this->sub_categorias[$i]->getName() . " - Pontos Mínimos: "
      . $this->sub_categorias[$i]->getPontos_minimos() . "\n";
    }
  }
  
  // Getters and Setters
    public function getName() : string
    {
        return $this->nome;
    }

    public function getCompanyKey(){
      return $this->companyKey;
    }

    public function getArraySubCategorias() : array {
      return $this->sub_categorias;
    }

    public function getSubCategoria(int $i) : MiliageSubprogram {
      return $this->sub_categorias[$i];
    }
  
    // Destructor
    public function __destruct()
    {
       // echo "The MiliageProgram {$this->name} was destroyed.";
    }
    static public function getFilename()
    {
        return get_called_class()::$local_filename;
    }

  }
