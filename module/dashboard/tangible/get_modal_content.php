<?php
include_once '../../include/db_connection.php';
session_start();

// Check if the month parameter is set
if (isset($_GET['month'])) {
    $selectedMonth = $_GET['month'];

    // Query to fetch data for the selected month
    $sql = "SELECT total_value FROM aims_all_asset_disposal WHERE MONTH(expected_date) = ?";
    $stmt = mysqli_prepare($con, $sql);

    // Bind the parameter
    mysqli_stmt_bind_param($stmt, 's', $selectedMonth);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Bind the result variable
    mysqli_stmt_bind_result($stmt, $totalValue);

    // Fetch the result
    mysqli_stmt_fetch($stmt);

    // Close the statement
    mysqli_stmt_close($stmt);

    // Format the HTML content
    $htmlContent = '<h5>Total Disposal Value for ' . date('F', mktime(0, 0, 0, $selectedMonth, 1)) . ': ' . $totalValue . ' RM</h5>';

    // Return the HTML content
    echo $htmlContent;
} else {
    // If the month parameter is not set, return an error message
    echo 'Error: Month parameter is not set.';
}
?>

