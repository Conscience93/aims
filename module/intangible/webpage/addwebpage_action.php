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

    $name = escapeInput($con, $_POST['name']);
    $category = escapeInput($con, $_POST['category']);
    $date_purchase = escapeInput($con, $_POST['date_purchase']);
    $price = escapeInput($con, $_POST['price']);
    $user = escapeInput($con, $_POST['user']);
    $server_name = escapeInput($con, $_POST['server_name']);
    $link = escapeInput($con, $_POST['link']);
    $particular = escapeInput($con, $_POST['particular']);
    $supplier = escapeInput($con, $_POST['supplier']);
    $start_warranty = escapeInput($con, $_POST['start_warranty']);
    $end_warranty = escapeInput($con, $_POST['end_warranty']);

    // picture
    $view = escapeInput($con, $_POST['view']);

    // Get asset category running number
    $sql = mysqli_query($con, "SELECT * FROM aims_webpage_category_run_no WHERE category = '$category'");
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
        $sqlDuplicateCheck = "SELECT COUNT(*) as count FROM aims_webpage WHERE name = '$name'";
        $resultDuplicateCheck = mysqli_query($con, $sqlDuplicateCheck);
        $count = mysqli_fetch_assoc($resultDuplicateCheck)['count'];

        if ($count > 0) {
            // Duplicate name found, handle accordingly
            echo "duplicate";
            exit; // Stop further execution
        }

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

        // Initialize $invoice
        $invoice = "";

        if (isset($_FILES['invoice']) && $_FILES['invoice']['error'] === UPLOAD_ERR_OK) {
            $invoice_tmp = $_FILES['invoice']['tmp_name'];
            $invoice_name = basename($_FILES["invoice"]["name"]);
            $invoice_destination = $target_directory_invoice . $invoice_name;
        
            if (copy($invoice_tmp, $invoice_destination)) {
                // Set $invoice to the relative path of the copied file
                $invoice = "include/upload/invoice/webpage/" . $asset_tag . "/" . $invoice_name;
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
                $document = "include/upload/document/webpage/" . $asset_tag . "/" . $document_name;
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
                $warranty = "include/upload/warranty/webpage/" . $asset_tag . "/" . $warranty_name;
            }
        }

        // Insert data into aims_webpage
        $sqlAsset = "INSERT INTO aims_webpage
            (name, 
            asset_tag, 
            category, 
            date_purchase, 
            price, 
            supplier, 
            user, 
            server_name,
            link, 
            start_warranty, 
            end_warranty, 
            particular, 
            invoice, 
            document, 
            warranty) 

            VALUES 

            ('$name', 
            '$asset_tag', 
            '$category', 
            '$date_purchase', 
            '$price', 
            '$supplier', 
            '$user',
            '$server_name',
            '$link', 
            '$start_warranty', 
            '$end_warranty',
            '$particular', 
            '$invoice', 
            '$document', 
            '$warranty');";

        $queryAsset = mysqli_query($con, $sqlAsset);

        // Creating picture directory
        $target_directory_picture = "../../include/upload/picture/webpage/" . $asset_tag . "/";

        if (!is_dir($target_directory_picture)) {
            mkdir($target_directory_picture, 0755, true);
        }

        // Initialize $picture
        $picturesForCurrentAsset = [];

        // Handle picture files
        // Check if there are picture files
        if (isset($_FILES['picture']) && is_array($_FILES['picture']['tmp_name'])) {
            $pictureCount = count($_FILES['picture']['tmp_name']);

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
                        $picturesForCurrentAsset[] = "include/upload/picture/webpage/" . $asset_tag . "/" . $picture_name;
                    }
                }
            }
        }

        // Insert picture data into aims_all_asset_picture
        foreach ($picturesForCurrentAsset as $picturePath) {
            $viewValue = isset($view[$i]) ? $view[$i] : ''; // Ensure view value exists
            $sqlPicture = "INSERT INTO aims_all_asset_picture (asset_tag, view, picture) VALUES ('$asset_tag', '$viewValue', '$picturePath')";
            $queryPicture = mysqli_query($con, $sqlPicture);

            if (!$queryPicture) {
                echo "Error inserting into aims_all_asset_picture: " . mysqli_error($con);
                exit;
            }
        }
    }

    if ($queryAsset) {
        $next_no = $asset_running_no + 1;
        $update_running_no = mysqli_query($con, "UPDATE aims_webpage_category_run_no SET next_no = '$next_no' WHERE category = '$category'");
        echo "true";
    } else {
        echo "false";
    }
?>
