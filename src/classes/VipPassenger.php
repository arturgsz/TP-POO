<?php
/* VipPassenger.php
 * This is the class for the VipPassenger object.
 */

require_once 'Passenger.php';

class VipPassenger extends Passenger
{
    // Attributes
    protected int $register_number;
    protected float $points_last_year;
    protected float $points_alltime;
    protected DateTime $entered_program;
    protected DateTime $expire_program;
    protected string $milliage_program;
    protected string $milliage_subprogram;


    // Constructor
    public function __construct(int $register_number,
                                float $points_last_year,
                                float $points_alltime,
                                DateTime $entered_program,
                                DateTime $expire_program,
                                string $milliage_program,
                                string $milliage_subprogram)
  {
        $this->register_number = $register_number;
        $this->points_last12 = $points_last_year;
        $this->points_alltime = $points_alltime;
        $this->entered_program = $entered_program;
        $this->expire_program = $expire_program;
        $this->milliage_program = $milliage_program;
        $this->document = $milliage_subprogram;
    
        try{
            $this->save(); 
         }catch(Exception $e){
             echo $e->getMessage();
             throw($e);
         }
    }

    public function refreshPoints() : bool
    {
      $this->points_last12 = 0;
      $this->points_alltime = 0;
      if($this->points_last12 == $this->points_alltime == 0){return true;}
      else {return false;}
      //só isso?
    }

    public function refreshMiliage() : bool
    {
      //implementar
    }
  
    // Getters and Setters
    public function getRegister_number() : int
    {
        return $this->register_number;
    }
    public function getPoints_last12() : float
    {
        return $this->points_last12;
    }
    public function getPoints_alltime() : float
    {
        return $this->points_alltime;
    }
    public function getEntered_program() : DateTime
    {
        return $this->entered_program;
    }
    public function getExpired_program() : DateTime
    {
        return $this->expired_program;
    }
    public function getMiliage_program() : string
    {
        return $this->miliage_program;
    }
    public function getmiliage_subprogram() : string
    {
        return $this->miliage_subprogram;
    } 
  
    
    // Destructor
    public function __destruct()
    {
      //  echo "The object VipPassenger with register {$this->register_number} was destroyed.";
    }
}