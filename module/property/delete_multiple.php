<?php
include_once '../../include/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['asset_asset_tag']) && is_array($_POST['asset_asset_tag'])) {
        foreach ($_POST['asset_asset_tag'] as $asset_tag) {
            $escaped_asset_tag = mysqli_real_escape_string($con, $asset_tag);

            // Delete from the main tables
            $tables = ['aims_property_residential', 'aims_property_commercial', 'aims_property_specialized', 'aims_property_land'];

            foreach ($tables as $table) {
                $sqlDelete = "DELETE FROM $table WHERE asset_tag = '$escaped_asset_tag'";
                $result = mysqli_query($con, $sqlDelete);

                if (!$result) {
                    echo "Error deleting asset with asset tag $escaped_asset_tag from $table: " . mysqli_error($con) . "<br>";
                }
            }

            // Delete picture from aims_all_property_picture
            $sqlDeletePicture = "DELETE FROM aims_all_property_picture WHERE asset_tag = '$escaped_asset_tag'";
            $resultPicture = mysqli_query($con, $sqlDeletePicture);

            if (!$resultPicture) {
                echo "Error deleting picture for asset tag $escaped_asset_tag: " . mysqli_error($con) . "<br>";
            }
        }

        echo "success"; // Provide a success response to the AJAX request
    } else {
        echo "No assets selected for deletion.<br>";
    }
} else {
    echo "Invalid request method.<br>";
}

// Close the database connection
mysqli_close($con);
?>
