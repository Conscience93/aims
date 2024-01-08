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
    $id = $_POST['id'];
    $number = $_POST['number']; // number of user having this user group

    $sqlUserGroup = "UPDATE aims_user_group SET 	
                                status 		            = 'INACTIVE'
                                WHERE id                = '".$id."'";

    if (mysqli_query($con, $sqlUserGroup)) {
        // Remove access
        $i = 1;
        while($i <= 100)
        {
            $sql_user_group_access = "DELETE FROM aims_submodule_access WHERE user_group_id = '$id'";
            $query_user_group_access = mysqli_query($con, $sql_user_group_access);
    
            ++$i;
        }

        // Remove user group from user
        $j = 1;
        while($j <= $number)
        {
            $sql_user = "UPDATE aims_user SET user_group_id = '' WHERE user_group_id = '$id'";
            $query_user = mysqli_query($con, $sql_user);

            ++$j;
        }

        echo "true";
    } else {
        echo mysqli_error($con);
    }

} else {
    echo "Form not submitted.";
}
?>