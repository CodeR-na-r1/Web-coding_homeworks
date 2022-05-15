<?php

include 'scripts/functions.php';
include 'scripts/data_arrays.php';
include 'scripts/Form_interaction.php';

if ($_POST)
{
  $My_form = new Form_interaction($_POST);
  
  if ($My_form->save())
  {
    echo "Добавлено";
  }

}

?>

<!DOCTYPE html>
<html lang="ru" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="styles/style.css">
    <title>Мой календарь</title>
  </head>
  <body>
    <div class="main_cont">
      <h1 class="main_cont_header">Мой календарь</h1>
      <div class="task_cont">
        <h3 class="task_cont_header">Новая задача</h3>
        <div class="form_cont">
          <form method="POST" action="">
            <div class="form_cont_field">
              <label class="form_cont_label_header">Тема:</label>
              <input class="form_cont_input_item" type="text" name="topic" value="<?= __clear($_POST['topic'] ?? '') ?>">
            </div>
            <div class="form_cont_field">
              <label class="form_cont_label_header">Тип:</label>
              <select class="form_cont_input_select" name="type">
                <?php
                  foreach ($types as $type) {
                    echo '<option' . (strcmp($type, ($_POST['type'] ?? '')) ? '' : ' selected') . '>' . $type . '	</option>';
                  }
                ?>
              </select>
            </div>
            <div class="form_cont_field">
              <label class="form_cont_label_header">Место:</label>
              <input class="form_cont_input_item" type="text" name="place" value="<?= __clear($_POST['place'] ?? '') ?>">
            </div>
            <div class="form_cont_field">
              <label class="form_cont_label_header">Дата и время:</label>
              <input type="date" name="date" value="<?= __clear($_POST['date'] ?? '') ?>">
              <input type="time" name="time" value="<?= __clear($_POST['time'] ?? '') ?>">
            </div>
            <div class="form_cont_field">
              <label class="form_cont_label_header">Длительность:</label>
              <select class="form_cont_input_select" name="duration">
                <?php
                  foreach ($durations as $duration) {
                    echo '<option' . (strcmp($duration, ($_POST['duration'] ?? '')) ? '' : ' selected') . '>' . $duration . '	</option>';
                  }
                ?>
              </select>
            </div>
            <div class="form_cont_field">
              <label class="form_cont_label_header">Комментарий:</label>
              <textarea name="comment" cols="55" rows="7" placeholder="Введите сюда комментарий к новой задаче"></textarea>
            </div>

            <button class="form_cont_button" type="submit">Добавить</button>
          </form>
        </div>
      </div>
      <div class="list_cont">
        <h3 class="list_cont_header">Список задач</h3>
      </div>
    </div>
  </body>
</html>