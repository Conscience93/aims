<?php
include_once '../../include/db_connection.php';
session_start();

if (isset($_POST['category'])) {
    $selectedCategory = $_POST['category'];

    // Fetch types based on the selected category from the database
    $sql = "SELECT * FROM aims_inventory_category_run_no WHERE category = '$selectedCategory'";
    $result = mysqli_query($con, $sql);

    $types = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $types[] = $row;
    }

    if ($types == []) {
        echo '<option value="">No Selection Found</option>';
    } else {
        foreach ($types as $type) {
            echo '<option value="' . $type['display_name'] . '">' . $type['display_name'] . '</option>';
        }
    }
} else {
    // Handle the case where the category is not set in the AJAX request
    echo '<option value="">Invalid Request</option>';
}
?>