<?php
if($submodule_access['asset']['view']!=1){
    header('location: logout.php');
}

$sqlServer = "SELECT aims_computer.asset_tag, 
                    aims_computer.name, 
                    aims_computer.processor, 
                    aims_computer_network.ip_address,
                    aims_computer_network.mac_address
                FROM aims_computer
                LEFT JOIN aims_computer_network ON aims_computer.asset_tag = aims_computer_network.asset_tag
                WHERE aims_computer.category ='Server'";

$resultServer = mysqli_query($con, $sqlServer);

// SQL query to retrieve data for virtual machines
$sqlVirtual = "SELECT aims_computer.asset_tag, 
                        aims_computer.name, 
                        aims_computer.processor, 
                        aims_computer_network.ip_address,
                        aims_computer_network.mac_address,
                        aims_computer.server_name
                    FROM aims_computer
                    LEFT JOIN aims_computer_network ON aims_computer.asset_tag = aims_computer_network.asset_tag
                    WHERE aims_computer.category = 'Virtual Machine' 
                        AND aims_computer.server_name IS NOT NULL";

$resultVirtual = mysqli_query($con, $sqlVirtual);
?>

<style>
    .action-button {
        cursor: pointer;
    }
    
    .hidden-number {
        visibility: hidden;
    }

    .branch-link:hover {
        color: #ff6600;
        text-decoration: underline;
        cursor: pointer;
    }

    #table_details {
        width: 100%;
        border-collapse: collapse;
        transition: width 0.3s ease;
    }

    #table_details th,
    #table_details td {
        text-align: left;
        padding: 12px;
        border: 1px solid #ddd;
    }

    #table_details td {
        width: auto; /* Set auto width for td */
    }

    #table_details th {
        background-color: #f2f2f2;
    }

    #table_details td {
        border-bottom: 1px solid #ddd;
        background-color: transparent;
    }

    /* -----------------------------
    CARD DISPLAY
    ----------------------------- */

    /* Header Box 1 */
    .card.header-box1 {
        width: calc(33.33% - 10px);
        height: 10vh;
        box-sizing: border-box;
        margin-bottom: 10px;
    }

    /* New Header Box  */
    .card.header-box3 {
        width: calc(21.88% - 10px);
        height: 10vh;
        box-sizing: border-box;
        margin-bottom: 10px;
    }

    .container {
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: space-between;
        margin-right: 0px;
        margin-left: 0px;
        float: left;
        height: 100vh;
        max-width: 100vw;
    }

    .card {
        width: calc(66.66% - 10px); /* Adjust the width as needed for two cards in a row */
        max-height: 42vh;
        overflow-y: auto;
        box-sizing: border-box;
    }

    /* card 2 */
    .card.box2 {
        width: calc(33.33% - 10px); /* Adjust the width as needed for two cards in a row */
        max-height: 74vh; /* Adjust the height as needed for Box 2 */
        margin-bottom: 10px;
    }

    /* Box 3 */
    .card.box3 {
        width: calc(66.66% - 10px); /* Adjust the width as needed for two cards in a row */
        max-height: 30vh; /* Adjust the height as needed for Box 3 */
        margin-top: -32vh; /* Add a negative margin at the top to move Box 3 up */
    }

</style>


<!-- Content -->
<div class="main">
    <div class="container">
        <!-- New Header Box 3 - Part 1 -->
        <div class="card shadow rounded header-box3">
            <div class="card-body">
                <!-- Content for Header Box 3 - Part 1 goes here -->
            </div>
        </div>

        <!-- New Header Box 3 - Part 2 -->
        <div class="card shadow rounded header-box3">
            <div class="card-body">
                <!-- Content for Header Box 3 - Part 2 goes here -->
            </div>
        </div>

        <!-- New Header Box 3 - Part 3 -->
        <div class="card shadow rounded header-box3">
            <div class="card-body">
                <!-- Content for Header Box 3 - Part 3 goes here -->
            </div>
        </div>

        <!-- Header Box 1 -->
        <div class="card shadow rounded header-box1">
            <div class="card-body">
                <!-- Content for Header Box 1 goes here -->
            </div>
        </div>

        <!-- Box 1 -->
        <div class="card shadow rounded">
            <div class="card-header" style="background:white;">
                <div class="row">
                    <div class="col-6">
                        <h3>Website Status</h3>
                    </div>
                    <div class="col-6">
                        <div class="float-right">
                            <a class="btn btn-primary" href="#" id="generateReport" target="_blank" title="Print">Generate Report</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body" style="max-height: 80vh; overflow-y: scroll;">
                <table id="table_server_details" class="computer-table">
                    <thead>
                        <tr style="background-color: #f2f2f2;">
                            <th>No.</th>
                            <th>Asset Tag</th>
                            <th>Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <?php
                    // Initialize counter
                    $counter = 1;

                    // Process data from aims_computer for servers
                    while ($rowServer = mysqli_fetch_assoc($resultServer)) {
                        $macToCheck = $rowServer['mac_address'];

                        // Placeholder status while pinging is in progress
                        $status = 'Checking...';
                        // Use a variable to store the color of the status text
                        $statusColor = 'gray';

                        echo '<tr style="background-color: #f2f2f2;">';
                        echo '<td>' . $counter . '</td>';
                        echo '<td><a class="branch-link" data-asset-tag="' . $rowServer['asset_tag'] . '" href="#">' . $rowServer['asset_tag'] . '</a></td>';
                        echo '<td>' . ($rowServer['name'] ? $rowServer['name'] : '-') . '</td>';
                        echo '<td style="color: ' . $statusColor . ';" class="status-cell server-status-cell" data-mac="' . $macToCheck . '">' . $status . '</td>';
                        echo '</tr>';

                        // Process data from aims_computer_network for virtual machines
                        $virtualCounter = 0; // Initialize counter for virtual machines
                        mysqli_data_seek($resultVirtual, 0); // Reset the virtual result set
                        while ($rowVirtual = mysqli_fetch_assoc($resultVirtual)) {
                            if ($rowServer['name'] == $rowVirtual['server_name']) {
                                $virtualCounter += 0.01; // Increment virtual counter with decimal
                                $virtualMacToCheck = $rowVirtual['mac_address'];
                                // Placeholder status while pinging is in progress
                                $virtualStatus = 'Checking...';
                                // Use a variable to store the color of the status text
                                $virtualStatusColor = 'gray';

                                echo '<tr>';
                                echo '<td class="hidden-number">' . ($counter + $virtualCounter) . '</td>';
                                echo '<td><a class="branch-link" data-asset-tag="' . $rowVirtual['asset_tag'] . '" href="#">' . $rowVirtual['asset_tag'] . '</a></td>';
                                echo '<td>' . ($rowVirtual['name'] ? $rowVirtual['name'] : '-') . '</td>';
                                echo '<td style="color: ' . $virtualStatusColor . ';" class="status-cell virtual-status-cell" data-mac="' . $virtualMacToCheck . '">' . $virtualStatus . '</td>';
                                echo '</tr>';
                            }
                        }

                        // Increment counter for the next server
                        $counter++;
                    }
                    ?>
                </table>
            </div>
        </div>
        <!-- Box 2: Add more boxes as needed -->
        <div class="card shadow rounded box2">
            <div class="card-body">
                <!-- Content for Box 2 goes here -->
            </div>
        </div>

        <!-- Box 3: Add more boxes as needed -->
        <div class="card shadow rounded box3">
            <div class="card-body">
                <!-- Content for Box 3 goes here -->
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Click event for branch links
        $('.branch-link').on('click', function (e) {
            e.preventDefault();

            // Get the asset tag from the clicked link
            var assetTag = $(this).data('asset-tag');

            // Load transfer details via AJAX
            $.ajax({
                type: 'GET',
                url: './module/report/server/load_details.php',
                data: { assetTag: assetTag },
                success: function (data) {
                    // Update modal body with transfer details
                    $('#ModalBody').html(data);

                    // Show the modal
                    $('#Modal').modal('show');
                },
                error: function () {
                    console.error('Error loading details');
                }
            });
        });
    });

    $(document).ready(function() {
        // Asynchronously update the status column for server cells
        $('.server-status-cell').each(function() {
            var cell = $(this);
            var macToCheck = cell.data('mac');

            // Perform asynchronous ping
            $.ajax({
                url: './module/report/server/get_status_ajax.php',
                data: { mac: macToCheck },
                success: function(result) {
                    // Update status and color based on the ping result
                    var status = result === '1' ? 'Online' : 'Offline';
                    var statusColor = result === '1' ? 'green' : 'red';
                    cell.text(status).css('color', statusColor);
                },
                error: function() {
                    // Handle error if needed
                }
            });
        });

        // Asynchronously update the status column for virtual machine cells
        $('.virtual-status-cell').each(function() {
            var cell = $(this);
            var macToCheck = cell.data('mac');

            // Perform asynchronous ping
            $.ajax({
                url: './module/report/server/get_virtual_status_ajax.php',
                data: { mac: macToCheck },
                success: function(result) {
                    // Update status and color based on the ping result
                    var virtualStatus = result === '1' ? 'Online' : 'Offline';
                    var virtualStatusColor = result === '1' ? 'green' : 'red';
                    cell.text(virtualStatus).css('color', virtualStatusColor);
                },
                error: function() {
                    // Handle error if needed
                }
            });
        });

        // Datatable initialization
        $('#table_server_details').DataTable({
            "paging": true,
            "ordering": true,
            "info": true,
            "searching": true,
            "pageLength": 4, // Set the number of items per page
            "columnDefs": [
                { "orderable": false, "targets": 3 }
            ]
        });


        // Hide the content of the cells with the hidden-number class
        $('.hidden-number').empty();

        // JavaScript code to update the href attribute
        $('#generateReport').on('click', function() {
            var printLink = './module/report/server/print.php?category=' + 'server';
            this.href = printLink;
        });
    });
</script>