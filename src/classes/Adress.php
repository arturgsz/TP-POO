<?php
/* Adress.php
 * This is the class for the Adress object.
 */
require_once 'PersistLogAuthenticate.php';

class Adress extends PersistLogAuthenticate
{
    // Attributes
    protected string $rua;
    protected string $bairro;
    protected string $cidade;
    protected string $estado;
    protected int $numero;
    protected string $cep;
    protected $coordenadas = [];
    protected static $local_filename = "Adress.txt";

    // Constructor
    public function __construct(string $rua, 
                                string $bairro, 
                                string $cidade, 
                                string $estado,
                                int $numero,
                                int $cep,
                                float $coordx, float $coordy)
    {
        $this->rua = $rua;
        $this->bairro = $bairro;
        $this->cidade = $cidade;
        $this->estado = $estado;
        $this->numero = $numero;
        $this->cep = $cep;

        $this->coordenadas[0] = $coordx;
        $this->coordenadas[1] = $coordy;
        
        //$this->adress_to_coord();
        try{
           $this->save(); 
        }catch(Exception $e){
            echo $e->getMessage();
            throw($e);
        }
        
    }

    public function adress_to_coord() : void
    {
      //Em Coordenadas Geográficas, primeiro temos lat, depois long:
      //Latitude - calcular lat:
      array_push($this->coordenadas, "lat");
      //Longitude - calcular long:
      array_push($this->coordenadas, "long");
    }

    // Getters and Setters
    public function getRua() : string
    {
        return $this->rua;
    }

    public function getBairro() : string
    {
        return $this->bairro;
    }

    public function getCidade() : string
    {
        return $this->cidade;
    }
    public function getEstado() : string
    {
        return $this->estado;
    }

    public function getNumero() : int
    {
        return $this->numero;
    }
    
    public function getCep() : string
    {
        return $this->cep;
    }

    public function getLat() : float
    {
        return $this->coordenadas[0];
    }

    public function getLong() : float
    {
        return $this->coordenadas[1];
    }

    public function setRua(string $rua)
    {
        $this->rua = $rua;
    }

    public function setBairro(string $bairro)
    {
        $this->bairro = $bairro;
    }

    public function setCidade(string $cidade)
    {
        $this->cidade = $cidade;
    }

    public function setNumero(int $numero)
    {
        $this->numero = $numero;
    }

    public function setCep(string $cep)
    {
        $this->cep = $cep;
    }

    // Destructor
    public function __destruct()
    {
        //echo "The adress with cep {$this->cep} was destroyed.";
    }

    static public function getFilename()
    {
        return get_called_class()::$local_filename;
    }

}

