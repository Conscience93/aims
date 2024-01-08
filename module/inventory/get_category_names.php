<?php
include_once '../../include/db_connection.php'; // Ensure this line includes your database connection

// Fetch category names from the database
$sql = "SELECT name FROM aims_inventory_category";
$result = mysqli_query($con, $sql);

$categories = [];
while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row['name'];
}

// Output options for datalist
if (!empty($categories)) {
    foreach ($categories as $category) {
        echo "<option value=\"$category\">";
    }
} else {
    echo '<option value="">No Selection Found</option>';
}
?>
