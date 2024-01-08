<?php

include_once '../../../include/db_connection.php';

$searchTerm = $_GET['name'];

// Use UNION to combine results from aims_asset, aims_computer, and aims_electronics
$sql = "SELECT name FROM aims_electronics WHERE name LIKE '%$searchTerm%' AND status = 'ACTIVE'";

$result = $con->query($sql);

if ($result->num_rows > 0) {
    // Start an unordered list
    echo '<ul class="suggested-names">';
    
    while ($row = $result->fetch_assoc()) {
        // Output each suggestion as a list item
        echo '<li>' . $row['name'] . '</li>';
    }

    // Close the unordered list
    echo '</ul>';
} else {
    // No results, you can provide a message or leave it empty
    echo '<p>No results found</p>';
}

$con->close();
?>
