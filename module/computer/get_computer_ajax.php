<?php
	include_once '../../include/db_connection.php';
	session_start();

	$name = isset($_POST['name']) ? mysqli_escape_string($con,$_POST['name']) : '';
	$category = isset($_POST['category']) ? mysqli_escape_string($con,$_POST['category']) : '';
	$price = isset($_POST['price']) ? mysqli_escape_string($con,$_POST['price']) : '';
	$processor = isset($_POST['processor']) ? mysqli_escape_string($con,$_POST['processor']) : '';


	if ($name != '') {
		$sql = "SELECT * FROM aims_computer WHERE name = '$name' AND category = '$category' AND price = '$price' AND processor = '$processor'";
		$query = mysqli_query($con, $sql);
		$result = mysqli_fetch_assoc($query);

		if ($result) {
			echo json_encode($result);
		}
	}
?>