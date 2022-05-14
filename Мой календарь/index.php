<?php

include 'scripts/functions.php';

?>

<!DOCTYPE html>
<html lang="ru" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="style.css">
    <title>Мой календарь</title>
  </head>
  <body>
    <div class="form_container">
      <center><h3>Новая задача</h3></center>
      <form method="POST" action="">
        <label>Тема:</label>
        <input type="text" name="topic" value="<?= __clear($_POST['topic'] ?? '') ?>">
        <br>
        <label>Тип:</label>
        <select name="type">
          <?php
            foreach ($types as $type) {
              echo '<option' . (strcmp($type, ($_POST['type'] ?? '')) ? '' : ' selected') . '>' . $type . '	</option>';
            }
           ?>
        </select>
        <br>
        <label>Место:</label>
        <input type="text" name="place" value="<?= __clear($_POST['place'] ?? '') ?>">
        <br>
        <label>Дата и время:</label>
        <input type="date" name="date" value="<?= __clear($_POST['date'] ?? '') ?>">
        <input type="time" name="time" value="<?= __clear($_POST['time'] ?? '') ?>">
        <br>
        <label>Длительность:</label>
        <select name="duration">
          <?php
            foreach ($durations as $duration) {
              echo '<option' . (strcmp($duration, ($_POST['duration'] ?? '')) ? '' : ' selected') . '>' . $duration . '	</option>';
            }
           ?>
        </select>
        <br>
        <label>Комментарий:</label>
        <select name="payment">
          <?php
            foreach ($payment_methods as $payment) {
              echo '<option' . (strcmp($payment, ($_POST['payment'] ?? '')) ? '' : ' selected') . '>' . $payment . '	</option>';
            }
           ?>
        </select>
        <br>
        <label>
          <input type="hidden" name="confirm" value="">
          <input type="checkbox" name="confirm" value="1">
          Receive conference newsletter
        </label>
        <br>
        <button type="submit">Submit</button>
      </form>
    </div>

  </body>
</html>
