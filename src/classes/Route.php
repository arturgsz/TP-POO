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
  protected $crew_members = []; 
  protected Vehicle $vehicle;
  protected Airport $airport;
  protected array $tempos = [];
  protected DateTime $previsao_decolagem;
  protected DateTime $tempo_inicio_rota;
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
    $this->distanciaTotal();
  
    try{
      $this->save(); 
   }catch(Exception $e){
       echo $e->getMessage();
       throw($e);
   }
  }


  private function distanciaTotal()
  { //velocidade veículos = 18 km/h
    //ultimo a entrar no veiculo é o crew_members[0];
    //distancia (km) + tempo (float horas) do ultimo tripulante a entrar no veiculo:
    $distancia = $this->calculaDistancia($this->crew_members[0]->getAdress()->getLat(),
                                         $this->crew_members[0]->getAdress()->getLong(),
                                         $this->airport->getAdress()->getlat(),                                        
                                         $this->airport->getAdress()->getLong());
    $this->tempos[0] = $distancia / 18;
    
    for($i = 1; $i < sizeof($this->crew_members); $i++){
      $distancia += $this->calculaDistancia($this->crew_members[sizeof($this->crew_members) - 1]->adress->coordenadas[0],
                                            $this->crew_members[sizeof($this->crew_members) - 1]->adress->coordenadas[1],
                                            $this->crew_members[$i]->adress->coordenadas[0],
                                            $this->crew_members[$i]->coordenadas[1]);
      $this->tempos[$i] = $distancia / 18;
    }

   $this->concatenaTempo();
  }

  private function calculaDistancia (float $lat1, float $lon1, float $lat2, float $lon2) : float
  {
    $r = 6371; // Raio médio da Terra em quilômetros
    // Converter graus em radianos
    $lat1 = deg2rad($lat1);
    $lon1 = deg2rad($lon1);
    $lat2 = deg2rad($lat2);
    $lon2 = deg2rad($lon2);
    // Diferença das coordenadas
    $dlat = $lat2 - $lat1;
    $dlon = $lon2 - $lon1;
    // Fórmula de Haversine
    $a = sin($dlat/2) * sin($dlat/2) + cos($lat1) * cos($lat2) * sin($dlon/2) * sin($dlon/2);
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    $distancia = $r * $c;
    return $distancia;
  }

  private function concatenaTempo () : void
  {
    $this->tempos[0] += 1.5;
    //temos os tempos em float (ex: 1,5 = 1 hora e 30 min)
    for($i = 0; $i < sizeof($this->tempos); $i++){
      $tempoTotal = $this->tempos[$i]; //adicionando 90 min para chegar 90 min antes da decolagem
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
    for($i = 0; $i < sizeof($this->crew_members); $i++){
      echo $this->crew_members[$i]->name . " " . $this->crew_members[$i]->surname . " - ".
      date_format($this->tempos[$i], 'H:i:s d-m-Y') . "<br>";
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
  public function getTempos() : array
  {
    return $this->tempos;
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
    // echo "Route has been deleted.";
  }
  static public function getFilename()
  {
      return get_called_class()::$local_filename;
  }
}