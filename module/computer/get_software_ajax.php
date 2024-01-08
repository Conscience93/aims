<?php
    include_once '../../include/db_connection.php';
	session_start();

    // Fetch software names
    $sql_software_names = "SELECT DISTINCT software_name FROM aims_software WHERE asset_tag = '$asset_tag'";
    $result_software_names = mysqli_query($con, $sql_software_names);
    $software_names = [];

    while ($row_software_names = mysqli_fetch_assoc($result_software_names)) {
        $software_names[] = $row_software_names['software_name'];
    }

    // Return software names as JSON
    echo json_encode($software_names);
?>