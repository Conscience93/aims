<?php
// get_virtual_status_ajax.php

// Get the MAC address from the AJAX request
$macToCheck = $_GET['mac'];

// Define the function to check the status of a virtual machine using its MAC address
function isVirtualMachineAliveByMac($mac) {
    $command = 'arp -a';
    $output = shell_exec($command);
    $position = strpos($output, "Type");
    $result = substr($output, $position + 4);
    $macArr = preg_split('/\s+/', $result);

    // Find the location of the MAC address in the array
    $locationOfMac = array_search($mac, $macArr);

    if ($locationOfMac !== false && $mac != "") {
        // Get the corresponding IP address
        $ipAddress = $macArr[$locationOfMac - 1];

        // Ping the IP address
        $pingCommand = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? 'ping -n 1 ' : 'ping -c 1 ';
        $pingCommand .= $ipAddress;

        exec($pingCommand, $pingOutput, $pingResult);

        // Check the result of the ping
        return $pingResult === 0; // 0 means success
    } else {
        return false; // MAC address not found in ARP table
    }
}

// Check the status of the virtual machine and return the result
$virtualStatus = isVirtualMachineAliveByMac($macToCheck) ? '1' : '0';
echo $virtualStatus;
?>