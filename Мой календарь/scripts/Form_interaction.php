<?php

include_once 'Database.php';
include_once 'functions.php';

class Form_interaction {

  protected $data = null;

  protected array $data_errors;

  public function __construct(array $_data, array $types, array $durations)
   {
     $this->data_errors = [];

     $this->data = array(
      ':topic' => $_data['topic'] ?? null,
      ':type' =>  convert_to_index($_data['type'], $types),
      ':place' => $_data['place'] ?? null,
      ':date' => $_data['date'] ?? null,
      ':time' => $_data['time'] ?? null,
      ':duration' => convert_to_index($_data['duration'], $durations),
      ':comment' => $_data['comment'] ?? null
    );
   }

   public function save() : bool
   {
     $this->check_errors();

     if ($this->validate())
     {
       Database::exec("INSERT INTO `tasks`
         (topic, type, place, date, time, duration, comment, status) VALUES
         (:topic, :type, :place, :date, :time, :duration, :comment, 1);"
       , $this->data);

        return true;
      }
      else
      {
        $this->print_errors();
        return false;
      }
   }

   public function update($task_id) : bool
   {
     $this->check_errors();

    if ($this->validate())
    {
      Database::exec("UPDATE `tasks` SET topic = :topic, type = :type, place = :place, date = :date, time = :time, duration = :duration, comment = :comment, status = 1 WHERE id = " . $task_id . " LIMIT 1;"
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
   		if (!$this->data[':place'])
   		{
   			$this->data_errors[] = 'Place is required';
   		}
   		if (!$this->data[':date'])
   		{
   			$this->data_errors[] = 'Date is required';
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
     $data = Database::exec("SELECT * FROM `tasks`");  // + config 
     return $data;
   }
}

?>