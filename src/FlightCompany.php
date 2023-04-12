<?php
/*
* FlightCompany.php
* This is the class for the Flight Company object.
*/

require_once 'FlightLines.php';

class FlightCompany
{
  private string $name;
  private string $code;
  private string $razao_social;
  private string $cnpj;
  private string $sigla;  //a sigla deve ser formada por duas letras
  private FlightLines $arrayObjetos;

    
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

  //função que adiciona objetos FlightLines na classe FlightCompany
  public function adicionaFlightLines(FlightLines $line) : array
  {
    $arrayObjetos[] = $line;
    return $arrayObjetos;
  }
  
  // Getters and Setters
  public function getName()
  {
    return $this->name;
  }

  public function getCode()
  {
    return $this->code;
  }

  public function getRazaoSocial()
  {
    return $this->razao_social;
  }

  public function getCnpj()
  {
    return $this->cnpj;
  }

  public function getSigla()
  {
    return $this->sigla;
  }

  public function setName(string $name)
  {
    $this->name = $name;
  }

  public function setCode(string $code)
  {
    $this->code = $code;
  }

  public function setRazaoSocial(string $razao_social)
  {
    $this->razao_social = $razao_social;
  }

  public function setCnpj(string $cnpj)
  {
    $this->cnpj = $cnpj;
  }

  public function setSigla(string $sigla)
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
