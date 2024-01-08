<?php
	session_start();
	// admin@dev.com
	$email = $_SESSION['aims_email'];

	$sql = "SELECT * FROM aims_user WHERE email = '$email'";
	$query = mysqli_query($con, $sql);
	$result = mysqli_fetch_assoc($query);
	$user_group_id = $result['user_group_id'];

	$sql = "SELECT
				aims_module.module,
				aims_submodule.submodule,
				aims_submodule_access.crud,
				aims_submodule_access.approve1,
				aims_submodule_access.approve2
			FROM
				aims_submodule
			JOIN aims_module ON aims_module.id = aims_submodule.module_id
			JOIN aims_submodule_access ON aims_submodule.id = aims_submodule_access.submodule_id
			WHERE aims_submodule_access.user_group_id = '$user_group_id'
			";
	$query = mysqli_query($con, $sql);

	$submodule_access = [];

	while ($row = mysqli_fetch_assoc($query)) {
		$crud = $row['crud'];
		$submodule_access[$row['submodule']] = array(
			'view' => ($crud & 0b1000) ? 1 : 0,
			'add' => ($crud & 0b0100) ? 1 : 0,
			'edit' => ($crud & 0b0010) ? 1 : 0,
			'delete' => ($crud & 0b0001) ? 1 : 0,
			'approve1' => $row['approve1'],
			'approve2' => $row['approve2']
		);
	}
?>