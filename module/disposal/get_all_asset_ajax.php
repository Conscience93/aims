<?php
	include_once '../../include/db_connection.php';
	session_start();

    $asset_tag = isset($_POST['asset_tag']) ? mysqli_escape_string($con,$_POST['asset_tag']) : '';
	$name = isset($_POST['name']) ? mysqli_escape_string($con,$_POST['name']) : '';
	$category = isset($_POST['category']) ? mysqli_escape_string($con,$_POST['category']) : '';

	if ($name != '') {
		$sql = "SELECT category, asset_tag, name FROM aims_asset
                WHERE asset_tag = '$asset_tag' AND name = '$name' AND category = '$category'
                UNION
                SELECT category, asset_tag, name FROM aims_computer
                WHERE asset_tag = '$asset_tag' AND name = '$name' AND category = '$category'
                UNION
                SELECT category, asset_tag, name FROM aims_electronics
                WHERE asset_tag = '$asset_tag' AND name = '$name' AND category = '$category'";
		$query = mysqli_query($con, $sql);
		$result = mysqli_fetch_assoc($query);

		if ($result) {
			echo json_encode($result);
		}
	}
?>