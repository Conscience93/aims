<?php
include_once '../../include/db_connection.php'; // Ensure this line includes your database connection
session_start();

date_default_timezone_set("Asia/Kuala_Lumpur");
$date = date('Y-m-d');
$time = date('H:i:s');

// Function to escape user input
function escapeInput($input) {
    global $con;
    return mysqli_real_escape_string($con, $input);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // News details
    $name = escapeInput($_POST['name']);
    $category = escapeInput($_POST['category']);
    $publisher = escapeInput($_POST['publisher']);
    $description = escapeInput($_POST['description']);
    $date_created = $date . " " . $time;
    $display_status = "ACTIVE";

    // Get news category running number
    $sql_running_no = mysqli_query($con, "SELECT * FROM aims_news_run_no WHERE category = '$category'");
    $result = mysqli_fetch_assoc($sql_running_no);
    $news_running_no = $result['next_no'];

    // Complete news tag wording, adding zero to the left
    $news_tag = $result['prefix'] . str_pad($news_running_no, 5, "0", STR_PAD_LEFT);

    // Creating File Upload Directory
    $target_directory_file = "../../include/upload/file/news/";

    if (!is_dir($target_directory_file)) {
        mkdir($target_directory_file, 0755, true);
    }

    // Initialize $file
    $file = "";

    // Check if an file file was uploaded
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_name = basename($_FILES["file"]["name"]);
        $file_destination = $target_directory_file . $file_name;

        if (move_uploaded_file($file_tmp, $file_destination)) {
            // Set $file to the relative path of the uploaded file
            $file = "include/upload/file/news/" . basename($_FILES["file"]["name"]);
        }
    }

    // Check for duplicates
    $duplicateCheckSql = "SELECT * FROM aims_news WHERE 
        name = '$name'";
        
    $duplicateCheckResult = mysqli_query($con, $duplicateCheckSql);

    if (mysqli_num_rows($duplicateCheckResult) > 0) {
        // Duplicate records found
        echo "Duplicate records found for one or more fields. Please check your input.";
    } else {
        // No duplicates found, proceed to insert the data
        $sqlNews = "INSERT INTO aims_news 
            (name, news_tag, category, publisher, description, date_created, file, display_status)
            VALUES ('$name', '$news_tag', '$category', '$publisher', '$description', '$date_created', '$file', '$display_status')";

        // Execute the SQL query
        if (mysqli_query($con, $sqlNews)) {
            // Vendor details inserted successfully
            $next_no = $news_running_no + 1;
            $update_running_no = mysqli_query($con, "UPDATE aims_news_run_no SET next_no = '$next_no' WHERE category = '$category'");
            echo "News added successfully!";
        } else {
            // Error occurred while inserting vendor details
            echo "Error: " . mysqli_error($con);
        }
    }
} else {
    // Handle the case when the form is not submitted
    echo "Form not submitted.";
}
?>