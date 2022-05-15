<?php

include 'Database.php';

class Form_interaction {

  protected $data = null;

  protected array $data_errors;

  public function __construct(array $data)
   {
     $this->data_errors = [];

     $this->data = array(
      ':topic' => $data['topic'] ?? null,
      ':type' => $data['type'] ?? null,
      ':place' => $data['place'] ?? null,
      ':date' => $data['date'] ?? null,
      ':time' => $data['time'] ?? null,
      ':duration' => $data['duration'] ?? null,
      ':comment' => $data['comment'] ?? null
    );
   }

   public function save() : bool
   {
     $this->check_errors();

     if ($this->validate())
     {
       Database::exec("INSERT INTO `tasks`
         (topic, type, place, date, time, duration, comment) VALUES
         (:topic, :type, :place, :date, :time, :duration, :comment);"
       , $this->data);

        return true;
      }
      else
      {
        $this->print_errors();
        return false;
      }
   }

   private function check_errors() : void
   {
     if (!$this->data[':topic'])
   	 {
   		  $this->data_errors[] = 'Topic is required';
   	  }
   		if (!$this->data[':type'])
   		{
   			$this->data_errors[] = 'Type is required';
   		}
   		if (!$this->data[':place'])
   		{
   			$this->data_errors[] = 'Place is required';
   		}
   		if (!$this->data[':date'])
   		{
   			$this->data_errors[] = 'Date is required';
   		}
   		if (!$this->data[':duration'])
   		{
   			$this->data_errors[] = 'Duration is required';
   		}
   }

   public function validate() : bool
   {
     return !(count($this->data_errors)) ;
   }

   private function print_errors() : void
   {
     echo '<ul style="color:red;">';
     foreach ($this->data_errors as $error) {
       echo '<li>' . $error . '</li>';
     }
     echo '</ul>';
   }

   public static function load_all()
   {
     $data = Database::exec("SELECT * FROM `calendar_tasks`");  // + config 
     return $data;
   }
}

?>