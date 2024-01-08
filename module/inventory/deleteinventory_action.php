<?php
include_once '../../include/db_connection.php';

// Check if "id" is set in the $_POST array
if (isset($_POST["id"])) {
    $id = $_POST["id"];

    // Check if the item_tag exists in the table before proceeding with deletion
    $sql_check = "SELECT * FROM aims_inventory WHERE id = '$id'";
    $result_check = mysqli_query($con, $sql_check);

    if ($result_check && mysqli_num_rows($result_check) > 0) {
        // If the id exists, proceed with deletion
        $sql_delete = "DELETE FROM aims_inventory WHERE id = '$id'";
        $query_delete = mysqli_query($con, $sql_delete);

        if ($query_delete) {
            echo json_encode(array("status" => "Success"));
        } else {
            echo json_encode(array("status" => "Error"));
        }
    } else {
        // If the item_tag does not exist, return an error status
        echo json_encode(array("status" => "Item tag not found"));
    }
} else {
    // If "id" is not set in the $_POST array, return an error status
    echo json_encode(array("status" => "ID not provided"));
}
?>
