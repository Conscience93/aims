<?php
include_once '../../include/db_connection.php';
session_start();

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

// Check for duplicate entry
$duplicateCheckQuery = "SELECT id FROM aims_computer_category_run_no WHERE display_name = '$display_name' AND category = '$category' AND prefix = '$prefix'";
$duplicateCheckResult = mysqli_query($con, $duplicateCheckQuery);

if (mysqli_num_rows($duplicateCheckResult) > 0) {
    // Duplicate entry found
    echo "false: Duplicate entry found.";
    exit; // Exit the script
}

// Insert data into the aims_computer_category_run_no with fixed next_no and digit_no
$sql = "INSERT INTO aims_computer_category_run_no 
(display_name, category, prefix, next_no, digit_no) 
VALUES 
('$display_name', '$category', '$prefix', $next_no, $digit_no)";

$queryAsset = mysqli_query($con, $sql);

if ($queryAsset) {
    echo "true";
} else {
    echo "false: " . mysqli_error($con);
}
?>
