<?php
include_once '../../../../include/db_connection.php';
session_start();

function escapeInput($input) {
    global $con;
    return mysqli_real_escape_string($con, $input);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $display_name = escapeInput($_POST['display_name']);
    $branch_contact_no = escapeInput($_POST['branch_contact_no']);
    $branch_email = escapeInput($_POST['branch_email']);
    $pic = escapeInput($_POST['pic']);
    $contact_no = escapeInput($_POST['contact_no']);
    $address = escapeInput($_POST['address']);

    $sqlCheckDuplicate = "SELECT COUNT(*) AS count FROM aims_preset_computer_branch 
        WHERE (display_name = '$display_name' 
        OR branch_contact_no = '$branch_contact_no' 
        OR branch_email = '$branch_email' 
        OR contact_no = '$contact_no' 
        OR address = '$address')";

    $result = mysqli_query($con, $sqlCheckDuplicate);

    if ($result) {
        $rowCheckDuplicate = mysqli_fetch_assoc($result);
        $count = $rowCheckDuplicate['count'];

        if ($count > 0) {
            echo "Duplicate record found. Branch not added.";
        } else {
            $sqlAsset = "INSERT INTO aims_preset_computer_branch 
                (display_name, branch_contact_no, branch_email, pic, contact_no, address)
                VALUES ('$display_name', '$branch_contact_no', '$branch_email', '$pic', '$contact_no', '$address')";

            if (mysqli_query($con, $sqlAsset)) {
                $insertedBranchId = mysqli_insert_id($con); // Retrieve the ID of the inserted branch
                echo "Branch added successfully with ID: $insertedBranchId"; // Return success message with ID
            } else {
                echo "Error: " . mysqli_error($con);
            }
        }
    } else {
        echo "Error: " . mysqli_error($con);
    }
} else {
    echo "Form not submitted.";
}
?>
