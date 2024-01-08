<?php
include_once "../../../include/db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    $password = password_hash('aims12345', PASSWORD_BCRYPT);

    $sql_user = "UPDATE aims_user SET
                        password = '".$password."'
                        WHERE id = '$id'
    ";

    $query_user = mysqli_query($con, $sql_user);

    if ($query_user) {
        echo "true";
    } else {
        echo "false";
    }
}
?>