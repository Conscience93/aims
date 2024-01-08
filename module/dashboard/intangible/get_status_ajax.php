<?php
// Get the URL from the AJAX request
$urlToCheck = $_GET['url'];

// Define the function to check the status of a website using its URL
function isWebsiteAliveByUrl($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute cURL request
    $response = curl_exec($ch);

    if ($response === false) {
        // Handle cURL error
        $error = curl_error($ch);
        error_log("CURL Error: $error");
        return false;
    }

    // Get HTTP status code
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Check if the HTTP status code indicates success (2xx or 3xx)
    return ($httpCode >= 200 && $httpCode < 400);
}

// Check the status of the website and return the result
$status = isWebsiteAliveByUrl($urlToCheck) ? '1' : '0';
echo $status;
?>