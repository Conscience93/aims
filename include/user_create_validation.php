<?php 
include_once './db_connection.php';

if (isset($_POST['type'])){
    if ($_POST['type']=="email") {
        $email = mysqli_escape_string($con, $_POST['email']);
        $emailSql = "SELECT * FROM aims_user WHERE email = '".$email."'";
        $emailResult = mysqli_query($con, $emailSql);
        $emailCount = mysqli_num_rows($emailResult);
        if($emailCount>0){
            //existing email
            echo trim("false");
        } else {
            echo trim("true");
        }
    }
}
?>