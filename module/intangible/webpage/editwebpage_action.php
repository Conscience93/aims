<?php
include_once '../../../include/db_connection.php';
session_start();

// Function to escape user input
function escapeInput($con, $input) {
    if (is_array($input)) {
        $escapedInput = [];
        foreach ($input as $value) {
            $escapedInput[] = mysqli_real_escape_string($con, $value);
        }
        return $escapedInput;
    } else {
        return mysqli_real_escape_string($con, $input);
    }
}

// Array data received from the form
$id = isset($_POST['id']) ? escapeInput($con, $_POST['id']) : null;
$name = isset($_POST['name']) ? escapeInput($con, $_POST['name']) : null;
$asset_tag = isset($_POST['asset_tag']) ? escapeInput($con, $_POST['asset_tag']) : null;
$category = isset($_POST['category']) ? escapeInput($con, $_POST['category']) : null;
$date_purchase = isset($_POST['date_purchase']) ? escapeInput($con, $_POST['date_purchase']) : null;
$price = isset($_POST['price']) ? escapeInput($con, $_POST['price']) : null;
$user = isset($_POST['user']) ? escapeInput($con, $_POST['user']) : null;
$link = isset($_POST['link']) ? escapeInput($con, $_POST['link']) : null;
$server_name = isset($_POST['server_name']) ? escapeInput($con, $_POST['server_name']) : null;
$particular = isset($_POST['particular']) ? escapeInput($con, $_POST['particular']) : null;
$supplier = isset($_POST['supplier']) ? escapeInput($con, $_POST['supplier']) : null;
$start_warranty = isset($_POST['start_warranty']) ? escapeInput($con, $_POST['start_warranty']) : null;
$end_warranty = isset($_POST['end_warranty']) ? escapeInput($con, $_POST['end_warranty']) : null;
$view = isset($_POST['view']) ? escapeInput($con, $_POST['view']) : null;

// Creating File Upload Directory
$target_directory_invoice = "../../include/upload/invoice/webpage/" . $asset_tag . "/";
$target_directory_document = "../../include/upload/document/webpage/" . $asset_tag . "/";
$target_directory_warranty = "../../include/upload/warranty/webpage/" . $asset_tag . "/";

if (!is_dir($target_directory_invoice)) {
    mkdir($target_directory_invoice, 0755, true);
}

if (!is_dir($target_directory_document)) {
    mkdir($target_directory_document, 0755, true);
}

if (!is_dir($target_directory_warranty)) {
    mkdir($target_directory_warranty, 0755, true);
}

// Get existing link
$sqlLink = mysqli_query($con, "SELECT * FROM aims_webpage WHERE id = '$id'");
$resultLink = mysqli_fetch_assoc($sqlLink);

// invoice

$invoice = '';

// invoice
if ($resultLink["invoice"]) {
    $invoice = $resultLink["invoice"];
} else if ($_FILES["invoice"]["name"] == "") {
    $invoice = "";
} else {
    $invoice = $target_directory_invoice . basename($_FILES["invoice"]["name"]);
    $invoice_tmp = $_FILES['invoice']['tmp_name'];
    move_uploaded_file($invoice_tmp, $invoice);
    $invoice = "include/upload/invoice/webpage" . $asset_tag . "/" . basename($_FILES["invoice"]["name"]);
}

// document

$document = '';

// document
if ($resultLink["document"]) {
    $document = $resultLink["document"];
} else if ($_FILES["document"]["name"] == "") {
    $document = "";
} else {
    $document = $target_directory_document . basename($_FILES["document"]["name"]);
    $document_tmp = $_FILES['document']['tmp_name'];
    move_uploaded_file($document_tmp, $document);
    $document = "include/upload/document/webpage" . $asset_tag . "/" . basename($_FILES["document"]["name"]);
}

// warranty

$warranty = '';

// warranty
if ($resultLink["warranty"]) {
    $warranty = $resultLink["warranty"];
} else if ($_FILES["warranty"]["name"] == "") {
    $warranty = "";
} else {
    $warranty = $target_directory_warranty . basename($_FILES["warranty"]["name"]);
    $warranty_tmp = $_FILES['warranty']['tmp_name'];
    move_uploaded_file($warranty_tmp, $warranty);
    $warranty = "include/upload/warranty/webpage" . $asset_tag . "/" . basename($_FILES["warranty"]["name"]);
}


// Update attributes other than pictures
$sql_asset = "UPDATE aims_webpage SET
    name = '$name',
    asset_tag = '$asset_tag', 
    category = '$category', 
    date_purchase = '$date_purchase', 
    price = '$price', 
    supplier = '$supplier', 
    user = '$user', 
    server_name = '$server_name',
    link = '$link', 
    start_warranty = '$start_warranty', 
    end_warranty = '$end_warranty', 
    particular = '$particular', 
    invoice = '$invoice', 
    document = '$document', 
    warranty = '$warranty'
WHERE id = '$id'";

// Now, handle picture uploads and updates
$target_directory_picture = "../../include/upload/picture/webpage/" . $asset_tag . "/";
if (!is_dir($target_directory_picture)) {
    mkdir($target_directory_picture, 0755, true);
}

// Initialize $picture
$picture = [];

// Check if picture files were uploaded
if (isset($_FILES['picture']) && $_FILES['picture']['name'][0] != "") {
    $pictureCount = count($_FILES['picture']['tmp_name']);
    for ($i = 0; $i < $pictureCount; $i++) {
        $picture_tmp = $_FILES['picture']['tmp_name'][$i];
        $picture_name = basename($_FILES['picture']['name'][$i]);
        $picture_destination = $target_directory_picture . $picture_name;

        if (move_uploaded_file($picture_tmp, $picture_destination)) {
            // Add the relative path of the uploaded picture to the $picture array
            $picture[] = "include/upload/picture/webpage/" . $asset_tag . "/" . $picture_name;
        }
    }
}

$queryPicture = null;

$mi = new MultipleIterator();

if (!empty($view) && !empty($picture)) {
    $mi->attachIterator(new ArrayIterator($view));
    $mi->attachIterator(new ArrayIterator($picture));
}

foreach ($mi as $value) {
    list($a, $b) = $value;
    $sqlPicture = "INSERT INTO aims_all_asset_picture 
        (asset_tag, view, picture) 
        VALUES 
        ('$asset_tag','$a', '$b')";
    $queryPicture = mysqli_query($con, $sqlPicture);
}

$queryAsset = mysqli_query($con, $sql_asset);

if ($queryAsset) {
    echo "true";
} else {
    echo "false: " . mysqli_error($con);
}
?>