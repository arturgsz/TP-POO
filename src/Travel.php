<?php
/* Travel.php
 * This is the class for the Travel object.
 */
//O atributo static $code é atributo da classe e vai gerar os 4 digitos do codigo da viagem
//O atributo $flight_code é atributo do objeto e não da classe

//Os atributos Datetime não estão no constructor porque eles serão inicializados por funções
//essas funções como precisam ser públicas tem senha de acesso '1234'

require_once 'FlightLines.php';
//require_once 'Ticket.php';

class Travel
{
    private static $code = '0000'; //gerador de codigo

    private string $flight_code; //codigo da viagem 2 letras seguida de 4 digitos
    private FlightLines $company_code; //2 letras da companhia aerea
    private DateTime $departure_time; 
    private DateTime $arrival_time;

    public function __construct(FlightLines $company_code)
    { 
      Travel::$code++;
      $this->flight_code = Travel::gerarCodigo($company_code); 
      $this->company_code = $company_code;
    }
  
    private function gerarCodigo(FlightLines $company_code) : string
    {
      $prefixo = $company_code->getCompany(); 
    
      if(Travel::$code == '10000'){
        Travel::$code = '0000';
        return $prefixo . '0001'; 
      } 
      else {
        if(Travel::$code <= 9) 
          return $prefixo . '000' . Travel::$code; 
          
        if(Travel::$code > 9 && Travel::$code <= 99)
          return $prefixo . '00' . Travel::$code;
        
        if(Travel::$code > 99 && Travel::$code <=999)
            return $prefixo . '0'. Travel::$flight_code;
           
        if(Travel::$code > 999 && Travel::$code <=9999)
          return $prefixo . Travel::$code;
      }
    }
    
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
    

    /*
    //private FlightLines $line;

    // Constructor
    public function __construct(DateTime $departure_time, 
                                DateTime $arrival_time, 
                                FlightLines $line)
    {
        $this->name = $name;
        $this->departure_time = $departure_time;
        $this->arrival_time = $arrival_time;
        //$this->line = $line;
    }

    //Funcao que cria codigo
    
    
    // Getters and Setters

    public function getName()
    {
        return $this->name;
    }

    public function getDepartureTime()
    {
        return $this->departure_time;
    }

    public function getArrivalTime()
    {
        return $this->arrival_time;
    }

    /*public function getLine()
    {
        return $this->line;
    

    public function setName(string $name)
    {
        $this->name = $name;
    }


    /*public function setLine(FlightLines $line)
    {
        $this->line = $line;
    }
    */


    // Destructor
    public function __destruct()
    {
        echo "Travel object destroyed";
    }
}
