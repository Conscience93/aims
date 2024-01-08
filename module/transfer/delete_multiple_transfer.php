<?php
include_once '../../include/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['asset_asset_tag']) && is_array($_POST['asset_asset_tag'])) {
        foreach ($_POST['asset_asset_tag'] as $asset_tag) {
            $escaped_asset_tag = mysqli_real_escape_string($con, $asset_tag);

            // Determine the table based on the asset tag prefix
            $table = '';
            switch ($asset_tag[0]) {
                case 'A':
                    $table = 'aims_transfer_asset';
                    break;
                case 'C':
                    $table = 'aims_transfer_computer';
                    break;
                case 'E':
                    $table = 'aims_transfer_electronics';
                    break;

                default:
                    // Handle unknown prefix or show an error
                    echo "Error: Unknown asset tag prefix.";
                    exit;
            }

            // Delete from the respective table
            $sqlDelete = "DELETE FROM $table WHERE asset_tag = '$escaped_asset_tag'";
            $result = mysqli_query($con, $sqlDelete);

            if ($result) {
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
