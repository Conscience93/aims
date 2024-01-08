<?php
include_once '../../../include/db_connection.php';

$asset_tag = $_POST["asset_tag"];

// Check if the asset_tag exists in the table before proceeding with deletion
$sql_check = "SELECT * FROM aims_transfer_asset WHERE asset_tag = '$asset_tag'";
$result_check = mysqli_query($con, $sql_check);

if (mysqli_num_rows($result_check) > 0) {
    // If the asset_tag exists, proceed with deletion
    $sql_delete = "DELETE FROM aims_transfer_asset WHERE asset_tag = '$asset_tag'";
    $query_delete = mysqli_query($con, $sql_delete);

    if ($query_delete) {
        echo json_encode(array("status" => "Success"));
    } else {
        echo json_encode(array("status" => "Error"));
    }
} else {
    // If the asset_tag does not exist, return an error status
    echo json_encode(array("status" => "Asset tag not found"));
}
?>
