<?php
include_once '../../../include/db_connection.php'; // Ensure this line includes your database connection
session_start();

// Function to escape user input
function escapeInput($input) {
    global $con;
    return mysqli_real_escape_string($con, $input);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // supplier details
    $display_name = escapeInput($_POST['display_name']);
    $contact_no = escapeInput($_POST['contact_no']);
    $pic = escapeInput($_POST['pic']);
    $address = escapeInput($_POST['address']);
    $email = escapeInput($_POST['email']);
    $fax = escapeInput($_POST['fax']);

    // Check for duplicates
    $duplicateCheckSql = "SELECT * FROM aims_people_supplier WHERE 
        display_name = '$display_name' OR
        contact_no = '$contact_no' OR
        pic = '$pic' OR
        address = '$address' OR
        email = '$email' OR
        fax = '$fax'";

    $duplicateCheckResult = mysqli_query($con, $duplicateCheckSql);

    if (mysqli_num_rows($duplicateCheckResult) > 0) {
        // Duplicate records found
        echo "Duplicate records found for all attributes. Please check your input.";
    } else {
        // No duplicates found, proceed to insert the new supplier details
        $sqlAsset = "INSERT INTO aims_people_supplier
            (display_name, contact_no, pic, address, email, fax)
            VALUES ('$display_name', '$contact_no', '$pic', '$address', '$email', '$fax')";

        // Execute the SQL query to insert supplier details
        if (mysqli_query($con, $sqlAsset)) {
            // supplier details inserted successfully
            echo "true";
        } else {
            // Error occurred while inserting supplier details
            echo "Error: " . mysqli_error($con);
        }
    }
} else {
    // Handle the case when the form is not submitted
    echo "Form not submitted.";
}
?>