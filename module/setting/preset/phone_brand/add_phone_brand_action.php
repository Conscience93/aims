<?php
include_once '../../../../include/db_connection.php'; // Ensure this line includes your database connection
session_start();

// Function to escape user input
function escapeInput($input) {
    global $con;
    return mysqli_real_escape_string($con, $input);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vendor details
    $display_name = escapeInput($_POST['display_name']);

    // Check if the phone_brand already exists in the database
    $sqlCheckDuplicate = "SELECT COUNT(*) AS count FROM aims_preset_devices_phone_brand WHERE display_name = '$display_name'";
    $queryCheckDuplicate = mysqli_query($con, $sqlCheckDuplicate);
    $rowCheckDuplicate = mysqli_fetch_assoc($queryCheckDuplicate);

    if ($rowCheckDuplicate['count'] > 0) {
        // Display an error message indicating that the phone_brand already exists
        echo "Brand already exists. (Duplicate)";
    } else {
        // Insert data into the aims_preset_devices_phone_brand table
        $sqlAsset = "INSERT INTO aims_preset_devices_phone_brand (display_name) VALUES ('$display_name')";

        if (mysqli_query($con, $sqlAsset)) {
            // phone_brand inserted successfully
            echo "true";
        } else {
            // Error occurred while inserting phone_brand
            echo "Error: " . mysqli_error($con);
        }
    }
} else {
    // Handle the case when the form is not submitted
    echo "Form not submitted.";
}
?>
