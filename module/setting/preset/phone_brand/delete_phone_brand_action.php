<?php
include_once '../../../../include/db_connection.php';

$id = $_POST["id"];

$sql = "DELETE FROM aims_preset_devices_phone_brand WHERE id = '$id'";
$result = mysqli_query($con, $sql);

if ($result) {
    echo json_encode(array("status" => "Success"));
} else {
    echo json_encode(array("status" => "Error"));
}
?>
