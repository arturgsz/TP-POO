<?php
/* MiliageSubprogram.php
 * This is the class for the MiliageProgram object.
 */


class MiliageSubprogram
{
    // Attributes
    private string $name;
    private string $miliage_program;
    private string $benefits;
    private float $minimal_points;
    private $clients = [];

    // Constructor
    public function __construct(string $name, 
                                string $miliage_program,
                                string $benefits,
                                float $minimal_points)
    {
        $this->name = $name;
        $this->miliage_program = $miliage_program;
        $this->benefits = $benefits;
        $this->minimal_points = $minimal_points;
    }

    public function AddClient() : bool
    {
      //implementar 
      return true;
    }

    public function RemoveClient() : bool
    {
      //implementar 
      return true;
    }

    // Getters and Setters
    public function getName() : string
    {
        return $this->name;
    }
    public function getMiliageProgram() : string
    {
        return $this->miliage_program;
    }  
    public function getBenefits() : string
    {
        return $this->benefits;
    }
    public function getMinimal_points() : float
    {
        return $this->minimal_points;
    }
    public function getClients() : array
    {
        return $this->clients;
    }
  
    // Destructor
    public function __destruct()
    {
        echo "The MiliagesubProgram {$this->name} was destroyed.";
    }
}
