<?php
include_once '../../include/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['asset_asset_tag']) && is_array($_POST['asset_asset_tag'])) {
        foreach ($_POST['asset_asset_tag'] as $asset_tag) {
            $escaped_asset_tag = mysqli_real_escape_string($con, $asset_tag);

            // Delete from aims_vehicle
            $sqlDelete = "DELETE FROM aims_vehicle WHERE asset_tag = '$escaped_asset_tag'";
            $result = mysqli_query($con, $sqlDelete);

            if ($result) {
                echo "Asset with asset tag $escaped_asset_tag deleted successfully from aims_vehicle.<br>";

                // Delete picture from aims_all_asset_picture
                $sqlDeletePicture = "DELETE FROM aims_all_asset_picture WHERE asset_tag = '$escaped_asset_tag'";
                $resultPicture = mysqli_query($con, $sqlDeletePicture);

                if (!$resultPicture) {
                    echo "Error deleting picture for asset tag $escaped_asset_tag: " . mysqli_error($con) . "<br>";
                }
            } else {
                echo "Error deleting asset with asset tag $escaped_asset_tag from aims_vehicle: " . mysqli_error($con) . "<br>";
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
