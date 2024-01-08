<?php
	include_once '../../../include/db_connection.php';

	if (isset($_POST)) {
		$user_group_id = $_POST['user_group_id'];
		$name = $_POST['name'];
		$submodule = $_POST['submodule'];
		$is_checked = $_POST['is_checked'];

		$sql = "SELECT id FROM aims_submodule WHERE submodule = '$submodule'";
		$query = mysqli_query($con, $sql);
		$result = mysqli_fetch_assoc($query);
		$submodule_id = $result['id'];

		$crud = '';

		switch ($name) {
			case 'view':
				$crud = $is_checked == 1 ? 0b1000 : 0b0000;
				break;
			case 'add':
				$crud = $is_checked == 1 ? 0b1100 : 0b1000;
				break;
			case 'edit':
				$crud = $is_checked == 1 ? 0b1110 : 0b1100;
				break;
			case 'delete':
				$crud = $is_checked == 1 ? 0b1111 : 0b1110;
				break;
		}

		$sql = "UPDATE aims_submodule_access SET crud = $crud 
				WHERE user_group_id = '$user_group_id' AND submodule_id = '$submodule_id'";

		$query = mysqli_query($con, $sql);

		if ($query) {
			echo 'Updated submodule access.';
		}
	}
?>