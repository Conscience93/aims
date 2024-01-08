<?php
	include_once '../../include/db_connection.php';
	session_start();

	$name = isset($_POST['name']) ? mysqli_escape_string($con,$_POST['name']) : '';

	if ($name != '') {
		$sql = "SELECT * FROM aims_computer WHERE name = '$name'";
		$query = mysqli_query($con, $sql);
		$result = mysqli_fetch_assoc($query);

		if ($result) {
			echo json_encode($result);
		}
	}
?>