<?php
include_once '../../../include/db_connection.php';
session_start();

if (isset($_GET['assetTag'])) {
    $assetTag = $_GET['assetTag'];

    // Use $assetTag in the SQL query
    $sqlTransfer = "SELECT * FROM aims_computer WHERE asset_tag = '$assetTag'";
    $queryTransfer = mysqli_query($con, $sqlTransfer);

    if (!$queryTransfer) {
        die('Error: ' . mysqli_error($con));
    }

    $rowCount = 1; // Initialize the row counter
    ?>
    <table id="table_details" class="striped-table">
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
        while ($rowTransfer = mysqli_fetch_assoc($queryTransfer)) {
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
    <?php
} else {
    echo 'Invalid request';
}
?>