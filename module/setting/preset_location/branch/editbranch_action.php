<?php
include_once '../../../../include/db_connection.php';
session_start();

// Function to escape user input
function escapeInput($input) {
    global $con;
    return mysqli_real_escape_string($con, $input);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = escapeInput($_POST['id']);
    $display_name = escapeInput($_POST['display_name']);
    $branch_contact_no = escapeInput($_POST['branch_contact_no']);
    $branch_email = escapeInput($_POST['branch_email']);
    $pic = escapeInput($_POST['pic']);
    $contact_no = escapeInput($_POST['contact_no']);
    $address = escapeInput($_POST['address']);

    // SQL statement to check for duplicates (excluding the current record by ID)
    $sqlCheckDuplicate = "SELECT COUNT(*) AS count FROM aims_preset_computer_branch 
        WHERE (display_name = '$display_name' 
        OR branch_contact_no = '$branch_contact_no' 
        OR branch_email = '$branch_email' 
        OR pic = '$pic' 
        OR contact_no = '$contact_no' 
        OR address = '$address') 
        AND id != '$id'";

    $result = mysqli_query($con, $sqlCheckDuplicate);

    $sqlTest = "SELECT * FROM aims_preset_computer_branch WHERE id = '$id'";
    $resultTest = mysqli_query($con, $sqlTest);
    $rowTest = mysqli_fetch_assoc($resultTest);
    $oldbranchName = $rowTest['display_name'];

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $count = $row['count'];

        if ($count > 0) {
            // A duplicate record exists, so don't update
            echo "Duplicate record found. Update not performed.";
        } else {
            // No duplicate record found, proceed with the update
            $sql = "UPDATE aims_preset_computer_branch SET
                display_name = '$display_name',
                branch_contact_no = '$branch_contact_no',
                branch_email = '$branch_email',
                pic = '$pic',
                contact_no = '$contact_no',
                address = '$address'
            WHERE id = '$id'";

            $sqlAsset = "UPDATE aims_asset SET
            branch = '$display_name'
            WHERE branch = '$oldbranchName'";

            $queryAsset = mysqli_query($con, $sqlAsset);

            $sqlComputer = "UPDATE aims_computer SET
            branch = '$display_name'
            WHERE branch = '$oldbranchName'";

            $queryComputer = mysqli_query($con, $sqlComputer);

            $sqlElectronic = "UPDATE aims_electronics SET
            branch = '$display_name'
            WHERE branch = '$oldbranchName'";

            $queryElectronic = mysqli_query($con, $sqlElectronic);

            $sqlDepartment = "UPDATE aims_preset_department SET
            branch = '$display_name'
            WHERE branch = '$oldbranchName'";

            $queryDepartment = mysqli_query($con, $sqlDepartment);

            $sqlLocation = "UPDATE aims_preset_location SET
            branch = '$display_name'
            WHERE branch = '$oldbranchName'";

            $queryLocation = mysqli_query($con, $sqlLocation);

            $queryAsset = mysqli_query($con, $sql);

            if ($queryAsset) {
                echo "true";
            } else {
                echo "false"; // Error occurred while updating vendor details
            }
        }
    } else {
        // Error occurred while checking for duplicates
        echo "false";
    }
} else {
    echo "false"; // Form not submitted or no ID provided
}
?>
