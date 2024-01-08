<?php
include_once '../../../../include/db_connection.php'; // Ensure this line includes your database connection
session_start();

// Function to escape user input
function escapeInput($input) {
    global $con;
    return mysqli_real_escape_string($con, $input);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $display_name = escapeInput($_POST['display_name']);

    $sqlCheckDuplicate = "SELECT COUNT(*) AS count FROM aims_software_category WHERE display_name = '$display_name'";
    $queryCheckDuplicate = mysqli_query($con, $sqlCheckDuplicate);
    $rowCheckDuplicate = mysqli_fetch_assoc($queryCheckDuplicate);

    if ($rowCheckDuplicate['count'] > 0) {
        echo "Category already exists. (Duplicate)";
    } else {
        $sqlAsset = "INSERT INTO aims_software_category (display_name) VALUES ('$display_name')";

        if (mysqli_query($con, $sqlAsset)) {
            echo "true";
        } else {
            echo "Error: " . mysqli_error($con);
        }
    }
} else {
    echo "Form not submitted.";
}
?>
