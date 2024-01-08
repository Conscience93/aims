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
$email = escapeInput($_POST['email']);
$full_name = escapeInput($_POST['full_name']);
$company_name = escapeInput($_POST['company_name']);
$contact_no = escapeInput($_POST['contact_no']);
$department = escapeInput($_POST['department']);
$address = escapeInput($_POST['address']);
$city = escapeInput($_POST['city']);
$state = escapeInput($_POST['state']);
$country = escapeInput($_POST['country']);

// Update data into the aims_user table
$sql = "UPDATE aims_user SET
    email = '$email',
    full_name = '$full_name',
    company_name = '$company_name',
    contact_no = '$contact_no',
    department = '$department',
    address = '$address',
    city = '$city',
    state = '$state',
    country = '$country' 
WHERE id = '$id'
";

$queryAsset = mysqli_query($con, $sql);

if ($queryAsset) {
    echo "true";
} else {
    echo "false";
}
?>
