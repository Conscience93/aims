<?php
include_once '../../../include/db_connection.php';

// Define the function to check the status of a host using its MAC address
function isHostAliveByMac($mac) {
    $command = 'arp -a';
    $output = shell_exec($command);
    $position = strpos($output, "Type");
    $result = substr($output, $position + 4);
    $macArr = preg_split('/\s+/', $result);

    // Find the location of the MAC address in the array
    $locationOfMac = array_search($mac, $macArr);

    if ($locationOfMac !== false) {
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

// Retrieve the category from the URL parameter
$category = isset($_GET['category']) ? urldecode($_GET['category']) : '';

$sqlUser = "SELECT aims_computer.asset_tag, 
                    aims_computer.name, 
                    aims_computer.ram, 
                    aims_computer.processor, 
                    aims_computer_network.ip_address,
                    aims_computer_network.mac_address
                FROM aims_computer
                LEFT JOIN aims_computer_network ON aims_computer.asset_tag = aims_computer_network.asset_tag
                WHERE aims_computer.category ='$category'";

$resultUser = mysqli_query($con, $sqlUser);
?>

<style>
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        margin: 0; /* Remove default margin */
    }

    .wrapper {
        flex: 1;
        position: relative;
        display: flex;
        flex-direction: column;
    }

    /* Center the header content */
    .header-content {
        margin: 0 auto;
        text-align: center;
        max-width: 600px; /* Adjust the maximum width as needed */
    }

    /* Add CSS styles for the footer */
    footer {
        text-align: center;
        padding: 10px;
        width: 100%;
        position: absolute;
    }
</style>

<!DOCTYPE html>
<html>
<!-- ... (Your existing HTML code) ... -->
<body>
    <div class="wrapper">
        <!-- Header Section -->
        <div class="header-content">
            <h4>SOFTWORLD SOFTWARE SDH BHD</h4>
            <div class="info">
                <h>1st Floor, Lot 182, Jalan Song Thian Cheok</h><br>
                <h>93100 Kuching, Sarawak, Malaysia.</h><br>
                <h>Tel: +6082-507070 Fax: +6082-507007</h><br>
                <h>URL: -  Email: admin@softworld.com.my</h><br><br>
                <hr>
            </div>
        </div>

        <!-- Body Section -->
        <main>   
            <!-- Display the retrieved data in a table -->
            <table class="computer-table">
                <tr>
                    <th>No.</th>
                    <th>Asset Tag</th>
                    <th>Name</th>
                    <th>IP Address</th>
                    <th>Status</th>
                </tr>
                <?php
                // Initialize counter
                $counter = 1;

                while ($rowUser = mysqli_fetch_assoc($resultUser)) {
                    $macToCheck = $rowUser['mac_address'];
                    $status = isHostAliveByMac($macToCheck) ? '<span style="color: green;">Online</span>' : '<span style="color: red;">Offline</span>';

                    echo '<tr>';
                    echo '<td>' . $counter . '</td>';       
                    echo '<td>' . ($rowUser['asset_tag'] ? $rowUser['asset_tag'] : '-') . '</td>';
                    echo '<td>' . ($rowUser['name'] ? $rowUser['name'] : '-') . '</td>';
                    echo '<td>' . ($rowUser['ip_address'] ? $rowUser['ip_address'] : '-') . '</td>';
                    echo '<td>' . $status . '</td>';
                    echo '</tr>';
                    
                    // Increment counter for the next row
                    $counter++;
                }
                ?>
            </table>
            <!-- Include additional details as needed -->
        </main>

        <!-- Footer Section -->
        <footer>
            <hr>
            <h>This is a computer-generated document no signature is required.</h>
        </footer>
    </div>
</body>
</html>