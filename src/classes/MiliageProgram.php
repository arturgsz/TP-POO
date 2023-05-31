<?php
/* MiliageProgram.php
 * This is the class for the MiliageProgram object.
 */

require_once 'MiliageSubprogram.php';
require_once "Passenger.php";

class MiliageProgram extends Persist
{
    // Attributes
    private $nome;
    private array $sub_categorias;
    
    
    protected static $local_filename = "MiliageProgram.txt";
       
    // Constructor
    public function __construct(string $nome)
    {
      $this->nome = $nome;
      $this->sub_categorias = [];

      $this->save();
      }


    public function AddCategoria (string $nome_categoria, int $pontosmin) : bool
    {
      $a1 = $this->sub_categorias;
	    $a2 = array($nome_categoria => $pontosmin);
	    $this->sub_categorias = (array_merge($a1,$a2));
      asort($this->sub_categorias);
    }
  

  
		public function UpdateSubProgramTiers(){

      foreach($subprogram as $this->sub_categorias){
					
          foreach($passenger as $subprogram->getpassengers()){
							$passenger_miliage = $passenger->getMiliage();

                foreach($sub as $this->sub_categorias){

                 if( $sub->getPontosMin() < $passenger_miliage){
                      $subprogram->removePassenger($passanger);
                      $sub->AddPassenger($passenger);
                  }
                }
          }           
		  }	
    }

      
      for($i = 0; $i< sizeof($this->$sub_categorias); $i++){
        $passangers_=$this->sub_categorias[i]->getPassangers();
					
          for ($j= 0; $j < sizeof($passangers_); $j++){
							$miliage_passanger = passangers_[$j]->getMiliage();
                
                for($k=0; $k<sizeof($this->$sub_categorias); $k++){
                  if($miliage_passanger > 
								$this->$sub_categorias[$k]->getpontosmin() && $miliage_passanger < 
								$this->$sub_categorias[$k+1]->getpontosmin() ){
               
                }
                } 
					}
			}			
		}

	
    public function downgrade(Passanger $passgenger) : bool
    {
      //implementar  
      return true;
    }
    
    public function upgrade(Passanger $passgenger) : bool
    {
      //implementar
      
      return true;
    }
	

      // Getters and Setters
    public function getName() : string
    {
        return $this->name;
    }

  
    // Destructor
    public function __destruct()
    {
        echo "The MiliageProgram {$this->name} was destroyed.";
    }
    static public function getFilename()
    {
        return get_called_class()::$local_filename;
    }
  }
