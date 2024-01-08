<?php
include_once '../../../../include/db_connection.php';
session_start();

if (isset($_POST['department'])) {
    $selectedDepartment = $_POST['department'];

    // Fetch locations based on the selected department from the database
    $sql = "SELECT * FROM aims_preset_location WHERE department = '$selectedDepartment'";
    $result = mysqli_query($con, $sql);

    $locations = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $locations[] = $row;
    }

    if ($locations == []) {
        echo '<option value="">No Selection Found</option>';
    } else {
        foreach ($locations as $location) {
            echo '<option value="' . $location['display_name'] . '">' . $location['display_name'] . '</option>';
        }
    }
} else {
    // Handle the case where the department is not set in the AJAX request
    echo '<option value="">Invalid Request</option>';
}
?>