<?php
include_once '../../include/db_connection.php';
session_start();

$fileType = isset($_POST['fileType']) ? $_POST['fileType'] : '';
$id = isset($_POST['id']) ? $_POST['id'] : '';

// Get the eletronics record based on the provided ID
$sqlGet = "SELECT * FROM aims_maintenance WHERE id = '$id'";
$resultGet = mysqli_query($con, $sqlGet);

if ($resultGet && mysqli_num_rows($resultGet) > 0) {
    $row = mysqli_fetch_assoc($resultGet);

    // Determine the field name based on the file type
    $fieldName = '';
    $filePath = '';

    switch ($fileType) {
        case 'maintenance':
            $fieldName = 'maintenance';
            $filePath = '../../' . $row['maintenance'];
            break;
        // Add more cases for other file types if needed.
        default:
            // Handle invalid file types here.
            break;
    }

    if (!empty($filePath)) {
        // Delete the file from the server
        if (unlink($filePath)) {
            // File deleted successfully; update the database field to indicate that the file is deleted
            $sqlUpdateField = "UPDATE aims_maintenance SET $fieldName = '' WHERE id = '$id'";
            $resultUpdateField = mysqli_query($con, $sqlUpdateField);

            if ($resultUpdateField) {
                echo "File deleted and database updated successfully.";
                echo "<script>window.location.href = 'http://localhost/aims/edit_maintenance?id=" . $row["id"] . "';</script>";
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
    echo "No asset record found for the provided ID.";
}
?>