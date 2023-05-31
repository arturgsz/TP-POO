<?php
/* Route.php
 * This is the class for the Route object.
 */

require_once 'Airport.php';
require_once 'Vehicle.php';
require_once 'Crew.php';
require_once 'Persist.php';

class Route extends Persist
{
  private $crew_members = []; 
  private Vehicle $vehicle;
  private Airport $airport;
  private array $tempos = [];
  private DateTime $previsao_decolagem;
  private DateTime $tempo_inicio_rota;
  protected static $local_filename = "Route.txt";
       

  
  public function __construct(array $crew_members,
                              Airport $airport,
                              Vehicle $vehicle,
                              DateTime $previsao_decolagem)
  {
    $this->crew_members = $crew_members;
    $this->airport = $airport;
    $this->vehicle = $vehicle;
    $this->previsao_decolagem = $previsao_decolagem;
  
    $this->save();
  }


  private function distanciaTotal() : float
  { //velocidade veículos = 18 km/h
    //ultimo a entrar no veiculo é o crew_members[0];
    //distancia (km) + tempo (float horas) do ultimo tripulante a entrar no veiculo:
    $distancia = $this->calculaDistancia($this->crew_members[0]->adress->coordenadas[0],
                                         $this->crew_members[0]->adress->coordenadas[1],
                                         $this->airport->adress->coordenadas[0],                                        
                                         $this->airport->adress->coordenadas[1]);
    $this->tempos[0] = $distancia / 18;
    
    for($i = 1; $i < sizeof($this->crew_members); i++){
      $distancia += $this->calculaDistancia($this->crew_members[sizeof($this->crew_members) - 1]->adress->coordenadas[0],
                                            $this->crew_members[sizeof($this->crew_members) - 1]->adress->coordenadas[1],
                                            $this->crew_members[$i]->adress->coordenadas[0],
                                            $this->crew_members[$i]->coordenadas[1]);
      $this->tempos[$i] = $distancia / 18;
    }

   $this->concatenaTempo();
  }

  private function calculaDistancia (float $x1, float $y1, float $x2, float $y2) : float
  {
    return 110.57 * sqrt( pow($x2-$x1,2) + pow($y2-$y1, 2) );
  }

  private function concatenaTempo () : void
  {
    //temos os tempos em float (ex: 1,5 = 1 hora e 30 min)
    for($i = 0; $i < sizeof($tempos); $i++){
      $tempoTotal = $this->tempos[$i] + 1,5; //adicionando 90 min para chegar 90 min antes da decolagem
      $h = intval($tempoTotal);
      if((($tempoTotal - $h)*60) > intval(($tempoTotal - $h)*60)){ 
        $min = intval(($tempoTotal - $h)*60 + 1);
      } //se der minuto + segs -> passa p/ prox minuto     
      else { 
        $min = ($tempoTotal - $h)*60; 
      }
      
      //mudando o array de tempos que era float (tempo em horas antes da decolagem) p/ datetime (date e hora normais)
      $t = 'PT'. $h . 'H' . $min . 'M';
      $this->tempos[$i] = $this->previsao_decolagem->sub(new DateInterval($t));
    }
  }

  //Descrição da Rota
  public function descricaoRota() : void
  {
    for($i = 0; $i < sizeof($crew_members); $i++){
      echo $this->crew_members[$i]->name . " " . $this->crew_members[$i]->surname . " - "
           $this->tempos[$i] . "<br>";
    }

  }

 // Setters and Getters
  public function getVehicle() : Vehicle
  {
    return $this->vehicle;
  }    
  public function getAirport() : Airport
  {
    return $this->airport;
  }  
  public function getTempo() : float
  {
    return $this->tempo;
  }  
  public function getDistancia() : float
  {
    return $this->calculaDistancia();
  }  
  public function setAirport(Airport $airport) : void
  {
    $this->airport = $airport;
  }    
  public function setVehicle(Vehicle $vehicle) : void
  {
    $this->vehicle = $vehicle;
  }  
  public function setCrew_members(array $crew_members) : void
  {
    $this->crew_members = $crew_members;
  }

  
  // Destructor
  public function __destruct()
  {
     echo "Route has been deleted.";
  }
  static public function getFilename()
  {
      return get_called_class()::$local_filename;
  }
}