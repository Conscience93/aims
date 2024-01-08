<?php
include_once '../../../include/db_connection.php';
session_start();

// Function to escape user input
function escapeInput($input) {
    global $con;
    return mysqli_real_escape_string($con, $input);
}

// Array data received from the form
    $id = escapeInput($_POST['id']);
    $display_name = escapeInput($_POST['display_name']);
    $email = escapeInput($_POST['email']);
    $contact_no = escapeInput($_POST['contact_no']);
    $address = escapeInput($_POST['address']);
    $nric = escapeInput($_POST['nric']);
    $branch = escapeInput($_POST['branch']);
    $department = escapeInput($_POST['department']);

// Creating File Upload Directory
$target_directory_profile = "../../include/upload/profile/staff/";

if (!is_dir($target_directory_profile)) {
    mkdir($target_directory_profile, 0755, true);
}

// Get existing link
$sqlLink = mysqli_query($con, "SELECT * FROM aims_people_staff WHERE id = '$id'");
$resultLink = mysqli_fetch_assoc($sqlLink);

// profile
if ($resultLink["profile"]) {
    $profile = $resultLink["profile"];
} else if ($_FILES["profile"]["name"] == "") {
    $profile = "";
} else {
    $profile = $target_directory_profile . basename($_FILES["profile"]["name"]);
    $profile_tmp = $_FILES['profile']['tmp_name'];
    move_uploaded_file($profile_tmp, $profile);
    $profile = "include/upload/profile/staff/" . basename($_FILES["profile"]["name"]);
}

// Update data into the aims_people_staff table
$sql_asset = "UPDATE aims_people_staff SET
    display_name = '$display_name',
    email = '$email',
    contact_no = '$contact_no',
    address = '$address',
    nric = '$nric',
    branch = '$branch',
    department = '$department',
    profile = '$profile'
WHERE id = '$id'
";

$queryAsset = mysqli_query($con, $sql_asset);

if ($queryAsset) {
    echo "true";
} else {
    echo "false";
}
