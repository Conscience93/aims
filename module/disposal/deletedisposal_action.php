<?php
include_once '../../include/db_connection.php';

$id = $_POST["id"];

// Fetch the asset_tag from aims_all_asset_disposal using the provided ID
$sql_fetch_asset_tag = "SELECT asset_tag FROM aims_all_asset_disposal WHERE id = '$id'";
$result_fetch_asset_tag = mysqli_query($con, $sql_fetch_asset_tag);
$row = mysqli_fetch_assoc($result_fetch_asset_tag);
$asset_tag = $row['asset_tag'];

// Delete records from aims_asset
$sql_asset_delete = "DELETE FROM aims_asset WHERE asset_tag = '$asset_tag'";
$result_asset_delete = mysqli_query($con, $sql_asset_delete);

// Delete records from aims_computer
$sql_computer_delete = "DELETE FROM aims_computer WHERE asset_tag = '$asset_tag'";
$result_computer_delete = mysqli_query($con, $sql_computer_delete);

// Delete records from aims_electronics
$sql_electronics_delete = "DELETE FROM aims_electronics WHERE asset_tag = '$asset_tag'";
$result_electronics_delete = mysqli_query($con, $sql_electronics_delete);

// Delete records from aims_all_asset_picture
$sql_picture_delete = "DELETE FROM aims_all_asset_picture WHERE asset_tag = '$asset_tag'";
$result_picture_delete = mysqli_query($con, $sql_picture_delete);

// Delete record from aims_all_asset_disposal
$sql_disposal_delete = "DELETE FROM aims_all_asset_disposal WHERE id = '$id'";
$result_disposal_delete = mysqli_query($con, $sql_disposal_delete);

if ($result_asset_delete && $result_computer_delete && $result_electronics_delete && $result_picture_delete &&$result_disposal_delete ) {
    echo json_encode(array("status" => "success"));
} else {
    echo json_encode(array("status" => "error"));
}
?>
