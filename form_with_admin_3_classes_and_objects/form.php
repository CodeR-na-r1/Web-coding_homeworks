<?php

include 'Form_interaction.php';

 function __clear($value='')
 {
  	return htmlspecialchars($value);
  }

	if (isset($_GET['ok'])) {
		echo 'Спасибо, ваша заявка принята!';
	}

	$topics = ['business', 'Technology', 'Advertising and Marketing'];
  $payment_methods = ['WebMoney', 'Yandex money', 'PayPal', 'Credit card'];

	if ($_POST)		// Восстановление данных в форме при обновлении страницы
	{
		$My_form = new Form_interaction($_POST);

    if ($My_form->save())
    {
      header('Location: /form.php?ok=1');
      exit;
    }
	}
	?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Форма</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>

	<div class="form_cont">
		<center><h3>Form</h3></center>
		<form method="POST" action="">
			<label>Name:</label>
			<input type="text" name="name" value="<?= __clear($_POST['name'] ?? '') ?>">
			<br>
  		<label>Family:</label>
  		<input type="text" name="family" value="<?= __clear($_POST['family'] ?? '') ?>">
  		<br>
      <label>Email:</label>
      <input type="email" name="email" value="<?= __clear($_POST['email'] ?? '') ?>">
      <br>
      <label>Phone:</label>
      <input type="number" name="phone" value="<?= __clear($_POST['phone'] ?? '') ?>">
      <br>
			<label>Topic:</label>
			<select name="topic">
				<?php
					foreach ($topics as $topic) {
						echo '<option' . (strcmp($topic, ($_POST['topic'] ?? '')) ? '' : ' selected') . '>' . $topic . '	</option>';
					}
				 ?>
			</select>
			<br>
      <label>Payment method:</label>
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
				<input type="checkbox" name="confirm" value="yes">
				Receive conference newsletter
			</label>
			<br>
			<button type="submit">Submit</button>
		</form>
	</div>

</body>
</html>
