<?php

include 'Database.php';

class Form_interaction {

  public static $separator = '||';  // разделитель
  public static $name_data_folder = 'data';
  public static $filename = 'user_data.txt';

  protected $data = null;

  protected array $data_errors;

  public function __construct(array $data)
   {
     $this->data_errors = [];

     $this->data = array(':name' => $data['name'] ?? null,
      ':lastname' => $data['family'] ?? null,
      ':email' => $data['email'] ?? null,
      ':tel' => $data['phone'] ?? null,
      ':subject_id' => $data['topic'] ?? null,
      ':payment_id' => $data['payment'] ?? null,
      ':confirm' => (bool)($data['confirm'] ?? 0) ? 1 : 0,
      ':client_ip' => $_SERVER['REMOTE_ADDR']
    );
   }

   public function save() : bool
   {
     $this->check_errors();

     if ($this->validate())
     {
       Database::exec("INSERT INTO `participants`
         (name, lastname, email, tel, subject_id, payment_id, date, confirm, client_ip) VALUES
         (:name, :lastname, :email, :tel, :subject_id, :payment_id, NOW(), :confirm, :client_ip);"
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
     if (!$this->data[':name'])
   	 {
   		  $this->data_errors[] = 'Name is required';
   	  }
   		if (!$this->data[':lastname'])
   		{
   			$this->data_errors[] = 'Family is required';
   		}
   		if (!$this->data[':email'])
   		{
   			$this->data_errors[] = 'Email is required';
   		}
   		if (!$this->data[':tel'])
   		{
   			$this->data_errors[] = 'Phone is required';
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
     $data = Database::exec("SELECT * FROM `participants`");
     return $data;
   }
}
