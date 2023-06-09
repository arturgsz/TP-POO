<?php
/* Route.php
 * This is the class for the Route object.
 */

//require_once 'Airport.php';
require_once 'Vehicle.php';
require_once 'Crew.php';
//require_once 'PersistLogAuthenticate.php';

class Route extends PersistLogAuthenticate
{
  protected $crew_members = []; 
  protected int $vehicleKey;
  protected int $airportKey;
  protected array $tempos = [];
  protected DateTime $previsao_decolagem;
  protected float $chegada_aeroporto;
  protected static $local_filename = "Route.txt";
       

  
  public function __construct(array $crew_membersKey,
                              Airport $airport,
                              Vehicle $vehicle,
                              DateTime $previsao_decolagem)
  {
    foreach($crew_membersKey as $crew_memberKey){
      array_push($this->crew_members, Crew::getByKey($crew_memberKey));
    }
    $this->airportKey = $airport->getKey();
    $this->vehicleKey = $vehicle->getKey();
    $this->previsao_decolagem = $previsao_decolagem;
    $this->distanciaTotal();
  
    try{
      $this->save(); 
   }catch(Exception $e){
       echo $e->getMessage();
       throw($e);
   }
  }


  public function distanciaTotal()
  { //velocidade veículos = 18 km/h
    //ultimo a entrar no veiculo é o crew_members[0];
    //distancia (km) + tempo (float horas) do ultimo tripulante a entrar no veiculo:
    $distancia = $this->calculaDistancia($this->crew_members[0]->getAdress()->getLat(),
                                         $this->crew_members[0]->getAdress()->getLong(),
                                         Airport::getByKey($this->airportKey)->getAdress()->getLat(),                                        
                                         Airport::getByKey($this->airportKey)->getAdress()->getLong());
    $this->tempos[0] = $distancia / 18;
    $this->chegada_aeroporto = $this->tempos[0];
    


    for($i = 1; $i < sizeof($this->crew_members); $i++){
      $distancia = $this->calculaDistancia($this->crew_members[$i-1]->getAdress()->getLat(),
                                            $this->crew_members[$i-1]->getAdress()->getLong(),
                                            $this->crew_members[$i]->getAdress()->getLat(),
                                            $this->crew_members[$i]->getAdress()->getLong());
      $this->tempos[$i] = $distancia / 18;
      try{
        $this->save(); 
     }catch(Exception $e){
         echo $e->getMessage();
         throw($e);
     }
    }
  }

  private function calculaDistancia (float $lat1, float $lon1, float $lat2, float $lon2) : float
  {
    $distancia = 0;
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
      $tempoTotal = $this->tempos[$i]; 
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

      echo $this->crew_members[$i]->getName() . " " . $this->crew_members[$i]->getSurname() . " - ".
      date_format($this->tempos[$i], 'H:i:s d-m-Y') . "\n";

      try{
        $this->save(); 
     }catch(Exception $e){
         echo $e->getMessage();
         throw($e);
     }
    }

  }

  //Descrição da Rota
  public function descricaoRota() : void
  {
    echo "Horario Voo - " . date_format($this->previsao_decolagem, 'H:i:s d-m-Y') . "\n";
    $this->concatenaTempo();

    // for($i = 0; $i < sizeof($this->crew_members); $i++){
    //   echo $this->crew_members[$i]->getName() . " " . $this->crew_members[$i]->getSurname() . " - ".
    //   date_format($this->tempos[$i], 'H:i:s d-m-Y') . "\n";
      
      
    //   // echo $this->crew_members[$i]->name . " " . $this->crew_members[$i]->surname . " - " .
    //   //      date_format($this->tempos[$i], 'H:i:s d-m-Y') . "<br>";
    // }
  }

 // Setters and Getters
  public function getVehicle() : Vehicle
  {
    return Vehicle::getByKey($this->vehicleKey);
  }    
  public function getAirport() : Airport
  {
    return Airport::getByKey($this->airportKey);
  }  

  public function getTempos() : array
  {
    return $this->tempos;
  }  

  public function setAirport(Airport $airport) : void
  {
    $this->airportKey = $airport->getKey();
  }    
  public function setVehicle(Vehicle $vehicle) : void
  {
    $this->vehicleKey = $vehicle->getKey();
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