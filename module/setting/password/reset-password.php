<head>
    <!-- Sweet Alert -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
</head>
<style>
  *{
    font-size: 25px;
  }
</style>
<?php
include_once "../../include/db_connection.php";
session_start();
date_default_timezone_set("Asia/Kuching");

//check token for password reset
if (isset($_GET["key"]) && isset($_GET["phone"]) && isset($_GET["action"]) 
&& ($_GET["action"]=="reset") && !isset($_POST["action"])){
  $key = $_GET["key"];
  $phone = $_GET["phone"];
  $curDate = date("Y-m-d H:i:s");
  $sql= "SELECT * FROM password_reset_temp WHERE `key`='$key' AND `phone`='$phone'";
  $result= mysqli_query($con, $sql);
    
    if (mysqli_num_rows($result) == 0) {
        echo "<div >".
        "<script>swal('Link expired', 'Either you did not copy the correct link from the whatsapp, or you have already used the key in which case it is deactivated.', 'error');
        setTimeout(function() {
            window.location.href = 'http://localhost/aims';
        }, 5000); // Redirect after 5 seconds (5000 milliseconds)
        </script>"."</div><br/>";

    }else{
        $row = mysqli_fetch_assoc($result);
        $expDate = $row['expDate'];

        if ($expDate >= $curDate){
        ?>
        <br/>
        <div class="container">
            <form method="post" action="http://localhost/aims/forgot_password/update-password.php" name="update">
            <input type="hidden" name="action" value="update" />
            <br/><br/>
            <label><strong>Enter New Password:</strong></label><br/>
            <input type="password" name="pass1" required />
            <br/><br/>
            <label><strong>Re-Enter New Password:</strong></label><br/>
            <input type="password" name="pass2" required/>
            <br/><br/>
            <input type="hidden" name="phone" value="<?php echo $phone;?>"/>
            <input type="submit" value="Reset Password" />
            </form>
        </div>
        <?php

        }else{
        echo "<div>"."<script>swal('Link Expired', 'The link is expired. You are trying to use the expired link which as valid only 10 minutes (10 minutes after request)', 'error');
            setTimeout(function() {
                window.location.href = 'http://localhost/aims';
            }, 5000); // Redirect after 5 seconds (5000 milliseconds)
            </script>"."</div>;";
            }
        }		
}//finish checking token valid

?>

<style>
.container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 98vh;
}


form {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 20px;
  background-color: #f2f2f2;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
  font-family: Arial, sans-serif;
  width: 100%;
  height: 100%;
}

label {
  margin-bottom: 10px;
  font-weight: bold;
  font-size: 1.5rem;
}

input[type="password"] {
  width: 100%;
  padding: 0.5rem;
  margin-bottom: 20px;
  border: none;
  border-radius: 3px;
  box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
  height: 2rem;
  font-size: 2rem;
}

input[type="submit"] {
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 3px;
  padding: 10px;
  cursor: pointer;
  font-size: 2rem;
}
</style>