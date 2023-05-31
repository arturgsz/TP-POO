<?php
/* Adress.php
 * This is the class for the Adress object.
 */
require_once 'Persist.php';

class Adress extends Persist
{
    // Attributes
    private string $rua;
    private string $bairro;
    private string $cidade;
    private int $numero;
    private int $cep;
    private $coordenadas = [];
    protected static $local_filename = "Adress.php";

    // Constructor
    public function __construct(string $rua, 
                                string $bairro, 
                                string $cidade, 
                                int $numero,
                                int $cep)
    {
        $this->rua = $rua;
        $this->bairro = $bairro;
        $this->cidade = $cidade;
        $this->numero = $numero;
        $this->cep = $cep;
        $this->adress_to_coord();
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

    public function getNumero() : int
    {
        return $this->numero;
    }
    
    public function getCep() : int
    {
        return $this->cep;
    }

    public function getLat() : string
    {
        return $this->coordenadas[0];
    }

    public function getLong() : string
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

    public function setNumero(string $numero)
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
        echo "The adress with cep {$this->cep} was destroyed.";
    }

    static public function getFilename()
    {
        return get_called_class()::$local_filename;
    }
}

