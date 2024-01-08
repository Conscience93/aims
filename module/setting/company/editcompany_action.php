<?php
include_once '../../../include/db_connection.php';
session_start();

// Function to escape user input
function escapeInput($input) {
    global $con;
    return mysqli_real_escape_string($con, $input);
}

$id = $_SESSION['aims_id'];

// Array data received from the input
$name = escapeInput($_POST['name']);
$email = escapeInput($_POST['email']);
$phone = escapeInput($_POST['phone']);
$fax = escapeInput($_POST['fax']);
$address = escapeInput($_POST['address']);

// File upload handling
$target_directory_logo = "../../../include/upload/logo/";

// Get existing link
$sqlLink = mysqli_query($con, "SELECT * FROM aims_company");
$resultLink = mysqli_fetch_assoc($sqlLink);

// Check if the target directory exists, if not, create it
if (!is_dir($target_directory_logo)) {
    mkdir($target_directory_logo, 0755, true);
}

$logo = ""; // Initialize $logo with an empty string

if ($resultLink && isset($resultLink["logo"])) {
    $logo = $resultLink["logo"];
}

if ($_FILES["logo"]["name"] != "") {
    // New logo provided, update $logo and move the uploaded file
    $newLogoPath = $target_directory_logo . basename($_FILES["logo"]["name"]);
    $logo_tmp = $_FILES['logo']['tmp_name'];

    // Delete the previous logo
    if (!empty($logo) && file_exists($logo)) {
        unlink($logo);
    }

    move_uploaded_file($logo_tmp, $newLogoPath);
    $logo = "include/upload/logo/" . basename($_FILES["logo"]["name"]);
}

// Update data in the aims_company table
$sql = "UPDATE aims_company SET 
    name = '$name',
    email = '$email',
    phone = '$phone',
    fax = '$fax',
    address = '$address',
    logo = '$logo'
WHERE id = $id;";

$query = mysqli_query($con, $sql);

if ($query) {
    echo "true";
} else {
    echo "false";
}
?>