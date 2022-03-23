<!--
    In cmd:
    cd C:\Users\RR\Downloads\My atom
    php -S localhost:8000
    In browser: http://localhost:8000/your_file.php
-->
<!DOCTYPE html>
<html lang="ru">

  <head>
    <meta charset="utf-8">
    <title>Таблица умножения</title>

    <style media="screen">
      .diagonal
      {
        background: yellow;
      }
      table
      {
        text-align: center;
        border-collapse: collapse;
      }
      td
      {
        padding: 5px;
        border: 1px solid black;
      }
    </style>
  </head>

  <body>

    <?php
      include 'functions.php';

      $table = create_table();
#      print_r($table);
      Show_table($table);
    ?>

  </body>

</html>
