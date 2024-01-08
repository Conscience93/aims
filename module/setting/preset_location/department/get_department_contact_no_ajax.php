<?php
	include_once '../../../include/db_connection.php';
	session_start();

	$display_name = isset($_POST['name']) ? mysqli_escape_string($con,$_POST['name']) : '';

	if ($display_name != '') {
		$sql = "SELECT contact_number FROM aims_preset_department WHERE display_name = '$display_name'";
		$query = mysqli_query($con, $sql);
		$result = mysqli_fetch_assoc($query);

		if ($result) {
			echo json_encode($result);
		}
	}
?>