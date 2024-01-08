<?php
// check_website_status.php
if (isset($_POST['url'])) {
    $url = $_POST['url'];
    $status = get_website_status($url); // Replace with your actual function to check the website status
    echo $status;
} else {
    echo 'Error';
}

// Function to check the website status
function get_website_status($url)
{
    $headers = @get_headers($url);

    if ($headers && strpos($headers[0], '200') !== false) {
        return 'Online';
    } else {
        return 'Offline';
    }
}
?>