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
                    $table = 'aims_asset';
                    break;
                case 'C':
                    $table = 'aims_computer';
                    break;
                case 'E':
                    $table = 'aims_electronics';
                    break;
                case 'F':
                    $table = 'aims_vehicle';
                    break;
                case 'P':
                    $table = 'aims_property';
                    break;
                // Add cases for other prefixes if needed
                // ...

                default:
                    // Handle unknown prefix or show an error
                    echo "Error: Unknown asset tag prefix.";
                    exit;
            }

            // Update the 'approval' attribute to 'REJECT'
            $sqlUpdate = "UPDATE $table SET approval = 'REJECT' WHERE asset_tag = '$escaped_asset_tag'";
            $resultUpdate = mysqli_query($con, $sqlUpdate);

            if ($resultUpdate) {
                echo "Asset with asset tag $escaped_asset_tag rejected successfully in $table.<br>";
            } else {
                echo "Error updating asset with asset tag $escaped_asset_tag in $table: " . mysqli_error($con) . "<br>";
            }
        }
    } else {
        echo "No assets selected for approval.<br>";
    }
} else {
    echo "Invalid request method.<br>";
}

// Close the database connection
mysqli_close($con);
?>