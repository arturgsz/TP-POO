<?php
/*
* FlightCompany.php
* This is the class for the Flight Company object.
*/

require_once 'Persist.php';

class FlightCompany extends Persist 
{
  private string $name;
  private string $code;
  private string $razao_social;
  private string $cnpj;
  private string $sigla;  //a sigla deve ser formada por duas letras
  //valor unitário da bagagem é definido por cada companhia aerea
  private float $luggadge; //bagagem
  private $flight_lines = [];
  private MiliageProgram $miliage_program;
  private $tripulation = [];
  protected static $local_filename = "FlightCompany.txt";
       

  public function __construct(string $name, 
                              string $code, 
                              string $razao_social, 
                              string $cnpj, 
                              string $sigla,
                              float $luggadge)
  {
    $this->name = $name;
    $this->code = $code;
    $this->razao_social = $razao_social;
      
    if(FlightCompany::confereSigla($sigla)){
      $sigla = mb_strtoupper($sigla);
      $this->sigla = $sigla;
    }     
    $this->cnpj = $cnpj;
    $this->luggadge = $luggadge;

    $this->save();
  }
        
  //conferir sigla da companhia area
  private function confereSigla(string $sigla) : bool
  {
    if( (mb_strlen($sigla) == 2) && gettype($sigla) =='string')
      return true;
    else {
      //tratar a Sigla da Companhia Áerea
      echo "Sigla invalida" . PHP_EOL;
      return false;
    }
  }

  public function NewLine () : FlightLines
  {
    //implementar
  }

  public function NewMiliage_program (string $nome, array $nome_categorias, array $pontosmin) : bool
  {
    $miliage_program = new MiliageProgram ($nome);    
  }

  public function AddCategoria (string $nome, string $nome_categorias, int $pontosmin) : bool
  {
    $this->miliage_program->AddCategoria($nome, $nome_categorias, $pontosmin);
  }

  public function NewCrew_member () : bool
  {
    //implementar
  }
  
  
  // Getters and Setters
  public function getName() : string
  {
    return $this->name;
  }

  public function getCode() : string
  {
    return $this->code;
  }

  public function getRazaoSocial() : string
  {
    return $this->razao_social;
  }

  public function getCnpj() : string
  {
    return $this->cnpj;
  }

  public function getSigla() : string
  {
    return $this->sigla;
  }

  public function getLuggadge() : float
  {
    return $this->luggadge;
  }

  public function getFlightLines() : array
  {
    return $this->flight_lines;
  }

  public function getMiliageProgram() : MiliageProgram
  {
    return $this->miliage_program;
  }

  public function getTripulation() : array
  {
    return $this->tripulation;
  }
  
  public function setName(string $name) : void
  {
    $this->name = $name;
  }

  public function setCode(string $code) : void
  {
    $this->code = $code;
  }

  public function setRazaoSocial(string $razao_social) : void
  {
    $this->razao_social = $razao_social;
  }

  public function setCnpj(string $cnpj) : void
  {
    $this->cnpj = $cnpj;
  }

  public function setSigla(string $sigla) : void
  {
    if(FlightCompany::confereSigla($sigla)){
      $sigla = mb_strtoupper($sigla);
      $this->sigla = $sigla;
    }
  }

  public function setLuggadge(float $luggadge) : void
  {
    $this->luggadge = $luggadge;
  }

  public function setFlightLines(array $flight_lines) : void
  {
    $this->flight_lines = $flight_lines;
  }

  public function setMiliageProgram(MiliageProgram $miliage_program) : void
  {
    $this->miliage_program = $miliage_program;
  }

  public function setTripulation(array $tripulation) : void
  {
    $this->tripulation = $tripulation;
  }

  // Destructor
  public function __destruct()
  {
    echo "The object {$this->name} was destroyed." . PHP_EOL;
  }
  static public function getFilename()
  {
      return get_called_class()::$local_filename;
  }
}

