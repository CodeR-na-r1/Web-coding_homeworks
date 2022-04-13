<?php
  include 'Form_interaction.php';

  function __clear($value='')
  {
  	return htmlspecialchars($value);
  }

  if (isset($_POST['selected_id'])) {   // Здесь обработка запроса на удаление записей
    $contents = Form_interaction::load_all();
    $content_rows = explode("\n", $contents);

    for ($i=0; $i < count($_POST['selected_id']); $i++) {
      foreach ($content_rows as $key => $data) {
        if ( strcmp($_POST['selected_id'][$i], explode(Form_interaction::$separator, $data)[0]) == 0) {
          //array_splice($content_rows, $key, 1);
          $edit_data = explode(Form_interaction::$separator, $data);
          $edit_data[10] = 0;
          $content_rows[$key] = implode(Form_interaction::$separator, $edit_data);
          break;
        }
      }
    }

    Form_interaction::save_all(implode("\n", $content_rows));
  }

  // Считываем данные с файла
  $data = Form_interaction::load_all(); // return string
  $rows = explode("\n", $data);  //  return array из string
?>

<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <title>Страница админа</title>
  	<link rel="stylesheet" href="style.css">
  </head>
  <body>
    <h2>Admin</h2>
    <form method="POST">
      <table>
        <!-- Заголовки -->
        <thead>
          <th></th>   <!-- Choise for deleting -->
          <th>Date</th>
          <th>Name</th>
          <th>Family</th>
          <th>Phone</th>
          <th>Email</th>
          <th>Topic</th>
          <th>Payment method</th>
          <th>Client ip</th>
          <th>Confirm</th>
        </thead>

        <tbody>
        <!-- Данные -->
          <?php foreach ($rows as $row): ?>
            <?php $data_row = explode(Form_interaction::$separator, trim($row)) ?>  <!-- Если нет нашего разделителя в данных, то функция вернет массив из одного элемента (ниже проверка) -->
            <?php if (count($data_row) != 11) {continue;} ?>  <!-- Проверка на наличие и корректное количество вхождений нашего разделителя. -->
            <?php if ($data_row[10] == '0') {continue;} ?>  <!-- Проверка статуса заявки (метки о том, что она удалена) -->
            <tr>
              <td><input type="checkbox" name="selected_id[]" value="<?= __clear($data_row[0]); ?>"></td>  <!-- id -->
              <td><?= __clear(date('d.m.y H.i', $data_row[7])); ?></td>  <!-- Date -->
              <td><?= __clear($data_row[1]); ?></td>  <!-- Name -->
              <td><?= __clear($data_row[2]); ?></td>  <!-- Surame -->
              <td><?= __clear($data_row[4]); ?></td>  <!-- Phone -->
              <td><?= __clear($data_row[3]); ?></td>  <!-- Email -->
              <td><?= __clear($data_row[5]); ?></td>  <!-- Topics -->
              <td><?= __clear($data_row[6]); ?></td>  <!-- Payment method -->
              <td><?= __clear($data_row[9]); ?></td>  <!-- Client ip -->
              <td><?= __clear($data_row[8]); ?></td>  <!-- Confirm -->
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <br>
      <button type="submit">Delete</button>
    </form>
  </body>
</html>
