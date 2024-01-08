<?php 
	include_once '../db_connection.php';
	session_start();
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);


	if (isset($_POST['login'])) {
		// Check connection
		if ($con->connect_error) {
			die("Connection failed: " . $con->connect_error);
		} 

		$email = $_POST['email'];
		$password = $_POST['password'];

		$valid_login = FALSE;

		//$sql = "SELECT * FROM aims_user WHERE email = '$email' AND status = 'ACTIVE'";
		$sql = "SELECT * FROM aims_user WHERE email = '$email'";
		$query = mysqli_query($con, $sql);
		if (mysqli_num_rows($query) > 0) {
			while($row = mysqli_fetch_assoc($query)) {
				if (password_verify($password, $row['password'])) {
					$_SESSION['aims_id'] = $row['id'];
					$_SESSION['aims_username'] = $row['username'];
					$_SESSION['aims_user_group_id'] = $row['user_group_id'];
					$_SESSION['aims_email'] = $row['email'];

					$valid_login = TRUE;
				}
			}
		}

		if ($valid_login) {
			$user_group_id = $_SESSION['aims_user_group_id'];

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

			if (isset($_POST['rememberme'])) {
				$email = $_POST['email'];
				$token = bin2hex(random_bytes(16)); // Generate a random token
				$cookie_expiry = time() + (60 * 60 * 24 * 30); // Cookie expires in 30 days (adjust as needed)
				
				// Set a cookie with the user's email and token
				setcookie('remember_user', $email . '|'. $token, $cookie_expiry, '/');
			}

			if ($submodule_access['dashboard']['view'] == 1) {
				header('location: /aims/dashboard');
			}

		} else {
			$_SESSION['error'] = "Invalid Login. Please check your login credentials and try again!";
			header('location: /aims');
		}
	}
?>