<?php
 function __clear($value='')
 {
 	return htmlspecialchars($value);
 }

	if (isset($_GET['ok'])) {
		echo 'Спасибо, ваша заявка принята!';
	}

	include 'config.php';

	$cities = ['Irkutsk', 'Angarsk', 'Shelekhov', 'Bratsk', 'Ulan Ude'];

	if ($_POST)		// Восстановление данных в форме при обновлении страницы
	{
		$data_errors = [];

		$name = $_POST['name'] ?? null;
		$company = $_POST['company'] ?? null;
		$city = $_POST['city'] ?? null;

		$confirm = (bool)($_POST['confirm'] ?? 0);

		if (!$name)
		{
			$data_errors[] = 'Name is required';
		}
		if (!$company)
		{
			$data_errors[] = 'Company is required';
		}

		if (!$data_errors) {
			$contents = '';
			# id + fix_filename + save_to_end_row
      $contents .= uniqid() . $separator;
			$contents .= $name . $separator;
			$contents .= $company . $separator;
			$contents .= $city . $separator;
      $contents .= date('Y-m-d_H-i-s') . $separator;
			$contents .= ($confirm ? '1' : '0') . $separator . "\n";

			if (!file_exists($name_data_folder)) {
				mkdir($name_data_folder, 0777);
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
			<label>Company:</label>
			<input type="text" name="company" value="<?= __clear($_POST['company'] ?? '') ?>">
			<br>
			<label>City:</label>
			<select name="city">
				<?php
					foreach ($cities as $city) {
						echo '<option' . (strcmp($city, $_POST['city']) ? '' : ' selected') . '>' . $city . '	</option>';
					}
				 ?>
			</select>
			<br>
			<label>
				<input type="hidden" name="confirm" value="">
				<input type="checkbox" name="confirm" value="yes">
				Confirm
			</label>
			<br>
			<button type="submit">submit</button>
		</form>
	</div>

</body>
</html>
