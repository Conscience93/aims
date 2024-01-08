<?php
include_once '../../include/db_connection.php';
session_start();

if (isset($_GET['assetTag'])) {
    $assetTag = $_GET['assetTag'];

    // Use $assetTag in the SQL query
    $sqlTransfer = "SELECT * FROM aims_transfer_asset WHERE asset_tag = '$assetTag'
                    UNION
                    SELECT * FROM aims_transfer_computer WHERE asset_tag = '$assetTag'
                    UNION
                    SELECT * FROM aims_transfer_electronics WHERE asset_tag = '$assetTag'";
    $queryTransfer = mysqli_query($con, $sqlTransfer);

    if (!$queryTransfer) {
        die('Error: ' . mysqli_error($con));
    }

    // Fetch all data into an array
    $transferData = [];
    while ($rowTransfer = mysqli_fetch_assoc($queryTransfer)) {
        $transferData[] = $rowTransfer;
    }

    $dateTransferHeaderPrinted = false; // Flag to check if Date Transfer header has been printed
    ?>

    <table id="table_original_location" class="striped-table">
        <h6><strong>Original Location</strong></h6>
        <thead>
            <tr>
                <th>Branch</th>
                <th>Department</th>
                <th>Location</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach ($transferData as $rowTransfer) {
            // Check if there is data in the attributes before displaying the row
            $showRow = ($rowTransfer['branch'] || $rowTransfer['department'] || $rowTransfer['location']);

            if ($showRow) {
                echo "<tr>";
                echo "<td>" . $rowTransfer['branch'] . "</td>";
                echo "<td>" . $rowTransfer['department'] . "</td>";
                echo "<td>" . $rowTransfer['location'] . "</td>";
                echo "</tr>";
            }
        }
        ?>
        </tbody>
    </table>

    <br>

    <table id="table_transfer" class="striped-table">
        <h6><strong>Transfer Details</strong></h6>
        <thead>
            <tr>
                <th>No.</th>
                <th>Type</th>
                <?php
                $showPeriodHeader = true; // Flag to check if Period header needs to be printed
                foreach ($transferData as $rowTransfer) {
                    if ($rowTransfer['type'] == 'Permanent' && !$dateTransferHeaderPrinted) {
                        echo "<th>Date Transfer</th>";
                        $dateTransferHeaderPrinted = true; // Set the flag to true
                    } elseif ($rowTransfer['type'] == 'Period' && $showPeriodHeader) {
                        echo "<th>Start Borrowed</th>";
                        echo "<th>Stop Borrowed</th>";
                        $showPeriodHeader = false; // Set the flag to false after printing headers once
                    }
                }
                ?>
                <th>Branch</th>
                <th>Department</th>
                <th>Location</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $rowCount = 1; // Reset the row counter
        foreach ($transferData as $rowTransfer) {
            // Check if there is data in the attributes before displaying the row
            $showRow = ($rowTransfer['date_transfer'] || $rowTransfer['start_date'] || $rowTransfer['end_date'] ||
                $rowTransfer['transfer_branch'] || $rowTransfer['transfer_department'] || $rowTransfer['transfer_location']);

            if ($showRow) {
                echo "<tr>";
                echo "<td>" . $rowCount . "</td>";
                echo "<td>" . $rowTransfer['type'] . "</td>";
                if ($rowTransfer['type'] == 'Permanent') {
                    echo "<td>" . $rowTransfer['date_transfer'] . "</td>";
                } elseif ($rowTransfer['type'] == 'Period') {
                    echo "<td>" . $rowTransfer['start_date'] . "</td>";
                    echo "<td>" . $rowTransfer['end_date'] . "</td>";
                }
                echo "<td>" . $rowTransfer['transfer_branch'] . "</td>";
                echo "<td>" . $rowTransfer['transfer_department'] . "</td>";
                echo "<td>" . $rowTransfer['transfer_location'] . "</td>";
                echo "</tr>";
                $rowCount++; // Increment the row counter
            }
        }
        ?>
        </tbody>
    </table>
    <?php
} else {
    echo 'Invalid request';
}
?>
