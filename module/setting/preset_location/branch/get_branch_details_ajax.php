<?php
	include_once '../../../../include/db_connection.php';
	session_start();

	$display_name = isset($_POST['display_name']) ? mysqli_escape_string($con,$_POST['display_name']) : '';

	if ($display_name != '') {
		$sql = "SELECT * FROM aims_preset_computer_branch WHERE display_name = '$display_name'";
		$query = mysqli_query($con, $sql);
		$result = mysqli_fetch_assoc($query);

		if ($result) {
			echo json_encode($result);
		}
	}
?>