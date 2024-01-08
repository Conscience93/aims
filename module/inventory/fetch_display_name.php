<?php
include_once '../../include/db_connection.php';
session_start();

// Fetch the display_name from aims_default_location
$selectQuery = "SELECT display_name FROM aims_default_location LIMIT 1"; // Assuming you want only one record
$result = mysqli_query($con, $selectQuery);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $display_name = $row['display_name'];

    // Send the display_name as a JSON response
    echo json_encode(array('status' => 'success', 'display_name' => $display_name));
} else {
    // If there is an error, send an error response
    echo json_encode(array('status' => 'error', 'message' => 'Error fetching display_name: ' . mysqli_error($con)));
}

// Close the database connection
mysqli_close($con);
?>
