<?php
include_once '../../include/db_connection.php';
session_start();

// Fetch category names from the database
$sql = "SELECT category_name FROM aims_preset_inventory_item_category";
$result = mysqli_query($con, $sql);

$categories = array();

while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row['category_name'];
}

// Return the category names as a JSON response
header('Content-Type: application/json');
echo json_encode($categories);
?>
