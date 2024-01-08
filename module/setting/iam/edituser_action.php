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
    $id = $_POST['id'];
    // $username = escapeInput($_POST['username']);
    // $password = escapeInput($_POST['password']);
    // $email = escapeInput($_POST['email']);
    $nric = escapeInput($_POST['nric']);
    $date_modified = $date . " - " . $time;

    $full_name = escapeInput($_POST['full_name']);
    $company_name = escapeInput($_POST['company_name']);
    // $branch = escapeInput($_POST['branch']);
    $department = escapeInput($_POST['department']);
    $position = escapeInput($_POST['position']);
    $contact_no = escapeInput($_POST['contact_no']);
    $address = escapeInput($_POST['address']);

    $user_group_id = escapeInput($_POST['user_group']);

    $target_directory_profile = "../../../include/upload/profile/staff/";

    if (!is_dir($target_directory_profile)) {
        mkdir($target_directory_profile, 0755, true);
    }

    $sqlLink = mysqli_query($con, "SELECT * FROM aims_user WHERE id = '$id'");
    $resultLink = mysqli_fetch_assoc($sqlLink);

    // profile
    if ($resultLink["profile_picture"]) {
        $profile_picture = $resultLink["profile_picture"];
    } else if ($_FILES["profile_picture"]["name"] == "") {
        $profile_picture = "";
    } else {
        $profile_picture = $target_directory_profile . basename($_FILES["profile_picture"]["name"]);
        $profile_tmp = $_FILES['profile_picture']['tmp_name'];
        move_uploaded_file($profile_tmp, $profile_picture);
        $profile_picture = "include/upload/profile/staff/" . basename($_FILES["profile_picture"]["name"]);
    }

    $sql_user = "UPDATE aims_user SET
        nric                        = '".$nric."',
        date_modified               = '".$date_modified."',
        full_name                   = '".$full_name."',
        company_name                = '".$company_name."',
        department                  = '".$department."',
        position                    = '".$position."',
        contact_no                  = '".$contact_no."',
        address                     = '".$address."',
        profile_picture             = '".$profile_picture."',
        user_group_id               = '".$user_group_id."'
        WHERE id = '$id'
    ";

    $query_user = mysqli_query($con, $sql_user);

    if ($query_user) {
        echo "true";
    } else {
        echo "false";
    }
} else {
    echo "Form not submitted.";
}