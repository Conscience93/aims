<?php
include_once '../../include/db_connection.php'; // Ensure this line includes your database connection

// Fetch branch display_names from the database
$sql = "SELECT display_name FROM aims_preset_computer_branch";
$result = mysqli_query($con, $sql);

$branchs = [];
while ($row = mysqli_fetch_assoc($result)) {
    $branchs[] = $row['display_name'];
}

// Output options for datalist
if (!empty($branchs)) {
    foreach ($branchs as $branch) {
        echo "<option value=\"$branch\">";
    }
} else {
    echo '<option value="">No Selection Found</option>';
}
?>
