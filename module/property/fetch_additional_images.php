<?php
include_once '../../include/db_connection.php';
session_start();


if (isset($_GET['assetTag'])) {
    $assetTag = $_GET['assetTag'];

    // Query the database for additional images based on the asset tag
    $sql = "SELECT picture FROM aims_all_property_picture WHERE asset_tag = '$assetTag'";
    $result = mysqli_query($con, $sql);

    if ($result) {
        $additionalImages = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $additionalImages[] = $row['picture'];
        }
        echo json_encode($additionalImages);
    } else {
        echo json_encode(array()); // Return an empty array if there are no additional images or an error occurs
    }
} else {
    echo json_encode(array()); // Return an empty array if the assetTag parameter is not set
}
?>
