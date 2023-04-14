<?php
/*
* FlightCompany.php
* This is the class for the Flight Company object.
*/

class FlightCompany
{
  private string $name;
  private string $code;
  private string $razao_social;
  private string $cnpj;
  private string $sigla;  //a sigla deve ser formada por duas letras
  
  public function __construct(string $name, 
                              string $code, 
                              string $razao_social, 
                              string $cnpj, 
                              string $sigla)
  {
    $this->name = $name;
    $this->code = $code;
    $this->razao_social = $razao_social;
      
    if(FlightCompany::confereSigla($sigla)){
      $sigla = mb_strtoupper($sigla);
      $this->sigla = $sigla;
    }     
    $this->cnpj = $cnpj;
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

  // Destructor
  public function __destruct()
  {
    echo "The object {$this->name} was destroyed." . PHP_EOL;
  }
}

