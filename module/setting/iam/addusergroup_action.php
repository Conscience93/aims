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
    $date_created = $date . " - " . $time;
    // status == ACTIVE default in database

    $sql_user_group = "INSERT INTO aims_user_group SET 	
                                user_group_name 		    = '".$name."',
                                description 				= '".$description."',
                                date_created                = '".$date_created."'";
    
    $query_user_group = mysqli_query($con, $sql_user_group);

    $userGroupId = mysqli_insert_id($con);

    if ($query_user_group) {
        $binary_number = base_convert(15, 10, 2);  // return 1111

        // add row access 100 times
        $i = 1;
        while($i <= 100)
        {
        $sql_user_group_access = "INSERT INTO aims_submodule_access SET 	
                                            submodule_id 		        = '".$i."',
                                            user_group_id 				= '".$userGroupId."',
                                            crud                        = '".$binary_number."'";

        $query_user_group_access = mysqli_query($con, $sql_user_group_access);
        ++$i;
        }

        echo "true";
    } else {
        echo "Error: " . mysqli_error($con);
    }

} else {
    echo "Form not submitted.";
}
?>