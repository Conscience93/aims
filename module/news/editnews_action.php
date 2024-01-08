<?php
include_once '../../include/db_connection.php';
session_start();

date_default_timezone_set("Asia/Kuala_Lumpur");
$date = date('Y-m-d');
$time = date('H:i:s');

// Function to escape user input
function escapeInput($input) {
    global $con;
    return mysqli_real_escape_string($con, $input);
}

// Array data received from the form
    $id = escapeInput($_POST['id']);
    $name = escapeInput($_POST['name']);
    $category = escapeInput($_POST['category']);
    $publisher = escapeInput($_POST['publisher']);
    $description = escapeInput($_POST['description']);

    $date_edited = $date . " " . $time;

// // Creating File Upload Directory
// $target_directory_profile = "../../include/upload/profile/staff/";

// if (!is_dir($target_directory_profile)) {
//     mkdir($target_directory_profile, 0755, true);
// }

// // Get existing link
// $sqlLink = mysqli_query($con, "SELECT * FROM aims_people_staff WHERE id = '$id'");
// $resultLink = mysqli_fetch_assoc($sqlLink);

// // profile
// if ($resultLink["profile"]) {
//     $profile = $resultLink["profile"];
// } else if ($_FILES["profile"]["name"] == "") {
//     $profile = "";
// } else {
//     $profile = $target_directory_profile . basename($_FILES["profile"]["name"]);
//     $profile_tmp = $_FILES['profile']['tmp_name'];
//     move_uploaded_file($profile_tmp, $profile);
//     $profile = "include/upload/profile/staff/" . basename($_FILES["profile"]["name"]);
// }

// Update data into the aims_people_staff table
$sql_news = "UPDATE aims_news SET
    name = '$name',
    category = '$category',
    publisher = '$publisher',
    description = '$description',
    date_edited = '$date_edited'
WHERE id = '$id'
";

$query_news = mysqli_query($con, $sql_news);

if ($query_news) {
    echo "News added successfully!";
} else {
    echo "false";
}
