<?php
include_once '../../../include/db_connection.php';
session_start();

// Function to escape user input
function escapeInput($input) {
    global $con;
    return mysqli_real_escape_string($con, $input);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // customer details
    $id = escapeInput($_POST['id']);
    $display_name = escapeInput($_POST['display_name']);
    $email = escapeInput($_POST['email']);
    $contact_no = escapeInput($_POST['contact_no']);
    $address = escapeInput($_POST['address']);
    $nric = escapeInput($_POST['nric']);

    // Check for duplicates
    $duplicateCheckSql = "SELECT * FROM aims_people_customer WHERE 
        (display_name = '$display_name' OR email = '$email' OR contact_no = '$contact_no' OR nric = '$nric') AND id != '$id'";

    $duplicateCheckResult = mysqli_query($con, $duplicateCheckSql);

    if (mysqli_num_rows($duplicateCheckResult) > 0) {
        // Duplicate records found
        echo "Duplicate records found for one or more fields. Please check your input.";
    } else {
        // Update data into the aims_customer table
        $sql = "UPDATE aims_people_customer SET
            display_name = '$display_name',
            email = '$email',
            contact_no = '$contact_no',
            address = '$address',
            nric = '$nric'
        WHERE id = '$id'";

        $queryAsset = mysqli_query($con, $sql);

        if ($queryAsset) {
            echo "true";
        } else {
            echo "false"; // Error occurred while updating customer details
        }
    }
} else {
    echo "false"; // Form not submitted or no ID provided
}
?>