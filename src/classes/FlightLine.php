<?php
/* FlightLines.php
 * This is the class for the Flight Lines object.
 */

require_once 'Airport.php';
require_once 'Airplane.php';
require_once 'Flight.php';
//require_once 'PersistLogAuthenticate.php';
date_default_timezone_set("America/Sao_Paulo");

class FlightLine extends PersistLogAuthenticate
{
  protected int $airportOriginKey; 
  protected int $airportDestinyKey;
  protected DateTime $expected_departure_time;
  protected DateTime $expected_arrival_time;
  protected DateInterval $duracao_estimada;
  protected int $airplaneKey; 
  protected int $flightCompanyKey;
  //protected string $code; //código da linha de voo
  protected bool $operational;
  protected $frequency = [];  //frequencia do voo
  protected float $line_price;
  protected float $lugadge_price; //valor unitario da bagagem
  protected float $cancelationFine;
  protected float $flightMiliage;
  protected string $codigo_voo;
  protected array $flightsKey;  //array de objetos do tipo Travel
  protected static $local_filename = "FlightLine.txt";
       

   public function __construct(string $codigo_voo,
                              Airport $origin,
                              Airport $destiny,
                              DateTime $expected_departure_time,
                              DateTime $expected_arrival_time,
                              Airplane $airplane,
                              FlightCompany $company,
                              bool $operational,
                              array $frequency,
                              float $line_price,
                              float $lugadge_price,
                              float $cancelationFine)
  {
    if(FlightLine::getRecordsByField("codigo_voo",$codigo_voo) != null)
      throw(new Exception("Já existe uma linha aérea com o código cadastrado\n"));

    $this->codigo_voo = $codigo_voo;
    $this->airportOriginKey = $origin->getKey();
    $this->airportDestinyKey = $destiny->getKey();
    $this->expected_departure_time = $expected_departure_time;
    $this->expected_arrival_time = $expected_arrival_time;
    $this->cancelationFine = $cancelationFine;
    $this->flightCompanyKey = $company->getKey();
    $this->airplaneKey = $airplane->getKey();
    $this->duracao_estimada = self::duracaoVoo($expected_departure_time,$expected_arrival_time);
    $this->operational = $operational;
    $this->frequency = $frequency;
    $this->line_price = $line_price;
    $this->lugadge_price = $lugadge_price;
    $this->flightMiliage = $this->calcMiliage();

    try{
      $this->checkCodigo_voo(); 
    }catch(Exception $e){
      echo $e->getMessage() . "\n";
    }

    if($this->operational){
      $this->buildNextFlights();
   
    try{
    $this->save(); 
   }catch(Exception $e){
     echo $e->getMessage();
     throw($e);
   }

  }
}
  public function checkCodigo_voo (){
    $letra1 = $this->codigo_voo[0]; $letra2 = $this->codigo_voo[1];
    $sigla = $letra1 . $letra2;
    $FlightCompanySigla = (FlightCompany::getByKey($this->flightCompanyKey))->getSigla();
    if($sigla != $FlightCompanySigla){
            throw(new Exception("Código de Linha Aérea inválido."));
    }
    }
 public function buildNextFlights(){

  $shift = intval(($this->expected_departure_time)->format('w'));
  //echo "entrou build\n";
  for($i=0; $i <30; $i++){
    
    if($i == 0 ){
        $date = new DateTime();
      if(($this->expected_departure_time) < $date)
        continue;
    }
    
    //frequency é um array que vai de 0 até 6 e possui valores de true ou false
    if(($this->frequency)[($i + $shift) % 7]){
      $flightDeparture = clone $this->expected_departure_time;
      $flightDeparture->modify('+'.$i.' day');
      
      $flightArrivel = clone $this->expected_arrival_time;
      $flightArrivel->modify('+'.$i.' day');
    
      if(!empty(($this->flightsKey)[date_format($flightDeparture,"Y/m/d H:i:s")]))
        continue;
 
      $flight = new Flight($this, $flightDeparture, $flightArrivel);
      
      ($this->flightsKey)[date_format($flightDeparture,"Y/m/d H:i:s")] = $flight->getKey();

    }
  }
  //echo "saiu build\n";
}

  private function calcMiliage(): float{
      $origem = Airport::getByKey($this->airportOriginKey);
      $destino = Airport::getByKey($this->airportDestinyKey);
      $lat_origem = $origem->getAdress()->getLat();
      $long_origem = $origem->getAdress()->getLong();
      $lat_destino = $destino->getAdress()->getLat();
      $long_destino = $destino->getAdress()->getLong();
      $distancia = $this->calculaDistancia($lat_origem, $long_origem, $lat_destino, $long_destino);
      $total = $distancia + $this->line_price;
      return round($total);
  }

 private function duracaoVoo($expected_departure_time,$expected_arrival_time) : DateInterval
  {
    $interval = $this->getExpectedArrivalTime()->diff($this->getExpectedDepartureTime());
    return $interval;   
  }
  public function getFlights(){
    return $this->flightsKey;
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

  //Airport
  public function getOrigin() : Airport
  {
    return Airport::getByKey($this->airportOriginKey);
  }
  public function getDestiny() : Airport
  {
    return Airport::getByKey($this->airportDestinyKey);
  }

  public function getCompanyKey(){
    return $this->flightCompanyKey;
  }
  public function setOrigin(int $origin) : void
  {
    $this->airportOriginKey = $origin;
  }
  public function setDestiny(int $destiny) : void
  {
    $this->airportDestinyKey = $destiny;
  }
  //Airplane
  public function getAirplane() : Airplane
  {
    return Airplane::getByKey($this->airplaneKey);
  }
  public function setAirplane(Airplane $Airplane) : void
  {
    $this->airplaneKey = $Airplane->getKey();
  //  $this->lugadge_price = $this->airplane->getLuggadge();
    $this->save();
  }
  //FlightLines
  public function getCode() : string
  {
    return $this->codigo_voo;
  }
  public function getExpectedDepartureTime() : DateTime
  {
    return $this->expected_departure_time;
  }
  public function getExpectedArrivalTime() : DateTime
  {
    return $this->expected_arrival_time;
  }
  public function getDuracao() : DateInterval
  {
    return $this->duracao_estimada;
  }
  public function getPrice() : float
  {
    return $this->line_price;
  }
  public function getFullPrice($luggadge) : float
  {
    return ($this->line_price) + ($this->lugadge_price)*$luggadge;
  }
  public function getLugadgeprice() : float
  {
    return $this->lugadge_price;
  }
  public function getFrequency() : array
  {
    return $this->frequency;
  }
  public function isOperational() : bool
  {
    return $this->operational;
  } 
  public function setPrice(float $price) : void
  {
    $this->line_price = $price;
  }
  public function setFrequency(array $frequency) : void
  {
    $this->frequency = $frequency;
  }
  public function setOperational(bool $operational) : void
  {
    $this->operational = $operational;
  }
  public function getFine(){
    return $this->cancelationFine;
  }

  public function getMiliage():float{
    return $this->flightMiliage;
  }

  public function informacoes() : void
  {
    $frequencia = '';
    foreach($this->getFrequency() as $freq) {
      $frequencia = "{$frequencia}{$freq}". " " ;
    }
    
    echo ("INFORMACOES DA FLIGHTLINE {$this->getCode()}" . PHP_EOL .
          "Origem: {$this->getOrigin()->getName()}" . PHP_EOL .
          "Destino: {$this->getDestiny()->getName()}" . PHP_EOL .
          "Horário: {$this->getExpectedDepartureTime()->format('Y/m/d H:i:s')}" . PHP_EOL .
          "Duração estimada: {$this->getDuracao()->d} dia(s) {$this->getduracao()->h} horas " .
           "{$this->getduracao()->i} minutos" . PHP_EOL .
          "Preço: {$this->getPrice()} " . PHP_EOL .
          "Frequência do Voo: {$frequencia}" . PHP_EOL .
          "Valor unitario da bagagem: {$this->getlugadgeprice()}" . PHP_EOL .
          "Esta linha está operando: ");  
          var_dump($this->isOperational());
          echo PHP_EOL . PHP_EOL ;        
  }
  static public function getFilename()
  {
      return get_called_class()::$local_filename;
  }
}
