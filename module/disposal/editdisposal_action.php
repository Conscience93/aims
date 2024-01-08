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
$id = isset($_POST['id']) ? escapeInput($con, $_POST['id']): null;
$asset_tag = isset($_POST['asset_tag']) ? escapeInput($con, $_POST['asset_tag']): null;
$name = isset($_POST['name']) ? escapeInput($con, $_POST['name']): null;
$status = 'DISPOSED';
$category = isset($_POST['category']) ? escapeInput($con, $_POST['category']): null;
$value = isset($_POST['value']) ? escapeInput($con, $_POST['value']): null;
$expected_date = isset($_POST['expected_date']) ? escapeInput($con, $_POST['expected_date']): null;
$reason = isset($_POST['reason']) ? escapeInput($con, $_POST['reason']): null;
$company = isset($_POST['company']) ? escapeInput($con, $_POST['company']): null;
$phone_no = isset($_POST['phone_no']) ? escapeInput($con, $_POST['phone_no']): null;
$email = isset($_POST['email']) ? escapeInput($con, $_POST['email']): null;
$pic = isset($_POST['pic']) ? escapeInput($con, $_POST['pic']): null;
$pic_phone_no = isset($_POST['pic_phone_no']) ? escapeInput($con, $_POST['pic_phone_no']): null;
$address = isset($_POST['address']) ? escapeInput($con, $_POST['address']): null;

// Update attributes other than pictures
$sql_asset = "UPDATE aims_all_asset_disposal SET
    name = '$name',
    category = '$category',
    value = '$value',
    expected_date = '$expected_date',
    reason = '$reason',
    company = '$company',
    phone_no = '$phone_no',
    email = '$email',
    pic = '$pic',
    pic_phone_no = '$pic_phone_no',
    address = '$address'
WHERE id = '$id'
";

$queryAsset = mysqli_query($con, $sql_asset);

if ($queryAsset) {
    echo "true";
} else {
    echo "false: " . mysqli_error($con);
}
?>