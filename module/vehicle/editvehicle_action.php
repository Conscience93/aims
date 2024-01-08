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
$id = isset($_POST['id']) ? escapeInput($con, $_POST['id']): null;
$asset_tag = isset($_POST['asset_tag']) ? escapeInput($con, $_POST['asset_tag']): null;
$name = isset($_POST['name']) ? escapeInput($con, $_POST['name']): null;
$status = 'ACTIVE';
$category = isset($_POST['category']) ? escapeInput($con, $_POST['category']): null;
$plate_no = isset($_POST['plate_no']) ? escapeInput($con, $_POST['plate_no']): null;
$brand = isset($_POST['brand']) ? escapeInput($con, $_POST['brand']): null;
$roadtax_expiry = isset($_POST['roadtax_expiry']) ? escapeInput($con, $_POST['roadtax_expiry']): null;
$date_purchase = isset($_POST['date_purchase']) ? escapeInput($con, $_POST['date_purchase']): null;
$price = isset($_POST['price']) ? escapeInput($con, $_POST['price']): null;
$value = isset($_POST['value']) ? escapeInput($con, $_POST['value']): null;
$remarks = isset($_POST['remarks']) ? escapeInput($con, $_POST['remarks']): null;
$branch = isset($_POST['branch']) ? escapeInput($con, $_POST['branch']): null;
$start_warranty = isset($_POST['start_warranty']) ? escapeInput($con, $_POST['start_warranty']): null;
$end_warranty = isset($_POST['end_warranty']) ? escapeInput($con, $_POST['end_warranty']): null;
$dealership = isset($_POST['dealership']) ? escapeInput($con, $_POST['dealership']): null;

// picture
$view = isset($_POST['view']) ? escapeInput($con, $_POST['view']): null;

// Creating File Upload Directory
$target_directory_invoice = "../../include/upload/invoice/vehicle/" . $asset_tag . "/";
$target_directory_document = "../../include/upload/document/vehicle/" . $asset_tag . "/";
$target_directory_warranty = "../../include/upload/warranty/vehicle/" . $asset_tag . "/";
$target_directory_roadtax = "../../include/upload/roadtax/vehicle/" . $asset_tag . "/";
$target_directory_insurance = "../../include/upload/insurance/vehicle/" . $asset_tag . "/";

if (!is_dir($target_directory_invoice)) {
    mkdir($target_directory_invoice, 0755, true);
}

if (!is_dir($target_directory_document)) {
    mkdir($target_directory_document, 0755, true);
}

if (!is_dir($target_directory_warranty)) {
    mkdir($target_directory_warranty, 0755, true);
}

if (!is_dir($target_directory_roadtax)) {
    mkdir($target_directory_roadtax, 0755, true);
}

if (!is_dir($target_directory_insurance)) {
    mkdir($target_directory_insurance, 0755, true);
}

// Get existing link
$sqlLink = mysqli_query($con, "SELECT * FROM aims_vehicle WHERE id = '$id'");
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
    $invoice = "include/upload/invoice/vehicle" . $asset_tag . "/" . basename($_FILES["invoice"]["name"]);
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
    $document = "include/upload/document/vehicle" . $asset_tag . "/" . basename($_FILES["document"]["name"]);
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
    $warranty = "include/upload/warranty/vehicle" . $asset_tag . "/" . basename($_FILES["warranty"]["name"]);
}

// roadtax

$roadtax = '';

// roadtax
if ($resultLink["roadtax"]) {
    $roadtax = $resultLink["roadtax"];
} else if ($_FILES["roadtax"]["name"] == "") {
    $roadtax = "";
} else {
    $roadtax = $target_directory_roadtax . basename($_FILES["roadtax"]["name"]);
    $roadtax_tmp = $_FILES['roadtax']['tmp_name'];
    move_uploaded_file($roadtax_tmp, $roadtax);
    $roadtax = "include/upload/roadtax/vehicle" . $asset_tag . "/" . basename($_FILES["roadtax"]["name"]);
}

// insurance

$insurance = '';

// insurance
if ($resultLink["insurance"]) {
    $insurance = $resultLink["insurance"];
} else if ($_FILES["insurance"]["name"] == "") {
    $insurance = "";
} else {
    $insurance = $target_directory_insurance . basename($_FILES["insurance"]["name"]);
    $insurance_tmp = $_FILES['insurance']['tmp_name'];
    move_uploaded_file($insurance_tmp, $insurance);
    $insurance = "include/upload/insurance/vehicle" . $asset_tag . "/" . basename($_FILES["insurance"]["name"]);
}

// Update attributes other than pictures
$sql_asset = "UPDATE aims_vehicle SET
    name = '$name',
    category = '$category',
    plate_no = '$plate_no',
    brand = '$brand',
    roadtax_expiry = '$roadtax_expiry',
    date_purchase = '$date_purchase',
    price = '$price',
    value = '$value',
    branch = '$branch',
    start_warranty = '$start_warranty',
    end_warranty = '$end_warranty',
    dealership = '$dealership',
    remarks = '$remarks',
    invoice = '$invoice',
    document = '$document',
    warranty = '$warranty',
    roadtax = '$roadtax',
    insurance = '$insurance'
WHERE id = '$id'
";

$queryAsset = mysqli_query($con, $sql_asset);

// Check if attributes update succeeded
$attributeUpdateSuccess = $queryAsset;

// Now, handle picture uploads and updates
$target_directory_picture = "../../include/upload/picture/vehicle/" . $asset_tag . "/";
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
            $picture[] = "include/upload/picture/vehicle/" . $asset_tag . "/" . $picture_name;
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