<?php
/* VipPassenger.php
 * This is the class for the VipPassenger object.
 */

require_once 'Passenger.php';

class VipPassenger extends Passenger
{
    // Attributes
    protected int $register_number;
    protected int $pointsKey;
    protected string $milliage_program;
    protected string $milliage_subprogram;

    // Constructor
    public function __construct(int $register_number,
                                string $milliage_program,
                                string $milliage_subprogram,
                                Points $points)
  {
        $this->register_number = $register_number;
        $this->milliage_program = $milliage_program;
        $this->document = $milliage_subprogram;
        $this->pointsKey = $points->getKey();
        try{
            $this->save(); 
         }catch(Exception $e){
             echo $e->getMessage();
             throw($e);
         }
    }

    public function getPoints() : float
    {         
        return  (Points::getByKey($this->pointsKey))->getPoints();
    }

   
  
    // Getters and Setters
    public function getRegister_number() : int
    {
        return $this->register_number;
    }

    public function getMiliage_program() : string
    {
        return $this->milliage_program;
    }
    public function getMiliage_subprogram() : string
    {
        return $this->milliage_subprogram;
    } 

    

    // Destructor
    public function __destruct()
    {
      //  echo "The object VipPassenger with register {$this->register_number} was destroyed.";
    }
}