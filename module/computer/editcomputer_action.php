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
$asset_tag = isset($_POST['asset_tag']) ? escapeInput($con, $_POST['asset_tag']): null;
$name = isset($_POST['name']) ? escapeInput($con, $_POST['name']): null;
$status = 'ACTIVE';
$server_name = isset($_POST['server_name']) ? escapeInput($con, $_POST['server_name']): null;
$branch = isset($_POST['branch']) ? escapeInput($con, $_POST['branch']): null;
$department = isset($_POST['department']) ? escapeInput($con, $_POST['department']): null;
$location = isset($_POST['location']) ? escapeInput($con, $_POST['location']): null;
$category = isset($_POST['category']) ? escapeInput($con, $_POST['category']): null;
$price = isset($_POST['price']) ? escapeInput($con, $_POST['price']): null;
$date_purchase = isset($_POST['date_purchase']) ? escapeInput($con, $_POST['date_purchase']): null;
$start_warranty = isset($_POST['start_warranty']) ? escapeInput($con, $_POST['start_warranty']): null;
$end_warranty = isset($_POST['end_warranty']) ? escapeInput($con, $_POST['end_warranty']): null;
$remark = isset($_POST['remark']) ? escapeInput($con, $_POST['remark']): null;
$username = isset($_POST['username']) ? escapeInput($con, $_POST['username']): null;

// Handle other arrays as needed
//supplier
$supplier = isset($_POST['supplier']) ? escapeInput($con, $_POST['supplier']): null;

// hardware specification
$computer_brand = isset($_POST['computer_brand']) ? escapeInput($con, $_POST['computer_brand']): null;
$phone_brand = isset($_POST['phone_brand']) ? escapeInput($con, $_POST['phone_brand']): null;
$virtual_machine = isset($_POST['virtual_machine']) ? escapeInput($con, $_POST['virtual_machine']): null;
$ram = isset($_POST['ram']) ? escapeInput($con, $_POST['ram']): null;
$processor = isset($_POST['processor']) ? escapeInput($con, $_POST['processor']): null;
$graphic_card = isset($_POST['graphic_card']) ? escapeInput($con, $_POST['graphic_card']): null;
$casing = isset($_POST['casing']) ? escapeInput($con, $_POST['casing']): null;
$psu = isset($_POST['psu']) ? escapeInput($con, $_POST['psu']): null;
$motherboard = isset($_POST['motherboard']) ? escapeInput($con, $_POST['motherboard']): null;

// network
$network_id = isset($_POST['network_id']) ? escapeInput($con, $_POST['network_id']): null;
$ip_type = isset($_POST['ip_type']) ? escapeInput($con, $_POST['ip_type']): null;
$ip_address = isset($_POST['ip_address']) ? escapeInput($con, $_POST['ip_address']): null;
$mac_address = isset($_POST['mac_address']) ? escapeInput($con, $_POST['mac_address']): null;
$port = isset($_POST['port']) ? escapeInput($con, $_POST['port']): null;

// remote access
$remote_id = isset($_POST['remote_id']) ? escapeInput($con, $_POST['remote_id']): null;
$remote_name = isset($_POST['remote_name']) ? escapeInput($con, $_POST['remote_name']): null;
$remote_address = isset($_POST['remote_address']) ? escapeInput($con, $_POST['remote_address']): null;
$remote_password = isset($_POST['remote_password']) ? escapeInput($con, $_POST['remote_password']): null;
$remote_port = isset($_POST['remote_port']) ? escapeInput($con, $_POST['remote_port']): null;

// hard drive
$hard_drive_id = isset($_POST['hard_drive_id']) ? escapeInput($con, $_POST['hard_drive_id']): null;
$hard_disk_name = isset($_POST['hard_disk_name']) ? escapeInput($con, $_POST['hard_disk_name']): null;
$hard_drive = isset($_POST['hard_drive']) ? escapeInput($con, $_POST['hard_drive']): null;
$storage = isset($_POST['storage']) ? escapeInput($con, $_POST['storage']): null;
$brand = isset($_POST['brand']) ? escapeInput($con, $_POST['brand']): null;
$purpose = isset($_POST['purpose']) ? escapeInput($con, $_POST['purpose']): null;
$end_warranty_disk = isset($_POST['end_warranty_disk']) ? escapeInput($con, $_POST['end_warranty_disk']): null;

// Handle other arrays as needed
// software
$software_id = isset($_POST['software_id']) ? escapeInput($con, $_POST['software_id']): null;
$software_category = isset($_POST['software_category']) ? escapeInput($con, $_POST['software_category']): null;
$software_name = isset($_POST['software_name']) ? escapeInput($con, $_POST['software_name']): null;
$software_brand = isset($_POST['software_brand']) ? escapeInput($con, $_POST['software_brand']): null;
$license_key = isset($_POST['license_key']) ? escapeInput($con, $_POST['license_key']): null;
$expiry_date = isset($_POST['expiry_date']) ? escapeInput($con, $_POST['expiry_date']): null;

// Handle other arrays as needed
// user
$user_id = isset($_POST['user_id']) ? escapeInput($con, $_POST['user_id']): null;
$username = isset($_POST['username']) ? escapeInput($con, $_POST['username']): null;
$password = isset($_POST['password']) ? escapeInput($con, $_POST['password']): null;
$user = isset($_POST['user']) ? escapeInput($con, $_POST['user']): null;
$role = isset($_POST['role']) ? escapeInput($con, $_POST['role']): null;

// picture
$view = isset($_POST['view']) ? escapeInput($con, $_POST['view']): null;

// Creating File Upload Directory
$target_directory_invoice = "../../include/upload/invoice/computer/" . $asset_tag . "/";
$target_directory_document = "../../include/upload/document/computer/" . $asset_tag . "/";
$target_directory_warranty = "../../include/upload/warranty/computer/" . $asset_tag . "/";

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
$sqlLink = mysqli_query($con, "SELECT * FROM aims_computer WHERE id = '$id'");
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
    $invoice = "include/upload/invoice/computer" . $asset_tag . "/" . basename($_FILES["invoice"]["name"]);
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
    $document = "include/upload/document/computer" . $asset_tag . "/" . basename($_FILES["document"]["name"]);
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
    $warranty = "include/upload/warranty/computer" . $asset_tag . "/" . basename($_FILES["warranty"]["name"]);
}

// Update the existing data in the aims_computer table
$sql_computer = "UPDATE aims_computer SET
    `name` = '$name',
    server_name = '$server_name',
    branch = '$branch',
    department = '$department',
    `location` = '$location',
    price = '$price',
    date_purchase = '$date_purchase',
    `start_warranty` = '$start_warranty',
    `end_warranty` = '$end_warranty',
    remark = '$remark',
    supplier = '$supplier',
    computer_brand = '$computer_brand',
    phone_brand = '$phone_brand',
    virtual_machine = '$virtual_machine',
    ram = '$ram',
    processor = '$processor',
    graphic_card = '$graphic_card',
    casing = '$casing',
    psu = '$psu',
    motherboard = '$motherboard',
    invoice = '$invoice',
    document = '$document',
    warranty = '$warranty'
    WHERE id = '$id'
";

$query_software = null;

$mi = new MultipleIterator();
if (is_array($software_category)) {
    $mi->attachIterator(new ArrayIterator($software_category));
    $mi->attachIterator(new ArrayIterator($software_name));
    $mi->attachIterator(new ArrayIterator($software_brand));
    $mi->attachIterator(new ArrayIterator($license_key));
    $mi->attachIterator(new ArrayIterator($expiry_date));
    $mi->attachIterator(new ArrayIterator($software_id));
}

// Execute SQL statement for software
foreach ($mi as $value) {
    list($a, $b, $c, $d, $e, $f) = $value;
    if ($f) {
        $sql_software = "UPDATE aims_software SET
        software_category = '$a',
        software_name = '$b', 
        brand = '$c', 
        license_key = '$d', 
        `expiry_date` = '$e'
        WHERE id = '$f'
        ";

        $query_software = mysqli_query($con, $sql_software);
    } else {
        $sql_software = "INSERT INTO aims_software
        (asset_tag, software_category, software_name, brand, license_key, `expiry_date`)
        VALUES ('$asset_tag', '$a', '$b', '$c', '$d', '$e')";
        $query_software = mysqli_query($con, $sql_software);
    }
}

$query_user = null;

$mi2 = new MultipleIterator();
if (is_array($username)) {
    $mi2->attachIterator(new ArrayIterator($username));
    $mi2->attachIterator(new ArrayIterator($password));
    $mi2->attachIterator(new ArrayIterator($user));
    $mi2->attachIterator(new ArrayIterator($role));
    $mi2->attachIterator(new ArrayIterator($user_id));
}

foreach ($mi2 as $value) {
    list($a, $b, $c, $d, $e) = $value;
    if ($e) {
        $sql_user = "UPDATE aims_computer_user SET
        username = '$a',
        password = '$b', 
        user = '$c', 
        role = '$d'
        WHERE  asset_tag = '$asset_tag'
        ";

        $query_user = mysqli_query($con, $sql_user);
    } else {
        $sql_user = "INSERT INTO aims_computer_user
        (asset_tag, username, password, user, role)
        VALUES ('$asset_tag', '$a', '$b', '$c', '$d')";
        $query_user = mysqli_query($con, $sql_user);
    }
}

$query_hard_drive = null;

$mi3 = new MultipleIterator();
if (is_array($hard_disk_name)) {
    $mi3->attachIterator(new ArrayIterator($hard_disk_name));
    $mi3->attachIterator(new ArrayIterator($hard_drive));
    $mi3->attachIterator(new ArrayIterator($brand));
    $mi3->attachIterator(new ArrayIterator($storage));
    $mi3->attachIterator(new ArrayIterator($purpose));
    $mi3->attachIterator(new ArrayIterator($end_warranty_disk));
    $mi3->attachIterator(new ArrayIterator($hard_drive_id));
}

// Loop through the hard drives and update or insert based on hard_drive_id
foreach ($mi3 as $value) {
    list($a, $b, $c, $d, $e, $f, $g) = $value;
    if ($g) { // If hard_drive_id exists, update the existing row.
        $sql_hard_drive = "UPDATE aims_computer_hard_drive SET
        hard_disk_name = '$a',
        hard_drive = '$b',
        brand = '$c', 
        storage = '$d', 
        purpose = '$e',
        end_warranty_disk = '$f'
        WHERE id = '$g'"; // Use the correct hard_drive_id here

        $query_hard_drive = mysqli_query($con, $sql_hard_drive);
    } else { // If hard_drive_id does not exist, insert a new hard drive
        $sql_hard_drive = "INSERT INTO aims_computer_hard_drive
        (asset_tag, hard_disk_name, hard_drive, brand, storage, purpose, end_warranty_disk)
        VALUES ('$asset_tag', '$a', '$b', '$c', '$d', '$e', '$f')";
        $query_hard_drive = mysqli_query($con, $sql_hard_drive);
    }
}

$queryNetwork = null;

$mi4 = new MultipleIterator();
if (is_array($ip_type)) {
    $mi4->attachIterator(new ArrayIterator($ip_type));
    $mi4->attachIterator(new ArrayIterator($ip_address));
    $mi4->attachIterator(new ArrayIterator($mac_address));
    $mi4->attachIterator(new ArrayIterator($port));
    $mi4->attachIterator(new ArrayIterator($network_id));
}

// Loop through the hard drives and update or insert based on Network_id
foreach ($mi4 as $value) {
    list($a, $b, $c, $d, $e) = $value;
    if ($e) { // If Network_id exists, update the existing row.
        $sqlNetwork = "UPDATE aims_computer_network SET
        ip_type = '$a',
        ip_address = '$b',
        mac_address = '$c',
        port = '$d'
        WHERE id = '$e'"; // Use the correct ip_id here

        $queryNetwork = mysqli_query($con, $sqlNetwork);
    } else { // If ip_id does not exist, insert a new hard drive
        $sqlNetwork = "INSERT INTO aims_computer_network
        (asset_tag, ip_type, ip_address, mac_address, port)
        VALUES ('$asset_tag', '$a', '$b', '$c', '$d')";
        $queryNetwork = mysqli_query($con, $sqlNetwork);
    }
}

// Now, handle picture uploads and updates
$target_directory_picture = "../../include/upload/picture/computer/" . $asset_tag . "/";
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
            $picture[] = "include/upload/picture/computer/" . $asset_tag . "/" . $picture_name;
        }
    }
}

$queryPicture = null;

$mi5 = new MultipleIterator();

if (!empty($view) && !empty($picture)) {
    $mi5->attachIterator(new ArrayIterator($view));
    $mi5->attachIterator(new ArrayIterator($picture));
}

foreach ($mi5 as $value) {
    list($a, $b) = $value;
    $sqlPicture = "INSERT INTO aims_all_asset_picture 
        (asset_tag, view, picture) 
        VALUES 
        ('$asset_tag','$a', '$b')";
    $queryPicture = mysqli_query($con, $sqlPicture);
}

$query_remote_access = null;

$mi6 = new MultipleIterator();
if (is_array($remote_name)) {
    $mi6->attachIterator(new ArrayIterator($remote_name));
    $mi6->attachIterator(new ArrayIterator($remote_address));
    $mi6->attachIterator(new ArrayIterator($remote_password));
    $mi6->attachIterator(new ArrayIterator($remote_port));
    $mi6->attachIterator(new ArrayIterator($remote_id));
}

// Execute SQL statement for software
foreach ($mi6 as $value) {
    list($a, $b, $c, $d, $e) = $value;
    if ($e) {
        $sqlRemoteAccess = "UPDATE aims_computer_remote_access SET
        remote_name = '$a',
        remote_address = '$b', 
        remote_password = '$c', 
        remote_port = '$d'
        WHERE id = '$e'
        ";

    $queryRemoteAccess = mysqli_query($con, $sqlRemoteAccess);
    } else { // If ip_id does not exist, insert a new hard drive
        $sqlRemoteAccess = "INSERT INTO aims_computer_remote_access
        (asset_tag, remote_name, remote_address, remote_password, remote_port)
        VALUES ('$asset_tag', '$a', '$b', '$c', '$d')";
        $queryRemoteAccess = mysqli_query($con, $sqlRemoteAccess);
    }
}

$query_computer = mysqli_query($con, $sql_computer);

if ($query_computer) {
    echo "true";
} else {
    echo "false: " . mysqli_error($con);
}
?>
