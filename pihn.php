<!-- <?php
/* 
 * This is the class for the Travel object.
 

require_once 'FlightLines.php';
require_once 'Airplane.php';
require_once 'Persist.php';

class Travel extends Persist
{
  protected int $linhadeVooKey;
  protected int $originKey; 
  protected int $destinyKey;
  protected int $airplaneKey; 
  protected string $Travel_code; // 2 letras seguida de 4 digitos
  protected string $code; 
  protected string $siglaFlightCompany;
  protected DateTime $departure_time; 
  protected DateTime $arrival_time;
  protected DateInterval $duracaoVoo;
  protected float $line_price; //preço definido pelo FlightLines
  protected float $lugadge_price; //valor unitario definido pela companhia aerea
  protected $seat = []; //assentos 
  protected static $local_filename = "Travel.txt";
       


    public function __construct(FlightLines $flightline,
                                // Airport $originKey,
                                // Airport $destinyKey,
                                // DateTime $expected_departure_time,
                                // DateTime $expected_arrival_time,
                                // Airplane $airplane,
                                // float $line_price,
                                // float $lugadge_price
                                )
    { 
      $this->linhadeVooKey = $flightline->getKey();
      $linhadeVoo =  FlightCompany::getByKey($this->linhadeVooKey);
      
      //Atualizar quando mexer em flightLine
      $this->code = rand(1000,9999);
      $this->originKey = $linhadeVoo->origin->getKey();
      $this->destinyKey = $linhadeVoo->destiny->getKey();
      $this->departure_time = $linhadeVoo->expected_departure_time;
      $this->arrival_time = $linhadeVoo->expected_arrival_time;
      $this->airplaneKey = $linhadeVoo->airplane->getKey();

      $flightCompany = Airplane::getByKey($this->airplaneKey)->getFlightCompany();
      $this->siglaFlightCompany = $flightCompany->getSigla();

      $this->line_price = $linhadeVoo->line_price;
      $this->lugadge_price = $linhadeVoo->lugadge_price;

      $airplane = Airport::getByKey($this->airplaneKey);
      $this->Travel_code = Travel::TravelCodigo($airplane->
                                                getFlightCompany()->getSigla(),
                                                $this->code);
      $this->duracaoVoo = Travel::duracaoVoo($this->departure_time,
                                             $this->arrival_time);
      $this->seat = Travel::CriaAssentos($this->seat);

      /*
      for($i= 0; $i< $max_ticket; $i++){
        $ticket_ = new FlightTicket(
          $i, 
          $this->lugadge_price,
          $this->line_price, 
          $this->flight_code);
      
      array_push($tickets, $ticket_); 
      }
     
  
    
    public function Add_ticket(FlightTicket $flightTicket)
    {
      array_push($tickets, $flightTicket); //conferir se é assim
    }    
    
    try{
      $this->save(); 
    }catch(Exception $e){
       echo $e->getMessage();
       throw($e);
    }
  }
    private function TravelCodigo(string $sigla, string $code) : string
    {
      return $sigla . strval($code);
    }
  
    private function duracaoVoo(DateTime $departure_time,
                                DateTime $arrival_time) : DateInterval
    {
      $interval = $this->getArrivalTime()->diff($this->getDepartureTime());
      return $interval;   
    }
  
    //essa função cria os assentos da Travel :)
    private function CriaAssentos(array $seat) : array
    {
      // Para facilitar essa função, os assentos do avião são do tipo int
      $quantidadeAssentos = $this->getAirplane()->getPassengerCapacity();
      
      for($i=1; $i <= $quantidadeAssentos; $i++)
      {
        array_push($seat,$i);
      }

      return $seat;
    }
  
    public function MostraAssentos() : void
    {     
      echo "Assentos disponíveis em voo: <br>";
      for($i=0; $i < sizeof($this->seat); $i++)
      {
        echo $this->seat[$i] . " ";
      }
      echo "<br><br>";
    }

    public function CreateTicket () : void
    {
        
    }

  
    // Getters and Setters
    public function getFlightLine() : FlightLines
    {
      return FlightLines::getByKey($this->linhadeVooKey);
    }  
    public function getOrigin() : Airport
    {
      return Airport::getByKey($this->originKey);
    }
    public function getDestiny() : Airport
    {
      return Airport::getByKey($this->destinyKey);
    }
    public function getCode() : string
    {
      return $this->code;
    }
    public function getFlightCode() : string
    {
      return $this->Travel_code;
    }
    public function getAirplane() : Airplane
    {
      return Airplane::getByKey($this->airplaneKey);
    }
    public function getDepartureTime() : DateTime
    {
      return $this->departure_time;
    }
    public function getArrivalTime() : DateTime
    {
      return $this->arrival_time;
    }
    public function getDuracao() : DateInterval
    {
      return $this->duracaoVoo;
    }
    public function getPrice() : float
    {
      return $this->line_price;
    }    
    public function getLuggadge() : float
    {
      return $this->lugadge_price;
    }
    public function setAirplane(Airplane $airplane) : void
    {
      $this->airplaneKey = $airplane->getKey();
      $airplane =  Airplane::getByKey($this->airplaneKey);
      $this->siglaFlightCompany = $airplane->getFlightCompany()->getSigla();
      $this->Travel_code = Travel::TravelCodigo($this->siglaFlightCompany,$this->code);
      $this->lugadge_price = $airplane->getLuggadge();
    }
  /*
  Como a data de chegada e data de partida estão como DateTime não será possivel setar as datas da travel
  
  
    public function setDepartureTime(string $new_departure_time) : void
    {
      $this->departure_time->modify($new_departure_time);
      $this->duracaoVoo = Travel::duracaoVoo($new_departure_time,$this->arrival_time);
    }
    public function setArrivalTime(string $new_arrival_time) : void
    {
      $this->arrival_time->modify($new_arrival_time);
      $this->duracaoVoo = Travel::duracaoVoo($this->departure_time,$new_arrival_time);
    }
  
    public function informacoes() : void
    {
    echo ("INFORMAÇÕES DO VOO" . PHP_EOL.
          "Voo {$this->getFlightCode()}" . PHP_EOL .
           "Companhia Aerea responsável: {$this->getAirplane()->getFlightCompany()->getName()} " . PHP_EOL .
           "Origem: {$this->getOrigin()->getName()}" . PHP_EOL .
           "Destino: {$this->getDestiny()->getName()}" . PHP_EOL .
           "Data e horário de Partida: {$this->getDepartureTime()->format('Y/m/d H:i:s')} " . PHP_EOL .
           "Data e horário de Chegada: {$this->getArrivalTime()->format('Y/m/d H:i:s')} " . PHP_EOL .
           "Duracao do Voo: {$this->getDuracao()->d} dia(s) {$this->getDuracao()->h} horas e {$this->getDuracao()->i} minutos" . PHP_EOL .
           "Aeronave: " . PHP_EOL .
           "Modelo: {$this->getAirplane()->getModel()}" . PHP_EOL .
           "Registro: {$this->getAirplane()->getRegistration()}" . PHP_EOL .
           "Numero de Assentos: " . PHP_EOL .
           "Preço do Voo: {$this->getPrice()}" . PHP_EOL . 
           "Valor unitario da bagagem: {$this->getLuggadge()}" . PHP_EOL . PHP_EOL);
    }

    // Destructor
    public function __destruct()
    {
        //echo "Travel object destroyed" . PHP_EOL;
    }
  static public function getFilename()
  {
      return get_called_class()::$local_filename;
  }
} -->*/