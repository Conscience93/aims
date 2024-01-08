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
$id = isset($_POST['id']) ? escapeInput($con, $_POST['id']) : null;
$item_tag = isset($_POST['item_tag']) ? escapeInput($con, $_POST['item_tag']) : null;
$stock = isset($_POST['stock']) ? escapeInput($con, $_POST['stock']) : null;
$name = isset($_POST['name']) ? escapeInput($con, $_POST['name']) : null;
$created_date = isset($_POST['created_date']) ? escapeInput($con, $_POST['created_date']) : null;
$default_location = isset($_POST['default_location']) ? escapeInput($con, $_POST['default_location']) : null;
$category = isset($_POST['category']) ? escapeInput($con, $_POST['category']) : null;
$type = isset($_POST['type']) ? escapeInput($con, $_POST['type']) : null;
$class = isset($_POST['class']) ? escapeInput($con, $_POST['class']) : null;
$uom = isset($_POST['uom']) ? escapeInput($con, $_POST['uom']) : null;
$sales_price = isset($_POST['sales_price']) ? escapeInput($con, $_POST['sales_price']) : null;
$purchase_price = isset($_POST['purchase_price']) ? escapeInput($con, $_POST['purchase_price']) : null;
$po_number = isset($_POST['po_number']) ? escapeInput($con, $_POST['po_number']) : null;
$do_number = isset($_POST['do_number']) ? escapeInput($con, $_POST['do_number']) : null;

// Update attributes other than pictures
$sql_asset = "UPDATE aims_inventory SET
    stock = '$stock',
    name = '$name',
    created_date = '$created_date',
    default_location = '$default_location',
    category = '$category',
    type = '$type',
    class = '$class',
    uom = '$uom',
    sales_price = '$sales_price',
    purchase_price = '$purchase_price',
    po_number = '$po_number',
    do_number = '$do_number'
WHERE id = '$id'
";

$queryAsset = mysqli_query($con, $sql_asset);

if ($queryAsset) {
    echo "true";
} else {
    echo "false: " . mysqli_error($con);
}
?>