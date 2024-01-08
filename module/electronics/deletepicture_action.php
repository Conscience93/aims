<?php
include_once '../../include/db_connection.php';
session_start();

$id = $_POST['id'];
$view = $_POST['view'];

// Delete the software record based on the provided id
$sql = "DELETE FROM aims_all_asset_picture WHERE id = '$id'";
$result = mysqli_query($con, $sql);

if ($result) {
    echo json_encode(array("status" => "Success"));
} else {
    echo json_encode(array("status" => "Error"));
}
?>