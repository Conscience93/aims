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
    $status = 'ACTIVE';
    $branch = escapeInput($con, $_POST['branch']);
    $department = escapeInput($con, $_POST['department']);
    $location = escapeInput($con, $_POST['location']);
    $category = escapeInput($con, $_POST['category']);
    $server_name = escapeInput($con, $_POST['server_name']);
    $price = escapeInput($con, $_POST['price']);
    $date_purchase = escapeInput($con, $_POST['date_purchase']);
    $start_warranty = escapeInput($con, $_POST['start_warranty']);
    $end_warranty = escapeInput($con, $_POST['end_warranty']);
    $remark = escapeInput($con, $_POST['remark']);
    $username = escapeInput($con, $_POST['username']);

    // Handle other arrays as needed
    //supplier
    $supplier = escapeInput($con, $_POST['supplier']);

    // hardware specification
    $computer_brand = escapeInput($con, $_POST['computer_brand']);
    $phone_brand = escapeInput($con, $_POST['phone_brand']);
    $virtual_machine = escapeInput($con, $_POST['virtual_machine']);
    $ram = escapeInput($con, $_POST['ram']);
    $processor = escapeInput($con, $_POST['processor']);
    $graphic_card = escapeInput($con, $_POST['graphic_card']);
    $casing = escapeInput($con, $_POST['casing']);
    $psu = escapeInput($con, $_POST['psu']);
    $motherboard = escapeInput($con, $_POST['motherboard']);

    // network
    $ip_type = escapeInput($con, $_POST['ip_type']);
    $ip_address = escapeInput($con, $_POST['ip_address']);
    $mac_address = escapeInput($con, $_POST['mac_address']);
    $port = escapeInput($con, $_POST['port']);

    // remote access
    $remote_name = escapeInput($con, $_POST['remote_name']);
    $remote_address = escapeInput($con, $_POST['remote_address']);
    $remote_password = escapeInput($con, $_POST['remote_password']);
    $remote_port = escapeInput($con, $_POST['remote_port']);

    // hard drive
    $hard_disk_name = escapeInput($con, $_POST['hard_disk_name']);
    $hard_drive = escapeInput($con, $_POST['hard_drive']);
    $storage = escapeInput($con, $_POST['storage']);
    $brand = escapeInput($con, $_POST['brand']);
    $purpose = escapeInput($con, $_POST['purpose']);
    $end_warranty_disk = escapeInput($con, $_POST['end_warranty_disk']);

    // Handle other arrays as needed
    // software
    $software_category = escapeInput($con, $_POST['software_category']);
    $software_name = escapeInput($con, $_POST['software_name']);
    $software_brand = escapeInput($con, $_POST['software_brand']);
    $license_key = escapeInput($con, $_POST['license_key']);
    $expiry_date = escapeInput($con, $_POST['expiry_date']);

    // Handle other arrays as needed
    // user
    $username = escapeInput($con, $_POST['username']);
    $password = escapeInput($con, $_POST['password']);
    $user = escapeInput($con, $_POST['user']);
    $role = escapeInput($con, $_POST['role']);

    // picture
    $view = escapeInput($con, $_POST['view']);

    // Get asset category running number
    $sql = mysqli_query($con, "SELECT * FROM aims_computer_category_run_no WHERE category = '$category'");
    $result = mysqli_fetch_assoc($sql);
    $asset_running_no = $result['next_no'];

    // Complete asset tag wording, adding zero to the left
    $asset_tag = $result['prefix'] . str_pad($asset_running_no, 5, "0", STR_PAD_LEFT);
    $base_asset_running_no = $result['next_no'];
    $base_name = $name;

    // Initialize the MultipleIterator
    $m5 = new MultipleIterator();

    // Array data received from the form
    if (isset($_POST['assetType']) && $_POST['assetType'] == 'multiple') {
        $quantity = escapeInput($con, $_POST['quantity']);
    } else {
        $quantity = 1;
    }

    for ($i = 0; $i < $quantity; $i++) {
        $picture = [];
        // Increment the asset running number
        $asset_running_no = $base_asset_running_no + $i;

        // Complete asset tag wording, adding zero to the left
        $asset_tag = $result['prefix'] . str_pad($asset_running_no, 5, "0", STR_PAD_LEFT);

        // Modify the name based on the asset type
        if ($_POST['assetType'] == 'single') {
            $name = $base_name;
        } else {
            $name = $base_name . ($i + 1);
        }

        // Check for duplicate name
        $sqlDuplicateCheck = "SELECT COUNT(*) as count FROM aims_computer WHERE name = '$name'";
        $resultDuplicateCheck = mysqli_query($con, $sqlDuplicateCheck);
        $count = mysqli_fetch_assoc($resultDuplicateCheck)['count'];

        if ($count > 0) {
            // Duplicate name found, handle accordingly
            echo "duplicate";
            exit; // Stop further execution
        }

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

        // Initialize $invoice
        $invoice = "";

        if (isset($_FILES['invoice']) && $_FILES['invoice']['error'] === UPLOAD_ERR_OK) {
            $invoice_tmp = $_FILES['invoice']['tmp_name'];
            $invoice_name = basename($_FILES["invoice"]["name"]);
            $invoice_destination = $target_directory_invoice . $invoice_name;
        
            if (copy($invoice_tmp, $invoice_destination)) {
                // Set $invoice to the relative path of the copied file
                $invoice = "include/upload/invoice/computer/" . $asset_tag . "/" . $invoice_name;
            }
        }

        // Initialize $document
        $document = "";

        // Check if an document file was uploaded
        if (isset($_FILES['document']) && $_FILES['document']['error'] === UPLOAD_ERR_OK) {
            $document_tmp = $_FILES['document']['tmp_name'];
            $document_name = basename($_FILES["document"]["name"]);
            $document_destination = $target_directory_document . $document_name;

            if (copy($document_tmp, $document_destination)) {
                // Set $document to the relative path of the uploaded file
                $document = "include/upload/document/computer/" . $asset_tag . "/" . $document_name;
            }
        }

        // Initialize $warranty
        $warranty = "";

        // Check if an warranty file was uploaded
        if (isset($_FILES['warranty']) && $_FILES['warranty']['error'] === UPLOAD_ERR_OK) {
            $warranty_tmp = $_FILES['warranty']['tmp_name'];
            $warranty_name = basename($_FILES["warranty"]["name"]);
            $warranty_destination = $target_directory_warranty . $warranty_name;

            if (copy($warranty_tmp, $warranty_destination)) {
                // Set $warranty to the relative path of the uploaded file
                $warranty = "include/upload/warranty/computer/" . $asset_tag . "/" . $warranty_name;
            }
        }

        // Insert data into the aims_electronics table
        // SQL statement for inserting data into aims_computer table
        $sqlComputer = "INSERT INTO aims_computer 
            (
                `name`,
                status,
                asset_tag,
                branch,
                department,
                `location`,
                category,
                server_name,
                price,
                date_purchase,
                remark,
                computer_brand,
                phone_brand,
                virtual_machine,
                ram,
                processor,
                graphic_card,
                casing,
                psu,
                motherboard,
                `start_warranty`,
                `end_warranty`,
                invoice,
                document,
                warranty,
                supplier
                )
        VALUES (
            '$name',
            '$status',
            '$asset_tag',
            '$branch',
            '$department',
            '$location',
            '$category',
            '$server_name',
            '$price',
            '$date_purchase',
            '$remark',
            '$computer_brand',
            '$phone_brand',
            '$virtual_machine',
            '$ram',
            '$processor',
            '$graphic_card',
            '$casing',
            '$psu',
            '$motherboard',
            '$start_warranty',
            '$end_warranty',
            '$invoice',
            '$document',
            '$warranty',
            '$supplier'
            )";

        $queryComputer = mysqli_query($con, $sqlComputer);

        // Insert data into aims_transfer_computer
        if ($queryComputer) {
            $sqlTransferComputer = "INSERT INTO aims_transfer_computer (asset_tag, name, branch, department, location) VALUES ('$asset_tag', '$name', '$branch', '$department', '$location')";
            $queryTransferComputer = mysqli_query($con, $sqlTransferComputer);

            if (!$queryTransferComputer) {
                echo "Error inserting into aims_transfer_computer: " . mysqli_error($con);
                exit;
            }
        }

        $querySoftware = null;

        $mi = new MultipleIterator();
        $mi->attachIterator(new ArrayIterator($software_category));
        $mi->attachIterator(new ArrayIterator($software_name));
        $mi->attachIterator(new ArrayIterator($software_brand));
        $mi->attachIterator(new ArrayIterator($license_key));
        $mi->attachIterator(new ArrayIterator($expiry_date));

        // Execute SQL statement for software
        foreach ($mi as $value) {
            list($a, $b, $c, $d, $e) = $value;
            $sqlSoftware = "INSERT INTO aims_software
                (asset_tag, software_category, software_name, brand, license_key, `expiry_date`)
                VALUES ('$asset_tag', '$a', '$b', '$c', '$d', '$e')";
            $querySoftware = mysqli_query($con, $sqlSoftware);
        }

        $queryUser = null;

        $mi2 = new MultipleIterator();
        $mi2->attachIterator(new ArrayIterator($username));
        $mi2->attachIterator(new ArrayIterator($password));
        $mi2->attachIterator(new ArrayIterator($user));
        $mi2->attachIterator(new ArrayIterator($role));

        foreach ($mi2 as $value) {
            list($a, $b, $c, $d) = $value;
            $sqlUser = "INSERT INTO aims_computer_user
                (asset_tag, username, password, user, role)
                VALUES ('$asset_tag', '$a', '$b', '$c', '$d')";
            $queryUser = mysqli_query($con, $sqlUser);
        }

        $queryHardDrive = null;

        $mi3 = new MultipleIterator();
        $mi3->attachIterator(new ArrayIterator($hard_disk_name));
        $mi3->attachIterator(new ArrayIterator($hard_drive));
        $mi3->attachIterator(new ArrayIterator($storage));
        $mi3->attachIterator(new ArrayIterator($brand));
        $mi3->attachIterator(new ArrayIterator($purpose));
        $mi3->attachIterator(new ArrayIterator($end_warranty_disk));

        foreach ($mi3 as $value) {
            list($a, $b, $c, $d, $e, $f) = $value;
            $sqlHardDrive = "INSERT INTO aims_computer_hard_drive
                (asset_tag, hard_disk_name, hard_drive, storage, brand, purpose, end_warranty_disk)
                VALUES ('$asset_tag', '$a', '$b', '$c', '$d', '$e', '$f')";
            $queryHardDrive = mysqli_query($con, $sqlHardDrive);
        }

        $queryNetwork = null;

        $mi4 = new MultipleIterator();
        $mi4->attachIterator(new ArrayIterator($ip_type));
        $mi4->attachIterator(new ArrayIterator($ip_address));
        $mi4->attachIterator(new ArrayIterator($mac_address));
        $mi4->attachIterator(new ArrayIterator($port));

        foreach ($mi4 as $value) {
            list($a, $b, $c, $d) = $value;
            $sqlNetwork = "INSERT INTO aims_computer_network
                (asset_tag, ip_type, ip_address, mac_address, port)
                VALUES ('$asset_tag', '$a', '$b', '$c', '$d')";
            $queryNetwork = mysqli_query($con, $sqlNetwork);
        }

        $target_directory_picture = "../../include/upload/picture/computer/" . $asset_tag . "/";

        if (!is_dir($target_directory_picture)) {
            mkdir($target_directory_picture, 0755, true);
        }

        // Initialize $picture
        $target_directory_picture = "../../include/upload/picture/computer/" . $asset_tag . "/";

        // Handle picture files
        // Check if there are picture files
        if (isset($_FILES['picture']) && is_array($_FILES['picture']['tmp_name'])) {
            $pictureCount = count($_FILES['picture']['tmp_name']);
            $picturesForCurrentAsset = [];

            for ($j = 0; $j < $pictureCount; $j++) {
                // Check if the current picture file exists and is not empty
                if (isset($_FILES['picture']['name'][$j]) && $_FILES['picture']['size'][$j] > 0) {
                    $picture_tmp = $_FILES['picture']['tmp_name'][$j];
                    $picture_name = basename($_FILES['picture']['name'][$j]);
                    $picture_destination = $target_directory_picture . $picture_name;

                    // Check if the destination directory exists, and if not, create it
                    if (!is_dir($target_directory_picture)) {
                        mkdir($target_directory_picture, 0755, true);
                    }

                    // Check if the file is successfully copied
                    if (copy($picture_tmp, $picture_destination)) {
                        // Add the relative path of the copied picture to the array
                        $picturesForCurrentAsset[] = "include/upload/picture/computer/" . $asset_tag . "/" . $picture_name;
                    }
                }
            }

            // Store the pictures for the current asset in the $picture array
            $picture[$i] = $picturesForCurrentAsset;
        }

        $queryPicture = null;

        $mi5 = new MultipleIterator();

        if (!empty($view) && !empty($picture)) {
            $mi5->attachIterator(new ArrayIterator($view));
            $mi5->attachIterator(new ArrayIterator($picture));
        }

        // Insert picture data
        if (!empty($view) && !empty($picture[$i])) {
            foreach ($picture[$i] as $index => $picturePath) {
                $viewValue = isset($view[$index]) ? $view[$index] : ''; // Ensure view value exists
                $sqlPicture = "INSERT INTO aims_all_asset_picture (asset_tag, view, picture) VALUES ('$asset_tag', '$viewValue', '$picturePath')";
                $queryPicture = mysqli_query($con, $sqlPicture);
            }
        }

        $queryRemoteAccess = null;

        $mi6 = new MultipleIterator();
        $mi6->attachIterator(new ArrayIterator($remote_name));
        $mi6->attachIterator(new ArrayIterator($remote_address));
        $mi6->attachIterator(new ArrayIterator($remote_password));
        $mi6->attachIterator(new ArrayIterator($remote_port));

        foreach ($mi6 as $value) {
            list($a, $b, $c, $d) = $value;
            $sqlRemoteAccess = "INSERT INTO aims_computer_remote_access
                (asset_tag, remote_name, remote_address, remote_password, remote_port)
                VALUES ('$asset_tag', '$a', '$b', '$c', '$d')";
            $queryRemoteAccess = mysqli_query($con, $sqlRemoteAccess);
        }
    }

    if ($queryComputer) {
        $next_no = $asset_running_no + 1;
        $update_running_no = mysqli_query($con, "UPDATE aims_computer_category_run_no SET next_no = '$next_no' WHERE category = '$category'");
        echo "true";
    } else {
        echo "false";
    }
?>