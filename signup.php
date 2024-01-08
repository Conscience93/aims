<?php
session_start();
include("./include/db_connection.php");
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aims";

$conn = new mysqli($servername, $username, $password, $dbname);
$register_result=false;

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
if ($_SERVER['REQUEST_METHOD'] == "POST"){
$username = $_POST['username'];
$email = $_POST['email'];
$nric = $_POST['nric'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$date_created = date('Y-m-d H:i:s');
$full_name = $_POST['full_name'];
$company_name = $_POST['company_name'];

    // Insert data into the database

    if (!empty($username) && !empty($email) && !empty($nric) && !empty($password) && !empty($date_created) && !empty($full_name) && !empty($company_name) ){
        $sql = "INSERT INTO aims_user (username, email, nric, password, date_created, full_name, company_name) VALUES ('$username', '$email', '$nric' ,'$password', '$date_created', '$full_name', '$company_name')";

        if ($conn->query($sql) === TRUE) {
$register_result=true;

            echo '<script>openpopup();</script>';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>



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
	

		<!-- AIMS custom CSS -->
		

		<style type="text/css">
			@font-face {
				font-family: Quicksand;
				src: url("include/fonts/Quicksand/Quicksand-VariableFont_wght.ttf");
			}

			:root {
				font-family: Quicksand;

				/* darker green */
				--primary-dark: darkgreen;

                /* lime green */
				--primary-light: limegreen;

				/* dark olive green */
				--primary-default: #0aB68B;
				
				--footer-height: 30px;
			}

			body {
				background-color: var(--primary-default);
			}

			h3 {
				font-family: Helvetica, "Trebuchet MS", Verdana, sans-serif;
			}

			#form-container {
				display: flex;
				justify-content: center;
				align-items: center;
				height: auto;
			}

			.btn {
    align-items: center;
    background-color: #0aB68B;
    background-position: 0 0;
    border: 1px solid #ceffc3;
    border-radius: 11px;
    box-sizing: border-box;
    color: #ffffff;
    cursor: pointer;
    display: flex;
    font-size: 1rem;
    font-weight: 700;
    line-height: 33.4929px;
    list-style: outside url(https://www.smashingmagazine.com/images/bullet.svg) none;
    padding: 2px 12px;
    text-align: left;
    text-decoration: none;
    text-shadow: none;
    text-underline-offset: 1px;
    transition: border .2s ease-in-out,box-shadow .2s ease-in-out;
    user-select: none;
    -webkit-user-select: none;
    touch-action: manipulation;
    white-space: nowrap;
    word-break: break-word;
    }

    .btn:active,
    .btn:hover,
    .btn:focus {
    outline: 0;
    }

    .btn:active {
    background-color: #3da326;
    box-shadow: rgba(0, 0, 0, 0.12) 0 1px 3px 0 inset;
    }

    .btn:hover {
    background-color: darkgreen;
    border-color: #ceffc3;
    }

    .btn:active:hover,
    .btn:focus:hover,
    .btn:focus {
    background-color: #3da326;
    box-shadow: rgba(0, 0, 0, 0.12) 0 1px 3px 0 inset;
    }

			#form-logo {
				display: block;
				margin-left: auto;
				margin-right: auto;
				width: 8rem;
				height: 8rem;
				padding-bottom: 2rem;
			}

			#form-box-colour {
				background-color:  #ffe3b3;
				border-radius: 15px;
				width: 500px;
                height: 900px;
                margin-left: auto;
                margin-right: auto;
                margin-top: 35px;
				
			}

			#form-login {
				display: flex;
				flex-direction: column;
				justify-content: center;
				align-items: center;
				width: 100%;
				height: 8%;
                margin-top: 390px;
			}

			#form-error-message {
				font-size:12px;
				font-weight:bold;
				color:red;
				text-align:center;
				letter-spacing: 0.5px;
				position: relative;
				margin: 2rem 0 1rem 1rem;
			}

			#topbar {
				display: flex;
				justify-content: center;
				align-items: center;
				position: fixed;
				top: 0;
				width: 100%;
				height: var(--footer-height);
				background-color: var(--primary-dark);
				color: white;
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

			#background-video {
				position: fixed;
				top: 0;
				left: 0;
				min-width: 100%;
				min-height: 100%;
				width: auto;
				height: auto;
				z-index: -1;
			}

            .popup{
                width: 400px;
                background: #fff;
                border-radius: 6px;
                position: absolute;
                top: 0;
                left: 50%;
                transform: translate(-50%, -50%) scale(0.1);
                text-align: centre;
                padding: 0 30px 30px;
                color: #333;
                visibility: hidden;
                transition: transform 0.4s, top 0.4s;
            }

            .open-popup{
                visibility: visible;
                top: 50%;
                transform: translate(-50%, -50%) scale(1);
            }

            .popup img{
                width: 100px;
                margin-top: -50px;
                border-radius: 50%;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            }

            .popop h2{
                font-size: 38px;
                font-weight: 500;
                margin: 30px 0 10px;

            }

            .popup button{
                width: 100%;
                margin-top: 50px;
                padding: 10px 0;
                background: #6fd649;
                color: #fff;
                border: 0;
                outline: none;
                font-size: 18px;
                border-radius: 4px;
                cursor: pointer;
                box-shadow: 0 5px 5px rgba(0, 0, 0, 0.2);
            }
                

            

		</style>
	</head>
    <body>
        
        <div id="form-box-colour" class="p-3">
        <h2>Signup Form</h2>
        <form id="form-login" action="" method="post">
        
            <input type="text" placeholder="Username" class="form-control" id="username" name="username" required><br><br>
            
            <input type="email"  placeholder="Email" class="form-control" id="email" name="email" required><br><br>

            <input type="nric"  placeholder="NRIC" class="form-control" id="nric" name="nric" required><br><br>
            
            <input type="password"  placeholder="Password" class="form-control" id="password" name="password" required><br><br>

            <input type="full_name"  placeholder="Full Name" class="form-control" id="full_name" name="full_name" required><br><br>

            <input type="company_name"  placeholder="Company Name" class="form-control" id="company_name" name="company_name" required><br><br>

            <?php
                if($register_result){
            ?>
            <h3 style="color: black">Registered Successfully</h3>
            <?php
                $register_result=false;
                }
            ?>
            
            <input type="submit"  class="form-control mt-1 btn btn-primary" onclick="openpopup()" value="Sign Up"></br>
            <div class="popup" id="popup">
                <img src="include\img\tick.png" >
                <h2>Thank You !<h2>
                    <p>your details has been successfully submitted. Thanks!</p>
                    <button type="button" onclick="closepopup()" >OK</button>
            </div>
            <a href="/aims/login" class="form-control mt-1 btn btn-primary">Back</a>

            
        </form>
        </div>

        <script>
            let popup = document.getElementById("popup");

            function openpopup(){
                popup.classList.add("open-popup");
            }
            function closepopup(){
                popup.classList.remove("open-popup");
            }

        </script>
    </body>
</html>