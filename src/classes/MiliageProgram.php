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
      $subProgram = new MiliageSubprogram ($nome_categoria, $pontosmin);
      array_push($this->sub_categorias, $subProgram);
      $this->UpdateSubProgramTiers();
    }

    public function UpdateSubProgramTiers() {
      foreach($this->sub_categorias as $subcat){
        foreach($subcat->getPassengersKey() as $passengerKey){
          $subcat->RemovePassenger($passengerKey);
          $verif = false;
          $indice_sub = 0;
          for($i=0; $i < sizeof($this->sub_categorias); $i++){
            if((Passenger::getByKey($passengerKey))->getPoints() >= $this->sub_categorias[$i]->getPontos_minimos()){
              if($verif == true){$this->sub_categorias[$indice_sub]->RemovePassenger($passengerKey);}
              $this->sub_categorias[$i]->AddPassenger($passengerKey);
              $verif = true;
              $indice_sub = $i;
            }
          }
        }
      }
      $this->save();
    }
  
  // public function UpdateSubProgramTiers() {
  //   for ($i = 0; $i < sizeof($this->sub_categorias); $i++) {
        
  //     $passengers = $this->sub_categorias[$i]->getPassengers();

  //       for ($j = 0; $j < sizeof($passengers); $j++) {
  //           $passenger_miliage = $passengers[$j]->getMiliageProgram();
          
  //             for($k = 0; $k < sizeof($this->sub_categorias); $k++){
  //                 $pontosmin_sub = $this->sub_categorias[$k]->getPontos_minimos();

  //               if ($passenger_miliage >= $this->sub_categorias[$k]->getPontos_minimos() && 
  //                   $passenger_miliage < $this->sub_categorias[$k + 1]->getPontos_minimos()) {
  //                   // fica na atual
  //                 }
  //               if($passenger_miliage < $this->sub_categorias[$k]->getPontos_minimos()){
  //                   // volta para a anterior
  //                   $this->sub_categorias[$k]->RemovePassenger($passengers[$j]);
  //                   $this->sub_categorias[$k-1]->AddPassenger($passengers[$j]);
  //                 }
  //               if($passenger_miliage >= $this->sub_categorias[$k+1]->getPontosMin()){
  //                   // vai para a próxima
  //                   $this->sub_categorias[$k]->RemovePassenger($passengers[$j]);
  //                   $this->sub_categorias[$k+1]->AddPassenger($passengers[$j]);
  //                 }
  //           }
  //       }
  //   }
  // }


  public function showSubCategorias() {
    $this->UpdateSubProgramTiers();

    echo "\nSubcategorias de " . $this->nome ." :";
    for($i = 0; $i < sizeof($this->sub_categorias); $i++)
    {
      echo "\n[".$i."] " . $this->sub_categorias[$i]->getName() . " - Pontos Mínimos: "
      . $this->sub_categorias[$i]->getPontos_minimos();

      if(sizeof($this->sub_categorias[$i]->getPassengersKey())){echo "\nPassageiros: ";}
      else{echo "\nSem Passageiros.\n";}
      foreach($this->sub_categorias[$i]->getPassengersKey() as $passengerKey)
      {
        echo "\n   - " . (Passenger::getByKey($passengerKey))->getName() . " " . (Passenger::getByKey($passengerKey))->getSurname() . 
              " - registro: " . (Passenger::getByKey($passengerKey))->getRegister_number() . "\n";
      }
    } echo "\n\n";
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
      $this->UpdateSubProgramTiers();
      return $this->sub_categorias;
    }

    public function getSubCategoria(int $i) : MiliageSubprogram {
      $this->UpdateSubProgramTiers();
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
