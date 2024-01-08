<?php
include_once '../../../include/db_connection.php'; 
session_start();

date_default_timezone_set("Asia/Kuala_Lumpur");
$date = date('Y-m-d');
$time = date('H:i:s');

// Function to escape user input
function escapeInput($input) {
    global $con;
    return mysqli_real_escape_string($con, $input);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = escapeInput($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = escapeInput($_POST['email']);
    $nric = escapeInput($_POST['nric']);
    $date_created = $date . " - " . $time;

    $full_name = escapeInput($_POST['full_name']);
    $company_name = escapeInput($_POST['company_name']);
    $branch = escapeInput($_POST['branch']);
    $department = escapeInput($_POST['department']);
    $position = escapeInput($_POST['position']);
    $contact_no = escapeInput($_POST['contact_no']);
    $address = escapeInput($_POST['address']);

    $user_group_id = escapeInput($_POST['user_group']);

    $target_directory_profile = "../../../include/upload/profile/staff/";

    if (!is_dir($target_directory_profile)) {
        mkdir($target_directory_profile, 0755, true);
    }

    $profile_picture = "";

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $profile_tmp = $_FILES['profile_picture']['tmp_name'];
        $profile_name = basename($_FILES["profile_picture"]["name"]);
        $profile_destination = $target_directory_profile . $profile_name;

        if (move_uploaded_file($profile_tmp, $profile_destination)) {
            $profile_picture = "include/upload/profile/staff/" . basename($_FILES["profile_picture"]["name"]);
        }
    }

    // Check for duplicates
    $duplicateCheckSql = "SELECT * FROM aims_user WHERE 
        username = '$username' OR
        email = '$email'";

    $duplicateCheckResult = mysqli_query($con, $duplicateCheckSql);

    if (mysqli_num_rows($duplicateCheckResult) > 0) {
        echo "Duplicate records found for username or email. Please use another input.";
    } else {
        $sql_user = "INSERT INTO aims_user SET
                                username 		            = '".$username."',
                                password 				    = '".$password."',
                                email                       = '".$email."',
                                nric                        = '".$nric."',
                                date_created                = '".$date_created."',
                                full_name                   = '".$full_name."',
                                company_name                = '".$company_name."',
                                department                  = '".$department."',
                                position                    = '".$position."',
                                contact_no                  = '".$contact_no."',
                                address                     = '".$address."',
                                profile_picture             = '".$profile_picture."',
                                user_group_id               = '".$user_group_id."'
                                ";

        if (mysqli_query($con, $sql_user)) {
            echo "true";
        } else {
            echo "Error: " . mysqli_error($con);
        }
    }
} else {
    echo "Form not submitted.";
}
?>