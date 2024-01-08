<?php
include_once '../../include/db_connection.php';
session_start();

$fileType = $_POST['fileType'];
$id = $_POST['id'];

// Ensure that $fileType is a valid value (e.g., "invoice", "document", "picture")
// You can add additional validation here if needed.

// Get the computer record based on the provided ID
$sqlGetComputer = "SELECT * FROM aims_computer WHERE id = '$id'";
$resultGetComputer = mysqli_query($con, $sqlGetComputer);

if ($resultGetComputer && mysqli_num_rows($resultGetComputer) > 0) {
    $row = mysqli_fetch_assoc($resultGetComputer);

    // Determine the field name based on the file type
    $fieldName = '';
    $filePath = '';

    switch ($fileType) {
        case 'invoice':
            $fieldName = 'invoice';
            $filePath = '../../' . $row['invoice'];
            break;
        case 'document':
            $fieldName = 'document';
            $filePath = '../../' . $row['document'];
            break;
        case 'warranty':
            $fieldName = 'warranty';
            $filePath = '../../' . $row['warranty'];
            break;
        case 'picture':
            $fieldName = 'picture';
            $filePath = '../../' . $row['picture'];
            break;
        case 'bill':
            $fieldName = 'bill';
            $filePath = '../../' . $row['bill'];
            break;
        // Add more cases for other file types if needed.
        default:
            // Handle invalid file types here.
            break;
    }

    if (!empty($filePath)) {
        // Delete the file from the server
        unlink($filePath);
        if (!file_exists($filePath)) {
            // File deleted successfully; update the database field to indicate that the file is deleted
            $sqlUpdateField = "UPDATE aims_computer SET $fieldName = '' WHERE id = '$id'";
            $resultUpdateField = mysqli_query($con, $sqlUpdateField);

            if ($resultUpdateField) {
                echo "File deleted and database updated successfully."; 
                echo "<script>window.location.href = 'http://localhost/aims/editcomputer?id=".$row["id"]."';</script>";
            } else {
                echo "Database update failed.";
            }
        } else {
            echo "File deletion failed.";
        }
    } else {
        echo "File path is empty";
    }
} else {
    echo "No computer record found for the provided ID.";
}
?>