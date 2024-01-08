<?php
include_once '../../../include/db_connection.php';
session_start();

// Function to escape user input
function escapeInput($con, $input) {
    if (is_array($input)) {
        $escapedInput = [];
        foreach ($input as $value) {
            $escapedInput[] = mysqli_real_escape_string($con, $value);
        }
        return $escapedInput;
    } else {
        return mysqli_real_escape_string($con, $input);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $display_name = escapeInput($con, $_POST['display_name']);
    $email = escapeInput($con, $_POST['email']);
    $contact_no = escapeInput($con, $_POST['contact_no']);
    $address = escapeInput($con, $_POST['address']);
    $nric = escapeInput($con, $_POST['nric']);
    $branch = escapeInput($con, $_POST['branch']);
    $department = escapeInput($con, $_POST['department']);

    // Creating File Upload Directory
    $target_directory_profile = "../../../include/upload/profile/staff/";

    if (!is_dir($target_directory_profile)) {
        mkdir($target_directory_profile, 0755, true);
    }

    $profile = "";

    if (isset($_FILES['profile']) && $_FILES['profile']['error'] === UPLOAD_ERR_OK) {
        $profile_tmp = $_FILES['profile']['tmp_name'];
        $profile_name = basename($_FILES["profile"]["name"]);
        $profile_destination = $target_directory_profile . $profile_name;

        if (move_uploaded_file($profile_tmp, $profile_destination)) {
            $profile = "include/upload/profile/staff/" . basename($_FILES["profile"]["name"]);
        }
    }

    // Check for duplicates
    $duplicateCheckSql = "SELECT * FROM aims_people_staff WHERE 
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
        $sqlAsset = "INSERT INTO aims_people_staff 
            (display_name, email, contact_no, address, nric, branch, department, profile)
            VALUES ('$display_name', '$email', '$contact_no', '$address', '$nric','$branch', '$department', '$profile')";

        // Execute the SQL query
        if (mysqli_query($con, $sqlAsset)) {
            // Vendor details inserted successfully
            echo "Staff details added successfully!";
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
