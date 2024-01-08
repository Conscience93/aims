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
$display_name = isset($_POST['type']) ? escapeInput($con, $_POST['type']) : null;

// Get asset category running number
$sql = mysqli_query($con, "SELECT * FROM aims_inventory_category_run_no WHERE display_name = '$display_name'");
$result = mysqli_fetch_assoc($sql);
$asset_running_no = $result['next_no'];

// Complete asset tag wording, adding zero to the left
$item_tag = $result['prefix'] . str_pad($asset_running_no, 5, "0", STR_PAD_LEFT);

    $sqlAsset = "INSERT INTO aims_inventory 
        (item_tag,
        stock, 
        name, 
        created_date, 
        default_location, 
        category, 
        type,
        class, 
        uom, 
        sales_price, 
        purchase_price,
        po_number,
        do_number
        ) 
        VALUES 
        ('$item_tag',
        '$stock',
        '$name', 
        '$created_date', 
        '$default_location', 
        '$category', 
        '$type', 
        '$class', 
        '$uom', 
        '$sales_price',
        '$purchase_price',
        '$po_number',
        '$do_number');";

    $queryAsset = mysqli_query($con, $sqlAsset);

    if ($queryAsset) {
        $next_no = $asset_running_no + 1;
        $update_running_no = mysqli_query($con, "UPDATE aims_inventory_category_run_no SET next_no = '$next_no' WHERE display_name = '$display_name'");
        echo "true";
    } else {
        echo "false";
    }
?>