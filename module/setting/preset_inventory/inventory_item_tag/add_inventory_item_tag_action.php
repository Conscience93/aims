<?php
include_once '../../../../include/db_connection.php'; // Ensure this line includes your database connection
session_start();
;

// Function to escape user input
function escapeInput($input) {
    global $con;
    return mysqli_real_escape_string($con, $input);
}

// Set fixed values for next_no and digit_no
$next_no = 1;
$digit_no = 6;

// Array data received from the form
$display_name = escapeInput($_POST['display_name']);
$category = escapeInput($_POST['category']);
$prefix = escapeInput($_POST['prefix']);

// Check if the display name already exists in the database
$sqlCheckDuplicate = "SELECT COUNT(*) AS count FROM aims_inventory_category_run_no WHERE 
    display_name = '$display_name' AND 
    prefix = '$prefix'";
    
$queryCheckDuplicate = mysqli_query($con, $sqlCheckDuplicate);
$rowCheckDuplicate = mysqli_fetch_assoc($queryCheckDuplicate);

if ($rowCheckDuplicate['count'] > 0) {
    // Display an error message indicating that the display name already exists
    echo "Duplicate record found. Item Tag not added.";
} else {
    // Insert data into the aims_location table
    $sqlAsset = "INSERT INTO aims_inventory_category_run_no 
    (display_name, category, prefix, next_no, digit_no) 
    VALUES 
    ('$display_name', '$category', '$prefix', $next_no, $digit_no)";

    $queryAsset = mysqli_query($con, $sqlAsset);

    if ($queryAsset) {
        echo "true";
    } else {
        echo "false";
    }
}
?>
