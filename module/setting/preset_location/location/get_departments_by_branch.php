<?php
include_once '../../../../include/db_connection.php';
session_start();

if (isset($_POST['branch'])) {
    $selectedBranch = $_POST['branch'];

    // Fetch departments based on the selected branch from the database
    $sql = "SELECT * FROM aims_preset_department WHERE branch = '$selectedBranch'";
    $result = mysqli_query($con, $sql);

    $departments = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $departments[] = $row;
    }

    if ($departments == []) {
        echo '<option value="">No Selection Found</option>';
    } else {
        foreach ($departments as $department) {
            echo '<option value="' . $department['display_name'] . '">' . $department['display_name'] . '</option>';
        }
    }
} else {
    // Handle the case where the branch is not set in the AJAX request
    echo '<option value="">Invalid Request</option>';
}
?>