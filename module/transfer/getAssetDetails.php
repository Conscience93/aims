<?php

include_once '../../include/db_connection.php';

$selectedAssetName = $_GET['name'];

// Assuming asset_tag is a common column in the mentioned tables
$sqlDetails = "SELECT category, asset_tag, branch, department, location FROM aims_asset WHERE name = '$selectedAssetName'
               UNION
               SELECT category, asset_tag, branch, department, location FROM aims_computer WHERE name = '$selectedAssetName'
               UNION
               SELECT category, asset_tag, branch, department, location FROM aims_electronics WHERE name = '$selectedAssetName'";

$resultDetails = $con->query($sqlDetails);

if ($resultDetails->num_rows > 0) {
    $rowDetails = $resultDetails->fetch_assoc();

    // Fetch the picture from aims_all_asset_picture based on asset_tag
    $assetTag = $rowDetails['asset_tag'];
    $sqlPicture = "SELECT picture FROM aims_all_asset_picture WHERE asset_tag = '$assetTag'";
    $resultPicture = $con->query($sqlPicture);

    if ($resultPicture->num_rows > 0) {
        $rowPicture = $resultPicture->fetch_assoc();
        $details = array(
            'category' => $rowDetails['category'],
            'asset_tag' => $rowDetails['asset_tag'],
            'branch' => $rowDetails['branch'],
            'department' => $rowDetails['department'],
            'location' => $rowDetails['location'],
            'picture' => $rowPicture['picture']
        );
    } else {
        // If there is no picture, still include other details
        $details = array(
            'category' => $rowDetails['category'],
            'asset_tag' => $rowDetails['asset_tag'],
            'branch' => $rowDetails['branch'],
            'department' => $rowDetails['department'],
            'location' => $rowDetails['location'],
            'picture' => '' // Set an empty string or any default value
        );
    }

    // Return the details as JSON
    echo json_encode($details);
} else {
    // Handle the case where details are not found
    echo json_encode(array('category' => 'Not found', 'asset_tag' => 'Not found', 'branch' => 'Not found', 'department' => 'Not found', 'location' => 'Not found', 'picture' => 'Not found'));
}

$con->close();
?>
