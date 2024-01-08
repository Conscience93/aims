<?php
include_once '../../include/db_connection.php'; // Ensure this line includes your database connection

// Fetch department display_names from the database
$sql = "SELECT display_name FROM aims_preset_department";
$result = mysqli_query($con, $sql);

$departments = [];
while ($row = mysqli_fetch_assoc($result)) {
    $departments[] = $row['display_name'];
}

// Output options for datalist
if (!empty($departments)) {
    foreach ($departments as $department) {
        echo "<option value=\"$department\">";
    }
} else {
    echo '<option value="">No Selection Found</option>';
}
?>
