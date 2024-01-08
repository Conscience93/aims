<?php
include_once '../../include/db_connection.php';
session_start();

// Function to escape user input
function escapeInput($input) {
    global $con;
    return mysqli_real_escape_string($con, $input);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // NFC details
    $id = escapeInput($_POST['id']);
    $nfc_code = escapeInput($_POST['nfc_code']);
    $qr_code = escapeInput($_POST['qr_code']);
    $asset_tag = escapeInput($_POST['asset_tag']);
    $name = escapeInput($_POST['name']);
    // Check for duplicates
    $duplicateCheckSql = "SELECT * FROM aims_izzat WHERE 
        (nfc_code = '$nfc_code' OR qr_code = '$qr_code' OR asset_tag = '$asset_tag' OR name = '$name') AND id != '$id'";

    $duplicateCheckResult = mysqli_query($con, $duplicateCheckSql);

    if (mysqli_num_rows($duplicateCheckResult) > 0) {
        // Duplicate records found
        echo "Duplicate records found for one or more fields. Please check your input.";
    } else {
        // Update data into the aims_izzat table
        $sql = "UPDATE aims_izzat SET
            nfc_code = '$nfc_code',
            qr_code = '$qr_code',
            asset_tag = '$asset_tag',
            name = '$name'
        WHERE id = '$id'";

        $queryAsset = mysqli_query($con, $sql);

        if ($queryAsset) {
            echo "true";
        } else {
            echo "false"; // Error occurred while updating nfc details
        }
    }
} else {
    echo "false"; // Form not submitted or no ID provided
}
?>