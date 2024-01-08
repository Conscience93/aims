<?php

include_once '../../../include/db_connection.php';
session_start();

// Array data received from the form
$asset_tag = isset($_POST['asset_tag']) ? $_POST['asset_tag'] : '';
$name = $_POST['name'];
$category = isset($_POST['category']) ? $_POST['category'] : '';
$transfer_branch = isset($_POST['transfer_branch']) ? $_POST['transfer_branch'] : '';
$transfer_department = isset($_POST['transfer_department']) ? $_POST['transfer_department'] : '';
$transfer_location = isset($_POST['transfer_location']) ? $_POST['transfer_location'] : '';
$date_transfer = isset($_POST['date_transfer']) ? $_POST['date_transfer'] : '';
$type = isset($_POST['type']) ? $_POST['type'] : '';
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';

// Insert data into the aims_transfer_computer table
$sql = "INSERT INTO aims_transfer_computer 
(name, asset_tag, category, transfer_branch, transfer_department, transfer_location, date_transfer, type, start_date, end_date, status) 
VALUES 
('$name', '$asset_tag', '$category', '$transfer_branch', '$transfer_department', '$transfer_location', '$date_transfer', '$type', '$start_date', '$end_date', 'TRANSFER')";

$queryAsset = mysqli_query($con, $sql);

if ($queryAsset) {
    // Update the current location in aims_computer table
    $updateSql = "UPDATE aims_computer SET branch = '$transfer_branch', department = '$transfer_department', location = '$transfer_location', status = 'TRANSFER' WHERE asset_tag = '$asset_tag'";
    $queryUpdate = mysqli_query($con, $updateSql);
    
    if ($queryUpdate) {
        echo "true";
    } else {
        echo "Update in aims_computer failed: " . mysqli_error($con);
    }
} else {
    echo "Insert into aims_transfer_computer failed: " . mysqli_error($con);
}
?>
