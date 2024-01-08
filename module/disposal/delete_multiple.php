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

            // Delete from the main table
            $sqlDelete = "DELETE FROM $table WHERE asset_tag = '$escaped_asset_tag'";
            $result = mysqli_query($con, $sqlDelete);

            if ($result) {
                echo "Asset with asset tag $escaped_asset_tag deleted successfully from $table.<br>";

                // Delete picture from aims_all_asset_picture
                $sqlDeletePicture = "DELETE FROM aims_all_asset_picture WHERE asset_tag = '$escaped_asset_tag'";
                $resultPicture = mysqli_query($con, $sqlDeletePicture);

                if (!$resultPicture) {
                    echo "Error deleting picture for asset tag $escaped_asset_tag: " . mysqli_error($con) . "<br>";
                }

                // Additional deletes for related tables
                if ($table === 'aims_computer') {
                    // Delete from aims_software
                    $sqlDeleteSoftware = "DELETE FROM aims_software WHERE asset_tag = '$escaped_asset_tag'";
                    $resultSoftware = mysqli_query($con, $sqlDeleteSoftware);

                    if (!$resultSoftware) {
                        echo "Error deleting software for asset tag $escaped_asset_tag: " . mysqli_error($con) . "<br>";
                    }

                    // Delete from aims_computer_hard_drive
                    $sqlDeleteHardDrive = "DELETE FROM aims_computer_hard_drive WHERE asset_tag = '$escaped_asset_tag'";
                    $resultHardDrive = mysqli_query($con, $sqlDeleteHardDrive);

                    if (!$resultHardDrive) {
                        echo "Error deleting hard drive for asset tag $escaped_asset_tag: " . mysqli_error($con) . "<br>";
                    }

                    // Delete from aims_computer_network
                    $sqlDeleteNetwork = "DELETE FROM aims_computer_network WHERE asset_tag = '$escaped_asset_tag'";
                    $resultNetwork = mysqli_query($con, $sqlDeleteNetwork);

                    if (!$resultNetwork) {
                        echo "Error deleting network for asset tag $escaped_asset_tag: " . mysqli_error($con) . "<br>";
                    }

                    // Delete from aims_computer_user
                    $sqlDeleteUser = "DELETE FROM aims_computer_user WHERE asset_tag = '$escaped_asset_tag'";
                    $resultUser = mysqli_query($con, $sqlDeleteUser);

                    if (!$resultUser) {
                        echo "Error deleting user for asset tag $escaped_asset_tag: " . mysqli_error($con) . "<br>";
                    }

                    // Delete from aims_computer_remote_access
                    $sqlDeleteRemoteAccess = "DELETE FROM aims_computer_remote_access WHERE asset_tag = '$escaped_asset_tag'";
                    $resultRemoteAccess = mysqli_query($con, $sqlDeleteRemoteAccess);

                    if (!$resultRemoteAccess) {
                        echo "Error deleting remote access for asset tag $escaped_asset_tag: " . mysqli_error($con) . "<br>";
                    }
                }

                // Delete from aims_all_asset_disposal
                $sqlDeleteDisposal = "DELETE FROM aims_all_asset_disposal WHERE asset_tag = '$escaped_asset_tag'";
                $resultDisposal = mysqli_query($con, $sqlDeleteDisposal);

                if (!$resultDisposal) {
                    echo "Error deleting from aims_all_asset_disposal for asset tag $escaped_asset_tag: " . mysqli_error($con) . "<br>";
                }
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
