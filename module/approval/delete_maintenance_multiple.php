<?php
include_once '../../include/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['asset_asset_tag']) && is_array($_POST['asset_asset_tag'])) {
        foreach ($_POST['asset_asset_tag'] as $asset_tag) {
            $escaped_asset_tag = mysqli_real_escape_string($con, $asset_tag);
        
            // Determine the table based on the asset tag prefix
            $table = 'aims_maintenance';

            // Delete the data from the specified table
            $sqlDelete = "DELETE FROM $table WHERE asset_tag = '$escaped_asset_tag'";
            $resultDelete = mysqli_query($con, $sqlDelete);

            if ($resultDelete) {
                echo "Asset with asset tag $escaped_asset_tag deleted successfully from $table.<br>";
            } else {
                echo "Error deleting asset with asset tag $escaped_asset_tag from $table: " . mysqli_error($con) . "<br>";
            }
        }
    } else {
        echo "No assets selected for deletion.<br>";
    }
} else {
    echo "Invalid request method.<br>";
}

// Close the database connection
mysqli_close($con);
?>