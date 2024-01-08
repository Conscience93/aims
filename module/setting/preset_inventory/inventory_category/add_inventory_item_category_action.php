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
    $name = escapeInput($_POST['name']);

    // Check if the computer_brand already exists in the database
    $sqlCheckDuplicate = "SELECT COUNT(*) AS count FROM aims_inventory_category WHERE name = '$name'";
    $queryCheckDuplicate = mysqli_query($con, $sqlCheckDuplicate);
    $rowCheckDuplicate = mysqli_fetch_assoc($queryCheckDuplicate);

    if ($rowCheckDuplicate['count'] > 0) {
        // Display an error message indicating that the inventory_item_category already exists
        echo "Category already exists. (Duplicate)";
    } else {
        // Insert data into the aims_inventory_category table
        $sqlAsset = "INSERT INTO aims_inventory_category (name) VALUES ('$name')";

        if (mysqli_query($con, $sqlAsset)) {
            // computer_brand inserted successfully
            echo "true";
        } else {
            // Error occurred while inserting computer_brand
            echo "Error: " . mysqli_error($con);
        }
    }
} else {
    // Handle the case when the form is not submitted
    echo "Form not submitted.";
}
?>
