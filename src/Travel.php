<?php
/* Travel.php
 * This is the class for the Travel object.
 */

require_once 'FlightLines.php';
require_once 'Airplane.php';
//require_once 'Ticket.php';

class Travel
{

  private string $Travel_code; // 2 letras seguida de 4 digitos
  private string $siglaFlightCompany;
  private string $code;

  private FlightLines $line;
  private Airplane $airplane;

  private DateTime $departure_time;
  private DateTime $arrival_time;
  private DateInterval $duracaoVoo;

  private float $line_price; //preço definido pelo FlightLines
  private float $lugadge_price; //valor unitario definido pela companhia aerea
  private $seat = []; //assentos 

  //int $max_ticket
  //private Ticket $ticket;
  //private $tickets = [];

  public function __construct(FlightLines $line)
  {
    $this->code = rand(1000, 9999);
    $this->line = $line;
    $this->airplane = $line->getAirplane();

    $this->departure_time = $line->getExpectedDepartureTime();
    $this->arrival_time = $line->getExpectedArrivalTime();

    $this->line_price = $line->getPrice();
    $this->lugadge_price = $line->getlugadgeprice();

    $this->siglaFlightCompany = $line->getAirplane()->getFlightCompany()->getSigla();

    $this->Travel_code = Travel::TravelCodigo($this->siglaFlightCompany, $this->code);

    $this->duracaoVoo = Travel::duracaoVoo($this->departure_time, $this->arrival_time);

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
     */
  }

  /*
    public function Add_ticket(FlightTicket $flightTicket)
    {
      array_push($tickets, $flightTicket); //conferir se é assim
    }    
    */

  private function TravelCodigo(string $sigla, string $code): string
  {
    return $sigla . strval($code);
  }
  private function duracaoVoo($departure_time, $arrival_time): DateInterval
  {
    $interval = $this->getArrivalTime()->diff($this->getDepartureTime());
    return $interval;
  }


  //essa função cria os assentos da Travel :)
  private function CriaAssentos(array $seat): array
  {
    // Para facilitar essa função, os assentos do avião são do tipo int
    $quantidadeAssentos = $this->getAirplane()->getPassengerCapacity();

    for ($i = 1; $i <= $quantidadeAssentos; $i++) {
      array_push($seat, $i);
    }
    return $seat;
  }

  //essa função ocupa os assentos da Travel
  private function Choose_seats($seat): array
  {

  }
  
  //essa função apresenta os assentos disponíveis da Travel
  private function Show_seats($seat):array
  {
    $quantidadeAssentos = $this->getAirplane()->getPassengerCapacity();
    for ($i = 1; $i <= $quantidadeAssentos; $i++) {
      if ($seat[$i] == '1') {
        echo "O assento" . $i . "está disponível";
      } else if ($seat[$i] == '0') {
        echo "O assento" . $i . "está indisponível";
      }
    }
  }


  // Getters and Setters
  public function getCode(): string
  {
    return $this->code;
  }
  public function getFlightCode(): string
  {
    return $this->Travel_code;
  }
  public function getFlightLine(): FlightLines
  {
    return $this->line;
  }
  public function getAirplane(): Airplane
  {
    return $this->airplane;
  }
  public function getDepartureTime(): DateTime
  {
    return $this->departure_time;
  }

  public function getArrivalTime(): DateTime
  {
    return $this->arrival_time;
  }
  public function getDuracao(): DateInterval
  {
    return $this->duracaoVoo;
  }
  public function getPrice(): float
  {
    return $this->line_price;
  }

  public function getLuggadge(): float
  {
    return $this->lugadge_price;
  }
  public function setAirplane(Airplane $airplane): void
  {
    $this->airplane = $airplane;
    $this->siglaFlightCompany = $airplane->getFlightCompany()->getSigla();
    $this->Travel_code = Travel::TravelCodigo($this->siglaFlightCompany, $this->code);
    $this->lugadge_price = $this->airplane->getLuggadge();
  }
  public function setDepartureTime(string $new_departure_time): void
  {
    $this->departure_time->modify($new_departure_time);
    $this->duracaoVoo = Travel::duracaoVoo($new_departure_time, $this->arrival_time);
  }
  public function setArrivalTime(string $new_arrival_time): void
  {
    $this->arrival_time->modify($new_arrival_time);
    $this->duracaoVoo = Travel::duracaoVoo($this->departure_time, $new_arrival_time);
  }

  public function informacoes(): void
  {
    echo ("INFORMAÇÕES DO VOO" . PHP_EOL .
      "Voo {$this->getFlightCode()}" . PHP_EOL .
      "Companhia Aerea responsável: {$this->getAirplane()->getFlightCompany()->getName()} " . PHP_EOL .
      "Origem: {$this->line->getOrigin()->getName()}" . PHP_EOL .
      "Destino: {$this->line->getDestiny()->getName()}" . PHP_EOL .
      "Data e horário de Partida: {$this->getDepartureTime()->format('Y/m/d H:i:s')} " . PHP_EOL .
      "Data e horário de Chegada: {$this->getArrivalTime()->format('Y/m/d H:i:s')} " . PHP_EOL .
      "Duracao do Voo: {$this->getDuracao()->h} horas e {$this->getDuracao()->i} minutos" . PHP_EOL .
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
    echo "Travel object destroyed";
  }
}
