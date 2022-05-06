<?php

class Database
{
  static protected $pdo = null;

  static public function get_connection() : PDO
  {
    if (static::$pdo == null)
    {
      $config = include 'config.php';
      static::$pdo = new PDO("mysql:host=localhost;dbname=reference;", "r1", "xxxx");//new PDO(("mysql:host=" . $config['db_host'] . ";dbname=" . $config['db_name'] . ";"), $config['db_user'], $config['db_pass']);
    }

    return static::$pdo;
  }

  static public function exec($sql, $sql_params=null)
  {
    if ($sql_params)
    {
      $query = static::get_connection()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

      $query->execute($sql_params);
    }
    else {
      $query = static::get_connection()->prepare($sql);
      $query->execute();
    }

    return $query->fetchAll();
  }

}

?>
