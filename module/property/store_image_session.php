<?php
include_once '../../include/db_connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $assetTag = $_POST['assetTag'];
    $newImageUrl = $_POST['newImageUrl'];

    // Store the image URL in a session variable
    $_SESSION[$assetTag] = $newImageUrl;

    // Debugging: Log values
    error_log("Asset Tag: " . $assetTag);
    error_log("New Image URL: " . $newImageUrl);

    // Return a response if needed
    echo json_encode(['success' => true]);
}