<?php
include_once '../../../../include/db_connection.php';
session_start();

if (isset($_POST['branchId'])) {
    $branchId = $_POST['branchId'];

    // Get the display_name corresponding to the branchId
    $getDisplayNameSql = "SELECT display_name FROM aims_preset_computer_branch WHERE id = $branchId";
    $getDisplayNameQuery = mysqli_query($con, $getDisplayNameSql);

    if ($getDisplayNameQuery) {
        $row = mysqli_fetch_assoc($getDisplayNameQuery);
        $displayName = $row['display_name'];

        // Perform the update query to set the selected branch as the default location
        $updateSql = "UPDATE aims_preset_computer_branch SET is_default = 1 WHERE id = $id";
        $updateQuery = mysqli_query($con, $updateSql);

        if ($updateQuery) {
            // Delete the existing record in aims_default_location table
            $deleteSql = "DELETE FROM aims_default_location WHERE id = $id";
            $deleteQuery = mysqli_query($con, $deleteSql);

            if ($deleteQuery) {
                // Insert the new default location into aims_default_location table
                $insertSql = "INSERT INTO aims_default_location (id, display_name) VALUES ('$branchId', '$displayName')";
                $insertQuery = mysqli_query($con, $insertSql);

                if ($insertQuery) {
                    // Optionally, you can handle success responses here
                    echo "Success";
                } else {
                    // Handle errors here if needed
                    echo "Error inserting into aims_default_location";
                }
            } else {
                // Handle errors here if needed
                echo "Error deleting from aims_default_location";
            }
        } else {
            // Handle errors here if needed
            echo "Error updating is_default";
        }
    } else {
        // Handle errors here if needed
        echo "Error fetching display_name";
    }
} else {
    // Handle cases where branchId is not set in the POST request
    echo "Branch ID not set";
}
?>
