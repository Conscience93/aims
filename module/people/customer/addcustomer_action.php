<?php
include_once '../../../include/db_connection.php'; // Ensure this line includes your database connection
session_start();

// Function to escape user input
function escapeInput($input) {
    global $con;
    return mysqli_real_escape_string($con, $input);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vendor details
    $display_name = escapeInput($_POST['display_name']);
    $email = escapeInput($_POST['email']);
    $contact_no = escapeInput($_POST['contact_no']);;
    $address = escapeInput($_POST['address']);
    $nric = escapeInput($_POST['nric']);

    // Check for duplicates
    $duplicateCheckSql = "SELECT * FROM aims_people_customer WHERE 
        display_name = '$display_name' OR
        email = '$email' OR
        contact_no = '$contact_no' OR
        nric = '$nric'";

    $duplicateCheckResult = mysqli_query($con, $duplicateCheckSql);

    if (mysqli_num_rows($duplicateCheckResult) > 0) {
        // Duplicate records found
        echo "Duplicate records found for one or more fields. Please check your input.";
    } else {
        // No duplicates found, proceed to insert the data
        $sqlAsset = "INSERT INTO aims_people_customer 
            (display_name, email, contact_no, address, nric)
            VALUES ('$display_name', '$email', '$contact_no', '$address', '$nric')";

        // Execute the SQL query
        if (mysqli_query($con, $sqlAsset)) {
            // Vendor details inserted successfully
            echo "Customer details added successfully!";
        } else {
            // Error occurred while inserting vendor details
            echo "Error: " . mysqli_error($con);
        }
    }
} else {
    // Handle the case when the form is not submitted
    echo "Form not submitted.";
}
?>