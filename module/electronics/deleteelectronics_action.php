<?php
include_once '../../include/db_connection.php';

$id = $_POST["id"];

// Retrieve the asset_tag from aims_computer based on the provided id
$sql_asset = "SELECT * FROM aims_electronics WHERE id = '$id'";
$result_asset = mysqli_query($con, $sql_asset);
$row_asset = mysqli_fetch_assoc($result_asset);

$asset_tag = $row_asset['asset_tag']; // Get the asset_tag

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
$target_directory_invoice = "../../include/upload/invoice/electronics/" . $row['asset_tag'];
$target_directory_document = "../../include/upload/document/electronics/" . $row['asset_tag'];
$target_directory_picture = "../../include/upload/picture/electronics/" . $row['asset_tag'];
$target_directory_warranty = "../../include/upload/warranty/electronics/" . $row['asset_tag'];

// remove folder
rmdir($target_directory_invoice);
rmdir($target_directory_document);
rmdir($target_directory_picture);
rmdir($target_directory_warranty);

// Delete records from aims_asset
$sql_asset_delete = "DELETE FROM aims_electronics WHERE id = '$id'";
$result_asset_delete = mysqli_query($con, $sql_asset_delete);

// Delete records from aims_all_asset_picture based on asset_tag
$sql_picture_delete = "DELETE FROM aims_all_asset_picture WHERE asset_tag = '$asset_tag'";
$result_picture_delete = mysqli_query($con, $sql_picture_delete);


if ($result_asset_delete && $result_picture_delete) {
    echo json_encode(array("status" => "success"));
} else {
    echo json_encode(array("status" => "error"));
}
?>
