<?php
include_once '../../../../include/db_connection.php';
session_start();

// Function to escape user input
function escapeInput($input) {
    global $con;
    return mysqli_real_escape_string($con, $input);
}

// Array data received from the form
$branch = escapeInput($_POST['branch']);
$department = escapeInput($_POST['department']);
$display_name = escapeInput($_POST['display_name']);

// Check if the display name already exists in the database
$sqlCheckDuplicate = "SELECT COUNT(*) AS count FROM aims_preset_location WHERE 
    display_name = '$display_name'";
    
$queryCheckDuplicate = mysqli_query($con, $sqlCheckDuplicate);
$rowCheckDuplicate = mysqli_fetch_assoc($queryCheckDuplicate);

if ($rowCheckDuplicate['count'] > 0) {
    // Display an error message indicating that the display name already exists
    echo "Duplicate record found. Location not added.";
} else {
    // Insert data into the aims_location table
    $sqlAsset = "INSERT INTO aims_preset_location 
    (branch,department,display_name) 
    VALUES 
    ('$branch','$department','$display_name');";

    $queryAsset = mysqli_query($con, $sqlAsset);

    if ($queryAsset) {
        echo "true";
    } else {
        echo "false";
    }
}
?>