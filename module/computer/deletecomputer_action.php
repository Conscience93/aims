<?php
include_once '../../include/db_connection.php';

$id = $_POST["id"];

// Retrieve the asset_tag from aims_computer based on the provided id
$sql_computer = "SELECT * FROM aims_computer WHERE id = '$id'";
$result_computer = mysqli_query($con, $sql_computer);
$row_computer = mysqli_fetch_assoc($result_computer);

$asset_tag = $row_computer['asset_tag']; // Get the asset_tag

$target_invoice_file = "../../" . $row['invoice'];
$target_document_file = "../../" . $row['document'];
$target_picture_file = "../../" . $row['picture'];
$target_warranty_file = "../../" . $row['warranty'];

if (!empty($target_invoice_file)) {
    unlink($target_invoice_file);
}
if (!empty($target_document_file)) {
    unlink($target_document_file);
}
if (!empty($target_picture_file)) {
    unlink($target_picture_file);
}
if (!empty($target_warranty_file)) {
    unlink($target_warranty_file);
}

// Creating File Upload Directory
$target_directory_invoice = "../../include/upload/invoice/computer/" . $row['asset_tag'];
$target_directory_document = "../../include/upload/document/computer/" . $row['asset_tag'];
$target_directory_picture = "../../include/upload/picture/computer/" . $row['asset_tag'];
$target_directory_warranty = "../../include/upload/warranty/computer/" . $row['asset_tag'];

// remove folder
rmdir($target_directory_invoice);
rmdir($target_directory_document);
rmdir($target_directory_picture);
rmdir($target_directory_warranty);

// Delete records from aims_computer
$sql_computer_delete = "DELETE FROM aims_computer WHERE id = '$id'";
$result_computer_delete = mysqli_query($con, $sql_computer_delete);

// Delete records from aims_software based on asset_tag
$sql_software_delete = "DELETE FROM aims_software WHERE asset_tag = '$asset_tag'";
$result_software_delete = mysqli_query($con, $sql_software_delete);

// Delete records from aims_software based on asset_tag
$sql_computer_network_delete = "DELETE FROM aims_computer_network WHERE asset_tag = '$asset_tag'";
$result_computer_network_delete = mysqli_query($con, $sql_computer_network_delete);

// Delete records from aims_computer_user based on asset_tag
$sql_user_delete = "DELETE FROM aims_computer_user WHERE asset_tag = '$asset_tag'";
$result_user_delete = mysqli_query($con, $sql_user_delete);

// Delete records from aims_computer_hard_drive based on asset_tag
$sql_hard_drive_delete = "DELETE FROM aims_computer_hard_drive WHERE asset_tag = '$asset_tag'";
$result_hard_drive_delete = mysqli_query($con, $sql_hard_drive_delete);

$sql_picture_delete = "DELETE FROM aims_all_asset_picture WHERE asset_tag = '$asset_tag'";
$result_picture_delete = mysqli_query($con, $sql_picture_delete);

$sql_remote_access_delete = "DELETE FROM aims_computer_remote_access WHERE asset_tag = '$asset_tag'";
$result_remote_access_delete = mysqli_query($con, $sql_remote_access_delete);


if ($result_computer_delete && $result_software_delete && $result_computer_network_delete && $result_user_delete && $result_hard_drive_delete && $result_picture_delete && $result_remote_access_delete) {
    echo json_encode(array("status" => "success"));
} else {
    echo json_encode(array("status" => "error"));
}
?>
