<?php
include_once '../../../include/db_connection.php';

// Retrieve the number of tables in the database
$result = $connection->query("SELECT COUNT(*) as table_count FROM information_schema.tables WHERE table_schema = '$aims'");
$row = $result->fetch_assoc();
$tableCount = $row['table_count'];

// Calculate the size of each table and total size
$tableSizes = [];
$totalSize = 0;

$tableListQuery = "SHOW TABLES";
$tableListResult = $connection->query($tableListQuery);

while ($table = $tableListResult->fetch_array()) {
    $tableName = $table[0];
    $sizeQuery = "SELECT SUM(DATA_LENGTH + INDEX_LENGTH) AS size 
                  FROM information_schema.TABLES 
                  WHERE TABLE_NAME = '$tableName' AND TABLE_SCHEMA = '$aims'";
    $sizeResult = $connection->query($sizeQuery);
    $sizeRow = $sizeResult->fetch_assoc();
    $tableSize = $sizeRow['size'];

    $tableSizes[$tableName] = $tableSize;
    $totalSize += $tableSize;
}

// Close the database connection
$connection->close();
?>
