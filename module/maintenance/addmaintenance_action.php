<?php
include_once '../../include/db_connection.php';
session_start();

// Array data received from the form
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

// Get asset type running number
$sql = mysqli_query($con, "SELECT * FROM aims_maintenance_type_run_no WHERE type = '$type'");
$result = mysqli_fetch_assoc($sql);
$maintenance_running_no = $result['next_no'];

// Complete asset tag wording, adding zero to the left
$maintenance_tag = $result['prefix'].str_pad($maintenance_running_no,5,"0",STR_PAD_LEFT);

// Check if the directories exist, and if not, create them
if (!is_dir($target_directory_maintenance)) {
    mkdir($target_directory_maintenance, 0755, true);
}

// maintenance
if ($_FILES["maintenance"]["name"] == "") {
    $maintenance = "";
}
else {
    $maintenance = $target_directory_maintenance . basename($_FILES["maintenance"]["name"]);
    $maintenance_tmp = $_FILES['maintenance']['tmp_name'];
    move_uploaded_file($maintenance_tmp, $maintenance);
    // replace into the linkable link
    $maintenance = "include/upload/maintenance/" . $asset_tag . "/" . basename($_FILES["maintenance"]["name"]);
}


// Insert data into the aims_maintenance table
$sqlAsset = "INSERT INTO aims_maintenance
(name, type, asset_tag, maintenance_tag, category, title, expenses, maintenance_date, maintenance, remark, vendors) 
VALUES 
('$name', '$type', '$asset_tag', '$maintenance_tag', '$category', '$title', '$expenses', '$maintenance_date', '$maintenance', '$remark', '$vendors');";

$queryAsset = mysqli_query($con, $sqlAsset);
    if ($queryAsset) {
        $next_no = $maintenance_running_no + 1;
        $update_running_no = mysqli_query($con, "UPDATE aims_maintenance_type_run_no SET next_no = '$next_no' WHERE type = '$type'");
        echo "true";
    } else {
        echo "false";
    }
?>