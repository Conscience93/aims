<?php
include_once '../../../../include/db_connection.php';

$id = $_POST["id"];

$sql = "DELETE FROM aims_preset_department WHERE id = '$id'";
$result = mysqli_query($con, $sql);

if ($result) {
    echo json_encode(array("status" => "Success"));
} else {
    // Add an error message to identify the issue
    echo json_encode(array("status" => "Error", "message" => mysqli_error($con)));
}
?>