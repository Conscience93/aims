<?php
	session_start();
	if (isset($_COOKIE['remember_user'])) {
		list($saved_email, $token) = explode('|', $_COOKIE['remember_user'], 3);

		echo "<script>document.addEventListener('DOMContentLoaded', () => {
			document.getElementById('email').value = '". htmlspecialchars($saved_email) ."';
			getUserGroup(document.getElementById('email').value);
			getUserCompany(document.getElementById('email').value);
		});</script>";
	}
?>

<style>
	body{
		margin:0;
		padding:0;
		font-family:Quicksand;
		src: url("include/fonts/Quicksand/Quicksand-VariableFont_wght.ttf");
		height:100vh;
		overflow:hidden;
		background-image: url('./include/img/background.png');
		background-size: cover; 
    	background-repeat: no-repeat; 
	}

	h3{
		text-align:center;
		margin-top:50px;
	}

	.center{
		position:absolute;
		top:50%;
		left:50%;
		transform:translate(-50% , -50%);
		width:400px;
		border-radius:10px;
		background-color:white;
	}

	.center h1{
		text-align:center;
		padding:0 0 20px 0;
		border-bottom:1px solid silver;
	}

	.center form{
		padding:0 30px;
		box-sizing:border-box;
	}
	.txt_field{
		margin-top:10px;
	}

	.txt_field input {
		width: calc(100% - 110px); /* Adjust width of input based on label width */
		border: 1px solid #ccc;
		border-radius: 5px;
		box-sizing: border-box;
		transition: border-color 0.3s ease;
	}

	.txt_field input:focus {
		border-color: #007bff; /* Change the border color on focus */
	}


	.remember_forget {
		display: flex; /* Use flexbox for layout */
		justify-content: space-between; /* Space items evenly */
		align-items: center; /* Center items vertically */
	}

	.forget_password{
		margin: -5px 0 20px 5px;
		cursor:pointer;
	}

	.remember_me {
		/* Optional styling for individual elements */
		margin: 20px; /* Add some margin between the elements */
	}

	.forget_password {
		/* Optional styling for individual elements */
		margin: 5px; /* Add some margin between the elements */
	}

	.forget_password:hover{
		text-decoration:underline;
	}

	#footer {
		display: flex;
		justify-content: center;
		align-items: center;
		position: fixed;
		bottom: 0;
		width: 100%;
		height: var(--footer-height);
		color: white;
	}

	#form-logo {
		display: block;
		margin-left: auto;
		margin-right: auto;
		width: 8rem;
		height: 8rem;
		padding-bottom: 2rem;
	}

</style>

<html>
	<head>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="include/icon/favicon.ico">
		<title>Assets Information and Management System</title>

		<!-- Bootstrap core CSS -->
		<link rel="stylesheet" href="include/css/bootstrap.min.css">

		<script>
			
		</script>

</head>
<body>

	<div class = "center"><br>
		<img src="include/img/aims_logo_design_by_boss.png" style = " padding-left:50px; height:75px; width:385px;" alt="AIMS LOGO">
		<hr></hr>
		<form id="form-login" method="post" action="include/login/login.php" autocomplete="off">

			<div class = "txt_field">
				<label>Email:</label><input style="margin-left:43px;"  type="text" id="email" name="email" autofocus oninput = "getUserGroup(this.value), getUserCompany(this.value)" required>
			</div>

			<div class = "txt_field">
				<label>Password:</label><input style="margin-left:15px;" type="password" id="password" name="password">
				<span><img src="include/action/hide.png" alt="Show Password" onclick="togglePassword()" id="show-password" style="width:20px;"></span>
			</div>

			<div class = "txt_field">
				<label>Role:</label><input  style="margin-left:51px;"  type="text" id="email_group" name="email_group" placeholder="" readonly>
			</div>

			<div class = "txt_field">
				<label>Company:</label><input style="margin-left:15px;"  type="text" id="email_company" name="email_company" placeholder="" readonly>
			</div>

			<div class="remember_forget">
				<div class ="remember_me">
					<input type="checkbox" class="form-check-input" name="rememberme" id="rememberme" checked>
					<label class="form-check-label" for="rememberme">Remember Me</label>
				</div>

				<div class ="forget_password">
					Forget <a href= "module/forgot_password/index.php"> Password? </a>
					<?php
					if(isset($_SESSION['error']))
						{
						echo '<div id="form-error-message"><span>'.$_SESSION['error'].'</span></div>';
						}
						unset($_SESSION['error']);
					?>
				</div>
			</div>
			<input type="submit" class="form-control mt-4 btn btn-primary" value="Log In" name="login">
		</form>	
	</div>

	<div id="footer">
		<strong class="ml-2 mr-2">Assets Information and Management System</strong>|<span class="ml-2 mr-2">Developed by Softworld Software Sdn Bhd © 2023</span>
	</div>
</body>

	
<script src="include/js/jquery-2.1.3.min.js"></script>
	<script src="include/js/bootstrap.min.js"></script>
	<script>
		function getUserGroup(email){
			// console.log(email);
			$.ajax({
				type: "POST",
				url: "include/login/get_user_group_ajax.php",
				data: "email=" + email,
				cache: true,
				success: function (result) {
					// console.log(result);
					$("#email_group").attr("placeholder", result.trim());
				}
			});
		}

		function getUserCompany(email){
			// console.log(email);
			$.ajax({
				type: "POST",
				url: "include/login/get_user_company_ajax.php",
				data: "email=" + email,
				cache: true,
				success: function (result) {
					// console.log(result);
					$("#email_company").attr("placeholder", result.trim());
				}
			});
		}

		function togglePassword() {
			var passwordInput = document.getElementById("password");
			var showPasswordButton = document.getElementById("show-password");

			if (passwordInput.type === "password") {
				passwordInput.type = "text";
				showPasswordButton.src = "include/action/show.png"; // Change to the image for hiding password
			} else {
				passwordInput.type = "password";
				showPasswordButton.src = "include/action/hide.png"; // Change to the image for showing password
			}
		}
	</script>
</body>
</html>