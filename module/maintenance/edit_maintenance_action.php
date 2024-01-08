<?php
include_once '../../include/db_connection.php';
session_start();

// Array data received from the form
$id = isset($_POST['id']) ? $_POST['id'] : '';
$type = $_POST['type'];
$name = $_POST['name'];
$title = $_POST['title'];
$remark = $_POST['remark'];
$vendors = $_POST['vendors'];
$expenses = isset($_POST['expenses']) ? $_POST['expenses'] : '';
$asset_tag = isset($_POST['asset_tag']) ? $_POST['asset_tag'] : '';
$category = isset($_POST['category']) ? $_POST['category'] : '';
$maintenance_date = isset($_POST['maintenance_date']) ? $_POST['maintenance_date'] : '';

// Creating File Upload Directory
$target_directory_maintenance = "../../include/upload/maintenance/" . $asset_tag . "/";

if (!is_dir($target_directory_maintenance)) {
    mkdir($target_directory_maintenance, 0755, true);
}

// Get existing link
$sqlLink = mysqli_query($con, "SELECT * FROM aims_maintenance WHERE id = '$id'");
$resultLink = mysqli_fetch_assoc($sqlLink);

// maintenance
if ($resultLink["maintenance"]) {
    $maintenance = $resultLink["maintenance"];
} else if ($_FILES["maintenance"]["name"] == "") {
    $maintenance = "";
} else {
    $maintenance = $target_directory_maintenance . basename($_FILES["maintenance"]["name"]);
    $maintenance_tmp = $_FILES['maintenance']['tmp_name'];
    move_uploaded_file($maintenance_tmp, $maintenance);
    $maintenance = "include/upload/maintenance/" . $asset_tag . "/" . basename($_FILES["maintenance"]["name"]);
}

// Update data into the table
$sql = "UPDATE aims_maintenance SET
    name = '$name',
    type = '$type',
    category = '$category',
    title = '$title',
    asset_tag = '$asset_tag',
    expenses = '$expenses',
    maintenance_date = '$maintenance_date',
    maintenance = '$maintenance',
    remark = '$remark',
    vendors = '$vendors'
WHERE id = '$id'";

$queryAsset = mysqli_query($con, $sql);

if ($queryAsset) {
    echo "true";
} else {
    echo "false";
}
?>