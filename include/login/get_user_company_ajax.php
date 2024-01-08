<?php
	include_once '../db_connection.php';
	session_start();

	$email = isset($_POST['email']) ? mysqli_escape_string($con,$_POST['email']) : '';

	if ($email != '') {
		// $sql = "SELECT * FROM stc_user WHERE email = '$email' AND status = 'ACTIVE'";
		$sql = "SELECT * FROM aims_user WHERE email = '$email'";
		$query = mysqli_query($con, $sql);
		$result = mysqli_fetch_assoc($query);
		// echo strtoupper($result['company_name']);

		if ($result) {
			$sql = "SELECT * FROM aims_user WHERE user_group_id = '" . $result['user_group_id'] . "'";
			$query = mysqli_query($con, $sql);
			$result = mysqli_fetch_assoc($query);
			echo $result['company_name'];
		}
	}
?>