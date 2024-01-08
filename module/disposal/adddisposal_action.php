<?php
include_once '../../include/db_connection.php';
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

// Array data received from the form
$asset_tag = escapeInput($con, $_POST['asset_tag']);
$name = escapeInput($con, $_POST['name']);
$status = 'ACTIVE';
$category = escapeInput($con, $_POST['category']);
$value = empty($_POST['value']) ? 0 : escapeInput($con, $_POST['value']);
$expected_date = escapeInput($con, $_POST['expected_date']);
$reason = escapeInput($con, $_POST['reason']);
$company = escapeInput($con, $_POST['company']);
$phone_no = escapeInput($con, $_POST['phone_no']);
$email = escapeInput($con, $_POST['email']);
$pic = escapeInput($con, $_POST['pic']);
$pic_phone_no = escapeInput($con, $_POST['pic_phone_no']);
$address = escapeInput($con, $_POST['address']);

$sqlAsset = "INSERT INTO aims_all_asset_disposal 
        (asset_tag, 
        name, 
        status, 
        category, 
        value, 
        expected_date, 
        reason, 
        company, 
        phone_no, 
        email, 
        pic, 
        pic_phone_no, 
        address
        ) 
        VALUES 
        ('$asset_tag', 
        '$name', 
        '$status', 
        '$category', 
        '$value', 
        '$expected_date', 
        '$reason', 
        '$company', 
        '$phone_no', 
        '$email', 
        '$pic', 
        '$pic_phone_no', 
        '$address');";

$queryAsset = mysqli_query($con, $sqlAsset);

if ($queryAsset) {
    // Update the status in the aims_all_asset_disposal table
    $updateStatusSql = "UPDATE aims_all_asset_disposal SET status = 'DISPOSED' WHERE asset_tag = '$asset_tag'";
    $updateStatusQuery = mysqli_query($con, $updateStatusSql);

    if ($updateStatusQuery) {
        // Update the status in the aims_asset table
        $updateAssetStatusSql = "UPDATE aims_asset SET status = 'DISPOSED' WHERE asset_tag = '$asset_tag'";
        mysqli_query($con, $updateAssetStatusSql);

        // Update the status in the aims_electronics table
        $updateElectronicsStatusSql = "UPDATE aims_electronics SET status = 'DISPOSED' WHERE asset_tag = '$asset_tag'";
        mysqli_query($con, $updateElectronicsStatusSql);

        // Update the status in the aims_computer table
        $updateComputerStatusSql = "UPDATE aims_computer SET status = 'DISPOSED' WHERE asset_tag = '$asset_tag'";
        mysqli_query($con, $updateComputerStatusSql);

        echo "true";
    } else {
        echo "Error updating status in aims_all_asset_disposal: " . mysqli_error($con);
    }
} else {
    echo "Error inserting data: " . mysqli_error($con);
}
?>
