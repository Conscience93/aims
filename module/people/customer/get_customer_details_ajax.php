<?php
	include_once '../../../include/db_connection.php';
	session_start();

	$supplier = isset($_POST['display_name']) ? mysqli_escape_string($con,$_POST['display_name']) : '';

	if ($supplier != '') {
		$sql = "SELECT * FROM aims_people_customer WHERE display_name = '$display_name'";
		$query = mysqli_query($con, $sql);
		$result = mysqli_fetch_assoc($query);

		if ($result) {
			echo json_encode($result);
		}
	}
?>