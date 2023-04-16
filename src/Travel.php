<?php
/* Travel.php
 * This is the class for the Travel object.
 */
//O atributo static $code é atributo da classe e vai gerar os 4 digitos do codigo da viagem
//O atributo $flight_code é atributo do objeto e não da classe

//Os atributos Datetime não estão no constructor porque eles serão inicializados por funções
//essas funções como precisam ser públicas tem senha de acesso '1234'

require_once 'Ticket.php';

class Travel
{
    private string $flight_code; //codigo da viagem 2 letras seguida de 4 digitos
    //private Ticket $ticket;
    private DateTime $departure_time; 
    private DateTime $arrival_time;
    private float $price;
    private float $line_price;
    private float $lugadge_price;
    private $tickets = [];
    //private string $FlightCompany;

    public function __construct(DateTime $expected_departure_time,
                                DateTime $expected_arrival_time,
                                float $line_price,
                                float $lugagde_price,
                                string $FlightLine_code,
                                int $max_ticket)
    { 
      $this->departure_time = $expected_departure_time;
      $this->arrival_time = $expected_arrival_time;
      $this->line_price = $line_price;
      $this->lugadge_price = $lugagde_price;
      $this->flight_code = rand(100,999)."-".$FlightLine_code;

      for($i= 0; $i< $max_ticket; $i++){
        $ticket_ = new FlightTicket(
          $i, 
          $this->lugadge_price,
          $this->line_price, 
          $this->flight_code);
      
      array_push($tickets, $ticket_); 
      }
     
    }
    
    // public function Add_ticket(FlightTicket $flightTicket)
    // {
    //     array_push($tickets, $flightTicket); //conferir se é assim
    // }    
  
    // private function gerarCodigo(string $company_code) : string
    // {
    //   $prefixo = $company_code; 
    
    //   if(Travel::$code == '10000'){
    //     Travel::$code = '0000';
    //     return $prefixo . '0001'; 
    //   } 
    //   else {
    //     if(Travel::$code <= 9) 
    //       return $prefixo . '000' . Travel::$code; 
          
    //     if(Travel::$code > 9 && Travel::$code <= 99)
    //       return $prefixo . '00' . Travel::$code;
        
    //     if(Travel::$code > 99 && Travel::$code <=999)
    //       return $prefixo . '0'. Travel::$flight_code;
           
    //     else //(Travel::$code > 999 && Travel::$code <=9999)
    //       return $prefixo . Travel::$code;
    //   }
    // }

    public function horaDePartida(string $chaveDeAcesso) : void
    {
      if($chaveDeAcesso == '1234')
            $this->departure_time = new DateTime();
            //mostrar a hora               //formato escolhido arbitrariamente
            // echo $this->departure_time->format('d/m/Y');

      //else 
        //Tratamento do Erro    
    }

    public function horaDeChegada(string $chaveDeAcesso) : void
    {
        if($chaveDeAcesso == '1234')
            $this->arrival_time = new DateTime();
      
      //else 
      //Tratamento do Erro
   }

  
  // essa função precisa ser modelada
  public function informacoesDoVoo() : void
  {
   //nome da companhia aerea
   //origem
   //destino
   //data
    echo "INFORMAÇÕES DO VOO" . PHP_EOL;
    echo "Voo {$this->getFlightCode()} da 'companhia aerea X' " . PHP_EOL;
    echo "Origem: " . PHP_EOL;
    echo "Destino: " . PHP_EOL;
    echo "Executado no dia " . PHP_EOL . PHP_EOL;
  }
  
    // Getters and Setters
    public function getFlightCode() : string
    {
        return $this->flight_code;
    }
    public function getDepartureTime()
    {
        return $this->departure_time;
    }

    public function getArrivalTime()
    {
        return $this->arrival_time;
    }

    public function getLine()
    {
        return $this->flight_code;
    }

    public function setFlight_code(string $flight_code)
    {
        $this->flight_code = $flight_code;
    }
    
    // Destructor
    public function __destruct()
    {
        echo "Travel object destroyed";
    }
}
