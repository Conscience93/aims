<?php
include_once '../../include/db_connection.php';
session_start();

// Query to fetch software categories
$sql = "SELECT * FROM aims_software_category";
$result = mysqli_query($con, $sql);

// Check if there are results
if (mysqli_num_rows($result) > 0) {
    $categories = array();
    
    // Fetch and store categories in an array
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
    
    // Return categories as JSON
    echo json_encode($categories);
} else {
    // No categories found
    echo json_encode(array());
}

// Close the database connection
mysqli_close($con);
?>
