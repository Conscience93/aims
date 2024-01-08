<?php
include_once '../../include/db_connection.php';
session_start();

$id = $_POST['id'];
$ip_address = $_POST['ip_address'];

// Delete the software record based on the provided id
$sql = "DELETE FROM aims_computer_network WHERE id = '$id'";
$result = mysqli_query($con, $sql);

if ($result) {
    echo json_encode(array("status" => "Success"));
} else {
    echo json_encode(array("status" => "Error"));
}
?>