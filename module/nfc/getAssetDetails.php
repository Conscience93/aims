<?php

include_once '../../include/db_connection.php';

$selectedAssetName = $_GET['name'];

$sqlDetails = "SELECT asset_tag FROM aims_asset WHERE name = '$selectedAssetName'
               UNION
               SELECT asset_tag FROM aims_computer WHERE name = '$selectedAssetName'
               UNION
               SELECT asset_tag FROM aims_electronics WHERE name = '$selectedAssetName'";

$resultDetails = $con->query($sqlDetails);

if ($resultDetails->num_rows > 0) {
    $rowDetails = $resultDetails->fetch_assoc();
    $details = array(
        'asset_tag' => $rowDetails['asset_tag']
    );

    // Return the details as JSON
    echo json_encode($details);
} else {
    // Handle the case where details are not found
    echo json_encode(array('asset_tag' => 'Not found'));
}

$con->close();
?>
