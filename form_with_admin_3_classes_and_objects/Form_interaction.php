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
        $this->contents .= uniqid() . self::$separator; // id
  			$this->contents .= $this->name . self::$separator; // name
  			$this->contents .= $this->family . self::$separator; // family
  			$this->contents .= $this->email . self::$separator; // email
  			$this->contents .= $this->phone . self::$separator; // phone
  			$this->contents .= $this->topic . self::$separator; // topic
  			$this->contents .= $this->payment . self::$separator; // payment
        $this->contents .= time() . self::$separator; // date
  			$this->contents .= ($this->confirm ? '1' : '0') . self::$separator; // confirm
  			$this->contents .= $_SERVER['REMOTE_ADDR'] . self::$separator; // client ip
  			$this->contents .= '1' . "\n"; // actual (no deleted)
echo $this->contents;
        if (!file_exists(self::$name_data_folder)) {
  				mkdir(self::$name_data_folder, 0777);   // имя и права в 8-ой сист. счисления
  			}

  			file_put_contents(self::$name_data_folder . '/' . self::$filename, $this->contents, FILE_APPEND | LOCK_EX);

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
     return file_put_contents(self::$name_data_folder . '/' . self::$filename, $data);
   }

   public static function load_all() : string
   {
     return file_get_contents(self::$name_data_folder . '/' . self::$filename);
   }
}
