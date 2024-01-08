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
$display_name = escapeInput($_POST['display_name']);
$staff = escapeInput($_POST['staff']);
$noe = escapeInput($_POST['noe']);

// Check if any of the fields already exist in the database
$sqlCheckDuplicate = "SELECT COUNT(*) AS count FROM aims_preset_department WHERE 
    display_name = '$display_name'"; 

$queryCheckDuplicate = mysqli_query($con, $sqlCheckDuplicate);
$rowCheckDuplicate = mysqli_fetch_assoc($queryCheckDuplicate);

if ($rowCheckDuplicate['count'] > 0) {
    // Display an error message indicating that a duplicate exists
    echo "Duplicate data found. (Duplicate)";
} else {
    // Insert data into the aims_department table
    $sqlAsset = "INSERT INTO aims_preset_department 
    (branch,display_name, staff, noe) 
    VALUES 
    ('$branch','$display_name', '$staff', '$noe')";

    $queryAsset = mysqli_query($con, $sqlAsset);

    if ($queryAsset) {
        echo "true";
    } else {
        echo "false";
    }
}
?>
