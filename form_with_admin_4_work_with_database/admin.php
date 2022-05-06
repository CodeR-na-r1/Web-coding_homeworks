<?php
  include 'Form_interaction.php';

  include 'functions.php';

  if (isset($_POST['selected_id'])) {   // Здесь обработка запроса на удаление записей
    foreach ($_POST['selected_id'] as $key => $value) {
      $query = "UPDATE `participants` SET `is_deleted` = '1' WHERE id=:id LIMIT 1;";
      Database::exec($query, array(':id' => $value));
    }
  }

  // Считываем данные с файла
  $data = Form_interaction::load_all(); // return string

  $data_subjects = Database::exec("select name FROM `subjects`");
  $data_payments = Database::exec("select name FROM `payments`");
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
          <?php foreach ($data as $row): ?>
            <?php if ($row[10] == '1') {continue;} ?>  <!-- Проверка статуса заявки (метки о том, что она удалена) -->
            <tr>
              <td><input type="checkbox" name="selected_id[]" value="<?= __clear($row[0]); ?>"></td>  <!-- id -->
              <td><?= __clear($row[7]); ?></td>  <!-- Date -->
              <td><?= __clear($row[1]); ?></td>  <!-- Name -->
              <td><?= __clear($row[2]); ?></td>  <!-- Surame -->
              <td><?= __clear($row[4]); ?></td>  <!-- Phone -->
              <td><?= __clear($row[3]); ?></td>  <!-- Email -->
              <td><?= __clear($data_subjects[$row[5]]['name']); ?></td>  <!-- Subjects -->
              <td><?= __clear($data_payments[$row[6]]['name']); ?></td>  <!-- Payment method -->
              <td><?= __clear($row[9]); ?></td>  <!-- Client ip -->
              <td><?= __clear($row[8]); ?></td>  <!-- Confirm -->
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <br>
      <button type="submit">Delete</button>
    </form>
  </body>
</html>
