<?php
include_once '../../../../include/db_connection.php';
session_start();

// Check if the branchId and displayName are set in the POST request
if (isset($_POST['branchId'], $_POST['displayName'])) {
    // Sanitize the input to prevent SQL injection
    $branchId = mysqli_real_escape_string($con, $_POST['branchId']);
    $displayName = mysqli_real_escape_string($con, $_POST['displayName']);

    // Delete existing data in aims_default_location table
    $deleteQuery = mysqli_query($con, "DELETE FROM aims_default_location");

    if ($deleteQuery) {
        // Insert new data into aims_default_location table
        $insertQuery = "INSERT INTO aims_default_location (id, display_name) VALUES ('$branchId', '$displayName')";

        if (mysqli_query($con, $insertQuery)) {
            // If insertion is successful, send a success response
            echo json_encode(array('status' => 'success', 'message' => 'Data inserted into aims_default_location table.'));
        } else {
            // If there is an error, send an error response
            echo json_encode(array('status' => 'error', 'message' => 'Error inserting data into aims_default_location table: ' . mysqli_error($con)));
        }
    } else {
        // If there is an error in deleting, send an error response
        echo json_encode(array('status' => 'error', 'message' => 'Error deleting existing data from aims_default_location table: ' . mysqli_error($con)));
    }
} else {
    // If branchId or displayName is not set in the POST request, send an error response
    echo json_encode(array('status' => 'error', 'message' => 'Branch ID or Display Name not provided.'));
}

// Close the database connection if needed
mysqli_close($con);
?>
