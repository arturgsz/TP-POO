<?php
/* FlightLines.php
 * This is the class for the Flight Lines object.
 */

require_once 'Airport.php';
require_once 'Airplane.php';
require_once 'Travel.php';

/*
array de frequencia dos voos: Valores válidos:
domingo => Sun
segunda => Mon
terça => Tue
quarta => Wed
quinta => Thu
sexta => Fri
sabado => Sat
*/

class FlightLines 
{
  private Airport $origin; 
  private Airport $destiny;
  private DateTime $expected_departure_time;
  private DateTime $expected_arrival_time;
  private DateInterval $duracao_estimada;
  private Airplane $airplane; 
  private string $code; //código da linha de voo
  private bool $operational;
  private $frequency = [];  //frequencia do voo
  private float $line_price;
  private float $lugadge_price; //valor unitario da bagagem
  private $array_travel = [];  //array de objetos do tipo Travel

   public function __construct(Airport $origin,
                              Airport $destiny,
                              DateTime $expected_departure_time,
                              DateTime $expected_arrival_time,
                              Airplane $airplane,
                              bool $operational,
                              array $frequency,
                              float $line_price)
  {
    $this->origin = $origin;
    $this->destiny = $destiny;
    $this->expected_departure_time = $expected_departure_time;
    $this->expected_arrival_time = $expected_arrival_time;
    $this->airplane = $airplane;
    $this->code = rand(1000,9999);
    $this->duracao_estimada = FlightLines::duracaoVoo($expected_departure_time,$expected_arrival_time);
    $this->operational = $operational;
    $this->frequency = $frequency;
    $this->line_price = $line_price;
    $this->lugadge_price = $airplane->getLuggadge();

    //CRIAÇÃO DE TRAVELS PARA OS PROXIMOS 30 DIAS
    if($operational) {
      $datetime = $expected_departure_time->format('Y/m/d H:i:s');
      $datetime_arrival = $expected_arrival_time->format('Y/m/d H:i:s');
      $novaData = new DateTime($datetime);
      $novaPartida = new DateTime($datetime_arrival);
      foreach($frequency as $freq) {
      $frequencia = $freq;
      $diadasemana = $novaData->format('D');
      while($diadasemana != $frequencia)
      {
        $novaData->add(new DateInterval('P1D'));
        $novaPartida->add(new DateInterval('P1D'));
        
        $diadasemana = $novaData->format('D');
      }
      for($i=0 ; $i < 5; $i++)
      {
        $travel = new Travel($this->code,
                             $this->origin,
                             $this->destiny,
                             $novaData,
                             $novaPartida,
                             $this->airplane,
                             $this->line_price,
                             $this->lugadge_price);
       // $array_travel[] = $travel;
        $novaData->add(new DateInterval('P7D')); 
        $novaPartida->add(new DateInterval('P7D'));
      }
      $novaData = new dateTime($datetime);
      $novaPartida = new dateTime($datetime_arrival);
     }
   }
 }
  
 private function duracaoVoo($expected_departure_time,$expected_arrival_time) : DateInterval
  {
    $interval = $this->getExpectedArrivalTime()->diff($this->getExpectedDepartureTime());
    return $interval;   
  }
  
 // Setters and Getters
  
  //Travel
  /*
  public function getTravel() : array
  {
    return $this->array_travel;
  }
  //ARRAY de Travels criados a partir da linha de Voo
  public function VoosCriados() : void
  {
    foreach($this->array_travel as $travel)
    {
      $travel->informacoes();
    } 
  }
  */
  
  //Airport
  public function getOrigin() : Airport
  {
    return $this->origin;
  }
  public function getDestiny() : Airport
  {
    return $this->destiny;
  }
  
  public function setOrigin(Airport $origin) : void
  {
    $this->origin = $origin;
  }
  public function setDestiny(Airport $destiny) : void
  {
    $this->destiny = $destiny;
  }
  
  //Airplane
  public function getAirplane() : Airplane
  {
    return $this->airplane;
  }
  public function setAirplane(Airplane $Airplane) : void
  {
    $this->airplane = $Airplane;
    $this->lugadge_price = $this->airplane->getLuggadge();
  }
  
  //FlightLines
  public function getCode() : string
  {
    return $this->code;
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
  public function getlugadgeprice() : float
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
  public function setExpectedDepartureTime(string $new_expected_departure_time) : void
  {
      $this->expected_departure_time->modify($new_expected_departure_time);
      $this->duracao_estimada = FlightLines::duracaoVoo($new_expected_departure_time,$this->expected_arrival_time);
  }
  public function setExpectedArrivalTime(string $new_expected_arrival_time): void
   {
    $this->expected_arrival_time->modify($new_expected_arrival_time);
    $this->duracao_estimada = FlightLines::duracaoVoo($this->expected_departure_time,$new_expected_arrival_time); 
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
}