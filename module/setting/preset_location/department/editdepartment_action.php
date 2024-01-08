<?php
include_once '../../../../include/db_connection.php';
session_start();

// Function to escape user input
function escapeInput($input) {
    global $con;
    return mysqli_real_escape_string($con, $input);
}

// Array data received from the form
$id = escapeInput($_POST['id']);
$branch = escapeInput($_POST['branch']);
$display_name = escapeInput($_POST['display_name']);
$noe = escapeInput($_POST['noe']);
$staff = escapeInput($_POST['staff']);

// Check if the display name already exists in the database, excluding the current record by ID
$sqlCheckDuplicate = "SELECT COUNT(*) AS count FROM aims_preset_department WHERE display_name = '$display_name' AND id != '$id'";
$queryCheckDuplicate = mysqli_query($con, $sqlCheckDuplicate);
$rowCheckDuplicate = mysqli_fetch_assoc($queryCheckDuplicate);

$sqlTest = "SELECT * FROM aims_preset_department WHERE id = '$id'";
    $resultTest = mysqli_query($con, $sqlTest);
    $rowTest = mysqli_fetch_assoc($resultTest);
    $olddepartmentName = $rowTest['display_name'];

if ($rowCheckDuplicate['count'] > 0) {
    // Display an error message indicating that the display name already exists
    echo "Name is already in use.";
} else {
    // Update data into the aims_preset_department table
    $sql = "UPDATE aims_preset_department SET
        branch = '$branch',
        display_name = '$display_name',
        noe = '$noe',
        staff = '$staff'
    WHERE id = '$id'
    ";

    $sqlAsset = "UPDATE aims_asset SET
    department = '$display_name'
    WHERE department = '$olddepartmentName'";

    $queryAsset = mysqli_query($con, $sqlAsset);

    $sqlComputer = "UPDATE aims_computer SET
    department = '$display_name'
    WHERE department = '$olddepartmentName'";

    $queryComputer = mysqli_query($con, $sqlComputer);

    $sqlElectronic = "UPDATE aims_electronics SET
    department = '$display_name'
    WHERE department = '$olddepartmentName'";

    $queryElectronic = mysqli_query($con, $sqlElectronic);

    $sqlLocation = "UPDATE aims_preset_location SET
    department = '$display_name'
    WHERE department = '$olddepartmentName'";

    $queryLocation = mysqli_query($con, $sqlLocation);

    $queryAsset = mysqli_query($con, $sql);

    if ($queryAsset) {
        echo "true";
    } else {
        echo "false";
    }
}
?>

