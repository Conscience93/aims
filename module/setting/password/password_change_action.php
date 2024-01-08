<?php
	include_once 'include/db_connection.php';
	session_start();
	
    if(isset($_POST["submit"])) {
		// Check connection
		if ($con->connect_error) {
			die("Connection failed: " . $con->connect_error);
		}

		$old_password = $_POST['old_pwd'];
		$new_password = $_POST['new_pwd'];
        // $new_cpassword = $_POST['new_cpwd'];
		// For now, no verification for old and new passwords, aka can have same old and new passwords together

		$hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

		$sql_q = mysqli_query($con, "SELECT * FROM aims_user WHERE id = '".$_SESSION['aims_id']."'");

		while ($row = mysqli_fetch_assoc($sql_q)) {
			// old password does not match
			if (!password_verify($old_password, $row['password'])) { 
				$_SESSION['message'] = "<div class='alert alert-danger'>
										Old password does not match! Please enter again!
											<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
												<span aria-hidden='true'>&times;</span>
											</button>
										</div>";
                echo "<script>window.location='../../main.php?page=password'</script>";
			} else {
				// update password
                $sql = "UPDATE aims_user SET password = '".$hashed_new_password."' WHERE id = '".$_SESSION['aims_id']."' ";
				if(mysqli_query($con, $sql)) {	
					$_SESSION['message'] = "<div class='alert alert-success'>
												Password has been updated successfully!
												<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
													<span aria-hidden='true'>&times;</span>
												</button>
											</div>";
                    echo "<script>window.location='../../main.php?page=password'</script>";
	            } else {
	               	echo "Error: " . $sql . "" . mysqli_error($con);
	            }                   
			}
		}
			
		$con->close();
	}
	
?>