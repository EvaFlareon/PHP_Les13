<?php

$connect = mysqli_connect("localhost", "root", "", "netology");
$sql = "select * from tasks";

if (!empty($_POST)) {
	if ($_POST['add'] && $_POST['adding'] !== '') {
		mysqli_query($connect, 'INSERT INTO `tasks`(`description`) VALUES ("'.$_POST['adding'].'")');
		header('Location: index.php');
	}
	
	foreach ($_POST as $key => $value) {
		if ($key[0] === 'c' && $value != '') {
			$i = substr($key, 1);
			mysqli_query($connect, "update tasks set is_done = 1 where id = ".$i);
			header('Location: index.php');
		}

		if ($key[0] === 'd' && $value != '') {
			$i = substr($key, 1);
			mysqli_query($connect, "delete from tasks where id = ".$i);
			header('Location: index.php');
		}
	}
}

$res = mysqli_query($connect, $sql);

?>

<!doctype>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<title>Работа с БД (2-е занятие)</title>
	<style>
		table {
			margin-top: 5px;
			border-collapse: collapse;
		}
		th, td {
			border: 1px solid grey;
		}
	</style>
</head>
<body>
	<h1>Список дел на сегодня</h1>
	<form action="" method="post">
		<table>
			<input type="text" name="adding"><input type="submit" name="add" value="Добавить">			
			<tr style="background-color: #eeeeee">
				<td>id</td>
				<td>description</td>
				<td>is_done</td>
				<td>date_added</td>
			</tr>
			<?php while ($data = mysqli_fetch_array($res)) { ?>
			<tr>
				<td><?php echo $data['id']; ?></td>
				<td><?php echo $data['description']; ?></td>
				<td><?php echo $data['is_done']; ?></td>
				<td><?php echo $data['date_added']; ?></td>
				<td style="border: none"><input type="submit" name="<?= 'c'.$data['id']; ?>" value="Выполнить"></td>
				<td style="border: none"><input type="submit" name="<?= 'd'.$data['id']; ?>" value="Удалить"></td>
			</tr>
			<? } ?>
		</table>
	</form>
</body>
</html>
