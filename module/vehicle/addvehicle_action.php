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
$name = escapeInput($con, $_POST['name']);
$category = escapeInput($con, $_POST['category']);
$status = 'ACTIVE';
$plate_no = escapeInput($con, $_POST['plate_no']);
$brand = escapeInput($con, $_POST['brand']);
$roadtax_expiry = escapeInput($con, $_POST['roadtax_expiry']);
$date_purchase = escapeInput($con, $_POST['date_purchase']);
$price = escapeInput($con, $_POST['price']);
$value = escapeInput($con, $_POST['value']);
$remarks = escapeInput($con, $_POST['remarks']);
$branch = escapeInput($con, $_POST['branch']);
$start_warranty = escapeInput($con, $_POST['start_warranty']);
$end_warranty = escapeInput($con, $_POST['end_warranty']);
$dealership = escapeInput($con, $_POST['dealership']);

// picture
$view = escapeInput($con, $_POST['view']);

// Get asset category running number
$sql = mysqli_query($con, "SELECT * FROM aims_vehicle_category_run_no WHERE category = '$category'");
$result = mysqli_fetch_assoc($sql);
$asset_running_no = $result['next_no'];

// Complete asset tag wording, adding zero to the left
$asset_tag = $result['prefix'] . str_pad($asset_running_no, 5, "0", STR_PAD_LEFT);

// Creating File Upload Directory
$target_directory_invoice = "../../include/upload/invoice/vehicle/" . $asset_tag . "/"; 
$target_directory_document = "../../include/upload/document/vehicle/" . $asset_tag . "/";
$target_directory_warranty = "../../include/upload/warranty/vehicle/" . $asset_tag . "/";
$target_directory_insurance = "../../include/upload/insurance/vehicle/" . $asset_tag . "/";
$target_directory_roadtax = "../../include/upload/roadtax/vehicle/" . $asset_tag . "/";

// Check if the directories exist, and if not, create them
if (!is_dir($target_directory_invoice)) {
    mkdir($target_directory_invoice, 0755, true);
}

if (!is_dir($target_directory_document)) {
    mkdir($target_directory_document, 0755, true);
}

if (!is_dir($target_directory_warranty)) {
    mkdir($target_directory_warranty, 0755, true);
}

if (!is_dir($target_directory_insurance)) {
    mkdir($target_directory_insurance, 0755, true);
}

if (!is_dir($target_directory_roadtax)) {
    mkdir($target_directory_roadtax, 0755, true);
}


// Invoice
if ($_FILES["invoice"]["name"] == "") {
    $invoice = "";
}
else {
    $invoice = $target_directory_invoice . basename($_FILES["invoice"]["name"]);
    $invoice_tmp = $_FILES['invoice']['tmp_name'];
    move_uploaded_file($invoice_tmp, $invoice);
    // replace into the linkable link
    $invoice = "include/upload/invoice/asset/" . $asset_tag . "/" . basename($_FILES["invoice"]["name"]);
}

// Document
if ($_FILES["document"]["name"] == "") {
    $document = "";
}
else {
    $document = $target_directory_document . basename($_FILES["document"]["name"]);
    $document_tmp = $_FILES['document']['tmp_name'];
    move_uploaded_file($document_tmp, $document);
    // replace into the linkable link
    $document = "include/upload/document/asset/" . $asset_tag . "/" . basename($_FILES["document"]["name"]);
}

// Warranty
if ($_FILES["warranty"]["name"] == "") {
    $warranty = "";
}
else {
    $warranty = $target_directory_warranty . basename($_FILES["warranty"]["name"]);
    $warranty_tmp = $_FILES['warranty']['tmp_name'];
    move_uploaded_file($warranty_tmp, $warranty);
    // replace into the linkable link
    $warranty = "include/upload/warranty/asset/" . $asset_tag . "/" . basename($_FILES["warranty"]["name"]);
}

// insurance
if ($_FILES["insurance"]["name"] == "") {
    $insurance = "";
}
else {
    $insurance = $target_directory_insurance . basename($_FILES["insurance"]["name"]);
    $insurance_tmp = $_FILES['insurance']['tmp_name'];
    move_uploaded_file($insurance_tmp, $insurance);
    // replace into the linkable link
    $insurance = "include/upload/insurance/vehicle/" . $asset_tag . "/" . basename($_FILES["insurance"]["name"]);
}

// roadtax
if ($_FILES["roadtax"]["name"] == "") {
    $roadtax = "";
}
else {
    $roadtax = $target_directory_roadtax . basename($_FILES["roadtax"]["name"]);
    $roadtax_tmp = $_FILES['roadtax']['tmp_name'];
    move_uploaded_file($roadtax_tmp, $roadtax);
    // replace into the linkable link
    $roadtax = "include/upload/roadtax/vehicle/" . $asset_tag . "/" . basename($_FILES["roadtax"]["name"]);
}

// Insert data into the aims_vehicle table
$sqlAsset = "INSERT INTO aims_vehicle 
(name, asset_tag, category, status, plate_no, brand, roadtax, roadtax_expiry, date_purchase, price, value, remarks, branch, start_warranty, end_warranty, dealership, insurance, invoice, document, warranty) 
VALUES 
('$name', '$asset_tag', '$category', '$status', '$plate_no', '$brand', '$roadtax', '$roadtax_expiry', '$date_purchase', '$price', '$value', '$remarks', '$branch', '$start_warranty', '$end_warranty', '$dealership', '$insurance', '$invoice', '$document', '$warranty');";

$target_directory_picture = "../../include/upload/picture/vehicle/" . $asset_tag . "/";

if (!is_dir($target_directory_picture)) {
    mkdir($target_directory_picture, 0755, true);
}

// Handle picture files
$picture = [];

if (isset($_FILES['picture']) && is_array($_FILES['picture']['tmp_name'])) {
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

// Insert asset data without pictures
if (empty($view) && empty($picture)) {
    $sqlAsset = "INSERT INTO aims_vehicle 
        (name, asset_tag, category, status, plate_no, brand, roadtax, roadtax_expiry, date_purchase, price, value, remarks, branch, start_warranty, end_warranty, insurance, invoice, document, warranty) 
        VALUES 
        ('$name', '$asset_tag', '$category', '$status', '$plate_no', '$brand', '$roadtax', '$roadtax_expiry', '$date_purchase', '$price', '$value', '$remarks', '$branch', '$start_warranty', '$end_warranty', '$insurance', '$invoice', '$document', '$warranty');";
} else {
    $sqlAsset = "INSERT INTO aims_vehicle 
        (name, asset_tag, category, status, plate_no, brand, roadtax, roadtax_expiry, date_purchase, price, value, remarks, branch, start_warranty, end_warranty, insurance, invoice, document, warranty) 
        VALUES 
        ('$name', '$asset_tag', '$category', '$status', '$plate_no', '$brand', '$roadtax', '$roadtax_expiry', '$date_purchase', '$price', '$value', '$remarks', '$branch', '$start_warranty', '$end_warranty', '$insurance', '$invoice', '$document', '$warranty');";
}

$queryAsset = mysqli_query($con, $sqlAsset);

if ($queryAsset) {
    // Insert picture data
    if (!empty($view) && !empty($picture)) {
        foreach ($mi as $value) {
            list($a, $b) = $value;
            $sqlPicture = "INSERT INTO aims_all_asset_picture 
                (asset_tag, view, picture) 
                VALUES 
                ('$asset_tag', '$a', '$b')";
            $queryPicture = mysqli_query($con, $sqlPicture);
        }
    }
    
    $next_no = $asset_running_no + 1;
    $update_running_no = mysqli_query($con, "UPDATE aims_vehicle_category_run_no SET next_no = '$next_no' WHERE category = '$category'");
    echo "true";
} else {
    echo "false";
}

?>
