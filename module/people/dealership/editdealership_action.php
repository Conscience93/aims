<?php
include_once '../../../include/db_connection.php';
session_start();

// Function to escape user input
function escapeInput($input) {
    global $con;
    return mysqli_real_escape_string($con, $input);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // supplier details
    $id = escapeInput($_POST['id']);
    $display_name = escapeInput($_POST['display_name']);
    $contact_no = escapeInput($_POST['contact_no']);
    $pic = escapeInput($_POST['pic']);
    $address = escapeInput($_POST['address']);
    $email = escapeInput($_POST['email']);
    $fax = escapeInput($_POST['fax']);

    // Check for duplicates
    $duplicateCheckSql = "SELECT * FROM aims_people_dealership WHERE 
        display_name = '$display_name' AND
        contact_no = '$contact_no' AND
        pic = '$pic' AND
        address = '$address' AND
        email = '$email' AND
        fax = '$fax' AND
        id != '$id'"; // Exclude the current record being updated

    $duplicateCheckResult = mysqli_query($con, $duplicateCheckSql);
    
    $sqlTest = "SELECT * FROM aims_people_dealership WHERE id = '$id'";
    $resultTest = mysqli_query($con, $sqlTest);
    $rowTest = mysqli_fetch_assoc($resultTest);
    $oldsupplierName = $rowTest['display_name'];

    if (mysqli_num_rows($duplicateCheckResult) > 0) {
        // Duplicate records found
        echo "Duplicate records found for all attributes. Please check your input.";
    } else {
        // No duplicates found, proceed to update the supplier details
        $sql = "UPDATE aims_people_dealership SET
            display_name = '$display_name',
            contact_no = '$contact_no',
            pic = '$pic',
            address = '$address',
            email = '$email',
            fax = '$fax'
        WHERE id = '$id'";

        $sqlAsset = "UPDATE aims_vehicle SET
            dealership = '$display_name'
            WHERE dealership = '$olddealershipName'";

        $queryAsset = mysqli_query($con, $sqlAsset);

        $query = mysqli_query($con, $sql);
        

        if ($queryAsset) {
            echo "true"; // Update successful
        } else {
            echo "false"; // Error occurred while updating supplier details
        }
    }
} else {
    echo "false"; // Form not submitted or no ID provided
}
?>