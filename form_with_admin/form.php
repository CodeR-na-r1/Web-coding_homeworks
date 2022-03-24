<?php
 function __clear($value='')
 {
 	return htmlspecialchars($value);
 }

	if (isset($_GET['ok'])) {
		echo 'Спасибо, ваша заявка принята!';
	}

	include 'config.php';

	$topics = ['business', 'Technology', 'Advertising and Marketing'];
  $payment_methods = ['WebMoney', 'Yandex money', 'PayPal', 'Credit card'];

	if ($_POST)		// Восстановление данных в форме при обновлении страницы
	{
		$data_errors = [];

		$name = $_POST['name'] ?? null;
    $family = $_POST['family'] ?? null;
    $email = $_POST['email'] ?? null;
    $phone = $_POST['phone'] ?? null;
		$topic = $_POST['topic'] ?? null;
		$payment = $_POST['payment'] ?? null;

		$confirm = (bool)($_POST['confirm'] ?? 0);

		if (!$name)
		{
			$data_errors[] = 'Name is required';
		}
		if (!$family)
		{
			$data_errors[] = 'Family is required';
		}
		if (!$email)
		{
			$data_errors[] = 'Email is required';
		}
		if (!$phone)
		{
			$data_errors[] = 'Phone is required';
		}
		if (!$topic)
		{
			$data_errors[] = 'Topic is required';
		}
		if (!$payment)
		{
			$data_errors[] = 'Payment method is required';
		}

		if (!$data_errors) {  // При отсутствии ошибок,формируем данные и пихаем в файл
			$contents = '';
      $contents .= uniqid() . $separator; // id
			$contents .= $name . $separator; // name
			$contents .= $family . $separator; // family
			$contents .= $email . $separator; // email
			$contents .= $phone . $separator; // phone
			$contents .= $topic . $separator; // topic
			$contents .= $payment . $separator; // payment
      $contents .= time() . $separator; // date
			$contents .= ($confirm ? '1' : '0') . "\n"; // confirm

      if (!file_exists($name_data_folder)) {
				mkdir($name_data_folder, 0777);   // имя и права в 8-ой сист. счисления
			}

			file_put_contents($name_data_folder . '/' . $filename, $contents, FILE_APPEND | LOCK_EX);

			header('Location: /form.php?ok=1');
			exit;

		} else
		{
			echo '<ul style="color:red;">';
			foreach ($data_errors as $error) {
				echo '<li>' . $error . '</li>';
			}
			echo '</ul>';
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
