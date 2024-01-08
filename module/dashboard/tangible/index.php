<?php
    if ($submodule_access['asset']['view'] != 1) {
        header('location: logout.php');
    }

    // Fetch data for disposal with month information
    $sqlTotalDisposalValue = "SELECT SUM(value) as total_value, MONTH(expected_date) as disposal_month, expected_date
                            FROM aims_all_asset_disposal 
                            GROUP BY MONTH(expected_date)";
    $queryTotalDisposalValue = mysqli_query($con, $sqlTotalDisposalValue);

    // Fetch all rows into an array
    $rowsDisposal = array();
    while ($row = mysqli_fetch_assoc($queryTotalDisposalValue)) {
        $rowsDisposal[] = $row;
    }

    // Assuming there's only one row, you can use mysqli_fetch_assoc
    $totalDisposalValue = !empty($rowsDisposal) ? $rowsDisposal[0]['total_value'] : 0;

    // Fetch data for asset prices
    $sqlAssetPrices = "SELECT price FROM aims_asset";
    $queryAssetPrices = mysqli_query($con, $sqlAssetPrices);

    // Fetch all rows into an array
    $rowsAssetPrices = array();
    while ($row = mysqli_fetch_assoc($queryAssetPrices)) {
        $rowsAssetPrices[] = $row;
    }

    // Assuming there's only one row, you can use mysqli_fetch_assoc
    $totalAssetPrice = !empty($rowsAssetPrices) ? $rowsAssetPrices[0]['price'] : 0;

    $dataPointsDisposal = array();
    foreach ($rowsDisposal as $row) {
        $totalDisposalValue = $row['total_value'];
        $expectedDate = $row['expected_date'];

        // Process expected_date to get the month
        $month = ($expectedDate != null) ? date('M', strtotime($expectedDate)) : '';

        // Add data to the array
        $dataPointsDisposal[] = array('month' => $month, 'value' => $totalDisposalValue);
    }

    $dataPointsAssetPrices = array();
    foreach ($rowsAssetPrices as $row) {
        $assetPrice = $row['price'];

        // Add data to the array
        $dataPointsAssetPrices[] = array('price' => $assetPrice);
    }

    $sqlTotalSum = "SELECT SUM(value) FROM aims_all_asset_disposal";
    $queryTotalSum = mysqli_query($con, $sqlTotalSum);

    // Fetch all rows into an array
    while ($row = mysqli_fetch_assoc($queryTotalSum)) {
        $totalSum = $row['SUM(value)'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your Title Here</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js">
    <style>
        /* Add modal styles here */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 10px;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }

        .main-container {
            display: flex;
            flex-direction: column;
            font-family: serif;
            overflow-y: auto;
        }

        .container-asset {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: left;
            padding-right: 30%;
            margin-left: 30px;
        }

        .card {
            width: calc(20% - 20px);
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        .info {
            padding: 5px;
            text-align: center;
        }

        .info h3 {
            font-size: 16px;
            margin-bottom: 3%;
            color:white;
        }

        .container-data {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;
        }

        .chart-container {
            width: calc(100% - 20px);
            max-width: 56.5%;
            height: 95%; /* Adjusted height */
            margin: 10px;
        }

        .chart-container .card-body {
            width: calc(100% - 30px);
            max-width: 90%;
            height: 95%; /* Adjusted height */
            margin: 10px;
        }

        .card.booking-container {
            width: calc(100% - 20px);
            max-width: 38.5%;
            height: 95%;
            margin: 10px;
        }

        .booking-container h2 {
            text-align: left;
            font-size: 1.5vw;
            padding: 10px;
            margin-bottom: 0;
            border-radius: 10px 10px 0 0;
        }

        .inventory-container{
            width: calc(100% - 20px);
            max-width: 56.5%;
            height: 270px; /* Adjusted height */
            margin: 10px;
        }

        .card.server-container {
            width: calc(100% - 20px);
            max-width: 38.5%;
            height: 270px;
            margin: 10px;
        }

        .second_container-data{
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;
        }

        .server-container table,
        .inventory-container table,
        .booking-container table{
            width: 100%;
            border-collapse: collapse;
            font-size: 1rem;
            text-align: center;
            margin-bottom: 0; /* Remove default margin for the table */
        }

        .server-container th,
        .server-container td,
        .inventory-container th,
        .inventory-container td,
        .booking-container th,
        .booking-container td {
            padding: 12px;
        }

        .server-container tr,
        .inventory-container tr,
        .booking-container tbody tr {
            color: #333333; /* Text color */
            background-color: #f0f0f0; /* Background color for rows */
        }

        .server-container th,
        .inventory-container th,
        .booking-container th {
            color:white;
            background-color: #211d5a; /* Adjust background color for header */
            font-size: 17px;
        }

        .server-container tbody tr:nth-child(even),
        .inventory-container tbody tr:nth-child(even),
        .booking-container tbody tr:nth-child(even) {
            background-color: #f9f9f9; /* Adjust background color for even rows */
        }

        .server-container tbody tr:hover,
        .inventory-container tbody tr:hover,
        .booking-container tbody tr:hover {
            background-color: #e0e0e0; /* Adjust background color for hover effect */
        }

        .total-sum {
            margin-left:30px;
            padding: 10px;
        }

        @media only screen and (max-width: 768px) {
        /* Adjust styles for screens up to 768px width */

        .card {
            width: calc(50% - 20px); /* Adjust card width for smaller screens */
        }

        .container-data,
        .second_container-data {
            flex-direction: column; /* Adjust flex direction for smaller screens */
        }

        .chart-container,
        .inventory-container,
        .server-container,
        .booking-container {
            width: calc(100% - 20px); /* Adjust container width for smaller screens */
            max-width: none;
        }

        /* Add more adjustments as needed for smaller screens */
        }

        @media only screen and (max-width: 480px) {
            /* Additional adjustments for screens up to 480px width */

            .card {
                width: calc(100% - 20px); /* Adjust card width for smaller screens */
            }

            /* Add more adjustments as needed for smaller screens */
        }

    </style>
</head>
        
<body>
<main>
    <div class="main-container">
        <div class="container-data">
            <div class="card chart-container">
                <div class="card-body">
                    <canvas id="myBarChart"></canvas>
                </div>
            </div>
            
            <div class = "card booking-container">
                <div style="text-align:left;font-size:1.5vw;">
                    <h2>Facilities Booking Record</h2>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Facility</th>
                            <th>Date</th>
                            <th>By</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Welding Room 1</td>
                            <td>2023-11-16</td>
                            <td>Hazim</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Electrical Lab</td>
                            <td>2023-11-16</td>
                            <td>Badrol</td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>
        </div>

        <div class = "second_container-data">
            
            <div class = "card inventory-container">
                <div style="text-align:center; font-size:1.5vw; padding-bottom:15px; display: flex; ">
                    <button id="POBtn" type="button" class="btn" onclick="showPO()" style="width: 30%; background-color: #ee3923 !important; color: white;">P.O&nbsp;</button>
                    <button id="ReceiveBtn" type="button" class="btn" onclick="showReceive()" style="width: 30%; background-color: #333333 !important; color: white;">Receive&nbsp;</button>
                    <button id="InspectionBtn" type="button" class="btn" onclick="showInspection()" style="width: 30%; background-color: #333333 !important; color: white;">Inspection&nbsp;</button>
                </div>
                
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>ID</th>
                            <th>Vendor</th>
                            <th>By</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2023-11-16</td>
                            <td>001</td>
                            <td>Vendor A</td>
                            <td>User 1</td>
                            <td>Active</td>
                        </tr>
                        <tr>
                            <td>2023-11-17</td>
                            <td>002</td>
                            <td>Vendor B</td>
                            <td>User 2</td>
                            <td>Inactive</td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>

            <div class="card server-container">
                <div style="text-align:center; font-size:1.5vw; padding-bottom:15px; display: flex;">
                    <button id="ServiceReportBtn" type="button" class="btn" onclick="showServiceReport()" style="width:30%; background-color: #ee3923 !important; color: white;">Service Request&nbsp;</button>
                    <button id="SchedulerBtn" type="button" class="btn" onclick="showSchedule()" style="width:30%; background-color: #333333 !important; color: white;">Schedule&nbsp;</button>
                    <button id="ServerBtn" type="button" class="btn" onclick="showServer()" style="width:30%; background-color: #333333 !important; color: white;">Server&nbsp;</button>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th>PIC</th>
                        </tr>
                    </thead>
                    <?php
                    //query vehicle from aim_asset table using pagination
                    $sql = "SELECT * FROM aims_people_supplier GROUP BY id";
                    $query = mysqli_query($con, $sql);

                    $rowCount = 0; // Initialize row count variable

                    while ($row = mysqli_fetch_assoc($query)) {
                        // Limit to 2 rows
                        if ($rowCount >= 2) {
                            break; // Exit the loop if more than 3 rows are processed
                        }

                        echo "<tr>";
                        echo "<td>".$row['display_name']."</td>";
                        echo "<td>".$row['contact_no']."</td>";
                        echo "<td>".$row['email']."</td>";
                        echo "<td>".$row['pic']."</td>";
                        echo "</tr>";

                        $rowCount++; // Increment row count after processing each row
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Modal container -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <!-- Modal data will be displayed here -->
        <div id="modalData"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('myBarChart').getContext('2d');
    var dataPointsDisposal = <?php echo json_encode($dataPointsDisposal); ?>;
    var dataPointsAssetPrices = <?php echo json_encode($dataPointsAssetPrices); ?>;

    var disposalLabels = dataPointsDisposal.map(function (item) {
        return item['month'];
    });

    var disposalValues = dataPointsDisposal.map(function (item) {
        return item['value'];
    });

    var assetPriceValues = dataPointsAssetPrices.map(function (item) {
        return item['price'];
    });

    var data = {
        labels: disposalLabels,
        datasets: [{
            label: 'Total Disposal Value (RM)',
            data: disposalValues,
            backgroundColor: 'rgba(255, 99, 132, 0.5)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }, {
            label: 'Asset Price (RM)',
            data: assetPriceValues,
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    };

    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });

    // Function to handle bar click event
    function handleBarClick(event) {
        var activePoint = myBarChart.getElementAtEvent(event);

        if (activePoint.length > 0) {
            var selectedMonth = disposalLabels[activePoint[0].index];
            fetchModalContent(selectedMonth);
        }
    }
rld1
    // Function to fetch modal content using AJAX
    function fetchModalContent(month) {
        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Specify the request method, URL, and asynchronous flag
        xhr.open('GET', './module/dashboard/get_modal_content.php?month=' + month, true);

        // Set up the onload event handler
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Update the modal content with the response
                var modalData = document.getElementById('modalData');
                modalData.innerHTML = xhr.responseText;

                // Display the modal
                var modal = document.getElementById('myModal');
                modal.style.display = 'block';
            }
        };

        // Send the request
        xhr.send();
    }

    // Function to close the modal
    function closeModal() {
        var modal = document.getElementById('myModal');
        modal.style.display = 'none';
    }
</script>
</body>
</html>
