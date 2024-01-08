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
$department = escapeInput($_POST['department']);
$display_name = escapeInput($_POST['display_name']);

// Check if the display name already exists in the database, excluding the current record by ID
$sqlCheckDuplicate = "SELECT COUNT(*) AS count FROM aims_preset_location WHERE display_name = '$display_name' AND id != '$id'";
$queryCheckDuplicate = mysqli_query($con, $sqlCheckDuplicate);
$rowCheckDuplicate = mysqli_fetch_assoc($queryCheckDuplicate);

$sqlTest = "SELECT * FROM aims_preset_location WHERE id = '$id'";
    $resultTest = mysqli_query($con, $sqlTest);
    $rowTest = mysqli_fetch_assoc($resultTest);
    $oldlocationName = $rowTest['display_name'];

if ($rowCheckDuplicate['count'] > 0) {
    // Display an error message indicating that the display name already exists
    echo "Name is already in use. (Duplicate)";
} else {
    // Update data into the aims_preset_location table
    $sql = "UPDATE aims_preset_location SET
        branch = '$branch',
        department = '$department',
        display_name = '$display_name'
    WHERE id = '$id'
    ";

    $sqlAsset = "UPDATE aims_asset SET
    `location` = '$display_name'
    WHERE `location` = '$oldlocationName'";

    $queryAsset = mysqli_query($con, $sqlAsset);

    $sqlComputer = "UPDATE aims_computer SET
    `location` = '$display_name'
    WHERE `location` = '$oldlocationName'";

    $queryComputer = mysqli_query($con, $sqlComputer);

    $sqlElectronic = "UPDATE aims_electronics SET
    `location` = '$display_name'
    WHERE `location` = '$oldlocationName'";

    $queryElectronic = mysqli_query($con, $sqlElectronic);

    $queryAsset = mysqli_query($con, $sql);

    if ($queryAsset) {
        echo "true";
    } else {
        echo "false";
    }
}
?>
