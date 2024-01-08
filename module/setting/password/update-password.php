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

//update password in aims_user table
if(isset($_POST["phone"]) && isset($_POST["action"]) &&($_POST["action"]=="update")){
  $pass1 = mysqli_real_escape_string($con,$_POST["pass1"]);
  $pass2 = mysqli_real_escape_string($con,$_POST["pass2"]);
  $phone = $_POST["phone"];
  $curDate = date("Y-m-d H:i:s");
  
  if ($pass1!=$pass2){
      echo "<div>"
      ."<script>
      swal('Password Unmatched','Both password must be same.', 'error');
      setTimeout(function(){ 
        history.back(); 
      }, 5000);</script>"
      ."</div><br/>;";
  }else{
      $hashed_password = md5($pass1);
      mysqli_query($con,
      "UPDATE `users` SET `password` = '$hashed_password' WHERE `phone` = '".$phone."';");
      //if no record in aims_user, ask to create account, else proceed
      if (mysqli_affected_rows($con) == 0) {
        mysqli_query($con,"DELETE FROM `password_reset_temp` WHERE `phone`='".$phone."';");
        echo "<div>"
        ."<script>
        swal('No account found','Please register your account with Frontdesk.', 'error');
        setTimeout(function(){ 
          window.location.href = 'http://localhost/aims';
        }, 5000);</script>"
        ."</div><br/>;";
      }else{
        mysqli_query($con,"DELETE FROM `password_reset_temp` WHERE `phone`='".$phone."';");
        echo "<div>" 
        ."<script>
            swal('Password successfully updated', 'Please login your account with the new password', 'success');
            setTimeout(function() {
              window.location.href = 'http://localhost/aims';
            }, 5000);
        </script>"
        ."</div><br />";
      }
  }		
}
?>