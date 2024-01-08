<?php
include_once '../../include/db_connection.php';
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
$status = 'ACTIVE';
$asset_tag = isset($_POST['asset_tag']) ? escapeInput($con, $_POST['asset_tag']) : null;
$category = isset($_POST['category']) ? escapeInput($con, $_POST['category']) : null;
$brand = isset($_POST['brand']) ? escapeInput($con, $_POST['brand']): null;
$model_no = isset($_POST['model_no']) ? escapeInput($con, $_POST['model_no']): null;
$price = isset($_POST['price']) ? escapeInput($con, $_POST['price']): null;
$value = isset($_POST['value']) ? escapeInput($con, $_POST['value']): null;
$date_purchase = isset($_POST['date_purchase']) ? escapeInput($con, $_POST['date_purchase']): null;
$start_warranty = isset($_POST['start_warranty']) ? escapeInput($con, $_POST['start_warranty']): null;
$end_warranty = isset($_POST['end_warranty']) ? escapeInput($con, $_POST['end_warranty']): null;
$branch = isset($_POST['branch']) ? escapeInput($con, $_POST['branch']): null;
$department = isset($_POST['department']) ? escapeInput($con, $_POST['department']): null;
$location = isset($_POST['location']) ? escapeInput($con, $_POST['location']): null;
$user = isset($_POST['user']) ? escapeInput($con, $_POST['user']): null;
$supplier = isset($_POST['supplier']) ? escapeInput($con, $_POST['supplier']): null;
$remark = isset($_POST['remark']) ? escapeInput($con, $_POST['remark']): null;
$po_number = isset($_POST['po_number']) ? escapeInput($con, $_POST['po_number']): null;
$do_number = isset($_POST['do_number']) ? escapeInput($con, $_POST['do_number']): null;
$view = isset($_POST['view']) ? escapeInput($con, $_POST['view']) : null;

// Creating File Upload Directory
$target_directory_invoice = "../../include/upload/invoice/electronics/" . $asset_tag . "/";
$target_directory_document = "../../include/upload/document/electronics/" . $asset_tag . "/";
$target_directory_warranty = "../../include/upload/warranty/electronics/" . $asset_tag . "/";

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
$sqlLink = mysqli_query($con, "SELECT * FROM aims_electronics WHERE id = '$id'");
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
    $invoice = "include/upload/invoice/electronics" . $asset_tag . "/" . basename($_FILES["invoice"]["name"]);
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
    $document = "include/upload/document/electronics" . $asset_tag . "/" . basename($_FILES["document"]["name"]);
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
    $warranty = "include/upload/warranty/electronics" . $asset_tag . "/" . basename($_FILES["warranty"]["name"]);
}


// Create SQL statement for main data update
$sql_electronics = "UPDATE aims_electronics SET
    name = '$name',
    category = '$category',
    brand = '$brand',
    model_no = '$model_no',
    price = '$price',
    value = '$value',
    date_purchase = '$date_purchase',
    start_warranty = '$start_warranty',
    end_warranty = '$end_warranty',
    branch = '$branch',
    department = '$department',
    location = '$location',
    user = '$user',
    supplier = '$supplier',
    remark = '$remark',
    po_number = '$po_number',
    do_number = '$do_number',
    document = '$document',
    invoice = '$invoice',
    warranty = '$warranty'
    WHERE id = '$id'
    ";

$queryElectronics = mysqli_query($con, $sql_electronics);

// Check if attributes update succeeded
$attributeUpdateSuccess = $queryElectronics;

// Now, handle picture uploads and updates
$target_directory_picture = "../../include/upload/picture/electronics/" . $asset_tag . "/";
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
            $picture[] = "include/upload/picture/electronics/" . $asset_tag . "/" . $picture_name;
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
        ('$asset_tag', '$a', '$b')";
    $queryPicture = mysqli_query($con, $sqlPicture);
}

// Check if picture upload/update succeeded
$pictureUpdateSuccess = ($queryPicture !== null);

if ($attributeUpdateSuccess || $pictureUpdateSuccess) {
    echo "true";
} else {
    echo "false: " . mysqli_error($con);
}

