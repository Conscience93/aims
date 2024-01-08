<?php
include_once '../../../include/db_connection.php';
session_start();

// Array data received from the form
$id = isset($_POST['id']) ? $_POST['id'] : '';
$asset_tag = isset($_POST['asset_tag']) ? $_POST['asset_tag'] : '';
$name = isset($_POST['name']) ? $_POST['name'] : '';
$category = isset($_POST['category']) ? $_POST['category'] : '';
$transfer_branch = isset($_POST['transfer_branch']) ? $_POST['transfer_branch'] : '';
$transfer_department = isset($_POST['transfer_department']) ? $_POST['transfer_department'] : '';
$transfer_location = isset($_POST['transfer_location']) ? $_POST['transfer_location'] : '';
$date_transfer = isset($_POST['date_transfer']) ? $_POST['date_transfer'] : '';
$type = isset($_POST['type']) ? $_POST['type'] : '';
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : '';

// Update data into the aims_electronics table
$sqlasset = "UPDATE aims_electronics SET 
    branch = '$transfer_branch', 
    department = '$transfer_department', 
    location = '$transfer_location' 
WHERE asset_tag = '$asset_tag'";

$sql = "INSERT INTO aims_transfer_electronics 
    (name, 
    asset_tag, 
    category, 
    transfer_branch, 
    transfer_department, 
    transfer_location, 
    date_transfer,
    type,
    start_date,
    end_date,
    status) 

    VALUES 

    ('$name', 
    '$asset_tag', 
    '$category', 
    '$transfer_branch', 
    '$transfer_department', 
    '$transfer_location', 
    '$date_transfer',
    '$type',
    '$start_date',
    '$end_date',
    '$status')";

$query = mysqli_query($con, $sql);
$queryAsset = mysqli_query($con, $sqlasset);

if ($query && $queryAsset) {
    echo "true";
} else {
    echo "false";
}
?>
