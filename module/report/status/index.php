<?php
if($submodule_access['asset']['view']!=1){
    header('location: logout.php');
}

$sqlServer = "SELECT aims_computer.asset_tag, 
                    aims_computer.name, 
                    aims_computer.ram, 
                    aims_computer.processor, 
                    aims_computer_network.ip_address,
                    aims_computer_network.mac_address
                FROM aims_computer
                LEFT JOIN aims_computer_network ON aims_computer.asset_tag = aims_computer_network.asset_tag
                WHERE aims_computer.category ='desktop'";

$resultServer = mysqli_query($con, $sqlServer);

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

    /* Style for Transfer History Modal */
    #Modal {
        max-width: 200%; /* Adjust the percentage for the max-width as needed */
        width: auto;
        margin: 0 auto;
        margin-top: 50px;
        padding-top: 60px;
        transition: max-width 0.3s ease; /* Add transition for max-width */
    }

    #Modal .modal-content {
        margin: auto;
        display: block;
        width: 100%;
        max-width: 800px;
    }

    #table_details {
        width: 100%;
        border-collapse: collapse; /* Add border-collapse property */
        transition: width 0.3s ease;
    }

    #table_details th,
    #table_details td {
        text-align: left;
        padding: 12px;
        border: 1px solid #ddd; /* Add border property */
    }

    #table_details td{
        width:500px;
    }

    #table_details th {
        background-color: #f2f2f2;
    }

    #table_details td {
        border-bottom: 1px solid #ddd;
        background-color: transparent; /* Set the background color of td to transparent */
    }

    /* Style for Transfer History Modal */
    #Modal {
        max-width: 200%; /* Adjust the percentage for the max-width as needed */
        width: auto;
        margin: 0 auto;
        margin-top: 50px;
        padding-top: 60px;
        transition: max-width 0.3s ease; /* Add transition for max-width */
    }

    #Modal .modal-content {
        margin: auto;
        display: block;
        width: 100%;
        max-width: 800px;
    }

    /* Responsive design for smaller screens */
    @media (max-width: 768px) {
        #Modal {
            max-width: 100%;
        }
    }
</style>

<!-- Content -->
<div class="main">

    <!-- Tab navigation -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="tab-server_details" data-toggle="tab" href="#server_details" role="tab" aria-controls="server_details" aria-selected="true">Computers</a>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content" id="myTabContent">
        <!-- Tab 1: Server Details -->
        <div class="tab-pane fade show active" id="server_details" role="tabpanel" aria-labelledby="tab-server_details">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Desktop Report</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a class="btn btn-primary" href="#" id="generateReport" onclick="confirmGenerateReport()" title="Print">Generate Report</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="max-height: 80vh; overflow-y: scroll;">
                    <!-- Generate table from query with pagination -->
                    <table id="table_server_details" class="computer-table">
                        <thead>
                            <tr style="background-color: #f2f2f2;">
                                <th>No.</th>
                                <th>Asset Tag</th>
                                <th>Name</th>
                                <th>IP Address</th>
                                <th>MAC Address</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <?php
                        // Initialize counter
                        $counter = 1;

                        // Process data from aims_computer for servers
                        while ($rowServer = mysqli_fetch_assoc($resultServer)) {
                            
                        
                            // Output table rows with a placeholder status
                            echo '<tr style="background-color: #f2f2f2;">';
                            echo '<td>' . $counter . '</td>';
                            echo '<td><a class="branch-link" data-asset-tag="' . $rowServer['asset_tag'] . '" href="#">' . $rowServer['asset_tag'] . '</a></td>';
                            echo '<td>' . ($rowServer['name'] ? $rowServer['name'] : '-') . '</td>';
                            echo '<td>' . ($rowServer['ip_address'] ? $rowServer['ip_address'] : '-') . '</td>';
                            echo '<td>' . ($rowServer['mac_address'] ? $rowServer['mac_address'] : '-') . '</td>';
                            echo '<td class="status-cell" data-mac="' . $rowServer['mac_address'] . '" data-ip="' . '">Checking...</td>';
                            echo '</tr>';
                        
                            // Increment counter for the next server
                            $counter++;
                        }
                        ?>
                    </table>
                </div>            
            </div>
        </div>         
    </div>
    <!-- Modal for details -->
    <div class="modal" id="Modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">More Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="ModalBody">
                <table id="table_details">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Asset Tag</th>
                            <th>Name</th>
                            <th>Processor</th>
                            <th>Ram</th>
                            <th>Brand</th>
                            <th>Current Location</th>
                        </tr>
                    </thead>
                    <?php
                    $sqlComputer = "SELECT * FROM aims_computer WHERE asset_tag = '$assetTag'";
                    $queryComputer = mysqli_query($con, $sqlComputer);

                    $rowCount = 1; // Initialize the row counter

                    while ($rowTransfer = mysqli_fetch_assoc($queryComputer)) {
                        echo "<tr>";
                        echo "<td>" . $rowCount . "</td>";
                        echo "<td>" . $rowTransfer['asset_tag'] . "</td>";
                        echo "<td>" . $rowTransfer['name'] . "</td>";
                        echo "<td>" . $rowTransfer['processor'] . "</td>";
                        echo "<td>" . $rowTransfer['ram'] . "</td>";
                        echo "<td>" . $rowTransfer['computer_brand'] . "</td>";
                        echo "<td>" . $rowTransfer['branch'] . "</td>";
                        echo "</tr>";
                        $rowCount++; // Increment the row counter
                    }
                    ?>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary" id="printBtn">Print</button> -->
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function confirmGenerateReport() {
        Swal.fire({
            title: "Select Report Type",
            icon: "question",
            showCancelButton: true,
            cancelButtonText: "Discard",
            confirmButtonText: "Confirm",
            input: 'select',
            inputOptions: {
                'generalreport': 'General',
                'softwarereport': 'Software',
                'remotereport': 'Remote'
            },
            inputPlaceholder: 'Select a report type',
            showLoaderOnConfirm: true,
            preConfirm: (selectedValue) => {
                if (!selectedValue) {
                    Swal.showValidationMessage('Please select a report type');
                } else {
                    generateReport(selectedValue);
                }
            }
        });
    }

    function generateReport(reportType) {
        var reportFileName = '';

        switch (reportType) {
            case 'softwarereport':
                reportFileName = 'printsoftware.php';
                break;
            case 'remotereport':
                reportFileName = 'printremote.php';
                break;
            default:
                reportFileName = 'print.php';
                break;
        }

        var reportURL = './module/report/status/' + reportFileName + '?category=' + 'desktop' ;

        window.open(reportURL, '_blank');
    }


    $(document).ready(function () {
        // Click event for branch links
        $('.branch-link').on('click', function (e) {
            e.preventDefault();

            // Get the asset tag from the clicked link
            var assetTag = $(this).data('asset-tag');

            // Load transfer details via AJAX
            $.ajax({
                type: 'GET',
                url: './module/report/status/load_details.php',
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
        // Datatable initialization
        $('#table_server_details').DataTable({
            "paging": true,
            "ordering": true,
            "info": true,
            "searching": true,
        });

        // Function to update status cells asynchronously
        function updateStatusCells() {
            $('.status-cell').each(function() {
                var cell = $(this);
                var macAddress = cell.data('mac');
                var ipAddress = cell.data('ip');

                // Show loading indicator
                cell.text('Checking...').css('color', 'gray');

                // Check status using isHostAliveByMac
                isHostAliveByMacAsync(macAddress, ipAddress, function(isOnline) {
                    // Update the status cell with the result
                    var statusColor = isOnline ? 'green' : 'red';
                    var statusText = isOnline ? 'Online' : 'Offline';
                    cell.css('color', statusColor).text(statusText);
                });
            });
        }

        // Function to check host status using isHostAliveByMac asynchronously
        function isHostAliveByMacAsync(mac, ip, callback) {
            var pingCommand = (navigator.platform.toUpperCase().indexOf('WIN') === 0) ? 'ping -n 1 ' : 'ping -c 1 ';
            pingCommand += ip;

            $.ajax({
                url: './module/report/status/get_status_ajax.php',
                type: 'GET',
                data: { mac: mac },
                dataType: 'json',
                success: function(response) {
                    var isOnline = response.isOnline;
                    callback(isOnline);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    callback(false); // Assume offline on error
                }
            });
        }

        // Update status cells after a delay (you can adjust the delay as needed)
        setTimeout(updateStatusCells, 1000);

        // // JavaScript code to update the href attribute
        // $('#generateReport').on('click', function() {
        //     var printLink = './module/report/status/print.php?category=' + 'desktop';
        //     this.href = printLink;
        // });
    });
</script>