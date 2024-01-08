<?php
include_once '../../../include/db_connection.php';
session_start();

date_default_timezone_set("Asia/Kuala_Lumpur");
$date = date('Y-m-d');
$time = date('H:i:s');

function escapeInput($input) {
    global $con;
    return mysqli_real_escape_string($con, $input);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = escapeInput($_POST['name']);
    $description = escapeInput($_POST['description']);
    $id = $_POST['id'];

    $sqlUserGroup = "UPDATE aims_user_group SET 	
                                user_group_name 		    = '".$name."',
                                description 				= '".$description."'
                                WHERE id                    = '".$id."'";

    if (mysqli_query($con, $sqlUserGroup)) {
        echo "true";
    } else {
        echo mysqli_error($con);
    }

} else {
    echo "Form not submitted.";
}
?>