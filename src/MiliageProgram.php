<?php
/* MiliageProgram.php
 * This is the class for the MiliageProgram object.
 */

require_once 'FlightCompany.php';
require_once 'MiliageSubprogram.php';


class MiliageProgram
{
    // Attributes
    private string $name;
    private FlightCompany $flightcompany;
    private $new_subGroups = [];

    // Constructor
    public function __construct(string $name, 
                                FlightCompany $flightcompany)
    {
        $this->name = $name;
        $this->flightcompany = $flightcompany;
    }

    public function downgrade() : bool
    {
      //implementar  
      return true;
    }
    
    public function upgrade() : bool
    {
      //implementar 
      return true;
    }

    public function new_Subprogram() : MiliageSubprogram
    {
      //implementar 
    }

      // Getters and Setters
    public function getName() : string
    {
        return $this->name;
    }
    public function getFlightCompany() : FlightCompany
    {
        return $this->flightcompany;
    }

  
    // Destructor
    public function __destruct()
    {
        echo "The MiliageProgram {$this->name} was destroyed.";
    }
}
