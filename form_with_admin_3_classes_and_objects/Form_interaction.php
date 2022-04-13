<?php

class Form_interaction {

  public static $separator = '||';  // разделитель
  public static $name_data_folder = 'data';
  public static $filename = 'user_data.txt';

  protected string $contents;

  protected string $name;
  protected string $family;
  protected string $email;
  protected string $phone;
  protected string $topic;
  protected string $payment;
  protected bool $confirm;

  protected array $data_errors;

  public function __construct(array $data)
   {
     $this->data_errors = [];

     $this->name = $data['name'] ?? null;
     $this->family = $data['family'] ?? null;
     $this->email = $data['email'] ?? null;
     $this->phone = $data['phone'] ?? null;
     $this->topic = $data['topic'] ?? null;
     $this->payment = $data['payment'] ?? null;
     $this->confirm = (bool)($data['confirm'] ?? 0);
   }

   public function save() : bool
   {
     $this->check_errors();

      if ($this->validate())
      {
        $this->contents = '';
        $this->contents .= uniqid() . $this->separator; // id
  			$this->contents .= $this->name . $this->separator; // name
  			$this->contents .= $this->family . $this->separator; // family
  			$this->contents .= $this->email . $this->separator; // email
  			$this->contents .= $this->phone . $this->separator; // phone
  			$this->contents .= $this->topic . $this->separator; // topic
  			$this->contents .= $this->payment . $this->separator; // payment
        $this->contents .= time() . $this->separator; // date
  			$this->contents .= ($this->confirm ? '1' : '0') . $this->separator; // confirm
  			$this->contents .= $_SERVER['REMOTE_ADDR'] . $this->separator; // client ip
  			$this->contents .= '1' . "\n"; // actual (no deleted)

        if (!file_exists($this->name_data_folder)) {
  				mkdir($this->name_data_folder, 0777);   // имя и права в 8-ой сист. счисления
  			}

  			file_put_contents($this->name_data_folder . '/' . $this->filename, $this->contents, FILE_APPEND | LOCK_EX);

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
     if (!$this->name)
   	 {
   		  $this->data_errors[] = 'Name is required';
   	  }
   		if (!$this->family)
   		{
   			$this->data_errors[] = 'Family is required';
   		}
   		if (!$this->email)
   		{
   			$this->data_errors[] = 'Email is required';
   		}
   		if (!$this->phone)
   		{
   			$this->data_errors[] = 'Phone is required';
   		}
   		if (!$this->topic)
   		{
   			$this->data_errors[] = 'Topic is required';
   		}
   		if (!$this->payment)
   		{
   			$this->data_errors[] = 'Payment method is required';
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

   public static function save_all(string $data) : int
   {
     return file_put_contents(Form_interaction::$name_data_folder . '/' . Form_interaction::$filename, $data);
   }

   public static function load_all() : string
   {
     return file_get_contents(Form_interaction::$name_data_folder . '/' . Form_interaction::$filename);
   }
}
