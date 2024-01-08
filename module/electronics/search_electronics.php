<?php
include_once '../../include/db_connection.php';

$searchTerm = isset($_POST['search']) ? mysqli_escape_string($con, $_POST['search']) : '';

if ($searchTerm != '') {
    $sql = "SELECT name FROM aims_electronics WHERE name LIKE '%$searchTerm%'";
    $query = mysqli_query($con, $sql);
    $results = array();

    while ($row = mysqli_fetch_assoc($query)) {
        $results[] = $row;
    }

    echo json_encode($results);
} else {
    echo json_encode([]);
}
?>