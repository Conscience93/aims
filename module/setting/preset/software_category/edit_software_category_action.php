<?php
include_once '../../../../include/db_connection.php';
session_start();

// Function to escape user input
function escapeInput($input) {
    global $con;
    return mysqli_real_escape_string($con, $input);
}

// Array data received from the form
$id = escapeInput($_POST['id']);
$display_name = escapeInput($_POST['display_name']);

// Check if the display name already exists in the database, excluding the current record by ID
$sqlCheckDuplicate = "SELECT COUNT(*) AS count FROM aims_software_category WHERE display_name = '$display_name' AND id != '$id'";
$queryCheckDuplicate = mysqli_query($con, $sqlCheckDuplicate);
$rowCheckDuplicate = mysqli_fetch_assoc($queryCheckDuplicate);

if ($rowCheckDuplicate['count'] > 0) {
    // Display an error message indicating that the display name already exists
    echo "Name is already in use. (Duplicate)";
} else {
    // Update data into the aims_preset_location table
    $sql = "UPDATE aims_software_category SET
        display_name = '$display_name'
    WHERE id = '$id'
    ";

    $queryAsset = mysqli_query($con, $sql);

    if ($queryAsset) {
        echo "true";
    } else {
        echo "false";
    }
}
?>
