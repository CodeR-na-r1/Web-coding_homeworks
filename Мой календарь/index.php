<?php

include_once 'scripts/functions.php';
include_once 'scripts/data_arrays.php';
include_once 'scripts/Form_interaction.php';

if ($_POST) // Обработка запроса на добавление новой записи
{
  $My_form = new Form_interaction($_POST, $types, $durations);

  if ($My_form->save())
  {
    echo "Добавлено";
    $_POST = null;
    $data_relevance = false;
  }
}

if ($data == null || !$data_relevance)  // Получение данных из БД
{
  $data = Form_interaction::load_all();
  $data_relevance = true;
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
                    echo '<option' . (strcmp($type["name"], ($_POST['type'] ?? '')) ? '' : ' selected') . '>' . $type["name"] . '	</option>';
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
              <input type="date" name="date" value="<?= __clear($_POST['date'] ?? '') ?>" class="form_cont_field_input_date">
              <input type="time" name="time" value="<?= __clear($_POST['time'] ?? '') ?>">
            </div>
            <div class="form_cont_field">
              <label class="form_cont_label_header">Длительность:</label>
              <select class="form_cont_input_select" name="duration">
                <?php
                  foreach ($durations as $duration) {
                    echo '<option' . (strcmp($duration["name"], ($_POST['duration'] ?? '')) ? '' : ' selected') . '>' . $duration["name"] . '	</option>';
                  }
                ?>
              </select>
            </div>
            <div class="form_cont_field">
              <label class="form_cont_label_header">Комментарий:</label>
              <textarea name="comment" cols="55" rows="7" placeholder="Введите сюда комментарий к новой задаче"><?= __clear($_POST['comment'] ?? '');?></textarea>
            </div>

            <button class="form_cont_button" type="submit">Добавить</button>
          </form>
        </div>
      </div>
      <div class="list_cont">
        <h3 class="list_cont_header">Список задач</h3>
        <div class="list_cont_menu">
          <span>Фильтры: </span>
          <select class="element_for_filter" name="sort_by_progress">
            <option value="nothing" selected>Все задачи</option>
            <option value="now">Текущие задачи</option>
            <option value="over">Просроченные задачи</option>
            <option value="completed">Выполненные задачи</option>
          </select>
          <input class="element_for_filter" type="date" class="sort_by_date">
          <span class="element_for_filter" value="all">Все</span>
          <span class="element_for_filter" value="this_week">Эта неделя</span>
          <span class="element_for_filter" value="next_week">След. неделя</span>
          <span class="element_for_filter" value="this_month">Этот месяц</span>
          <span class="element_for_filter" value="next_month">След. месяц</span>
        </div>
        <div class="list_cont_tasks">
          <table>
            <thead>
              <tr>
                <th>Тип</th>
                <th>Задача</th>
                <th>Место</th>
                <th>Дата и время</th>
                <th>Длительность</th>
                <th>Комментарий</th>
                <th>Статус</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($data as $key => $value) { ?>
              <tr>
                <td><?= __clear($types[$value["type"] - 1]["name"]); ?></td>
                <td><?= __clear($value["topic"]); ?></td>
                <td><?= __clear($value["place"]); ?></td>
                <td><?= __clear($value["date"] . " " . $value["time"]); ?></td>
                <td><?= __clear($durations[$value["duration"] - 1]["name"]); ?></td>
                <td><?= __clear($value["comment"]); ?></td>
                <td><?= __clear($statuses[$value["status"] - 1]["name"]); ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <script src="script.js"></script>

  </body>
</html>