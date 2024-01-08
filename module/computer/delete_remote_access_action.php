<?php
include_once '../../include/db_connection.php';
session_start();

$id = $_POST['id'];
$remote_name = $_POST['remote_name'];

// Delete the software record based on the provided id
$sql = "DELETE FROM aims_computer_remote_access WHERE id = '$id'";
$result = mysqli_query($con, $sql);

if ($result) {
    echo json_encode(array("status" => "Success"));
} else {
    echo json_encode(array("status" => "Error"));
}
?>