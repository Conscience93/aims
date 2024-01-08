<?php
// get_status_ajax.php

// Include the functions
function isHostAliveByMac($mac) {
    $command = 'arp -a';
    $output = shell_exec($command);
    $position = strpos($output, "Type");
    $result = substr($output, $position + 4);
    $macArr = preg_split('/\s+/', $result);

    // Find all occurrences of the MAC address in the array
    $locationsOfMac = array_keys($macArr, $mac);

    // Check if the MAC address is found in the ARP table
    if (!empty($locationsOfMac)) {
        foreach ($locationsOfMac as $locationOfMac) {
            // Get the corresponding IP address
            $ipAddress = $macArr[$locationOfMac - 1];

            // Ping the IP address
            $pingCommand = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? 'ping -n 1 ' : 'ping -c 1 ';
            $pingCommand .= $ipAddress;

            exec($pingCommand, $pingOutput, $pingResult);

            // Check the result of the ping
            $isOnline = ($pingResult === 0); // 0 means success

            // If at least one IP is online, consider the host online
            if ($isOnline) {
                return true;
            }
        }

        // If none of the IPs are online, consider the host offline
        return false;
    } else {
        return false; // MAC address not found in ARP table
    }
    if (!$isOnline) {
        return isHostAliveByIP(getIPAddressFromHostnameOrOtherMethod($hostname));
    }
}

// Define the function to check the status of a host using its IP address
function isHostAliveByIP($ipAddress) {
    $pingCommand = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? 'ping -n 1 ' : 'ping -c 1 ';
    $pingCommand .= $ipAddress;

    exec($pingCommand, $pingOutput, $pingResult);

    return ($pingResult === 0); // 0 means success
}

function getIPAddressFromHostnameOrOtherMethod($hostname) {
    // Use DNS resolution to get the IP address
    $ipAddress = gethostbyname($hostname);

    return $ipAddress;
}

// Check if MAC parameter is set
if (isset($_GET['mac'])) {
    $mac = $_GET['mac'];

    // Call the isHostAliveByMac function
    $isOnline = isHostAliveByMac($mac);

    // Return the result as JSON
    echo json_encode(['isOnline' => $isOnline]);
} else {
    // If MAC parameter is not set, return an error message
    echo json_encode(['error' => 'MAC parameter not provided']);
}
?>